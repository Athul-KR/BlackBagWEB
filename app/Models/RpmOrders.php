<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
use Session;

class RpmOrders extends Model
{
    use HasFactory, SoftDeletes;

      public static function rpmDevicesByUUIDS($deviceUUIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
          if( empty($deviceUUIDS)){ return array(); }
        $result = $Corefunctions->convertToArray(DB::table('ref_rpm_devices')->select('id', 'device_uuid', 'device','sku','category','one_time_charge','per_month_amount')->whereIn('device_uuid', $deviceUUIDS)->get());
        return $result ;
	}
        /*public static function addToRpmOrders($input,$userDets){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $orderUUID  = $Corefunctions->generateUniqueKey('10', 'rpm_orders', 'rpm_order_uuid');
        $orderId    = DB::table('rpm_orders')->insertGetId(array(
            'rpm_order_uuid'        => $orderUUID,
            'user_id'               => $userDets['user_id'],
            'patient_id'            => $userDets['patient_id'],
            'clinic_id'             => $userDets['clinic_id'],
            'shipping_country_id'   => $input['shipping_country_id'],
            'shipping_user_phone'   => $input['shipping_user_phone'],
            'shipping_country_code' => $input['shipping_country_code'],
            'shipping_address'      => $input['shipping_address'],
            'shipping_city'         => $input['shipping_city'],
            'shipping_state_id'        => $input['shipping_state_id'],
            'shipping_zip'          => $input['shipping_zip'],
            'created_at'            => Carbon::now(),
        ));
        $orderCode =1000+$orderId ;
        DB::table('rpm_orders')->where('id', $orderId)->limit(1)->update(array(
            'order_code' => $orderCode
        ));

        return [
            'id'                => $orderId,
            'rpm_order_uuid'    => $orderUUID,
            'order_code'        => $orderCode,
        ];
    }*/
    public static function addToRpmOrders($input){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $orderUUID  = $Corefunctions->generateUniqueKey('10', 'rpm_orders', 'rpm_order_uuid');
        $orderId    = DB::table('rpm_orders')->insertGetId(array(
            'rpm_order_uuid'        => $orderUUID,
            'user_id'               => $input['user_id'],
            'patient_id'            => $input['patient_id'],
            'clinic_id'             => $input['clinic_id'],
            'clinic_user_id'        => $input['clinic_user_id'],
            'created_at'            => Carbon::now(),
        ));
        $orderCode =1000+$orderId.$orderId ;
        DB::table('rpm_orders')->where('id', $orderId)->limit(1)->update(array(
            'order_code' => $orderCode
        ));

        return [
            'id'                => $orderId,
            'rpm_order_uuid'    => $orderUUID,
            'order_code'        => $orderCode,
        ];
    }
         
    public static function addToOrderDevices($deviceID,$orderID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $uuID = $Corefunctions->generateUniqueKey('10', 'rpm_order_devices', 'rpm_order_device_uuid');
        $orderDeviceId    = DB::table('rpm_order_devices')->insertGetId(array(
            'rpm_order_device_uuid' => $uuID,
            'rpm_device_id'         => $deviceID,
            'rpm_order_id'          => $orderID,
            'created_at'            => Carbon::now(),
        ));
            return [
            'id'                => $orderDeviceId,
            'rpm_order_device_uuid'    => $uuID,
        ];
    
    }
    public static function updateRpmOrderResponse($orderID,$apiresponse,$status,$startDate){
        DB::table('rpm_orders')->where('id', $orderID)->limit(1)->update(array(
            'api_response'         => $apiresponse,
            'start_date'           => $startDate,
            //'status'               => $status,
            'updated_at'           => Carbon::now()
        ));
    }  

