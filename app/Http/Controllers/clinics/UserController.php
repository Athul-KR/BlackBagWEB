<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Consultant;
use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\ClinicCard;
use App\Models\Nurse;
use App\Models\Otp;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\RefCountryCode;
use App\Models\RefSpecialty;
use App\Models\RefDesignation;
use App\Models\ImportDoc;
use App\Models\UserBilling;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Route;
class UserController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        // Middleware for session check
        $this->middleware(function ($request, $next) {
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
                return Redirect::to('/');
            }
            // Check if the session has the 'user' key (adjust as per your session key)
            $sessionCeck = $this->Corefunctions->validateUser();
            if (!$sessionCeck) {
                return Redirect::to('/logout');
            }
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
            $method = Route::current()->getActionMethod();
            /* Validate onboarding process */
            if(Session::has('user') && session()->get('user.userType') == 'doctor'){
                $onboardClinic = $this->Corefunctions->validateClincUserOnboarding();
                if(isset($onboardClinic ['success']) && $onboardClinic ['success'] == 1){
                    return Redirect::to('doctor/onboarding/contact-details');
                }
            }

            if(!in_array($method,array('enableAddOn','submitAddOn'))){
                if ($this->Corefunctions->validateClincOnboarding()) {
                    return Redirect::to('/onboarding/business-details');
                }

                 /* Validate onboarding process */
                if(Session::has('user') && session()->get('user.userType') == 'doctor' || ( session()->get('user.userType') == 'clinics' && session('user.licensed_practitioner') == 1) ){
                    $onboardClinic = $this->Corefunctions->validateClincUserOnboarding();
                    if(isset($onboardClinic ['success']) && $onboardClinic ['success'] == 1){
                        return Redirect::to('doctor/onboarding/contact-details');
                    }
                
                }
            }
            return $next($request);
        });
    }
    //  user list
    public function list(Request $request, $status = 'active')
    {
        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
        $userType = (isset($_GET['userType']) && ($_GET['userType'] != '')) ? $_GET['userType'] : '';
        $searchterm = (isset($_GET['searchterm']) && ($_GET['searchterm'] != '')) ? $_GET['searchterm'] : '';

        /* get users list */
        $clinicUserDetails = ClinicUser::getClinicUserList($status,$limit,$userType,$searchterm);
        

        $clinicUserList     = $clinicUserDetails['clinicUserList'] ; 
        $clinicUserData     = $clinicUserDetails['clinicUser'] ;
        $pendingcount       = $clinicUserDetails['pendingCount'] ;   
        $activecount        = $clinicUserDetails['activecount'] ; 
        $innactiveCount     = $clinicUserDetails['innactiveCount'] ; 
        
         /*jomy-phone number format */
        if(!empty($clinicUserData)){
            foreach($clinicUserData['data'] as $key => $user){
                $clinicUserData['data'][$key]['phone'] =  $this->Corefunctions->formatPhoneNumber($user['country_code'],$this->Corefunctions->formatPhone($user['phone_number']));
            }
        }
    
        $createdIds = $this->Corefunctions->getIDSfromArray($clinicUserData['data'], 'created_by');
        $updatedIds = $this->Corefunctions->getIDSfromArray($clinicUserData['data'], 'updated_by');
        $userIds = array_filter(array_merge($createdIds, $updatedIds));
        $usersList = ClinicUser::getAllClinicUsersByUserID($userIds) ;
        $usersList = $this->Corefunctions->getArrayIndexed1($usersList, 'user_id');
     
        $specialtyIds = $this->Corefunctions->getIDSfromArray($clinicUserData['data'], 'specialty_id');
        $specialtyIds = array_filter($specialtyIds);
        $specialtyList = RefSpecialty::getSpecialityByIDs($specialtyIds);
        $clientSecret = '';
     
        $userType =  User::getUserTypes();
        $userType = $this->Corefunctions->getArrayIndexed1($userType, 'id');
        
        $clinicId = session()->get('user.clinicID');
        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));

        $seo['title'] = "Users | " . env('APP_NAME');
        $seo['keywords'] = "Find a user Online, Healthcare Specialist Directory, Doctor Availability Status, Online Doctor Scheduling, create Doctors Easily, Book a Doctor Appointment Online, Consult with a Doctor, Specialized Medical Professionals, Online Healthcare Appointment, Book Appointment with Specialist, Expert Doctors for Your Needs";
        $seo['description'] = "Discover and book appointments with qualified doctors online. Check doctor availability and schedule your appointment at your convenience. Ideal for patients looking for trusted medical professionals and hassle-free doctor consultations";
        $seo['og_title'] = "Doctors | " . env('APP_NAME');
        $seo['og_description'] = "Discover and book appointments with qualified doctors online. Check doctor availability and schedule your appointment at your convenience. Ideal for patients looking for trusted medical professionals and hassle-free doctor consultations";

        // Return view with all the necessary data
        return view('users.listing', compact('clinicUserDetails','seo','clinicUserList','clinicUserData','pendingcount','activecount','innactiveCount','status','limit','usersList','specialtyList','clientSecret','userType','clinicDetails'));
    }

    // add user
    public function create(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
          
            // Check if data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $designationDetails = $specialities = array();
            // Fetch country details
            $countryDetails = User::getCountryCodes();
            // Fetch state details
            $stateDetails = User::getStates();
            $designationDetails = User::getDesignations();
            $specialities = User::getSpecialities();

            $userType =  User::getUserTypes();

            $data['userType']           = $userType;
            $data['countryDetails']     = $countryDetails;
            $data['stateDetails']       = $stateDetails;
            $data['specialities']       = $specialities;
            $data['designation']        = $designationDetails;

            $html = view('users.create', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
     

    // store users
    public function store(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
          
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            $input['phone_number'] = str_replace(["(", ")", " ","-"], "", $input['phone_number']);

            // Fetch country ID from ref_country_codes table
            $countryCode = RefCountryCode::getCountryCodeByShortCode($input['countrycode']);
            /* get user details */
            $userDetails = User::getUserByPhone($input,$countryCode['id']);


            $isValid = $this->Corefunctions->validateClinicUser($input,$countryCode['id']);
            if(isset($isValid['error'])){
                return response()->json([
                    'status' => 1,
                    'message' => $isValid['message'],
                ]);
            }
            /** Inset info to clinic users info  */
            $clinicUserKey = $this->Corefunctions->generateUniqueKey("10", "clinic_users", "clinic_user_uuid");
            $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');

            $input['first_name']    =  $input['username'];
            $input['user_phone']    = $input['phone_number'];
            $input['user_email']    = $input['email'];
            $input['invitationkey'] = $invitationkey ;

            if (empty($userDetails)) {
              
                $userID = User::insertUser($input,$countryCode,null,'-1');
            } else {
                $userID = $userDetails['id'];
            }
            $username =  $input['first_name'].' '. $input['last_name'];
            $code = $this->Corefunctions->generateClinicianCode(session()->get('user.clinicName'),$username);
            $clinicUser = ClinicUser::insertClinicUser($input,$countryCode,$userID,session()->get('user.clinicID'),'-1',session()->get('user.userID'),$code);
            $clinicUserID = $clinicUser['clinicID'];
            $key = $clinicUser['clinic_user_uuid'];

            /* clinic Image Upload */
            if (isset($input['tempimage']) && $input['tempimage'] != "") {
                $this->Corefunctions->uploadImage($input,$userID,'clinic_users',$clinicUserID,$key);
            }

            /** Invitation mail */
            $clinic = Clinic::clinicByID(session()->get('user.clinicID'));

            $doctorDetails = ClinicUser::getUserByUserId(session()->get('user.userID'),session()->get('user.clinicID'));

            /** Invitation mail */
            $data['name']   = $username;
            $data['clinic'] = $clinic->name;
            $data['cliniclogo'] = ($clinic->logo != '') ? $this->Corefunctions->resizeImageAWS($clinic->id,$clinic->logo,$clinic->name,180,180,'1') : asset("images/default_clinic.png"); 
            $data['email']  = $input['email'];
            $data['clinicianname']  = $this->Corefunctions->showClinicanName($doctorDetails,'1');
            $data['link']   = url('invitation/' . 'c_' . $invitationkey);
            if(isset($input['user_type_id'])  && ($input['user_type_id'] =='2' || ($input['user_type_id'] =='1'  )  ) ){
                /** email template update for doc invitaion -onbording BB-348 */
                $data['link']   = url('register?invitationkey=' . 'c_' . $invitationkey); 
                $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.doctorinvitation');

            }else{
                $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.userinvitation');

            }
           
            $arr['success'] = 1;
            $arr['message'] = 'Invitation sent successfully';
            return response()->json($arr);
            exit();
        }
    }
    public function resendInvitation(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $clinicUserDetails = ClinicUser::userByUUID($data['key']);
            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid Data');
            }
            if($clinicUserDetails->status == '1'){
                return redirect('/users');
            }
            $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');
            /* update invitationkey */
            ClinicUser::updateClinicInvitation($invitationkey,$clinicUserDetails->id);
         
            $clinic = Clinic::clinicByID(session()->get('user.clinicID'));

            $doctorDetails = ClinicUser::getUserByUserId(session()->get('user.userID'),session()->get('user.clinicID'));
          
            /** Invitation mail */
            $data['clinic'] = $clinic->name;
            $data['name'] = isset($clinicUserDetails->user_type_id)  && ( $clinicUserDetails->user_type_id == '2' || ($clinicUserDetails->user_type_id == '1') ) ? $this->Corefunctions->showClinicanName($clinicUserDetails,'0') : $clinicUserDetails->first_name.' '.$clinicUserDetails->last_name ;
            $data['email'] = $clinicUserDetails->email;
            $data['clinicianname']  = $this->Corefunctions->showClinicanName($doctorDetails,'1');
            $data['link'] = url('invitation/' . 'c_' . $invitationkey);
            $data['cliniclogo'] = ($clinic->logo != '') ? $this->Corefunctions->resizeImageAWS($clinic->id,$clinic->logo,$clinic->name,180,180,'1') : asset("images/default_clinic.png"); 
           
            if(isset($clinicUserDetails->user_type_id)  && ( $clinicUserDetails->user_type_id == '2' || ($clinicUserDetails->user_type_id == '1') )){
               
                /** email template update for doc invitaion -onbording BB-348 */
                $data['link']   = url('register?invitationkey=' . 'c_' . $invitationkey); 
                $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.doctorinvitation');
            }else{
               
                $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.userinvitation');
            }
           

            $arr['response'] = $response;
            $arr['success'] = 1;
            $arr['message'] = 'Invitation resent successfully';
            return response()->json($arr);
            exit();
        }
    }
    public function delete()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            if ($data['status'] == 'activate') {
                ClinicUser::onlyTrashed()->where('clinic_user_uuid', $data['key'])->restore();
                $arr['message'] = 'User activated successfully.';
            } else {
                $docclinic = ClinicUser::userByUUID($data['key']) ;
                $appointmentDetails = Appointment::userAppointment($docclinic->id);
                if(!empty($appointmentDetails)){
                    $arr['success'] = 0;
                    $arr['message'] = 'The user cannot be deleted, they have an active appointment. Please cancel the appointment before proceeding.';
                    return response()->json($arr);
                    exit();
                }
                $adminCount = ClinicUser::where('clinic_id', session()->get('user.clinicID'))->where('user_type_id', '1')->count();
                if ($adminCount <= 1 && $docclinic->user_type_id == '1') {
                    $arr['success'] = 0;
                    $arr['message'] = 'The clinic requires one admin user.';
                    return response()->json($arr);
                    exit();
                }
                ClinicUser::delecteclinicUse($data['key']) ;
               

                $arr['message'] = 'User deactivated successfully.';
            }

            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function edit(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                return $this->Corefunctions->returnError('Fields missing');
            }
          
            /** get user details */
            $userDetails = ClinicUser::getClinicUserByKey($data['key']) ;
            if (empty($userDetails)) {
                return $this->Corefunctions->returnError('Invalid data');
            }
            if($userDetails['clinic_id'] != session()->get('user.clinicID')){
                return $this->Corefunctions->returnError('Permission denied');
            }
            $userDetails['logo_path'] =  $userDetails['status'] == '1' && ($userDetails['user']['profile_image'] != '') ? $this->Corefunctions->resizeImageAWS($userDetails['user_id'],$userDetails['user']['profile_image'],$userDetails['user']['first_name'],180,180,'1') : (($userDetails['logo_path'] != '') ? $this->Corefunctions-> resizeImageAWS($userDetails['id'],$userDetails['logo_path'],$userDetails['name'],180,180,'1') : '');
            // Fetch country ID from ref_country_codes table
            if ($userDetails['country_code'] != '') {
                $countryCodedetails = RefCountryCode::getCountryCodeById($userDetails['country_code']);
                $userDetails['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
                $userDetails['short_code'] = !empty($countryCodedetails) ? $countryCodedetails['short_code'] : null;
            }

            $designationDetails = User::getDesignations();
            $specialties = User::getSpecialities();
            /** check another admin exists or nt  */
            $isAdmins = ClinicUser::getClinicAdmin($data['key']);
            $stateDetails = User::getStates();

            $userType =  User::getUserTypes();

            $data['userType']           = $userType;
            $data['stateDetails'] = $stateDetails;
            $data['specialties'] = $specialties;
            $data['isAdmins'] = $isAdmins;
            $data['designation'] = $designationDetails;
            $data['userDetails'] = $userDetails;
            $html = view('users.edit', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function update(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
           
      
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            // Check if form data is empty
            if (!($data['key'])) {
                return $this->Corefunctions->returnError('Key missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            $input['phone_number'] = str_replace(["(", ")", " ","-"], "", $input['phone_number']);

            /** check clinic user exists */
            $clinicUserDetails = ClinicUser::userByUUID($data['key']); 

            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid user');
            }
            /* get user appointment details */
            $isadminexist = User::checkAdminExist($clinicUserDetails->id);
            if($isadminexist <= 0 && $input['user_type_id'] != $clinicUserDetails->user_type_id){
                $arr['success'] = 0;
                $arr['message'] = 'You cannot change the user type as there are no other admins assigned to this clinic. ';
                return response()->json($arr);
                exit();
           
            }
            $appointmentDetails =  Appointment::userAppointment($clinicUserDetails->id) ;
            if(!empty($appointmentDetails) && $input['user_type_id'] != $clinicUserDetails->user_type_id){
                $arr['success'] = 0;
                $arr['message'] = 'The user type cannot be changed, they have an active appointment. Please cancel the appointment before proceeding.';
                return response()->json($arr);
                exit();
            }
            $input['crppath'] = (isset($clinicUserDetails->logo_path) && ($clinicUserDetails->logo_path != '')) ? $clinicUserDetails->logo_path : '';
            if ($input['isremove'] == 1) {
                $input['crppath'] = '';

            }
            $countryCode = RefCountryCode::getCountryCodeByShortCode($input['countrycode']);
            $isValid = $this->Corefunctions->validateClinicUser($input,$countryCode['id'],$clinicUserDetails);
            if(isset($isValid['error'])){
                return response()->json([
                    'status' => 1,
                    'message' => $isValid['message'],
                ]);
            }
            $userDetails = User::userByID($clinicUserDetails->user_id,'all');
            /* Update User In Dosespot */
         
            $clinicUserDets = $this->Corefunctions->convertToArray($clinicUserDetails);
            $clinicUserDets['specialty_id'] = (isset($input['speciality']) && $input['speciality'] != '') ? $input['speciality']: $clinicUserDets['specialty_id'];
            $clinicUserDets['npi_number']   = (isset($input['npi_number'])  && $input['npi_number'] != '') ? $input['npi_number'] : $clinicUserDets['npi_number'];
            $clinicUserDets['designation_id']   = (isset($input['designation'])  && $input['designation'] != '') ? $input['designation'] : $clinicUserDets['designation_id'];
            //print_r($input);die;
            $userDets                       = array();
            $userDets['first_name']         = $input['username'];
            $userDets['last_name']          = isset($input['last_name']) ? $input['last_name'] : null;
            $userDets['email']              = isset($input['email']) ? $input['email'] : null;
            $userDets['phone_number']       = isset($input['phone_number']) ? $input['phone_number'] : null;
            $userDets['country_code']       = !empty($countryCode) ? $countryCode['id'] : $userDetails->country_code;
            $userDets['address']            = (isset($input['address']) && $input['address'] != '')  ? $input['address'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->address);
            $userDets['city']               = (isset($input['city']) && $input['city'] != '')  ? $input['city'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->city);
            $userDets['zip_code']           = (isset($input['zip']) && $input['zip'] != '')  ? $input['zip'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->zip_code);
            $userDets['state']              = ($userDetails->address == '') && isset($input['state']) && ($input['state'] != '')  ? $input['state'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->state);
            $userDets['state_id']          = ($userDetails->address == '') && isset($input['state_id']) && ($input['state_id'] != '') ? $input['state_id'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->state_id);
            $userDets['dob']               = (isset($input['dob']) && $input['dob'] != '') ? date('Y-m-d', strtotime($input['dob'])) : $userDetails->dob;  
            $userDets['fax']               = (isset($input['fax']) && $input['fax'] != '') ? $input['fax'] : $userDetails->fax;  
            $userDets['dosespot_clinician_id']               = $userDetails->dosespot_clinician_id;  
      
            if( isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] == 'on' ){
                $clinicId = session()->get('user.clinicID');

                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
                if(  $clinicUserDets['eprescribe_enabled'] == '1' && $clinicDetails['dosepot_id'] !== null  ){
                  if( $userDetails->dosespot_clinician_id !== null ){  
                        if( !empty($userDets)){
                            $response       = $this->Corefunctions->editClinicUserDoseSpot($clinicUserDets,$userDets);
                            if( !empty($response) && $response['success'] == 0 && isset($response['errors']) ){
                                $arr['success'] = 0;
                                $arr['message'] = $response['errors'];
                                return response()->json($arr);
                                exit();
                             }
                        }
                    }else{
                      $clientUserResponse = $this->Corefunctions->createClinicUserDoseSpot($clinicUserDets,$userDets);
                      if( !empty($clientUserResponse) && $clientUserResponse['success'] == 0 && isset($clientUserResponse['errors']) ){
                            $arr['success'] = 0;
                            $arr['message'] = $clientUserResponse['errors'];
                            return response()->json($arr);
                            exit();
                      }
                  }
                    
                }
            }
        
            if($clinicUserDetails->is_licensed_practitioner == '1' && !isset($input['is_licensed_practitioner']) ){
                $clinicId = session()->get('user.clinicID');
                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
                if(  $clinicUserDetails->eprescribe_enabled == '1' && $clinicDetails['dosepot_id'] !== null ){
                    $clientUserResponse = $this->Corefunctions->removeClinicUserDoseSpot($clinicUserDets,$userDets);
                    if( !empty($clientUserResponse) && $clientUserResponse['success'] == 0 && isset($clientUserResponse['errors']) ){
                            $arr['success'] = 0;
                            $arr['message'] = $clientUserResponse['errors'];
                            return response()->json($arr);
                            exit();
                      }
                }
            }
            
            /* update details */
            clinicUser::updateClinicUsersEdit($input,$countryCode,$clinicUserDetails);

            $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::userByUUID($data['key']));
            $licensedPractitioner = (isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] == 'on') ? '1' : '0';
            if($clinicUserDetails['clinic_user_uuid'] == Session::get('user.clinicuser_uuid')){
                $firstName = $this->Corefunctions->showClinicanName($clinicUserDetails,'1');
                $lastName = $clinicUserDetails['last_name'];
                session()->put('user.firstName', $firstName);
                session()->put('user.lastName', $lastName);
                session()->put('user.licensed_practitioner', $licensedPractitioner);
            }
            
            if (!empty($userDetails)) {
                /*update to user table also */
                User::updateUserData($input,$countryCode,$userDetails);
            }
            
       
            
            /* user Image Upload */
            if (isset($input['tempimage']) && $input['tempimage'] != "") {
                $this->Corefunctions->uploadImage($input,$clinicUserDetails['user_id'],'clinic_users',$clinicUserDetails['id'],$clinicUserDetails['clinic_user_uuid']);
            }

            $clinicUserDetails = ClinicUser::getClinicUserByKey($data['key']);
            // update session if logged in user
            if (session()->get('user.clinicuser_uuid') == $clinicUserDetails['clinic_user_uuid']) { 
                $userLogo = isset($image_path) && $image_path != '' ? $this->Corefunctions->getAWSFilePath($image_path) : (($clinicUserDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicUserDetails['logo_path']) : '');
                $userName = (isset($input['user_type_id']) && $input['user_type_id'] != '3') ? $this->Corefunctions->showClinicanName($clinicUserDetails,1) : $input['username'];

                Session::put("user.firstName", $userName);
                Session::put("user.email", $input['email']);
                Session::put("user.phone", $input['phone_number']);
                Session::put("user.userLogo", $userLogo);
            }
            $arr['success'] = 1;
            $arr['message'] = 'User details updated successfully';
            return response()->json($arr);
            exit();
        }
    }
    public function updateProfile(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
           
      
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            // Check if form data is empty
            if (!($data['key'])) {
                return $this->Corefunctions->returnError('Key missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            $input['phone_number'] = str_replace(["(", ")", " ","-"], "", $input['phone_number']);

            /** check clinic user exists */
            $clinicUserDetails = ClinicUser::userByUUID($data['key']); 

            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid user');
            }
            /* get user appointment details */
            $isadminexist = User::checkAdminExist($clinicUserDetails->id);
            if($isadminexist <= 0 && $input['user_type_id'] != $clinicUserDetails->user_type_id){
                $arr['success'] = 0;
                $arr['message'] = 'You cannot change the user type as there are no other admins assigned to this clinic. ';
                return response()->json($arr);
                exit();
           
            }
            $appointmentDetails =  Appointment::userAppointment($clinicUserDetails->id) ;
            if(!empty($appointmentDetails) && $input['user_type_id'] != $clinicUserDetails->user_type_id){
                $arr['success'] = 0;
                $arr['message'] = 'The user type cannot be changed, they have an active appointment. Please cancel the appointment before proceeding.';
                return response()->json($arr);
                exit();
            }
            $input['crppath'] = (isset($clinicUserDetails->logo_path) && ($clinicUserDetails->logo_path != '')) ? $clinicUserDetails->logo_path : '';
            if ($input['isremove'] == 1) {
                $input['crppath'] = '';

            }
            $countryCode = RefCountryCode::getCountryCodeByShortCode($input['countrycode']);
            $isValid = $this->Corefunctions->validateClinicUser($input,$countryCode['id'],$clinicUserDetails);
            if(isset($isValid['error'])){
                return response()->json([
                    'status' => 1,
                    'message' => $isValid['message'],
                ]);
            }
            $userDetails = User::userByID($clinicUserDetails->user_id,'all');
            /* Update User In Dosespot */
         
            $clinicUserDets = $this->Corefunctions->convertToArray($clinicUserDetails);
            $clinicUserDets['specialty_id'] = (isset($input['speciality']) && $input['speciality'] != '') ? $input['speciality']: $clinicUserDets['specialty_id'];
            $clinicUserDets['npi_number']   = (isset($input['npi_number'])  && $input['npi_number'] != '') ? $input['npi_number'] : $clinicUserDets['npi_number'];
            $clinicUserDets['designation_id']   = (isset($input['designation'])  && $input['designation'] != '') ? $input['designation'] : $clinicUserDets['designation_id'];
            //print_r($input);die;
            $userDets                       = array();
            $userDets['first_name']         = $input['username'];
            $userDets['last_name']          = isset($input['last_name']) ? $input['last_name'] : null;
            $userDets['email']              = isset($input['email']) ? $input['email'] : null;
            $userDets['phone_number']       = isset($input['phone_number']) ? $input['phone_number'] : null;
            $userDets['country_code']       = !empty($countryCode) ? $countryCode['id'] : $userDetails->country_code;
            $userDets['address']            = (isset($input['address']) && $input['address'] != '')  ? $input['address'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->address);
            $userDets['city']               = (isset($input['city']) && $input['city'] != '')  ? $input['city'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->city);
            $userDets['zip_code']           = (isset($input['zip']) && $input['zip'] != '')  ? $input['zip'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->zip_code);
            $userDets['state']              = ($userDetails->address == '') && isset($input['state']) && ($input['state'] != '')  ? $input['state'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->state);
            $userDets['state_id']          = ($userDetails->address == '') && isset($input['state_id']) && ($input['state_id'] != '') ? $input['state_id'] : ((!empty($countryCode) && $countryCode['id']!= $userDetails->country_code) ? NULL : $userDetails->state_id);
            $userDets['dob']               = (isset($input['dob']) && $input['dob'] != '') ? date('Y-m-d', strtotime($input['dob'])) : $userDetails->dob;  
            $userDets['fax']               = (isset($input['fax']) && $input['fax'] != '') ? $input['fax'] : $userDetails->fax;  
            $userDets['dosespot_clinician_id']               = $userDetails->dosespot_clinician_id;  
      
            if( isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] == 'on' ){
                $clinicId = session()->get('user.clinicID');

                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
                if(  $clinicUserDets['eprescribe_enabled'] == '1' && $clinicDetails['dosepot_id'] !== null  ){
                  if( $userDetails->dosespot_clinician_id !== null ){  
                        if( !empty($userDets)){
                            $response       = $this->Corefunctions->editClinicUserDoseSpot($clinicUserDets,$userDets);
                            if( !empty($response) && $response['success'] == 0 && isset($response['errors']) ){
                                $arr['success'] = 0;
                                $arr['message'] = $response['errors'];
                                return response()->json($arr);
                                exit();
                             }
                        }
                    }else{
                      $clientUserResponse = $this->Corefunctions->createClinicUserDoseSpot($clinicUserDets,$userDets);
                      if( !empty($clientUserResponse) && $clientUserResponse['success'] == 0 && isset($clientUserResponse['errors']) ){
                            $arr['success'] = 0;
                            $arr['message'] = $clientUserResponse['errors'];
                            return response()->json($arr);
                            exit();
                      }
                  }
                    
                }
            }
        
            if($clinicUserDetails->is_licensed_practitioner == '1' && !isset($input['is_licensed_practitioner']) ){
                $clinicId = session()->get('user.clinicID');
                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
                if(  $clinicUserDetails->eprescribe_enabled == '1' && $clinicDetails['dosepot_id'] !== null ){
                    $clientUserResponse = $this->Corefunctions->removeClinicUserDoseSpot($clinicUserDets,$userDets);
                    if( !empty($clientUserResponse) && $clientUserResponse['success'] == 0 && isset($clientUserResponse['errors']) ){
                            $arr['success'] = 0;
                            $arr['message'] = $clientUserResponse['errors'];
                            return response()->json($arr);
                            exit();
                      }
                }
            }
            
            /* update details */
            clinicUser::updateClinicUsers($input,$countryCode,$clinicUserDetails);

            $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::userByUUID($data['key']));
            $licensedPractitioner = (isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] == 'on') ? '1' : '0';
            if($clinicUserDetails['clinic_user_uuid'] == Session::get('user.clinicuser_uuid')){
                $firstName = $this->Corefunctions->showClinicanName($clinicUserDetails,'1');
                $lastName = $clinicUserDetails['last_name'];
                session()->put('user.firstName', $firstName);
                session()->put('user.lastName', $lastName);
                session()->put('user.licensed_practitioner', $licensedPractitioner);
            }
            
            if (!empty($userDetails)) {
                /*update to user table also */
                User::updateUserData($input,$countryCode,$userDetails);
            }
            
       
            
            /* user Image Upload */
            if (isset($input['tempimage']) && $input['tempimage'] != "") {
                $this->Corefunctions->uploadImage($input,$clinicUserDetails['user_id'],'clinic_users',$clinicUserDetails['id'],$clinicUserDetails['clinic_user_uuid']);
            }

            $clinicUserDetails = ClinicUser::getClinicUserByKey($data['key']);
            // update session if logged in user
            if (session()->get('user.clinicuser_uuid') == $clinicUserDetails['clinic_user_uuid']) { 
                $userLogo = isset($image_path) && $image_path != '' ? $this->Corefunctions->getAWSFilePath($image_path) : (($clinicUserDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicUserDetails['logo_path']) : '');
                $userName = (isset($input['user_type_id']) && $input['user_type_id'] != '3') ? $this->Corefunctions->showClinicanName($clinicUserDetails,1) : $input['username'];

                Session::put("user.firstName", $userName);
                Session::put("user.email", $input['email']);
                Session::put("user.phone", $input['phone_number']);
                Session::put("user.userLogo", $userLogo);
            }
            $arr['success'] = 1;
            $arr['message'] = 'User details updated successfully';
            return response()->json($arr);
            exit();
        }
    }
    public function import(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            $html = view('users.import', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function importUsers(Request $request,$type)
    {
        if ($request->ajax()) {
            $userTypeArray = array('clinic' => '1','doctor' => '2','nurse' => '3');
            if ($request->hasFile('file')) {
                try {
                    // Load the uploaded file
                    $file = $request->file('file');
                    $spreadsheet = IOFactory::load($file->getPathname()); // Load the spreadsheet
                    $sheet = $spreadsheet->getActiveSheet(); // Retrieve the active sheet
                    $data = $sheet->toArray(); // Convert the sheet to an array

                    $validRecords = []; // For valid records
                    $errorRecords = []; // For records with errors (existing emails)

                    // Check if the file contains valid data (excluding headers and empty rows)
                    $nonEmptyRows = array_filter($data, function ($row) {
                        // Skip rows with no content
                        return !empty(array_filter($row));
                    });
                    // Define the required columns
                    if($type == 'nurse'){
                        $requiredColumns = ['name', 'email', 'department', 'specialty', 'phone', 'country code'];
                    }else{
                        $requiredColumns = ['name', 'email', 'designation', 'specialty','npi number','phone', 'country code'];
                    }
                    $headers = array_map('strtolower', $data[0]);
                    // Get the first row as headers

                    // Check if all required columns are present
                    $missingColumns = array_diff($requiredColumns, $headers);

                    // If any required columns are missing, return an error
                    if (!empty($missingColumns)) {
                        $arr['error'] = 1;
                        $arr['message'] = 'The uploaded file is missing the following columns: ' . implode(', ', $missingColumns);
                        return response()->json($arr);
                    }
                    // If only the header or empty file, return error message
                    if (count($nonEmptyRows) <= 1) { // Assuming the first row is the header
                        $arr['error'] = 1;
                        $arr['message'] = 'The uploaded file does not contain any valid data.';

                        return response()->json($arr);
                    }
                    $nonEmptyRows = array_slice($data, 1);
                    $invalidEmails = [];
                    foreach ($nonEmptyRows as $index => $row) {
                        $row = array_combine($headers, $row); // Map row values to header keys for easier access
                        if (!empty($row['email']) && !filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                            $invalidEmails[] = $row['email'];
                        }
                    }

                    // Check if there are invalid emails
                    if (!empty($invalidEmails)) {
                        $arr['error'] = 1;
                        $arr['message'] = 'The uploaded file contains invalid email addresses: ' . implode(', ', $invalidEmails);
                        return response()->json($arr);
                    }
                    $importDocIDs = array();
                    $import_key = $this->Corefunctions->generateUniqueKey('10', 'import_docs', 'import_key');
                    foreach ($data as $index => $row) {

                        if ($index === 0 || empty(array_filter($row))) {
                            continue; // Skip header or empty rows
                        }
                        $countrycode = ($type == 'nurse') ? (isset($row[5]) ? trim($row[5]) : '') : (isset($row[6]) ? trim($row[6]) : '') ;
                        $countryCodedetails = RefCountryCode::getCountryCodeByCode($countrycode);

                        $insertArr = array();
                        /* array for insertion */
                        $insertArr['import_doc_uuid'] = $this->Corefunctions->generateUniqueKey("10", "import_docs", "import_doc_uuid");
                        $insertArr['name']            = isset($row[0]) ? trim($row[0]) : ''; // Adjust according to the column index
                        $insertArr['email']           = isset($row[1]) ? trim($row[1]) : '';
                        if($type == 'nurse'){
                            $insertArr['department']  = isset($row[2]) ? trim($row[2]) : '';
                        }else{
                            $insertArr['designation'] = isset($row[2]) ? trim($row[2]) : '';
                        }
                        $insertArr['specialty']        = isset($row[3]) ? trim($row[3]) : '';
                        $insertArr['npi_number']        = isset($row[4]) ? trim($row[4]) : '';
                        $insertArr['phone_number']     = ($type == 'nurse') ?  (isset($row[4]) ? trim($row[4]) : '') : (isset($row[5]) ? trim($row[5]) :'');
                        $insertArr['country_code']     = !empty($countryCodedetails) ? $countryCodedetails['id'] : null;
                        $insertArr['userID']           = session()->get('user.userID');
                        $insertArr['type']             = 1;

                        if($type != 'nurse'){
                            $designation              = RefDesignation::fetchDesignation($insertArr['designation']) ;
                            $insertArr['designation'] = !empty($designation) ? $designation['id'] : null;
                        }
                        $specialties            = RefSpecialty::fetchSpeciality($insertArr['specialty']);
                        $insertArr['specialty'] = !empty($specialties) ? $specialties['id'] : null;

                        // Check if email exists in users table
                        // not needed ;
                        // $existingDoctr = ClinicUser::where('phone_number', $insertArr['phone_number'])->where('user_type_id', $userTypeArray[$type])->where('clinic_id', session()->get('user.clinicID'))->first();
                        
                        // if (!empty($existingUser) ) {
                        $insertArr['error'] = '';

                        /** Check all fields are exists */
                        foreach ($requiredColumns as $columnName) {
                            $columnIndex = array_search($columnName, $headers);
                            $rowData[$columnName] = isset($row[$columnIndex]) ? trim($row[$columnIndex]) : null;
                            if (empty($rowData[$columnName])) {
                                $insertArr['status'] = '-1';
                                $insertArr['error'] .= 'The uploaded file does not contain valid data for ' . $columnName . '. ';
                                $errorRecords[] = $insertArr;

                                $isRecordValid = false; // Mark record as invalid
                                break; // Exit the loop and go to the next record
                            }
                        }
                        $input['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['short_code'] : null;
                        $input['phone_number'] = $insertArr['phone_number'] ;
                        $input['email']        = $insertArr['email'] ;
                        
                        $isValidUser = $this->Corefunctions->validateUserPhone($input);
                        if (isset($isValidUser['error']) && $isValidUser['error'] == 1 ) {
                            // If email exists, add to error records
                            $insertArr['status']            = '-1';
                            // $insertArr['is_exists'] = 1;
                            $insertArr['error'] .= $isValidUser['message'];
                        }
                        if ($type != 'nurse' && empty($designation)) {
                            $insertArr['status'] = '-1';
                            $insertArr['error'] .= 'Provided designation is not in our system.';
                        }
                        if (empty($specialties)) {
                            $insertArr['status'] = '-1';
                            $insertArr['error'] .= 'Provided specialty is not in our system.';
                        }
                        if (empty($countryCodedetails)) {
                            $insertArr['status'] = '-1';
                            $insertArr['error'] .= 'Invalid country code details are entered.';
                        }
                        /* npi validation */
                        if ($type != 'nurse' ) {

                            if (!preg_match('/^\d{10}$/', $insertArr['npi_number'])) {
                                $insertArr['status'] = '-1';
                                $insertArr['error'] .= 'NPI Number must be a 10-digit number. ';
                            }else{
                                $existuserdata  = ClinicUSer::where('npi_number',$insertArr['npi_number'])->where('email','!=',$insertArr['email'])->limit(1)->withTrashed()->first(); 
                                if(!empty($existuserdata)  ) {
                                    $insertArr['status'] = '-1';
                                    $insertArr['error'] .= 'NPI Number already exist. ';
                                }
                            }
                        }
                        if($type == 'nurse'){
                            $importDocID = Nurse::insertConsultantExcelData($insertArr, $import_key, session()->get('user.clinicID'));
                        }else{
                            $importDocID = Consultant::insertConsultantExcelData($insertArr, $import_key, session()->get('user.clinicID'));
                        }

                    }

                    // Return a preview page with both valid and error records
                    $arr['success'] = 1;
                    $arr['message'] = 'Preview the uploaded file.';
                    $arr['import_key'] = $import_key;

                    return response()->json($arr);
                } catch (\Exception $e) {
                    // Rollback the transaction in case of an error
                    DB::rollBack();
                    return response()->json(['error' => 'Error importing users: ' . $e->getMessage()], 500);
                }
            }
        }
    }

    public function excelPreview($importKey,$type)
    {
        return view('users.excelpreview', compact('importKey','type'));
    }
    /* preview for uploaded file ajax */
    public function importPreview(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }
            $importKey    = $data['importKey'];
            $userType     = $data['userType'];
            $lastImportID = (isset($data['lastExportID']) && ($data['lastExportID'] != '0')) ? $data['lastExportID'] : '0' ;
            /** Get the imported exel data  */
            $excelDetails = ImportDoc::getImportDocs($importKey,$lastImportID);
         
            $lastExportID = 0;
            $hasdata      = 0;
            if (!empty($excelDetails)) {
                foreach ($excelDetails as $cdkey => $cdvalue) {
                    $lastExportID = $cdvalue['id'];
                }
                $hasdata = 1;
            }

            /** get designation ids  */
            $designationIds = $this->Corefunctions->getIDSfromArray($excelDetails,'designation_id');
            $designationDeatils = RefDesignation::getDesignationByIDS($designationIds) ;
           
            /** get specialty ids  */
            $specialtyIds = $this->Corefunctions->getIDSfromArray($excelDetails,'specialty_id');
            $specialtyDetails = RefSpecialty::getSpecialityByIDs($specialtyIds);
          
            /** get countryIds */
            $countrycodeIds     = $this->Corefunctions->getIDSfromArray($excelDetails,'country_code');
            $countryCodedetails = RefCountryCode::getCountryCodeByIDS($countrycodeIds) ;

            $data['lastExportID'] = $lastExportID;
            $data['designationDeatils'] = $designationDeatils;
            $data['specialtyDetails'] = $specialtyDetails;
            $data['excelDetails'] = $excelDetails;
            $data['importKey'] = $importKey;
            $data['countryCodedetails'] = $countryCodedetails;
            $data['userType'] = $userType;
            $html = view('users.preview', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['hasdata'] = $hasdata;
            return response()->json($arr);
            exit();
        }
    }

    /** Store imported data of users */

    public function storePreview(Request $request)
    {

        if ($request->ajax()) {

            $data = request()->all();
            $userTypeArray = array('clinic' => '1','doctor' => '2','nurse' => '3');

            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Data missing',
                ]);
            }
            $importDocList = ImportDoc::getImportDocsByKey($data['importKey']);
        
            if (!empty($importDocList)) {
                foreach ($importDocList as $index => $row) {
                    $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');

                    /** get user details */
                    $countryCodeID =  isset($row['country_code']) && $row['country_code'] != '' ? $row['country_code'] : null;
                    $userDetails = User::getUserByPhone($row,$countryCodeID);
                   
                    $clinicUser = ClinicUser::clinicUserByPhone($row['phone_number'],$countryCodeID) ;
                    if (!empty($userDetails)) {
                        $userID = $userDetails['id'];
                        /** if the importred user already exists then update the user details */
                        if ($row['is_exists'] == '1') {
                            $userDetails->first_name = $row['name'];
                            $userDetails->email = $row['email'];
                            $userDetails->update();
                            $userID = $userDetails['id'];
                        }
                    }
                  
                    if (!empty($clinicUser)) {
                        if ($row['is_exists'] == '1') {
                            $row['username']  = $row['name'];
                            $row['user_type_id']  =  $userTypeArray[$data['userType']];
                            $row['designation'] = isset($row['designation_id']) && $row['designation_id'] != '' ? $row['designation_id'] : null;
                            $row['speciality']  = $row['specialty_id'];
                            $row['npi_number'] = isset($row['npi_number']) && $row['npi_number'] != '' ? $row['npi_number'] : null;
                            $countryCode['id'] = isset($row['country_code']) && $row['country_code'] != '' ? $row['country_code'] : null;
                            ClinicUser::updateClinicUsers($row,$countryCode,$clinicUser) ;
                        }
                        
                    
                    } else {
                        /** Inset clinic users Consultant info  */
                        $input['name']  = $row['name'];
                        $fullName = isset($row['name']) ? trim($row['name']) : '';
                        $nameParts = explode(' ', $fullName, 2);

                        $input['first_name'] = $nameParts[0] ?? null;
                        $input['last_name'] = $nameParts[1] ?? null;
                        $rawPhone = isset($row['phone_number']) ? $row['phone_number'] : null;
                        $input['user_phone'] = $rawPhone ? preg_replace('/\D/', '', $rawPhone) : null;
                        $input['user_email']  = $row['email'];
                        $input['department']  = isset($row['department']) && $row['department'] != '' ? $row['department'] : null;
                        $input['qualification'] = isset($row['qualification'])  ? $row['qualification'] : null;
                        $input['user_type_id']  =  $userTypeArray[$data['userType']];
                        $input['designation'] = isset($row['designation_id']) && $row['designation_id'] != '' ? $row['designation_id'] : null;
                        $input['speciality']  = $row['specialty_id'];
                        $input['npi_number'] = isset($row['npi_number']) && $row['npi_number'] != '' ? $row['npi_number'] : null;
                        $input['invitationkey'] = $invitationkey;
                        $input['is_licensed_practitioner'] = 'on'; 
                        $userCountryCode['id']  =  isset($row['country_code']) && $row['country_code'] != '' ? $row['country_code'] : null;
                   
                        if (empty($userDetails)) {
                            /* insert to user */
                            $userID = User::insertUser($input,$userCountryCode,'','-1') ;
                        }
                         /** Invitation mail */
                         $clinic = Clinic::where('id', session()->get('user.clinicID'))->first();

                        $code = $this->Corefunctions->generateClinicianCode($clinic->name,$input['first_name']);
                        /* Inset clinic users Consultant info  */
                        $clinicUser = ClinicUser::insertClinicUser($input,$userCountryCode,$userID,session()->get('user.clinicID'),'-1',session()->get('user.userID'),$code);

                       

                        $doctorDetails = ClinicUser::getUserByUserId(session()->get('user.userID'),session()->get('user.clinicID'));
                        
                        $data['clinic'] = $clinic->name;
                        $data['name'] = $row['name'];
                        $data['email'] = $row['email'];
                        $data['clinicianname']  = $this->Corefunctions->showClinicanName($doctorDetails,'1');
                        $data['link'] = url('invitation/' . 'c_' . $invitationkey);
                        $data['cliniclogo'] = ($clinic->logo != '') ? $this->Corefunctions->resizeImageAWS($clinic->id,$clinic->logo,$clinic->name,180,180,'1') : asset("images/default_clinic.png"); 

                        // print'<pre>';print_r($input);exit;
                        if($input['user_type_id'] != 3 ){
                            $data['link']   = url('register?invitationkey=' . 'c_' . $invitationkey); 
                            $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.doctorinvitation');
            
                        }else{
                            $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.userinvitation');

                        }
                    }

                }
            }

            // Return a preview page with both valid and error records
            $arr['success'] = 1;
            $arr['message'] = 'User file imported successfully';

            return response()->json($arr);

        }
    }

    /* Not in use */
    public function previewDetails(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }
            $importKey = $data['importKey'];

            /** Get the imported exel data  */
            $excelDetails = $this->Corefunctions->convertToArray(DB::table('import_docs')->where('import_doc_uuid', $importKey)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());
            $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::where('phone_number', $excelDetails['phone_number'])->whereNull('deleted_at')->first());

            /** check with email id */
            if (empty($clinicUser)) {
                $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::where('clinic_id', session()->get('user.clinicID'))->where('email', $excelDetails['email'])->whereNull('deleted_at')->first());
            }
            $designation = User::getDesignations();;
            $designation = $this->Corefunctions->getArrayIndexed1($designation, 'id');

            $data['clinicUser'] = $clinicUser;
            $data['excelDetails'] = $excelDetails;
            $data['designation'] = $designation;

            $html = view('users.previewdetails', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    /** delete imported data of users */
    public function deleteDoc(Request $request)
    {
        if ($request->ajax()) {

            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Data missing');
                
            }
            $importDocList = ImportDoc::importDocsByKey($data['importKey']);
            if (empty($importDocList)) {
                $arr['success'] = 0;
                $arr['message'] = 'Invalid records.';
                return response()->json($arr);
            }
            ImportDoc::updateImportDoc($data['importKey']);
          
            $arr['success'] = 1;
            $arr['message'] = 'Records removed successfully';
            return response()->json($arr);
         
        }
    }
    /* sample  doc for  download*/
    public function downloadSampleDoc($type)
    {
        if($type == 'nurse'){
            $filename = "Sample_Doc.xlsx";
            $headers = array(
                'Content-Type: application/excel',
            );
            $docppath = SAMPLEPATH . 'Nurse_Sample_Doc.xlsx';
        }else{
            $filename = "Sample_Doc.xlsx";
            $headers = array(
                'Content-Type: application/excel',
            );
            $docppath = SAMPLEPATH . 'Doctor_Sample_Doc.xlsx';
        }
       
        return response()->download($docppath, $filename, $headers);
    }
    /* check for user activities befor delete */
    public function checkAppointmentTagged()
    {
        $clinicuser_uuid = session('user.clinicuser_uuid');
        $clinicUserDets = ClinicUser::where('clinic_user_uuid', $clinicuser_uuid)->first();
        $clinicID = session('user.clinicID');
        $userId = session('user.userID');
        if(empty($clinicUserDets)){
            return $this->Corefunctions->returnError('Invalid clinic user');
           
        }

        $clinicuser_uuid = session('user.clinicuser_uuid');
        $clinicUserDets = ClinicUser::where('clinic_user_uuid', $clinicuser_uuid)->first();

        $isadminexist = User::checkAdminExist($clinicUserDets->id);
        $isAppointmentsTagged = Appointment::checkAppointmentsTaggedToDoctor($clinicUserDets->id);
        
        if($isadminexist <= 0){
            return $this->Corefunctions->returnError('You cannot delete your account as there are no other admins assigned to this clinic.');
           
        }
        if($isAppointmentsTagged > 0){
            return $this->Corefunctions->returnError('You cannot delete your account because there are appointments tagged to this user');
        }
        $arr['success'] = 1;
        return response()->json($arr);
    }

    /* delete user by otp  */
    public function deleteClinicUser()
    {
        if (request()->ajax()) {

            $clinicuser_uuid = session('user.clinicuser_uuid');
            $clinicUserDets = ClinicUser::userByUUID($clinicuser_uuid);
            $clinicID = session('user.clinicID');
            $userId = session('user.userID');

            if(empty($clinicUserDets)){
                return $this->Corefunctions->returnError('Invalid clinic user');
            }
            $countryCode = RefCountryCode::getCountryCodeById($clinicUserDets->country_code) ;
            $userOtpData = $this->Corefunctions->insertToOtps($clinicUserDets->phone_number, $countryCode);
            
            if($clinicUserDets->is_licensed_practitioner == '1' &&  $clinicUserDets->dosepot_id !== null ){
                $clinicUserDets     = $this->Corefunctions->convertToArray($clinicUserDetails);
                $userDets           = $this->Corefunctions->convertToArray(User::userByID($clinicUserDets['user_id']));
                $this->Corefunctions->removeClinicUserDoseSpot($clinicUserDets,$userDets);
            }

            $arr['success'] = 1;
            $arr['otp'] = $userOtpData['userotp'];
            $arr['key'] = $userOtpData['otpUuid'];
            $arr['phonenumber'] = $clinicUserDets->phone_number;
            $arr['countrycode'] = $countryCode['country_code'];
            $arr['countryCodeShort'] = $countryCode['short_code'];
            $arr['countryId'] = $countryCode['id'];
            $arr['type'] = 'deleteclinicuser';

            $arr['message'] = 'Otp generated successfully';
            return response()->json($arr);
                
        }
    }
    

    public function verifyotp()
    {
        if (request()->ajax()) {
            $this->Corefunctions = new \App\customclasses\Corefunctions;
            $data = request()->all();

            // Check if data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
                
            }
            $phoneNumber = session('user.phone');
            // Parse form data
            parse_str($data['formdata'], $input);
            $countryId = $input['countryId'];
            // Get OTP details from the 'otps' table
            $otpDetails = Otp::getOtpDetails($input);

            // If OTP is invalid, return error
            if (empty($otpDetails)) {
                return $this->Corefunctions->returnError('Invalid Otp.');

            }
            // If OTP is expired, return error
            if (time() > $otpDetails['expiry_on']) {
                return $this->Corefunctions->returnError('Code expired.');
               
            }
            // Update otp as used 
            Otp::updateOtp($input['otpkey'],'otp_uuid');
            
            /* get countru code details*/
            $countryCode = RefCountryCode::getCountryCodeByShortCode($input['countryCodeShort']);
          
            if(isset($input['type']) && $input['type'] =='deleteclinicuser'){
                $clinicuser_uuid = session('user.clinicuser_uuid');
                $clinicUserDets = ClinicUser::userByUUID($clinicuser_uuid);
               
                $phone = $clinicUserDets->phone_number;
                $email = $clinicUserDets->email;
               
                User::removeClinicUserAccount($clinicUserDets->id,$clinicUserDets->user_id,$phone,$email);
                return response()->json([
                   'token' => 'delete',
                   'success' => 1,
                   'message' => 'Profile deleted successfully',
                ]);
            }
        }
    }

    public function details($key)
    {

        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
        /** get doctors Details */
        $clinicUserDetails = ClinicUser::ClinicUserDetails($key);
        if (empty($clinicUserDetails)) {
            return redirect('/users');
        }
        if($clinicUserDetails['clinic_id'] != session()->get('user.clinicID')){
            return redirect('/users');
        }
      
        $clinicUserDetails['logo_path'] = (isset($clinicUserDetails['user']['profile_image']) && $clinicUserDetails['user']['profile_image'] !='') ? $this->Corefunctions->resizeImageAWS($clinicUserDetails['user_id'],$clinicUserDetails['user']['profile_image'],$clinicUserDetails['user']['first_name'],180,180,'1') :  $this->Corefunctions-> resizeImageAWS($clinicUserDetails['id'],$clinicUserDetails['logo_path'],$clinicUserDetails['name'],180,180,'1') ;
        
        /** get countryCodeDetails */
        $countryCodeDetails = RefCountryCode::getCountryCodeById($clinicUserDetails['country_code']);
       
        $seo['title'] = "User Details  | " . env('APP_NAME');
        
        return view('users.details', compact('clinicUserDetails','seo', 'countryCodeDetails'));
    }

    public function enableAddOn(){
        if (request()->ajax()) {
            $data = request()->all();
            $useruuid = (isset($data['useruuid']) && $data['useruuid'] != '') ? $data['useruuid'] : '';
            $clinicId = session()->get('user.clinicID');

            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
            $isEprescribeEnabled = Clinic::checkEprescribeEnabled($clinicId);
            $users = $this->Corefunctions->convertToArray(ClinicUser::getClinicLicencedPractitioners($clinicId));
            if(count($users) == '0'){
                $primaryContact = $this->Corefunctions->convertToArray(ClinicUser::getClinicPrimaryContact($clinicId));
                $users = array_merge($users,$primaryContact);
            }
            $userCards = ClinicCard::getUserCards($clinicId);
            if (!empty($userCards) ) {
                foreach ($userCards as $key => $cards) {
                    $userCards[$key]['expiry'] = $cards['exp_month'].'/'.$cards['exp_year'];
                    $userCards[$key]['card_num'] = $cards['card_number'];
                    $userCards[$key]['patient_card_uuid'] = $cards['clinic_card_uuid'];
                }
            }
            $is_prorated = (date('j') != 1) ? 1 : 0;

            $countries = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());
            $countries = $this->Corefunctions->convertToArray($countries);

            $addressdata = $this->Corefunctions->convertToArray(DB::table('user_billing')->select('user_billing_uuid', 'billing_address','billing_company_name','billing_phone','billing_city','billing_state_id','billing_state_other','billing_country_id','billing_zip','billing_country_code')->where('clinic_id', $clinicId)->whereNull('deleted_at')->first());

            $states          = $this-> Corefunctions->convertToArray(DB::table('ref_states')->get());
            $type = 'payment';
            $clientSecret = '';
    
            $html = view('users.addon', compact('users', 'userCards', 'countries', 'states','addressdata','type','isEprescribeEnabled','clientSecret','is_prorated','useruuid'))->render();
            return response()->json([
                'view' => $html,
                'success' => 1,
            ]);
        }
    }
    public function submitAddOn(){
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            $clinicId = Session::get('user.clinicID');
            $userId = Session::get('user.userID');
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));

            $clinicUsers = (!empty($input['selected_user_ids'])) ? explode(',', $input['selected_user_ids']) : array();

            $addOnDetails = $this->Corefunctions->convertToArray(DB::table('addons')->where('id','1')->first());

            $billingCheck = UserBilling::getBillingInfo($clinicId);
            $countryCodedetails  = array();
            if(empty($billingCheck)){
                $userBillingKey = $this->Corefunctions->generateUniqueKey('10', 'user_billing', 'user_billing_uuid');
                UserBilling::saveBillingData($input,$userId,$userBillingKey,$clinicId,$countryCodedetails);
            }else{
                UserBilling::updateBillingData($billingCheck['id'],$input,$countryCodedetails);
            }
            $billingInfo = UserBilling::getUserBilling($clinicId);

            $addOnAmount = $this->Corefunctions->calculateAddOnAmount($clinicUsers,$clinicId,'1');
            $usercount = count($clinicUsers);
            $currentMonth = Carbon::now();
            $currentMonthName = $currentMonth->format('F Y');
            $amount = number_format($addOnAmount, 2);   
            $notes = "Your ePrescribe amount for {$currentMonthName}.";
           
            $isEprescribeEnabled = Clinic::checkEprescribeEnabled($clinicId);
            if($isEprescribeEnabled == '0'){
                /* Dosespot Integration */
                 if( is_null($clinicDetails['dosepot_id']) ){
                     $clientResponse =  $this->Corefunctions->createClinicDoseSpot($clinicDetails);
                     if( !empty($clientResponse) && $clientResponse['success'] == 0 && isset($clientResponse['errors']) ){
                          return $this->Corefunctions->returnError($clientResponse['errors']);
                     }
                 }
            } 
            
            $hasDoseSpotAdmin = '0';
            $doseSpotAdmin = ClinicUser::doseSpotAdminByClinicID($clinicId);
            if( !empty($doseSpotAdmin)){
                $hasDoseSpotAdmin = '1';
            }
            
            /* Clinician Admin Registration In Dosespot */
            $clinicPrimaryUser = ClinicUser::getPrimayUser($clinicId);
            if( !empty($clinicPrimaryUser) ){
               if( $hasDoseSpotAdmin == 0 ){
                    $userDets       = $this->Corefunctions->convertToArray(User::userByID($clinicPrimaryUser['user_id']));
                    $additionalInfo['ClinicianRoleType'] = ( !empty($clinicUsers) && in_array($clinicPrimaryUser['clinic_user_uuid'],$clinicUsers) ) ? array('1','4') : array('4');
                    $additionalInfo['dosespot_admin']    = '1';
                    $clientUserResponse = $this->Corefunctions->createClinicUserDoseSpot($clinicPrimaryUser,$userDets,$additionalInfo);
                   
                    if( !empty($clientUserResponse) && $clientUserResponse['success'] == 0 && isset($clientUserResponse['errors']) ){
                        return $this->Corefunctions->returnError($clientUserResponse['errors']);
                    }
                }
            }
            
            if(!empty($clinicUsers)){
                foreach($clinicUsers as $clinicuser){
                    $clinicUserDets = ClinicUser::userByUUID($clinicuser);
                    
                    /* Clinic User Dosespot Integration */
                    $clinicUserData  = $this->Corefunctions->convertToArray($clinicUserDets);
                    $userDets       = $this->Corefunctions->convertToArray(User::userByID($clinicUserData['user_id']));
                    
                    if( !empty($userDets) && !empty($clinicUserData)  && $clinicUserData['is_licensed_practitioner'] == '1'){
                       
                        
                        $clientUserResponse = $this->Corefunctions->createClinicUserDoseSpot($clinicUserData,$userDets);
                        if( !empty($clientUserResponse) && $clientUserResponse['success'] == 0 && isset($clientUserResponse['errors']) ){
                            return $this->Corefunctions->returnError($clientUserResponse['errors']);
                        }
                    } 

                }
            }
            
            
            

            $result = $this->Corefunctions->submitPayment($clinicId,$addOnAmount,$input);

            $id = Invoice::insertInvoice($clinicId,$addOnAmount,$usercount,$billingInfo,$notes,1); 

            if($isEprescribeEnabled == '0'){
                $itemnotes = "One time setup payment for ePrescibe";
                InvoiceItem::insertInvoiceItem($id,$clinicId,$addOnDetails['one_time_setup_amount'],'0',$itemnotes);
                $amount = $addOnAmount - $addOnDetails['one_time_setup_amount'];
            }else{
                $amount = $addOnAmount;
            }
            $itemnotes = "Monthly Fixed Charges for {$usercount} seats - {$currentMonthName}";
            InvoiceItem::insertInvoiceItem($id,$clinicId,$amount,$usercount,$itemnotes);

            Invoice::markAsPaid($id, $result['paymentIds']['id'],$result['paymentIds']['receipt_num']);
            if($isEprescribeEnabled == '0'){
                Clinic::insertClinicAddon($clinicId,$addOnDetails['id']);
            }
            
            if(!empty($clinicUsers)){
                foreach($clinicUsers as $clinicuser){
                    $clinicUserDets = ClinicUser::userByUUID($clinicuser);
                    $id = ClinicUser::insertEprescribers($clinicUserDets->user_id,$clinicUserDets->clinic_id,$addOnDetails['amount']);
                    ClinicUser::enableEprescribe($clinicuser,$id);
                    
                }
            }

            return response()->json([
                'success' => 1,
                'message' => 'Addon enabled successfully',
            ]);
        }
    }
    public function checkAddon(){
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $userDetails = ClinicUser::getClinicUserByKey($data['userKey']) ;
            if (empty($userDetails)) {
                return $this->Corefunctions->returnError('Invalid data');
            }
            /* check the user details needed or not   */
            $isShow  =$this->Corefunctions->checkuserData($userDetails['user_id']);
            $isShow  = $userDetails['user_type_id'] == '3' ? '0' : $isShow ;
            
            $clinicId      = session()->get('user.clinicID');
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
            $isUsUser      = $this->Corefunctions->checkIsUserUserForePrescribe($clinicDetails,$userDetails);

            return response()->json([
                'isUsUser' => $isUsUser ,
                'isShow' => $isShow ,
                'success' => 1,
                'message' => 'Addon enabled successfully',
            ]);
        }
    }

}
