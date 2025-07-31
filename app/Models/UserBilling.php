<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class UserBilling extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'user_billing';

    public static function getUserBillingByUserId($userId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userBilling = $Corefunctions->convertToArray(DB::table('user_billing')->where('user_id',$userId)->first());
        return $userBilling;
    }
    public static function getUserBillingCount($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userBillingCount = $Corefunctions->convertToArray(DB::table('user_billing')->where('clinic_id', $clinicId)->whereNull('parent_type')->whereNull('deleted_at')->limit(1)->count());
        return $userBillingCount;
	}
    public static function getUserBilling($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userBilling = $Corefunctions->convertToArray(DB::table('user_billing')->select('user_billing_uuid', 'billing_address','billing_company_name','billing_phone','billing_city','billing_state_id','billing_country_id','billing_zip','billing_state_other','billing_country_code','billing_email')->whereNull('parent_type')->where('clinic_id', $clinicId)->whereNull('deleted_at')->first());
        return $userBilling;
	}
    public static function getBillingInfo($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $billingCheck = DB::table('user_billing')->whereNull('parent_type')->where('clinic_id', $clinicId)->whereNull('deleted_at')->first();
        $billingCheck = $Corefunctions->convertToArray($billingCheck);
        return $billingCheck;
    }
    public static function saveBillingData($inputParams,$userId,$userBillingKey,$clinicID,$countryCodedetails,$parent_type=''){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $clinicDets = $Corefunctions->convertToArray(DB::table('clinics')->where('id', $clinicID)->first());
        $addressId= DB::table('user_billing')->insertGetId(array(
            'user_billing_uuid' => $userBillingKey,
            'billing_company_name' => ( isset( $inputParams['company_name'] ) && $inputParams['company_name'] != '' ) ? trim($inputParams['company_name']) : $clinicDets['name'],
            'billing_country_id' => ( isset( $inputParams['country_id'] ) && $inputParams['country_id'] != '' ) ? trim($inputParams['country_id']) : NULL,
            'billing_country_code' => !empty($countryCodedetails) ? $countryCodedetails['id'] : NULL,
            'billing_phone' => ( isset( $inputParams['phone_number'] ) && $inputParams['phone_number'] != '' ) ? trim($inputParams['phone_number']) : NULL,
            'billing_address' => ( isset( $inputParams['address'] ) && $inputParams['address'] != '' ) ? trim($inputParams['address']) : NULL,
            'billing_city' => ( isset($inputParams['city']) && $inputParams['city']!='' ) ? trim($inputParams['city']) : NULL,
            'billing_zip' => (isset($inputParams['zip']) && $inputParams['zip']!='') ? trim($inputParams['zip']) : NULL,
            'billing_state_id' => (isset($inputParams['state_id']) && $inputParams['state_id']!='') ? trim($inputParams['state_id']) : NULL,
            'billing_state_other' => (isset($inputParams['state']) && $inputParams['state']!='') ? trim($inputParams['state']) : NULL,
            'user_id' => $userId,
            'clinic_id' => $clinicID,
            'parent_type' =>isset($parent_type) && $parent_type !='' ? $parent_type : NULL  ,
            'created_at' => Carbon\Carbon::now()
        ));
    }
    public static function updateBillingData($userBillID,$inputParams,$countryCodedetails){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $billingInfo = $Corefunctions->convertToArray(DB::table('user_billing')->where('id',$userBillID)->first());
        $addressId= DB::table('user_billing')->where('id',$userBillID)->update(array(
            'billing_company_name' => ( isset( $inputParams['company_name'] ) && $inputParams['company_name'] != '' ) ? trim($inputParams['company_name']) : $billingInfo['billing_company_name'],
            'billing_country_id' => ( isset( $inputParams['country_id'] ) && $inputParams['country_id'] != '' ) ? trim($inputParams['country_id']) : $billingInfo['billing_country_id'],
            'billing_country_code' => !empty($countryCodedetails) ? $countryCodedetails['id'] : $billingInfo['billing_country_code'],
            'billing_phone' => ( isset( $inputParams['phone_number'] ) && $inputParams['phone_number'] != '' ) ? trim($inputParams['phone_number']) : $billingInfo['billing_phone'],
            'billing_address' => ( isset( $inputParams['address'] ) && $inputParams['address'] != '' ) ? trim($inputParams['address']) : $billingInfo['billing_address'],
            'billing_city' => ( isset($inputParams['city']) && $inputParams['city']!='' ) ? trim($inputParams['city']) : $billingInfo['billing_city'],
            'billing_zip' => (isset($inputParams['zip']) && $inputParams['zip']!='') ? trim($inputParams['zip']) : $billingInfo['billing_zip'],
            'billing_state_id' => (isset($inputParams['state_id']) && $inputParams['state_id']!='') ? trim($inputParams['state_id']) : $billingInfo['billing_state_id'],
            'billing_state_other' => (isset($inputParams['state']) && $inputParams['state']!='') ? trim($inputParams['state']) : $billingInfo['billing_state_other'],
            'updated_at' => Carbon\Carbon::now()
        ));
    }
    public static function getUserBillingByUserIds($userIds){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userBilling = $Corefunctions->convertToArray(DB::table('user_billing')->whereIn('user_id', $userIds)->whereNull('deleted_at')->get());
        return $userBilling;
    }
}
