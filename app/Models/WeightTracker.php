<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;
class WeightTracker extends Model
{
    use HasFactory, SoftDeletes;

    public static function insertWeight($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
        $key = $Corefunctions->generateUniqueKey('8', 'weight_tracker', 'weight_tracker_uuid');

        DB::table('weight_tracker')->insertGetId([
            'weight_tracker_uuid' => $key,
            'user_id'          => $inputData['user_id'],
            'clinic_id'        => $inputData['clinic_id'],
            'weight'           => isset($inputData['weight']) && $inputData['weight'] !='' ? $inputData['weight'] : NULL,
            'kg'               => isset($inputData['kg']) && $inputData['kg'] !='' ? $inputData['kg'] : NULL,
            'lbs'              => isset($inputData['lbs']) && $inputData['lbs'] !='' ? $inputData['lbs'] : NULL,
            'reportdate'       => $inputData['reportdate'],
            'reporttime'       => $inputData['reporttime'],
            'unit'             => isset($inputData['unit']) && $inputData['unit'] !='' ? $inputData['unit'] : 'kg',
            'source_type_id'   => isset($inputData['sourceType']) && $inputData['sourceType'] !='' ? $inputData['sourceType'] : NULL,
            'created_by'       => Session::get('user.userID'),
            'bmi'              => isset($inputData['bmi']) && $inputData['bmi'] !='' ? $inputData['bmi'] : NULL, 
            'created_at'       => Carbon\Carbon::now(),
            
        ]);
    }
    public static function updateWeight($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
     
        DB::table('weight_tracker')->where('weight_tracker_uuid', $inputData['key'])->update(array(
            'weight'           => isset($inputData['weight']) && $inputData['weight'] !='' ? $inputData['weight'] : NULL,
            'kg'               => isset($inputData['kg']) && $inputData['kg'] !='' ? $inputData['kg'] : NULL,
            'lbs'              => isset($inputData['lbs']) && $inputData['lbs'] !='' ? $inputData['lbs'] : NULL,
            'unit'             => isset($inputData['unit']) && $inputData['unit'] !='' ? $inputData['unit'] : 'kg',
            'reportdate'       => $inputData['reportdate'],
            'reporttime'       => $inputData['reporttime'],
            'updated_by'       => $inputData['user_id'],
            'updated_at'       => Carbon\Carbon::now(),

        ));
    }
    public static function getWeightTracker($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('weight_tracker')->whereNull('deleted_at')->where('user_id',$userID)->orderBy('id', 'desc')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getWeightTrackerBySourceType($userID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('weight_tracker')->whereNull('deleted_at')->where('user_id',$userID)->where('source_type_id',$sourceType)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getWeightTrackerByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('weight_tracker')->whereNull('deleted_at')->where('weight_tracker_uuid',$key)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function deleteWeightTracker($key){
        DB::table('weight_tracker')->where('weight_tracker_uuid',$key)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }
    public static function getLatYearWeightTracker($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $data = DB::table('weight_tracker')->where('user_id', $userID)
        ->whereBetween('created_at', [now()->subYear(), now()]) // Last 1 year
        ->orderBy('created_at', 'asc')->get();
        $medicalDetails = $Corefunctions->convertToArray($data);
        return $medicalDetails ;
    }
    
}
