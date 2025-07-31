<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Session;

class ClinicUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'clinic_users';

   
    protected $guarded = [];

    //Fetching the creator ---relation
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    //CreatedBy Updated by Accessors Formatting
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
    public function doctorSpecialty()
    {
        return $this->belongsTo(RefSpecialty::class, 'specialty_id');
    }
    public function designation()
    {
        return $this->belongsTo(RefDesignation::class, 'designation_id');
    }
    public static function getclinicUserWithSpeciality()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $doctorDetails = $Corefunctions->convertToArray(self::with('user')->where('clinic_user_uuid', Session::get('user.clinicuser_uuid'))
                ->whereIn('user_type_id', ['1','2','3'])->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->with('doctorSpecialty')->first());
        return $doctorDetails;
    }
    public static function getPrimaryclinicUserWithSpeciality()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $doctorDetails = $Corefunctions->convertToArray(self::with('user')->where('is_primary','1')
                ->whereIn('user_type_id', ['1','2','3'])->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->with('doctorSpecialty')->first());
        return $doctorDetails;
    }


    public static function userByUUID($clinic_user_uuid)
    {
        $clinicuser = DB::table('clinic_users')->where('clinic_user_uuid', $clinic_user_uuid)->first();
        return $clinicuser;
    } 
   
    public static function userByID($id)
    {
        $clinicuser = DB::table('clinic_users')->where('id', $id)->first();
        return $clinicuser;
    }
    public static function userByClinicID($clinicId)
    {
        $clinicuser = DB::table('clinic_users')->where('clinic_id',$clinicId)->where('status', '1')->first() ;
        return $clinicuser;
    }
    public static function getClinicUserByInvitation($input,$countryID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $clinicDetails = ClinicUser::where('phone_number', $input['phonenumber'])->where('country_code',$countryID)->where('invitation_key', $input['invitationkey'])->whereNull('deleted_at')->orderBy('id','desc')->first();
        $clinicDetails = $Corefunctions->convertToArray($clinicDetails);
        return $clinicDetails;
    }

    public static function clinicUserByInvitationKey($key)
    {
        $clinicuser = DB::table('clinic_users')->where('invitation_key', $key)->where('status', '!=', '1')->first();
        return $clinicuser;
    }

    
    public static function getLastLoginClinicData($input,$clinicId,$type='')
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $clinicuserDetails = DB::table('clinic_users')->where('status', '1')->where('clinic_id',$clinicId)->whereNull('deleted_at');
        if(isset($type) && $type == 'email'){
            $clinicuserDetails = $clinicuserDetails->where('email', $input['email'])->first();
        }else{
            $clinicuserDetails = $clinicuserDetails->where('phone_number', $input['phonenumber'])->first();
        }
        
        $clinicuserDetails = $Corefunctions->convertToArray($clinicuserDetails);
        return $clinicuserDetails;
    }

    public static function getDoctors($clinicID, $search = null)
    {
        return DB::table('clinic_users')
            ->select(
                'clinic_users.clinic_user_uuid',
                'clinic_users.designation_id',
                'clinic_users.id',
                'users.id as userID',
                'users.user_uuid',
                'users.first_name','users.last_name'
            )
            ->leftJoin('users', 'clinic_users.user_id', '=', 'users.id')
            ->where('clinic_users.user_type_id', '!=', '3') // Exclude user type 3
            ->whereIn('clinic_users.status', ['-1','1'])
            ->whereNull('clinic_users.deleted_at')
            ->where('clinic_users.clinic_id', $clinicID)
            ->when(!empty(trim($search)), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('clinic_users.first_name', 'like', '%' . $search . '%')
                    ->orWhere('users.first_name', 'like', '%' . $search . '%');
                });
            })
            ->get();
    }

    public static function getNurses($clinicId, $search = null)
    {
        return self::where('user_type_id', '3') // Nurse type
            ->where('status', '1')
            ->whereNull('deleted_at')
            ->where('clinic_id', $clinicId)
            ->when(!empty(trim($search)), function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
         
            ->get();
            
    }

    public static function getNursesByUserIDs($clinicID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $nurses = DB::table('clinic_users')->where('user_type_id', '3')->whereIn('status', ['-1','1'])->whereNull('deleted_at')->where('clinic_id', $clinicID)->get();
        $nurses = $Corefunctions->convertToArray($nurses);
        $nurseIDS = $Corefunctions->getIDSfromArray($nurses, 'user_id');
        $nurses = $Corefunctions->convertToArray(DB::table('users')->whereIn('id',$nurseIDS)->get());
        return $nurses;
    }
    public static function getClinicUserWithClinic()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $doctorDetails =  $Corefunctions->convertToArray(self::with('user')->where('clinic_user_uuid', Session::get('user.clinicuser_uuid'))->whereIn('user_type_id', ['1','2','3'])->where('clinic_id', session()->get('user.clinicID'))->first()); // Getting data using UUID
        return $doctorDetails;
    }

    public static function getClinicUserWithUserKey($key)
    {
      
        $doctorDetails = self::with('user')->where('clinic_user_uuid', $key)->where('clinic_id', session()->get('user.clinicID'))->first(); // Getting data using UUID
        return $doctorDetails;
    }


    public static function getClinicUserWithClinicID()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $clinicUserdetails =   self::select('clinics.country_id', 'clinic_users.name', 'clinic_users.phone_number', 'clinic_users.country_code', 'clinic_users.clinic_user_uuid')
        ->join('clinics', 'clinics.id', '=', 'clinic_users.clinic_id')
        ->where('clinic_users.user_id', session()->get('user.userID'))->where('clinic_users.clinic_id', session()->get('user.clinicID'))->where('clinic_users.user_type_id', '1')->where('clinic_users.status', '1')->whereNull('clinics.deleted_at')->first();
        $clinicUserdetails =  $Corefunctions->convertToArray($clinicUserdetails);
        return $clinicUserdetails ;
    }
    public static function updateAvailable($clinic_user_uuid, $login_status)
    {
        return DB::table('clinic_users')->where('clinic_user_uuid', $clinic_user_uuid)->update(array(
            'login_status' => $login_status,
            'updated_at' => Carbon::now(),
        ));
    }
    public static function delecteclinicUse($clinic_user_uuid)
    {
        return DB::table('clinic_users')->where('clinic_user_uuid', $clinic_user_uuid)->update(array(
            'deleted_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ));

       
    }

    public static function getClinicUserList($status, $limit, $userType = '', $searchterm = '',$page='',$pageType='')
    {

        $Corefunctions = new \App\customclasses\Corefunctions;

        $clinicUserQuery = DB::table('clinic_users')->where('clinic_users.clinic_id', session()->get('user.clinicID'));
        if (isset($userType) && $userType != '') {
            $userTypeArray = array('admin' => '1', 'clinician' => '2', 'nurse' => '3');
            $clinicUserQuery = $clinicUserQuery->where('clinic_users.user_type_id', $userTypeArray[$userType]);
        }
        if (isset($searchterm) && ($searchterm != '')) {
            $clinicUserQuery->where(function ($query) use ($searchterm) {
                $query->where('clinic_users.first_name', 'like', '%' . $searchterm . '%')
                    ->orWhere('clinic_users.last_name', 'like', '%' . $searchterm . '%')
                    ->orWhere('clinic_users.email', 'like', '%' . $searchterm . '%')
                    ->orWhere('clinic_users.phone_number', 'like', '%' . $searchterm . '%');
            });
        }
        // Clone the base query to calculate the counts separately
        $activeCountQuery = clone $clinicUserQuery;
        $inactiveCountQuery = clone $clinicUserQuery;
        $pendingCountQuery = clone $clinicUserQuery;

        // Calculate the counts
        $activecount = $activeCountQuery->whereNull('clinic_users.deleted_at')->where('clinic_users.status', '1')->count();
        $innactiveCount = $inactiveCountQuery->whereNotNull('deleted_at')->count();
        $pendingCount = $pendingCountQuery->whereNull('deleted_at')->whereIn('status', ['-1', '0'])->count();

        // Apply filters based on the status parameter
        if ($status == 'inactive') {
            $clinicUserQuery = $clinicUserQuery->whereNotNull('clinic_users.deleted_at');
            $clinicUserQuery->leftJoin('users', 'clinic_users.user_id', '=', 'users.id') // Left join ensures all clinic_users are included even if no user data exists
                ->select('clinic_users.*', 'users.first_name as first_name', 'users.profile_image as profile_image', 'users.email as user_email', 'users.phone_number as user_phone');
        } elseif ($status == 'pending') {
            $clinicUserQuery->whereNull('deleted_at')->whereIn('status', ['-1', '0']);
        } else {
            $clinicUserQuery->whereNull('clinic_users.deleted_at')->where('clinic_users.status', '1');
            $clinicUserQuery->leftJoin('users', 'clinic_users.user_id', '=', 'users.id') // Left join ensures all clinic_users are included even if no user data exists
                ->select('clinic_users.*', 'users.first_name as first_name', 'users.profile_image as profile_image', 'users.email as user_email', 'users.phone_number as user_phone');
        }

        if($pageType !='' && $pageType == 'timing'){
            $clinicUserList = $clinicUserQuery->where('is_licensed_practitioner', '1');
        }

        // Paginate the final user list
        if($page !=''){
            $clinicUserList = $clinicUserQuery->orderBy('id', 'desc')->paginate($limit);

        }else{
            $clinicUserList = $clinicUserQuery->orderBy('id', 'desc')->paginate('10', ['*'], 'page', $page);

        }
      
        

        $clinicUserData = $Corefunctions->convertToArray($clinicUserList);

        $data['clinicUser']     = $clinicUserData;
        $data['clinicUserList'] = $clinicUserList;
        $data['activecount']    = $activecount;
        $data['innactiveCount'] = $innactiveCount;
        $data['pendingCount'] = $pendingCount;

        return $data;
    }


    public static function getClinicUserByEmail($input,$clinicUsers = array())
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $emailExists = ClinicUser::where('email', $input['email'])->where('clinic_id', session()->get('user.clinicID'));
        // for edit
        if(isset($clinicUsers) && !empty($clinicUsers) && $clinicUsers->id !=''){
            $emailExists = $emailExists->where('id','!=', $clinicUsers->id);
        }
        $emailExists = $emailExists->withTrashed()->first();
        $emailExists =$Corefunctions->convertToArray($emailExists);
        return $emailExists;
    }
     public static function getClinicUserByEmailEdit($input,$clinicuser)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $emailExists = $Corefunctions->convertToArray(ClinicUser::where('email', $input['email'])->where('id','!=', $clinicuser['id'])->where('clinic_id', session()->get('user.clinicID'))->withTrashed()->first());

        return $emailExists;
    }
    public static function ClinicUserDetails($key)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $doctorDetails = $Corefunctions->convertToArray(ClinicUser::where('clinic_user_uuid', $key)
        // ->whereIn('user_type_id', ['1','2'])
        ->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->with(['doctorSpecialty','user'])->first());
        return $doctorDetails;
    }
    public static function getClinicUserByPhone($input, $countryCodeId,$clinicUsers= array())
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $phoneExists = ClinicUser::where('phone_number', $input['phone_number'])->where('country_code', $countryCodeId)->where('clinic_id', session()->get('user.clinicID'));
        // for edit
        if(!empty($clinicUsers) && $clinicUsers->id !=''){
            $phoneExists = $phoneExists->where('id','!=',$clinicUsers->id);
        }
        $phoneExists = $phoneExists->withTrashed()->first();
        $phoneExists =$Corefunctions->convertToArray($phoneExists);

        return $phoneExists;
    }
     public static function getClinicUserByPhoneEdit($input,$clinicuser, $countryCodeId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $emailExists = $Corefunctions->convertToArray(ClinicUser::where('phone_number', $input['phone_number'])->where('id','!=', $clinicuser['id'])->where('country_code', $countryCodeId)->where('clinic_id', session()->get('user.clinicID'))->withTrashed()->first());

        return $emailExists;
    }
    public static function updateParentDetails($patientID,$userID)
    { 
        DB::table('clinic_users')->where('id',$patientID)->limit(1)->update(array(
            'user_id'       	=> $userID,
            'status' 			=> '1' ,
            'invitation_key' 	=> null ,
			"login_status" 		=>'1' ,
            'updated_at' 		=> Carbon::now()
        ));

    }
    public static function updateLastOnboarding($key,$userID,$lastStep){
        return  DB::table('clinic_users')->where('clinic_user_uuid', $key)->where('user_id',$userID)->update(array(
            "last_onboarding_step" => $lastStep,
            "updated_at"           => Carbon::now()
        ));
    }
    public static function completeOnboarding($key,$userID){
        return  DB::table('clinic_users')->where('clinic_user_uuid', $key)->update(array(
            "onboarding_complete" => '1',
            "updated_at"           => Carbon::now()
        ));
    }

    public static function getClinicUserWithUsers($userDetails)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
    
        $clinicUserDetails = ClinicUser::with('user')->select('clinic_users.user_type_id','clinic_users.id','first_name','clinic_users.user_id', 'clinic_users.clinic_id', 'clinic_users.clinic_user_uuid', 'logo_path', 'is_clinic_admin', 'designation_id','is_licensed_practitioner','clinic_users.clinic_code','onboarding_complete','last_onboarding_step')->where('clinic_users.user_id', $userDetails["id"])->where('clinic_users.clinic_id',$userDetails['last_login_clinic_id'])->where('clinic_users.status', '1')->first();
        $clinicUserDetails = $Corefunctions->convertToArray(  $clinicUserDetails );
        return $clinicUserDetails;
    }
    public static function getClinicUserByKey($key)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $clinicUserDetails = $Corefunctions->convertToArray(ClinicUser::with(['user'])->where('clinic_user_uuid', $key)->whereNull('deleted_at')->first());
        return $clinicUserDetails;
    }

    public static function getClinicUserByUuid($key)
    {
        $doctor = self::with('user')->where('clinic_user_uuid', $key)->first();
        return $doctor;
    }

    public static function getClinicUserById($clinicUserId)
    {
        return self::with('user')
            ->where('id', $clinicUserId)
            ->select('id', 'designation_id', 'user_type_id', 'user_id','name','user_id')->withTrashed()
            ->first();
    }
    public static function getClinicUserByUserId($userId)
    {
        return self::with('user')
            ->where('user_id', $userId)
            ->select('id', 'designation_id', 'user_type_id', 'user_id','name','user_id','email','phone_number','country_code','clinic_code','first_name','last_name')->withTrashed()
            ->first();
    }

    public static function getClinicUsersByIds($clinicUserIds)
    {
        return self::with('user')
            ->whereIn('id', $clinicUserIds)
            ->withTrashed()
            ->get();
    }

    public static function getClinicUsersByUserIds($clinicUserIds)
    {
        return self::with('user')
            ->whereIn('user_id', $clinicUserIds)
            ->withTrashed()
            ->get();
    }

    public static function getClinicAdmin($key)
    {
        $isAdmins = DB::table('clinic_users')->where('clinic_user_uuid','!=',$key)->where('clinic_users.clinic_id', session()->get('user.clinicID'))->where('clinic_users.user_type_id','1')->where('clinic_users.status', '1')->whereNull('deleted_at')->count();
        return $isAdmins;
    }
    public static function getClinicAdmins($clinicIDS)
    {
        $admins = DB::table('clinic_users')->whereIn('clinic_id', $clinicIDS)->where('user_type_id','1')->whereNull('deleted_at')->get();
        return $admins;
    }
    public static function getClinicUsers($clinicID)
    {
        $admins = ClinicUser::where('clinic_id', $clinicID)->whereNull('deleted_at')->with(['doctorSpecialty','user'])->get();
        return $admins;
    }
    public static function getPrescribers($clinicID)
    {
        $admins = ClinicUser::where('clinic_id', $clinicID)->where('eprescribe_enabled','1')->whereNull('deleted_at')->with(['doctorSpecialty','user'])->get();
        return $admins;
    }
    public static function getUserPrescribers($clinicID,$userID)
    {
        $admins = ClinicUser::where('clinic_id', $clinicID)->where('user_id',$userID)->where('eprescribe_enabled','1')->whereNull('deleted_at')->with(['doctorSpecialty','user'])->get();
        return $admins;
    }

    public static function insertClinicUser($input,$userCountryCode,$userID,$clinicID,$status='1',$clinicUserID='',$clinicCode=''){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $clinicUserUuid = $Corefunctions->generateUniqueKey("10", "clinic_users", "clinic_user_uuid");
        

        $insertid = DB::table('clinic_users')->insertGetId(array(

            'clinic_user_uuid'   => $clinicUserUuid,
            'clinic_id'          => $clinicID,
            'user_id'            => $userID,
            'name'               => isset($input['name']) ? $input['name'] : $input['first_name'],
            'first_name'         => $input['first_name'],
            'last_name'          => isset($input['last_name']) ? $input['last_name'] :null ,
            'phone_number'       => $input['user_phone'],
            'email'              => $input['user_email'],
            'country_code'       => !empty($userCountryCode) ? $userCountryCode['id'] : null,
            'user_type_id'       => isset($input['user_type_id'])  && $input['user_type_id'] !='' ? $input['user_type_id'] : 1,
            'department'         => (isset($input['department']) && $input['department'] != '') ? $input['department'] : null,
            'status'             => $status,
            'is_clinic_admin'    => '1',
            'designation_id'     => isset($input['designation']) && $input['designation'] != '' ? $input['designation'] : null,
            'specialty_id'       => isset($input['speciality']) && $input['speciality'] != '' ?  $input['speciality'] : null ,
            'created_by'         => $clinicUserID !='' ? $clinicUserID : $userID ,
            'invitation_key'     => isset($input['invitationkey']) && $input['invitationkey'] !='' ? 'c_' . $input['invitationkey'] : null,
            'created_at'         => Carbon::now(),
            'npi_number'                  =>  (isset($input['npi_number']) && $input['npi_number'] != '') ? $input['npi_number'] : '' ,
            'is_licensed_practitioner'    =>  isset($input['user_type_id']) &&  $input['user_type_id'] == 2 ? 1 : ( (isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] == 'on') ? 1 : 0 ),
            'clinic_code'        => $clinicCode ,
            'is_primary'         =>((isset($input['is_primary']) ) ? '1' : '0' ),
            'fax'           => (isset($input['fax']) && $input['fax'] != '') ? $input['fax'] : null,
            
        ));
        return ['clinicID' => $insertid,'clinic_user_uuid' => $clinicUserUuid];
       
    }



    public static function updateClinicUsers($input,$countryCode,$clinicUserDetails)
    { 
        DB::table('clinic_users')->where('id',$clinicUserDetails->id)->limit(1)->update(array(
            'name'          => $input['username'] ,
            'first_name'    => $input['username'] ,
            'last_name'     => isset($input['last_name']) ? $input['last_name'] : null ,
            'phone_number'  => isset($input['phone_number']) ? $input['phone_number'] : $clinicUserDetails->phone_number ,
            'email'         => $input['email'],
            'department'    => (isset($input['department']) && $input['department'] != '') ?  $input['department'] : null ,
            'specialty_id'  => (isset($input['speciality']) && $input['speciality'] != '') ? $input['speciality'] : $clinicUserDetails->specialty_id,
            'designation_id'=> (isset($input['designation']) && $input['designation'] != '') ?  $input['designation'] : $clinicUserDetails->designation_id,
            'country_code'  => !empty($countryCode) ? $countryCode['id'] : $clinicUserDetails->country_code ,
            'user_type_id'  => isset($input['user_type_id']) ?  $input['user_type_id'] : 1,
            'updated_by'    => session()->get('user.userID'),
            'logo_path'     =>  isset($input['crppath']) ?  $input['crppath'] : null,
            'updated_at' 	=> Carbon::now(),
            'fax'           => (isset($input['fax']) && $input['fax'] != '') ? $input['fax'] : '',
            'npi_number'    =>  (isset($input['npi_number']) && $input['npi_number'] != '') ? $input['npi_number'] : $clinicUserDetails->npi_number ,
            'is_licensed_practitioner' => ((isset($input['user_type_id']) &&  $input['user_type_id'] == '2') || (isset($clinicUserDetails->user_type_id) &&  $clinicUserDetails->user_type_id == '2')) ? 1 : ( (isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] == 'on') ? 1 : 0 )
        ));

    }
    public static function updateClinicUsersEdit($input,$countryCode,$clinicUserDetails)
    { 
        DB::table('clinic_users')->where('id',$clinicUserDetails->id)->limit(1)->update(array(
            'name'          => $input['username'] ,
            'first_name'    => $input['username'] ,
            'last_name'     => isset($input['last_name']) ? $input['last_name'] : null ,
            'phone_number'  => isset($input['phone_number']) ? $input['phone_number'] : $clinicUserDetails->phone_number ,
            'email'         => $input['email'],
            'country_code'  => !empty($countryCode) ? $countryCode['id'] : $clinicUserDetails->country_code ,
            'user_type_id'  => isset($input['user_type_id']) ?  $input['user_type_id'] : 1,
            'updated_by'    => session()->get('user.userID'),
            'logo_path'     =>  isset($input['crppath']) ?  $input['crppath'] : null,
            'updated_at' 	=> Carbon::now(),
            'department'    => (isset($input['department']) && $input['department'] != '') ?  $input['department'] : null ,
        ));

    }
    public static function updateClinicUsersOnboading($input,$countryCode,$clinicUserDetails)
    { 
        DB::table('clinic_users')->where('id',$clinicUserDetails->id)->limit(1)->update(array(
            'specialty_id'  => (isset($input['speciality']) && $input['speciality'] != '') ? $input['speciality'] : null ,
            'designation_id'=> (isset($input['designation']) && $input['designation'] != '') ? $input['designation'] : null ,
            'updated_by'    => session()->get('user.userID'),
            'updated_at' 	=> Carbon::now(),
            'npi_number'                  =>  (isset($input['npi_number']) && $input['npi_number'] != '') ? $input['npi_number'] : '' ,
            'is_licensed_practitioner'    => isset($clinicUserDetails->user_type_id) && $clinicUserDetails->user_type_id == 2 ? 1 : ( (isset($input['is_licensed_practitioner']) && $input['is_licensed_practitioner'] == 'on') ? 1 : 0 ),

        ));

    }
    public static function updateClinicInvitation($invitationkey,$id)
    {
        return DB::table('clinic_users')->where('id',$id)->update(array(
            'invitation_key' => 'c_' . $invitationkey ,
            'status'         =>  '-1',
            'updated_at' => Carbon::now(),
        ));

    }

    public static function clinicUserByPhone($phone_number, $countryCodeId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userdetails = ClinicUser::where('phone_number', $phone_number)->where('country_code', $countryCodeId)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at')->first();
        $userdetails = $Corefunctions->convertToArray($userdetails);

        return $userdetails;
    }


    public static function getAllClinicUsersByUserID($userIds,$type='')
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $usersList = ClinicUser::with('user')->whereIn('clinic_users.user_id', $userIds);
        if($type == 'patient'){
            $usersList =  $usersList->where('clinic_id', session()->get('user.clinicID'))->where('status', '1');
        }
        if($type == 'nurse'){
            $usersList =  $usersList->where('clinic_id', session()->get('user.clinicID'))->where('user_type_id', '3');
        }
        $usersList =  $usersList->withTrashed()->get();
        $usersList = $Corefunctions->convertToArray($usersList);
        return $usersList;

    }

    public static function getClinicIds()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $clinicUserDetails = $Corefunctions->convertToArray(ClinicUser::select('clinic_users.user_type_id', 'clinic_users.clinic_id', 'clinic_users.clinic_user_uuid', 'clinic_users.email', 'clinic_users.name', 'clinic_users.logo_path','is_clinic_admin')
                    ->where('clinic_users.user_id', session()->get('user.userID'))->where('clinic_users.status', '1')->whereNull('deleted_at')->get());
       
        $clinicIds = $Corefunctions->getIDSfromArray($clinicUserDetails, 'clinic_id');

        return $clinicIds;

    }


    public static function getClinicUserDetails($userId, $clinicId)
    {
        return self::with('user')
            ->select(
                'clinic_users.user_type_id',
                'clinic_users.user_id',
                'clinic_users.clinic_id',
                'clinic_users.clinic_user_uuid',
                'logo_path',
                'is_clinic_admin',
                'designation_id'
            )
            ->where('clinic_users.user_id', $userId)
            ->where('clinic_users.clinic_id', $clinicId)
            ->where('clinic_users.status', '1')
            ->first();
    }

    public static function getUserByUserId($userId, $clinicId,$type='')
    {
        $clinicUser = self::with('user')->where('user_id', $userId)->where('clinic_id', $clinicId);
        if($type =='clinic'){
            $clinicUser =$clinicUser->where('clinic_users.status', '1')->whereNull('users.deleted_at') ;
        }
        $clinicUser = $clinicUser->first();
        return $clinicUser ;
    }

    public static function getUserByUserDetails($userId)
    {
        $clinicUser = self::with('user')->where('user_id', $userId);
        
        $clinicUser = $clinicUser->first();
        return $clinicUser ;
    }

    public static function getClinicUserCount()
    {
        $clinicDetailsCount =  self::select('clinic_users.user_type_id', 'clinic_users.clinic_id', 'clinics.name', 'clinic_users.clinic_user_uuid','clinic_users.consultation_time_id','clinic_users.consultation_time')
              ->join('clinics', 'clinics.id', '=', 'clinic_users.clinic_id')->where('clinic_users.user_id', session()->get('user.userID'))->where('clinic_users.status', '1')->whereNull('clinics.deleted_at')->count();
        return   $clinicDetailsCount ;
    }


    public static function getDoctorsByUserUuid($clinicUserUuid, $clinicId, $search = null)
    {
        return self::where('user_type_id', '2') // Doctor type
            ->whereIn('status', ['-1','1'])
            ->whereNull('deleted_at')
            ->where('clinic_id', $clinicId)
            ->where('clinic_user_uuid', $clinicUserUuid)
            ->when(!empty(trim($search)), function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();
    }
    public static function getClinicUser($userId, $clinicId){
        return self::where('user_id', $userId)->where('clinic_id', $clinicId)->first();
    }
    public static function updateClinicUserStatus($key, $status){
        DB::table('clinic_users')->where('clinic_user_uuid', $key)->update(array(
            'status' => $status,
            'invitation_key' => null,
            'updated_at' => Carbon::now(),
        ));
    }
    public static function getUserClinic($userID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $clinicDetails = self::join('clinics', 'clinics.id', '=', 'clinic_users.clinic_id')
        ->where('clinic_users.user_id',$userID)->where('clinic_users.status', '1')->whereNull('clinics.deleted_at')->whereNull('clinic_users.deleted_at')->count();
  
        return $clinicDetails;
    }
    public static function insertEprescribers($userId,$clinicId,$amount){
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-t');
        $id = DB::table('eprescribers')->insertGetId(array(
            'user_id' => $userId,
            'clinic_id' => $clinicId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'created_at' => Carbon::now(),
        ));
        return $id;
    }
    public static function enableEprescribe($key,$id){
        DB::table('clinic_users')->where('clinic_user_uuid', $key)->update(array(
            'eprescribe_enabled' => '1',
            'eprescriber_id' => $id
        ));
    }
    public static function disableEprescribe($key){
        DB::table('clinic_users')->where('clinic_user_uuid', $key)->update(array(
            'eprescribe_enabled' => '0',
            'eprescriber_id' => NULL
        ));
    }
    public static function getEprescribeEnabledClinicUsers($clinicId){
        return self::where('clinic_id', $clinicId)->where('eprescribe_enabled','1')->get();
    }

    public static function updateClinicUserDuration($input,$key,$userID){
        return  DB::table('clinic_users')->where('user_id',$userID)->update(array(
           
            "consultation_time_id" => isset($input['timeduration']) && $input['timeduration'] !='' ?  $input['timeduration'] : null ,
            "consultation_time"    => isset($input['timeduration']) && $input['timeduration'] == '7' ?  $input['customduration'] : null ,
            "updated_at"           => Carbon::now()
        ));
    }

    public static function getClinicUserByUserIDNew($userIds,$clinicID,$type=''){
        $user = self::with('user')->whereIn('user_id', $userIds)->where('clinic_id', $clinicID);
        if( $type =='appoinment'){
            $user = $user->withTrashed();
        }
        $user = $user->get();
        return $user;
    }

    public static function getLicencedPractitioners($clinicIDs){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $users = $Corefunctions->convertToArray( self::with('user')->join('clinics','clinics.id','=','clinic_users.clinic_id')->select('clinic_users.clinic_user_uuid', 'clinic_users.user_id', 'clinic_users.first_name', 'clinic_users.designation_id', 'clinic_users.specialty_id','clinics.name', 'clinics.logo')->whereIn('clinic_users.clinic_id', $clinicIDs)->where('clinic_users.is_licensed_practitioner', '1')->get() );
        return $users;
    }

    public static function getClinicLicencedPractitioners($clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $users = $Corefunctions->convertToArray( self::with('user')->join('clinics','clinics.id','=','clinic_users.clinic_id')->select('clinic_users.*', 'clinics.name', 'clinics.logo')->where('clinic_users.clinic_id', $clinicID)->where('clinic_users.is_licensed_practitioner', '1')->where('clinic_users.status', '1')->get() );
        return $users;
    }

    public static function getClinicPrimaryContact($clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $users = $Corefunctions->convertToArray( self::with('user')->join('clinics','clinics.id','=','clinic_users.clinic_id')->select('clinic_users.*', 'clinics.name', 'clinics.logo')->where('clinic_users.clinic_id', $clinicID)->where('clinic_users.is_licensed_practitioner', '0')->where('clinic_users.is_primary', '1')->get() );
        return $users;
    }


    public static function getClinicUserDets($key){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userDets = $Corefunctions->convertToArray( self::with('user')->join('clinics','clinics.id','=','clinic_users.clinic_id')->select('clinic_users.id', 'clinic_users.clinic_user_uuid', 'clinic_users.user_id', 'clinic_users.first_name', 'clinic_users.designation_id', 'clinic_users.specialty_id', 'clinic_users.clinic_id', 'clinics.name', 'clinics.logo')->where('clinic_users.clinic_user_uuid', $key)->first() );
        return $userDets;
    }
    public static function clinicUserByIDS($clinicUserIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
        if( empty($clinicUserIDS)){ return array(); }
        $result = $Corefunctions->convertToArray(DB::table('clinic_users')->select('id', 'user_id', 'clinic_id','first_name','last_name','logo_path','designation_id')->whereIn('id', $clinicUserIDS)->get());
        return $result ;
	}


    public static function updateDosepotClinicUsers($input,$clinicUserDetails)
    { 
  
        DB::table('clinic_users')->where('id',$clinicUserDetails->id)->limit(1)->update(array(
            'name'          => $input['username'] ,
            'first_name'    => $input['username'] ,
            'last_name'     => isset($input['last_name']) ? $input['last_name'] : null ,
            'updated_by'    => session()->get('user.userID'),
            'updated_at' 	=> Carbon::now(),
            'fax'           => (isset($input['fax']) && $input['fax'] != '') ? $input['fax'] : '',
            'npi_number'                  =>  (isset($input['npi_number']) && $input['npi_number'] != '') ? $input['npi_number'] : '' ,

        ));

    }
     public static function eprescribeByID($id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $clinicuser =  $Corefunctions->convertToArray(DB::table('eprescribers')->where('id', $id)->whereNull('deleted_at')->first());
        return $clinicuser;
    }
     public static function doseSpotAdminByClinicID($clinicID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $clinicuser = $Corefunctions->convertToArray(DB::table('clinic_users')->select('id','user_id','clinic_id','dosespot_admin')->where('clinic_id', $clinicID)->where('dosespot_admin', '1')->whereNull('deleted_at')->first());
        return $clinicuser;
    }
     public static function updateDoseSpotAdmin($clinicUserID,$dosespotAdmin){
        return  DB::table('clinic_users')->where('id',$clinicUserID)->update(array(
           
            "dosespot_admin" => $dosespotAdmin,
            "updated_at"     => Carbon::now()
        ));
    }
      public static function getPrimayUser($clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $clinicuser = $Corefunctions->convertToArray(DB::table('clinic_users')->where('clinic_id', $clinicID)->where('is_primary', '1')->whereNull('deleted_at')->first());
        return $clinicuser;
    }
    
    public static function getClinicUserByUserIDS($userIDS, $clinicIDS){
        if( empty($userIDS)){
            return array();
        }
        if( empty($clinicIDS)){
            return array();
        }
        
        return self::with('user')
            ->select(
                'clinic_users.first_name',
                'clinic_users.last_name',
                'clinic_users.user_type_id',
                'clinic_users.user_id',
                'clinic_users.clinic_id',
                'clinic_users.clinic_user_uuid',
                'logo_path',
                'is_clinic_admin',
                'designation_id'
            )
            ->whereIn('clinic_users.user_id', $userIDS)
            ->whereIn('clinic_users.clinic_id', $clinicIDS)
            ->where('clinic_users.status', '1')
            ->get();
    }

     
}
