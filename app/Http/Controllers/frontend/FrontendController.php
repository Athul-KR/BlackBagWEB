<?php

namespace App\Http\Controllers\frontend;

use App\Models\ClinicUser;
use App\Models\PatientDocs;
use App\Models\RefState;
use App\Models\StripeConnection;
use App\Models\User;
use App\Models\Clinic;
use App\Models\FcUserFolder;
use App\Models\FcFile;
use App\Models\RefCountryCode;
use Redirect;
use Session;
use App\Models\Otp;
use App\customclasses\Corefunctions;
use App\Models\Appointment;
use App\Models\Inquiry;
use App\Models\RpmOrders;
use App\Models\Patient;
use App\Models\PatientNoteHistory;
use App\Models\ClinicGallery;
use App\Models\VideoCallParticipant;
use App\Models\VideoCall;
use App\Models\AppointmentType;
use App\Models\Payment;
use App\Models\PatientCard;
use App\Models\ClinicSubscription;
use App\Models\PatientSubscription;
use App\Models\BpTracker;
use App\Models\RefPlanIcons;
use App\Models\Chats;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Validator;
use File;
use DateTimeZone;

class FrontendController extends Controller
{

    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->stripePayment      = new \App\customclasses\StripePayment;
       
    }
    /*******register Account *****/

    public function createPatient()
    {

        $data = request()->all();
        $type = 'register';

        $state = $this->Corefunctions->convertToArray(RefState::getStateList());
        $clinics = Clinic::get();

        $data['type'] = $type;
        $data['clinics'] = $clinics;
        $data['state'] = $state;
        $html = view('frontend.patient-create', $data);
        $arr['view'] = $html->__toString();
        $arr['success'] = 1;
        return response()->json($arr);
    }
    /* not in use */
    public function storePatient()
    {

        $data = request()->all();

        if (empty($data)) {
            return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
        }

        parse_str($data['formdata'], $input);


        // Fetch country ID from ref_country_codes table
        $countryCode = $this->Corefunctions->convertToArray(RefCountryCode::getCountryCodeByShortCode($input['countryCodeShort']));

        $whatsappcountryCode = $this->Corefunctions->convertToArray(RefCountryCode::getCountryCodeByShortCode($input['whatsappcountryCodeShorts']));
            
        /*****phone number valid check****/

        $patientDetails = Patient::where('clinic_id', $input['clinic'])->where('email', $input['email'])->withTrashed()->count();

        if ($patientDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Email already exists in the system';
            return response()->json($arr);
        }

         $userDetails = User::where('email', $email)->withTrashed()->count();
        if ($userDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Email already exists in the system';
            return response()->json($arr);
        }
        $userPhoneDetails = User::where('phone_number', $input['phone_number'])->where('country_code', $countryCode['id'])->withTrashed()->count();
        if ($userPhoneDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Phone number already exists in the system';
            return response()->json($arr);
        }
        $patientDetails = Patient::where('clinic_id', $input['clinic'])->where('phone_number', $input['phone_number'])->where('country_code', $countryCode['id'])->withTrashed()->count();

        if ($patientDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Phone number already exists in the system';
            return response()->json($arr);
        }
        
        $clinicUserDetails = ClinicUser::where('clinic_id', $input['clinic'])->where('phone_number', $input['phone_number'])->where('country_code', $countryCode['id'])->withTrashed()->count();

        if ($clinicUserDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Phone number already exists in the system';
            return response()->json($arr);
        }

        $clinicUserDetails = ClinicUser::where('clinic_id', $input['clinic'])->where('email', $input['email'])->withTrashed()->count();

        if ($clinicUserDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Email already exists in the system';
            return response()->json($arr);
        }
        $clinicDetails = ClinicUser::where('email', $input['email'])->where('phone_number', '!=', $input['phone_number'])->withTrashed()->count();

        if ($clinicUserDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Email with different phonenumber already exists in the system';
            return response()->json($arr);
        }




        /** check the patient with users table */
        $userDetails = User::where('phone_number', $input['phone_number'])->where('email', $input['email'])->where('country_code', $countryCode['id'])->first();

        if (empty($userDetails)) {
            $userUuid = $this->Corefunctions->generateUniqueKey("10", "users", "user_uuid");
            $userObject = new User();
            $userObject->user_uuid = $userUuid;
            $userObject->first_name = $input['name'];
            $userObject->phone_number = $input['phone_number'];
            $userObject->email = $input['email'];
            $userObject->country_code = $countryCode['id'];
            $userObject->address = $input['address'];
            $userObject->city = $input['city'];
            $userObject->zip_code = $input['zip'];
            $userObject->status = '1';
            $userObject->save();
            $userID = $userObject->id;
        } else {

            $userID = $userDetails->id;
        }

        /** Inset Consultant info  */
        $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');

        $patientuuid = $this->Corefunctions->generateUniqueKey("10", "patients", "patients_uuid");
        $patientObject = new Patient();
        $patientObject->patients_uuid = $patientuuid;
        $patientObject->name = $input['name'];
        $patientObject->clinic_id = $input['clinic'];
        $patientObject->gender = $input['gender'];
        $patientObject->email = $input['email'];
        $patientObject->dob = (isset($input['dob']) && $input['dob'] != '') ? date('Y-m-d', strtotime($input['dob'])) : NULL;
        $patientObject->phone_number = $input['phone_number'];
        $patientObject->whatsapp_number = isset($input['whatsapp_num']) ? $input['whatsapp_num'] : null;
        $patientObject->address = $input['address'];
        $patientObject->city = $input['city'];

        $patientObject->zip = $input['zip'];
        $patientObject->country_code = $countryCode['id'];
        $patientObject->whatsapp_country_code = (!empty($input['whatsapp_num']) && !empty($input['whatsappcountryCodeShorts'])) ? $whatsappcountryCode['id'] : null;
        $patientObject->user_id = $userID;
        $patientObject->status = '1';
        $patientObject->state = (isset($input['state']) && $input['state'] != '' && $input['countrycode'] != '+1' && $input['countrycode'] != '1') ? $input['state'] : null;
        $patientObject->state_id = (isset($input['state_id']) && $input['state_id'] != '' && $input['countrycode'] == '+1' && $input['countrycode'] == '1') ? $input['state_id'] : null;
        $patientObject->invitation_key = 'c_' . $invitationkey;
        $patientObject->save();
        $patientID = $patientObject->id;


        $userDetails = $this->Corefunctions->convertToArray(User::where('id', $userID)->whereNull('deleted_at')->first());
        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::where('id', $input['clinic'])->first());




        /* patient Image Upload */
        if ($input['tempimage'] != "") {
            /* Temp Image Details */
            $tempImageDetails = DB::table("temp_docs")->where("tempdoc_uuid", $input['tempimage'])->first();
            if (!empty($tempImageDetails)) {
                $originalpath = "storage/app/public/tempImgs/original/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
                $croppath = "storage/app/public/tempImgs/crop/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
                $crppath = 'patients/' . $patientuuid . '.' . $tempImageDetails->temp_doc_ext;
                $image_path = $tempImageDetails->tempdoc_uuid . '.' . $tempImageDetails->temp_doc_ext;

                $image_path = File::get($croppath);

                if ($this->Corefunctions->uploadDocumenttoAWS($crppath, $image_path)) {
                    $image_path = $crppath;
                    $patient = DB::table('patients')->where('id', $patientID)->update(array(
                        'logo_path' => $image_path,
                    ));
                }

                unlink($croppath);
            }
        }


        $timezoneDetails = DB::table('ref_timezones')->where('id', $userDetails['timezone_id'])->whereNull('deleted_at')->first();
        $timezoneDetails = $this->convertToArray($timezoneDetails);
        // Store user session data
        $sessArray = array();
        $sessArray['user']['userID'] = $userDetails["id"];
        $sessArray['user']['firstName'] = $userDetails['first_name'];
        $sessArray['user']['lastName'] = $userDetails['last_name'];
        $sessArray['user']['email'] = $userDetails["email"];
        $sessArray['user']['phone'] = $userDetails["phone_number"];
        $sessArray['user']['user_uuid'] = $userDetails['user_uuid'];
        $sessArray['user']['clinicuser_uuid'] = $patientuuid;
        $sessArray['user']['image_path'] = ($input['tempimage'] != "") ? $this->Corefunctions->getAWSFilePath($image_path) : asset('images/default_img.png');
        // $sessArray['user']['user_type']             = isset($input['type']) && $input['type'] == 'doctor' ? 'doctor' : 'clinics';
        $sessArray['user']['userType'] = 'patient';
        $sessArray['user']['clinicID'] = $input['clinic'];
        $sessArray['user']['clinicName'] = $clinicDetails['name'];
        $sessArray['user']['clinicUUID'] = $clinicDetails['clinic_uuid'];
        $sessArray['user']['userLogo'] = ($userDetails['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['profile_image']) : '';
        $sessArray['user']['clinicLogo'] = ($clinicDetails['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset('images/default_clinic.png');
        $sessArray['user']['timezone'] = !empty($timezoneDetails) ? $timezoneDetails['timezone_format'] : 'UTC';

        $clinicDetailsCount = ClinicUser::select('clinic_users.user_type_id', 'clinic_users.clinic_id', 'clinics.name', 'clinic_users.clinic_user_uuid')
            ->join('clinics', 'clinics.id', '=', 'clinic_users.clinic_id')
            ->where('clinic_users.user_id', $userDetails["id"])->where('clinic_users.status', '1')->whereNull('clinics.deleted_at')->count();


        $patientsCount = Patient::select('patients.user_type_id', 'patients.clinic_id', 'clinics.name', 'patients.clinic_user_uuid')
            ->join('clinics', 'clinics.id', '=', 'patients.clinic_id')
            ->where('patients.user_id', $userDetails["id"])->where('patients.status', '1')->whereNull('clinics.deleted_at')->count();
        $clinicDetailsCount = $clinicDetailsCount + $patientsCount;

        $sessArray['user']['hasWorkSpace'] = $clinicDetailsCount > 1 ? 1 : 0;


        $sessArray['user']['stripeConnection'] = 0;
        session($sessArray);



        $arr['success'] = 1;
        $arr['message'] = 'Account created successfully';
        return response()->json($arr);
    }



    //Settings-- Change phone number
    public function changePhoneNumber()
    {

        $input = request()->all();
        if (empty($input)) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Missing required fields';
            return response()->json($arr);
        }

        parse_str($input['formdata'], $data);
        $data['phonenumber'] = str_replace(["(", ")", " ","-"], "", $data['phonenumber']);
        $clinicID = session('user.clinicID');
        $userId   = session('user.userID');

        $patient = Patient::getPatientwithUserID($userId);
        if (empty($patient)) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Invalid patient';
            return response()->json($arr);
        }
        $countryCode = RefCountryCode::getCountryCodeByShortCode($data['countryCodeShort']);
    
        $patientUserDetails = User::where('id', '!=', $userId)->where('email', $patient->email)->withTrashed()->count();

        if ($patientUserDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Email already exists in the system';
            return response()->json($arr);
        }


        $patientUserDetails = User::where('id', '!=', $userId)->where('phone_number', $data['phonenumber'])->where('country_code', $countryCode['id'])->withTrashed()->count();

        if ($patientUserDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Phone number already exists in the system';
            return response()->json($arr);
        }

        // $clinicUserDetails = ClinicUser::where('clinic_id', $patient->clinic_id)->where('phone_number', $data['phonenumber'])->where('country_code', $countryCode['id'])->withTrashed()->count();

        // if ($clinicUserDetails > 0) {
        //     $arr['error'] = 1;
        //     $arr['errormsg'] = 'Phone number already exists in the system';
        //     return response()->json($arr);
        // }

        // $clinicUserDetails = ClinicUser::where('clinic_id', $patient->clinic_id)->where('email', $patient->email)->withTrashed()->count();

        // if ($clinicUserDetails > 0) {
        //     $arr['error'] = 1;
        //     $arr['errormsg'] = 'Email already exists in the system';
        //     return response()->json($arr);
        // }
        $clinicUserDetails = User::where('email', $patient->email)->where('phone_number', '!=', $data['phonenumber'])->where('id', '!=', $userId)->withTrashed()->count();

        if ($clinicUserDetails > 0) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Email with different phonenumber already exists in the system';
            return response()->json($arr);
        }
      
        $userOtpData = $this->insertToOtps($data['phonenumber'], $countryCode['id']);

        // Return success response with OTP details
        $arr['success'] = 1;
        $arr['otp'] = $userOtpData['userotp'];
        $arr['key'] = $userOtpData['otpUuid'];
        $arr['phonenumber'] = $data['phonenumber'];
        $arr['countrycode'] = '+'.$data['countrycode'];
        $arr['countryCodeShort'] = $countryCode['short_code'];
        $arr['countryId'] = $countryCode['id'];
        // $arr['type'] = 'patient';

        $arr['message'] = 'Otp generated successfully';
        return response()->json($arr);
    }


    //Show phone number modal
    public function showPhoneNumberModal()
    {
        $patientuuid = session('user.clinicuser_uuid');
        $patient = Patient::where('patients_uuid', $patientuuid)->first();

        if (empty($patient)) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Patient does not exists';
            return response()->json($arr);
        }
        $countryCode = DB::table('ref_country_codes')
            ->select('id', 'short_code', 'country_code')
            ->where('id', $patient->country_id)
            ->orWhere('id', $patient->country_code)
            ->first();



        // dd($countryCode);

        $html = view('frontend.change-phone-modal', compact('patient', 'countryCode'));
        $arr['view'] = $html->__toString();
        $arr['success'] = 1;
        return response()->json($arr);
    }



    //Submit login form
    public function submitlogin()
    {

        if (request()->ajax()) {
            $this->Corefunctions = new \App\customclasses\Corefunctions;
            $data = request()->all();


            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            // dd($input);
            $type = isset($input['type']) && $input['type'] != '' ? $input['type'] : '';

           
            // Fetch country ID from ref_country_codes table for clinic
            $countryCode = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id', 'short_code', 'country_code')
                ->where('short_code', $input['countryCodeShort'])
                ->first());

            // If user does not exist, return error response
            if (empty($countryCode)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Sorry,The provided country or phone number mismatch'
                ]);
            }



            /** Check for inviation form doctor */
            if (isset($input['invitationkey']) && $input['invitationkey'] != '') {
                $parentDetails = Patient::where('phone_number', $input['phonenumber'])->where('country_code', $countryCode['id'])->first();

                // /** Inset user ifo  */
                if (!empty($parentDetails)) {
                    $userUuid = $this->Corefunctions->generateUniqueKey("10", "users", "user_uuid");
                    /** /* Fetch user  Details */
                    $userDetails = User::where('phone_number', $parentDetails->phone_number)->where('country_code', $parentDetails->country_code)->first();


                    if (empty($userDetails)) {
                        $userObject = new User();
                        $userObject->user_uuid = $userUuid;
                        $userObject->first_name = $parentDetails->name;
                        $userObject->phone_number = $parentDetails->phone_number;
                        $userObject->country_code = $countryCode['id'];
                        $userObject->email = $parentDetails->email;
                        $userObject->status = '1';
                        $userObject->save();
                        $userID = $userObject->id;
                    } else {
                        $userDetails->status = '1';
                        $userDetails->update();
                        $userID = $userDetails->id;
                    }
                }
            }





            // Check if the user exists by phone number
            $userDetails = $this->Corefunctions->convertToArray(User::select('id', 'user_uuid', 'phone_number')->where('phone_number', $input['phonenumber'])->where('country_code', $countryCode['id'])->first());

            if ($input['type'] == 'patient') {
                $userDetails = $this->Corefunctions->convertToArray(Patient::where('phone_number', $input['phonenumber'])->where('phone_number', $input['phonenumber'])->where('country_code', $countryCode['id'])->first());
                // dd($userDetails);
            }

            // If user does not exist, return error response
            if (empty($userDetails)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Sorry,The provided credentials do not match our records.'
                ]);
            }

            // Fetch country ID from ref_country_codes table
            // $countryCode = $this->Corefunctions->convertToArray(
            //     DB::table('ref_country_codes')
            //         ->select('country_id')
            //         ->where('id', $input['countrycode'])
            //         ->first()
            // );
            $userOtpData = $this->insertToOtps($input['phonenumber'], $countryCode['id']);

            // Return success response with OTP details
            $arr['success'] = 1;
            $arr['otp'] = $userOtpData['userotp'];
            $arr['key'] = $userOtpData['otpUuid'];
            $arr['phonenumber'] = $input['phonenumber'];
            $arr['countrycode'] = $input['countrycode'];
            $arr['countryCodeShort'] = $countryCode['short_code'];
            $arr['countryId'] = $countryCode['id'];
            $arr['type'] = $input['type'];

            $arr['message'] = 'Otp generated successfully';
            return response()->json($arr);
        }
    }


    //Insert otp
    public function insertToOtps($phoneNumber, $countryCode = array())
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
      
        /** Deactivate previous otp generated for this phone number */
        DB::table('otps')->where('phone_number', $phoneNumber)->update(array(
            'deleted_at' => Carbon::now(),
            "is_used" => '1',
            'updated_at' => Carbon::now()
        ));

        // Generate unique OTP UUID
        $otpUuid = $this->Corefunctions->generateUniqueKey("10", "otps", "otp_uuid");
        // Generate a random 4-digit OTP
        $userotp = rand(1000, 9999);
        // Set OTP expiry time (3 minutes from now)
        $expiryOn = time() + (3 * 60);

        // Insert OTP details into the 'otps' table
        $otpObject = new Otp();
        $otpObject->otp_uuid = $otpUuid;
        $otpObject->otp = $userotp;
        $otpObject->phone_number = $phoneNumber;
        $otpObject->is_used = '0';
        $otpObject->country_id = !empty($countryCode) ? $countryCode : 1;
        $otpObject->expiry_on = $expiryOn;
        $otpObject->save();

        $responseArray['userotp'] = $userotp;
        $responseArray['otpUuid'] = $otpUuid;
        return $responseArray;
    }




    //    Verify Otp
    public function verifyotp()
    {
        if (request()->ajax()) {
            $this->Corefunctions = new \App\customclasses\Corefunctions;
            $data = request()->all();
            // dd($data);

            // Check if data is empty
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
            $phoneNumber = session('user.phone');
            

            // Parse form data
            parse_str($data['formdata'], $input);
            $countryId = $input['countryId'];
            $newPhoneNumber = $input['phonenumber'] ;
        
            // Get OTP details from the 'otps' table
            $otpDetails = Otp::getOtpDetails($input);
           
            // If OTP is invalid, return error
            if (empty($otpDetails)) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Invalid Otp.'
                ]);
            }

            // If OTP is expired, return error
            if (time() > $otpDetails['expiry_on']) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Code expired.'
                ]);
            }

            // Update otp as used
            Otp::updateOtp($input['otpkey'],'otp_uuid');
            
            $userDetails = Patient::where('phone_number', $otpDetails['phone_number'])->whereNull('deleted_at')->first();

            if (request('tokn') !== 'update' || empty(request('tokn'))) {
                // If user does not exist, return error response
                if (empty($userDetails)) {
                    session()->flash("otperror", "The provided credentials do not match our records.");
                    return back();
                }
            }
           $countryCode = RefCountryCode::getCountryCodeByShortCode($input['countryCodeShort']);

            if (isset($input['type']) && $input['type'] == 'deletepatient') {
                $user_uuid = session('user.user_uuid');
                $userDetails = User::userByKey($user_uuid);

                $phone = $userDetails->phone_number;
                $email = $userDetails->email;
                User::removeAccount($userDetails->id, $phone, $email);
                return response()->json([
                    'token' => 'delete',
                    'success' => 1,
                    'message' => 'Profile deleted successfully',
                ]);
            }
            if (request('tokn') == 'update') {
                $input['phonenumber'] = $phoneNumber ;
                $user = User::getUserByPhoneCountry( $input,$countryId);
                
                // dd($user);
                $userDetails = Patient::getPatientByUserIDPhone($input,$countryId,$user['id']); 
           
                if ($user || $userDetails) {
                    User::updateUserPhone($input['countryId'],$newPhoneNumber,$userDetails['user_id']);
                    Patient::updatePatientPhone($input['countryId'],$newPhoneNumber,$userDetails['id']);
                }
            }
           
            $clinicuserDetails = $this->Corefunctions->convertToArray(Patient::where('phone_number', $otpDetails['phone_number'])->first());
            $userDetails = $this->Corefunctions->convertToArray(User::where('id', $clinicuserDetails['user_id'])->first());
            // $clinicDetails = $this->Corefunctions->convertToArray(Clinic::where('id', $clinicuserDetails['clinic_id'])->first());
            // dd($userDetails);
            $logoPath = ($clinicuserDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicuserDetails['logo_path']) : asset('images/default_img.png');

            $countryCodes = RefCountryCode::getCountryCodeById($clinicuserDetails['country_code']);
            
            $timezoneDetails = User::getUserTimeZoneById($userDetails['timezone_id']);
            $timezoneDetails = $this->Corefunctions->convertToArray($timezoneDetails);

            if (request('tokn') == 'update') {
                session()->put('user.phone', $userDetails["phone_number"]);
                session()->put('user.country_code', $countryCodes['country_code']);
            }else{
                // Store user session data
                $sessArray = array();
                $sessArray['user']['userID'] = $userDetails["id"];
                $sessArray['user']['firstName'] = $userDetails['first_name'];
                $sessArray['user']['lastName'] = $userDetails['last_name'];
                $sessArray['user']['email'] = $userDetails["email"];
                $sessArray['user']['phone'] = $userDetails["phone_number"];
                $sessArray['user']['user_uuid'] = $userDetails['user_uuid'];
                $sessArray['user']['country_code'] = $countryCodes['country_code'];
                $sessArray['user']['clinicuser_uuid'] = $clinicuserDetails['patients_uuid'];
                $sessArray['user']['image_path'] = ($clinicuserDetails['logo_path'] != "") ? $this->Corefunctions->getAWSFilePath($clinicuserDetails['logo_path']) : asset('images/default_img.png');
                // $sessArray['user']['user_type']             = isset($input['type']) && $input['type'] == 'doctor' ? 'doctor' : 'clinics';
                $sessArray['user']['userType'] = 'patient';
                $sessArray['user']['clinicID'] = $clinicuserDetails['clinic_id'];
                $sessArray['user']['userLogo'] = ($userDetails['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['profile_image']) : asset('images/default_img.png');
                $sessArray['user']['timezone'] = !empty($timezoneDetails) ? $timezoneDetails['timezone_format'] : 'UTC';

                $clinicDetailsCount = ClinicUser::select('clinic_users.user_type_id', 'clinic_users.clinic_id', 'clinics.name', 'clinic_users.clinic_user_uuid')
                    ->join('clinics', 'clinics.id', '=', 'clinic_users.clinic_id')
                    ->where('clinic_users.user_id', $userDetails["id"])->where('clinic_users.status', '1')->whereNull('clinics.deleted_at')->count();
                // $patientsCount = Patient::select('patients.user_type_id', 'patients.clinic_id', 'clinics.name', 'patients.clinic_user_uuid')
                //     ->join('clinics', 'clinics.id', '=', 'patients.clinic_id')
                //     ->where('patients.user_id', $userDetails["id"])->where('patients.status', '1')->whereNull('clinics.deleted_at')->count();
                // $clinicDetailsCount = $clinicDetailsCount + $patientsCount;

                $sessArray['user']['hasWorkSpace'] = $clinicDetailsCount > 1 ? 1 : 0;
                $sessArray['user']['stripeConnection'] = 0;
                session()->put($sessArray);
            }

            if (request('tokn') == 'update') {
                session(['user.phone' => $userDetails["phone_number"]]);
                return response()->json([
                    'token' => 'update',
                    'success' => 1,
                    'message' => 'Phone number changed successfully',

                ]);
            }
            // Return success response
            return response()->json([
                'success' => 1,
                'message' => 'OTP verified successfully',
                'change' => 'Phone numberchanged',
            ]);
        }
    }


    public function getNotes()
    {
        $uuid = request('uuid');

        $appointment = Appointment::where('appointment_uuid', $uuid)->withTrashed()->first();
        $note = $appointment->notes;
        return response()->json([
            'note' => $note,
            'status' => 1,
        ]);
    }
    public function showLogin()
    {

        $html = view('frontend.patient-login');
        $arr['view'] = $html->__toString();
        $arr['success'] = 1;
        return response()->json($arr);
    }



    //Logout
    public function logout(Request $request)
    {
      

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent CSRF issues
        $request->session()->regenerateToken();
        if (isset($_GET['redirectinvite']) && $_GET['redirectinvite'] != '') {
            return redirect('/' . $_GET['redirectinvite']);
        } else {
           
            return redirect('/login')->with('status', 'You have been logged out successfully!');
        }

        // Redirect to the login page with a logout message
    }



    //Save inquiries 
    public function storeContactUs()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            parse_str($data['formdata'], $input);
             
            if ($this->validateRecaptcha($input['g-recaptcha-response']) == 0 && $input['formtype'] == 'contactus') {

                $arr['error'] = 1;
                $arr['errormsg'] = 'Please verify your identity.';
                return response()->json($arr);
            } else {
             
                /**  insert to  inquiries table */
                Inquiry::insertInquiry($input);
                if (!empty($input['phone_number'])) {
                    $phoneNumberWithTimestamp = $input['phone_number'];
                    $cleanPhoneNumber = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $phoneNumberWithTimestamp);
                    $phone = $this->Corefunctions->formatPhone($cleanPhoneNumber);
                }
                if( $input['formtype'] == 'contactus' ){

                    //adding data into array for displaying in mail for mail
                    $data['name'] = $input['name'];
                    $data['email'] = env('CONTACT_US_MAIL');
                    $data['userEmail'] = $input['email'];
                    $data['phone'] = (strpos($input['countrycode'], '+') === 0 ? $input['countrycode'] : '+' . $input['countrycode']) . ' ' . $phone;
                    $data['userMessage'] = $input['message'];

                    $response = $this->Corefunctions->sendmail($data, 'Inquiry submitted by '.$data['name'], 'emails.inquiry');
                   
                    //adding data into array for displaying in mail for mail
                    $data['name'] = $input['name'];
                    $data['email'] = $input['email'];
                    $data['userEmail'] = $input['email'];
                    $data['phone'] = (strpos($input['countrycode'], '+') === 0 ? $input['countrycode'] : '+' . $input['countrycode']) . ' ' . $phone;
                    $data['userMessage'] = $input['message'];
                    $data['isFooter'] = 0;

                    $response = $this->Corefunctions->sendmail($data, 'Thank you for contacting BlackBag', 'emails.inquiryconfirm');

                }
              if( $input['formtype'] == 'landingpage' ){

                    //adding data into array for displaying in mail for mail
                    $data['name'] = $input['name'].' '.$input['last_name'];
                    $data['email'] = env('CONTACT_US_MAIL');
                    $data['userEmail'] = $input['email'];
                    $data['clinicname'] = $input['clinic_name'];
                    $data['phone'] = (strpos($input['countrycode'], '+') === 0 ? $input['countrycode'] : '+' . $input['countrycode']) . ' ' . $phone;
                  
                    $response = $this->Corefunctions->sendmail($data, 'Inquiry submitted by '.$data['name'], 'emails.landingpage');
                   
                    //adding data into array for displaying in mail for mail
                    $data['name'] = $input['name'].' '.$input['last_name'];
                    $data['email'] = $input['email'];
                    $data['userEmail'] = $input['email'];
                   $data['clinicname'] = $input['clinic_name'];
                    $data['phone'] = (strpos($input['countrycode'], '+') === 0 ? $input['countrycode'] : '+' . $input['countrycode']) . ' ' . $phone;
                    $data['isFooter'] = 0;

                    $response = $this->Corefunctions->sendmail($data, 'Thank you for contacting BlackBag', 'emails.landingpageconfirm');

                }
              
                $arr['success'] = 1;
                $arr['message'] = "Inquiry submitted successfully";
                return response()->json($arr);
            }
        }
    }


    function validateRecaptcha($recaptcha)
    {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
            'secret' => env('RECAPTCHA_SECRETKEY'),
            'response' => $recaptcha,
            'remoteip' => $remoteip
        ];
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);

        $success = 0;
        if (isset($resultJson->score) && $resultJson->score >= 0.3) {
            $success = 1;
        }


        return $success;
    }



    public function myAppointments1()
    {
        $patientId = session('user.patientID');
        $appointments = Appointment::where('patient_id', $patientId)->with('consultant')->latest('appointments.created_at')->paginate(10);

        return view('frontend.appointments', compact('appointments'));
    }


    //show my appointments modal
    public function myAppointmentsTemplate()
    {
     
        if (!Session::has('user')) {
           
            return redirect('/');
        }

        if (Session::has('user') && session()->get('user.userType') != 'patient') {
           
            return redirect('/dashboard');
        }
        $this->middleware(function ($request, $next) {
          
            if (session()->has('user') == false) {

                // Redirect to login page if session does not exist
                return redirect()->route('frontend.index');
            }
            return $next($request);
        });

        $status = "open";

        $seo['title'] = "My Appointments  | " . env('APP_NAME');
        $seo['keywords'] = "Manage appointments online, track status, book in-person or virtual visits, view past history, manage schedules, and enjoy effortless healthcare scheduling.";
        $seo['description'] = "Manage appointments effortlessly. Book online or in-person, track status, view doctor details, and get real-time notifications for a seamless healthcare experience.";
        $seo['og_title'] = "My Appointments  | " . env('APP_NAME');
        $seo['og_description'] = "Manage appointments easily with our user-friendly platform. Book online or in-person, track status, view doctor details, and get real-time notifications for seamless care.";
       
        return view('frontend.appointments', compact('status', 'seo'));
    }


    // Show my appointments list
    public function myAppointments($type = '', $status = '')
    {
        if (!Session::has('user')) {
            return redirect('/');
        }
        $userTimeZone = session()->get('user.timezone');

        $type = request("type");
        $status = request("status");
        $page = request("page");
        $userId = session('user.userID');
        $clinickey = request("clinickey");
        $clinicID = '';
        /** get clinic id key  for clinic filter */
        if ($clinickey != 'all' && $clinickey != '') {
            $clinicfilterData = Clinic::clinicByUUID($clinickey);
            $clinicfilterData = $this->Corefunctions->convertToArray($clinicfilterData);
            $clinicID = $clinicfilterData['id'];
        }
        /* get all patients details tagged to the user  */
        $patientDetails = Patient::getPatientsByUserId($userId, $clinicID);
        $allPatientDetails =  $patientDetails['patientDetails'];
        $patientDetails =  $patientDetails['patientDetailsWithClinic'];

        $patientIds = $this->Corefunctions->getIDSfromArray($patientDetails, 'user_id'); // get patient Ids 
        $clinicIds  = $this->Corefunctions->getIDSfromArray($allPatientDetails, 'clinic_id'); // Get clinic ids

        /* get  patients dclinic etails */
        $clinicDetails = Clinic::getclinicByID($clinicIds);
        $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
        $clinicDetails = $this->Corefunctions->getArrayIndexed1($clinicDetails, 'id');

        // $patientId = isset($patient->id) ? $patient->id :'';

        // Base query for online appointments
        $onlineRecords = Appointment::where('status', '1')
            ->whereIn('patient_id', $patientIds)
            ->whereIn('appointment_type_id', ['1', '2'])
            ->with(['consultant', 'consultantClinicUser']);

        $openCount = (clone $onlineRecords)
            ->where('is_completed', '0')
            ->where(function ($query) use ($userTimeZone) {
                $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                    ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            })->count();
        $receptionCount = (clone $onlineRecords)->where(function ($query) {
            $query->where('is_completed', '0')->where('reception_waiting', '1');
        })->count();
        $cancelledCount = (clone $onlineRecords)->onlyTrashed()->count();
        $completedCount = (clone $onlineRecords)->where('is_completed', '1')->count();

        if ($status == 'open') {
            $onlineRecords->where('is_completed', '0')->where(function ($query) use ($userTimeZone) {
                $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                    ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            });
        } elseif ($status == 'reception') {
            $onlineRecords->where(function ($query) use ($userTimeZone) {
                $currentDate = now($userTimeZone)->toDateString(); // Get current date in the user's timezone
                $currentTime = now($userTimeZone)->format('H:i'); // Get current time in HH:mm format
            
                $query->where('is_completed','0')->where('reception_waiting','1'); // Ensure current time is within 1 hour after appointment time
            });
        } elseif ($status == 'cancelled') {
            $onlineRecords->onlyTrashed();
        } elseif ($status == 'completed') {
            $onlineRecords->where('is_completed', '1');
        }

        // Pagination and Retrieving Data
        try {
            // $perPage = request()->get('perPage', 10);
            $appointments = $onlineRecords->orderBy('id', 'desc')->paginate(10, ['*'], 'page', $page);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Something went wrong! Appointment Model not found',
                'redirect' => route('frontend.index'),
                'success' => 0,
            ]);
        }


        // Render appropriate view

        $pagination = $appointments->links('pagination::bootstrap-4')->render();
        $html = view('frontend.appendappointments', compact('userTimeZone', 'appointments', 'status', 'type', 'clinicDetails', 'clinickey', 'openCount', 'receptionCount', 'cancelledCount', 'completedCount'))->render();



        return response()->json([
            'html' => $html,
            'type' => $type,
            'status' => $status,
            'pagination' => $pagination,
            'success' => 1,
        ]);
    }

    //Medical History
    public function medicalHistory()
    {
        if (!Session::has('user')) {
            return redirect('/');
        }
        $userId = session('user.userID');
        $clinicId = session('user.clinicID');

        $patient = Patient::getPatientByClinicId($userId,$clinicId);

        if (empty($patient)) {
            return redirect()->route('frontend.index');
        }

        $patientDocument = PatientDocs::getPatientDocs($patient->id);
        foreach ($patientDocument as $key => $val) {
            if ($val['doc_path'] != '') {
                $patientDocument[$key]['temdocppath'] = $this->Corefunctions->getAWSFilePath($val['doc_path']);
            }
        }

        $seo['title'] = "Medical History  | " . env('APP_NAME');
        $seo['keywords'] = "Access and manage patient medical history securely. View records, personal health notes, observations, and detailed history for comprehensive healthcare management.";
        $seo['description'] = "Welcome to your trusted healthcare connection. Access virtual care, consult experienced doctors, schedule appointments easily, and receive secure, patient-centered telehealth services.";
        $seo['og_title'] = "Medical History  | " . env('APP_NAME');
        $seo['og_description'] = "Welcome to your trusted healthcare connection. Access virtual care, consult experienced doctors, schedule appointments seamlessly, and enjoy secure, patient-centered telehealth services.";

        return view('frontend.medical-history', compact('patient', 'patientDocument', 'seo'));
    }


    //note update
    public function noteUpdate()
    {

        $notes = request('notes');
        $patientuuid = session('user.clinicuser_uuid');
        $patient = Patient::patientByUUID($patientuuid);

        Patient::updatePatientNotes($patient->id,$notes);

        //Save history into DB
        PatientNoteHistory::insertHistory($patient);

        return redirect()->back()->with('success', 'Medical history note updated successfully!');
    }



    public function profileUpdate()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        if (request()->ajax()) {
            $data = request()->all();

            if (!isset($data['key'])) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
            $userId = session('user.userID');
            $clinicId = session('user.clinicID');

            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));

            if (empty($patientDetails)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Patient does not exists';
                return response()->json($arr);
            }

            $countryCode = isset($patientDetails['user']['country_code']) ? RefCountryCode::getCountryCodeById($patientDetails['user']['country_code']) : RefCountryCode::getCountryCodeById($patientDetails['country_code']);

            $whatsappCountryCode = RefCountryCode::getCountryCodeById($patientDetails['whatsapp_country_code']);

            $state = RefState::getStateList();
 
            $patientDetails['logo_path'] = isset($patientDetails['user']['profile_image']) && ($patientDetails['user']['profile_image'] !='' ) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : ( ($patientDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($patientDetails['logo_path']) : '' );

            $patientDocument = PatientDocs::getPatientDocs($patientDetails['id']);
            foreach ($patientDocument as $key => $val) {
                if ($val['doc_path'] != '') {
                    $patientDocument[$key]['temdocppath'] = $this->Corefunctions->getAWSFilePath($val['doc_path']);
                }
            }

            $data['countryCode'] = $countryCode;
            $data['whatsappCountryCode'] = $whatsappCountryCode;
            $data['patientDetails'] = $patientDetails;
            $data['patientDocument'] = $patientDocument;
            $data['state'] = $state;

            $html = view('frontend.patient-edit', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }


    public function storeDocs(Request $request)
    {
        if (request()->ajax()) {
            $this->Corefunctions = new \App\customclasses\Corefunctions;

            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            $patientuuid = session('user.clinicuser_uuid');
            $patient = Patient::patientByUUID($patientuuid);

            /** upload patiend documents  */
            if (isset($input['patient_docs']) && $input['patient_docs'] != '') {
                foreach ($input['patient_docs'] as $key => $val) {
                    $tempDoc = DB::table('temp_docs')->where('id', $val['tempdocid'])->whereNull('deleted_at')->first();
                    $tempDoc = $this->Corefunctions->convertToArray($tempDoc);
                    $originalpath = TEMPDOCPATH . $tempDoc['tempdoc_uuid'] . '.' . $tempDoc['temp_doc_ext'];
                    $file_size = filesize($originalpath);

                    $docid = PatientDocs::savePatientDocuments($tempDoc, $file_size, $patient);

                    $crppath = $this->Corefunctions->getMyPathForAWS($docid, $dockey, $tempDoc['temp_doc_ext'], 'uploads/patientdocuments/');
                    $image_path = file_get_contents($originalpath);
                    if ($this->Corefunctions->uploadDocumenttoAWS($crppath, $image_path)) {
                        $imagepath = $crppath;
                    }

                    PatientDocs::updatePatientDocImage($docid,$imagepath);

                    unlink($originalpath);
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Document added successfully';
            return response()->json($arr);
        }
    }

    public function removeDocs(Request $request)
    {
        if (request()->ajax()) {

            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }

            $patientDoc = PatientDocs::removePatientDoc($data['uuid']);

            $arr['success'] = 1;
            $arr['message'] = 'Document removed successfully';
            return response()->json($arr);
        }
    }


    public function delete()
    {

        $id = request('uuid');
        $patients_uuid = session('user.clinicuser_uuid');

        $patient = Patient::patientByUUID($patients_uuid);

        $clinicID = session('user.clinicID');
        $userId = session('user.userID');

        $patient = Patient::getPatientDets($userId, $clinicID);
        if($clinicID == ''){
            $patient = Patient::getPatientWithOutClinic($userId);
        }
      
        if (empty($patient)) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Invalid patient';
            return response()->json($arr);
        }

        /* check the patient have any active appoinmnet in this clinic */
        $userTimeZone = session()->get('user.timezone');
        $appointmentDetails = Appointment::appoinmentByPatientWithClinic($userId,$clinicID, $userTimeZone);
        if (!empty($appointmentDetails)) {
            $arr['success'] = 0;
            $arr['errormsg'] = 'You have active appointments with this clinic. Please contact your clinic admin.';
            return response()->json($arr);
            exit();
        }
        

        $countryCode = RefCountryCode::getCountryCodeById( $patient->country_code );
        
        $userOtpData = $this->insertToOtps($patient->phone_number, $countryCode['id']);

        // Return success response with OTP details
        $arr['success'] = 1;
        $arr['otp'] = $userOtpData['userotp'];
        $arr['key'] = $userOtpData['otpUuid'];
        $arr['phonenumber'] = $patient->phone_number;
        $arr['countrycode'] = $countryCode['country_code'];
        $arr['countryCodeShort'] = $countryCode['short_code'];
        $arr['countryId'] = $countryCode['id'];
        $arr['type'] = 'deletepatient';

        $arr['message'] = 'Otp generated successfully';
        return response()->json($arr);
    }

    public function checkPhoneExist()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $phone = preg_replace('/[\s\-\(\)]/', '', $data['phone_number']);
            $uuid = $data['uuid'];
            $email = $data['email'];
            $clinicId = $data['clinic_id'];
            $type = $data['type'];
            $countryCodeShorts = strtoupper(request('country_code'));
            $countryCode =  RefCountryCode::getCountryCodeByShortCode( $countryCodeShorts );

            $clinicDetail = array();
            $userDetails = array();

            //Patient Create from FE
            if ($type == 'patient') {
                $user = User::getUserByPhoneCountryWithTrashed($phone, $countryCode['id']);
                if (!empty($user)) {
                    return 'false';
                }
                return 'true';
            }
        }
    }

    public function checkEmailExist()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $uuid = $data['uuid'];
            $email = $data['email'];
            $clinicId = $data['clinic_id'];
            $type = $data['type'];
            $countryCodeShorts = strtoupper(request('country_code'));
            $countryCode =  RefCountryCode::getCountryCodeByShortCode( $countryCodeShorts );

            //Check For clinic
            if ($type == 'clinic') {
                if (isset($data['email']) && $data['email'] != '') {
                    $user = User::getUserByEmail($email);
                    if (!empty($user)) {
                        return 'false';
                    }
                    $clinicDetails =  Clinic::getClinicCountByEmail($email);
                    if ($clinicDetails > 0 ) {
                        return 'false';
                    }
                }
                return 'true';
            }

            //Patient Create from FE
            if ($type == 'patient') {
                $user = User::getUserByEmail($email);
                if (!empty($user)) {
                    return 'false';
                }
                return 'true';
            }
        }
    }


    public function updatePatient(Request $request)
    {
        if (request()->ajax()) {

            $data = request()->all();

            if (empty($data)) {
                return response()->json(['error' => 1, 'message' => 'Fields missing']);
            }
            if (empty($data['key'])) {
                return response()->json(['error' => 1, 'message' => 'Key missing']);
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            $input['whatsapp_num'] = (isset($input['whatsapp_num']) && $input['whatsapp_num'] != '') ? str_replace(["(", ")", " ","-"], "", $input['whatsapp_num']) : '';

            //dd($input);exit;

            if (empty($data['key'])) {
                return response()->json(['error' => 1, 'message' => 'Patient not found!']);
            }

            $patientDetails = Patient::patientByUUID($data['key']);
            
            $email = $input['email'];
            $phone = $patientDetails->phone_number;
            $clinicId = $patientDetails->clinic_id;

            $countryCode  = RefCountryCode::getCountryCodeByShortCode($input['countryCodeShort']);
            $whatsappcountryCode = RefCountryCode::getCountryCodeByShortCode($input['whatsappcountryCodeShorts']);

            // 1. Check if email exists and if it is associated with the same phone and country code
            $emailExists = Patient::validatePatient($email,$clinicId,$patientDetails->id,$patientDetails->user_id,$phone,$countryCode['id']);
            if(isset($emailExists['error']) && $emailExists['error'] =='1'){
                return $this->Corefunctions->returnError($emailExists['errormsg']);
            }
            $input['phone_number'] = $patientDetails->phone_number;

            /** update Patient info  */
            Patient::updatePatient($patientDetails->id,$input,$whatsappcountryCode,$countryCode);
            if ($input['isremove'] == 1) {
                $crppath = '';
                $patientDetails->logo_path = '';
                $logoPath = asset('images/default_img.png');
                Patient::updatePatientImage($patientDetails->id,$patientDetails->user_id,'');
            }
          
            if ($patientDetails->user_id != NULL) {
                $userDetails = User::userByID($patientDetails->user_id,'all') ;
                $input['username'] = $input['name'];
                User::updateUserData($input,$countryCode,$userDetails);
            }


            $logoPath = ($patientDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($patientDetails['logo_path']) : asset('images/default_img.png');

            $crppath = (isset($patientDetails->logo_path) && ($patientDetails->logo_path != '')) ? $patientDetails->logo_path : '';

            /* User Image Upload */
            if ($input['tempimage'] != "") {
                /* Temp Image Details */
                $tempImageDetails = DB::table("temp_docs")->where("tempdoc_uuid", $input['tempimage'])->first();
                if (!empty($tempImageDetails)) {
                    $originalpath = "storage/app/public/tempImgs/original/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
                    $croppath = "storage/app/public/tempImgs/crop/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;

                    $crppath = $this->Corefunctions->getMyPathForAWS($patientDetails->id, $tempImageDetails->tempdoc_uuid, $tempImageDetails->temp_doc_ext, 'uploads/patients/');

                    $image_path = File::get($croppath);
                    $file_size = filesize($originalpath);
                    if ($this->Corefunctions->uploadDocumenttoAWS($crppath, $image_path)) {
                        $imagepath = $crppath;
                        Patient::updatePatientImage($patientDetails->id,$patientDetails->user_id,$imagepath);
                        $logoPath = $this->Corefunctions->getAWSFilePath($imagepath);
                    }
                    unlink($croppath);
                }
            }

            $countryCodes = RefCountryCode::getCountryCodeById($patientDetails->country_code);

            session()->put('user.country_code', $countryCodes['country_code']);
            session()->put('user.firstName',$input['name']);
            session()->put('user.middleName',$input['middle_name']);
            session()->put('user.lastName',$input['last_name']);
            session(['user.image_path' => $logoPath]);
            // dd(session('user.userLogo'));

            $arr['success'] = 1;
            $arr['message'] = 'Patient updated successfully';
            return response()->json($arr);
        }
    }

    public function index()
    {
        $ishome = '1';

        $seo['title'] =  env('APP_NAME')." – Concierge Medicine | Telehealth Platform";
        $seo['keywords'] = "concierge medicine software, advanced healthcare platform, telehealth practice
management, patient scheduling system, secure virtual care, HIPAA-compliant platform.";
        $seo['description'] = " BlackBag offers advanced concierge medical practice
management. Schedule appointments, automate tasks, and deliver secure virtual care
effortlessly.";
        $seo['og_title'] = env('APP_NAME')." – Concierge Medicine | Telehealth Platform";
        $seo['og_description'] = " BlackBag offers advanced concierge medical practice
management. Schedule appointments, automate tasks, and deliver secure virtual care
effortlessly.";

        return view('frontend.home', compact('seo','ishome'));
    }


    public function landingPage()
    {

        $seo['title'] = " Get Started | " . env('APP_NAME');
        $seo['keywords'] = "advanced telehealth, online doctor consultation, virtual care, concierge medicine,
automated scheduling, secure healthcare, patient engagement";
        $seo['description'] = "Be a pioneer with BlackBag’s advanced telehealth.
Automate note-taking, scheduling, and provide secure virtual care. Join our Early Adopter
Program today!";
        $seo['og_title'] = " Get Started | " . env('APP_NAME');
        $seo['og_description'] = "Be a pioneer with BlackBag’s advanced telehealth.
Automate note-taking, scheduling, and provide secure virtual care. Join our Early Adopter
Program today!";
         $seo['og_image'] = "/images/og_image_getstarted.png";
        return view('frontend.landingpage', compact('seo'));
    }

    public function forDoctors()
    {
        $seo['title'] = "For Doctors | " . env('APP_NAME');
        $seo['keywords'] = "telemedicine for doctors, virtual care platform, advanced healthcare, patient
management software, online consultations, HIPAA-compliant telemedicine";
        $seo['description'] = "Join BlackBag’s doctor community to offer virtual care,
streamline patient management, and grow your practice with advanced telemedicine tools.";
        $seo['og_title'] = "For Doctors | " . env('APP_NAME');
        $seo['og_description'] = "Join BlackBag’s doctor community to offer virtual care,
streamline patient management, and grow your practice with advanced telemedicine tools.";
        $seo['og_image'] = "/images/og_image_doctor.png";
        return view('frontend.for-doctors',compact('seo'));
    }
    public function contactUs()
    {

        $seo['title'] = "Contact Us | " . env('APP_NAME');
        $seo['keywords'] = "telemedicine support, contact BlackBag, healthcare customer service,
HIPAA-compliant platform, virtual care assistance";
        $seo['description'] = "Reach out to BlackBag for expert telemedicine support. Use
our secure form for fast, personalized assistance with your virtual care needs.";
        $seo['og_title'] = "Contact Us | " . env('APP_NAME');
        $seo['og_description'] = "Reach out to BlackBag for expert telemedicine support. Use
our secure form for fast, personalized assistance with your virtual care needs.";
        $seo['og_image'] = "/images/og_image_contactus.png";
        return view('frontend.contact-us', compact('seo'));
    }

    public function findDoctorsAndClinics()
    {

        return view('frontend.find-doctors-and-clinics');
    }
    public function clinicProfile()
    {

        return view('frontend.clinic-profile');
    }
    public function tourismProfile()
    {

        return view('frontend.tourism-profile');
    }



    public function forClinics()
    {
        $seo['title'] = "For Clinics | " . env('APP_NAME');
        $seo['keywords'] = "telemedicine for clinics, clinic management software, secure virtual care, patient
scheduling system, HIPAA-compliant platform, remote healthcare solutions, clinic workflow
optimization";
        $seo['description'] = "Join BlackBag’s global clinic network to enhance patient
care with secure telemedicine, streamline scheduling, and protect data with advanced tools.";
        $seo['og_title'] = "For Clinics | " . env('APP_NAME');
        $seo['og_description'] = "Join BlackBag’s global clinic network to enhance patient
care with secure telemedicine, streamline scheduling, and protect data with advanced tools.";
        $seo['og_image'] = "/images/og_image_forclinic.png";
        return view('frontend.for-clinics', compact('seo'));
    }

    public function pricing()
    {
        $seo['title'] = "Pricing | " . env('APP_NAME');
        $seo['keywords'] = "telemedicine, pay as you go, clinic management software, HIPAA-compliant
platform, ePrescribe, virtual care";
        $seo['description'] = "Explore BlackBag’s transparent pricing with no monthly
subscriptions. Pay $5 per patient consultation and access unlimited telemedicine features for
your clinic.";
        $seo['og_title'] = "Pricing | " . env('APP_NAME');
        $seo['og_description'] = "Explore BlackBag’s transparent pricing with no monthly
subscriptions. Pay $5 per patient consultation and access unlimited telemedicine features for
your clinic.";
        $seo['og_image'] = "/images/og_image_pricing.png";

        return view('frontend.pricing', compact('seo'));
    }


    public function searchResults()
    {

        return view('frontend.search-results');
    }
    public function viewProfile()
    {

        return view('frontend.view-profile');
    }

    public function myReceipt()
    {
        if (!Session::has('user')) {
            return redirect('/');
        }
        if (session()->get('user.userType') == 'patient' || session()->get('user.userType') == 'clinics') {

            $userID = session()->get('user.userID');
            $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;

            $paymentDetails = Payment::getUserPayments($userID, $limit);
            $paymentData = $this->Corefunctions->convertToArray($paymentDetails);
         
            /** get appointment Ids */

            $appintIds = $this->Corefunctions->getIDSfromArray($paymentData['data'], 'parent_id');

            $appointments = $this->Corefunctions->convertToArray(Appointment::getAppointmentsByIds($appintIds));
            $appointment = $this->Corefunctions->getArrayIndexed1($appointments, 'id');
           
            $seo['keywords']    = "Black Bag provides secure access to receipts for appointments and medical consultations. Download payment confirmations for doctor visits and manage patient billing efficiently.";
            $seo['description'] = "Thank you for your payment. Easily access and manage your appointment receipts for consultations, medical services, and treatments. A receipt will be sent after payment confirmation.";
            $seo['title'] = 'My Receipts | BlackBag';
            $seo['og_title'] = "My Receipts | BlackBag";
            $seo['og_description'] = "Thank you for your payment. Easily access and manage your appointment receipts for consultations, medical services, and treatments. A receipt will be sent after successful payment.";

            return view('frontend.myreceipt', compact('paymentDetails', 'paymentData', 'limit', 'appointment', 'seo'));
        } else {
            return redirect('/');
        }
    }

    public function viewReceipt()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $paymentDetails = Payment::getpaymentsByKey($data['key']);


            $imagePath2 =  $this->invoiceHtmlToPdf($data['key']);


            $filename = $this->Corefunctions->getMyPathForAWS($paymentDetails['id'], $paymentDetails['payment_uuid'], 'pdf', "receipt/");
            //print_r($imagePath2);die;
            $this->Corefunctions->uploadDocumenttoAWS($filename, file_get_contents($imagePath2));
            $invoicePath = $this->Corefunctions->getAWSFilePath($filename);

            $html = view('payments.viewinvoice', compact('invoicePath'));
            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function viewReceiptById()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $paymentDetails = Payment::getpaymentsById($data['id']);


            $imagePath2 =  $this->invoiceHtmlToPdf($paymentDetails['payment_uuid']);


            $filename = $this->Corefunctions->getMyPathForAWS($paymentDetails['id'], $paymentDetails['payment_uuid'], 'pdf', "receipt/");
            //print_r($imagePath2);die;
            $this->Corefunctions->uploadDocumenttoAWS($filename, file_get_contents($imagePath2));
            $invoicePath = $this->Corefunctions->getAWSFilePath($filename);

            $html = view('payments.viewinvoice', compact('invoicePath'));
            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function invoiceHtmlToPdf($paymentKey)
    {

        $url      = url("viewrecieptdetails") . "/" . $paymentKey;

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


    public function receiptDownload($key)
    {


        $paymentDetails = $this->Corefunctions->convertToArray(DB::table('payments')->where('payment_uuid', $key)->limit(1)->first());


        $imagePath2 =  $this->invoiceHtmlToPdf($key);
        $filename = $this->Corefunctions->getMyPathForAWS($paymentDetails['id'], $paymentDetails['payment_uuid'], 'pdf', "receipt/");
        $fileName = 'Receipt_#' . $paymentDetails['receipt_num'] . '.pdf';
        $this->Corefunctions->uploadDocumenttoAWS($filename, file_get_contents($imagePath2));
        $invoicePath = $this->Corefunctions->getAWSFilePath($filename);



        if (@file_get_contents($invoicePath) == true) {
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . $fileName . "\"");
            readfile($invoicePath);
        }
        exit;
    }


    public function fileCabinet()
    {
        if (Session::has('user') && session()->get('user.userType') != 'patient') {
            return redirect('/dashboard');
        }

        $seo['keywords']    = "Secure file storage for medical records. Upload and manage files, create folders, store lab results, X-rays, treatment plans, PDF summaries, and health history notes efficiently.";
        $seo['description'] = "A secure and centralized solution for managing patient records. Store and organize medical documents, test results, treatment plans, and health history with ease.";
        $seo['title'] = 'File Cabinet | BlackBag';
        $seo['og_title'] = "File Cabinet | BlackBag";
        $seo['og_description'] = "A secure, centralized solution for managing patient records. Safely store and organize medical documents, test results, and health history for easy access and efficiency.";
        return view('frontend.filecabinet.listing', compact('seo'));
    }
    public function files($key)
    {
        $folder = FcUserFolder::folderByKey($key);
        if (empty($folder)) {
            return redirect()->route('frontend.index');
        }
        if ($folder['user_id'] != session('user.userID')) {
            return redirect()->route('frontend.index');
        }

        $files = FcFile::getFiles($folder['id'], session('user.userID'));
        $userIDs = $this->Corefunctions->getIDSfromArray($files, 'created_by');
        $userDetails = $this->Corefunctions->convertToArray(User::whereIn('id', $userIDs)->whereNull('deleted_at')->get());
        $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'id');

        $seo['keywords']    = "File cabinet,File uploads ,storage,Folder creation,Medical history, Medical records,lab results,xrays,Treatment plans, PDF summaries,Medical History Files, Health Notes and Observations.";
        $seo['description'] = "A secure solution for organizing and managing patient records and important medical documents. Safely store and organize sensitive medical records, test results, and patient history in one centralized location. ";
        $seo['title'] = 'Filecabinet | BlackBag';
        return view('frontend.filecabinet.fileslisting', compact('files', 'folder', 'userDetails', 'seo'));
    }
    public function storeFolder()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            parse_str($data['formdata'], $input);

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');
            $userType = (isset($usertype) && $usertype == 'patient') ? '2' : '3';

            FcUserFolder::addFolder($input['folder_name'], $patientID, $clinicID, $userType, session('user.userID'));

            $arr['success'] = 1;
            $arr['message'] = "Folder created successfully";
            return response()->json($arr);
        }
    }
    public function getFolders()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');
            $userId = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['patientID'];
            $patient = $this->Corefunctions->convertToArray(Patient::where('user_id', $userId)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());
            if (isset($usertype) && $usertype == 'patient') {
                $folders = FcUserFolder::getFolders($userId);
            } else {
                $folders = FcUserFolder::getFoldersByClinicId($userId, $clinicID);
            }
            $userIDs = $this->Corefunctions->getIDSfromArray($folders, 'created_by');
            $userDetails = $this->Corefunctions->convertToArray(User::whereIn('id', $userIDs)->whereNull('deleted_at')->get());
            $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'id');

            $data['folders'] = $folders;
            $data['patient'] = $patient;
            $data['userDetails'] = $userDetails;

            $html = view('frontend.filecabinet.folders', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }
    public function editFolder()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $folder = FcUserFolder::folderByKey($data['key']);
            if (empty($folder)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Folder';
                return response()->json($arr);
                exit();
            }

            $usertype = Session::get('user.userType');
            $userId = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['patientID'];
            $patient = $this->Corefunctions->convertToArray(Patient::where('user_id', $userId)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());

            $data['patient'] = $patient;
            $data['folder'] = $folder;

            $html = view('frontend.filecabinet.editfolder', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }
    public function updateFolder()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            parse_str($data['formdata'], $input);

            FcUserFolder::updateFolder($data['key'], $input['edit_folder_name']);

            $arr['success'] = 1;
            $arr['message'] = "Folder updated successfully";
            return response()->json($arr);
        }
    }
    public function getFiles()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $folder = FcUserFolder::folderByKey($data['key']);
            if (empty($folder)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Folder';
                return response()->json($arr);
                exit();
            }
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');
            $usertype = Session::get('user.userType');
            $userId = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['patientID'];
            $patient = $this->Corefunctions->convertToArray(Patient::where('user_id', $userId)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());

            if (isset($usertype) && $usertype == 'patient') {
                $files = FcFile::getFiles($folder['id'], $userId);
            } else {
                $files = FcFile::getFilesByClinicId($folder['id'],$userId, $clinicID);
            }
            $userIDs = $this->Corefunctions->getIDSfromArray($files, 'created_by');
            $userDetails = $this->Corefunctions->convertToArray(User::whereIn('id', $userIDs)->whereNull('deleted_at')->get());
            $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::whereIn('user_id', $userIDs)->with('designation')->get());
            $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'id');
            $clinicUser = $this->Corefunctions->getArrayIndexed1($clinicUser, 'user_id');

            $data['folder'] = $folder;
            $data['files'] = $files;
            $data['patient'] = $patient;
            $data['userDetails'] = $userDetails;
            $data['clinicUser'] = $clinicUser;

            $html = view('frontend.filecabinet.files', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }
    public function uploadFile()
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $docs = $data['file'];
            if (empty($docs)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $size = filesize($data['file']);
            $fileSizeInMB = $size / (1024 * 1024);
            $fileSizeInMB = round($fileSizeInMB, 2);
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
            exit();
        }
    }
    public function storeFile()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $folder = FcUserFolder::folderByKey($data['key']);
            if (empty($folder)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Folder';
                return response()->json($arr);
                exit();
            }

            parse_str($data['formdata'], $input);

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');
            $userType = (isset($usertype) && $usertype == 'patient') ? '2' : '3';

            /** upload files  */
            if (isset($input['patient_files']) && !empty($input['patient_files'])) {
                foreach ($input['patient_files'] as $val) {
                    $tempDoc = FcFile::getTempDocById($val['tempdocid']);
            
                    if ($tempDoc) {
                        $originalPath = TEMPDOCPATH . $tempDoc->tempdoc_uuid . '.' . $tempDoc->temp_doc_ext;
                        $fileSize = filesize($originalPath);
            
                        $fileExists = FcFile::fileExists($folder['id'], $tempDoc->original_name);
                        $fileName = $fileExists
                            ? $this->Corefunctions->getFileName($folder['id'], $tempDoc->original_name, $tempDoc->temp_doc_ext, 'fc_files', 'file_name')
                            : $tempDoc->original_name;
            
                        $fileKey = $this->Corefunctions->generateUniqueKey(10, 'fc_files', 'file_key');
                        $fileId = FcFile::addFile($fileKey, $patientID, $folder['id'], $tempDoc, $userType, $clinicID, session('user.userID'), $fileName);
            
                        $awsPath = $this->Corefunctions->getMyPathForAWS($fileId, $fileKey, $tempDoc->temp_doc_ext, 'uploads/patientfiles/');
                        $imageContent = file_get_contents($originalPath);
            
                        if ($this->Corefunctions->uploadDocumenttoAWSPrivate($awsPath, $imageContent)) {
                            FcFile::updateFilePath($fileId, $awsPath);
                        }
            
                        unlink($originalPath);
                    }
                }
            
                // Update folder timestamp
                FcUserFolder::updateFolderTimestamp($data['key']);
            }

            $arr['success'] = 1;
            $arr['message'] = "File uploaded successfully";
            return response()->json($arr);
        }
    }
    public function removeFile(Request $request)
    {
        if (request()->ajax()) {

            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }

            $file = FcFile::fileByKey($data['uuid']);
            if (empty($file)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid File';
                return response()->json($arr);
                exit();
            }
            if ($file['created_by'] != session('user.userID')) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'You do not have permission to delete this file';
                return response()->json($arr);
                exit();
            }

            FcFile::removeFile($data['uuid']);

            $arr['success'] = 1;
            $arr['message'] = 'File removed successfully';
            return response()->json($arr);
        }
    }
    public function removeFolder(Request $request)
    {
        if (request()->ajax()) {

            $data = request()->all();
            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }

            $folder = FcUserFolder::folderByKey($data['uuid']);
            if (empty($folder)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Folder';
                return response()->json($arr);
                exit();
            }
            if ($folder->created_by != session('user.userID')) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'You do not have permission to delete this folder';
                return response()->json($arr);
                exit();
            }

            FcUserFolder::removeFolder($data['uuid']);
            DB::table('fc_user_folders')->where('fc_user_folder_uuid', $data['uuid'])->update(array(
                'deleted_at' => carbon::now()
            ));

            $arr['success'] = 1;
            $arr['message'] = 'Folder removed successfully';
            return response()->json($arr);
        }
    }

    public function downloadFile($key)
    {
        $tempImageDetails = FcFile::fileByKey($key);
        $filename = $tempImageDetails['orginal_name'];
        $Docname = $tempImageDetails['file_key'] . '.' . $tempImageDetails['file_ext'];
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $temdocppath = $this->Corefunctions->getAWSPathPrivate($tempImageDetails['file_path']);
        return response()->streamDownload(function () use ($temdocppath) {
            readfile($temdocppath);
        }, $filename, $headers);
        exit;
    }
    public function appointmentDetails($uuid)
    {
        if (!$uuid) {
            return redirect('/myappointments')->with('error', "Failed to find data or Invalid key passed!");
        }
        if (!Session::has('user')) {
            return redirect('/');
        }
        $userTimeZone = session()->get('user.timezone');
        $clinicId = session()->get('user.clinicID');
        $appointment = Appointment::getAppointmentByUuid($uuid);
        $appointment = $this->Corefunctions->convertToArray($appointment);
       
        if (empty($appointment)) {
            return redirect('/myappointments')->with('error', 'Failed to fetch appointment data!');
        }

        // Fetch doctor and transform logo path
        $doctor = ClinicUser::getUserByUserId($appointment['consultant_id'], $clinicId);
        if ($doctor) {
            $doctor->logo_path = $doctor->user->profile_image ? $this->Corefunctions->getAWSFilePath($doctor->user->profile_image) : '';
        }

        // Fetch nurse and transform logo path
        $nurse = ClinicUser::getUserByUserId($appointment['nurse_id'], $clinicId);
        if ($nurse) {
            $nurse->logo_path = $nurse->user->profile_image ? $this->Corefunctions->getAWSFilePath($nurse->user->profile_image) : '';
        }

        $patientphone = '';
        $room = VideoCall::getVideoCallByAppointmentId($appointment['id']);
        $participants = $videoParticipantOthers = $videoParticipantPatients = array();
        if (!empty($room)) {
            $participants = VideoCallParticipant::getParticipantsByCallId($room->id);
            $participantsClinic = VideoCallParticipant::getClinicParticipantsByCallId($room->id);
            $participantsClinic = $this->Corefunctions->convertToArray($participantsClinic);
            $videoParticipantPatients = VideoCallParticipant::getVideoParticipantPatients($room->id);
            $videoParticipantOthers = VideoCallParticipant::getVideoParticipantOthers($room->id);

            $videoParticipantOthers = $this->Corefunctions->convertToArray($videoParticipantOthers);
            $videoParticipantPatients = $this->Corefunctions->convertToArray($videoParticipantPatients);
        }

        $clinicuserIDS = $this->Corefunctions->getIDSfromArray($videoParticipantOthers, 'participant_id');
        $patientIDS = $this->Corefunctions->getIDSfromArray($videoParticipantPatients, 'participant_id');

        $clinicUserDetails = [];
        if (!empty($clinicuserIDS)) {
            $clinicUserDetails = ClinicUser::getClinicUsersByUserIds($clinicuserIDS);
            $clinicUserDetails = $this->Corefunctions->convertToArray($clinicUserDetails);
            $clinicUserDetails = $this->Corefunctions->getArrayIndexed1($clinicUserDetails, 'user_id');
        }

        $patientDetails = [];
        if (!empty($patientIDS)) {
            $patientDetails = Patient::getPatientsByUserIds($patientIDS);
            $patientDetails = $this->Corefunctions->convertToArray($patientDetails);
            $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'user_id');
        }

        // Fetch patient details
        $patient = Patient::getPatientByClinicId($appointment['patient_id'], $clinicId);
        if ($patient) {
            $patient->logo_path = isset($patient->user->profile_image) && $patient->user->profile_image != '' ? $this->Corefunctions->resizeImageAWS($patient->user->id, $patient->user->profile_image, $patient->user->first_name, 180, 180, '1') : ($patient->logo_path ? $this->Corefunctions->getAWSFilePath($patient->logo_path) : '');
            $patient->age = $this->Corefunctions->calculateAge($patient->dob);
            $patientphone = $this->Corefunctions->formatPhone($patient->phone_number);
        }

        // Fetch country code
        $countryCode = $patient && $patient->country_code ? RefCountryCode::getCountryCodeById($patient->country_code) : null;

        $appointmentTypes = AppointmentType::all()->keyBy('id')->toArray();
        $userDets = User::userByID($appointment['created_by']);

        $clinicUserDets = ClinicUser::getClinicUserByUserId($appointment['consultant_id']);

        $bookedBy = (Session::get('user.userID') == $appointment['created_by']) ? 'Self' : $userDets->first_name;
        $clinicianName = $this->Corefunctions->showClinicanName($clinicUserDets);

        $previousAppointments = Appointment::getPreviousAppointments($appointment['patient_id'], $appointment['id'], $appointment['created_at']);
        $appointmentNotes = Appointment::getAppointmentNotes($appointment['id']);

        $seo['title'] = "Appointments  | " . env('APP_NAME');
        $seo['keywords'] = "Manage Appointments Online, Track Appointment Status, In-person Doctor Appointments, Virtual Healthcare Appointments, Clinican Schedule,Upcoming Appointments, Past Appointment History, Doctor Appointment Details,Appointment Date and Time Management, Effortless Healthcare Scheduling, Check Appointment Status, Appointment Booking Actions ";
        $seo['description'] = "Manage your appointments efficiently with our user-friendly platform. Book online or in-person appointments, check your upcoming schedule, view consulting doctor details, and track appointment status effortlessly. Stay updated on your healthcare consultations with real-time notifications, ensuring a seamless experience";
        $seo['og_title'] = "Appointments  | " . env('APP_NAME');
        $seo['og_description'] = "Manage your appointments efficiently with our user-friendly platform. Book online or in-person appointments, check your upcoming schedule, view consulting doctor details, and track appointment status effortlessly. Stay updated on your healthcare consultations with real-time notifications, ensuring a seamless experience";
        return view('frontend.appointmentdetails', compact('userTimeZone', 'appointment', 'patient', 'doctor', 'clinicUserDetails', 'nurse', 'countryCode', 'appointmentTypes', 'room', 'bookedBy', 'previousAppointments', 'appointmentNotes', 'participants', 'seo', 'patientphone', 'patientDetails', 'clinicianName'));
    }
    public function getSummary()
    {
        $data = request()->all();

        $fileDets = FcFile::fileByKey($data['filekey']);
        $data['fileDets'] = $fileDets;

        $html = view('frontend.filecabinet.appendpdfpreview', $data);

        $arr['view'] = $html->__toString();
        $arr['success'] = 1;
        return response()->json($arr);
    }

    public function getAISummary()
    {
        $data = request()->all();

        $fileDets = FcFile::fileByKey($data['filekey']);
        $data['fileDets'] = $fileDets;

        $html = view('frontend.filecabinet.appendsummary', $data);

        $arr['view'] = $html->__toString();
        $arr['summary'] = $fileDets['summarized_data'];
        $arr['success'] = 1;
        return response()->json($arr);
    }


    public function privacyPolicy()
    {
        $seo['title'] = "Privacy Policy  | " . env('APP_NAME');
        $seo['keywords'] = "BlackBag,Effortless Appointment Scheduling,Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation,Patient Privacy Protection, Healthcare Scheduling Made Simple, Easy Medical Appointment Scheduling,Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare,Access Healthcare Anytime, Experienced Doctors Online, virtual care, medical specialties, appointment scheduling, and data security";
        $seo['description'] = "Read our privacy policy to understand how we protect your personal information and ensure your data privacy on BlackBag.";
        $seo['og_title'] = "Privacy Policy | " . env('APP_NAME');
        $seo['og_description'] = "Read our privacy policy to understand how we protect your personal information and ensure your data privacy on BlackBag";

        return view('frontend.privacy-policy', compact('seo'));
    }

    public function termsConditions()
    {
        $seo['title'] = "Terms and Conditions | " . env('APP_NAME');
        $seo['keywords'] = "BlackBag,Terms and conditions,Effortless Appointment Scheduling, Trusted Healthcare Experts,Book Medical Appointments Online, Online Doctor Consultation,Patient Privacy Protection,Healthcare Scheduling Made Simple, Easy Medical Appointment Scheduling, Patient Friendly Healthcare Platform,Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care, medical specialties, appointment scheduling, and data security.";
        $seo['description'] = "Read the terms and conditions for using BalckBag's services. Understand your rights and obligations before you begin.";
        $seo['og_title'] = "Terms and conditions | " . env('APP_NAME');
        $seo['og_description'] = " Read the terms and conditions for using BalckBag's services. Understand your rights and obligations before you begin.";

        return view('frontend.terms-and-condition', compact('seo'));
    }

    public function getCards()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        if (request()->ajax()) {
            $data = request()->all();

            $userId = session('user.userID');

            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));

            if (empty($patientDetails)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Patient does not exists';
                return response()->json($arr);
            }

            $userCards = PatientCard::getUserCards($userId);
            if (!empty($userCards) ) {
                foreach ($userCards as $key => $cards) {
                    $userCards[$key]['expiry'] = $cards['exp_month'].'/'.$cards['exp_year'];
                }
            }
            $userDetails = $this->Corefunctions->convertToArray(User::userByID($userId));
            $clientSecret = '';
            if( empty($userCards) && !empty($patientDetails) ){
                $patientDetails['name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($patientDetails,Session::get('user.email')); 
                if(!empty($clientSecretResponse)){
                    $clientSecret = $clientSecretResponse['response'];
                    if($userDetails['stripe_customer_id'] == ''){
                        Payment::updateUserStripeCustomerIdInPatients($patientDetails['id'],$clientSecretResponse['customerID']);
                        Payment::updateUserStripeCustomerIdInUsers($userDetails['id'],$clientSecretResponse['customerID']);
                    }
                }
            }

            $data['clientSecret'] = $clientSecret;
            $data['userCards'] = $userCards;
            $data['patientDetails'] = $patientDetails;
            $data['type'] = 'mycards';

            $html = view('frontend.mycards', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function subscriptions(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Fields Missing',
                ]);
            }

            $userId = session('user.userID');
            $clinics = Patient::getClinics($userId);

            $html = view('frontend.subscriptions', compact('clinics'));
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function getPlans(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Fields Missing',
                ]);
            }

            $subscriptionPlans = Patient::getClinicSubscriptions($data['clinic_id']);

            $html = view('frontend.subscriptionplans', compact('subscriptionPlans'));
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function purchasePlan(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
               return response()->json([
                    'status' => 0,
                    'message' => 'Fields Missing',
                ]);
            }
            $clinic = Clinic::clinicByID( $data['clinic_id'] );
            if (empty($clinic)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Invalid Clinic',
                ]);
            }

            $userId = session('user.userID');
            $patientDetails = Patient::getPatientsByUserId($userId, $data['clinic_id']);

            $subscriptionDets = ClinicSubscription::getClinicSubscriptionByKey($data['clinic_id'],$data['key']);
            if (empty($subscriptionDets)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Invalid Subscription',
                ]);
            }
            if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Stripe not connected',
                ]);
            }
            $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();

            // Payment to clinic //
            $result = $this->Corefunctions->subscriptionPayment($stripeConnection->stripe_user_id,$patientDetails,$input,$subscriptionDets['monthly_amount'],$data['clinic_id']);
            $paymentIds = $result['paymentIds'];
            $cardDetails = $result['cardDetails'];

            $historyId = PatientSubscription::insertPatientSubscriptionHistory($data['clinic_id'],$patientDetails['id'],$subscriptionDets,$paymentIds['id']);
            PatientSubscription::insertPatientSubscription($data['clinic_id'],$patientDetails['id'],$subscriptionDets,$historyId);

            $arr['message'] = 'Subscription plan purchased successfully.';
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function dashboard(){
        if (!Session::has('user')) {
            return redirect('/');
        }
        $userId = session('user.userID');
        $clinicId = session('user.clinicID');
      
        $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));

        if (empty($patientDetails)) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Patient does not exists';
            return response()->json($arr);
        }

        $patientDetails['logo_path'] = isset($patientDetails['user']['profile_image']) && ($patientDetails['user']['profile_image'] !='' ) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : ( ($patientDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($patientDetails['logo_path']) : '' );
        $patientDetails['age'] = $this->Corefunctions->calculateAge($patientDetails['dob']);

        $upcomingAppointment = Appointment::getUpcomingAppointment($patientDetails['user_id']);
        if(!empty( $upcomingAppointment )){
            /** get consutant details */
            $clinicUserDetails =  $this->Corefunctions->convertToArray(ClinicUser::getUserByUserId($upcomingAppointment['consultant_id'],$upcomingAppointment['clinic_id']));
            $upcomingAppointment['consultant_clinic_user'] = $clinicUserDetails ;

            $upcomingAppointment['clinic_logo'] = isset($upcomingAppointment['logo']) && ($upcomingAppointment['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($upcomingAppointment['logo']) : asset("images/default_clinic.png");

            $speciality = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->where('id',$upcomingAppointment['consultant_clinic_user']['specialty_id'])->first());
            $upcomingAppointment['speciality'] = !empty($speciality) ? $speciality['specialty_name'] : null;

          
        }

        $userID = session('user.userID');
        $clinicuser_uuid = session()->get('user.clinicuser_uuid');
        $userType = session()->get('user.userType');
        $userTimeZone = session()->get('user.timezone');

        $loginUserDetails = Patient::patientByUUID($clinicuser_uuid);
        $appointmentData = Appointment::getAppointment($userType,$userID,$userTimeZone);

        $todayAppointmentsCount = $appointmentData['todayAppointmentsCount'] ;
        $appointmentDates       = $appointmentData['appointmentDates'] ;
        $appointmentDetails     = $appointmentData['appointmentDetails'] ;

        $bpReadings = BpTracker::getLastMedicalHistory($userID,'bp_tracker');
        $glucoseReadings = BpTracker::getLastMedicalHistory($userID,'glucose_tracker');
        $oxygenReadings = BpTracker::getLastMedicalHistory($userID,'oxygen_saturations');
        
        $finalChats = $this->getRecentChats();
      

        $seo['title'] = "Dashboard | " . env('APP_NAME');
        $seo['keywords'] = "Telemedicine for clinics, global partnerships, secure virtual care, clinic scheduling, remote healthcare, 24/7 support, digital solutions, and medical data security.";
        $seo['description'] = "Join our global clinic network to enhance patient care with telemedicine. Streamline operations, secure data, and offer seamless virtual care with 24/7 support.";
        $seo['og_title'] = "Dashboard | " . env('APP_NAME');
        $seo['og_description'] = "Join our global network of clinics to enhance patient care with telemedicine. Streamline operations, secure data, and offer seamless virtual care with 24/7 support.";

        return view('frontend.dashboard', compact('seo','patientDetails','upcomingAppointment','bpReadings','glucoseReadings','oxygenReadings','appointmentDates','finalChats'));
    }

    public function getGraphData()
    {
        if (request()->ajax()) {
            $userTimeZone = session()->get('user.timezone');
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if (!isset($data['type'])) {
                return $this->Corefunctions->returnError('Form missing');
            }
            $formType = $data['type'];
            $usertype = Session::get('user.userType');
            $userId = session('user.userID');
            $patient = $this->Corefunctions->convertToArray(Patient::where('user_id', $userId)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());
            $medicathistoryDetails  =  $fields =  $medicathistoryChart = array();
            $startDate = isset($data['startDate']) ? $data['startDate'] : '';
            $endDate =  isset($data['endDate']) ? $data['endDate'] : '';
            $label =  isset($data['label']) ? $data['label'] : 'recent';
            $page      = isset($data['page']) ? $data['page'] : 1;
            $pagelimit      = isset($data['pagelimit']) ? $data['pagelimit'] : 1;
            switch ($formType) {
                case 'bp':
                    $fields = ['systolic', 'diastolic','pulse'];
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId,'bp_tracker',$startDate,$endDate,$label,'patient',$page,$pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'] ;
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'] ;

                    break;
                case 'glucose':
                    $fields = ['bgvalue','a1c'];
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId,'glucose_tracker',$startDate,$endDate,$label,'patient',$page,$pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'] ;
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'];

                    break;
                case 'oxygen-saturations':
                    $fields = ['saturation'];
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId,'oxygen_saturations',$startDate,$endDate,$label,'patient',$page,$pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'] ;
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'] ;

                    break;
                default:
                    break;
            }

            // **Format Data for Charts**
            $labels = [];
            $values = [];
            $isrpm = 0 ;
           
            if(!empty($medicathistoryChart)){
                foreach ($medicathistoryChart as $record) {
                    // $labels[] = $this->Corefunctions->timezoneChange($record['created_at'], "m/d");
                    $labels[] = $this->Corefunctions->timezoneChange($record['created_at'], "d M Y");
                    $graphvalues = []; // Reset this variable for each record
                    foreach ($fields as $field) {
                        $graphvalues[$field] = isset($record[$field]) ? $record[$field] : null;
                    }
                    $values[] = $graphvalues;
                    if( isset( $record['rpm_deviceid']) && $record['rpm_deviceid']){
                        $isrpm = 1;
                    }
                   
                }
            }
            $arr['isrpm'] =  $isrpm ;
            $arr['success'] = 1;
            $arr['labels'] =  $labels;
            $arr['values'] =  $values;
            $arr['startDate'] = $startDate ;
            $arr['endDate'] = $endDate;
            $arr['label'] = $label;

            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

    public function myAccounts()
    {
        if (!Session::has('user') ) {
            return redirect('/');

        }
        $userId = session('user.userID');
        $clinicId = session('user.clinicID');

        $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
     
        if (empty($patientDetails)) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Patient does not exists';
            return response()->json($arr);
        }
        $statusIDS = array('-1','1');
        $deviceOrdersCount = RpmOrders::getPendingRpmOrdersCount($statusIDS,$clinicId,$userId,$patientDetails['id']);
        $seo['title'] = "My Accounts | " . env('APP_NAME');
        $seo['keywords'] = "BlackBag,Terms and conditions,Effortless Appointment Scheduling, Trusted Healthcare Experts,Book Medical Appointments Online, Online Doctor Consultation,Patient Privacy Protection,Healthcare Scheduling Made Simple, Easy Medical Appointment Scheduling, Patient Friendly Healthcare Platform,Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care, medical specialties, appointment scheduling, and data security.";
        $seo['description'] = "Read the terms and conditions for using BalckBag's services. Understand your rights and obligations before you begin.";
        $seo['og_title'] = "My Accounts | " . env('APP_NAME');
        $seo['og_description'] = " Read the terms and conditions for using BalckBag's services. Understand your rights and obligations before you begin.";

        return view('frontend.myaccounts', compact('seo','deviceOrdersCount'));
    }

    public function bookAppointment(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $input =  array();
            if(!empty($data['formdata'])){
                parse_str($data['formdata'], $input);
            }
            $clinicuseruuid = (isset($data['clinicuseruuid']) && $data['clinicuseruuid'] != '') ? $data['clinicuseruuid'] : '';

            $userID = Session::get('user.userID');
            $clinicIDs = Clinic::getPatientTaggedClinicIDs($userID);
            $clinics = Clinic::getClinics($clinicIDs);
            if(!empty($clinics)){
                foreach($clinics as $key => $clinic){
                    $clinics[$key]['clinic_logo'] = isset($clinic['logo']) && ($clinic['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinic['logo']) : asset("images/default_clinic.png");
                }
            }
            $clinicUsers = ClinicUser::getLicencedPractitioners($clinicIDs);

            if(!empty($clinicUsers)){
                foreach($clinicUsers as $key => $value){
                    $speciality = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->where('id',$value['specialty_id'])->first());
                    $clinicUsers[$key]['speciality'] = !empty($speciality) ? $speciality['specialty_name'] : null;
                    $clinicUsers[$key]['clinic_logo'] = isset($value['logo']) && ($value['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($value['logo']) : asset("images/default_clinic.png");
                }
            }

            $html = view('frontend.bookappointment', compact('clinicUsers','clinics','input','clinicuseruuid'));
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function getClinicUsers(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            //for clear filter logic
            if($data['clinic_id'] == ''){
                 $userID = Session::get('user.userID');
                $clinicIDs = Clinic::getPatientTaggedClinicIDs($userID);
                $clinics = Clinic::getClinics($clinicIDs);
                if(!empty($clinics)){
                    foreach($clinics as $key => $clinic){
                        $clinics[$key]['clinic_logo'] = isset($clinic['logo']) && ($clinic['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinic['logo']) : asset("images/default_clinic.png");
                    }
                }
                $clinicUsers = ClinicUser::getLicencedPractitioners($clinicIDs);

            }else{
                $clinicUsers = ClinicUser::getClinicLicencedPractitioners($data['clinic_id']);
            }
            
            if(!empty($clinicUsers)){
                foreach($clinicUsers as $key => $value){
                    $speciality = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->where('id',$value['specialty_id'])->first());
                    $clinicUsers[$key]['speciality'] = !empty($speciality) ? $speciality['specialty_name'] : null;
                    $clinicUsers[$key]['clinic_logo'] = isset($value['logo']) && ($value['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($value['logo']) : asset("images/default_clinic.png");
                }
            }
            $html = view('frontend.clinicusers', compact('clinicUsers'));
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function getTimeSlots(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $input =  array();
            if(!empty($data['formdata'])){
                parse_str($data['formdata'], $input);
            }

            $clinicUser = ClinicUser::getClinicUserDets($data['clinicUserUuid']);
            $speciality = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->where('id',$clinicUser['specialty_id'])->first());
            $clinicUser['speciality'] = !empty($speciality) ? $speciality['specialty_name'] : null;
            $clinicUser['clinic_logo'] = isset($clinicUser['logo']) && ($clinicUser['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinicUser['logo']) : asset("images/default_clinic.png");
        
            $date = (!empty($input) && isset($input['appointmentdate']) && $input['appointmentdate'] != '') ? date('Y-m-d',strtotime($input['appointmentdate'])) : date('Y-m-d');

            $timeslots = $this->Corefunctions->getAvailableTimeSlots($date,$clinicUser['user_id']);
           
            $html = view('frontend.timeslot', compact('clinicUser','timeslots','input'));
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function fetchAvailableSlots(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            if (Session::has('user') && session()->get('user.userType') != 'patient') {
                $clinicId = session('user.clinicID');
                $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::getUserByUserId($data['doctorID'], $clinicId));
            }else{
                $clinicUser = ClinicUser::getClinicUserDets($data['clinicuseruuid']);
            }
            $timeslots  =array();
            $date = date('Y-m-d',strtotime($data['appointmentdate']));
              // ✅ Check Vacation Table Before Fetching Slots
            $isOnVacation = DB::table('vacations')->where('user_id',$clinicUser['user_id'])
              ->where(function ($query) use ($date) {
                  $query->where(function ($q) use ($date) {
                      // Specific date vacation
                      $q->where('vacation_type', 'specific')
                          ->whereDate('vacation_from', $date);
                  })->orWhere(function ($q) use ($date) {
                      // Range vacation
                      $q->where('vacation_type', 'range')
                          ->whereDate('vacation_from', '<=', $date)
                          ->whereDate('vacation_to', '>=', $date);
                  });
              })
              ->exists();
           
            if(empty($isOnVacation)){
                $timeslots = $this->Corefunctions->getAvailableTimeSlots($date,$clinicUser['user_id']);
            }
              


            $html = view('frontend.appendtimeslots', compact('timeslots'));
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function submitAppointment(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $formdata = $data['formdata'];
            parse_str($data['formdata'], $input);

            $clinicUser = ClinicUser::getClinicUserDets($input['clinicuseruuid']);
            $speciality = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->where('id',$clinicUser['specialty_id'])->first());
            $clinicUser['speciality'] = !empty($speciality) ? $speciality['specialty_name'] : null;
            $clinicUser['clinic_logo'] = isset($clinicUser['logo']) && ($clinicUser['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinicUser['logo']) : asset("images/default_clinic.png");

            $clinicId = $clinicUser['clinic_id'];
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId)); 
            $subscriptionDets =  array();
            if(session()->get('user.userID') != ''){
                $patientDets = Patient::patientByUser(session()->get('user.userID'));
                $subscriptionDets = PatientSubscription::getPatientSubscription($patientDets['id']);
            }

            if(!empty($subscriptionDets)){
                $amount = $subscriptionDets['virtual_fee'];
            }else{
                $amount = $clinicDetails['virtual_fee'];
            }

            $html = view('frontend.appendsummary', compact('clinicUser','input','formdata','amount'));
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function confirmBooking(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            parse_str($data['formdata'], $input);

            $clinicUser = ClinicUser::getClinicUserDets($input['clinicuseruuid']);

            $userTimeZone = session()->get('user.timezone');
            $dateTimeString = $input['appointmentdate'] . ' ' . $input['appointment_time'];
            $dateTime = \DateTime::createFromFormat('m/d/Y h:i A',$dateTimeString,new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedDate = $dateTime->format('Y-m-d');
            $formattedTime = $dateTime->format('H:i:s');

            $input['patient'] = session()->get('user.userID');
            $userId = $clinicUser['user_id']; 
            $clinicId = $clinicUser['clinic_id'];

            $appointmentDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeString, $userTimeZone);

            // Get the current datetime in the user's timezone
            $currentDateTime = Carbon::now($userTimeZone);

            // Check if the appointment date and time is in the past
            if ($appointmentDateTime->lt($currentDateTime)) {
                $arr['success'] = 0;
                $arr['message'] = 'The selected appointment time is in the past.';
                return response()->json($arr);
            }
            /** check the patient have same appointment with other doctors */
            $appointmentExists = Appointment::isAppointmentExists($clinicId,$formattedDate,$formattedTime,$input['patient'] ?? null,null,$userId);
            if ($appointmentExists) {
                return response()->json([
                    'success' => 0,
                    'message' => 'An appointment is already scheduled for that time',
                ]);
            }
            
            $expiredDate = new \DateTime($formattedDate. ' ' . $formattedTime);
            // Add 1 hour to the current DateTime object
            $expiredDate->modify('+1 hour');

            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId)); 
            
            $subscriptionDets =  array();
            if(session()->get('user.userID') != ''){
                $patientDets = Patient::patientByUser(session()->get('user.userID'));
                $subscriptionDets = PatientSubscription::getPatientSubscription($patientDets['id']);
            }

            if(!empty($subscriptionDets)){
                $amount = $subscriptionDets['virtual_fee'];
            }else{
                $amount = $clinicDetails['virtual_fee'];
            }
            
            $appointmentUuid = $this->Corefunctions->generateUniqueKey("10", "appointments", "appointment_uuid"); //generate uuid
            $input['appointment_type_id'] = '1';
            $input['doctor'] = $userId;
            $input['appointment_fee'] = $amount;
            $appointment = Appointment::createAppointment($input,$clinicId,$formattedDate,$formattedTime,$expiredDate,$appointmentUuid,$userId);
            
            $appID = $appointment->id;
            $appUid = $appointment->appointment_uuid;
            
            /** Notification for doctor */
            $clinicUserDoctor = Appointment::getClinicUserDoctor($clinicId, $userId);
            
            $this->Corefunctions->addNotifications(3,$clinicId,$clinicUserDoctor['user_id'],$appID);
            
            if($input['appointment_type_id'] == 1){
                $data['appointment_type'] ="Online Appointment";
            }else{
                $data['appointment_type'] ="In-person Appointment";
            }

            $patientDetails = Patient::getPatientDets($input['patient'],$clinicId);

            /** Invitation mail */
            $clinic = Clinic::clinicByID($clinicId);
            $data['name'] = $this->Corefunctions -> showClinicanName($clinicUserDoctor,'1');
            $data['clinic'] = $clinic->name;
            $data['email'] = $clinicUserDoctor['email'];
            $data['date'] =  date('M d Y', strtotime($formattedDate)) ;
            $data['time'] = date('h:i A', strtotime($formattedTime)) ;
            $data['link'] = url('meet/'.$appUid);
            $data['userType'] = "clinicUser";
            $data['patient'] = $patientDetails->first_name.' '.$patientDetails->last_name;
            $response = $this->Corefunctions->sendmail($data, 'New Online Appointment Scheduled - '.$patientDetails['first_name'].' '.$patientDetails['last_name'], 'emails.appointmentdoctor');
            
            $roomkey = $this->Corefunctions->generateUniqueKey('10', 'video_calls', 'room_key');
            
            $videocall = new VideoCall();
            $videocall->room_key = $roomkey;
            $videocall->appointment_id = $appID;
            $videocall->created_by =  session()->get('user.userID');
            $videocall->user_type = session()->get('user.userType');
            $videocall->save();
            
            $videocall = VideoCall::where('id',$videocall->id)->first();
            $videocall->room_id = 'Room_'.(1000+$videocall->id);
            $videocall->update();
            $arr['success'] = 1;
            $arr['message'] = 'Appointment created successfully!';
            return response()->json($arr);
        }
    }
    public function subscriptionplans(){
        if (!Session::has('user')) {
            return redirect('/');
        }
        $userID = Session::get('user.userID');
        $clinicID = Session::get('user.clinicID');

        $patientDetails  = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($userID,$clinicID));
        if (empty($patientDetails)) {
            return redirect('/patient/dashboard');
        }
        if($patientDetails['onboarding_completed'] == '1'){
            if($patientDetails['user']['is_taken_intakeform'] == '1'){
                return redirect('/patient/dashboard');
            }else{
                return redirect('/intakeform');
            }
        }

        $clinic = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicID));
        $clinic['clinic_logo'] = isset($clinic['logo']) && ($clinic['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinic['logo']) : asset("images/default_clinic.png");
        $clinicSubscriptions = ClinicSubscription::getClinicSubscriptions($clinicID);
        
        $planIcons = $this->Corefunctions->convertToArray(RefPlanIcons::all());
        $planIcons = $this->Corefunctions->getArrayIndexed1($planIcons,'id');

        return view('frontend.subscriptionplans',compact('clinic','clinicSubscriptions','planIcons'));
    }
    public function startonBoarding(){
        if (!Session::has('user')) {
            return redirect('/');
        }
        $userID = Session::get('user.userID');
        $clinicID = Session::get('user.clinicID');

        $patientDetails  = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($userID,$clinicID));
        if($patientDetails['onboarding_completed'] == '1'){
            if($patientDetails['user']['is_taken_intakeform'] == '1'){
                return redirect('/patient/dashboard');
            }else{
                return redirect('/intakeform');
            }
        }

        // DB::table('patients')->where('user_id',$userID)->where('clinic_id',$clinicID)->update(array(
        //     'onboarding_completed' => '1'
        // ));

        $clinic = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicID));
        $clinic['clinic_logo'] = isset($clinic['logo']) && ($clinic['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinic['logo']) : asset("images/default_clinic.png");
        
        $seo['title'] = "Patient Onboarding | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('frontend.startonboarding',compact('seo','clinic','patientDetails'));
    }
    protected function cancelAppointment()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
            try {
                $appointment = Appointment::appointmentByKey($data['key']);
                Appointment::where('appointment_uuid', $data['key'])->update(array(
                    'cancelled_by' => Session::get('user.userID'),
                    'cancelled_by_type' => (Session::get('user.userType') == 'patient') ? 'p' : 'u',
                    'deleted_at' => Carbon::now(),
                ));
                $message = 'Appointment deleted successfully!';
                $status = 'success';

                $appID = $appointment->id;
                
                /** notification for doctor */
                $clinicUserDoctor = ClinicUser::getUserByUserId($appointment->consultant_id,session()->get('user.clinicID'));
                $this->Corefunctions->addNotifications(4,session()->get('user.clinicID'),$clinicUserDoctor['user_id'],$appID);
                
                /** notification for nurse */
                $clinicUserNurse = ClinicUser::getUserByUserId($appointment->nurse_id,session()->get('user.clinicID'));
                $this->Corefunctions->addNotifications(4,session()->get('user.clinicID'),$clinicUserNurse['user_id'],$appID);

                /** notification for patients */
                $patientDetails = Patient::getPatientByClinicId($appointment->patient_id,session()->get('user.clinicID'));
                $this->Corefunctions->addNotifications(4,session()->get('user.clinicID'),$patientDetails['user_id'],$appID);

                /** Inviappointment cancel */
                $clinic = $this->Corefunctions->convertToArray(Clinic::ClinicByID(session()->get('user.clinicID')));
                
                /** Invitation mail */
                $data['name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $data['doctorName'] = $this->Corefunctions -> showClinicanName($clinicUserDoctor,'1');
                $data['clinic'] = $clinic['name'];
                $data['email'] = $patientDetails['email'];
                $data['date'] = $appointment->appointment_date ;
                $data['appType'] =( $appointment->appointment_type_id == 1) ? 'Online Appointment'  : 'In-person Appointment';
                $data['time'] = $appointment->time ;
                $data['location'] =  $this->Corefunctions->formatAddress($clinic);
                
                $response = $this->Corefunctions->sendmail($data, 'Appointment Cancellation', 'emails.appointmentcancel');
            } catch (ModelNotFoundException $e) {
                $message = 'Unable to find appointment';
                $status = 'error';
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                $message = 'An error occurred while deleting the appointment';
                $status = 'error';
            }

            $arr['success'] = 1;
            $arr['message'] = 'Appointment cancelled successfully';
            return response()->json($arr);
            exit();
        }
    }


    public function validatePatientLogin(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $userId = session('user.userID');
            $clinicId = session('user.clinicID');
            $patientID  = session()->get('user.patientID');
         
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
                $sessionCeck = $this->Corefunctions->validatePatientLogin($userId,$patientID);
                if (!$sessionCeck) {
                    $arr['success'] = 0;
                    return response()->json($arr);
                }
            }

            $arr['success'] = 1;
            return response()->json($arr);
        }
    }
    public function getRecentChats(){
        
         $userId            = session('user.userID');
         $clinicID          = Session::get('user.clinicID');
         $patientDetails    = Patient::getPatientsByUserId($userId, $clinicID);
        
         $chats             = Chats::getPatientChats($userId);
         $clinicIDS = $userIDS = $chatIDS = array();
         if( !empty($chats) ){
             foreach( $chats as $ch){
                 $userIDS[]   = ( $ch['from_user_id'] == $userId  ) ? $ch['to_user_id'] : $ch['from_user_id'];
                 $clinicIDS[] = $ch['clinic_id'];
                 $chatIDS[] = $ch['id'];
             }
         }
         
         $clinicUsers = $this->Corefunctions->convertToArray(ClinicUser::getClinicUserByUserIDS($userIDS,$clinicIDS));
         $finalClinicUsers = array();
         if( !empty($clinicUsers)){
             foreach( $clinicUsers as $cuv){
                 $finalClinicUsers[$cuv['clinic_id']][$cuv['user_id']] = $cuv;
             }
         }
         /* Unread Count */
         $unreadChats = Chats::checkUnreadChatExists($userId,$chatIDS);
         $unreadChats = $this->Corefunctions->getArrayIndexed1($unreadChats, 'chat_id'); 
         
         /* Last Message */
         $lastChats = Chats::getChatsLastMessage($chatIDS);
         $lastChats = $this->Corefunctions->getArrayIndexed1($lastChats, 'chat_id');
         if( !empty($lastChats) ){
             foreach( $lastChats as $lsk => $lsv){
                $lastChats[$lsk]['last_chat_time'] = $this->Corefunctions->timezoneChange($lsv['created_at'], "h:i A");
             }
         }

         if( !empty($chats) ){
             foreach( $chats  as $chv => $cht){
                 $sessionUserID   = ( $cht['from_user_id'] == $userId  ) ? $cht['from_user_id'] : $cht['to_user_id'];
                 $otherUserID   = ( $cht['from_user_id'] == $userId  ) ? $cht['to_user_id'] : $cht['from_user_id'];
                 $doctorDets    = ( isset($finalClinicUsers[$cht['clinic_id']] ) && !empty($finalClinicUsers[$cht['clinic_id']] ) && isset($finalClinicUsers[$cht['clinic_id']][$otherUserID] ) && !empty( $finalClinicUsers[$cht['clinic_id']][$otherUserID] ) ) ? $finalClinicUsers[$cht['clinic_id']][$otherUserID] : array();
                 
                 
                 if( !empty($doctorDets) ){
                     $profileImage = $this->Corefunctions -> resizeImageAWS($doctorDets['user']['id'],$doctorDets['user']['profile_image'],$doctorDets['user']['first_name'],180,180,'1');
                     $userName     =$this->Corefunctions -> showClinicanNameUser($doctorDets,'1');
                     
                     $cht['profile_image'] = $profileImage;
                     $cht['user_name']     = $userName;
                 }
                 $chats[$chv] = $cht;
                 
             }
         }
        $finalArr['lastChats'] = $lastChats;
        $finalArr['chats'] = $chats;
        return $finalArr;
        
    }
    public function workspaceChange(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            /** get the clinic list of the logged in user  */
           
            $patientDetails = Patient::getPatientCount();
             // Get clinic ids fromclinic user 
            $clinicIds     = ClinicUser::getClinicIds();
            $clinicDetails = Clinic::getclinicByID($clinicIds);
            $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
            $clinicDetails = $this->Corefunctions->getArrayIndexed1($clinicDetails, 'id');

            
            $data['clinicDetails'] = $clinicDetails;
            $data['patientDetails'] = $patientDetails;
            $html = view('layouts.changeclinic', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function selectClinic(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            
            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }
            $ispatient ='0';
            
            if(isset($data['type']) && $data['type'] =='patient'){
                $clinicDetails = $this->Corefunctions->convertToArray(Patient::getPatientByUser());
                $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
                $clinic_user_uuid = $clinicDetails['patients_uuid'];
                $ispatient ='1';
                $redirectUrl =url('/myappointments');
            }else{
                // Get clinic user details
                $clinicDetails = $this->Corefunctions->convertToArray(ClinicUser::getUserByUserId(session()->get('user.userID'),$data['clinicID']),'clinic');
                $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);

            }
            
            /** check stripe connection */
            $stripe_connected = 1;
            $userLogo = ($clinicDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo_path']) : '';
            $clinicName = $clinicLogo = $clinic_uuid = $stripeURL ='';
            $userType = 'patient';
            if($ispatient == '0'){
                
                $clinicData = Clinic::clinicByID($clinicDetails['clinic_id']) ;
                $clinicName = $clinicData->name;
                $clinic_uuid = $clinicData->clinic_uuid;
                
                $clinicLogo = ($clinicData->logo != '') ? $this->Corefunctions->getAWSFilePath($clinicData->logo) : '';
            
                
                $clinic_user_uuid = $clinicDetails['clinic_user_uuid'];
                if (!empty($clinicDetails) && $clinicDetails['user_type_id'] == '1') {
                    //  Process stripe connection details
                    $stripe_connected = 0;
                    if (($clinicData->stripe_connection_id != '')) {
                        $stripe_connected = 1;
                    }
                }
               if(!empty($clinicDetails) && $clinicDetails['user_type_id'] == '1'){
                    $userType = 'clinics';
                }elseif(!empty($clinicDetails) && $clinicDetails['user_type_id'] == '2'){
                    $userType = 'doctor';
                }else{
                    $userType = 'nurse';
                } /** update stripe info */
                
                $stripeURL = 'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&state=' . $clinicDetails['clinic_user_uuid'] . '&redirect_uri=' . url("/connect/stripe");
                $redirectUrl =url('/dashboard');
            }
            // Get clinic user details
            $clinicDetailsCount = ClinicUser::getClinicUserCount();
            $patientsCount      = Patient::getPatientCount();

            $clinicDetailsCount = $clinicDetailsCount + $patientsCount;
            $hasWorkSpace       = $clinicDetailsCount > 1 ? 1 : 0;
            
            
           $clinicAdmin = ((!empty($clinicDetails) && isset($clinicDetails['is_clinic_admin']) && $clinicDetails['is_clinic_admin'] == '1') || $userType =='clinics')  ? 1 : 0;
            Session::put("user.clinicLogo", $clinicLogo);
            /** update stripe info */
            Session::put("user.hasWorkSpace", $hasWorkSpace);
            Session::put("user.clinicID", $clinicDetails['clinic_id']);
            Session::put("user.clinicUUID", $clinic_uuid);
            Session::put("user.clinicuser_uuid",$clinic_user_uuid );
            Session::put("user.userType", $userType);
            Session::put("user.clinicName", $clinicName);
            Session::put("user.isClinicAdmin", $clinicAdmin);
            Session::put("user.userLogo", $userLogo);
            Session::put("user.stripeConnection", $stripe_connected);
            
           
            /** update last login id */
            User::updateLastLoginClinic($clinicDetails['user_id'], $clinicDetails['clinic_id']);
          
            // Return success response
            return response()->json([
                'success' => 1,
                'stripe_connected' => $stripe_connected,
                'redirecturl' => $redirectUrl,
                'stripeURL' =>$stripeURL,
                'message' => 'Clinic changed successfully',
            ]);
        }
    }
    /** Add new clinic */
    public function addWorkspace(Request $request)
    {
        if (request()->ajax()) {

            $data = request()->all();

            // Fetch country ID from ref_country_codes table
            $countryDetails = RefCountryCode::getAllCountry() ;
            // Fetch state details
            $stateDetails = RefState::getStateList() ;
            /** clinic user details */
            $clinicUserdetails = ClinicUser::getClinicUserWithClinicID();

            $data['clinicUserdetails'] = $clinicUserdetails;
            $data['countryDetails'] = $countryDetails;
            $data['stateDetails'] = $stateDetails;
            $html = view('clinics.addclinic', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();

            // return view('clients.listing',$data);
        }
    }
     public function viewWebhook(){
       
         $type      = ( isset($_GET['type']) ) ? $_GET['type'] : '';
         $typeArr   = array('e','r');
         if( $type != ''){
             if( !in_array($type,$typeArr)){
                  return redirect('webhook/view');
                  exit;
             }
         }
         
         
         $webhooks   = DB::table("webhooks")->orderBy('id','desc');
         if( $type != ''){
             $webhooks = $webhooks->where('type',$type);
         }
         $webhooks     = $webhooks->paginate(25)->appends(['type' => $type]);
         $seo['title'] = "Webhooks  | " . env('APP_NAME');
        $seo['keywords'] = "Manage appointments online, track status, book in-person or virtual visits, view past history, manage schedules, and enjoy effortless healthcare scheduling.";
        $seo['description'] = "Manage appointments effortlessly. Book online or in-person, track status, view doctor details, and get real-time notifications for a seamless healthcare experience.";
        $seo['og_title'] = "Webhooks  | " . env('APP_NAME');
        $seo['og_description'] = "Manage appointments easily with our user-friendly platform. Book online or in-person, track status, view doctor details, and get real-time notifications for seamless care.";
         
        return view('frontend.webhooks', compact('webhooks','seo','typeArr','type'));
         
     }
    public function idpSuccess(){
        
     $clinicId = '993669';
     $userId = '3067532';
     $clinicKey = 'TH9SFP3VYD7ETMHCFQERPVEVKVNSJQ7K';
 
            list($encryptedClinicId, $userIdVerify) = $this->Corefunctions->sso($clinicKey, $userId);

            $ssoUrl = "https://my.staging.dosespot.com/LoginSingleSignOn.aspx?" .
                "SingleSignOnClinicId=" . urlencode($clinicId) .
                "&SingleSignOnUserId=" . urlencode($userId) .
                "&SingleSignOnPhraseLength=32" .
                "&SingleSignOnCode=" . urlencode($encryptedClinicId) .
                "&SingleSignOnUserIdVerify=" . urlencode($userIdVerify) .
                "&RefillsErrors=1";
        
        print "<pre>";
    print_r($ssoUrl);
    exit;
   }
    
   
}
