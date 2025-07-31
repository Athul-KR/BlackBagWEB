<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Support\Facades\Session; // Import Session facade
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionsHistory;
use App\Models\Subscription;
use App\Models\ClinicUser;
use App\Models\Payment;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use File;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
    }
    public function viewreceipt(Request $request){
        if (request()->ajax()) {
            $data = request()->all();
            if( !$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $paymentDetails = $this->Corefunctions->convertToArray(DB::table('payments')->where('id',$data['key'])->where('user_id',$this->user['id'])->limit(1)->first());
            $state      = $this->Corefunctions->convertToArray(User::stateByID($paymentDetails['billing_state']));

            $imagePath2 =  $this->invoiceHtmlToPdf($paymentDetails['payment_uuid']);
            $filename = $this->Corefunctions->getMyPathForAWS($paymentDetails['id'], $paymentDetails['payment_uuid'], 'pdf', "receipt/");

            $this->Corefunctions->uploadDocumenttoAWS($filename,file_get_contents($imagePath2));
            $invoicePath = $this->Corefunctions->getAWSFilePath($filename);
            
        
            $html = view('clinics.viewinvoice',compact('invoicePath','state'));
            $arr['view']    = $html->__toString();
            $arr['invoicePath'] = $invoicePath;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }

    }
    public function invoiceHtmlToPdf($invoicekey,$type='')
    {

        if($type =='invoice' ){
            $url      = url("viewinvoicedetails")."/".$invoicekey;
        }else{
            $url      = url("viewrecieptdetails")."/".$invoicekey;
        }
  
        $url = "https://icwares.com/pdfgen/?url=".$url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );   
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);
        $imagePath2 = $response['pdfurl'];
 
        return $imagePath2;

    }
    public function viewinvoice(Request $request){
        if (request()->ajax()) {
            $data = request()->all();
            if( !$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $paymentDetails = $this->Corefunctions->convertToArray(DB::table('invoices')->where('invoice_uuid',$data['key'])->limit(1)->first());

            $imagePath2 =  $this->invoiceHtmlToPdf($paymentDetails['invoice_uuid'],'invoice');
            $file_path = $this->Corefunctions->getMyPathForAWS($paymentDetails['id'], $paymentDetails['invoice_uuid'], 'pdf', "invoices/");
            $filename = $file_path.'/'.$data['key'].'.pdf';
            $this->Corefunctions->uploadDocumenttoAWS($filename,file_get_contents($imagePath2));
            $downloadPath = $this->Corefunctions->getAWSFilePath($filename);
            $invoicePath = $downloadPath;
        
            $html = view('clinics.viewinvoice',compact('invoicePath'));
            $arr['view']    = $html->__toString();
            $arr['invoicePath'] = $invoicePath;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        } 
    }

    public function invoiceDownload($key)
    {


        $paymentDetails = $this->Corefunctions->convertToArray(DB::table('invoices')->where('invoice_uuid',$key)->limit(1)->first());

        $imagePath2 =  $this->invoiceHtmlToPdf($paymentDetails['invoice_uuid'],'invoice');
        $file_path = $this->Corefunctions->getMyPathForAWS($paymentDetails['id'], $paymentDetails['invoice_uuid'], 'pdf', "invoices/");
        $filename = $file_path.'/'.$key.'.pdf';
        $this->Corefunctions->uploadDocumenttoAWS($filename,file_get_contents($imagePath2));
        $downloadPath = $this->Corefunctions->getAWSFilePath($filename);
        $invoicePath = $downloadPath;

        $customFilename = 'invoice_' . $paymentDetails['invoice_number'] . '.pdf';
        if (@file_get_contents($invoicePath) == true) {
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . $customFilename . "\"");
            readfile($invoicePath);
        }
        exit;
    }

}
