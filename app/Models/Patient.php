<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
use Session;

class Patient extends Model
{
	use HasFactory, SoftDeletes;

	protected $guarded = [];
	public static function insertTempDocs($tempkey, $ext, $filename)
	{

		return DB::table('temp_docs')->insertGetId(array(
			'tempdoc_uuid' => $tempkey,
			'temp_doc_ext' => $ext,
			'original_name' => $filename,
			'created_at' => carbon::now()
		));
	}

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
	public function clinicPatients()
	{
		return $this->hasMany(PatientClinic::class,  'patient_id', 'id');
	}

	public function patientAppointments()
	{
		return $this->hasMany(Appointment::class,  'patient_id', 'id');
	}

	public static function patientByInvitationKey($key){
        $patient = DB::table('patients')->where('invitation_key', $key)->where('status', '!=', '1')->whereNull('deleted_at')->first();
        return $patient;
    }

	public static function patientByID($id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $patient = Patient::with('user')->where('id',$id)->first();
        $patient = $Corefunctions->convertToArray($patient);
        return $patient;
    }

	public static function patientByUUID($patient_uuid){
        $patient = Patient::with('user')->where('patients_uuid',$patient_uuid)->first();
        return $patient;
    }

	public static function getPatients($clinicId, $search = null)
    {
        return self::where('status', '1')
            ->whereNull('deleted_at')
            ->where('clinic_id', $clinicId)
            ->when(!empty(trim($search)), function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();
    }
	public static function getPatientByUserIDs($clinicID){
		$Corefunctions = new \App\customclasses\Corefunctions;
        $patients = DB::table('patients')->whereIn('status', ['-1','1'])->whereNull('deleted_at')->where('clinic_id', $clinicID)->get();
		$patients = $Corefunctions->convertToArray($patients);
        $patientIDS = $Corefunctions->getIDSfromArray($patients, 'user_id');
        $patients = $Corefunctions->convertToArray(DB::table('users')->whereIn('id',$patientIDS)->get());
        return $patients;
    }
	public static function getPatientByID($patientIds){
        $patient = DB::table('patients')->where('status','1')->whereIn('id', $patientIds)->get();
        return $patient;
    }
	public static function getPatientByUserID($patientIds,$clinicID,$type=''){
        $patient = self::with('user')->where('status','1')->whereIn('user_id', $patientIds)->where('clinic_id', $clinicID);
        if( $type =='appoinment'){
            $patient = $patient->withTrashed();
        }
        $patient = $patient->get();
        return $patient;
    }
    public static function getPatientByUserIDNew($patientIds,$clinicID,$type=''){
        $patient = self::with('user')->whereIn('user_id', $patientIds)->where('clinic_id', $clinicID);
        if( $type =='appoinment'){
            $patient = $patient->withTrashed();
        }
        $patient = $patient->get();
        return $patient;
    }
    public static function getPatientWithUser($patientKey){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $patient = $Corefunctions->convertToArray( self::with('user')->where('patients_uuid', $patientKey)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first());

        return $patient;
    }
    public static function patientByUser($userId){
        return $patient = self::with('user')->where('user_id', $userId)->first();
    }
    public static function getPatientsByIds($patientIDS){
        $patients = self::with('user')->whereIn('id', $patientIDS)->withTrashed()->get();
        return $patients;
    }
    public static function getPatientsByUserIds($patientIDS){
        $patients = self::with('user')->whereIn('user_id', $patientIDS)->withTrashed()->get();
        return $patients;
    }
	// public static function getPatientsByUserId($userId,$clinicID =''){
	// 	$Corefunctions = new \App\customclasses\Corefunctions;
    //     $patientDetails = DB::table('patients')->where('status','1')->whereNull('deleted_at')->where('user_id', $userId);
	// 	if($clinicID !=''){
	// 		$patientDetails = $patientDetails->where('clinic_id',$clinicID);
	// 	}
	// 	$patientDetails = $patientDetails->get();
	// 	$patientDetails = $Corefunctions->convertToArray($patientDetails);
    //     return $patientDetails;
    // }

	public static function getPatientsByUserId($userId, $clinicID = '')
	{
    		$Corefunctions = new \App\customclasses\Corefunctions;

			// Start building the query
			$query = DB::table('patients')->where('status', '1')->whereNull('deleted_at')->where('user_id', $userId);

			// Clone the query for `clinicID`
			$queryWithClinicID = clone $query;

			// If `clinicID` is provided, filter with it
			if($clinicID !=''){
				$queryWithClinicID = $queryWithClinicID->where('clinic_id', $clinicID);
			}

			// Fetch results
			$patientDetailsWithClinicID = $queryWithClinicID->get();
			$patientDetails = $query->get();

			// Convert results to arrays
			$patientDetailsWithClinicID = $Corefunctions->convertToArray($patientDetailsWithClinicID);
			$patientDetails = $Corefunctions->convertToArray($patientDetails);

			// Return both arrays
			return [
				'patientDetails' => $patientDetails,
				'patientDetailsWithClinic' => $patientDetailsWithClinicID
			];
		}

    public static function getPatientByEmail($input)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $emailExists = $Corefunctions->convertToArray(Patient::where('email', $input['email'])->where('clinic_id', session()->get('user.clinicID'))->withTrashed()->first());

        return $emailExists;
    }
    public static function getPatientByPhone($input, $countryCodeId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $phoneExists = $Corefunctions->convertToArray(Patient::where('phone_number', $input['phone_number'])->where('country_code', $countryCodeId)->where('clinic_id', session()->get('user.clinicID'))->withTrashed()->first());

        return $phoneExists;
    }

