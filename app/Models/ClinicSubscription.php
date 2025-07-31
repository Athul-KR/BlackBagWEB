<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use Carbon;
use DB;

class ClinicSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clinic_subscriptions';

    public static function getClinicSubscriptions($clinicId,$currentSubscriptionId='0'){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subscription = $Corefunctions->convertToArray(self::where('clinic_id',$clinicId)->where('id','!=',$currentSubscriptionId)->whereNull('deleted_at')->orderBy('sort_order','asc')->get());
        return $subscription ;
    }
    public static function getPatientClinicSubscriptions($clinicId,$currentSubscriptionId='0'){
        $Corefunctions = new \App\customclasses\Corefunctions;
        // ->where('id','!=',$currentSubscriptionId)
        $subscription = $Corefunctions->convertToArray(self::where('clinic_id',$clinicId)->whereNull('deleted_at')->orderBy('annual_amount','asc')->get());
        return $subscription ;
    }
    public static function getClinicGenericSubscription($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subscription = $Corefunctions->convertToArray(self::select('id','is_generic')->where('clinic_id',$clinicId)->where('is_generic','1')->whereNull('deleted_at')->get());
        return $subscription ;
    }
    public static function getAllGenericPlan(){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subscription = $Corefunctions->convertToArray(DB::table('generic_subscriptions')->whereNull('deleted_at')->get());
        return $subscription ;
    }
    public static function getClinicSubscriptionByKey($clinicId,$key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subscription = $Corefunctions->convertToArray(self::where('clinic_id',$clinicId)->where('clinic_subscription_uuid',$key)->whereNull('deleted_at')->first());
        return $subscription ;
    }
    public static function getPlanCount($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $planCount = $Corefunctions->convertToArray(self::where('clinic_id',$clinicId)->whereNull('deleted_at')->count());
        $planCount ++ ;
        return $planCount ;
    }
    public static function getClinicSubscriptionById($clinicId,$id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subscription = $Corefunctions->convertToArray(self::where('clinic_id',$clinicId)->where('id',$id)->whereNull('deleted_at')->first());
        return $subscription ;
    }
    public static function getClinicSubscriptionByUuid($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subscription = $Corefunctions->convertToArray(self::where('clinic_subscription_uuid',$key)->whereNull('deleted_at')->first());
        return $subscription ;
    }

    public static function insertPlan($clinicId,$input,$clinicDetails,$isgeneric='0',$planCount){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $insertid = DB::table('clinic_subscriptions')->insertGetId([
            'clinic_subscription_uuid' => $Corefunctions->generateUniqueKey('8', 'clinic_subscriptions', 'clinic_subscription_uuid') ,
            'plan_name'               => $input['plan_name'],
            'description'             => $input['description'],
            'monthly_amount'          => $input['monthly_amount'],
            'annual_amount'           => $input['annual_amount'],
            'has_per_appointment_fee' => isset($input['has_per_appointment_fee']) && $input['has_per_appointment_fee'] == 'on' ? 1 : 0,
            'inperson_fee'            => isset($input['inperson_fee']) &&  $input['inperson_fee'] !='' && (isset($input['has_per_appointment_fee']) && $input['has_per_appointment_fee']) ? $input['inperson_fee'] :($clinicDetails['inperson_fee'] !='' ? $clinicDetails['inperson_fee'] : 0),
            'virtual_fee'             => isset($input['virtual_fee']) &&  $input['virtual_fee'] !='' && (isset($input['has_per_appointment_fee']) && $input['has_per_appointment_fee']) ? $input['virtual_fee'] : ($clinicDetails['virtual_fee'] !='' ? $clinicDetails['virtual_fee'] : 0),
            'created_at'              => Carbon\Carbon::now(),
            'is_generic'              => $isgeneric,
            'created_by'              => Session::get('user.userID'),
            'clinic_id'               => $clinicId,
            'sort_order'              => $planCount,
            'plan_icon_id'            => $input['plan_icon_id'],
        ]);
        return  $insertid ;
    }
    public static function updateSubscriptionPlan($clinicId,$input,$clinicDetails){
      
        return  DB::table('clinic_subscriptions')->where('clinic_subscription_uuid', $input['subscription_uuid'])->update(array(
            'plan_name'               => $input['plan_name'],
            'description'             => $input['description'],
            'monthly_amount'          => $input['monthly_amount'],
            'annual_amount'           => $input['annual_amount'],
            'has_per_appointment_fee' => isset($input['has_per_appointment_fee']) && $input['has_per_appointment_fee'] == 'on' ? '1' : 0,
            'inperson_fee'            => isset($input['inperson_fee']) &&  $input['inperson_fee'] !='' ? $input['inperson_fee'] :($clinicDetails['inperson_fee'] !='' ? $clinicDetails['inperson_fee'] : 0),
            'virtual_fee'             => isset($input['virtual_fee']) &&  $input['virtual_fee'] !='' ? $input['virtual_fee'] : ($clinicDetails['virtual_fee'] !='' ? $clinicDetails['virtual_fee'] : 0),
            'plan_icon_id'            => $input['plan_icon_id'],
            "updated_at"              => Carbon\Carbon::now()
        ));
    }

    public static function deleteSubscriptionPlan($clinicId,$key){
        return  DB::table('clinic_subscriptions')->where('clinic_subscription_uuid', $key)->update(array(
            
            "deleted_at"              => Carbon\Carbon::now()
        ));
    }

    public static function getSubscriptionsbyIDs($ids){
        $Corefunctions = new \App\customclasses\Corefunctions;

        return  $Corefunctions->convertToArray(DB::table('clinic_subscriptions')->whereIn('id',$ids)->get());
    }
 
} 