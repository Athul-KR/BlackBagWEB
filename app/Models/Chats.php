<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Session;

class Chats extends Model
{
    use HasFactory, SoftDeletes;

   
    protected $guarded = [];

    
    public static function getChat($info){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $result = $Corefunctions->convertToArray(DB::table('chats')->where('clinic_id', $info['clinic_id'])->where('chat_type_id', $info['chat_type_id'])->whereNull('deleted_at')->where(function($query) use ($info) {
            $query->where(function($q) use ($info) {
                $q->where('from_user_id', $info['from_user_id'])
                  ->where('to_user_id', $info['to_user_id']);
            })->orWhere(function($q) use ($info) {
                $q->where('from_user_id', $info['to_user_id'])
                  ->where('to_user_id', $info['from_user_id']);
            });
        })
        ->first());

        return $result;
    } 
    public static function getChatParticipant($info){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('chat_participants')->where('chat_id', $info['chat_id'])->where('user_id', $info['user_id'])->where('participant_id', $info['participant_id'])->where('participant_type_id', $info['participant_type_id'])->whereNull('deleted_at')->first());
        return $result;
    } 
    public static function checkUnreadMessageExists($chatID,$lastReadTime){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('chat_messages')->where('chat_id', $chatID)->where('created_at', '>', $lastReadTime)->whereNull('deleted_at')->exists();
        return $result;
    }
    public static function getAllChatMessages($info){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('chat_participants')->select('chat_messages.*','chat_participants.user_id','chat_participants.participant_id','chat_participants.participant_type_id')->join('chat_messages', 'chat_messages.chat_participant_id', '=', 'chat_participants.id')->where('chat_participants.chat_id', $info['chat_id'])->whereNull('chat_participants.deleted_at')->whereNull('chat_messages.deleted_at');
        if( isset($info['first_chat_id']) && $info['first_chat_id'] != '' ){
            $result = $result->where('chat_messages.id', '<', $info['first_chat_id']);
        }
        $result = $result->orderBy('chat_messages.id','desc');
        if( isset($info['is_count']) && $info['is_count'] == '1'  ){
            $result = $result->count();
        }else{
               $result = $result->limit(10)->get();
         }
        
        
       
         $result =  $Corefunctions->convertToArray($result);                                      
        return $result;
    } 
    public static function addChatParticipant($info){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $chat_participant_uuid = $Corefunctions->generateUniqueKey("12", "chat_participants", "chat_participant_uuid");
        $insertid = DB::table('chat_participants')->insertGetId(array(
            'chat_participant_uuid'         => $chat_participant_uuid,
            'chat_id'                       => $info['chat_id'],
            'user_id'                       => $info['user_id'],
            'participant_id'                => $info['participant_id'],
            'participant_type_id'           => $info['participant_type_id'],
            'created_at'                    => Carbon::now()
        ));
        return $insertid ;
    }  
    public static function addChatMessages($info){

        $insertid = DB::table('chat_messages')->insertGetId(array(
            'chat_id'                       => $info['chat_id'],
            'chat_participant_id'           => $info['chat_participant_id'],
            'message'                       => $info['message'],
            'created_at'                    => Carbon::now()
        ));
        return $insertid ;
    }
    public static function getPatientChats($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $result = $Corefunctions->convertToArray(DB::table('chats')->where('chat_type_id', '1')->whereNull('deleted_at')->where('from_user_id', $userID)->orWhere('to_user_id', $userID)->orderBy('created_at','desc')->get());

        return $result;
    } 
     public static function checkUnreadChatExists($userID,$chatIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
       if( empty($chatIDS)){ return array(); }
         
        $unreadCounts = DB::table('chat_participants as cp')
        ->join('chat_messages as cm', 'cm.chat_id', '=', 'cp.chat_id')
        ->select('cp.chat_id', DB::raw('COUNT(cm.id) as unread_count'))
        ->where('cp.user_id', $userID)
        ->whereIn('cp.chat_id', $chatIDS)
        ->whereNull('cp.deleted_at')
        ->whereNull('cm.deleted_at')
        ->whereColumn('cm.chat_participant_id', '!=', 'cp.id')
        ->where(function ($query) {
            $query->whereNull('cp.last_read_time')
                  ->orWhereColumn('cm.created_at', '>', 'cp.last_read_time');
        })
        ->groupBy('cp.chat_id')
        ->get();

        $result = $Corefunctions->convertToArray($unreadCounts);
        
        return $result;
    } 
    public static function getChatsLastMessage($chatIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
       if( empty($chatIDS)){ return array(); }
         
        $lastMessages = DB::table('chat_messages as cm1')
    ->select('cm1.*')->whereIn('cm1.chat_id', $chatIDS)->whereNull('cm1.deleted_at')
    ->join(DB::raw('(
        SELECT chat_id, MAX(created_at) as max_created
        FROM chat_messages
        GROUP BY chat_id
    ) as cm2'), function($join) {
        $join->on('cm1.chat_id', '=', 'cm2.chat_id')
             ->on('cm1.created_at', '=', 'cm2.max_created');
    })
    ->get();

        $result = $Corefunctions->convertToArray($lastMessages);
        
        return $result;
    } 
    public static function chatByUUID($chatUUID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('chats')->where('chat_uuid', $chatUUID)->first();
        $result = $Corefunctions->convertToArray($result);
        return $result;
    }
    public static function addChatDocs($info,$chatID,$chatparticipantID,$doc_path,$chatMessageID){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $chat_participant_uuid = $Corefunctions->generateUniqueKey("12", "chat_docs", "chat_doc_uuid");
        $insertid = DB::table('chat_docs')->insertGetId(array(
            'chat_doc_uuid'                 => $chat_participant_uuid,
            'chat_id'                       => $chatID,
            'chat_message_id'               => $chatMessageID,
            'chat_participant_id'           => $chatparticipantID,
            'doc_path'                      => $doc_path,
            'doc_ext'                       => $info->temp_doc_ext,
            'original_name'                 => $info->original_name,
            'file_size'                     => $info->file_size,
            'created_at'                    => Carbon::now()
        ));
        return $insertid ;
    }
    
    	public static function insertTempDocs($tempkey, $ext, $filename,$filesize)
	{

		return DB::table('temp_docs')->insertGetId(array(
			'tempdoc_uuid' => $tempkey,
			'temp_doc_ext' => $ext,
			'original_name' => $filename,
			'file_size' => $filesize,
			'created_at' => carbon::now()
		));
	}
    public static function chatDocsByMessageIDs($messageIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $result = $Corefunctions->convertToArray(DB::table('chat_docs')->whereIn('chat_message_id', $messageIDS)->whereNull('deleted_at')->get());

        return $result;
    } 
     public static function chatParticipantByUUId($participantUUID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('chat_participants')->where('chat_participant_uuid', $participantUUID)->whereNull('deleted_at')->first());
        return $result;
    }  
    public static function getAllChatParticipants($chatID,$userID=''){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('chat_participants')->where('chat_id', $chatID)->whereNull('deleted_at');
        if($userID != '' ){
            $result = $result->where('user_id','!=',$userID);
        }
        $result = $result->get();
        $result = $Corefunctions->convertToArray($result);
        return $result;
    }  
    public static function getChatParticipantByChatID($chatID,$userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('chat_participants')->where('chat_id', $chatID)->where('user_id', $userID)->whereNull('deleted_at');
      
        $result = $result->first();
        $result = $Corefunctions->convertToArray($result);
        return $result;
    }
    public static function getMentionedUsers($searchTerm,$clinicID,$sessionUserID=''){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $users = DB::table('users')->select('clinic_users.id','clinic_users.user_id','clinic_users.clinic_user_uuid','users.user_uuid','users.first_name','users.last_name','users.profile_image','clinic_users.user_type_id')
            ->join('clinic_users', 'clinic_users.user_id', '=', 'users.id');
        if( $sessionUserID != ''){
            $users =  $users->where('clinic_users.user_id', '!=',$sessionUserID);
        }
         $users =  $users->where('clinic_users.clinic_id', $clinicID)->where('clinic_users.status', '1')->where('clinic_users.user_id', '!=',$sessionUserID)->whereNull('users.deleted_at')->whereNull('clinic_users.deleted_at')->where('clinic_users.user_type_id','!=','4')
            ->where(function ($query) use ($searchTerm) {
                $query->where('users.first_name', 'like', "%{$searchTerm}%")
                      ->orWhere('users.last_name', 'like', "%{$searchTerm}%");
            })
            ->get();

            $result = $Corefunctions->convertToArray($users);
            return $result;
        }
    public static function chatDocByID($chatDocID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('chat_docs')->where('id', $chatDocID)->whereNull('deleted_at');
      
        $result = $result->first();
        //$result = $Corefunctions->convertToArray($result);
        return $result;
    }
    
    public static function chatByID($chatID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('chats')->where('id', $chatID)->first();
        $result = $Corefunctions->convertToArray($result);
        return $result;
    }
    public static function chatDocsByIDS($chatIDS=array()){
        if( empty($chatIDS)){ return array(); }
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('chat_docs')->where('chat_id', $chatIDS)->whereNull('deleted_at');
      
        $result = $result->get();
        $result = $Corefunctions->convertToArray($result);
        return $result;
    }
    
    
    
     
}
