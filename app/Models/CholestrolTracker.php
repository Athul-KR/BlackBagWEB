<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class CholestrolTracker extends Model
{
    use HasFactory, SoftDeletes;

    public static function insertCholesterol($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
        $key = $Corefunctions->generateUniqueKey('8', 'cholestrol_tracker', 'cholestrol_tracker_uuid');
        

        DB::table('cholestrol_tracker')->insertGetId([

            'cholestrol_tracker_uuid' => $key,
            'user_id'                 => $inputData['user_id'],
            'clinic_id'               => $inputData['clinic_id'],
            'cltotal'                 => isset($inputData['cholesterol']) && $inputData['cholesterol'] !='' ? $inputData['cholesterol'] : NULL,
            'LDL'                     => isset($inputData['ldl']) && $inputData['ldl'] !='' ? $inputData['ldl'] : NULL,
            'HDL'                     => isset($inputData['hdl']) && $inputData['hdl'] !='' ? $inputData['hdl'] : NULL,
            'triglycerides'           => isset($inputData['triglycerides']) && $inputData['triglycerides'] !='' ? $inputData['triglycerides'] : NULL,
            'fasting'                 => isset($inputData['fasting']) && $inputData['fasting'] =='on' ? '1' : '0',
            'reportdate'              => $inputData['reportdate'],
            'reporttime'              => $inputData['reporttime'],
            'source_type_id'          => isset($inputData['sourceType']) && $inputData['sourceType'] !='' ? $inputData['sourceType'] : NULL,
            'created_by'              => Session::get('user.userID'),
            'created_at'              => Carbon\Carbon::now(),
            
        ]);
    }
    public static function updateCholesterol($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
     
        DB::table('cholestrol_tracker')->where('cholestrol_tracker_uuid', $inputData['key'])->update(array(
            'cltotal'                 => isset($inputData['cholesterol']) && $inputData['cholesterol'] !='' ? $inputData['cholesterol'] : NULL,
            'LDL'                     => isset($inputData['ldl']) && $inputData['ldl'] !='' ? $inputData['ldl'] : NULL,
            'HDL'                     => isset($inputData['hdl']) && $inputData['hdl'] !='' ? $inputData['hdl'] : NULL,
            'triglycerides'           => isset($inputData['triglycerides']) && $inputData['triglycerides'] !='' ? $inputData['triglycerides'] : NULL,
            'fasting'                 => isset($inputData['fasting']) && $inputData['fasting'] =='on' ? '1' : '0',
            'reportdate'              => $inputData['reportdate'],
            'reporttime'              => $inputData['reporttime'],
            'updated_by'               => $inputData['user_id'],
            'updated_at'               => Carbon\Carbon::now(),

        ));
    }
    public static function getCholesterolTracker($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('cholestrol_tracker')->whereNull('deleted_at')->where('user_id',$userID)->orderBy('id', 'desc')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }

    public static function getCholesterolTrackerBySourceType($userID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('cholestrol_tracker')->whereNull('deleted_at')->where('user_id',$userID)->where('source_type_id',$sourceType)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }

    public static function getCholesterolTrackerByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('cholestrol_tracker')->whereNull('deleted_at')->where('cholestrol_tracker_uuid',$key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function deleteCholestrolTracker($key){
        DB::table('cholestrol_tracker')->where('cholestrol_tracker_uuid',$key)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }


}
