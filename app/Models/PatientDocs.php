<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;
use Session;

class PatientDocs extends Model
{
    use HasFactory,SoftDeletes;

    public static function getPatientDocs($patient_id)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $docdetails = $Corefunctions->convertToArray(PatientDocs::where('patient_id', $patient_id)->whereNull('deleted_at')->get());
        return $docdetails;
    }
    public static function getPatientDocsByKey($key)
    {
        $docdetails = self::where('patient_doc_uuid', $key)->whereNull('deleted_at')->first();
        return $docdetails;
    }
    public static function removePatientDoc($key)
    {
        DB::table('patient_docs')->where('patient_doc_uuid', $key)->update(array(
            'deleted_at' => Carbon\Carbon::now()
        ));
    }
    public static function savePatientDocuments($tempDoc, $filesize, $patient){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $dockey = $Corefunctions->generateUniqueKey(8, 'patient_docs', 'patient_doc_uuid');

        $documentId = DB::table('patient_docs')->insertGetId(array(
            'patient_doc_uuid' => $dockey,
            'patient_id' => $patient->id,
            'orginal_name' => $tempDoc['original_name'],
            'doc_ext' => $tempDoc['temp_doc_ext'],
            'file_size' => $filesize,
            'created_at' => Carbon\Carbon::now(),
            'uploaded_by' => session()->get('user.userID'),
        ));
    }
    public static function updatePatientDocImage($docid, $imagepath){
        DB::table('patient_docs')->where('id', $docid)->update(array(
            'doc_path' => $imagepath,
        ));
    }
}
