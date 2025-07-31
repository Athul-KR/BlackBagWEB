<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [''];

    public static function insertInquiry($input){
   
        $insertid = DB::table('inquiries')->insertGetId(array(
          
            'name'          => $input['name'],
            'email'         => isset($input['email']) ? $input['email'] : null,
            'phone_number'  => isset($input['phone_number']) ? $input['phone_number'] : null ,
            'country_code'  =>  isset($input['countrycode']) ? $input['countrycode'] : null ,
            'message'       => isset($input['message']) && !empty($input['message']) ? $input['message'] : null,
            'last_name'     => isset($input['last_name']) ? $input['last_name'] : null,
            'clinic_name'   => isset($input['clinic_name']) ? $input['clinic_name'] : null,
            'server_info'   => json_encode($_SERVER),
            'ip_address'    => $_SERVER['REMOTE_ADDR'],
            'created_at'    => Carbon\Carbon::now()

        ));
        return $insertid ;
    }

}
