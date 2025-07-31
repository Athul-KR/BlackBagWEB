<?php

namespace App\Http\Controllers\frontend;


use App\Models\ClinicUser;
use App\Models\User;
use App\Models\CholestrolTracker;
use App\Models\GlucoseTracker;
use App\Models\WeightTracker;
use App\Models\HeightTracker;
use App\Models\RefTemperature;
use App\Models\VideoCall;
use App\Models\AppointmentType;
use App\Models\PatientImagingTest;
use App\Models\PatientLabTest;
use App\Models\MedicalNote;
use Illuminate\Support\Str;
use Redirect;
use Session;
use App\Models\Otp;
use App\customclasses\Corefunctions;
use App\Models\Appointment;
use App\Models\Inquiry;
use App\Models\Patient;
use App\Models\PatientNoteHistory;
use App\Models\BpTracker;
use App\Models\PatientCondition;
use App\Models\Immunization;
use App\Models\Allergy;
use App\Models\OxygenSaturation;
use App\Models\Medication;
use App\Models\BodyTemperature;
use App\Models\RpmOrders;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Validator;
use File;

class InTakeFormController extends Controller
{

    public function __construct()
    {

        $this->Corefunctions = new \App\customclasses\Corefunctions;
        if (Session::has('user') && session()->get('user.userType') != 'patient') {
            //return Redirect::to('/dashboard');

        }
    }
    /** get intakeform  */
    public function inTakeForm()
    {
        if (!Session::has('user')) {
            return Redirect::to('/');
        }
        if (Session::has('user') && session()->get('user.userType') != 'patient') {
            return Redirect::to('/dashboard');
        }
        $userID           =  Session::get('user.userID');
        $userDetails = $this->Corefunctions->convertToArray(DB::table('users')->select('is_taken_intakeform')->where('id', $userID)->whereNull('deleted_at')->first());
        if ($userDetails['is_taken_intakeform'] == '1') {
            return Redirect::to('/');
        }
        $seo['keywords']    = "Intakeform,Healthmetrics,Medication Details,Medical History,personalized care.";
        $seo['description'] = "Let’s Begin Your Health Journey .Share your key health metrics for better personalized care.This form is essential for gathering important information about your medical history, current health concerns, and personal details.";
        $seo['title'] = 'Intakeform | ' . env('APP_NAME');

        return view('frontend.intake.intakeform', compact('seo'));
    }


