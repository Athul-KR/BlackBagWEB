<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class Immunization extends Model
{
    use HasFactory, SoftDeletes;

    public static function addImmunization($immunization,$patientID,$clinicID,$sourceType,$createdBy){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('8', 'immunization', 'immunization_uuid');
        DB::table('immunization')->insertGetId(array(
            'immunization_uuid' => $key,
            'immunizationtype_id' => $immunization,
            'user_id' => $patientID,
            'clinic_id' => $clinicID,
            'source_type_id' => $sourceType,
            'created_by' => $createdBy,
            'created_at' => Carbon\Carbon::now(),
        ));
    }
    public static function updateImmunization($key,$immunization,$updatedBy){
        DB::table('immunization')->where('immunization_uuid',$key)->update(array(
            'immunizationtype_id' => $immunization,
            'updated_by' => $updatedBy,
            'updated_at' => Carbon\Carbon::now(),
        ));
    }
    public static function getImmunization($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('immunization')->join('ref_immunization_types','ref_immunization_types.id','=','immunization.immunizationtype_id')->select('immunization.*','ref_immunization_types.immunization_type')->whereNull('immunization.deleted_at')->where('user_id',$userID)->orderBy('id', 'desc')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getImmunizationByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('immunization')->whereNull('deleted_at')->where('immunization_uuid',$key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function deleteImmunization($key){
        DB::table('immunization')->where('immunization_uuid',$key)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }

}
