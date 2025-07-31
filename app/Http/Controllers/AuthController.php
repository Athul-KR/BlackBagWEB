<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Support\Facades\Session; // Import Session facade
use App\Models\User;
use App\Models\Otp;
use App\Models\Clinic;
use App\Models\ClinicUser;
use App\Models\Consultant;
use App\Models\Patient;
use App\Models\RefDesignation;
use App\Models\RefSpecialty;
use App\Models\StripeConnection;
use App\customclasses\Corefunctions;
use App\Models\Nurse;
use App\Models\Appointment;
use App\Models\RefCountryCode;
use App\Models\Payment;
use App\Models\VideoCall;
use App\Models\VideoCallParticipant;
use App\Models\PatientCard;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionsHistory;
use App\Models\Subscription;
use App\Models\UserConnection;
use App\Models\RefLabTest;
use App\Models\PatientLabTest;
use App\Models\PatientLabTestItem;
use App\Models\PatientImagingTest;
use App\Models\RefOnboardingStep;
use App\Models\ClinicOnboardingHistory;

use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use File;

class AuthController extends Controller
{
    public function __construct()
    {
        
        $this->Corefunctions = new \App\customclasses\Corefunctions;

    }
    /**
     * Show login form
     */
    public function login()
    {
        $userType= isset($_GET['type']) && $_GET['type'] !='' ? $_GET['type'] : '';
        if (Session::has('user')) {
            return Redirect::to('/dashboard'); // Adjust the URL to your login route
        }
        $phone = $countrycode = $key = '';

        /*** prefil data when invitition key comes ****/
        if (isset($_GET['invitationkey']) && $_GET['invitationkey'] != '') {
            $key = $_GET['invitationkey'];
            $keyParts = explode('_', $key);

            // Code Fix Required | Chances of duplicate invite key, Use a prefix with keygenereated before checking - Done
            if ($keyParts[0] == 'c') {
                $clinicdoctorDetails = ClinicUser::clinicUserByInvitationKey($key);
            } else {
                $clinicdoctorDetails = Patient::patientByInvitationKey($key);
            }
            if(empty($clinicdoctorDetails)){
                return Redirect::to('/login');
            }

            $userDetails = array();
            if ($clinicdoctorDetails->user_id != null) {
                $userDetails = User::userByID($clinicdoctorDetails->user_id);
            }
            
            $phone = !empty($userDetails) && isset($userDetails->phone_number) ? $userDetails->phone_number : $clinicdoctorDetails->phone_number;
            $countryCode = !empty($userDetails) && isset($userDetails->country_code) ? $userDetails->country_code : $clinicdoctorDetails->country_code;
            $countrycode = DB::table('ref_country_codes')->select('country_code', 'short_code')->where('id', $countryCode)->first();
            
           
        }
        $seo['title'] = "Login  | " . env('APP_NAME');
        $seo['description'] = "Log in to your BlackBag account securely by entering your credentials below and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Login ,Sign in ,Join, Patient login, Clinics login,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('auth.login', compact('key', 'phone', 'countrycode','userType','seo'));
    }

    public function connecttostripe()
    {
        $seo['title'] = "Login  | " . env('APP_NAME');
        $seo['description'] = "Log in to your BlackBag account securely by entering your credentials below and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Login ,Sign in ,Join, Patient login, Clinics login,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('auth.connectstripe', compact('seo'));
    }

    public function register()
    {
        $invitationkey = (isset($_GET['invitationkey']) && $_GET['invitationkey'] != '') ? $_GET['invitationkey'] : '';
        
        $clinicPatientDetails = array();
        if($invitationkey != ''){   

            $seo = array();
            $seo['title'] = 'Invitation | ' . env('APP_NAME');
            $seo['description'] = "";
            $seo['keywords'] = "";
            $seo['og:title'] = "";
            $seo['og:description'] = "";
            $haserror = '0';
            $errormsg = '';
            $isDeleted = '0';
            $alreadyLoggined = '';
            $key = $invitationkey;
            $keyParts = explode('_', $invitationkey);
            if ($keyParts[0] == 'c') {
                $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::clinicUserByInvitationKey($invitationkey));
                $isDeleted = ( !empty($clinicUserDetails) && $clinicUserDetails['deleted_at'] != '') ? '1' : '0' ;
                if (empty($clinicUserDetails)) {
                    $haserror = '1';
                    return view('invitation', compact('seo', 'invitationkey', 'alreadyLoggined', 'haserror', 'errormsg'));
                }
                
                if ($clinicUserDetails['country_code'] != '') {
                    $countryCodedetails = RefCountryCode::getCountryCodeById($clinicUserDetails['country_code']);
                    $clinicUserDetails['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
                    $clinicUserDetails['short_code'] = !empty($countryCodedetails) ? $countryCodedetails['short_code'] : null;
                }
                $clinicUserDetails['logo_path'] = ($clinicUserDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicUserDetails['logo_path']) : '';

                $doctorDetails = ClinicUser::getUserByUserId($clinicUserDetails['created_by'],$clinicUserDetails['clinic_id']);
                $clinicianname  = $this->Corefunctions->showClinicanName($doctorDetails,'0');
             
                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicUserDetails['clinic_id']));
                $clinicDetails['logo'] = ($clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");
                if (Session::has('user')) {
                    $alreadyLoggined = 1;
                }
                $doctorDetails = ClinicUser::getUserByUserId($clinicUserDetails['created_by'],$clinicUserDetails['clinic_id']);
                $clinicianname  = $this->Corefunctions->showClinicanName($doctorDetails,'0');
             
                $name =  isset($clinicUserDetails['user_type_id'])  && ( $clinicUserDetails['user_type_id'] == '2' || ($clinicUserDetails['user_type_id'] == '1') ) ? $this->Corefunctions->showClinicanName($clinicUserDetails,'1') : $clinicUserDetails['first_name'].' '.$clinicUserDetails['last_name'] ;

                return view('auth.register-clinic',compact('seo','clinicUserDetails','invitationkey','alreadyLoggined','key','haserror','name','clinicianname','clinicDetails'));
            }else{
                $clinicPatientDetails = $this->Corefunctions->convertToArray(Patient::patientByInvitationKey($invitationkey));
                if(empty($clinicPatientDetails)){
                    return Redirect::to('/login');
                }

                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicPatientDetails['clinic_id']));
                $clinicDetails['logo'] = ($clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");
                $name = $clinicPatientDetails['first_name'].' '.$clinicPatientDetails['last_name'];
                $countryCodedetails = RefCountryCode::getCountryCodeById($clinicPatientDetails['country_code']);
                $clinicPatientDetails['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
                
                if (Session::has('user')) {
                    $alreadyLoggined = 1;
                    return view('patient.invitation', compact('seo', 'invitationkey', 'alreadyLoggined', 'haserror', 'errormsg', 'key','name','clinicDetails'));
                }
            }
        }
        if (Session::has('user')) {
            return Redirect::to('/dashboard');
        }

