<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
use Session;

class PatientCondition extends Model
{
    use HasFactory, SoftDeletes;

    public static function addPatientCondition($relationID,$conditionID,$sourceType,$userID,$createdBy,$clinicID=NULL){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $userTimeZone = session()->get('user.timezone');
        $key = $Corefunctions->generateUniqueKey('8', 'patient_conditions', 'patient_condition_uuid');
        DB::table('patient_conditions')->insertGetId(array(
            'patient_condition_uuid' => $key,
            'relation_id' => $relationID,
            'condition_id' => $conditionID,
            'user_id' => $userID,
            'clinic_id' => $clinicID,
            'source_type_id' => $sourceType,
            'created_by' => $createdBy,
            'reportdate' => now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d'),
            'created_at' => Carbon::now(),
        ));
    }
    public static function updatePatientCondition($key,$relationID,$conditionID,$updatedBy){
        DB::table('patient_conditions')->where('patient_condition_uuid',$key)->update(array(
            'relation_id' => $relationID,
            'condition_id' => $conditionID,
            'updated_by' => $updatedBy,
            'updated_at' => Carbon::now(),
        ));
    }
    public static function removePatientCondition($userID){
        DB::table('patient_conditions')->where('user_id',$userID)->where('source_type_id','1')->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }
    public static function getSelfPatientCondition($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('patient_conditions')->whereNull('patient_conditions.deleted_at')->where('user_id',$userID)->where('relation_id','=','19')->orderBy('id', 'desc')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getPatientCondition($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('patient_conditions')->whereNull('patient_conditions.deleted_at')->where('user_id',$userID)->where('relation_id','!=','19')->orderBy('id', 'desc')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getPatientConditionByRelation($userID,$relationID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('patient_conditions')->where('user_id',$userID)->where('relation_id',$relationID)->where('source_type_id',$sourceType)->whereNull('patient_conditions.deleted_at')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getPatientConditionByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('patient_conditions')->whereNull('patient_conditions.deleted_at')->where('patient_condition_uuid',$key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function deletePatientCondition($key){
        DB::table('patient_conditions')->where('patient_condition_uuid',$key)->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }
    public static function deleteFamilyHistory($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('patient_conditions')->whereNull('patient_conditions.deleted_at')->where('patient_condition_uuid',$key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        DB::table('patient_conditions')->where('user_id',$medicalDetails['user_id'])->where('relation_id',$medicalDetails['relation_id'])->where('source_type_id',$medicalDetails['source_type_id'])->whereNull('patient_conditions.deleted_at')->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }

}
