<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Consultant extends Model
{
    use HasFactory, SoftDeletes;

    public static function insertConsultantExcelData($input,$import_key,$clinic_id)
    {
        $id = DB::table('import_docs')->insertGetId(array(
            'import_doc_uuid'      => $input['import_doc_uuid'],
            'parent_type'          => $input['type'],
            'name'                 => $input['name'],
            'email'                => $input['email'],
            'phone_number'         => $input['phone_number'],
            'designation_id'       => isset($input['designation']) ? $input['designation'] : null,
            'specialty_id'         => isset($input['specialty']) ? $input['specialty'] : null,
            'npi_number'           => isset($input['npi_number']) ? $input['npi_number'] : null ,
            'user_id'              => $input['userID'],
            'gender'               => isset($input['gender']) ? $input['gender'] : null ,
            'dob'                  => (isset($input['dob']) && $input['dob']!='')?  date('Y-m-d',strtotime($input['dob'])) : NULL,
            'address'              => isset($input['address']) ? $input['address'] : null ,
            'city'                 => isset($input['city']) ? $input['city'] : null ,
            'state'                => isset($input['state']) ? $input['state'] : null ,
            'zip'                  => isset($input['zip']) ? $input['zip'] : null ,
            'notes'                => isset($input['note']) ? $input['note'] : null ,
            'whatsapp_number'      => isset($input['whatsappnumber']) ? $input['whatsappnumber'] : null ,
            'country_code'         => isset($input['country_code']) ? $input['country_code'] : null ,
            'whatsapp_country_code'=> isset($input['whatsapp_country_code']) ? $input['whatsapp_country_code'] : null ,
            'error'                => isset($input['error']) ? $input['error'] : null ,
            'is_exists'            => isset($input['is_exists']) ? $input['is_exists'] : '0' ,
            'status'               => isset($input['status']) ? $input['status'] : '0' ,
            'import_key'           => $import_key ,
            'clinic_id'            => $clinic_id
            
        ));
        return $id;
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'consultant_id')->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Adjust the foreign key if necessary
    }
    
    


    // public function clinicConsultants()
    // {
    //     return $this->hasMany(ClinicConsultant::class,  'consultant_id', 'id');
    // }

    public function ClinicUsers()
    {
        return $this->hasMany(ClinicUser::class, 'parent_id', 'id');
    }
}
