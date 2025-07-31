<?php

namespace App\Http\Controllers\frontend;


use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Support\Str;
use Redirect;
use Session;
use App\Models\Chats;
use App\Models\Patient;
use App\customclasses\Corefunctions;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Validator;
use File;

class PatientChatController extends Controller
{

    public function __construct()
    {
        
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        if (Session::has('user') && session()->get('user.userType') != 'patient') {
            return Redirect::to('/dashboard');

        }
    }
    
     public function chats(){
        if (!Session::has('user')) {
            return redirect('/');
        }
         $userId            = session('user.userID');
         $clinicID          = Session::get('user.clinicID');
         $patientDetails    = Patient::getPatientsByUserId($userId, $clinicID);
         if( empty($patientDetails) ){
             return Redirect::to('/dashboard');
         }
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
        
         
        
         

        $seo['title'] = "Chats | " . env('APP_NAME');
        $seo['keywords'] = "Telemedicine for clinics, global partnerships, secure virtual care, clinic scheduling, remote healthcare, 24/7 support, digital solutions, and medical data security.";
        $seo['description'] = "Join our global clinic network to enhance patient care with telemedicine. Streamline operations, secure data, and offer seamless virtual care with 24/7 support.";
        $seo['og_title'] = "Chats | " . env('APP_NAME');
        $seo['og_description'] = "Join our global network of clinics to enhance patient care with telemedicine. Streamline operations, secure data, and offer seamless virtual care with 24/7 support.";
         
        $data['lastChats']   = $lastChats;
        $data['unreadChats'] = $unreadChats;
        $data['chats']       = $chats;
        $data['seo']         = $seo;
        return view('frontend.chats.listing', $data);
    }
    
    /*Patient Chat Details   */
    public function chatDetails(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $key = $data['key'];
            
           $userId            = session('user.userID');
           $clinicID          = Session::get('user.clinicID');
           $patientDetails    = Patient::getPatientsByUserId($userId, $clinicID);
           if( empty($patientDetails) ){
               return $this->Corefunctions->returnError('Inavlid patient');
           }
            
            $chat = Chats::chatByUUID($key);
            if( empty($chat)){
                 return $this->Corefunctions->returnError('Invalid chat');
            }
            $sessionUserID   = ( $chat['from_user_id'] == $userId  ) ? $chat['from_user_id'] : $chat['to_user_id'];
            if( $sessionUserID != $userId ){
                return $this->Corefunctions->returnError('You dont have access to this chat.');
            }
            $otherUserID       = ( $chat['from_user_id'] == $userId  ) ? $chat['to_user_id'] : $chat['from_user_id'];
            $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::getUserByUserId($otherUserID, $chat['clinic_id']));
            
            if( !empty($clinicUserDetails)){
                $clinicUserDetails['chat_image'] = $this->Corefunctions -> resizeImageAWS($clinicUserDetails['user']['id'],$clinicUserDetails['user']['profile_image'],$clinicUserDetails['user']['first_name'],180,180,'1');
                $clinicUserDetails['chat_name'] = $this->Corefunctions -> showClinicanNameUser($clinicUserDetails,'1');
            }
            
            
            $chatParticipant                    = Chats::getChatParticipantByChatID($chat['id'],$clinicUserDetails['user_id']);
            
