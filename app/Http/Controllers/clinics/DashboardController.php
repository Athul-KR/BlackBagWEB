<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\ClinicUser;
use App\Models\StripeConnection;
use App\Models\Clinic;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\RefSupportType;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionsHistory;
use App\Models\Subscription;
use App\Models\ClinicCard;
use App\Models\UserBilling;
use App\Models\Support;
use App\Models\RefState;
use App\Models\RefCountryCode;
use DB;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Route;

            
class DashboardController extends Controller
{
    public function __construct()
    {

        $this->Corefunctions = new \App\customclasses\Corefunctions;
        // Middleware for session check
        $this->middleware(function ($request, $next) {
            $method = Route::current()->getActionMethod();
            if(!in_array($method,array('workspaceChange','selectClinic','appointmentList'))){
                if (Session::has('user') && session()->get('user.userType') == 'patient') {
                    return Redirect::to('/');
                }
            }
            // Check if the session has the 'user' key (adjust as per your session key)
            if (Session::has('user') && session()->get('user.userType') != 'patient') {
                $sessionCeck = $this->Corefunctions->validateUser();
                if (!$sessionCeck) {
                    return Redirect::to('/logout');
                }
            }
            
            // Check if the session has the 'user' key (adjust as per your session key)
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
            if ($this->Corefunctions->validateClincOnboarding()) {
                return Redirect::to('/onboarding/business-details');
            }

            /* Validate onboarding process */
            if(Session::has('user') && (session()->get('user.userType') == 'doctor' || session()->get('user.userType') == 'clinics' )){
                $onboardClinic = $this->Corefunctions->validateClincUserOnboarding();
                if(isset($onboardClinic ['success']) && $onboardClinic ['success'] == 1){
                    return Redirect::to('doctor/onboarding/contact-details');
                }
             
            }
         
            return $next($request);
        });
    }

