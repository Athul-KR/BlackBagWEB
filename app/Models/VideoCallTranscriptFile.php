<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VideoCallTranscriptFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Insert a new video call transcript file record.
     */
    public static function insertVideoCallTranscriptFile($input)
    {
        return DB::table('video_call_transcript_files')->insertGetId([
            'video_call_file_uuid' => !empty($input['video_call_file_uuid']) ? $input['video_call_file_uuid'] : null,
            'transcript_file_path' => !empty($input['transcript_file_path']) ? $input['transcript_file_path'] : null,
            'transcript_data'      => !empty($input['transcript_data']) ? $input['transcript_data'] : null,
            'call_id'              => !empty($input['call_id']) ? $input['call_id'] : null,
            'appointment_id'       => !empty($input['appointment_id']) ? $input['appointment_id'] : null,
            'created_at'           => Carbon::now(),
        ]);
    }

    /**
     * Update the transcript file path.
     */
    public static function updateVideoCallTranscriptFile($video_call_transcript_file_id, $filePath)
    {
        return DB::table('video_call_transcript_files')
            ->where('id', $video_call_transcript_file_id)
            ->update([
                'transcript_file_path' => $filePath,
                'updated_at'           => Carbon::now(),
            ]);
    }

    /**
     * Get transcript files by appointment ID.
     */
    public static function getVideoCallTranscriptFile($appointment_id)
    {
        return DB::table('video_call_transcript_files')
            ->where('appointment_id', $appointment_id)->orderBy('id','asc')
            ->get();
    }
}
