<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class InvoiceItem extends Model
{
    public static function insertInvoiceItem($invoiceId,$clinicId,$amount,$usercount,$notes){
        $id = DB::table('invoice_items')->insertGetId(array(
            'invoice_id' => $invoiceId,
            'clinic_id' => $clinicId,
            'itemname' => $notes,
            'quantity' => $usercount,
            'amount' => $amount,
            'created_at' => Carbon\Carbon::now(),
        ));
    }
}
