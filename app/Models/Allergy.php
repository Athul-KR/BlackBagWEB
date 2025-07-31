<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
use Session;

class Allergy extends Model
{
    use HasFactory, SoftDeletes;

    public static function addAllergy($title,$reaction,$sourceType,$userID,$createdBy,$clinicID=NULL){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('8', 'allergies', 'allergies_uuid');
        DB::table('allergies')->insertGetId(array(
            'allergies_uuid' => $key,
            'allergy' => $title,
            'reaction' => $reaction,
            'user_id' => $userID,
            'source_type_id' => $sourceType,
            'clinic_id' => $clinicID,
            'created_by' => $createdBy,
            'created_at' => Carbon::now(),
        ));
    }
    public static function updateAllergy($key,$title,$reaction,$updatedBy){
        DB::table('allergies')->where('allergies_uuid',$key)->update(array(
            'allergy' => $title,
            'reaction' => $reaction,
            'updated_by' => $updatedBy,
            'updated_at' => Carbon::now(),
        ));
    }
    public static function removeAllergy($userID){
        DB::table('allergies')->where('user_id',$userID)->where('source_type_id','1')->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }
    public static function getAllergy($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('allergies')->whereNull('deleted_at')->where('user_id',$userID)->orderBy('id', 'desc')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getAllergyByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('allergies')->whereNull('deleted_at')->where('allergies_uuid',$key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function deleteAllergy($key){
        DB::table('allergies')->where('allergies_uuid',$key)->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }

}
