<?php

namespace App\Http\Controllers;

use App\Models\BusinessHour;
use App\Models\BusinessHoursTime;
use App\Models\Clinic;
use App\Models\ClinicGallery;
use App\Models\ClinicUser;
use App\Models\RefState;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use App\Models\StripeConnection;
use App\Models\RefDesignation;
use App\Models\RefCountryCode;
use App\Models\Subscription;
use App\Models\ClinicCard;
use App\Models\Payment;
use App\Models\ClinicSubscription;
use App\Models\Invoice;
use App\Models\RefConsultationTime;
use App\Models\RefSpecialty;
use App\Models\RefPlanIcons;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Psy\Command\WhereamiCommand;
use Redirect;
use Str;
use Illuminate\Support\Facades\Session;
use App\Models\Vacation;

class ClinicController extends Controller
{


    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->stripePayment      = new \App\customclasses\StripePayment;

        
        if ($this->Corefunctions->validateClincOnboarding()) {
            return Redirect::to('/onboarding/business-details');
        }
    }
   //View Profile
    public function profile()
    {
       
        if (Session::has('user') && session()->get('user.userType') == 'patient' ) {
            return Redirect::to('/');
        }
        if (session()->has('user') == false || session()->get('user.userType') == 'nurse' || session()->get('user.userType') == 'doctor') {
            return Redirect::to('/login');
        }
       
        if ($this->Corefunctions->validateClincOnboarding()) {
            return Redirect::to('/onboarding/business-details');
        }

        $urlArray = $_GET;
    
        if (!isset($urlArray['code']) && isset($_GET['state']) && $_GET['state'] != '') {
            $iserror = isset($_GET['error']) && $_GET['error_description'] && $_GET['error']!='' && $_GET['error_description'] !='' ? $_GET['error_description'] : '' ;
            return Redirect::to('/logout')->with('message',$iserror);
        }
        if (isset($urlArray['code']) && $urlArray['code'] != '') {
            $connectionID = $this->Corefunctions->connectStripe($urlArray);
            Session::put("user.stripeConnection", 1);
            return redirect()->to('profile'); 
        }

        $clinicId = session('user.clinicID');
        $clinic = Clinic::getClinicWithstate($clinicId);
       
        $clinicUser = ClinicUser::userByClinicID($clinic->id);
        $states     = RefState::get();

        $clinic['logo'] = ($clinic['logo'] != '') ? $this->Corefunctions->resizeImageAWS($clinic['id'],$clinic['logo'],$clinic['name'],180,180,'1') : asset("images/default_clinic.png");
        $clinic['banner_img'] = ($clinic['banner_img'] != '') ? $this->Corefunctions->resizeImageAWS($clinic['id'],$clinic['banner_img'],$clinic['name'],550,190,'1') : asset('images/default banner.png');

        $galleryImages      = ClinicGallery::getGalleryByClinic($clinicId);
        $clinicCountryCode  = RefCountryCode::getCountryCodeById($clinic->country_code);
        $countryCode        = RefCountryCode::getCountryCodeById($clinicUser->country_code);
        $businessHours_data = BusinessHour::getBusinessHour($clinicId);

        $businessHours = [
            'Monday' => ['day' => 'Monday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Tuesday' => ['day' => 'Tuesday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Wednesday' => ['day' => 'Wednesday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Thursday' => ['day' => 'Thursday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Friday' => ['day' => 'Friday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Saturday' => ['day' => 'Saturday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Sunday' => ['day' => 'Sunday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
        ];
        if (!$businessHours_data->isEmpty()) {
            foreach ($businessHours_data as $data) {
                // Check if the 'businessHourTime' relationship is not empty
                if ($data->businessHourTime) {
                    // Format the times using Str::of() for the start and end times
                    $start_time = $data->businessHourTime->from_time ? Carbon::parse($data->businessHourTime->from_time)->format('g:i A') : null;
                    $end_time = $data->businessHourTime->to_time ? Carbon::parse($data->businessHourTime->to_time)->format('g:i A') : null;
                    // Populate the array for the specific day
                    $businessHours[$data->day] = [
                        'day' => $data->day,
                        'bussinesshour_uuid' => $data->bussinesshour_uuid,
                        'is_open' => $data->isopen,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    ];
                }
            }
        }   

        foreach ($galleryImages as $galleryImage) {
            $galleryImage->image = ($galleryImage->image_path != '') ? $this->Corefunctions->getAWSFilePath($galleryImage->image_path) : "No Images Found";
        }

        // Fetch country ID from ref_country_codes table
        $countryDetails = RefCountryCode::getAllCountry();
        $clientSecret ='';
        if( !empty($clinic) ){
            $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($clinic,Session::get('user.email')); 
            if(!empty($clientSecretResponse)){
                $clientSecret = $clientSecretResponse['response'];
                if($clinic['stripe_customer_id'] == ''){
                    Payment::UpdateUserStripeCustomerIdInClinics($clinic['id'],$clientSecretResponse['customerID']);
                }
            }
        }

        if (empty($clinic)) {
            return redirect()->back()->with('error', 'Clinic not found!');
        }
        $timezoneDetails = User::getTimeZone();
        $seo['title']          = "Manage Clinic | " . env('APP_NAME');
        $seo['keywords']       = "Dashboard Overview, Upcoming Appointments, Today’s Appointments,
                                  Patient Appointment Details, Patient Name and Contact, Appointment Date and Time
                                  Online Appointments, See All Appointments, Black Bag Patient Management,
                                  Healthcare Scheduling, Patient Actions and Updates, Appointment Notifications ";

        $seo['description']    = "Manage your healthcare appointments seamlessly with the Black Bag
                                  dashboard. View upcoming patient details, appointment types, and schedules. Stay
                                  updated with notifications and easily access actions for efficient management";

        $seo['og_title']       = "Dashboard | " . env('APP_NAME');
        $seo['og_description'] = "Manage your healthcare appointments seamlessly with the Black Bag
                                  dashboard. View upcoming patient details, appointment types, and schedules. Stay
                                  updated with notifications and easily access actions for efficient management";


        return view('clinics.view-profile', compact('clinic', 'states', 'galleryImages', 'businessHours', 'clinicCountryCode', 'countryCode','countryDetails','clinicUser','seo','clientSecret','timezoneDetails'));
    }


    public function updateProfile()
    {
        $data = request()->all();
        parse_str($data['formData'], $input);
        $uuid = $input['clinic_uuid'];
        
        // Perform validation on the parsed form data
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'countrycode' => 'required',
            'website_link' => 'nullable|regex:/^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}([\/\w .-]*)*\/?$/',
            'address' => 'required',
            'city' => 'required',
            // 'state_id' => 'required',
            'zip_code' => 'required|numeric',
        ], [
            'website_link.regex' => 'The website link must be a valid URL',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => 'Error!',
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'redirect' => route('clinic.profile'),
            ]);
        }

        // Fetch country ID from ref_country_codes table
        $countryCode = $this->Corefunctions->convertToArray(Clinic::countryCodeByShortCode($input['countryCodeShort']));
        if (empty($uuid)) {
            return response()->json([
                'success' => 'Error!',
                'status' => 'error',
                'message' => 'Invalid key or Clinic details not found',
                'redirect' => route('clinic.profile'),
            ]);
        }

        $clinic = Clinic::clinicByUUID($uuid);
        if (empty($clinic)) {
            $data['success'] = "Error!";
            $data['status'] = "error";
            $data['redirect'] = route('clinic.profile');
            $data['message'] = "Clinic details not found";
        }
        $user = User::userByID(session('user.userID'));
        if (empty($user)) {
            $data['success'] = "Error!";
            $data['status'] = "error";
            $data['redirect'] = route('clinic.profile');
            $data['message'] = "User details not found";
        }
        $crppathLogo = (isset($clinic->logo) && ($clinic->logo != '')) ? $clinic->logo : '';
        $crppathBanner = (isset($clinic->banner_img) && ($clinic->banner_img != '')) ? $clinic->banner_img : '';

        if ($input['isremove'] == 1) {
           
            $crppathLogo = '';
             Session::put("user.clinicLogo", '');
        }
        if ($input['isremove_banner'] == 1) {
            $crppathBanner = '';
        }
       
        Clinic::updateClinic($uuid,$input,$crppathLogo,$crppathBanner,$countryCode);
        Session::put("user.clinicName", $input['name']);
        /* Clinic Image Upload */
        if ($input['tempimage'] != "") {
            $this->Corefunctions->uploadImage($input,'','clinic',$clinic->id,$clinic->clinic_uuid);

        }

        // Process Banner Image (tempimage_banner)
        if ($input['tempimage_banner'] != "") {
            $input['tempimage'] =$input['tempimage_banner'] ;
            $this->Corefunctions->uploadImage($input,'','clinicbanner',$clinic->id,$clinic->clinic_uuid);
        }

        $message ='Clinic details updated successfully';
        if($input['timezone_id'] != $clinic->timezone_id){
            $message.= '.Changing the timezone requires manually updating the business hours.';
        }
        // Return success response
        return response()->json([
            'success' => "Success!",
            'status' => "success",
            'message' => $message,
            'redirect' => route('clinic.profile'),

        ]);
    }
    /* not in use */
    public function updateUserProfile()
    {
        $data = request()->all();
        parse_str($data['formData'], $input);
        $uuid = $input['clinic_uuid'];
        // dd($input);
        if (empty($uuid)) {
            return response()->json([
                'success' => 'Error!',
                'status' => 'error',
                'message' => 'Invalid key or Clinic details not found',
                'redirect' => route('clinic.profile'),
            ]);
        }

        // Fetch country ID from ref_country_codes table
        $countryCode = $this->Corefunctions->convertToArray(Clinic::countryCodeByShortCode(strtoupper($input['countryCodeShort'])));

        $clinic = Clinic::clinicByUUID($uuid);
        if (empty($clinic)) {
            $data['success'] = "Error!";
            $data['status'] = "error";
            $data['redirect'] = route('clinic.profile');
            $data['message'] = "Clinic details not found";
        }

        $clinicUser = ClinicUser::where('user_type_id', '1')->where('status', '1')->where('clinic_id', $clinic->id)->first();
        $clinicUserDetails = ClinicUser::where('user_type_id', '!=', '1')->whereNull('deleted_at')->where('phone_number', $input['phone_number'])->where('country_code', $countryCode['id'])->where('clinic_id', $clinic->id)->first();
        if (!empty($clinicUserDetails)) {
            return response()->json(['status' => 'error', 'message' => 'User with phone number already exist']);
        }
        
        $clinicUserDetails = ClinicUser::where('user_type_id', '!=', '1')->whereNull('deleted_at')->where('email', $input['email'])->where('clinic_id', $clinic->id)->first();
        if (!empty($clinicUserDetails)) {
            return response()->json(['status' => 'error', 'message' => 'User with email ID already exist']);
        }

        $patientDetails = Patient::whereNull('deleted_at')->where('phone_number', $input['phone_number'])->where('country_code', $countryCode['id'])->where('clinic_id', $clinic->id)->first();
        if (!empty($patientDetails)) {
            return response()->json(['status' => 'error', 'message' => 'User with phone number already exist']);
        }

        $patientDetails = Patient::whereNull('deleted_at')->where('email', $input['email'])->where('clinic_id', $clinic->id)->first();
        if (!empty($patientDetails)) {
            return response()->json(['status' => 'error', 'message' => 'User with email ID already exist']);
        }
        $user = User::where('id',$clinicUser->user_id)->first();
       
        if (empty($clinicUser || $user)) {
            $data['success'] = "Error!";
            $data['status'] = "error";
            $data['redirect'] = route('clinic.profile');
            $data['message'] = "User details not found";
        }

        // Update clinic_user details
        $clinicUser->name = $input['name'];
        $clinicUser->email = $input['email'];
        $clinicUser->phone_number = $input['phone_number'];
        $clinicUser->country_code = $countryCode['id'];
        $clinicUser->update();


        // Update user details
        $user->first_name = $input['name'];
        $user->email = $input['email'];
        $user->phone_number = $input['phone_number'];
        $user->country_code = $countryCode['id'];
        $user->update();


      
        Session::put("user.firstName",$input['name']);
        Session::put("user.email",$input['email']);
        Session::put("user.phone",$input['phone_number']);
        
        // Return success response
        return response()->json([
            'success' => "Success!",
            'status' => "success",
            'username' =>$input['name'],
            'email' =>$input['email'],
            'message' => "Clinic details updated successfully",
            'redirect' => route('clinic.profile'),

        ]);
    }

    public function saveAbout()
    {
        // Get the clinic ID from the session
        $clinicId = session('user.clinicID');
        // Get the raw input data from the request (the serialized form data)
        $data = request()->all();
        parse_str($data['formData'], $input);  // Parse the form data into a usable array

        $clinic = Clinic::find($clinicId);
        $clinic->update([
            'about' => $input['notes'],
        ]);
        // Return a success response
        return response()->json([
            'success' => 1,
            'redirect' => back(),
            'message' => 'About updated successfully!'
        ]);
    }

    public function galleryImages(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
            }
            $docs = $data['file'];
            if (empty($docs)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
            }
            $size = filesize($data['file']);
            $fileSizeInMB = $size / (1024 * 1024);
            $fileSizeInMB = round($fileSizeInMB, 2);

            if ($fileSizeInMB > '3') {
                $arr['error'] = 1;
                $arr['errormsg'] = 'You could upload files with size of only maximum 3 Mb';
                return response()->json($arr);
            }

            $filename = $data['file']->getClientOriginalName();
            $ext = $data['file']->getClientOriginalExtension();

            /** Insert to temp doc table  */
            $docKey = $this->Corefunctions->generateUniqueKey('10', 'temp_docs', 'tempdoc_uuid');
            $tempdocid = ClinicGallery::insertTempDocs($docKey, $ext, $filename);

            $tempdocpath = $this->Corefunctions->getMyPath1($tempdocid, $docKey, $ext, TEMPDOCPATH);
            $fileName = $docKey . "." . $ext;
            $data['file']->move(TEMPDOCPATH, $fileName);
            $temdocppath = url(TEMPDOCPATH . $fileName);

            $arr['success'] = 1;
            $arr['filesize'] = $fileSizeInMB;
            $arr['tempkey'] = $docKey;
            $arr['docname'] = $filename;
            $arr['tempdocpath'] = $temdocppath;
            $arr['tmpname'] = $docKey . '.' . $ext;
            $arr['ext'] = $ext;
            $arr['tempdocid'] = $tempdocid;
            return response()->json($arr);
        }
    }

    public function storeGalleryImage()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }
            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            $clinicID = session('user.clinicID');

            /** upload gallery documents  */
            if (isset($input['patient_docs']) && $input['patient_docs'] != '') {
                foreach ($input['patient_docs'] as $key => $val) {
                    $tempDoc = ClinicGallery::getTempDocs($val['tempdocid'])  ;
                    $originalpath = TEMPDOCPATH . $tempDoc['tempdoc_uuid'] . '.' . $tempDoc['temp_doc_ext'];
                    $file_size = filesize($originalpath);

                    $dockey = $this->Corefunctions->generateUniqueKey('8', 'clinic_gallery', 'gallery_uuid');
                    $docid = ClinicGallery::insertToGallery($tempDoc,$clinicID,$dockey);
                  
                    $crppath = $this->Corefunctions->getMyPathForAWS($docid, $dockey, $tempDoc['temp_doc_ext'], 'uploads/clinic-gallery/');
                    $image_path = file_get_contents($originalpath);
                    if ($this->Corefunctions->uploadDocumenttoAWS($crppath, $image_path)) {
                        $imagepath = $crppath;
                    }
                    ClinicGallery::updateImageToGallery($docid,$imagepath);
                 
                    unlink($originalpath);
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Image added successfully';
            return response()->json($arr);
        }
    }

    public function removeGalleryImage(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }
            $patientDoc = ClinicGallery::getGalleryByKey($data['uuid']);
            $patientDoc->delete();
            $arr['success'] = 1;
            $arr['message'] = 'Image removed successfully';
            return response()->json($arr);
        }
    }
    public function tabContent(Request $request)
    {
        if (request()->ajax()) {
            $input = request()->all();
            $clinicId = session('user.clinicID');
            
            $clinic      = Clinic::getClinicWithstate($clinicId,'tab') ;
            $clinic['logo'] = ($clinic['logo'] != '') ? $this->Corefunctions->resizeImageAWS($clinic['id'],$clinic['logo'],$clinic['name'],180,180,'1') : asset("images/default_clinic.png");

            // $clinicUser  = ClinicUser::userByClinicID($clinic->id);
            // $countryCode = RefCountryCode::getCountryCodeById($clinicUser->country_code); // not used
            $formType = $input['type'] ;
            switch ($formType) {
                case 'clinicprofile':
                    $countryCodeDetails =array();
                    /*  get rinmary clinic user details */
                    $clinicUser = ClinicUser::getPrimaryclinicUserWithSpeciality() ;
                    if(!empty($clinicUser)){
                        $clinicUser['logo_path'] = ($clinicUser['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicUser['logo_path']) : '';
                        $designationDetails = ($clinicUser['designation_id'] != '') ? RefDesignation::designationByID($clinicUser['designation_id']) : array() ;
                        $clinicUser['designation'] = (!empty($designationDetails)) ?  $designationDetails['name'] : '';
                          /** get countryCodeDetails */
                        $countryCodeDetails =RefCountryCode::getCountryCodeById($clinicUser['country_code']);
                    }
                    $clinicCountryCode  = RefCountryCode::getCountryCodeById($clinic['country_code']);

                    $timezoneDetails = User::getTimeZone();
                    $timezoneDetails = $this->Corefunctions->convertToArray($timezoneDetails);
                    $timezoneDetails = $this->Corefunctions->getArrayIndexed1($timezoneDetails,'id');

                    $html = view('clinics.'.$input['type'] , compact('clinic','clinicUser','countryCodeDetails','clinicCountryCode','timezoneDetails'));

                break;

                case 'stripe_info':

                   
                    $clinicUser = ClinicUser::getclinicUserWithSpeciality() ;
                    $clinicUser['logo_path'] = ($clinicUser['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicUser['logo_path']) : '';
                   
                    $clinicStripeId = Clinic::getStripeConnectId($clinicId);

                    $stripeData = array();
                    if($clinicStripeId != null){
                        $stripeData = StripeConnection::getStripeConnectionInfo($clinicStripeId);
                       
                    }
                    $stripeData['is_connected']  = $clinicStripeId == null ? 0 : 1; 
                    $stripeData['url'] = $clinicStripeId == null 
                    ? 'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&stripe=connect&state=' . $clinicUser['clinic_user_uuid'] . '&redirect_uri=' . url("profile")
                    : "/disconnect/stripe";
                    $stripeData['text'] = "To enjoy seamless onboarding, effortless bank validation and swift payouts for a trusted and efficient experience we use Stripe Connect";
                    $clinicUser['name'] = $this->Corefunctions->showClinicanName($clinicUser,'1');

                    $html = view('clinics.stripe-info', compact('clinic','clinicUser','stripeData'));
                break ;

                case 'patientsubscription':

                    $clinicId = session('user.clinicID');
                    $subscritionList = ClinicSubscription::getClinicSubscriptions($clinicId);
                    $genericPlans =  ClinicSubscription::getAllGenericPlan();

                    $isGeneric = ClinicSubscription::getClinicGenericSubscription($clinicId);

                  
                    
                    $planIcons = $this->Corefunctions->convertToArray(RefPlanIcons::all());
                    $planIcons = $this->Corefunctions->getArrayIndexed1($planIcons,'id');
                    
                    $html = view('clinics.'.$input['type'] , compact('subscritionList','genericPlans','isGeneric','planIcons'));
                break ;

                case 'addons':

                    $invoices = Invoice::getInvoices($clinicId);
                    $invoices = $this->Corefunctions->convertToArray($invoices);
               
                    /** check add on enabled or not  */
                    $isenabledaddon = Clinic::checkEprescribeEnabled($clinicId);
                    $users = $this->Corefunctions->convertToArray(ClinicUser::getPrescribers($clinicId));

                    $cancelledclinicaddon =  $this->Corefunctions->convertToArray( DB::table('clinic_addons')->whereNotNull('deleted_at')->select('deleted_at')->where('clinic_id',$clinicId)->first() );
                    $clinicaddon =  $this->Corefunctions->convertToArray( DB::table('clinic_addons')->whereNull('deleted_at')->select('end_date')->where('clinic_id',$clinicId)->first() );
                    // 2. Parse the end‑date
                    $nextPaymentDue = $cancelledDate = '';
                    if(!empty($cancelledclinicaddon)){
                        $endDate = Carbon::parse($cancelledclinicaddon['deleted_at']);
                        $cancelledDate = $endDate->copy()->format('m/d/Y');
                    }
                    if(!empty($users) && !empty($clinicaddon)){
                        $endDate = Carbon::parse($clinicaddon['end_date']);
                        // $nextPaymentDue = Carbon::now()->addMonthNoOverflow()->startOfMonth()->format('d/m/Y');
                        $nextPaymentDue = $endDate->copy()->format('m/d/Y');
                    }
                    $prescribedUsers = $this->Corefunctions->convertToArray(ClinicUser::getClinicLicencedPractitioners($clinicId));
                    $isUsUser = '1';
                     if(count($prescribedUsers) == '1'){
                        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
                         if( !empty($prescribedUsers)){
                             foreach( $prescribedUsers as $ps){
                                 $isUsUser      = $this->Corefunctions->checkIsUserUserForePrescribe($clinicDetails,$ps);
                           
                             }
                         }
                     }
               
                    /* check for clinic need add prescribers  */
                    $isAddPrescribers = DB::table('clinic_users')->where('eprescribe_enabled','0')->where('clinic_id',$clinicId)->whereNull('deleted_at')->count();
                    $html = view('clinics.'.$input['type'] , compact('users','invoices','nextPaymentDue','isAddPrescribers','isenabledaddon','isUsUser','cancelledDate'));
                break ;


                case 'billings':

                    $clinicUser = ClinicUser::getclinicUserWithSpeciality() ;
                    $clinicUser['logo_path'] = ($clinicUser['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicUser['logo_path']) : '';
                   
                    $clinicSubscription = Subscription::getSubscriptionByClinicId($clinicId);
                    $userCards = ClinicCard::getUserCards($clinicId);
                    if (!empty($userCards) ) {
                        foreach ($userCards as $key => $cards) {
                            $userCards[$key]['expiry'] = $cards['exp_month'].'/'.$cards['exp_year'];
                        }
                    }
                    $clientSecret = '';
           
                    $clinicStripeId = Clinic::getStripeConnectId($clinicId);

                    $stripeData = array();
                    if($clinicStripeId != null){
                        $stripeData = StripeConnection::getStripeConnectionInfo($clinicStripeId);
                       
                    }
        
                    $stripeData['is_connected']  = $clinicStripeId == null ? 0 : 1; 
                    $stripeData['url'] = $clinicStripeId == null 
                    ? 'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&stripe=connect&state=' . $clinicUser['clinic_user_uuid'] . '&redirect_uri=' . url("profile")
                    : "/disconnect/stripe";
                    $stripeData['text'] = "To enjoy seamless onboarding, effortless bank validation and swift payouts for a trusted and efficient experience we use Stripe Connect";
                    
                    if( empty( $userCardsFinalArray ) ){
                        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
                        if( !empty($clinicDetails) ){
                            $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($clinicDetails,Session::get('user.email')); 
                            if(!empty($clientSecretResponse)){
                                $clientSecret = $clientSecretResponse['response'];
                                if($clinicDetails['stripe_customer_id'] == ''){
                                    Payment::UpdateUserStripeCustomerIdInClinics($clinicDetails['id'],$clientSecretResponse['customerID']);
                                }
                            }
                        }
                    }
                    
                    $states = RefState::getStateList() ;
                    $countries = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());
                    $countries = $this->Corefunctions->convertToArray($countries);
                    $countries = $this->Corefunctions->getArrayIndexed1($countries,'id');

                    $userAddress = $this->Corefunctions->convertToArray(DB::table('user_billing')->select('user_billing_uuid', 'billing_address','billing_company_name','billing_phone','billing_city','billing_state_id','billing_state_other','billing_country_id','billing_zip','billing_country_code')->whereNull('parent_type')->where('clinic_id', $clinicId)->whereNull('deleted_at')->get());
                    $stateID  = $this->Corefunctions->getIDSfromArray($userAddress,'billing_state_id');

                    $state          = $this-> Corefunctions->convertToArray(DB::table('ref_states')->whereIn('id',$stateID)->get());
                    $state          = $this-> Corefunctions->getArrayIndexed1($state,'id');

                    $addresses = $invoices = array();
                    if (!empty($userAddress)) {
                        foreach ($userAddress as $key => $useraddr) {
                            $countryCodedetails = RefCountryCode::getCountryCodeById($useraddr['billing_country_code']);
                            $final['address']               = $useraddr['billing_address'];
                            $final['user_billing_uuid']     = $useraddr['user_billing_uuid'];
                            $final['company_name']          = $useraddr['billing_company_name'];
                            $final['country_code']          = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
                            $final['phone_number']          = $this->Corefunctions->formatPhone($useraddr['billing_phone']);
                            $final['state']                 = !empty($state) ? $state[$useraddr['billing_state_id']]['state_name'] : $useraddr['billing_state_other'];
                            $final['city']                  = $useraddr['billing_city'];
                            $final['country_id']            = $useraddr['billing_country_id'];
                            $final['postal_code']           = $useraddr['billing_zip'];
                            $addresses[]                    = $final;
                        }
                    }

                    $countryID = NULL;
                    $countryCode = NULL;
                    if( isset($clinicUser) && !empty($clinicUser) && $clinicUser['country_code'] != '' ){
                        $countryCode = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->where('id',$clinicUser['country_code'])->first());
                        if( !empty($countryCode)){
                            $countryID = $countryCode['id'];
                            $countryCode = $countryCode['country_code'];
                        }
                    }

                    $html = view('clinics.billing', compact('clinic','clinicSubscription','userCards','clientSecret','addresses','states','countries','countryID','countryCode'));
                break ;
               

                case 'workinghours':

                     /* get users list */
                    $status ='active';
                    $limit = (isset($input['limit']) && ($input['limit'] != '')) ? $input['limit'] : 10;
                    $userType = (isset($input['userType']) && ($input['userType'] != '')) ? $input['userType'] : '';
                    $searchterm = (isset($input['searchterm']) && ($input['searchterm'] != '')) ? $input['searchterm'] : '';

                    $page = (isset($input['page']) && ($input['page']!= '')) ? $input['page']: 1;

                    $clinicUserDetails = ClinicUser::getClinicUserList($status,$limit,$userType,$searchterm,$page,'timing');
                    
                
                    $clinicUserList     = $clinicUserDetails['clinicUserList'] ; 
                    $clinicUserData     = $clinicUserDetails['clinicUser'] ;

                    if(!empty($clinicUserData)){
                        foreach($clinicUserData['data'] as $key => $user){
                            $clinicUserData['data'][$key]['phone'] =  $this->Corefunctions->formatPhoneNumber($user['country_code'],$this->Corefunctions->formatPhone($user['phone_number']));
                        }
                    }

                    $specialtyIds = $this->Corefunctions->getIDSfromArray($clinicUserData['data'], 'specialty_id');
                    $specialtyIds = array_filter($specialtyIds);
                    $specialtyList = RefSpecialty::getSpecialityByIDs($specialtyIds);
                    $businessHours_data     = BusinessHour::getBusinessHour($clinicId) ;

                 

                  
                    $html = view('clinics.workinghours_list', compact('clinicUserData','clinicUserList','status','limit','userType','searchterm','specialtyList'));
                break ;

                case 'workinghours_details':
                    $pageType = isset( $input['pageType']) ?  $input['pageType'] : '';
                  if(!isset($input['key']) || $input['key'] == ''){
                    return response()->json(['error' => 1, 'errormsg' => '']);
                  }
                  $userDetails = ClinicUser::getClinicUserByKey($input['key']) ;
                  $userDetails['logo_path'] =  $userDetails['status'] == '1' && ($userDetails['user']['profile_image'] != '') ? $this->Corefunctions->resizeImageAWS($userDetails['user_id'],$userDetails['user']['profile_image'],$userDetails['user']['first_name'],180,180,'1') : (($userDetails['logo_path'] != '') ? $this->Corefunctions-> resizeImageAWS($userDetails['id'],$userDetails['logo_path'],$userDetails['name'],180,180,'1') : '');
                  $userID  = $userDetails['user_id'] ;
               
                  $consultaionTime = $this->Corefunctions->convertToArray(DB::table('ref_consultation_times')->whereNull('deleted_at')->get());
                  $consultaionTime = $this->Corefunctions->getArrayIndexed1($consultaionTime, 'id');
                  $businessHoursDetails = BusinessHour::with('slots')
                    ->where('clinic_id', $clinicId)->where('user_id',$userID)
                    ->get()
                    ->groupBy('day');
                    // $businessHours = $this->Corefunctions->convertToArray($businessHours);
                  
                   /* get  consultation time */
                $consultingTimes = RefConsultationTime::getConsultationTime();

                $businessHours = [
                    'Sunday' => ['day' => 'Sunday','is_open' => 0, 'label' => 'Closed'],
                    'Monday' => ['day' => 'Monday','is_open' => 1, 'label' => 'Open'],
                    'Tuesday' => ['day' => 'Tuesday','is_open' => 1, 'label' => 'Open'],
                    'Wednesday' => ['day' => 'Wednesday','is_open' => 1, 'label' => 'Open'],
                    'Thursday' => ['day' => 'Thursday','is_open' => 1, 'label' => 'Open'],
                    'Friday' => ['day' => 'Friday','is_open' => 1, 'label' => 'Open'],
                    'Saturday' => ['day' => 'Saturday','is_open' => 1, 'label' => 'Open'],
                    
                ];
                $key = $input['key'];

                /*  get vacation details */
                $vacationDetails = DB::table('vacations')->whereNull('deleted_at')->where('clinic_id',$clinicId)->where('user_id', $userID)->orderBy('vacation_from', 'asc')->get();

                $html = view('clinics.workinghours_details', compact('userDetails','businessHours','businessHoursDetails','consultaionTime','consultingTimes','key','vacationDetails','pageType'));
               break ;


               case 'settings':

                    
                    $html = view('clinics.'.$input['type'] , compact('clinic'));

                break;



                
                default:
                break;
            }
          
            $galleryImages          = ClinicGallery::getGalleryByClinic($clinicId) ;
            $galleryImagesAfterFive = ClinicGallery::where('clinic_id', $clinicId)->offset(5)->limit(PHP_INT_MAX)->get();
           


            foreach ($galleryImages as $galleryImage) {
                $galleryImage->image = ($galleryImage->image_path != '')
                    ? $this->Corefunctions->getAWSFilePath($galleryImage->image_path)
                    : "No Images Found";
            }

            foreach ($galleryImagesAfterFive as $galleryImageAfterFive) {
                $galleryImageAfterFive->image = ($galleryImageAfterFive->image_path != '')
                    ? $this->Corefunctions->getAWSFilePath($galleryImageAfterFive->image_path)
                    : "No Images Found";    
            }
            $clinicStripeId = Clinic::getStripeConnectId($clinicId);

            $stripeData = array();
            if($clinicStripeId != null){
                $stripeData = StripeConnection::getStripeConnectionInfo($clinicStripeId);
               
            }

           
           
            if( empty( $userCardsFinalArray ) ){
                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
                if( !empty($clinicDetails) ){
                    $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($clinicDetails,Session::get('user.email')); 
                    if(!empty($clientSecretResponse)){
                        $clientSecret = $clientSecretResponse['response'];
                        if($clinicDetails['stripe_customer_id'] == ''){
                            Payment::UpdateUserStripeCustomerIdInClinics($clinicDetails['id'],$clientSecretResponse['customerID']);
                        }
                    }
                }
            }

            // $invoicedata = Invoice::getInvoices($clinicId);
            // $invoicedata         = $this->Corefunctions->convertToArray($invoicedata);
            // $subscriptionPlanIds   = $this->Corefunctions->getIDSfromArray($invoicedata,'subscription_plan_id');

            // $subscriptionDetails = $this->Corefunctions->convertToArray(DB::table('subscription_plans')->select('plan_name','id')->whereIn('id',$subscriptionPlanIds)->get());
            // $subscriptionDetails = $this->Corefunctions->getArrayIndexed1($subscriptionDetails,'id');

            // $userSubscriptionListNewArray = array();
            // if (!empty($invoicedata)) {
            //     foreach ($invoicedata as $key => $usl) {
            //         $subfinal['invoice_number']     = $usl['invoice_number'];
            //         $subfinal['invoice_uuid']       = $usl['invoice_uuid'];
            //         $subfinal['status']             = $usl['status'];
            //         $subfinal['plan_name']          = $subscriptionDetails[$usl['subscription_plan_id']]['plan_name'];
            //         $subfinal['billing_date']       = date('M d, Y', strtotime($usl['created_at']));
            //         $subfinal['payment_id']         = $usl['payment_id'];
            //         $amount                         = $usl['total_amount'] ;
            //         $subfinal['amount_label']       = '$'.$amount;
            //         $userSubscriptionListNewArray[] = $subfinal;
            //     }
            // }
            // $invoices = isset($userSubscriptionListNewArray) ? $userSubscriptionListNewArray :array();

         
           
            // if ($input['type'] == "about") {
            //     $html = view('clinics.about-template', compact('clinic', 'businessHours'));
            // } elseif ($input['type'] == "gallery") {
            //     $html = view('clinics.gallery-template', compact('galleryImages','galleryImagesAfterFive'));
            // } elseif ($input['type'] == "stripe_info") {
            //     $html = view('clinics.stripe-info', compact('clinic','clinicUser','stripeData'));
            // }elseif($input['type']  == 'billings'){
            //     $html = view('clinics.billing', compact('clinic','clinicSubscription','userCards','clientSecret','invoices','addresses','states','countries','countryID','countryCode'));
            // }

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Successful';
            // $arr['redirect'] = back();
            return response()->json($arr);
        }
    }


    public function checkMailExist()
    {
        $email = request('email');
        $clinic_uuid = request('clinic_uuid');
        if (!empty($clinic_uuid)) {
            $validator = Validator::make(['email' => $email], [
                'email' => 'email|unique:clinics,email,' . $clinic_uuid . ',clinic_uuid',
            ]);
        } else {
            $validator = Validator::make(['email' => $email], [
                'email' => 'email|unique:clinic_users,email|unique:users,email,',
            ]);
        }

        if ($validator->fails()) {
            // return response()->json(['error' => 'Email already exists.'], 422);
            return 'false';
        } else {
            // return response()->json(['success' => 'Email is available.']);
            return 'true';
        }
    }
    /* not in use */
    public function checkPhoneExist()
    {
        $phone = request('phone');
        $phoneNumber = request('phone');
        $type = request('formtype');
        $clinic_uuid = request('clinic_uuid');
        $clinic = Clinic::where('clinic_uuid', $clinic_uuid)->withTrashed()->first();
        $clinicUser = ClinicUser::where('clinic_id', $clinic->id)->withTrashed()->first();
        $user = User::where('id', $clinicUser->user_id)->withTrashed()->first();
        $clinicUserID = $clinicUser->clinic_user_uuid;

        $hasData = '0';
        if ($type == 'userUpdate') {
            $existclinicdata  = Clinic::where('phone_number','=',$phoneNumber)->where('clinic_uuid','!=',$clinic_uuid)->limit(1)->withTrashed()->first();
             
            if( !empty($existclinicdata) ) {
                $hasData ='1';
            }else {
                $hasData ='0';
            }
        } else {
            $clinicdata  = Clinic::where('phone_number','=',$phoneNumber)->limit(1)->withTrashed()->first();
             
            if( !empty($clinicdata) ) {
                $hasData ='1';
            }else {
                $hasData ='0';
            }
        }

        if ( $hasData == 1 ) {
            return 'false';
          } else {
            return 'true';
          }
    }

    //Show the modal of business hours
    public function businessHoursCreate()
    {
        $clinicId = session('user.clinicID');
        $businessHours_data = BusinessHour::getBusinessHour($clinicId) ;
        $businessHours = [
            'Monday' => ['day' => 'Monday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Tuesday' => ['day' => 'Tuesday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Wednesday' => ['day' => 'Wednesday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Thursday' => ['day' => 'Thursday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Friday' => ['day' => 'Friday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Saturday' => ['day' => 'Saturday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
            'Sunday' => ['day' => 'Sunday', 'bussinesshour_uuid' => null, 'start_time' => null, 'end_time' => null, 'is_open' => 0],
        ];
        if (!$businessHours_data->isEmpty()) {
            foreach ($businessHours_data as $data) {
                $businessHours[$data->day] = [
                    'day' => $data->day,
                    'bussinesshour_uuid' => $data->bussinesshour_uuid,
                    'is_open' => $data->isopen,
                    'start_time' => $data->businessHourTime->from_time ?? null,
                    'end_time' => $data->businessHourTime->to_time ?? null,
                ];
            }

        }

        $html = view('clinics.business-hours', compact('businessHours'));
        $arr['view'] = $html->__toString();
        $arr['success'] = 1;
        return response()->json($arr);
    }

    public function businessHoursUpdate(Request $request)
    {
        // Retrieve business hours data
        $clinicId = session('user.clinicID');
        $data = request()->all();
        $businessHours = $request->input('businessHours');
        // dd($data);

        $inptHours = [];
        $day = [];
        $businessHours_data = BusinessHour::getBusinessHour($clinicId) ;
        $businessHours_data = $this->Corefunctions->convertToArray($businessHours_data);
        foreach ($businessHours_data as $hours) {
            $day[] = $hours['day'];
        }

        if (!empty($businessHours)) {
            foreach ($businessHours as $hour) {
                $inptHours[] = $hour['day'];

                $checkDayExist = BusinessHour::getBusinessHourByDay($clinicId,$hour['day']) ;
                
                if (empty($checkDayExist)) {
                    $businessHourUuid = $this->Corefunctions->generateUniqueKey("10", "bussiness_hours", "bussinesshour_uuid");
                    $businessHourTimeUuid = $this->Corefunctions->generateUniqueKey("10", "bussinesshours_times", "bussinesshour_time_uuid");

                    $businessHour = BusinessHour::saveBusinessHour($clinicId,$hour,$businessHourUuid,$businessHourTimeUuid);
                   
                } else {
                    $checkDayExist->businessHourTime()->update([
                        'bussiness_hour_id' => $checkDayExist->id,
                        'from_time' => date('H:i:s', strtotime($hour['start_time'])),
                        'to_time' => date('H:i:s', strtotime($hour['end_time'])),
                        'status' => '1',
                    ]);
                }
            }

        }
        $toDeletes = array_diff($day, $inptHours);
        if (!empty($toDeletes)) {
            foreach ($toDeletes as $toDelete) {
                $checkDayExist = BusinessHour::getBusinessHourByDay($clinicId,$toDelete);
                $checkDayExist->delete();

            }
        }

        // Return a success response
        return response()->json([
            'success' => 1,
            'message' => 'Business hours updated successfully!'
        ]);
    }
    public function myProfile()
    {
     
    
        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
        /** get doctors Details */
        $doctorDetails = ClinicUser::getclinicUserWithSpeciality() ;
        if (empty($doctorDetails)) {
            return redirect('/users');
        }
        if ($this->Corefunctions->validateClincOnboarding() &&  session()->get('user.userType') != 'doctor') {
            return Redirect::to('/onboarding/business-details');
        }

        $doctorDetails['logo_path'] = ($doctorDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($doctorDetails['logo_path']) : '';
        /** get designation data */
        $designationDeatils = RefDesignation::designationByID($doctorDetails['designation_id']);
        $designation = !empty($designationDeatils) ? $designationDeatils['name'] : '--';

        /** get countryCodeDetails */
        $countryCodeDetails =RefCountryCode::getCountryCodeById($doctorDetails['country_code']);
        $seo['title'] = "My Profile  | " . env('APP_NAME');
        
        return view('users.myprofile', compact('doctorDetails','seo', 'designation', 'countryCodeDetails'));
    }

    public function getMyProfileTab(Request $request)
    {
        if (request()->ajax()) {
            $input = request()->all();
            $clinicId = session('user.clinicID');
            
            $clinic      = Clinic::getClinicWithstate($clinicId,'tab') ;
            $clinic['logo'] = ($clinic['logo'] != '') ? $this->Corefunctions->resizeImageAWS($clinic['id'],$clinic['logo'],$clinic['name'],180,180,'1') : asset("images/default_clinic.png");

         
            $formType = $input['type'] ;
            switch ($formType) {
                case 'profiledetails':

                    $doctorDetails = ClinicUser::getclinicUserWithSpeciality() ;
                    if (empty($doctorDetails)) {
                        return $this->Corefunctions->returnError('Invalid user');
                    }
            
                    if ($doctorDetails['country_code'] != '') {
                        $countryCodedetails = RefCountryCode::getCountryCodeById($doctorDetails['country_code']);
                        $doctorDetails['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
                        $doctorDetails['short_code'] = !empty($countryCodedetails) ? $countryCodedetails['short_code'] : null;
                    }

                    $doctorDetails['logo_path'] = ($doctorDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($doctorDetails['logo_path']) : '';
                    $countryCodeDetails =RefCountryCode::getCountryCodeById($doctorDetails['country_code']);
                    $designation = User::getDesignations();
                    $specialties = User::getSpecialities();
                    $stateDetails = User::getStates();

                    $html = view('myprofile.'.$input['type'] , compact('clinic','doctorDetails','stateDetails','countryCodeDetails','designation','specialties'));

                break;

              
              

                case 'workinghours':

                 
                  $userDetails = ClinicUser::getClinicUserByKey(Session::get('user.clinicuser_uuid')) ;
                  $userDetails['logo_path'] =  $userDetails['status'] == '1' && ($userDetails['user']['profile_image'] != '') ? $this->Corefunctions->resizeImageAWS($userDetails['user_id'],$userDetails['user']['profile_image'],$userDetails['user']['first_name'],180,180,'1') : (($userDetails['logo_path'] != '') ? $this->Corefunctions-> resizeImageAWS($userDetails['id'],$userDetails['logo_path'],$userDetails['name'],180,180,'1') : '');
                  $userID  = $userDetails['user_id'] ;
               
                  $consultaionTime = $this->Corefunctions->convertToArray(DB::table('ref_consultation_times')->whereNull('deleted_at')->get());
                  $consultaionTime = $this->Corefunctions->getArrayIndexed1($consultaionTime, 'id');
                  $businessHoursDetails = BusinessHour::with('slots')
                    ->where('clinic_id', $clinicId)->where('user_id',$userID)
                    ->get()
                    ->groupBy('day');
                    // $businessHours = $this->Corefunctions->convertToArray($businessHours);
                  
                   /* get  consultation time */
                $consultingTimes = RefConsultationTime::getConsultationTime();

            
                $key = $input['key'];
            
                   $html = view('myprofile.'.$input['type'], compact('userDetails','businessHoursDetails','consultaionTime','consultingTimes','key'));
               break ;


               case 'addons':
                    $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));
                    $clincCard = $this->Corefunctions->convertToArray(DB::table('clinic_cards')->whereNull('deleted_at')->where('clinic_id',$clinicId)->first());
                    // eprescribe_enabled
                    $users = $this->Corefunctions->convertToArray(ClinicUser::getUserPrescribers($clinicId, $clinicId = session('user.userID')));
                    $nextPaymentDue = Carbon::now()->addMonthNoOverflow()->startOfMonth()->format('d/m/Y');

                    /* check for clinic need add prescribers  */
                    $isAddPrescribers = DB::table('clinic_users')->where('eprescribe_enabled','0')->where('clinic_id',$clinicId)->whereNull('deleted_at')->count();

                    $clientSecret = '' ;
                    if( empty( $clincCard ) ){
                    
                      if( !empty($clinicDetails) ){
                              $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($clinicDetails,Session::get('user.email')); 
                              if(!empty($clientSecretResponse)){
                                  $clientSecret = $clientSecretResponse['response'];
                                  if($clinicDetails['stripe_customer_id'] == ''){
                                      Payment::UpdateUserStripeCustomerIdInClinics($clinicDetails['id'],$clientSecretResponse['customerID']);
                                  }
                              }
                          }
                      }

                      

                    $html = view('myprofile.'.$input['type'] , compact('users','nextPaymentDue','isAddPrescribers','clientSecret'));

                break;



                
                default:
                break;
            }
          
     
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Successful';
            // $arr['redirect'] = back();
            return response()->json($arr);
        }
    }


    public function updateClinic(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $clinicId = session('user.clinicID');
            $uuid = $data['key'] ;
            $clinicDetails =  $this->Corefunctions->convertToArray(DB::table('clinics')->where('clinic_uuid', $uuid)->where('id',$clinicId)->first());
            if(empty($clinicDetails)){
                return $this->Corefunctions->returnError('Invalid clinic details');
            }
            parse_str($data['formdata'], $input);
            /* store clinic apponment types data  */
            if( isset($input['appointment_type'])){
                $clinic = Clinic::updateClinicAppoinmentFee($input,$clinicId);
            }
     
          
            $arr['success'] = 1;
            $arr['message'] = 'Successful';
            // $arr['redirect'] = back();
            return response()->json($arr);
        }
    }

    public function appointmentList()
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            // Default limit
            $limit = isset($data['limit']) ? intval($data['limit']) : 10;

            $userTimeZone = session()->get('user.timezone');
            $status = $data['status'];
            $page = $data['page'];
            
            $doctorDetails = ClinicUser::getClinicUserWithClinic();


            if (empty($doctorDetails)) {
                return $this->Corefunctions->returnError('Invalid details');
            }
            $appointmentDetails = Appointment::getAppointmentList(session()->get('user.clinicID'),'',$userTimeZone,$doctorDetails['user_id'],$status,'profile',$limit,$page);
         
        
            $appointmentRecords = $appointmentDetails['appointments'];
            $openCount          = $appointmentDetails['openCount'];
            $receptionCount    = $appointmentDetails['receptionCount'];
            $cancelledCount    = $appointmentDetails['cancelledCount'];
            $completedCount    = $appointmentDetails['completedCount'];

            $appointmentRecordDetails = $this->Corefunctions->convertToArray($appointmentRecords);
         

            if(session()->get('user.userType') == 'nurse'){
                $appointmentRecords = Appointment::where('clinic_id', session()->get('user.clinicID'))->where('status', '1')->where('nurse_id', $doctorDetails['user_id'])->whereIn('appointment_type_id', ['1','2']);
            }else{
                $appointmentRecords = Appointment::where('clinic_id', session()->get('user.clinicID'))->where('status', '1')->where('consultant_id', $doctorDetails['user_id'])->whereIn('appointment_type_id', ['1','2']);
            }
            $appointmentRecords = $appointmentRecords->orderBy('appointment_date', 'asc')->orderBy('appointment_time', 'asc');
            
            $openCount = (clone $appointmentRecords)
                ->where('is_completed', '0')
                ->where(function ($query) use ($userTimeZone) {
                $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                    ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            })->count();
            $receptionCount = (clone $appointmentRecords)
                ->where('is_completed', '0')
                ->where('reception_waiting', '1')
                ->count();
            $cancelledCount = (clone $appointmentRecords)->onlyTrashed()->count();
            $completedCount = (clone $appointmentRecords)->where('is_completed', '1')->count();

            if ($status == 'open') {
                $appointmentRecords->where('is_completed', '0')->where(function ($query) use ($userTimeZone) {
                    $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                          ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
                });
            } elseif ($status == 'reception') {
                $appointmentRecords->where('is_completed', '0')->where('reception_waiting', '1');
            } elseif ($status == 'cancelled') {
                $appointmentRecords->onlyTrashed();
            } elseif ($status == 'completed') {
                $appointmentRecords->where('is_completed', '1');
            }

            $appointmentRecords = $appointmentRecords->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $page);
          
            $appointmentRecordDetails = $this->Corefunctions->convertToArray($appointmentRecords);

            /** get nurse details for appointments */
            $nurseIds = $this->Corefunctions->getIDSfromArray($appointmentRecordDetails['data'], 'nurse_id');
            $nurseDetails = ClinicUser::with('user')->where('clinic_id', session()->get('user.clinicID'))->where('user_type_id', '3')->whereIn('user_id', $nurseIds)->withTrashed()->get();
            $nurseDetails = $this->Corefunctions->convertToArray($nurseDetails);
            $nurseDetails = $this->Corefunctions->getArrayIndexed1($nurseDetails, 'user_id');

            /** patientlist */
            $patientIds = $this->Corefunctions->getIDSfromArray($appointmentRecordDetails['data'], 'patient_id');
            $patientDetails = Patient::with('user')->where('clinic_id', session()->get('user.clinicID'))->whereIn('user_id', $patientIds)->withTrashed()->get();
            $patientDetails = $this->Corefunctions->convertToArray($patientDetails);
            $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'user_id');

            $data['patientDetails'] = $patientDetails;
            $data['appointmentRecords'] = $appointmentRecordDetails['data'];
            $data['appointmentRecordList'] = $appointmentRecords;
            $data['nurseDetails'] = $nurseDetails;
            $data['consultantKey'] = Session::get('user.clinicuser_uuid');
            $data['status'] = $data['status'];
            $data['limit'] = $limit;
            $data['openCount'] = $openCount;
            $data['receptionCount'] = $receptionCount;
            $data['cancelledCount'] = $cancelledCount;
            $data['completedCount'] = $completedCount;

            $html = view('doctors.appointment_list', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['pagination'] = $appointmentRecords->links('pagination::bootstrap-4')->render();
            return response()->json($arr);
            exit();

        }
    }
    public function updatePlanOrder(Request $request){
        if (request()->ajax()) {
            $data = request()->all();

            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $order = $request->input('order');

            foreach ($order as $item) {
                DB::table('clinic_subscriptions')
                    ->where('clinic_subscription_uuid', $item['uuid'])
                    ->update(['sort_order' => $item['sort_order']]);
            }

            $arr['success'] = 1;
            $arr['message'] = 'Sort order changed successfully.';
            return response()->json($arr);
            exit();
        }
    }


    public function appointmentForVacation(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $appointments = [];
            if ($data['vacation_type'] === 'specific') {
                $date = Carbon::createFromFormat('m/d/Y', $data['vacation_date'])->format('Y-m-d');
            
                $appointments = Appointment::whereDate('appointment_date', $date)
                    ->whereNull('deleted_at')
                    ->where('is_completed', '!=', '1')
                    ->where('consultant_id', $data['doctorID'])
                    ->get();
            
            } else {
                $from = Carbon::createFromFormat('m/d/Y', $data['vacation_from'])->format('Y-m-d');
                $to = !empty($data['vacation_to'])
                    ? Carbon::createFromFormat('m/d/Y', $data['vacation_to'])->format('Y-m-d')
                    : $from;
            
                $appointments = Appointment::whereBetween('appointment_date', [$from, $to])
                    ->whereNull('deleted_at')
                    ->where('is_completed', '!=', '1')
                    ->where('consultant_id', $data['doctorID'])
                    ->get();
            }

            if ($appointments->isEmpty()) {
                return response()->json([
                    'success' => 1,
                    'hasAppointments' => false,
                    'message' => 'No appointments scheduled during the selected vacation period.',
                    'dates' => [],
                ]);
            } else {
                // Collect unique dates (or times) with appointments
                // $dates = $appointments->pluck('appointment_date')->unique()->values()->toArray();
                $dates = $appointments->pluck('appointment_date')->unique()->map(function($date) {return Carbon::parse($date)->format('m/d/Y'); })->values()->toArray();
                if (count($dates) === 1) {
                    $msg = 'An appointment is scheduled on: ' . $dates[0];
                } else {
                    $msg = 'Appointments are scheduled on: ' . implode(', ', $dates);
                }

                return response()->json([
                    'success' => 0,
                    'hasAppointments' => true,
                    'message' => $msg,
                    'dates' => $dates,
                    // 'details' => $details, // Uncomment if you want more info
                ]);
            }
        }
    }

    public function cancelUserEprescription(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }
            $userDets = ClinicUser::getClinicUserByUuid($data['key']);
            if(empty($userDets)){
                return response()->json(['error' => 1, 'errormsg' => 'Invalid user']);
            }
            DB::table('eprescribers')->where('id',$userDets['eprescriber_id'])->update(array(
                'deleted_at' => Carbon::now()
            ));
            ClinicUser::disableEprescribe($data['key']);

            return response()->json([
                'success' => 1,
                'message' => 'Eprescription cancelled successfully fo this user.',
            ]);
        }
    }

    public function cancelClinicEprescription(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }
            $clinicId = session()->get('user.clinicID');
            $clinicDets = Clinic::clinicByID($clinicId);
            if(empty($clinicDets)){
                return response()->json(['error' => 1, 'errormsg' => 'Invalid clinic']);
            }
            DB::table('clinic_addons')->where('clinic_id',$clinicId)->update(array(
                'deleted_at' => Carbon::now()
            ));

            return response()->json([
                'success' => 1,
                'message' => 'Eprescription cancelled successfully fo this clinic.',
            ]);
        }
    }

}
