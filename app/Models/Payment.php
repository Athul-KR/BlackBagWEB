<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
class Payment extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'payments';

    public static function insertTransactions($transactionInfo,$userid,$clinicID){
		$Id = DB::table('transactions')->insertGetId(array(
		  'transaction_info' =>  $transactionInfo,		  
		  'user_id' =>  $userid,		  
		  'clinic_id' =>  $clinicID,		   
		));
		return $Id;
	}
    public static function getpaymentsByKey($paymentKey){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $paymentDetails = $Corefunctions->convertToArray(DB::table('payments')->where('payment_uuid', $paymentKey)->limit(1)->first());

		return $paymentDetails;
	}

    public static function getPaymentsById($id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $paymentDetails = $Corefunctions->convertToArray(DB::table('payments')->where('id', $id)->limit(1)->first());

		return $paymentDetails;
	}

    public static function savePaymentData($inputParams,$paymentkey,$userId, $paymentDetails,$status='1',$clinic,$type='',$balance=0){
        $paymentId= DB::table('payments')->insertGetId(array(
            'payment_uuid' => $paymentkey,
            'billing_first_name' => $inputParams['billing_name'],
            'billing_country_id' => ($inputParams['country_id'] !='') ? $inputParams['country_id'] : NULL,
            'billing_phone' => ($inputParams['phone_number'] !='') ? $inputParams['phone_number'] : NULL,
            'billing_address' => ($inputParams['address'] !='') ? $inputParams['address'] : NULL,
            'billing_city' => ($inputParams['city'] !='') ? $inputParams['city'] : NULL,
            'billing_zip' => ($inputParams['zip'] !='') ? $inputParams['zip'] : NULL,
            'billing_state' => ($inputParams['state'] !='') ?$inputParams['state'] : NULL,
            'billing_email' => ( isset( $inputParams['billing_email'] ) && $inputParams['billing_email'] !='') ? $inputParams['billing_email'] : NULL,
            'name_on_card' => ($inputParams['name_on_card'] !='') ?$inputParams['name_on_card'] : NULL,
            'card_num' => ($inputParams['card_number'] !='') ?$inputParams['card_number'] : NULL,
            'card_type' => ($inputParams['card_type'] !='') ?$inputParams['card_type'] : NULL,
            'exp_year' => ($inputParams['expiry_year'] !='') ?$inputParams['expiry_year'] : NULL,
            'exp_month' => ($inputParams['expiry_month'] !='') ?$inputParams['expiry_month'] : NULL,
            'transaction_id' => $paymentDetails['transactionid'],
            'stripe_customer_id' => $paymentDetails['stripe_customerid'],
            'stripe_payment_id' => $paymentDetails['stripe_paymentid'],
            'user_card_id' => $paymentDetails['card_id'],
            'amount' => floatval($paymentDetails['amount']) + floatval($balance),
            'stripe_fee' => $inputParams['stripe_fee'],
            'platform_fee' => $inputParams['platform_fee'],
            'user_id' => $userId,
            'parent_id' =>  ( isset( $inputParams['appntID'] ) && $inputParams['appntID'] !='') ? $inputParams['appntID'] : NULL,
            'parent_type' => (isset($type) && $type != '') ? $type : 'appointment',
            'used_account_balance' => floatval($balance),
            'status' => $status,
            'created_by' => $userId,
            'created_at' => Carbon::now(),
            'billed_by' => serialize($clinic),
        ));
        $receiptNum =1000+$paymentId ;
        DB::table('payments')->where('id', $paymentId)->limit(1)->update(array(
            'receipt_num' => 'BB/RCPT/'.$receiptNum
        ));

        return [
            'id' => $paymentId,
            'receipt_num' => $receiptNum,
        ];
    }
    public static function updateUserStripeCustomerIdInClinics($clinicid,$stripe_customerid){
        DB::table('clinics')->where('id', $clinicid)->limit(1)->update(array(
            'stripe_customer_id' => $stripe_customerid,
            'updated_at'           => Carbon::now()
        ));
    }
    public static function updateUserStripeCustomerIdInPatients($patientid,$stripe_customerid){
        DB::table('patients')->where('id', $patientid)->limit(1)->update(array(
            'stripe_customer_id' => $stripe_customerid,
            'updated_at'           => Carbon::now()
        ));
    }
    public static function updateUserStripeCustomerIdInUsers($userid,$stripe_customerid){
        DB::table('users')->where('id', $userid)->limit(1)->update(array(
            'stripe_customer_id' => $stripe_customerid,
            'updated_at'           => Carbon::now()
        ));
    }
    public static function updateInvoiceBalance($invoiceid,$total_amount){
        DB::table('invoices')->where('id', $invoiceid)->limit(1)->update(array(
            'total_amount' => $total_amount,    
            'updated_at' => Carbon::now()
        ));
    }
    public static function updateAccountLocked($clinic_id, $account_locked ){
        DB::table('clinics')->where('id', $clinic_id)->limit(1)->update(array(
           'account_locked' => $account_locked,    
           'updated_at' => Carbon::now()
       ));
    }
    public static function updateTrialSubscriptionByUserPlanID( $userPlanID ){
        return DB::table('subscriptions')->where('id', $userPlanID)->limit(1)->update(array(
            'trial_subscription' =>'0',    
            'updated_at' => Carbon::now()
        ));
    }
    public static function updateInvoiceStatus($invoiceid,$paymentID = NULL,$status){
        DB::table('invoices')->where('id', $invoiceid)->limit(1)->update(array(
            'status' => $status,    
            'payment_id' => $paymentID,    
            'updated_at' => Carbon::now()
       ));
    }
    public static function insertInvoiceData( $invoiceDate, $payByDate, $retry_date,  $userid,  $clinicid, $billingInfo, $amount, $planDetails, $intentID, $expiryData ){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('10', 'invoices', 'invoice_uuid');
        $invoiceID = DB::table('invoices')->insertGetId(array(
            'user_id'                   => $userid,
            'invoice_date'              => $invoiceDate,
            'pay_by_date'               => $payByDate,
            'clinic_id'                 => $clinicid,
            'total_amount'              => ($amount != '') ? $amount : 0.00,
            'subscription_plan_id'      => $planDetails['id'],
            'billing_first_name'        => ( !empty( $billingInfo ) && isset( $billingInfo['billing_first_name'] ) ) ? $billingInfo['billing_first_name'] : NULL,
            'billing_last_name'         => ( !empty( $billingInfo ) && isset( $billingInfo['billing_last_name'] ) ) ? $billingInfo['billing_last_name'] : NULL,
            'billing_country_id'        => ( !empty( $billingInfo ) && isset( $billingInfo['billing_country_id'] )  && $billingInfo['billing_country_id'] !='' ) ? $billingInfo['billing_country_id'] : NULL,
            'billing_phone_number'      => ( !empty( $billingInfo ) && isset( $billingInfo['billing_phone'] )  && $billingInfo['billing_phone'] !='' ) ? $billingInfo['billing_phone'] : NULL,
            'billing_address'           => ( !empty( $billingInfo ) && isset( $billingInfo['billing_address'] )  && $billingInfo['billing_address'] !='' ) ? $billingInfo['billing_address'] : NULL,
            'billing_city'              => ( !empty( $billingInfo ) && isset( $billingInfo['billing_city'] )  && $billingInfo['billing_city'] !='' ) ? $billingInfo['billing_city'] : NULL,
            'billing_zip'               => ( !empty( $billingInfo ) && isset( $billingInfo['billing_zip']) && $billingInfo['billing_zip'] !='' ) ? $billingInfo['billing_zip'] : NULL,
            'billing_state'             => ( !empty( $billingInfo ) && isset( $billingInfo['billing_state']) && $billingInfo['billing_state'] !='' ) ? $billingInfo['billing_state'] : NULL,
            'status'                    => (isset($planDetails['fromtrial'] ) && $planDetails['fromtrial'] == 1 ) ? '5' : '1',
            'stripe_payment_intent_id'  => $intentID,
            'invoice_uuid'              => $key,
            'retry_date'                => $retry_date,
            'created_at'                => Carbon::now()
        ));
        DB::table('invoices')->where('id', $invoiceID)->limit(1)->update(array(
            'invoice_number' => 1000+$invoiceID,
        ));
        return  $invoiceID;
    }
    public static function insertInvoiceItemData( $invoiceID, $clinicid, $subscriptionID, $planID, $amount ){
        $invoiceItemID = DB::table('invoice_items')->insertGetId(array(
            'invoice_id' => $invoiceID,
            'clinic_id' => $clinicid,
            'amount' => ($amount != '') ? $amount : 0.00,
            'subscription_id' => $subscriptionID,
            'subscription_plan_id' => $planID,
            'created_at' => Carbon::now()
        ));
        return  $invoiceItemID;
    }
    public static function updateInvoiceAmount($invoiceid, $amount){
        return    DB::table('invoices')->where('id', $invoiceid)->limit(1)->update(array(
           'total_amount' => $amount,    
           'updated_at' => Carbon::now()
        ));
    }
    public static function updateInvoiceIntentID($invoiceid, $intentID){
        return  DB::table('invoices')->where('id', $invoiceid)->limit(1)->update(array(
           'stripe_payment_intent_id' => $intentID,    
           'updated_at' => Carbon::now()
        ));
    } 
    public static function updateRetryDate($invoiceid, $retrydate){
        return DB::table('invoices')->where('id', $invoiceid)->limit(1)->update(array(
           'retry_date' => $retrydate,    
           'updated_at' => Carbon::now()
        ));
    }
    public static function updateInvoicePaymentID($invoiceid, $paymentID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        DB::table('invoices')->where('id', $invoiceid)->limit(1)->update(array(
            'payment_id' => $paymentID,     
            'updated_at' => Carbon::now()
        ));
        $invoiceDets = $Corefunctions->convertToArray(DB::table('invoices')->select('id','invoice_number')->where('id',$invoiceid)->first());
        if( !empty($invoiceDets)){
            DB::table('payments')->where('id', $paymentID)->limit(1)->update(array(
                'receipt_num' => 'RCPT/'.$invoiceDets['invoice_number'],
            ));
        }
        return;
    }

    
    public static function getPayouts($startDate,$endDate,$limit){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $paymentDetails =  DB::table('payments')->join('transactions', 'transactions.id', '=', 'payments.transaction_id')->select('payments.created_at','payments.parent_id','payments.id')
        ->where('transactions.clinic_id', session()->get('user.clinicID'))->where('payments.status','1');
        if($startDate !='' && $endDate  !=''){
            $paymentDetails =$paymentDetails->whereDate('payments.created_at','>=',$startDate)->whereDate('payments.created_at','<=',$endDate);
        }
        
        $paymentDetails = $paymentDetails->orderBy('payments.id', 'desc')->paginate($limit);

      
        $paymentData = $Corefunctions->convertToArray($paymentDetails);
        return ['paymentData' => $paymentData,'paymentDetails' => $paymentDetails];
		
	}

    public static function getUserPayments($userID, $limit = 10,$page='1',$clinicid='')
    {
        $perPage = request()->get('perPage', 10);
        $query = DB::table('payments')->join('transactions', 'transactions.id', '=', 'payments.transaction_id')->select('payments.*','transactions.transaction_info','transactions.clinic_id')->where('payments.status', '1')->where('payments.user_id',$userID);
        if(isset($clinicid) && $clinicid != ''){
            $query = $query->where('transactions.clinic_id',$clinicid);
        }
        $result = $query->orderBy('payments.id', 'desc')->paginate('10', ['*'], 'page', $page);
        return $result;
    }
    public static function patientCardById($usercardkey){ 
        $Corefunctions = new \App\customclasses\Corefunctions;
        $row = DB::table('patient_cards')->where('patient_card_uuid',$usercardkey)->first();
        $row = $Corefunctions->convertToArray($row);
        return $row; 
    } 
    public static function clinicCardById($usercardkey){ 
        $Corefunctions = new \App\customclasses\Corefunctions;
        $row = DB::table('clinic_cards')->where('clinic_card_uuid',$usercardkey)->first();
        $row = $Corefunctions->convertToArray($row);
        return $row; 
    } 
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withTrashed();
    }
    public function patientUser()
    {
        return $this->hasOne(Patient::class, 'user_id', 'user_id')->withTrashed();
    }

}
