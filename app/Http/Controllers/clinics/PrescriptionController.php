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

class PrescriptionController extends Controller
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
    
   
    /*Add Prescription   */
    public function addPrescription(){
        if(request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $type = $data['type'];

            /** get patient Details */
            $userID         = $data['userID'];
            $patientDetails =   $this->Corefunctions->convertToArray(Patient::patientByUserAndClinicID($userID,session()->get('user.clinicID')));
            if (empty($patientDetails)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
           
            if( $type == 'add'){
               
                $clinicUserDetails = $this->Corefunctions->convertToArray(ClinicUser::getClinicUserByUuid(session()->get('user.clinicuser_uuid')));
                if( $patientDetails['dosepsot_patient_id'] == ''){
                    if( !empty($clinicUserDetails) && isset($clinicUserDetails['user']) && $clinicUserDetails['user']['dosespot_clinician_id'] != ''  ){
                    $patientResponse =  $this->Corefunctions->createPatientDoseSpot($clinicUserDetails,$patientDetails);
                    if( !empty($patientResponse) && $patientResponse['success'] == 0 && isset($patientResponse['errors']) ){
                          return $this->Corefunctions->returnError($patientResponse['errors']);
                     }
                    }
                }
                 $patientDetails =   $this->Corefunctions->convertToArray(Patient::patientByUserAndClinicID($userID,session()->get('user.clinicID')));
                $iframURl                = $this->Corefunctions->patientPrescriptionUrl($clinicUserDetails,$patientDetails);
                $arr['iframeurl']              = $iframURl;
            }
            

            
            $arr['success']        = 1;
            $arr['message']        = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
  
    
}