            $speciality = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->where('id',$clinicUserDetails['specialty_id'])->first());
            
            $clinic = $this->Corefunctions->convertToArray(Clinic::selectedClinicByID( $chat['clinic_id'] ));
            $chatID = $chat['id'];
            $participants                    = array();
            $participants['chat_id']         = $chatID;
            $participants['chat_type_id']    = '1';
            $chatMessages                    = Chats::getAllChatMessages($participants);
            
            
                        
            
            
            $today      = date('Y-m-d');
            $yesterday  = date('Y-m-d', strtotime('-1 day'));
            $finalChats = array();
            
            $patientIDS = $userIDS = $clientUserIDS = array();
            
            $allParticipants    =  Chats::getAllChatParticipants($chatID);
            $userIDS            = $this->Corefunctions->getIDSfromArray($allParticipants, 'user_id');
            $participantUsers    = User::userByIDS($userIDS);
            
            if( !empty($chatMessages) ){
                foreach( $chatMessages as $msk => $msv){
                    $userIDS[] = $msv['user_id'];
                    $patientIDS[]        = $msv['participant_id'];
                    if( $msv['participant_type_id'] == '1'){
                        $clientUserIDS[] = $msv['participant_id'];
                    }
                     $chatMessageIDs[]        = $msv['id'];
                    
                    
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
          
            $chatMessages = array_reverse($chatMessages);
            
               $chatDocs = Chats::chatDocsByMessageIDs($chatMessageIDs);
            $chatDocs = $this->Corefunctions->getArrayIndexed1($chatDocs,'chat_message_id');
            
                if( !empty($chatMessages)){
                foreach ($chatMessages as $cht) {
                    
                    $user = ( isset( $userDets[$cht['user_id']] ) ) ? $userDets[$cht['user_id']] : array();
                    
                    if( !empty($user) ){
                        $userName = $profileImage = '';
                        if ( $cht['participant_type_id'] == '1' && isset( $clientUserDets[$cht['participant_id']] ) ) {
                            $clientUser =     $clientUserDets[$cht['participant_id']];
                            if( !empty($clientUser) ){
                                 $profileImage = $this->Corefunctions -> resizeImageAWS($user['id'],$user['profile_image'],$user['first_name'],180,180,'1');
                                 $userName     =$this->Corefunctions -> showClinicanNameUser($clientUser,'1');
                            }
                        }
                      
                        $hasDoc = '';
                        $docInfo = array();
                        if( !empty($chatDocs) && isset($chatDocs[$chat['id']] ) ){
                            $docDets = $chatDocs[$chat['id']];
                            $hasDoc  = '1';
                            $docInfo =  $this->Corefunctions ->chatDocumentImage($docDets);
                       
                        }
                       $chat['hasDoc']       = $hasDoc;
                       $chat['docInfo']      = $docInfo;
                       $cht['name']          = $userName;
                       $cht['profile_image'] = $profileImage;
                       $cht['created_time'] = $this->Corefunctions->timezoneChange($cht['created_at'], "h:i A");


                        $createdDate = date('Y-m-d', strtotime($cht['created_at']));

                        if ($createdDate === $today) {
                            $finalChats['Today'][] = $cht;
                        } elseif ($createdDate === $yesterday) {
                            $finalChats['Yesterday'][] = $cht;
                        } else {
                            $finalChats[$createdDate][] = $cht; // group by actual date
                        }
                    }
                }
            }
            
          

            $data = array();
            $data['chat']                   = $chat;
            $data['chatParticipant']        = $chatParticipant;
            $data['clinic_user_uuid']       = $clinicUserDetails['clinic_user_uuid'];
            $data['finalChats']             = $finalChats;
            $data['clinic']                 = $clinic;
            $data['speciality']             = $speciality;
            $data['clinicUserDetails']      = $clinicUserDetails;
            
            $html                           = view('frontend.chats.details', $data);
            $arr['view']                    = $html->__toString();   



            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    
         /*Patient Add Chat Details   */
    public function addChat(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $clinic_user_uuid = $data['clinic_user_uuid'];
             parse_str($data['formData'], $input);

            /** get patient Details */
            $userId            = session('user.userID');
            $clinicID          = Session::get('user.clinicID');
            $patientDetails    = $this->Corefunctions->convertToArray(Patient::getPatientsByUserId($userId, $clinicID));
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Invalid User');
            }
           $patientDetails = $patientDetails['patientDetails']['0'];
            $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::userByUUID($clinic_user_uuid));
            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid Clinic User');
            }
            
            $chatInfo  = array();
            $chatInfo['from_parent_id']      = $patientDetails['id'];
            $chatInfo['from_user_id']        = $patientDetails['user_id'];
            $chatInfo['to_parent_id']        = $clinicUserDetails['id'];
            $chatInfo['to_user_id']          = $clinicUserDetails['user_id'];
            $chatInfo['from_parent_type']    = 'p';
            $chatInfo['to_parent_type']      = 'c';
            
            $chatInfo['clinic_id']           = Session::get('user.clinicID');
            $chatInfo['chat_type_id']        = '1';
            $chat                            = Chats::getChat($chatInfo);
            if( empty($chat)){
                Chats::addChat($chatInfo);
            }
            $chat                            = Chats::getChat($chatInfo);
            $chatID = $chat['id'];
              if( isset($data['mentionIds']) && !empty($data['mentionIds'])){
                $participantIDS = $data['mentionIds'];
                $participants =  Chats::getAllChatParticipants($chat['id']);
                $dbUserIDS = $this->Corefunctions->getIDSfromArray($participants, 'user_id');
                $formUserIDS = $data['mentionIds'];
                $toInsert       = array_diff($formUserIDS,$dbUserIDS);
                if( !empty($toInsert)){
                    $clinicUsers = $this->Corefunctions->convertToArray(ClinicUser::getClinicUserByUserIDNew($toInsert,$chat['clinic_id']));
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
            
            
            
            $chatParticipant                 = array();
            
            /* Check in Chat Participants, if not entered. Then added it in chat participantts */
            $participantInfo                         = array();
            $participantInfo['chat_id']              = $chat['id'];
            $participantInfo['user_id']              = $patientDetails['user_id'];
            $participantInfo['participant_id']       = $patientDetails['id'];
            $participantInfo['participant_type_id']  = '2';
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
                $finalResponse = $this->uploadChatDocs($input,$chat['id'],$chatParticipantID,$chatMsgID,session('user.userID'));
                $docPath       = ( !empty($finalResponse) && isset($finalResponse['isSuccess']) ) ? $finalResponse['crppath'] : '';
            }
            
            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    
       public function getMentions(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            
            $clinic = $this->Corefunctions->convertToArray(Clinic::clinicByUUID( $data['clinicuuid'] ));
            if (empty($clinic)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            
            $searchTerm = isset($data['query']) ? trim($data['query']) : '';
            $results = Chats::getMentionedUsers($searchTerm,$clinic['id']);
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
    public function chatDocuments(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $key = $data['key'];
            
            $chat = Chats::chatByUUID($key);
            if( empty($chat)){
                 return $this->Corefunctions->returnError('Invalid chat');
            }
      
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
           
            $html                           = view('frontend.chats.documents', $data);
          
            $arr['view']                    = $html->__toString(); 
            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    
    
   
     

}
