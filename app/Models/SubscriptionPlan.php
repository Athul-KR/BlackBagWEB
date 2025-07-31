<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class SubscriptionPlan extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'subscription_plans';

    public static function getTrialPlan(){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $trialSubscriptionDetails = DB::table('subscription_plans')->whereNull('deleted_at')->where('id', '1' )->first();
        $trialSubscriptionDetails = $Corefunctions->convertToArray($trialSubscriptionDetails);
		return $trialSubscriptionDetails;
	}
    public static function getPlanById($planId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $subscriptionPlan = $Corefunctions->convertToArray(DB::table('subscription_plans')->whereNull('deleted_at')->where('id',$planId)->first());
        return $subscriptionPlan;
    }
    public static function getSubscriptionPlans(){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $subscriptionPlans = $Corefunctions->convertToArray(DB::table('subscription_plans')->select('plan_name','amount','id')->get());
        return $subscriptionPlans;
    }
    public static function getPlanbyIDs($planIds){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $subscriptionPlans = $Corefunctions->convertToArray(DB::table('subscription_plans')->whereNull('deleted_at')->whereIn('id',$planIds)->get());
        return $subscriptionPlans;
    }
}
