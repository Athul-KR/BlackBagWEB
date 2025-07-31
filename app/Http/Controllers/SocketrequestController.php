<?php
namespace App\Http\Controllers;
use DB;
use Carbon;

use App\Models\User;
use App\Models\VideoCall;
use App\Models\Chats;
use App\Models\Appointment;
use App\Models\VideoCallParticipant;
use App\Models\Patient;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\customclasses\Corefunctions;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use App\Models\UserConnection;
use Illuminate\Support\Facades\Session; // Import Session facade

class SocketrequestController extends Controller{
    
    public function __construct(Request $request){
        $this->Corefunctions = new \App\customclasses\Corefunctions;
    }
    
   
    public function handleWSSEvent(){
        
        $jsonData = file_get_contents('php://input');
        $input    = json_decode($jsonData, true); // fecth data
        
        DB::table('socket_requests')->insertGetId(array(
            'request_data' => $jsonData,
            'server_info' => json_encode($_SERVER),
            'created_at' => Carbon\Carbon::now()
        ));
        
        
        $connectionID       = (!empty($input) && isset($input['connectionId'])) ? $input['connectionId'] : '';
        $action             = (isset($input['payload']['data']['event'])) ? $input['payload']['data']['event']: '';
        $eventType             = (isset($input['eventType'])) ? $input['eventType']: '';
        $participantKey             = (isset($input['payload']['data']['participant_uuid'])) ? $input['payload']['data']['participant_uuid']: '';
        $roomKey             = (isset($input['payload']['data']['roomkey'])) ? $input['payload']['data']['roomkey']: '1';
        $clinicID             = (isset($input['payload']['data']['clinic_id'])) ? $input['payload']['data']['clinic_id']: '';
       
        if($eventType == 'disconnected'){
            User::disconnectConnection($connectionID);
        }
        switch ($action) {
            case 'connect':
                
                 $userSessions =User::getUserSessionID($participantKey);
                 
                 User::insertUserConnection($userSessions->user_id,$connectionID,$userSessions->id);
                 
                break;
           case 'changeclinic':
                
                 $userSessions =User::getUserSessionID($participantKey);
                 $query = DB::table('user_connections')->select('connection_id')->where('user_id', $userSessions->user_id)->where('user_session_id', $userSessions->id);
                 $peerConnectionDetails = $query->where('status', '1')->get();
                 $peerConnectionDetails = $this->Corefunctions->convertToArray($peerConnectionDetails);
                 $connectionIDS         = $this->Corefunctions->getIDSfromArray($peerConnectionDetails, 'connection_id');
                 $connectionIds = array_values($connectionIDS);
                 if (!empty($connectionIDS)) {
                    
                    $payloadData = array(
                        "action" => "receiveandsend",
                        "data" => array(
                            "event" => 'changeclinic',
                             "clinic_id" => $clinicID,
                             "connectionIDS" => $connectionIds,
                            "participantKey" => $participantKey
                        )
                    );
                    
                    
                    $this->brodcastMessages($payloadData);
                } 
                
                 
                break;
            case 'waitingroom':
                $peerConnectionDetails = $this->getPeerConnections($roomKey );
                
               // print_r($peerConnectionDetails);die;
                $connectionIDS         = $peerConnectionDetails['connectionIDS'];
                $message               = $peerConnectionDetails['message'];
                $messageuser               = $peerConnectionDetails['messageuser'];
                $aptkey               = $peerConnectionDetails['appointment_key'];
                $messageprofileimage               = $peerConnectionDetails['messageprofileimage'];
              

                $connectionIds = array_values($connectionIDS);
                
                if (!empty($connectionIDS)) {
                    
                    $payloadData = array(
                        "action" => "receiveandsend",
                        "data" => array(
                            "event" => 'waitingroom',
                            "message" => $message,
                            "messageuser" => $messageuser,
                            "messageprofileimage" => $messageprofileimage,
                             "connectionIDS" => $connectionIds,
                            "participantKey" => $participantKey,
                            "roomKey" => $roomKey,
                            "aptkey" => $aptkey
                        )
                    );
                    
                    
                    $this->brodcastMessages($payloadData);
                } 
            break;
            case 'acceptcallrequest':
                
                 
                $videoCallDetails = VideoCall::videoCallByKey($roomKey);
                
                $videoCallDetails = $this->Corefunctions->convertToArray($videoCallDetails);
                 
                $videoCallParticipantDetails = VideoCallParticipant::getWaitingParticipant($videoCallDetails['id']);
            
                $query = DB::table('user_connections')->select('connection_id')->where('user_id', $videoCallParticipantDetails->participant_id);
                $peerConnectionDetails = $query->where('status', '1')->get();
                $peerConnectionDetails = $this->Corefunctions->convertToArray($peerConnectionDetails);
                $connectionIDS         = $this->Corefunctions->getIDSfromArray($peerConnectionDetails, 'connection_id');
        
               
                    $payloadData = array(
                        "action" => "receiveandsend",
                        "data" => array(
                            "event" => 'acceptcallrequest',
                            "connectionIDS" => $connectionIDS,
                            "participantKey" => $participantKey,
                            "roomKey" => $roomKey,
                        )
                    );
                    
                    
                    $this->brodcastMessages($payloadData);
                break;
            case 'rejectcallrequest':
                
                 
                $videoCallDetails = VideoCall::videoCallByKey($roomKey);
                
                $videoCallDetails = $this->Corefunctions->convertToArray($videoCallDetails);
                 
                $videoCallParticipantDetails = VideoCallParticipant::getWaitingParticipant($videoCallDetails['id']);
            
                $query = DB::table('user_connections')->select('connection_id')->where('user_id', $videoCallParticipantDetails->participant_id);
                $peerConnectionDetails = $query->where('status', '1')->get();
                $peerConnectionDetails = $this->Corefunctions->convertToArray($peerConnectionDetails);
                $connectionIDS         = $this->Corefunctions->getIDSfromArray($peerConnectionDetails, 'connection_id');
        
               
                    $payloadData = array(
                        "action" => "receiveandsend",
                        "data" => array(
                            "event" => 'rejectcallrequest',
                            "connectionIDS" => $connectionIDS,
                            "participantKey" => $participantKey,
                            "roomKey" => $roomKey,
                        )
                    );
                    
                    
                    $this->brodcastMessages($payloadData);
                break;    
            case 'chat':
                $userIDS = array();
                $participant      = Chats::chatParticipantByUUId($participantKey);
                if( !empty($participant)){
                    $allParticipants      = Chats::getAllChatParticipants($participant['chat_id']);
                    $userIDS              = $this->Corefunctions->getIDSfromArray($allParticipants, 'user_id');
                }
                $connectionIDS = array();
                 if( !empty($userIDS)){
                     $query = DB::table('user_connections')->select('connection_id')->whereIn('user_id', $userIDS);
                     $peerConnectionDetails = $query->where('status', '1')->get();
                     $peerConnectionDetails = $this->Corefunctions->convertToArray($peerConnectionDetails);
                     $connectionIDS         = $this->Corefunctions->getIDSfromArray($peerConnectionDetails, 'connection_id');
        
                 }
                if( !empty($connectionIDS)){
                    $payloadData = array(
                        "action" => "receiveandsend",
                        "data" => array(
                            "event" => 'chat',
                            "connectionIDS" => $connectionIDS,
                            "participantKey" => $participantKey,
                        )
                    );
                    
                    
                    $this->brodcastMessages($payloadData);
                }
            
                
               
                    
                break;
            case 'disconnected':
                
                break;
            default:
                break;
        }
        

        //return ;
        
        
        $arr['success'] = 1;
        return response()->json($arr);
        exit();
    
        
    }
     
