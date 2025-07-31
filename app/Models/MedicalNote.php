<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
use Session;

class MedicalNote extends Model
{
    use HasFactory, SoftDeletes;

    public static function insertMedicalNotes($input,$clinicID,$createdBy,$patientID){

        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('8', 'medical_notes', 'medical_note_uuid');

        $insertid =   DB::table('medical_notes')->insertGetId(array(
            'medical_note_uuid' => $key,
            'summary' => $input['note'],
            'subjective' => isset( $input['subjective']) && $input['subjective'] !='' ? $input['subjective'] : null , 
            'objective' => isset( $input['objective']) && $input['objective'] !='' ? $input['objective'] : null , 
            'assessment' => isset( $input['assessment']) && $input['assessment'] !='' ? $input['assessment'] : null , 
            'plan' => isset( $input['plan']) && $input['plan'] !='' ? $input['plan'] : null , 
            'show_to_patient' => isset( $input['allowPatient']) && $input['allowPatient'] =='on' ? 1 : 0 , 
            'is_soap_note' => isset( $input['is_soap_note']) && $input['is_soap_note'] !='' ? $input['is_soap_note'] : 0 , 
            // 'video_scribe' => isset( $input['video_scribe']) && $input['video_scribe'] !='' ? $input['video_scribe'] : null , 
            // 'call_id' => isset( $input['call_id']) && $input['call_id'] !='' ? $input['call_id'] : null , 
            'appointment_id' => isset( $input['appointment_id']) && $input['appointment_id'] !='' ? $input['appointment_id'] : null , 
            'user_id'   => $patientID ,
            'clinic_id' => $clinicID,
            'created_by' => $createdBy,
            'created_at' => Carbon::now(),
        ));
        return   $insertid ;
    }

    public static function updateMedicalNotes($input,$updated,$medicalnotekey){

        DB::table('medical_notes')->where('medical_note_uuid',$medicalnotekey)->update(array(
            'summary' => $input['note'],
            'subjective' => isset( $input['subjective']) && $input['subjective'] !='' ? $input['subjective'] : null , 
            'objective' => isset( $input['objective']) && $input['objective'] !='' ? $input['objective'] : null , 
            'assessment' => isset( $input['assessment']) && $input['assessment'] !='' ? $input['assessment'] : null , 
            'plan' => isset( $input['plan']) && $input['plan'] !='' ? $input['plan'] : null , 
            'show_to_patient' => isset( $input['allowPatient']) && $input['allowPatient'] =='on' ? 1 : 0 , 
            'is_soap_note' => isset( $input['is_soap_note']) && $input['is_soap_note'] !='' ? $input['is_soap_note'] : 0 ,
            'updated_by' => $updated,
            'updated_at' => Carbon::now(),
        ));

       

        return   $medicalnotekey ;
    }


    public static function insertMedicalNoteIcd10Codes($medicalNoteID,$codeID){

        $insertid =   DB::table('medical_notes_icd10_codes')->insertGetId(array(
            'medical_note_id' => $medicalNoteID,
            'icd10_code_id' => $codeID,
            'created_at' => Carbon::now(),
        ));

        return   $insertid ;
    }
    public static function getMedicalNotesByUser($userID,$clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalNotes =  $Corefunctions->convertToArray(self::select('id','created_at','medical_note_uuid','video_scribe','is_soap_note','created_by')->where('user_id',$userID)->where('clinic_id',$clinicID)->whereNull('deleted_at')->latest()->take(5)->get()) ;
        return $medicalNotes ;
    }
    public static function getMedicalNotesByKey($key,$userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalNotes =  $Corefunctions->convertToArray(self::where('medical_note_uuid',$key)->where('user_id',$userID)->whereNull('deleted_at')->first()) ;
        return $medicalNotes ;
    }
    public static function notesDetailsByID($id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalNotes =  $Corefunctions->convertToArray(self::where('id',$id)->whereNull('deleted_at')->first()) ;
        return $medicalNotes ;
    }

    public static function getAllMedicalNotesByUser($userID,$page,$usertype,$appointmentid=''){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalNotes = self::where('user_id',$userID)->whereNull('deleted_at');
        if($usertype == 'patient'){
            $medicalNotes =  $medicalNotes->where('show_to_patient','1');
        }
        if(isset($appointmentid) && $appointmentid != ''){
            $medicalNotes =  $medicalNotes->where('appointment_id',$appointmentid);
        }
        $medicalNotes =  $medicalNotes->orderBy('id', 'desc')->paginate('10', ['*'], 'page', $page) ;
        return $medicalNotes ;
    }

    public static function getNotesIcdCodes($medicalNoteId){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalNotes =  $Corefunctions->convertToArray(DB::table('medical_notes_icd10_codes')->where('medical_note_id',$medicalNoteId)->whereNull('deleted_at')->get()) ;
        return $medicalNotes ;
    }
     
    
    public static function getIcdCodesByIDs($ids){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalNotes =  $Corefunctions->convertToArray(DB::table('ref_icd10_codes')->whereIn('id',$ids)->whereNull('deleted_at')->get()) ;
        return $medicalNotes ;
    }

    public static function deleteMedicalNotes($medicalNoteID,$deletedBy){

        DB::table('medical_notes')->where('id',$medicalNoteID)->update(array(
            'deleted_at' => Carbon::now(),
            'deleted_by' => $deletedBy
        ));

        DB::table('medical_notes_icd10_codes')->where('medical_note_id',$medicalNoteID)->update(array(
            'deleted_at' => Carbon::now(),
        ));

        return   $medicalNoteID ;
    }
    public static function insertMedicalNotesTranscript($input){

        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('8', 'medical_notes', 'medical_note_uuid');
        $medicalNotes = DB::table('medical_notes')->where('appointment_id',$input['appointment_id'])->where('call_id',$input['call_id'])->where('video_scribe',$input['video_scribe'])->first();
        if(empty($medicalNotes)){
            $insertid =   DB::table('medical_notes')->insertGetId(array(
                'medical_note_uuid' => $key,
                'video_scribe' => isset( $input['video_scribe']) && $input['video_scribe'] !='' ? $input['video_scribe'] : null , 
                'call_id' => isset( $input['call_id']) && $input['call_id'] !='' ? $input['call_id'] : null , 
                'appointment_id' => isset( $input['appointment_id']) && $input['appointment_id'] !='' ? $input['appointment_id'] : null , 
                'user_id'   => isset( $input['user_id']) && $input['user_id'] !='' ? $input['user_id'] : null  ,
                'clinic_id' => isset( $input['clinic_id']) && $input['clinic_id'] !='' ? $input['clinic_id'] : null ,
                'created_by' => NULL,
                'created_at' => Carbon::now(),
            ));
            return   $insertid ;
        }else{
            return $medicalNotes->id;
        }
    }
   public static function updateMedicalNotesTranscript($input,$medicalNoteID){

         return DB::table('medical_notes')->where('id',$medicalNoteID)->update($input);
       
    }

    public static function deleteIcdCode($codeid,$medicalNoteid){

        DB::table('medical_notes_icd10_codes')->where('icd10_code_id',$codeid)->where('medical_note_id',$medicalNoteid)->update(array(
            'deleted_at' => Carbon::now(),
        ));
       
    }
}
