<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class SubscriptionsHistory extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'subscriptions_history';

    public static function insertSubscriptionsHistory($userId,$clinicId,$trialSubscriptionDetails){
		$Id = DB::table('subscriptions_history')->insertGetId(array(           
            'subscription_plan_id' => $trialSubscriptionDetails['id'],
            'clinic_id' => $clinicId,
            'user_id' => $userId,
            'start_date' => date('Y-m-d'),
            'end_date' => NULL,
            'tenure_type_id' => $trialSubscriptionDetails['tenure_type_id'],
            'tenure_period' => '1',
            'payment_id' => NULL,
            'created_at' => Carbon\Carbon::now(),
        ));
		return $Id;
	}
}
