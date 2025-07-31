<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Appointment;
use App\Models\RefCountryCode;
use App\Models\Patient;
use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\RefDesignation;
use App\Models\Notification;
use App\Models\RefLabTest;
use App\Models\PatientImagingTest;
use App\Models\PatientLabTestItem;

use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Route;

class ImagingController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        // Middleware for session check
        $this->middleware(function ($request, $next) {
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
                $method = Route::current()->getActionMethod();
                if(!in_array($method,array('getOrderList','printImagingOrder'))){
                    return Redirect::to('/');
                }
            }
            // Check if the session has the 'user' key (adjust as per your session key)
             $sessionCeck = $this->Corefunctions->validateUser();
             if(!$sessionCeck){
                return Redirect::to('/logout');
            }
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
            return $next($request);
        });
    }
    
   
     /** get the addLabs   */
    public function addImaging()
    {
        if(request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            /* category list  */
            $categoryList    = RefLabTest::getImagingCategoryList();
            /** get oprtion */
            $optionsList  =   RefLabTest::getOptionList();
            

            /** get patient Details */
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($data['userID']));
            $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'] : $patientDetails['first_name'];
            $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);

            /*user details */
            $userDetails = ClinicUser::getClinicUserByUserId(Session::get('user.userID'));
            $userDetails = $this->Corefunctions->convertToArray($userDetails);

            $finalTestArray = $imagingList =  array();

            $data['finalTestArray']  = $finalTestArray ;
            $data['imagingList']      = $imagingList ;
            $data['userDetails']     = $userDetails ;
            $data['patientDetails']  = $patientDetails ;
            
            $data['optionsList']    = $optionsList ;
            $data['categoryList']    = $categoryList ;
            $html           = view('appointment.imaging.addimaging', $data);
            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
         }
    }
    private function saveImagingData($formdata,$userID){

       
        /* insert to lab test table */
        $img_test_uuid  = $this->Corefunctions->generateUniqueKey('8', 'patient_lab_tests', 'lab_test_uuid') ;
        $insertArray = [
            'imaging_test_uuid'   => $img_test_uuid ,
            'test_date'       => date('Y-m-d') ,
            'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
            'patient_id'      => $userID ,
        ];
        $imgId = PatientImagingTest::insertImagingTests($insertArray);
        
        foreach ($formdata as $input) {

            $insertArray = [
                'category_id'     => isset($input['category_id']) ? $input['category_id'] : '',
                'subcategory_id'  => isset($input['subcategory_id']) ? $input['subcategory_id'] : '',
                'test_date'       => date('Y-m-d') ,
                'description'     => isset($input['description'])  && $input['description'] != '' ? $input['description']  : '',
                'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
                'option_id'       =>( isset( $input['options[]'] ) && !empty( $input['options[]'] ) ) ?  serialize( (array) $input['options[]'] ) : '' ,
                'patient_id'      => $userID ,
                'is_contrast'     =>( isset( $input['is_contrast'] ) ) ? ($input['is_contrast']) : NULL,
               
            ];

             /* insert items */
             PatientImagingTest::insertImagingTestItems($insertArray,$imgId);
        }
        return $img_test_uuid ;


    }

    
    private function updateImagingrItems($formdata,$userID,$imagID){
        DB::table('patient_imaging_test_items')->where('patient_imaging_id',$imagID)->update(array(
            'deleted_at' => Carbon::now(),
        ));
        foreach ($formdata as $input) {
                $insertArray = [
                    'category_id'     => isset($input['category_id']) ? $input['category_id'] : '',
                    'subcategory_id'  => isset($input['subcategory_id']) ? $input['subcategory_id'] : '',
                    'test_date'       => date('Y-m-d'),
                    'description'     => isset($input['description'])  && $input['description'] != '' ? $input['description']  : '',
                    'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
                    'option_id'       =>( isset( $input['options[]'] ) && !empty( $input['options[]'] ) ) ?  serialize( (array) $input['options[]'] ) : ''  ,
                    'patient_id'      => $userID ,
                    'is_contrast'     =>( isset( $input['is_contrast'] ) ) ? ($input['is_contrast']) : NULL ,
                
                ];
             /* insert items */
             PatientImagingTest::insertImagingTestItems($insertArray,$imagID);
        }
    }

  
    public function getOrderList()
    {
        if(request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $usertype = Session::get('user.userType');
            $data['userID'] = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['userID'];

            if (!isset($data['userID'])) {
                return $this->Corefunctions->returnError('Key missing');
            }  $data['isback'] = '1';
            /*  view from listing  */
            if(isset($data['orderKey']) && $data['orderKey'] !=''){
                $data['isback'] = '0';
                $labkey = $data['orderKey'] ;
            }elseif(isset($data['labkey']) && $data['labkey'] !=''){
                $labkey = $data['labkey'] ;
                $imageingList =  PatientImagingTest::getPatientImagingByKey($labkey) ;
                $formdata = $data['formdata'] ;
                $allEntries = json_decode($formdata, true);
                $this->updateImagingrItems($allEntries,$data['userID'],$imageingList['id']);
            }else{
                $formdata = $data['formdata'] ;
                $allEntries = json_decode($formdata, true); // true = decode as associative array

                /* save the print page details */
                $labkey = $this->saveImagingData($allEntries,$data['userID']);
    
            }
            
            /** get patient Details */
            $patientDetails                     = $this->Corefunctions->convertToArray(Patient::patientByUser($data['userID']));
            $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'] : $patientDetails['first_name'];
            $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);
            
            $finalTestArray = $orderLists = $userDetails = $finalGroupedArray = array();
            $clinicId = session()->get('user.clinicID');
            $clinicDetails = Clinic::clinicByID($clinicId);
            $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
            $countryCodedetails = RefCountryCode::getCountryCodeById($clinicDetails['country_code']);

            /** get oprtion */
            $optionsList  =   RefLabTest::getOptionList();
            

            // if (isset($labkey) && $labkey != '') {
            //      /* get the test lists */
            //      $imagingList =  PatientImagingTest::getPatientImagingByKey($labkey) ;
            //      if (empty($imagingList)) {
            //         $arr['error'] = 1;
            //         $arr['message'] = 'Invalid imaging order';
            //         return response()->json($arr);
            //     }if($imagingList['patient_id'] != $data['userID'] ){
            //         $arr['error'] = 1;
            //         $arr['message'] = 'Invalid lab order';
            //         return response()->json($arr);
            //     }
            //     /* get the test item lists */
            //     $imagingItemLists =  PatientImagingTest::getPatientImagingItems($imagingList['id']) ;
                

            //     // foreach ($imagingItemLists as $item) {
            //     //     $labId = $item['lab_test_id'];
            //     //     $subId = $item['sub_lab_test_id'];
            //     //     // Initialize array if not already set
            //     //     if (!isset($finalTestArray[$labId])) {
            //     //         $finalTestArray[$labId] = [];
            //     //     }
            //     //     // Add item if sub_lab_test_id is unique in this group
            //     //     $exists = array_filter($finalTestArray[$labId], function ($i) use ($subId) {
            //     //         return $i['sub_lab_test_id'] == $subId;
            //     //     });
                
            //     //     if (empty($exists)) {
            //     //         $finalTestArray[$labId][] = $item;
            //     //     }
            //     // }


                
            //     /*user details */
            //     $userDetails = ClinicUser::getClinicUserByUserId($imagingList['created_by']);
            //     $userDetails = $this->Corefunctions->convertToArray($userDetails);
            // }

            $finalGroupedArray = [];

            if (isset($labkey) && $labkey != '') {
                // Get the test lists
                $imagingList = PatientImagingTest::getPatientImagingByKey($labkey);
                if (empty($imagingList)) {
                    return response()->json(['error' => 1, 'message' => 'Invalid imaging order']);
                }

                if ($imagingList['patient_id'] != $data['userID']) {
                    return response()->json(['error' => 1, 'message' => 'Invalid lab order']);
                }

                // Get the test item lists
                $imagingItemLists = PatientImagingTest::getPatientImagingItems($imagingList['id']);
                $testDate = $imagingList['test_date'] ?? null; // Ensure test_date exists

                foreach ($imagingItemLists as $item) {
                    $categoryId = $item['lab_test_id'];
                    $subcategoryId = $item['sub_lab_test_id'];
                    $description = $item['description'];
                    $selectedOptionNames = [];

                    // Safely parse option_id
                    $optionIdRaw = $item['option_id'] ?? '';
                    if (!empty($optionIdRaw)) {
                        $selectedOptionIds = unserialize($optionIdRaw);
                        if (is_array($selectedOptionIds)) {
                            foreach ($optionsList as $option) {
                                if (in_array($option['id'], $selectedOptionIds)) {
                                    $selectedOptionNames[] = $option['name'];
                                }
                            }
                        }
                    }

                    
                    if (!isset($finalGroupedArray[$categoryId])) {
                        $finalGroupedArray[$categoryId] = [
                            'category_id' => $categoryId,
                            'test_date' => $testDate,
                            'subcategories' => []
                        ];
                    }

                   
                    $existingOptions = $finalGroupedArray[$categoryId]['options'] ?? [];
                    $mergedOptions = array_unique(array_merge($existingOptions, $selectedOptionNames));
                    $finalGroupedArray[$categoryId]['options'] = $mergedOptions;

                   
                    $finalGroupedArray[$categoryId]['subcategories'][] = [
                        'subcategory_id' => $subcategoryId,
                        'description' => $description,
                        'options' => $selectedOptionNames,
                        'is_contrast' => $item['is_contrast'],
                    ];
                }

                // Get user details
                $userDetails = ClinicUser::getClinicUserByUserId($imagingList['created_by']);
                $userDetails = $this->Corefunctions->convertToArray($userDetails);
            }



          
           /*categoryIds all categories */
           $categoryDetails =  RefLabTest::getAllImagingCategoryList();
           $categoryDetails = $this->Corefunctions->getArrayIndexed1($categoryDetails, 'id');

           $imagingTestIds = $this->Corefunctions->getIDSfromArray($imagingItemLists,'sub_lab_test_id');
           $imagingcptCodes = RefLabTest::getImageinfCtp($imagingTestIds);
           $imagingcptCodes = $this->Corefunctions->getArrayIndexed1($imagingcptCodes, 'imaging_test_id');

           $cptIDS = $this->Corefunctions->getIDSfromArray($imagingcptCodes,'cpt_code_id');
           $cptCodes = RefLabTest::getCptCodes($cptIDS);
           $cptCodes = $this->Corefunctions->getArrayIndexed1($cptCodes, 'id');
            /** get countryCodeDetails */
            $userCountryCode = RefCountryCode::getCountryCodeById($userDetails['country_code']);
      

           $data['cptCodes']   = $cptCodes ;
           $data['imagingcptCodes']   = $imagingcptCodes ;
           $data['userCountryCode']   = $userCountryCode ;
            $data['patientDetails']   = $patientDetails ;
            $data['userDetails']      = $userDetails ;
            $data['imagingList']       = $imagingList ;
            $data['finalTestArray']       = $finalGroupedArray ;
            $data['categoryDetails']  = $categoryDetails ;
            $data['clinicDetails']  = $clinicDetails ;
            $data['countryCodedetails']  = $countryCodedetails;
            $data['labkey']  = $labkey;
        
            $html                     = view('appointment.imaging.orderlistprint', $data);

            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            $arr['key'] = $labkey ;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }




  

    //Search Function
    public function imagingsearch($type)
    {
        if (request()->ajax()) {
            $search = request('search');
            $clinicId = session()->get('user.clinicID');
            if ($type == "category") {
                $category = RefLabTest::getImagingCategoryList($search);
                $html = '';
                if (empty($category)) {
                    $html .= '<li class="dropdown-item "><div class="dropview_body profileList justify-content-center"><p>No Data Found</p></div></li>';
                } else {
                    foreach ($category as $cl) {
                        $html .= '<li id="cat_' . $cl['id'] . '" class="dropdown-item select_category_list select_category" style="cursor:pointer">';
                        $html .= '<p  class="m-0 select_category_item" data-id="' . $cl['id'] . '">' . $cl['name'] . '</p>';
                        $html .= '</li>';
                    }
                }
            }
            if($type == 'subcategory'){
                $html = '';
                $data = request()->all();
                $categoryID = isset($data['category_id']) ? $data['category_id'] : '';
                /* get subcategory details */
                $subCategory = RefLabTest::getImagingSubcategoryListByCategory($categoryID,$search);
                if (empty($subCategory)) {
                    $html .= '<li class="dropdown-item "><div class="dropview_body profileList justify-content-center"><p>No Data Found</p></div></li>';
                } else {
                    foreach ($subCategory as $cl) {
                        $html .= '<li id="cat_' . $cl['id'] . '" class="dropdown-item select_subcategory_list" style="cursor:pointer">';
                        $html .= '<div class="dropview_body"><p  class="m-0 select_subcategory_item" data-id="' . $cl['id'] . '">' . $cl['name'] . '</p></div>';
                        $html .= '</li>';
                    }
                }

            }
            return response()->json([
                'view' => $html,
                'status' => 1,
            ]);
        }
    }




      /** delete */
     /** get sub category details   */
     public function deleteImaging()
     {
         if(request()->ajax()) {
             $data = request()->all();
             // Check if form data is empty
             if (empty($data)) {
                 return $this->Corefunctions->returnError('Fields missing');
             }
          
             if($data['type']  == 'sub'){
                DB::table('patient_imaging_test_items')->where('imaging_items_uuid',$data['key'])->update(array(
                    'deleted_at' => Carbon::now(),
                ));
               
            }else{

           
                $testDetails = PatientImagingTest::getPatientImagingByKey($data['key']);
                if(!empty($testDetails)){
                    PatientImagingTest::deleteAllLabTests($data['key']);

                    /* delete all items  */
                    DB::table('patient_imaging_test_items')->where('patient_imaging_id',$testDetails['id'])->update(array(
                        'deleted_at' => Carbon::now(),
                    ));
                    
                }
            }
          
           
             $arr['success'] = 1;
             $arr['message'] = 'Data fetched successfully';
             return response()->json($arr);
         }
     }



     public function imagingaddOrder()
     {
        if(request()->ajax()) {
             $data = request()->all();
             // Check if form data is empty
             if (empty($data)) {
                 return $this->Corefunctions->returnError('Fields missing');
             }
             $formdata = $data['formdata'] ;
             $allEntries = json_decode($formdata, true); // true = decode as associative array
         
             $finalGroupedArray =$imagingList= [];
            /** get oprtion */
            $optionsList  =   RefLabTest::getOptionList();
            $imagingTestIds = [];
            $isexists = [];
          
            foreach ($allEntries as $entry) {
                $imagingList['test_date'] = date('Y-m-d');
                $categoryId = $entry['category_id'];
                $subcategoryId = $entry['subcategory_id'];
                $key = $categoryId . '-' . $subcategoryId;
                /** check duplicate  */
                if (isset($isexists[$key])) {
                    // Duplicate found
                    return response()->json([
                        'status' => 'error',
                        'message' => 'This category and subcategory combination has already been added.' ,
                    ]);
                }
                $isexists[$key] = true;
                // Remove token since it's repeated and not needed in grouping
                unset($entry['_token']);
                /** option */
              
                $selectedOptionNames = [];

                $selectedOptionIds = $entry['options[]'] ?? [];
                
                // Ensure it's an array, even if only one value was selected
                if (!is_array($selectedOptionIds)) {
                    $selectedOptionIds = [$selectedOptionIds];
                }
                
                if (!empty($selectedOptionIds)) {
                    foreach ($optionsList as $option) {
                        if (in_array($option['id'], $selectedOptionIds)) {
                            $selectedOptionNames[] = $option['name'];
                        }
                    }
                }
                
                if (!isset($finalGroupedArray[$categoryId])) {
                    $finalGroupedArray[$categoryId] = [
                        'category_id' => $categoryId,
                        'test_date' => date('Y-m-d'),
                      
                        'subcategories' => []
                    ];
                }

                $finalGroupedArray[$categoryId]['subcategories'][] = [
                    'subcategory_id' => $entry['subcategory_id'],
                    'description' => $entry['description'],
                    'options' => $selectedOptionNames,
                    'is_contrast' => isset($entry['is_contrast']) ? $entry['is_contrast'] : '' ,
                ];
                $imagingTestIds[] = $entry['subcategory_id'];
            }
            // print'<pre>';print_r($finalGroupedArray );exit;
            /** get patient Details */
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($data['userID']));
            $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'] : $patientDetails['first_name'];
            $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);

             /*categoryIds all categories */
            $categoryDetails =  RefLabTest::getAllImagingCategoryList();
            $categoryDetails = $this->Corefunctions->getArrayIndexed1($categoryDetails, 'id');
            /*user details */
            $userDetails = ClinicUser::getClinicUserByUserId(Session::get('user.userID'));
            $userDetails = $this->Corefunctions->convertToArray($userDetails);
          

           
            $imagingcptCodes = RefLabTest::getImageinfCtp($imagingTestIds);
            $imagingcptCodes = $this->Corefunctions->getArrayIndexed1($imagingcptCodes, 'imaging_test_id');
            
            $cptIDS = $this->Corefunctions->getIDSfromArray($imagingcptCodes,'cpt_code_id');
            $cptCodes = RefLabTest::getCptCodes($cptIDS);
            $cptCodes = $this->Corefunctions->getArrayIndexed1($cptCodes, 'id');
            /** get countryCodeDetails */
            $countryCodeDetails = RefCountryCode::getCountryCodeById($userDetails['country_code']);
      
            $data['countryCodeDetails']   = $countryCodeDetails ;
            $data['cptCodes']   = $cptCodes ;
            $data['imagingcptCodes']   = $imagingcptCodes ;
            $data['optionsList']   = $optionsList ;
            $data['patientDetails']   = $patientDetails ;
            $data['userDetails']      = $userDetails ;
            $data['imagingList']       = $imagingList  ;
            $data['finalTestArray']   = $finalGroupedArray ;
            $data['categoryDetails']  = $categoryDetails ;

           
            $data['formdata']           = $formdata ;
          
             $html                     = view('appointment.imaging.orderlist', $data);
 
             $arr['view']    = $html->__toString();
             $arr['success'] = 1;
             $arr['message'] = 'Data fetched successfully';
             return response()->json($arr);
         }
     }


      public function printImagingOrder(Request $request, $labKey)
     {
         $orderLists =  PatientImagingTest::getPatientImagingByKey($labKey) ;
        if(empty($orderLists)){
            return Redirect::to('/dashboard'); 
        }
       
        $patientDetails = $this->getPatientDetails($orderLists['patient_id']);
         $patientName = preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '_', $patientDetails['first_name']));
       
        $url = url("/imaging/print/orders/" . $labKey);
        
        $filename = 'RadiologyForm_'.$patientName.'_'.date('Y-m-d',strtotime($orderLists['test_date'])).'.pdf';
    
         if (!is_dir(TEMPDOCPATH))
             mkdir(TEMPDOCPATH);
         $tempPath = TEMPDOCPATH . $filename;
      
         $output   = shell_exec('/usr/local/bin/wkhtmltopdf --enable-javascript  --enable-javascript  -T 2.54cm -B 2.54cm ' . escapeshellarg($url) . ' --footer-right "[page] of [toPage]" ' . escapeshellarg($tempPath) . ' 2>&1');
         
         $printpath = url(TEMPDOCPATH . $filename);
         if(isset($_GET['is_download']) && $_GET['is_download'] == 1){
             if (@file_get_contents($printpath) == true) {
                 header('Content-Type: application/octet-stream');
                 header("Content-Transfer-Encoding: Binary");
                 header("Content-disposition: attachment; filename=\"" . $filename . "\"");
                 readfile($printpath);
             }
             exit;
         }
        
         $data['printpath']    = url($tempPath);
         $data['description'] = '';
         $data['title'] = 'Reports';
         $data['pagetitle']  = 'Reports';
         $data['headcls']  = 'reports';
         return view('printview', $data);
     } 
     private function getPatientDetails($userID){
        /** get patient Details */
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userID));
            $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'] : $patientDetails['first_name'];
            $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);
             return  $patientDetails;
    }

     public function editOrder()
     {
         if(request()->ajax()) {
             $data = request()->all();
             // Check if form data is empty
             if (empty($data)) {
                 return $this->Corefunctions->returnError('Fields missing');
             }
             if (!isset($data['userID'])) {
                 return $this->Corefunctions->returnError('Key missing');
             }
             /*  view from listing  */
             if(isset($data['labkey']) && $data['labkey'] !=''){
                 $labkey = $data['labkey'] ;
                 $imagingList =  PatientImagingTest::getPatientImagingByKey($labkey);
             }
             
             /** get patient Details */
             $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($data['userID']));
             $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
             $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'] : $patientDetails['first_name'];
             $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);
             
             $finalTestArray = $imagingList = $userDetails = array();
             $clinicId = session()->get('user.clinicID');
             $clinicDetails = Clinic::clinicByID($clinicId);
             $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
             $countryCodedetails = RefCountryCode::getCountryCodeById($clinicDetails['country_code']);
 
              /** get oprtion */
            $optionsList  =   RefLabTest::getOptionList();
            

             if (isset($labkey) && $labkey != '') {
                    /* get the test lists */
                    $imagingList =  PatientImagingTest::getPatientImagingByKey($labkey) ;

                    /* get the test item lists */
                    $imagingItemLists =  PatientImagingTest::getPatientImagingItems($imagingList['id']) ;
                

                     /** option */
                // $selectedOptionIds = explode(',',$entry['options[]']); // convert string to array
                // foreach ($optionsList as $option) {
                //     if (in_array($option['id'], $selectedOptionIds)) {
                //         $selectedOptionNames[] = $option['name'];
                //     }
                // }

                foreach ($imagingItemLists as $item) {
                    $labId = $item['lab_test_id'];
                    $subId = $item['sub_lab_test_id'];
                    // Initialize array if not already set
                    if (!isset($finalTestArray[$labId])) {
                        $finalTestArray[$labId] = [];
                    }
                    // Add item if sub_lab_test_id is unique in this group
                    $exists = array_filter($finalTestArray[$labId], function ($i) use ($subId) {
                        return $i['sub_lab_test_id'] == $subId;
                    });
                
                    if (empty($exists)) {
                        $finalTestArray[$labId][] = $item;
                    }
                }
                
                /*user details */
                $userDetails = ClinicUser::getClinicUserByUserId($imagingList['created_by']);
                $userDetails = $this->Corefunctions->convertToArray($userDetails);
            }

            $imagingTestIds = [];

            foreach ($finalTestArray as $categoryId => $subcategoryItems) {
                foreach ($subcategoryItems as $entry) {
                    $subcategoryId = $entry['sub_lab_test_id'];
                   
                    // Parse options
                    $selectedOptionNames = [];

                    // Safely parse option_id
                    $optionIdRaw = $entry['option_id'] ?? '';
                    if (!empty($optionIdRaw)) {
                        $selectedOptionIds = unserialize($optionIdRaw);
                        if (is_array($selectedOptionIds)) {
                            foreach ($optionsList as $option) {
                                if (in_array($option['id'], $selectedOptionIds)) {
                                    $selectedOptionNames[] = $option['name'];
                                }
                            }
                        }
                    }


                    // Set initial category block
                    if (!isset($finalGroupedArray[$categoryId])) {
                        $finalGroupedArray[$categoryId] = [
                            'category_id' => $categoryId,
                            'test_date' => $entry['test_date'] ?? '',
                         
                            'subcategories' => []
                        ];
                    }

                    $finalGroupedArray[$categoryId]['subcategories'][] = [
                        'subcategory_id' => $subcategoryId,
                        'description' => $entry['description'] ?? '',
                        'options' => $selectedOptionNames,
                        'is_contrast' => $entry['is_contrast'],
                    ];

                    $imagingTestIds[] = $subcategoryId;
                }
            }


         

            
            // $imagingTestIds = $this->Corefunctions->getIDSfromArray($imagingItemLists,'sub_lab_test_id');
            $imagingcptCodes = RefLabTest::getImageinfCtp($imagingTestIds);
            $imagingcptCodes = $this->Corefunctions->getArrayIndexed1($imagingcptCodes, 'imaging_test_id');
 
            $cptIDS = $this->Corefunctions->getIDSfromArray($imagingcptCodes,'cpt_code_id');
            $cptCodes = RefLabTest::getCptCodes($cptIDS);
            $cptCodes = $this->Corefunctions->getArrayIndexed1($cptCodes, 'id');
 
 
            $data['cptCodes']   = $cptCodes ;
            $data['imagingcptCodes']   = $imagingcptCodes ;

            /** get countryCodeDetails */
            $countryCodeDetails = RefCountryCode::getCountryCodeById($userDetails['country_code']);
                
            $data['countryCodeDetails']   = $countryCodeDetails ;
            /*categoryIds all categories */
            $categoryDetails =  RefLabTest::getAllImagingCategoryList();
            $categoryDetails = $this->Corefunctions->getArrayIndexed1($categoryDetails, 'id');
            
             $data['patientDetails']   = $patientDetails ;
             $data['userDetails']      = $userDetails ;
             $data['imagingList']       = $imagingList ;
             $data['finalTestArray']       = $finalGroupedArray ;
             $data['categoryDetails']  = $categoryDetails ;
             $data['clinicDetails']  = $clinicDetails ;
             $data['countryCodedetails']  = $countryCodedetails;
             $html                     = view('appointment.imaging.orderlist', $data);
 
             $arr['view']    = $html->__toString();
             $arr['success'] = 1;
             $arr['key'] = $labkey ;
             $arr['message'] = 'Data fetched successfully';
             return response()->json($arr);
         }
     }



}
