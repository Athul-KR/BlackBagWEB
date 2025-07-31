<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
class VideoCall extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function videoCallByKey($key){
        $patient = DB::table('video_calls')->where('room_key', $key)->whereNull('deleted_at')->first();
        return $patient;
    }
    public static function videoCallByID($id){
        $patient = DB::table('video_calls')->where('id', $id)->whereNull('deleted_at')->first();
        return $patient;
    }
    public static function getParticipationByKey($key){
        $participantCalls = DB::table('video_call_participants')->where('vcparticipation_key', $key)->whereNull('deleted_at')->first();
        return $participantCalls;
    } public static function getParticipationByID($id,$callid){
        $participantCalls = DB::table('video_call_participants')->where('participant_id', $id)->where('call_id', $callid)->whereNull('deleted_at')->orderBy('id','desc')->first();
        return $participantCalls;
    }
    public static function updateVideocallByID($id){
        $data = [
        'call_started' => time(),
        'updated_at' => Carbon\Carbon::now(),
    ];
        $participantCalls = DB::table('video_calls')->where('id', $id)->update($data);
        return $participantCalls;
    }
    
    public static function updateVideoCallStatus($participant_id, $callid,$status){
    // Initialize data array with common values
    $data = [
        'is_completed' => '1',
        'completed' => time(),
        'updated_at' => Carbon\Carbon::now(),
    ];

        
    if($status == '5'){
        DB::table('video_call_participants')
        ->where('participant_id', $participant_id)->where('call_id', $callid)->whereNull('completed')
        ->update($data);
    }else{
        DB::table('video_call_participants')->where('call_id', $callid)
        ->update($data);
    }
    // Update the video call participation record in the database
    return ;
}


    public static function updateParticipationByID($id,$callid,$iswaiting,$isreject ='0'){
        
        if($isreject == '1'){
             $data = [
            'is_waiting' => $iswaiting,
            'is_reject' => $isreject,
            'is_completed' => '1',
            'completed' => time()
            ];
            
        }else{
             $data = [
            'is_waiting' => $iswaiting,
            'is_reject' => $isreject
            ];
        }
        
        $participantCalls = DB::table('video_call_participants')->where('participant_id', $id)->where('call_id', $callid)->whereNull('completed')->update($data);
        return $participantCalls;
    } 
    public static function getWaitingUser($callid){
        $participantCalls = DB::table('video_call_participants')->where('call_id', $callid)->where('is_waiting', '1')->whereNull('deleted_at')->whereNull('completed')->first();
        return $participantCalls;
    }
    public static function getvideoCallByAppoinmentID($id){
        $videoCalls = DB::table('video_calls')->where('appointment_id', $id)->first();
        return $videoCalls;
    }
     public static function getvideoCallByRoomID($room_id){
        $videoCalls = DB::table('video_calls')->where('room_id', $room_id)->first();
        return $videoCalls;
    }
    public static function getVideoCallByAppointmentId($appointmentId)
    {
        return self::where('appointment_id', $appointmentId)->first();
    }
   
     public static function getVideoCallByAppointmentIds($appointmentId)
    {
        return self::whereIn('appointment_id', $appointmentId)->get();
    }
   
     
}
