<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $dates = ['appointment_date'];

    public function creatorAppointments()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function clinicUsers()
    {
        return $this->belongsTo(ClinicUser::class, 'clinic_user_id')->withTrashed(); // Adjust the foreign key if necessary
    }
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id')->withTrashed(); // Adjust the foreign key if necessary
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'consultant_id')->withTrashed(); // Assuming 'user_id' is the column linking to 'users' table
    }
    public function patientUser()
    {
        return $this->hasOne(Patient::class, 'user_id', 'patient_id')->withTrashed();
    }
    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id')->withTrashed(); // Adjust the foreign key if necessary
    }
    public function consultantClinicUser()
    {
        return $this->hasOne(ClinicUser::class, 'user_id', 'consultant_id')->withTrashed();
    }
    public function appointmentTypes()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id'); 
    }
    public static function appoinmentNoteByID($appoinmentID){
        return $user = DB::table('appointment_notes')->where('appointment_id', $appoinmentID)->whereNull('deleted_at')->get();
    }
    public static function addNotes($appoinmentID,$input){
        $Corefunctions = new \App\customclasses\Corefunctions;
         $appointment_note_key = $Corefunctions->generateUniqueKey('8', 'appointment_notes', 'appointment_note_key');
                
         DB::table('appointment_notes')->insertGetId([
                'appointment_note_key' =>$appointment_note_key,
                'appointment_id' =>$appoinmentID,
                'notes' => isset($input['note']) ? $input['note'] : '',
                'created_at' => Carbon\Carbon::now(),
            ]);
    }
    public static function appointmentByID($id){
        $appointment = DB::table('appointments')->where('id',$id)->first();
        return $appointment;
    }
    public static function updateAppointmentByID($id,$waiting){
        $appointment = DB::table('appointments')->where('id',$id)->update(array(
            'reception_waiting' => $waiting,
            'updated_at' => Carbon\Carbon::now(),
        ));
        return $appointment;
    }
    public static function deleteAppointment($uuid){
        $appointment = DB::table('appointments')->where('appointment_uuid',$uuid)->update(array(
            'cancelled_by' => Session::get('user.userID'),
            'cancelled_by_type' => (Session::get('user.userType') == 'patient') ? 'p' : 'u',
            'deleted_at' => Carbon\Carbon::now(),
        ));
        return ;
    }
    public static function activateAppointment($uuid){
        $appointment = DB::table('appointments')->where('appointment_uuid',$uuid)->update(array(
            'deleted_at' => null,
        ));
        return ;
    }

    
    public static function appointmentByKey($key){
        $appointment = DB::table('appointments')->where('appointment_uuid',$key)->first();
        return $appointment;
    }
    public static function checkAppointmentsTaggedToDoctor($userId){
        $appointment = DB::table('appointments')->whereNull('deleted_at')->where('consultant_id',$userId)->orWhere('nurse_id',$userId)->count();
        return $appointment;
    }
    public static function getAppointment($userType,$userID,$userTimeZone,$date='',$type=''){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $todayAppointmentsCount = $appointmentDates ='';

        $appointmentDetails = Appointment::select('id', 'patient_id', 'consultant_id', 'appointment_date', 'appointment_time', 'notes', 'appointment_uuid', 'appointment_type_id', 'reception_waiting')->where('clinic_id', session()->get('user.clinicID'))->where('status', '1')->with('consultant', 'consultantClinicUser');
        
        // Add user-specific filters
        $userColumnMap = [
            'patient' => 'patient_id',
            'doctor' => 'consultant_id',
            'nurse' => 'nurse_id',
        ];
       
        if (isset($userColumnMap[$userType]) && $userType != 'clinics') {
            $appointmentDetails->where($userColumnMap[$userType],session()->get('user.userID'));
        }
    
        if ($type == 'list') {
            if ($date != '') {
                $selectedDate = date('Y-m-d', strtotime($date));
                $appointmentDetails = $appointmentDetails->whereDate('expired_at', \Carbon\Carbon::parse($date)->format('Y-m-d'))->orderBy('id', 'desc')->limit(5)->get(); // Filter by the selected date
            } else {
                $todayDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
                $appointmentDetails = $appointmentDetails->whereDate('expired_at', $todayDate)->whereTime('expired_at', '>', now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s'))->orderBy('id', 'desc')->limit(5)->get();
            }
        }else{
            
            $todayDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
            $todayAppointmentsCount = (clone $appointmentDetails)->whereDate('expired_at', $todayDate)->whereTime('expired_at', '>', now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s'))->count();
            $appointmentDetails->where(function ($query) use ($userTimeZone) {
                // Get appointments that are in the future
                $query->where('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'))->where('is_completed','!=','1');
            });
            $appointmentDates    = $appointmentDetails->pluck('appointment_date')->toArray();
            $appointmentDetails = $appointmentDetails->orderBy('appointment_date', 'asc')->limit(5)->get();
        }
        

       $appointmentDetails = $Corefunctions->convertToArray($appointmentDetails);

       return [
            'todayAppointmentsCount' =>$todayAppointmentsCount,
            'appointmentDates' => $appointmentDates,
            'appointmentDetails' => $appointmentDetails,
        ];
    
    }

    public static function userAppointment($userId){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $appointmentDetails =  $Corefunctions->convertToArray(Appointment::where('clinic_id', session()->get('user.clinicID'))->where('status', '1')->where('consultant_id',$userId)->orWhere('nurse_id',$userId)->first());
        return $appointmentDetails;
    }

    public static function getAppointments($clinicId,$status){
        $query = DB::table('appointments')->where('status', '1')
            ->where('clinic_id', $clinicId);
        if ($status === 'inactive') { //fetch deleted data
            $query->onlyTrashed();
        }

        if ($status === 'available') {
            $query->where('login_status', '1');
        }

        if ($status === 'not-available') {
            $query->where('login_status', '0');
        }

        if(session()->get('user.userType') == 'patient' &&  session()->has('user.patientID') == 'patient' && (session()->get('user.patientID') != '')){
            $query->where('patient_id',session()->get('user.userID'));
        }elseif(session()->get('user.userType') == 'nurse'){
            $query->where('nurse_id',session()->get('user.userID'));
        }elseif(session()->get('user.userType') == 'doctor'){
            $query->where('consultant_id',session()->get('user.userID'));
        }  
        $perPage = request()->get('perPage', 10);
        $appointments = $query->latest()->paginate($perPage);

        return [
            'perPage' => $perPage,
            'appointments' => $appointments,
        ];
    }

    public static function getPatientCancelledCount($clinicId){
        $count = Appointment::where('clinic_id', $clinicId)->where('status', '1')->where('is_notes_locked','0')->where('cancelled_by_type','p')->onlyTrashed()->count();
        return $count;
    }

    public static function getAppointmentList($clinicId,$clinicuser_uuid,$userTimeZone,$userID,$status,$userType,$type,$limit=10,$page=''){
        $limit = is_numeric($limit) && $limit > 0 ? $limit : 10; // Ensure valid limit
        $onlineRecords = Appointment::where('clinic_id', $clinicId);
      
        if(isset($type) && $type != '' && $type == 'online'){
            $onlineRecords = $onlineRecords->where('appointment_type_id', '1');
        }elseif(isset($type) && $type != '' &&  $type == 'in-person'){
            $onlineRecords = $onlineRecords->where('appointment_type_id', '2');
        }else{
            $onlineRecords = $onlineRecords->whereIn('appointment_type_id', ['1','2']);
        }
        $onlineRecords = $onlineRecords->with('creatorAppointments', 'patient', 'patientUser', 'consultant', 'consultantClinicUser');

        if(session()->get('user.userType') == 'patient'){
            $onlineRecords->where('patient_id',$userID);
        } 
        if(session()->get('user.userType') == 'doctor' ){
            $onlineRecords->where('consultant_id',$userID);
        } 
        if(session()->get('user.userType') == 'nurse'){
            $onlineRecords->where('nurse_id',$userID);
        }

        // $onlineRecords = $onlineRecords->orderBy('appointment_date', 'asc')->orderBy('appointment_time', 'asc');
        if($userType != 'profile'){
            if($userType != 'patient'){
                $fullpermission ='1';
                $loginUserDetails = ClinicUser::where('clinic_user_uuid',$clinicuser_uuid)->withTrashed()->first();
                if(empty($loginUserDetails)){
                    return back()->with('error', "Invalid clinic details or not found!");
                }
            }else{
                $fullpermission ='0';
                $loginUserDetails = Patient::where('patients_uuid',$clinicuser_uuid)->withTrashed()->first(); 
                if(empty($loginUserDetails)){
                    return back()->with('error', "Invalid clinic details or not found!");
                }
            }
        }
        $openCount = (clone $onlineRecords)
            ->where('status', '1')->where('is_completed', '0')->where('is_notes_locked','0')
            ->where(function ($query) use ($userTimeZone) {
            $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
        })->count();
        $receptionCount = (clone $onlineRecords)->where(function ($query) {
            $query->where('status', '1')->where('is_completed', '0')->where('is_notes_locked','0')->where('reception_waiting', '1');
        })->count();
        $cancelledCount = (clone $onlineRecords)->where('status', '1')->where('is_notes_locked','0')->onlyTrashed()->count();
        $completedCount = (clone $onlineRecords)->where('status', '1')->where('is_completed', '1')->where('is_notes_locked','0')->count();
        $noshowCount = (clone $onlineRecords)->where('status', '2')->where('is_notes_locked','0')->count();
        $notesLockedCount = (clone $onlineRecords)->where('status', '1')->where('is_notes_locked','1')->count();

        if ($status == 'open') {
            $onlineRecords->where('status', '1')->where('is_completed', '0')->where('is_notes_locked','0')->where(function ($query) use ($userTimeZone) {
                $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                      ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            });
        }elseif ($status == 'reception') {
            $onlineRecords->where('status', '1')->where(function ($query) use ($userTimeZone) {
                $currentDate = now($userTimeZone)->toDateString(); // Get current date in the user's timezone
                $currentTime = now($userTimeZone)->format('H:i'); // Get current time in HH:mm format
            
                $query->where('is_completed','0')->where('reception_waiting','1')->where('is_notes_locked','0'); // Ensure current time is within 1 hour after appointment time
            });
        }elseif ($status == 'no_show') {
            $onlineRecords->where('status','2')->where('is_notes_locked','0');
        }elseif ($status == 'cancelled') {
            $onlineRecords->where('status', '1')->where('is_notes_locked','0')->onlyTrashed();
        }elseif ($status == 'completed') {
            $onlineRecords->where('status', '1')->where('is_completed','1')->where('is_notes_locked','0');
        }elseif ($status == 'notes_locked') {
            $onlineRecords->where('status', '1')->where('is_notes_locked','1');
        }
       
        $perPage = request()->get('perPage', 10);
        if($userType == 'profile'){
          
            $appointments = $onlineRecords->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $page);
         
        }else{
         
            $appointments = $onlineRecords->latest()->paginate($perPage);

        }
        
        return [
            'fullpermission' => isset( $fullpermission) ? $fullpermission : '',
            'openCount' => $openCount,
            'receptionCount' => $receptionCount,
            'cancelledCount' => $cancelledCount,
            'completedCount' => $completedCount,
            'noshowCount' => $noshowCount,
            'notesLockedCount' => $notesLockedCount,
            'perPage' => $perPage,
            'appointments' => $appointments,
        ];
    }

    public static function getPatientAppointmentList($clinicId,$userTimeZone,$userID,$status,$limit,$page,$field=''){
        
        $field = isset($field) && $field !='' ? $field :'patient_id' ;
        $onlineRecords = Appointment::where('status', '1')
        ->where('clinic_id', session()->get('user.clinicID'))
        ->where($field, $userID)
        ->whereIn('appointment_type_id', ['1', '2'])
        ->with('creatorAppointments', 'patient', 'patientUser', 'consultant', 'consultantClinicUser');

        $onlineRecords = $onlineRecords->orderBy('appointment_date', 'asc')->orderBy('appointment_time', 'asc');

        $openCount = (clone $onlineRecords)
            ->where('is_completed', '0')
            ->where(function ($query) use ($userTimeZone) {
                $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                    ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            })->count();

        $receptionCount = (clone $onlineRecords)->where('is_completed', '0')->where('reception_waiting', '1')->count();

        $cancelledCount = (clone $onlineRecords)->onlyTrashed()->count();

        $completedCount = (clone $onlineRecords)->where('is_completed', '1')->count();

        $perPage = request()->get('perPage', 10);

        if ($status == 'open') {
            $onlineRecords->where('is_completed', '0')->where(function ($query) use ($userTimeZone) {
                $query->where('expired_at', '<', now()->setTimezone($userTimeZone)->setTimezone('UTC'))
                    ->orWhere('expired_at', '>=', now()->setTimezone($userTimeZone)->setTimezone('UTC'));
            });
        } elseif ($status == 'reception') {
            $onlineRecords->where(function ($query) use ($userTimeZone) {
                $currentDate = now($userTimeZone)->toDateString(); // Get current date in the user's timezone
                $currentTime = now($userTimeZone)->format('H:i'); // Get current time in HH:mm format

                $query->where('is_completed', '0')->where('reception_waiting', '1'); // Ensure current time is within 1 hour after appointment time
            });
        } elseif ($status == 'cancelled') {
            $onlineRecords->onlyTrashed();
        } elseif ($status == 'completed') {
            $onlineRecords->where('is_completed', '1');
        }

        $appointmentRecords = $onlineRecords->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $page);


        return [
            // 'fullpermission' => $fullpermission,
            'openCount' => $openCount,
            'receptionCount' => $receptionCount,
            'cancelledCount' => $cancelledCount,
            'completedCount' => $completedCount,
            'perPage' => $perPage,
            'appointments' => $appointmentRecords,
        ];
    }

    public static function getAppointmentTypes(){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $appointmentTypes = $Corefunctions->convertToArray(DB::table('appointment_types')->whereNull('deleted_at')->get());
        return $appointmentTypes;
    }
    public static function isAppointmentExists($clinicId, $formattedDate, $formattedTime, $patientId = null, $nurseId = null, $doctorId = null,$isEdit='',$appointmentId='')
    {
        return self::where('clinic_id', $clinicId)
            ->where('appointment_date', $formattedDate)
            ->where('appointment_time', $formattedTime)
            ->where('is_completed','!=','1')
            ->when($isEdit == '1', function ($query) use ($appointmentId) {
                $query->where('id', '!=', $appointmentId);
            })
            ->where(function ($query) use ($patientId, $nurseId, $doctorId) {
                if ($patientId) {
                    $query->orWhere('patient_id', $patientId);
                }
                if ($nurseId) {
                    $query->orWhere('nurse_id', $nurseId);
                }
                if ($doctorId) {
                    $query->orWhere('consultant_id', $doctorId);
                }
            })
            ->exists();
    }
    public static function createAppointment($input, $clinicId, $formattedDate, $formattedTime, $expiredDate, $appointmentUuid, $userId)
    {
        $appointment = new self();
        $appointment->appointment_uuid = $appointmentUuid;
        $appointment->clinic_id = $clinicId;
        $appointment->patient_id = $input['patient'] ?? null;
        $appointment->consultant_id = $input['doctor'] ?? null;
        $appointment->nurse_id = $input['nurse'] ?? null;
        $appointment->appointment_date = $formattedDate;
        $appointment->appointment_time = $formattedTime;
        $appointment->appointment_end_time = isset($input['appointment_end_time']) ? $input['appointment_end_time'] : null;
        $appointment->expired_at = $expiredDate;
        $appointment->appointment_type_id = $input['appointment_type_id'] ?? null;
        $appointment->status = '1';
        $appointment->notes = $input['note'] ?? null;
        $appointment->created_by = session()->get('user.userID');
        $appointment->appointment_fee = isset($input['appointment_fee']) ? str_replace(',', '', $input['appointment_fee']) : null;
        $appointment->save();

        return $appointment;
    }

    public static function getClinicUserDoctor($clinicId, $doctorId)
    {
        return ClinicUser::with('user')
            ->where('clinic_id', $clinicId)
            ->where('user_id', $doctorId)
            ->whereNull('deleted_at')
            ->first();
    }

    public static function getAppointmentByUuid($uuid)
    {
        return self::where('appointment_uuid', $uuid)
            ->with('appointmentTypes')
            ->withTrashed()
            ->first();
    }

    public static function getPreviousAppointments($patientId, $appointmentId, $createdAt)
    {
        return self::where('patient_id', $patientId)
            ->where('id', '!=', $appointmentId)
            ->where('created_at', '<', $createdAt)
            ->with(['consultant', 'consultantClinicUser'])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
    }

    public static function getAppointmentsByPatient($patientId,$clinicId)
    {
        return self::select('created_at','appointment_date','appointment_time','appointment_uuid')->where('patient_id', $patientId)
             ->whereNull('deleted_at')
             ->where('clinic_id', $clinicId)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
    }


    public static function getAppointmentNotes($appointmentId)
    {
        return DB::table('appointment_notes')
            ->where('appointment_id', $appointmentId)
            ->get();
    }

    public static function checkConflictingAppointments($clinicId, $formattedDate, $formattedTime, $appointmentId)
    {
        return [
            'Patient' => self::where('patient_id', request('patient'))
                ->where('clinic_id', $clinicId)
                ->where('appointment_date', $formattedDate)
                ->where('appointment_time', $formattedTime)
                ->where('id', '!=', $appointmentId)
                ->exists(),

            'Nurse' => self::where('nurse_id', request('nurse'))
                ->where('clinic_id', $clinicId)
                ->where('appointment_date', $formattedDate)
                ->where('appointment_time', $formattedTime)
                ->where('id', '!=', $appointmentId)
                ->exists(),

            'Doctor' => self::where('consultant_id', request('doctor'))
                ->where('clinic_id', $clinicId)
                ->where('appointment_date', $formattedDate)
                ->where('appointment_time', $formattedTime)
                ->where('id', '!=', $appointmentId)
                ->exists(),
        ];
    }

    public function updateAppointment(array $validatedData, $formattedDate, $formattedTime, $expiredDate,$input)
    {
        $this->patient_id = $validatedData['patient'];
        $this->consultant_id = $validatedData['doctor'];
        $this->nurse_id = $validatedData['nurse'];
        $this->appointment_date = $formattedDate;
        $this->appointment_time = $formattedTime;
        $this->expired_at = $expiredDate;
        $this->appointment_type_id = $validatedData['appointment_type_id'];
        $this->notes = $validatedData['note'];
        $this->appointment_fee = str_replace(',', '', $validatedData['appointment_fee']);
        $this->appointment_end_time = isset($input['appointment_end_time']) ? $input['appointment_end_time'] : null;

        return $this->update();
    }
    public static function updateAppointmentSchedule($appointmentId,$formattedDate, $formattedTime, $expiredDate)
    {
        DB::table('appointments')->where('id', $appointmentId)->update(array(
            'appointment_date' => $formattedDate ,
            'appointment_time' => $formattedTime ,
            'expired_at' => $expiredDate ,
            'updated_by' => session()->get('user.userID')
        ));
    }

    public static function updateReceptionWaiting($appointmentId,$status)
    {
        DB::table('appointments')->where('id', $appointmentId)->update(array(
            'reception_waiting' => $status,
        ));
    }

    public static function getAppointmentsByDate($patientId, $type = 'past')
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $appointmentRecords = Appointment::select('appointment_date', 'appointment_time')
            ->where('clinic_id', session()->get('user.clinicID'))
            ->where('status', '1')
            ->where('patient_id', $patientId)
            ->when($type === 'past', function ($query) {
                return $query->where(DB::raw("CONCAT(appointment_date, ' ', appointment_time)"), '<', now())
                            ->orderBy('id', 'desc');
            })
            ->when($type === 'upcoming', function ($query) {
                return $query->where(DB::raw("CONCAT(appointment_date, ' ', appointment_time)"), '>=', now())
                            ->orderBy('appointment_date', 'asc')
                            ->orderBy('appointment_time', 'asc');
            })
            ->first();
        $appointmentRecords = $Corefunctions->convertToArray($appointmentRecords);
        return $appointmentRecords ;
    }

    public static function appoinmentByPatient($patientId)
    {
      
        $Corefunctions = new \App\customclasses\Corefunctions;
        $appoinemnt = $Corefunctions->convertToArray(self::where('clinic_id', session()->get('user.clinicID'))->where('patient_id', $patientId)->where('status', '1')->first());
        return $appoinemnt ;

    }

    public static function appoinmentByPatientWithClinic($patientId, $clinicId, $userTimeZone)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
    
        $appointmentDetails =  DB::table('appointments')->where('cancelled_by_type','!=','u')->where('clinic_id', $clinicId)
            ->where('patient_id', $patientId)
            ->where('status', '1')->where('is_paid','0')
            // ->where(function ($query) use ($userTimeZone) {
            //     $userNowUTC = now()->setTimezone($userTimeZone)->setTimezone('UTC');
            //     $query->where('expired_at', '>=', $userNowUTC)
            //           ->where('is_completed', '!=', '1');
            // })
            ->get();


    
        return $Corefunctions->convertToArray($appointmentDetails);
    }
    
    public static function getAppointmentByUser($field, $parent_id)
    {
        $Corefunctions = new \App\customclasses\Corefunctions; 
        $appoinemnt = $Corefunctions->convertToArray(Appointment::where('status', '1')->where('clinic_id', session()->get('user.clinicID'))->where($field, $parent_id)->get()); // Build the query
        return $appoinemnt ;
    }

    public static function getAppointmentsByIds($appointmentIds)
    {
        return self::with(['consultantClinicUser.user'])
            ->whereIn('id', $appointmentIds)
            ->get();
    }
    public static function getAppointmentsByConsultant($key)
    {
        return self::with(['consultantClinicUser.user'])
            ->where('appointment_uuid', $key)
            ->get();
    }

    public static function getFirstWaitingByClinicID($clinicId)
    {
        return self::where('clinic_id', $clinicId)
            ->where('reception_waiting', '1')
            ->where('is_completed', '0')->orderBy('id','desc')
            ->get();
    }
    
    public static function updateTranscriptFileAdded($appointmentId,$status)
    {
       return  DB::table('appointments')->where('id', $appointmentId)->update(array(
            'is_run_transcript' => $status,
        ));
    }
    public static function getAllAppointmentForTranscribe()
    {
       return  DB::table('appointments')->join('video_call_transcript_files', 'appointments.id', '=', 'video_call_transcript_files.appointment_id')->where('appointments.is_run_transcript', '0')->whereNull('video_call_transcript_files.deleted_at')->whereNull('appointments.deleted_at')->select('appointments.id','appointments.patient_id','appointments.clinic_id','appointments.consultant_id','appointments.nurse_id')->first();
    }
    public static function getUpcomingAppointment($patientId){
        $Corefunctions = new \App\customclasses\Corefunctions; 
        return $Corefunctions->convertToArray(Appointment::where('appointments.status', '1')
            ->join('clinics', 'appointments.clinic_id', '=', 'clinics.id')
            ->where('appointments.patient_id', $patientId)
            ->whereIn('appointments.appointment_type_id', ['1', '2'])
            ->where(DB::raw("CONCAT(appointment_date, ' ', appointment_time)"), '>=', now())
            ->with('consultant')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->first());
    }
    
}
