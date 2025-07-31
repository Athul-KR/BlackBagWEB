<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class Invoice extends Model
{
    public static function getInvoices($clinicId){
        $invoicedata = DB::table('invoices')->select('id','invoice_uuid','invoice_number','status', 'created_at', 'payment_id','grandtotal')->where('parent_id', $clinicId)->where('invoice_type_id',1)->orderBy('id','desc')->whereNull('deleted_at')->get();
        return $invoicedata;
    }
    public static function insertInvoice($clinicId,$amount,$usercount,$billinginfo,$notes,$type,$autoChargeDate=NULL){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $invoicekey = $Corefunctions->generateUniqueKey("10", "invoices", "invoice_uuid");

        $invoiceID = DB::table('invoices')->insertGetId(array(
            'invoice_uuid' => $invoicekey,
            'invoice_type_id' => '1',
            'parent_id' => $clinicId,
            'grandtotal' => $amount,
            'autochargedate' => $autoChargeDate,
            'no_of_users' => $usercount,
            'billing_first_name' => $billinginfo['billing_company_name'],
            'billing_email' => $billinginfo['billing_email'],
            'billing_phone_number' => $billinginfo['billing_phone'],
            'billing_address' => $billinginfo['billing_address'],
            'billing_city' => $billinginfo['billing_city'],
            'billing_state' => $billinginfo['billing_state_id'],
            'billing_zip' => $billinginfo['billing_zip'],
            'billing_country_id' => $billinginfo['billing_country_id'],
            'invoice_notes' => $notes,
            'invoice_type_id' => $type,
            'status' => '1',
            'created_at' => Carbon\Carbon::now(),
        ));

        $receipt_num = 1000+$invoiceID;
        DB::table('invoices')->where('id', $invoiceID)->limit(1)->update(array(
            'invoice_number' => $receipt_num,
            'receipt_number' => 'BB/RCPT/'.$receipt_num,
        ));

        return $invoiceID;
    }

    
    public static function getUnpaidInvoicesForCurrentMonth()
    {
        return self::where('status', '1')
            ->whereDate('autochargedate',date('Y-m-d'))
            ->where('invoice_type_id','1')
            ->whereNull('payment_id')
            ->get();
    }

    public static function getInvoiceByParentID($id)
    {
        return self::where('status', '1')
            ->whereDate('autochargedate',date('Y-m-d'))
            ->where('parent_id',$id)
            ->where('invoice_type_id',2)
            ->whereNull('payment_id')
            ->first();
    }

    public static function markAsPaid($invoiceId, $paymentId, $receiptNum)
    {
        return self::where('id', $invoiceId)
            ->update([
                'status' => '2',
                'payment_id' => $paymentId,
                'receipt_number' => 'BB/RCPT/'.$receiptNum,
            ]);
    }

    public static function getInvoiceById($id)
    {
        return self::where('id', $id)->first();
    }
}
