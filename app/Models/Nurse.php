<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Nurse extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];




    //CreatedBy Updated by Accessors Formatting
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    //Relation on Designations
    public function designation()
    {
        return $this->hasOne(RefDesignation::class, 'id', 'designation_id');
    }

    public function ClinicUsers()
    {
        return $this->hasMany(ClinicUser::class, 'parent_id', 'id');
    }




    public static function insertConsultantExcelData($input,$import_key,$clinic_id)
    {

        $id = DB::table('import_docs')->insertGetId(array(
            'import_doc_uuid'      => $input['import_doc_uuid'],
            'parent_type'          => $input['type'],
            'name'                 => $input['name'],
            'email'                => $input['email'],
            'phone_number'         => $input['phone_number'],
            'department'           => $input['department'],
            'specialty_id'         => $input['specialty'],
            // 'qualification'        => $input['qualification'],
            'user_id'              => $input['userID'],
            'country_code'         => $input['country_code'],
            'error'                 => isset($input['error']) ? $input['error'] : null ,
            'is_exists' => isset($input['is_exists']) ? $input['is_exists'] : '0' ,
            'status'  => isset($input['status']) ? $input['status'] : '0' ,
            'import_key' =>  $import_key ,
            'clinic_id' => $clinic_id

        ));
        return $id;

        // $id = DB::table('import_docs')->insertGetId(array(
        //     'import_doc_uuid'      => $input['import_doc_uuid'],
        //     'parent_type'          => $input['type'],
        //     'name'                 => $input['name'],
        //     'email'                => $input['email'],
        //     'phone_number'         => $input['phone'],
        //     // 'designation_id'       => isset($input['designation']) ? $input['designation'] : null,
        //     'specialty_id'         => isset($input['specialty']) ? $input['specialty'] : null,
        //     'qualification'        => isset($input['qualification']) ? $input['qualification'] : null ,
        //     'user_id'              => $input['userID'],
        //     'gender'               => isset($input['gender']) ? $input['gender'] : null ,
        //     'dob'                  =>  (isset($input['dob']) && $input['dob']!='')?  date('Y-m-d',strtotime($input['dob'])) : NULL,
        //     'address'              => isset($input['address']) ? $input['address'] : null ,
        //     'city'                 => isset($input['city']) ? $input['city'] : null ,
        //     'state'                => isset($input['state']) ? $input['state'] : null ,
        //     'zip'                  => isset($input['zip']) ? $input['zip'] : null ,
        //     'notes'                => isset($input['note']) ? $input['note'] : null ,
        //     'whatsapp_number'      => isset($input['whatsappnumber']) ? $input['whatsappnumber'] : null ,
        //     'country_code'         => isset($input['country_code']) ? $input['country_code'] : null ,
        //     'whatsapp_country_code'=> isset($input['whatsapp_country_code']) ? $input['whatsapp_country_code'] : null ,
        //     'error'                 => isset($input['error']) ? $input['error'] : null ,
        //     'is_exists' => isset($input['is_exists']) ? $input['is_exists'] : '0' ,
        //     'status'  => isset($input['status']) ? $input['status'] : '0' ,
        //     'import_key' =>  $import_key ,
        //     'clinic_id' => $clinic_id
            
        // ));
    }
}
