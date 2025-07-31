<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;
use Session;

class PatientSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function getPatientSubscription($patientId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $patientSubscriptions = $Corefunctions->convertToArray(DB::table('patient_subscriptions')->join('clinic_subscriptions','clinic_subscriptions.id','=','patient_subscriptions.clinic_subscription_id')->where('patient_subscriptions.status','1')->where('patient_subscriptions.patient_id',$patientId)->first());
        return $patientSubscriptions ;
    }
    public static function getPatientSubscriptionNew($clinicId,$patientId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $patientSubscriptions = $Corefunctions->convertToArray(DB::table('patient_subscriptions')->join('clinic_subscriptions','clinic_subscriptions.id','=','patient_subscriptions.clinic_subscription_id')->where('patient_subscriptions.status','1')->where('patient_subscriptions.patient_id',$patientId)->where('patient_subscriptions.clinic_id',$clinicId)->first());
        return $patientSubscriptions ;
    }
    public static function getPatientSubscriptionByKey($clinicId,$key){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $patientSubscriptions = $Corefunctions->convertToArray(DB::table('patient_subscriptions')->join('clinic_subscriptions','clinic_subscriptions.id','=','patient_subscriptions.clinic_subscription_id')->where('patient_subscriptions.status','1')->where('patient_subscriptions.patient_subscription_uuid',$key)->where('patient_subscriptions.clinic_id',$clinicId)->first());
        return $patientSubscriptions ;
    }

    public static function insertPatientSubscriptionHistory($clinicId,$patientId,$clinicSubscription,$paymentId,$monthlychecked='0'){
        $endDate = ($monthlychecked=='1') ? Carbon\Carbon::now()->addMonth()->format('Y-m-d') : Carbon\Carbon::now()->addYear()->format('Y-m-d');
        $insertid = DB::table('patient_subscription_history')->insertGetId([
            'clinic_id'                         => $clinicId,
            'patient_id'                        => $patientId,
            'clinic_subscription_id'            => $clinicSubscription['id'],
            'start_date'                        => date('Y-m-d'),
            'end_date'                          => $endDate,
            'amount'                            => ($monthlychecked=='1') ? $clinicSubscription['monthly_amount'] : $clinicSubscription['annual_amount'],
            'payment_id'                        => $paymentId,
            'created_at'                        => Carbon\Carbon::now(),
        ]);
        return  $insertid ;
    }

    public static function insertPatientSubscription($clinicId,$patientId,$clinicSubscription,$historyId,$monthlychecked='0'){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $endDate = ($monthlychecked=='1') ? Carbon\Carbon::now()->addMonth() : Carbon\Carbon::now()->addYear();
        $renewalDate = $endDate->copy()->addDay();
          
        $insertid = DB::table('patient_subscriptions')->insertGetId([
            'patient_subscription_uuid'         => $Corefunctions->generateUniqueKey('8', 'patient_subscriptions', 'patient_subscription_uuid'),
            'clinic_id'                         => $clinicId,
            'patient_id'                        => $patientId,
            'clinic_subscription_id'            => $clinicSubscription['id'],
            'start_date'                        => date('Y-m-d'),
            'end_date'                          => $endDate->format('Y-m-d'),
            'amount'                            => ($monthlychecked=='1') ? $clinicSubscription['monthly_amount'] : $clinicSubscription['annual_amount'],
            'patient_subscription_history_id'   => $historyId,
            'renewal_plan_id'                   => $clinicSubscription['id'],
            'renewal_date'                      => $renewalDate->format('Y-m-d'),
            'tenure_type_id'                    => ($monthlychecked=='1') ? 1 : 2,
            'renewal_plan_tenure_type_id'       => ($monthlychecked=='1') ? 1 : 2,
            'created_at'                        => Carbon\Carbon::now(),
        ]);
        return  $insertid ;
    }
    public static function updatetPatientSubscriptionStatus($subscriptionkey){
        $insertid = DB::table('patient_subscriptions')->where('patient_subscription_uuid',$subscriptionkey)->update([
            'status'            => '0',
            'deleted_at'        => Carbon\Carbon::now(),
            
        ]);
    }
   

    public static function updatePatientSubscription($subscriptionkey,$clinicId,$clinicSubscription,$historyId,$monthlychecked='0'){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $endDate = ($monthlychecked=='1') ? Carbon\Carbon::now()->addMonth() : Carbon\Carbon::now()->addYear();
        $renewalDate = $endDate->copy()->addDay();
          
        $insertid = DB::table('patient_subscriptions')->where('patient_subscription_uuid',$subscriptionkey)->update([
            'clinic_id'                         => $clinicId,
            'clinic_subscription_id'            => $clinicSubscription['id'],
            'start_date'                        => date('Y-m-d'),
            'end_date'                          => $endDate->format('Y-m-d'),
            'amount'                            => ($monthlychecked=='1') ? $clinicSubscription['monthly_amount'] : $clinicSubscription['annual_amount'],
            'patient_subscription_history_id'   => $historyId,
            'renewal_plan_id'                   => $clinicSubscription['id'],
            'renewal_date'                      => $renewalDate->format('Y-m-d'),
            'tenure_type_id'                    => ($monthlychecked=='1') ? 1 : 2,
            'renewal_plan_tenure_type_id'       => ($monthlychecked=='1') ? 1 : 2,
            'updated_at'                        => Carbon\Carbon::now(),
        ]);
        return  $insertid ;
    }
    public static function updateRenewalPlanID($subscriptionkey,$clinicSubscription,$monthlychecked){
        $insertid = DB::table('patient_subscriptions')->where('patient_subscription_uuid',$subscriptionkey)->update([
            'renewal_plan_id'                   => $clinicSubscription['id'],
            'renewal_plan_tenure_type_id'       => ($monthlychecked=='1') ? 1 : 2,
            'updated_at'                        => Carbon\Carbon::now(),
        ]);
        return  $insertid ;
    }


    public static function getPatientSubscriptionsByRenewDate($renewDate){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $patientSubscriptions = DB::table('patient_subscriptions')->select('id','patient_id','clinic_subscription_id','renewal_date','patient_subscription_history_id','renewal_plan_id','id','end_date','clinic_id','tenure_type_id','amount')->where('status','1')->whereDate('renewal_date', $renewDate)->whereNull('deleted_at')->get();
        $patientSubscriptions = $Corefunctions->convertToArray($patientSubscriptions);
        return $patientSubscriptions;
    }

}
