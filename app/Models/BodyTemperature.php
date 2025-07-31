<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;
use Session;
class BodyTemperature extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'body_temperature';

    public static function getBodyTemperature($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $temparatureDetails = DB::table('body_temperature')->whereNull('deleted_at')->orderBy('id','desc')->where('user_id',$userID)->get();
        $temparatureDetails = $Corefunctions->convertToArray($temparatureDetails);

        return $temparatureDetails ;
    }
    public static function getBodyTemperatureBySourceType($userID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('body_temperature')->select('user_id','body_temperature_uuid','celsius','farenheit','unit','updated_at','created_by','updated_by','source_type_id','created_at','reportdate','reporttime')->whereNull('deleted_at')->where('user_id',$userID)->where('source_type_id',$sourceType)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }

    public static function getBodyTemperatureByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $temparatureDetails = DB::table('body_temperature')->whereNull('deleted_at')->where('body_temperature_uuid',$key)->first();
        $temparatureDetails = $Corefunctions->convertToArray($temparatureDetails);

        return $temparatureDetails ;
    }




    public static function insertBodyTemperature($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
        $key = $Corefunctions->generateUniqueKey('8', 'body_temperature', 'body_temperature_uuid');
     
        DB::table('body_temperature')->insertGetId([
            'body_temperature_uuid' => $key,
            'user_id'         => $inputData['user_id'],
            'clinic_id'       => $inputData['clinic_id'],
            'celsius'         => isset($inputData['celsius']) && $inputData['celsius'] !='' ? $inputData['celsius'] : NULL,
            'farenheit'       => isset($inputData['farenheit']) && $inputData['farenheit'] !='' ? $inputData['farenheit'] : NULL,
            'unit'              => isset($inputData['unit']) && $inputData['unit'] !='' ? $inputData['unit'] : NULL,
            'source_type_id'  => isset($inputData['sourceType']) && $inputData['sourceType'] !='' ? $inputData['sourceType'] : NULL,
            'reportdate'      => $inputData['reportdate'],
            'reporttime'      => $inputData['reporttime'],
            'created_by'      => Session::get('user.userID'),
            'created_at'      => Carbon\Carbon::now(),

        ]);
    }

    public static function deleteBodyTemperature($key){
        DB::table('body_temperature')->where('body_temperature_uuid',$key)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }
 

    public static function updateBodyTemperature($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
     
        DB::table('body_temperature')->where('body_temperature_uuid', $inputData['key'])->update(array(
            'celsius'         => isset($inputData['celsius']) && $inputData['celsius'] !='' ? $inputData['celsius'] : NULL,
            'farenheit'       => isset($inputData['farenheit']) && $inputData['farenheit'] !='' ? $inputData['farenheit'] : NULL,
            'unit'            => isset($inputData['unit']) && $inputData['unit'] !='' ? $inputData['unit'] : NULL,
            'reportdate'      => $inputData['reportdate'],
            'reporttime'      => $inputData['reporttime'],
            'updated_by'      => $inputData['user_id'],
            'updated_at'      => Carbon\Carbon::now(),

        ));
    }

    public static function getLatYearBodyTemperature($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $data = DB::table('body_temperature')->where('user_id', $userID)
        ->whereBetween('created_at', [now()->subYear(), now()]) // Last 1 year
        ->orderBy('created_at', 'asc')->get();
        $medicalDetails = $Corefunctions->convertToArray($data);
        return $medicalDetails ;
    }   

}
