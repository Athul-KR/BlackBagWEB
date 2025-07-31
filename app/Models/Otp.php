<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;

class Otp extends Model
{
    use HasFactory,SoftDeletes;

    public static function updateOtp($value,$type)
    {
        DB::table('otps')->where($type, $value)->where('is_used', '0')->update(array(
            'deleted_at'    =>  Carbon\Carbon::now(),
            "is_used"       => '1',
            'updated_at'    =>  Carbon\Carbon::now(),
        ));
    }
    public static function getOtpDetails($input)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $otpDetails = $Corefunctions->convertToArray(Otp::select('phone_number', 'expiry_on', 'email')
                ->where('otp_uuid', $input['otpkey'])
                ->where('otp', $input['otp'])
                ->where('is_used', '0')
                ->whereNull('deleted_at')
                ->first()
        );
        return $otpDetails;
    }
    public static function insertOtp($phoneNumber,$countryCode,$otpUuid,$userotp)
    {
        $expiryOn = time() + (3 * 60);
        DB::table('otps')->insertGetId(array(
            'otp_uuid' => $otpUuid ,
            'otp' => $userotp ,
            'phone_number' => $phoneNumber ,
            'is_used' => '0' ,
            'country_id' => !empty($countryCode) ? $countryCode['id'] : 1 ,
            'expiry_on' => $expiryOn ,
            'created_at'    =>  Carbon\Carbon::now(),
        ));


    }

}
