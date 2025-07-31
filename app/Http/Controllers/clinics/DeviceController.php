<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Patient;
use App\Models\ClinicUser;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\RefCountryCode;
use App\Models\RpmOrders;

use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use File;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        // Middleware for session check
        $this->middleware(function ($request, $next) {
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
                return Redirect::to('/');
            }
            // Check if the session has the 'user' key (adjust as per your session key)
             $sessionCeck = $this->Corefunctions->validateUser();
             if(!$sessionCeck){
                return Redirect::to('/logout');
            }
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
            return $next($request);
        });
    }
    
   
    /*Add Rpm Order   */
    public function addDevices(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $type = $data['type'];

            /** get patient Details */
            $userID         = $data['userID'];
            $patientDetails =   $this->Corefunctions->convertToArray(Patient::patientByUser($userID));
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if( $type == 'add'){
                $clinicId = session()->get('user.clinicID');
                $rpmDevices          = RpmOrders::getRpmDevices();
                $activeOrderDevices  = RpmOrders::getPatientRpmDevices($userID,$clinicId);
                $deviceIDS           = $this->Corefunctions->getIDSfromArray($activeOrderDevices, 'rpm_device_id');
                $activeDevices       = RpmOrders::rpmDevicesByIDS($deviceIDS);

                $data['activeDevices']    = $activeDevices ;
                $data['rpmDevices']       = $rpmDevices ;
                $html                     = view('appointment.devices.add', $data);
                $arr['view']              = $html->__toString();
            }
            if( $type == 'placeorder'){
                 parse_str($data['formData'], $input);
                 if( !isset($input['rpmdevices']) || empty($input['rpmdevices']) ){
                       return $this->Corefunctions->returnError('Please select devices');
                 }
                $rpmDevices               = RpmOrders::rpmDevicesByUUIDS($input['rpmdevices']);
                $deviceIDS      = $this->Corefunctions->getIDSfromArray($rpmDevices, 'id');
                $statusIDS      = array('-1');
                $clinicId       = session()->get('user.clinicID');
                $deviceOrders   = RpmOrders::rpmUserSelectedDevices($userID,$clinicId,$deviceIDS,$statusIDS);

                $existingDeviceNames = array();
                if( !empty($deviceOrders)){
                    $rpmDevices        = $this->Corefunctions->getArrayIndexed1($rpmDevices,'id');
                    foreach( $deviceOrders as $dv){
                        if( isset($rpmDevices[$dv['rpm_device_id']]) ){
                            $existingDeviceNames[] = $rpmDevices[$dv['rpm_device_id']]['device'];
                        }
                    }
                }
             
                 if(!empty($existingDeviceNames)){
                     $deviceNames = implode(",", $existingDeviceNames);
                    $errorMsg = "Devices already added: ".$deviceNames.'.';
                    $arr['error']    = 1;
                    $arr['errormsg'] = $errorMsg;
                    return response()->json($arr);
                    exit();
                }
                

                
                 $oneTimeTotal = $perMonthTotal = 0;
                 if( !empty($rpmDevices)){
                     foreach( $rpmDevices as $rpm){
                         $oneTimeTotal  += $rpm['one_time_charge'];
                         $perMonthTotal += $rpm['per_month_amount'];
                     }
                 }
                 $totalAmount              = $oneTimeTotal + $perMonthTotal;
                
                 $data['oneTimeTotal']     = $oneTimeTotal;
                 $data['perMonthTotal']    = $perMonthTotal;
                 $data['totalAmount']      = $totalAmount;
                 $data['rpmDevices']       = $rpmDevices;
                 $html                     = view('appointment.devices.selecteddevices', $data);
                 $arr['view']              = $html->__toString();   

            } 
            if( $type == 'confirmorder'){
                 parse_str($data['formData'], $input);
                 if( !isset($input['rpmdevices']) || empty($input['rpmdevices']) ){
                       return $this->Corefunctions->returnError('Please select devices');
                 }
                 $rpmDevices               = RpmOrders::rpmDevicesByUUIDS($input['rpmdevices']);
                
                $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::userByUUID(session()->get('user.clinicuser_uuid')));    
                $parentID = (!empty($clinicUserDetails)) && $clinicUserDetails['id'] ? $clinicUserDetails['id'] : '';
                
                $input['patient_id']        = $patientDetails['id'];
                $input['user_id']           = $patientDetails['user_id'];
                $input['clinic_id']         = $patientDetails['clinic_id'];
                $input['clinic_user_id']    = $parentID;
                $orderInfo                  = RpmOrders::addToRpmOrders( $input );
                
                 if( !empty($rpmDevices)){
                     foreach( $rpmDevices as $rpm){
                         $orderDeviceInfo  =  RpmOrders::addToOrderDevices( $rpm['id'],$orderInfo['id'] );
                     }
                 }
                
                /* Send Email To Patients */
                $clinic             = Clinic::clinicByID(session()->get('user.clinicID'));
                $clinicUserDoctor   = Appointment::getClinicUserDoctor(session()->get('user.clinicID'), $clinicUserDetails['user_id']);
                $clinicianName      = $this->Corefunctions->showClinicanName($clinicUserDoctor, '0');

                $emailData = [
                    'email'           => $patientDetails['email'],
                    'username'        => $patientDetails['first_name'].' '.$patientDetails['last_name'],
                    'clinicName'      => $clinic->name,
                    'doctorname'      => $clinicianName,
                    'orderInfo'       => $orderInfo,
                    'rpmDevices'      => $rpmDevices,
                ];
               
                $this->Corefunctions->sendmail($emailData, 'Your Medical Device Has Been Ordered', 'emails.deviceordered');
                
                /* Notification To Patients */
                $this->Corefunctions->addNotifications(21,session()->get('user.clinicID'),$patientDetails['user_id'],$orderInfo['id']);
                

            }

            
            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    public function checkSelectedDeviceExist(Request $request){
        $this->Corefunctions = new \App\customclasses\Corefunctions;

        if (request()->ajax()) {

            $data           = request()->all();
        
            $type           = $data['type'];
            $clinicId       = session()->get('user.clinicID');
            $userID         = $data['userID'];
            $deviceUUIDS    = ( isset($data['rpmdeviceuuids']) ) ? explode(',', $data['rpmdeviceuuids']) : array();
           
            $devices        = RpmOrders::rpmDevicesByUUIDS( $deviceUUIDS );
            $devices        = $this->Corefunctions->getArrayIndexed1($devices,'id');
            $deviceIDS      = $this->Corefunctions->getIDSfromArray($devices, 'id');
            $statusIDS      = array('-1');
            $deviceOrders   = RpmOrders::rpmUserSelectedDevices($userID,$clinicId,$deviceIDS,$statusIDS);
            
            $existingDeviceNames = array();
            if( !empty($deviceOrders)){
                foreach( $deviceOrders as $dv){
                    if( isset($devices[$dv['rpm_device_id']]) ){
                        $existingDeviceNames[] = $devices[$dv['rpm_device_id']]['device'];
                    }
                }
            }


            
            if(!empty($existingDeviceNames)){
                $deviceNames = implode(",", $existingDeviceNames);
                $errorMsg = "Devices already added: ".$deviceNames.'.';
                return response()->json([
                    'valid' => false,
                    'message' => $errorMsg,
                ]);
            }
           
            return response()->json(['valid' => true]);

        }

    }
    
      public function cancelOrder(){
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $order  = RpmOrders::rpmOrderByUUID($data['key']);
            if( empty($order) ){
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Order';
                return response()->json($arr);
                exit();
            }
             if( $order['status'] != '1'){
                $arr['error'] = 1;
                $arr['errormsg'] = 'You cannot cancel this order';
                return response()->json($arr);
                exit();
             }
            
            /* Create Bearer Token */
            $token = $this->Corefunctions->createSmartmeterBearerToken('token');

            /* Create Order */
            $apiKey = env('SMARTMETER_API_KEY'); 


            $orderData = [
                'order' => [
                    'order_number'           => $order['order_code'],     

                ],
            ];

            $apiResponse = $this->Corefunctions->addSmartMeterAPI("cancel",$orderData,$token);
             if (!empty($apiResponse) && isset($apiResponse['status']) && $apiResponse['status']['code'] && $apiResponse['status']['code'] == '200') {
                RpmOrders::updateOrderStatus($order['id'], '5');
                RpmOrders::updateCancelledOn($order['id'], 'd',Session::get('user.userID'));
                        
            }
            

            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    } 
    
    
}
