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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Route;
class MeetController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->stripePayment      = new \App\customclasses\StripePayment;
        $this->MetaInfo = new \App\customclasses\MetaInfo;
        $this->middleware(function ($request, $next) {
            $method = Route::current()->getActionMethod();
           
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


    
   //completed meeting 
    public function completedMeet($key){
        $userTimeZone = session()->get('user.timezone');
        $appointment = Appointment::where('appointment_uuid', $key)->first();

        if (empty($appointment)) {
            return redirect()->route('appointment.list')->with('error', 'Appointment not found!');
        }
        
        // Prepare data to pass to the view
        $data = [
            'seo' => $this->getSEO($appointment->clinic_id)
        ];

        return view('videos.completed', $data);
    }

   //join meeting 
    public function joinMeet($key){
        $userTimeZone = session()->get('user.timezone');
        $appointment = Appointment::where('appointment_uuid', $key)->first();

        if (empty($appointment)) {
            return redirect()->route('appointment.list')->with('error', 'Appointment not found!');
        }
          // Add expired check
        $isExpired = false;
        $currentDateTime = Carbon::now($userTimeZone);
        $appointmentDateTime = Carbon::createFromFormat(
            'Y-m-d H:i:s', 
            $appointment->appointment_date . ' ' . $appointment->appointment_time, 
            'UTC'
        )->setTimezone($userTimeZone);
        // Check if appointment is more than 30 minutes past its scheduled time
        if ($currentDateTime->diffInMinutes($appointmentDateTime, false) < -30) {
            $isExpired = true;
        }


        $currentLogginedUserDetails = $this->getCurrentLogginedUserDetails(session()->get('user.userID'));
        $currentLogginedUserDetails['profile_image'] = $this->getProfileImage($currentLogginedUserDetails);
        // Get patient details
        $userDetails = $this->getPatientDetails($appointment->patient_id);
       
        if (empty($userDetails)) {
            return redirect()->route('appointment.list')->with('error', 'Appointment not found!');
        }
        // Get user details
        $this->validateUserAccess($appointment);

        // Get video call details if available
        $videoCallDetails = VideoCall::getvideoCallByAppoinmentID($appointment->id);

        // Format logos
        $userDetails['logo_path'] = $this->getProfileImage($userDetails['user']);
        
        $usertype = Session::get('user.userType');
        if ($usertype == 'patient') {
            $userDetails = $this->getDoctorDetails($appointment->consultant_id);
            $userDetails['logo_path'] = $this->getProfileImage($userDetails['user']);
            
        }
       
        // Calculate appointment date and time in the user's timezone
        $appointmentDateTime = $this->getAppointmentDateTime($appointment, $userTimeZone);

        // Get current time and check appointment time
        $currentDateTime = now()->setTimezone(new \DateTimeZone($userTimeZone));
        $isToday = $this->isAppointmentToday($appointmentDateTime, $currentDateTime);

        // Check if appointment is within the allowed time window
        $timeStatus = $this->checkAppointmentTime($appointmentDateTime,$isToday);

        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::where('id', $appointment->clinic_id)->first());
        //Get all partipant images
        $participantImages = $this->getPaticipantImages($appointment);

        
        // Prepare data to pass to the view
        $data = [
            'startappoinment' => $timeStatus['startAppoinment'],
            'overtime' => $timeStatus['overtime'],
            'videocalldetails' => $videoCallDetails,
            'appointment' => $appointment,
            'clinicdetails' => $clinicDetails,
            'userdetails' => $userDetails,
            'loggineduserdetails' => $currentLogginedUserDetails,
            'visittimediff' => $timeStatus['visitTimeDiff'],
            'participantimages' => $participantImages,
            'usertype' => $usertype,
            'seo' => $this->getSEO($appointment->clinic_id),
            'isExpired' => $isExpired ,
        ];

        return view('videos.videocall', $data);
    }

    // user details based on appointment
   
     function validateUserAccess($appointment){
        $usertype = Session::get('user.userType');
        $clinicuser_uuid = Session::get('user.clinicuser_uuid');
        $userDetails = [];

        if ($usertype !== 'patient') {
            $userDetails = ClinicUser::with('user')->where('clinic_user_uuid', $clinicuser_uuid)->first();
            if ($usertype !== 'clinics') {
                if (!in_array($userDetails->user_id, [$appointment->consultant_id, $appointment->nurse_id])) {
                    return redirect()->route('appointment.list')->with('error', 'Not authorized to access');
                }
            }
        } else {
            $userDetails = Patient::with('user')->where('patients_uuid', $clinicuser_uuid)->first();
            if (empty($userDetails)) {
                return redirect()->route('appointment.list')->with('error', 'Not authorized to access');
            }
            if ($userDetails->user_id !== $appointment->patient_id) {
                return redirect()->route('appointment.list')->with('error', 'Not authorized to access');
            }
        }
        return;
    }

   // get patient details
    
     function getPatientDetails($patientId){
        return $this->Corefunctions->convertToArray(Patient::with('user')->where('user_id', $patientId)->first());
    }
    //get participant images
    function getPaticipantImages($appointment){
        $userIDS= array($appointment->consultant_id, $appointment->nurse_id,$appointment->patient_id);
        $userDetails = $this->Corefunctions->convertToArray(User::whereIn('id', $userIDS)->get());
        $userArray = array();
        if(!empty($userDetails)){
            foreach($userDetails as $usr){
                $userArray[] = array('identity'=>$usr['user_uuid'],'imageUrl'=>$this->getProfileImage($usr));
            }
        }
        //print_r($userArray);die;
        return $userArray;
    }

     function getCurrentLogginedUserDetails($userId){
        return $this->Corefunctions->convertToArray(User::where('id', $userId)->first());
    }

    // get doctor details
   
     function getDoctorDetails($consultantId){
        return ClinicUser::with('user')->where('user_id', $consultantId)->first();
    }

    // get profile image
   
     function getProfileImage($user){
        return ($user['profile_image'] !== '') 
            ? $this->Corefunctions->resizeImageAWS($user['id'], $user['profile_image'], $user['first_name'], 180, 180, '1')
            : $this->Corefunctions ->userInitials($user['first_name']);
    }

    // calculate appointment DateTime
    
     function getAppointmentDateTime($appointment, $userTimeZone){
        return new \DateTime($appointment->appointment_date . ' ' . $appointment->appointment_time, new \DateTimeZone($userTimeZone));
    }

    // check if the appointment is today
     function isAppointmentToday($appointmentDateTime, $currentDateTime){
        return $appointmentDateTime->format('Y-m-d') === $currentDateTime->format('Y-m-d');
    }

    // the appointment time  (within 30 minutes)
     function checkAppointmentTime($appointmentDateTime,$isToday){
        $minus30Minutes = (clone $appointmentDateTime)->modify('-30 minutes');
        $plus30Minutes = (clone $appointmentDateTime)->modify('+30 minutes');

        $startAppoinment = 0;
        $overtime = 0;
        $visitTimeDiff = 0;

        if ($isToday && ($appointmentDateTime >= $minus30Minutes && $appointmentDateTime <= $plus30Minutes)) {
            $startAppoinment = 1; 
        } elseif ($isToday &&  $appointmentDateTime > $plus30Minutes) {
            $overtime = 1; 
        }

        $visitTimeDiff = (strtotime($appointmentDateTime->getTimestamp()) > strtotime('+30minutes')) 
            ? strtotime($appointmentDateTime->getTimestamp()) - strtotime('+30minutes') 
            : 0;

        return [
            'startAppoinment' => $startAppoinment,
            'overtime' => $overtime,
            'visitTimeDiff' => $visitTimeDiff
        ];
    }

    
    
    
    
    
 
    public function checkVideoCallStatus()
    {
         if (request()->ajax()) {
                $data = request()->all();

                $roomkey = $data['roomkey'];
                $userID = Session::get('user.userID');

                $videochatDets = VideoCall::videoCallByKey($roomkey);
                $videocallParticipant = VideoCall::getParticipationByID($userID,$videochatDets->id);
            //print_r($videocallParticipant);die;
                $hasWaiting = $callStarted = 0;
                $waitingMessage = $waitingUserID = '';
                $appointmentDetails = Appointment::appointmentByID($videochatDets->appointment_id);
                if(Session::get('user.userType')!='patient'){
                    $waitingUser = VideoCall::getWaitingUser($videochatDets->id);

                    
                    
                    if (!empty($waitingUser)) {
                        $hasWaiting = 1;
                        $patientDetails = User::userByID($waitingUser->participant_id);
                        $waitingMessage = $patientDetails->first_name . ' ' . $patientDetails->last_name . ' is waiting in the video reception';
                    }
                }else{
                    $callStarted = ($videocallParticipant->is_waiting == '1') ? 0 : 1;
                }
                $data['success'] = '1';
                $data['hasWaiting'] = $hasWaiting;
                $data['isCompleted'] = $videocallParticipant->completed == NULL  ? 0 : 1;
                $data['callStarted'] = $callStarted;
                $data['waitingMessage'] = $waitingMessage;
                $data['appoinment_uuid'] = $appointmentDetails->appointment_uuid;

                return response()->json($data);
        }
    }
      public function initiateVideoCall()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if roomkey is provided
            if (!$data['roomkey']) {
                return response()->json([
                        'status' => 0,
                        'message' => 'Fields missing'
                    ]);
            }

            // Get video chat details using roomkey
            $videochatDets = VideoCall::videoCallByKey($data['roomkey']);

            // If video chat details are empty, return an error
            if (empty($videochatDets)) {
                return response()->json([
                        'status' => 0,
                        'message' => 'Fields missing'
                    ]);
            }

           $userId = session()->get('user.userID');
            // Fetch the current user details
            $user = User::userByID($userId);

            // Set user image path
            $user->Img = ($user->profile_image != '') 
                ?  $this->Corefunctions->resizeImageAWS($user->id,$user->profile_image,$user->first_name,180,180,'1') 
                : DEFAULTIMG;

            // Get room key
            $videocallkey = $data['roomkey'];

            // Request token from an external API
            $requestData = file_get_contents("http://demo.icwares.com/tests/twiliomaster/gettoken.php?user={$user->user_uuid}&room={$videocallkey}");
            $requestToken = json_decode($requestData, true);

            // If the token response is not as expected, return an error
            if (!isset($requestToken['token'])) {
                return response()->json(['msg' => 'Unable to generate token'], 500);
            }

            // Prepare response data
            $data = [
                'token' => $requestToken['token'],
                'identity' => $requestToken['room']
            ];

            return response()->json($data);
        }
    }
    public function generatetoken(){
        $videocallkey = $_GET['roomkey'];
        $participantkey = $_GET['participationkey'];
        $requestData = file_get_contents('http://demo.icwares.com/tests/twiliomaster/gettoken.php?user='.$participantkey.'&room='.$videocallkey);
        $requestToken = json_decode($requestData,true);
        print $requestToken['token']; exit;
    }
    protected function acceptcall(){
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
        $userType = Session::get('user.userType') == 'clinic' ? 'Clinician' : Session::get('user.userType');
        $userID = Session::get('user.userID');
        $appointment = Appointment::appointmentByID($videocall->appointment_id);
        $loginUserDetails = User::userByID($userID);


        

        if (!isset($data['act'])) {
            
            
            // Appointment check
            if (empty($appointment) || $appointment->is_completed == '1') {
                return response()->json([
                    'status' => 0,
                    'message' => 'Appointment already completed'
                ]);
            }
            $vcParticipantCount = VideoCallParticipant::where('call_id', $videocall->id)
            ->where('participant_id', $loginUserDetails->id)
            ->where('participant_type', $userType)
            ->whereNull('completed')
            ->count();

//            if ($vcParticipantCount >= 1) {
//                return response()->json([
//                    'status' => 0,
//                    'message' => 'Participant already joined'
//                ]);
//            }

            // Create a participant if not already joined
            $vcParticipationKey = $this->Corefunctions->generateUniqueKey('10', 'video_call_participants', 'vcparticipation_key');
            $videocallParticipantData = [
                'vcparticipation_key' => $vcParticipationKey,
                'call_id' => $videocall->id,
                'initiated' => time(),
                'participant_id' => $loginUserDetails->id,
                'participant_type' => $userType,
            ];
            // Handle the initial join
            $callStarted = $this->handleInitialJoin($videocall, $appointment, $userType, $loginUserDetails, $videocallParticipantData);
        }

        // Accept action: Update the appointment and participant status
        if (isset($data['act']) && $data['act'] == 'accept') {
            return $this->acceptParticipant($videocall, $appointment, $userType);
        }

        // Reject action: Update the participant as rejected
        if (isset($data['act']) && $data['act'] == 'reject') {
            return $this->rejectParticipant($videocall, $appointment, $userType);
        }

        return response()->json([
            'success' => 1,
            'callStarted' => $callStarted,
            'message' => ' completed successfully',
            'roomkey' => $data['roomkey'],
            'appointmentkey' => $appointment->appointment_uuid,
            'participationkey' => $vcParticipationKey
        ]);
    }
}