	public static function getPatientDetails($input, $countryCodeId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

		$parentDetails = $Corefunctions->convertToArray(Patient::where('phone_number', $input['phonenumber'])->where('country_code',$countryCodeId)->where('status', '1')->whereNull('deleted_at')->first());

        return $parentDetails;
    }
    public static function getPatientByUserIDPhone($input, $countryCodeId,$userID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
		$parentDetails = $Corefunctions->convertToArray(Patient::where('phone_number', $input['phonenumber'])->where('user_id', $userID)->where('country_code',$countryCodeId)->first());

        return $parentDetails;
    }

	public static function getPatientBymail($input)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
		$parentDetails = $Corefunctions->convertToArray(Patient::where('email', $input['email'])->where('status', '1')->whereNull('deleted_at')->first());
        return $parentDetails;
    }
	public static function getPatientInvitaionWithClinic($key)
	{
		$Corefunctions = new \App\customclasses\Corefunctions;
		$patientsDetails = Patient::select('patients.clinic_id','patients.patients_uuid','patients.logo_path','clinics.name','clinics.clinic_uuid','clinics.logo','patients.id as patientID','patients.status')
			->leftJoin('clinics', 'clinics.id', '=', 'patients.clinic_id')
			// ->where('patients.user_id', $userID)
            ->where('patients.invitation_key', $key)->where('status', '!=', '1')
			// ->where('patients.status', '1')
			->whereNull('clinics.deleted_at')
			->first();

		$patientsDetails = $Corefunctions->convertToArray($patientsDetails);
		return $patientsDetails;
	}
	public static function getPatientWithClinic($userID)
	{
		$Corefunctions = new \App\customclasses\Corefunctions;
		$patientsDetails = Patient::select('patients.clinic_id','patients.patients_uuid','patients.logo_path','clinics.name','clinics.clinic_uuid','clinics.logo','patients.id as patientID')
			->leftJoin('clinics', 'clinics.id', '=', 'patients.clinic_id')
			->where('patients.user_id', $userID)
			->where('patients.status', '1')
			->whereNull('clinics.deleted_at')
			->first();

		$patientsDetails = $Corefunctions->convertToArray($patientsDetails);
		return $patientsDetails;
	}

	public static function insertPatient($input,$userCountryCode,$userID,$createdBy,$status='1',$clinicID=''){
        $Corefunctions = new \App\customclasses\Corefunctions;

		$patientuuid = $Corefunctions->generateUniqueKey("10", "patients", "patients_uuid");
       
        $insertid = DB::table('patients')->insertGetId(array(

            'patients_uuid'   		    => $patientuuid,
            // 'name'          		    => $input['first_name'],
            'first_name'          		=> $input['first_name'],
            'middle_name'  				=> isset($input['middle_name']) && $input['middle_name'] != '' ? $input['middle_name'] : null ,
            'last_name'  				=> isset($input['last_name']) && $input['last_name'] != '' ? $input['last_name'] : null ,
            'gender'  				    => isset($input['gender']) && $input['gender'] != '' ? $input['gender'] : null ,
            'email'  				    => $input['email'] ,
            'dob'  					    => (isset($input['dob']) && $input['dob'] != '') ? date('Y-m-d', strtotime($input['dob'])) : NULL ,
            'phone_number'  		    => $input['user_phone'] ,
            'country_code' 			    => !empty($userCountryCode) ? $userCountryCode['id'] : null ,
            'created_by' 			    => $createdBy ,
			'user_id' 				    => $userID ,
            'status'  				    => $status ,
			'whatsapp_number' 		    => isset($input['whatsapp_num']) &&  trim($input['whatsapp_num'] !='') ? $input['whatsapp_num'] : null ,
            'address' 				    => isset($input['address']) ? $input['address']  : null ,
            'city' 					    => isset($input['city']) ? $input['city'] : null ,
            'zip' 					    => isset($input['zip']) ? $input['zip'] : null ,
            'whatsapp_country_code'     => isset($input['whatsappcountryCode']) && $input['whatsappcountryCode']!='' ? $input['whatsappcountryCode'] : null , 
            'clinic_id' 			    => ($clinicID !='') ? $clinicID : null ,
            'state' 				    => isset($input['state']) && ($input['state'] != '')  ? $input['state'] : null ,
            'state_id' 				    => isset($input['state_id']) && ($input['state_id'] != '') ? $input['state_id'] : null ,
            'invitation_key' 		    => isset($input['invitationkey']) && ($input['invitationkey'] != '') ? 'p_' . $input['invitationkey']  : null ,
            'assigned_clinic_user_id'   => isset($input['doctor']) &&  trim($input['doctor'] !='') ? $input['doctor'] : null ,
            'created_at'    		    => Carbon::now()
        ));
        return $insertid ;
    }

	public static function getPatientsByUserUuid($clinicUserUuid, $clinicId)
    {
        return self::whereNull('deleted_at')
            ->where('patients_uuid', $clinicUserUuid)
            ->whereIn('status', ['-1','1'])
            ->where('clinic_id', $clinicId)
            ->get();
    }
	public static function getPatientDets($userId, $clinicId)
    {
		return self::where('clinic_id', $clinicId)->where('user_id',$userId)->first();
	}
    public static function getPatientWithOutClinic($userId)
    {
		return self::whereNull('clinic_id')->where('user_id',$userId)->first();
	}
    public static function getPatientClinicCount($userId)
    {
		return self::where('user_id',$userId)->count();
	}

	public static function getPatientByClinicId($userId, $clinicId)
    {
        return self::with('user')
            ->where('user_id', $userId)
            ->where('clinic_id', $clinicId)
            ->withTrashed()
            ->first();
    }
    public static function getPatientByUserDetails($userId)
    {
        return self::with('user')
            ->where('user_id', $userId)
            ->withTrashed()
            ->first();
    }
    public static function getPatientByUser()
    {
        return self::select('patients.user_id',  'patients.first_name', 'patients.last_name','patients.patients_uuid', 'patients.logo_path', 'patients.clinic_id')
        ->join('users', 'users.id', '=', 'patients.user_id')
        ->where('patients.user_id', session()->get('user.userID'))->where('patients.status', '1')->whereNull('users.deleted_at')->first() ;
    }

    public static function getPatientCount()
    {
		return self::where('user_id', session()->get('user.userID'))->where('status', '1')->whereNull('deleted_at')->count();
	}
    public static function getClinicIds()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $patientClinicDetails = $Corefunctions->convertToArray(self::select('clinic_id')
                    ->where('user_id', session()->get('user.userID'))->where('status', '1')->whereNull('deleted_at')->get());
       
        $clinicIds = $Corefunctions->getIDSfromArray($patientClinicDetails, 'clinic_id');

        return $clinicIds;

    }

    public static function getPatientwithUserID($userId)
    {
		return self::where('user_id', $userId)
        ->whereNull('deleted_at')
        ->first();
	}


    public static function getPatientDetsById($id)
    {
        return self::with('user')
            ->where('id', $id)
            ->first();
    }
    public static function updatePatientStatus($patientId,$status)
    {
        DB::table('patients')->where('id', $patientId)->update(array(
            'status' => $status,
            'invitation_key' => NULL,
            'updated_at' => Carbon::now(),
        ));
    }
    public static function updatePatientStatusByClinicId($patientId,$clinicId,$status)
    {
        DB::table('patients')->where('id', $patientId)->where('clinic_id',$clinicId)->update(array(
            'status' => $status,
            'invitation_key' => NULL,
            'updated_at' => Carbon::now(),
        ));
    }
    public static function updatePatientPhone($countryId,$phone,$patientId)
    {
        DB::table('patients')->where('id', $patientId)->update(array(
            'country_code' => $countryId,
            'phone_number' => $phone
        ));
    }
    public static function updateInvitationKey($patientId,$invitationkey)
    {
        DB::table('patients')->where('id', $patientId)->update(array(
            'status' => '-1',
            'invitation_key' => 'p_' . $invitationkey ,
            'updated_at' => Carbon::now(),
        ));
    }
    public static function updatePatient($patientId,$input,$whatsappcountryCode,$countryCodedetails)
    {
        DB::table('patients')->where('id', $patientId)->update(array(
           
        //    'name' => $input['name'] ,
           'first_name' => $input['name'] ,
           'middle_name' => isset($input['middle_name']) && $input['middle_name'] != '' ? $input['middle_name'] : null ,
           'last_name'     => isset($input['last_name']) ? $input['last_name'] : null ,
           'gender' => $input['gender'] ,
           'email' => $input['email'] ,
           'dob' => (isset($input['dob']) && $input['dob'] != '') ? date('Y-m-d', strtotime($input['dob'])) : NULL ,
           'phone_number' => $input['phone_number'] ,
           'whatsapp_number' => isset($input['whatsapp_num']) ? $input['whatsapp_num'] : null ,
           'whatsapp_country_code' =>  !empty($whatsappcountryCode) ? $whatsappcountryCode['id'] : '185' ,
           'country_code' => !empty($countryCodedetails) ? $countryCodedetails['id'] : '185' ,
           'address' => isset($input['address']) && ($input['address'] != '') ? $input['address'] : null,
           'city' => isset($input['city']) && ($input['city'] != '') ? $input['city'] : null,
           'state' => isset($input['state']) && ($input['state'] != '') && $input['countrycode'] != '+1' ? $input['state'] : null ,
           'state_id' => isset($input['state_id']) && ($input['state_id'] != '') ? $input['state_id'] : null ,
           'zip' => isset($input['zip']) && ($input['zip'] != '') ? $input['zip'] : null,
           'notes'=> isset($input['type']) && ($input['type'] == 'frontend') && isset($input['note']) ? $input['note'] : null ,
           'assigned_clinic_user_id'   => isset($input['doctor']) &&  trim($input['doctor'] !='') ? $input['doctor'] : null ,
           'updated_at' => Carbon::now(),
           'updated_by' => session()->get('user.userID'),
        ));
    }

    public static function validatePatient($email,$clinicId,$patientID,$userId,$phone,$countryID)
    {
        $data['success'] = '1';
        $phone    =  str_replace(["(", ")", " ","-"], "", $phone);

        $emailExists = Patient::where('email', $email)
            ->where('clinic_id', $clinicId)
            ->where('id', '!=', $patientID)
            ->exists() || User::where('email', $email)
            ->where('id', '!=', $userId)
            ->exists();

        // 2. Check if phone exists with the same country code and if it is associated with the same email
        $phoneExists = Patient::where('phone_number', $phone)
            ->where('country_code', $countryID)
            ->where('clinic_id', $clinicId)
            ->where('id', '!=', $patientID)
            ->exists() || User::where('phone_number', $phone)
            ->where('country_code', $countryID)
            ->where('id', '!=', $userId)
            ->exists();

        // If email exists but the phone doesn't match, return error
        if ($emailExists) {
            $associatedPhone = User::where('email', $email)
                ->pluck('phone_number')
                ->first();
            $associatedCountryCode = User::where('email', $email)
                ->pluck('country_code')
                ->first();
              
            if ($associatedPhone != $phone || $associatedCountryCode != $countryID) {
                $data['error'] = '1';
                $data['errormsg'] = 'This email is already associated with a different phone number or country code.' ;
                return  $data ;
            }
        }

        // If phone exists but the email doesn't match, return error
        if ($phoneExists) {
            $associatedEmail = User::where('phone_number', $phone)
                ->where('country_code', $countryID)
                ->pluck('email')
                ->first();

            if ($associatedEmail != $email) {
                $data['error'] = '1';
                $data['errormsg'] = 'This phone number is already associated with a different email address.' ;
                return  $data ;
                
            }
        }
        return $data ;

    }

    public static function getPatientList($isPermission,$patientIds,$searchterm,$status,$limit,$prioritypatient,$rpmpatient){
    

        $patientData = Patient::with('user')->select('patients.*', 'patients.dob', DB::raw('TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age'))
        ->where('patients.clinic_id', session()->get('user.clinicID'));


        if ($isPermission == 0) {
            $patientData = $patientData->whereIn('patients.id', $patientIds);
        }
        if ((isset($prioritypatient) && $prioritypatient == '1') || (isset($rpmpatient) && $rpmpatient == '1')) {
            $patientData = $patientData->where(function ($query) use ($prioritypatient, $rpmpatient) {
                if ($prioritypatient == '1') {
                    $query->orWhere('is_priority_patient', '1');
                }
                if ($rpmpatient == '1') {
                    $query->orWhere('rpm_patient', '1');
                }
            });
        }

        // Clone the base query to calculate the counts separately
        $activeCountQuery = clone $patientData;
        $inactiveCountQuery = clone $patientData;
        $pendingCountQuery = clone $patientData;

        // Calculate the counts
        $activecount = $activeCountQuery->where('patients.status', '1')->count();
        $inactiveCount = $inactiveCountQuery->onlyTrashed()->count();
        $pendingcount = $pendingCountQuery->whereIn('patients.status', array('0', '-1'))->count();

        if (isset($searchterm) && ($searchterm != '')) {
            $patientData = $patientData->where('patients.first_name', 'like', '%' . $searchterm . '%')->orWhere('patients.last_name', 'like', '%' . $searchterm . '%')->orWhere('patients.middle_name', 'like', '%' . $searchterm . '%');
        }

        if (isset($status) && ($status != '') && ($status == 'inactive')) {
            $patientData = $patientData->onlyTrashed();
        } else if (isset($status) && ($status != '') && ($status == 'pending')) {
            $patientData = $patientData->whereIn('patients.status', array('0', '-1'));
        } else {
            $patientData = $patientData->where('patients.status', '1')->whereNull('patients.deleted_at');
        }

       
        $patientData = $patientData->orderByRaw('is_priority_patient DESC')->orderBy('patients.id', 'desc')->paginate($limit);

        return [
 
            'patientData' => $patientData,
            'activecount' => $activecount,
            'inactiveCount' => $inactiveCount,
            'pendingcount' => $pendingcount,
           
        ];

    }

    public function rpmOrders() {
        return $this->hasMany(RpmOrders::class, 'user_id', 'user_id');
    }

    public static function updatePatientImage($patientID,$userID,$imagepath){
        DB::table('patients')->where('id', $patientID)->update(array(
            'logo_path' => $imagepath,
        ));
        DB::table('users')->where('id', $userID)->update(array(
            'profile_image' => $imagepath,
        ));

    }

    public static function updatePatientNotes($patientID,$notes){
        DB::table('patients')->where('id', $patientID)->update(array(
            'notes' => $notes,
        ));
    }

    public static function getClinics($userId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $clinics = DB::table('patients')->join('clinics','clinics.id','=','patients.clinic_id')->where('patients.user_id', $userId)->get();
        $clinics = $Corefunctions->convertToArray($clinics);

        return $clinics;
    }
    
     public static function updatePatientDosepotId($patientID,$dosepotid){
        return  DB::table('patients')->where('id', $patientID)->update(array(
            "dosepsot_patient_id"       => $dosepotid,
            "updated_at"                 => Carbon::now()
        ));
    }
    public static function patientByUserID($patientID,$clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $patient = self::with('user')->where('status','1')->where('user_id', $patientID)->whereNull('deleted_at')->where('clinic_id', $clinicID);
        $patient = $patient->first();
        $patient = $Corefunctions->convertToArray($patient);
        return $patient;
    }

    public static function updatePatientClinic($patientUserId,$clinicId)
    {
        DB::table('patients')->where('user_id',$patientUserId)->where('clinic_id',$clinicId)->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }
    public static function patientByUserAndClinicID($userId,$clinicID){
        return $patient = self::with('user')->where('user_id', $userId)->where('clinic_id', $clinicID)->whereNull('deleted_at')->first();
    }
        public static function clinicUserByIDS($clinicUserIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
        if( empty($clinicUserIDS)){ return array(); }
        $result = $Corefunctions->convertToArray(DB::table('clinic_users')->select('id', 'user_id', 'clinic_id','first_name','last_name','logo_path','designation_id')->whereIn('id', $clinicUserIDS)->get());
        return $result ;
	}
    public static function patientByIDS($patientIds){
        $Corefunctions = new \App\customclasses\Corefunctions;
        if( empty($patientIds)){ return array(); }
        $patient = DB::table('patients')->select('id','user_id','first_name','last_name','logo_path')->whereIn('id', $patientIds)->get();
        $patient = $Corefunctions->convertToArray($patient);
        $patient =    $Corefunctions->getArrayIndexed1($patient,'id');
        return $patient;
    }
     public static function getRpmPatients(){
         $Corefunctions = new \App\customclasses\Corefunctions;
        $patient = self::with('user')->where('status','1')->where('rpm_patient','1')->get();
        $patient =    $Corefunctions->convertToArray($patient);
        return $patient;
    }

}
