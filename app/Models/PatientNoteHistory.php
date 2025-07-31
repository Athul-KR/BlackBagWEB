<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;
use Session;
class PatientNoteHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function insertHistory($patientDetails){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $insertid = DB::table('patient_note_histories')->insertGetId(array(

            'patient_id'    => $patientDetails->id ,
            'user_id'       => $patientDetails->user_id ,
            'clinic_id'     => session()->get('user.clinicID') ,
            'updated_by'    => session()->get('user.userID'),
            'created_at'    => Carbon\Carbon::now()
        ));
        return $insertid ;
    }


}