    /** store intakeform  */
    public function storeIntake()
    {

        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');
            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                foreach ($input as $section => $data) {
                    if (is_array($data) && array_filter($data)) {
                        $data['user_id'] = $patientID;
                        $data['clinic_id'] = $clinicID;
                        $intakeData = $this->Corefunctions->intakeFormInsertion($section, $data);
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }

    /** store inmedicationform  */
    public function storeMedication()
    {

        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            if (!empty($input)) {
                if (isset($input['key']) && $input['key'] != '') {
                    $intakeData = DB::table('patient_intakeform')->where('patient_intakeform_uuid', $input['key'])->update(array(
                        'intakeform_data' => serialize($input),
                        'user_id' => session('user.userID'),
                        'updated_at' => Carbon::now(),
                    ));
                    PatientCondition::removePatientCondition(session('user.userID'));

                    Allergy::removeAllergy(session('user.userID'));
                } else {
                    $key = $this->Corefunctions->generateUniqueKey('8', 'patient_intakeform', 'patient_intakeform_uuid');
                    $intakeData = DB::table('patient_intakeform')->insertGetId(array(
                        'patient_intakeform_uuid' => $key,
                        'intakeform_data' => serialize($input),
                        'user_id' => session('user.userID'),
                        'created_at' => Carbon::now(),
                    ));
                }
                if (isset($input['has_medication']) && $input['has_medication'] == 'yes') {
                    if (isset($input['bp_medication']) && $input['bp_medication'] == 'yes') {
                        PatientCondition::addPatientCondition('19', '24', $input['sourcetype'], session('user.userID'), session('user.userID'));
                    }
                    if (isset($input['diabetes_medication']) && $input['diabetes_medication'] == 'yes') {
                        PatientCondition::addPatientCondition('19', '362', $input['sourcetype'], session('user.userID'), session('user.userID'));
                    }
                    if (isset($input['cholesterol_medication']) && $input['cholesterol_medication'] == 'yes') {
                        PatientCondition::addPatientCondition('19', '25', $input['sourcetype'], session('user.userID'), session('user.userID'));
                    }
                    if (isset($input['other_medications']) && $input['other_medications'] == 'yes') {
                        $medication['medicine_name'] = $input['other_medication_data'] ?? '';
                        Medication::where('user_id', session('user.userID'))->delete();
                        Medication::addMedication($medication, null, session('user.userID'), null, $input['sourcetype'], session('user.userID'));
                    }
                }

                if (isset($input['has_allergy']) && $input['has_allergy'] == 'yes') {
                    if (isset($input['is_allergic_to_food']) && $input['is_allergic_to_food'] == 'yes') {
                        if (!empty($input['foodallergy'])) {
                            foreach ($input['foodallergy'] as $foodallergy) {
                                if (array_filter($foodallergy)) {
                                    Allergy::addAllergy($foodallergy['title'], $foodallergy['reaction'], $input['sourcetype'], session('user.userID'), session('user.userID'));
                                }
                            }
                        }
                    }
                    if (isset($input['is_allergic_to_drug']) && $input['is_allergic_to_drug'] == 'yes') {
                        if (!empty($input['drugallergy'])) {
                            foreach ($input['drugallergy'] as $drugallergy) {
                                if (array_filter($drugallergy)) {
                                    Allergy::addAllergy($drugallergy['title'], $drugallergy['reaction'], $input['sourcetype'], session('user.userID'), session('user.userID'));
                                }
                            }
                        }
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }

    /** store inmedicationhistoryform  */
    public function storeMedicationHistory()
    {

        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                if (!empty($input['relations'])) {
                    foreach ($input['relations'] as $relation) {
                        if (array_filter($relation)) {
                            $relationID = (isset($relation['relation']) && $relation['relation'] != '') ? $relation['relation'] : 0;
                            $conditionID = (isset($relation['condition_id']) && $relation['condition_id'] != '') ? $relation['condition_id'] : 0;
                            PatientCondition::addPatientCondition($relationID, $conditionID, $input['sourcetype'], $patientID, session('user.userID'), $clinicID);
                        }
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }

    /** store inmedicationhistoryform  */
    public function storeMedicationHistoryIntake()
    {

        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                if (!empty($input['relations'])) {
                    foreach ($input['relations'] as $relation) {
                        if (array_filter($relation)) {
                            if (!empty($relation['condition_id'])) {
                                foreach ($relation['condition_id'] as $condition_id) {
                                    $relationID = (isset($relation['relation']) && $relation['relation'] != '') ? $relation['relation'] : 0;
                                    $conditionID = (isset($condition_id) && $condition_id != '') ? $condition_id : 0;
                                    PatientCondition::addPatientCondition($relationID, $conditionID, $input['sourcetype'], $patientID, session('user.userID'), $clinicID);
                                }
                            }
                        }
                    }
                }
            }

            DB::table('users')->where('id', session('user.userID'))->update(array(
                'is_taken_intakeform' => '1',
            ));

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }

    /** store inmedicationhistoryform  */
    public function storeFamilyHistory()
    {

        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                $relationID = (isset($input['relation']) && $input['relation'] != '') ? $input['relation'] : 0;
                if (!empty($input['condition_id'])) {
                    foreach ($input['condition_id'] as $condition_id) {
                        $conditionID = (isset($condition_id) && $condition_id != '') ? $condition_id : 0;
                        PatientCondition::addPatientCondition($relationID, $conditionID, $input['sourcetype'], $patientID, session('user.userID'), $clinicID);
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }

    /** update familyhistoryform  */
    public function storeMedicalCondition()
    {

        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                $relationID = (isset($input['relation']) && $input['relation'] != '') ? $input['relation'] : 0;
                $conditionID = (isset($input['condition_id']) && $input['condition_id'] != '') ? $input['condition_id'] : 0;
                PatientCondition::addPatientCondition($relationID, $conditionID, $input['sourcetype'], $patientID, session('user.userID'), $clinicID);
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data updated successfully';
            return response()->json($arr);
        }
    }

    /** update familyhistoryform  */
    public function updateMedicationHistory()
    {

        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);
            if (isset($data['formtype']) && $data['formtype'] == 'medical-conditions') {
                if (!empty($input)) {

                    $relationID = (isset($input['relation']) && $input['relation'] != '') ? $input['relation'] : 0;
                    $conditionID = (isset($input['condition_id']) && $input['condition_id'] != '') ? $input['condition_id'] : 0;
                    PatientCondition::updatePatientCondition($data['key'], $relationID, $conditionID, session('user.userID'));
                }
            } else {
                $patientConditionDets = PatientCondition::getPatientConditionByKey($data['key']);

                // Parse form data from serialized input
                // parse_str($data['formdata'], $input);

                if (!empty($input)) {
                    $relationID = (isset($input['relation']) && $input['relation'] != '') ? $input['relation'] : 0;
                    DB::table('patient_conditions')->where('relation_id', $patientConditionDets['relation_id'])->where('user_id', $patientID)->where('source_type_id', $input['sourcetype'])->update(array(
                        'deleted_at' => Carbon::now(),
                    ));
                    if (!empty($input['condition_id'])) {
                        foreach ($input['condition_id'] as $condition_id) {
                            $conditionID = (isset($condition_id) && $condition_id != '') ? $condition_id : 0;
                            PatientCondition::addPatientCondition($relationID, $conditionID, $input['sourcetype'], $patientID, session('user.userID'), $clinicID);
                        }
                    }
                }
            }




            $arr['success'] = 1;
            $arr['message'] = 'Data updated successfully';
            return response()->json($arr);
        }
    }

    /** update familyhistoryform  */
    public function updateFamilyHistory()
    {

        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');
            $patientConditionDets = PatientCondition::getPatientConditionByKey($data['key']);

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                $relationID = (isset($input['relation']) && $input['relation'] != '') ? $input['relation'] : 0;
                DB::table('patient_conditions')->where('relation_id', $patientConditionDets['relation_id'])->where('user_id', $patientID)->where('source_type_id', $input['sourcetype'])->update(array(
                    'deleted_at' => Carbon::now(),
                ));
                if (!empty($input['condition_id'])) {
                    foreach ($input['condition_id'] as $condition_id) {
                        $conditionID = (isset($condition_id) && $condition_id != '') ? $condition_id : 0;
                        PatientCondition::addPatientCondition($relationID, $conditionID, $input['sourcetype'], $patientID, session('user.userID'), $clinicID);
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data updated successfully';
            return response()->json($arr);
        }
    }

    /** get the intake forms   */
    public function getForms()
    {
        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if (!isset($data['formtype'])) {
                return $this->Corefunctions->returnError('Form missing');
            }
            $formType = $data['formtype'];
            $userId = session('user.userID');

            $intakedata = DB::table('patient_intakeform')->where('user_id', $userId)->first();
            $data['relations'] = $this->Corefunctions->convertToArray(DB::table('ref_relations')->where('internal_field', '0')->get());
            $data['immunizationTypes'] = $this->Corefunctions->convertToArray(DB::table('ref_immunization_types')->get());
            $data['bpDetails'] = BpTracker::getBpTrackerBySourceType($userId, '1');
            $data['glucoseDetails'] = GlucoseTracker::getGlucoseTrackerBySourceType($userId, '1');
            $data['cholesterolDetails'] = CholestrolTracker::getCholesterolTrackerBySourceType($userId, '1');
            $data['weightDetails'] = WeightTracker::getWeightTrackerBySourceType($userId, '1');
            $data['heightDetails'] = HeightTracker::getHeightTrackerBySourceType($userId, '1');
            $data['saturationDetails'] = OxygenSaturation::getSaturationBySourceType($userId, '1');
            $data['temparatureTypes'] = RefTemperature::getTemparatreTypes();
            $data['temperatureDetails'] = BodyTemperature::getBodyTemperatureBySourceType($userId, '1');
            $data['intakeData'] = (!empty($intakedata)) ? unserialize($intakedata->intakeform_data) : array();
            $data['medications'] = $intakedata;
            // dd($data['bpDetails']);
            if (isset($data['isskip']) && $data['isskip'] == '1') {
                DB::table('users')->where('id', session('user.userID'))->update(array(
                    'is_taken_intakeform' => '1',
                ));
            }
            //print_r($userId);die;
            $html = view('frontend.intake.' . $formType, $data);

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    public function getConditions(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            $searchVal = $data['term'];

            $searchResult = array();
            if ($searchVal != '') {
                $querys = DB::table('ref_conditions')->whereNull('ref_conditions.deleted_at');
                $querys->where('condition', 'LIKE', '%' . $searchVal . '%');

                $searchResult = $querys->orderBy('id', 'asc')->limit(10)->get();
                $searchResult = $this->Corefunctions->convertToArray($searchResult);
                $searchResult = $this->Corefunctions->getArrayIndexed1($searchResult, 'id');
            }

            $finalArr = array();
            if (!empty($searchResult)) {
                foreach ($searchResult as $vk => $sf) {
                    $finalArr[$vk]['label'] = $sf['condition'];
                    $finalArr[$vk]['key']     = $sf['id'];
                }
            } else {
                $finalArr[0]['label'] = 'No such condition';
                $finalArr[0]['key']   = '0';
            }

            print json_encode($finalArr);
            exit;
        }
    }

    public function getMedicines(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();
            $searchVal = $data['term'];

            $searchResult = array();
            if ($searchVal != '') {
                $querys = DB::table('ref_medicines')->whereNull('ref_medicines.deleted_at');
                $querys->where('medicine', 'LIKE', '%' . $searchVal . '%');

                $searchResult = $querys->orderBy('id', 'asc')->limit(10)->get();
                $searchResult = $this->Corefunctions->convertToArray($searchResult);
                $searchResult = $this->Corefunctions->getArrayIndexed1($searchResult, 'id');
            }

            $finalArr = array();
            if (!empty($searchResult)) {
                foreach ($searchResult as $vk => $sf) {
                    $finalArr[$vk]['label'] = $sf['medicine'];
                    $finalArr[$vk]['key']     = $sf['id'];
                }
            } else {
                $finalArr[0]['label'] = 'No such medicine';
                $finalArr[0]['key']   = '0';
            }

            print json_encode($finalArr);
            exit;
        }
    }

    //Medical History
    public function medicalHistory()
    {
        if (Session::has('user') && session()->get('user.userType') != 'patient') {
            return Redirect::to('/dashboard');
        }

        $userId = session('user.userID');


        $userDetails = User::where('id', $userId)->whereNull('deleted_at')->first();

        if (empty($userDetails)) {
            return redirect()->route('frontend.index');
        }


        $seo['title']       = "Medical History  | " . env('APP_NAME');
        $seo['keywords']    = "Patient Medical History, View Medical Records, Personal Health History, 
                                Patient Health Notes, Medical History Files, Health Notes and Observations, Access 
                                Patient Records, Detailed Medical History, Manage Health History Files, Complete 
                                Patient Medical History, Secure Medical History Data";
        $seo['description'] = "Welcome to your trusted healthcare connection, offering virtual care at 
                                your fingertips. Our platform provides reliable telehealth services, allowing you to 
                                consult with experienced doctors online, discuss health concerns, and receive timely 
                                medical advice from the comfort of your home. With a wide range of specialties 
                                including general medicine, dermatology, paediatrics, urology, and gynaecology, we 
                                ensure comprehensive care. Effortlessly schedule appointments, get real-time 
                                availability updates, and receive reminders, all while knowing your health data is 
                                safeguarded with advanced security protocols. Experience patient-cantered care with 
                                trusted professionals committed to your health and well-being";
        $seo['og_title']    =  "Medical History  | " . env('APP_NAME');
        $seo['og_description'] = " Access and manage comprehensive medical history records with ease. 
                                    View detailed patient notes, upload or download medical files, and maintain organized 
                                    documentation of health history. Ensure a secure and efficient way to track personal 
                                    health information for better medical care";

        $patient = array();
        return view('frontend.medicalhistory.medical-history', compact('seo', 'patient'));
    }

    public function editmedicalHistory()
    {
        if (request()->ajax()) {
            $userTimeZone = session()->get('user.timezone');
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if (!isset($data['type'])) {
                return $this->Corefunctions->returnError('Form missing');
            }
            $formType = $data['type'];
            $usertype = Session::get('user.userType');
            $userId = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['patientID'];
            $patient = $this->Corefunctions->convertToArray(Patient::where('user_id', $userId)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());
            $medicathistoryDetails  =  $fields =  $medicathistoryChart = array();
            $startDate = isset($data['startDate']) ? $data['startDate'] : '';
            $endDate =  isset($data['endDate']) ? $data['endDate'] : '';
            $label =  isset($data['label']) ? $data['label'] : 'recent';
            $page      = isset($data['page']) ? $data['page'] : 1;
            $pagelimit      = isset($data['pagelimit']) ? $data['pagelimit'] : 1;

            $devicesIDS = array();
            switch ($formType) {
                case 'bp':
                    $fields = ['systolic', 'diastolic', 'pulse'];
                    /*** get  to blood_pressure tracker  */
                    // $medicathistoryDetails = BpTracker::getBpTracker($userId);
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId, 'bp_tracker', $startDate, $endDate, $label, 'patient', $page, $pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'];
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'];

                    $medicathistoryDetailsArray =   $this->Corefunctions->convertToArray($medicathistoryDetails);
                    $devicesIDS          = $this->Corefunctions->getIDSfromArray($medicathistoryDetailsArray['data'], 'rpm_deviceid');

                    break;

                case 'cholesterol':

                    /*** get  to CholestrolTracker tracker  */
                    $fields = ['cltotal', 'LDL', 'HDL', 'triglycerides'];
                    // $medicathistoryDetails = CholestrolTracker::getCholesterolTracker($userId);
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId, 'cholestrol_tracker', $startDate, $endDate, $label, 'patient', $page, $pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'];
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'];

                    $medicathistoryDetailsArray =   $this->Corefunctions->convertToArray($medicathistoryDetails);

                    break;

                case 'glucose':
                    $fields = ['bgvalue', 'a1c'];
                    /*** get  to GlucoseTracker tracker  */
                    // $medicathistoryArray = GlucoseTracker::getGlucoseTracker($userId,$startDate,$endDate,$label,1);
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId, 'glucose_tracker', $startDate, $endDate, $label, 'patient', $page, $pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'];
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'];

                    $medicathistoryDetailsArray =   $this->Corefunctions->convertToArray($medicathistoryDetails);
                    $devicesIDS          = $this->Corefunctions->getIDSfromArray($medicathistoryDetailsArray['data'], 'rpm_deviceid');
                    break;

                case 'weight':
                    $fields = ['kg'];
                    // $medicathistoryDetails = WeightTracker::getWeightTracker($userId);
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId, 'weight_tracker', $startDate, $endDate, $label, 'patient', $page, $pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'];
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'];

                    $medicathistoryDetailsArray =   $this->Corefunctions->convertToArray($medicathistoryDetails);
                    $devicesIDS          = $this->Corefunctions->getIDSfromArray($medicathistoryDetailsArray['data'], 'rpm_deviceid');
                    /*check height exists or not  */
                    $userHeight =   HeightTracker::getHeightTracker($userId);
                    $data['isheight'] = empty($userHeight) ?  0 : 1;
                    break;
                case 'height':
                    $fields = ['cm'];
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId, 'height_tracker', $startDate, $endDate, $label, 'patient', $page, $pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'];
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'];

                    break;
                case 'oxygen-saturations':
                    $fields = ['saturation'];

                    // $medicathistoryDetails = OxygenSaturation::getOxygenSaturation($userId);
                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId, 'oxygen_saturations', $startDate, $endDate, $label, 'patient', $page, $pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'];
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'];

                    $medicathistoryDetailsArray =   $this->Corefunctions->convertToArray($medicathistoryDetails);
                    $devicesIDS          = $this->Corefunctions->getIDSfromArray($medicathistoryDetailsArray['data'], 'rpm_deviceid');
                    break;
                case 'patient-medications':
                    $medicathistory = Medication::getMedications($userId);

                    /** get medicineIDS  with details*/
                    $medicineIds = $this->Corefunctions->getIDSfromArray($medicathistory, 'medicine_id');
                    $medicineIds = array_filter($medicineIds, function ($id) {
                        return $id != 0;
                    });
                    $medicineDetails = $this->Corefunctions->convertToArray(DB::table('ref_medicines')->whereIn('id', $medicineIds)->get());
                    $medicineDetails = $this->Corefunctions->getArrayIndexed1($medicineDetails, 'id');

                    $conditionIds = $this->Corefunctions->getIDSfromArray($medicathistory, 'condition_id');
                    $conditionIds = array_filter($conditionIds, function ($id) {
                        return $id != 0;
                    });
                    $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->whereIn('id', $conditionIds)->get());
                    $conditionDetails = $this->Corefunctions->getArrayIndexed1($conditionDetails, 'id');

                    $strengthUnits = $this->Corefunctions->convertToArray(DB::table('ref_strength_units')->get());
                    $strengthUnits = $this->Corefunctions->getArrayIndexed1($strengthUnits, 'id');

                    $dispenseUnits = $this->Corefunctions->convertToArray(DB::table('ref_medication_dispense_units')->get());
                    $dispenseUnits = $this->Corefunctions->getArrayIndexed1($dispenseUnits, 'id');

                    $medicathistoryDetails = [];

                    // / Loop through each item individually (no grouping)
                    foreach ($medicathistory as $item) {
                        $medicineId = (!empty($item['medicine_id']) && $item['medicine_id'] != '0') ? $item['medicine_id'] : '0';
                        $medicineName = (!empty($item['medicine_name']) && $item['medicine_name'] != '0') ? $item['medicine_name'] : '';
                        $sourceTypeId = $item['source_type_id'];
                        $conditionId = $item['condition_id'];

                        $medicathistoryDetails[] = [
                            'id' => $item['id'],
                            'medication_uuid' => $item['medication_uuid'],
                            'created_by' => $item['created_by'],
                            'created_at' => $item['created_at'],
                            'updated_at' => $item['updated_at'],
                            'strength' => $item['strength'],
                            'strength_unit_id' => $item['strength_unit_id'],
                            'medicine_id' => $medicineId,
                            'medicine_name' => $medicineName,
                            'source_type_id' => $sourceTypeId,
                            'conditions' => ($conditionId != '0') ? ($conditionDetails[$conditionId]['condition'] ?? '--') : '--',
                            'frequency' => $item['frequency'],
                            'prescribed_by' => $item['prescribed_by'],
                            'dispense_unit_id' => $item['dispense_unit_id'],
                            'quantity' => $item['quantity'],
                            'start_date' => $item['start_date'],
                        ];
                    }

                    // print'<pre>';
                    // print_r($medicathistoryDetails);exit;
                    // // Grouping the data
                    // foreach ($medicathistory as $item) {
                    //     $medicineId = (isset($item['medicine_id']) && $item['medicine_id'] != '' && $item['medicine_id'] != '0') ? $item['medicine_id'] : '0';
                    //     $medicineName = (isset($item['medicine_name']) && $item['medicine_name'] != '' && $item['medicine_name'] != '0') ? $item['medicine_name'] : '';
                    //     $sourceTypeId = $item['source_type_id'];
                    //     $conditionId = $item['condition_id'];

                    //     $groupKey = ($medicineId != '0') ? $medicineId . '-' . $sourceTypeId : $medicineName . '-' . $sourceTypeId;

                    //     if (!isset($medicathistoryDetails[$groupKey])) {
                    //         $medicathistoryDetails[$groupKey] = [
                    //             'id' => $item['id'],
                    //             'medication_uuid' => $item['medication_uuid'],
                    //             'created_by' => $item['created_by'],
                    //             'created_at' => $item['created_at'],
                    //             'updated_at' => $item['updated_at'],
                    //             'strength' => $item['strength'],
                    //             'strength_unit_id' => $item['strength_unit_id'],
                    //             'medicine_id' => $medicineId,
                    //             'medicine_name' => $medicineName,
                    //             'source_type_id' => $sourceTypeId,
                    //             'conditions' => [],
                    //         ];
                    //     }
                    //     $medicathistoryDetails[$groupKey]['conditions'][] = ($conditionId != '0') ? $conditionDetails[$conditionId]['condition'] : '--';
                    // }
                    // foreach ($medicathistoryDetails as &$group) {
                    //     $group['conditions'] = implode(',', $group['conditions']);
                    // }

                    $data['conditionDetails'] = $conditionDetails;
                    $data['medicineDetails'] = $medicineDetails;
                    $data['strengthUnits'] = $strengthUnits;
                    $data['dispenseUnits'] = $dispenseUnits;
                    break;
                case 'medical-conditions':
                    $medicathistoryDetails = PatientCondition::getSelfPatientCondition($userId);

                    $conditionIds = $this->Corefunctions->getIDSfromArray($medicathistoryDetails, 'condition_id');
                    $conditionIds = array_filter($conditionIds, function ($id) {
                        return $id != 0;
                    });
                    $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->whereIn('id', $conditionIds)->get());
                    $conditionDetails = $this->Corefunctions->getArrayIndexed1($conditionDetails, 'id');

                    $data['conditionDetails'] = $conditionDetails;
                    break;
                case 'allergies':
                    $medicathistoryDetails = Allergy::getAllergy($userId);
                    break;
                case 'immunizations':
                    $medicathistoryDetails = Immunization::getImmunization($userId);
                    break;
                case 'family-history':

                    $medicathistory = PatientCondition::getPatientCondition($userId);
                    $relationIds = $this->Corefunctions->getIDSfromArray($medicathistory, 'relation_id');
                    $relationIds = array_filter($relationIds, function ($id) {
                        return $id != 0;
                    });
                    $relationDetails = $this->Corefunctions->convertToArray(DB::table('ref_relations')->whereIn('id', $relationIds)->get());
                    $relationDetails = $this->Corefunctions->getArrayIndexed1($relationDetails, 'id');

                    $conditionIds = $this->Corefunctions->getIDSfromArray($medicathistory, 'condition_id');
                    $conditionIds = array_filter($conditionIds, function ($id) {
                        return $id != 0;
                    });
                    $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->whereIn('id', $conditionIds)->get());
                    $conditionDetails = $this->Corefunctions->getArrayIndexed1($conditionDetails, 'id');

                    $medicathistoryDetails = [];
                    // Grouping the data
                    foreach ($medicathistory as $item) {
                        $relationId = $item['relation_id'];
                        $sourceTypeId = $item['source_type_id'];
                        $conditionId = $item['condition_id'];

                        $groupKey = $relationId;

                        if (!isset($medicathistoryDetails[$groupKey])) {
                            $medicathistoryDetails[$groupKey] = [
                                'id' => $item['id'],
                                'patient_condition_uuid' => $item['patient_condition_uuid'],
                                'created_by' => $item['created_by'],
                                'created_at' => $item['created_at'],
                                'updated_at' => $item['updated_at'],
                                'relation_id' => $relationId,
                                'source_type_id' => $sourceTypeId,
                                'conditions' => [],
                            ];
                        }
                        $medicathistoryDetails[$groupKey]['conditions'][] = $conditionDetails[$conditionId]['condition'];
                    }
                    foreach ($medicathistoryDetails as &$group) {
                        $group['conditions'] = implode(', ', $group['conditions']);
                    }

                    $data['relationDetails'] = $relationDetails;
                    $data['conditionDetails'] = $conditionDetails;
                    break;

                case 'measurements':
                    $medicathistoryDetails = WeightTracker::getWeightTracker($userId);
                    break;

                case 'temparature':
                    $fields = ['celsius'];

                    $medicathistoryArray = BpTracker::getLatestMedicalHistory($userId, 'body_temperature', $startDate, $endDate, $label, 'patient', $page, $pagelimit);
                    $medicathistoryChart  = $medicathistoryArray['medicathistoryChart'];
                    $medicathistoryDetails  = $medicathistoryArray['medicathistoryDetails'];

                    // $medicathistoryDetails = BodyTemperature::getBodyTemperature($userId);
                    break;
                default:
                    // Handle unknown section
                    break;
            }

            $relations = $this->Corefunctions->convertToArray(DB::table('ref_relations')->where('internal_field', '0')->get());
            $immunizationTypes = $this->Corefunctions->convertToArray(DB::table('ref_immunization_types')->get());
            $sourceTypes = $this->Corefunctions->convertToArray(DB::table('ref_source_types')->get());
            $conditions = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->limit(25)->get());
            $medicines = $this->Corefunctions->convertToArray(DB::table('ref_medicines')->limit(25)->get());
            $temparatureTypes = RefTemperature::getTemparatreTypes();

            /** get userIDS  with details*/
            $userIds = $this->Corefunctions->getIDSfromArray($medicathistoryDetails, 'created_by');
            $userDetails = $this->Corefunctions->convertToArray(User::whereIn('id', $userIds)->get());
            $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::whereIn('user_id', $userIds)->with('designation')->get());
            $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'id');
            $clinicUser = $this->Corefunctions->getArrayIndexed1($clinicUser, 'user_id');
            $sourceTypes = $this->Corefunctions->getArrayIndexed1($sourceTypes, 'id');


            /*  get device details  */
            $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
            $devices             = $this->Corefunctions->getArrayIndexed1($devices, 'id');


            if (!empty($medicathistoryDetails) && !empty($devices)) {
                foreach ($medicathistoryDetails as $rpk => $rpo) {
                    $rpo->device_name     = (!empty($devices) && isset($devices[$rpo->rpm_deviceid])) ? $devices[$rpo->rpm_deviceid]['device'] : '';
                    $rpo->device_category    = (!empty($devices) && isset($devices[$rpo->rpm_deviceid])) ? $devices[$rpo->rpm_deviceid]['category'] : '';
                    $rpo->device_image    = (!empty($devices) && isset($devices[$rpo->rpm_deviceid])) ? asset('images/rpmdevices/' . $devices[$rpo->rpm_deviceid]['category'] . '.png') : '';

                    if (isset($devices[$rpo->rpm_deviceid])) {
                        $medicathistoryDetails[$rpk] = $rpo;
                    }
                }
            }

            $data['devices'] = $devices;
            $data['patient'] = $patient;
            $data['temparatureTypes'] = $temparatureTypes;
            $data['userTimeZone'] = $userTimeZone;
            $data['sourceTypes'] = $sourceTypes;
            $data['relations'] = $relations;
            $data['conditions'] = $conditions;
            $data['medicines'] = $medicines;
            $data['medicathistoryDetails'] = $medicathistoryDetails;
            $data['immunizationTypes'] = $immunizationTypes;
            $data['userDetails'] = $userDetails;
            $data['clinicUser'] = $clinicUser;
            $data['formType'] = $formType;
            $data['viewtype'] = 'patient';
            $data['fields'] = $fields;
            $data['medicalhistoryList'] = $medicathistoryChart;




            // **Format Data for Charts**
            $labels = [];
            $values = [];
            if (!empty($medicathistoryChart)) {
                foreach ($medicathistoryChart as $record) {
                    $labels[] = $this->Corefunctions->timezoneChange($record['reportdate'], "m/d");
                    $graphvalues = []; // Reset this variable for each record
                    foreach ($fields as $field) {
                        $graphvalues[$field] = isset($record[$field]) ? $record[$field] : null;
                    }
                    $values[] = $graphvalues;
                }
            }



            $html = view('frontend.medicalhistory.' . $formType, $data);

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['labels'] =  $labels;
            $arr['values'] =  $values;

            $arr['startDate'] = $startDate;
            $arr['endDate'] = $endDate;
            $arr['label'] = $label;

            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

    /** get the intake forms   */
    public function editForm()
    {
        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if (!isset($data['formtype'])) {
                return $this->Corefunctions->returnError('Form missing');
            }
            $formType = $data['formtype'];
            $key = $data['key'];
            $usertype = Session::get('user.userType');
            $userId = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['patientID'];
            $patient = $this->Corefunctions->convertToArray(Patient::where('user_id', $userId)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());
            $medicathistoryDetails  = array();
            switch ($formType) {
                case 'bp':
                    /*** get  to blood_pressure tracker  */
                    $medicathistoryDetails = BpTracker::getBpTrackerByKey($key);
                    break;
                case 'cholesterol':
                    /*** get  to CholestrolTracker tracker  */
                    $medicathistoryDetails = CholestrolTracker::getCholesterolTrackerByKey($key);

                    break;

                case 'glucose':

                    /*** get  to GlucoseTracker tracker  */
                    $medicathistoryDetails = GlucoseTracker::getGlucoseTrackerByKey($key);

                    break;

                case 'weight':

                    $medicathistoryDetails = WeightTracker::getWeightTrackerByKey($key);

                    break;
                case 'height':

                    $medicathistoryDetails = HeightTracker::getHeightTrackerByKey($key);

                    break;
                case 'oxygen-saturations':

                    $medicathistoryDetails = OxygenSaturation::getOxygenSaturationByKey($key);

                    break;
                case 'patient-medications':

                    $medicathistory = Medication::getMedicationByKey($key);

                    $medicine = '';

                    if ($medicathistory['medicine_id'] != 0) {
                        $medicineDetails = $this->Corefunctions->convertToArray(DB::table('ref_medicines')->where('id', $medicathistory['medicine_id'])->first());
                        $medicine = $medicineDetails['medicine'];
                    }

                    if ($medicathistory['medicine_id'] != 0) {
                        $medicathistory = Medication::getMedicationByMedicine($medicathistory['user_id'], $medicathistory['medicine_id'], $medicathistory['source_type_id']);
                    } else {
                        $medicathistory = Medication::getMedicationByMedicineName($medicathistory['user_id'], $medicathistory['medicine_name'], $medicathistory['source_type_id']);
                    }
                    $conditionIds = $this->Corefunctions->getIDSfromArray($medicathistory, 'condition_id');
                    $conditionIds = array_filter($conditionIds, function ($id) {
                        return $id != 0;
                    });

                    $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->whereIn('id', $conditionIds)->get());
                    $conditionDetails = $this->Corefunctions->getArrayIndexed1($conditionDetails, 'id');

                    $strengthUnits = $this->Corefunctions->convertToArray(DB::table('ref_strength_units')->get());
                    $strengthUnits = $this->Corefunctions->getArrayIndexed1($strengthUnits, 'id');

                    $dispenseUnits = $this->Corefunctions->convertToArray(DB::table('ref_medication_dispense_units')->get());
                    $dispenseUnits = $this->Corefunctions->getArrayIndexed1($dispenseUnits, 'id');

                    // / Loop through each item individually (no grouping)
                    foreach ($medicathistory as $item) {
                        $medicineId = (!empty($item['medicine_id']) && $item['medicine_id'] != '0') ? $item['medicine_id'] : '0';
                        $medicineName = (!empty($item['medicine_name']) && $item['medicine_name'] != '0') ? $item['medicine_name'] : '';
                        $sourceTypeId = $item['source_type_id'];
                        $conditionId = $item['condition_id'];

                        $medicathistoryDetails = [
                            'id' => $item['id'],
                            'medication_uuid' => $item['medication_uuid'],
                            'created_by' => $item['created_by'],
                            'created_at' => $item['created_at'],
                            'updated_at' => $item['updated_at'],
                            'strength' => $item['strength'],
                            'strength_unit_id' => $item['strength_unit_id'],
                            'medicine_id' => $medicineId,
                            'medicine_name' => $medicineName,
                            'source_type_id' => $sourceTypeId,
                            'conditions' => ($conditionId != '0') ? ($conditionDetails[$conditionId]['condition'] ?? '') : '',
                            'condition_id' => ($conditionId != '0') ? ($conditionId ?? '') : '',
                            'frequency' => $item['frequency'],
                            'prescribed_by' => $item['prescribed_by'],
                            'dispense_unit_id' => $item['dispense_unit_id'],
                            'quantity' => $item['quantity'],
                            'start_date' => $item['start_date'],
                        ];
                    }

                    // $medicathistoryDetails = [];
                    // $groupedData = [];

                    // foreach ($medicathistory as $item) {
                    //     $medicineId = (isset($item['medicine_id']) && $item['medicine_id'] != '' && $item['medicine_id'] != '0') ? $item['medicine_id'] : '0';
                    //     $medicineName = (isset($item['medicine_name']) && $item['medicine_name'] != '' && $item['medicine_name'] != '0') ? $item['medicine_name'] : '';
                    //     $sourceTypeId = $item['source_type_id'];
                    //     $groupKey = ($medicineId != '0') ? $medicineId . '-' . $sourceTypeId : $medicineName . '-' . $sourceTypeId;
                    //     if (!isset($groupedData[$groupKey])) {
                    //         $groupedData[$groupKey] = [
                    //             'medication_uuid' => $item['medication_uuid'],
                    //             'strength' => $item['strength'],
                    //             'strength_unit_id' => $item['strength_unit_id'],
                    //             'medicine_id' => $medicineId,
                    //             'medicine_name' => $medicineName,
                    //             'source_type_id' => $sourceTypeId,
                    //             'conditions' => [],
                    //             'frequency' => $item['frequency'],
                    //             'prescribed_by' => $item['prescribed_by'],
                    //             'dispense_unit_id' => $item['dispense_unit_id'],
                    //             'quantity' => $item['quantity'],
                    //             'start_date' => $item['start_date'],
                    //         ];
                    //     }
                    //     $groupedData[$groupKey]['conditions'][] = [
                    //         'id' => $item['condition_id'],
                    //         'name' => ($item['condition_id'] != '' && $item['condition_id'] != '0') ? $conditionDetails[$item['condition_id']]['condition'] : '',
                    //     ];
                    // }

                    // foreach ($groupedData as $group) {
                    //     $medicathistoryDetails = [
                    //         'medication_uuid' => $group['medication_uuid'],
                    //         'medicine_id' => $group['medicine_id'],
                    //         'medicine_name' => $group['medicine_name'],
                    //         'source_type_id' => $group['source_type_id'],
                    //         'conditions' => $group['conditions'],
                    //         'strength' => $group['strength'],
                    //         'strength_unit_id' => $group['strength_unit_id'],
                    //     ];
                    // }
                    $data['strengthUnits'] = $strengthUnits;
                    $data['dispenseUnits'] = $dispenseUnits;
                    $data['medicine'] = $medicine;
                    break;
                case 'medical-conditions':

                    $medicathistoryDetails = PatientCondition::getPatientConditionByKey($key);

                    $condition = '';
                    if ($medicathistoryDetails['condition_id'] != 0) {
                        $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->where('id', $medicathistoryDetails['condition_id'])->first());
                        $condition = $conditionDetails['condition'];
                    }

                    $data['condition'] = $condition;
                    break;
                case 'allergies':

                    $medicathistoryDetails = Allergy::getAllergyByKey($key);
                    break;
                case 'immunizations':

                    $medicathistoryDetails = Immunization::getImmunizationByKey($key);
                    break;
                case 'family-history':

                    $medicathistory = PatientCondition::getPatientConditionByKey($key);

                    $medicathistory = PatientCondition::getPatientConditionByRelation($medicathistory['user_id'], $medicathistory['relation_id'], $medicathistory['source_type_id']);
                    $conditionIds = $this->Corefunctions->getIDSfromArray($medicathistory, 'condition_id');
                    $conditionIds = array_filter($conditionIds, function ($id) {
                        return $id != 0;
                    });
                    $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->whereIn('id', $conditionIds)->get());
                    $conditionDetails = $this->Corefunctions->getArrayIndexed1($conditionDetails, 'id');

