<?php

namespace App\Http\Controllers\clinics;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Consultant;
use App\Models\Patient;
use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\RefDesignation;
use App\Models\Appointment;
use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use File;

class DoctorsController extends Controller
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
            if (!$sessionCeck) {
                return Redirect::to('/logout');
            }
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
            return $next($request);
        });
    }

 


  
    public function import(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            $html = view('doctors.import', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
    public function importDoctors(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                try {
                    // Load the uploaded file
                    $file = $request->file('file');
                    $spreadsheet = IOFactory::load($file->getPathname()); // Load the spreadsheet
                    $sheet = $spreadsheet->getActiveSheet(); // Retrieve the active sheet
                    $data = $sheet->toArray(); // Convert the sheet to an array

                    $validRecords = []; // For valid records
                    $errorRecords = []; // For records with errors (existing emails)

                    // Check if the file contains valid data (excluding headers and empty rows)
                    $nonEmptyRows = array_filter($data, function ($row) {
                        // Skip rows with no content
                        return !empty(array_filter($row));
                    });
                    // Define the required columns
                    $requiredColumns = ['name', 'email', 'designation', 'specialty', 'qualification', 'phone', 'country code'];
                    $headers = array_map('strtolower', $data[0]);
                    // Get the first row as headers

                    // Check if all required columns are present
                    $missingColumns = array_diff($requiredColumns, $headers);

                    // If any required columns are missing, return an error
                    if (!empty($missingColumns)) {
                        $arr['error'] = 1;
                        $arr['message'] = 'The uploaded file is missing the following columns: ' . implode(', ', $missingColumns);
                        return response()->json($arr);
                    }
                    // If only the header or empty file, return error message
                    if (count($nonEmptyRows) <= 1) { // Assuming the first row is the header
                        $arr['error'] = 1;
                        $arr['message'] = 'The uploaded file does not contain any valid data.';

                        return response()->json($arr);
                    }
                    $importDocIDs = array();
                    $import_key = $this->Corefunctions->generateUniqueKey('10', 'import_docs', 'import_key');
                    foreach ($data as $index => $row) {

                        if ($index === 0 || empty(array_filter($row))) {
                            continue; // Skip header or empty rows
                        }
                        $countrycode = isset($row[6]) ? trim($row[6]) : '';
                        $countryCodedetails = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id')->where('country_code', '+' . $countrycode)->orderBy('id', 'desc')->first());

                        $insertArr = array();
                        $insertArr['import_doc_uuid'] = $this->Corefunctions->generateUniqueKey("10", "import_docs", "import_doc_uuid");
                        $insertArr['name'] = isset($row[0]) ? trim($row[0]) : ''; // Adjust according to the column index
                        $insertArr['email'] = isset($row[1]) ? trim($row[1]) : '';
                        $insertArr['designation'] = isset($row[2]) ? trim($row[2]) : '';
                        $insertArr['designationName'] = isset($row[2]) ? trim($row[2]) : '';
                        $insertArr['specialty'] = isset($row[3]) ? trim($row[3]) : '';
                        $insertArr['qualification'] = isset($row[4]) ? trim($row[4]) : '';
                        $insertArr['Phone_number'] = isset($row[5]) ? trim($row[5]) : '';
                        $insertArr['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['id'] : null;
                        $insertArr['userID'] = session()->get('user.userID');
                        $insertArr['type'] = 1;

                        $designation = $this->Corefunctions->convertToArray(DB::table('ref_designations')->where('type', 'doctor')->select('name', 'id')->whereRaw('LOWER(name) = ?', [strtolower($insertArr['designation'])])->first());
                        $insertArr['designation'] = !empty($designation) ? $designation['id'] : null;

                        $specialties = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->whereRaw('LOWER(specialty_name) = ?', [strtolower($insertArr['specialty'])])->first());
                        $insertArr['specialty'] = !empty($specialties) ? $specialties['id'] : null;

                        // Check if email exists in users table
                        $existingDoctr = ClinicUser::where('phone_number', $insertArr['Phone_number'])->where('user_type_id', '2')->where('clinic_id', session()->get('user.clinicID'))->first();
                        // if (!empty($existingUser) ) {
                        $insertArr['error'] = '';

                        /** Check all fields are exists */
                        foreach ($requiredColumns as $columnName) {
                            $columnIndex = array_search($columnName, $headers);
                            $rowData[$columnName] = isset($row[$columnIndex]) ? trim($row[$columnIndex]) : null;
                            if (empty($rowData[$columnName])) {
                                $insertArr['status'] = '-1';
                                $insertArr['error'] .= 'The uploaded file does not contain valid data for ' . $columnName . '. ';
                                $errorRecords[] = $insertArr;

                                $isRecordValid = false; // Mark record as invalid
                                break; // Exit the loop and go to the next record
                            }
                        }

                        if (!empty($existingDoctr) && (($existingDoctr['phone_number'] == $insertArr['Phone_number']) || ($existingDoctr['email'] == $insertArr['email']))) {
                            // If email exists, add to error records
                            // $insertArr['status']            = '-1';
                            $insertArr['is_exists'] = 1;
                            $insertArr['error'] .= 'User already exist with the same email or phone number.';

                        }
                        if (empty($designation)) {
                            $insertArr['status'] = '-1';
                            $insertArr['error'] .= 'Provided designation is not in our system.';
                        }
                        if (empty($specialties)) {
                            $insertArr['status'] = '-1';
                            $insertArr['error'] .= 'Provided specialty is not in our system.';
                        }
                        if (empty($countryCodedetails)) {
                            $insertArr['status'] = '-1';
                            $insertArr['error'] .= 'Invalid country code details are entered.';
                        }

                        $importDocID = Consultant::insertConsultantExcelData($insertArr, $import_key, session()->get('user.clinicID'));

                    }

                    // Return a preview page with both valid and error records
                    $arr['success'] = 1;
                    $arr['message'] = 'Preview the uploaded file.';
                    $arr['import_key'] = $import_key;

                    return response()->json($arr);
                } catch (\Exception $e) {
                    // Rollback the transaction in case of an error
                    DB::rollBack();
                    return response()->json(['error' => 'Error importing doctors: ' . $e->getMessage()], 500);
                }
            }
        }
    }

    public function excelPreview($importKey)
    {
        return view('doctors.excelpreview', compact('importKey'));
    }

    public function importPreview(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }
            $importKey = $data['importKey'];

            /** Get the imported exel data  */
            $excelDetails = DB::table('import_docs')->where('import_key', $importKey)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at');
            if (isset($data['lastExportID']) && ($data['lastExportID'] != '0')) {
                $excelDetails = $excelDetails->where('id', '<', $lastClientID);
            }
            $excelDetails = $excelDetails->orderBY('id', 'desc')->limit(10)->get();
            $excelDetails = $this->Corefunctions->convertToArray($excelDetails);

            $lastExportID = 0;
            $hasdata = 0;
            if (!empty($excelDetails)) {
                foreach ($excelDetails as $cdkey => $cdvalue) {
                    $lastExportID = $cdvalue['id'];
                }
                $hasdata = 1;
            }

            /** get designation ids  */
            $designationIds = $this->Corefunctions->getIDSfromArray($excelDetails, 'designation_id');
            $designationDeatils = $this->Corefunctions->convertToArray(DB::table('ref_designations')->whereIn('id', $designationIds)->select('name', 'id')->get());
            $designationDeatils = $this->Corefunctions->getArrayIndexed1($designationDeatils, 'id');

            /** get specialty ids  */
            $specialtyIds = $this->Corefunctions->getIDSfromArray($excelDetails, 'specialty_id');
            $specialtyDetails = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->whereIn('id', $specialtyIds)->select('specialty_name', 'id')->get());
            $specialtyDetails = $this->Corefunctions->getArrayIndexed1($specialtyDetails, 'id');

            /** get countryIds */
            $countrycodeIds = $this->Corefunctions->getIDSfromArray($excelDetails, 'country_code');
            $countryCodedetails = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('country_code', 'id')->whereIn('id', $countrycodeIds)->whereNull('deleted_at')->get());
            $countryCodedetails = $this->Corefunctions->getArrayIndexed1($countryCodedetails, 'id');

            $data['lastExportID'] = $lastExportID;
            $data['designationDeatils'] = $designationDeatils;
            $data['specialtyDetails'] = $specialtyDetails;
            $data['excelDetails'] = $excelDetails;
            $data['importKey'] = $importKey;
            $data['countryCodedetails'] = $countryCodedetails;

            $html = view('doctors.preview', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['hasdata'] = $hasdata;
            return response()->json($arr);
            exit();
        }
    }

    /** Store imported data of doctors */

    public function storePreview(Request $request)
    {

        if ($request->ajax()) {

            $data = request()->all();

            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Data missing',
                ]);
            }

            $importDocList = $this->Corefunctions->convertToArray(DB::table('import_docs')->where('status', '0')->where('import_key', $data['importKey'])->whereNull('deleted_at')->get());

            if (!empty($importDocList)) {
                foreach ($importDocList as $index => $row) {
                    $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');

                    $userDetails = User::where('phone_number', $row['phone_number'])->whereNull('deleted_at')->first();
                    $clinicUser = ClinicUser::where('clinic_id', session()->get('user.clinicID'))->where('phone_number', $row['phone_number'])->whereNull('deleted_at')->first();

                    if (!empty($userDetails)) {
                        $userID = $userDetails->id;
                        /** if the importred user already exists then update the user details */
                        if ($row['is_exists'] == '1') {
                            $userDetails->first_name = $row['name'];
                            $userDetails->email = $row['email'];
                            $userDetails->update();
                            $userID = $userDetails->id;
                        }
                    }
                    if (!empty($clinicUser)) {

                        if ($row['is_exists'] == '1') {
                            $clinicUser->name = $row['name'];
                            $clinicUser->phone_number = isset($row['phone_number']) ? $row['phone_number'] : null;
                            $clinicUser->email = $row['email'];
                            $clinicUser->designation_id = isset($row['designation_id']) && $row['designation_id'] != '' ? $row['designation_id'] : null;
                            $clinicUser->specialty_id = $row['specialty_id'];
                            $clinicUser->qualification = $row['qualification'];
                            $clinicUser->country_code = isset($row['country_code']) && $row['country_code'] != '' ? $row['country_code'] : null;
                            $clinicUser->update();
                        }
                    } else {

                        /** Inset clinic users Consultant info  */
                        $clinicUseruuid = $this->Corefunctions->generateUniqueKey("10", "clinic_users", "clinic_user_uuid");
                        $clinicUserObject = new ClinicUser();
                        $clinicUserObject->clinic_user_uuid = $clinicUseruuid;
                        $clinicUserObject->name = $row['name'];
                        $clinicUserObject->phone_number = isset($row['phone_number']) ? $row['phone_number'] : null;
                        $clinicUserObject->email = $row['email'];
                        $clinicUserObject->designation_id = isset($row['designation_id']) && $row['designation_id'] != '' ? $row['designation_id'] : null;
                        $clinicUserObject->specialty_id = $row['specialty_id'];
                        $clinicUserObject->qualification = $row['qualification'];
                        $clinicUserObject->created_by = session()->get('user.userID');
                        $clinicUserObject->clinic_id = session()->get('user.clinicID');
                        $clinicUserObject->user_type_id = 2;
                        $clinicUserObject->status = '-1';
                        $clinicUserObject->invitation_key = 'c_' . $invitationkey;
                        $clinicUserObject->country_code = isset($row['country_code']) && $row['country_code'] != '' ? $row['country_code'] : null;
                        $clinicUserObject->user_id = isset($userID) ? $userID : null;

                        $clinicUserObject->save();
                        $doctorID = $clinicUserObject->id;

                        /** Invitation mail */
                        $clinic = Clinic::where('id', session()->get('user.clinicID'))->first();
                        $data['clinic'] = $clinic->name;
                        $data['name'] = $row['name'];
                        $data['email'] = $row['email'];
                        $data['link'] = url('invitation/' . 'c_' . $invitationkey);

                        $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.doctorinvitation');
                    }

                }
            }

            // Return a preview page with both valid and error records
            $arr['success'] = 1;
            $arr['message'] = 'Doctor file imported successfully';

            return response()->json($arr);

        }
    }

    public function previewDetails(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }
            $importKey = $data['importKey'];

            /** Get the imported exel data  */
            $excelDetails = $this->Corefunctions->convertToArray(DB::table('import_docs')->where('import_doc_uuid', $importKey)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());

            $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::where('phone_number', $excelDetails['phone_number'])->whereNull('deleted_at')->first());

            /** check with email id */
            if (empty($clinicUser)) {
                $clinicUser = $this->Corefunctions->convertToArray(ClinicUser::where('clinic_id', session()->get('user.clinicID'))->where('email', $excelDetails['email'])->whereNull('deleted_at')->first());
            }
            $designation = $this->Corefunctions->convertToArray(DB::table('ref_designations')->select('name', 'id')->get());
            $designation = $this->Corefunctions->getArrayIndexed1($designation, 'id');

            $data['clinicUser'] = $clinicUser;
            $data['excelDetails'] = $excelDetails;
            $data['designation'] = $designation;

            $html = view('doctors.previewdetails', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

    /** delete imported data of doctors */
    public function deleteDoc(Request $request)
    {
        if ($request->ajax()) {

            $data = request()->all();
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Data missing',
                ]);
            }

            $importDocList = $this->Corefunctions->convertToArray(DB::table('import_docs')->where('import_doc_uuid', $data['importKey'])->whereNull('deleted_at')->first());
            if (empty($importDocList)) {
                $arr['success'] = 0;
                $arr['message'] = 'Invalid records.';
                return response()->json($arr);
            }
            DB::table('import_docs')->where('import_doc_uuid', $data['importKey'])->update(array(
                'deleted_at' => Carbon::now(),
            ));
            $arr['success'] = 1;
            $arr['message'] = 'Records removed successfully';
            return response()->json($arr);
            // Return a preview page with both valid and error records

        }
    }

    public function downloadSampleDoc()
    {
        $filename = "Doctor_Sample_Doc.xlsx";
        $headers = array(
            'Content-Type: application/excel',
        );
        $docppath = SAMPLEPATH . 'Doctor_Sample_Doc.xlsx';

        return response()->download($docppath, $filename, $headers);
    }

    public function details($key)
    {

        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
        /** get doctors Details */
        $doctorDetails = $this->Corefunctions->convertToArray(ClinicUser::with('user')->where('clinic_user_uuid', $key)
                ->whereIn('user_type_id', ['1','2'])->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->with('doctorSpecialty')->first());

        $doctorDetails = $this->Corefunctions->convertToArray($doctorDetails);
        if (empty($doctorDetails)) {
            return redirect('/users');
        }
        $doctorDetails['logo_path'] = ($doctorDetails['logo_path'] != '') ? $this->Corefunctions->getAWSFilePath($doctorDetails['logo_path']) : '';
        /** get designation data */
        $designationDeatils = $this->Corefunctions->convertToArray(DB::table('ref_designations')->select('name', 'id')->where('id', $doctorDetails['designation_id'])->first());
        $designation = !empty($designationDeatils) ? $designationDeatils['name'] : '--';

        /** get countryCodeDetails */
        $countryCodeDetails = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('country_code', 'id')->where('id', $doctorDetails['country_code'])->first());
        $seo['title'] = "User Details  | " . env('APP_NAME');
        
        return view('doctors.details', compact('doctorDetails','seo', 'designation', 'countryCodeDetails'));
    }

    public function resendInvitation(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }

            $clinicdoctorDetails = ClinicUser::where('clinic_user_uuid', $data['key'])->first();
            if (empty($clinicdoctorDetails)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Invalid Data',
                ]);
            }
            $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');

            $clinicdoctorDetails->invitation_key = 'c_' . $invitationkey;
            $clinicdoctorDetails->status = '-1';
            $clinicdoctorDetails->update();
            $clinic = Clinic::where('id', session()->get('user.clinicID'))->first();

            /** Invitation mail */

            $data['clinic'] = $clinic->name;
            /** Invitation mail */
            $data['name'] = $clinicdoctorDetails->first_name.' '.$clinicdoctorDetails->last_name;
            $data['email'] = $clinicdoctorDetails->email;
            $data['link'] = url('invitation/' . 'c_' . $invitationkey);

            $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.doctorinvitation');

            $arr['response'] = $response;
            $arr['success'] = 1;
            $arr['message'] = 'Invitation resent successfully';
            return response()->json($arr);
            exit();
        }
    }

    public function delete()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                $arr['error'] = 1;
                $arr['errormsg'] = 'Fields missing';
                return response()->json($arr);
                exit();
            }
            if ($data['status'] == 'activate') {
                ClinicUser::onlyTrashed()->where('clinic_user_uuid', $data['key'])->restore();
                $arr['message'] = 'Doctor activated successfully.';
            } else {
                $docclinic = ClinicUser::where('clinic_user_uuid', $data['key'])->first();
                $docclinic->delete();

                $arr['message'] = 'Doctor deactivated successfully.';
            }

            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }
   



    //Appointment List Function not needed 
    public function appointmentList()
    {
        if (request()->ajax()) {
            $data = request()->all();

            // Check if form data is empty
            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing',
                ]);
            }
            // Default limit
            $limit = isset($data['limit']) ? intval($data['limit']) : 10;

            $userTimeZone = session()->get('user.timezone');
            $status = $data['status'];
            $page = $data['page'];

            $consultantKey = $data['consultantKey'];
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
            $fullpermission = '1';
            if ($consultantKey != $clinicuser_uuid && session()->get('user.userType') == 'doctor') {
                $fullpermission = '0';
            }
            $doctorDetails = ClinicUser::getClinicUserWithUserKey($consultantKey);

            if (empty($doctorDetails)) {
               return $this->Corefunctions->returnError('Invalid details');
            }
            
            $field = ($doctorDetails->user_type_id == 3) ? 'nurse_id' : 'consultant_id' ;
            $appointmentRecords =   Appointment::getPatientAppointmentList(session()->get('user.clinicID'),$userTimeZone, $doctorDetails->user_id,$status,$limit,$page,$field);

            //  // Initialize the query for online records
            // $appointmentRecords = Appointment::where('clinic_id', session()->get('user.clinicID'))->where('status', '1')->where($field, $doctorDetails->user_id)->whereIn('appointment_type_id', ['1','2']);
            // $appointmentRecords = $appointmentRecords->orderBy('appointment_date', 'asc')->orderBy('appointment_time', 'asc');
            
            // $openCount = (clone $appointmentRecords)
            //     ->where('is_completed', '0')
            //     ->where(function ($query) use ($userTimeZone) {
            //     $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
            //         ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            // })->count();
            // $receptionCount = (clone $appointmentRecords)
            //     ->where('is_completed', '0')
            //     ->where('reception_waiting', '1')
            //     ->count();
            // $cancelledCount = (clone $appointmentRecords)->onlyTrashed()->count();
            // $completedCount = (clone $appointmentRecords)->where('is_completed', '1')->count();

            // if ($status == 'open') {
            //     $appointmentRecords->where('is_completed', '0')->where(function ($query) use ($userTimeZone) {
            //         $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
            //               ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            //     });
            // } elseif ($status == 'reception') {
            //     $appointmentRecords->where('is_completed', '0')->where('reception_waiting', '1');
            // } elseif ($status == 'cancelled') {
            //     $appointmentRecords->onlyTrashed();
            // } elseif ($status == 'completed') {
            //     $appointmentRecords->where('is_completed', '1');
            // }

            // $appointmentRecords = $appointmentRecords->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $page);

            $openCount = $appointmentRecords['openCount'] ;
            $receptionCount = $appointmentRecords['receptionCount'] ;
            $cancelledCount = $appointmentRecords['cancelledCount'] ;
            $completedCount = $appointmentRecords['completedCount'] ;
            $perPage = $appointmentRecords['perPage'] ;
            $appointmentRecords = $appointmentRecords['appointments'];

            $appointmentRecordDetails = $this->Corefunctions->convertToArray($appointmentRecords);

            /** get nurse details for appointments */
            $nurseIds = $this->Corefunctions->getIDSfromArray($appointmentRecordDetails['data'], 'nurse_id');
            $nurseDetails = ClinicUser::with('user')->where('clinic_id', session()->get('user.clinicID'))->where('user_type_id', '3')->whereIn('user_id', $nurseIds)->withTrashed()->get();
            $nurseDetails = $this->Corefunctions->convertToArray($nurseDetails);
            $nurseDetails = $this->Corefunctions->getArrayIndexed1($nurseDetails, 'user_id');

            /** patientlist */
            $patientIds = $this->Corefunctions->getIDSfromArray($appointmentRecordDetails['data'], 'patient_id');
            $patientDetails = Patient::getPatientByUserID($patientIds,session()->get('user.clinicID'),'appoinment');
            $patientDetails = $this->Corefunctions->convertToArray($patientDetails);
            $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'user_id');
            
            $data['patientDetails'] = $patientDetails;
            $data['appointmentRecords'] = $appointmentRecordDetails['data'];
            $data['appointmentRecordList'] = $appointmentRecords;
            $data['nurseDetails'] = $nurseDetails;
            $data['consultantKey'] = $consultantKey;
            $data['status'] = $data['status'];
            $data['fullpermission'] = $fullpermission;
            $data['limit'] = $limit;
            $data['openCount'] = $openCount;
            $data['receptionCount'] = $receptionCount;
            $data['cancelledCount'] = $cancelledCount;
            $data['completedCount'] = $completedCount;

            $html = view('doctors.appointment_list', $data);
            $arr['view'] = $html->__toString();
            $arr['success'] = 1;
            $arr['pagination'] = $appointmentRecords->links('pagination::bootstrap-4')->render();
            return response()->json($arr);
            exit();

        }
    }

    /** mark as admin */
    public function markAsAdmin()
    {
        if (request()->ajax()) {
            $data = request()->all();
            if (!$data['key']) {
                $response = $this->Corefunctions->returnError('Fields missing');
            }
            if ($data['status'] == '0') {
                $docclinic = ClinicUser::where('clinic_user_uuid', $data['key'])->first();
                $docclinic->is_clinic_admin = '1';
                $docclinic->update();
                $arr['message'] = 'The doctor marked as admin.';
            } else {
                $docclinic = ClinicUser::where('clinic_user_uuid', $data['key'])->where('user_type_id', '2')->first();
                $docclinic->is_clinic_admin = '0';
                $docclinic->update();
                $arr['message'] = 'The doctor remove from admin successfully.';
            }

            $arr['success'] = 1;
            return response()->json($arr);
            exit();
        }
    }

}

