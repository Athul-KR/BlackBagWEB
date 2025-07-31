<?php

namespace App\Http\Controllers\clinics;

use App\Http\Requests\StoreNurseRequest;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\ClinicUser;
use App\Models\Consultant;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\RefCountryCode;
use App\Models\RefDesignation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use File;
// use Illuminate\Support\Facades\File;

class NurseController extends Controller
{

    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->middleware(function ($request, $next) {
            
            if (request()->ajax() && !Session::has('user.userID')) {
                
                return response()->json([
                    'status' => 'expired',
                    'message' => 'Session expired',
                    'reload' => true
                ], 419);
            }
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
                return Redirect::to('/');
            }
            $sessionCeck = $this->Corefunctions->validateUser();

            if (!$sessionCeck) {
                return Redirect::to('/logout');
            }
            if (session()->has('user') == false) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login');
            }
            return $next($request);
        });
    }

    //Listing function
    public function list($status = 'active')
    {
        if(session()->get('user.userType') == 'patient' ){
            return Redirect::to('/dashboard');
        }
        if (!in_array($status, ['active', 'inactive', 'available', 'pending', 'not-available'])) {
            return back()->with('error', 'Invalid status provided! Please try again');
        }

        $clinicId = session()->get('user.clinicID'); // get logged in clinic id
        $clinic = Clinic::find($clinicId); //getting the clinic using clinic id

        if (empty($clinic)) {
            return back()->with('error', "Access available for clinics only .Invalid clinic details or not found!");
        }

        $type = request('type');

        // Base query for counting all statuses
        $countQuery = ClinicUser::with(['creator','doctorSpecialty'])->where('user_type_id', '3')->where('clinic_id', $clinicId);

        // Get counts for all statuses
        $pendingCount = (clone $countQuery)->whereIn('status', ['-1', '0']);
        $activeCount = (clone $countQuery)->where('status', '1');
        $inactiveCount = (clone $countQuery)->onlyTrashed();
        if ($type) {
            if ($type == 'available') {
                $pendingCount = $pendingCount->where('login_status', '1');
                $activeCount = $activeCount->where('login_status', '1');
                $inactiveCount = $inactiveCount->where('login_status', '1');
            } elseif ($type == 'not-available') {
                $pendingCount = $pendingCount->where('login_status', '0');
                $activeCount = $activeCount->where('login_status', '0');
                $inactiveCount = $inactiveCount->where('login_status', '0');
            }
        }
        $pendingCount = $pendingCount->count();
        $activeCount = $activeCount->count();
        $inactiveCount = $inactiveCount->count();

        // Main query for fetching nurses based on selected status
        $query = ClinicUser::with(['creator'])->where('user_type_id', '3')->where('clinic_id', $clinicId);

        // Define status conditions based on the input status
        $statusConditions = [
            'inactive' => function ($q) {
                $q->onlyTrashed();
            },
            'pending' => function ($q) {
                $q->whereIn('status', ['-1', '0']);
            },
        ];

        if ($type == 'available') {
            $query->where('login_status', '1');
        } elseif ($type == 'not-available') {
            $query->where('login_status', '0');
        }


        // Apply the status condition if it exists in the array
        if (array_key_exists($status, $statusConditions)) {
            $statusConditions[$status]($query);
        } else {
            // Default to active status if not one of the specified statuses
            $query->where('status', '1');
        }

        // $activeCount = $query->count();
        // dd($activeCount);

        try {
            // Get the number of items per page from the request, default to 10
            $perPage = request()->get('perPage', 10);

            // Retrieve the paginated data
            $nurses = $query->latest()->paginate($perPage);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('nurses.listing')->with('error', 'Something went wrong! Nurse Model not found');
        }
        $seo['title'] = "Nurses | " . env('APP_NAME');
        $seo['keywords'] = "Certified Nurses for Care, Nurse Departments, Nursing Services, Healthcare Nurses, Health Care Nursing Professionals, Active Nurses, Nurse Availability, General Nurse Services, Nurse Search Online, Nurse Availability Status, Nurse Profiles Management, Nursing Specializations, Patient Care Nurses";
        $seo['description'] = "Find qualified and experienced nurses across various specialties with ease. Ideal for patients and healthcare facilities seeking reliable and qualified nursing staff";                  
        $seo['og_title'] = "Nurses | " . env('APP_NAME');
        $seo['og_description'] = "Find qualified and experienced nurses across various specialties with ease. Ideal for patients and healthcare facilities seeking reliable and qualified nursing staff"; 
        
        return view('nurses.listing', compact('nurses','status','type','perPage','activeCount','pendingCount','inactiveCount','seo'));
    }

    //Create Function
    public function create()
    {
        if (request()->ajax()) {
            $data = request()->all();
            $designations = DB::table('ref_designations')->select('name', 'id')->where('type', 'nurse')->get();
            $designationDetails = json_decode($designations, true);

            $specialties = DB::table('ref_specialties')->select('id', 'specialty_name')->get();

            $data['specialties'] = $specialties;
            $data['designation'] = $designationDetails;
            $html = view('nurses.create', $data)->render();
            $arr['view'] = $html;
            $arr['status'] = 1;
            return response()->json($arr);
        }
    }



    //Store Function
    public function store(Request $request)
    {
        //Validation Check
        $validatedData = $request->all();
        $clinicUserUuid = $this->Corefunctions->generateUniqueKey("10", "clinic_users", "clinic_user_uuid"); //generate uuid
        $userId = session()->get('user.userID'); // get logged in user id
        $clinicId = session()->get('user.clinicID'); // get logged in clinic id
        $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');

        // Fetch country ID from ref_country_codes table
        $countryCode = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id', 'short_code')->where('short_code', request('countryCodeShort'))->first());

        $countryCode = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id')->where('short_code', $validatedData['countrycode'])->first());
        $userDetails = $this->Corefunctions->convertToArray(User::where('email', $validatedData['email'])->where('phone_number', $validatedData['phone_number'])->where('country_code', $countryCode['id'])->first());

        if (empty($userDetails)) {
            $userDetails = $this->Corefunctions->convertToArray(User::where('email', $validatedData['email'])->first());
            if (empty($userDetails)) {
                $userDetails = $this->Corefunctions->convertToArray(User::where('phone_number', $validatedData['phone_number'])->where('country_code', $countryCode['id'])->first());
                if (!empty($userDetails)) {
                    return redirect()->back()->with('error', 'The user have different email exist with this phone number.');
                }
            } else {
                return redirect()->back()->with('error', 'The user has a different phone number associated with this email.');
            }
        }
        $clinicuserDetails = $this->Corefunctions->convertToArray(ClinicUser::where('email', $validatedData['email'])->where('phone_number', $validatedData['phone_number'])->where('country_code', $countryCode['id'])->where('clinic_id', session()->get('user.clinicID'))->first());
        if (!empty($clinicuserDetails)) {
            return redirect()->back()->with('error', 'User already exist.');
        }
        try {
            // Creating Clinic Nurse
            $clinicUserObject = new ClinicUser();
            $clinicUserObject->clinic_user_uuid = $clinicUserUuid;
            $clinicUserObject->clinic_id = session()->get('user.clinicID');
            $clinicUserObject->user_type_id = 3;
            $clinicUserObject->user_id = !empty($userDetails) ? $userDetails['id'] : null;
            $clinicUserObject->status = '-1';
            $clinicUserObject->name = $validatedData['name'];
            $clinicUserObject->email = $validatedData['email'];
            $clinicUserObject->phone_number = $validatedData['phone_number'];
            $clinicUserObject->department = $validatedData['department'];
            $clinicUserObject->country_code = $countryCode['id'];
            $clinicUserObject->qualification = $validatedData['qualification'];
            $clinicUserObject->specialty_id = $validatedData['specialties'];
            $clinicUserObject->created_by = $userId;
            $clinicUserObject->invitation_key = 'c_'.$invitationkey;
            $clinicUserObject->save();
            $nurseID = $clinicUserObject->id;

            /* Nurse Image Upload */
            if (request('tempimage') != "") {
                /* Temp Image Details */
                $tempImageDetails = DB::table("temp_docs")->where("tempdoc_uuid", request('tempimage'))->first();
                if (!empty($tempImageDetails)) {
                    $originalpath = "storage/app/public/tempImgs/original/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
                    $croppath = "storage/app/public/tempImgs/crop/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
                    $crppath = 'nurses/' . $clinicUserUuid . '.' . $tempImageDetails->temp_doc_ext;
                    $image_path = $tempImageDetails->tempdoc_uuid . '.' . $tempImageDetails->temp_doc_ext;
                    $image_path = File::get($croppath);
                    if ($this->Corefunctions->uploadDocumenttoAWS($crppath, $image_path)) {
                        $image_path = $crppath;
                        DB::table('clinic_users')->where('id', $nurseID)->update(array(
                            'logo_path' => $image_path,
                        ));
                    }
                    unlink($croppath);
                }
            }


            $data['email'] = $validatedData['email'];
            $data['name'] = $validatedData['name'];
            $clinic = Clinic::clinicByID(session()->get('user.clinicID'));

            /** Invitation mail */
            $data['clinic'] = $clinic->name;
            $data['link'] = url('invitation/' . 'c_'.$invitationkey);
            $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.nurse-invitation');
            return redirect()->route('nurse.list')->with('success', 'Nurse created and invitation sent successfully!');
        } catch (\Exception $e) {
            // Handle the error and provide feedback to the user
            return redirect()->back()->with('error', 'Failed to create nurse: ' . $e->getMessage());
        }
    }


    // Edit Nurse Function
    public function edit($uuid)
    {
        if (!$uuid) {
            return redirect()->route('nurse.list')->with('error', 'Cannot edit Invalid uuid!');
        }
        $type = request('type');
        $nurse = ClinicUser::with(['user'])->where('clinic_user_uuid', $uuid)->first(); //getting data using uuid

        if (empty($nurse)) {
            return redirect()->route('nurse.list')->with('error', 'Cannot edit, unable to find nurse!');
        }

        $designation = RefDesignation::select('name', 'id')->where('type', 'nurse')->get();


        // Fetch country ID from ref_country_codes table
        $countryCode = $this->Corefunctions->convertToArray(
            DB::table('ref_country_codes')
                ->select('id', 'short_code', 'country_code')
                ->where('id', $nurse->country_code)
                ->first()
        );

        $specialties = DB::table('ref_specialties')
            ->select('id', 'specialty_name')->whereNull('deleted_at')->get();


        if($nurse['status'] == '1'){
            $nurse['logo_path'] =  $this->Corefunctions->resizeImageAWS($nurse['user_id'],$nurse['user']['profile_image'],$nurse['user']['first_name'],180,180,'1');

        }else{
            $nurse['logo_path'] = $this->Corefunctions-> resizeImageAWS($nurse['id'],$nurse['logo_path'],$nurse['name'],180,180,'1');
        }
        // dd($nurse);

        $html = view('nurses.edit', compact('nurse', 'designation', 'type', 'countryCode', 'specialties'))->render();
        $arr['view'] = $html;
        $arr['status'] = 1;
        return response()->json($arr);
    }


     //Update Nurse Function
    public function update(Request $request, $uuid)
    {
        // dd(request()->all());
        //Validation Check
        $validatedData = request()->all();
        $nurse = ClinicUser::where('clinic_user_uuid', $uuid)->first();
        if (empty($nurse)) {
            return redirect()->route('nurse.list')->with('error', 'Invalid or nurse not found!');
        }

        // Fetch country ID from ref_country_codes table
        $countryCode = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id', 'short_code')->where('short_code', strtoupper(request('countryCodeShort')))->first());
        $countryCode = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id')->where('short_code', $validatedData['countrycode'])->first());
        $userDetails = $this->Corefunctions->convertToArray(User::where('email', $validatedData['email'])->where('phone_number', $validatedData['phone_number'])->where('country_code', $countryCode['id'])->first());

        if (empty($userDetails)) {
            $userDetails = $this->Corefunctions->convertToArray(User::where('email', $validatedData['email'])->first());
            if (empty($userDetails)) {
                $userDetails = $this->Corefunctions->convertToArray(User::where('phone_number', $validatedData['phone_number'])->where('country_code', $countryCode['id'])->first());
                if (!empty($userDetails)) {
                    return redirect()->back()->with('error', 'The user have different email exist with this phone number.');
                }
            } else {
                return redirect()->back()->with('error', 'The user has a different phone number associated with this email.');
            }
        }
        $clinicuserDetails = $this->Corefunctions->convertToArray(ClinicUser::where('email', $validatedData['email'])->where('phone_number', $validatedData['phone_number'])->where('country_code', $countryCode['id'])->where('clinic_id', session()->get('user.clinicID'))->where('clinic_user_uuid', '!=',$uuid)->first());
        if (!empty($clinicuserDetails)) {
            return redirect()->back()->with('error', 'User already exist.');
        }
      
        $crppath = (isset($nurse->logo_path) && ($nurse->logo_path != '')) ? $nurse->logo_path : '';
        if (request('isremove') == 1) {
            $crppath = '';
        }

        $nurse->name = $validatedData['name'];
        $nurse->email = $validatedData['email'];
        $nurse->phone_number = $validatedData['phone_number'];
        $nurse->department = $validatedData['department'];
        $nurse->qualification = $validatedData['qualification'];
        $nurse->specialty_id = $validatedData['specialties'];
        $nurse->country_code = $countryCode['id'];
        $nurse->created_by = session()->get('user.userID');
        $nurse->logo_path = $crppath;
        $nurse->update();
        if (session::get('user.userType') == 'nurse' && session()->get('user.userID') == $nurse->user_id) {
            $nameParts = explode(' ', trim($validatedData['name']));
            // Assign the first part as the first name
            $firstName = array_shift($nameParts);
            // Combine the remaining parts as the last name
            $lastName = implode(' ', $nameParts);

            session()->put('user.firstName', $firstName);
            session()->put('user.lastName', $lastName);
            session()->put('user.email', $validatedData["email"]);
            session()->put('user.phone', $validatedData["phone_number"]);
            session()->put('user.userLogo', $crppath);
        }
        DB::table('users')->where('id', $nurse->user_id)->update(array(
            'profile_image' => $crppath,
        ));
        /* nurse Image Upload */
        if (request('tempimage') != "") {
            /* Temp Image Details */
            $tempImageDetails = DB::table("temp_docs")->where("tempdoc_uuid", request('tempimage'))->first();
            if (!empty($tempImageDetails)) {
               

               
                    $originalpath = "storage/app/public/tempImgs/original/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
                    $croppath = "storage/app/public/tempImgs/crop/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
                    //$crppath = 'users/' . $clinicUserDetails->clinic_user_uuid . '.' . $tempImageDetails->temp_doc_ext;
                    $crppath = $this->Corefunctions->getMyPathForAWS($nurse->id, $tempImageDetails->tempdoc_uuid, $tempImageDetails->temp_doc_ext, 'users/');
                    // $crppath = $this->Corefunctions->getMyPathForAWS($nurse->id,$nurse->clinic_user_uuid,$tempImageDetails->temp_doc_ext,'users/');
                    $image_path = $tempImageDetails->tempdoc_uuid . '.' . $tempImageDetails->temp_doc_ext;

                    $image_path = File::get($croppath);

                    if ($this->Corefunctions->uploadDocumenttoAWS($crppath, $image_path)) {
                        $image_path = $crppath;
                        DB::table('clinic_users')->where('id', $nurse->id)->update(array(
                            'logo_path' => $image_path,
                        ));
                          if ($nurse->user_id != NULL) {
                                DB::table('users')->where('id', $nurse->user_id)->update(array(
                                    'profile_image' => $image_path,
                                ));
                          }
                    }
                    unlink($croppath);
                


                
            }
        }
        // return redirect()->route('nurse.lists', [$type])->with('success', 'Nurse details updated successfully!');
        return redirect()->back()->with('success', 'Nurse details updated successfully!');
    }

    //View Function
    public function view($uuid)
    {
        $status = request("status");

        if (!$uuid) {
            return redirect()->route('nurse.list')->with('error', 'Invalid uuid!');
        }

        $nurse = ClinicUser::where('clinic_user_uuid', $uuid)->with(['doctorSpecialty','user'])->where('clinic_id',Session::get('user.clinicID'))->first(); //getting data using uuid
        if (empty($nurse)) {
            return redirect()->route('nurse.list');
        }
        if($nurse['status'] == '1'){
            $nurse['logo_path'] =  $this->Corefunctions->resizeImageAWS($nurse['user_id'],$nurse['user']['profile_image'],$nurse['user']['first_name'],180,180,'1');

        }else{
            $nurse['logo_path'] = $this->Corefunctions-> resizeImageAWS($nurse['id'],$nurse['logo_path'],$nurse['name'],180,180,'1');

        }

        if (empty($nurse)) {
            return redirect()->route('nurse.list')->with('error', 'Invalid uuid!');
        }


        //Online Records
        $onlineRecords = Appointment::where([
            ['status', '1'],
            ['nurse_id', $nurse->id],
            ['appointment_date', '>', now()],
        ])
        ->whereIn('appointment_type_id', [1, 2]);

        $countryCode=  DB::table('ref_country_codes')
            ->select('country_code')
            ->where('id', $nurse['country_code'])
            ->first();

        try {
            // Get the number of items per page from the request, default to 10
            $perPage = request()->get('perPage', 10);
            // Retrieve the paginated data
            $appointments = $onlineRecords->latest()->paginate($perPage);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('nurse.list')->with('error', 'Something went wrong! Appointment Model not found');
        }
        $seo['title'] = "User Details  | " . env('APP_NAME');
        return view('nurses.view', compact('nurse', 'seo', 'appointments', 'perPage', 'status','countryCode'));
    }

    //Appointment List Function
    public function appointmentList($uuid)
    {
        $status = request("status");
        $page = request("page");
        // dd($page);
        
        $userTimeZone = session()->get('user.timezone');
        $userType = session()->get('user.userType'); // Get logged in clinic ID
            
        $clinicId = session()->get('user.clinicID'); // Get logged in clinic ID
        $clinic = Clinic::find($clinicId); // Getting the clinic using clinic ID

        $nurse = ClinicUser::where('clinic_user_uuid', $uuid)->first(); // Getting data using UUID
        // dd($nurse);

        if (empty($nurse)) {
            return redirect()->route('nurse.list')->with('error', 'Invalid uuid!');
        }
        $fullpermission ='0';
            $clinicuser_uuid = Session::get('user.clinicuser_uuid');
          if($userType != 'patient'){
            $fullpermission ='1';
            $loginUserDetails = ClinicUser::where('clinic_user_uuid',$clinicuser_uuid)->first();
            if(empty($loginUserDetails)){
                return back()->with('error', "Invalid clinic details or not found!");
            }
        }else{
            $fullpermission ='0';
           $loginUserDetails = Patient::where('patients_uuid',$clinicuser_uuid)->first(); 
            if(empty($loginUserDetails)){
                return back()->with('error', "Invalid clinic details or not found!");
            }
        } 
        $field = $nurse->user_type_id == 3 ? 'nurse_id' : 'consultant_id' ;
        // Initialize the query for online records
        $onlineRecords = Appointment::where([
            ['status', '1'],
            [$field, $nurse->user_id],
        ])
        ->whereIn('appointment_type_id', [1, 2]);

        $onlineRecords = $onlineRecords->orderBy('appointment_date', 'asc')->orderBy('appointment_time', 'asc');

        $openCount = (clone $onlineRecords)
            ->where('is_completed', '0')
            ->where(function ($query) use ($userTimeZone) {
            $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
        })->count();
        
        $receptionCount = (clone $onlineRecords)
            ->where('is_completed', '0')
            ->where('reception_waiting', '1')
            ->count();
        
        $cancelledCount = (clone $onlineRecords)->onlyTrashed()->count();
        
        $completedCount = (clone $onlineRecords)->where('is_completed', '1')->count();

        // Handle Online Appointments
        if ($status == 'open') {
            $onlineRecords->where('is_completed', '0')->where(function ($query) use ($userTimeZone) {
                $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                      ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            });
        } elseif ($status == 'reception') {
            $onlineRecords->where('is_completed', '0')->where('reception_waiting', '1');
        } elseif ($status == 'cancelled') {
            $onlineRecords->onlyTrashed();
        } elseif ($status == 'completed') {
            $onlineRecords->where('is_completed','1');
        }

        try {
            // Get the number of items per page from the request, default to 10
            $perPage = request()->get('perPage', 10);

            // Retrieve the paginated data
            $appointments = $onlineRecords->latest()->paginate($perPage);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('nurse.list')->with('error', 'Something went wrong! Appointment Model not found');
        }
        $html = view('appointment.appointments', compact('userTimeZone','nurse', 'appointments', 'perPage', 'status','fullpermission','openCount','receptionCount','cancelledCount','completedCount'))->render();
        return response()->json([
            'html' => $html,
            'success' => 1,
            // 'status' => $status,
            // 'type' => $type
        ]);
    }

    // Delete Function
    protected function delete($uuid)
    {
        if (empty($uuid)) {
            return redirect()->route('nurse.list')->with('error', 'Nurse not found or invalid uuid!');
        }

        try {
            $nurse = ClinicUser::where('clinic_user_uuid', $uuid)->first();
            $nurse->delete();
            $message = 'Nurse deleted successfully!';
            $status = 'success';

        } catch (ModelNotFoundException $e) {
            $message = 'Unable to find nurse';
            $status = 'error';
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $message = 'An error occurred while deleting the nurse';
            $status = 'error';
        }
        return response()->json([
           
            'status' => 'active',
            'redirect' => url('/users'),
         
        ]);

        return redirect()->route('user.list', ['status' => 'active'])->with($status, $message);
    }


    // Activate Function
    protected function activate($uuid)
    {
        if (empty($uuid)) {
            return redirect()->route('nurse.lists', ['status' => 'inactive'])->with('error', 'Nurse not found or invalid uuid!');
        }

        $nurse = ClinicUser::onlyTrashed()->where('clinic_user_uuid', $uuid)->first();

        if ($nurse) {
            $nurse->restore();
            $message = 'Nurse activated successfully!';
            $status = 'success';
        } else {
            $message = 'Failed to activate nurse!';
            $status = 'error';
        }

        return redirect()->route('nurse.lists', ['status' => 'inactive'])->with($status, $message);
    }


    //Import Blade View function
    public function import()
    {
        if (request()->ajax()) {
            $html = view('nurses.import')->render();
            $arr['view'] = $html;
            $arr['status'] = 1;
            return response()->json($arr);
        }
    }


    public function importNurse(Request $request)
    {

        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                try {
                    // Load the uploaded file
                    $file = $request->file('file');
                    $spreadsheet = IOFactory::load($file->getPathname()); // Load the spreadsheet
                    $sheet = $spreadsheet->getActiveSheet();              // Retrieve the active sheet
                    $data = $sheet->toArray();                            // Convert the sheet to an array

                    
                    $validRecords = [];   // For valid records
                    $errorRecords = [];   // For records with errors (existing emails)

                    // Check if the file contains valid data (excluding headers and empty rows)
                    $nonEmptyRows = array_filter($data, function ($row) {
                        // Skip rows with no content
                        return !empty(array_filter($row));
                    });

                    // Define the required columns
                    $requiredColumns = ['name', 'email', 'department','specialty', 'qualification', 'phone', 'country code'];
                    // Get the first row as headers
                    $headers = $data[0];
                   
                    // Convert both arrays to lowercase for case-insensitive comparison
                    $lowercaseHeaders = array_map('strtolower', $headers);
                    $lowercaseRequiredColumns = array_map('strtolower', $requiredColumns);

                    // Check if all required columns are present
                    $missingColumns = array_diff($lowercaseRequiredColumns, $lowercaseHeaders);

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

                        $countrycode = isset($row[5]) ? trim($row[5]) : '';
                        $countryCodedetails = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id')->where('country_code',$countrycode)->orWhere('country_code', '+' . $countrycode)->first());


                        $insertArr = array();
                        $insertArr['import_doc_uuid'] = $this->Corefunctions->generateUniqueKey("10", "import_docs", "import_doc_uuid");
                        $insertArr['name'] = isset($row[0]) ? trim($row[0]) : ''; // Adjust according to the column index
                        $insertArr['email'] = isset($row[1]) ? trim($row[1]) : '';
                        $insertArr['department'] = isset($row[2]) ? trim($row[2]) : '';
                        $insertArr['specialty'] = isset($row[3]) ? trim($row[3]) : '';
                        $insertArr['qualification'] = isset($row[4]) ? trim($row[4]) : '';
                        $insertArr['Phone_number'] = isset($row[6]) ? trim($row[6]) : '';
                        $insertArr['country_code'] = !empty($countryCodedetails) ? $countryCodedetails['id'] : null;
                        $insertArr['userID'] = session()->get('user.userID');
                        $insertArr['type'] = 2;


                        $specialties = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->whereRaw('LOWER(specialty_name) = ?', [strtolower($insertArr['specialty'])])->first());
                       
                        $insertArr['specialty'] = !empty($specialties) ? $specialties['id'] : null;
               
                     
                        // $countryCode = RefCountryCode::where('country_code', '+' . $insertArr['country_code'])->first();
                        $insertArr['error'] = '';

                        foreach ($requiredColumns as $columnName) {
                            $columnIndex = array_search($columnName, $lowercaseHeaders);
                            $rowData[$columnName] = isset($row[$columnIndex]) ? trim($row[$columnIndex]) : null;
                            if ( empty($rowData[$columnName])) {
                                    $insertArr['status']            = '-1';
                                    $insertArr['error'] .=  'The uploaded file does not contain valid data for ' . $columnName.'. ';
                                    $errorRecords[] = $insertArr;
                                
                                $isRecordValid = false; // Mark record as invalid
                                break; // Exit the loop and go to the next record
                            }
                            
                        }

                        // Validate phone number
                        if (!preg_match('/^\d{10}$/', $insertArr['phone'])) {
                            $insertArr['error'] .= 'Phone number must be  10 digits. ';
                            $errorRecords[] = $insertArr;
                        }
                        if (empty($specialties)) {
                            $insertArr['status'] = '-1';
                            $insertArr['error'] .= 'Provided specialty is not in our system. ';
                        }
                        if (empty($countryCodedetails)) {
                            $insertArr['status'] = '-1';
                            $insertArr['error'] .= 'Invalid country code details are entered. ';
                        }
                       
                        else {

                            //checking email and phone number exist
                            $existingUser = User::where('email', $insertArr['email'])->first();
                            $existingPhoneUser = User::where('phone_number', $insertArr['phone'])->first();
                            
                            $existingNurse = ClinicUser::where('email', $insertArr['email'])->where('clinic_id', session('user.clinicID'))->first();
                            $existingPhoneNurse = ClinicUser::where('phone_number', $insertArr['phone'])->where('clinic_id', session('user.clinicID'))->first();

                            if ($existingUser || $existingNurse) {
                                // If email exists add to error records
                                $insertArr['error'] .= ' User already exist with the same email. ';
                                $errorRecords[] = $insertArr;
                            }

                            if ($existingPhoneUser || $existingPhoneNurse) {
                                $insertArr['error'] .= ' User already exist with the same phone number. ';
                                $errorRecords[] = $insertArr;
                            }
                        }
                        $importDocID = Nurse::insertConsultantExcelData($insertArr, $import_key, session()->get('user.clinicID'));

                    }
                    
                    // Return a preview page with both valid and error records
                    $arr['success'] = 1;
                    $arr['message'] = 'Preview the uploaded file.';
                    $arr['import_key'] = $import_key;

                    return response()->json($arr);
                } catch (\Exception $e) {
                    // Rollback the transaction in case of an error
                    DB::rollBack();
                    return response()->json(['error' => 'Error importing nurses: ' . $e->getMessage()], 500);
                }
            }
        }
    }

    public function excelPreview($importKey)
    {
        return view('nurses.excelpreview', compact('importKey'));
    }

    //Preview Document
    public function importPreview()
    {
        if (request()->ajax()) {
            $data = request()->all();
         

            if (empty($data)) {
                return response()->json([
                    'error' => 1,
                    'errormsg' => 'Fields missing'
                ]);
            }
            $importKey = $data['importKey'];

            /** Get the imported exel data  */
            $excelDetails = DB::table('import_docs')->where('import_key', $importKey)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at');
            if (isset($data['lastExportID']) && ($data['lastExportID'] != '0')) {
                $excelDetails = $excelDetails->where('id', '<', $lastClientID);
            }
            $excelDetails = $excelDetails->orderBY('id', 'desc')->limit(20)->get();
            $excelDetails = $this->Corefunctions->convertToArray($excelDetails);

            $lastExportID = 0;
            if (!empty($excelDetails)) {
                foreach ($excelDetails as $cdkey => $cdvalue) {
                    $lastExportID = $cdvalue['id'];
                }
            }
        
            /** get specialty ids  */
            $specialtyIds = $this->Corefunctions->getIDSfromArray($excelDetails, 'specialty_id');
            $countryCodeIds = $this->Corefunctions->getIDSfromArray($excelDetails, 'country_code');
            $specialtyDetails = $this->Corefunctions->convertToArray(DB::table('ref_specialties')->whereIn('id', $specialtyIds)->select('specialty_name', 'id')->get());         
            $countryCodeDetails = $this->Corefunctions->convertToArray(DB::table('ref_country_codes')->whereIn('id', $countryCodeIds)->select('country_code', 'id')->whereNull('deleted_at')->get());     
            $specialtyDetails = $this->Corefunctions->getArrayIndexed1($specialtyDetails, 'id');
            $countryCodeDetails = $this->Corefunctions->getArrayIndexed1($countryCodeDetails, 'id');

            $data['lastExportID'] = $lastExportID;
            $data['specialtyDetails'] = $specialtyDetails;
            $data['countryCodeDetails'] = $countryCodeDetails;
            $data['excelDetails'] = $excelDetails;
            $data['importKey'] = $importKey;

            $html = view('nurses.preview', $data)->render();
            $arr['view'] = $html;
            $arr['success'] = 1;
            return response()->json($arr);
        }
    }



    /** Store imported data of nurse */
    public function storePreview(Request $request)
    {
        if ($request->ajax()) {
            $data = request()->all();
            try {

                if (empty($data)) {
                    return response()->json([
                        'error' => 1,
                        'errormsg' => 'Data missing'
                    ]);
                }

                // $importDocIDs = $data['importKey'];
                $clinicId = session()->get('user.clinicID');
                $clinic = Clinic::clinicByID(session()->get('user.clinicID'));
                $userId = session()->get('user.userID');

                $importRecords = $this->Corefunctions->convertToArray(DB::table('import_docs')->where('status', '0')->where('import_key', $data['importKey'])->whereNull('deleted_at')->get());
                
                if (!empty($importRecords)) {
                    foreach ($importRecords as $index => $row) {
                        //Create Nurse
                        $nurseUuid = $this->Corefunctions->generateUniqueKey("10", "clinic_users", "clinic_user_uuid");
                        $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');

                        $nurse = new ClinicUser();
                        $nurse->clinic_user_uuid = $nurseUuid;
                        $nurse->name = $row['name'];
                        $nurse->email = $row['email'];
                        $nurse->department = $row['department'];
                        $nurse->specialty_id = $row['specialty_id'];
                        $nurse->qualification = $row['qualification'];
                        $nurse->phone_number = $row['phone_number'];
                        $nurse->created_by = $userId;
                        $nurse->clinic_id = $clinicId;
                        $nurse->user_type_id = 3;
                        $nurse->country_code = isset($row['country_code']) && $row['country_code'] != '' ? $row['country_code'] : null;
                        // $nurse->user_id = $userId;
                        $nurse->status = '-1';
                        $nurse->invitation_key = 'c_'.$invitationkey;
                        $nurse->save();
                        $nurseID = $nurse->id;
                    
                        /** Invitation mail */
                        $data['name'] = $row['name'];
                        $data['email'] = $row['email'];
                        $data['link'] = url('invitation/' . 'c_'.$invitationkey);

                        $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.nurse-invitation');
                    }
                }

                // Return a preview page with both valid and error records
                $arr['success'] = 1;
                $arr['message'] = 'Nurse file imported successfully';

                return response()->json($arr);
            } catch (\Exception $e) {

                return response()->json(['error' => 'Error importing nurses: ' . $e->getMessage()], 500);
            }
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
                    'errormsg' => 'Data missing'
                ]);
            }

            $importDocList = $this->Corefunctions->convertToArray(DB::table('import_docs')->where('import_doc_uuid', $data['importKey'])->whereNull('deleted_at')->first());
           
            if (empty($importDocList)) {
                $arr['success'] = 0;
                $arr['message'] = 'Invalid records.';
                return response()->json($arr);
            }
            DB::table('import_docs')->where('import_doc_uuid', $data['importKey'])->update(array(
                'deleted_at' => Carbon::now()
            ));
            $arr['success'] = 1;
            $arr['message'] = 'Records removed successfully';
            return response()->json($arr);
            // Return a preview page with both valid and error records

        }
    }

    public function downloadSampleDoc()
    {
        $filename = "Nurse_Sample_Doc.xlsx";
        $headers = array(
            'Content-Type: application/excel',
        );
        $docppath = SAMPLEPATH . 'Nurse_Sample_Doc.xlsx';

        return response()->download($docppath, $filename, $headers);
    }

    public function resendInvitation($uuid)
    {
        // Find the nurse by UUID
        $nurse = ClinicUser::where('clinic_user_uuid', $uuid)->whereIn('status', ['-1', '0'])->where('user_type_id', '3')->first();
        // dd($uuid);
        $user = User::userByPhoneNumber($nurse->phone_number);

        if (empty($nurse)) {
            return response()->json([
                'success' => 0,
                'message' => 'No nurse data found!'
            ]);
        }

        if (!empty($user)) {
            return response()->json([
                'success' => 0,
                'message' => 'Nurse already active!'
            ]);
        }

        $invitationkey = $this->Corefunctions->generateUniqueKey('16', 'clinic_users', 'invitation_key');

        $nurse->update([
            'invitation_key' => 'c_'.$invitationkey
        ]);

        $data['email'] = $nurse['email'];
        $data['name'] = $nurse['name'];
        $data['clinic_users_uuid'] = $uuid;
        $data['link'] = url('invitation/' . 'c_'.$invitationkey);
        $clinic = Clinic::where('id', session()->get('user.clinicID'))->first();

        /** Invitation mail */
        $data['clinic'] = $clinic->name;
        $response = $this->Corefunctions->sendmail($data, 'Invitation to Join '.$clinic->name, 'emails.nurse-invitation');

        return response()->json([
            'success' => 1,
            'message' => 'Invitation resent successfully!',
        ]);
    }
}
