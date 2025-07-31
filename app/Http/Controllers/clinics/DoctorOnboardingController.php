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
use DB;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Route;


            
class DoctorOnboardingController extends Controller
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
            $onboardClinic = $this->Corefunctions->validateClincUserOnboarding();
            /* validate onboarding process */
           
            $method = Route::current()->getActionMethod();
            if(!in_array($method,array('editPlan','onBoardingSteps','validateplan','validateWorkingHours','doctorOnboarding','doctoronBoardingSteps','doctoronBoardingStore'))){
                if(!$onboardClinic){
                    return Redirect::to('/dashboard');
                }
            }
           
            $this->lastStep =  isset($onboardClinic['step']) ? $onboardClinic['step'] : '' ;
      
            return $next($request);
        });
    }


    protected  function handleTimingAndCharges($input,$clinicId,$data){
       
        $userID = isset($input['user_id']) && $input['user_id'] !='' ? $input['user_id'] :  session()->get('user.userID') ;
        if(isset($data['actiontype']) && $data['actiontype'] == 'update'){
         
            $getPreviousBusinessIds =  BusinessHour::where('clinic_id', $clinicId)->where('user_id', $input['user_id'])->pluck('id')->toArray();
           
            DB::table('bussinesshours_times')->whereIn('bussiness_hour_id', $getPreviousBusinessIds)->update(['status' => '0','deleted_at' => Carbon::now()]);
            DB::table('bussiness_hours')->where('clinic_id', $clinicId)->where('user_id', $input['user_id'])->update(['status' => '0','deleted_at' => Carbon::now()]);
        }
        foreach ($input['business_hours'] as $day => $data) {
            $inputArray['status'] = isset($data['is_open']) ? $data['is_open'] : '0'; // 'open' or 'closed'
            $inputArray['day'] = $day; 
            $inputArray['clinicId'] = $clinicId; 
            $inputArray['userID'] = isset($input['user_id']) && $input['user_id'] !='' ? $input['user_id'] :  session()->get('user.userID') ;
            $slots = $data['slots'] ?? [];
            // print'<pre>';print_r($input);exit;
            $businessHourID =  BusinessHour::insertToBusinessHour($inputArray);
           
            if(!empty($slots)){
                foreach ($slots as $slot) {
                    if(isset($slot['from']) && isset($slot['to'])){
                        // Save each slot to DB
                        $inputArray['from'] = isset($slot['from']) ? $slot['from'] : null;
                        $inputArray['to']   = isset($slot['to']) ? $slot['to'] : null;
                        $inputArray['slot']   = isset($slot['slot']) ? $slot['slot'] : null;
                        
                        BusinessHoursTime::insertToBusinessHoursTime($inputArray,$businessHourID);
                        
                    }
                  
                }
            }
           
        }

      
        /** store duration in clinic users */ 
        clinicUser::updateClinicUserDuration($input,session()->get('user.clinicuser_uuid'),$userID);
        return ;

     
    }


    private function isTimeOverlapping($start1, $end1, $start2, $end2) {
        $start1 = strtotime($start1);
        $end1 = strtotime($end1);
        $start2 = strtotime($start2);
        $end2 = strtotime($end2);

        return ($start1 < $end2 && $end1 > $start2);
    }


    public function doctorOnboarding(){
       
        $latestStep = $this->lastStep ;
        $latestStep  = $latestStep == 'business-details' ? 'contact-details' : $latestStep ;
        $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::select('onboarding_complete', 'last_onboarding_step')->where('clinic_user_uuid',session('user.clinicuser_uuid'))->whereNull('last_onboarding_step')->where('onboarding_complete','0')->whereNull('deleted_at')->first());
        if(!empty($clinicUserDetails) && $clinicUserDetails['last_onboarding_step'] !='' ){
            return Redirect::to('doctor/onboarding/' . $latestStep);
        }
        $clinicDetails = $this->Corefunctions->convertToArray(Clinic::where('id',session('user.clinicID'))->whereNull('deleted_at')->first());
      
        $isOnbrdType = 'doctor' ;
        $clientSecret ='';
        $seo['title'] = "Welcome | " . env('APP_NAME');
        $seo['description'] = "Create your account today at BlackBag and enjoy with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.";
        $seo['keywords'] = "Sign up ,Join, Patient Registration, Clinics Registration,Black Bag,Effortless Appointment Scheduling, Trusted Healthcare Experts, Book Medical Appointments Online, Online Doctor Consultation, Virtual Care Solutions, Telehealth Services, Quick Medical Booking, Easy to Create Appointments, Secure Health Data Management, Safe Medical Information, Confidential Healthcare Data, Health Consultation Online, Online Healthcare Support, Patient Friendly Healthcare Platform, Doctor Appointment Reminders, Trusted Online Healthcare, Access Healthcare Anytime, Experienced Doctors Online, virtual care,medical specialties, appointment scheduling, and data security.";
        
        return view('onboarding.welcome',compact('seo','clientSecret','latestStep','isOnbrdType','clinicDetails'));
    }

    public function doctoronBoardingSteps($key)
    {   
        // print'<pre>';print_r(session::all());exit;
        $onboardClinic = $this->Corefunctions->validateClincUserOnboarding();
       
        // if(empty( $onboardClinic)){
        //     return Redirect::to('dashboard');
        // }
        $lastStep =  isset($onboardClinic['step']) ? $onboardClinic['step'] : '' ;
        $latestStep  =( $lastStep == 'business-details' || $lastStep == '' ) ? 'contact-details' : $lastStep ;
        
        if($key !='' && $key !=  $latestStep){
            return Redirect::to('doctor/onboarding/' . $latestStep);
        }
        $latestStep = ( $key !='' && $key ==  $latestStep) ? $key :  $latestStep ; 
        // $latestStep = 'timing_and_charges' ;
        $onboardingSteps = RefOnboardingStep::getOnboardingStepsUser();
      
        $clinicId = session('user.clinicID');
        $clinicuserkey = session('user.clinicuser_uuid');
        $userId   = session('user.userID') ; 
        $clientSecret = '';

        switch ($latestStep) {

            case 'contact-details':
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
                // Fetch country ID from ref_country_codes table
                $countryDetails = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());
                // Fetch country ID from ref_country_codes table
                $stateDetails = $this->Corefunctions->convertToArray(DB::table('ref_states')->get());
                /* get all designation */
                $designationDetails = RefDesignation::getDesignation();
                /* get all specialities */
                $specialties = RefSpecialty::getSpeciality();

                $data['clinicUserDetails']  = $clinicUserDetails;
                $data['clinicDetails']      = $clinicDetails;
                $data['designationDetails'] = $designationDetails;
                $data['stateDetails']       = $stateDetails;
                $data['countryDetails']     = $countryDetails;
                $data['specialties']        = $specialties;

                  /* insert clinic onboarding history for each steps */
                $historyID = ClinicOnboardingHistory::insertOnboardingHistory($clinicId,1,$userId);
                  /* update last onbording step to clinic user table */
                $clinic = ClinicUser::updateLastOnboarding($clinicuserkey,$userId,1);

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
        return view('onboarding.doctor.'.$latestStep,$data);
    }


       /* store onBoardingSteps */
       public function doctoronBoardingStore()
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
               $complete = 0 ;
               $clinicId = session('user.clinicID');
               $userId   = session('user.userID') ; 
               $stepID   = isset($data['currentStepId']) ? $data['currentStepId'] : '';
               $clinicuserkey = session('user.clinicuser_uuid');
               switch ($step) {
   
                
   
                   case 'working-hours':
   
                       /** check clinic user exists */
                        $clinicUserDetails = ClinicUser::userByUUID(Session::get('user.clinicuser_uuid')); 

                        if (empty($clinicUserDetails)) {
                            return $this->Corefunctions->returnError('Invalid user');
                        }
                       /*  update the clinic and clinic user details from Business step  */
                       clinicUser::updateClinicUsersOnboading($input,'',$clinicUserDetails) ;
                     
                       $historyID = ClinicOnboardingHistory::insertOnboardingHistory($clinicId,2);
                       /* update last onbording step to clinic table */
                       $clinic = ClinicUser::updateLastOnboarding($clinicuserkey,$userId,2);


                          
                        if($clinicUserDetails->is_licensed_practitioner == '0' && (!isset($input['is_licensed_practitioner']) || (isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] != 'on'))){
                      
                            $clinic = ClinicUser::completeOnboarding($clinicuserkey,$userId);
                            $complete = 1 ;
                            Session::put("user.licensed_practitioner",0);
                        }else{
                            Session::put("user.licensed_practitioner",1);
                        }
                       $updatedClinicUserDetails = ClinicUser::userByUUID(Session::get('user.clinicuser_uuid'));

                        $name = $this->Corefunctions->showClinicanName($updatedClinicUserDetails,'0');
                        Session::put("user.firstName",$name);
                      
                       break;
   
                   case 'payment-processing':
               
                       // print'<pre>';print_r($input);exit;
                       /*  update the timing details  */
                       $this->handleTimingAndCharges($input,$clinicId,$data);
                     
                       $clinic = ClinicUser::completeOnboarding($clinicuserkey,$userId);
                       break;
         
                   default:
                       // Handle unknown section
                       break;
               }
               $arr['complete'] = $complete ;
               $arr['step'] = $step ;
               $arr['success'] = 1;
               $arr['message'] = 'Data fetched successfully';
               return response()->json($arr);
           }
       }
    

}

