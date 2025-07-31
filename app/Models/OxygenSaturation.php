<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
use Session;

class OxygenSaturation extends Model
{
    use HasFactory, SoftDeletes;

    public static function getOxygenSaturation($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('oxygen_saturations')->whereNull('oxygen_saturations.deleted_at')->where('user_id',$userID)->orderBy('id','desc')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }

    public static function getOxygenSaturationByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('oxygen_saturations')->whereNull('oxygen_saturations.deleted_at')->where('oxygen_saturation_uuid',$key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }

    public static function addOxygenSaturation($input,$createdBy){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('8', 'oxygen_saturations', 'oxygen_saturation_uuid');
        DB::table('oxygen_saturations')->insertGetId(array(
            'oxygen_saturation_uuid' => $key,
            'saturation' => $input['saturation'],
            'user_id' => $input['user_id'],
            'clinic_id' => $input['clinic_id'],
            'source_type_id' => $input['sourceType'],
            'reportdate' => $input['reportdate'],
            'reporttime' => $input['reporttime'],
            'created_by' => $createdBy,
            'created_at' => Carbon::now(),
        ));
    }

    public static function updateOxygenSaturation($key,$input,$updatedBy){
        DB::table('oxygen_saturations')->where('oxygen_saturation_uuid',$key)->update(array(
            'saturation' => $input['saturation'],
            'reportdate' => $input['reportdate'],
            'reporttime' => $input['reporttime'],
            'updated_by' => $updatedBy,
            'updated_at' => Carbon::now(),
        ));
    }

    public static function deleteOxygenSaturation($key){
        DB::table('oxygen_saturations')->where('oxygen_saturation_uuid',$key)->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }

    public static function getSaturationBySourceType($userID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('oxygen_saturations')->whereNull('deleted_at')->where('user_id',$userID)->where('source_type_id',$sourceType)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }

    public static function getLatYearOxygenSaturation($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $data = DB::table('oxygen_saturations')->where('user_id', $userID)
        ->whereBetween('created_at', [now()->subYear(), now()]) // Last 1 year
        ->orderBy('created_at', 'asc')->get();
        $medicalDetails = $Corefunctions->convertToArray($data);
        return $medicalDetails ;
    }
}
