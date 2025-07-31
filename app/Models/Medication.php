<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class Medication extends Model
{
    use HasFactory, SoftDeletes;

    public static function addMedication($medication,$conditionID,$patientID,$clinicID,$sourceType,$createdBy){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('8', 'medications', 'medication_uuid');
        $conditionData = DB::table('medications')->insertGetId(array(
            'medication_uuid' => $key,
            'medicine_id' => (isset($medication['medicine_id']) && $medication['medicine_id'] != '' && $medication['medicine_id'] != 'medicine') ? $medication['medicine_id'] : '0',
            'condition_id' => $conditionID,
            'medicine_name' => (isset($medication['medicine_id']) && $medication['medicine_id'] != '' && $medication['medicine_id'] != '0') ? '' : $medication['medicine_name'],
            'quantity' => (isset($medication['quantity']) && $medication['quantity'] != '') ? $medication['quantity'] : 0,
            'strength' => (isset($medication['strength']) && $medication['strength'] != '') ? $medication['strength'] : 0,
            'strength_unit_id' => (isset($medication['strength_unit_id']) && $medication['strength_unit_id'] != '') ? $medication['strength_unit_id'] : '1',
            'prescribed_by' => (isset($medication['prescribed_by']) && $medication['prescribed_by'] != '') ? $medication['prescribed_by'] : '',
            'frequency' => (isset($medication['frequency']) && $medication['frequency'] != '') ? $medication['frequency'] : '',
            'start_date' => (isset($medication['start_date']) && $medication['start_date'] != '') ? date('Y-m-d',strtotime($medication['start_date'])) : NULL,
            'dispense_unit_id' => (isset($medication['dispense_unit_id']) && $medication['dispense_unit_id'] != '') ? $medication['dispense_unit_id'] : '0',
            'user_id' => $patientID,
            'clinic_id' => $clinicID,
            'source_type_id' => $sourceType,
            'created_by' => $createdBy,
            'created_at' => Carbon\Carbon::now(),
        ));
    }
    public static function updateMedication($key,$medication,$conditionID,$updatedBy){
        DB::table('medications')->where('medication_uuid',$key)->update(array(
            'medicine_id' => (isset($medication['medicine_id']) && $medication['medicine_id'] != '') ? $medication['medicine_id'] : '0',
            'condition_id' => $conditionID,
            'quantity' => (isset($medication['quantity']) && $medication['quantity'] != '') ? $medication['quantity'] : 0,
            'medicine_name' => (isset($medication['medicine_name']) && $medication['medicine_name'] != '') ? $medication['medicine_name'] : '',
            'strength' => (isset($medication['strength']) && $medication['strength'] != '') ? $medication['strength'] : 0,
            'strength_unit_id' => (isset($medication['strength_unit_id']) && $medication['strength_unit_id'] != '') ? $medication['strength_unit_id'] : '1',
            'prescribed_by' => (isset($medication['prescribed_by']) && $medication['prescribed_by'] != '') ? $medication['prescribed_by'] : '',
            'frequency' => (isset($medication['frequency']) && $medication['frequency'] != '') ? $medication['frequency'] : '',
            'start_date' => (isset($medication['start_date']) && $medication['start_date'] != '') ? date('Y-m-d',strtotime($medication['start_date'])) : NULL,
            'dispense_unit_id' => (isset($medication['dispense_unit_id']) && $medication['dispense_unit_id'] != '') ? $medication['dispense_unit_id'] : '0',
            'updated_by' => $updatedBy,
            'updated_at' => Carbon\Carbon::now(),
        ));
    }
    public static function getMedication($userID,$page='1',$clinicID){
        $perPage = request()->get('perPage', 10);
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('medications')->whereNull('medications.deleted_at')->orderBy('id', 'desc')->where('user_id',$userID)->where('clinic_id',$clinicID)->paginate('10', ['*'], 'page', $page);

        return $medicalDetails ;
    }
    public static function getMedications($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('medications')->whereNull('medications.deleted_at')->orderBy('id', 'desc')->where('user_id',$userID)->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);
        
        return $medicalDetails ;
    }
    public static function getMedicationByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('medications')->whereNull('deleted_at')->where('medication_uuid',$key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function deleteMedication($key){
        DB::table('medications')->where('medication_uuid',$key)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }
    public static function getMedicationByMedicine($userID,$medicineID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('medications')->where('user_id',$userID)->where('medicine_id',$medicineID)->where('source_type_id',$sourceType)->whereNull('medications.deleted_at')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getMedicationByMedicineName($userID,$medicineName,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('medications')->where('user_id',$userID)->where('medicine_name',$medicineName)->where('source_type_id',$sourceType)->whereNull('medications.deleted_at')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    
    public static function getDoseSpotMedications($userID,$clinicID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('medications')->select('id','user_id','dosespot_prescription_id')->where('user_id',$userID)->where('clinic_id',$clinicID)->where('source_type_id',$sourceType)->whereNull('medications.deleted_at')->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    
    public static function addDoseSpotMedication($medInfo){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('8', 'medications', 'medication_uuid');
        $conditionData = DB::table('medications')->insertGetId(array(
            'medication_uuid'   => $key,
            'medicine_name'     => (isset($medInfo['medicine_name']) )  ? $medInfo['medicine_name'] : '',
            'quantity'          => (isset($medInfo['quantity']) && $medInfo['quantity'] != '') ? $medInfo['quantity'] : 0,
          //  'strength'          => (isset($medInfo['strength']) && $medInfo['strength'] != '') ? $medInfo['strength'] : 0,
            'prescribed_by'     => (isset($medInfo['prescribed_by']) && $medInfo['prescribed_by'] != '') ? $medInfo['prescribed_by'] : '',
            'frequency'         => (isset($medInfo['frequency']) && $medInfo['frequency'] != '') ? $medInfo['frequency'] : '',
            'start_date'        => (isset($medInfo['start_date']) && $medInfo['start_date'] != '') ? $medInfo['start_date'] : NULL,
            'dispense_unit_id' => (isset($medInfo['dispense_unit_id']) && $medInfo['dispense_unit_id'] != '') ? $medInfo['dispense_unit_id'] : '0',
            'user_id'           => (isset($medInfo['user_id']) && $medInfo['user_id'] != '') ? $medInfo['user_id'] : '0',
            'clinic_id'         => (isset($medInfo['clinic_id']) && $medInfo['clinic_id'] != '') ? $medInfo['clinic_id'] : '0',
            'source_type_id'    => (isset($medInfo['source_type_id']) && $medInfo['source_type_id'] != '') ? $medInfo['source_type_id'] : '0',
            'dosespot_prescription_id'    => (isset($medInfo['dosespot_prescription_id']) && $medInfo['dosespot_prescription_id'] != '') ? $medInfo['dosespot_prescription_id'] : NULL,
            'dosespot_medication_data'    => (isset($medInfo['dosespot_medication_data']) ) ? $medInfo['dosespot_medication_data'] : NULL,
            'dispense_unit_id'    => (isset($medInfo['dispense_unit_id']) ) ? $medInfo['dispense_unit_id'] : NULL,
            'created_at'        => Carbon\Carbon::now(),
        ));
    }
     public static function dispenseUnitByDosespotIDS($dispenseUnitIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
        if( empty($dispenseUnitIDS)){ return array(); }
        $result = $Corefunctions->convertToArray(DB::table('ref_medication_dispense_units')->select('id', 'form', 'dosepsot_dispense_unit_id')->whereIn('dosepsot_dispense_unit_id', $dispenseUnitIDS)->get());
        $result =    $Corefunctions->getArrayIndexed1($result,'dosepsot_dispense_unit_id');

        return $result ;
	}
      public static function removeMedications($userID,$dosespotIDS,$clinicID){
        DB::table('medications')->where('user_id',$userID)->whereIn('dosespot_prescription_id',$dosespotIDS)->where('clinic_id',$clinicID)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }
    
    
}
