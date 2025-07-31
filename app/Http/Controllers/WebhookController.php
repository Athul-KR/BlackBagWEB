<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use DB;
use File;
use App\Models\RpmOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Psy\Command\WhereamiCommand;
use Redirect;
use Str;
use Illuminate\Support\Facades\Session;
use App\customclasses\Corefunctions;


class WebhookController extends Controller
{


    public function __construct()
    {  
        $this->Corefunctions = new \App\customclasses\Corefunctions;
     
    }
    public function addSmartMeterNotifications(){
        
        $returndata = array();
        
        $apiKey = env('SMARTMETER_API_KEY'); // Replace with your actual API key
        
        $token = $this->Corefunctions->createSmartmeterBearerToken('token');
       // $url = "https://dev.api.smartmeterrpm.com/api/notifications";
        $url = env('SMARTMETER_API_URL') . 'notifications';
            
        $params['api_key']      = $apiKey;
        $params['notify_url']   = url('api/smartmeter/get_fulfillments');
        $params['immediate']    = true;
        $params['type']         = 'fulfillment';
        
        $params['api_key']      = $apiKey;
        $params['notify_url']   = url('api/smartmeter/readings');
        $params['immediate']    = true;
        $params['type']         = 'reading';
        
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-KEY: ' . $apiKey,
            'Authorization: Bearer '.$token
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        $response = curl_exec($ch);
        $result = json_decode($response, true);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
           print "<pre>";
           print_r("....No error ..");
           print_r($result);
           exit;
        }
            curl_close($ch);
        }
    
    public function smartMeterFulfillments(){

        $jsonData            = file_get_contents('php://input');
        $input               = json_decode($jsonData, true);
        RpmOrders::insertWebhookData($_POST,$_REQUEST,$input,'r');
       /* RpmOrders::insertWebhookData($_POST,$_REQUEST,$input);
      return response()->json(['status' => 200]);*/
        /*$webhookResponse = RpmOrders::webhookByID('37');
        if( !empty($webhookResponse)){
           $input = ( $webhookResponse['inputdata'] != '') ? unserialize($webhookResponse['inputdata']) : array(); 
        }*/
   
        if( !empty( $input ) ){
             if( $input['status'] == 'shipped' ){
                 $orderReference    = ( $input['order_number'] ) ? $input['order_number'] : '';
                 if( $orderReference != ''){
                     $orderDets         = RpmOrders::orderByOrderCode($input['order_number']);
                     
                     
                     
                     if( !empty($orderDets) ){
                         RpmOrders::updateOrderStatus($orderDets['id'],'2');  
                         RpmOrders::updateRpmPatient($orderDets['patient_id'],'1');  
                         
                        /*  $devices = ( isset($input['devices'] ) ) ? $input['devices'] : array();
                          if( !empty($devices) ){
                              foreach( $devices as $dv){
                                  if( isset( $dv['status'] ) && $dv['status'] == 'shipped' ){
                                      $serial       = ( $dv['serial_number'] ) ? $dv['serial_number'] : "";
                                      $deviceId     = ( $dv['device_id'] ) ? $dv['device_id'] : "";
                                      if( $serial != '' && $deviceId != ''){
                                         // RpmOrders::updateDeviceMacID($deviceId,$serial);
                                      }
                                  }
                              }
                          }*/
                     }
                 }
         
             }
        }
        
        

    }   
    public function smartMeterFetchdataBack(){
         $jsonData            = file_get_contents('php://input');
        $input               = json_decode($jsonData, true);
        RpmOrders::insertWebhookData($_POST,$_REQUEST,$input,'r');
        
        
/*      RpmOrders::insertWebhookData($_POST,$_REQUEST,$input);
      return response()->json(['status' => 200]);*/
        
        /* $webhookResponse = RpmOrders::webhookByID('37');*/
        
        $orderDevices   = RpmOrders::getOrderDevices();
        $orderDevices   = $this-> Corefunctions->getArrayIndexed1($orderDevices,'device_macid');
        
        
        $startDate      = date('Y-m-d',strtotime('-2 days'));
        $startTime      = date('H:i:s',strtotime('-1 hour'));
        $startDate      = $startDate.'T'.$startTime;
        $endxtime       = strtotime('+1 hour');
        $endDate        = date('Y-m-d',strtotime('+8 hours'));
        $endTime        = date('H:i:s',strtotime('+8 hours'));
        $endDate        = $endDate.'T'.$endTime;
        
        $deviceMacIDS   = $this->Corefunctions->getIDSfromArray($orderDevices,'device_macid');
        $rpmOrderIDS    = $this->Corefunctions->getIDSfromArray($orderDevices,'rpm_order_id');
        $smartMeterData = $this->fetchSmartMeterData($deviceMacIDS,$startDate,$endDate);
        $rpmOrders      = RpmOrders::rpmOrdersByIDS($rpmOrderIDS);
        $rpmOrders      = $this-> Corefunctions->getArrayIndexed1($rpmOrders,'id');

 
        if( !empty( $smartMeterData ) ){
            if( isset( $smartMeterData['readings'] ) && !empty( $smartMeterData['readings'] ) ){
                foreach( $smartMeterData['readings'] as $srk => $srv ){
                    $userID  = ( !empty($rpmOrders) && isset( $orderDevices[$srv['device_id']] ) && isset( $rpmOrders[$orderDevices[$srv['device_id']]['rpm_order_id'] ] ) ) ? $rpmOrders[$orderDevices[$srv['device_id']]['rpm_order_id'] ]['user_id'] : NULL;
                    $clinicID  = ( !empty($rpmOrders) && isset( $orderDevices[$srv['device_id']] ) && isset( $rpmOrders[$orderDevices[$srv['device_id']]['rpm_order_id'] ] ) ) ? $rpmOrders[$orderDevices[$srv['device_id']]['rpm_order_id'] ]['clinic_id'] : NULL;
                    
                    $recordedtime = strtotime($srv['date_recorded']) + ($srv['time_zone_offset'] * 3600);
                    $srv['date_recorded'] = date('Y-m-d h:i A',$recordedtime);

                    if( isset( $orderDevices[$srv['device_id']] ) ){
                        /* Blood Glucose */
                        if( $srv['reading_type'] == 'blood_glucose' ){
                            $bgExist = RpmOrders::checkRPMDataExists('glucose_tracker',$userID,$srv['reading_id'],$orderDevices[$srv['device_id']]['rpm_device_id']);
                            if( empty( $bgExist ) ){
                                RpmOrders::addSmartMeterBGTracker($userID, $orderDevices[$srv['device_id']]['rpm_device_id'], $srv,$clinicID);

                            }

                            /* Check & update RPM Start Date */
                            $clinicUser = RpmOrders::clinicUserByuserID($userID,$clinicID);
                            if( !empty( $clinicUser ) && $clinicUser['rpm_startdate'] == '0000-00-00' ){
                                $firstSyncDate = RpmOrders::getRPMFirstSyncDate('glucose_tracker',$userID, $orderDevices[$srv['device_id']]['rpm_device_id'],$clinicID);
                                if( !empty( $firstSyncDate ) ){
                                   RpmOrders::updateRPMStartDate($clinicUser['id'],$firstSyncDate['reportdate']);
                                }
                            }
                        }

                        /* Blood Pressure */
                        if( $srv['reading_type'] == 'blood_pressure' ){
                            $bpExist = RpmOrders::checkRPMDataExists('bp_tracker',$userID,$srv['reading_id'],$orderDevices[$srv['device_id']]['rpm_device_id']);
                            if( empty( $bpExist ) ){
                                RpmOrders::addSmartMeterBPTracker($userID, $orderDevices[$srv['device_id']]['rpm_device_id'], $srv,$clinicID);

                            }

                            /* Check & update RPM Start Date */
                            $clinicUser = RpmOrders::clinicUserByuserID($userID,$clinicID);
                            if( !empty( $clinicUser ) && $clinicUser['rpm_startdate'] == '0000-00-00' ){
                                $firstSyncDate = $this->rpm_model->getRPMFirstSyncDate('bptracker',$userID, $orderDevices[$srv['device_id']]['rpm_device_id'],$clinicID);
                                if( !empty( $firstSyncDate ) ){
                                     RpmOrders::updateRPMStartDate($clinicUser['id'],$firstSyncDate['reportdate']);
                                }
                            }
                        }

                        /* Weight */
                        if(  $srv['reading_type'] == 'weight' ){
                            $weightExist = RpmOrders::checkRPMDataExists('weight_tracker',$userID,$srv['reading_id'],$orderDevices[$srv['device_id']]['rpm_device_id']);
                            if( empty( $weightExist ) ){
                                $weightArr = $srv;
                                /* BMI Calculation */
                                $userHeight =  RpmOrders::currentVitalRecords($userID);
                                if( !empty( $userHeight ) ){
                                    $feetToInch = ($userHeight['heightfeet']*12)+$userHeight['heightinch'];
                                    $feetToInchSquare = $feetToInch * $feetToInch;
                                    $cmToM = $userHeight['heightcm']/100;
                                    $metreSquare = $cmToM * $cmToM;
                                    $weightArr['bmilbs'] = round($srv['weight_lbs']/$feetToInchSquare,2);
                                    $weightArr['bmikg'] = round($srv['weight_kg']/$metreSquare,2);
                                }

                               RpmOrders::addSmartMeterWTTracker($userID, $orderDevices[$srv['device_id']]['rpm_device_id'], $weightArr,$clinicID);

                            }

                            /* Check & update RPM Start Date */
                            $clinicUser = RpmOrders::clinicUserByuserID($userID,$orderDevices[$srv['device_id']]['organizationid']);
                            if( !empty( $clinicUser ) && $clinicUser['rpm_startdate'] == '0000-00-00' ){
                                $firstSyncDate = $this->rpm_model->getRPMFirstSyncDate('weight_tracker',$userID, $orderDevices[$srv['device_id']]['rpm_device_id'],$clinicID);
                                if( !empty( $firstSyncDate ) ){
                                     RpmOrders::updateRPMStartDate($clinicUser['id'],$firstSyncDate['reportdate']);
                                }
                            }
                        }

                        /* Oxygen Saturation */
                        if( $srv['reading_type'] == 'pulse_ox' ){
                            $o2SatExist =RpmOrders::checkRPMDataExists('oxygen_saturations',$userID,$srv['reading_id'],$orderDevices[$srv['device_id']]['rpm_device_id']);
                            if( empty( $o2SatExist ) ){
                                RpmOrders::addSmartMeterOxygenSaturation($userID, $orderDevices[$srv['device_id']]['rpm_device_id'], $srv,$clinicID);

                            }

                            /* Check & update RPM Start Date */
                            $clinicUser = RpmOrders::clinicUserByuserID($userID,$clinicID);
                            if( !empty( $clinicUser ) && $clinicUser['rpm_startdate'] == '0000-00-00' ){
                                $firstSyncDate = $this->rpm_model->getRPMFirstSyncDate('oxygen_saturation',$userID, $orderDevices[$srv['device_id']]['rpm_device_id'],$clinicID);
                                if( !empty( $firstSyncDate ) ){
                                     RpmOrders::updateRPMStartDate($clinicUser['id'],$firstSyncDate['reportdate']);
                                }
                            }
                        }

                       // $this -> rpm_model -> updateRPMUserDeviceLastSync( $orderDevices[$srv['device_id']]['userdeviceid'], time() );
                    }
                }
            }
        }
        
        

    }
    
     public function fetchSmartMeterData($deviceMacIDS,$startDate,$endDate){            
        $returndata = array();
        $url = 'readings/';

        $modules = array('blood_glucose','blood_pressure','weight','pulse_ox');

        $params['api_key']      = env('SMARTMETER_API_KEY');
        $params['date_start']   = $startDate;
        $params['date_end']     = $endDate;
        $params['reading_type'] = $modules;
        $params['device_ids']   = $deviceMacIDS;

        $returndata = $this -> additionalfunctions->addSmartMeterAPI($url,$params);

        return $returndata;
    } 
    public function getFulfillments(){            
     $jsonData            = file_get_contents('php://input');
     $input               = json_decode($jsonData, true);

       RpmOrders::insertWebhookData($_POST,$_REQUEST,$input,'r');
        
        
       /* return response()->json(['status' => 200]);
        $webhookResponse = RpmOrders::webhookByID('37');
        if( !empty($webhookResponse)){
           $input = ( $webhookResponse['inputdata'] != '') ? unserialize($webhookResponse['inputdata']) : array(); 
        }*/
   
        if( !empty( $input ) ){
             if( $input['status'] == 'shipped' ){
                 $orderReference    = ( $input['order_number'] ) ? $input['order_number'] : '';
                 if( $orderReference != ''){
                     $orderDets         = RpmOrders::orderByOrderCode($input['order_number']);
                     
                     
                     
                     if( !empty($orderDets) ){
                         RpmOrders::updateOrderStatus($orderDets['id'],'2');  
                         RpmOrders::updateRpmPatient($orderDets['patient_id'],'1');  
                         RpmOrders::updateTackingNumber($orderDets['id'],$input['tracking_number']);  
                        
                     }
                 }
             }
               if( $input['status'] == 'delivered' ){
                 $orderReference    = ( $input['order_number'] ) ? $input['order_number'] : '';
                 if( $orderReference != ''){
                     $orderDets         = RpmOrders::orderByOrderCode($input['order_number']);
                     
                     if( !empty($orderDets) ){
                         RpmOrders::updateOrderStatus($orderDets['id'],'4');  
                        
                     }
                 }
             }
        }
        return response()->json(['status' => 200]);
    }
    
        public function smartMeterFetchdata(){
         $jsonData            = file_get_contents('php://input');
        $input               = json_decode($jsonData, true);
        
      RpmOrders::insertWebhookData($_POST,$_REQUEST,$input,'r');
     // return response()->json(['status' => 200]);
        
        /*$webhookResponse = RpmOrders::webhookByID('16');
        
        $input = array();
        if( !empty($webhookResponse)){
           $input = ( $webhookResponse['inputdata'] != '') ? unserialize($webhookResponse['inputdata']) : array(); 
        }
    */
        if( !empty( $input ) ){
            $readingType    = trim($input['reading_type']);
            $readingID      = $input['reading_id'];
            $deviceID       = $input['device_id'];
            $orderDevice    = RpmOrders::orderDeviceByDeviceMacID($deviceID);
            $insertData     = array();

            if( !empty($orderDevice) ){
            $order          =  RpmOrders::rpmOrderByID($orderDevice['rpm_order_id']);
            $insertData     =  $input;
            $insertData['source_type_id']  = '4';
            if( !empty($order) ){
                 switch ($readingType) {
                    case 'blood_glucose':
                         $bgExist = RpmOrders::checkRPMDataExists('glucose_tracker',$order['user_id'],$insertData['reading_id'],$orderDevice['rpm_device_id']);
                         if( empty($bgExist) ){
                             RpmOrders::addSmartMeterBGTracker($order['user_id'],$orderDevice['rpm_device_id'],$insertData,$order['clinic_id']);
                         }
                         break; 
                    case 'weight':
                         $insertData['unit']    = 'kg';
                         $insertData['user_id'] = $order['user_id'];
                          $insertData['weight']   = $insertData['weight_kg'];
                         $bmi                    = $this->Corefunctions->getBmiDetails($insertData);
                      
                         $insertData['bmi']  = ( isset($bmi) ) ? $bmi : NULL;
                         $wtExist = RpmOrders::checkRPMDataExists('weight_tracker',$order['user_id'],$insertData['reading_id'],$orderDevice['rpm_device_id']);
                    
                         if( empty($wtExist)){
                            RpmOrders::addSmartMeterWTTracker($order['user_id'],$orderDevice['rpm_device_id'],$insertData,$order['clinic_id']);
                         }
                         break;   
                     case 'pulse_ox':
                     
                         $pulseExist = RpmOrders::checkRPMDataExists('oxygen_saturations',$order['user_id'],$insertData['reading_id'],$orderDevice['rpm_device_id']);
                         if( empty($pulseExist)){
                            RpmOrders::addSmartMeterOxygenSaturation($order['user_id'],$orderDevice['rpm_device_id'],$insertData,$order['clinic_id']);
                         }
                         break;
                     case 'blood_pressure':
                     
                         $bpExist = RpmOrders::checkRPMDataExists('bp_tracker',$order['user_id'],$insertData['reading_id'],$orderDevice['rpm_device_id']);
                         if( empty($bpExist)){
                            RpmOrders::addSmartMeterBPTracker($order['user_id'],$orderDevice['rpm_device_id'],$insertData,$order['clinic_id']);
                         }
                         break;
                    default:
                        break;
                 }
                }
            }
  
            
            
        }
       return response()->json(['status' => 200]);     
       print "<pre>";
       print_r($input);
       exit;
 
        
        

    }
   public function dosespotNotifications(){

        $jsonData            = file_get_contents('php://input');
        $input               = json_decode($jsonData, true);
        RpmOrders::insertWebhookData($_POST,$_REQUEST,$input,'e');
        return response()->json(['status' => 200]);
   }
    
   

}
