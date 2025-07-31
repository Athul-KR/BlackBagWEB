<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Consultant;
use App\Models\Subscription;
use App\Models\Patient;
use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\RpmOrders;
use App\Models\MedicalNote;
use App\Models\RefDesignation;
use App\Models\Appointment;
use App\Models\Notification;
use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Route;
class NotificationController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        // Middleware for session check
        $this->middleware(function ($request, $next) {
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
                // return Redirect::to('/');
            }
            $method = Route::current()->getActionMethod();
            if(!in_array($method,array('list'))){
                if (Session::has('user') && session()->get('user.userType') == 'patient') {
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
             /* Validate onboarding process */
             if ($this->Corefunctions->validateClincOnboarding()) {
                return Redirect::to('/onboarding/business-details');
            }
            return $next($request);
        });
    }

    public function notification()
    {
        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
        $filterby = (isset($_GET['filterby']) && ($_GET['filterby'] != '')) ? $_GET['filterby'] : '';

        $notificationDetails = Notification::getNotifications($filterby, $limit);
        $notificationList = $this->Corefunctions->convertToArray($notificationDetails);
        $notificationList = $notificationList['data'];

        $userIDS = $this->Corefunctions->getIDSfromArray($notificationDetails,'user_id');
        $userDets = User::getUsersByIDs($userIDS);
        $userDets = $this-> Corefunctions->convertToArray($userDets);
        $userDets = $this->Corefunctions->getArrayIndexed1($userDets, 'id');

        $groupedNotifications = array();
        if (!empty($notificationList)) {
            $groupedNotifications = [
                'Today' => [],
                'Yesterday' => [],
                'Older' => []
            ];
        
            foreach ($notificationList as $notification) {
                $messageData = $this->getNotificationMessage($notification['notification_type_id'],$notification['parent_id'],$notification['user_id']);
                $notification['username'] = isset($messageData['username']) ? $messageData['username'] : '';
                $notification['notificationMessage'] = $messageData['message'];
                $notification['toRedirect'] = $messageData['toRedirect'];
                $notification['notify_user_img'] = $messageData['userImg'];
                $notification['notificationdate'] = $notification['created_at'];
                $notification['notificationkey']    = $notification['notification_uuid'];
                $notification['is_read']    = $notification['is_read'];
                // Determine the category based on date
                $notificationDate = date('Y-m-d', strtotime($notification['created_at']));
                $today = date('Y-m-d');
                $yesterday = date('Y-m-d', strtotime('-1 day'));
        
                if ($notificationDate === $today) {
                    $groupedNotifications['Today'][] = $notification;
                } elseif ($notificationDate === $yesterday) {
                    $groupedNotifications['Yesterday'][] = $notification;
                } else {
                    $groupedNotifications['Older'][] = $notification;
                }
            }
        }

        $seo['title'] = "Notifications | " . env('APP_NAME');
        $seo['keywords'] = "Notification Alerts, Healthcare Notifications, Appointment Notifications, Invitation Acceptance Notifications, Real-Time Alerts for Healthcare Professionals, Appointment Status Updates, Instant Alerts for Nurses and Doctors, Healthcare Invitation Tracking, Appointment Confirmation Alerts, Patient Appointment Notifications, Urgent Notifications for Healthcare Providers, Automated Notification System, Notification Management System ";                            
        $seo['description'] = "Stay updated with real-time notifications for your healthcare team. Our platform delivers instant alerts for appointment confirmations, invitation responses, and staff availability, ensuring efficient communication between doctors, nurses, and patients. Ideal for healthcare providers seeking seamless, automated notification systems to improve staff coordination, patient care, and appointment management";                  
        $seo['og_title'] = "Notifications | " . env('APP_NAME');
        $seo['og_description'] = "Stay updated with real-time notifications for your healthcare team. Our platform delivers instant alerts for appointment confirmations, invitation responses, and staff availability, ensuring efficient communication between doctors, nurses, and patients. Ideal for healthcare providers seeking seamless, automated notification systems to improve staff coordination, patient care, and appointment management"; 

        return view('notification.listing',compact('groupedNotifications','notificationDetails','limit','seo'));
    }

    public function list(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            
            $notificationDetails = Notification::getNotifications();
            $notificationDetails = $this->Corefunctions->convertToArray($notificationDetails);
            $notificationDetails = $notificationDetails['data'];
        
            $userIDS = $this->Corefunctions->getIDSfromArray($notificationDetails,'user_id');
            $userDets = User::getUsersByIDs($userIDS);
            $userDets = $this-> Corefunctions->convertToArray($userDets);
            $userDets = $this->Corefunctions->getArrayIndexed1($userDets, 'id');
            $usertype = Session::get('user.userType');

            // Filter if user is 'patient' onlu notes notifications
            if ($usertype == 'patient' && !empty($notificationDetails)) {
                $notificationDetails = array_filter($notificationDetails, function ($notification) {
                 //   return $notification['notification_type_id'] == 17;
                    return in_array($notification['notification_type_id'], [17, 21]);
                });
                $notificationDetails = array_values($notificationDetails);
            }
            if (!empty($notificationDetails)) {
                foreach ($notificationDetails as $km => $kv) {
                   
                    $messageData                                     = $this->getNotificationMessage($kv['notification_type_id'], $kv['parent_id'],$kv['user_id']);               
                    $notificationDetails[$km]['notificationMessage'] = $messageData['message'];
                    $notificationDetails[$km]['username'] = isset($messageData['username']) ? $messageData['username'] : '';
                    $notificationDetails[$km]['toRedirect']          = $messageData['toRedirect'];
                    $notificationDetails[$km]['notify_user_img']     = $messageData['userImg'];
                    $notificationDetails[$km]['notificationdate']    = $kv['created_at'];
                    $notificationDetails[$km]['notificationkey']    = $kv['notification_uuid'];
                    $notificationDetails[$km]['is_read']    = $kv['is_read'];
                }
            }
            
            $notificationCount = Notification::getNotificationCount();

            $data['notificationDetails']     = $notificationDetails;
            $data['notificationCount']     = $notificationCount;
            
            $html           = view('notification.notificationlist',$data);
            $arr['view']    = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }

    }


    public function getUserDetails($userID){
        $userDetails = $this->Corefunctions->convertToArray(User::userByID($userID));
        if (!empty($userDetails)) {
            $userDetails['profile_image'] = ($userDetails['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['profile_image']) : asset('images/default_img.png');
        }
        return $userDetails;
    }  
    public function getNotificationMessage($notificationTypeID, $parentID,$userId){
        $msg = '';
        $returnArray = array(
            'message' => '',
            'userImg' => '',
            'toRedirect' => ''
        );
        switch ($notificationTypeID) {
            case 1: 
                // Invite to team
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(ClinicUser::userByID($parentID));
                if (!empty($parentDetails)) {
                    $userImage = ($parentDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($parentDetails['logo_path']) : asset('images/default_img.png');
                    $usertype = ($parentDetails['user_type_id'] == 1) ? 'Admin' : (($parentDetails['user_type_id'] == 2) ? 'Clinician' : 'Nurse');
                    
                    $msg                    =  $parentDetails['name'].' has accepted the invitation <span class="badge bg-info">'. $usertype.'</span>';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                        
                    $returnArray['toRedirect'] = ($parentDetails['user_type_id'] == 2) ? url('user/'.$parentDetails['clinic_user_uuid'].'/details') : url('user/'.$parentDetails['clinic_user_uuid'].'/details') ;
                }
            break;

            case 2: 
                // Invite to team
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(ClinicUser::userByID($parentID));
                if (!empty($parentDetails)) {
                    $userImage = ($parentDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($parentDetails['logo_path']) : asset('images/default_img.png');
                    $usertype = ($parentDetails['user_type_id'] == 1) ? 'Admin' : (($parentDetails['user_type_id'] == 2) ? 'Clinician' : 'Nurse');
                    
                    $msg                    =  $parentDetails['name'].' has declined the invitation <span class="badge bg-info">'. $usertype.'</span> ';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                     
                    $returnArray['toRedirect'] = url('users/list/pending');
                }
            break;

            case 3: 
                // Apoointmnet create -doctor
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                $userDetails = $this->getUserDetails($parentDetails['created_by']);
                if(empty($userDetails )){
                    $userDetails = $this->Corefunctions->convertToArray(Patient::with('user')->where('id', $parentDetails['created_by'])->where('clinic_id',session()->get('user.clinicID'))->whereNull('deleted_at')->first()); 
                }
                $userImage = ($userDetails['profile_image'] != '') ? $userDetails['profile_image'] : asset('images/default_img.png');
                $patientDetails = $this->Corefunctions->convertToArray(Patient::with('user')->where('user_id', $parentDetails['patient_id'])->withTrashed()->first());
                
                $msg                    =  isset($patientDetails['user']['first_name']) ? 'An appointment has been scheduled with '.$patientDetails['user']['first_name'].' on ' .$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"F j, Y").' at '.$this->Corefunctions->timezoneChange($parentDetails['appointment_time'],"g:i A") : '' ;
                $returnArray['message'] = $msg;
                $returnArray['userImg'] = $userImage ;                          
                $returnArray['toRedirect'] =  url('appointment/'.$parentDetails['appointment_uuid'].'/details') ;
            break;

            case 4: 
                // Apoointmnet create -Cancel
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                if (!empty($parentDetails)) {
                    $userDetails = $this->getUserDetails($parentDetails['cancelled_by']);
                    if($parentDetails['cancelled_by_type'] == 'u'){
                        $clinicUserDets = ClinicUser::where('user_id',$parentDetails['cancelled_by'])->withTrashed()->first();
                    }else{
                        $clinicUserDets = Patient::where('user_id',$parentDetails['cancelled_by'])->withTrashed()->first();
                    }
                    $userImage = ($userDetails['profile_image'] != '') ? $userDetails['profile_image'] : asset('images/default_img.png');
                    if(!empty($clinicUserDets)){
                        if($parentDetails['cancelled_by_type'] == 'u' && $clinicUserDets->user_type_id != '3'){
                            $username = $this->Corefunctions -> showClinicanName($clinicUserDets);
                        }else{
                            $username = $userDetails['first_name'].' '. $userDetails['last_name'];
                        }
                    
                        $msg                    = $username. ' has been cancelled the appointment for ' .$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"M d, Y") .' ';
                        $returnArray['message'] = $msg;
                        $returnArray['userImg'] = $userImage ;                        
                        $returnArray['toRedirect'] =  url('appointments?status=cancelled') ;
                    }
                }
            break;

            case 5: 
                // Payment reminder
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                if (!empty($parentDetails) ) {
                    $userDetails = $this->getUserDetails($parentDetails['created_by']);
                    $userImage = ($userDetails['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['profile_image']) : asset('images/default_img.png');

                    $msg                    = 'Your appointment is scheduled on '.$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"M d, Y").'. Please make sure to complete payment before the due.';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;
                    $returnArray['toRedirect'] =  url('appointments');
                }
            break;
            case 6: 
                // Apoointmnet nurse -doctor
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                if (!empty($parentDetails) && $parentDetails['created_by'] != session()->get('user.userID') ) {
                    $userDetails = $this->Corefunctions->convertToArray(ClinicUser::getUserByUserId($parentDetails['created_by'],session()->get('user.clinicID')));
                    if(empty($userDetails )){
                        $userDetails = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($parentDetails['created_by'],session()->get('user.clinicID')));
                    }
                    $patientDetails = $this->Corefunctions->convertToArray(User::getUserById($parentDetails['patient_id'])); 
                    $userImage =  !empty($userDetails) && isset($userDetails['user']['profile_image']) && ($userDetails['user']['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['user']['profile_image']) : ( isset($userDetails['logo_path']) && ($userDetails['logo_path'] !='') ? $this->Corefunctions->getAWSFilePath($userDetails['logo_path']) : asset('images/default_img.png') );
                    
                    $msg                    =  'An appointment has been scheduled with '.$patientDetails['first_name'].' on ' .$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"F j, Y").' at '.$this->Corefunctions->timezoneChange($parentDetails['appointment_time'],"g:i A") ;
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;  
                    $returnArray['toRedirect'] =  url('appointment/'.$parentDetails['appointment_uuid'].'/details') ;
                }
            break;
            case 7: 
                // Apoointmnet create -doctor
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                if (!empty($parentDetails)  ) {
                    $userDetails = $this->Corefunctions->convertToArray(ClinicUser::getUserByUserId($parentDetails['created_by'],session()->get('user.clinicID')));
                    if(empty($userDetails )){
                        $userDetails = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($parentDetails['created_by'],session()->get('user.clinicID'))); 
                    }
                    $userImage =  !empty($userDetails) && isset($userDetails['user']['profile_image']) && ($userDetails['user']['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['user']['profile_image']) : asset('images/default_img.png');

                    $msg                    =  'Appointment Scheduled on' .$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"M d, Y") ;
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                        
                    $returnArray['toRedirect'] =  url('appointment/'.$parentDetails['appointment_uuid'].'/details') ;
                }
            break;

            case 9: 
                // patient accept 
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Patient::getPatientDetsById($parentID)); 
                if (!empty($parentDetails)) {
                    $userImage =  !empty($parentDetails) && isset($parentDetails['user']['profile_image']) && ($parentDetails['user']['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($parentDetails['user']['profile_image']) : ( isset($parentDetails['logo_path']) && ($parentDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($parentDetails['logo_path']) : asset('images/default_img.png'));
                    
                    $msg                    =  $parentDetails['first_name'].' has accepted the invitation <span class="badge bg-info">Patient</span>';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;     
                    $returnArray['toRedirect'] =  url('patient/'.$parentDetails['patients_uuid'].'/details');
                }
                break;

                case 10: 
                //  decline patient
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Patient::getPatientDetsById($parentID)); 
                if (!empty($parentDetails)) {
                    $userImage =  !empty($parentDetails) && isset($parentDetails['user']['profile_image']) && ($parentDetails['user']['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($parentDetails['user']['profile_image']) : ( isset($parentDetails['logo_path']) && ($parentDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($parentDetails['logo_path']) : asset('images/default_img.png'));

                    $msg                    =  $parentDetails['first_name'].' has declined the invitation <span class="badge bg-info">Patient</span>';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage;                  
                    $returnArray['toRedirect'] = url('patient/'.$parentDetails['patients_uuid'].'/details'); 
                }
                break;

            case 11: 
                // Apoointmnet waiting in room
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                if (!empty($parentDetails)  ) {
                    $userDetails = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($parentDetails['patient_id'],session()->get('user.clinicID'))); 
                    $userImage =  !empty($userDetails) && isset($userDetails['user']['profile_image']) && ($userDetails['user']['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['user']['profile_image']) : asset('images/default_img.png');

                    $msg                    =   $userDetails['user']['first_name'].' is waiting in reception room to join appoinment';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                        
                    $returnArray['toRedirect'] =  url('meet/'.$parentDetails['appointment_uuid']) ;
                }
            break;

            case 12: 
                // Appointmnet complete
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                if (!empty($parentDetails)) {
                    $userDetails = $this->getUserDetails($parentDetails['created_by']);
                    $clinicUserDets = ClinicUser::getClinicUser($parentDetails['created_by'],session()->get('user.clinicID'));
                    $userImage =  !empty($userDetails) && isset($userDetails['profile_image']) && ($userDetails['profile_image'] != '') ? $userDetails['profile_image'] : asset('images/default_img.png');
                    if($clinicUserDets->user_type_id != '3'){
                        $username = $this->Corefunctions -> showClinicanName($clinicUserDets);
                    }else{
                        $username = $userDetails['first_name'].' '. $userDetails['last_name'];
                    }

                    $msg                    = $username. ' has been completed the appointment for ' .$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"M d, Y") .' ';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;  
                    $returnArray['toRedirect'] =  url('appointment/'.$parentDetails['appointment_uuid'].'/details') ;                      
                  
                }
            break;

            case 13: 
                // Subscription Expiry
                $parentDetails = $this->Corefunctions->convertToArray(Subscription::getSubscriptionById($parentID));
                if (!empty($parentDetails)) {
                    $userImage = asset('images/default_img.png');

                    $msg                    = 'Your trial ends on '.$this->Corefunctions->timezoneChange($parentDetails['end_date'],"M d, Y").'. Add a payment method within the next 2 days to avoid account lockout.';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                        
                    $returnArray['toRedirect'] =  url('appointments') ;
                        
                }
            break;

            case 14: 
                // Subscription Expiry
                $parentDetails = $this->Corefunctions->convertToArray(Subscription::getSubscriptionById($parentID));
                if (!empty($parentDetails)) {
                    $userImage = asset('images/default_img.png');

                    $msg                    = 'Your subscription is expiring on '.$this->Corefunctions->timezoneChange($parentDetails['end_date'],"M d, Y").'. Add a payment method now to avoid service disruption.';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                        
                    $returnArray['toRedirect'] =  url('appointments') ;
                }
                
            break;

            case 15: 
                // Account Locked
                $userImage = asset('images/default_img.png');

                $msg                    = 'Your account is locked due to missing payment details. Add a payment method to reactivate your account.';
                $returnArray['message'] = $msg;
                $returnArray['userImg'] = $userImage ;                        
                $returnArray['toRedirect'] =  url('appointments');
            break;

            case 16: 
                // Subscription Renewed Successfully
                $parentDetails = $this->Corefunctions->convertToArray(Subscription::getSubscriptionById($parentID));
                if (!empty($parentDetails)) {
                    $userImage = asset('images/default_img.png');

                    $msg                    = 'Payment successful! Your subscription is active until '.$this->Corefunctions->timezoneChange($parentDetails['end_date'],"M d, Y").'.';
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                        
                    $returnArray['toRedirect'] =  url('appointments') ;    
                }
            break;

            case 17: 
                // Subscription Renewed Successfully
                $parentDetails = $this->Corefunctions->convertToArray(MedicalNote::notesDetailsByID($parentID));
                if (!empty($parentDetails)) {

                    $userDetails = $this->getUserDetails($parentDetails['created_by']);
                    $clinicUserDets = ClinicUser::getClinicUser($parentDetails['created_by'],session()->get('user.clinicID'));
                    $userImage =  !empty($userDetails) && isset($userDetails['profile_image']) && ($userDetails['profile_image'] != '') ? $userDetails['profile_image'] : asset('images/default_img.png');
                    if($clinicUserDets->user_type_id != '3'){
                        $username = $this->Corefunctions -> showClinicanName($clinicUserDets);
                    }else{
                        $username = $userDetails['first_name'].' '. $userDetails['last_name'];
                    }

                   

                    $msg                    = 'A new soap note added by '.$username;
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                        
                    $returnArray['toRedirect'] =  url('notes') ;    
                }
            break;

            case 19: 
                // Apoointmnet nurse -doctor
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                if (!empty($parentDetails) && $parentDetails['created_by'] != session()->get('user.userID') ) {
                    $userDetails = $this->Corefunctions->convertToArray(ClinicUser::getUserByUserId($parentDetails['created_by'],session()->get('user.clinicID')));
                    if(empty($userDetails )){
                        $userDetails = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($parentDetails['created_by'],session()->get('user.clinicID')));
                    }
                    $patientDetails = $this->Corefunctions->convertToArray(User::getUserById($parentDetails['patient_id'])); 
                    $userImage =  !empty($userDetails) && isset($userDetails['user']['profile_image']) && ($userDetails['user']['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['user']['profile_image']) : ( isset($userDetails['logo_path']) && ($userDetails['logo_path'] !='') ? $this->Corefunctions->getAWSFilePath($userDetails['logo_path']) : asset('images/default_img.png') );
                    
                    $msg                    =  'Your appointment has been rescheduled with '.$patientDetails['first_name'].' on ' .$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"F j, Y").' at '.$this->Corefunctions->timezoneChange($parentDetails['appointment_time'],"g:i A") ;
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;  
                    $returnArray['toRedirect'] =  url('appointment/'.$parentDetails['appointment_uuid'].'/details') ;
                }
            break;

            case 18: 
                // Apoointmnet create -doctor
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                if (!empty($parentDetails)  ) {
                    $userDetails = $this->Corefunctions->convertToArray(ClinicUser::getUserByUserId($parentDetails['created_by'],session()->get('user.clinicID')));
                    if(empty($userDetails )){
                        $userDetails = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($parentDetails['created_by'],session()->get('user.clinicID'))); 
                    }
                    $userImage =  !empty($userDetails) && isset($userDetails['user']['profile_image']) && ($userDetails['user']['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDetails['user']['profile_image']) : asset('images/default_img.png');

                    $msg                    =  'Your appointment has been rescheduled on' .$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"M d, Y") ;
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                        
                    $returnArray['toRedirect'] =  url('appointment/'.$parentDetails['appointment_uuid'].'/details') ;
                }
            break;

            case 20: 
                // Apoointmnet create -doctor
                /* Fetch team user details */
                $parentDetails = $this->Corefunctions->convertToArray(Appointment::appointmentByID($parentID));
                $userDetails = $this->getUserDetails($parentDetails['created_by']);
                if(empty($userDetails )){
                    $userDetails = $this->Corefunctions->convertToArray(Patient::with('user')->where('id', $parentDetails['created_by'])->where('clinic_id',session()->get('user.clinicID'))->whereNull('deleted_at')->first()); 
                }
                $userImage = ($userDetails['profile_image'] != '') ? $userDetails['profile_image'] : asset('images/default_img.png');
                $patientDetails = $this->Corefunctions->convertToArray(Patient::with('user')->where('user_id', $parentDetails['patient_id'])->withTrashed()->first());
                
                $msg                    =  isset($patientDetails['user']['first_name']) ? 'your appointment has been rescheduled with '.$patientDetails['user']['first_name'].' on ' .$this->Corefunctions->timezoneChange($parentDetails['appointment_date'],"F j, Y").' at '.$this->Corefunctions->timezoneChange($parentDetails['appointment_time'],"g:i A") : '' ;
                $returnArray['message'] = $msg;
                $returnArray['userImg'] = $userImage ;                          
                $returnArray['toRedirect'] =  url('appointment/'.$parentDetails['appointment_uuid'].'/details') ;
            break;  
            case 21: 
                // Device Ordered to patient
                $parentDetails = $this->Corefunctions->convertToArray(RpmOrders::rpmOrderByID($parentID));
                if( !empty($parentDetails)){
                    $msg                    =  "Your medical device(".$parentDetails['order_code'].") has been ordered." ;
                    $userImage              = asset('images/default_img.png');
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                          
                    $returnArray['toRedirect'] =  url('myaccounts') ;
                }
            break;  
            case 22: 
                // Device Ordered to patient
                $parentDetails = $this->Corefunctions->convertToArray(RpmOrders::rpmOrderByID($parentID));
                if( !empty($parentDetails)){
                    $userDetails = $this->getUserDetails($parentDetails['user_id']);
                    $userImage = ($userDetails['profile_image'] != '') ? $userDetails['profile_image'] : asset('images/default_img.png');
                    $statusTxt              = ( $parentDetails['status'] == '3') ? 'rejected' : 'accepted';
                    $msg                    =  "Medical device(".$parentDetails['order_code'].") has been ".$statusTxt." by ".$userDetails['first_name'].' '.$userDetails['last_name'].".";
                    $userImage              = asset('images/default_img.png');
                    $returnArray['message'] = $msg;
                    $returnArray['userImg'] = $userImage ;                          
                    $returnArray['toRedirect'] =  url('myaccounts') ;
                }
                
            break;
                    
            default:
            $returnArray;
        }
        return $returnArray;
    }

    public function clearAll(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            
            Notification::clearNotifications(session()->get('user.userID'), session()->get('user.clinicID'));

            $arr['success'] = 1;
            $arr['message'] = 'Notifications cleared successfully';
            return response()->json($arr);
            exit();
        }
    }
   

    public function markAsRead(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $key = $data['notification_key'];

            Notification::markAsRead($key);

            $notifications = Notification::notificationByKey($key);
            $notifications = $this->Corefunctions->convertToArray($notifications);
            
            $redirectUrl =$this->getNotificationMessage($notifications['notification_type_id'],$notifications['parent_id'],$notifications['user_id']);
            $arr['success'] = 1;
            $arr['redirectUrl'] = $redirectUrl['toRedirect'];
            return response()->json($arr);
            exit();
        }
    }

   

}