//   participant join 
 
   function handleInitialJoin($videocall, $appointment, $userType, $loginUserDetails, $videocallParticipantData){
       $vcParticipantCount = VideoCallParticipant::where('call_id', $videocall->id)->count();
        if ($vcParticipantCount === 0) {
            // Start the call if this is the first participant
            VideoCall::updateVideocallByID($videocall->id);
           
        }

        // Determine if the user is a doctor or not and set additional properties
        $videocallParticipantData['is_owner'] = ($userType != 'patient' && $loginUserDetails->id == $appointment->consultant_id) ? '1' : '0';
        $callStarted = ($userType == 'patient') ? '0' : '1';
        $videocallParticipantData['is_waiting'] = ($userType == 'patient') ? '1' : '0';

        VideoCallParticipant::create($videocallParticipantData);
        return $callStarted;
    }

    //Accept a waiting participant and update the status.

    function acceptParticipant($videocall, $appointment, $userType){
        // Update appointment status
        Appointment::updateAppointmentByID($videocall->appointment_id, '0');

        // Fetch waiting user and update status
        $waitingUser = VideoCall::getWaitingUser($videocall->id);
        $participant = VideoCall::updateParticipationByID($waitingUser->participant_id,$videocall->id,'0');
         

        return response()->json([
            'success' => 1,
            'iswaiting' => 0,
            'is_reject' => 0,
            'callStarted' => 1,
            'isdoctor' => $userType == 'doctor' ? 1 : 0,
            'roomkey' => $videocall->room_key,
            'appointmentkey' => $appointment->appointment_uuid,
        ]);
    }
    //Reject a participant and update the status.
     
    function rejectParticipant($videocall, $appointment, $userType){
        // Update appointment status
        Appointment::updateAppointmentByID($videocall->appointment_id, '0');

        // Fetch waiting user and update status
        $waitingUser = VideoCall::getWaitingUser($videocall->id);
        if ($waitingUser) {
             $participant = VideoCall::updateParticipationByID($waitingUser->participant_id,$videocall->id,'0','1');
        }

        return response()->json([
            'success' => 1,
            'iswaiting' => 0,
            'is_reject' => 1,
            'callStarted' => 0,
            'isdoctor' => $userType == 'doctor' ? 1 : 0,
            'roomkey' => $videocall->room_key,
            'appointmentkey' => $appointment->appointment_uuid,
        ]);
    }
    public function updateVideoCallStatus(){
           $videocallkey = $_GET['roomkey'];
          $status = $_GET['status'];
            // Check if roomkey is provided
            if (!$videocallkey) {
                return response()->json([
                        'status' => 0,
                        'message' => 'Fields missing'
                    ]);
            }

            // Get video chat details using roomkey
            $videochatDets = VideoCall::videoCallByKey($videocallkey);

            // If video chat details are empty, return an error
            if (empty($videochatDets)) {
                return response()->json([
                        'status' => 0,
                        'message' => 'Fields missing'
                    ]);
            }
            $userID = Session::get('user.userID');
            $loginUserDetails = User::userByID($userID);
            VideoCall::updateVideoCallStatus($loginUserDetails->id,$videochatDets->id,$status);

            return response()->json(['msg' => 'Video call status updated successfully']); 
         
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
        
    
        
    
   
}
