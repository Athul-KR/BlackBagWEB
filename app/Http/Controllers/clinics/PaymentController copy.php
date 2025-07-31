<?php

namespace App\Http\Controllers\clinics;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\RefState;
use App\Models\Clinic;
use App\Models\ClinicUser;
use App\Models\Consultant;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\PatientCard;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;

        $this->stripePayment = new \App\customclasses\StripePayment;
        $this->middleware(function ($request, $next) {
            if (session()->has('user') == false) {

                // Redirect to login page if session does not exist
                return Redirect::to('/login');
            }
            return $next($request);
        });
    }

    // Delete Function
    protected function createpaymentIntent()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $appoinmentuuid = $data['appoinment_uuid'];
            $usertype = Session::get('user.userType');
            $appointment = Appointment::select('appointment_uuid', 'is_paid', 'clinic_id', 'payment_required', 'appointment_fee', 'patient_id', 'patient_id', 'appointment_date', 'appointment_time')->where('appointment_uuid', $appoinmentuuid)->first();
            if (empty($appointment)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Appointment invalid',
                ]);
            }
            if (!empty($appointment) && $appointment->is_paid == '1') {
                return response()->json([
                    'status' => 0,
                    'message' => 'Payment already done'
                ]);
            }
            $clientSecret = $payment_intent_id = '';
            if ($appointment->is_paid == '0' && $appointment->payment_required == '1') {
                $patientDetails = Patient::where('user_id', $appointment->patient_id)->first();
                if (empty($patientDetails)) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'Patient invalid',
                    ]);
                }
                $clinic = Clinic::select('stripe_connection_id')->whereNull('deleted_at')->where('id', $appointment->clinic_id)->first();
                if (empty($clinic)) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'clinic invalid',
                    ]);
                }
                $appoinmentDate = $this->Corefunctions->timezoneChange($appointment['appointment_date'],"M d, Y").' | '.$this->Corefunctions->timezoneChange($appointment['appointment_time'],'h:i A');


                $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();
                $customerStripeId = $patientDetails['stripe_customer_id'];
                $transferAmount = ($appointment->appointment_fee * (2.9 / 100)) + 0.3;
                $appoinmentData = array(
                    'amount' => (int) (((string) ($appointment->appointment_fee * 100))), // convert doller to cent,
                    'transferAmount' => (int) (((string) (env('APPLICATION_FEE') * 100))),
                    'paymentMethodId' => $data['payment_method'],
                    'stripe_customer_id' => $patientDetails->stripe_customer_id,
                    'descriptionApplicationFee' => 'Appointment fee  - '.$patientDetails->first_name.' '.$patientDetails->last_name.' | '.$appoinmentDate,
                    
                    'description' => 'Payment for appoinment ' . $appointment->appointment_uuid,
                    'metaData' => array(
                        'Name' => $patientDetails->first_name,
                        "Address" => $patientDetails->address,
                        "City" => $patientDetails->city,
                        "postal_code" => $patientDetails->zip,
                        "state" => $patientDetails->state,
                    ),
                    "name" => $patientDetails->first_name,
                    "email" => $patientDetails->email,
                    "stripe_user_id" => $stripeConnection->stripe_user_id,
                );

                $clientSecretResponse = $this->stripePayment->setupPaymentIntent($appoinmentData);
                print_r($clientSecretResponse);die;
                if (!empty($clientSecretResponse) && $clientSecretResponse['status'] == 1) {
                    $clientSecret = $clientSecretResponse['response'];
                    if ($patientDetails['stripe_customer_id'] == '') {
                        Patient::where('id', $patientDetails['id'])->update(array(
                            'stripe_customer_id' => $clientSecretResponse['customerID'],
                        ));
                    }
                    $payment_intent_id = $clientSecretResponse['payment_intent_id'];
                    $paymentstatus = $clientSecretResponse['paymentstatus'];
                } else {
                    return response()->json([
                        'status' => 0,
                        'message' => $clientSecretResponse['message'],
                    ]);
                }
            }

            $arr['amount'] = $appointment->appointment_fee;
            $arr['paymentstatus'] = $paymentstatus;
            $arr['clientSecret'] = $clientSecret;
            $arr['payment_intent_id'] = $payment_intent_id;
            $arr['appoinmentuuid'] = $appoinmentuuid;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    protected function createpaymentIntentNew()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $appoinmentuuid = $data['appoinment_uuid'];
            $usertype = Session::get('user.userType');
            $appointment = Appointment::select('appointment_uuid', 'is_paid', 'clinic_id', 'payment_required', 'appointment_fee', 'patient_id', 'patient_id', 'appointment_date', 'appointment_time')->where('appointment_uuid', $appoinmentuuid)->first();
            if (empty($appointment)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Appointment invalid',
                ]);
            }
            if (!empty($appointment) && $appointment->is_paid == '1') {
                return response()->json([
                    'status' => 0,
                    'message' => 'Payment already done'
                ]);
            }
            $clientSecret = $payment_intent_id = '';
            if ($appointment->is_paid == '0' && $appointment->payment_required == '1') {
                $patientDetails = Patient::where('user_id', $appointment->patient_id)->first();
                if (empty($patientDetails)) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'Patient invalid',
                    ]);
                }
                $clinic = Clinic::select('stripe_connection_id')->whereNull('deleted_at')->where('id', $appointment->clinic_id)->first();
                if (empty($clinic)) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'clinic invalid',
                    ]);
                }
                $appoinmentDate = $this->Corefunctions->timezoneChange($appointment['appointment_date'],"M d, Y").' | '.$this->Corefunctions->timezoneChange($appointment['appointment_time'],'h:i A');

                $customerStripeId = $patientDetails['stripe_customer_id'];
                $appoinmentData = array(
                    'amount' => (int) (((string) ($appointment->appointment_fee * 100))), // convert doller to cent,
                    'paymentMethodId' => $data['payment_method'],
                    'stripe_customer_id' => $patientDetails->stripe_customer_id,
                    'description' => 'Payment for appoinment ' . $appointment->appointment_uuid,
                    'metaData' => array(
                        'Name' => $patientDetails->first_name.' '.$patientDetails->last_name,
                        "Address" => $patientDetails->address,
                        "City" => $patientDetails->city,
                        "postal_code" => $patientDetails->zip,
                        "state" => $patientDetails->state,
                    ),
                    "name" => $patientDetails->first_name.' '.$patientDetails->last_name,
                    "email" => $patientDetails->email,
                    "stripe_user_id" => '',
                );

                $clientSecretResponse = $this->stripePayment->setupPaymentIntentNew($appoinmentData);

                if (!empty($clientSecretResponse) && $clientSecretResponse['status'] == 1) {
                    $clientSecret = $clientSecretResponse['response'];
                    if ($patientDetails['stripe_customer_id'] == '') {
                        Patient::where('id', $patientDetails['id'])->update(array(
                            'stripe_customer_id' => $clientSecretResponse['customerID'],
                        ));
                    }
                    $payment_intent_id = $clientSecretResponse['payment_intent_id'];
                    $paymentstatus = $clientSecretResponse['paymentstatus'];
                } else {
                    return response()->json([
                        'status' => 0,
                        'message' => $clientSecretResponse['message'],
                    ]);
                }
            }

            $arr['amount'] = $appointment->appointment_fee;
            $arr['paymentstatus'] = $paymentstatus;
            $arr['clientSecret'] = $clientSecret;
            $arr['payment_intent_id'] = $payment_intent_id;
            $arr['appoinmentuuid'] = $appoinmentuuid;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function submitPayment()
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Fields missing',
                ]);
            }
            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            $appointment = Appointment::where('appointment_uuid', $data['appoinment_uuid']) ->with( 'consultant')->first();
            if ($appointment->is_paid == '0' && $appointment->payment_required == '1') {
                $clinicUserDoctor = ClinicUser::with('user')->where('user_id',$appointment->consultant_id)->whereNull('deleted_at')->first();
                $patientDetails = $this->Corefunctions->convertToArray(Patient::with('user')->where('user_id', $appointment->patient_id)->whereNull('deleted_at')->first());

                $paymentIntentId = $data['setupIntentID'];
                $clinic = Clinic::select('stripe_connection_id','name','phone_number','address as billing_address','state as billing_state','city as billing_city','zip_code as billing_zip','country_id as billing_country_id','state_id','country_code','logo')->whereNull('deleted_at')->where('id', $appointment->clinic_id)->first();
                if (empty($clinic)) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'clinic invalid',
                    ]);
                }
                $clinic->country_code = isset($clinic->country_code) && ($clinic->country_code != '') ? $this->Corefunctions->getCountryCode($clinic->country_code) : '';

                if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
                    return response()->json([
                         'status' => 0,
                        'message' => 'Stripe not connected',
                    ]);
                }
                $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();
                $paymentIntentId = $this->stripePayment->retrievePaymentIntent($paymentIntentId, $stripeConnection->stripe_user_id);
                $intentDetails = json_decode(json_encode($paymentIntentId), true);
                print "<pre>";
                print_r($intentDetails);
                exit;

                $paymentMethodResponse = $this->stripePayment->retrievePaymentMethod($intentDetails['response']['payment_method'], $stripeConnection->stripe_user_id);
                $paymentMethodResponse = json_decode(json_encode($paymentMethodResponse['response']), true);

                if (!empty($intentDetails) && $intentDetails['success'] == 1) {
                    if ($intentDetails['response']['status'] == 'requires_action') {
                        return response()->json([
                            'status' => 1,
                            'action_url' => $intentDetails['response']['next_action']['redirect_to_url']['url'],
                            'return_url' => url('stripe/webhooks/3dsecureauthentication'),
                        ]);
                    }
                }

                /** insert payment section */
                $cardDetails = !empty($paymentMethodResponse['card']) ? $paymentMethodResponse['card'] : array();
               
                $stripe_fee = ($appointment->appointment_fee * (2.9 / 100)) + 0.3;
                $platform_fee = env('APPLICATION_FEE');
                /*** insert card details */
                // insert card details
                $card_uuid = $this->Corefunctions->generateUniqueKey("10", "patient_cards", "patient_card_uuid");
                $cardObject = new PatientCard();
                $cardObject->patient_card_uuid = $card_uuid;
                $cardObject->exp_month = $cardDetails['exp_month'];
                $cardObject->exp_year = $cardDetails['exp_year'];
                $cardObject->name_on_card = isset($input['name_on_card']) ? $input['name_on_card'] : $patientDetails['first_name'];
                $cardObject->card_num = $cardDetails['last4'];
                $cardObject->card_type = $cardDetails['brand'];
                //$cardObject->stripe_card_id = $cardDetails['stripe_cardid'];
                $cardObject->user_id = session()->get('user.userID');
                $cardObject->status = '1';
                $cardObject->save();
                $cardID = $cardObject->id;

                /** insert to transaction table */
                $transactionId = Payment::insertTransactions(json_encode($paymentIntentId), session()->get('user.userID'), $appointment->clinic_id);

                $stateID = (isset($patientDetails['user']['state_id']) && $patientDetails['user']['state_id'] !='') ? $patientDetails['user']['state_id'] : $patientDetails['state_id'];
                $state = $this->Corefunctions->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id',$stateID)->whereNull('deleted_at')->first());
                $patientDetails['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] :( (isset($patientDetails['user']['state']) && $patientDetails['user']['state'] !='') ? $patientDetails['user']['state'] : $patientDetails['state_id'] );

                // inputParams
                $inputParams = array();
                /** Input datea for store to payment table */
                $inputParams['billing_name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $inputParams['billing_email'] = $patientDetails['email'];
                $inputParams['country_id'] = $patientDetails['country_code'];
                $inputParams['phone_number'] = $patientDetails['phone_number'];
                $inputParams['address'] = (isset($patientDetails['user']['address']) && $patientDetails['user']['address'] !='') ? $patientDetails['user']['address'] : $patientDetails['address'];
                $inputParams['city'] =  (isset($patientDetails['user']['city']) && $patientDetails['user']['city'] !='') ? $patientDetails['user']['city'] : $patientDetails['city'];
                $inputParams['zip'] =  (isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code'] !='') ? $patientDetails['user']['zip_code'] : $patientDetails['zip'];
                $inputParams['state'] = $patientDetails['state'];
                $inputParams['name_on_card'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $inputParams['card_number'] = $cardDetails['last4'];
                $inputParams['card_type'] = $cardDetails['brand'];
                $inputParams['expiry_year'] = $cardDetails['exp_year'];
                $inputParams['expiry_month'] = $cardDetails['exp_month'];
                $inputParams['stripe_fee'] = $stripe_fee;
                $inputParams['platform_fee'] = $platform_fee;

                $paymentDetails['stripe_customerid'] = $patientDetails['stripe_customer_id'];
                $paymentDetails['stripe_paymentid'] = isset($intentDetails['response']['id']) ? $intentDetails['response']['id'] : null;
                $paymentDetails['card_id'] = $cardID;
                $paymentDetails['amount'] = $appointment->appointment_fee;
                $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

                $inputParams['appntID'] = $appointment->id;

                $paymentKey = $this->Corefunctions->generateUniqueKey('10', 'payments', 'payment_uuid');



                $paymentIds = Payment::savePaymentData($inputParams, $paymentKey, session()->get('user.userID'), $paymentDetails, '1',$clinic);

                /** update paid status  */
                DB::table('appointments')->where('id', $appointment->id)->update(array(
                    'is_paid' => '1',
                ));

                /** receipt mail for patient */
                $data['email'] = $patientDetails['email'];
                $data['name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $data['clinicName'] = $clinic->name;
                $data['receipt_num'] = '#'.$paymentIds['receipt_num'];
                $data['payment_method'] = 'Card';
                $data['amount'] =  $appointment->appointment_fee;
                $data['paymentdate'] =  carbon::now();
                $data['card_number'] = $cardDetails['last4'];
                $data['appointmnetDate'] = date('M d Y', strtotime($appointment->appointment_date));
                $data['appointmnetTime'] = date('h:i A', strtotime($appointment->appointment_time));
                $data['doctorname'] = $this->Corefunctions -> showClinicanName($clinicUserDoctor,'1');
                 // Appointment date and time
                $formattedTime = date('H:i:s', strtotime($appointment->appointment_time));
                $formattedDate = date('Y-m-d', strtotime($appointment->appointment_date));
                $appointmentDateTime = strtotime($appointment->appointment_time);
                $currentTimestamp = $this->Corefunctions->currentTime(); // Laravel's now() function gives you a Carbon instance


                // Get the current date and time
                // Calculate 10 minutes before and after the current time
                $minus10Minutes = $currentTimestamp - (15 * 60); // 10 minutes earlier
                $plus10Minutes = $currentTimestamp + (60 * 60);  // 10 minutes later

                // Check if the appointment date is today
                $isToday = $formattedDate === date('Y-m-d',$currentTimestamp);

                $overtime = $startAppoinment =0;
                // Check if the selected time is in the past
                if ($isToday && ($currentTimestamp >= $minus10Minutes && $currentTimestamp <= $plus10Minutes )) {
                    $startAppoinment = 1;
                }elseif ($isToday && $appointmentDateTime > $plus10Minutes) {
                    $overtime = 1;
                }elseif ($formattedDate >date('Y-m-d',$currentTimestamp) ) {
                    $overtime = 1;
                }
                
                $response = $this->Corefunctions->sendmail($data, 'Appointment Payment Receipt', 'emails.receipt');
                $html = view('appointment.paymentsuccess', compact('appointment','startAppoinment','overtime'))->render();
                return response()->json([
                    'status' => 1,
                    'html' => $html,
                    'message' => 'Payment completed ',
                ]);
            } else {
                $arr['status'] = 0;
                $arr['message'] = 'Payment already done';
                return response()->json($arr);
                exit();
            }

            $arr['success'] = 1;
            $arr['message'] = 'Appointment cancelled successfully';
            return response()->json($arr);
            exit();
        }
    }
    public function submitPaymentNew()
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Fields missing',
                ]);
            }
            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            $appointment = Appointment::where('appointment_uuid', $data['appoinment_uuid']) ->with( 'consultant')->first();
            if ($appointment->is_paid == '0' && $appointment->payment_required == '1') {
                $clinicUserDoctor = ClinicUser::with('user')->where('user_id',$appointment->consultant_id)->whereNull('deleted_at')->first();
                $patientDetails = $this->Corefunctions->convertToArray(Patient::with('user')->where('user_id', $appointment->patient_id)->whereNull('deleted_at')->first());

                $paymentIntentId = $data['setupIntentID'];
                
                $paymentIntentId = $this->stripePayment->retrievePaymentIntent($paymentIntentId, $patientDetails['stripe_customer_id']);
                $intentDetails = json_decode(json_encode($paymentIntentId), true);

                $paymentMethodResponse = $this->stripePayment->retrievePaymentMethod($intentDetails['response']['payment_method'], $patientDetails['stripe_customer_id']);
                $paymentMethodResponse = json_decode(json_encode($paymentMethodResponse['response']), true);

                if (!empty($intentDetails) && $intentDetails['success'] == 1) {
                    if ($intentDetails['response']['status'] == 'requires_action') {
                        return response()->json([
                            'status' => 1,
                            'action_url' => $intentDetails['response']['next_action']['redirect_to_url']['url'],
                            'return_url' => url('stripe/webhooks/3dsecureauthentication'),
                        ]);
                    }
                }

                /** insert payment section */
                $cardDetails = !empty($paymentMethodResponse['card']) ? $paymentMethodResponse['card'] : array();
               
                $stripe_fee = ($appointment->appointment_fee * (2.9 / 100)) + 0.3;
                $platform_fee = env('APPLICATION_FEE');
                /*** insert card details */
                // insert card details
                $card_uuid = $this->Corefunctions->generateUniqueKey("10", "patient_cards", "patient_card_uuid");
                $cardObject = new PatientCard();
                $cardObject->patient_card_uuid = $card_uuid;
                $cardObject->exp_month = $cardDetails['exp_month'];
                $cardObject->exp_year = $cardDetails['exp_year'];
                $cardObject->name_on_card = isset($input['name_on_card']) ? $input['name_on_card'] : $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $cardObject->card_num = $cardDetails['last4'];
                $cardObject->card_type = $cardDetails['brand'];
                $cardObject->user_id = session()->get('user.userID');
                $cardObject->status = '1';
                $cardObject->save();
                $cardID = $cardObject->id;

                /** insert to transaction table */
                $transactionId = Payment::insertTransactions(json_encode($paymentIntentId), session()->get('user.userID'), $appointment->clinic_id);

                $stateID = (isset($patientDetails['user']['state_id']) && $patientDetails['user']['state_id'] !='') ? $patientDetails['user']['state_id'] : $patientDetails['state_id'];
                $state = $this->Corefunctions->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id',$stateID)->whereNull('deleted_at')->first());
                $patientDetails['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] :( (isset($patientDetails['user']['state']) && $patientDetails['user']['state'] !='') ? $patientDetails['user']['state'] : $patientDetails['state_id'] );

                // inputParams
                $inputParams = array();
                /** Input datea for store to payment table */
                $inputParams['billing_name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $inputParams['billing_email'] = $patientDetails['email'];
                $inputParams['country_id'] = $patientDetails['country_code'];
                $inputParams['phone_number'] = $patientDetails['phone_number'];
                $inputParams['address'] = (isset($patientDetails['user']['address']) && $patientDetails['user']['address'] !='') ? $patientDetails['user']['address'] : $patientDetails['address'];
                $inputParams['city'] =  (isset($patientDetails['user']['city']) && $patientDetails['user']['city'] !='') ? $patientDetails['user']['city'] : $patientDetails['city'];
                $inputParams['zip'] =  (isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code'] !='') ? $patientDetails['user']['zip_code'] : $patientDetails['zip'];
                $inputParams['state'] = $patientDetails['state'];
                $inputParams['name_on_card'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $inputParams['card_number'] = $cardDetails['last4'];
                $inputParams['card_type'] = $cardDetails['brand'];
                $inputParams['expiry_year'] = $cardDetails['exp_year'];
                $inputParams['expiry_month'] = $cardDetails['exp_month'];
                $inputParams['stripe_fee'] = $stripe_fee;
                $inputParams['platform_fee'] = $platform_fee;

                $paymentDetails['stripe_customerid'] = $patientDetails['stripe_customer_id'];
                $paymentDetails['stripe_paymentid'] = isset($intentDetails['response']['id']) ? $intentDetails['response']['id'] : null;
                $paymentDetails['card_id'] = $cardID;
                $paymentDetails['amount'] = $appointment->appointment_fee;
                $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

                $inputParams['appntID'] = $appointment->id;

                $paymentKey = $this->Corefunctions->generateUniqueKey('10', 'payments', 'payment_uuid');

                $paymentIds = Payment::savePaymentData($inputParams, $paymentKey, session()->get('user.userID'), $paymentDetails, '1',$clinic);

                /** update paid status  */
                DB::table('appointments')->where('id', $appointment->id)->update(array(
                    'is_paid' => '1',
                ));

                /** receipt mail for patient */
                $data['email'] = $patientDetails['email'];
                $data['name'] = $patientDetails['first_name'];
                $data['clinicName'] = $clinic->name;
                $data['receipt_num'] = '#'.$paymentIds['receipt_num'];
                $data['payment_method'] = 'Card';
                $data['amount'] =  $appointment->appointment_fee;
                $data['paymentdate'] =  carbon::now();
                $data['card_number'] = $cardDetails['last4'];
                $data['appointmnetDate'] = date('M d Y', strtotime($appointment->appointment_date));
                $data['appointmnetTime'] = date('h:i A', strtotime($appointment->appointment_time));
                $data['doctorname'] = $this->Corefunctions -> showClinicanName($clinicUserDoctor,'1');
                 // Appointment date and time
                $formattedTime = date('H:i:s', strtotime($appointment->appointment_time));
                $formattedDate = date('Y-m-d', strtotime($appointment->appointment_date));
                $appointmentDateTime = strtotime($appointment->appointment_time);
                $currentTimestamp = $this->Corefunctions->currentTime(); // Laravel's now() function gives you a Carbon instance


                // Get the current date and time
                // Calculate 10 minutes before and after the current time
                $minus10Minutes = $currentTimestamp - (15 * 60); // 10 minutes earlier
                $plus10Minutes = $currentTimestamp + (60 * 60);  // 10 minutes later

                // Check if the appointment date is today
                $isToday = $formattedDate === date('Y-m-d',$currentTimestamp);

                $overtime = $startAppoinment =0;
                // Check if the selected time is in the past
                if ($isToday && ($currentTimestamp >= $minus10Minutes && $currentTimestamp <= $plus10Minutes )) {
                    $startAppoinment = 1;
                }elseif ($isToday && $appointmentDateTime > $plus10Minutes) {
                    $overtime = 1;
                }elseif ($formattedDate >date('Y-m-d',$currentTimestamp) ) {
                    $overtime = 1;
                }
                
                $response = $this->Corefunctions->sendmail($data, 'Appointment Payment Receipt', 'emails.receipt');
                $html = view('appointment.paymentsuccess', compact('appointment','startAppoinment','overtime'))->render();
                return response()->json([
                    'status' => 1,
                    'html' => $html,
                    'message' => 'Payment completed ',
                ]);
            } else {
                $arr['status'] = 0;
                $arr['message'] = 'Payment already done';
                return response()->json($arr);
                exit();
            }

            $arr['success'] = 1;
            $arr['message'] = 'Appointment cancelled successfully';
            return response()->json($arr);
            exit();
        }
    }
    public function submitPaymentPatient()
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Fields missing',
                ]);
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            // Fetch appointment details
            $appointment = Appointment::where('appointment_uuid', $data['appoinment_uuid'])
                ->with('consultant')
                ->first();

            if (!$appointment) {
                return response()->json(['status' => 0, 'message' => 'Invalid appointment']);
            }

            if ($appointment->is_paid == '1') {
                return response()->json(['status' => 0, 'message' => 'Payment already done']);
            }

            if ($appointment->payment_required != '1') {
                return response()->json(['status' => 0, 'message' => 'Payment not required for this appointment']);
            }

            // Get selected card details
            $userCard = Patientcard::getUserCardByKey($input['selected_card']);
            if (!$userCard) {
                return response()->json(['status' => 0, 'message' => 'Invalid Card']);
            }

            // Fetch clinic details
            $clinic = Clinic::select('stripe_connection_id', 'name')
                ->where('id', $appointment->clinic_id)
                ->whereNull('deleted_at')
                ->first();

            if (!$clinic || !$clinic->stripe_connection_id) {
                return response()->json(['status' => 0, 'message' => 'Clinic or Stripe not connected']);
            }

            // Fetch patient details
            $patientDetails = Patient::with('user')
                ->where('user_id', $appointment->patient_id)
                ->whereNull('deleted_at')
                ->first();

            if (!$patientDetails) {
                return response()->json(['status' => 0, 'message' => 'Patient not found']);
            }

            // Calculate Stripe fees and payment amount
            $appointmentFee = $appointment->appointment_fee;
            $stripe_fee = ($appointmentFee * 0.029) + 0.3;
            $platform_fee = env('APPLICATION_FEE', 0);

            // Create Stripe Payment Intent using selected card
            $paymentIntent = $this->stripePayment->createPaymentIntent(
                $appointmentFee * 100, // Amount in cents
                $patientDetails['stripe_customer_id'],
                $userCard['stripe_card_id'], // Using Stripe Card ID directly
                "Appointment Payment for {$appointment->id}"
            );

            if (isset($paymentIntent) && !empty($paymentIntent) && isset($paymentIntent['status']) && $paymentIntent['status'] == '1') {
                // Insert transaction details
                $transactionId = Payment::insertTransactions(
                    json_encode($paymentIntent),
                    session()->get('user.userID'),
                    $appointment->clinic_id
                );

                $inputParams = array();
                /** Input datea for store to payment table */
                $inputParams['billing_name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $inputParams['billing_email'] = $patientDetails['email'];
                $inputParams['country_id'] = $patientDetails['country_code'];
                $inputParams['phone_number'] = $patientDetails['phone_number'];
                $inputParams['address'] = (isset($patientDetails['user']['address']) && $patientDetails['user']['address'] !='') ? $patientDetails['user']['address'] : $patientDetails['address'];
                $inputParams['city'] =  (isset($patientDetails['user']['city']) && $patientDetails['user']['city'] !='') ? $patientDetails['user']['city'] : $patientDetails['city'];
                $inputParams['zip'] =  (isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code'] !='') ? $patientDetails['user']['zip_code'] : $patientDetails['zip'];
                $inputParams['state'] = $patientDetails['state'];
                $inputParams['name_on_card'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $inputParams['card_number'] = $userCard['card_num'];
                $inputParams['card_type'] = $userCard['card_type'];
                $inputParams['expiry_year'] = $userCard['exp_year'];
                $inputParams['expiry_month'] = $userCard['exp_month'];
                $inputParams['stripe_fee'] = $stripe_fee;
                $inputParams['platform_fee'] = $platform_fee;

                $paymentDetails['stripe_customerid'] = $patientDetails['stripe_customer_id'];
                $paymentDetails['stripe_paymentid'] = isset($paymentIntent['response']['id']) ? $paymentIntent['response']['id'] : null;
                $paymentDetails['card_id'] = $userCard['id'];
                $paymentDetails['amount'] = $appointment->appointment_fee;
                $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

                $inputParams['appntID'] = $appointment->id;

                // Save payment record
                $paymentKey = $this->Corefunctions->generateUniqueKey('10', 'payments', 'payment_uuid');
                Payment::savePaymentData(
                    $inputParams, 
                    $paymentKey, 
                    session()->get('user.userID'), 
                    $paymentDetails, 
                    '1', 
                    $clinic
                );

                // Mark appointment as paid
                DB::table('appointments')->where('id', $appointment->id)->update(array(
                    'is_paid' => '1',
                ));

                // Send payment receipt to patient
                $data = [
                    'email' => $patientDetails->email,
                    'name' => $patientDetails->first_name,
                    'clinicName' => $clinic->name,
                    'receipt_num' => '#'.$paymentKey,
                    'payment_method' => 'Card',
                    'amount' => $appointmentFee,
                    'paymentdate' => now(),
                    'card_number' => $userCard['card_num'],
                    'appointmnetDate' => date('M d Y',strtotime($appointment->appointment_date)),
                    'appointmnetTime' => date('h:i A',strtotime($appointment->appointment_time)),
                    'doctorname' => $appointment->consultant->user->name ?? 'Unknown',
                ];

                $this->Corefunctions->sendmail($data, 'Appointment Payment Receipt', 'emails.receipt');

            }

            $formattedTime = date('H:i:s', strtotime($appointment->appointment_time));
            $formattedDate = date('Y-m-d', strtotime($appointment->appointment_date));
            $appointmentDateTime = strtotime($appointment->appointment_time);
            $currentTimestamp = $this->Corefunctions->currentTime(); 
            $minus10Minutes = $currentTimestamp - (15 * 60); // 10 minutes earlier
            $plus10Minutes = $currentTimestamp + (60 * 60);  // 10 minutes later

            $isToday = $formattedDate === date('Y-m-d',$currentTimestamp);

            $overtime = $startAppoinment = 0;
            if ($isToday && ($currentTimestamp >= $minus10Minutes && $currentTimestamp <= $plus10Minutes )) {
                $startAppoinment = 1;
            }elseif ($isToday && $appointmentDateTime > $plus10Minutes) {
                $overtime = 1;
            }elseif ($formattedDate >date('Y-m-d',$currentTimestamp) ) {
                $overtime = 1;
            }

            // Success response with HTML
            $html = view('appointment.paymentsuccess', compact('appointment','startAppoinment','overtime'))->render();
            return response()->json([
                'status' => 1,
                'html' => $html,
                'message' => 'Payment completed successfully.',
            ]);

        }
    }
    public function getStripeClientSecret(){
        if (request()->ajax()) {
            $clientSecret = '';
            $patientDetails = Patient::with('user')->where('user_id', Session::get('user.userID'))->whereNull('deleted_at')->first();
            if( !empty($patientDetails) ){
                $patientDetails['name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($patientDetails,Session::get('user.email')); 
                if(!empty($clientSecretResponse)){
                    $clientSecret = $clientSecretResponse['response'];
                    if($patientDetails['stripe_customer_id']==''){
                        Payment::UpdateUserStripeCustomerIdInPatients($patientDetails['id'],$clientSecretResponse['customerID']);
                    }
                }
            }
            $arr['clientSecret'] = $clientSecret;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
}