    public function dashboard()
    {
    
     
        $clinicuser_uuid = session()->get('user.clinicuser_uuid');
        $userType = session()->get('user.userType'); 
        $userTimeZone = session()->get('user.timezone');
        $fullPermission = ($userType !== 'patient') ? '1' : '0';
        $clinicId = session('user.clinicID');
        if ($userType != 'patient') {
            $loginUserDetails = ClinicUser::getClinicUserWithClinic() ;
            $userName = $this->Corefunctions -> showClinicanName($loginUserDetails,1);
            if (empty($loginUserDetails)) {
                return back()->with('error', "Invalid clinic details or not found!");
            }
            $userID = $loginUserDetails['id'] ;
        } else {
            $loginUserDetails = Patient::patientByUUID($clinicuser_uuid);
            $userName = $loginUserDetails->name;
            if (empty($loginUserDetails)) {
                return back()->with('error', "Invalid clinic details or not found!");
            }
            $userID = $loginUserDetails->id ;
        }
        // Get upcoming appointment list for the clinic
        $appointmentData = Appointment::getAppointment($userType,$userID,$userTimeZone) ;
        
        $todayAppointmentsCount = $appointmentData['todayAppointmentsCount'] ;
        $appointmentDates       = $appointmentData['appointmentDates'] ;
        $appointmentDetails     = $appointmentData['appointmentDetails'] ;
   
        /** patientlist */
        $patientIds = $this->Corefunctions->getIDSfromArray($appointmentDetails, 'patient_id');
        $patientDetails = Patient::getPatientByUserIDNew($patientIds,session()->get('user.clinicID')) ; 
        $patientDetails = $this->Corefunctions->convertToArray($patientDetails);
        $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'user_id');
        if (!empty($patientDetails)) {
            foreach ($patientDetails as $key => $patient) {
                if (isset($patient['dob'])) {

                    /* jomy */
                    $patientDetails[$key]['age'] =$this->Corefunctions->calculateAge($patient['dob']);
                }
            }
        }
        $eprescriberDets = array();
        $clinicDetails = Clinic::clinicByID($clinicId);
        $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);
        $stripe_connected = (!empty($clinicDetails) ) && ($clinicDetails['stripe_connection_id'] != null || $clinicDetails['stripe_connection_id'] != 0) ? 1 : 0;
        
        $isEprescribeEnabled = $loginUserDetails['eprescribe_enabled'];
        if($isEprescribeEnabled == '1'){
            $eprescriberDets = $this->Corefunctions->convertToArray(DB::table('eprescribers')->where('id',$loginUserDetails['eprescriber_id'])->first());
        }

        $userId = $loginUserDetails['user']['dosespot_clinician_id'];
        if(!empty($eprescriberDets) && $eprescriberDets['onboarding_completed'] == '0'){
            $result = $this->Corefunctions->registrationStatus($userId,$clinicDetails);
            if(!empty($result) && isset($result['Item']) && $result['Item'] == 'IDPSuccess'){
                DB::table('eprescribers')->where('id',$loginUserDetails['eprescriber_id'])->update(array(
                    'onboarding_completed' => '1',
                ));
                $eprescriberDets = $this->Corefunctions->convertToArray(DB::table('eprescribers')->where('id',$loginUserDetails['eprescriber_id'])->first());
            }
        }

        $seo['title'] = "Dashboard | " . env('APP_NAME');
        $seo['keywords'] = "    Dashboard Overview, Upcoming Appointments, Today’s Appointments,
                                Patient Appointment Details, Patient Name and Contact, Appointment Date and Time
                                Online Appointments, See All Appointments, Black Bag Patient Management,
                                Healthcare Scheduling, Patient Actions and Updates, Appointment Notifications ";

        $seo['description'] = "     Manage your healthcare appointments seamlessly with the Black Bag
                                    dashboard. View upcoming patient details, appointment types, and schedules. Stay
                                    updated with notifications and easily access actions for efficient management";

        $seo['og_title'] = "Dashboard | " . env('APP_NAME');
        $seo['og_description'] = "  Manage your healthcare appointments seamlessly with the Black Bag
                                    dashboard. View upcoming patient details, appointment types, and schedules. Stay
                                    updated with notifications and easily access actions for efficient management";

        return view('dashboard.listing', compact('appointmentDetails', 'fullPermission', 'patientDetails', 'todayAppointmentsCount', 'appointmentDates', 'seo','userName','isEprescribeEnabled','stripe_connected','appointmentDetails','todayAppointmentsCount','eprescriberDets','loginUserDetails'));
    }

    //Appointment List Function
    public function appointmentList()
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
            $userTimeZone = session()->get('user.timezone');
            $userType = session()->get('user.userType'); // Get logged in clinic ID
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
            $fullPermission = ($userType !== 'patient') ? '1' : '0';

            if ($userType != 'patient') {
                $loginUserDetails = ClinicUser::userByUUID($clinicuser_uuid);
                if (empty($loginUserDetails)) {
                    return back()->with('error', "Invalid clinic details or not found!");
                }
            } else {
                $loginUserDetails = Patient::patientByUUID($clinicuser_uuid);
                if (empty($loginUserDetails)) {
                    return back()->with('error', "Invalid clinic details or not found!");
                }
            }

            $data['date']= ($data['date'] !='') ? $data['date'] : Carbon::now('UTC')->format('Y-m-d');
            // Get upcoming appointment list for the clinic
            $appointmentData = Appointment::getAppointment($userType,$loginUserDetails->user_id,$userTimeZone,$data['date'],'list');
            $appointmentDetails = $appointmentData['appointmentDetails'];
            
            /** patientlist */
            $patientIds = $this->Corefunctions->getIDSfromArray($appointmentDetails, 'patient_id');
            $patientDetails = Patient::getPatientByUserIDNew($patientIds,session()->get('user.clinicID'));
            $patientDetails = $this->Corefunctions->convertToArray($patientDetails);
            $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'user_id');

            /** doctorlist */
            $doctorIds = $this->Corefunctions->getIDSfromArray($appointmentDetails, 'consultant_id');
            $doctorDetails = ClinicUser::getClinicUserByUserIDNew($doctorIds,session()->get('user.clinicID'));
            $doctorDetails = $this->Corefunctions->convertToArray($doctorDetails);
            $doctorDetails = $this->Corefunctions->getArrayIndexed1($doctorDetails, 'user_id');

            $data['patientDetails'] = $patientDetails;
            $data['doctorDetails'] = $doctorDetails;
            $data['appointmentDetails'] = $appointmentDetails;
            $data['fullpermission'] = $fullPermission;
            // $data['selectedDate'] = date('m/d/Y', strtotime($data['date']));
            $data['selectedDate']  = isset($data['date']) && !empty($data['date']) ? date('m/d/Y', strtotime($data['date'])): date('m/d/Y');
           
            $html = view('dashboard.appointment', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;

            return response()->json($arr);
            exit();
        }
    }

    public function getAppointments()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }
            $clinicuser_uuid = session()->get('user.clinicuser_uuid');
            $userType = session()->get('user.userType');
            $userTimeZone = session()->get('user.timezone');
            $fullPermission = ($userType != 'patient') ? '1' : '0';

            if ($userType != 'patient') {
                $loginUserDetails = ClinicUser::getClinicUserWithClinic() ;
                $userName = $this->Corefunctions -> showClinicanName($loginUserDetails,1);
                if (empty($loginUserDetails)) {
                    return back()->with('error', "Invalid clinic details or not found!");
                }
                $userID = $loginUserDetails['id'] ;
            } else {
                $loginUserDetails = Patient::patientByUUID($clinicuser_uuid);
                $userName = $loginUserDetails->name;
                if (empty($loginUserDetails)) {
                    return back()->with('error', "Invalid clinic details or not found!");
                }
                $userID = $loginUserDetails->id ;
            }

            $appointmentData = Appointment::getAppointment($userType,$userID,$userTimeZone) ;
        
            $todayAppointmentsCount = $appointmentData['todayAppointmentsCount'] ;
            $appointmentDates       = $appointmentData['appointmentDates'] ;
            $appointmentDetails     = $appointmentData['appointmentDetails'] ;
    
            /** patientlist */
            $patientIds = $this->Corefunctions->getIDSfromArray($appointmentDetails, 'patient_id');
            $patientDetails = Patient::getPatientByUserIDNew($patientIds,session()->get('user.clinicID')) ; 
            $patientDetails = $this->Corefunctions->convertToArray($patientDetails);
            $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'user_id');
            if (!empty($patientDetails)) {
                foreach ($patientDetails as $key => $patient) {
                    if (isset($patient['dob'])) {

                        /* jomy */
                        $patientDetails[$key]['age'] =$this->Corefunctions->calculateAge($patient['dob']);
                    }
                }
            }
            
            $data['patientDetails'] = $patientDetails;
            $data['appointmentDetails'] = $appointmentDetails;
            $data['fullpermission'] = $fullPermission;
           
            $html = view('dashboard.appointment_list', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['fullpermission'] =  $fullPermission;
            return response()->json($arr);
            exit();
        }
    }

    public function support()
    {
        $supportTypes = RefSupportType::all();

        $seo['title'] = "Support | " . env('APP_NAME');
        $seo['keywords'] = "    Customer Support, Technical Support, 24/7 Help Desk, Get Help Online,
                                Support Assistance, Technical Issue Resolution, Contact Customer Support, Message
                                for Support, Help with Technical Problems, Support Ticket System, Instant Help and
                                Assistance, Problem Solving Assistance, Support for Technical Issues, Customer
                                Service Help  ";

        $seo['description'] = "     Get the assistance you need with our dedicated support team, available to
                                    resolve any technical issues or answer your questions. Whether you need help
                                    troubleshooting, have questions about our services, or require specific support, simply
                                    send us a message, and we’ll provide prompt and effective solutions. Our 24/7 support
                                    ensures you’re never alone, and we’re here to assist you every step of the way for a
                                    seamless experience";

        $seo['og_title'] = "Support | " . env('APP_NAME');
        $seo['og_description'] = " Get the assistance you need with our dedicated support team, available to
                                    resolve any technical issues or answer your questions. Whether you need help
                                    troubleshooting, have questions about our services, or require specific support, simply
                                    send us a message, and we’ll provide prompt and effective solutions. Our 24/7 support
                                    ensures you’re never alone, and we’re here to assist you every step of the way for a
                                    seamless experience";

        return view('support', compact('supportTypes', 'seo'));
    }
    public function storeSupport()
    {
        $input = request()->all();

        if (!$input) {
            $arr['error'] = 1;
            $arr['errormsg'] = 'Fields missing';
            return to_route('support')->with('error', 'Missing the required fields!');
        }
        $supportType = RefSupportType::where('id', $input['support_type'])->first();

        $clinicID = session('user.clinicID');
        $firstName = session('user.firstName');
        $lastName = session('user.lastName');
        $email = session('user.email');
        $clinic = Clinic::find($clinicID);

        Support::create([
            'type_id' => $input['support_type'],
            'message' => $input['message'],
            'clinic_id' => $clinicID,
        ]); //Storing into db

        //Adding data into array for displaying in mail for mail
        $data['clinic'] = $clinic->name;
        $data['supportType'] = $supportType->type;
        $data['firstName'] = $firstName;
        $data['lastName'] = $lastName;
        $data['email'] = env('CONTACT_US_MAIL');
        $data['userEmail'] = $email;
        $data['userMessage'] = $input['message'];

        $response = $this->Corefunctions->sendmail($data, 'New Support Inquiry', 'emails.support-inquiry');
        //Adding data into array for displaying in mail for mail
        $data['clinic'] = $clinic->name;
        $data['supportType'] = $supportType->type;
        $data['firstName'] = $firstName;
        $data['lastName'] = $lastName;
        $data['email'] = $email;
        $data['userEmail'] = $email;
        $data['userMessage'] = $input['message'];

        $response = $this->Corefunctions->sendmail($data, 'Re: Support Inquiry', 'emails.support-inquiry-reply');

        if ($response['status'] == 'success') {
            return to_route('support')->with('success', 'Support inquiry submitted successfully!');
        }

        return to_route('support')->with('error', 'Something went wrong. Failed to send message!');
    }

    /** change clinic workspace */
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
           
           $clinicCode = isset($clinicDetails['clinic_code']) ? $clinicDetails['clinic_code'] : '';
            Session::put("user.clinicLogo", $clinicLogo);
            /** update stripe info */
            Session::put("user.hasWorkSpace", $hasWorkSpace);
            Session::put("user.clinicID", $clinicDetails['clinic_id']);
            Session::put("user.clinicCode", $clinicCode);
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

    /** Add new clinic */
    public function addClinic()
    {
        if (request()->ajax()) {
            $this->Corefunctions = new \App\customclasses\Corefunctions;
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }
            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            
            $userID = session()->get('user.userID');
            /*** current clinic user details */
            $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::userByUUID(session()->get('user.clinicuser_uuid')));

            // Fetch country ID from ref_country_codes table
            $countryCode = RefCountryCode::getCountryCodeByShortCode($input['clinic_countrycode']);
           /* Insert to clinic */
            $clinicID    = Clinic::insertClinic($input,$countryCode) ; 
            $cilinicData =Clinic::clinicByID($clinicID);
            /* Insert clinic data to clinincs users table*/
            $clinicUser['first_name']  = !empty($clinicUser) ? $clinicUser['name'] : null;
            $clinicUser['user_phone']  = !empty($clinicUser) ? $clinicUser['phone_number'] : null;
            $clinicUser['user_email']  = !empty($clinicUser) ? $clinicUser['email'] : null;
            $clinicUser['designation'] = !empty($clinicUser) ? $clinicUser['designation_id'] : null;
            $clinicUser['speciality']  =  !empty($clinicUser) ? $clinicUser['specialty_id'] : null;
            $userCountryCode = array();
            $userCountryCode['id'] = !empty($clinicUser) ? $clinicUser['country_code'] : null ;

            $username =  $clinicUser['first_name'].' '. $clinicUser['last_name'];
            $code = $this->Corefunctions->generateClinicianCode($input['clinic_name'],$username);

            $clinicUserInsert = ClinicUser::insertClinicUser($clinicUser,$userCountryCode,$userID,$clinicID,'1','',$code) ;
            $clinicUserUuid =$clinicUserInsert['clinic_user_uuid'] ;
            // Get clinic user details
            $clinicDetailsCount = ClinicUser::getClinicUserCount();
            $hasWorkSpace = $clinicDetailsCount > 1 ? 1 : 0;

            $stripe_connected = 0;

            // Store user session data
            Session::put("user.clinicuser_uuid", $clinicUserUuid);
            Session::put("user.hasWorkSpace", $hasWorkSpace);
            Session::put("user.userType", 'clinics');
            Session::put("user.clinicID", $clinicID);
            Session::put("user.stripeConnection", $stripe_connected);
            Session::put("user.clinicName", $input['clinic_name']);
            Session::put("user.clinicLogo", '');

            Session::put("user.clinicUUID", $cilinicData->clinic_uuid);
            //Session::put("user.userLogo", '');
            
            $arr['stripe_connected'] = $stripe_connected;
            /** regirect to onboarding */
            $arr['stripeURL'] =  url('onboarding') ;
            // $arr['stripeURL'] =  'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&state=' . $clinicUserUuid . '&redirect_uri=' . url("/connect/stripe");
            $arr['success'] = 1;
            $arr['message'] = 'Clinic added successfully';
            return response()->json($arr);
            exit();
        }
    }
    public function globalSearch(Request $request)
    {

        $searchValue = (isset($_GET['search']) && $_GET['search'] != '') ? $_GET['search'] : '';

        $seo['title'] = "Global Search - ".$searchValue." | " . env('APP_NAME');
        $seo['og_title'] = "Global Search - ".$searchValue." | " . env('APP_NAME');

        return view('globalsearch.listing', compact('searchValue','seo'));

    }
    public function searchTerm()
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            if (isset($data['searchterm']) && $data['searchterm'] != '') {

                $searchTerm = strtolower($data['searchterm']);
                $designationIds = DB::table('ref_designations')
                    ->where('name', 'like', '%' . $searchTerm . '%')
                    ->pluck('id')
                    ->toArray();
                $specialityIds = DB::table('ref_specialties')
                    ->where('specialty_name', 'like', '%' . $searchTerm . '%')
                    ->pluck('id')
                    ->toArray();
                $clinicID = session()->get('user.clinicID');
                if ($searchTerm != '') {

                    if (session()->get('user.userType') == 'patient') {

                        $queryParts[] = "(SELECT id AS result_column ,'patient' AS user_type , 'patients' AS table_name,status,deleted_at,created_at,name ,patients_uuid AS uuId,logo_path,email,phone_number,country_code
                            FROM patients
                            WHERE status='1'  and clinic_id=$clinicID
                             and deleted_at IS  NULL

                             and (LOWER(name) LIKE '%$searchTerm%'
                             OR LOWER(email) LIKE '%$searchTerm%'
                             OR phone_number LIKE '%$searchTerm%')";

                    } else {

                        if (!empty($designationIds)) {

                            $queryParts[] = "
                                SELECT
                                    id AS result_column,
                                    'clinic' AS user_type,
                                    'clinic_users' AS table_name,
                                    status,
                                    deleted_at,
                                    created_at,
                                    name,
                                    clinic_user_uuid AS uuId,
                                    logo_path,
                                    department,
                                    email,
                                    phone_number,
                                    country_code,
                                    designation_id,
                                    specialty_id,
                                    user_type_id
                                FROM clinic_users
                                WHERE status = '1'
                                  AND clinic_id = $clinicID
                                  
                                  AND clinic_id IS NOT NULL
                                  AND deleted_at IS NULL
                                  AND (
                                      LOWER(name) LIKE '%$searchTerm%'
                                      OR LOWER(department) LIKE '%$searchTerm%'
                                     
                                  )

                                  AND designation_id IN (" . implode(', ', $designationIds) . ")
                            ";
                        } else if (!empty($specialityIds)) {
                            $queryParts[] = "
                                SELECT
                                    id AS result_column,
                                    'clinic' AS user_type,
                                    'clinic_users' AS table_name,
                                    status,
                                    deleted_at,
                                    created_at,
                                    name,
                                    clinic_user_uuid AS uuId,
                                    logo_path,
                                    department,
                                    email,
                                    phone_number,
                                    country_code,
                                    designation_id,
                                    specialty_id,
                                    user_type_id
                                FROM clinic_users
                                WHERE status = '1'
                                  AND clinic_id = $clinicID
                                  AND clinic_id IS NOT NULL
                                  AND deleted_at IS NULL
                                  AND (
                                      LOWER(name) LIKE '%$searchTerm%'
                                      OR LOWER(department) LIKE '%$searchTerm%'
                                      OR specialty_id IN (" . implode(', ', $specialityIds) . ")
                                    )
                                
                            ";

                        } else {
                            $queryParts[] = "
                                    SELECT
                                        id AS result_column,
                                        'clinic' AS user_type,
                                        'clinic_users' AS table_name,
                                        status,
                                        deleted_at,
                                        created_at,
                                        name,
                                        clinic_user_uuid AS uuId,
                                        logo_path,
                                        department,
                                        email,
                                        phone_number,
                                        country_code,
                                        designation_id,
                                        specialty_id,
                                        user_type_id
                                    FROM clinic_users
                                    WHERE status = '1'
                                    AND clinic_id = $clinicID
                                    AND clinic_id IS NOT NULL
                                    AND deleted_at IS NULL
                                    AND (
                                        LOWER(name) LIKE '%$searchTerm%'
                                        OR LOWER(department) LIKE '%$searchTerm%'
                                    )
                                ";
                        }

                        $queryParts[] = "
                            SELECT
                                id AS result_column,
                                'patient' AS user_type,
                                'patients' AS table_name,
                                status,
                                deleted_at,
                                created_at,
                                name,
                                patients_uuid AS uuId,
                                logo_path,
                                NULL AS department,
                                email,
                                phone_number,
                                country_code,
                                NUll as user_type_id,
                                NULL AS designation_id,
                                NULL AS specialty_id
                            FROM patients
                            WHERE status = '1'
                              AND clinic_id = $clinicID
                              AND deleted_at IS NULL
                              AND clinic_id IS NOT NULL
                              AND (
                                  LOWER(name) LIKE '%$searchTerm%'
                                  OR LOWER(email) LIKE '%$searchTerm%'
                                  OR phone_number LIKE '%$searchTerm%'
                              )
                        ";
                    }

                }
                //print_r($queryParts);die;
                if (!empty($queryParts)) {
                    DB::enableQueryLog();

                    $combinedQuery = implode(' UNION ', $queryParts);

                    // Wrap the combined query with parentheses and alias
                    $rawQuery = "($combinedQuery) AS combined_results";

                    $query = DB::table(DB::raw($rawQuery));

                    if (
                        isset($data['lastSearchId']) &&
                        $data['lastSearchId'] !== '0' &&
                        $data['lastSearchId'] !== '' &&
                        $data['isloadmore'] === '1'
                    ) {
                        $query = $query->where('created_at', '<', $data['lastSearchId']);
                    }

                    $query = $query->orderBy('result_column', 'desc');

                    $searchResult = $query->limit(20)->get();
                    //    $dd = DB::getQueryLog();
                    //    print_r($dd);die;

                }
                if ($searchResult->isNotEmpty()) {

                    $lastRow = $searchResult->last();

                    $lastCreatedAt = $lastRow->created_at;
                } else {
                    $lastCreatedAt = '0';
                }
                $searchResultList = $this->Corefunctions->convertToArray($searchResult);
                //    print"<pre>";print_r($searchResult);exit;
                /** country code for phone number  */
                $countyIDs = $this->Corefunctions->getIDSfromArray($searchResultList, 'country_code');
                $countryCode = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('country_code', 'id')->whereIn('id', $countyIDs)->whereNull('deleted_at')->get());
                $countryCode = $this->Corefunctions->getArrayIndexed1($countryCode, 'id');

                $designationIDS = $this->Corefunctions->getIDSfromArray($searchResultList, 'designation_id');
                $designations = $this->Corefunctions->convertToArray(
                    DB::table('ref_designations')->select('name', 'id', 'designation_uuid')->get()
                );
                $designations = $this->Corefunctions->getArrayIndexed1($designations, 'id');

                $specialityIDS = $this->Corefunctions->getIDSfromArray($searchResultList, 'specialty_id');
                $specialityIDS = $this->Corefunctions->convertToArray(
                    DB::table('ref_specialties')->select('specialty_name', 'id', 'specialty_uuid')->get()
                );
                $speciality = $this->Corefunctions->getArrayIndexed1($specialityIDS, 'id');

                $data['searchResultList'] = $searchResultList;
                $data['searchResult'] = $searchResult;
                $data['countryCode'] = $countryCode;
                $data['designations'] = $designations;
                $data['speciality'] = $speciality;
                $data['isLoadMore'] = $data['isloadmore'];
                $html = view('globalsearch.appendlist', $data);
                $arr['view'] = $html->__toString();
                $arr['success'] = 1;
                $arr['lastSearchId'] = $lastCreatedAt;
                return response()->json($arr);
                exit();
            }
        }

    }

    /** For sample import file upload */
    public function uploadfile($type)
    {
        return view('upload', compact('type'));
    }
    /** For sample import file upload save */
    public function storeFile(Request $request)
    {
        // Check if a file is uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $type = request()->type;
            // Ensure the directory exists
            if (!is_dir('assets/sampledocs')) {
                mkdir('assets/sampledocs', 0755, true); // Create directory if it doesn't exist
            }

           $filename = ($type == "nurse" ? "Sample_Doc.xlsx" : ($type == "doctors" ? "Doctor_Sample_Doc.xlsx" : "Patient_Sample_Doc.xlsx"));
            $docppath = SAMPLEPATH . $filename;

            // Check if the file already exists
            if (file_exists($docppath)) {
                unlink($docppath); // Delete the existing file
            }
            // print_r($file);exit;
            // Move the uploaded file to the destination folder
            $file->move(SAMPLEPATH, $filename);
            // dd($filename);
            print_r('success');
            exit;
        } else {
            return response()->json(['error' => 'No file uploaded.'], 400);
        }
    }
    public function getTrialInfo(){
        if (request()->ajax()) {
            $data = request()->all();
            if( !$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $clinicId = Session::get('user.clinicID');

            /* Clinic Subscription */
            $clinicSubscription = Subscription::getSubscriptionByClinicId($clinicId);
            
            if(empty($clinicSubscription)){
                $arr['error']    = 1;
                $arr['errormsg'] = 'Invalid subscription';
                return response()->json($arr);
                exit();
            }
            /* Fetch plan name */
            $subscriptionPlan = SubscriptionPlan::getPlanById($clinicSubscription['subscription_plan_id']);

            /* Fetch user card count */
            $userCardCount = ClinicCard::getUserCardCount($clinicId);

            /* Fetch user address count */
            $userBillingCount = UserBilling::getUserBillingCount($clinicId);

            $trialPlanInfo = array();     

            $to   = \Carbon\Carbon::createFromFormat('Y-m-d', substr($clinicSubscription['end_date'], 0, 10));
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
            $diff_in_days = $from->diffInDays($to, false); // Use false to get negative values
            $trialPlanInfo['diff_in_days'] = $diff_in_days;
            
            if( $clinicSubscription['subscription_plan_id'] == '1'){
                $trialPlanInfo['trial_day_msg'] = 'You are currently on the Free Basic Plan. To get limitless features, upgrade your Subscription Plan.' ; 
                $trialPlanInfo['showTrialPlanMessage'] = 1; 

            }elseif( strtotime( $clinicSubscription['end_date'] ) < strtotime( date('Y-m-d') ) && (strtotime($clinicSubscription['renewal_date']) ) > strtotime( date('Y-m-d')) ){
                $trialPlanInfo['trial_day_msg'] = 'Your '.$subscriptionPlan['plan_name'].' trial plan will end on '.date('d F Y', strtotime($clinicSubscription['renewal_date'])) ; 
                $trialPlanInfo['showTrialPlanMessage'] = 1; 

            }elseif( strtotime( $clinicSubscription['end_date'] ) < strtotime( date('Y-m-d') ) ){
                $trialPlanInfo['showTrialPlanMessage'] = 1;
                $trialPlanInfo['trial_day_msg'] = 'Your '.$subscriptionPlan['plan_name'].' trial period has expired. Please upgrade your subscription to continue using BlackBag.' ; 
            }else{
                if( ( $clinicSubscription['trial_subscription'] == '1')){
                    $trialPlanInfo['showTrialPlanMessage'] = 1; 
                    $trialPlanInfo['trial_day_msg'] = ( $diff_in_days != 0 ) ? 'Your '.$subscriptionPlan['plan_name'].' trial plan will end in '.$diff_in_days.' day(s).' : 'Your '.$subscriptionPlan['plan_name'].' trial plan will end in 0 day(s).' ; 
                }

            }             

            $trialPlanInfo['trial_subscription'] = $clinicSubscription['trial_subscription'];
            if( ( $clinicSubscription['trial_subscription'] == '1'  && $diff_in_days <= 5 && !empty( $clinicSubscription ) ) && ( $userCardCount == 0 || $userBillingCount == 0 ) ){
                $trialPlanInfo['showTrialPlanMessage'] = 1; 
            }

            $data['trialPlanInfo'] = $trialPlanInfo;


            $html        = view('trialmsg',$data);
            $arr['view'] = $html->__toString();
            $arr['message'] ='Trial info fetched successfully.';
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function completeDosespotOnboarding(){
        if (request()->ajax()) {
            $data = request()->all();
            if( !$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $loginUserDetails = ClinicUser::getClinicUserWithClinic();
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID(Session::get('user.clinicID')));
            $clinicKey = $clinicDetails['dosepot_key'];
            $clinicId = $clinicDetails['dosepot_id'];
            $userId = $loginUserDetails['user']['dosespot_clinician_id'];

            list($encryptedClinicId, $userIdVerify) = $this->Corefunctions->sso($clinicKey, $userId);

            $ssoUrl = "https://my.staging.dosespot.com/LoginSingleSignOn.aspx?" .
                "SingleSignOnClinicId=" . urlencode($clinicId) .
                "&SingleSignOnUserId=" . urlencode($userId) .
                "&SingleSignOnPhraseLength=32" .
                "&SingleSignOnCode=" . urlencode($encryptedClinicId) .
                "&SingleSignOnUserIdVerify=" . urlencode($userIdVerify) .
                "&RefillsErrors=1";

            $arr['url'] = $ssoUrl;
            $arr['message'] = 'URL generated successfully.';
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function updateStatus()
    {
        if(request()->ajax()) {
            $loginUserDetails = ClinicUser::getClinicUserWithClinic();

            $userId = $loginUserDetails['user']['dosespot_clinician_id'];
            $result = $this->Corefunctions->registrationStatus($userId);
            if(!empty($result) &&  isset($result['Item']) && $result['Item'] == 'IDPSuccess'){
                DB::table('eprescribers')->where('id',$loginUserDetails['eprescriber_id'])->update(array(
                    'onboarding_completed' => '1',
                ));
            }
           
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

}

