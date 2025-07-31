<?php

namespace App\Http\Controllers\clinics;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use App\Models\Patient;
use App\Models\PatientClinic;
use App\Models\PatientDocs;
use App\Models\User;
use App\Models\ClinicUser;
use App\Models\Consultant;
use App\Models\RefState;
use App\Models\Appointment;
use App\Models\PatientNoteHistory;
use App\Models\BpTracker;
use App\Models\GlucoseTracker;
use App\Models\CholestrolTracker;
use App\Models\WeightTracker;
use App\Models\HeightTracker;
use App\Models\PatientCondition;
use App\Models\FcUserFolder;
use App\Models\RefCountryCode;
use App\Models\ImportDoc;
use App\Models\RefDesignation;
use App\Models\RpmOrders;
use App\Models\Chats;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;
use File;
use DB;

class PatientController extends Controller
{

    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;

        // Middleware for session check
        $this->middleware(function ($request, $next) {
            $sessionCeck = $this->Corefunctions->validateUser();
            if (!$sessionCeck) {
                return Redirect::to('/logout');
            }
            // Check if the session has the 'user' key (adjust as per your session key)
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
             /* Validate onboarding process */
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
            return $next($request);
        });
    }

    public function list(Request $request, $status = 'active')
    {
        if (session()->get('user.userType') == 'patient') {
            return Redirect::to('/dashboard'); // Adjust the URL to your login route
        }
        // DB::table('patients')
        // ->join('users', 'patients.user_id', '=', 'users.id')
        // ->whereNotNull('patients.stripe_customer_id')
        // ->update([
        //     'users.stripe_customer_id' => DB::raw('patients.stripe_customer_id')
        // ]);
        $prioritypatient = request("prioritypatient");
        $rpmpatient = request("rpmpatient");

        /** check for access permission */
        $isPermission =  $this->Corefunctions->checkPermission();
        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
        $searchterm = (isset($_GET['searchterm']) && ($_GET['searchterm'] != '')) ? $_GET['searchterm'] : '' ;
        $patientIds = array();
        /** get the patients id attached for the doctor */
        if ($isPermission == 0) {
            // Get clinic user details
            $clinicUserDetails = userByUUID(session()->get('user.clinicuser_uuid'));
            $clinicUserDetails = $this->Corefunctions->convertToArray($clinicUserDetails);

            $parent_id = session()->get('user.userType') == 'doctor'  ? 'consultant_id' : 'nurse_id';
            $appoinmentDoc = Appointment::getAppointmentByUser($parent_id,$clinicUserDetails['id']);
            $patientIds = $this->Corefunctions->getIDSfromArray($appoinmentDoc, 'patient_id');
        }

        $patientDetails = Patient::getPatientList($isPermission,$patientIds,$searchterm,$status,$limit,$prioritypatient,$rpmpatient);
        // $patientData = Patient::with('user')->select('patients.*', 'patients.dob', DB::raw('TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age'))
        //     ->where('patients.clinic_id', session()->get('user.clinicID'));
        // if ($isPermission == 0) {
        //     $patientData = $patientData->whereIn('patients.id', $patientIds);
        // }
        // // Clone the base query to calculate the counts separately
        // $activeCountQuery = clone $patientData;
        // $inactiveCountQuery = clone $patientData;
        // $pendingCountQuery = clone $patientData;

        // // Calculate the counts
        // $activecount = $activeCountQuery->where('patients.status', '1')->count();
        // $inactiveCount = $inactiveCountQuery->onlyTrashed()->count();
        // $pendingcount = $pendingCountQuery->whereIn('patients.status', array('0', '-1'))->count();

        // if (isset($_GET['searchterm']) && ($_GET['searchterm'] != '')) {
        //     $patientData = $patientData->where('patients.name', 'like', '%' . $_GET['searchterm'] . '%');
        // }

        // if (isset($status) && ($status != '') && ($status == 'inactive')) {
        //     $patientData = $patientData->onlyTrashed();
        // } else if (isset($status) && ($status != '') && ($status == 'pending')) {
        //     $patientData = $patientData->whereIn('patients.status', array('0', '-1'));
        // } else {
        //     $patientData = $patientData->where('patients.status', '1')->whereNull('patients.deleted_at');
        // }
        // $patientData = $patientData->orderBy('patients.id', 'desc')->paginate($limit);

       
        $patientData   = $patientDetails['patientData'];
        $activecount   = $patientDetails['activecount'];
        $inactiveCount = $patientDetails['inactiveCount'];
        $pendingcount  = $patientDetails['pendingcount'];
      
        // Convert to array
        $patientList = $this->Corefunctions->convertToArray($patientData);
     
        $modifiedPatients = [];
        $clinicId = Session::get('user.clinicID');
        // print'<pre>';print_r($patientList['data']);exit;
        foreach ($patientList['data'] as $patient) {
            $appointmentRecords = Appointment::getAppointmentsByDate($patient['user_id'],'past'); 
            if (isset($patient['dob'])) {
                /*jomy*/
                $patient['age'] = $this->Corefunctions->calculateAge($patient['dob']);
            }
            $patient['phone']   = $this->Corefunctions->formatPhoneNumber($patient['country_code'], $this->Corefunctions->formatPhone($patient['phone_number']));
            $patient['country_id'] = $patient['user']['country_id'] = $patient['country_code'];
            $patient['user']['state_id'] = $patient['state_id'];
            $patient['formattedAddress'] = isset($patient['user']) && !empty($patient['user']['address']) && ($patient['user']['address']!='') ? $this->Corefunctions->formatAddress($patient['user']): $this->Corefunctions->formatAddress($patient);
            // Format the previous appointment date and time if available
            if (isset($appointmentRecords['appointment_date']) && isset($appointmentRecords['appointment_time'])) {
                $date = $this->Corefunctions->timezoneChange($appointmentRecords['appointment_date'], "M d, Y");
                $time = $this->Corefunctions->timezoneChange($appointmentRecords['appointment_time'], "h:i A");
                $patient['last_appointment'] = $date . ' | ' . $time;
            } else {
                $patient['last_appointment'] = '--';
            }

            $stats = array('-1','1','2','4');
            /* Fetch Orders */
            $rpmdOrders          = RpmOrders::getRpmOrders($stats,$clinicId,$patient['user_id'],$patient['id']);
            $rpmdOrders          = $this->Corefunctions->getArrayIndexed1($rpmdOrders,'id');
            $orderIDS            = $this->Corefunctions->getIDSfromArray($rpmdOrders,'id');
            $clinicIDS           = $this->Corefunctions->getIDSfromArray($rpmdOrders,'clinic_id');

            /* Fetch Order Devices */
            $rpmdOrderDevices    = RpmOrders::getOrderDevicesByOrderIDS($stats,$orderIDS);
            $devicesIDS          = $this->Corefunctions->getIDSfromArray($rpmdOrderDevices,'rpm_device_id');
            $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
            $devices             = $this->Corefunctions->getArrayIndexed1($devices,'id');
            if( !empty($rpmdOrderDevices) ){
                foreach( $rpmdOrderDevices as $rpk => $rpo){
                    $rpo['device_name']     = ( !empty($devices) && isset($devices[$rpo['rpm_device_id']] ) ) ? $devices[$rpo['rpm_device_id']]['device'] : '';
                    $rpo['device_category']     = ( !empty($devices) && isset($devices[$rpo['rpm_device_id']] ) ) ? $devices[$rpo['rpm_device_id']]['category'] : '';
                    $rpo['device_image']    = ( !empty($devices) && isset($devices[$rpo['rpm_device_id']] ) ) ? asset('images/rpmdevices/'.$devices[$rpo['rpm_device_id']]['category'].'.png')  : '';
                    if( isset( $rpmdOrders[$rpo['rpm_order_id']] ) ){
                        $rpmdOrders[$rpo['rpm_order_id']]['devices'][] = $rpo; 
                    }
                }
            }

            $patient['rpm_orders'] = $rpmdOrders;
          
                    
            $modifiedPatients[] = $patient;
        }
        /** states */
        $stateIds = $this->Corefunctions->getIDSfromArray($patientList['data'], 'state_id');
        $state = RefState::getStateByIDS($stateIds) ;
        $patientList['data'] = $modifiedPatients;
        
        // if (isset($rpmpatient) && $rpmpatient == '1') {
        //     $page = request()->get('page', 1);
        //     $limit = (int) ($request->get('limit') ?? 5);
        //     $perPage = $limit;
        //     $offset = ($page - 1) * $perPage;

        //     $slicedData = array_slice($modifiedPatients, $offset, $perPage);
        //     $patientData = new LengthAwarePaginator(
        //         $slicedData,
        //         count($modifiedPatients),
        //         $perPage,
        //         $page,
        //         ['path' => request()->url(), 'query' => request()->query()]
        //     );
        // }

        
        $seo['title'] = "Patients | " . env('APP_NAME');
        $seo['keywords'] = "Patient Records Management, Track Patient Information, Healthcare Patient Data, Patient History and Appointments, Previous Appointment Tracking, Patient Data Management System, Digital Patient Record System, Health Records Tracking, Patient Contact Information Database";
        $seo['description'] = "Efficiently manage patient records with our comprehensive system. Easily access and update patient profiles to provide personalized care. Ideal for healthcare providers looking to streamline patient management and improve service delivery";
        $seo['og_title'] = "Patients | " . env('APP_NAME');
        $seo['og_description'] = "Efficiently manage patient records with our comprehensive system. Easily access and update patient profiles to provide personalized care. Ideal for healthcare providers looking to streamline patient management and improve service delivery";

        return view('patient.listing', compact('patientList', 'limit', 'patientData', 'status', 'activecount', 'inactiveCount', 'pendingcount', 'state', 'seo'));
    }


    public function create(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            $clinicId = session()->get('user.clinicID');
            $state = RefState::getStateList();
            $doctors = $this->Corefunctions->convertToArray(ClinicUser::getDoctors($clinicId));

            $data['type'] = isset($data['type']) && $data['type'] != '' ?  $data['type'] : '';
            $data['createdfrom'] = isset($data['createdfrom']) && $data['createdfrom'] != '' ?  $data['createdfrom'] : '';
            $data['state'] = $state;
            $data['doctors'] = $doctors;

            $html = view('patient.create', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function store(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            $input['phone_number'] = str_replace(["(", ")", " ","-"], "", $input['phone_number']);
            $input['whatsapp_num'] = (isset($input['whatsapp_num']) && $input['whatsapp_num'] != '') ? str_replace(["(", ")", " ","-"], "", $input['whatsapp_num']) : '';

            // Fetch country ID from ref_country_codes table
            $countryCode = RefCountryCode::getCountryCodeByShortCode($input['countrycode']);

            /** check the patient with users table */
            $userDetails = User::getUserByPhone($input,$countryCode['id']) ;
            // $userDetails = User::select('id', 'user_uuid', 'phone_number')->where('country_code',$countryCode['id'])->where('phone_number', $input['phone_number'])->where('email', $input['email'])->whereNull('deleted_at')->first();
            
            /** check phone number exist with in the same clinic */
            $isValid = $this->Corefunctions->validateClinicUser($input,$countryCode['id']);
            if(isset($isValid['error'])){
                return response()->json([
                    'status' => 1,
                    'message' => $isValid['message'],
                ]);
            }

            $input['first_name']  = $input['name'];
            $input['user_phone']  = $input['phone_number'];
            $input['user_email']  = $input['email'];

            if (empty($userDetails)) {
                $userID = User::insertUser($input,$countryCode,'','-1') ;

            } else {
                $userID = $userDetails['id'];
            }
            $whatsappcountryCode = RefCountryCode::getCountryCodeByShortCode($input['whatsappcountryCode']);

           
            /** Inset Consultant info  */
            $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'patients', 'invitation_key');
            $input['invitationkey']  =  $invitationkey;
            $input['whatsappcountryCode']  =  !empty($whatsappcountryCode) ? $whatsappcountryCode['id'] : null ;
            $patientID = Patient::insertPatient($input,$countryCode,$userID,session()->get('user.userID'),'-1',session()->get('user.clinicID'));
            $clinicDetails = $this->Corefunctions->convertToArray(DB::table('clinics')->whereNull('deleted_at')->where('id',Session::get('user.clinicID'))->first());
            $clinicDetails['clinic_logo'] = isset($clinicDetails['logo']) && ($clinicDetails['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");

            $clinicUserDets = Appointment::getClinicUserDoctor(session()->get('user.clinicID'), $input['doctor']);


            /** Invitation mail */
            $data['name'] = $input['name']. (isset($input['middle_name']) && !empty($input['middle_name']) ? ' ' . $input['middle_name'] : ''). ' ' . $input['last_name'];
            $data['clinicName'] = Session::get('user.clinicName') ; 
            $data['email'] = $input['email'];
            $data['clinicDetails'] = $clinicDetails;
            $data['address'] =  $this->Corefunctions->formatAddress($clinicDetails);
            $data['clinicUserDets'] = $clinicUserDets;
            $data['clinicianName'] = $this->Corefunctions->showClinicanName($clinicUserDets);
            $data['image'] = $this->Corefunctions -> resizeImageAWS($clinicUserDets->user_id,$clinicUserDets['user']->profile_image,$clinicUserDets['user']->first_name,180,180,'1');
            $data['link'] = url('register?invitationkey=p_'.$invitationkey);
            $response = $this->Corefunctions->sendmail($data,'Invitation to Join '.Session::get('user.clinicName'), 'emails.patientinvitationnew');

       

            $arr['success'] = 1;
            $arr['createdfrom'] = $input['createdfrom'];
            $arr['patientname'] = $input['name'].' '. $input['last_name'];
            $arr['patientid'] = $userID;
            $arr['message'] = 'Patient added successfully';
            return response()->json($arr);
            exit();
        }
    }

    public function details($key)
    {
        if (Session::has('user') && session()->get('user.userType') == 'patient') {
            return Redirect::to('/');
        }
        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;

        /** get patient Details */
        $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUUID($key));
        if (empty($patientDetails)) {
            return redirect('/patients');
        }
        if($patientDetails['clinic_id'] != session()->get('user.clinicID')){
            return redirect('/patients');
        }

        $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
        $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'].' '.$patientDetails['user']['last_name'] : $patientDetails['first_name'].' '.$patientDetails['last_name'];
        $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);
        $patientDetails['country_id']       = $patientDetails['user']['country_id'] = $patientDetails['country_code'];
        $patientDetails['formattedAddress'] = (isset($patientDetails['user']) && $patientDetails['user']['address'] !='') ? $this->Corefunctions->formatAddress($patientDetails['user']) : $this->Corefunctions->formatAddress($patientDetails);
        /** get the previous appointment */
        $appointmentRecords = Appointment::getAppointmentsByDate($patientDetails['user_id'],'past');
        // $appointmentRecords = Appointment::select('appointment_date', 'appointment_time')->where(DB::raw("CONCAT(appointment_date, ' ', appointment_time)"), '<', now())->where('clinic_id', session()->get('user.clinicID'))->where('status', '1')->orderBY('id', 'desc')->where('patient_id', $patientDetails['user_id'])->first();
        /** Get the next upcoming appointment */
        $nextAppointment = Appointment::getAppointmentsByDate($patientDetails['user_id'],'upcoming');
        
        $patientDocument = PatientDocs::getPatientDocs($patientDetails['id']); 
       
        foreach ($patientDocument as $key => $val) {
            if ($val['doc_path'] != '') {
                $patientDocument[$key]['temdocppath'] = $this->Corefunctions->getAWSFilePath($val['doc_path']);
            }
        }
        $state = RefState::getStateByID($patientDetails['state_id']);
        $patientDetails['state'] = !empty($state) ?  $state['state_name'] :  $patientDetails['state'];
        $countryCodeDetails = RefCountryCode::getCountryCodeById($patientDetails['country_code']) ;
        
        $seo['title'] = 'Patient Details | BlackBag';
        $type = 'patient';
        
        $showPrescription = $this->Corefunctions->showPrescription(Session::get('user.clinicuser_uuid'));
       
        $clinicUserDetails = ClinicUser::userByUUID(session()->get('user.clinicuser_uuid'));
         
        /* Chat */
        $hasUnReadChat = '0';
        if( !empty($clinicUserDetails) ){
            $chatInfo  = array();
            $chatInfo['from_clinic_user_id'] = $clinicUserDetails->id;
            $chatInfo['from_user_id']        = $clinicUserDetails->user_id;
            $chatInfo['to_patient_id']       = $patientDetails['id'];
            $chatInfo['to_user_id']          = $patientDetails['user_id'];
            $chatInfo['clinic_id']           = Session::get('user.clinicID');
            $chatInfo['chat_type_id']        = '1';
            $chat                            = Chats::getChat($chatInfo);
            if( !empty($chat) ){
                $participants                         = array();
                $participants['chat_id']              = $chat['id'];
                $participants['user_id']              = $chat['from_user_id'];
                $participants['participant_id']       = $clinicUserDetails->id;
                $participants['participant_type_id']  = '1';
                $chatParticipant                 = Chats::getChatParticipant($participants);
                if( !empty($chatParticipant) ){
                    $lastReadTime    = $chatParticipant['last_read_time'];
                    $hasUnReadChat   = Chats::checkUnreadMessageExists($chat['id'],$lastReadTime);
                }
            }
            
        }
    
        

        return view('patient.details', compact('patientDetails', 'patientDocument', 'appointmentRecords', 'countryCodeDetails', 'seo','nextAppointment','type','showPrescription','hasUnReadChat'));
    }

    public function removeDoc()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $patientDocument = PatientDocs::where('patient_doc_uuid', $data['key'])->whereNull('deleted_at')->first();
            $patientDocument->delete();

            $arr['message'] = 'Patient document deleted successfully.';
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    //Appointment List Function
    public function appointmentList()
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $userTimeZone = session()->get('user.timezone');
            $userType     = session()->get('user.userType'); // Get logged in clinic ID
            $limit        = isset($data['limit']) ? intval($data['limit']) : 10; // Default limit
            $type         = $data['type'];
            $status       = $data['status'];
            $page         = $data['page'];
            $patientKey   = $data['patientKey'];

            $patient = Patient::getPatientWithUser($patientKey);

            if (empty($patient)) {
                return $this->Corefunctions->returnError('Invalid details');
            }
            if($patient['clinic_id'] != session()->get('user.clinicID')){
                return $this->Corefunctions->returnError("You don't have permission to access this.");
            }
            $fullpermission = '0';
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
            if ($userType != 'patient') {
                $fullpermission = '1';
                $loginUserDetails =ClinicUser::getClinicUserByUuid($clinicuser_uuid);
                if (empty($loginUserDetails)) {
                    return back()->with('error', "Invalid clinic details or not found!");
                }
            } else {
                $fullpermission = '0';
                $loginUserDetails = Patient::patientByUUID($clinicuser_uuid);
                if (empty($loginUserDetails)) {
                    return back()->with('error', "Invalid clinic details or not found!");
                }
            }
            
            $appointments = array();
            // Base query for online appointments
            // Handle Online Appointments
            if ($data['type'] == 'appointments') {

                $onlineRecords =   Appointment::getPatientAppointmentList(session()->get('user.clinicID'),$userTimeZone,$patient['user_id'],$status,$limit,$page);

                $openCount = $onlineRecords['openCount'] ;
                $receptionCount = $onlineRecords['receptionCount'] ;
                $cancelledCount = $onlineRecords['cancelledCount'] ;
                $completedCount = $onlineRecords['completedCount'] ;
                $perPage = $onlineRecords['perPage'] ;
                $appointmentRecords = $onlineRecords['appointments'];
              
                $appointmentRecordDetails = $this->Corefunctions->convertToArray($onlineRecords['appointments']);
                
                /** get doctor details for appointments */
                $doctorIds = $this->Corefunctions->getIDSfromArray($appointmentRecordDetails['data'], 'consultant_id');
                $doctorDetails = ClinicUser::getAllClinicUsersByUserID($doctorIds,'patient');
                $doctorDetails = $this->Corefunctions->getArrayIndexed1($doctorDetails, 'user_id');    
            }
            $data['userTimeZone'] = $userTimeZone;
            $data['patientKey'] = $patientKey;
            $data['type'] = $data['type'];
            $data['status'] = $data['status'];
            $data['limit'] = $limit;
            $data['patient'] = $patient;
            $ispatient = 1;

            if ($data['type'] == 'medical') {
                $html = view('patient.medical_history', $data);
                $arr['view'] = $html->__toString();
            } else if ($data['type'] == 'filecabinet') {
                $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

                if (isset($usertype) && $usertype == 'patient') {
                    $folders = FcUserFolder::getFolders($patient['user_id']);
                } else {
                    $folders = FcUserFolder::getFoldersByClinicId($patient['user_id'], $clinicID);
                }

                $userIDs = $this->Corefunctions->getIDSfromArray($folders, 'created_by');
                $userDetails = User::getUsersByIDs($userIDs);
                $clinicUser  = ClinicUser::getAllClinicUsersByUserID($userIDs,'patient');
              
                $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'id');
                $clinicUser = $this->Corefunctions->getArrayIndexed1($clinicUser, 'user_id');

                $data['folders'] = $folders;
                $data['userDetails'] = $userDetails;
                $data['clinicUser'] = $clinicUser;


                $html = view('frontend.filecabinet.folders', $data);
                $arr['view'] = $html->__toString();
            } else if ($data['type'] == 'appointments') {
                $appointments = $appointmentRecordDetails['data'];
                $appointmentRecordList = $appointmentRecords;
                $html = view('patient.appointment_list', compact('userTimeZone', 'appointments', 'appointmentRecordList', 'perPage', 'status', 'type', 'fullpermission', 'ispatient', 'openCount', 'receptionCount', 'cancelledCount', 'completedCount', 'patientKey','doctorDetails', 'limit'));
                $arr['view'] = $html->__toString();
                $arr['pagination'] = $appointmentRecords->links('pagination::bootstrap-4')->render();
            }

            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function uploadDocument()
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
            $tempdocid = Patient::insertTempDocs($docKey, $ext, $filename);

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

    public function destroy()
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
                $patient = Patient::onlyTrashed()->where('patients_uuid', $data['key'])->first();
                if (empty($patient)) {
                    $arr['error'] = 1;
                    $arr['errormsg'] = 'Invalid patient.';
                    return response()->json($arr);
                    exit();
                }
                Patient::onlyTrashed()->where('patients_uuid', $data['key'])->restore();
                $arr['message'] = 'Patient activated successfully.';
            } else {
                $patient = Patient::patientByUUID($data['key']);
                if (empty($patient)) {
                    $arr['error'] = 1;
                    $arr['errormsg'] = 'Invalid patient.';
                    return response()->json($arr);
                    exit();
                }
              
                $appointmentDetails = Appointment::appoinmentByPatient($patient->user_id);
               
                if (!empty($appointmentDetails)) {
                    $arr['error'] = 1;
                    $arr['errormsg'] = 'The patient cannot be deleted, they have an active appointment. Please cancel the appointment before proceeding.';
                    return response()->json($arr);
                    exit();
                }

                if($patient['clinic_id'] != session()->get('user.clinicID')){
                    $arr['error'] = 1;
                    $arr['errormsg'] = "You don't have permission to delete this patient.";
                    return response()->json($arr);
                    exit();
                }

                $patient->delete();
                $arr['message'] = 'Patient deactivated successfully.';
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
            if (!isset($data['key'])) {
                return $this->Corefunctions->returnError('Fields missing');
               
            }
            $patientDetails = Patient::getPatientWithUser($data['key']);

            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Patient does not exists');
            }
            if($patientDetails['clinic_id'] != session()->get('user.clinicID')){
                return $this->Corefunctions->returnError("You don't have permission to access this.");
            }

            $countryCodedetails = RefCountryCode::getCountryCodeById($patientDetails['country_code']);
            $patientDetails['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
            if ($patientDetails['whatsapp_country_code'] != '') {
                $countryCodedetailsWhatsapp = RefCountryCode::getCountryCodeById($patientDetails['whatsapp_country_code']); 
                $patientDetails['whatsapp_country_code'] = !empty($countryCodedetailsWhatsapp) ? $countryCodedetailsWhatsapp['country_code'] : $patientDetails['whatsapp_country_code'];
                $patientDetails['whatsapp_short_code']   = !empty($countryCodedetailsWhatsapp) ? $countryCodedetailsWhatsapp['short_code'] : null;
            }

            $state = RefState::getStateList();
            
            $patientDetails['logo_path'] = ($patientDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($patientDetails['logo_path']) : '';
            $patientDocument = PatientDocs::getPatientDocs($patientDetails['id']);
            foreach ($patientDocument as $key => $val) {
                if ($val['doc_path'] != '') {
                    $patientDocument[$key]['temdocppath'] = $this->Corefunctions->getAWSFilePath($val['doc_path']);
                }
            }
            
            $clinicId = session()->get('user.clinicID');
            $doctors = $this->Corefunctions->convertToArray(ClinicUser::getDoctors($clinicId));

            $data['patientDetails'] = $patientDetails;
            $data['patientDocument'] = $patientDocument;
            $data['countryCodedetails'] = $countryCodedetails;
            $data['state'] = $state;
            $data['doctors'] = $doctors;

            $html = view('patient.edit', $data);
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

            if (empty($data)) {
                return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
            }
            if (empty($data['key'])) {
                return response()->json(['error' => 1, 'errormsg' => 'Key missing']);
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            $input['phone_number'] = str_replace(["(", ")", " ","-"], "", $input['phone_number']);
            $input['whatsapp_num'] = (isset($input['whatsapp_num']) && $input['whatsapp_num'] != '') ? str_replace(["(", ")", " ","-"], "", $input['whatsapp_num']) : '';

            $patientDetails      = Patient::patientByUUID($data['key']) ;
            $countryCodedetails  = RefCountryCode::getCountryCodeByShortCode($input['countrycode']);
            $whatsappcountryCode = RefCountryCode::getCountryCodeByShortCode($input['whatscountrycode']);
           
            $email    = $input['email'];
            $phone    =  str_replace(["(", ")", " ","-"], "", $input['phone_number']);
            $clinicId = session()->get('user.clinicID');

            // 1. Check if email exists and if it is associated with the same phone and country code
            $emailExists = Patient::validatePatient($email,$clinicId,$patientDetails->id,$patientDetails->user_id,$phone,$countryCodedetails['id']);
            if(isset($emailExists['error']) && $emailExists['error'] =='1'){
                return $this->Corefunctions->returnError($emailExists['errormsg']);
              
            }
            // $isValid = $this->Corefunctions->validateClinicUser($input,$countryCodedetails['id'],$clinicUserDetails);
            // if(isset($isValid['error'])){
            //     return response()->json([
            //         'status' => 1,
            //         'message' => $isValid['message'],
            //     ]);
            // }


            $input['type'] = request('type') ;
            Patient::updatePatient($patientDetails->id,$input,$whatsappcountryCode,$countryCodedetails);
          
            if ($patientDetails->user_id != NULL) {
             
                $userDetails = User::userByID($patientDetails->user_id,'all') ;
                $input['username'] = $input['name'];
                User::updateUserData($input,$countryCodedetails,$userDetails);
                
            }
            //Save history into DB
            PatientNoteHistory::insertHistory($patientDetails);
            
            /* not in use */
            $crppath = (isset($patientDetails->logo_path) && ($patientDetails->logo_path != '')) ? $patientDetails->logo_path : '';

            $arr['success'] = 1;
            $arr['message'] = 'Patient updated successfully';
            return response()->json($arr);
            exit();
        }
    }

    /** delete imported data of doctors */
    public function deleteDoc(Request $request)
    {
        if ($request->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Data missing'
                ]);
            }
            $importDocList = ImportDoc::importDocsByKey($data['importKey']);
            if (empty($importDocList)) {
                $arr['success'] = 0;
                $arr['message'] = 'Invalid records.';
                return response()->json($arr);
            }
            ImportDoc::updateImportDoc($data['importKey']) ;
           
            $arr['success'] = 1;
            $arr['message'] = 'Records removed successfully';
            return response()->json($arr);
        }
    }
    /* referPatient- not in user */
    public function referPatient(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (!isset($data['key'])) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
            $patientDetails = $this->Corefunctions->convertToArray(Patient::where('patients_uuid', $data['key'])->where('status', '1')->first());
            if (empty($patientDetails)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Patient does not exists';
                return response()->json($arr);
            }
            $patientClinicDetails = $this->Corefunctions->convertToArray(PatientClinic::where('patient_id', $patientDetails['id'])->where('clinic_id', session()->get('user.clinicID'))->first());
            if (empty($patientClinicDetails)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Patient does not exists in this clinic';
                return response()->json($arr);
            }

            $data['patient_key'] = $data['key'];

            $html = view('patient.refer', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function downloadSampleDoc()
    {
        $filename = "Patient_Sample_Doc.xlsx";
        $headers = array(
            'Content-Type: application/excel',
        );
        $docppath = SAMPLEPATH . 'Patient_Sample_Doc.xlsx';

        return response()->download($docppath, $filename, $headers);
    }

    /** Import sections */
    public function import(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            $html = view('patient.import', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function importPatients(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                try {
                    // Load the uploaded file
                    $file = $request->file('file');
                    $spreadsheet = IOFactory::load($file->getPathname()); // Load the spreadsheet
                    $sheet = $spreadsheet->getActiveSheet();              // Retrieve the active sheet
                    $data = $sheet->toArray();                            // Convert the sheet to an array

                    $validRecords = [];   // For valid records
                    $errorRecords = [];   // For records with errors (existing emails)
                    $emails = [];  // Track emails to identify duplicates within the file
                    $duplicateEmails = []; // To store duplicate emails in the file


                    $nonEmptyRows = array_filter($data, function ($row) {
                        // Skip rows with no content
                        return !empty(array_filter($row));
                    });
                    // Define the required columns
                    $requiredColumns = ['name', 'gender', 'email', 'date of birth', 'address', 'city', 'state', 'zip', 'phone number', 'country code', 'whatsapp number', 'whatsapp country code'];
                    // Get the first row as headers
                    $headers = array_map('strtolower', $data[0]);
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
                    // Define a regex pattern for mm/dd/yyyy, mm-dd-yyyy, mm/dd/yy, or mm-dd-yy format
                    $datePattern = '/^(0[1-9]|1[0-2])[\/-](0[1-9]|[12][0-9]|3[01])[\/-](\d{2}|\d{4})$/';

                    $nonEmptyRows = array_slice($data, 1);
                    $invalidEmails = [];
                    $invalidPhoneNumbers = [];
                    foreach ($nonEmptyRows as $index => $row) {
                        $row = array_combine($headers, $row); // Map row values to header keys for easier access
                        if (!empty($row['email']) && !filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                            $invalidEmails[] = $row['email'];
                        }
                        // Validate phone number (at least 10 digits)
                        if (!empty($row['phone number']) && !preg_match('/^\d{10,}$/', $row['phone number'])) {
                            $invalidPhoneNumbers[] = $row['phone number'];
                        }
                    }

                    // Check if there are invalid emails
                    if (!empty($invalidEmails)) {
                        $arr['error'] = 1;
                        $arr['message'] = 'The uploaded file contains invalid email addresses: ' . implode(', ', $invalidEmails);
                        return response()->json($arr);
                    }

                    if (!empty($invalidPhoneNumbers)) {
                        $arr['error'] = 1;
                        $arr['message'] = 'The uploaded file contains invalid phone numbers (must be at least 10 digits): ' . implode(', ', $invalidPhoneNumbers);
                        return response()->json($arr);
                    }

                    $importDocIDs = array();
                    $import_key = $this->Corefunctions->generateUniqueKey('10', 'import_docs', 'import_key');
                
                    foreach ($data as $index => $row) {

                        if ($index === 0 || empty(array_filter($row))) {
                            continue; // Skip header or empty rows
                        }
                        $rowData = [];

                        // Check if 'date of birth' is set and validate it
                        $dob = strtolower(trim($row[array_search('date of birth', $headers)] ?? ''));

                        // Convert the date to 'Y-m-d' format
                        $formattedDob = isset($row[3]) ? trim($row[3]) : '';
                        if (strpos($dob, '/') !== false) {
                            $formattedDob = date('Y-m-d', strtotime($dob));
                        } elseif (strpos($dob, '-') !== false) {
                            list($month, $day, $year) = explode('-', $dob);
                            $formattedDob = date('Y-m-d', strtotime("{$month}/{$day}/{$year}"));
                        }
                        $countrycode         = isset($row[9]) ? trim($row[9]) : '';
                        $whatsappcountrycode = isset($row[11]) ? trim($row[11]) : '';
                        $state               = isset($row[6]) ? trim($row[6]) : '';

                        $countryCodedetails         = RefCountryCode::getCountryCodeByCode($countrycode);
                        $whatsappCountryCodedetails = RefCountryCode::getCountryCodeByCode($whatsappcountrycode);
                        $state                      = RefState::getState($state);
                       
                        $insertArr = array();
                        $insertArr['import_doc_uuid'] = $this->Corefunctions->generateUniqueKey("10", "import_docs", "import_doc_uuid");
                        $insertArr['name'] = isset($row[0]) ? trim($row[0]) : ''; // Adjust according to the column index
                        $insertArr['email'] = isset($row[1]) ? trim($row[1]) : '';
                        $insertArr['gender'] = isset($row[2]) ? trim($row[2]) : '';
                        $insertArr['dob'] = $formattedDob;
                        $insertArr['address'] = isset($row[4]) ? trim($row[4]) : '';
                        $insertArr['city'] = isset($row[5]) ? trim($row[5]) : '';
                        $insertArr['state'] = !empty($state) ? $state['id'] : null;
                        $insertArr['zip'] = isset($row[7]) ? trim($row[7]) : '';
                        $insertArr['phone_number'] = isset($row[8]) ? trim($row[8]) : '';
                        $insertArr['country_code'] =  !empty($countryCodedetails) ? $countryCodedetails['id'] : null;
                        $insertArr['whatsappnumber'] = isset($row[10]) ? trim($row[10]) : '';
                        $insertArr['whatsapp_country_code'] = !empty($whatsappCountryCodedetails) ? $whatsappCountryCodedetails['id'] : null;
                        $insertArr['userID'] = session()->get('user.userID');
                        $insertArr['type'] = 3;

                       
                        // $existingUser  = User::where('email', $insertArr['email'])->first();
                        /** check email exist with in the same clinic */
                        $emailExists = ClinicUser::getClinicUserByEmail($insertArr);
                        
                        /** check phone number exist with in the same clinic */
                        $phoneExists = ClinicUser::getClinicUserByPhone($insertArr,$countryCodedetails['id']);
                        

                         /** check email exist with in the same clinic */
                        $emailExistsPatient = Patient::getPatientByEmail($insertArr);
                        
                        /** check phone number exist with in the same clinic */
                        $phoneExistsPatient = Patient::getPatientByPhone($insertArr,$countryCodedetails['id']);
                        
                        // check phone number exist in the same clicnic
                        $existClinincData = ClinicUser::where('phone_number', $insertArr['phone_number'])->where('clinic_id', session()->get('user.clinicID'))->first();
                        
                        /** check for contry codes  */
                        $validcountrycode = $this->Corefunctions->validateCountryCode($countrycode, $whatsappcountrycode);

                        $rowData = [];
                        $isRecordValid = true; // Flag to track if all required columns are present
                        $insertArr['error'] = '';
                        foreach ($requiredColumns as $columnName) {
                            $columnIndex = array_search($columnName, $headers);
                            $rowData[$columnName] = isset($row[$columnIndex]) ? trim($row[$columnIndex]) : null;

                            if ($columnName !== 'note' && empty($rowData[$columnName])) {

                                if (!preg_match($datePattern, $dob)) {
                                    $insertArr['dob'] = isset($row[3]) ? trim($row[3]) : '';
                                    $insertArr['status']            = '-1';
                                    $insertArr['error'] .= 'The uploaded file does not contain valid data for ' . $columnName . ' and invalid date format.';
                                } else {
                                    $insertArr['status']            = '-1';
                                    $insertArr['error'] .=  'The uploaded file does not contain valid data for ' . $columnName;
                                }
                                $isRecordValid = false; // Mark record as invalid
                                break; // Exit the loop and go to the next record
                            }
                        }
                        if (empty($countryCodedetails)) {
                            $insertArr['status']            = '-1';
                            $insertArr['error'] .= 'Invalid country code details are entered.';
                        }
                      

                        // Proceed with additional checks only if the record is valid
                       if (!empty($emailExists)) {
                            $insertArr['status']            = '-1';
                            $insertArr['error'] .= 'User already exist with same email.';
                            $errorRecords[] = $insertArr;
                        }else if (!empty($phoneExists)) {
                            $insertArr['status']            = '-1';
                            $insertArr['error'] .= 'User already exist with same phone number.';
                            $errorRecords[] = $insertArr;
                        }else if (!empty($emailExistsPatient)) {
                            $insertArr['status']            = '-1';
                            $insertArr['error'] .= 'The patient already exists with the same email in the clinic.';
                            $errorRecords[] = $insertArr;
                        }else if (!empty($phoneExistsPatient)) {
                            $insertArr['status']            = '-1';
                            $insertArr['error'] .= 'The patient already exists with the same phone number in the clinic.';
                            $errorRecords[] = $insertArr;
                        } elseif ($validcountrycode == '0') {
                            $insertArr['status']            = '-1';
                            $insertArr['error'] .= 'Please add a valid country code.';
                            $errorRecords[] = $insertArr;
                        } elseif (!preg_match($datePattern, $dob)) {
                            $insertArr['status']            = '-1';
                            $insertArr['dob'] = isset($row[3]) ? trim($row[3]) : '';
                            $insertArr['error'] .= 'Invalid date format. Expected format: mm/dd/yy or mm-dd-yy. ';
                        } elseif (in_array($insertArr['email'], $emails)) {
                            $insertArr['status']            = '-1';
                            $insertArr['error'] .= 'Duplicate email found within the uploaded file.';
                            $duplicateEmails[] = $insertArr['email'];
                        } elseif (!filter_var($insertArr['email'], FILTER_VALIDATE_EMAIL)) {
                            $insertArr['status']            = '-1';
                            $insertArr['error'] .= 'Invalid email format.';
                            continue;
                        }
                        $importDocID = Consultant::insertConsultantExcelData($insertArr, $import_key, session()->get('user.clinicID'));
                        $emails[] = $insertArr['email'];
                    }
                    // Return a preview page with both valid and error records
                    $arr['success'] = 1;
                    $arr['message'] = 'Preview the uploaded file.';
                    $arr['import_key'] = $import_key;
                    $arr['errorRecor?ds'] = $errorRecords;
                    return response()->json($arr);
                } catch (\Exception $e) {
                    // Rollback the transaction in case of an error
                    DB::rollBack();
                    return response()->json(['error' => 'Error importing patients: ' . $e->getMessage()], 500);
                }
            }
        }
    }

    public function excelPreview($importKey)
    {
        return view('patient.excelpreview', compact('importKey'));
    }

    public function importPreview(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }

            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
            $importKey = $data['importKey'];
            $lastExportID = (isset($data['lastExportID']) && ($data['lastExportID'] != '0')) ? $data['lastExportID'] : '0' ;
            /** Get the imported exel data  */
            $excelDetails = ImportDoc::getImportDocs($importKey,$lastExportID);
            

            /** get countryIds */
            $countrycodeIds = $this->Corefunctions->getIDSfromArray($excelDetails, 'country_code');
            $countryCodedetails = RefCountryCode::getCountryCodeByIDS($countrycodeIds) ;
          
            $whatsappcountrycodeIds     = $this->Corefunctions->getIDSfromArray($excelDetails, 'whatsapp_country_code');
            $whatsappcountryCodedetails = RefCountryCode::getCountryCodeByIDS($whatsappcountrycodeIds) ;
           
            $lastExportID  = 0;
            if (!empty($excelDetails)) {
                foreach ($excelDetails as $cdkey => $cdvalue) {

                    $cdvalue['country_code'] = $lastExportID = $cdvalue['id'];
                }
            }
            /** get designation ids  */
            $designationIds = $this->Corefunctions->getIDSfromArray($excelDetails, 'designation_id');
            $designationDeatils = RefDesignation::getDesignationByIDS($designationIds) ;
           
            $data['lastExportID'] = $lastExportID;
            $data['designationDeatils'] = $designationDeatils;
            $data['excelDetails'] = $excelDetails;
            $data['countryCodeDetails'] = $countryCodedetails;
            $data['whatsappcountryCodedetails'] = $whatsappcountryCodedetails;
            $data['importKey'] = $importKey;

            $html = view('patient.preview', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    /** Store imported data of doctors */
    public function storePreview(Request $request)
    {
        if ($request->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Data missing'
                ]);
            } 
            $importDocList = ImportDoc::getImportDocsByKey($data['importKey']);
            if (!empty($importDocList)) {
                foreach ($importDocList as $index => $row) {
                    /** check the patient with users table */
                    $userDetails = User::userByPhoneNumber($row['phone_number']);
                    
                    /** Inset clinic users Consultant info  */
                    $row['first_name']  = $row['name'];
                    $row['user_phone']  = isset($row['phone_number']) ? $row['phone_number'] : null;
                    $row['user_email']  = $row['email'];
                    $row['gender']       = (strtolower($row['gender']) == 'female') ? 2 : ((strtolower($row['gender']) == 'male') ? 1 : 3);
                    $userCountryCode['id']  =  isset($row['country_code']) && $row['country_code'] != '' ? $row['country_code'] :  '+1';
                
                    if (empty($userDetails)) {
                        /* insert to user */
                        $userID = User::insertUser($row,$userCountryCode,'','-1') ;
                    } else {
                        $userID = $userDetails->id;
                    }
                    $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'patients', 'invitation_key');
                    /** Inset Consultant info  */
                    
                    $row['whatsapp_num'] = isset($row['whatsapp_number']) ? $row['whatsapp_number'] : null;
                    $row['state_id']     = $row['state'];
                    $row['whatsappcountryCode']     = isset($row['whatsapp_country_code']) ? $row['whatsapp_country_code'] : '+1';
                    $row['invitationkey']     = $invitationkey ;
                    

                    Patient::insertPatient($row,$userCountryCode,$userID,session()->get('user.userID'),'-1',session()->get('user.clinicID')) ;
                    $clinicDetails = $this->Corefunctions->convertToArray(DB::table('clinics')->whereNull('deleted_at')->where('id',Session::get('user.clinicID'))->first());
                    $clinicDetails['clinic_logo'] = isset($clinicDetails['logo']) && ($clinicDetails['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");
                    if(isset($input['doctor']) && $input['doctor'] != ''){
                        $clinicUserDets = Appointment::getClinicUserDoctor(session()->get('user.clinicID'), $input['doctor']);
                    }else{
                        $clinicUserDets = ClinicUser::getClinicUserByUserId( Session::get('user.userID'));
                    }

                    /** Invitation mail */
                    $data['name'] = $row['name'];
                    $data['clinicName'] = Session::get('user.clinicName') ; 
                    $data['email'] = $row['email'];
                    $data['clinicDetails'] = $clinicDetails;
                    $data['address'] =  $this->Corefunctions->formatAddress($clinicDetails);
                    $data['clinicUserDets'] = $clinicUserDets;
                    $data['clinicianName'] = $this->Corefunctions->showClinicanName($clinicUserDets);
                    $data['image'] = $this->Corefunctions -> resizeImageAWS($clinicUserDets->user_id,$clinicUserDets['user']->profile_image,$clinicUserDets['user']->first_name,180,180,'1');
                    $data['link'] = url('register?invitationkey=p_'.$invitationkey);
                    $response = $this->Corefunctions->sendmail($data,'Invitation to Join '.Session::get('user.clinicName'), 'emails.patientinvitationnew');
                }
            }
            $arr['success'] = 1;
            $arr['message'] = 'Patients imported successfully';
            return response()->json($arr);
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
            $patientDetails =Patient::getPatientWithUser( $data['key']);
           
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Invalid Data');
                
            }
            $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'patients', 'invitation_key');
            Patient::updateInvitationKey($patientDetails['id'],$invitationkey) ;
          
            $clinicDetails = $this->Corefunctions->convertToArray(DB::table('clinics')->whereNull('deleted_at')->where('id',Session::get('user.clinicID'))->first());
            $clinicDetails['clinic_logo'] = isset($clinicDetails['logo']) && ($clinicDetails['logo'] !='' ) ? $this->Corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");
            if(isset($patientDetails['assigned_clinic_user_id']) && $patientDetails['assigned_clinic_user_id'] != ''){
                $clinicUserDets = Appointment::getClinicUserDoctor(session()->get('user.clinicID'), $patientDetails['assigned_clinic_user_id']);
            }else{
                $clinicUserDets = ClinicUser::getClinicUserByUserId( Session::get('user.userID'));
            }

            /** Invitation mail */
            $data['name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
            $data['clinicName'] = Session::get('user.clinicName') ; 
            $data['email'] = $patientDetails['email'];
            $data['clinicDetails'] = $clinicDetails;
            $data['address'] =  $this->Corefunctions->formatAddress($clinicDetails);
            $data['clinicUserDets'] = $clinicUserDets;
            $data['clinicianName'] = $this->Corefunctions->showClinicanName($clinicUserDets);
            $data['image'] = $this->Corefunctions -> resizeImageAWS($clinicUserDets->user_id,$clinicUserDets['user']->profile_image,$clinicUserDets['user']->first_name,180,180,'1');
            $data['link'] = url('register?invitationkey=p_'.$invitationkey);
            $response = $this->Corefunctions->sendmail($data,'Invitation to Join '.Session::get('user.clinicName'), 'emails.patientinvitationnew');

            $arr['success'] = 1;
            $arr['message'] = 'Invitation resent successfully';
            return response()->json($arr);
            exit();
        }
    }

    /* not in use */
    public function downloaDocument($key)
    {
        $patientDocument = PatientDocs::getPatientDocsByKey($key);
        $filename = $patientDocument->orginal_name;
        $Docname = $patientDocument->patient_doc_uuid . '.' . $patientDocument->doc_ext;

        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $Docname . '"',
        ];
        $temdocppath = $this->Corefunctions->getAWSFilePath($patientDocument->doc_path);
        return response()->streamDownload(function () use ($temdocppath) {
            readfile($temdocppath);
        }, $Docname, $headers);
        exit;
    }

    public function markAsPriority(){
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $patientDetails = Patient::getPatientWithUser( $data['key'] );
           
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Invalid Data');
            }

            if($data['type'] == 'setaspriority'){
                Patient::where('patients_uuid', $data['key'])->update(array(
                    'is_priority_patient' => '1',
                ));
                $arr['message'] = 'Patient marked as priority patient successfully.';
            }else{
                Patient::where('patients_uuid', $data['key'])->update(array(
                    'is_priority_patient' => '0',
                ));
                $arr['message'] = 'Patient removed from priority successfully.';
            }

            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function fetchDevices(){
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $patientDetails = Patient::getPatientWithUser( $data['key']);
           
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Invalid Data');
            }

            $clinicId = Session::get('user.clinicID');
            $stats = array('-1','1','2','4');
            /* Fetch Orders */
            $rpmdOrders          = RpmOrders::getRpmOrders($stats,$clinicId,$patientDetails['user_id'],$patientDetails['id']);
            $rpmdOrders          = $this->Corefunctions->getArrayIndexed1($rpmdOrders,'id');
            $orderIDS            = $this->Corefunctions->getIDSfromArray($rpmdOrders,'id');
            $clinicIDS           = $this->Corefunctions->getIDSfromArray($rpmdOrders,'clinic_id');

            /* Fetch Order Devices */
            $rpmdOrderDevices    = RpmOrders::getOrderDevicesByOrderIDS($stats,$orderIDS);
            $devicesIDS          = $this->Corefunctions->getIDSfromArray($rpmdOrderDevices,'rpm_device_id');
            $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
            $devices             = $this->Corefunctions->getArrayIndexed1($devices,'id');
            if( !empty($rpmdOrderDevices) ){
                foreach( $rpmdOrderDevices as $rpk => $rpo){
                    $rpo['device_name']     = ( !empty($devices) && isset($devices[$rpo['rpm_device_id']] ) ) ? $devices[$rpo['rpm_device_id']]['device'] : '';
                    $rpo['device_category']     = ( !empty($devices) && isset($devices[$rpo['rpm_device_id']] ) ) ? $devices[$rpo['rpm_device_id']]['category'] : '';
                    $rpo['device_image']    = ( !empty($devices) && isset($devices[$rpo['rpm_device_id']] ) ) ? asset('images/rpmdevices/'.$devices[$rpo['rpm_device_id']]['category'].'.png')  : '';
                    if( isset( $rpmdOrders[$rpo['rpm_order_id']] ) ){
                        $rpmdOrders[$rpo['rpm_order_id']]['devices'][] = $rpo; 
                    }
                }
            }

            $html = view('patient.appenddevices', compact('rpmdOrders'));
            $arr['success'] = 1;
            $arr['view'] = $html->__toString();
            return response()->json($arr);
            exit();
        }
    }
}
