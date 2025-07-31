<?php

namespace App\Http\Controllers\clinics;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use DB;
use File;
use App\Models\RpmOrders;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\User;
use App\Models\RefState;
use App\Models\UserBilling;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\RefCountryCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Psy\Command\WhereamiCommand;
use Redirect;
use Str;
use Illuminate\Support\Facades\Session;

class RpmController extends Controller
{


    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
       // Middleware for session check
    /*    $this->middleware(function ($request, $next) {
            $sessionCeck = $this->Corefunctions->validateUser();
            if (!$sessionCeck) {
                return Redirect::to('/logout');
            }
            // Check if the session has the 'user' key (adjust as per your session key)
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
            return $next($request);
        });*/
    }
    
     public function confirmOrderedDevices(){
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            $userId = session('user.userID');
            $order  = RpmOrders::rpmOrderByUUID($input['key']);
            if( empty($order) ){
                return response()->json([
                    'status' => 0,
                    'message' => 'Invalid Order.',
                ]);
            }
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
            $clinic         = $this->Corefunctions->convertToArray(Clinic::clinicByID($order['clinic_id']));
            
            if ($clinic['stripe_connection_id'] == '' || $clinic['stripe_connection_id'] == null) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Stripe not connected',
                ]);
            }


            $countryCodedetails  = array();
            $billingInfo = UserBilling::getUserBillingByUserId($userId);
            if(empty($billingInfo)){
                $userBillingKey = $this->Corefunctions->generateUniqueKey('10', 'user_billing', 'user_billing_uuid');
                UserBilling::saveBillingData($input,$userId,$userBillingKey,$clinic['id'],$countryCodedetails);
            }else{
                UserBilling::updateBillingData($billingInfo['id'],$input,$countryCodedetails);
            }

            $amount         = (float) str_replace(',', '', $input['amount']); 
            $perMonthAmount = (float) str_replace(',', '', $input['amount']); 
            $notes = "Payment for device order : ".$order['order_code'];
            
            $id         = Invoice::insertInvoice($order['id'],$perMonthAmount,'0',$billingInfo,$notes,3); 
            InvoiceItem::insertInvoiceItem($id,$clinic['id'],$perMonthAmount,'0',$notes);

            $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic['stripe_connection_id'])->where('status', '1')->first();

            // Payment to clinic //
            $paymentIds = array();
            $paymentIds['id'] = 0;
            if($amount > 0){  
                $result = $this->Corefunctions->deviceOrderPayment($stripeConnection->stripe_user_id,$patientDetails,$input,$amount,$clinic['id'],$order['id']);
              
                if(isset( $result['status']) && $result['status'] == 0){
                    $arr['message'] = isset($result['message']) ?  $result['message'] : 'Payment failed.' ;
                    $arr['success'] = 0;
                    return response()->json($arr);
                }
                $paymentIds = $result['paymentIds'];
                RpmOrders::updatePaymentIdInRpmOrder( $order['id'],$paymentIds['id'] );
                $userDets = $this->Corefunctions->convertToArray(User::userByID(session('user.userID')));
                if( !empty($userDets) ){
                    
                   $rpmResponse =  $this->addBulkOrder($order,$input,$userDets);
                    if( !empty($rpmResponse) && isset( $rpmResponse['is_success']) && $rpmResponse['is_success'] == '0' && isset( $rpmResponse['error_message'])){
                        $arr['message']     = $rpmResponse['error_message'];
                        $arr['success']     = 0;
                        return response()->json($arr);
                    }
                }
                
            }
           
            
            

            $arr['message'] = 'Order updated successfully.';
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    
    
    public function addSmartMeterOrder(){
       
        /* Bulk Order */
        $input['shipping_address']      = 'Suite 100';
        $input['shipping_city']         = 'Lake Mary';
        $input['shipping_zip']          = '25916';
        $input['shipping_country_id']   = '1';
        $input['shipping_user_phone']   = '8787878787';
        $input['shipping_country_code'] = '+91';
        $input['shipping_state_id']     = 'Lake Mary';
        
        $userDets['name']               = 'John Doe';
        $userDets['user_id']            = '1';
        $userDets['patient_id']         = '2';
        $userDets['clinic_id']          = '10';
        
        //$this->addBulkOrder($input,$userDets);
        $this->addSingleOrder($input,$userDets);
        
    }
       
    function addBulkOrder($orderInfo,$input,$userDets){
        
        $orderDevices        = RpmOrders::getOrderDevicesByOrderID($orderInfo['id'],'-1');
        $devicesIDS          = $this->Corefunctions->getIDSfromArray($orderDevices,'rpm_device_id');
        $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
        $devices             = $this->Corefunctions->getArrayIndexed1($devices,'id');
        $orderDevices        =  $this->Corefunctions->getArrayIndexed1($orderDevices,'rpm_device_id');
        
        
        $orderData     = $rpmLinesData = array();
        if( !empty($orderInfo)){
            if( !empty($devices)){
                foreach( $devices as $dv){
                   $lines = array(
                        'quantity'  => 1, // Or another relevant array
                        'sku'       => $dv['sku'],
                    );
                    $rpmLinesData[] = $lines;
                    
                }
            }
        }
       

       /* Create Bearer Token */
        $token = $this->Corefunctions->createSmartmeterBearerToken('token');

        /* Create Order */
        $apiKey = env('SMARTMETER_API_KEY'); 
      

        $stateName = $input['state'];
        if( $input['country_id'] == '185'){
            $state = $this->Corefunctions->convertToArray(RefState::getStateByID($input['state_id']));
            if( !empty($state) ){
                $stateName  = $state['state_name'];
            }
        }
        $country  = RefCountryCode::getCountryCodeById($input['country_id']);
        $orderData = [
            'order' => [
                'order_number'           => $orderInfo['order_code'],
                'customer_id'            => $userDets['user_uuid'],
                'customer_name'          => $userDets['first_name'].' '.$userDets['last_name'],
                'address1'               => $input['address'],
                'address2'               => $input['address'],
                'city'                   => $input['address'],
                'state'                  => $stateName,
                'zipcode'                => $input['zip'],
                'country'                => ( empty($country) ) ? $country['country_name'] : "United States",
                'shippingMethod'         => "MAIL",
                'po_number'              => "PO987065",
                'lines'                  => $rpmLinesData         
                
            ],
        ];

        $apiResponse = $this->Corefunctions->addSmartMeterAPI("orders",$orderData,$token);
        

        $isSuccess = $errorMessage = '';
        if ( !empty($apiResponse) && isset( $apiResponse['data'] ) && isset( $apiResponse['status'] ) && $apiResponse['status']['code'] && $apiResponse['status']['code'] == '201' ) {
            RpmOrders::updateRpmOrderResponse( $orderInfo['id'],serialize($apiResponse),'1',date('Y-m-d') );
            RpmOrders::updateOrderStatus( $orderInfo['id'],'1');
            /* Update Device ID Rpm Order Devices Table */
            $skuDevices             = $this->Corefunctions->getArrayIndexed1($devices,'sku');
            $rpmDeviceLines         = ( isset( $apiResponse['data']['order'] ) && isset( $apiResponse['data']['order']['lines'] ) ) ? $apiResponse['data']['order']['lines'] : array();
            $isSuccess = '1';
            if( !empty( $rpmDeviceLines ) ){
                foreach( $rpmDeviceLines as $dv ){
                   
                    if( isset($skuDevices[$dv['sku']] ) ){
                      
                        $deviceID = $skuDevices[$dv['sku']]['id'];
                        $orderDevice = ( !empty($orderDevices) && isset($orderDevices[$deviceID]) ) ? $orderDevices[$deviceID] : array();
                        if( !empty($orderDevice) ){
                            RpmOrders::updateRpmDeviceMacID( $orderDevice['id'],$dv['id'] );
                        }
                    }
                }
            }
            
             //$this->Corefunctions->rpmDeviceStatusChangeMail($orderInfo,$devices); 
            
            
            /*echo "Order created successfully:\n";
            print_r(json_decode($response, true));*/
        }
     
         if ( !empty($apiResponse) && isset( $apiResponse['status'] ) && $apiResponse['status']['code'] && $apiResponse['status']['code'] == '500' ) {
            
            $isSuccess = '0';
            $errorMessage = ( isset($apiResponse['status']['message'])) ? $apiResponse['status']['message'] : '';
        } 
        $finalArr                    = array();
        $finalArr['is_success']      = $isSuccess;
        $finalArr['error_message']   = $errorMessage;
        return $finalArr;
        
    }
    function addSingleOrder($input,$userDets){

        $deviceUUID  = 'oki89uifhy';
        $device      = RpmOrders::rpmDeviceByUUID( $deviceUUID );

        $deviceParams = array();
        if( !empty( $devices ) ){
            foreach( $devices as $dk => $dv ){
                $deviceParams[$dk]['device_id'] = $dv['device_uuid'];
            }
        }

        $shippingParams                     =  array();
        $shippingParams['name']             = $userDets['name'];
        $shippingParams['line1']            = $input['shipping_address'];
        $shippingParams['city']             = $input['shipping_city'];
        $shippingParams['state']            = 'AL';
        $shippingParams['postal_code']      = $input['shipping_zip'];
        $shippingParams['country']          = 'USA';

        /* Insert To Rpm Orders */
        $addInfo       = array();
        $orderInfo     = RpmOrders::addToRpmOrders( $input,$userDets );
        if( !empty($orderInfo) ){
            RpmOrders::addToOrderDevices( $device['id'],$orderInfo['id'] );
        }

        /* Create Bearer Token */
        $token = $this->Corefunctions->createSmartmeterBearerToken('token');

        /* Create Order */
        $apiKey = "0724597736f05548143044408005db702e421e53f4c190aec2418e13d63bcb41"; // Replace with your actual API key

        $orderData = [
            'order' => [
                'order_number'           => $orderInfo['order_code'],
                'customer_id'            => "276653",
                'customer_name'          => "John Jim",
                'address1'               => "123",
                'address2'               => "Suite 100",
                'city'                   => "Lake Mary",
                'state'                  => "Florida",
                'zipcode'                => "32746",
                'country'                => "United States",
                'shippingMethod'         => "MAIL",
                'po_number'              => "PO987065",
                'lines' => [
                    [
                        'quantity' => '3',
                        'sku'      => "AC2242-11"
                    ]
                ]
            ],
        ];

        $apiResponse = $this->Corefunctions->addSmartMeterAPI("orders",$orderData,$token);

        if ( !empty($apiResponse) && isset( $apiResponse['data'] ) && isset( $apiResponse['status'] ) && $apiResponse['status']['code'] && $apiResponse['status']['code'] == '201' ) {
            RpmOrders::updateRpmOrderResponse( $orderInfo['id'],serialize($apiResponse),'1' );
            /*echo "Order created successfully:\n";
            print_r(json_decode($response, true));*/
        } 

    }
   
    
   

}