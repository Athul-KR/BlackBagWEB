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
use App\Models\User;
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
                $userDetails = $this->Corefunctions->convertToArray(User::userByID($patientDetails->user_id));
                $appoinmentDate = $this->Corefunctions->timezoneChange($appointment['appointment_date'],"M d, Y").' | '.$this->Corefunctions->timezoneChange($appointment['appointment_time'],'h:i A');


                $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();
                //$customerStripeId = $patientDetails['stripe_customer_id'];
                
                $transferAmount = ($appointment->appointment_fee * (2.9 / 100)) + 0.3;
                $appoinmentData = array(
                    'amount' => (int) (((string) ($appointment->appointment_fee * 100))), // convert doller to cent,
                    'transferAmount' => (int) (((string) (env('APPLICATION_FEE') * 100))),
                    'paymentMethodId' => $data['payment_method'],
                    'stripe_customer_id' => $userDetails['stripe_customer_id'],
                    'descriptionApplicationFee' => 'Appointment fee  - '.$patientDetails->first_name.' '.$patientDetails->last_name.' | '.$appoinmentDate,
                    
                    'description' => 'Payment for appoinment ' . $appointment->appointment_uuid,
                    'metaData' => array(
                        'Name' => $patientDetails->first_name,
                        "Address" => $patientDetails->address,
                        "City" => $patientDetails->city,
                        "postal_code" => $patientDetails->zip,
                        "state" => $patientDetails->state,
                    ),
                    "name" => $patientDetails->first_name.' '.$patientDetails->last_name,
                    "email" => $patientDetails->email,
                    "stripe_user_id" => $stripeConnection->stripe_user_id,
                );
                $clientSecretResponse = $this->stripePayment->setupPaymentIntentOnbehalf($appoinmentData);
               
                if (!empty($clientSecretResponse) && $clientSecretResponse['status'] == 1) {
                    $clientSecret = $clientSecretResponse['response'];
                    if ($userDetails['stripe_customer_id'] == '') {
                        User::where('id', $userDetails['id'])->update(array(
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

                $paymentIntentId = isset($data['setupIntentID']) ? $data['setupIntentID'] : '';

                // Instant Payment //
                $result = $this->Corefunctions->instantPayment($paymentIntentId,$stripeConnection->stripe_user_id,$patientDetails,$input,$appointment);
                if(isset($result['status']) && $result['status'] == '0' ){
                    $arr['status'] = 0;
                    $arr['message'] = $result['message'];
                    return response()->json($arr);
                    exit();
                }
                $paymentIds = $result['paymentIds'];
                $cardDetails = $result['cardDetails'];

               
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
                $data['card_number'] = $cardDetails['card_num'];
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
            $arr['message'] = 'Payment done successfully';
            return response()->json($arr);
            exit();
        }
    }
    public function getStripeClientSecret(){
        if (request()->ajax()) {
            $clientSecret = '';
            $patientDetails = Patient::with('user')->where('user_id', Session::get('user.userID'))->whereNull('deleted_at')->first();
            $userDetails = $this->Corefunctions->convertToArray(User::userByID(Session::get('user.userID')));
            if( !empty($patientDetails) ){
                $patientDetails['name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($patientDetails,Session::get('user.email')); 
                if(!empty($clientSecretResponse)){
                    $clientSecret = $clientSecretResponse['response'];
                    if($userDetails['stripe_customer_id']==''){
                        Payment::updateUserStripeCustomerIdInPatients($patientDetails['id'],$clientSecretResponse['customerID']);
                        Payment::updateUserStripeCustomerIdInUsers(Session::get('user.userID'),$clientSecretResponse['customerID']);
                    }
                }
            }
            $arr['clientSecret'] = $clientSecret;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function getClinicStripeClientSecret(){
        if (request()->ajax()) {
            $clientSecret = '';
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID(Session::get('user.clinicID')));
            if( !empty($clinicDetails) ){
                $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($clinicDetails,Session::get('user.email')); 
                if(!empty($clientSecretResponse)){
                    $clientSecret = $clientSecretResponse['response'];
                    if($clinicDetails['stripe_customer_id']==''){
                        Payment::updateUserStripeCustomerIdInClinics($clinicDetails['id'],$clientSecretResponse['customerID']);
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