        $phone = $countrycode = $key = '';
        $seo['title'] = "Sign Up | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('auth.register-patient',compact('seo','clinicPatientDetails','invitationkey'));
    }

    /***  login form submission via AJAX */
    public function submitlogin()
    {
        // Code Fix Required | Corefunctions already available in this -> , Use a common return error function, unserialize form data at top done - Done
        if (request()->ajax()) {

            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            parse_str($data['formdata'], $input);
          
            /*********** For login with email and Otp  **********/
            if (isset($data['logintype']) && $data['logintype'] == 'email') {
                $userDetails = $this->loginWithEmail($data['formdata']);
                if (isset($userDetails['error'])) {
                    return $this->Corefunctions->returnError($userDetails['errormsg']);
                }
                // Return success response with OTP details
                $response = $this->returnResponse($userDetails,'email');
                return response()->json($response);
                exit();
            }
            $input['phonenumber'] = str_replace(["(", ")", " ","-"], "", $input['phonenumber']);
            /** get country code details */
            $countryCode = RefCountryCode::getCountryCodeByShortCode($input['countryCodeShort']);

            /* Check for inviation form doctor */
            if (isset($input['invitationkey']) && $input['invitationkey'] != '') {
                // Code Fix Required | Correct the variable parentDetails, $userObject - Done
                $parentDetails = ClinicUser::getClinicUserByInvitation($input,$countryCode['id']);
              
                if (empty($parentDetails)) {
                    return $this->Corefunctions->returnError('Sorry!!!, The provided credentials does not match our records.');
                }
              
                $userType = $parentDetails['user_type_id'];
                 /** Insert user ifo  */
                if (!empty($parentDetails)) {
                    $userUuid = $this->Corefunctions->generateUniqueKey("10", "users", "user_uuid");
                    /* Fetch user  Details */
                    $userDetails = User::getUserByPhone($parentDetails,$parentDetails['country_code']);
                    
                    $userID     = $userDetails['id'];
                    /* update to users table */
                    $userData = User::updateUsers($parentDetails,$userID);
                    /* update clinic user  */
                    $userData = clinicUser::updateParentDetails($parentDetails['id'],$userID);
                    // Code Fix Required | Remove UUID  - Done
                    /* notification for invitation accept */
                    $this->Corefunctions->addNotifications(1, $parentDetails["clinic_id"], $parentDetails['created_by'], $parentDetails['id']);

                }
               
            }

            // Check if the user exists by phone number
            $userDetails = User::getUserByPhoneCountry($input,$countryCode['id']);
           
            // If user does not exist, return error response
            if (empty($userDetails)) {
                return $this->Corefunctions->returnError('Sorry!!!, The provided credentials does not match our records.');
            }
            $this->deleteImagesRecursive(TEMPDOCPATH.'/'.$userDetails['id']);
            $this->deleteImagesRecursive(TEMPDOCPATH);
           
            $userType='clinic';
            if( $userDetails['last_login_clinic_id'] != NULL ){
                $parentDetails = ClinicUser::getLastLoginClinicData($input,$userDetails['last_login_clinic_id']); /* get last logined clinic user details  */
                  // /* check the user also have active clinic */
                $clinicDetailsCount = ClinicUser::getUserClinic($userDetails['id']) ;
                if (!empty($parentDetails) && $clinicDetailsCount == 0) {
                    return $this->Corefunctions->returnError('Your clinic has been deactivated.Please contact the '.env('APP_NAME').' admin to activate it');
                }
            }
            /* get patient details  */
            if( empty( $parentDetails ) ){
                $parentDetails = Patient::getPatientDetails($input,$countryCode['id']);
                $userType='patient';
            }
          
            if (empty($parentDetails)) {
                return $this->Corefunctions->returnError('Sorry!!!, The provided credentials does not match our records.');
            }
          
            /* insert to otps table */
            $userOtpData = $this->Corefunctions->insertToOtps($input['phonenumber'], $countryCode);
            $timezoneId = $this->updateUserTimezone($input, $userDetails);

            // Return success response with OTP details
            $input['userotp'] = $userOtpData['userotp'];
            $input['otpUuid'] = $userOtpData['otpUuid'];
            $input['userType'] = $userType;
            $response = $this->returnResponse($input);
            return response()->json($response);
            exit();
           
        }
    }
    private function deleteImagesRecursive($dir) {
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp','pdf'];

            if (!is_dir($dir)) return;

            foreach (scandir($dir) as $item) {
                if ($item === '.' || $item === '..') continue;

                $path = $dir . DIRECTORY_SEPARATOR . $item;

                if (is_dir($path)) {
                    $this->deleteImagesRecursive($path); // Recursive call
                } elseif (is_file($path)) {
                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    if (in_array($ext, $imageExtensions)) {
                        unlink($path);
                    }
                }
            }
        }
    private function returnResponse($userDetails,$type='')
    {
        $arr['success']          = 1;
        $arr['key']              = $userDetails['otpUuid'];
        $arr['phonenumber']      = $userDetails['phonenumber'];
        $arr['type']             = $type;
        $arr['userType']         = $userDetails['userType'];
        $arr['countrycode']      = $userDetails['countrycode'];
        $arr['countryCodeShort'] = $userDetails['countryCodeShort'];
        $arr['email']            = isset($userDetails['email']) ? $userDetails['email'] : '';
        $arr['otp']              = isset($userDetails['userotp']) ? $userDetails['userotp'] :'';
        $arr['message']          = 'Otp generated successfully';
        return $arr ;
    }

   
    private function updateUserTimezone($input, $userDetails)
    {
        if (isset($input['timezoneOffset']) && $input['timezoneOffset'] != '') {
            $timezone = User::getUserTimeZone($input['timezoneOffset']);
            $timezoneId = !empty($timezone) ? $timezone->id : null;

            if ($timezoneId != $userDetails['timezone_id']) {
                User::updateUserTimezone($userDetails['id'], $timezoneId);
            }

            return $timezoneId;
        }

        return null;
    }

       /* Verify OTP via AJAX */
    public function verifyotp()
    {
 
        // Code Fix Required | Corefunctions already available in this - Done
       if (request()->ajax()) {

           $data = request()->all();
            // Check if data is empty
           if (empty($data)) {
               return $this->Corefunctions->returnError('Fields missing');
           }

            // Parse form data
           parse_str($data['formdata'], $input);

           /* just for automation testing with static otp check */
           if( $input['phonenumber'] == '3125550198'){
            
                $input['otpkey'] ='12345943';
                $input['otp'] ='1234';
                $otpDetails =  $this->Corefunctions->convertToArray(DB::table('otps')->select('phone_number', 'expiry_on', 'email')
                    ->where('otp_uuid','12345943')
                    ->where('otp','1234')
                    ->first()
                );
                if (empty($otpDetails)) {
                    return $this->Corefunctions->returnError('Invalid OTP.');
                }
                // Otp::updateOtp($input['otpkey'],'otp_uuid');
           }else{
                if (!isset($input['otpkey']) || empty($input['otpkey'])) {
                    return $this->Corefunctions->returnError('OTP key missing');
                }
    
                // Code Fix Required | Requires Check for $input['otpkey'] - Done
                // Get OTP details from the 'otps' table
                $otpDetails = Otp::getOtpDetails($input);
    
                if (empty($otpDetails)) {
                    return $this->Corefunctions->returnError('Invalid OTP.');
                }
                
                // If OTP is expired, return error
                if (time() > $otpDetails['expiry_on']) {
                    return $this->Corefunctions->returnError('Code expired.');
                }
                
                // Update otp as used
                Otp::updateOtp($input['otpkey'],'otp_uuid');
           }
           $input['invitationkey'] =  isset($data['invitationkey']) && $data['invitationkey'] !='' ? $data['invitationkey'] : '';
           
           /* get countru code details*/
           $countryCode = RefCountryCode::getCountryCodeByShortCode($input['countryCodeShort']);
          
           if (isset($input['logintype']) && $input['logintype'] == 'email') {
               $userDetails = User::getUserDetails($otpDetails,'email');      // Get user details by email
           } else {
               $userDetails = User::getUserDetails($otpDetails,'phone',$countryCode["id"]);  // Get user details by phone number
           }
           // If user does not exist, return error response
           if (empty($userDetails)) {
               session()->flash("otperror", "The provided credentials does not match our records.");
               return back();
           }
            /* update invitation status for clinic users */
            if($input['invitationkey'] !=''){
            $parentDetails = ClinicUser::getClinicUserByInvitation($input,$countryCode["id"]);
            // print_r($countryCode["id"]);exit;
                if (!empty($parentDetails)) {
                    DB::table('clinic_users')->where('id',$parentDetails['id'])->limit(1)->update(array(
                        'status' 			=> '1' ,
                        'invitation_key' 	=> null ,
                    ));
                }
            }

           $clinicUserDetails = array() ;
           if( $userDetails['last_login_clinic_id'] != NULL){
                $clinicUserDetails = ClinicUser::getClinicUserWithUsers($userDetails);
             
            }
           
           if(empty($clinicUserDetails)){
              
                $response = $this->checkPatientDetails($userDetails,$input);
              
                return response()->json($response);
           }
         
           $patientID = $clinicId = '';
           $user_type                      = !empty($clinicUserDetails) && $clinicUserDetails['user_type_id'] == '2' ? 'doctor' : (!empty($clinicUserDetails) && $clinicUserDetails['user_type_id'] == '3' ? 'nurse' : 'clinics');
           $clinicId                       = !empty($clinicUserDetails) ? $clinicUserDetails['clinic_id'] : '';
           $logoPath                       = (isset($userDetails['profile_image']) && $userDetails['profile_image'] != '') ?  $this->Corefunctions -> resizeImageAWS($userDetails['id'],$userDetails['profile_image'],$userDetails['first_name'],180,180,'1') : (!empty($clinicUserDetails) && ($clinicUserDetails['logo_path'] != '') ? $this->Corefunctions-> resizeImageAWS($clinicUserDetails['id'],$clinicUserDetails['logo_path'],$clinicUserDetails['first_name'],180,180,'1') : '');
           $clinicuuid                     = !empty($clinicUserDetails) ? $clinicUserDetails['clinic_user_uuid'] : '';
           $userDetails['profile_image']   = $logoPath;
           $userDetails['clinicCode']      = !empty($clinicUserDetails) && $clinicUserDetails['clinic_code'] != '' ? $clinicUserDetails['clinic_code'] : '';
           $clinicUserDetails['name']      = $userDetails['first_name'];
           $userDetails['first_name']      = $this->Corefunctions->showClinicanName($clinicUserDetails,'1');
           $clinicId                       = ($userDetails['last_login_clinic_id'] != '') ? $userDetails['last_login_clinic_id'] : $clinicId ;
           $clinicAdmin                    = ((!empty($clinicUserDetails) && $clinicUserDetails['is_clinic_admin'] == '1') || $user_type =='clinics')  ? 1 : 0;
           $is_licensed_practitioner       =  !empty($clinicUserDetails) ? $clinicUserDetails['is_licensed_practitioner'] : 0;
           $clinicDetails = Clinic::clinicByID($clinicId);
           $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
           if($clinicDetails['deleted_at'] !=''){
                /* get the latest clininc details if last clinic is deleted by admin*/
                $latestUserDetails = $this->Corefunctions->convertToArray(ClinicUser::latestClinicForUser($userDetails['id'],$userDetails['last_login_clinic_id']));
                /* fetch new clinic */
                if (!empty($latestUserDetails)) {
                    $clinicDetails = Clinic::clinicByID($latestUserDetails['clinic_id']);
                    $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
                    $clinicId      = !empty($clinicDetails) ? $clinicDetails['id'] : '';
                }
           }
           if (empty($clinicDetails)) {
               return response()->json([
                   'error' => 1,
                   'errormsg' => 'Sorry,The provided credentials do not match our records.',
               ]);
           }
         
           // Code Fix Required | Stripe Connected cannot be set to 1 - Done   /** check for stripe connection */
           $stripe_connected = (!empty($clinicUserDetails) && $clinicAdmin == 1) && ($clinicDetails['stripe_connection_id'] != null || $clinicDetails['stripe_connection_id'] != 0) ? 1 : 0;
           $userDetails['userSessionID'] = User::insertUserSession($userDetails['id']);
           //Store session 
           $sessionData = $this->Corefunctions->setSessionData($userDetails, $clinicDetails, $user_type, $clinicuuid, $stripe_connected, $clinicId, $clinicAdmin);
       
           /** update last login id */
           User::updateLastLoginClinic($userDetails['id'],$clinicDetails['id']);
           

           /*addlogin info */
        
           $browser     = $_SERVER['HTTP_USER_AGENT'];
           $devicetype = '1'; // device type
           if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
               $ip = $_SERVER['HTTP_CLIENT_IP'];
           } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
               $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
           } else {
               $ip = $_SERVER['REMOTE_ADDR'];
           }
           $details = json_decode(@file_get_contents("http://ipinfo.io/{$ip}/json"));
           (isset($details->city) && $details->city != "") ? $city = $details->city : $city = "";
           (isset($details->region) && $details->region != "") ? $region = $details->region : $region = "";
           (isset($details->country) && $details->country != "") ? $country = $details->country : $country = "";
           (isset($details->loc) && $details->loc != "") ? $loc = $details->loc : $loc = "";
           (isset($details->org) && $details->org != "") ? $org = $details->org : $org = "";
           $result = (array) $details;
           
           $logininfoid = User::addLoginInfo($city, $region, $country, $loc, $ip, $devicetype,$browser,$userDetails['id']);


           // Code Fix Required | No need to send stripe_connected status, just use hasRedirect & redirectURL - Done
            /* validate onboarding process */
            $onboardClinic = $this->Corefunctions->validateClincOnboarding();
            $lastStep =  isset($onboardClinic['step']) ? $onboardClinic['step'] : '' ;
            $hasRedirect = '1';

            Session::put("user.licensed_practitioner",$is_licensed_practitioner);
            /** onboarding for doctors  */
            if(($clinicUserDetails['user_type_id'] == '2' || ($clinicUserDetails['user_type_id'] == '1' && $clinicDetails['onboarding_complete'] == 1 ) ) &&  ($clinicUserDetails['onboarding_complete'] == 0 || $clinicUserDetails['onboarding_complete'] == '') ){
                /* check doctor onboarding  */
                $hasRedirect = '2';
                $onboardClinic = $this->Corefunctions->validateClincUserOnboarding();
            
                $lastStep =  isset($onboardClinic['step']) ? $onboardClinic['step'] : '' ;

            }
            return response()->json([
                'success' => 1,
                'type' => '',
                'lastStep' => $lastStep,
                'hasRedirect' => $hasRedirect,
                // "redirectURL" => url('onboarding/business-details'),
                'redirectURL' => 'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&state=' . $clinicUserDetails['clinic_user_uuid'] . '&redirect_uri=' . url("/connect/stripe"),
                'message' => 'Otp verified successfully',
                'isregister' => isset($input['isregister']) && $input['isregister'] !='' ? $input['isregister'] : '0',
            ]);
        }
    }


    /** sign up clinics and patient */
    public function registerUser()
    {
        if (request()->ajax()) {
        //    print_r('test');exit;
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $userType      = isset($data['userType']) ? $data['userType'] : 'clinics' ;
            $clinicDetails = array();
            
            parse_str($data['formdata'], $input);           // Parse data

           
            $countryShortCode     = ($userType == 'patient') ? $input['patient_countryCodeShort']  : $input['user_countryCodeShort'] ;
            $input['user_phone']  = ($userType == 'patient') ? str_replace(["(", ")", " ","-"], "", $input['patient_phonenumber'])  : str_replace(["(", ")", " ","-"], "", $input['user_phone']) ;
           
            // Fetch country ID from ref_country_codes table for user
            $userCountryCode = RefCountryCode::getCountryCodeByShortCode($countryShortCode);
           
        
            /**  invitation from doctor */
            if($userType == 'doctor'){
                if(isset($data['invitationkey']) && $data['invitationkey'] != ''){
                    $input['phonenumber'] = $input['user_phone'];
                 
                    
                    $parentDetails = ClinicUser::getClinicUserByInvitation($input,$userCountryCode['id']);
                    if (empty($parentDetails)) {
                        return response()->json([
                            'error'          =>  1,
                            'message'          =>  'Sorry!!!, The provided credentials does not match our records.',
                        ]);
                    }
                    $userType = $parentDetails['user_type_id'];
                    DB::table('clinic_users')->where('id', $parentDetails['id'])->update(array(
                        'first_name'  => $input['username'],
                        'last_name'  => $input['last_name'],
                        'logo_path'  => $input['userisremove'] == 1 ? null : $parentDetails['logo_path'] ,
                        'updated_at' => Carbon::now(),
                    ));
                    /* user Image Upload */
                    if (isset($input['usertempimage']) && $input['usertempimage'] != "") {
                        $input['tempimage'] = $input['usertempimage'] ;
                        $this->Corefunctions->uploadImage($input,$parentDetails['user_id'],'clinic_users',$parentDetails['id'],$parentDetails['clinic_user_uuid']);
                    }
                    /** Insert user ifo  */
                    if (!empty($parentDetails)) {
                        $userUuid = $this->Corefunctions->generateUniqueKey("10", "users", "user_uuid");
                        /* Fetch user  Details */
                        $userDetails = User::getUserByPhone($parentDetails,$parentDetails['country_code']);
                        
                        $userID     = $userDetails['id'];
                        /* update to users table */
                        $userData = User::updateUsers($parentDetails,$userID);
                        /* update clinic user  */
                        DB::table('clinic_users')->where('id',$parentDetails['id'])->limit(1)->update(array(
                            'user_id'       	=> $userID,
                            "login_status" 		=>'1' ,
                            'updated_at' 		=> Carbon::now()
                        ));
                        // $userData = clinicUser::updateParentDetails($parentDetails['id'],$userID);
                        // Code Fix Required | Remove UUID  - Done
                        /* notification for invitation accept */
                        $this->Corefunctions->addNotifications(1, $parentDetails["clinic_id"], $parentDetails['created_by'], $parentDetails['id']);
                    }
                    /**insert to otps table */
                    $userOtpData = $this->Corefunctions->insertToOtps($input['user_phone'],$userCountryCode);

                    return response()->json([
                        'success'          =>  1,
                        'hasRedirect'      =>  0,
                        'phonenumber'      =>  $input['user_phone'],
                        'countryCodeShort' =>  $countryShortCode ,
                        'countrycode'      =>  !empty($userCountryCode) ? $userCountryCode['country_code'] : null,
                        'userType'         =>  $userType,
                        'otp'              =>  isset($userOtpData['userotp']) ? $userOtpData['userotp'] : '',
                        'key'              =>  isset($userOtpData['otpUuid']) ? $userOtpData['otpUuid'] : '',
                        'message'          =>  'Clinic added successfully',
                    ]);


                }
            }


 
            // Generate unique OTP UUID
            $clinicID = null ; $clinicUserUuid ='';$clinicAdmin = 0;$user_type = $userType ;
            if($userType != 'patient'){
                /** check email exist with in the same clinic */
                $userExists = User::checkUserExistance($input,$userCountryCode['id'],'register');
                if (isset($userExists['error'] )) {
                    return response()->json([
                        'error' => 1,
                        'message' => $userExists['message'],
                    ]);
                }

               
                $clinicAdmin = 1 ; // for clinic login
                // Fetch country ID from ref_country_codes table for clinic
                $clinicCountryCode =array();
                if(!isset($data['invitationkey'])){
                    $clinicID = Clinic::insertClinic($input,$clinicCountryCode);
                }
                $input['email'] = $input['user_email'];
            }
            $input['phone_number'] = $input['user_phone'];
            $userExists = User::getUserDetailsByEmail($input);
            if(empty($userExists)){
               
                $userID = User::insertUser($input,$userCountryCode,$clinicID);    /* Inset user ifo  */
            }else{
                User::updateUser($input,$clinicID);
                $userID = $userExists['id'];
            }

            if($userType == 'patient'){
                if(isset($data['invitationkey']) && $data['invitationkey'] != ''){
                    $parentDetails = $this->Corefunctions->convertToArray(Patient::patientByInvitationKey($data['invitationkey']));
                    if(!empty($parentDetails)){
                        $input['name'] =  $input['first_name'];
                        DB::table('patients')->where('id', $parentDetails['id'])->update(array(
                            // 'status' => '1',
                            'first_name'      => $input['name'],
                            'middle_name'  	  => isset($input['middle_name']) && $input['middle_name'] != '' ? $input['middle_name'] : null ,
                            'last_name'  	  => isset($input['last_name']) && $input['last_name'] != '' ? $input['last_name'] : null ,
                           
                            'updated_at' => Carbon::now(),
                        ));
                        DB::table('users')->where('id',$parentDetails['user_id'])->update(array(
                            'first_name'      => $input['name'],
                            'middle_name'  	  => isset($input['middle_name']) && $input['middle_name'] != '' ? $input['middle_name'] : null ,
                            'last_name'  	  => isset($input['last_name']) && $input['last_name'] != '' ? $input['last_name'] : null ,
                            'last_login_clinic_id' => $parentDetails['clinic_id'],
                        ));
                    }
                    $patientID = $parentDetails['id'];
                }else{
                    $patientID = Patient::insertPatient($input,$userCountryCode,$userID,$userID);
                }
                 /* patient Image Upload */
                if (isset($input['tempimage']) && $input['tempimage'] != "") {
                    $this->Corefunctions->uploadImage($input,$userID,$userType,$patientID);
                
                }

            }else{

                
                $username =  $input['first_name'].' '. $input['last_name'];
                $code = $this->Corefunctions->generateClinicianCode($input['clinic_name'],$username);
                $input['is_primary'] = '1';
                $clinicUser = ClinicUser::insertClinicUser($input,$userCountryCode,$userID,$clinicID,'1','',$code);
                $clinicUserUuid = $clinicUser['clinic_user_uuid'];

             
            }
           
            // Get user details by phone number
            $userDetails = User::userByID($userID); 
            $userDetails = $this->Corefunctions->convertToArray($userDetails);

            /**insert to otps table */
            $userOtpData = $this->Corefunctions->insertToOtps($input['user_phone'],$userCountryCode);

            $timezoneId  = NULL;
            $timezoneId  = $this->updateUserTimezone($input, $userDetails);
         
            /*  redirect to  otp page signup from fronend BB-236*/
            if(isset($data['formType']) && ($data['formType'] == 'forclinic') && ($userType == 'clinics')){
                /* temparory user storage */
                $userDetails = $this->Corefunctions->setTempSessionData($userOtpData,$input,$userCountryCode,$countryShortCode);
            }
         
            $trialSubscriptionDetails = SubscriptionPlan::getTrialPlan();

            if( empty( $trialSubscriptionDetails ) ){
                $arr['error']    = 1;
                $arr['errormsg'] = 'Please select trial subscription.';
                return response()->json($arr);
                exit();
            }
            if($userType != 'patient'){
                /* Insert into Subscription History */
                $subscriptionHistoryID = SubscriptionsHistory::insertSubscriptionsHistory($userID,$clinicID,$trialSubscriptionDetails);
                    
                /* Insert into Subscription */
                $userSubscriptionID = Subscription::insertSubscription($userID,$clinicID,$trialSubscriptionDetails,$subscriptionHistoryID,'1');
            
                $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::getClinicUser($userID,$clinicID));

                /** Generate Invoice ***/
                $billingInfo                    = array();
                $billingInfo['company_name']    = $clinicUser['name'];
                $billingInfo['country_id']      = '';
                $billingInfo['phone_number']    = $clinicUser['phone_number'];
                $billingInfo['address']         = '';
                $billingInfo['city']            = '';
                $billingInfo['zip']             = '';
                $billingInfo['state']           = '';
                // $invoiceID = $this->Corefunctions->generateNewInvoice( $userSubscriptionID, $trialSubscriptionDetails['id'], $userID, $clinicID, $billingInfo, '', $istrial='1');
                // Payment::updateInvoiceStatus($invoiceID,'0','2');
            }
        
            // Return response
            return response()->json([
                'success'          =>  1,
                'hasRedirect'      =>  0,
                'phonenumber'      =>  $input['user_phone'],
                'countryCodeShort' =>  $countryShortCode ,
                'countrycode'      =>  !empty($userCountryCode) ? $userCountryCode['country_code'] : null,
                'userType'         =>  $userType,
                'otp'              =>  isset($userOtpData['userotp']) ? $userOtpData['userotp'] : '',
                'key'              =>  isset($userOtpData['otpUuid']) ? $userOtpData['otpUuid'] : '',
                'redirecURL'       =>  'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&state=' . $clinicUserUuid . '&redirect_uri=' . url("/connect/stripe"),
                'message'          =>  'Clinic added successfully',
            ]);
        }
    }



   private function checkPatientDetails($userDetails, $input){
  
       if(isset($input['invitationkey']) && $input['invitationkey'] != ''){
            $patientsDetails = Patient::getPatientInvitaionWithClinic($input['invitationkey']);
              /* update statas after otp verify */
            if(!empty($patientsDetails) && isset($patientsDetails['status']) && $patientsDetails['status'] != '1'){
                DB::table('patients')->where('patients_uuid', $patientsDetails['patients_uuid'])->update(array(
                    'status' => '1',
                    'invitation_key' => NULL,
                ));
            }
            
       }else{
            $patientsDetails = $this->Corefunctions->convertToArray(Patient::getPatientWithClinic($userDetails["id"]));
       }
      
       if(empty($patientsDetails)){
           session()->flash("otperror", "The provided credentials does not match our records.");
           return back();
       }
      
      
      
       if (!empty($patientsDetails)) {

           $clinicDetails = [
               'name'        => $patientsDetails['name'],
               'clinic_uuid' => $patientsDetails['clinic_uuid'],
               'logo'        => $patientsDetails['logo'],
           ];

           $clinicId                     = isset($patientsDetails['clinic_id']) ? $patientsDetails['clinic_id'] : '';
           $patientID                    = $patientsDetails['patientID'];
           $patient_uuid                 = $patientsDetails['patients_uuid'];
           $logoPath                     = (isset($userDetails['profile_image']) && $userDetails['profile_image'] != '') ? $this->Corefunctions->resizeImageAWS($userDetails['id'], $userDetails['profile_image'], $userDetails['first_name'], 180, 180, '1') : '';
           $userDetails['profile_image'] = $logoPath;
       }
       $userDetails['userSessionID'] = User::insertUserSession($userDetails['id']);
       $sessionData = $this->Corefunctions->setSessionData($userDetails, $clinicDetails, 'patient',$patient_uuid,0,$clinicId,0,$patientID);
       $this->Corefunctions->attachDefaultFolders($userDetails["id"]);

       $arr['success']          = 1;
       $arr['type']             ='patient' ;
       $arr['hasRedirect']      = $userDetails['is_taken_intakeform'];
       $arr['redirectURL']      = url('intakeform') ;
       $arr['isregister']       = isset($input['isregister']) && $input['isregister'] !='' ? $input['isregister'] : '0' ;
       $arr['message']          = 'Otp verified successfully' ;
       return $arr ;
      

   }
    public function connectStripe(Request $request)
    {
        // Code Fix Required | Session Check Missing  - Done
        /***  Check if the session has the 'user' key */
        if (!Session::has('user')) {
            // Redirect to login page if session does not exist
            return Redirect::to('/login');
        }
        /** check for any stripe return error */
        

        $urlArray = $_GET;
    
        if (!isset($urlArray['code']) && isset($_GET['state']) && $_GET['state'] != '') {
            $iserror = isset($_GET['error']) && $_GET['error_description'] && $_GET['error']!='' && $_GET['error_description'] !='' ? $_GET['error_description'] : '' ;
            return Redirect::to('/logout')->with('message',$iserror);
            // return Redirect::to('/logout'); // Adjust the URL to your login route
        }
        if (isset($urlArray['code']) && $urlArray['code'] != '') {
            $connectionID = $this->Corefunctions->connectStripe($urlArray);
            Session::put("user.stripeConnection", 1);
            
             /* insert clinic onboarding history for each steps */
             $historyID = ClinicOnboardingHistory::insertOnboardingHistory(session('user.clinicID'),4);
             /* update last onbording step to clinic table */
             $clinic = Clinic::updateLastOnboarding(session('user.clinicID'),4);
             return redirect('onboarding/patient-subscriptions');
            // return redirect()->to('dashboard'); 
        }
    }
    public function disConnectStripe()
    {
       
        // Code Fix Required | Session Check Missing - Done
        if (!Session::has('user')) {
            // Redirect to login page if session does not exist
            return Redirect::to('/login');
        }

        if (request()->ajax()) {
            $this->stripePayment = new \App\customclasses\StripePayment;
            $this->Corefunctions = new \App\customclasses\Corefunctions;

            $data = request()->all();
            $clinicDetails = ClinicUser::where('clinic_id', session()->get('user.clinicID'))->first();

            $stripeConnectionDetails = StripeConnection::where('user_id', $clinicDetails['user_id'])->first();
            if (empty($stripeConnectionDetails)) {
                session()->flash("error", "Invalid Data");
                return back();
            }

            // Stripe disconect function

            $connectionresponse = $this->stripePayment->disConnectStripeAccount($stripeConnectionDetails->stripe_user_id);

            $connectionresponse = json_decode(json_encode($connectionresponse['response']), true);
          
            if (!isset($connectionresponse['stripe_user_id'])) {
                session()->flash("error", "Invalid access! Please contact the Administrator");
                return back();
            }

            if (empty($connectionresponse) && !isset($connectionresponse['stripe_user_id'])) {
                session()->flash("error", "stripe response failure");
                return back();
            }

            if (!empty($connectionresponse) && isset($connectionresponse['stripe_user_id'])) {

                $stripeConnectionDetails->disconnection_response = json_encode($connectionresponse);
                $stripeConnectionDetails->status = '0';
                $stripeConnectionDetails->deleted_at = Carbon::now();
                $stripeConnectionDetails->update();
                $connectionID = $stripeConnectionDetails->id;

                DB::table('clinics')->where('id', $clinicDetails->clinic_id)->update(array(
                    'stripe_connection_id' => null,
                    'updated_at' => Carbon::now(),
                ));

                DB::table('patients')->where('clinic_id', $clinicDetails->clinic_id)->where('user_id', $clinicDetails['user_id'])->update(array(
                    'stripe_customer_id' => null,
                    'updated_at' => Carbon::now(),
                ));
                DB::table('users')->where('id', $clinicDetails['user_id'])->update(array(
                    'stripe_customer_id' => null,
                ));
            }
            $arr['success'] = 1;
            $arr['message'] = 'Stripe disconnected successfully.';
            return response()->json($arr);
            exit();
        }
    }

    
    public function success(){
        $seo['title'] = "Sign Up  | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('auth.success',compact('seo'));
    }

    /**
     * Logout user and invalidate session
     */
    public function clearTempuser(Request $request)
    {
        Session::forget('tempuser'); // Clears the session data
    }

    public function logout(Request $request)
    {
      
        $clinicuser_uuid = Session::get('user.clinicuser_uuid');
        $connectionId = Session::get('user.connection_id');
        ClinicUser::updateAvailable($clinicuser_uuid,'0');
        // Invalidate the session
        $request->session()->invalidate();
        $message = $request->session()->get('message');
        // Regenerate the session token to prevent CSRF issues
        $request->session()->regenerateToken();
        /* disconnect socket */
        UserConnection::updateUserConnection( $connectionId );
        if (isset($_GET['redirectinvite']) && $_GET['redirectinvite'] != '') {
            return redirect('/' . $_GET['redirectinvite']);
        } else {
           
            return redirect('/login')->with('message',$message);
        }

        // Redirect to the login page with a logout message
    }

    public function registerClinic(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            $timezoneOffset = $data['timezoneOffset'];
            $this->Corefunctions = new \App\customclasses\Corefunctions;
            // Fetch country ID from ref_country_codes table
            $countryDetails = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());

            // Fetch country ID from ref_country_codes table
            $stateDetails = $this->Corefunctions->convertToArray(DB::table('ref_states')->get());

            /** get all designation */
            $designationDetails = RefDesignation::getDesignation();

            /** get all specialities */
            $specialties = RefSpecialty::getSpeciality();

            $data['countryDetails'] = $countryDetails;
            $data['specialties'] = $specialties;
            $data['designation'] = $designationDetails;
            $data['stateDetails'] = $stateDetails;
            $data['timezoneOffset'] = $timezoneOffset;
            $html = view('auth.register', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();

            // return view('clients.listing',$data);
        }
    }

    public function invitationCheck(Request $request, $invitationkey)
    {

        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $seo = array();
        $seo['title'] = 'Invitation | ' . env('APP_NAME');
        $seo['description'] = "";
        $seo['keywords'] = "";
        $seo['og:title'] = "";
        $seo['og:description'] = "";

        $haserror = '0';
        $errormsg = '';
        $isDeleted = '0';
        $alreadyLoggined = '';
        if (Session::has('user')) {
            $alreadyLoggined = 1;
        }

        // Code Fix Required | Use the prefix and do the proper checks - Done
        $key = $invitationkey;
        $keyParts = explode('_', $invitationkey);
        if ($keyParts[0] == 'c') {
            $clinicdoctorDetails = ClinicUser::clinicUserByInvitationKey($invitationkey);
            $isDeleted = ( !empty($clinicdoctorDetails) && $clinicdoctorDetails->deleted_at != '') ? '1' : '0' ;
            if (empty($clinicdoctorDetails)) {
                $haserror = '1';
                return view('invitation', compact('seo', 'invitationkey', 'alreadyLoggined', 'haserror', 'errormsg'));
            }
            $doctorDetails = ClinicUser::getUserByUserId($clinicdoctorDetails->created_by,$clinicdoctorDetails->clinic_id);
            $clinicianname  = $this->Corefunctions->showClinicanName($doctorDetails,'0');
         
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicdoctorDetails->clinic_id));
            $clinicDetails['logo'] = ($clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");
            $name =  isset($clinicdoctorDetails->user_type_id)  && ( $clinicdoctorDetails->user_type_id == '2' || ($clinicdoctorDetails->user_type_id == '1') ) ? $this->Corefunctions->showClinicanName($clinicdoctorDetails,'0') : $clinicdoctorDetails->first_name.' '.$clinicdoctorDetails->last_name ;
            return view('invitation', compact('seo', 'invitationkey', 'alreadyLoggined', 'haserror', 'errormsg', 'clinicDetails','isDeleted', 'clinicianname', 'name'));
        } else {
            $clinicPatientDetails = Patient::patientByInvitationKey($invitationkey);
            if (empty($clinicPatientDetails)) {
                $haserror = '1';
                return view('patient.invitation', compact('seo', 'invitationkey', 'alreadyLoggined', 'haserror', 'errormsg', 'key'));
            }
            $doctorDetails = ClinicUser::getUserByUserId($clinicPatientDetails->created_by,$clinicPatientDetails->clinic_id);
            $clinicianname  = $this->Corefunctions->showClinicanName($doctorDetails,'1');
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicPatientDetails->clinic_id));
            $clinicDetails['logo'] = ($clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");
            $name = $clinicPatientDetails->name;
            return view('patient.invitation', compact('seo', 'key', 'alreadyLoggined', 'haserror', 'errormsg', 'clinicDetails','isDeleted','clinicianname', 'name'));
        }
    }

            /* Fetch User Details */
   public function invitationStatusChange($key, Request $request)
    {
        // Code Fix Required | Use the prefix and do the proper checks, Make session function as common function - Done

        if (request()->ajax()) {
            $data = request()->all();
           
            /* Fetch User Details */
            if (isset($data['type']) && ($data['type'] == 'patient')) {
                $parentDetails = $this->Corefunctions->convertToArray(Patient::patientByInvitationKey($key));
            } else {
                $parentDetails = $this->Corefunctions->convertToArray(ClinicUser::clinicUserByInvitationKey($key));
            }

            $toRegister = 0;
            if (empty($parentDetails)) {
                $arr['message'] = "The user is currently inactive. Please contact the Clinic for further assistance.";
                $arr['success'] = 0;
                return response()->json($arr);
                exit();

            }
            if (!empty($parentDetails) && $parentDetails['status'] == '1') {
                $arr['message'] = "Invitation already accepted!";
                $arr['success'] = 0;
                return response()->json($arr);
                exit();
            }

            /* Accept Scenerio */
            if (isset($data['accept']) && $data['accept'] == 1) {
                if (isset($data['type']) && $data['type'] == 'patient') {
                    $userType = '';

                    Patient::updatePatientStatus($parentDetails['id'],'1');

                    /* Insert user info  */
                    if (!empty($parentDetails)) {
                        /* Fetch user  Details */
                        $userDetails = User::getUserByPhone($parentDetails,$parentDetails['country_code']);
                        
                        if (empty($userDetails)) {
                            $userID = User::insertUser($parentDetails);
                        } else {
                            /* if user already exist with same phone/email and adress is null updating address from invited patient  */
                            if($userDetails['address'] == ''){

                                User::updateUserAddress($parentDetails,$userDetails['id']);
                            }
                            User::updateUserStatus($userDetails['id']);

                            $userID = $userDetails['id'];
                            $userUuid = $userDetails['user_uuid'];
                        }

                        $timezoneId= NULL;
                        if( isset($data['timezoneOffset']) && $data['timezoneOffset']!=''){          
                            $timezone = User::getUserTimeZone($data['timezoneOffset']);
                            $timezoneId= !empty($timezone) ? $timezone->id : Null;   
                            
                            if( $timezoneId != $userDetails['timezone_id'] ){
                                User::updateUserTimezone($userID,$timezoneId);
                            }
                        }

                        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($parentDetails['clinic_id']));

                        if (empty($clinicDetails)) {
                            return response()->json([
                                'error' => 1,
                                'errormsg' => 'Sorry,The provided credentials do not match our records.',
                            ]);
                        }

                        $this->Corefunctions->attachDefaultFolders($userID);

                        $timezoneDetails = User::getUserTimeZoneById($userDetails['timezone_id']);
                        $timezoneDetails = $this->Corefunctions->convertToArray($timezoneDetails);

                        // Store user session data
                        $sessArray = array();

                        $sessArray['user']['firstName'] = $parentDetails['name'];
                        $sessArray['user']['lastName'] = '';
                        $sessArray['user']['userID'] = $parentDetails['user_id'];
                        $sessArray['user']['email'] = $parentDetails['email'];
                        $sessArray['user']['phone'] = $parentDetails['phone_number'];
                        $sessArray['user']['user_uuid'] = $userUuid;
                        $sessArray['user']['image_path'] = ($parentDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($parentDetails['logo_path']) : asset('images/default_img.png');
                        $sessArray['user']['userType'] = 'patient';
                        $sessArray['user']['clinicuser_uuid'] = $parentDetails['patients_uuid'];
                        $sessArray['user']['userLogo'] = ($parentDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($parentDetails['logo_path']) : asset('images/default_img.png');
                        $sessArray['user']['timezone'] = !empty($timezoneDetails) ? $timezoneDetails['timezone_format'] : 'UTC';

                        session($sessArray);
                    }

                    /* Add Accept Notifications */
                    $this->Corefunctions->addNotifications(9, $parentDetails['clinic_id'], $parentDetails['created_by'], $parentDetails['id']);
                    $arr['hasRedirect'] = ($userDetails['is_taken_intakeform'] == '1')? '0' :'1';
                    $arr['redirectURL'] = url('intakeform');
                }
                
                $arr['message'] = "Invitation accepted successfully";
                $arr['success'] = 1;
                $arr['key'] = $key;
                return response()->json($arr);
                exit();
            }

            if (isset($data['accept']) && $data['accept'] == 0) {
                if (isset($data['type']) && ($data['type'] == 'patient')) {
                    Patient::updatePatientStatus($parentDetails['id'],'0');

                    /* Add Decline Notifications */
                    $this->Corefunctions->addNotifications(10, $parentDetails['clinic_id'], $parentDetails['created_by'], $parentDetails['id']);

                } else {
                    ClinicUser::updateClinicUserStatus($parentDetails['clinic_user_uuid'],'0');

                    /* Add Decline Notifications */
                    $this->Corefunctions->addNotifications(2, $parentDetails["clinic_id"], $parentDetails['created_by'], $parentDetails['id']);

                }
               
                $arr['message'] = "Invitation declined successfully!";
                $arr['success'] = 2;
                return response()->json($arr);
                exit();
            }

            $arr['message'] = "Success";
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    
    //not in use
    public function LoginWithGoogle()
    {

        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();

    }
    //not in use
    public function handleGoogleCallback(Request $request)
    {

        $googleUser = Socialite::driver('google')->stateless()->user();
        $googleUser = $this->Corefunctions->convertToArray($googleUser);

        $existuser = User::where('email', $googleUser['email'])->whereNull('deleted_at')->first();

        if (!empty($existuser)) {
            if (empty($existuser->profile_image) && $googleUser['avatar'] != '') {
                $image_key = $this->Corefunctions->generateUniqueKey('12', 'temp_docs', 'tempdoc_uuid');
                $path = $googleUser['avatar'];
                $imageContent = file_get_contents($path); // Fetch the image

                if ($imageContent !== false) {
                    // Step 3: Generate a unique path for S3
                    $s3Path = $this->Corefunctions->getMyPath(0, $image_key, "jpg", "profileImage");

                    // Step 4: Upload the image to S3
                    $uploadSuccess = $this->Corefunctions->uploadDocumenttoAWS($s3Path, $imageContent);
                    if ($uploadSuccess) {
                        // Step 5: Update the user's profile with the uploaded image path
                        $existuser->profile_image = $s3Path;
                        $existuser->status = '1';
                        $existuser->update();
                    }
                }

            }
        }
        $existuser = $this->Corefunctions->convertToArray($existuser);
        if (empty($googleUser)) {
            return redirect('login');
        }

        /*** insert to user table *********/

        if (empty($existuser)) {
          
            if ($googleUser['avatar'] != '') {
                $path = $googleUser['avatar'];
                $imageContent = file_get_contents($path); // Fetch the image

                if ($imageContent !== false) {
                    $image_key = $this->Corefunctions->generateUniqueKey('12', 'temp_docs', 'tempdoc_uuid');
                    // Step 3: Generate a unique path for S3
                    $s3Path = $this->Corefunctions->getMyPath(0, $image_key, "jpg", "profileImage");

                    // Step 4: Upload the image to S3
                    $uploadSuccess = $this->Corefunctions->uploadDocumenttoAWS($s3Path, $imageContent);
                    $image_path = $s3Path;

                }

            }

            // Code Fix Required | Remove IPinfo if not used. Check other logins too - Done

            $userkey = $this->Corefunctions->generateUniqueKey('10', 'users', 'user_uuid');
            $newUser = new User();
            $newUser->user_uuid = $userkey;
            $newUser->first_name = $googleUser['name'];
            $newUser->email = $googleUser['email'];
            $newUser->google_id = $googleUser['id'];
            $newUser->status = '1';

            if ($googleUser['avatar'] != '') {
                $newUser->profile_image = $image_path;
            }
            $newUser->save();

            $user = User::where('id', $newUser->id)->first();
            $user = $this->Corefunctions->convertToArray($user);
            $userID = $newUser->id;

            // Generate unique OTP UUID
            $clinicUuid = $this->Corefunctions->generateUniqueKey("10", "clinics", "clinic_uuid");

            $clinicObject = new Clinic();
            $clinicObject->clinic_uuid = $clinicUuid;
            $clinicObject->name = $googleUser['name'];
            $clinicObject->email = $googleUser['email'];

            $clinicObject->save();

            $clinicID = $clinicObject->id;

            /* Insert clinic data to clinincs users table*/
            // Generate unique OTP UUID
            $clinicUserUuid = $this->Corefunctions->generateUniqueKey("10", "clinic_users", "clinic_user_uuid");
            $clinicUserObject                   = new ClinicUser();
            $clinicUserObject->clinic_user_uuid = $clinicUserUuid;
            $clinicUserObject->clinic_id        = $clinicID;
            $clinicUserObject->user_id          = $userID;
            $clinicUserObject->name             = $googleUser['name'];
            $clinicUserObject->email            = $googleUser['email'];
            $clinicUserObject->user_type_id     = 2;
            $clinicUserObject->is_clinic_admin  = '1';
            $clinicUserObject->status           = '1';
            $clinicUserObject->save();


            // Get user details by phone number
            $userDetails = $this->Corefunctions->convertToArray(User::where('id', $userID)->whereNull('deleted_at')->first());

            // Store user session data
            $clinicDetails = [
                'name' => $googleUser['name'],
                'clinic_uuid' => $clinicUuid,
                'logo' => null,
            ];
            $sessionData = $this->Corefunctions->setSessionData($userDetails, $clinicDetails, $user_type = 'clinics', $clinicUserUuid,  0, $clinicID, $clinicAdmin = 1);

            $stripeURL = 'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&state=' . $clinicUserUuid . '&redirect_uri=' . url("/connect/stripe");

            // Code Fix Required | Remove one redirect - Done
            return redirect($stripeURL);
           
       
        } else {
         
            $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::select('clinic_users.user_type_id', 'clinic_users.clinic_id', 'clinic_users.clinic_user_uuid', 'logo_path')
                    ->where('clinic_users.user_id', $existuser["id"])->where('clinic_users.status', '1')->first());
            // If user does not exist, return error response
            if (!empty($clinicUserDetails)) {
                $user_type = !empty($clinicUserDetails) && $clinicUserDetails['user_type_id'] == '2' ? 'doctor' : (!empty($clinicUserDetails) && $clinicUserDetails['user_type_id'] == '3' ? 'nurse' : 'clinics');
                $clinicId = $clinicUserDetails['clinic_id'];
                $logoPath = ($clinicUserDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicUserDetails['logo_path']) : '';
                $clinicuuid = $clinicUserDetails['clinic_user_uuid'];
            }
            if (empty($clinicUserDetails)) {
             
                return redirect('login');

            }
            $clinicId = ($existuser['last_login_clinic_id'] == null) ? $clinicId : $existuser['last_login_clinic_id'];

            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::select('id', 'clinic_uuid', 'name', 'logo', 'stripe_connection_id')->where('id', $clinicId)->whereNull('deleted_at')->first());
            if (empty($clinicDetails)) {
                return redirect('login');
            }

            
          
            // Store user session data
            $sessionData = $this->Corefunctions->setSessionData($existuser, $clinicDetails, $user_type = 'clinics',$clinicuuid, 0, $clinicId, $clinicAdmin = 1);

          
            /** update last login id */

            DB::table('users')->where('id', $existuser['id'])->update(array(
                'last_login_clinic_id' => $clinicDetails['id'],
                'updated_at' => Carbon::now(),
            ));

            //  Process stripe connection details
            $stripeConnection = StripeConnection::where('user_id', $existuser["id"])->where('status', '1')->first();
            $stripe_connected = 0;
            if (!empty($stripeConnection)) {
                $stripe_connected = 1;
            }
          
            $stripeURL = 'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&state=' . $clinicUserDetails['clinic_user_uuid'] . '&redirect_uri=' . url("/connect/stripe");
            if ($stripe_connected == 0) {
                return redirect($stripeURL);
            }
          

            return redirect('dashboard');

        }
       
       
        return redirect('dashboard');


    }

    private function loginWithEmail($formData)
    {

        /*********** For login with Phone number and Otp  **********/
        parse_str($formData, $input);
        $userDetails = User::getUserByEmail($input['email']);
       
        // If user does not exist, return error response
        if (empty($userDetails)) {

            $responseArray['error'] = 0;
            $responseArray['errormsg'] = 'Sorry,The provided credentials do not match our records.';
            return $responseArray;
        }
        $userType='clinic';

        if ($userDetails['last_login_clinic_id'] != NULL) {

            $parentDetails = ClinicUser::getLastLoginClinicData($input,$userDetails['last_login_clinic_id'],'email');
            // /* check the user also have active clinic */
            $clinicDetailsCount = ClinicUser::getUserClinic($userDetails['id']) ;
            if (!empty($parentDetails) && $clinicDetailsCount == 0) {
                $responseArray['error'] = 0;
                $responseArray['errormsg'] = 'Your clinic has been deactivated.Please contact the '.env('APP_NAME').' admin to activate it';
                return $responseArray;

            }
        } 
        if(empty($parentDetails)){
            $parentDetails = Patient::getPatientBymail($input);
            $userType='patient';
        }
       
      
       
        // If user does not exist, return error response
        if (empty($parentDetails)) {
            
            $responseArray['error'] = 0;
            $responseArray['errormsg'] = 'Sorry,The provided credentials do not match our records.';
            return $responseArray;

        }
        /* Deactivate previous otp generated for this email */
        Otp::updateOtp($input['email'],'email');
      

        // Generating unique UUID ,randon otpn & expiry time (3 minutes from now)
        $otpUuid = $this->Corefunctions->generateUniqueKey("10", "otps", "otp_uuid");
        $userotp = rand(1000, 9999);
        $expiryOn = time() + (3 * 60);

        // Insert OTP details into the 'otps' table
        $otpObject = new Otp();
        $otpObject->otp_uuid = $otpUuid;
        $otpObject->otp = $userotp;
        $otpObject->email = $input['email'];
        $otpObject->phone_number = $userDetails['phone_number'];
        $otpObject->is_used = '0';
        $otpObject->country_id = !empty($countryCode) ? $countryCode['id'] : 1;
        $otpObject->expiry_on = $expiryOn;
        $otpObject->save();

        /**get country code details */
        $countryCode = RefCountryCode::getCountryCodeById($userDetails['country_id']) ;

        /** send otp  mail */
        $data['email'] = $input['email'];
        $data['name'] = $userDetails['first_name'];
        $data['otp'] = $userotp;

        /* otp send mail */
        $response = $this->Corefunctions->sendmail($data, 'Login OTP', 'emails.otpmail');
      
        $responseArray['userType'] = $userType;
        $responseArray['phonenumber'] = $userDetails['phone_number'];
        $responseArray['userotp'] = $userotp;
        $responseArray['otpUuid'] = $otpUuid;
        $responseArray['response'] = $response;
        $responseArray['countrycode'] = !empty($countryCode) ? $countryCode['country_code'] : '';
        $responseArray['countryCodeShort'] = !empty($countryCode) ? $countryCode['short_code'] : '';
        $responseArray['email'] = $input['email'];
        return $responseArray;

    }
    public function viewReceiptDetails($paymentKey)
    {

        $paymentDetails = Payment::getpaymentsByKey($paymentKey);                /*payment details  */
        $cardDetails    = PatientCard::getCardsById($paymentDetails['user_card_id']);  /*card details */

        $userDetails   = $this->Corefunctions->convertToArray(User::userByID($paymentDetails['user_id'],'all'));
        $countryCode   = RefCountryCode::getCountryCodeById($paymentDetails['billing_country_id']);

        $tranactionDetails = $this->Corefunctions->convertToArray(DB::table('transactions')->where('id',$paymentDetails['transaction_id'])->first());

        $clinicDetails = Clinic::getReceiptClinicByID($tranactionDetails['clinic_id']) ;
        
        $clinicDetails['logo']          = isset($clinicDetails['logo']) && ($clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset('images/default_clinic.png');
        $cliniccountryCode   =  isset($clinicDetails['country_code']) && ($clinicDetails['country_code'] != '') ? RefCountryCode::getCountryCodeById($clinicDetails['country_code']) : '';
        $cliniccode  = isset($cliniccountryCode['country_code']) && ($cliniccountryCode['country_code'] != '') ? $cliniccountryCode['country_code'] : '';
        $clinicName                     = $clinicDetails['name'] ;      
        $subscriptionName = '';
        if ($paymentDetails['parent_type'] == 'subscription') {
            $subscription = \App\Models\ClinicSubscription::find($paymentDetails['parent_id']);
            $subscriptionName = $subscription->plan_name;
        }
        if($paymentDetails['parent_type'] != 'ePrescribe'){
            /** clinic details address details */
            if( $paymentDetails['billed_by'] !='' && is_string($paymentDetails['billed_by'])){
                $clinicDetails = unserialize($paymentDetails['billed_by']);
                $clinicDetails['logo'] = isset($clinicDetails['logo']) && ($clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset('images/default_clinic.png');
            }
        }
       
        $paymentDetails['country_code'] = $countryCode['country_code'];
        $data['paymentDetails'] = $paymentDetails;
        $data['cliniccode']   = $cliniccode;
        $data['cardDetails'] = $cardDetails;
        $data['userDetails'] = $userDetails;
        $data['clinicDetails'] = $clinicDetails;
        $data['clinicName']    = $clinicName;
        $data['subscriptionName']    = $subscriptionName;
        return view('payments.receiptdetails', $data);

    }

    public function validateUserPhone(Request $request)
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;

        if (request()->ajax()) {

            $data = request()->all();
            $type = $data['type'];
           
            $validateUser = $this->Corefunctions->validateUserPhone($data);
            
            if(isset($validateUser['error'])){
                return response()->json([
                    'valid' => false,
                    'message' => $validateUser['message'],
                ]);
            }
           
            return response()->json(['valid' => true]);

        }

    }
  
    public function validateUserPhoneRegister(Request $request)
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;

        if (request()->ajax()) {

            $data = request()->all();
            $type = $data['type'];
           
            $validateUser = $this->Corefunctions->validateUserPhoneRegister($data);
            //print_r($validateUser);die;
            if(isset($validateUser['error'])){
                return response()->json([
                    'valid' => false,
                    'message' => $validateUser['message'],
                ]);
            }
           
            return response()->json(['valid' => true]);

        }

    }
    public function viewInvoiceDetails(Request $request,$key){

        $subscriptionDetails = $subscriptionPlanDetails = array() ;
        $paymentDetails = $this->Corefunctions->convertToArray(DB::table('invoices')->where('invoice_uuid',$key)->limit(1)->first());
        if(isset($paymentDetails['billing_state']) && $paymentDetails['billing_state'] != ''){
            $state = DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->where('id', $paymentDetails['billing_state'])->first();
            $state = $this->Corefunctions->convertToArray($state);
        }

        $clinicDetails = Clinic::getReceiptClinicByID($paymentDetails['parent_id']) ;
        
        $clinicDetails['logo']          = isset($clinicDetails['logo']) && ($clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset('images/default_clinic.png');
        $clinicDetails['country_code']  = isset($clinicDetails['country_code']) && ($clinicDetails['country_code'] != '') ? $this->Corefunctions->getCountryCode($clinicDetails['country_code']) : '';
        $clinicName                     = $clinicDetails['name'] ;

        // $subscriptionDetails               = $this->Corefunctions->convertToArray(DB::table('subscriptions')->select('trial_subscription')->where('subscription_plan_id',$paymentDetails['subscription_plan_id'])->where('user_id',$paymentDetails['user_id'])->where('clinic_id',$paymentDetails['clinic_id'])->limit(1)->first());
        $paymentInfo = Payment::getPaymentsById($paymentDetails['payment_id']);
        $paymentDetails['isTrial'] = ( !empty( $subscriptionDetails ) && $subscriptionDetails['trial_subscription'] =='1') ? '1' : '0';

        // $subscriptionPlanDetails            = $this->Corefunctions->convertToArray(DB::table('subscription_plans')->where('id',$paymentDetails['subscription_plan_id'])->limit(1)->first());
        // $subscriptionPlanDetails['duration'] = (!empty( $subscriptionDetails ) && $subscriptionDetails['trial_subscription'] =='1') ? '15 Days' : (($subscriptionPlanDetails['tenure_type_id'] =='1') ? 'Yearly' : 'Monthly');


        // $userDetails = $this->Corefunctions->convertToArray(DB::table('users')->where('id',$paymentDetails['user_id'])->limit(1)->first());

        $country                           = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->where('id', $paymentDetails['billing_country_id'])->limit(1)->first());
        $paymentDetails['billing_country'] = ( !empty($country ) ) ? $country['country_name'] :'';
        $paymentDetails['amount_label'] = ( !empty($paymentDetails) ) ? '$'.$paymentDetails['grandtotal'] : $paymentDetails['grandtotal'] ;
        $paymentDetails['billing_state'] = $state['state_name'];
        $paymentDetails['country_code']  = isset($paymentDetails['billing_country_id']) && ($paymentDetails['billing_country_id'] != '') ? $this->Corefunctions->getCountryCode($paymentDetails['billing_country_id']) : '';
        /* Fetch Payment Details  */
        // $paymentData = $this->Corefunctions->convertToArray(DB::table('payments')->where('id',$paymentDetails['payment_id'])->limit(1)->first());
        // if( !empty($paymentData)){
        //     $paymentData['current_account_balance']     = '$'.$paymentData['current_account_balance'];
        //     $paymentData['remaining_account_balance']   = '$'.$paymentData['remaining_account_balance'];

        //     $paymentData['subscription_amount']         = '$'.$paymentData['subscription_amount'];
        //     $paymentData['db_amount']                   = $paymentData['amount'];
        //     $paymentData['db_subscription_amount']      = $paymentData['subscription_amount'];
        // }

        // $data['paymentData']            = $paymentData;
        // $data['userDetails']            = $userDetails;
        $data['paymentDetails']         = $paymentDetails;
        $data['subscriptionDetails']    = $subscriptionPlanDetails;
        $data['clinicDetails']          = $clinicDetails;
        $data['paymentInfo']         = $paymentInfo;

        return view('clinics.invoicedetails',$data);

    }
    
    public function socketEvent(Request $request)
    {
        // Code Fix Required | Use the prefix and do the proper checks, Make session function as common function - Done

        if (request()->ajax()) {
            $data = request()->all();
            $action             = (isset($data['socketdata']['data']['event'])) ? $data['socketdata']['data']['event']: '';
      
          switch ($action) {
             case 'connect':
                 session()->put('user.connection_id', $data['socketdata']['connectionId']);
                  break;
              default:
                break;
            }
             
            $arr['event'] = $action;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
    
        }
    }
      public function checkvideocall(Request $request)
    {
        // Code Fix Required | Use the prefix and do the proper checks, Make session function as common function - Done

        if (request()->ajax()) {
            $data = request()->all();
            $appointmentDetails = Appointment::getFirstWaitingByClinicID(session()->get('user.clinicID'));
            $appointmentDetails = $this->Corefunctions->convertToArray($appointmentDetails);
    
            $appointmentIDS = $this->Corefunctions->getIDSfromArray($appointmentDetails, 'id');
           
            $videocallDetails = VideoCall::getVideoCallByAppointmentIds($appointmentIDS);
            $videocallDetails = $this->Corefunctions->convertToArray($videocallDetails);
    
            $videocallIDS = $this->Corefunctions->getIDSfromArray($videocallDetails, 'id');
           
            $videoCallParticipantDetails = VideoCallParticipant::getVideocallByIDs($videocallIDS);
              
            $message = $messageuser = $messageProfileImage = '';
            $videoCall = $appointment = array();
            if(!empty($videoCallParticipantDetails)){
                
                $videoCall = VideoCall::videoCallByID($videoCallParticipantDetails->call_id);
                $appointment = Appointment::appointmentByID($videoCall->appointment_id);
         
                
                $userDetails = Patient::patientByUser($videoCallParticipantDetails->participant_id);
                 //print_r($userDetails);die;
                $message = ' is waiting for join the call.';
                $messageuser = $userDetails->name;
                $messageProfileImage = ($userDetails->user->profile_image != '') ? $this->Corefunctions-> resizeImageAWS($userDetails->user->id,$userDetails->user->profile_image,$userDetails->user->first_name,180,180,'1') : asset('images/default_img.png');

            }
             
            $arr['roomKey'] = isset($videoCall->room_key) ? $videoCall->room_key : '';
            $arr['aptkey'] =  isset($appointment->appointment_uuid) ? $appointment->appointment_uuid : '';
            $arr['message'] = $message;
            $arr['messageuser'] = $messageuser;
            $arr['messageProfileImage'] = $messageProfileImage;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
    
        }
    }
    public function printLabs($labKey) {
        /* get the test lists */
        $finalTestArray = $orderLists = $userDetails = $clinicDetails = $countryCodedetails =$userCountryCode = array();

        if (isset($labKey) && $labKey != '') {
            /* get the test lists */
            $orderLists =  PatientLabTest::getPatientLabTest($labKey) ;
            if(empty($orderLists)){
                return Redirect::to('/dashboard'); 
            }
          
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
            $userCountryCode = RefCountryCode::getCountryCodeById($userDetails['country_code']);
            $patientDetails = Patient::patientByUser($orderLists['patient_id']);
            $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'] : $patientDetails['first_name'];
            $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);
        }
        
        /*categoryIds all categories */
        $categoryDetails =  RefLabTest::getAllCategoryList();
        $categoryDetails = $this->Corefunctions->getArrayIndexed1($categoryDetails, 'id');
        $clinicId = $orderLists['clinic_id'];
        $clinicDetails = Clinic::clinicByID($clinicId);
        $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
        $clinicDetails['logo'] = (isset($clinicDetails['logo']) && $clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset('images/default_clinic.png');    
        $countryCodedetails = RefCountryCode::getCountryCodeById($clinicDetails['country_code']);
         return view('appointment.labs.orderprint', compact(
            'patientDetails',
            'userDetails',
            'userCountryCode',
            'orderLists',
            'finalTestArray',
            'categoryDetails',
            'clinicDetails',
            'countryCodedetails',
            
        ));
    }



    public function printImaging($labKey) {
     
        /* get the test lists */
        $finalTestArray = $orderLists = $userDetails = $clinicDetails = $countryCodedetails = $userCountryCode = array();
        /** get oprtion */
        $optionsList  =   RefLabTest::getOptionList();
            
        if (isset($labKey) && $labKey != '') {
            /* get the test lists */
            $orderLists =  PatientImagingTest::getPatientImagingByKey($labKey) ;
            
            if(empty($orderLists)){
                return view('not-found');
            }
            /* get the test item lists */
            $orderItemLists =  PatientImagingTest::getPatientImagingItems($orderLists['id']) ;                
            $imagingTestIds = array();
            foreach ($orderItemLists as $item) {
                $imagingTestIds[] =$item['sub_lab_test_id'];
                $labId = $item['lab_test_id'];
                $subId = $item['sub_lab_test_id'];
                $selectedOptionIds =$selectedOptionNames= [];
                /** set options array */
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
                // Add options to item
                $item['options'] = $selectedOptionNames;


                // Initialize array if not already set
                // Initialize main array if not already set
                if (!isset($finalTestArray[$labId])) {
                    $finalTestArray[$labId] = [
                        'is_contrast' => $item['is_contrast'], // ✅ Set here from the first item
                        'items' => []
                    ];
                }
                // if (!isset($finalTestArray[$labId])) {
                //     $finalTestArray[$labId] = [];
                // }
                // Add item if sub_lab_test_id is unique in this group
                $exists = array_filter($finalTestArray[$labId]['items'], function ($i) use ($subId) {
                    return $i['sub_lab_test_id'] == $subId;
                });
                if (empty($exists)) {
                    $finalTestArray[$labId]['items'][] = $item;
                }
            }
        //    print'<pre>';print_r( $finalTestArray);exit;
            /*user details */
            $userDetails = ClinicUser::getClinicUserByUserId($orderLists['created_by']);
            $userDetails = $this->Corefunctions->convertToArray($userDetails);

            $userCountryCode = RefCountryCode::getCountryCodeById($userDetails['country_code']);

            $patientDetails = Patient::patientByUser($orderLists['patient_id']);
            $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'] : $patientDetails['first_name'];
            $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);
        }
       
        /*categoryIds all categories */
        $categoryDetails =  RefLabTest::getAllImagingCategoryList();
        $categoryDetails = $this->Corefunctions->getArrayIndexed1($categoryDetails, 'id');


        $clinicId = $orderLists['clinic_id'];
        $clinicDetails = Clinic::clinicByID($clinicId);
        $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
        $clinicDetails['logo'] = (isset($clinicDetails['logo']) && $clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset('images/default_clinic.png');    
        $countryCodedetails = RefCountryCode::getCountryCodeById($clinicDetails['country_code']);
            $imagingcptCodes = RefLabTest::getImageinfCtp($imagingTestIds);
            $imagingcptCodes = $this->Corefunctions->getArrayIndexed1($imagingcptCodes, 'imaging_test_id');
          
            $cptIDS = $this->Corefunctions->getIDSfromArray($imagingcptCodes,'cpt_code_id');
            $cptCodes = RefLabTest::getCptCodes($cptIDS);
            $cptCodes = $this->Corefunctions->getArrayIndexed1($cptCodes, 'id');
        return view('appointment.imaging.orderprint', compact(
            'patientDetails',
            'userDetails',
            'orderLists',
            'userCountryCode',
            'cptCodes',
            'imagingcptCodes',
            'finalTestArray',
            'categoryDetails',
            'clinicDetails',
            'countryCodedetails'
        ));
    }

           

    public function startonBoarding(){
        $seo['title'] = "onBoarding | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('onboarding.startonboarding',compact('seo'));
    }
    public function patientOnboarding(){
        $seo['title'] = "onBoarding | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('onboarding.patientonboarding',compact('seo'));
    }
    
    public function onBoarding(){

        $onboardingSteps = RefOnboardingStep::getOnboardingSteps();
        $clinicId = session('user.clinicID');
        $userId   = session('user.userID') ; 
        $specialties = RefSpecialty::getSpeciality();
         // get clinic details
         $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));
         // get clinic details
         $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::getClinicUser($userId,$clinicId));
          // Fetch country ID from ref_country_codes table
         if ($clinicUserDetails['country_code'] != '') {
             $countryCodedetails = RefCountryCode::getCountryCodeById($clinicUserDetails['country_code']);
             $clinicUserDetails['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
             $clinicUserDetails['short_code'] = !empty($countryCodedetails) ? $countryCodedetails['short_code'] : null;
         }

        $seo['title'] = "onBoarding | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('onboarding.onboarding',compact('seo','onboardingSteps','clinicDetails','clinicUserDetails','specialties'));
    }

    public function validateNpiNumber(Request $request)
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;

        if (request()->ajax()) {

            $data = request()->all();
            $type = $data['type'];
            $hasData = '0';
            $existuserid = (isset($data['id'])) ? $data['id'] : '' ;
           
            $existuserdata  = ClinicUSer::where('npi_number',$data['npi_number'])->where('email','!=',$data['email'])->limit(1)->withTrashed()->first(); 
            if(!empty($existuserdata)  ) {
                $hasData ='1';
            }

            if ( $hasData == 1 ) {
                return 'false';
            } else {
                return 'true';
            }

        }

    }

}

