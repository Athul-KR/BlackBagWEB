<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\RefDesignation;
use App\Models\Notification;
use App\Models\RefLabTest;
use App\Models\PatientLabTest;
use App\Models\PatientLabTestItem;
use App\Models\RefCountryCode;
use Illuminate\Support\Facades\Route;
use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use File;

class LabsController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        // Middleware for session check
        $this->middleware(function ($request, $next) {
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
               
                $method = Route::current()->getActionMethod();
                if(!in_array($method,array('getOrderList','printLabsOrder'))){
                    return Redirect::to('/');
                }
                // 
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
    public function addLabs()
    {
        if(request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
          
            /* category list  */
            $categoryList    = RefLabTest::getCategoryList();

            /** get patient Details */
            $patientDetails = $this->getPatientDetails($data['userID']);
            
            /*user details */
            $userDetails = ClinicUser::getClinicUserByUserId(Session::get('user.userID'));
            $userDetails = $this->Corefunctions->convertToArray($userDetails);
            $finalTestArray = $orderLists =  array();
            /** get countryCodeDetails */
            $countryCodeDetails = RefCountryCode::getCountryCodeById($userDetails['country_code']);
      
            $data['countryCodeDetails']  = $countryCodeDetails ;
            $data['finalTestArray']  = $finalTestArray ;
            $data['orderLists']      = $orderLists ;
            $data['userDetails']     = $userDetails ;
            $data['patientDetails']  = $patientDetails ;
           
            $data['categoryList']    = $categoryList ;
            $html           = view('appointment.labs.addlabs', $data);
            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
         }
    }

    private function getPatientDetails($userID){
        /** get patient Details */
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userID));
            $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'] : $patientDetails['first_name'];
            $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);
             return  $patientDetails;
    }
    private function saveLabsOrder($formdata,$userID){

        /* insert to lab test table */
        $lab_test_uuid  = $this->Corefunctions->generateUniqueKey('8', 'patient_lab_tests', 'lab_test_uuid') ;
        $insertArray = [
            'lab_test_uuid'   => $lab_test_uuid ,
            'test_date'       =>  date('Y-m-d'),
            'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
            'patient_id'      => $userID ,
        ];
        $labId = PatientLabTest::insertLabTests($insertArray);

        foreach ($formdata as $input) {
            $subcategoryIds =array();
            if ( isset($input['subcategory_id']) &&  is_string($input['subcategory_id'])) {
                $subcategoryIds = explode(',',$input['subcategory_id']);
            }
            // Save each one into the database
            if(!empty($subcategoryIds)){
                foreach ($subcategoryIds as $subcategoryId) {
                    $insertArray = [
                        'category_id'     => isset($input['category_id']) ? $input['category_id'] : '',
                        'subcategory_id'  => $subcategoryId ,
                        'test_date'       => date('Y-m-d'),
                        'description'     => isset($input['description'])  && $input['description'] != '' ? $input['description']  : '',
                        'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
                        'patient_id'      => $userID ,
                    
                    ];

                    /* insert items */
                    PatientLabTest::insertLabTestItems($insertArray,$labId);
                }
            }else{

                $insertArray = [
                    'category_id'     => isset($input['category_id']) ? $input['category_id'] : '',
                    'subcategory_id'  => null ,
                    'test_date'       => date('Y-m-d'),
                    'description'     => isset($input['description'])  && $input['description'] != '' ? $input['description']  : '',
                    'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
                    'patient_id'      => $userID ,
                
                ];

                /* insert items */
                PatientLabTest::insertLabTestItems($insertArray,$labId);

            }

          
        }
        return $lab_test_uuid ;


    }

    private function updateLabsOrderItems($formdata,$userID,$labId){
        DB::table('patient_lab_test_items')->where('patient_lt_id',$labId)->update(array(
            'deleted_at' => Carbon::now(),
        ));
        foreach ($formdata as $input) {

            if (is_string($input['subcategory_id'])) {
                $subcategoryIds = explode(',',$input['subcategory_id']);
            }
             // Save each one into the database
             if(!empty($subcategoryIds)){
                foreach ($subcategoryIds as $subcategoryId) {
                    $insertArray = [
                        'category_id'     => isset($input['category_id']) ? $input['category_id'] : '',
                        'subcategory_id'  => $subcategoryId ,
                        'test_date'       => date('Y-m-d'),
                        'description'     => isset($input['description'])  && $input['description'] != '' ? $input['description']  : '',
                        'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
                        'patient_id'      => $userID ,
                    
                    ];
                    /* insert items */
                    PatientLabTest::insertLabTestItems($insertArray,$labId);
                }  
            }else{

                $insertArray = [
                    'category_id'     => isset($input['category_id']) ? $input['category_id'] : '',
                    'subcategory_id'  => null ,
                    'test_date'       => date('Y-m-d'),
                    'description'     => isset($input['description'])  && $input['description'] != '' ? $input['description']  : '',
                    'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
                    'patient_id'      => $userID ,
                
                ];

                /* insert items */
                PatientLabTest::insertLabTestItems($insertArray,$labId);

            }
            // $insertArray = [
            //     'category_id'     => isset($input['category_id']) ? $input['category_id'] : '',
            //     'subcategory_id'  => isset($input['subcategory_id']) ? $input['subcategory_id'] : '',
            //     'test_date'       => date('Y-m-d') ,
            //     'description'     => isset($input['description'])  && $input['description'] != '' ? $input['description']  : '',
            //     'clinic_id'       => (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID') ,
            //     'patient_id'      => $userID ,
            // ];

           
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
            $countryCodedetails =array();
            if (!isset($data['userID'])) {
                return $this->Corefunctions->returnError('Key missing');
            }

            /*  view from listing  */
            if(isset($data['orderKey']) && $data['orderKey'] !=''){
                $labkey = $data['orderKey'];
            }elseif(isset($data['labkey']) && $data['labkey'] !=''){
                $labkey = $data['labkey'] ;
                $orderLists =  PatientLabTest::getPatientLabTest($labkey) ;
                $formdata = $data['formdata'] ;
                $allEntries = json_decode($formdata, true);
                $this->updateLabsOrderItems($allEntries,$data['userID'],$orderLists['id']);
            }else{
                $formdata = $data['formdata'] ;
                $allEntries = json_decode($formdata, true); // true = decode as associative array
              
                /* save the print page details */
                $labkey = $this->saveLabsOrder($allEntries,$data['userID']);
    
            }
            
            /** get patient Details */
            $patientDetails = $this->getPatientDetails($data['userID']);
            
            
            $finalTestArray = $orderLists = $userDetails = array();
            $clinicId = session()->get('user.clinicID');
            $clinicDetails = Clinic::clinicByID($clinicId);
            $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
            if(!empty($clinicDetails)){
                $countryCodedetails = RefCountryCode::getCountryCodeById($clinicDetails['country_code']);
            }
            
          
            if (isset($labkey) && $labkey != '') {
                /* get the test lists */
                $orderLists =  PatientLabTest::getPatientLabTest($labkey) ;
                if (empty($orderLists)) {
                    $arr['error'] = 1;
                    $arr['message'] = 'Invalid lab order';
                    return response()->json($arr);
                }if($orderLists['patient_id'] != $data['userID'] ){
                    $arr['error'] = 1;
                    $arr['message'] = 'Invalid lab order';
                    return response()->json($arr);
                }
                /* get the test item lists */
                $orderItemLists =  PatientLabTest::getPatientLabItems($orderLists['id']) ;                
        
                foreach ($orderItemLists as $item) {
                    $labId = $item['lab_test_id'];
                    $subId = isset($item['sub_lab_test_id']) && (trim($item['sub_lab_test_id']) !='') ? $item['sub_lab_test_id'] : '';
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
                $userDetails = ClinicUser::getClinicUserByUserId($orderLists['created_by']);
                $userDetails = $this->Corefunctions->convertToArray($userDetails);
            }
          
           
            /*categoryIds all categories */
            $categoryDetails =  RefLabTest::getAllCategoryList();
            $categoryDetails = $this->Corefunctions->getArrayIndexed1($categoryDetails, 'id');

             /** get countryCodeDetails */
             $userCountryCode = RefCountryCode::getCountryCodeById($userDetails['country_code']);
      

             $data['userCountryCode']   = $userCountryCode ;
            $data['patientDetails']   = $patientDetails ;
            $data['userDetails']      = $userDetails ;
            $data['orderLists']       = $orderLists ;
            $data['finalTestArray']       = $finalTestArray ;
            $data['categoryDetails']  = $categoryDetails ;
            $data['clinicDetails']  = $clinicDetails ;
            $data['countryCodedetails']  = $countryCodedetails;
            $html                     = view('appointment.labs.orderlistprint', $data);

            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            $arr['key'] = $labkey ;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

    public function printLabsOrder(Request $request, $labKey)
    {
        $orderLists =  PatientLabTest::getPatientLabTest($labKey) ;
        if(empty($orderLists)){
            return Redirect::to('/dashboard'); 
        }
       
        $usertype = Session::get('user.userType');
        /** get patient Details */
        if($usertype == 'patient'){
            if(session('user.userID') != $orderLists['patient_id']){
                return Redirect::to('patient/dashboard'); 
            }
        }else{
            if(session()->get('user.clinicID') != $orderLists['clinic_id']){
                return Redirect::to('/dashboard'); 
            }
        }
           
            

        $patientDetails = $this->getPatientDetails($orderLists['patient_id']);
       $url = url("/labs/print/orders/" . $labKey);
        $patientName = preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '_', $patientDetails['first_name']));
        $filename = 'LabForm_'.$patientName.'_'.date('Y-m-d',strtotime($orderLists['test_date'])).'.pdf';
    
        //$filename = $labKey . '_labsprint' . time() . '.pdf';
    
        if (!is_dir(TEMPDOCPATH))
            mkdir(TEMPDOCPATH);
        if (!is_dir(TEMPDOCPATH.'/'.$orderLists['patient_id']))
            mkdir(TEMPDOCPATH.'/'.$orderLists['patient_id']);
        $tempPath = TEMPDOCPATH.'/'.$orderLists['patient_id'].'/' . $filename;
        $output   = shell_exec('/usr/local/bin/wkhtmltopdf --enable-javascript  --enable-javascript  -T 2.54cm -B 2.54cm ' . escapeshellarg($url) . ' --footer-right "[page] of [toPage]" ' . escapeshellarg($tempPath) . ' 2>&1');
        
        $printpath = url(TEMPDOCPATH.'/'.$orderLists['patient_id'].'/' . $filename);
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
   
    public function invoiceHtmlToPdf($labKey)
    {

       
        $url      = url("labs/print/orders") . "/" . $labKey;

        $url = "https://icwares.com/pdfgen/?url=" . $url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $imagePath2 = $response['pdfurl'];

        return $imagePath2;
    }

    //Search Function
    public function labsearch($type)
    {
        if (request()->ajax()) {
            $search = request('search');
            $clinicId = session()->get('user.clinicID');
            if ($type == "category") {
                $category = RefLabTest::getCategoryList($search);
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
                $subCategory = RefLabTest::getSubcategoryListByCategory($categoryID,$search);
                $subCategory = $categoryID == '' ? array() : $subCategory ;
                if (empty($subCategory)) {
                    $html .= '<select  multiple class="form-control multiselsub multiselcustomers select_subcategory_list" name="subcategory_id" id="subcategories" style="cursor:pointer" ></select>';
                } else {
                    // foreach ($subCategory as $cl) {
                    //     $html .= '<li id="cat_' . $cl['id'] . '" class="dropdown-item select_subcategory_list" style="cursor:pointer">';
                    //     $html .= '<div class="dropview_body"><p  class="m-0 select_subcategory_item" data-id="' . $cl['id'] . '">' . $cl['name'] . '</p></div>';
                    //     $html .= '</li>';
                    // }
                    $html .= ' <select multiple class="form-control multiselsub multiselcustomers select_subcategory_list" name="subcategory_id" id="subcategories" style="cursor:pointer" >';
                    foreach ($subCategory as $cl) {
                        $html .= '<option class="vars" value="'.$cl['id'] .'" data-id="' . $cl['id'] . '" >' . $cl['name'] . '</option>';
                      
                    }
                    $html .= ' </select>';
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
     public function deleteitem()
     {
         if(request()->ajax()) {
             $data = request()->all();
             // Check if form data is empty
             if (empty($data)) {
                 return $this->Corefunctions->returnError('Fields missing');
             }
          
            if($data['type']  == 'catogory'){
                $testDetails = PatientLabTest::getPatientLabTest($data['key']);
                if(!empty($testDetails)){
                    PatientLabTest::deleteAllLabTests($data['key']);

                    /* delete all items  */
                    DB::table('patient_lab_test_items')->where('patient_lt_id',$testDetails['id'])->update(array(
                        'deleted_at' => Carbon::now(),
                    ));
                    
                }
               
            }else{
                PatientLabTestItem::deleteLabTests($data['key']);
            }
          
           
             $arr['success'] = 1;
             $arr['message'] = 'Data fetched successfully';
             return response()->json($arr);
         }
     }



     public function addOrder()
     {
         if(request()->ajax()) {
             $data = request()->all();
             // Check if form data is empty
             if (empty($data)) {
                 return $this->Corefunctions->returnError('Fields missing');
             }
             $formdata = $data['formdata'] ;
             $allEntries = json_decode($formdata, true); // true = decode as associative array
           

             $finalGroupedArray = [];
             $orderLists =  array();
            
            // foreach ($allEntries as $entry) {
            //     $orderLists['test_date'] = date('Y-m-d');
            //     $categoryId = $entry['category_id'];
            //     // Remove token since it's repeated and not needed in grouping
            //     unset($entry['_token']);
                
            //     if (!isset($finalGroupedArray[$categoryId])) {
            //         $finalGroupedArray[$categoryId] = [
            //             'category_id' => $categoryId,
            //             'test_date' => date('Y-m-d'),
            //             'subcategories' => []
            //         ];
            //     }

            //     $finalGroupedArray[$categoryId]['subcategories'][] = [
            //         'subcategory_id' => $entry['subcategory_id'],
            //         'description' => $entry['description'],
            //     ];
            // }
            foreach ($allEntries as $entry) {
                $orderLists['test_date'] = date('Y-m-d');
                $categoryId = $entry['category_id'];
        
                $subcategoryIds = isset($entry['subcategory_id']) && trim($entry['subcategory_id']) != '' ? explode(',', $entry['subcategory_id']) : array();

                $description = isset($entry['description']) ? $entry['description'] : '';

                if (empty($subcategoryIds)) {
                  
                    $finalGroupedArray[$categoryId]['subcategories'][] = [
                        'subcategory_id' => '',
                        'description' => $description,
                        'test_date' => date('Y-m-d'),
                    ];
                }

                // Only process subcategory IDs if available
                if (!empty($subcategoryIds)) {
                    foreach ($subcategoryIds as $subId) {
                        $subId = trim($subId);
                        if ($subId !== '') {
                           
                            $finalGroupedArray[$categoryId]['subcategories'][] = [
                                'subcategory_id' => $subId,
                                'description' => $description,
                            ];
                        }
                    }
                }



            }

         
            /** get patient Details */
            $patientDetails = $this->getPatientDetails($data['userID']);
            /*user details */
            $userDetails = ClinicUser::getClinicUserByUserId(Session::get('user.userID'));
            $userDetails = $this->Corefunctions->convertToArray($userDetails);
            /** get countryCodeDetails */
            $countryCodeDetails = RefCountryCode::getCountryCodeById($userDetails['country_code']);
      
            /*categoryIds all categories */
            $categoryDetails =  RefLabTest::getAllCategoryList();
            $categoryDetails = $this->Corefunctions->getArrayIndexed1($categoryDetails, 'id');

            $data['countryCodeDetails']   = $countryCodeDetails ;
            $data['patientDetails']   = $patientDetails ;
            $data['userDetails']      = $userDetails ;
            $data['orderLists']       = $orderLists ;
            $data['finalTestArray']   = $finalGroupedArray ;
            $data['categoryDetails']  = $categoryDetails ;

           
            $data['formdata']           = $formdata ;
          
             $html                     = view('appointment.labs.orderlist', $data);
 
             $arr['view']    = $html->__toString();
             $arr['success'] = 1;
             $arr['message'] = 'Data fetched successfully';
             return response()->json($arr);
         }
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
                $orderLists =  PatientLabTest::getPatientLabTest($labkey);
            }
            
            /** get patient Details */
            $patientDetails = $this->getPatientDetails($data['userID']);
            
            $finalTestArray = $orderLists = $userDetails = array();
            $clinicId = session()->get('user.clinicID');
            $clinicDetails = Clinic::clinicByID($clinicId);
            $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
            $countryCodedetails = RefCountryCode::getCountryCodeById($clinicDetails['country_code']);

            if (isset($labkey) && $labkey != '') {
                /* get the test lists */
                $orderLists =  PatientLabTest::getPatientLabTest($labkey) ;

                /* get the test item lists */
                $orderItemLists =  PatientLabTest::getPatientLabItems($orderLists['id']) ;                

                foreach ($orderItemLists as $item) {
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
                $userDetails = ClinicUser::getClinicUserByUserId($orderLists['created_by']);
                $userDetails = $this->Corefunctions->convertToArray($userDetails);
            }
            
            /*categoryIds all categories */
            $categoryDetails =  RefLabTest::getAllCategoryList();
            $categoryDetails = $this->Corefunctions->getArrayIndexed1($categoryDetails, 'id');

            $data['patientDetails']   = $patientDetails ;
            $data['userDetails']      = $userDetails ;
            $data['orderLists']       = $orderLists ;
            $data['finalTestArray']       = $finalTestArray ;
            $data['categoryDetails']  = $categoryDetails ;
            $data['clinicDetails']  = $clinicDetails ;
            $data['countryCodedetails']  = $countryCodedetails;
            $html                     = view('appointment.labs.orderlist', $data);

            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            $arr['key'] = $labkey ;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

}
