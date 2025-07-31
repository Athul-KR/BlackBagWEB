<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;

class VideoCallParticipant extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'video_call_participants';

    public static function getParticipantsByCallId($callId)
    {
        return self::select(
            'participant_type',
            'participant_id',
            DB::raw('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(initiated), FROM_UNIXTIME(completed)))) as total_duration'),
            DB::raw('FROM_UNIXTIME(MIN(initiated)) AS first_initiated_time'),
            DB::raw('FROM_UNIXTIME(MAX(completed)) AS last_completed_time')
        )
        ->where('call_id', $callId)
        ->groupBy('participant_type', 'participant_id')
        ->get();
    }

    public static function getClinicParticipantsByCallId($callId)
    {
        return self::where('call_id', $callId)
            ->where('participant_type', '!=', 'patient')
            ->get();
    }

    public static function checkParticipantJoined($callId, $participantId, $participantType)
    {
        return self::where('call_id', $callId)
            ->where('participant_id', $participantId)
            ->where('participant_type', $participantType)
            ->whereNull('completed')
            ->count();
    }

    public static function getParticipantJoined($callId, $participantId, $participantType)
    {
        return self::where('participant_id',$participantId)->where('call_id',$callId)->where('participant_type',$participantType)->orderBy('id','desc')->first();
    }

    public static function countCallParticipants($callId)
    {
        return self::where('call_id', $callId)->count();
    }

    public static function addParticipant($callId, $participantId, $participantType, $isOwner = '0', $isWaiting = '0')
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $vcParticipationKey = $Corefunctions->generateUniqueKey('10', 'video_call_participants', 'vcparticipation_key');
        
        return self::create([
            'vcparticipation_key' => $vcParticipationKey,
            'call_id' => $callId,
            'initiated' => time(),
            'participant_id' => $participantId,
            'participant_type' => $participantType,
            'is_owner' => $isOwner,
            'is_waiting' => $isWaiting,
        ]);
    }

    public static function updateCallStatus($callId, $status)
    {
        return self::where('call_id', $callId)->update($status);
    }

    public static function updateCallStatusForParticipantReject($callId,$particpantId, $status)
    {
        return self::where('call_id', $callId)->where('participant_id', $particpantId)->update($status);
    }

    public static function updateCallStatusForParticipant($callId, $status)
    {
        return self::where('call_id', $callId)->update($status);
    }

    public static function markAsCompleted($participantId, $callId, $participantType)
    {
        return self::where('participant_id', $participantId)
            ->where('call_id', $callId)
            ->where('participant_type', $participantType)
            ->whereNull('completed')
            ->update([
                'is_completed' => '1',
                'completed' => time()
            ]);
    }
    public static function getFirstWaitingParticipant($callId)
    {
        return self::where('call_id', $callId)
            ->where('is_waiting', '1')->orderBy('id','desc')
            ->first();
    }
    public static function getWaitingParticipant($callId)
    {
        return self::where('call_id', $callId)
            ->where('participant_type', 'patient')->orderBy('id','desc')
            ->first();
    }
    public static function getVideoCallParticipants($callId)
    {
        return self::select(
            'participant_type',
            'participant_id',
            \DB::raw('TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(MIN(initiated)), FROM_UNIXTIME(MAX(completed))) as total_duration'), // Total duration in seconds
            \DB::raw('FROM_UNIXTIME(MIN(initiated)) AS first_initiated_time'),
            \DB::raw('FROM_UNIXTIME(MAX(completed)) AS last_completed_time')
        )
        ->where('call_id', $callId)
        ->whereNotNull('completed')
        ->groupBy('participant_type', 'participant_id')
        ->get();
    }
    public static function getVideoParticipantPatients($callId)
    {
        return self::select('participant_id')
            ->where('call_id', $callId)
            ->where('participant_type', 'patient')
            ->get();
    }

    public static function getVideoParticipantOthers($callId)
    {
        return self::select('participant_id')
            ->where('call_id', $callId)
            ->where('participant_type', '!=', 'patient')
            ->get();
    }
    public static function getVideocallByIDs($id)
    {
        return self::whereIn('call_id', $id)
            ->where('is_waiting', '1')
            ->first();
    } 
}
