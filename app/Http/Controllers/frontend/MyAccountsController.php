<?php

namespace App\Http\Controllers\frontend;

use App\Models\ClinicUser;
use App\Models\PatientDocs;
use App\Models\RefState;
use App\Models\StripeConnection;
use App\Models\User;
use App\Models\Clinic;
use App\Models\FcUserFolder;
use App\Models\FcFile;
use App\Models\RefCountryCode;
use App\Models\UserBilling;
use App\Models\RpmOrders;
use Redirect;
use Session;
use App\Models\Otp;
use App\customclasses\Corefunctions;
use App\Models\Appointment;
use App\Models\Inquiry;
use App\Models\Patient;
use App\Models\PatientNoteHistory;
use App\Models\ClinicGallery;
use App\Models\VideoCallParticipant;
use App\Models\VideoCall;
use App\Models\AppointmentType;
use App\Models\Payment;
use App\Models\PatientCard;
use App\Models\ClinicSubscription;
use App\Models\PatientSubscription;
use App\Models\BpTracker;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\RefPlanIcons;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Validator;
use File;
use DateTimeZone;

class MyAccountsController extends Controller
{

    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->stripePayment      = new \App\customclasses\StripePayment;
    }

    /* my accounts */

    public function getAccountDatas()
    {

        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $clinicId = session('user.clinicID');
            $userId   = session('user.userID');
            $viewType =  isset($data['viewType']) ? $data['viewType'] : 'myprofile';
            $page     = isset($data['page']) ? $data['page'] : '';

            $patientDetails                     = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
            if (empty($patientDetails)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Patient does not exists';
                return response()->json($arr);
            }
            $userDetails = $this->Corefunctions->convertToArray(User::userByID($userId));

            switch ($viewType) {

                case 'myprofile':
                    $patientDetails['logo_path']        = isset($patientDetails['user']['profile_image']) && ($patientDetails['user']['profile_image'] != '') ? $this->Corefunctions->resizeImageAWS($patientDetails['user']['id'], $patientDetails['user']['profile_image'], $patientDetails['user']['first_name'], 180, 180, '1') : (($patientDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($patientDetails['logo_path']) : '');
                    $patientDetails['formattedAddress'] = (isset($patientDetails['user']) && $patientDetails['user']['address'] != '') ? $this->Corefunctions->formatAddress($patientDetails['user']) : $this->Corefunctions->formatAddress($patientDetails);

                    $countryCodeDetails          = isset($patientDetails['user']['country_code']) ? RefCountryCode::getCountryCodeById($patientDetails['user']['country_code']): RefCountryCode::getCountryCodeById($patientDetails['country_code']);
                    $whatsappCountryCode         = RefCountryCode::getCountryCodeById($patientDetails['whatsapp_country_code']);
                    if (empty($patientDetails)) {
                        $arr['error']    = 1;
                        $arr['errormsg'] = 'Patient does not exists';
                        return response()->json($arr);
                    }

                    $data['patientDetails']      = $patientDetails;
                    $data['countryCodeDetails']  = $countryCodeDetails;
                    $data['whatsappCountryCode'] = $whatsappCountryCode;
                    break;

                case 'devices':
                    /* Pending Count */
                    $stats = array('-1', '1');
                    $deviceOrdersCount = RpmOrders::getPendingRpmOrdersCount($stats, $clinicId, $userId, $patientDetails['id']);

                    $data['deviceOrdersCount']      = $deviceOrdersCount;
                    break;
                case 'cards-billing':

                    $userCards = PatientCard::getUserCards($userId);
                    if (!empty($userCards)) {
                        foreach ($userCards as $key => $cards) {
                            $userCards[$key]['expiry'] = $cards['exp_month'] . '/' . $cards['exp_year'];
                        }
                    }
                    $clientSecret = '';
                    if (empty($userCards) && !empty($patientDetails)) {
                        $patientDetails['name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                        $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($patientDetails, Session::get('user.email'));
                        if (!empty($clientSecretResponse)) {
                            $clientSecret = $clientSecretResponse['response'];
                            if ($userDetails['stripe_customer_id'] == '') {
                                Payment::UpdateUserStripeCustomerIdInPatients($patientDetails['id'], $clientSecretResponse['customerID']);
                                Payment::UpdateUserStripeCustomerIdInUsers($userDetails['id'], $clientSecretResponse['customerID']);
                            }
                        }
                    }
                    $addresses  = array();

                    $states = RefState::getStateList();
                    $countries = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());
                    $countries = $this->Corefunctions->convertToArray($countries);
                    $countries = $this->Corefunctions->getArrayIndexed1($countries, 'id');

                    $userAddress = $this->Corefunctions->convertToArray(DB::table('user_billing')->select('user_billing_uuid', 'billing_address', 'billing_company_name', 'billing_phone', 'billing_city', 'billing_state_id', 'billing_state_other', 'billing_country_id', 'billing_zip', 'billing_country_code')->where('user_id', $userId)->where('clinic_id', $clinicId)->where('parent_type', 'p')->whereNull('deleted_at')->get());
                    $stateID  = $this->Corefunctions->getIDSfromArray($userAddress, 'billing_state_id');

                    $state          = $this->Corefunctions->convertToArray(DB::table('ref_states')->whereIn('id', $stateID)->get());
                    $state          = $this->Corefunctions->getArrayIndexed1($state, 'id');
                    $addresses  = array();
                    if (!empty($userAddress)) {
                        foreach ($userAddress as $key => $useraddr) {
                            $countryCodedetails = RefCountryCode::getCountryCodeById($useraddr['billing_country_code']);
                            $final['address']               = $useraddr['billing_address'];
                            $final['user_billing_uuid']     = $useraddr['user_billing_uuid'];
                            $final['company_name']          = $useraddr['billing_company_name'];
                            $final['country_code']          = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
                            $final['phone_number']          = $this->Corefunctions->formatPhone($useraddr['billing_phone']);
                            $final['state']                 = !empty($state) ? $state[$useraddr['billing_state_id']]['state_name'] : $useraddr['billing_state_other'];
                            $final['state_name']            = !empty($useraddr['billing_state_other']) ?  $useraddr['billing_state_other'] : '';
                            $final['city']                  = $useraddr['billing_city'];
                            $final['country_id']            = $useraddr['billing_country_id'];
                            $final['postal_code']           = $useraddr['billing_zip'];
                            $addresses[]                    = $final;
                        }
                    }

                    $data['states']         = $states;
                    $data['addresses']      = $addresses;
                    $data['clientSecret']   = $clientSecret;
                    $data['userCards']      = $userCards;
                    $data['countries']      = $countries;
                    $data['patientDetails'] = $patientDetails;
                    $data['type']           = 'mycards';

                    break;

                case 'myclinics':
                    /*  get all clinics relapted with patient  */
                    $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
                    $page =  (isset($data['page']) && ($data['page'] != '')) ? $data['page'] : 10;
                    $patientClinics = $this->Corefunctions->convertToArray(Patient::select('clinic_id')->where('user_id', $userId)->whereNull('deleted_at')->get());
                    $clinicIds = $this->Corefunctions->getIDSfromArray($patientClinics, 'clinic_id');

                    $clinicsListDetails = Clinic::whereIn('id', $clinicIds)->whereNull('deleted_at')->paginate($limit, ['*'], 'page', $page);
                    $clinics = $this->Corefunctions->convertToArray($clinicsListDetails);
                    // Fetch all relevant clinicians
                    $allClinicians = $this->Corefunctions->convertToArray(ClinicUser::whereIn('clinic_id', $clinicIds)
                        ->whereIn('user_type_id', [1, 2]) //  1 and 2 are clinician types
                        ->whereNull('deleted_at')
                        ->where('status', '1')
                        ->with('user') // Eager load the related user details
                        ->get()
                        ->groupBy('clinic_id')); // Group by clinic_id

                    $clinicsData = [];
                    if (!empty($clinics['data'])) {
                        foreach ($clinics['data'] as $clinic) {
                            // Get clinicians for this clinic from the pre-fetched data
                            $clinicians = $allClinicians[$clinic['id']] ?? collect(); // Use grouped data, default to empty collection if no clinicians

                            $cliniciansData = [];
                            if (!empty($clinicians)) {
                                foreach ($clinicians as $clinician) {

                                    if (!empty($clinician['user'])) {
                                        $userData = $clinician['user'];
                                        $cliniciansData[] = [
                                            'id' => $userData['id'],
                                            'name' => $this->Corefunctions->showClinicanNameUser($clinician, '0'),
                                            'image' => isset($userData['profile_image']) && ($userData['profile_image'] != '')
                                                ? $this->Corefunctions->resizeImageAWS($userData['id'], $userData['profile_image'], $userData['first_name'], 180, 180, '1')
                                                : asset('images/default_img.png'), // Default image if none
                                        ];
                                    }
                                }
                            }

                            $clinicsData[] = [
                                'id' => $clinic['id'],
                                'name' => $clinic['name'],
                                'clinic_uuid' => $clinic['clinic_uuid'],
                                'email' => $clinic['email'],
                                'phone_number' => $clinic['phone_number'],
                                'country_code' => $clinic['country_code'],
                                'logo_path' => ($clinic['logo'] != '') ? $this->Corefunctions->resizeImageAWS($clinic['id'], $clinic['logo'], $clinic['name'], 180, 180, '1') : asset("images/default_clinic.png"),
                                'clinicians' => $cliniciansData,
                            ];
                        }
                    }
                    $countryIDs                 = $this->Corefunctions->getIDSfromArray($clinics['data'], 'country_code');
                    $countryCodeDetails         = RefCountryCode::getCountryCodeByIDS($countryIDs);
                    $data['countryCodeDetails'] = $countryCodeDetails;
                    $data['clinicsList']        = $clinicsData;
                    $data['clinicsListDetails'] = $clinicsListDetails;
                    $data['limit']              = $limit;

                    break;
                case 'receipts':
                    $userID = session()->get('user.userID');
                    $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
                    $clinicId = (isset($data['clinicid']) && ($data['clinicid'] != '')) ? $data['clinicid'] : '';

                    $paymentDetails = Payment::getUserPayments($userID, $limit, $page, $clinicId);
                    $paymentData = $this->Corefunctions->convertToArray($paymentDetails);

                    $patientClinics = $this->Corefunctions->convertToArray(Patient::where('user_id', $userId)->whereNull('deleted_at')->get());
                    $clinicIds = $this->Corefunctions->getIDSfromArray($patientClinics, 'clinic_id');

                    $patientClinics = $this->Corefunctions->convertToArray(Clinic::whereIn('id', $clinicIds)->whereNull('deleted_at')->get());

                    $clinics = \App\Models\Clinic::whereIn('id', $clinicIds)->get()->keyBy('id');

                    foreach ($paymentData['data'] as $key => $payment) {
                        if ($payment['parent_type'] == 'subscription') {
                            $subscription = \App\Models\ClinicSubscription::find($payment['parent_id']);
                            $clinicId = (!empty($subscription)) ? $subscription->clinic_id : '';
                            $paymentData['data'][$key]['clinic_name'] = (isset($clinicId) && $clinicId != '') ? $clinics[$clinicId]->name : '--';
                        } elseif ($payment['parent_type'] == 'appointment') {
                            $appointment = \App\Models\Appointment::find($payment['parent_id']);
                            if ($appointment && $appointment->clinic_id) {
                                $clinicId = $appointment->clinic_id;
                                $paymentData['data'][$key]['clinic_name'] = $clinics[$clinicId]->name;
                            }
                        } elseif ($payment['parent_type'] == 'deviceorder') {
                            $rpmorder = \App\Models\RpmOrders::find($payment['parent_id']);
                            if ($rpmorder && $rpmorder->clinic_id) {
                                $clinicId = $rpmorder->clinic_id;
                                $paymentData['data'][$key]['clinic_name'] = $clinics[$clinicId]->name;
                            }
                        }
                    }

                    $data['paymentDetails'] = $paymentDetails;
                    $data['paymentData'] = $paymentData;
                    $data['clinics'] = $clinics;
                    $data['patientClinics'] = $patientClinics;
                    $data['limit'] = $limit;
                    break;
                case 'subscriptions':
                    $patientSubscriptionDets = array();
                    $userID = Session::get('user.userID');
                    $clinicIDs = Clinic::getPatientTaggedClinicIDs($userID);
                    $clinics = Clinic::getClinics($clinicIDs);
                    if (!empty($clinics)) {
                        foreach ($clinics as $key => $clinic) {
                            $clinics[$key]['clinic_logo'] = isset($clinic['logo']) && ($clinic['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinic['logo']) : asset("images/default_clinic.png");
                            $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionNew($clinic['id'], $patientDetails['id']);
                            $clinics[$key]['subscriptions'] = $patientSubscriptionDets;
                            $clinicSubscriptions = ClinicSubscription::getClinicSubscriptions($clinic['id']);
                            $clinicSubscriptions = $this->Corefunctions->getArrayIndexed1($clinicSubscriptions, 'id');
                            $clinics[$key]['clinicsubscriptions'] = $clinicSubscriptions;
                        }
                    }

                    $planIcons = $this->Corefunctions->convertToArray(RefPlanIcons::all());
                    $planIcons = $this->Corefunctions->getArrayIndexed1($planIcons, 'id');

                    $data['clinics'] = $clinics;
                    $data['planIcons'] = $planIcons;
                    break;

                default:
                    break;
            }

            $html = view('frontend.myaccounts.' . $viewType, $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = "Data fetched successfully.";
            return response()->json($arr);
            exit();
        }
    }

    public function fetchPlanDetails(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $userId   = session('user.userID');
            $type = (isset($data['type']) && $data['type'] != '') ? $data['type'] : 'yearly';
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
            $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionNew($data['clinicid'], $patientDetails['id']);

            $currentSubscriptionId = (!empty($patientSubscriptionDets)) ? $patientSubscriptionDets['clinic_subscription_id'] : '0';
            $currentSubscriptionDets = (!empty($patientSubscriptionDets)) ?  $this->Corefunctions->convertToArray(ClinicSubscription::getClinicSubscriptionById($data['clinicid'], $currentSubscriptionId)) : array();
            $renewalSubscriptionDets = (!empty($patientSubscriptionDets)) ?  $this->Corefunctions->convertToArray(ClinicSubscription::getClinicSubscriptionById($data['clinicid'], $patientSubscriptionDets['renewal_plan_id'])) : array();
            $clinicSubscriptions = ClinicSubscription::getPatientClinicSubscriptions($data['clinicid'], $currentSubscriptionId);
            $clinic = $this->Corefunctions->convertToArray(Clinic::clinicByID($data['clinicid']));
            $clinic['clinic_logo'] = isset($clinic['logo']) && ($clinic['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinic['logo']) : asset("images/default_clinic.png");

            $planIcons = $this->Corefunctions->convertToArray(RefPlanIcons::all());
            $planIcons = $this->Corefunctions->getArrayIndexed1($planIcons, 'id');

            $data['patientSubscriptionDets'] = $patientSubscriptionDets;
            $data['clinicSubscriptions'] = $clinicSubscriptions;
            $data['currentSubscriptionDets'] = $currentSubscriptionDets;
            $data['renewalSubscriptionDets'] = $renewalSubscriptionDets;
            $data['clinic'] = $clinic;
            $data['type'] = $type;
            $data['planIcons'] = $planIcons;

            $html = view('frontend.myaccounts.attachchangeplan', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = "Data fetched successfully.";
            return response()->json($arr);
            exit();
        }
    }

    public function fetchPaymentDetails(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $userId = session('user.userID');

            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
            $clinicSubscription = ClinicSubscription::getClinicSubscriptionByUuid($data['subscriptionkey']);
            $monthlychecked = $data['isMonthlyChecked'];
            $clinic = $this->Corefunctions->convertToArray(Clinic::clinicByID($data['clinicid']));
            $clinic['clinic_logo'] = isset($clinic['logo']) && ($clinic['logo'] != '') ? $this->Corefunctions->getAWSFilePath($clinic['logo']) : asset("images/default_clinic.png");

            $userCards = PatientCard::getUserCards($userId);
            if (!empty($userCards)) {
                foreach ($userCards as $key => $cards) {
                    $userCards[$key]['expiry'] = $cards['exp_month'] . '/' . $cards['exp_year'];
                }
            }

            $countries = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());
            $countries = $this->Corefunctions->convertToArray($countries);

            $addressdata = $this->Corefunctions->convertToArray(DB::table('user_billing')->select('user_billing_uuid', 'billing_address', 'billing_company_name', 'billing_phone', 'billing_city', 'billing_state_id', 'billing_state_other', 'billing_country_id', 'billing_zip', 'billing_country_code')->where('user_id', $userId)->where('parent_type', 'p')->whereNull('deleted_at')->first());

            $states = $this->Corefunctions->convertToArray(DB::table('ref_states')->get());
            $type = 'payment';
            $clientSecret = '';
            $pageType = (isset($data['type'])) ? $data['type'] : '';

            $prorationDetails = $this->Corefunctions->getSubscriptionDetails($data['clinicid'], $patientDetails, $clinicSubscription, $monthlychecked);
            if ($prorationDetails['upgrade'] == 0 && $prorationDetails['downgrade'] == 1) {
                $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionNew($data['clinicid'], $patientDetails['id']);
                if ($clinicSubscription['id'] == $patientSubscriptionDets['renewal_plan_id']) {
                    return $this->Corefunctions->returnError("Sorry, you have already downgraded to this plan.");
                }
                PatientSubscription::updateRenewalPlanID($patientSubscriptionDets['patient_subscription_uuid'], $clinicSubscription, $monthlychecked);

                $arr['isdowngraded'] = 1;
                $arr['message'] = 'You have successfully downgraded to the new plan. Your new plan will become active on ' . date('m/d/Y', strtotime($patientSubscriptionDets['renewal_date'])) . '.';
                return response()->json($arr);
                exit();
            }
            
            $planIcons = $this->Corefunctions->convertToArray(RefPlanIcons::all());
            $planIcons = $this->Corefunctions->getArrayIndexed1($planIcons,'id');

            $data['clinicSubscription'] = $clinicSubscription;
            $data['clinic'] = $clinic;
            $data['userCards'] = $userCards;
            $data['countries'] = $countries;
            $data['states'] = $states;
            $data['addressdata'] = $addressdata;
            $data['proratedAmount'] = $prorationDetails['amount'];
            $data['is_prorated'] = $prorationDetails['is_prorated'];
            $data['type'] = $type;
            $data['clientSecret'] = $clientSecret;
            $data['patientDetails'] = $patientDetails;
            $data['monthlychecked'] = $monthlychecked;
            $data['pageType'] = $pageType;
            $data['planIcons'] = $planIcons;

            $html = view('frontend.myaccounts.appendpayment', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = "Data fetched successfully.";
            return response()->json($arr);
            exit();
        }
    }

    public function saveAddress(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            parse_str($data['formdata'], $input);

            $input['phone_number'] = str_replace(["(", ")", " ", "-"], "", $input['phone_number']);
            $countryCodedetails  = RefCountryCode::getCountryCodeByShortCode($input['countrycode']);

            $clinicId = Session::get('user.clinicID');
            $userId = Session::get('user.userID');

            $billingCheck = DB::table('user_billing')->where('user_id', $userId)->where('clinic_id', $clinicId)->whereNull('deleted_at')->first();
            $billingCheck = $this->Corefunctions->convertToArray($billingCheck);


            if (empty($billingCheck)) {
                $userBillingKey = $this->Corefunctions->generateUniqueKey('10', 'user_billing', 'user_billing_uuid');
                UserBilling::saveBillingData($input, $userId, $userBillingKey, $clinicId, $countryCodedetails, 'p');
            } else {
                UserBilling::updateBillingData($billingCheck['id'], $input, $countryCodedetails);
            }
            $arr['success'] = 1;
            $arr['message'] = "Address added successfully.";
            return response()->json($arr);
            exit();
        }
    }



    public function getClinic(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            if (!$data['clinicCode']) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Clinic code missing';
                return response()->json($arr);
                exit();
            }
            $userId   = session('user.userID');
            $clinicCodeCheck = $this->Corefunctions->convertToArray(ClinicUser::select('clinic_id')->where('clinic_code', $data['clinicCode'])->first());
            if (empty($clinicCodeCheck)) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Invalid clinic code';
                return response()->json($arr);
                exit();
            }
            /*  check the clinic exists or not */
            $clinic = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicCodeCheck['clinic_id']));
            if (empty($clinicCodeCheck)) {
                $arr['error']    = 0;
                $arr['errormsg'] = 'Invalid clinic';
                return response()->json($arr);
                exit();
            }
            /** check the patient already exists in the clinic */
            $patientClinic = $this->Corefunctions->convertToArray(Patient::getPatientDets($userId, $clinicCodeCheck['clinic_id']));
            if (!empty($patientClinic)) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'The patient is already attached to this clinic.';
                return response()->json($arr);
                exit();
            }

            $logopath =  ($clinic['logo'] != '') ? $this->Corefunctions->resizeImageAWS($clinic['id'], $clinic['logo'], $clinic['name'], 180, 180, '1') : asset("images/default_clinic.png");
            $phonenumber =  $this->Corefunctions->formatPhone($clinic['phone_number']);
            $clinicCountryCode  = RefCountryCode::getCountryCodeById($clinic['country_code']);

            $address = $this->Corefunctions->formatAddress($clinic);


            $data['logopath'] = $logopath;
            $data['clinic'] = $clinic;
            $data['phonenumber'] = $phonenumber;
            $data['clinicCountryCode'] = $clinicCountryCode;
            $html = view('frontend.myaccounts.clinicdetails', $data);
            $arr['html'] = $html->__toString();

            $arr['address'] = $address;
            $arr['logo'] = $logopath;
            $arr['ClinicName'] = $clinic['name'];
            $arr['success'] = 1;
            $arr['message'] = "Clinic attached  added successfully.";
            return response()->json($arr);
            exit();
        }
    }

    public function addToClinic(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            if (!$data['clinicCode']) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Clinic code missing';
                return response()->json($arr);
                exit();
            }
            $userId   = session('user.userID');
            $clinicCodeCheck = $this->Corefunctions->convertToArray(ClinicUser::select('clinic_id')->where('clinic_code', $data['clinicCode'])->first());
            if (empty($clinicCodeCheck)) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Invalid clinic code';
                return response()->json($arr);
                exit();
            }

            /* get patient details */

            $patientDetails     = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
            $countryCode['id']  =  $patientDetails['country_code'];
            /** replacing the input names */
            $patientDetails['user_phone'] = $patientDetails['phone_number'];
            $patientDetails['whatsapp_num'] = $patientDetails['whatsapp_number'];
            $patientDetails['whatsappcountryCode'] = $patientDetails['whatsapp_country_code'];
            $patientDetails['first_name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
            $patientID = Patient::insertPatient($patientDetails, $countryCode, $patientDetails['user_id'], session()->get('user.userID'), '1', $clinicCodeCheck['clinic_id']);


            $arr['success'] = 1;
            $arr['message'] = "Clinic attached  added successfully.";
            return response()->json($arr);
            exit();
        }
    }

    public function confirmSubscription()
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            $userId = session('user.userID');

            $clinic = Clinic::clinicByID($input['clinicid']);
            if (empty($clinic)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Invalid Clinic',
                ]);
            }

            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));

            $subscriptionDets = ClinicSubscription::getClinicSubscriptionByKey($input['clinicid'], $input['key']);
            if (empty($subscriptionDets)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Invalid Subscription',
                ]);
            }
            if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Stripe not connected for this clinic.',
                ]);
            }

            $subscriptionDets = ClinicSubscription::getClinicSubscriptionByKey($input['clinicid'], $input['key']);

            $countryCodedetails  = array();
            $billingInfo = UserBilling::getUserBillingByUserId($userId);
            if (empty($billingInfo)) {
                $userBillingKey = $this->Corefunctions->generateUniqueKey('10', 'user_billing', 'user_billing_uuid');
                UserBilling::saveBillingData($input, $userId, $userBillingKey, $input['clinicid'], $countryCodedetails, 'p');
            } else {
                UserBilling::updateBillingData($billingInfo['id'], $input, $countryCodedetails);
            }
            $billingInfo = UserBilling::getUserBillingByUserId($userId);

            $amount = (float) str_replace(',', '', $input['amount']);
            $notes = "Payment for patient subscription : " . $subscriptionDets['plan_name'];

            $id = Invoice::insertInvoice($input['clinicid'], $amount, '0', $billingInfo, $notes, 2);
            InvoiceItem::insertInvoiceItem($id, $input['clinicid'], $amount, '0', $notes);

            $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();

            // Payment to clinic //
            $paymentIds = array();
            $paymentIds['id'] = 0;
            if ($amount > 0) {
                $result = $this->Corefunctions->subscriptionPayment($stripeConnection->stripe_user_id, $patientDetails, $input, $amount, $input['clinicid'], $subscriptionDets['id']);
                if (isset($result['status']) && $result['status'] == '0') {
                    $arr['error'] = 1;
                    $arr['errormsg'] = $result['message'];
                    return response()->json($arr);
                    exit();
                }
                $paymentIds = $result['paymentIds'];
                $cardDetails = $result['cardDetails'];
            }
            $monthlychecked = $input['monthlychecked'];

            $historyId = PatientSubscription::insertPatientSubscriptionHistory($input['clinicid'], $patientDetails['id'], $subscriptionDets, $paymentIds['id'], $monthlychecked);

            $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionNew($input['clinicid'], $patientDetails['id']);
            if (empty($patientSubscriptionDets)) {
                PatientSubscription::insertPatientSubscription($input['clinicid'], $patientDetails['id'], $subscriptionDets, $historyId, $monthlychecked);
            } else {
                PatientSubscription::updatePatientSubscription($patientSubscriptionDets['patient_subscription_uuid'], $input['clinicid'], $subscriptionDets, $historyId, $monthlychecked);
            }

            $arr['message'] = 'Subscription plan purchased successfully.';
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function confirmSubscriptionNew()
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            $userId = session('user.userID');

            $clinic = Clinic::clinicByID($input['clinicid']);
            if (empty($clinic)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Invalid Clinic',
                ]);
            }

            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));

            $subscriptionDets = ClinicSubscription::getClinicSubscriptionByKey($input['clinicid'], $input['key']);
            if (empty($subscriptionDets)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Invalid Subscription',
                ]);
            }
            if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Stripe not connected for this clinic.',
                ]);
            }

            $countryCodedetails  = array();
            $billingInfo = UserBilling::getUserBillingByUserId($userId);
            if (empty($billingInfo)) {
                $userBillingKey = $this->Corefunctions->generateUniqueKey('10', 'user_billing', 'user_billing_uuid');
                UserBilling::saveBillingData($input, $userId, $userBillingKey, $input['clinicid'], $countryCodedetails, 'p');
            } else {
                UserBilling::updateBillingData($billingInfo['id'], $input, $countryCodedetails);
            }
            $billingInfo = UserBilling::getUserBillingByUserId($userId);

            $prorationDetails = $this->Corefunctions->getSubscriptionDetails($input['clinicid'], $patientDetails, $subscriptionDets, $input['monthlychecked']);
            if (($prorationDetails['downgrade'] == 0 && $prorationDetails['upgrade'] == 1) || ($prorationDetails['upgrade'] == 0 && $prorationDetails['downgrade'] == 0)) {
                $amount = (float) str_replace(',', '', $prorationDetails['amount']);
                $notes = "Payment for patient subscription : " . $subscriptionDets['plan_name'];

                $id = Invoice::insertInvoice($input['clinicid'], $amount, '0', $billingInfo, $notes, 2);
                InvoiceItem::insertInvoiceItem($id, $input['clinicid'], $amount, '0', $notes);

                $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();

                // Payment to clinic //
                $paymentIds = array();
                $paymentIds['id'] = 0;
                $userBalance = DB::table('users')->where('id', $patientDetails['user_id'])->value('account_balance');
                $usedBalance = 0;
                $amountToCharge = $amount;
                $balance = 0;

                if ($userBalance !== null && $userBalance > 0) {
                    if ($userBalance >= $amount) {
                        // Fully covered by balance
                        $usedBalance = $amount;
                        $amountToCharge = 0;
                        $balance = $userBalance - $usedBalance;

                        $paymentIntentId = null;
                        $transactionId = Payment::insertTransactions($paymentIntentId, $patientDetails['user_id'], $clinicId);

                        $stripe_fee = 0.00;
                        $platform_fee = 0.00;

                        $stateID = (isset($patientDetails['user']['state_id']) && $patientDetails['user']['state_id'] != '') ? $patientDetails['user']['state_id'] : $patientDetails['state_id'];
                        $state = $this->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id', $stateID)->whereNull('deleted_at')->first());
                        $patientDetails['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] : ((isset($patientDetails['user']['state']) && $patientDetails['user']['state'] != '') ? $patientDetails['user']['state'] : $patientDetails['state_id']);
                        $clinic = Clinic::select('stripe_connection_id', 'name', 'phone_number', 'address as billing_address', 'state as billing_state', 'city as billing_city', 'zip_code as billing_zip', 'country_id as billing_country_id', 'state_id', 'country_code', 'logo')->whereNull('deleted_at')->where('id', $clinicId)->first();

                        // inputParams
                        $inputParams = array();
                        /** Input datea for store to payment table */
                        $inputParams['billing_name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                        $inputParams['billing_email'] = $patientDetails['email'];
                        $inputParams['country_id'] = $patientDetails['country_code'];
                        $inputParams['phone_number'] = $patientDetails['phone_number'];
                        $inputParams['address'] = (isset($patientDetails['user']['address']) && $patientDetails['user']['address'] != '') ? $patientDetails['user']['address'] : $patientDetails['address'];
                        $inputParams['city'] =  (isset($patientDetails['user']['city']) && $patientDetails['user']['city'] != '') ? $patientDetails['user']['city'] : $patientDetails['city'];
                        $inputParams['zip'] =  (isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code'] != '') ? $patientDetails['user']['zip_code'] : $patientDetails['zip'];
                        $inputParams['state'] = $patientDetails['state'];
                        $inputParams['name_on_card'] = null;
                        $inputParams['card_number'] = null;
                        $inputParams['card_type'] = null;
                        $inputParams['expiry_year'] = null;
                        $inputParams['expiry_month'] = null;
                        $inputParams['stripe_fee'] = $stripe_fee;
                        $inputParams['platform_fee'] = $platform_fee;

                        $paymentDetails['stripe_customerid'] = $patientDetails['stripe_customer_id'];
                        $paymentDetails['stripe_paymentid'] = null;
                        $paymentDetails['card_id'] = null;
                        $paymentDetails['amount'] = $amount;
                        $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

                        $inputParams['appntID'] = $subscriptionDets['id'];

                        $paymentKey = $this->generateUniqueKey('10', 'payments', 'payment_uuid');

                        $paymentIds = Payment::savePaymentData($inputParams, $paymentKey, $patientDetails['user_id'], $paymentDetails, '1', $clinic, 'subscription', $usedBalance);

                        $paymentIds = $result['paymentIds'];
                        $cardDetails = $result['cardDetails'];
                    } else {
                        // Partially covered by balance
                        $usedBalance = $userBalance;
                        $amountToCharge = $amount - $usedBalance;

                        $balance = 0;

                        // Charge remaining via card
                        $result = $this->Corefunctions->subscriptionPayment($stripeConnection->stripe_user_id, $patientDetails, $input, $amountToCharge, $input['clinicid'], $subscriptionDets['id'], $usedBalance);

                        if (isset($result['status']) && $result['status'] == '0') {
                            $arr['error'] = 1;
                            $arr['errormsg'] = $result['message'];
                            return response()->json($arr);
                        }

                        $paymentIds = $result['paymentIds'];
                        $cardDetails = $result['cardDetails'];
                    }
                } else {
                    $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionNew($input['clinicid'], $patientDetails['id']);
                    if (!empty($patientSubscriptionDets)) {
                        $currentAmount = (float) $patientSubscriptionDets['amount']; // Current plan amount
                        $newAmount = (float) $amount; // New plan amount (upgraded/downgraded)

                        if ($currentAmount > $newAmount) {
                            $balance = round($currentAmount - $newAmount, 2);
                        }
                    }
                    // No balance at all, full charge
                    $result = $this->Corefunctions->subscriptionPayment($stripeConnection->stripe_user_id, $patientDetails, $input, $amount, $input['clinicid'], $subscriptionDets['id']);
                    if (isset($result['status']) && $result['status'] == '0') {
                        $arr['error'] = 1;
                        $arr['errormsg'] = $result['message'];
                        return response()->json($arr);
                    }

                    $paymentIds = $result['paymentIds'];
                    $cardDetails = $result['cardDetails'];
                }

                $monthlychecked = $input['monthlychecked'];

                $historyId = PatientSubscription::insertPatientSubscriptionHistory($input['clinicid'], $patientDetails['id'], $subscriptionDets, $paymentIds['id'], $monthlychecked);

                $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionNew($input['clinicid'], $patientDetails['id']);
                if (empty($patientSubscriptionDets)) {
                    PatientSubscription::insertPatientSubscription($input['clinicid'], $patientDetails['id'], $subscriptionDets, $historyId, $monthlychecked);

                    $arr['message'] = 'Subscription plan purchased successfully.';
                } else {
                    PatientSubscription::updatePatientSubscription($patientSubscriptionDets['patient_subscription_uuid'], $input['clinicid'], $subscriptionDets, $historyId, $monthlychecked);

                    $arr['message'] = 'Subscription plan upgraded successfully.';
                }

                User::updateAccountBalance($patientDetails['user_id'], $balance);
            }

            $arr['success'] = 1;
            return response()->json($arr);
        }
    }

    public function subscriptionDetails(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $patientSubscriptions = $this->Corefunctions->convertToArray(DB::table('patient_subscriptions')->join('clinic_subscriptions', 'clinic_subscriptions.id', '=', 'patient_subscriptions.clinic_subscription_id')->where('patient_subscriptions.status', '1')->where('patient_subscriptions.patient_subscription_uuid', $data['key'])->first());
            $clinic = $this->Corefunctions->convertToArray(Clinic::clinicByID($data['clinicId']));

            $data['patientSubscriptions'] = $patientSubscriptions;
            $data['clinic'] = $clinic;

            $html = view('frontend.myaccounts.plandetails', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = "Data fetched successfully.";
            return response()->json($arr);
            exit();
        }
    }
    public function fetchDevices(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }

            $clinicId = session('user.clinicID');
            $userId   = session('user.userID');

            $patientDetails                     = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
            if (empty($patientDetails)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Patient does not exists';
                return response()->json($arr);
            }
            $type = $data['type'];
            $stats = array('4');
            if ($type == 'pending') {
                $stats = array('-1', '1', '2');
            } elseif ($type == 'rejected') {
                $stats = array('3');
            }

            /* Fetch Orders */
            $rpmdOrders          = RpmOrders::getRpmOrders($stats, $clinicId, $userId, $patientDetails['id']);
            $rpmdOrders          = $this->Corefunctions->getArrayIndexed1($rpmdOrders, 'id');
            $orderIDS            = $this->Corefunctions->getIDSfromArray($rpmdOrders, 'id');
            $clinicIDS           = $this->Corefunctions->getIDSfromArray($rpmdOrders, 'clinic_id');

            /* Fetch Order Devices */
            $rpmdOrderDevices    = RpmOrders::getOrderDevicesByOrderIDS($stats, $orderIDS);
            $devicesIDS          = $this->Corefunctions->getIDSfromArray($rpmdOrderDevices, 'rpm_device_id');
            $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
            $devices             = $this->Corefunctions->getArrayIndexed1($devices, 'id');

            /* Fetch Created By */
            $clinicUserIDS       = $this->Corefunctions->getIDSfromArray($rpmdOrders, 'clinic_user_id');
            $clinicUsers         = ClinicUser::clinicUserByIDS($clinicUserIDS);
            $clinicUsers         = $this->Corefunctions->getArrayIndexed1($clinicUsers, 'id');

            /* Clinics */
            $clinics             = Clinic::getClinics($clinicIDS);
            $clinics             = $this->Corefunctions->getArrayIndexed1($clinics, 'id');


            $userIDS             = $this->Corefunctions->getIDSfromArray($clinicUsers, 'user_id');
            $userDets            = User::getUsersByIDs($userIDS);
            $userDets            = $this->Corefunctions->getArrayIndexed1($userDets, 'id');



            if (!empty($rpmdOrders)) {
                foreach ($rpmdOrders as $rok => $rov) {
                    $createdBy = $userImage = '';

                    if (!empty($clinicUsers) && isset($clinicUsers[$rov['clinic_user_id']])) {
                        $clinicUserDets = $clinicUsers[$rov['clinic_user_id']];
                        if (isset($userDets[$clinicUserDets['user_id']])) {

                            $createdBy  = $userDets[$clinicUserDets['user_id']]['first_name'] . ' ' . $userDets[$clinicUserDets['user_id']]['last_name'];
                            $userImage = ($userDets[$clinicUserDets['user_id']]['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDets[$clinicUserDets['user_id']]['profile_image']) : asset('images/default_img.png');
                        }
                    }
                    $userTimeZone = session()->get('user.timezone');
                    $dateTimeString = $rov['created_at'];

                    $formattedDate = $this->Corefunctions->timezoneChange($rov['created_at'], "M d, Y");
                    $formattedTime = $this->Corefunctions->timezoneChange($rov['created_at'], "h:i A");

                    $rpmdOrders[$rok]['user_image'] = $userImage;
                    $rpmdOrders[$rok]['created_user'] = $createdBy;
                    $rpmdOrders[$rok]['clinic_name']  = (!empty($clinics) && isset($clinics[$rov['clinic_id']])) ? $clinics[$rov['clinic_id']]['name'] : '';
                    $rpmdOrders[$rok]['ordered_date']  = ($rov['created_at'] != '') ? $formattedDate : '';
                    $rpmdOrders[$rok]['ordered_time']  = ($rov['created_at'] != '') ? $formattedTime : '';
                }
            }

            if (!empty($rpmdOrderDevices)) {
                foreach ($rpmdOrderDevices as $rpk => $rpo) {
                    $rpo['device_name']     = (!empty($devices) && isset($devices[$rpo['rpm_device_id']])) ? $devices[$rpo['rpm_device_id']]['device'] : '';
                    $rpo['device_category']     = (!empty($devices) && isset($devices[$rpo['rpm_device_id']])) ? $devices[$rpo['rpm_device_id']]['category'] : '';
                    $rpo['device_image']    = (!empty($devices) && isset($devices[$rpo['rpm_device_id']])) ? asset('images/rpmdevices/' . $devices[$rpo['rpm_device_id']]['category'] . '.png') : '';
                    if (isset($rpmdOrders[$rpo['rpm_order_id']])) {
                        $rpmdOrders[$rpo['rpm_order_id']]['devices'][] = $rpo;
                    }
                }
            }



            $data['type']            = $type;
            $data['rpmdOrders']      = $rpmdOrders;



            $html        = view('frontend.myaccounts.deviceslist', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = "Data fetched successfully.";
            return response()->json($arr);
            exit();
        }
    }
    public function deviceStatuschange()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $order  = RpmOrders::rpmOrderByUUID($data['key']);
            if (empty($order)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Order';
                return response()->json($arr);
                exit();
            }
            if ($order['user_id'] != Session::get('user.userID')) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'You dont have access.';
                return response()->json($arr);
                exit();
            }
            if ($data['status'] == 'reject') {
                $orderDevices        = RpmOrders::getOrderDevicesByOrderID($order['id'], '-1');
                $devicesIDS          = $this->Corefunctions->getIDSfromArray($orderDevices, 'rpm_device_id');
                $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
                $devices             = $this->Corefunctions->getArrayIndexed1($devices, 'id');
                RpmOrders::updateOrderStatus($order['id'], '3');
                $this->Corefunctions->rpmDeviceStatusChangeMail($order, $devices, 'reject');
                $arr['message'] = 'Order rejected successfully.';
            } else {
                $orderDevices        = RpmOrders::getOrderDevicesByOrderID($order['id'], '-1');
                $devicesIDS          = $this->Corefunctions->getIDSfromArray($orderDevices, 'rpm_device_id');
                $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
                $devices             = $this->Corefunctions->getArrayIndexed1($devices, 'id');

                $oneTimeTotal = $perMonthTotal = 0;
                if (!empty($devices)) {
                    foreach ($devices as $rpm) {
                        $oneTimeTotal  += $rpm['one_time_charge'];
                        $perMonthTotal += $rpm['per_month_amount'];
                    }
                }
                $totalAmount        = $oneTimeTotal + $perMonthTotal;
                $userID             = Session::get('user.userID');
                $userCards          = PatientCard::getUserCards($userID);
                if (!empty($userCards)) {
                    foreach ($userCards as $key => $cards) {
                        $userCards[$key]['expiry'] = $cards['exp_month'] . '/' . $cards['exp_year'];
                    }
                }
                $addressdata = $this->Corefunctions->convertToArray(DB::table('user_billing')->select('user_billing_uuid', 'billing_address', 'billing_company_name', 'billing_phone', 'billing_city', 'billing_state_id', 'billing_state_other', 'billing_country_id', 'billing_zip', 'billing_country_code')->where('user_id', $userID)->where('parent_type', 'p')->whereNull('deleted_at')->first());

                $states = $this->Corefunctions->convertToArray(DB::table('ref_states')->get());

                $countries = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());
                $countries = $this->Corefunctions->convertToArray($countries);


                $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userID));

                $addressdata = $this->Corefunctions->convertToArray(DB::table('user_billing')->select('user_billing_uuid', 'billing_address', 'billing_company_name', 'billing_phone', 'billing_city', 'billing_state_id', 'billing_state_other', 'billing_country_id', 'billing_zip', 'billing_country_code')->where('user_id', $userID)->where('parent_type', 'p')->whereNull('deleted_at')->first());

                $data['patientDetails']         = $patientDetails;
                $data['addressdata']         = $addressdata;
                $data['order']         = $order;
                $data['countries']     = $countries;
                $data['states']        = $states;
                $data['addressdata']   = $addressdata;
                $data['userCards']     = $userCards;
                $data['totalAmount']   = $totalAmount;
                $data['perMonthTotal'] = $perMonthTotal;
                $data['oneTimeTotal']  = $oneTimeTotal;
                $data['devices']       = $devices;
                $html                  = view('frontend.myaccounts.acceptdeviceorder', $data);
                $arr['view'] = $html->__toString();
            }
            $stats = array('-1', '1');
            $deviceOrdersCount = RpmOrders::getPendingRpmOrdersCount($stats, $order['clinic_id'], $order['user_id'], $order['patient_id']);

            $arr['deviceOrdersCount'] = $deviceOrdersCount;
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    public function trackDeviceorder()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $order  = RpmOrders::rpmOrderByUUID($data['key']);
            if (empty($order)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Order';
                return response()->json($arr);
                exit();
            }

            $statusText = '';
            if ($order['status'] == '1') {
                $statusText = 'Awaiting Fulfillment';
            } else if ($order['status'] == '2') {
                $clinicUsers         = ClinicUser::getClinicUserById($order['clinic_user_id']);
                $clinicUsers         = $this->Corefunctions->convertToArray($clinicUsers);

                if (!empty($clinicUsers)) {
                    $userDets            = User::getUserById($clinicUsers['user_id']);
                    $userDets            = $this->Corefunctions->convertToArray($userDets);
                    if (!empty($userDets)) {
                        $createdBy  = $userDets['first_name'] . ' ' . $userDets['last_name'];
                        $userImage = ($userDets['profile_image'] != '') ? $this->Corefunctions->getAWSFilePath($userDets['profile_image']) : asset('images/default_img.png');
                    }
                }
                $formattedDate = $this->Corefunctions->timezoneChange($order['created_at'], "M d, Y");
                $formattedTime = $this->Corefunctions->timezoneChange($order['created_at'], "h:i A");

                $data['ordered_date']  = ($order['created_at'] != '') ? $formattedDate : '';
                $data['ordered_time']  = ($order['created_at'] != '') ? $formattedTime : '';

                $statusText          = 'Shipped';
                $orderIDS[]           = $order['id'];
                $stats               = array('2');
                $rpmdOrderDevices    = RpmOrders::getOrderDevicesByOrderIDS($stats, $orderIDS);
                $devicesIDS          = $this->Corefunctions->getIDSfromArray($rpmdOrderDevices, 'rpm_device_id');
                $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
                $devices             = $this->Corefunctions->getArrayIndexed1($devices, 'id');
                $devices             = $this->Corefunctions->getIDSfromArray($devices, 'device');
                $data['devices']               = implode('<br>', $devices);
                $data['tracking_number']       = $order['tracking_number'];
                $data['created_by']            = $createdBy;
                $data['created_image']         = $userImage;
                //print_r($data);die;
            }
            $data['statusText']       = $statusText;
            $html                  = view('frontend.myaccounts.trackorder', $data);
            $arr['view'] = $html->__toString();


            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }


    public function cancelSubscription(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $userId   = session('user.userID');

            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
            $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionByKey($data['clinicid'], $data['subscriptionkey']);

            if (empty($patientSubscriptionDets)) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Invalid data.';
                return response()->json($arr);
                exit();
            }
            /* update patient table */
            PatientSubscription::updatetPatientSubscriptionStatus($data['subscriptionkey']);


            $arr['success'] = 1;
            $arr['message'] = "Subscription cancelled  successfully.";
            return response()->json($arr);
            exit();
        }
    }

    public function getOrderDevices()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['orderuuid']) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $order  = RpmOrders::rpmOrderByUUID($data['orderuuid']);
            if (empty($order)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Order';
                return response()->json($arr);
                exit();
            }

            $orderIDS[]          = $order['id'];
            $stats               = array('-1', '1', '2', '3', '4');
            $rpmdOrderDevices    = RpmOrders::getOrderDevicesByOrderIDS($stats, $orderIDS);
            $devicesIDS          = $this->Corefunctions->getIDSfromArray($rpmdOrderDevices, 'rpm_device_id');
            $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);

            $data['devices']     = $devices;
            $html                = view('frontend.myaccounts.remainingdevicelist', $data);
            $arr['view']         = $html->__toString();


            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }


    public function leaveClinic(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            if (!$data['clinicKey']) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Key missing';
                return response()->json($arr);
                exit();
            }
            $userId   = session('user.userID');

            $clinic = $this->Corefunctions->convertToArray(Clinic::clinicByUUID($data['clinicKey']));
            if (empty($clinic)) {
                $arr['error']    = 0;
                $arr['errormsg'] = 'Invalid clinic';
                return response()->json($arr);
                exit();
            }
            /* check the patient have any active appoinmnet in this clinic */
            $userTimeZone = session()->get('user.timezone');
            $appointmentDetails = Appointment::appoinmentByPatientWithClinic($userId, $clinic['id'], $userTimeZone);
          
            if (!empty($appointmentDetails)) {
                $arr['success'] = 0;
                $arr['errormsg'] = 'You have active appointments with this clinic. Please contact your clinic admin.';
                return response()->json($arr);
                exit();
            }
            /** leave from clinic if appoiment exists after confirmation */
            if (empty($appointmentDetails)) {
                /* update patient table */
                /** checl patient exists in other clinics */
                $patientCount = patient::getPatientClinicCount($userId, $clinic['id']);

                if ($patientCount > 1) {
                    patient::updatePatientClinic($userId, $clinic['id']);
                } else {
                    DB::table('patients')->where('user_id', $userId)->where('clinic_id', $clinic['id'])->update(array(
                        'clinic_id' => NULL,
                    ));
                }
            }


            $arr['success'] = 1;
            $arr['message'] = "You have successfully disconnected from the clinic.";
            return response()->json($arr);
            exit();
        }
    }

    public function cancelOrder()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            $order  = RpmOrders::rpmOrderByUUID($data['key']);
            if (empty($order)) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Invalid Order';
                return response()->json($arr);
                exit();
            }
            if ($order['status'] != '1') {
                $arr['error'] = 1;
                $arr['errormsg'] = 'You cannot cancel this order';
                return response()->json($arr);
                exit();
            }

            /* Create Bearer Token */
            $token = $this->Corefunctions->createSmartmeterBearerToken('token');

            /* Create Order */
            $apiKey = env('SMARTMETER_API_KEY');
            $orderData = array();

         
            $url = "orders/".$order['order_code'];
            $apiResponse = $this->Corefunctions->cancelRPMOrder($url, $orderData, $token);
            if (!empty($apiResponse) && isset($apiResponse['status']) && $apiResponse['status']['code'] && $apiResponse['status']['code'] == '200') {
                RpmOrders::updateOrderStatus($order['id'], '5');
                RpmOrders::updateCancelledOn($order['id'], 'p',Session::get('user.userID'));
            }
              $stats = array('-1', '1');
             $deviceOrdersCount = RpmOrders::getPendingRpmOrdersCount($stats, $order['clinic_id'], $order['user_id'], $order['patient_id']);

            $arr['deviceOrdersCount'] = $deviceOrdersCount;

            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
}
