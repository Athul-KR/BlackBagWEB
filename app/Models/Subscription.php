<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class Subscription extends Model
{
    public static function insertSubscription($userId,$clinicId,$trialSubscriptionDetails,$subscriptionHistoryID,$isTrial){
        return DB::table('subscriptions')->insertGetId(array(           
            'subscription_plan_id' => $trialSubscriptionDetails['id'],
            'renewal_plan_id' =>  NULL,
            'clinic_id' => $clinicId,
            'user_id' => $userId,
            'start_date' => date('Y-m-d'),
            'end_date' => NULL,
            'renewal_date' => NULL, 
            'subscription_history_id' => $subscriptionHistoryID,
            'trial_subscription' => $isTrial,
            'created_at' => Carbon\Carbon::now(),
        ));
    }
    public static function updateUserSubscription($usubID,$subscriptionId,$historyID,$startDate,$endDate,$renewDate,$renewPlanID){
        DB::table('subscriptions')->where('id', $usubID)->limit(1)->update(array(
            'subscription_plan_id' => $subscriptionId,
            'subscription_history_id' =>  $historyID,
            'start_date' =>  $startDate,
            'end_date' =>  $endDate,
            'renewal_date' =>  $renewDate,
            'renewal_plan_id' =>  $renewPlanID,
            'updated_at' => Carbon\Carbon::now()
        ));
    }
    public static function insertUsersubscription($userId,$subscriptionId,$historyID,$startDate,$endDate,$renewDate,$renewPlanID,$clinicID){
        $Id =  DB::table('subscriptions')->insertGetId(array(
          'clinic_id' =>  $clinicID,
          'user_id' =>  $userId,
          'subscription_plan_id' => $subscriptionId,
          'subscription_history_id' =>  $historyID,
          'start_date' =>  $startDate,
          'end_date' =>  $endDate,
          'renewal_date' =>  $renewDate,
          'renewal_plan_id' =>  $renewPlanID,
          'created_at' => Carbon\Carbon::now()
        ));
        return $Id;
    }
    public static function getSubscriptionByClinicId($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $clinicSubscription = DB::table('subscriptions')->join('subscription_plans','subscription_plans.id','=','subscriptions.subscription_plan_id')->select('subscriptions.subscription_plan_id','subscriptions.id','subscriptions.renewal_date','subscriptions.renewal_plan_id','subscriptions.start_date','subscriptions.end_date','subscriptions.trial_subscription','subscription_plans.plan_name')->where('subscriptions.clinic_id',$clinicId)->whereNull('subscriptions.deleted_at')->first();
        $clinicSubscription = $Corefunctions->convertToArray($clinicSubscription);
        return $clinicSubscription;
    }
    public static function getSubscriptionById($id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $clinicSubscription = DB::table('subscriptions')->select('subscription_plan_id','id','renewal_date','renewal_plan_id','start_date','end_date','trial_subscription')->where('id',$id)->whereNull('deleted_at')->first();
        $clinicSubscription = $Corefunctions->convertToArray($clinicSubscription);
        return $clinicSubscription;
    }
    public static function getSubscriptionsByRenewDate($renewDate){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $clinicSubscription = DB::table('subscriptions')->select('id','clinic_id','user_id','subscription_plan_id','renewal_date','subscription_history_id','renewal_plan_id','id','trial_subscription','end_date')->whereDate('renewal_date', $renewDate)->whereNull('deleted_at')->get();
        $clinicSubscription = $Corefunctions->convertToArray($clinicSubscription);
        return $clinicSubscription;
    }
}
