<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionsHistory;
use App\Models\Subscription;
use App\Models\ClinicCard;
use App\Models\PatientCard;
use App\Models\UserBilling;
use App\Models\Payment;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\RefCountryCode;
use DB;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Route;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->stripePayment      = new \App\customclasses\StripePayment;
    }
    public function getuserbilling(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            $subscription = array();
            $userId = Session::get('user.userID');
            $clinicId = Session::get('user.clinicID');

            $clinicSubscription = Subscription::getSubscriptionByClinicId($clinicId);
            if (!empty($clinicSubscription)) {
                $subscription = SubscriptionPlan::getPlanById($clinicSubscription['subscription_plan_id']);
            }

            $subscriptionsFinalArray = array();
            if (!empty($subscription)) {
                $subscriptionsFinalArray['subscription_name'] = $subscription['subscription_name'];
                $subscriptionsFinalArray['duration']          = $subscription['subscription_type'];
            }

            $userCardsDetails = ClinicCard::getUserCards($clinicId);
            $userCards = array();
            if (!empty($userCardsDetails)) {
                foreach ($userCardsDetails as $key => $cards) {
                    $final['card_type']         = $cards['card_type'];
                    $final['card_number']       = $cards['card_num'];
                    $final['expiry']            = $cards['exp_month'] . '/' . $cards['exp_year'];
                    $final['name_on_card']      = $cards['name_on_card'];
                    $final['clinic_card_uuid']    = $cards['clinic_card_uuid'];
                    $final['is_default']        = $cards['is_default'];
                    $userCards[]                = $final;
                }
            }

            $userBilling = UserBilling::getUserBilling($clinicId);
            $billingInfo = array();
            if (!empty($userBilling)) {
                foreach ($userBilling as $ubk => $ubv) {
                    $final['address']               = $ubv['billing_address'];
                    $final['user_billing_uuid']     = $ubv['user_billing_uuid'];
                    $final['company_name']          = $ubv['billing_first_name'] . ' ' . $ubv['billing_last_name'];
                    $final['phone_number']          = $ubv['billing_phone'];
                    $final['state']                 = $ubv['billing_state'];
                    $final['city']                  = $ubv['billing_city'];
                    $final['country_id']            = $ubv['billing_country_id'];
                    $final['postal_code']           = $ubv['billing_zip'];
                    $billingInfo[]                  = $final;
                }
            }

            $html           = view('subscriptions.billing', compact('billingInfo', 'userCards'));

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function addCard(Request $request)
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

            $userId = Session::get('user.userID');

            $userDetails = $this->Corefunctions->convertToArray(User::userByID($userId));

            if (isset($data['type']) && $data['type'] == 'patient') {
                $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUser($userId));
                $user_info      = array(
                    "Name"      => (!empty($userDetails)) ? $userDetails['first_name'] . ' ' . $userDetails['first_name'] : '',
                    "Address"   => (!empty($userDetails) && $userDetails['address'] != '') ? $userDetails['address'] : '',
                    "Zip Code"  => (!empty($userDetails) && $userDetails['zip_code'] != '') ? $userDetails['zip_code'] : '',
                );
                $intentResponse = $this->stripePayment->retrieveSetupIntent($input['setupintentid']);
                if (!empty($intentResponse) && isset($intentResponse['status']) && $intentResponse['status'] == '1') {
                    $intentResponse = json_decode(json_encode($intentResponse['response']), True);
                    if ($userDetails['stripe_customer_id'] == '') {
                        $customerResponse = $this->stripePayment->updateCustomer($intentResponse['customer'], $userDetails['email'], $user_info, $input['stripeToken']);
                        if (!empty($customerResponse) && isset($customerResponse['status']) && $customerResponse['status'] == '1') {
                            $customerResponse = json_decode(json_encode($customerResponse['response']), True);
                            $customerStripeId = $customerResponse['id'];
                            Payment::updateUserStripeCustomerIdInPatients($patientDetails['id'], $customerStripeId);
                        } else {
                            $arr['error']    = 1;
                            $arr['errormsg'] = $customerResponse['response'];
                            return response()->json($arr);
                            exit();
                        }
                    }
                } else {
                    $arr['error']    = 1;
                    $arr['errormsg'] = $intentResponse['response'];
                    return response()->json($arr);
                    exit();
                }
            } else {
                $clinicId = Session::get('user.clinicID');
                $userBilling = UserBilling::getUserBillingByUserId($userId);
                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByID($clinicId));

                $user_info      = array(
                    "Name"      => (!empty($userBilling)) ? $userBilling['billing_company_name'] . ' ' . $userBilling['billing_company_name'] : $clinicDetails['name'],
                    "Address"   => (!empty($userBilling) && $userBilling['billing_address'] != '') ? $userBilling['billing_address'] : $clinicDetails['address'],
                    "Zip Code"  => (!empty($userBilling) && $userBilling['billing_zip'] != '') ? $userBilling['billing_zip'] : $clinicDetails['zip_code'],
                );

                $intentResponse = $this->stripePayment->retrieveSetupIntent($input['setupintentid']);
                if (!empty($intentResponse) && isset($intentResponse['status']) && $intentResponse['status'] == '1') {
                    $intentResponse = json_decode(json_encode($intentResponse['response']), True);
                    if ($clinicDetails['stripe_customer_id'] == '') {
                        $customerResponse = $this->stripePayment->updateCustomer($intentResponse['customer'], $userDetails['email'], $user_info, $input['stripeToken']);
                        if (!empty($customerResponse) && isset($customerResponse['status']) && $customerResponse['status'] == '1') {
                            $customerResponse = json_decode(json_encode($customerResponse['response']), True);
                            $customerStripeId = $customerResponse['id'];
                            Payment::updateUserStripeCustomerIdInClinics($clinicId, $customerStripeId);
                        } else {
                            $arr['error']    = 1;
                            $arr['errormsg'] = $customerResponse['response'];
                            return response()->json($arr);
                            exit();
                        }
                    }
                } else {
                    $arr['error']    = 1;
                    $arr['errormsg'] = $intentResponse['response'];
                    return response()->json($arr);
                    exit();
                }
            }
            $paymentMethodResponse = $this->stripePayment->retrievePaymentMethodNew($input['stripeToken']);
            if (!empty($paymentMethodResponse) && isset($paymentMethodResponse['status']) && $paymentMethodResponse['status'] == '1') {
                $paymentMethodResponse = json_decode(json_encode($paymentMethodResponse['response']), True);
                $input['card_number'] = $paymentMethodResponse['card']['last4'];
            } else {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Invalid Request';
                return response()->json($arr);
                exit();
            }
            if (isset($data['type']) && $data['type'] == 'patient') {
                $checkCardExists = PatientCard::checkCardExists($userId, $input);
            } else {
                $checkCardExists = ClinicCard::checkCardExists($clinicId, $input);
            }
            if (!empty($checkCardExists)) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Sorry! This card is already added';
                return response()->json($arr);
                exit();
            }

            if (isset($data['type']) && $data['type'] == 'patient') {
                $checkIsdefault = DB::table('patient_cards')->where('user_id', $userId)->whereNull('deleted_at')->get();
                $checkIsdefault = $this->Corefunctions->convertToArray($checkIsdefault);
            } else {
                $checkIsdefault = DB::table('clinic_cards')->where('clinic_id', $clinicId)->whereNull('deleted_at')->get();
                $checkIsdefault = $this->Corefunctions->convertToArray($checkIsdefault);
            }

            $is_default = empty($checkIsdefault) ? '1' : 0;

            $toInsertCardArray['stripe_cardid'] = $paymentMethodResponse['id']; // card id from stripe
            $toInsertCardArray['exp_month']     = $paymentMethodResponse['card']['exp_month']; //exp_month from Stripe
            $toInsertCardArray['exp_year']      = $paymentMethodResponse['card']['exp_year']; //exp_year from Stripe
            $toInsertCardArray['cardtype']      = $paymentMethodResponse['card']['brand']; //Card Type from Stripe
            $toInsertCardArray['nameoncard']    = $input['name_on_card']; //Name on card from input
            $toInsertCardArray['card_number']   = $input['card_number'] = $paymentMethodResponse['card']['last4']; //Cvv in card from input
            $toInsertCardArray['stripe_setup_intentid'] = $intentResponse['id'];

            /*** Insert Card details To Table ****/
            if (isset($data['type']) && $data['type'] == 'patient') {
                $usercardid = PatientCard::addUserCards($toInsertCardArray, $userDetails['id'], $is_default);
            } else {
                $usercardid = ClinicCard::addUserCards($toInsertCardArray, $userDetails['id'], $is_default, $clinicId);
            }

            $successMsg = 'Card added successfully.';
            $showProcessPopUP = 0;

            if (!empty($clinicDetails) && $clinicDetails['account_locked']  == '1' && count($checkIsdefault) == '1') {
                $userBilling = $this->Corefunctions->convertToArray(DB::table('user_billing')->where('clinic_id', $clinicId)->whereNull('deleted_at')->limit(1)->first());
                $successMsg = 'Your payment process has been completed.';
                if (!empty($userBilling)) {
                    $clinicSubscriptionDetails = $this->Corefunctions->convertToArray(DB::table('subscriptions')->where('clinic_id', $clinicId)->whereNull('deleted_at')->limit(1)->first());

                    $billingInfo['company_name'] = (isset($userBilling['billing_first_name'])) ? $userBilling['billing_first_name'] : NULL;
                    $billingInfo['country_id'] = (isset($userBilling['billing_country_id']) && $userBilling['billing_country_id'] != '') ? $userBilling['billing_country_id'] : NULL;
                    $billingInfo['phone_number'] = $userBilling['billing_phone'];
                    $billingInfo['address'] = $userBilling['billing_address'];
                    $billingInfo['city'] = (isset($userBilling['billing_city']) && $userBilling['billing_city'] != '') ? $userBilling['billing_city'] : NULL;
                    $billingInfo['zip'] = (isset($userBilling['billing_zip']) && $userBilling['billing_zip'] != '') ? $userBilling['billing_zip'] : NULL;
                    $billingInfo['state'] = isset($userBilling['billing_state']) && ($userBilling['billing_state'] != '') ? $userBilling['billing_state'] : NULL;

                    // $invoiceID = $this->Corefunctions->generateNewInvoice( $clinicSubscriptionDetails['id'], $clinicSubscriptionDetails['subscription_plan_id'], $userId, $clinicId , $billingInfo,' ' );
                    // $this->Corefunctions->invoicePayment( $invoiceID );
                    $showProcessPopUP = 1;
                }
            }

            $arr['success']  = 1;
            $arr['message'] = $successMsg;
            $arr['exp_month'] = $paymentMethodResponse['card']['exp_month'];
            $arr['card_number'] = $paymentMethodResponse['card']['last4'];
            $arr['card_type'] = $paymentMethodResponse['card']['brand'];
            $arr['exp_year'] = $paymentMethodResponse['card']['exp_year'];
            $arr['key'] = $usercardid;
            return response()->json($arr);
            exit();
        }
    }
    public function markAsDefaultCard(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (isset($data['type']) && $data['type'] == 'patient') {
                $userId = Session::get('user.userID');
                PatientCard::removeDefaultCard($userId);
                PatientCard::markAsDefault($data['key'], $userId);
            } else {
                $clinicId = Session::get('user.clinicID');
                ClinicCard::removeDefaultCard($clinicId);
                ClinicCard::markAsDefault($data['key'], $clinicId);
            }

            $arr['success'] = 1;
            $arr['message'] = "Card marked as default successfully.";
            return response()->json($arr);
            exit();
        }
    }
    public function removeCard(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (isset($data['type']) && $data['type'] == 'patient') {
                $cardDetails = PatientCard::getUserCardByKey($data['key']);
            } else {
                $cardDetails = ClinicCard::getUserCardByKey($data['key']);
            }

            if (empty($cardDetails)) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Invalid Key.';
                return response()->json($arr);
                exit();
            }
            if ($cardDetails['is_default'] == '1') {
                $arr['error']    = 1;
                $arr['errormsg'] = 'You are not able to remove the default card .';
                return response()->json($arr);
                exit();
            }

            /** Soft delete the data */
            if (!empty($cardDetails)) {
                if (isset($data['type']) && $data['type'] == 'patient') {
                    PatientCard::removeUserCard($data['key']);
                } else {
                    ClinicCard::removeUserCard($data['key']);
                }
            }
            $arr['success'] = 1;
            $arr['message'] = "Card removed successfully.";
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

            $billingCheck = UserBilling::getBillingInfo($clinicId);

            if (empty($billingCheck)) {
                $userBillingKey = $this->Corefunctions->generateUniqueKey('10', 'user_billing', 'user_billing_uuid');
                UserBilling::saveBillingData($input, $userId, $userBillingKey, $clinicId, $countryCodedetails);
            } else {
                UserBilling::updateBillingData($billingCheck['id'], $input, $countryCodedetails);
            }
            $arr['success'] = 1;
            $arr['message'] = "Address added successfully.";
            return response()->json($arr);
            exit();
        }
    }
    public function addAddress(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            $country = DB::table('ref_country_codes')->select('id', 'country_name')->whereNull('deleted_at')->orderBy('id', 'asc')->get();
            $country = $this->Corefunctions->convertToArray($country);

            if (isset($data['type']) && isset($data['key'])) {
                $addressData = DB::table('user_billing')->select('user_billing_uuid', 'billing_company_name', 'billing_address', 'billing_city', 'billing_zip', 'billing_country_id', 'billing_state_id', 'billing_state_other', 'billing_phone', 'billing_country_code')->where('user_billing_uuid', $data['key'])->whereNull('deleted_at')->first();
                $addressData   =  $this->Corefunctions->convertToArray($addressData);
            }

            $singleline = (isset($data['singleline']) && $data['singleline'] != '') ? '1' : '0';

            $formatAddress =   $this->Corefunctions->formatBillingAddress($addressData, $singleline);
            $states = DB::table('ref_states')->get();
            $states = $this->Corefunctions->convertToArray($states);
            $countryCodeDetailsUsa = DB::table('ref_country_codes')->where('ref_country_codes.id', 236)->get();
            $countryCodeDetailsUsa = $this->Corefunctions->convertToArray($countryCodeDetailsUsa);

            $countryCodeDetailsAll = DB::table('ref_country_codes')->where('ref_country_codes.id', '!=', 236)->whereNull('deleted_at')->orderBy('ref_country_codes.country_name', 'asc')->get();
            $countryCodeDetailsAll = $this->Corefunctions->convertToArray($countryCodeDetailsAll);
            $countryCodeDetails = array_merge($countryCodeDetailsUsa, $countryCodeDetailsAll);

            $countries = $countryCodeDetails;

            $addressdata = isset($addressData) ? $addressData : array();

            $countryCodedetails = RefCountryCode::getCountryCodeById($addressdata['billing_country_code']);
            $addressdata['billing_country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;

            $html = view('clinics.edit_address', compact('states', 'countries', 'formatAddress', 'addressdata', 'countryCodedetails'));

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function updateAddress(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            // dd($data);
            if (!$data) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            parse_str($data['formdata'], $input);
            $userAddress = DB::table('user_billing')->where('user_billing_uuid', $data['key'])->whereNull('deleted_at')->first();
            $userAddress = $this->Corefunctions->convertToArray($userAddress);

            if (empty($userAddress)) {
                $arr['error']    = 1;
                $arr['errormsg'] = 'Invalid address details.';
                return response()->json($arr);
                exit();
            }

            $input['phone_number'] = (isset($input['phone_number']) && $input['phone_number'] != '') ? str_replace(["(", ")", " ", "-"], "", $input['phone_number']) : '';
            $countryCodedetails  = (isset($input['phone_number']) && $input['phone_number'] != '') ? RefCountryCode::getCountryCodeByShortCode($input['countrycode']) : array();

            UserBilling::updateBillingData($userAddress['id'], $input, $countryCodedetails);

            $stateName =  $input['state'];
            if (isset($input['country_id']) && $input['country_id'] == '236' &&  isset($input['state_id']) && $input['state_id'] != '') {
                $usStates = $this->Corefunctions->convertToArray(User::stateByID($input['state_id']));
                if (!empty($usStates)) {
                    $stateName = $usStates['state_prefix'];
                }
            }

            $clinicDetails = $this->Corefunctions->convertToArray(DB::table('clinics')->whereNull('deleted_at')->where('id', Session::get('user.clinicID'))->first());
            if ($clinicDetails['stripe_customer_id'] != '') {
                $address = [
                    'line1'         => $input['address'],
                    'city'          => $input['city'],
                    'state'         => $stateName,
                    'postal_code'   => $input['zip'],
                    'line2'         => $input['address'],
                    'country'       => 'US',
                ];
                $customerDetails = $this->stripePayment->updateStripeCustomerAddress($clinicDetails['stripe_customer_id'], $address);
            }

            $arr['success'] = 1;
            $arr['message'] = "Address updated successfully.";
            return response()->json($arr);
            exit();
        }
    }
}
