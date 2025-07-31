<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\RefIcd10Code;
use App\Models\MedicalNote;
use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use File;

class NotesController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        // Middleware for session check
        $this->middleware(function ($request, $next) {
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
                // return Redirect::to('/');
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
    
   
     /** get the add forms   */
    public function addNotes()
    {
        if(request()->ajax()) {
            $data = request()->all();
             // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'error' => '1',
                    'errormsg' => 'Fields missing' ,
                ]);
            }
            if (($data['userID']) == '') {
                return response()->json([
                    'error' => '1',
                    'errormsg' => 'Fields missing' ,
                ]);
            }
            $appointment_id = '';
            if(isset($data['key']) && $data['key'] != ''){
                $appointment = Appointment::appointmentByKey($data['key']);
                $appointment_id = $appointment->id;
            }
            $clinicId = session()->get('user.clinicID'); 
            $medicalNoteDetails =array();
            /* get latest medica notes details */
            $medicalNoteList = MedicalNote::getMedicalNotesByUser($data['userID'],$clinicId);
            
            if ( isset($data['medicalnotekey'])  && $data['medicalnotekey'] !='') {
                /* get latest medica notes details */
                $medicalNoteDetails = MedicalNote::getMedicalNotesByKey($data['medicalnotekey'],$data['userID'],$clinicId);
                if(empty( $medicalNoteDetails)){
                    return response()->json([
                        'error' => '1',
                        'errormsg' => 'Invalid notes' ,
                    ]);
                }
                if(isset($medicalNoteDetails['appointment_id']) && $medicalNoteDetails['appointment_id'] != ''){
                    $appointment = Appointment::appointmentByID($medicalNoteDetails['appointment_id']);
                    if($appointment->is_notes_locked == '1'){
                        return response()->json([
                            'error' => '1',
                            'errormsg' => 'The notes for this appointment are locked and cannot be edited.' ,
                        ]);
                    }
                }
                /* get notes icd codes  */
                $notesIcdCodes = MedicalNote::getNotesIcdCodes($medicalNoteDetails['id']);
                $codeIDs = $this->Corefunctions->getIDSfromArray($notesIcdCodes, 'icd10_code_id');

                /* get icd codes  */
                $icd10Codes =  MedicalNote::getIcdCodesByIDs($codeIDs);
                $data['icd10Codes'] = $icd10Codes ;

            }
            $userIDs = $this->Corefunctions->getIDSfromArray($medicalNoteList, 'created_by');
                    
            $userDetails = ClinicUser::getClinicUsersByUserIds($userIDs);
            $userDetails = $this->Corefunctions->convertToArray($userDetails);
            $userDetails = $this->Corefunctions->getArrayIndexed1($userDetails, 'user_id');

            $data['userDetails'] = $userDetails;
            $data['viewType'] = $data['view'] ;
            $data['medicalNoteList'] = $medicalNoteList ;
            $data['medicalNoteDetails'] = $medicalNoteDetails ;
            $data['appointment_id'] = $appointment_id;
            $html = view('appointment.notes.addnote', $data);
            
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
         }
    }
  

    public function getsummary()
    {

        
        if(request()->ajax()) {
             $data = request()->all();
               
                $url = env('AI_URL');

                $content = $data['notes'];
                $prompt = 'Convert the following clinical summary into a structured SOAP format. Return the result as a JSON object with keys: subjective, objective, assessment, plan, and icd10_codes (an array of code + description). Summary:';

                $vars = [
                    'model' => 'gpt-4',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a medical assistant. Convert medical summaries into structured SOAP format and suggest ICD-10 codes.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt . "\n\n" . $content
                        ]
                    ],
                    'temperature' => 0.7,
                ];


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $headers = [
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env('AI_AUTHORIZATION_KEY')
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $server_output = curl_exec($ch);
                curl_close($ch);

                $result = json_decode($server_output, true);
                $result = json_decode($result['choices'][0]['message']['content'],true);

                $arr['success'] = 1;
                $arr['subjective'] = isset($result['subjective']) ? $result['subjective'] : '';
                $arr['objective'] = isset($result['objective']) ? $result['objective'] : '';
                $arr['assessment'] = isset($result['assessment']) ? $result['assessment'] : '';
                $arr['plan'] = isset($result['plan']) ? $result['plan'] : '';
                 $icd10code='';
                 $icd10CodesArray = $result['icd10_codes'] ?? [];
                if(!empty($result['icd10_codes'])){
                    foreach($result['icd10_codes'] as $codes){
                        $icd10code .='<span class="align_middle badge rounded-pill bg-dark px-3 py-2 icdcls_'.$codes['code'].'" data-bs-toggle="tooltip" title="'.$codes['description'].'">'.$codes['code'].'<a type="button" onclick="removeIcd10Code(\'' . addslashes($codes['code']) . '\')" class="remove-condition d-flex"><span class="material-symbols-outlined danger">close</span></a></span>';
                    }
                }
                // Extract only the 'code' values into a separate array
                $icd10CodeValues = array_map(function($code) {
                    return $code['code'];
                }, $icd10CodesArray);

                $arr['icd10CodeValues'] = $icd10CodeValues;
                $arr['icd10code'] = $icd10code;          
                $arr['message'] = 'Data fetched successfully';
                return response()->json($arr);
                
        }

    }


    /** save notes  */
    public function saveNotes()
    {
        if(request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            
            $clinicId = session()->get('user.clinicID'); 
            
            // Parse form data from serialized input
            parse_str($data['formData'], $input);
            /** insert to medicat noyes */
            $medicalNoteID = MedicalNote::insertMedicalNotes($input,$clinicId,session('user.userID'),$data['userID']);

            if(isset($input['icd10_code_values']) && $input['icd10_code_values'] !=''){
                /* get icd 10 codes  */
                $icdcodesIDS = RefIcd10Code::geticdcodes($input['icd10_code_values']);
              
                /** inset to medical note codes */
                if(!empty($icdcodesIDS)){
                    foreach($icdcodesIDS as $codes){
                        $icd10 = MedicalNote::insertMedicalNoteIcd10Codes($medicalNoteID,$codes['id']);
                    }

                
                }
            }
            /* notification to patient  */
            if(isset( $input['allowPatient']) && $input['allowPatient'] =='on'){
                $this->Corefunctions->addNotifications(13,$clinicId,$data['userID'],$medicalNoteID);
            }
          
       
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
        }
    }

    /** get notes details   */
    public function notesDetails()
    {
        if(request()->ajax()) {
             $data = request()->all();
             // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            $usertype = Session::get('user.userType');
            $data['userID'] = (isset($usertype) && $usertype == 'patient') ? session('user.userID') : $data['userID'];

            if (($data['userID']) == '') {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if (($data['medicalnotekey']) == '') {
                return $this->Corefunctions->returnError('Key missing');
            }
            $clinicId = session()->get('user.clinicID'); 
            $icd10Codes = array();
            /* get latest medica notes details */
            $medicalNoteDetails = MedicalNote::getMedicalNotesByKey($data['medicalnotekey'],$data['userID']);
            
           
           if(isset($medicalNoteDetails['video_scribe']) && $medicalNoteDetails['video_scribe'] == '1') {
                $tabs = [
                    ['id' => 'summary', 'label' => 'Objective', 'icon' => 'summarize', 'active' => true],
                    ['id' => 'transcription', 'label' => 'Transcription', 'icon' => 'ink_pen'],
                ];
                
                
                $transcription =  file_get_contents($this->Corefunctions->getAWSPathPrivate($medicalNoteDetails['transcript_file_path']));
                
                // Remove "WEBVTT" header
                $transcription = preg_replace('/^WEBVTT\s*/', '', $transcription);

                // Break into lines
                $lines = explode("\n", $transcription);

                $result = [];
                $currentTimestamp = null;

                foreach ($lines as $line) {
                    $line = trim($line);
                    // If this line contains a timestamp
                    if (preg_match('/^(\d{2}):(\d{2}):(\d{2})\.\d{3}\s+-->/i', $line, $match)) {
                        // Convert to h:i A format
                        $hours = (int)$match[1];
                        $minutes = (int)$match[2];
                        $seconds = (int)$match[3];

                        $time = \DateTime::createFromFormat('H:i:s', sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds));
                        $currentTimestamp = $time ? $time->format('h:i A') : null;
                    }
                    // Skip numeric sequence lines
                    elseif (preg_match('/^\d+$/', $line)) {
                        continue;
                    }
                    // If it's dialogue/content, tag with formatted time
                    elseif (!empty($line) && $currentTimestamp) {
                        $result[] = $line;
                    }
                }

                $medicalNoteDetails['transcription'] =  implode("\n", $result);
            }else{
                $tabs = [
                    ['id' => 'summary', 'label' => 'Notes', 'icon' => 'summarize', 'active' => true],
                    ['id' => 'transcription-subjective', 'label' => 'Subjective', 'icon' => 'note_alt'],
                    ['id' => 'transcription-objective', 'label' => 'Objective', 'icon' => 'fact_check'],
                    ['id' => 'transcription-assessment', 'label' => 'Assessment', 'icon' => 'analytics'],
                    ['id' => 'transcription-plan', 'label' => 'Plan', 'icon' => 'playlist_add_check'],
                    ['id' => 'transcription-icd10', 'label' => 'ICD 10', 'icon' => 'healing'],
                ];

                /* get notes icd codes  */
                $notesIcdCodes = MedicalNote::getNotesIcdCodes($medicalNoteDetails['id']);
                $codeIDs = $this->Corefunctions->getIDSfromArray($notesIcdCodes, 'icd10_code_id');

                /* get icd codes  */
                $icd10Codes =  MedicalNote::getIcdCodesByIDs($codeIDs);
            }
            $data['tabs'] = $tabs ;
            $data['icd10Codes'] = $icd10Codes ;
            $data['medicalNoteDetails'] = $medicalNoteDetails ;
            $data['type'] = isset($data['type']) ? $data['type'] : '' ;
          
            $html = view('appointment.notes.details', $data);
            
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['message'] = 'Data fetched successfully';
            return response()->json($arr);
         }
    }


    /** delete notes  */
    public function deleteNotes()
    {
        if(request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            if (($data['medicalnotekey']) == '') {
                return $this->Corefunctions->returnError('Key missing');
            }
          
            $clinicId = session()->get('user.clinicID'); 
            /* get latest medica notes details */
            $medicalNoteDetails = MedicalNote::getMedicalNotesByKey($data['medicalnotekey'],$data['userID'],$clinicId);
            if(empty( $medicalNoteDetails)){
                return response()->json([
                    'error' => '1',
                    'errormsg' => 'Invalid notes' ,
                ]);
            }
            if(isset($medicalNoteDetails['appointment_id']) && $medicalNoteDetails['appointment_id'] != ''){
                $appointment = Appointment::appointmentByID($medicalNoteDetails['appointment_id']);
                if($appointment->is_notes_locked == '1'){
                    return response()->json([
                        'error' => '1',
                        'errormsg' => 'The notes for this appointment are locked and cannot be deleted.' ,
                    ]);
                }
            }
        
            /** delete */
           MedicalNote::deleteMedicalNotes($medicalNoteDetails['id'],session('user.userID'));
          
            $arr['success'] = 1;
            $arr['message'] = 'Notes deleted successfully';
            return response()->json($arr);
        }
    }

   
    
    /** save notes  */
    public function updateNotes()
    {
        if(request()->ajax()) {
            $data = request()->all();
            // Check if form data is empty
            if (empty($data)) {
                return $this->Corefunctions->returnError('Fields missing');
            }
            
            $clinicId = session()->get('user.clinicID'); 
            if (($data['medicalnotekey']) == '') {
                return $this->Corefunctions->returnError('Key missing');
            }
          
            $clinicId = session()->get('user.clinicID'); 
            /* get latest medica notes details */
            $medicalNoteDetails = MedicalNote::getMedicalNotesByKey($data['medicalnotekey'],$data['userID'],$clinicId);
            if(empty( $medicalNoteDetails)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid notes' ,
                ]);
            }
            // Parse form data from serialized input
            parse_str($data['formData'], $input);

           
            /** insert to medicat noyes */
            $medicalNoteID = MedicalNote::updateMedicalNotes($input,session('user.userID'),$data['medicalnotekey']);


            /** delete existing icd code  */
            $notesIcdCodes = MedicalNote::getNotesIcdCodes($medicalNoteDetails['id']);
            $dbIcdIDS      = $this->Corefunctions->getIDSfromArray($notesIcdCodes, 'icd10_code_id' );
            $formIcdIDS = array();
            if( isset( $input['exisicdcode'] ) && !empty( $input['exisicdcode'] ) ){
                foreach ( $input['exisicdcode'] as $lk => $icd) {
                
                        $formIcdIDS[] = $icd['icd'];
                }
            }
            $toDelete= array_diff($dbIcdIDS , $formIcdIDS );
            if(  !empty( $toDelete ) ){
                foreach ( $toDelete as $icd => $code ) {
                    MedicalNote::deleteIcdCode($code,$medicalNoteDetails['id']);
                }
            }



            if(isset($input['icd10_code_values']) && $input['icd10_code_values'] !=''){
                /* get icd 10 codes  */
                $icdcodesIDS = RefIcd10Code::geticdcodes($input['icd10_code_values']);
                /** inset to medical note codes */
                /** deactivete previus codes */
                  DB::table('medical_notes_icd10_codes')->where('medical_note_id',$medicalNoteDetails['id'])->update(array(
                    'deleted_at' => Carbon::now(),
                ));
                if(!empty($icdcodesIDS)){
                    foreach($icdcodesIDS as $codes){
                        $icd10 = MedicalNote::insertMedicalNoteIcd10Codes($medicalNoteDetails['id'],$codes['id']);
                    }
                  
                }
            }
            
           


            $arr['success'] = 1;
            $arr['message'] = 'Notes updated successfully';
            return response()->json($arr);
        }
    }

}