                    $medicathistoryDetails = [];
                    $groupedData = [];

                    foreach ($medicathistory as $item) {
                        $relationId = $item['relation_id'];
                        $sourceTypeId = $item['source_type_id'];
                        $groupKey = $relationId . '-' . $sourceTypeId;
                        if (!isset($groupedData[$groupKey])) {
                            $groupedData[$groupKey] = [
                                'patient_condition_uuid' => $item['patient_condition_uuid'],
                                'relation_id' => $relationId,
                                'source_type_id' => $sourceTypeId,
                                'conditions' => [],
                            ];
                        }
                        $groupedData[$groupKey]['conditions'][] = [
                            'id' => $item['condition_id'],
                            'name' => $conditionDetails[$item['condition_id']]['condition'],
                        ];
                    }

                    foreach ($groupedData as $group) {
                        $medicathistoryDetails = [
                            'patient_condition_uuid' => $group['patient_condition_uuid'],
                            'relation_id' => $group['relation_id'],
                            'source_type_id' => $group['source_type_id'],
                            'conditions' => $group['conditions'],
                        ];
                    }

                    break;

                case 'temperature':

                    $medicathistoryDetails = BodyTemperature::getBodyTemperatureByKey($key);

                    break;

                default:
                    // Handle unknown section
                    break;
            }
            $relations = $this->Corefunctions->convertToArray(DB::table('ref_relations')->where('internal_field', '0')->get());
            $immunizationTypes = $this->Corefunctions->convertToArray(DB::table('ref_immunization_types')->get());
            $temparatureTypes = RefTemperature::getTemparatreTypes();

            $data['patient'] = $patient;
            $data['temparatureTypes'] = $temparatureTypes;
            $data['relations'] = $relations;
            $data['immunizationTypes'] = $immunizationTypes;
            $data['medicathistoryDetails'] = $medicathistoryDetails;
            //  $data['userDetails'] = $userDetails  ;

            $html = view('frontend.medicalhistory.edit-' . $formType, $data);

            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

    public function deleteForm()
    {
        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if (!isset($data['formtype'])) {
                return $this->Corefunctions->returnError('Form missing');
            }
            $formType = ($data['formtype'] == 'medical_conditions') ? 'medical-conditions' : (($data['formtype'] == 'family-history') ? 'family_history' : $data['formtype']);
            $key = $data['key'];
            switch ($formType) {
                case 'bp':
                    BpTracker::deleteBpTracker($key);
                    $formValues = 'Blood pressure';
                    break;
                case 'cholesterol':
                    CholestrolTracker::deleteCholestrolTracker($key);
                    $formValues = 'Cholesterol';
                    break;
                case 'glucose':
                    GlucoseTracker::deleteGlucoseTracker($key);
                    $formValues = 'Glucose level';
                    break;
                case 'weight':
                    WeightTracker::deleteWeightTracker($key);
                    $formValues = 'Weight';
                    break;
                case 'height':
                    HeightTracker::deleteHeightTracker($key);
                    $formValues = 'Height';
                    break;
                case 'oxygen-saturations':
                    OxygenSaturation::deleteOxygenSaturation($key);
                    $formValues = 'Oxygen saturation';
                    break;
                case 'patient-medications':
                    Medication::deleteMedication($key);
                    $formValues = 'Patient medication';
                    break;
                case 'medications':
                    Medication::deleteMedication($key);
                    $formValues = 'Patient medication';
                    break;
                case 'medical-conditions':
                    PatientCondition::deletePatientCondition($key);
                    $formValues = 'Medical condition';
                    break;
                case 'allergies':
                    Allergy::deleteAllergy($key);
                    $formValues = 'Allergy';
                    break;
                case 'immunizations':
                    Immunization::deleteImmunization($key);
                    $formValues = 'Immunization';
                    break;
                case 'family_history':
                    PatientCondition::deleteFamilyHistory($key);
                    $formValues = 'Family history';
                    break;
                case 'temparature':
                    BodyTemperature::deleteBodyTemperature($key);
                    $formValues = 'Body temperature';
                    break;
                default:
                    break;
            }

            $arr['success'] = 1;
            $arr['message'] = $formValues . ' deactivated successfully';
            return response()->json($arr);
        }
    }
    /* store immunization */
    public function storeImmunization()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                if (!empty($input['immunizations'])) {
                    foreach ($input['immunizations'] as $immunization) {
                        if (array_filter($immunization)) {
                            Immunization::addImmunization($immunization['immunization'], $patientID, $clinicID, $input['sourcetype'], session('user.userID'));
                        }
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }
    /* update immunization */
    public function updateImmunization()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                if (!empty($input['immunizations'])) {
                    foreach ($input['immunizations'] as $immunization) {
                        if (array_filter($immunization)) {
                            Immunization::updateImmunization($data['key'], $immunization['immunization'], session('user.userID'));
                        }
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data updated successfully';
            return response()->json($arr);
        }
    }
    /* store allergy */
    public function storeAllergy()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                if (!empty($input['allergies'])) {
                    foreach ($input['allergies'] as $allergy) {
                        if (array_filter($allergy)) {
                            $title = (isset($allergy['allergy']) && $allergy['allergy'] != '') ? $allergy['allergy'] : '';
                            $reaction = (isset($allergy['reaction']) && $allergy['reaction'] != '') ? $allergy['reaction'] : '';
                            if ($title != '' || $reaction != '') {
                                Allergy::addAllergy($title, $reaction, $input['sourcetype'], $patientID, session('user.userID'), $clinicID);
                            }
                        }
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }
    /* update allergy */
    public function updateAllergy()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                if (!empty($input['allergies'])) {
                    foreach ($input['allergies'] as $allergy) {
                        if (array_filter($allergy)) {
                            $title = (isset($allergy['allergy']) && $allergy['allergy'] != '') ? $allergy['allergy'] : '';
                            $reaction = (isset($allergy['reaction']) && $allergy['reaction'] != '') ? $allergy['reaction'] : '';
                            Allergy::updateAllergy($data['key'], $title, $reaction, session('user.userID'));
                        }
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data updated successfully';
            return response()->json($arr);
        }
    }
    /* store medication */
    public function storePatientMedication()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                if (!empty($input['medications'])) {
                    foreach ($input['medications'] as $medication) {
                        if (array_filter($medication)) {
                            if (isset($medication['condition_id']) && $medication['condition_id'] != '' && $medication['condition_id'] != '0') {
                                $conditionID = $medication['condition_id'];
                                Medication::addMedication($medication, $conditionID, $patientID, $clinicID, $input['sourcetype'], session('user.userID'));
                            } else {
                                Medication::addMedication($medication, 0, $patientID, $clinicID, $input['sourcetype'], session('user.userID'));
                            }
                        }
                    }
                }
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }
    public function updatePatientMedication()
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            parse_str($data['formdata'], $input);

            $medicationDets = Medication::getMedicationByKey($data['key']);

            $patientID = (!empty($data['patientID']) && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = ($usertype == 'patient') ? NULL : session('user.clinicID');

            if (!empty($input) && !empty($input['medications'])) {
                foreach ($input['medications'] as $medication) {
                    if (array_filter($medication)) {
                        // Use updated medicine_id and medicine_name from the loop
                        $medicineID = isset($medication['medicine_id']) ? $medication['medicine_id'] : 0;
                        $medicineName = isset($medication['medicine_name']) ? $medication['medicine_name'] : '';

                        // Now insert updated medications
                        if (isset($medication['condition_id']) && $medication['condition_id'] != '' && $medication['condition_id'] != '0') {
                            $conditionID = $medication['condition_id'];
                            Medication::updateMedication($data['key'], $medication, $conditionID, session('user.userID'));
                        } else {
                            Medication::updateMedication($data['key'], $medication, 0, session('user.userID'));
                        }
                    }
                }
            }

            return response()->json(['success' => 1, 'message' => 'Data updated successfully']);
        }
    }
    public function checkconditionexists()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            if ($data['condition_id']) {
                $existpatientconditionid = (isset($data['patientconditionid'])) ? $data['patientconditionid'] : '';
                $hasData = '0';
                /* Condition By ID */
                $existconditiondata  = DB::table('patient_conditions')->where('condition_id', $data['condition_id'])->where('user_id', $patientID)->where('relation_id', '19')->whereNull('deleted_at')->limit(1)->first();
                if ($existpatientconditionid != '') {
                    $existconditiondata = DB::table('patient_conditions')->where('condition_id', $data['condition_id'])->where('user_id', $patientID)->where('relation_id', '19')->where('id', '!=', $existpatientconditionid)->whereNull('deleted_at')->limit(1)->first();
                }
                $hasData = (!empty($existconditiondata)) ? '1' : '0';
                if ($hasData == 1) {
                    return 'false';
                } else {
                    return 'true';
                }
            }
        }
    }
    public function checkrelationexists()
    {
        if (request()->ajax()) {
            $data = request()->all();

            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $realtionID = (isset($data['realtionID']) && $data['realtionID'] != '' && $data['realtionID'] != 'null') ? $data['realtionID'] : '';

            if ($data['relation']) {
                $existpatientrelationid = (isset($data['patientrelationid'])) ? $data['patientrelationid'] : '';
                $hasData = '0';
                $existrelationdata  = DB::table('patient_conditions')->where('relation_id', $data['relation'])->where('user_id', $patientID)->whereNull('deleted_at')->limit(1)->first();
                if ($existpatientrelationid != '') {
                    $existrelationdata = DB::table('patient_conditions')->where('relation_id', $data['relation'])->where('user_id', $patientID)->where('id', '!=', $existpatientrelationid)->whereNull('deleted_at')->limit(1)->first();
                }
                $hasData = (!empty($existrelationdata)) ? '1' : '0';
                if ($realtionID ==  $data['relation']) {
                    return 'true';
                } else {
                    if ($hasData == 1) {
                        return 'false';
                    } else {
                        return 'true';
                    }
                }
            }
        }
    }
    /* store saturation */
    public function storeSaturation()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $patientID = (isset($data['patientID']) && $data['patientID'] != '' && $data['patientID'] != 'null') ? $data['patientID'] : session('user.userID');
            $usertype = Session::get('user.userType');
            $clinicID = (isset($usertype) && $usertype == 'patient') ? NULL : session('user.clinicID');
            $userTimeZone = session()->get('user.timezone');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            if (!empty($input)) {
                if (isset($input['reportdate'])  && $input['reportdate'] != '') {
                    $dateTimeString = $input['reportdate'];
                    $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

                    $dateTime->setTimezone(new \DateTimeZone('UTC'));
                    $formattedDate = $dateTime->format('Y-m-d');
                } else {
                    $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
                }
                if (isset($input['reporttime'])  && $input['reporttime'] != '') {
                    $dateTimeString = $input['reporttime'];
                    $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

                    $dateTime->setTimezone(new \DateTimeZone('UTC'));
                    $formattedTime = $dateTime->format('H:i:s');
                } else {
                    $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
                }
                $insertArray = [
                    'saturation' => $input['saturation'],
                    'reportdate' => $formattedDate,
                    'reporttime' => $formattedTime,
                    'user_id'    => $patientID,
                    'clinic_id'  => $clinicID,
                    'sourceType' => isset($input['sourcetype'])  && $input['sourcetype'] != '' ? $input['sourcetype']  : '1',
                ];
                OxygenSaturation::addOxygenSaturation($insertArray, session('user.userID'));
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data added successfully';
            return response()->json($arr);
        }
    }
    /* update saturation */
    public function updateSaturation()
    {
        if (request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }

            $userTimeZone = session()->get('user.timezone');

            // Parse form data from serialized input
            parse_str($data['formdata'], $input);

            $saturationDets = OxygenSaturation::getOxygenSaturationByKey($data['key']);

            if (!empty($input)) {
                if (!empty($input['editreportdate'])) {
                    $dateTimeString = $input['editreportdate'];

                    // Create DateTime object in the user's timezone
                    $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

                    if ($dateTime) {
                        $dateTime->setTimezone(new \DateTimeZone('UTC')); // Convert to UTC
                        $input['reportdate'] = $dateTime->format('Y-m-d'); // Format to Y-m-d
                    } else {
                        $input['reportdate'] = $saturationDets['reportdate']; // Fallback for invalid date
                    }
                } else {
                    $input['reportdate'] = $saturationDets['reportdate'];
                }

                if (!empty($input['editreporttime'])) {
                    $timeString = $input['editreporttime']; // e.g., "10:30 PM"

                    // Create DateTime object in the user's timezone
                    $time = \DateTime::createFromFormat('h:i A', $timeString, new \DateTimeZone($userTimeZone));

                    if ($time) {
                        $time->setTimezone(new \DateTimeZone('UTC')); // Convert to UTC
                        $input['reporttime'] = $time->format('H:i:s'); // Format to 24-hour format
                    } else {
                        $input['reporttime'] = $saturationDets['reporttime']; // Fallback for invalid time
                    }
                } else {
                    $input['reporttime'] = $saturationDets['reporttime'];
                }
                $input['saturation'] = $input['editsaturation'];
                OxygenSaturation::updateOxygenSaturation($data['key'], $input, session('user.userID'));
            }

            $arr['success'] = 1;
            $arr['message'] = 'Data updated successfully';
            return response()->json($arr);
        }
    }


    /** medical history vitals update  */

    /** get the intake forms   */
    public function medicalHistoryGraph()
    {
        if (request()->ajax()) {

            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if (!isset($data['type'])) {
                return $this->Corefunctions->returnError('Form missing');
            }
            $usertype = Session::get('user.userType');
            $data['userID'] = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['userID'];
            if (!isset($data['userID'])) {
                return $this->Corefunctions->returnError('Key missing');
            }
            $lastVitalID = 0;
            $formType = $data['type'];
            $viewtype = isset($data['viewtype']) ? $data['viewtype'] : '';
            $lastMHID = isset($data['lastId']) ? $data['lastId'] : '0';
            $userId   =  $data['userID'];
            $medicalHistoryDetails = $medicalhistoryList = array();
            $startDate = isset($data['startDate']) ? $data['startDate'] : '';
            $endDate =  isset($data['endDate']) ? $data['endDate'] : '';
            $label =  isset($data['label']) ? $data['label'] : '';

            switch ($formType) {
                case 'blood_pressure':
                    $fields = ['systolic', 'diastolic', 'pulse'];
                    $table = 'bp_tracker';
                    $key = 'bp_tracker_uuid';
                    break;

                //   case 'heart_rate':
                //       $fields = ['pulse'];
                //       $table = 'bp_tracker';
                //       $key ='bp_tracker_uuid';
                //       break;

                case 'blood_glucose':
                    $fields = ['bgvalue', 'a1c'];
                    $table = 'glucose_tracker';
                    $key = 'glucose_tracker_uuid';
                    break;

                case 'cholesterol':
                    $fields = ['cltotal', 'LDL', 'HDL', 'triglycerides'];
                    $table = 'cholestrol_tracker';
                    $key = 'cholestrol_tracker_uuid';
                    break;

                //   case 'hba1c':
                //       $fields = ['a1c'];
                //       $table = 'glucose_tracker';
                //       $key ='glucose_tracker_uuid';
                //       break;

                case 'weight':
                    $fields = ['kg'];
                    $table = 'weight_tracker';
                    $key = 'weight_tracker_uuid';
                    break;

                case 'height':
                    $fields = ['cm'];
                    $table = 'height_tracker';
                    $key = 'height_tracker_uuid';
                    break;

                case 'bmi':
                    $fields = ['bmi'];
                    $table = 'weight_tracker';
                    $key = 'weight_tracker_uuid';

                    break;

                case 'oxygen_levels':
                    $fields = ['saturation'];
                    $table = 'oxygen_saturations';
                    $key = 'oxygen_saturation_uuid';

                    break;

                case 'temperature':
                    $fields = ['celsius'];
                    $table = 'body_temperature';
                    $key = 'body_temperature_uuid';

                    break;

                default:
                    break;
            }
            $page      = isset($data['page']) ? $data['page'] : 1;
            $pagelimit = isset($data['pagelimit']) && $data['pagelimit'] != '' ? $data['pagelimit'] : 10;
            // **Fetch Medical History Data**

            $medicalHistoryArray = BpTracker::getLatestMedicalHistory($userId, $table, $startDate, $endDate, $label, $viewtype, $page, $pagelimit);

            $medicalHistoryDetails = $medicalHistoryArray['medicalHistoryList'];
            $medicalHistoryDetailsArray =  $medicalHistoryArray['medicalHistoryPaginate'];
            $perPage = '10';


            $devicesIDS = $devices = array();
            /*  get device details  */
            if ($formType == 'blood_pressure' || $formType == 'blood_glucose' || $formType == 'oxygen_levels' || $formType == 'weight') {
                $devicesIDS          = $this->Corefunctions->getIDSfromArray($medicalHistoryDetails, 'rpm_deviceid');

                $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
                $devices             = $this->Corefunctions->getArrayIndexed1($devices, 'id');
            }

            // **Format Data for Charts**
            $labels = [];
            $values = [];
            $medicalhistoryList = [];

            foreach ($medicalHistoryDetails as $record) {
                $labels[] = $this->Corefunctions->timezoneChange($record['reportdate'], "m/d");
                $recordValues = [];
                $graphvalues = []; // Reset this variable for each record

                foreach ($fields as $field) {
                    $recordValues[$field] = isset($record[$field]) ? $record[$field] : null;
                    $graphvalues[$field] = isset($record[$field]) ? $record[$field] : null;
                }

                $recordValues['source_type_id'] = isset($record['source_type_id']) ? $record['source_type_id'] : null;
                $recordValues['reportdate'] = $record['reportdate'];
                $recordValues['reporttime'] = $record['reporttime'];
                $recordValues['created_by'] = isset($record['created_by']) ? $record['created_by'] : '';
                $recordValues['key'] =  isset($record[$key]) ? $record[$key] : null;
                $recordValues['rpm_deviceid'] = isset($record['rpm_deviceid']) ? $record['rpm_deviceid'] : null;

                $recordValues['device_name']     = (!empty($devices) && isset($devices[$record['rpm_deviceid']])) ? $devices[$record['rpm_deviceid']]['device'] : '';
                $recordValues['device_category']    = (!empty($devices) && isset($devices[$record['rpm_deviceid']])) ? $devices[$record['rpm_deviceid']]['category'] : '';
                $recordValues['device_image']    = (!empty($devices) && isset($devices[$record['rpm_deviceid']])) ? asset('images/rpmdevices/' . $devices[$record['rpm_deviceid']]['category'] . '.png') : '';



                $values[] = $graphvalues;
                $medicalhistoryList[] = $recordValues;

                $lastVitalID = $record['id'];
            }

            $sourceTypes = $this->Corefunctions->convertToArray(DB::table('ref_source_types')->get());
            $sourceTypes = $this->Corefunctions->getArrayIndexed1($sourceTypes, 'id');


            // **Prepare Data for View**
            $data = [
                'medicalHistoryDetailsArray' => $medicalHistoryDetailsArray,
                'perPage'               => $perPage,
                'labels'                => $labels,
                'medicalhistoryList'    => $medicalhistoryList,
                'fields'                => $fields,
                'sourceTypes'           => $sourceTypes,
                'values'                => $values,
                'viewtype'              => $viewtype,
                'formType'              => $formType,
                'view'                  => isset($data['view']) ? $data['view'] : '',
                'lastVitalID'           => $lastVitalID,
                'isloadmore'            => isset($data['isloadmore']) ? $data['isloadmore'] : 0,

            ];

            if (isset($data['isloadmore']) && $data['isloadmore'] == 1) {
                $html = view('appointment.charts.list', $data);
            } else {
                $html = view('appointment.charts.vitals-chart', $data);
            }


            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['lastVitalID'] =  $lastVitalID;
            $arr['labels'] =  $labels;
            $arr['values'] =  $values;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }
    public function appointmentMedicalHistory()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }

            $formType = $data['type'];
            $page     = isset($data['page']) ? $data['page'] : '';
            $viewType = isset($data['view']) ? $data['view'] : '';
            $usertype = Session::get('user.userType');
            $data['patientId'] = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['patientId'];
            switch ($formType) {
                case 'vitals':

                    /*** get  medical history  */
                    $medicalHistory = $this->Corefunctions->appointmentMedicalHistory($data['patientId']);
                    $data['medicalHistory'] = $medicalHistory;
                    $data['userId'] = $data['patientId'];
                    $view = 'appointment.medicalhistory.appendvitals';
                    break;

                case 'previousappointments':

                    $appointment = Appointment::appointmentByKey($data['key']);
                    if (empty($appointment)) {
                        $arr['error'] = 1;
                        $arr['errormsg'] = 'Invalid Appointment';
                        return response()->json($arr);
                    }
                    $previousAppointments = Appointment::getPreviousAppointments($appointment->patient_id, $appointment->id, $appointment->created_at);
                    if (!empty($previousAppointments)) {
                        foreach ($previousAppointments as $pak => $pav) {
                            $previousAppointments[$pak]['videocall'] = VideoCall::getVideoCallByAppointmentId($pav['id']);
                        }
                    }
                    $appointmentTypes = AppointmentType::all()->keyBy('id')->toArray();

                    $data['previousAppointments'] = $previousAppointments;
                    $data['appointmentTypes'] = $appointmentTypes;
                    $view = 'appointment.medicalhistory.previous_appointments';

                    break;

                case 'previousappointments_patient':

                    $appointment = Appointment::appointmentByKey($data['key']);
                    if (empty($appointment)) {
                        $arr['error'] = 1;
                        $arr['errormsg'] = 'Invalid Appointment';
                        return response()->json($arr);
                    }
                    $previousAppointments = Appointment::getPreviousAppointments($appointment->patient_id, $appointment->id, $appointment->created_at);
                    if (!empty($previousAppointments)) {
                        foreach ($previousAppointments as $pak => $pav) {
                            $previousAppointments[$pak]['videocall'] = VideoCall::getVideoCallByAppointmentId($pav['id']);
                        }
                    }
                    $appointmentTypes = AppointmentType::all()->keyBy('id')->toArray();

                    $data['previousAppointments'] = $previousAppointments;
                    $data['appointmentTypes'] = $appointmentTypes;
                    $view = 'frontend.previous_appointments_patient';

                    break;

                case 'history':

                    $medicalHistory = [
                        [
                            'title' => 'Medical Conditions',
                            'type'  => 'medical_conditions',
                        ],
                        [
                            'title' => 'Allergies',
                            'type'  => 'allergies',
                        ],
                        [
                            'title' => 'Immunizations',
                            'type'  => 'immunizations',
                        ],
                        [
                            'title' => 'Family Medical History',
                            'type'  => 'family_history',
                        ]
                    ];
                    $data['medicalHistory'] = $medicalHistory;
                    $view = 'appointment.medicalhistory.history';

                    break;

                case 'medications':

                    /* Dosespot */
                    $patientDets = Patient::patientByUserAndClinicID($data['patientId'], session()->get('user.clinicID'));
                    if (!empty($patientDets) && $patientDets['dosepsot_patient_id'] != '') {
                        $loginUserDetails = ClinicUser::getClinicUserWithClinic();
                        $response = $this->Corefunctions->getMedicationHistory($patientDets, $loginUserDetails);
                    }

                    $page     = isset($data['page']) ? $data['page'] : '';
                    $medicathistoryArray = Medication::getMedication($data['patientId'], $page, session()->get('user.clinicID'));
                    $perPage = '10';
                    $medicathistory = $this->Corefunctions->convertToArray($medicathistoryArray);

                    /** get medicineIDS  with details*/
                    $medicineIds = $this->Corefunctions->getIDSfromArray($medicathistory['data'], 'medicine_id');
                    $medicineIds = array_filter($medicineIds, function ($id) {
                        return $id != 0;
                    });
                    $medicineDetails = $this->Corefunctions->convertToArray(DB::table('ref_medicines')->whereIn('id', $medicineIds)->get());
                    $medicineDetails = $this->Corefunctions->getArrayIndexed1($medicineDetails, 'id');

                    $conditionIds = $this->Corefunctions->getIDSfromArray($medicathistory['data'], 'condition_id');
                    $conditionIds = array_filter($conditionIds, function ($id) {
                        return $id != 0;
                    });
                    $conditionDetails = $this->Corefunctions->convertToArray(DB::table('ref_conditions')->whereIn('id', $conditionIds)->get());
                    $conditionDetails = $this->Corefunctions->getArrayIndexed1($conditionDetails, 'id');

                    $strengthUnits = $this->Corefunctions->convertToArray(DB::table('ref_strength_units')->get());
                    $strengthUnits = $this->Corefunctions->getArrayIndexed1($strengthUnits, 'id');

                    $dispenseUnits = $this->Corefunctions->convertToArray(DB::table('ref_medication_dispense_units')->get());
                    $dispenseUnits = $this->Corefunctions->getArrayIndexed1($dispenseUnits, 'id');

                    $medicathistoryDetails = [];

                    // / Loop through each item individually (no grouping)
                    foreach ($medicathistory['data'] as $item) {
                        $medicineId = (!empty($item['medicine_id']) && $item['medicine_id'] != '0') ? $item['medicine_id'] : '0';
                        $medicineName = (!empty($item['medicine_name']) && $item['medicine_name'] != '0') ? $item['medicine_name'] : '';
                        $sourceTypeId = $item['source_type_id'];
                        $conditionId = $item['condition_id'];

                        $medicathistoryDetails[] = [
                            'id' => $item['id'],
                            'medication_uuid' => $item['medication_uuid'],
                            'created_by' => $item['created_by'],
                            'created_at' => $item['created_at'],
                            'updated_at' => $item['updated_at'],
                            'strength' => $item['strength'],
                            'strength_unit_id' => $item['strength_unit_id'],
                            'medicine_id' => $medicineId,
                            'medicine_name' => $medicineName,
                            'source_type_id' => $sourceTypeId,
                            'conditions' => ($conditionId != '0') ? ($conditionDetails[$conditionId]['condition'] ?? '--') : '--',
                            'frequency' => $item['frequency'],
                            'prescribed_by' => $item['prescribed_by'],
                            'dispense_unit_id' => $item['dispense_unit_id'],
                            'quantity' => $item['quantity'],
                            'start_date' => (isset($item['start_date']) && $item['start_date'] != '') ? date('M d Y', strtotime($item['start_date'])) : '',
                        ];
                    }


                    $data['conditionDetails'] = $conditionDetails;
                    $data['medicineDetails'] = $medicineDetails;
                    $data['strengthUnits'] = $strengthUnits;
                    $data['dispenseUnits'] = $dispenseUnits;
                    $data['medicathistoryDetails'] = $medicathistoryDetails;
                    $data['medicathistoryArray'] = $medicathistoryArray;
                    $data['perPage'] = $perPage;

                    $view = 'appointment.medicalhistory.medications';
                    break;


                case 'notes':
                    $appointmentid = '';
                    $notesLocked = '0';
                    if (isset($data['key']) && $data['key'] != '') {
                        $appointment = Appointment::appointmentByKey($data['key']);
                        $appointmentid = $appointment->id;
                        $notesLocked = ($appointment->is_notes_locked == '1') ? '1' : '0';
                    }
                    $perPage = '10';
                    $usertype = Session::get('user.userType');
                    $data['patientId'] = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['patientId'];
                    $clinicId = session()->get('user.clinicID');
                    /* get latest medical notes details */
                    $medicalNotesArray = MedicalNote::getAllMedicalNotesByUser($data['patientId'], $page, $usertype, $appointmentid);
                    $medicalNoteDetails = $this->Corefunctions->convertToArray($medicalNotesArray);

                    $userIDs = $this->Corefunctions->getIDSfromArray($medicalNoteDetails['data'], 'created_by');


                    $userDetails = ClinicUser::getClinicUsersByUserIds($userIDs);
                    $userDetails = $this->Corefunctions->convertToArray($userDetails);
                    $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'user_id');
                    $data['medicalNoteDetails'] = $medicalNoteDetails;
                    $data['userDetails']        = $userDetails;
                    $data['medicalNotesArray']  = $medicalNotesArray;
                    $data['perPage'] = $perPage;
                    $data['notesLocked'] = $notesLocked;

                    $view = 'appointment.medicalhistory.notes';
                    break;

                case 'labs':

                    /* get the test lists */
                    $orderListsArray =  PatientLabTest::getAllPatientOrders($data['patientId'], $page);
                    $perPage = '10';
                    $orderLists = $this->Corefunctions->convertToArray($orderListsArray);
                    $userIDs = $this->Corefunctions->getIDSfromArray($orderLists['data'], 'created_by');
                    $userDetails = ClinicUser::getAllClinicUsersByUserID($userIDs);
                    $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'user_id');


                    $data['orderLists'] = $orderLists;
                    $data['userDetails'] = $userDetails;
                    $data['orderListsArray'] = $orderListsArray;
                    $data['perPage'] = $perPage;

                    $view = 'appointment.labs.labs';
                    break;


                case 'imaging':

                    /* get the test lists */
                    $imagingListsArray =  PatientImagingTest::getAllPatientImaging($data['patientId'], $page);
                    $perPage = '10';
                    $imagingLists = $this->Corefunctions->convertToArray($imagingListsArray);
                    $userIDs = $this->Corefunctions->getIDSfromArray($imagingLists['data'], 'created_by');
                    $userDetails = ClinicUser::getAllClinicUsersByUserID($userIDs);
                    $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'user_id');


                    $data['imagingLists'] = $imagingLists;
                    $data['userDetails'] = $userDetails;
                    $data['imagingListsArray'] = $imagingListsArray;
                    $data['perPage'] = $perPage;

                    $view = 'appointment.imaging.imaging';
                    break;

                case 'devices':
                    $stats = array('-1', '1', '2', '4');
                    $clinicId = Session::get('user.clinicID');
                    $patient = $this->Corefunctions->convertToArray(Patient::getPatientByClinicId($data['patientId'], $clinicId));
                    /* Fetch Orders */
                    $rpmdOrders          = RpmOrders::getRpmOrders($stats, $clinicId, $patient['user_id'], $patient['id']);
                    $rpmdOrders          = $this->Corefunctions->getArrayIndexed1($rpmdOrders, 'id');
                    $orderIDS            = $this->Corefunctions->getIDSfromArray($rpmdOrders, 'id');
                    $clinicIDS           = $this->Corefunctions->getIDSfromArray($rpmdOrders, 'clinic_id');
                    $clinicUserIDS       = $this->Corefunctions->getIDSfromArray($rpmdOrders, 'clinic_user_id');
                    $clinicUsers         = $this->Corefunctions->convertToArray(ClinicUser::getClinicUsersByIds($clinicUserIDS));
                    $clinicUsers          = $this->Corefunctions->getArrayIndexed1($clinicUsers, 'id');


                    /* Fetch Order Devices */
                    $rpmdOrderDevices    = RpmOrders::getOrderDevicesByOrderIDS($stats, $orderIDS);
                    $devicesIDS          = $this->Corefunctions->getIDSfromArray($rpmdOrderDevices, 'rpm_device_id');
                    $devices             = RpmOrders::rpmDevicesByIDS($devicesIDS);
                    $devices             = $this->Corefunctions->getArrayIndexed1($devices, 'id');
                    if (!empty($rpmdOrders)) {
                        foreach ($rpmdOrders as $rok => $rov) {
                            $image = (isset($clinicUsers[$rov['clinic_user_id']]['logo_path']) && $clinicUsers[$rov['clinic_user_id']]['logo_path'] != '') ? $this->Corefunctions->resizeImageAWS($clinicUsers[$rov['clinic_user_id']]['id'], $clinicUsers[$rov['clinic_user_id']]['logo_path'], $clinicUsers[$rov['clinic_user_id']]['first_name'], 180, 180, '1') : '';
                            $rpmdOrders[$rok]['ordered_by'] = $clinicUsers[$rov['clinic_user_id']]['first_name'] . ' ' . $clinicUsers[$rov['clinic_user_id']]['last_name'];
                            $rpmdOrders[$rok]['ordered_by_email'] = $clinicUsers[$rov['clinic_user_id']]['email'];
                            $rpmdOrders[$rok]['ordered_by_image'] = ($image != '') ? $image : asset('images/default_img.png');
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
                    $data['rpmdOrders'] = $rpmdOrders;

                    $view = 'appointment.devices.listing';
                default:
                    break;
            }
            $data['viewType'] = $viewType;
            $html = view($view, $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
}
