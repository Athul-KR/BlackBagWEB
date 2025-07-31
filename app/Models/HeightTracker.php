<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;
class HeightTracker extends Model
{
    use HasFactory, SoftDeletes;

    public static function insertHeight($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
        $key = $Corefunctions->generateUniqueKey('8', 'height_tracker', 'height_tracker_uuid');

        DB::table('height_tracker')->insertGetId([
            'height_tracker_uuid' => $key,
            'user_id'           => $inputData['user_id'],
            'clinic_id'         => $inputData['clinic_id'],
            'height'            => isset($inputData['height']) && $inputData['height'] !='' ? $inputData['height'] : NULL,
            'cm'                => isset($inputData['cm']) && $inputData['cm'] !='' ? $inputData['cm'] : NULL,
            'inches'            => isset($inputData['inches']) && $inputData['inches'] !='' ? $inputData['inches'] : NULL,
            'reportdate'        => $inputData['reportdate'],
            'reporttime'        => $inputData['reporttime'],
            'unit'              => isset($inputData['unit']) && $inputData['unit'] !='' ? $inputData['unit'] : 'cm',
            'source_type_id'    => isset($inputData['sourceType']) && $inputData['sourceType'] !='' ? $inputData['sourceType'] : NULL,
            'created_by'        => Session::get('user.userID'),
            'created_at'        => Carbon\Carbon::now(),
            
        ]);
    }
    public static function updateHeight($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
     
        DB::table('height_tracker')->where('height_tracker_uuid', $inputData['key'])->update(array(
            'height'            => isset($inputData['height']) && $inputData['height'] !='' ? $inputData['height'] : NULL,
            'cm'                => isset($inputData['cm']) && $inputData['cm'] !='' ? $inputData['cm'] : NULL,
            'inches'            => isset($inputData['inches']) && $inputData['inches'] !='' ? $inputData['inches'] : NULL,
            'unit'              => isset($inputData['unit']) && $inputData['unit'] !='' ? $inputData['unit'] : NULL,
            'reportdate'        => $inputData['reportdate'],
            'reporttime'        => $inputData['reporttime'],
            'updated_by'        => $inputData['user_id'],
            'updated_at'        => Carbon\Carbon::now(),

        ));
    }
    public static function getHeightTracker($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('height_tracker')->whereNull('deleted_at')->where('user_id',$userID)->orderBy('id', 'desc')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getHeightTrackerBySourceType($userID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('height_tracker')->whereNull('deleted_at')->where('user_id',$userID)->where('source_type_id',$sourceType)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getHeightTrackerByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('height_tracker')->whereNull('deleted_at')->where('height_tracker_uuid',$key)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function deleteHeightTracker($key){
        DB::table('height_tracker')->where('height_tracker_uuid',$key)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }
    public static function getLatYearHeightTracker($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $data = DB::table('height_tracker')->where('user_id', $userID)
        ->whereBetween('created_at', [now()->subYear(), now()]) // Last 1 year
        ->orderBy('created_at', 'asc')->get();
    }

    public static function getLatestHeightTracker($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('height_tracker')->whereNull('deleted_at')->where('user_id',$userID)->orderBy('reportdate','desc')->orderBy('id','desc')->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);
       
        return $medicalDetails ;
    }

}
