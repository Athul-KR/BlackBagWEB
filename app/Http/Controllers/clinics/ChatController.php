<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Patient;
use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\RefCountryCode;
use App\Models\Chats;

use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use File;

class ChatController extends Controller
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
             if(!$sessionCeck){
                return Redirect::to('/logout');
            }
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
            return $next($request);
        });
    }
    
   
    /*Clinic Chat Details   */
    public function chatDetails(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
           
            $key = $data['key'];
            $loadmore = ( isset($data['loadmore']) && $data['loadmore'] == '1') ? '1': '';
            /** get patient Details */
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUUID($key));
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Invalid User');
            }
            if($patientDetails['clinic_id'] != session()->get('user.clinicID')){
                 return $this->Corefunctions->returnError('Invalid Clinic');
            }
            $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::userByUUID(session()->get('user.clinicuser_uuid')));
            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid Clinic User');
            }
            $patientDetails['logo_path']        = (isset($patientDetails['user'])) ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'],$patientDetails['user']['profile_image'],$patientDetails['user']['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patientDetails['id'],$patientDetails['logo_path'],$patientDetails['first_name'],180,180,'2');
            $patientDetails['name']             = (isset($patientDetails['user'])) ? $patientDetails['user']['first_name'].' '.$patientDetails['user']['last_name'] : $patientDetails['first_name'].' '.$patientDetails['last_name'] ;
            $patientDetails['age']              = $this->Corefunctions->calculateAge($patientDetails['dob']);
            
            
            /* Chat Details */
            $chatInfo  = array();
            $chatInfo['from_clinic_user_id'] = $clinicUserDetails['id'];
            $chatInfo['from_user_id']        = $clinicUserDetails['user_id'];
            $chatInfo['to_patient_id']       = $patientDetails['id'];
            $chatInfo['to_user_id']          = $patientDetails['user_id'];
            $chatInfo['clinic_id']           = Session::get('user.clinicID');
            $chatInfo['chat_type_id']        = '1';
            $chat                           = Chats::getChat($chatInfo);
           
            $chatMessages       = $chatParticipant = array();
            $firstChatID        = ( isset($data['first_chat_id']) ) ? $data['first_chat_id'] : '';
            $allParticipants    =  Chats::getAllChatParticipants($chat['id']);
            $userIDS            = $this->Corefunctions->getIDSfromArray($allParticipants, 'user_id');
            $participantUsers    = User::userByIDS($userIDS);
            if(  !empty($chat) ){
                $participants                    = array();
                $participants['chat_id']         = $chat['id'];
                $participants['first_chat_id']   = $firstChatID;
                $participants['chat_type_id']    = '1';
                
                $chatMessages                    = Chats::getAllChatMessages($participants);
           
                $participantInfo                         = array();
                $participantInfo['chat_id']              = $chat['id'];
                $participantInfo['user_id']              = $chat['from_user_id'];
                $participantInfo['participant_id']       = $clinicUserDetails['id'];
                $participantInfo['participant_type_id']  = '1';
                $chatParticipant                    = Chats::getChatParticipant($participantInfo);
                
            }
          
            $today      = date('Y-m-d');
            $yesterday  = date('Y-m-d', strtotime('-1 day'));
            $finalChats = array();
            
            $patientIDS = $userIDS = $clientUserIDS = $chatMessageIDs = array();
            if( !empty($chatMessages) ){
                foreach( $chatMessages as $msk => $msv){
                    $userIDS[] = $msv['user_id'];
                    $chatMessageIDs[]        = $msv['id'];
                    $patientIDS[]        = $msv['participant_id'];
                    if( $msv['participant_type_id'] == '1'){
                        $clientUserIDS[] = $msv['participant_id'];
                    }
                     $original = $msv['message'];
                    
                    $cleaned = preg_replace_callback('/@\[(note:(\d+))\]/', function($matches) use ($participantUsers) {
                        $userId = (int)$matches[2];
                        if( isset($participantUsers[$userId])){
                             $name = $participantUsers[$userId]['first_name'].' '.$participantUsers[$userId]['last_name'];
                        }
                       
                        return "@[$name]";
                    }, $original);
                    
                    $chatMessages[$msk]['message'] = $cleaned;
                  
                }
            }
            
            $userDets       = User::userByIDS($userIDS);
            $clientUserDets = ClinicUser::clinicUserByIDS($clientUserIDS);
            $clientUserDets = $this->Corefunctions->getArrayIndexed1($clientUserDets,'id');
            $patientDets    = Patient::patientByIDS($patientIDS);
         
            $chatMessages = array_reverse($chatMessages);
            $firstChatID  = '';
            $hasLoadMore  = '';
              if( !empty($chatMessages)){
                  $firstChatID                      = $chatMessages[0]['id'];
                  $participants['is_count']         = '1';
                  $participants['first_chat_id']    = $firstChatID;
                  $remainingCount                   = Chats::getAllChatMessages($participants);
                  $hasLoadMore                      = ( $remainingCount > 1 ) ? '1' : '0';
               
              }
     
          
            
            $chatDocs = Chats::chatDocsByMessageIDs($chatMessageIDs);
            $chatDocs = $this->Corefunctions->getArrayIndexed1($chatDocs,'chat_message_id');

            
            if( !empty($chatMessages)){
                foreach ($chatMessages as $chat) {
                   
                    $user = ( isset( $userDets[$chat['user_id']] ) ) ? $userDets[$chat['user_id']] : array();
                    
                    if( !empty($user) ){
                        $userName = $profileImage = '';
                        if ( $chat['participant_type_id'] == '1' && isset( $clientUserDets[$chat['participant_id']] ) ) {
                            $clientUser =     $clientUserDets[$chat['participant_id']];
                            if( !empty($clientUser) ){
                                 $profileImage = $this->Corefunctions -> resizeImageAWS($user['id'],$user['profile_image'],$user['first_name'],180,180,'1');
                                 $userName     =$this->Corefunctions -> showClinicanNameUser($clientUser,'1');
                            }
                        }
                        if ( $chat['participant_type_id'] == '2' && isset( $patientDets[$chat['participant_id']] ) ) {
                            $patient  =  $patientDets[$chat['participant_id']];
                        
                            if( !empty($patient) ){
                                $userName        =  (isset($user)) ? $user['first_name'].' '.$user['last_name'] : $patient['first_name'].' '.$patient['last_name'];
                                $profileImage    = (isset($user)) ? $this->Corefunctions->resizeImageAWS($user['id'],$user['profile_image'],$user['first_name'],180,180,'1') : $this->Corefunctions->resizeImageAWS($patient['id'],$patient['logo_path'],$patient['first_name'].' '.$patient['last_name'],180,180,'2');
                            }
                        }
                        $hasDoc = '';
                        $docInfo = array();
                        if( !empty($chatDocs) && isset($chatDocs[$chat['id']] ) ){
                            $docDets = $chatDocs[$chat['id']];
                            $hasDoc  = '1';
                            $docInfo =  $this->Corefunctions ->chatDocumentImage($docDets);
                       
                        }
                        

                       $chat['hasDoc']        = $hasDoc;
                       $chat['docInfo']        = $docInfo;
                       $chat['name']          = $userName;
                       $chat['profile_image'] = $profileImage;
                       $chat['created_time'] = $this->Corefunctions->timezoneChange($chat['created_at'], "h:i A");


                        $createdDate = date('Y-m-d', strtotime($chat['created_at']));

                        if ($createdDate === $today) {
                            $finalChats['Today'][] = $chat;
                        } elseif ($createdDate === $yesterday) {
                            $finalChats['Yesterday'][] = $chat;
                        } else {
                            $finalChats[$createdDate][] = $chat; // group by actual date
                        }
                    }
                }
            }
          
           
            $data['chatParticipant']        = $chatParticipant;
            $data['patient_uuid']           = $patientDetails['patients_uuid'];
            $data['session_userid']         = $clinicUserDetails['user_id'];
            $data['finalChats']             = $finalChats;
            $data['chatMessages']           = $chatMessages;
            $data['patientDetails']         = $patientDetails;
            if( $loadmore == 1){
                  $html                           = view('chats.chatmessages', $data);
            }else{
                  $html                           = view('chats.details', $data);
            }
          
            $arr['view']                    = $html->__toString(); 
            $arr['hasLoadMore']            = $hasLoadMore;
            $arr['firstChatID']            = $firstChatID;



            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    
    
       /*Clinic Add Chat Details   */
    public function addChat(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $patientUuid = $data['patient_uuid'];
             parse_str($data['formData'], $input);

            /** get patient Details */
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUUID($patientUuid));
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Invalid User');
            }
            if($patientDetails['clinic_id'] != session()->get('user.clinicID')){
                 return $this->Corefunctions->returnError('Invalid Clinic');
            }
            $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::userByUUID(session()->get('user.clinicuser_uuid')));
            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid Clinic User');
            }
            $chatInfo  = array();
            $chatInfo['from_clinic_user_id'] = $clinicUserDetails['id'];
            $chatInfo['from_user_id']        = $clinicUserDetails['user_id'];
            $chatInfo['to_patient_id']       = $patientDetails['id'];
            $chatInfo['to_user_id']          = $patientDetails['user_id'];
            $chatInfo['clinic_id']           = Session::get('user.clinicID');
            $chatInfo['chat_type_id']        = '1';
            $chat                            = Chats::getChat($chatInfo);
            $chatParticipant                 = array();
            $chatID                          = $chat['id'];
            if( !empty($chat)){
                if( isset($data['mentionIds']) && !empty($data['mentionIds'])){
                    $participantIDS = $data['mentionIds'];
                    $participants =  Chats::getAllChatParticipants($chat['id']);
                    $dbUserIDS = $this->Corefunctions->getIDSfromArray($participants, 'user_id');
                    $formUserIDS = $data['mentionIds'];
                    $toInsert       = array_diff($formUserIDS,$dbUserIDS);
                    if( !empty($toInsert)){
                        $clinicUsers = $this->Corefunctions->convertToArray(ClinicUser::getClinicUserByUserIDNew($toInsert,Session::get('user.clinicID')));
                        $clinicUsers = $this->Corefunctions->getArrayIndexed1($clinicUsers,'user_id');
                       
                        foreach( $toInsert as $tn){
                            $dataInfo = array();
                            $dataInfo['chat_id'] = $chatID;
                            $dataInfo['user_id'] = $tn;
                            $dataInfo['participant_id'] = ( !empty($clinicUsers) && isset($clinicUsers[$tn]) ) ? $clinicUsers[$tn]['id'] : '';
                            $dataInfo['participant_type_id'] = '1';
                            $chatParticipantID = Chats::addChatParticipant($dataInfo);
                        }
                    }

                }
            }
            
            /* Check in Chat Participants, if not entered. Then added it in chat participantts */
            $participantInfo                      = array();
            $participantInfo['chat_id']           = $chat['id'];
            $participantInfo['user_id']           = $clinicUserDetails['user_id'];
            $participantInfo['participant_id']       = $clinicUserDetails['id'];
            $participantInfo['participant_type_id']  = '1';
            if(  !empty($chat) ){
                $chatParticipant                    = Chats::getChatParticipant($participantInfo);
                if( !empty($chatParticipant) ){
                    $chatParticipantID              = $chatParticipant['id'];
                }
            }
            if( empty($chatParticipant)){
               $chatParticipantID = Chats::addChatParticipant($participantInfo);
            }
            $docPath = NULL;
           
            
            
            /* Add In Message Table */
            $messageInfo = array();
            $messageInfo['chat_id']              = $chat['id'];
            $messageInfo['chat_participant_id']  = $chatParticipantID;
            $messageInfo['message']              = $data['message'];
            $chatMsgID = Chats::addChatMessages($messageInfo);
            
             if( isset($input['chatdoc']) && $input['chatdoc'] != ''){
                $finalResponse = $this->uploadChatDocs($input,$chat['id'],$chatParticipantID,$chatMsgID,$patientDetails['user_id']);
                $docPath       = ( !empty($finalResponse) && isset($finalResponse['isSuccess']) ) ? $finalResponse['crppath'] : '';
            }
            
            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
  
    public function uploadDocument(){
        if (request()->ajax()) {
            $data = request()->all();

            if (!$data) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            ;
            $fileName = basename($_FILES['upload']['name']);

                /** Insert to temp doc table  */
            $docKey        = $this->Corefunctions->generateUniqueKey('10', 'temp_docs', 'tempdoc_uuid');
            $ext           = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
            $fileSizeBytes = $_FILES['upload']['size'];
            $tempdocid     = Chats::insertTempDocs($docKey, $ext, $fileName,$fileSizeBytes);

            $docName    = $docKey . "." . $ext;
            $tempdocpath = TEMPDOCPATH . $docName;

            if (move_uploaded_file($_FILES['upload']['tmp_name'], $tempdocpath)) {
                
            } 

            $tempdocpath = $this->Corefunctions->getMyPath1($tempdocid, $docKey, $ext, TEMPDOCPATH);
            
            $temdocppath = url(TEMPDOCPATH . $docName);

            $arr['success']     = 1;
            $arr['tempkey']     = $docKey;
            $arr['docname']     = $fileName;
            $arr['tempdocpath'] = $temdocppath;
            $arr['tmpname']     = $docKey . '.' . $ext;
            $arr['ext']         = $ext;
            $arr['tempdocid']   = $tempdocid;

            return response()->json($arr);
            exit();
        }
    }
    function uploadChatDocs($input,$chatID,$chatParticipantID,$chatMsgID,$userID){
        $isSuccess = '0'; 
       $tempImageDetails = DB::table("temp_docs")->where("tempdoc_uuid", $input['chatdoc'])->first();
      if (!empty($tempImageDetails)) {
          
          $croppath     = TEMPDOCPATH . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
        
          $image_path = $tempImageDetails->tempdoc_uuid . '.' . $tempImageDetails->temp_doc_ext;
          $crppath    = 'chats/' . $tempImageDetails->tempdoc_uuid . '.' . $tempImageDetails->temp_doc_ext;
          $image_path = File::get($croppath);
          if ( $this->Corefunctions->uploadDocumenttoAWS($crppath, $image_path)) {
               $isSuccess = '1'; 
          }
          unlink($croppath);
          $chatDocID = Chats::addChatDocs($tempImageDetails,$chatID,$chatParticipantID,$crppath,$chatMsgID);
          $this->Corefunctions->uploadFileToFileCabinet($chatID,$chatDocID,$userID);
      }
        $response = array();
        $response['isSuccess'] = $isSuccess;
        $response['crppath']   = $crppath;
     return $response;
        
        
    }
     public function getMentions(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $searchTerm = isset($data['query']) ? trim($data['query']) : '';
            $results = Chats::getMentionedUsers($searchTerm,Session::get('user.clinicID'),session()->get('user.userID'));
            $userTypes =  User::getUserTypes();
            $userTypes = $this->Corefunctions->getArrayIndexed1($userTypes,'id');

            $finalArr = array();
            if( !empty($results)){
                foreach( $results as $rsk => $rs){
                    $finalArr[$rsk]['id'] = $rs['id'];
                    $finalArr[$rsk]['user_id'] = $rs['user_id'];
                    $finalArr[$rsk]['user_name'] = $userName = $rs['first_name']. ' '.$rs['last_name'];
                    $finalArr[$rsk]['user_type'] = $userType = ( isset($userTypes[$rs['user_type_id']])) ? $userTypes[$rs['user_type_id']]['user_type'] : '' ;
                    $finalArr[$rsk]['image']     = $image = $this->Corefunctions -> resizeImageAWS($rs['user_id'],$rs['profile_image'],$rs['first_name'],180,180,'1');
                  
                }
            }
          
            $arr['users']          = $finalArr;
            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    } 
    public function chatDocuments(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $key = $data['key'];
            /** get patient Details */
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUUID($key));
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Invalid User');
            }
            if($patientDetails['clinic_id'] != session()->get('user.clinicID')){
                 return $this->Corefunctions->returnError('Invalid Clinic');
            }
            $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::userByUUID(session()->get('user.clinicuser_uuid')));
            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid Clinic User');
            }
            
            
            
            /* Chat Details */
            $chatInfo  = array();
            $chatInfo['from_clinic_user_id'] = $clinicUserDetails['id'];
            $chatInfo['from_user_id']        = $clinicUserDetails['user_id'];
            $chatInfo['to_patient_id']       = $patientDetails['id'];
            $chatInfo['to_user_id']          = $patientDetails['user_id'];
            $chatInfo['clinic_id']           = Session::get('user.clinicID');
            $chatInfo['chat_type_id']        = '1';
            $chat                           = Chats::getChat($chatInfo);
           
            $chatDocs  = array();
            if( !empty($chat) ){
                $chatDocs = Chats::chatDocsByIDS($chat['id']);
            }
            if( !empty($chatDocs)){
                foreach( $chatDocs as $chk => $chv){
                   $showpath= $this->Corefunctions->chatDocumentImage($chv);
                    $chatDocs[$chk]['doc_path_toshow'] = $showpath;
                    $chatDocs[$chk]['created_time'] = $this->Corefunctions->timezoneChange($chv['created_at'], "h:i A");
                    
                }
            }
           
            $data['chatDocs'] = $chatDocs;
           
            $html                           = view('chats.documents', $data);
          
            $arr['view']                    = $html->__toString(); 
            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    
    
  
    
    
    
}
