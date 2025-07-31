<?php

namespace App\Http\Controllers\clinics;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Clinic;
use App\Models\ClinicUser;
use App\Models\User;
use App\Models\Consultant;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\VideoCallParticipant;
use App\Models\VideoCall;
use App\Models\BpTracker;
use App\Models\RefCountryCode;
use App\Models\Medication;
use App\Models\HeightTracker;
use App\Models\WeightTracker;
use App\Models\OxygenSaturation;
use App\Models\BodyTemperature;
use App\Models\PatientCondition;
use App\Models\Allergy;
use App\Models\CholestrolTracker;
use App\Models\GlucoseTracker;
use App\Models\Immunization;
use App\Models\RefTemperature;
use App\Models\RefLabTest;
use App\Models\PatientImagingTest;
use App\Models\PatientLabTest;
use App\Models\PatientCard;
use App\Models\PatientSubscription;
use App\Models\Payment;
use App\Models\ClinicCard;
use App\Models\RefConsultationTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Route;
class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->stripePayment      = new \App\customclasses\StripePayment;
        $this->MetaInfo = new \App\customclasses\MetaInfo;
        $this->middleware(function ($request, $next) {
            $method = Route::current()->getActionMethod();
            if(!in_array($method,array('joinVideo','joinMeet','acceptcall','videocallend','acceptcallcheck','fetchVideocallDetails','getNotes'))){
                if (Session::has('user') && session()->get('user.userType') == 'patient') {
                    return Redirect::to('/');
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

            }

            
            
            $sessionCeck = $this->Corefunctions->validateUser();
            if(!$sessionCeck){
                return Redirect::to('/logout');
            }
            if (session()->has('user') == false) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login');
            }
            
            return $next($request);
        });
    }

    public function list($status = '')
    {
        $status = request()->query('status', '');
        $userType = request()->query('user_type', '');

        /** get the parent id if login type nurse or doctor */
        $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::userByUUID(session()->get('user.clinicuser_uuid')));    
        $parentID = (!empty($clinicUserDetails)) && $clinicUserDetails['id'] ? $clinicUserDetails['id'] : '';
        
        $clinicId = session()->get('user.clinicID'); // get logged in clinic id
        $clinic = Clinic::find($clinicId); //getting the clinic using clinic id

        if (empty($clinic)) {
            return back()->with('error', "Invalid clinic details or not found!");
        }
        $data = Appointment::getAppointments($clinicId,$status);
        $appointments = $data['appointments'];
        $perPage = $data['perPage'];
        
        $seo['title'] = "Appointments | " . env('APP_NAME');
        $seo['keywords'] = "Online Appointments, In-person Appointments, Book Patient Appointments, Doctor Consultation Booking, Schedule Appointment Online, Healthcare Appointment Management, Appointment Booking System, Real-Time Appointment Updates, Flexible Appointment Scheduling, Create Appointment Easily, Book Doctor Appointments Easily, Track Appointments Effortlessly";
        $seo['description'] = "Streamline your healthcare management with our easy-to-use appointment booking system. Whether you’re scheduling online or in-person appointments, track all patient consultations, doctor availability, appointment dates and times, and status updates";                  
        $seo['og_title'] = "Appointments | " . env('APP_NAME');
        $seo['og_description'] = "Streamline your healthcare management with our easy-to-use appointment booking system. Whether you’re scheduling online or in-person appointments, track all patient consultations, doctor availability, appointment dates and times, and status updates"; 

        return view('appointment.listing', compact('appointments', 'status', 'perPage','seo'));
    }

    // List Function
    public function appointmentList()
    {
        $status = request("status");
        $page = request("page");
        $type = request("type");
        $userTimeZone = session()->get('user.timezone');
        $clinicId = session()->get('user.clinicID'); // Get logged in clinic ID
        $userType = session()->get('user.userType'); // Get logged in clinic ID
        $clinic = Clinic::find($clinicId); // Getting the clinic using clinic ID
        $clinicuser_uuid = Session::get('user.clinicuser_uuid');
        $userID = Session::get('user.userID');

        if (empty($clinic)) {
            return back()->with('error', "Invalid clinic details or not found!");
        }

        
        $patientCancelledCount = Appointment::getPatientCancelledCount($clinicId);

        $data = Appointment::getAppointmentList($clinicId,$clinicuser_uuid,$userTimeZone,$userID,$status,$userType,$type);
        $appointments = $data['appointments'];
        $perPage = $data['perPage'];
        $fullpermission = $data['fullpermission'];
        $openCount = $data['openCount'];
        $receptionCount = $data['receptionCount'];
        $cancelledCount = $data['cancelledCount'];
        $completedCount = $data['completedCount'];
        $notesLockedCount = $data['notesLockedCount'];
        $noshowCount = $data['noshowCount'];
    
        $html = view('appointment.appointments', compact('userTimeZone','appointments', 'perPage', 'status','fullpermission','openCount','receptionCount','cancelledCount','completedCount','noshowCount','notesLockedCount','patientCancelledCount'))->render();
    
        return response()->json([
            'html' => $html,
            'success' => 1,
        ]);
    }

    //Create Function
    public function create()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $clinicId = session()->get('user.clinicID'); // get logged in clinic id
            $userId = session()->get('user.userID'); 
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');

            $appointmentTypes =  Appointment::getAppointmentTypes();

            $clinicUserDetails = ClinicUser::getClinicUserDetails($userId, $clinicId);
            $clinicAdmin = ((!empty($clinicUserDetails) && $clinicUserDetails['is_clinic_admin'] == '1') || $user_type =='clinics')  ? 1 : 0;

            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));
            $stripe_connected = (!empty($clinicUserDetails) && $clinicAdmin == 1) && ($clinicDetails['stripe_connection_id'] != null || $clinicDetails['stripe_connection_id'] != 0) ? 1 : 0;
            if($stripe_connected == '0'){
                $arr['status'] = 0;
                $arr['errormsg'] = 'Please connect to Stripe to proceed with scheduling your appointment.';
                $arr['redirectURL'] = 'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&state=' . $clinicUserDetails['clinic_user_uuid'] . '&redirect_uri=' . url("/connect/stripe");
                return response()->json($arr);
            }

            $doctors = $this->Corefunctions->convertToArray(ClinicUser::getDoctors($clinicId));
            $patients = Patient::getPatientByUserIDs($clinicId);
            if(session()->get('user.userType') == 'doctor' && session()->get('user.isClinicAdmin') != '1'){
                $doctors = ClinicUser::getDoctorsByUserUuid($clinicuser_uuid, $clinicId);
            }else if(session()->get('user.userType') == 'patient' ){
                $patients = Patient::getPatientsByUserUuid($clinicuser_uuid, $clinicId);
            }
            $nurses = ClinicUser::getNursesByUserIDs($clinicId);

            $selecteddate = (isset($data['selecteddate']) && $data['selecteddate'] != '' && $data['selecteddate'] != '01/01/1970') ? $data['selecteddate'] : '';
    
            $html = view('appointment.create', compact('appointmentTypes', 'doctors', 'patients', 'nurses','selecteddate','clinicDetails'))->render();
            return response()->json([
                'view' => $html,
                'status' => 1,
            ]);
        }
    }


    //Search Function
    public function search($type)
    {
        if (request()->ajax()) {
            $search = request('search');
            $clinicId = session()->get('user.clinicID');
            if ($type == "patient") {
                $patients = Patient::getPatients($clinicId, $search);
                $html = '';
                if ($patients->isEmpty()) {
                    $html .= '<li class="dropdown-item "><div class="dropview_body profileList justify-content-center"><p>No Data Found</p></div></li>';
                } else {
                    foreach ($patients as $patient) {
                        $html .= '<li id="' . $patient['clinic_user_uuid'] . '" class="dropdown-item select_patient_list" style="cursor:pointer">';
                        $html .= '<div class="dropview_body profileList">';
                        $html .= '<p class="select_patient_item" data-id="' . $patient['user_id'] . '">' . $patient['name'] . '</p>';
                        $html .= '</div></li>';
                    }
                }
            }

            if ($type == "doctor") {
                $clinicuser_uuid = Session::get('user.clinicuser_uuid');
                $doctors = $this->Corefunctions->convertToArray(ClinicUser::getDoctors($clinicId, $search));
                if(session()->get('user.userType') == 'doctor' && session()->get('user.isClinicAdmin') != '1'){
                    $doctors = ClinicUser::getDoctorsByUserUuid($clinicuser_uuid, $clinicId, $search);
                }
                $html = '';
                if (empty($doctors)) {
                    $html .= '<li class="dropdown-item "><div class="dropview_body profileList justify-content-center"><p>No Data Found</p></div></li>';
                } else {
                    foreach ($doctors as $doctor) {
                        $html .= '<li id="' . $doctor['clinic_user_uuid'] . '" class="dropdown-item select_doctor_list" style="cursor:pointer">';
                        $html .= '<div class="dropview_body profileList">';
                        $html .= '<p class="select_doctor_item" data-id="' . $doctor['id'] . '">' .$this->Corefunctions -> showClinicanNameUser($doctor,'1'). '</p>';
                        $html .= '</div></li>';
                    }
                }
            }

            if ($type == "nurse") {
                $nurses = ClinicUser::getNurses($clinicId, $search);
                $html = '';
                if ($nurses->isEmpty()) {
                    $html .= '<li class="dropdown-item "><div class="dropview_body profileList justify-content-center"><p>No Data Found</p></div></li>';
                } else {
                    foreach ($nurses as $nurse) {
                        $html .= '<li id="' . $nurse['clinic_user_uuid'] . '" class="dropdown-item select_nurse_list" style="cursor:pointer">';
                        $html .= '<div class="dropview_body profileList">';
                        $html .= '<p class="select_nurse_item" data-id="' . $nurse['id'] . '">' . $nurse['name'] . '</p>';
                        $html .= '</div></li>';
                    }
                }
            }

            return response()->json([
                'view' => $html,
                'status' => 1,
            ]);
        }
    }

    // Store Function
    public function store()
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
            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            //Validation Check
            // $validatedData = $request->validated();

            $userTimeZone = session()->get('user.timezone');
            $dateTimeString = $input['appointment_date'] . ' ' . $input['appointment_time'];
            $dateTime = \DateTime::createFromFormat('m/d/Y h:i A',$dateTimeString,new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedDate = $dateTime->format('Y-m-d');
            $formattedTime = $dateTime->format('H:i:s');

            $userId = session()->get('user.userID'); // get logged in user id
            $clinicId = session()->get('user.clinicID'); // get logged in clinic id

            $appointmentDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeString, $userTimeZone);

            // Get the current datetime in the user's timezone
            $currentDateTime = Carbon::now($userTimeZone);

            // Check if the appointment date and time is in the past
            if ($appointmentDateTime->lt($currentDateTime)) {
                $arr['success'] = 0;
                $arr['message'] = 'The selected appointment time is in the past.';
                return response()->json($arr);
            }
           
            /* check patient validity */
            $patientData = Patient::getPatientDets($input['patient'],$clinicId);
            if(empty($patientData) ){
                $arr['success'] = 0;
                $arr['message'] = 'The selected patient is not part of your clinic.';
                return response()->json($arr);
            }

            $nurseDetails = ClinicUser::getClinicUser($input['nurse'],$clinicId);
            $doctorDetails = ClinicUser::getClinicUser($input['doctor'],$clinicId);
            if(empty($nurseDetails) || empty($doctorDetails)){
                $arr['success'] = 0;
                $arr['message'] = 'The selected clinician or nurse is not part of your clinic.';
                return response()->json($arr);
            }
            /* get consultant time */
            if(isset($doctorDetails->consultation_time_id) && $doctorDetails->consultation_time_id != '7'){
                $consultingTimes =  $this->Corefunctions->convertToArray(RefConsultationTime::getConsultationTimeById($doctorDetails->consultation_time_id));
                $durationText = $consultingTimes['consultation_time']; // e.g. "15 mins"
                
                // Extract the number of minutes from the string
                preg_match('/\d+/', $durationText, $matches);
                $durationMinutes = isset($matches[0]) ? (int)$matches[0] : 0;
            }else{
                $durationMinutes = (int)$doctorDetails->consultation_time;
            }
            // Parse the input appointment time (e.g., "03:15 PM")
            // Combine appointment date and time from user input
            $dateTimeString = $input['appointment_date'] . ' ' . $input['appointment_time'];

            // Create DateTime object in user's timezone
            $startDateTime = \DateTime::createFromFormat('m/d/Y h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

            // Clone it for end time calculation
            $endDateTime = clone $startDateTime;
         
            $endDateTime->modify("+$durationMinutes minutes");
            $endDateTime->setTimezone(new \DateTimeZone('UTC'));
            // Store end time in desired format, e.g., "04:00 PM"
            $input['appointment_end_time'] = $endDateTime->format('H:i:s');

            /** check the patient have same appointment with other doctors */
            $appointmentExists = Appointment::isAppointmentExists($clinicId,$formattedDate,$formattedTime,$input['patient'] ?? null,$input['nurse'] ?? null,$input['doctor'] ?? null);
            if ($appointmentExists) {
                return response()->json([
                    'success' => 0,
                    'message' => 'An appointment is already scheduled for that time',
                ]);
            }
            
            $expiredDate = new \DateTime($formattedDate. ' ' . $formattedTime);
            // Add 1 hour to the current DateTime object
            $expiredDate->modify('+1 hour');

            
            $appointmentUuid = $this->Corefunctions->generateUniqueKey("10", "appointments", "appointment_uuid"); //generate uuid
            $appointment = Appointment::createAppointment($input,$clinicId,$formattedDate,$formattedTime,$expiredDate,$appointmentUuid,$userId);
            
            $appID = $appointment->id;
            $appUid = $appointment->appointment_uuid;
            
            /** Notification for doctor */
            $clinicUserDoctor = Appointment::getClinicUserDoctor(session()->get('user.clinicID'), $input['doctor']);
         
            $this->Corefunctions->addNotifications(3,session()->get('user.clinicID'),$clinicUserDoctor['user_id'],$appID);
            
            if($input['appointment_type_id'] == 1){
                $data['appointment_type'] ="Online Appointment";
            }else{
                $data['appointment_type'] ="In-person Appointment";
            }

            $patientDetails = Patient::getPatientDets($input['patient'],session()->get('user.clinicID'));

            /** Invitation mail */
            $clinic = Clinic::clinicByID(session()->get('user.clinicID'));
            $data['name'] = $this->Corefunctions -> showClinicanName($clinicUserDoctor,'1');
            $data['clinic'] = $clinic->name;
            $data['email'] = $clinicUserDoctor['email'];
            $data['date'] =  date('M d Y', strtotime($formattedDate)) ;
            $data['time'] = date('h:i A', strtotime($formattedTime)) ;
            $data['link'] = url('meet/'.$appUid);
            $data['userType'] = "clinicUser";
            $data['patient'] = $patientDetails->first_name.' '.$patientDetails->last_name;
            $response = $this->Corefunctions->sendmail($data, 'New Online Appointment Scheduled - '.$patientDetails['first_name'].' '.$patientDetails['last_name'], 'emails.appointmentdoctor');

            /** notification & mail for nurse */
            $clinicUserNurse = Appointment::getClinicUserDoctor(session()->get('user.clinicID'), $input['nurse']);
            $this->Corefunctions->addNotifications(6,session()->get('user.clinicID'),$clinicUserNurse['user_id'],$appID);
            $data['name'] = $clinicUserNurse['name'];
            $data['clinic'] = $clinic->name;
            $data['email'] = $clinicUserNurse['email'];
            $data['date'] =  date('M d Y', strtotime($formattedDate)) ;
            $data['time'] = date('h:i A', strtotime($formattedTime)) ;
            $data['link'] = url('meet/'.$appUid);
            $data['userType'] = "clinicUser";
            $data['patient'] = $patientDetails->first_name.' '.$patientDetails->last_name;
            $response = $this->Corefunctions->sendmail($data, 'New Online Appointment Scheduled - '.$patientDetails['first_name'].' '.$patientDetails['last_name'], 'emails.appointmentdoctor');

            /** notification for patients */
            $this->Corefunctions->addNotifications(7,session()->get('user.clinicID'),$patientDetails['user_id'],$appID);

            /** mail to patient */
            $data['name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
            $data['clinic'] = $clinic->name;
            $data['email'] = $patientDetails['email'];
            $data['date'] =  date('M d Y', strtotime($formattedDate)) ;
            $data['time'] = date('h:i A', strtotime($formattedTime)) ;
            $data['link'] = url('meet/'.$appUid);
            $data['userType'] = "patient";
            $data['doctor'] = $this->Corefunctions -> showClinicanName($clinicUserDoctor,'1');
            $response = $this->Corefunctions->sendmail($data, 'Appointment Scheduled with '.$data['clinic'], 'emails.appointment');
            $roomkey = $this->Corefunctions->generateUniqueKey('10', 'video_calls', 'room_key');
           
            $videocall = new VideoCall();
            $videocall->room_key = $roomkey;
            $videocall->appointment_id = $appID;
            $videocall->created_by = $userId;
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

    //Edit Function
    public function edit($uuid)
    {
        if (request()->ajax()) {
            if (!$uuid) {
                return view('appointment.listing')->with('error', "Failed to find data or Invalid key passed!");
            }
            $type = request('type');
            $status = request('status');
            $userType = request()->query('user_type', '');
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');

            $datas = request()->all();
            $clinicId = session()->get('user.clinicID'); // get logged in clinic id
            $appointment = Appointment::appointmentByKey($uuid);
           
            if (empty($appointment)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Invalid record'
                ]);
            }

            if($appointment->clinic_id != session()->get('user.clinicID')){
                return response()->json([
                    'error' => 1,
                    'errormsg' => "You don't have permission to access this"
                ]);
            }
            
            if(session()->get('user.userType') != 'clinics' && session()->get('user.isClinicAdmin') != '1' ){
                $doctor = ClinicUser::getClinicUserByUuid($clinicuser_uuid);
                if($appointment['consultant_id'] != $doctor->user_id ){
                    return response()->json([
                        'error' => 1,
                        'errormsg' => 'Invalid record'
                    ]);
                }
            }

            // Retrieve appointment types
            $appointmentTypes =  Appointment::getAppointmentTypes();

            $doctors = $this->Corefunctions->convertToArray(ClinicUser::getDoctors($clinicId));
            if(session()->get('user.userType') == 'doctor' && session()->get('user.isClinicAdmin') != '1'){
                $doctors = ClinicUser::getDoctorsByUserUuid($clinicuser_uuid, $clinicId);
            }
            $nurses = ClinicUser::getNursesByUserIDs($clinicId);
            $patients = Patient::getPatientByUserIDs($clinicId);

            /* selected slot  */
            $date = date('Y-m-d',strtotime($appointment->appointment_date));
            $timeslots = $this->Corefunctions->getAvailableTimeSlots($date,$appointment->consultant_id,'edit',$appointment->appointment_time);
          
            $userTimeZone = session('user.timezone');
            $editDateTimeUTC = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->appointment_date . ' ' . $appointment->appointment_time, 'UTC');
            $editDateTimeUser = $editDateTimeUTC->copy()->setTimezone($userTimeZone);
            $input['appointment_time'] = $editDateTimeUser->format('h:i A');
         

            $html = view('appointment.edit', compact('appointmentTypes', 'appointment', 'doctors', 'patients', 'nurses', 'type', 'status', 'userType','timeslots','input'))->render();

            return response()->json([
                'view' => $html,
                'status' => 1,
            ]);
        }
    }

    public function view($uuid)
    {
        if (!$uuid) {
            return view('appointment.listing')->with('error', "Failed to find data or Invalid key passed!");
        }

        $userTimeZone = session()->get('user.timezone');
        $clinicId = session()->get('user.clinicID');

        $appointment = Appointment::getAppointmentByUuid($uuid);
        $appointment = $this->Corefunctions->convertToArray($appointment);
        if (!$appointment) {
            return redirect()->route('appointment.list')->with('error', 'Failed to fetch appointment data!');
        }
        if($appointment['clinic_id'] != session()->get('user.clinicID')){
            return redirect()->route('appointment.list')->with('error', 'Permission denied!');
        }

        // Fetch doctor details
        $doctor = ClinicUser::getUserByUserId($appointment['consultant_id'], $clinicId);
        if ($doctor) {
            $doctor->logo_path = $doctor->user->profile_image ? $this->Corefunctions->getAWSFilePath($doctor->user->profile_image) : '';
        }

        // Fetch nurse details
        $nurse = ClinicUser::getUserByUserId($appointment['nurse_id'], $clinicId);
        if ($nurse) {
            $nurse->logo_path = $nurse->user->profile_image ? $this->Corefunctions->getAWSFilePath($nurse->user->profile_image) : '';
        }

        // Fetch video call room and participants
        $room = VideoCall::getVideoCallByAppointmentId($appointment['id']);
        $participants = array();
        if (!empty($room)) {
            $participants = VideoCallParticipant::getParticipantsByCallId($room->id);
            $participantsClinic = VideoCallParticipant::getClinicParticipantsByCallId($room->id);
            $participantsClinic = $this->Corefunctions->convertToArray($participantsClinic);
            $clinicuserIDS = $this->Corefunctions->getIDSfromArray($participantsClinic, 'participant_id');
        }

        // Fetch patient details
        $patient = Patient::getPatientByClinicId($appointment['patient_id'], $clinicId);
        if ($patient) {
            $patient->logo_path = isset($patient->user->profile_image) && $patient->user->profile_image != '' ? $this->Corefunctions->resizeImageAWS($patient->user->id, $patient->user->profile_image, $patient->user->first_name, 180, 180, '1') : ($patient->logo_path ? $this->Corefunctions->getAWSFilePath($patient->logo_path) : '');
            $patient->age = $this->Corefunctions->calculateAge($patient->dob);
            $patientphone = $this->Corefunctions->formatPhone($patient->phone_number);
        }

        // Fetch clinic user details
        $clinicUserDetails = array();
        if(!empty($clinicuserIDS)){
            $clinicUserDetails = ClinicUser::getClinicUsersByIds($clinicuserIDS);
            $clinicUserDetails = $this->Corefunctions->convertToArray($clinicUserDetails);
            $clinicUserDetails = $this->Corefunctions->getArrayIndexed1($clinicUserDetails, 'id');
        }

        // Fetch country code
        $countryCode = $patient && $patient->country_code ? RefCountryCode::getCountryCodeById($patient->country_code) : null;

        $appointmentTypes = AppointmentType::all()->keyBy('id')->toArray();
       
        $clinicuser_uuid = Session::get('user.clinicuser_uuid');
        $clinicUserDets = ClinicUser::getClinicUserByUserId($appointment['created_by']);
        $bookedBy = ($clinicUserDets->id == $appointment['created_by']) ? 'Self' : (($clinicUserDets->user_type_id != '3') ? $this->Corefunctions->showClinicanName($clinicUserDets) : $clinicUserDets->user->first_name);

        $previousAppointments = Appointment::getPreviousAppointments($appointment['patient_id'], $appointment['id'], $appointment['created_at']);
        
        $appointmentNotes = Appointment::getAppointmentNotes($appointment['id']);

        $seo['title'] = 'Appointment Details | BlackBag';

        return view('appointment.view', compact('userTimeZone', 'appointment', 'patient', 'doctor', 'clinicUserDetails', 'nurse','countryCode', 'appointmentTypes', 'room', 'bookedBy', 'previousAppointments','appointmentNotes', 'participants', 'seo', 'patientphone'));
    }

    public function viewNew($uuid)
    {
        if (!$uuid) {
            return view('appointment.listing')->with('error', "Failed to find data or Invalid key passed!");
        }

        $userTimeZone = session()->get('user.timezone');
        $clinicId = session()->get('user.clinicID');

        $appointment = Appointment::getAppointmentByUuid($uuid);
        $appointment = $this->Corefunctions->convertToArray($appointment);
        if (!$appointment) {
            return redirect()->route('appointment.list')->with('error', 'Failed to fetch appointment data!');
        }
        if($appointment['clinic_id'] != session()->get('user.clinicID')){
            return redirect()->route('appointment.list');
        }

        // Fetch doctor details
        $doctor = ClinicUser::getUserByUserId($appointment['consultant_id'], $clinicId);
        if ($doctor) {
            $doctor->logo_path = $doctor->user->profile_image ? $this->Corefunctions->getAWSFilePath($doctor->user->profile_image) : '';
        }

        // Fetch nurse details
        $nurse = ClinicUser::getUserByUserId($appointment['nurse_id'], $clinicId);
        if ($nurse) {
            $nurse->logo_path = $nurse->user->profile_image ? $this->Corefunctions->getAWSFilePath($nurse->user->profile_image) : '';
        }

        $patientphone = '';
        // Fetch video call room and participants
        $room = VideoCall::getVideoCallByAppointmentId($appointment['id']);
        $participants = $videoParticipantPatients = $videoParticipantOthers = array();
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

        $clinicuser_uuid = Session::get('user.clinicuser_uuid');
        $userDets = User::userByID($appointment['created_by']);
        $clinicUserDets = ClinicUser::getClinicUserByUserId($appointment['consultant_id']);

        $bookedBy = (Session::get('user.userID') == $appointment['created_by']) ? 'Self' : $userDets->first_name;
        $clinicianName = $this->Corefunctions->showClinicanName($clinicUserDets);

        $previousAppointments = Appointment::getPreviousAppointments($appointment['patient_id'], $appointment['id'], $appointment['created_at']);
        if(!empty($previousAppointments)){
            foreach($previousAppointments as $pak => $pav){
                $previousAppointments[$pak]['videocall'] = VideoCall::getVideoCallByAppointmentId($pav['id']);
            }
        }
        $appointmentNotes = Appointment::getAppointmentNotes($appointment['id']);
        $showPrescription = $this->Corefunctions->showPrescription(Session::get('user.clinicuser_uuid'));

        $seo['title'] = 'Appointment Details | BlackBag';
        $type = 'appointment';

        return view('appointment.viewnew', compact('userTimeZone', 'appointment', 'patient', 'doctor', 'clinicUserDetails', 'nurse','countryCode', 'appointmentTypes', 'room', 'bookedBy', 'previousAppointments','appointmentNotes', 'participants', 'seo', 'patientphone','patientDetails','type','clinicianName','showPrescription'));
    }

    public function editappointment()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!isset($data['key'])) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }

            $clinicId = session()->get('user.clinicID'); // get logged in clinic id
            $appointment = Appointment::appointmentByKey($data['key']);
            
            if (empty($appointment) ) {
                $arr['message']    = 'Failed to fetch appointment data!';
                $arr['success'] = 0;
                return response()->json($arr);
                exit();
            }
            if($appointment->clinic_id != session()->get('user.clinicID')){
                $arr['message']    = "You don't have permission to access this.";
                $arr['success'] = 0;
                return response()->json($arr);
                exit();
            }
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
            if(session()->get('user.userType') != 'clinics' && session()->get('user.isClinicAdmin') != '1'){
                $doctor = ClinicUser::userByUUID($clinicuser_uuid);
                if($appointment->consultant_id != $doctor->id && $appointment->nurse_id != $doctor->id ){
                    $arr['message']    = 'Failed to fetch appointment data!';
                    $arr['success'] = 0;
                    return response()->json($arr);
                    exit();
                }
            }

            // Retrieve appointment types
            $appointmentTypes = Appointment::getAppointmentTypes();

            $doctors = $this->Corefunctions->convertToArray(ClinicUser::getDoctors($clinicId));
            $patients = Patient::getPatientByUserIDs($clinicId);
            if(session()->get('user.userType') == 'doctor' && session()->get('user.isClinicAdmin') != '1'){
                $doctors = ClinicUser::getDoctorsByUserUuid($clinicuser_uuid, $clinicId);
            }else if(session()->get('user.userType') == 'patient' ){
                $patients = Patient::getPatientsByUserUuid($clinicuser_uuid, $clinicId);
            }
            $nurses = ClinicUser::getNursesByUserIDs($clinicId);

            $data['doctors'] = $doctors;
            $data['nurses'] = $nurses;
            $data['patients'] =  $patients;
            $data['appointmentTypes'] =  $appointmentTypes;
            $data['appointment'] =  $appointment;
            $data['status'] = $data['status'];
            $data['type'] =  $data['type'];
            $data['userType'] = $data['userType'];

            $html           = view('appointment.edit', $data);
            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    // Update Function
    public function update(StoreAppointmentRequest $request)
    {
        $uuid = request('appointment_uuid');
        $type = request('type');
        $status = request('status');
        $nurseUuid = request('nurse_uuid');
        $userType = request('user_type');

        //Validation Check
        $validatedData = $request->validated();

        $appointment = Appointment::appointmentByKey($uuid);
        $appointmentId = $appointment->id;

        $userTimeZone = session()->get('user.timezone');
        $dateTimeString = $validatedData['appointment_date'] . ' ' . $validatedData['appointment_time'];
        $dateTime = \DateTime::createFromFormat('m/d/Y h:i A',$dateTimeString,new \DateTimeZone($userTimeZone));

        $dateTime->setTimezone(new \DateTimeZone('UTC'));
        $formattedDate = $dateTime->format('Y-m-d');
        $formattedTime = $dateTime->format('H:i:s');

        $clinicId = session()->get('user.clinicID');
        if (empty($appointment)) {
            return redirect()->route('appointment.list')->with('error', 'Invalid or appointment not found!');
        }

        // Combine the date and time into a single DateTime object for comparison
        $appointmentDateTime = strtotime($validatedData['appointment_time']);

        // Get the current date and time
        $currentDateTime = $this->Corefunctions->currentTime(); // Laravel's now() function gives you a Carbon instance
        
        // Check if the appointment date is today
        $isToday = $formattedDate === date('Y-m-d',$currentDateTime);
        
        // Check if the selected time is in the past
        if ($isToday && $appointmentDateTime < $currentDateTime) {
            return redirect()->route('appointment.list', ['type' => $type, 'status' => $status])->with(
                [
                    'type' => $type,
                    'status' => $status,
                    'error' => "The selected appointment time is in the past!"
                ]
            );
        }

        $conflicts = Appointment::checkConflictingAppointments($clinicId, $formattedDate, $formattedTime, $appointmentId);

        // Filter out the ones that exist
        $appointmentsWithConflicts = array_keys(array_filter($conflicts));

        if (!empty($appointmentsWithConflicts)) {
            $joinedNames = implode(', ', array_slice($appointmentsWithConflicts, 0, -1))
                . (count($appointmentsWithConflicts) > 1 ? ' or ' : '')
                . end($appointmentsWithConflicts);

            $errorMessage = "The selected time slot is already booked for the $joinedNames.";

            if ($userType == 'nurse') {
                return redirect()->route('nurse.view', [$nurseUuid, 'type' => $type, 'status' => $status])
                    ->with('error', $errorMessage);
            }

            return redirect()->route('appointment.list', ['type' => $type, 'status' => $status])
                ->with('error', $errorMessage);
        }
        
        $expiredDate = new \DateTime($formattedDate. ' ' . $formattedTime);

        // Add 1 hour to the current DateTime object
        $expiredDate->modify('+1 hour');

        $doctorDetails = ClinicUser::getClinicUser($validatedData['doctor'],$clinicId);
        /* get consultant time */
        if(isset($doctorDetails->consultation_time_id) && $doctorDetails->consultation_time_id != '7'){
            $consultingTimes =  $this->Corefunctions->convertToArray(RefConsultationTime::getConsultationTimeById($doctorDetails->consultation_time_id));
            $durationText = $consultingTimes['consultation_time']; // e.g. "15 mins"
            
            // Extract the number of minutes from the string
            preg_match('/\d+/', $durationText, $matches);
            $durationMinutes = isset($matches[0]) ? (int)$matches[0] : 0;
        }else{
            $durationMinutes = (int)$doctorDetails->consultation_time;
        }
        // Parse the input appointment time (e.g., "03:15 PM")
        // Combine appointment date and time from user input
        $dateTimeString = $validatedData['appointment_date'] . ' ' . $validatedData['appointment_time'];

        // Create DateTime object in user's timezone
        $startDateTime = \DateTime::createFromFormat('m/d/Y h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

        // Clone it for end time calculation
        $endDateTime = clone $startDateTime;
     
        $endDateTime->modify("+$durationMinutes minutes");
        $endDateTime->setTimezone(new \DateTimeZone('UTC'));
        // Store end time in desired format, e.g., "04:00 PM"
        $validatedData['appointment_end_time'] = $endDateTime->format('H:i:s');


        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->updateAppointment($validatedData, $formattedDate, $formattedTime, $expiredDate,$validatedData);

        // if (!empty($status && $type)) {
        if ($userType == 'doctors') {
            $doctors = ClinicUser::getClinicUser($validatedData['doctor'],$clinicId);
            $doctorsKey = $doctors->clinic_user_uuid;
            return Redirect::to('user/' . $doctorsKey . '/details?type=' . $type . '&status=' . $status)->with('success', "Appointment updated successfully!");
        } elseif($userType == 'nurse') {
            return redirect()->route('nurse.view', [$nurseUuid, 'type' => $type, 'status' => $status])->with(
                [
                    'type' => $type,
                    'status' => $status,
                    'success' => "Appointment updated successfully!"
                ]
            );
        }elseif($userType == 'dashboard') {
            return Redirect::to('dashboard/')->with('success', "Appointment updated successfully!");

        }elseif($userType == 'patient') {
            $patientDetails = $this->Corefunctions->convertToArray(Patient::getPatientDets($validatedData['patient'], session()->get('user.clinicID')));
            return Redirect::to('patient/' . $patientDetails['patients_uuid'] . '/details?type=' . $type . '&status=' . $status)->with('success', "Appointment updated successfully!");
        }

        return redirect()->route('appointment.list')->with(
            [
                'type' => $type,
                'status' => $status,
                'success' => "Appointment updated successfully!"
            ]

        );
    }

    // Delete Function
    protected function delete($uuid)
    {
        $type = request('type');
        $status = request('status');
        $userType = request()->query('user_type', '');
        $nurseUuid = request()->query('key', '');

        if (empty($uuid)) {
            return response()->json([
                'type' => $type,
                'status' => $status,
                'user_type' => $userType,
                'redirect' => (Session::get('user.userType') == 'patient') ? url('myappointments') : route('appointment.list'),
                'message' => "appointment not found or invalid uuid!",
            ]);
        }
        $appointment = Appointment::appointmentByKey($uuid);
        if(empty( $appointment)){
            return $this->Corefunctions->returnError('Invalid Data.');
        }
        try {
            $appointment = Appointment::appointmentByKey($uuid);
            if($appointment->clinic_id != session()->get('user.clinicID')){
                $arr['success'] = 0;
                $arr['message'] = "You don't have permission to delete this appointment.";
                return response()->json($arr);
                exit();
            }
            Appointment::deleteAppointment($uuid);
         
            $message = 'appointment deleted successfully!';
            $success = 'success';

            $appID =  $appointment->id ;
            $clinicUserDoctor = ClinicUser::getUserByUserId($appointment->consultant_id,session()->get('user.clinicID'));
            $this->Corefunctions->addNotifications(4,session()->get('user.clinicID'),$clinicUserDoctor['user_id'],$appID);
            
            /** notification for nurse */
            if(!empty($clinicUserNurse)){
                $clinicUserNurse = ClinicUser::getUserByUserId($appointment->nurse_id,session()->get('user.clinicID'));
                $this->Corefunctions->addNotifications(4,session()->get('user.clinicID'),$clinicUserNurse['user_id'],$appID);
            }

            /** notification for patients */
            $patientDetails= Patient::getPatientByClinicId($appointment->patient_id,session()->get('user.clinicID'));
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
            $success = 'error';
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $message = 'An error occurred while deleting the appointment';
            $success = 'error';
        }

        // return redirect()->route('appointment.list', ['status' => 'active'])->with($status, $message);

        if (!empty($userType)) {

            return response()->json([
                'type' => $type,
                'status' => $status,
                'redirect' => route('nurse.view', [$nurseUuid, 'type' => $type, 'status' => $status]),
                'message' => $message,
            ]);
        }

        return response()->json([
            'type' => $type,
            'status' => $status,
            'redirect' => (Session::get('user.userType') == 'patient') ? url('myappointments') : route('appointment.list', ['type' => $type, 'status' => $status]),
            'message' => $message,
        ]);
    }

    protected function activate($uuid)
    {
        $type = request('type');
        $status = request('status');
        $userType = request()->query('user_type', '');
        $nurseUuid = request()->query('key', '');

        if (empty($uuid)) {
            return redirect()->route('appointment.list')->with('error', 'appointment not found or invalid uuid!');
        }
        $appointment = Appointment::appointmentByKey($uuid);

        if (empty($appointment)) {
            return response()->json([
                'message' => 'Appointment not found.',
                'success' => 'error',
                'redirect' => route('appointment.list')
            ]);
        }

        if($appointment->clinic_id != session()->get('user.clinicID')){
            return response()->json([
                'message' => "You don't have permission to access this.",
                'success' => 'error',
                'redirect' => route('appointment.list')
            ]);
            return redirect('/appointments');
        }

        $doctorDetails = ClinicUser::getUserByUserId($appointment->consultant_id,session()->get('user.clinicID'));

        if (empty($doctorDetails)) {
            return response()->json([
                'message' => 'The clinician is deactivated. You cannot activate this appointment until the clinician is reactivated.',
                'success' => 'error',
                'redirect' => route('appointment.list'),
            ]);
        }
        try {
            Appointment::activateAppointment($uuid);
            // $appointment->restore();
            $message = 'The appointment has been activated successfully';
            $success = 'success';
        } catch (ModelNotFoundException $e) {
            $message = 'Unable to activate appointment';
            $success = 'error';
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $message = 'An error occurred while activating the appointment';
            $success = 'error';
        }

        if (!empty($userType)) {
            return response()->json([
                'type' => $type,
                'status' => $status,
                'redirect' => route('nurse.view', [$nurseUuid, 'type' => $type, 'status' => $status]),
                'message' => $message,
            ]);
        }

        return response()->json([
            'type' => $type,
            'status' => $status,
            'redirect' => route('appointment.list'),
        ]);
    }

    public function getNotes()
    {
        $uuid = request('uuid');
        $appointment = Appointment::appointmentByKey($uuid);
        $note = $appointment->notes;
        return response()->json([
            'note' => $note,
            'status' => 1,
        ]);
    }

    public function getPaymentResponse()
    {
        $uuid = request('uuid');
        $appointment = Appointment::appointmentByKey($uuid);
        $payment_response = $appointment->payment_response;
        return response()->json([
            'payment_response' => $payment_response,
            'status' => 1,
        ]);
    }

    protected function joinVideo()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $appoinmentuuid = $data['appoinment_uuid'];
            $usertype = Session::get('user.userType');
            $data['stripeAcc'] ='';
            $appointment = Appointment::appointmentByKey($appoinmentuuid);
            if (empty($appointment)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Appointment invalid'
                ]);
            }
            if (!empty($appointment) && $appointment->is_paid == '1') {
                return response()->json([
                    'status' => 0,
                    'message' => 'Payment already done'
                ]);
            }
            if (!empty($appointment) && $appointment->is_completed == '1') {
                return response()->json([
                    'status' => 0,
                    'message' => 'Appointment already completed'
                ]);
            }

            // Check for expiry (after 1 day from appointment date)
            $appointmentDate = Carbon::parse($appointment->appointment_date)->startOfDay();
            $expiryDate = $appointmentDate->copy()->addDay();
            $today = Carbon::now()->startOfDay();
            if ($today->greaterThanOrEqualTo($expiryDate)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Your appointment has expired.Please contact the Clinic for further assistance.'
                ]);
            }

            $clientSecret = '';
            
            if($usertype == 'patient'){
                if($appointment->is_paid == '0' && $appointment->payment_required == '1'){
                    $patientDetails = Patient::patientByUser($appointment->patient_id,session()->get('user.clinicID'));
                    if (empty($patientDetails)) {
                        return response()->json([
                            'status' => 0,
                            'message' => 'Patient invalid'
                        ]);
                    }
                }
                $clinic = Clinic::ClinicByID($appointment->clinic_id);
                    if (empty($clinic)) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'clinic invalid'
                    ]);
                }
                $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->first();
                if(empty($stripeConnection)){
                    return response()->json([
                        'status' => 0,
                        'message' => 'Stripe not connected'
                    ]);
                }
                $userCards = PatientCard::getUserCards($appointment->patient_id);
                if (!empty($userCards) ) {
                    foreach ($userCards as $key => $cards) {
                        $userCards[$key]['expiry'] = $cards['exp_month'].'/'.$cards['exp_year'];
                    }
                }
                
                $data['stripeAcc'] = $stripeConnection->stripe_user_id;
            }else{
                return;
            }
            //echo $clientSecret;exit;
            
            $data['amount'] = $appointment->appointment_fee;
            $data['clientSecret'] = $clientSecret;
            $data['appoinmentuuid'] = $appoinmentuuid;
            $data['userCards'] = $userCards;
            $data['type'] = 'payment';

            $html           = view('appointment.payment',$data);
            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

  
     // Delete Function
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
                if ($data['apptype'] == 'cancel') {
                    $appointment = Appointment::appointmentByKey($data['key']);
                    if($appointment->created_by != session()->get('user.userID') ){
                        $arr['success'] = 0;
                        $arr['message'] = 'Invalid data';
                        return response()->json($arr);
                        exit();
                    }
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

                } else {
                    $appointment = Appointment::appointmentByKey($data['key']);
                    $appointment->restore();
                    $message = 'appointment activated successfully!';
                    $success = 'success';
                }
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
    public function cancel(){
        if (!request()->ajax()) {
            return;
        }

        $data = request()->all();
        if (empty($data)) {
            return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
        }

        parse_str($data['formdata'], $input);

        $clinicUserUuid = session('user.clinicuser_uuid');
        $appointment = Appointment::appointmentByKey($input['appointmentuuid']);

        if (!$appointment) {
            return response()->json(['error' => 1, 'errormsg' => 'Invalid Appointment']);
        }

        if($appointment->clinic_id != session()->get('user.clinicID')){
            return response()->json(['error' => 1, 'errormsg' => "You don't have permission to access this"]);
        }

        if($appointment->deleted_at != '' && $appointment->cancelled_by_type == 'u'){
            return response()->json(['error' => 1, 'errormsg' => 'This appointment has already been cancelled.']);
        }

        $clinicId = $appointment->clinic_id;
        $clinic = Clinic::select([
            'id', 'stripe_connection_id', 'name', 'phone_number',
            'address as billing_address', 'state as billing_state',
            'city as billing_city', 'zip_code as billing_zip',
            'country_id as billing_country_id', 'state_id',
            'country_code', 'logo','in_person_cancellation_fee', 'virtual_cancellation_fee'
        ])
        ->where('id', $clinicId)
        ->whereNull('deleted_at')
        ->first();

        if (!$clinic) {
            return response()->json(['error' => 1, 'errormsg' => 'Clinic invalid']);
        }

        if(isset($input['collect_cancellation_fee']) && $input['collect_cancellation_fee'] == '1'){
            $patient = Patient::with('user')
                ->where('user_id', $appointment->patient_id)
                ->where('clinic_id', $clinicId)
                ->whereNull('deleted_at')
                ->first();

            $patientDetails = $this->Corefunctions->convertToArray($patient);
            $patientCard = PatientCard::getDefaultUserCard($patientDetails['user_id']);
            if (!$patientCard) {
                return response()->json(['error' => 1, 'errormsg' => 'Please add a card for this patient before proceeding.']);
            }

            $clinicCard = ClinicCard::getDefaultUserCard($clinicId);
            if (!$clinicCard) {
                return response()->json(['error' => 1, 'errormsg' => 'Please add a card for this clinic before proceeding.']);
            }


            if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Stripe not connected',
                ]);

            }
            $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();

            $amount = ($appointment->appointment_type_id == '1') ? $clinic->virtual_cancellation_fee : $clinic->in_person_cancellation_fee;
            $result = $this->Corefunctions->subscriptionPayment($stripeConnection->stripe_user_id,$patientDetails,$input,$amount,$clinicId,$appointment->id,'','cancellation_fee');
            
            if (isset($result['status']) && $result['status'] == '0') {
                $arr['error'] = 1;
                $arr['errormsg'] = $result['message'];
                return response()->json($arr);
            }
            $paymentIds = $result['paymentIds'];
            $cardDetails = $result['cardDetails'];
            $msg = "Appointment cancelled successfully and an amount of $'.$amount.' debited from patient's card.";
        }else{
            $msg = "Appointment cancelled successfully.";
        }

        // Update appointment
        DB::table('appointments')->where('appointment_uuid', $input['appointmentuuid'])->update(array(
            'cancelled_by' => Session::get('user.userID'),
            'cancelled_by_type' => 'u',
            'deleted_at' => Carbon::now(),
        ));

        $appID = $appointment->id;
        
        /** notification for doctor */
        $clinicUserDoctor = ClinicUser::getUserByUserId($appointment->consultant_id,session()->get('user.clinicID'));
        $this->Corefunctions->addNotifications(4,session()->get('user.clinicID'),$clinicUserDoctor['user_id'],$appID);
        
        /** notification for nurse */
        if( !empty($clinicUserNurse) ){
            $clinicUserNurse = ClinicUser::getUserByUserId($appointment->nurse_id,session()->get('user.clinicID'));
            $this->Corefunctions->addNotifications(4,session()->get('user.clinicID'),$clinicUserNurse['user_id'],$appID);
        }

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
        $data['time'] = $appointment->appointment_time ;
        $data['location'] =  $this->Corefunctions->formatAddress($clinic);
        
        $response = $this->Corefunctions->sendmail($data, 'Appointment Cancellation', 'emails.appointmentcancel');

        return response()->json([
            'success' => 1,
            'message' => $msg,
        ]);
    }

    /** join meeting */
    public function joinMeet($key)
    {
        
        $userTimeZone = session()->get('user.timezone');
        $appoinmentuuid = $key;
        $usertype = Session::get('user.userType');
        $clinicuser_uuid = Session::get('user.clinicuser_uuid');
        $appointment = Appointment::appointmentByKey($appoinmentuuid);
        if (empty($appointment)) {
            return redirect()->route('appointment.list')->with('error', 'Appointment not found!');
        }
        $doctorDetails = ClinicUser::getUserByUserId($appointment->consultant_id,session()->get('user.clinicID'));
        $nurseDetails = ClinicUser::getUserByUserId($appointment->nurse_id,session()->get('user.clinicID'));
        $videoCallDetails = VideoCall::getVideoCallByAppointmentId($appointment->id);
       
        $patientDetails = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($appointment->patient_id,session()->get('user.clinicID')));
         
        if (empty($patientDetails)) {
            return redirect()->route('appointment.list')->with('error', 'Appointment not found!');
        }
        
        $patientDetails['logo_path'] = ($patientDetails['user']['profile_image'] != '') ? $this->Corefunctions-> resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : asset('images/default_img.png');
        $patientDetails['age']       = $this->Corefunctions->calculateAge($patientDetails['dob']);

        $doctorDetails->logo_path = $doctorDetails->profile_image ? $this->Corefunctions->getAWSFilePath($doctorDetails->profile_image) : '';
        
        
        // Appointment date and time
        $formattedTime = date('H:i:s', strtotime($appointment->appointment_time));
        $formattedDate = date('Y-m-d', strtotime($appointment->appointment_date));
        $appointmentDateTime = strtotime($appointment->appointment_time);
        
        // Get the user's time zone
        $userTimeZone = session()->get('user.timezone');
        $userTimeZone = new \DateTimeZone($userTimeZone);

        // Combine appointment date and time into a DateTime object based on user's time zone
        $appointmentDateTime = new \DateTime($appointment->appointment_date . ' ' . $appointment->appointment_time, $userTimeZone);

        // Get current time in the user's time zone
        $currentDateTime = now()->setTimezone($userTimeZone); // Laravel's `now()` helper
        $currentDate = $currentDateTime->format('Y-m-d'); // Current date in user time zone

        // Convert appointment date to the same time zone and format
        $formattedDate = $this->Corefunctions->timezoneChange($appointment->appointment_date, "Y-m-d");

        // Get the time difference of 30 minutes before and after the current appointment
        $minus10Minutes = (clone $appointmentDateTime)->modify('-30 minutes'); // 30 minutes earlier
        $plus10Minutes = (clone $appointmentDateTime)->modify('+30 minutes');  // 30 minutes later

        // Check if the appointment date is today
        $isToday = $formattedDate === $currentDate;

        // Check if the selected time is in the past or if it is overtime
        $startAppoinment = 0;
        $overtime = 0;

        if ($isToday && ($appointmentDateTime >= $minus10Minutes && $appointmentDateTime <= $plus10Minutes)) {
            $startAppoinment = 1; // Appointment is within the 30-minute window
        } elseif ($isToday && $appointmentDateTime > $plus10Minutes) {
            $overtime = 1; // Appointment is after the 30-minute window
        }

        
        $role= 0;
        $appoinmentTo = $this->Corefunctions->showClinicanName($doctorDetails,'1');
        $appoinmentToLogo = ($doctorDetails['user']['profile_image'] != '') ? $this->Corefunctions-> resizeImageAWS($doctorDetails['user']['id'],$doctorDetails['user']['profile_image'],$doctorDetails['user']['first_name'],180,180,'1') : asset('images/default_img.png');
        if($usertype != 'patient'){
            $role = ($usertype == 'doctor' || $usertype == 'clinics') ? 1 :0; 
            $loginUserDetails = ClinicUser::getClinicUserByUuid($clinicuser_uuid);
            if($usertype != 'clinics'){
                if(!in_array($loginUserDetails->user_id,array($appointment->consultant_id,$appointment->nurse_id))){
                    return redirect()->route('appointment.list')->with('error', 'Not authorized to access');
                }
            }
            $appoinmentTo = $patientDetails['user']['first_name'];
            $appoinmentToLogo = ($patientDetails['user']['profile_image'] != '') ? $this->Corefunctions-> resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : asset('images/default_img.png');
            $username = ($role == 1) ? $this->Corefunctions->showClinicanName($loginUserDetails) : $loginUserDetails->name;
        }else{
            $loginUserDetails = Patient::patientByUUID($clinicuser_uuid); 
            
            if(empty($loginUserDetails) ){
               
                return redirect()->route('appointment.list')->with('error', 'Not authorized to access');
            }
            $patientDetails = Patient::getPatientDets($appointment->patient_id,session()->get('user.clinicID'));
            if($loginUserDetails->user_id != $patientDetails->user_id){
                return redirect()->route('appointment.list')->with('error', 'Not authorized to access');
            }
            $username = $loginUserDetails->name;
        }

        $appointmentNotes = Appointment::appoinmentNoteByID($appointment->id); 
        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::ClinicByID($appointment->clinic_id));
        
       
        // $currentDateTime = Carbon::now($userTimeZone);
        // $appointmentDateTime = Carbon::createFromFormat(
        //     'Y-m-d H:i:s', 
        //     $appointment->appointment_date . ' ' . $appointment->appointment_time, 
        //     'UTC'
        // )->setTimezone($userTimeZone);
        // // Check if appointment is more than 30 minutes past its scheduled time
        // if ($currentDateTime->diffInMinutes($appointmentDateTime, false) < -30) {
        //     $isExpired = true;
        // }

        /*  check the appoinment clinic time expiry */
        $isExpired = $this->Corefunctions->checkAppoinmentExpiry($appointment,$doctorDetails);
       
      
        $data['seo'] = $this->getSEO($appointment->clinic_id);
        $data['appointmentNotes'] = $appointmentNotes;
        $data['overtime'] = $overtime;
        $data['username'] = $username;
        $data['isExpired'] = $isExpired;
        $data['startAppoinment'] = $startAppoinment;
        $data['videoCallDetails'] = $videoCallDetails;
        $data['appoinmentuuid'] = $appoinmentuuid;
        $data['appointment'] = $appointment;
        $data['clinicDetails'] = $clinicDetails;
        $data['particpantID'] = $loginUserDetails->user_id;
        $data['patientDetails'] = $patientDetails;
        $data['role'] = $role;
        $data['usertype'] = $usertype;
        $data['doctorDetails'] = $doctorDetails;
        $data['appoinmentTo'] = $appoinmentTo;
        $data['appoinmentToLogo'] = $appoinmentToLogo;
        $data['userTimeZone'] = $userTimeZone;
        $data['type'] = 'videocall';
        return view('appointment.videocall', $data);
    }
     
       
    public function getSEO($clinicId){
        $clinicDetails = $this -> getClinicDetails($clinicId);
        $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);  
        $seoMeta = $this -> MetaInfo ->getTitle($clinicDetails);
                
        return $seoMeta;
    }
    public function getClinicDetails($clinicId){
        return $clinicDetails = $this->Corefunctions->convertToArray(Clinic::where('id', $clinicId)->first());
    }
        
    protected function addnote()
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

            $videocall = VideoCall::videoCallByKey($data['roomkey']);
            
            if (empty($videocall)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
            $userTimeZone = session()->get('user.timezone');
            Appointment::addNotes($videocall->appointment_id,$data);
            $appointmentNotes = Appointment::appoinmentNoteByID($videocall->appointment_id); 
            $data['userTimeZone'] = $userTimeZone;
            $data['appointmentNotes'] = $appointmentNotes;
            $html           = view('appointment.videocallnote', $data);
            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Appointment cancelled successfully';
            return response()->json($arr);
            exit();
        }
    }
    
    protected function acceptcall()
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

            $videocall = VideoCall::videoCallByKey($data['roomkey']);
            $usertype = Session::get('user.userType') == 'clinic' ? 'Clinician' : Session::get('user.userType') ;
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
            $appointment = Appointment::appointmentByID($videocall->appointment_id);

            $waiting = $reject = $isdoctor ='0';
            
            if($usertype != 'patient'){
                $loginUserDetails = ClinicUser::getClinicUserByUuid($clinicuser_uuid);
            }else{
                $loginUserDetails = Patient::patientByUUID($clinicuser_uuid);
            }
             if (!empty($appointment) && $appointment->is_completed == '1') {
                return response()->json([
                    'status' => 0,
                    'message' => 'Appointment already completed'
                ]);
            }
            
            if(!isset($data['act'])){
                $participantCount = VideoCallParticipant::checkParticipantJoined($videocall->id, $loginUserDetails->user_id, $usertype);
                if ($participantCount >= 1) {
//                    return response()->json([
//                        'status' => 0,
//                        'message' => 'Participant already joined'
//                    ]);
                }

                $callParticipants = VideoCallParticipant::countCallParticipants($videocall->id);
                if ($callParticipants == 0) {
                    VideoCall::where('room_key',$data['roomkey'])->update(array(
                        'call_started' => time(),
                    ));
                }

                if ($loginUserDetails->id == $appointment->consultant_id && $usertype != 'patient') {
                    VideoCallParticipant::addParticipant($videocall->id, $appointment->consultant_id, $usertype, '1');
                    $isdoctor = '1';
                } else {
                    if ($usertype == 'patient') {
                        Appointment::updateReceptionWaiting($appointment->id,'1');
                        $userDetails = ClinicUser::where('user_id', $appointment->consultant_id)->first();
                        $this->Corefunctions->addNotifications(11, $appointment->clinic_id, $userDetails->user_id, $appointment->id);
                    } else {
                        $isdoctor = '1';
                    }
            
                    VideoCallParticipant::addParticipant($videocall->id, $loginUserDetails->user_id, $usertype, '0', ($usertype == 'patient') ? '1' : '0');
                }
            }

            if (isset($data['act']) && $data['act'] == 'accept') {
                Appointment::updateReceptionWaiting($appointment->id,'0');
                VideoCallParticipant::updateCallStatusForParticipant($videocall->id,['is_waiting' => '0', 'is_reject' => '0']);
            }
            
            if (isset($data['act']) && $data['act'] == 'reject') {
                Appointment::updateReceptionWaiting($appointment->id,'0');
                VideoCallParticipant::updateCallStatusForParticipantReject($videocall->id, $data['participantID'],[
                    'is_waiting' => '0',
                    'is_reject' => '1',
                    'completed' => time()
                ]);
            }
           
            $arr['success'] = 1;
            $arr['iswaiting'] = $waiting;
            $arr['is_reject'] = $reject;
            $arr['isdoctor'] = $isdoctor;
            $arr['success'] = 1;
            $arr['message'] = 'Appointment cancelled successfully';
            return response()->json($arr);
            exit();
        }
    }

    protected function videocallend()
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

            $videocall = VideoCall::videoCallByKey($data['roomkey']);
            if (empty($videocall)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
            
            VideoCallParticipant::markAsCompleted($data['videocallparticipantID'],$videocall->id,Session::get('user.userType'));
            
            $callParticipants = VideoCallParticipant::countCallParticipants($videocall->id);
            if($callParticipants == 0){
                $videocall->duration = time() - $videocall->call_started;
                $videocall->call_ended = time();
                $videocall->update();
            }
            
            $arr['success'] = 1;
            $arr['message'] = 'video call successfully updated!';
            return response()->json($arr);
            exit();
        }
    }

    protected function acceptcallcheck()
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
            $videocall = VideoCall::where('room_key',$data['roomkey'])->first();
            $usertype = Session::get('user.userType');
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
            if($usertype != 'patient'){
                $loginUserDetails = ClinicUser::userByUUID($clinicuser_uuid);
            }else{
                $loginUserDetails = Patient::patientByUUID($clinicuser_uuid);
            }
           
            if(isset($data['act']) && $data['act']=='status'){
                $videocallDetails = VideoCallParticipant::getParticipantJoined($videocall->id, $loginUserDetails->user_id, $usertype);
               
                $arr['is_waiting'] = $videocallDetails->is_waiting;
                $arr['is_reject'] = $videocallDetails->is_reject;
            }else{
                
                
                $videocallDetails = VideoCallParticipant::getFirstWaitingParticipant($videocall->id);
                
                $iswaiting = $waitingID ='0';
                $msg ='';
                if(!empty($videocallDetails)){
                    $iswaiting = $videocallDetails->is_waiting;
                    $waitingID = $videocallDetails->participant_id;
                    $userDetails =  User::userByID($videocallDetails->participant_id);
                   
                    $msg = $userDetails->first_name . ' ' . $userDetails->last_name.' is waiting to join the session.';
                }
                
                $arr['iswaiting'] = $iswaiting;
                $arr['waitingID'] = $waitingID;
                $arr['message'] = $msg;
            }
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function fetchVideocallDetails(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
    
            $videocall = VideoCall::getVideoCallByAppointmentId($data['id']);
    
            if (!$videocall) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'No video call found'
                ]);
            }
    
            $videoParticipants = VideoCallParticipant::getVideoCallParticipants($videocall->id);
    
            $videoParticipantPatients = VideoCallParticipant::getVideoParticipantPatients($videocall->id);
            $videoParticipantOthers = VideoCallParticipant::getVideoParticipantOthers($videocall->id);
    
            $videoParticipantOthers = $this->Corefunctions->convertToArray($videoParticipantOthers);
            $videoParticipantPatients = $this->Corefunctions->convertToArray($videoParticipantPatients);
    
            $clinicuserIDS = $this->Corefunctions->getIDSfromArray($videoParticipantOthers, 'participant_id');
            $patientIDS = $this->Corefunctions->getIDSfromArray($videoParticipantPatients, 'participant_id');
           
            $clinicUserDetails = [];
            if (!empty($clinicuserIDS)) {
                $clinicUserDetails = ClinicUser::getClinicUsersByIds($clinicuserIDS);
                $clinicUserDetails = $this->Corefunctions->convertToArray($clinicUserDetails);
                $clinicUserDetails = $this->Corefunctions->getArrayIndexed1($clinicUserDetails, 'id');

            
            }
    
            $patientDetails = [];
            if (!empty($patientIDS)) {
                $patientDetails = Patient::getPatientsByIds($clinicuserIDS);
                $patientDetails = $this->Corefunctions->convertToArray($patientDetails);
                $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'id');
            }
    
            $data['clinicUserDetails'] = $clinicUserDetails;
            $data['patientDetails'] = $patientDetails;
            $data['videocall'] = $videocall;
            $data['participants'] = $videoParticipants;
    
            $html = view('appointment.videocalldetails', $data);
    
            return response()->json([
                'view' => $html->__toString(),
                'success' => 1
            ]);
        }
    }
    public function getVideocallDetails(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
    
            $videocall = VideoCall::getVideoCallByAppointmentId($data['id']);
    
            if (!$videocall) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'No video call found'
                ]);
            }
    
            $videoParticipants = VideoCallParticipant::getVideoCallParticipants($videocall->id);
    
            $videoParticipantPatients = VideoCallParticipant::getVideoParticipantPatients($videocall->id);
            $videoParticipantOthers = VideoCallParticipant::getVideoParticipantOthers($videocall->id);
    
            $videoParticipantOthers = $this->Corefunctions->convertToArray($videoParticipantOthers);
            $videoParticipantPatients = $this->Corefunctions->convertToArray($videoParticipantPatients);
    
            $clinicuserIDS = $this->Corefunctions->getIDSfromArray($videoParticipantOthers, 'participant_id');
            $patientIDS = $this->Corefunctions->getIDSfromArray($videoParticipantPatients, 'participant_id');
    
            $clinicUserDetails = [];
            if (!empty($clinicuserIDS)) {
                $clinicUserDetails = ClinicUser::getClinicUsersByIds($clinicuserIDS);
                $clinicUserDetails = $this->Corefunctions->convertToArray($clinicUserDetails);
                $clinicUserDetails = $this->Corefunctions->getArrayIndexed1($clinicUserDetails, 'id');
            }
    
            $patientDetails = [];
            if (!empty($patientIDS)) {
                $patientDetails = Patient::getPatientsByIds($clinicuserIDS);
                $patientDetails = $this->Corefunctions->convertToArray($patientDetails);
                $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'id');
            }
    
            $data['clinicUserDetails'] = $clinicUserDetails;
            $data['patientDetails'] = $patientDetails;
            $data['videocall'] = $videocall;
            $data['participants'] = $videoParticipants;
    
            $html = view('appointment.appendvideocalldetails', $data);
    
            return response()->json([
                'view' => $html->__toString(),
                'success' => 1
            ]);
        }
    }
    protected function markAsCompleted()
    {
        if (!request()->ajax()) {
            return;
        }

        $data = request()->all();
        if (empty($data)) {
            return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
        }

        $clinicUserUuid = session('user.clinicuser_uuid');
        $appointment = Appointment::appointmentByKey($data['key']);

        if (!$appointment) {
            return response()->json(['error' => 1, 'errormsg' => 'Invalid Appointment']);
        }

        $clinicId = $appointment->clinic_id;
        $clinic = Clinic::select([
            'id', 'stripe_connection_id', 'name', 'phone_number',
            'address as billing_address', 'state as billing_state',
            'city as billing_city', 'zip_code as billing_zip',
            'country_id as billing_country_id', 'state_id',
            'country_code', 'logo'
        ])
        ->where('id', $clinicId)
        ->whereNull('deleted_at')
        ->first();

        if (!$clinic) {
            return response()->json(['error' => 1, 'errormsg' => 'Clinic invalid']);
        }

        $clinicUserDoctor = ClinicUser::with('user')
            ->where('user_id', $appointment->consultant_id)
            ->whereNull('deleted_at')
            ->first();

        $patient = Patient::with('user')
            ->where('user_id', $appointment->patient_id)
            ->where('clinic_id', $clinicId)
            ->whereNull('deleted_at')
            ->first();

        $patientDetails = $this->Corefunctions->convertToArray($patient);
        $patientCard = PatientCard::getDefaultUserCard($patientDetails['user_id']);
        if (!$patientCard) {
            return response()->json(['error' => 1, 'errormsg' => 'Please add a card for this patient before proceeding.']);
        }

        $clinicCard = ClinicCard::getDefaultUserCard($clinicId);
        if (!$clinicCard) {
            return response()->json(['error' => 1, 'errormsg' => 'Please add a card for this clinic before proceeding.']);
        }


         if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
            return response()->json([
                'status' => 0,
                'message' => 'Stripe not connected',
            ]);

        }
        $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();

        // Stripe Payment
        $paymentIntentId = $data['setupIntentID'] ?? '';
        $input = [];

        $result = $this->Corefunctions->instantPayment(
            $paymentIntentId,
            $stripeConnection->stripe_user_id,
            $patientDetails,
            $input,
            $appointment
        );

        if(isset($result['status']) && $result['status'] == '0'){
            Appointment::where('appointment_uuid', $data['key'])->update(array(
                'payment_response' => $result['message'],
            ));
            return response()->json(['error' => 1,'errormsg' => $result['message']]);
        }
        $paymentIds = $result['paymentIds'];
        $cardDetails = $result['cardDetails'];

        // Send receipt email
        $emailData = [
            'email'           => $patientDetails['email'],
            'name'            => $patientDetails['first_name'].' '.$patientDetails['last_name'],
            'clinicName'      => $clinic->name,
            'receipt_num'     => '#' . $paymentIds['receipt_num'],
            'payment_method'  => 'Card',
            'amount'          => $appointment->appointment_fee,
            'paymentdate'     => now(),
            'card_number'     => $cardDetails['card_num'],
            'appointmnetDate' => date('M d Y', strtotime($appointment->appointment_date)),
            'appointmnetTime' => date('h:i A', strtotime($appointment->appointment_time)),
            'doctorname'      => $this->Corefunctions->showClinicanName($clinicUserDoctor, '1'),
        ];

        $this->Corefunctions->sendmail($emailData, 'Appointment Payment Receipt', 'emails.receipt');

        // Update appointment
        Appointment::where('appointment_uuid', $data['key'])->update(array(
            'is_completed' => '1',
            'is_paid' => '1',
        ));

        // Add notifications
        $appID = $appointment->id;
        $clinicId = session('user.clinicID');

        $this->Corefunctions->addNotifications(12, $clinicId, $appointment->consultant_id, $appID);
        if(isset($appointment->nurse_id) && $appointment->nurse_id != ''){
            $this->Corefunctions->addNotifications(12, $clinicId, $appointment->nurse_id, $appID);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Appointment marked as completed successfully!'
        ]);
    }

    protected function markAsNoShow()
    {
        if (!request()->ajax()) {
            return;
        }

        $data = request()->all();
        if (empty($data)) {
            return response()->json(['error' => 1, 'errormsg' => 'Fields missing']);
        }

        parse_str($data['formdata'], $input);

        $clinicUserUuid = session('user.clinicuser_uuid');
        $appointment = Appointment::appointmentByKey($input['appointmentkey']);

        if (!$appointment) {
            return response()->json(['error' => 1, 'errormsg' => 'Invalid Appointment']);
        }

        if($appointment->status == '2'){
            return response()->json(['error' => 1, 'errormsg' => 'This appointment has already been marked as a no-show.']);
        }

        $clinicId = $appointment->clinic_id;
        $clinic = Clinic::select([
            'id', 'stripe_connection_id', 'name', 'phone_number',
            'address as billing_address', 'state as billing_state',
            'city as billing_city', 'zip_code as billing_zip',
            'country_id as billing_country_id', 'state_id',
            'country_code', 'logo','in_person_mark_as_no_show_fee', 'virtual_mark_as_no_show_fee'
        ])
        ->where('id', $clinicId)
        ->whereNull('deleted_at')
        ->first();

        if (!$clinic) {
            return response()->json(['error' => 1, 'errormsg' => 'Clinic invalid']);
        }

        if(isset($input['collect_fee']) && $input['collect_fee'] == '1'){
            $patient = Patient::with('user')
                ->where('user_id', $appointment->patient_id)
                ->where('clinic_id', $clinicId)
                ->whereNull('deleted_at')
                ->first();

            $patientDetails = $this->Corefunctions->convertToArray($patient);
            $patientCard = PatientCard::getDefaultUserCard($patientDetails['user_id']);
            if (!$patientCard) {
                return response()->json(['error' => 1, 'errormsg' => 'Please add a card for this patient before proceeding.']);
            }

            $clinicCard = ClinicCard::getDefaultUserCard($clinicId);
            if (!$clinicCard) {
                return response()->json(['error' => 1, 'errormsg' => 'Please add a card for this clinic before proceeding.']);
            }


            if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Stripe not connected',
                ]);

            }
            $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();

            $amount = ($appointment->appointment_type_id == 1) ? $clinic->virtual_mark_as_no_show_fee : $clinic->in_person_mark_as_no_show_fee;
            $result = $this->Corefunctions->subscriptionPayment($stripeConnection->stripe_user_id,$patientDetails,$input,$amount,$clinicId,$appointment->id,'','no_show_fee');
            
            if (isset($result['status']) && $result['status'] == '0') {
                $arr['error'] = 1;
                $arr['errormsg'] = $result['message'];
                return response()->json($arr);
            }
            $paymentIds = $result['paymentIds'];
            $cardDetails = $result['cardDetails'];
            $msg = "Appointment marked as no show successfully and an amount of $'.$amount.' debited from patient's card.";
        }else{
            $msg = "Appointment marked as no show successfully.";
        }

        // Update appointment
        Appointment::where('appointment_uuid', $input['appointmentkey'])->update(array(
            'status' => '2',
        ));

        return response()->json([
            'success' => 1,
            'message' => $msg
        ]);
    }

    /** get the add forms   */
    public function addMedicalhistory()
    {
        if(request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $strengthUnits = $this->Corefunctions->convertToArray(DB::table('ref_strength_units')->get());
            $strengthUnits = $this->Corefunctions->getArrayIndexed1($strengthUnits, 'id');

            $dispenseUnits = $this->Corefunctions->convertToArray(DB::table('ref_medication_dispense_units')->get());
            $dispenseUnits = $this->Corefunctions->getArrayIndexed1($dispenseUnits, 'id');
            $formType = $data['type'];

            if($formType == 'weight'){
                /*check height exists or not  */
              $userHeight =   HeightTracker::getHeightTracker($data['userID']);
              $data['isheight'] = empty($userHeight) ?  0 : 1 ;
            }
            $data['immunizationTypes'] = $this->Corefunctions->convertToArray(DB::table('ref_immunization_types')->get());
            $data['relations'] = $this->Corefunctions->convertToArray(DB::table('ref_relations')->where('internal_field', '0')->whereNull('deleted_at')->get());

            $data['userId'] = $data['userID'];
            $data['formType'] = $formType;
            $data['strengthUnits'] = $strengthUnits;
            $data['dispenseUnits'] = $dispenseUnits;
            $html = view('vitals.add_'.$formType, $data);

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

    /*get history */
    public function historyDetails()
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
              $formType = $data['type'];             
              $userId =  $data['userID'];

              $medicalHistoryDetails  = array();
          
                switch ($formType) {
                    case 'medical_conditions':
                       
                        $table = 'patient_conditions';
                        $data['title'] = 'Medical Conditions' ;

                        break;

                    case 'allergies':

                        $table = 'allergies';
                       
                        $data['title'] = 'Allergies' ;
                        break;

                    case 'immunizations':
                        $table = 'immunization';
                        $data['title'] = 'Immunizations' ;
                        break;
                
                    case 'family_history':

                        $table = 'patient_conditions';
                        
                        $data['title'] = 'Family Medical History' ;

                        break;

                   
                
                    default:
                    break;
                } 

            $medicathistoryDetails = $this->Corefunctions->getHistoryDetails($formType,$userId,$table);

            if($formType == 'medical_conditions' || $formType == 'family_history') {
                $conditionIds = $this->Corefunctions->getIDSfromArray($medicathistoryDetails, 'condition_id');
               
                $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->whereIn('id', $conditionIds)->get());
                $conditionDetails = $this->Corefunctions->getArrayIndexed1($conditionDetails, 'id');

                
                $relationIds = $this->Corefunctions->getIDSfromArray($medicathistoryDetails, 'relation_id');
                
                $relationDetails = $this->Corefunctions->convertToArray(DB::table('ref_relations')->whereIn('id', $relationIds)->get());
                $relationDetails = $this->Corefunctions->getArrayIndexed1($relationDetails, 'id');

                if($formType == 'family_history') {
                    $medicathistory = [];
                    // Grouping the data
                    foreach ($medicathistoryDetails as $item) {
                        $relationId = $item['relation_id'];
                        $conditionId = $item['condition_id'];

                        $groupKey = $relationId;

                        if (!isset($medicathistory[$groupKey])) {
                            $medicathistory[$groupKey] = [
                                'id' => $item['id'],
                                'patient_condition_uuid' => $item['patient_condition_uuid'],
                                'created_by' => $item['created_by'],
                                'created_at' => $item['created_at'],
                                'updated_at' => $item['updated_at'],
                                'relation_id' => $relationId,
                                'conditions' => [],
                            ];
                        }
                        $medicathistory[$groupKey]['conditions'][] = $conditionDetails[$conditionId]['condition'];
                    }
                    foreach ($medicathistory as &$group) {
                        $group['conditions'] = implode(', ', $group['conditions']);
                    }
                    $medicathistoryDetails = $medicathistory;
                }
               
                $data['conditionDetails'] = $conditionDetails;
                $data['relationDetails'] = $relationDetails;
            }
            
            $sourceTypes = $this->Corefunctions->convertToArray(DB::table('ref_source_types')->get());
            $sourceTypes = $this->Corefunctions->getArrayIndexed1($sourceTypes, 'id');

            $userIDs = $this->Corefunctions->getIDSfromArray($medicathistoryDetails, 'created_by');
            $userDetails = User::getUsersByIDs($userIDs);
            $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'id');
              
            $immunizationTypes = $this->Corefunctions->convertToArray(DB::table('ref_immunization_types')->get());
            $immunizationTypes = $this->Corefunctions->getArrayIndexed1($immunizationTypes, 'id');


            $data['immunizationTypes']    =$immunizationTypes ;
            $data['medicathistoryDetails'] = $medicathistoryDetails;
            $data['sourceTypes'] = $sourceTypes;
            $data['formType'] = $formType;
            $data['userDetails'] = $userDetails;

            $html = view('appointment.medicalhistory.historydetails', $data);

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['medicathistoryDetails'] = $medicathistoryDetails ;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }


   /** get the intake forms   */
   public function editForm()
   {
       if (request()->ajax()) {

           $data = request()->all();
           // Check if form data is empty
           if (empty($data)) {
               return $this->Corefunctions->returnError('Fields missing');
           }
           if (!isset($data['formtype'])) {
               return $this->Corefunctions->returnError('Form missing');
           }
           $formType = $data['formtype'];
           $type = $data['type'];
           $key = $data['key'];
           $usertype = Session::get('user.userType');
           $userId = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['patientID'];
           $patient = $this->Corefunctions->convertToArray(Patient::where('user_id', $userId)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());
           $medicathistoryDetails  = array();
           switch ($formType) {
               case 'blood_pressure':
                   /*** get  to blood_pressure tracker  */
                   $medicathistoryDetails = BpTracker::getBpTrackerByKey($key);
                   break;
               case 'heart_rate':
                   /*** get  to blood_pressure tracker  */
                   $medicathistoryDetails = BpTracker::getBpTrackerByKey($key);
                   break;
             
               case 'blood_glucose':

                   /*** get  to GlucoseTracker tracker  */
                   $medicathistoryDetails = GlucoseTracker::getGlucoseTrackerByKey($key);

                   break;
                case 'cholesterol':

                    /*** get  to CholesterolTracker tracker  */
                    $medicathistoryDetails = CholestrolTracker::getCholesterolTrackerByKey($key);
 
                    break;
           case 'hba1c':

               /*** get  to GlucoseTracker tracker  */
               $medicathistoryDetails = GlucoseTracker::getGlucoseTrackerByKey($key);

               break;
                       

               case 'weight':

                   $medicathistoryDetails = WeightTracker::getWeightTrackerByKey($key);

                   break;
               case 'height':

                   $medicathistoryDetails = HeightTracker::getHeightTrackerByKey($key);

                   break;
               case 'oxygen_levels':

                   $medicathistoryDetails = OxygenSaturation::getOxygenSaturationByKey($key);

                   break;
              
               

               case 'temperature':

                   $medicathistoryDetails = BodyTemperature::getBodyTemperatureByKey($key);

               break;

               case 'medications':

                $medicathistoryDetails = Medication::getMedicationByKey($key);
                $condition = '';
                if ($medicathistoryDetails['condition_id'] != 0) {
                    $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->where('id', $medicathistoryDetails['condition_id'])->first());
                    $condition = $conditionDetails['condition'];
                }
                $medicine = '';
                if ($medicathistoryDetails['medicine_id'] != 0) {
                    $medicineDetails = $this->Corefunctions->convertToArray(DB::table('ref_medicines')->where('id', $medicathistoryDetails['medicine_id'])->first());
                    $medicine = $medicineDetails['medicine'];
                }
                $data['condition'] = $condition;
                $data['medicine'] = $medicine;

                break;

                case 'medical_conditions':
                    $medicathistoryDetails = PatientCondition::getPatientConditionByKey($key);

                    $condition = '';
                    if ($medicathistoryDetails['condition_id'] != 0) {
                        $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->where('id', $medicathistoryDetails['condition_id'])->first());
                        $medicathistoryDetails['condition'] = $conditionDetails['condition'];
                    }
                break;

                case 'allergies':
                    $medicathistoryDetails = Allergy::getAllergyByKey($key);
                break;
                case 'immunizations':

                    $medicathistoryDetails = Immunization::getImmunizationByKey($key);
                    break;
                case 'family_history':

                    $medicathistory = PatientCondition::getPatientConditionByKey($key);

                    $medicathistory = PatientCondition::getPatientConditionByRelation($medicathistory['user_id'], $medicathistory['relation_id'], $medicathistory['source_type_id']);
                    $conditionIds = $this->Corefunctions->getIDSfromArray($medicathistory, 'condition_id');
                
                    $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->whereIn('id', $conditionIds)->get());
                    $conditionDetails = $this->Corefunctions->getArrayIndexed1($conditionDetails, 'id');

                    $medicathistoryDetails = [];
                    $groupedData = [];

                    foreach ($medicathistory as $item) {
                        $relationId = $item['relation_id'];
                        $sourceTypeId = $item['source_type_id'];
                        $groupKey = $relationId . '-' . $sourceTypeId;
                        if (!isset($groupedData[$groupKey])) {
                            $groupedData[$groupKey] = [
                                'patient_condition_uuid' => $item['patient_condition_uuid'],
                                'relation_id' => $relationId,
                                'source_type_id' => $sourceTypeId,
                                'conditions' => [],
                            ];
                        }
                        $groupedData[$groupKey]['conditions'][] = [
                            'id' => $item['condition_id'],
                            'name' => $conditionDetails[$item['condition_id']]['condition'],
                        ];
                    }

                    foreach ($groupedData as $group) {
                        $medicathistoryDetails = [
                            'patient_condition_uuid' => $group['patient_condition_uuid'],
                            'relation_id' => $group['relation_id'],
                            'source_type_id' => $group['source_type_id'],
                            'conditions' => $group['conditions'],
                        ];
                    }
                    $data['relations'] = $this->Corefunctions->convertToArray(DB::table('ref_relations')->where('internal_field', '0')->get());

                break;
              

                default:
                   // Handle unknown section
                break;
           }
           $relations = $this->Corefunctions->convertToArray(DB::table('ref_relations')->where('internal_field', '0')->get());
           $immunizationTypes = $this->Corefunctions->convertToArray(DB::table('ref_immunization_types')->get());
           $temparatureTypes = RefTemperature::getTemparatreTypes();
           
           $strengthUnits = $this->Corefunctions->convertToArray(DB::table('ref_strength_units')->get());
           $strengthUnits = $this->Corefunctions->getArrayIndexed1($strengthUnits, 'id');
           $dispenseUnits = $this->Corefunctions->convertToArray(DB::table('ref_medication_dispense_units')->get());
           $dispenseUnits = $this->Corefunctions->getArrayIndexed1($dispenseUnits, 'id');
           $data['relations'] = $this->Corefunctions->convertToArray(DB::table('ref_relations')->where('internal_field', '0')->whereNull('deleted_at')->get());
           
         
           $data['userId'] = $userId ;
           $data['key'] = $key;
           $data['type'] = $type;
           $data['formType'] = $formType;
           $data['patient'] = $patient;
           $data['temparatureTypes'] = $temparatureTypes;
           $data['relations'] = $relations;
           $data['immunizationTypes'] = $immunizationTypes;
           $data['medicathistoryDetails'] = $medicathistoryDetails;
           $data['strengthUnits'] = $strengthUnits;
           $data['dispenseUnits'] = $dispenseUnits;

           $html = view('vitals.add_'.$formType, $data);

           $arr['view'] = $html->__toString();
           $arr['success'] = 1;
           $arr['message'] = 'Data fetched successfully';
           return response()->json($arr);
       }
    }
    public function triggerAmount(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
               return $this->Corefunctions->returnError('Fields missing');
            }
            
            $clinicId = session()->get('user.clinicID');
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId)); 
            
            $subscriptionDets =  array();
            if($data['patientId'] != ''){
                $patientDets = Patient::patientByUser($data['patientId']);
                $subscriptionDets = PatientSubscription::getPatientSubscription($patientDets['id']);
            }

            if(!empty($subscriptionDets)){
                $amount = ($data['type'] == '1') ? $subscriptionDets['virtual_fee'] : $subscriptionDets['inperson_fee'];
            }else{
                $amount = ($data['type'] == '1') ? $clinicDetails['virtual_fee'] : $clinicDetails['inperson_fee'];
            }

            $arr['amount'] = $amount;
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    public function startAppointment(){
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
               return $this->Corefunctions->returnError('Fields missing');
            }

            $appointment = Appointment::getAppointmentByUuid($data['key']);
            $appointment = $this->Corefunctions->convertToArray($appointment);
            if (!$appointment) {
                return redirect()->route('appointment.list')->with('error', 'Failed to fetch appointment data!');
            }

            $clinicId = session()->get('user.clinicID');
            $userCards = ClinicCard::getUserCards($clinicId);
            if (empty($userCards) ) {
                $arr['status'] = 0;
                $arr['errormsg'] = 'Please add atleast one card before starting your appointment.';
            }

            $input['uuid'] = $data['key'];
            $result = $this->Corefunctions->submitPayment($appointment['clinic_id'],env('APPLICATION_FEE'),$input);
            Appointment::where('appointment_uuid', $data['key'])->update(array(
                'is_paid' => '1'
            ));

            $arr['success'] = 1;
            $arr['message'] = 'Appointment started successfully.';
            return response()->json($arr);
        }
    }


    public function reschedule()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $uuid = $data['uuid'] ;
            if (!$uuid) {
                return view('appointment.listing')->with('error', "Failed to find data or Invalid key passed!");
            }
            
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
            $clinicId = session()->get('user.clinicID'); // get logged in clinic id
            $appointment = Appointment::appointmentByKey($uuid);
           
            if (empty($appointment)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Invalid record'
                ]);
            }

            $clinicUserNurse =  $this->Corefunctions->convertToArray(Appointment::getClinicUserDoctor(session()->get('user.clinicID'),$appointment->nurse_id));
            if(!empty($clinicUserNurse)){
                $clinicUserNurse['logo_path'] =  !empty($clinicUserNurse) && ($clinicUserNurse['user']['profile_image'] != '') ? $this->Corefunctions->resizeImageAWS($clinicUserNurse['user_id'],$clinicUserNurse['user']['profile_image'],$clinicUserNurse['user']['first_name'],180,180,'1') : (($clinicUserNurse['logo_path'] != '') ? $this->Corefunctions-> resizeImageAWS($clinicUserNurse['id'],$clinicUserNurse['logo_path'],$clinicUserNurse['name'],180,180,'1') : '');

            }

            $clinicUserDoctor =  $this->Corefunctions->convertToArray(Appointment::getClinicUserDoctor(session()->get('user.clinicID'), $appointment->consultant_id));
            $clinicUserDoctor['logo_path'] =  ($clinicUserDoctor['user']['profile_image'] != '') ? $this->Corefunctions->resizeImageAWS($clinicUserDoctor['user_id'],$clinicUserDoctor['user']['profile_image'],$clinicUserDoctor['user']['first_name'],180,180,'1') : (($clinicUserDoctor['logo_path'] != '') ? $this->Corefunctions-> resizeImageAWS($clinicUserDoctor['id'],$clinicUserDoctor['logo_path'],$clinicUserDoctor['name'],180,180,'1') : '');


            $patientDetails =  $this->Corefunctions->convertToArray(Patient::getPatientDets($appointment->patient_id,session()->get('user.clinicID')));
            $patientDetails['logo_path'] =  (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $html = view('appointment.reschedule', compact('appointment','clinicUserNurse','clinicUserDoctor','patientDetails'))->render();

            return response()->json([
                'view' => $html,
                'status' => 1,
            ]);
        }
    }

    function rescheduleUpdate(){
        if (request()->ajax()) {
            $data = request()->all();
           
            parse_str($data['formData'], $input);
            $uuid = $data['appointment_uuid'];
            $clinicId = Session::get('user.clinicID');
            
            
            $appointment = Appointment::appointmentByKey($uuid);
            if (empty($appointment)) {
                return redirect()->route('appointment.list')->with('error', 'Invalid or appointment not found!');
            }
            $appointmentId = $appointment->id;

            $userTimeZone = session()->get('user.timezone');
            $dateTimeString = $input['appointment_date'] . ' ' . $input['appointment_time'];
            $dateTime = \DateTime::createFromFormat('m/d/Y h:i A',$dateTimeString,new \DateTimeZone($userTimeZone));
            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedDate = $dateTime->format('Y-m-d');
            $formattedTime = $dateTime->format('H:i:s');
         
           
            // Combine the date and time into a single DateTime object for comparison
            $appointmentDateTime = strtotime($input['appointment_time']);
            $currentDateTime = $this->Corefunctions->currentTime(); //    // Get the current date and time
            // Check if the appointment date is today
            $formattedDate === date('Y-m-d',$currentDateTime);
            /** check the patient have same appointment with other doctors */
            $appointmentExists = Appointment::isAppointmentExists($clinicId,$formattedDate,$formattedTime,$appointment->patient_id,$appointment->nurse_id,$appointment->consultant_id,'1',$appointmentId);
            if ( $appointmentExists ) {
                return response()->json([
                    'success' => 0,
                    'message' => 'An appointment is already scheduled for that time',
                ]);
            }
            $expiredDate = new \DateTime($formattedDate. ' ' . $formattedTime);
            // Add 1 hour to the current DateTime object
            $expiredDate->modify('+1 hour');
            /*  update table  */
            Appointment::updateAppointmentSchedule($appointmentId, $formattedDate, $formattedTime, $expiredDate);

            
            /* notification and emails for respectve */
            if($formattedDate != $appointment->appointment_date || $formattedTime != $appointment->appointment_time){

            if($appointment->appointment_type_id == 1){
                $data['appointment_type'] ="Online Appointment";
            }else{
                $data['appointment_type'] ="In-person Appointment";
            }


            $clinic = Clinic::clinicByID(session()->get('user.clinicID'));
            $patientDetails = Patient::getPatientDets($appointment->patient_id,session()->get('user.clinicID'));
             /**  mail and notification for doctor*/
            $clinicUserDoctor = Appointment::getClinicUserDoctor(session()->get('user.clinicID'), $appointment->consultant_id);
            if( $appointment->consultant_id != session()->get('user.userID') ){
                $this->Corefunctions->addNotifications(20,session()->get('user.clinicID'),$clinicUserDoctor['user_id'],$appointmentId);
              
                $data['name'] = $this->Corefunctions -> showClinicanName($clinicUserDoctor,'1');
                $data['clinic'] = $clinic->name;
                $data['email'] = $clinicUserDoctor['email'];
                $data['date'] =  date('M d Y', strtotime($formattedDate)) ;
                $data['time'] = date('h:i A', strtotime($formattedTime)) ;
                $data['link'] = url('meet/'.$uuid);
                $data['userType'] = "clinicUser";
                $data['patient'] = $patientDetails->first_name.' '.$patientDetails->last_name;
                $response = $this->Corefunctions->sendmail($data, 'Appointment Re-scheduled - '.$patientDetails->first_name.' '.$patientDetails->last_name, 'emails.rescheduleappointment');
     
            }
           
             /** notification & mail for nurse */
             $clinicUserNurse = Appointment::getClinicUserDoctor(session()->get('user.clinicID'),$appointment->nurse_id);
             $this->Corefunctions->addNotifications(19,session()->get('user.clinicID'),$clinicUserNurse['user_id'],$appointmentId);
             $data['name'] = $clinicUserNurse['name'];
             $data['clinic'] = $clinic->name;
             $data['email'] = $clinicUserNurse['email'];
             $data['date'] =  date('M d Y', strtotime($formattedDate)) ;
             $data['time'] = date('h:i A', strtotime($formattedTime)) ;
             $data['link'] = url('meet/'.$uuid);
             $data['userType'] = "clinicUser";
             $data['patient'] = $patientDetails->first_name.' '.$patientDetails->last_name;
             $response = $this->Corefunctions->sendmail($data, 'Appointment Re-scheduled- '.$patientDetails->first_name.' '.$patientDetails->last_name, 'emails.rescheduleappointment');
 
             /** notification for patients */
             $this->Corefunctions->addNotifications(18,session()->get('user.clinicID'),$patientDetails->user_id,$appointmentId);
 
             /** mail to patient */
             $data['name'] =  $patientDetails->first_name.' '.$patientDetails->last_name;
             $data['clinic'] = $clinic->name;
             $data['email'] = $patientDetails->email;
             $data['date'] =  date('M d Y', strtotime($formattedDate)) ;
             $data['time'] = date('h:i A', strtotime($formattedTime)) ;
             $data['link'] = url('meet/'.$uuid);
             $data['userType'] = "patient";
             $data['doctor'] = $this->Corefunctions -> showClinicanName($clinicUserDoctor,'1');
             $response = $this->Corefunctions->sendmail($data, 'Appointment Re-Scheduled with '.$data['clinic'], 'emails.reschedulepatient');
                
            }
            return response()->json([
                'success' => '1',
                    'message' => "Appointment updated successfully!"
            ]);

        }
    }

    protected function markAsNotesLocked()
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
            try {
                $appointment = Appointment::appointmentByKey($data['key']);
                Appointment::where('appointment_uuid', $data['key'])->update(array(
                    'is_notes_locked' => '1',
                ));

            } catch (ModelNotFoundException $e) {
                $message = 'Unable to find appointment';
                $status = 'error';
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                $message = 'An error occurred while deleting the appointment';
                $status = 'error';
            }

            $arr['success'] = 1;
            $arr['message'] = 'Appointment notes marked as locked successfully';
            return response()->json($arr);
            exit();
        }
    }
}