     public function getPeerConnections($roomKey){


        if (!$roomKey) {
            return;
        }
        
        $videoCallDetails = VideoCall::videoCallByKey($roomKey);
        $videoCallDetails = $this->Corefunctions->convertToArray($videoCallDetails);
         
      // print_r($videoCallDetails);die;
        if (empty($videoCallDetails)) {
            return;
        }
       
        $appoinmentDetails = Appointment::appointmentByID($videoCallDetails['appointment_id']);
        $appoinmentDetails = $this->Corefunctions->convertToArray($appoinmentDetails);
        
        $clinicAdminuser = DB::table('clinic_users')->where('user_type_id', '1')->where('clinic_id',$appoinmentDetails['clinic_id'])->where('status', '1')->get();
         
        $userIDS = $this->Corefunctions->getIDSfromArray($clinicAdminuser, 'user_id');
         if(empty($userIDS)){
             $userIDS =  array();
         }  
        array_push($userIDS,$appoinmentDetails['consultant_id'],$appoinmentDetails['nurse_id']);
        
        $query = DB::table('user_connections')->select('connection_id')->whereIn('user_id', $userIDS);
        $peerConnectionDetails = $query->where('status', '1')->orderBy('id','desc')->whereNull('deleted_at')->get();
         
         
        $peerConnectionDetails = $this->Corefunctions->convertToArray($peerConnectionDetails);
        $connectionIDS         = $this->Corefunctions->getIDSfromArray($peerConnectionDetails, 'connection_id');
         
        $videoCallParticipantDetails = VideoCallParticipant::getFirstWaitingParticipant($videoCallDetails['id']);
        
        $message = $messageuser = '';
        
        if(!empty($videoCallDetails)){
            $userDetails = Patient::patientByUser($videoCallParticipantDetails->participant_id);
             //print_r($userDetails);die;
            $message = ' is waiting for the call.';
            $messageuser = $userDetails->user->first_name;
            $messageProfileImage = ($userDetails->user->profile_image != '') ? $this->Corefunctions-> resizeImageAWS($userDetails->user->id,$userDetails->user->profile_image,$userDetails->user->first_name,180,180,'1') : asset('images/default_img.png');
          
        }
             
        $finalDataArray = array(
            'connectionIDS' => $connectionIDS,
            'message' => $message,
            'messageuser' => $messageuser,
            'messageprofileimage' => $messageProfileImage,
            'clinic_id' => $appoinmentDetails['clinic_id'],
            'appointment_key' => $appoinmentDetails['appointment_uuid']
        );

          
        return $finalDataArray;
        
        
    }
   
     public function brodcastMessages($payloadData){
        
        // Convert data to JSON format
        $postData = json_encode($payloadData);
        
        // API endpoint
        $url = env('RESPONSE_SOCKET_END_POINT');
        
        // Initialize curl session
        $curl = curl_init($url);
        
        // Set the CURLOPT_RETURNTRANSFER option to true to return the transfer as a string
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        // Set the CURLOPT_POST option to true for a POST request
        curl_setopt($curl, CURLOPT_POST, true);
        
        // Set the request data as the POST field
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        
        // Set the Content-Type header to application/json
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        
        // Execute the request and get the response
        $response = curl_exec($curl);
 DB::table('socket_requests')->insertGetId(array(
            'request_data' => $postData,
            'server_info' => json_encode($_SERVER),
            'created_at' => Carbon\Carbon::now()
        ));
        
     //print_r($response);die;
        
        // Close curl session
        curl_close($curl);


        
    }
    
    
    
} 