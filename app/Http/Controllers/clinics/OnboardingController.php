<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\ClinicUser;
use App\Models\StripeConnection;
use App\Models\Clinic;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\RefSupportType;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionsHistory;
use App\Models\Subscription;
use App\Models\ClinicCard;
use App\Models\Vacation;
use App\Models\UserBilling;
use App\Models\Support;
use App\Models\RefState;
use App\Models\RefCountryCode;
use App\Models\RefDesignation;
use App\Models\RefSpecialty;
use App\Models\Payment;
use App\Models\RefOnboardingStep;
use App\Models\ClinicOnboardingHistory;
use App\Models\RefConsultationTime;
use App\Models\BusinessHour;
use App\Models\BusinessHoursTime;
use App\Models\ClinicSubscription;
use App\Models\RefPlanIcons;
use DB;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Route;


            
class OnboardingController extends Controller
{
    public function __construct()
    {

        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->stripePayment      = new \App\customclasses\StripePayment;
        
        // Middleware for session check
        $this->middleware(function ($request, $next) {
            $method = Route::current()->getActionMethod();
            // if(!in_array($method,array('settings'))){
                if (Session::has('user') && session()->get('user.userType') == 'patient') {
                    return Redirect::to('/');
                }
            // }
            
            // Check if the session has the 'user' key (adjust as per your session key)
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }

            /* validate onboarding process */
            $onboardClinic = $this->Corefunctions->validateClincOnboarding();
            $method = Route::current()->getActionMethod();
            if(!in_array($method,array('editPlan','onBoardingSteps','validatePlan','validateWorkingHours','userUpdate','userEdit','addPlan'))){
                if(!$onboardClinic){
                    return Redirect::to('/dashboard');
                }
            }
           
            $this->lastStep =  isset($onboardClinic['step']) ? $onboardClinic['step'] : '' ;
          
            return $next($request);
        });
    }

    public function onboardingWelcome(){

        
        $latestStep = $this->lastStep ;
        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::select('onboarding_complete', 'last_onboarding_step')->where('id',session('user.clinicID'))->whereNull('last_onboarding_step')->where('onboarding_complete','0')->whereNull('deleted_at')->first());
      
        if(!empty($clinicDetails) && $clinicDetails['last_onboarding_step'] !='' ){
            return Redirect::to('/onboarding/' . $this->lastStep);
        }
        $clientSecret ='';
        $seo['title'] = "Welcome | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        return view('onboarding.welcome',compact('seo','clientSecret','clinicDetails','latestStep'));
    }


    public function onBoarding($key)
    {   
        
        // $latestStep = 'timing_and_charges'  ;
        if($key !='' && $key != $this->lastStep){
            return Redirect::to('/onboarding/' . $this->lastStep);
        }
        $latestStep = ( $key !='' && $key == $this->lastStep) ? $key : $this->lastStep ; 
        // $latestStep = 'timing_and_charges' ;
        $onboardingSteps = RefOnboardingStep::getOnboardingSteps();
        
        $clinicId = session('user.clinicID');
        $userId   = session('user.userID') ; 
        $clientSecret = '';

        switch ($latestStep) {

            case 'business-details':
                // get clinic details
                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));
                // get clinic details
                $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::getClinicUser($userId,$clinicId));
                 // Fetch country ID from ref_country_codes table
                if ($clinicUserDetails['country_code'] != '') {
                    $countryCodedetails = RefCountryCode::getCountryCodeById($clinicUserDetails['country_code']);
                    $clinicUserDetails['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
                    $clinicUserDetails['short_code'] = !empty($countryCodedetails) ? $countryCodedetails['short_code'] : null;
                }
                $clinicUserDetails['logo_path'] = ($clinicUserDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($clinicUserDetails['logo_path']) : '';
                // Fetch country ID from ref_country_codes table
                $countryDetails = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());
                // Fetch country ID from ref_country_codes table
                $stateDetails = $this->Corefunctions->convertToArray(DB::table('ref_states')->get());
                /* get all designation */
                $designationDetails = RefDesignation::getDesignation();
                /* get all specialities */
                $specialties = RefSpecialty::getSpeciality();

                $timezoneDetails = User::getTimeZone();

                $data['timezoneDetails']    = $timezoneDetails;
                $data['clinicUserDetails']  = $clinicUserDetails;
                $data['clinicDetails']      = $clinicDetails;
                $data['designationDetails'] = $designationDetails;
                $data['stateDetails']       = $stateDetails;
                $data['countryDetails']     = $countryDetails;
                $data['specialties']        = $specialties;

                  /* insert clinic onboarding history for each steps */
                $historyID = ClinicOnboardingHistory::insertOnboardingHistory($clinicId,1);
                  /* update last onbording step to clinic table */
                $clinic = Clinic::updateLastOnboarding($clinicId,1);

                break;

            case 'working-hours':
           
                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));
                /* get  consultation time */
                $consultingTimes = RefConsultationTime::getConsultationTime();

                $businessHours = [
                    'Sunday' => ['day' => 'Sunday','is_open' => 0, 'label' => 'Closed'],
                    'Monday' => ['day' => 'Monday','is_open' => 1, 'label' => 'Open'],
                    'Tuesday' => ['day' => 'Tuesday','is_open' => 1, 'label' => 'Open'],
                    'Wednesday' => ['day' => 'Wednesday','is_open' => 1, 'label' => 'Open'],
                    'Thursday' => ['day' => 'Thursday','is_open' => 1, 'label' => 'Open'],
                    'Friday' => ['day' => 'Friday','is_open' => 1, 'label' => 'Open'],
                    'Saturday' => ['day' => 'Saturday','is_open' => 1, 'label' => 'Open'],
                    
                ];
                $clientSecret = '' ;
                if( empty( $clincCard ) ){
                    if( !empty($clinicDetails) ){
                          $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($clinicDetails,Session::get('user.email')); 
                          if(!empty($clientSecretResponse)){
                              $clientSecret = $clientSecretResponse['response'];
                              if($clinicDetails['stripe_customer_id'] == ''){
                                  Payment::UpdateUserStripeCustomerIdInClinics($clinicDetails['id'],$clientSecretResponse['customerID']);
                              }
                          }
                    }
                }

                $data['clientSecret']  = $clientSecret;
                $data['consultingTimes']  = $consultingTimes;
                $data['businessHours']    = $businessHours;
                $data['clinicDetails']      = $clinicDetails;

                break;

            case 'payment-processing':
        
                $stripredirectURl =  'https://connect.stripe.com/oauth/v2/authorize?response_type=code&client_id=' . env('CLIENT_ID') . '&scope=read_write&state=' .Session::get('user.clinicuser_uuid') . '&redirect_uri=' . url("/connect/stripe");
                $data['stripredirectURl']    = $stripredirectURl;

                break;
            case 'patient-subscriptions':
               
              /* check card added or not */
              $clincCard = $this->Corefunctions->convertToArray(DB::table('clinic_cards')->whereNull('deleted_at')->where('clinic_id',$clinicId)->first());
              $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));
              $clientSecret = '' ;
              if( empty( $clincCard ) ){
              
                if( !empty($clinicDetails) ){
                        $clientSecretResponse = $this->stripePayment->setupPaymentIntentWithCustomer($clinicDetails,Session::get('user.email')); 
                        if(!empty($clientSecretResponse)){
                            $clientSecret = $clientSecretResponse['response'];
                            if($clinicDetails['stripe_customer_id'] == ''){
                                Payment::UpdateUserStripeCustomerIdInClinics($clinicDetails['id'],$clientSecretResponse['customerID']);
                            }
                        }
                    }
                }
              $subscritionList = ClinicSubscription::getClinicSubscriptions($clinicId);
                /** get generic plans */
              $genericPlans =  ClinicSubscription::getAllGenericPlan();
                
                /* Get Icons */
              $planIcons = $this->Corefunctions->convertToArray(RefPlanIcons::all());
              $planIcons = $this->Corefunctions->getArrayIndexed1($planIcons,'id');
               
                
              $data['subscritionList']  = $subscritionList;
              $data['genericPlans']    = $genericPlans;
              $data['clientSecret']  = $clientSecret;
              $data['clincCard']     = $clincCard;
              $data['clinicDetails'] = $clinicDetails;
              $data['planIcons'] = $planIcons;

            break;
            case 'subscription_plan':

                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));

                /*  update the subscritpion details  */
               if(isset($input['subscription_uuid']) && $input['subscription_uuid'] !=''){
                $subscritionID =  ClinicSubscription::updateSubscriptionPlan($clinicId,$input,$clinicDetails);
               }else{
                $subscritionID =  ClinicSubscription::insertPlan($clinicId,$input,$clinicDetails);
               }
             
            
              
            break;

            case 'choose-addons':

                // get clinic details
                $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::getClinicUser($userId,$clinicId));
                 $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));
                $isUsUser = '1';
                if( !empty($clinicUserDetails) && !empty($clinicDetails)){
                    if( $clinicUserDetails['country_code'] != 185 || $clinicDetails['country_code'] != 185 ){
                        $isUsUser = '0';
                    }
                }
             
                /* check the user details needed or not   */
               // $isShow  =$this->Corefunctions->checkuserData($userId);
                $isShow = '1';
                $data['isUsUser'] = $isUsUser ;
                $data['clinicUserDetails'] = $clinicUserDetails ;
                $data['isShow'] = $isShow ;
            break;


            default:
                // Handle unknown section
                break;
        }


        $seo['title'] = "onBoarding | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";

        $data['seo'] =$seo ;
        $data['onboardingSteps'] =$onboardingSteps ;
        $data['latestStep'] =$latestStep ;
        $data['clientSecret'] =$clientSecret ;
        return view('onboarding.'.$latestStep,$data);
    }


     /* store onBoardingSteps */
    public function onBoardingSteps()
    {
        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $step = $data['nextstep'];
            if(isset($data['formdata']) && $data['formdata'] !=''){
                parse_str($data['formdata'], $input);
            }
        
            $clinicId = session('user.clinicID');
            $userId   = session('user.userID') ; 
            $stepID   = isset($data['currentStepId']) ? $data['currentStepId'] : '';
            $message = 'Data fetched successfully';
            
            switch ($step) {

                case 'business-details':
                  
                    break;

                case 'working-hours':

                   
                     $clinic = Clinic::clinicByID($clinicId);
                       
                    /*  update the clinic and clinic user details from Business step  */
                    $this->handleBusinessDetails($input,$clinicId,$data);
                     
                    /* insert clinic onboarding history for each steps from onboarding page*/
                    if(isset($data['formType']) && $data['formType'] =='onboarding'){
                        $historyID = ClinicOnboardingHistory::insertOnboardingHistory($clinicId,2);
                        /* update last onbording step to clinic table */
                        $clinic = Clinic::updateLastOnboarding($clinicId,2);

                        if(!isset($input['is_licensed_practitioner']) || (isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] != 'on')){
                            $step = 'payment-processing' ;
                            $clinic = Clinic::updateLastOnboarding($clinicId,3);
                        }else{
                            Session::put("user.licensed_practitioner",1);
                        }
                    }else{
                        $message ='Clinic details updated successfully';
                       
                        if(isset($input['timezone_id']) && $input['timezone_id'] != $clinic->timezone_id){
                            //$message.= '.Changing the timezone requires manually updating the business hours.';
                            $this->Corefunctions->convertTimeslot($clinic->id,$input['timezone_id']);
                        }
                    }
                   
                    break;

                case 'payment-processing':
            
                    // print'<pre>';print_r($input);exit;
                    /*  update the timing details  */
                    $this->handleTimingAndCharges($input,$clinicId,$data);
                     /* insert clinic onboarding history for each steps */
                    if(isset($data['formType']) && $data['formType'] =='onboarding'){
                        $historyID = ClinicOnboardingHistory::insertOnboardingHistory($clinicId,3);
                        /* update last onbording step to clinic table */
                       $clinic = Clinic::updateLastOnboarding($clinicId,3);
                    }
                 

                    break;
                case 'patient-subscriptions':
                    /** stripe connection  */
                    /* update last onbording step to clinic table */
                    if(isset($data['islater']) && ($data['islater']) == '1'){
                        $clinic = Clinic::updateLastOnboarding($clinicId,4);    
                    }
                  
                break;
                case 'subscription_plan':

                
                   $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));
                   /* use templates from generic plan  */
                     /** get subscription plan count */
                     $planCount = ClinicSubscription::getPlanCount($clinicId);
                    if(isset($data['plan_type']) && $data['plan_type'] == 'generic'){
                        // print_r('test');exit;
                     
                        $genericPlans =  ClinicSubscription::getAllGenericPlan();
                        if(!empty($genericPlans )){
                            foreach($genericPlans as $pln){
                                /* check name exists  */
                                $existuserdata  = $this->Corefunctions->convertToArray(DB::table('clinic_subscriptions')->whereNull('deleted_at')->where('clinic_id',$clinicId)->whereRaw('LOWER(plan_name) = ?', [strtolower($pln['plan_name'])])->limit(1)->first());
                                if(!empty( $existuserdata )){
                                    $arr['error'] = 0;
                                    $arr['message'] = 'The selected plan ' .$pln['plan_name'].' already added.';
                                    return response()->json($arr);
                                }
                                $subscritionID =  ClinicSubscription::insertPlan($clinicId,$pln,$clinicDetails,'1',$planCount);
                            }
                        }
                        
                    }else{
                        /*  update the subscritpion details  */
                        if(isset($input['subscription_uuid']) && $input['subscription_uuid'] !=''){
                            $subscritionID =  ClinicSubscription::updateSubscriptionPlan($clinicId,$input,$clinicDetails);
                        }else{
                          
                            $subscritionID =  ClinicSubscription::insertPlan($clinicId,$input,$clinicDetails,'0',$planCount);
                        }
                    }
                  
                break;

                case 'choose-addons':

                      /* insert clinic onboarding history for each steps */
                      if(isset($data['islater']) && ($data['islater']) != '0'){
                        $historyID = ClinicOnboardingHistory::insertOnboardingHistory($clinicId,5);
                      }
                      /* update last onbording step to clinic table */
                      $clinic = Clinic::updateLastOnboarding($clinicId,5);

                break;
                
                /*last step */
                case 'eprescribe':

                    $clinic = Clinic::completeOnboarding($clinicId);
                    // /* update last onbording step to clinic table */
                    // if(isset($data['islater']) && ($data['islater']) != '1'){
                    // }
                break;

                default:
                    // Handle unknown section
                    break;
            }

            // $html = view('onboarding.' . $step, $data);

            // $arr['view'] = $html->__toString();
        
            $arr['step'] = $step ;
            $arr['success'] = 1;
            $arr['message'] = $message;
            return response()->json($arr);
        }
    }
 

    /* get plans details */
    public function subscriptionPlan()
    {
        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            
            $clinicId = session('user.clinicID');
            $userId   = session('user.userID') ; 
          
            $subscritionList = ClinicSubscription::getClinicSubscriptions($clinicId);
            $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));

            $planIcons = $this->Corefunctions->convertToArray(RefPlanIcons::all());
            $planIcons = $this->Corefunctions->getArrayIndexed1($planIcons,'id');
            // $data['is_list'] = empty($subscritionList) ? 1 : 0 ;
            $data['clinicDetails'] = $clinicDetails;
            $data['subscritionList'] = $subscritionList;
            $data['planIcons'] = $planIcons;
            $html = view('onboarding.subscriptionplans', $data);

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['is_list'] =  empty($subscritionList) ? 1 : 0 ;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    /* get plans details */
    public function editPlan($type)
    {
        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            
            $clinicId = session('user.clinicID');
            if($type=='delete'){
                ClinicSubscription::deleteSubscriptionPlan($clinicId,$data['key']);
            }else{
                $subscritionDetails = ClinicSubscription::getClinicSubscriptionByKey($clinicId,$data['key']);
                $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));

                /* Get Icons */
                $planIcons = RefPlanIcons::all();
                
                $data['clinicDetails']      = $clinicDetails;
                $data['subscritionDetails'] = $subscritionDetails;
                $data['planIcons'] = $planIcons;
                $html = view('onboarding.edit_plan', $data);
    
                $arr['view'] = $html->__toString();
            }
          
           
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

    public function addPlan()
    {
        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            
            $clinicDetails = Clinic::clinicByID(Session::get('user.clinicID'));
            
            $planIcons = RefPlanIcons::all();
            $data['planIcons'] = $planIcons;
            $data['clinicDetails'] = $clinicDetails;
            $html = view('onboarding.add_plan', $data);
    
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    protected  function vacationUpdates($input,$userID,$clinicId){
       
          /** update already exist items */
          $vacationIDs = DB::table('vacations')->where('clinic_id',$clinicId)->where('user_id', $userID)->orderBy('vacation_from', 'asc')->pluck('id')->toArray();

          $formvacationIds = array();
          if (isset($input['exist_vacations']) && is_array($input['exist_vacations'])) {
            
              foreach ($input['exist_vacations'] as $vacation) {
                $formvacationIds[] = $vacation['vacation_id'];
                if ($vacation['vacation_type'] === 'specific') {
                    $from = Carbon::createFromFormat('m/d/Y', $vacation['vacation_date'])->format('Y-m-d');
                    $to = $from;
                } else {
                    $from = Carbon::createFromFormat('m/d/Y', $vacation['vacation_from'])->format('Y-m-d');
                    $to = !empty($vacation['vacation_to'])
                        ? Carbon::createFromFormat('m/d/Y', $vacation['vacation_to'])->format('Y-m-d')
                        : $from;
                }
                 DB::table('vacations')->where('id', $vacation['vacation_id'])->update(array(
                      'vacation_type' => $vacation['vacation_type'],
                      'vacation_from' => $from,
                      'vacation_to' => $to,
                  ));
              }
          }
        $toDeletes = array_diff($vacationIDs, $formvacationIds);
        if(!empty( $toDeletes)){
            foreach ($toDeletes as $toDelete) {
                DB::table('vacations')->where('id', $toDelete)->update(array(
                    'deleted_at' =>  Carbon::now(),
                   
                ));

            } 
        }
        //   print'<pre>';
        //   print_r( $toDeletes );exit;
        if (isset($input['vacations']) && is_array($input['vacations'])) {
            foreach ($input['vacations'] as $vacation) {
                // clinicUser::insetvacations($vacations,session()->get('user.clinicuser_uuid'),$userID);
                if ($vacation['vacation_type'] === 'specific') {
                    $from = Carbon::createFromFormat('m/d/Y', $vacation['vacation_date'])->format('Y-m-d');
                    $to = $from;
                } else {
                    $from = Carbon::createFromFormat('m/d/Y', $vacation['vacation_from'])->format('Y-m-d');
                    $to = !empty($vacation['vacation_to'])
                        ? Carbon::createFromFormat('m/d/Y', $vacation['vacation_to'])->format('Y-m-d')
                        : $from;
                }
                $insertid = DB::table('vacations')->insertGetId([
                    'user_id' => $userID,
                    'clinic_id' => $clinicId,
                    'vacation_type' => $vacation['vacation_type'],
                    'vacation_from' => $from,
                    'vacation_to' => $to,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
       
        return ;
     
    }

    protected  function handleTimingAndCharges($input,$clinicId,$data){
    //    print'<pre>';print_r($input);exit;
        $userID = isset($input['user_id']) && $input['user_id'] !='' ? $input['user_id'] :  session()->get('user.userID') ;
        if(isset($data['actiontype']) && $data['actiontype'] == 'update'){
            /** update vacation details */
            /* update vaccation for manageclinic */
            $this->vacationUpdates($input,$userID,$clinicId);
          
            $getPreviousBusinessIds =  BusinessHour::where('clinic_id', $clinicId)->where('user_id', $input['user_id'])->pluck('id')->toArray();
            DB::table('bussinesshours_times')->whereIn('bussiness_hour_id', $getPreviousBusinessIds)->update(['status' => '0','deleted_at' => Carbon::now()]);
            DB::table('bussiness_hours')->where('clinic_id', $clinicId)->where('user_id', $input['user_id'])->update(['status' => '0','deleted_at' => Carbon::now()]);
          
            
        }
        $clinicDetails = Clinic::clinicByID($clinicId);
        
        foreach ($input['business_hours'] as $day => $data) {
            $inputArray['status'] = isset($data['is_open']) ? $data['is_open'] : '0'; // 'open' or 'closed'
            $inputArray['day'] = $day; 
            $inputArray['clinicId'] = $clinicId; 
            $inputArray['userID'] = isset($input['user_id']) && $input['user_id'] !='' ? $input['user_id'] :  session()->get('user.userID') ;
            $slots = $data['slots'] ?? [];
           
            $businessHourID =  BusinessHour::insertToBusinessHour($inputArray);
           
            $userTimezone =  DB::table('ref_timezones')->where('id', $clinicDetails->timezone_id)->whereNull('deleted_at')->first();
            if(!empty($slots)){
                foreach ($slots as $slot) {
                    if(isset($slot['from']) && isset($slot['to']) && ($slot['from']!='') && ($slot['to']!='')){
                        $etTimezone = new \DateTimeZone($userTimezone->timezone_format); // ET includes DST
                        $utcTimezone = new \DateTimeZone('UTC');

                        $utcToTime = (new \DateTime($slot['to'], $etTimezone))
                            ->setTimezone($utcTimezone)
                            ->format('H:i:s');
                        
                        $utcFromTime = (new \DateTime($slot['from'], $etTimezone))
                            ->setTimezone($utcTimezone)
                            ->format('H:i:s');
                        
                        
                        // Save each slot to DB
                        $inputArray['from'] = isset($slot['from']) ? $slot['from'] : null;
                        $inputArray['to']   = isset($slot['to']) ? $slot['to'] : null;
                        $inputArray['slot']   = isset($slot['slot']) ? $slot['slot'] : null;
                        $inputArray['fromTimeUtc']   =  isset($slot['from']) ? $utcFromTime : null;
                        $inputArray['toTimeUtc']   =  isset($slot['to']) ? $utcToTime : null;
                        
                        BusinessHoursTime::insertToBusinessHoursTimeNew($inputArray,$businessHourID,$clinicDetails);
                        
                    }
                }
            }
           
        }

      
        /** store duration in clinic users */ 
        clinicUser::updateClinicUserDuration($input,session()->get('user.clinicuser_uuid'),$userID);
        return ;

     
    }


    protected  function handleBusinessDetails($input,$clinicId,$data){


        /* update business details datas  for clinic*/
        $input['phone'] = str_replace(["(", ")", " ","-"], "", $input['phone']);
        $countryCode = $this->Corefunctions->convertToArray(Clinic::countryCodeByShortCode($input['clinic_countryCodeShort']));   // Fetch country ID from ref_country_codes table
        
        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::clinicByUUID(session('user.clinicUUID')));
        $crppathLogo = (isset($clinicDetails['logo']) && ($clinicDetails['logo'] != '')) ? $clinicDetails['logo'] : '';

        if (isset($input['isremove']) && $input['isremove'] == 1) {
            $crppathLogo = '';
            Session::put("user.clinicLogo", '');
        }

        Clinic::updateClinic(Session::get('user.clinicUUID'),$input,$crppathLogo,'',$countryCode);
     
        
        if( !empty($clinicDetails) && $clinicDetails['dosepot_id'] !== null  ){
             $response       = $this->Corefunctions->editClinicDoseSpot($clinicDetails);
        }
        Session::put("user.clinicName", $input['name']); // Update session for clinic name
        /* Clinic Image Upload */
        if ($input['tempimage'] != "") {
            $this->Corefunctions->uploadImage($input,'','clinic',$clinicId,Session::get('user.clinicUUID'));
        }
        // firstName
        if(isset($data['formType']) && $data['formType'] !='clinic'){
            /* Save clinic user details */
            $input['phone_number'] = str_replace(["(", ")", " ","-"], "", $input['user_phone']);
            /** check clinic user exists */
            $clinicUserDetails = ClinicUser::userByUUID(Session::get('user.clinicuser_uuid')); 

            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid user');
            }
            $input['email'] = $input['user_email'];
            clinicUser::updateClinicUsers($input,'',$clinicUserDetails) ;
            // Re-fetch the updated user details
            $updatedClinicUserDetails = ClinicUser::userByUUID(Session::get('user.clinicuser_uuid'));

            /** update admin onboarding */
            $clinic = ClinicUser::completeOnboarding(Session::get('user.clinicuser_uuid'), session()->get('user.userID'));
            /* user Image Upload */
            if (isset($input['usertempimage']) && $input['usertempimage'] != "") {
                $input['tempimage'] = $input['usertempimage'] ;
                $this->Corefunctions->uploadImage($input,$clinicUserDetails->user_id,'clinic_users',$clinicUserDetails->id,$clinicUserDetails->clinic_user_uuid);
            }
            $userDetails = User::userByID($clinicUserDetails->user_id,'all');
            if (!empty($userDetails)) {
                /*update to user table also */
                $input['address'] = (isset($input['user_address']) && $input['user_address'] != '')  ? $input['user_address'] : '' ;
                $input['city'] =  (isset($input['user_city']) && $input['user_city'] != '')  ? $input['user_city'] : '' ;
                $input['state'] =  (isset($input['user_state']) && $input['user_state'] != '')  ? $input['user_state'] : '' ;
                $input['zip'] =  (isset($input['user_zip_code']) && $input['user_zip_code'] != '')  ? $input['user_zip_code'] : '' ;
                $input['state_id'] =  (isset($input['user_state_id']) && $input['user_state_id'] != '')  ? $input['user_state_id'] : '' ;

               
                User::updateUserData($input,'',$userDetails);
            }
           
            $name = $this->Corefunctions->showClinicanName($updatedClinicUserDetails,'0');
            Session::put("user.firstName",$name);
           

        }

        /* store clinic apponment types data  */
        if( isset($input['appointment_type'])){
            $clinic = Clinic::updateClinicAppoinmentFee($input,$clinicId);
        }
       
        return ;
    }

  /* To check clinic plam already exists */
  public function validatePlan()
  {
    if (request()->ajax()) {
      $data = request()->all();
        
      if ($data['type']) {
        $existid = (isset($data['id'])) ? $data['id'] : '' ;
        $hasData = '0';
        $clinicId = session('user.clinicID');
        /* User By Email */
        $existuserdata  = $this->Corefunctions->convertToArray(DB::table('clinic_subscriptions')->whereNull('deleted_at')->where('clinic_id',$clinicId)->whereRaw('LOWER(plan_name) = ?', [strtolower($data['plan_name'])])->limit(1)->first());
        if($existid != ''){
          $existuserdata = $this->Corefunctions->convertToArray(DB::table('clinic_subscriptions')->whereNull('deleted_at')->where('clinic_id',$clinicId)->whereRaw('LOWER(plan_name) = ?', [strtolower($data['plan_name'])])->where('id','!=',$data['id'])->limit(1)->first());
        }
        $hasData = ( !empty( $existuserdata ) ) ? '1' : '0';
        if ( $hasData == 1 ) {
          return 'false';
        } else {
          return 'true';
        }
      }
    }
  }


    /** validate timeing associated with any other clinic  */

    public function validateWorkingHours(){
        if (request()->ajax()) {
            $data = request()->all();
            parse_str($data['formdata'], $input);
            
            $userID = isset($input['user_id']) && $input['user_id'] !='' ? $input['user_id'] : session()->get('user.userID');
            $clinicId = session('user.clinicID');
            
            // Get all business hours for this user in other clinics
            $businessHours = $this->Corefunctions->convertToArray(
                DB::table('bussiness_hours')
                    ->where('user_id', $userID)
                    ->where('isopen', '1')
                    ->where('clinic_id', '!=', $clinicId)
                    ->whereNull('deleted_at')
                    ->get()
            );

            $overlappingSlots = [];
            $dayErrors = [];
            
            // Check each day in the input
            foreach ($input['business_hours'] as $day => $dayData) {
                if (!isset($dayData['is_open']) || $dayData['is_open'] != '1') {
                    continue; // Skip if day is not open
                }

                $inputSlots = $dayData['slots'] ?? [];
                $dayErrors[$day] = [];
                
                // Get business hours for this day from other clinics
                $dayBusinessHours = array_filter($businessHours, function($bh) use ($day) {
                    return $bh['day'] === $day;
                });

                foreach ($dayBusinessHours as $bh) {
                    // Get time slots for this business hour
                    $existingSlots = $this->Corefunctions->convertToArray(
                        DB::table('bussinesshours_times')
                            ->where('bussiness_hour_id', $bh['id'])
                            ->whereNull('deleted_at')
                            ->get()
                    );

                    // Check for overlapping slots
                    foreach ($inputSlots as $slotIndex => $inputSlot) {
                        foreach ($existingSlots as $existingSlot) {
                            if ($this->isTimeOverlapping(
                                $inputSlot['from'], 
                                $inputSlot['to'], 
                                $existingSlot['from_time'], 
                                $existingSlot['to_time']
                            )) {
                                $clinicName = DB::table('clinics')
                                    ->where('id', $bh['clinic_id'])
                                    ->value('name');
                                
                                $dayErrors[$day][] = [
                                    'slot_index' => $slotIndex,
                                    'time' => $inputSlot['from'] . ' - ' . $inputSlot['to'],
                                    'clinic' => $clinicName
                                ];
                            }
                        }
                    }
                }
            }

            // Filter out days with no errors
            $dayErrors = array_filter($dayErrors, function($errors) {
                return !empty($errors);
            });

            if (!empty($dayErrors)) {
                return response()->json([
                    'success' => 0,
                    'errors' => $dayErrors
                ]);
            }

            return response()->json([
                'success' => 1,
                'message' => 'No overlapping time slots found'
            ]);
        }
    }

    private function isTimeOverlapping($start1, $end1, $start2, $end2) {
        $start1 = strtotime($start1);
        $end1 = strtotime($end1);
        $start2 = strtotime($start2);
        $end2 = strtotime($end2);

        return ($start1 < $end2 && $end1 > $start2);
    }

    

    public function userEdit(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                return $this->Corefunctions->returnError('Fields missing');
            }
          
            /** get user details */
            $userDetails = ClinicUser::getClinicUserByKey($data['key']) ;
            if (empty($userDetails)) {
                return $this->Corefunctions->returnError('Invalid data');
            }
            if($userDetails['clinic_id'] != session()->get('user.clinicID')){
                return $this->Corefunctions->returnError('Permission denied');
            }
            // Fetch country ID from ref_country_codes table
            if ($userDetails['country_code'] != '') {
                $countryCodedetails = RefCountryCode::getCountryCodeById($userDetails['country_code']);
                $userDetails['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['country_code'] : null;
                $userDetails['short_code'] = !empty($countryCodedetails) ? $countryCodedetails['short_code'] : null;
            }

            $designationDetails = User::getDesignations();
            $specialties = User::getSpecialities();
            /** check another admin exists or nt  */
            $isAdmins = ClinicUser::getClinicAdmin($data['key']);
            $stateDetails = User::getStates();

            
            
            $data['stateDetails'] = $stateDetails;
            $data['specialties'] = $specialties;
            $data['isAdmins'] = $isAdmins;
            $data['designation'] = $designationDetails;
            $data['userDetails'] = $userDetails;
            $html = view('onboarding.user_edit', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }


    public function userUpdate(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
           
      
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            // Check if form data is empty
            if (!($data['key'])) {
                return $this->Corefunctions->returnError('Key missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            $input['phone_number'] = str_replace(["(", ")", " ","-"], "", $input['phone_number']);

            /** check clinic user exists */
            $clinicUserDetails = ClinicUser::userByUUID($data['key']); 

            if (empty($clinicUserDetails)) {
                return $this->Corefunctions->returnError('Invalid user');
            }
          
            $userDetails = User::userByID($clinicUserDetails->user_id,'all');

          
            
            /* update details */
            clinicUser::updateDosepotClinicUsers($input,$clinicUserDetails);
            
            if (!empty($userDetails)) {
                /*update to user table also */
                User::updateDosepotUserData($input,$userDetails);
            }
            
       

            // update session if logged in user
            $clinicUserDetails = ClinicUser::getClinicUserByKey($data['key']);
            if (session()->get('user.clinicuser_uuid') == $clinicUserDetails['clinic_user_uuid']) { 
                $userName = (isset($input['user_type_id']) && $input['user_type_id'] != '3') ? $this->Corefunctions->showClinicanName($clinicUserDetails,1) : $input['username'];

                Session::put("user.firstName", $userName);
                Session::put("user.email", $input['email']);
                Session::put("user.phone", $input['phone_number']);
             
            }

            $isShow  =$this->Corefunctions->checkuserData($clinicUserDetails['user_id']);

            $arr['success'] = 1;
            $arr['isShow'] = $isShow;
            $arr['message'] = 'User details updated successfully';
            return response()->json($arr);
            exit();
        }
    }




}