    public static function rpmDeviceByUUID($deviceUUID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('ref_rpm_devices')->select('id', 'device_uuid', 'device')->where('device_uuid', $deviceUUID)->first());
        return $result ;
	}
    public static function insertWebhookData($postdata,$reqinput,$input,$type=''){
        $id    = DB::table('webhooks')->insertGetId(array(
            'postdata'      => serialize($postdata),
            'requestdata'   => serialize($reqinput),
            'inputdata'     => serialize($input),
            'type'          => $type,
            'created_at'    => Carbon::now()
        ));
        return $id;

    }
    public static function orderByOrderCode($ordercode){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->select('id', 'order_code', 'user_id','patient_id','clinic_id')->where('order_code', $ordercode)->first());
        return $result ;
	}
    public static function updateDeviceMacID($orderDeviceUUID,$deviceMacID){
        DB::table('rpm_order_devices')->where('rpm_order_device_uuid', $orderDeviceUUID)->limit(1)->update(array(
            'device_macid'         => $deviceMacID,
            'updated_at'           => Carbon::now()
        ));
    }
    public static function getOrderDevices(){
         $Corefunctions = new \App\customclasses\Corefunctions;
       return  $Corefunctions->convertToArray(DB::table('rpm_order_devices')->join('ref_rpm_devices', 'ref_rpm_devices.id', '=', 'rpm_order_devices.rpm_device_id')->where('rpm_order_devices.status', '1')->whereNull('rpm_order_devices.deleted_at')->whereNull('ref_rpm_devices.deleted_at')->select('rpm_order_devices.id','rpm_order_devices.rpm_order_id','rpm_order_devices.rpm_device_id','rpm_order_devices.device_macid')->get());
    }
     public static function checkRPMDataExists($tablename,$userid,$uniqueid,$deviceid){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table($tablename)->select('id')->where('reading_id', $uniqueid)->where('user_id', $userid)->where('rpm_deviceid', $deviceid)->first());
        return $result ;
	}
    public static function rpmOrdersByIDS($orderIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
          if( empty($orderIDS)){ return array(); }
        $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->select('id','order_code', 'user_id', 'clinic_id')->whereIn('id', $orderIDS)->get());
        return $result ;
	}
      public static function addSmartMeterBGTracker($userid,$deviceid,$inputData,$clinicID='0' ){
           $Corefunctions = new \App\customclasses\Corefunctions;
         $key = $Corefunctions->generateUniqueKey('8', 'glucose_tracker', 'glucose_tracker_uuid');
        DB::table('glucose_tracker')->insertGetId([
            'glucose_tracker_uuid' => $key,
            'user_id'              => $userid,
            'clinic_id'            => $clinicID,
            'bgvalue'              => isset($inputData['blood_glucose_mgdl']) && $inputData['blood_glucose_mgdl'] !='' ? $inputData['blood_glucose_mgdl'] : NULL,
            'a1c'                  => '0',
            'source_type_id'       => $inputData['source_type_id'],
            'reportdate'           => date('Y-m-d',strtotime($inputData['date_recorded'])),
            'reporttime'           => date('H:i:s',strtotime($inputData['date_recorded'])),
            'rpm_deviceid'          => $deviceid,
            'reading_id'            => $inputData['reading_id'],
            'created_at'           => Carbon::now(),
            
        ]);

    }
    public static function clinicUserByuserID($userID,$clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('clinic_users')->select('id', 'user_id', 'rpm_startdate')->where('user_id', $userID)->where('clinic_id', $clinicID)->whereNull('deleted_at')->first());
        return $result ;
	} 
    public static function getRPMFirstSyncDate($tablename,$userid,$deviceid,$clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table($tablename)->select('id', 'reportdate')->where('user_id', $userID)->where('clinic_id', $clinicID)->where('rpm_device_id', $clinicID)->whereNull('deleted_at')->orderBy('reportdate','asc')->first());
        return $result ;
	}
     public static function updateRPMStartDate($clinicUserID,$rpmstartdate){
        DB::table('clinic_users')->where('id', $clinicUserID)->limit(1)->update(array(
            'rpm_startdate'         => $rpmstartdate,
            'updated_at'           => Carbon::now()
        ));
    }
    
        public static function addSmartMeterBPTracker($userid,$deviceid,$inputData,$clinicID='0'){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
        $key = $Corefunctions->generateUniqueKey('8', 'bp_tracker', 'bp_tracker_uuid');

        DB::table('bp_tracker')->insertGetId([

            'bp_tracker_uuid' => $key,
            'user_id'         => $userid,
            'clinic_id'       => $clinicID,
            'systolic'        => isset($inputData['systolic_mmhg']) && $inputData['systolic_mmhg'] !='' ? $inputData['systolic_mmhg'] : NULL,
            'diastolic'       => isset($inputData['diastolic_mmhg']) && $inputData['diastolic_mmhg'] !='' ? $inputData['diastolic_mmhg'] : NULL,
            'pulse'           => isset($inputData['pulse_bpm']) && $inputData['pulse_bpm'] !='' ? $inputData['pulse_bpm'] : NULL,
            'source_type_id'  => $inputData['source_type_id'],
            'rpm_deviceid'    => $deviceid,
            'reading_id'      => $inputData['reading_id'],
            'reportdate'      => date('Y-m-d',strtotime($inputData['date_recorded'])),
            'reporttime'      => date('H:i:s',strtotime($inputData['date_recorded'])),
            'created_at'      => Carbon::now(),

        ]);
    }
   
    
       public static function getLatestHeightTracker($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('height_tracker')->whereNull('deleted_at')->where('user_id',$userID)->orderBy('reportdate','desc')->orderBy('id','desc')->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);
       
        return $medicalDetails ;
    }
    
    public static function addSmartMeterWTTracker($userid,$deviceid,$inputData,$clinicID='0'){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
        $key = $Corefunctions->generateUniqueKey('8', 'weight_tracker', 'weight_tracker_uuid');

        DB::table('weight_tracker')->insertGetId([
            'weight_tracker_uuid' => $key,
            'user_id'          => $userid,
            'clinic_id'        => $clinicID,
            'weight'           => isset($inputData['weight_kg']) && $inputData['weight_kg'] !='' ? $inputData['weight_kg'] : NULL,
            'unit'             =>  isset($inputData['unit']) && $inputData['unit'] !='' ? $inputData['unit']  : NULL,
            'reportdate'       => date('Y-m-d',strtotime($inputData['date_recorded'])),
            'reporttime'       => date('H:i:s',strtotime($inputData['date_recorded'])),
            'source_type_id'   => $inputData['source_type_id'],
            'rpm_deviceid'     => $deviceid,
            'reading_id'       => $inputData['reading_id'],
          //  'bmi'              => isset($inputData['bmikg']) && $inputData['bmikg'] !='' ? $inputData['bmikg'] : NULL, 
            'created_at'       => Carbon::now(),
            
        ]);
    }
      public static function addSmartMeterOxygenSaturation($userid,$deviceid,$inputData,$clinicID='0' ){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('8', 'oxygen_saturations', 'oxygen_saturation_uuid');
        DB::table('oxygen_saturations')->insertGetId(array(
            'oxygen_saturation_uuid' => $key,
            'saturation'     => $inputData['spo2'],
            'user_id'        => $userid,
            'clinic_id'      => $clinicID,
            'rpm_deviceid'   => $deviceid,
            'source_type_id'       => $inputData['source_type_id'],
            'reading_id'     => $inputData['reading_id'],
            'reportdate'     => date('Y-m-d',strtotime($inputData['date_recorded'])),
            'reporttime'     => date('H:i:s',strtotime($inputData['date_recorded'])),
            'created_at'     => Carbon::now(),
        ));
    }
    public static function getRpmDevices(){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('ref_rpm_devices')->select('id', 'device_uuid', 'device','sku','one_time_charge','per_month_amount','category')->whereNull('deleted_at')->get());
        return $result ;
	}
    public static function getPatientRpmDevices($userID,$clinicID){
         $Corefunctions = new \App\customclasses\Corefunctions;
        
       $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->join('rpm_order_devices', 'rpm_order_devices.rpm_order_id', '=', 'rpm_orders.id')->where('rpm_orders.user_id', $userID)->where('rpm_orders.clinic_id', $clinicID)->whereNull('rpm_order_devices.deleted_at')->whereNull('rpm_order_devices.deleted_at')->select('rpm_order_devices.id','rpm_order_devices.rpm_order_id','rpm_order_devices.rpm_device_id','rpm_order_devices.device_macid')->where('rpm_order_devices.status','2')->where('rpm_orders.status','2')->get());
         return $result;
    }
      public static function rpmDevicesByIDS($deviceIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
          if( empty($deviceIDS)){ return array(); }
        $result = $Corefunctions->convertToArray(DB::table('ref_rpm_devices')->select('id','device', 'category','one_time_charge','per_month_amount','sku')->whereIn('id', $deviceIDS)->get());
          if( !empty($result)){
              foreach( $result as $rsk => $rsv){
                 $result[$rsk]['device_image'] = asset('images/rpmdevices/'.$rsv['category'].'.png');
              }
          }
        return $result ;
	} 
    
      public static function getRpmOrders($status,$clinicId,$userID,$patientID){
         $Corefunctions = new \App\customclasses\Corefunctions;
        
       $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->select('rpm_orders.id','rpm_orders.rpm_order_uuid','rpm_orders.order_code','rpm_orders.clinic_user_id','rpm_orders.clinic_id','rpm_orders.created_at','rpm_orders.status','rpm_orders.tracking_number')->where('rpm_orders.user_id', $userID)->whereIn('rpm_orders.status',$status)->where('rpm_orders.clinic_id',$clinicId)->where('rpm_orders.patient_id',$patientID)->orderBy('rpm_orders.created_at','desc')->get());
         return $result;
    }  
    public static function getOrderDevicesByOrderIDS($status,$orderIDS){
         $Corefunctions = new \App\customclasses\Corefunctions;
        if( empty($orderIDS)){
            return array();
        }
        
       $result = $Corefunctions->convertToArray(DB::table('rpm_order_devices')->whereNull('rpm_order_devices.deleted_at')->whereNull('rpm_order_devices.deleted_at')->select('rpm_order_devices.id','rpm_order_devices.rpm_order_id','rpm_order_devices.rpm_device_id','rpm_order_devices.device_macid')->whereIn('rpm_order_devices.status',$status)->whereIn('rpm_order_devices.rpm_order_id',$orderIDS)->get());
         return $result;
    }
       public static function rpmOrderByUUID($rpmorderuuid){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->select('id', 'rpm_order_uuid', 'order_code','user_id','clinic_id','status','clinic_user_id','patient_id','tracking_number','created_at')->where('rpm_order_uuid', $rpmorderuuid)->first());
        return $result ;
	}
    public static function updateOrderStatus($orderID,$status){
        DB::table('rpm_orders')->where('id', $orderID)->limit(1)->update(array(
            'status'               => $status,
            'updated_at'           => Carbon::now()
        ));  
        DB::table('rpm_order_devices')->where('rpm_order_id', $orderID)->update(array(
            'status'               => $status,
            'updated_at'           => Carbon::now()
        ));
    }
    public static function getOrderDevicesByOrderID($orderID,$status){
         $Corefunctions = new \App\customclasses\Corefunctions;
      
        
       $result = $Corefunctions->convertToArray(DB::table('rpm_order_devices')->whereNull('rpm_order_devices.deleted_at')->whereNull('rpm_order_devices.deleted_at')->select('rpm_order_devices.id','rpm_order_devices.rpm_order_id','rpm_order_devices.rpm_device_id','rpm_order_devices.device_macid')->where('rpm_order_devices.status',$status)->where('rpm_order_devices.rpm_order_id',$orderID)->get());
         return $result;
    }
    public static function updatePaymentIdInRpmOrder($orderID,$paymentID){
        DB::table('rpm_orders')->where('id', $orderID)->limit(1)->update(array(
            'payment_id'           => $paymentID,
            'updated_at'           => Carbon::now()
        ));  
       
    }
     
      public static function getPendingRpmOrdersCount($status,$clinicId,$userID,$patientID){
         $Corefunctions = new \App\customclasses\Corefunctions;
        
       $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->select('rpm_orders.id','rpm_orders.rpm_order_uuid','rpm_orders.order_code','rpm_orders.clinic_user_id','rpm_orders.clinic_id','rpm_orders.created_at','rpm_orders.tracking_number')->where('rpm_orders.user_id', $userID)->whereIn('rpm_orders.status',$status)->where('rpm_orders.clinic_id',$clinicId)->where('rpm_orders.patient_id',$patientID)->count());
         return $result;
    }
    public static function rpmOrderByID($rpmorderID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->select('id', 'rpm_order_uuid', 'order_code','user_id','clinic_id','status')->where('id', $rpmorderID)->first());
        return $result ;
	}  
    public static function webhookByID($id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('webhooks')->where('id', $id)->first());
        return $result ;
	}
    public static function updateRpmDeviceMacID($orderDeviceID,$deviceID){
        
        DB::table('rpm_order_devices')->where('id', $orderDeviceID)->update(array(
            'device_macid'               => $deviceID,
            'updated_at'                => Carbon::now()
        ));
    }
    public static function orderDeviceByDeviceMacID($deviceID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('rpm_order_devices')->select('id', 'rpm_device_id','rpm_order_id')->where('device_macid', $deviceID)->first());
        return $result ;
	} 
    public static function updateRpmPatient($patientID,$rpmPatient){
        
        DB::table('patients')->where('id', $patientID)->update(array(
            'rpm_patient'               => $rpmPatient,
        ));
    }
    public static function updateTackingNumber($orderID,$trackingnumber){
        
        DB::table('rpm_orders')->where('id', $orderID)->update(array(
            'tracking_number'               => $trackingnumber,
        ));
    }
    public static function rpmUserSelectedDevices($userID,$clinicID,$deviceIDS,$statusIDS){
         $Corefunctions = new \App\customclasses\Corefunctions;
        if( empty($deviceIDS)){ return array(); }
       $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->join('rpm_order_devices', 'rpm_order_devices.rpm_order_id', '=', 'rpm_orders.id')->select('rpm_orders.id','rpm_orders.status','rpm_order_devices.rpm_device_id')->where('rpm_orders.user_id', $userID)->whereIn('rpm_orders.status',$statusIDS)->whereIn('rpm_orders.status',$deviceIDS)->whereIn('rpm_orders.status',$statusIDS)->whereIn('rpm_orders.status',$statusIDS)->where('rpm_orders.clinic_id',$clinicID)->orderBy('rpm_orders.created_at','desc')->get());
         return $result;
    }  
     
      public static function getDeliveredOrders($userIDS,$status,$startdate){
         $Corefunctions = new \App\customclasses\Corefunctions;
          if( empty($userIDS)){ return array();}
        
       $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->select('id','rpm_order_uuid','user_id','order_code','clinic_user_id','clinic_id','created_at','status','start_date')->whereIn('user_id', $userIDS)->where('status',$status)->where('start_date','<=',$startdate)->orderBy('created_at','desc')->get());
         return $result;
    }  
    public static function getDeliveredOrderDevices($orderIDS,$status){
         $Corefunctions = new \App\customclasses\Corefunctions;
          if( empty($orderIDS)){ return array();}
        
       $result = $Corefunctions->convertToArray(DB::table('rpm_order_devices')->whereIn('rpm_order_id', $orderIDS)->where('status',$status)->get());
         return $result;
    } 
     public static function rpmDeviceByIDS($deviceIDS){
         if( empty($deviceIDS)){ return array(); }
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('ref_rpm_devices')->whereIn('id', $deviceIDS)->get());
         $result = $Corefunctions->getArrayIndexed1($result,'id');
        return $result ;
	}
      public static function getRpmInvoices($autochargeDate,$typeID,$status){
       $Corefunctions = new \App\customclasses\Corefunctions;
       $result = $Corefunctions->convertToArray(DB::table('invoices')->where('autochargedate',$autochargeDate)->where('invoice_type_id',$typeID)->where('status',$status)->get());
         return $result;
    } 
     public static function orderByIDS($rpmorderIDS){
         if( empty($rpmorderIDS)){
             return array();
         }
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table('rpm_orders')->where('id', $rpmorderIDS)->get());
        return $result ;
	}
    public static function updateCancelledOn($orderID,$type,$cancelledBy){
        
        DB::table('rpm_orders')->where('id', $orderID)->update(array(
            'cancelled_by'              => $cancelledBy,
            'cancelled_by_type'         => $type,
            'cancelled_on'              => Carbon::now(),
            'updated_at'                => Carbon::now()
        ));
    }
    
    
    
}
