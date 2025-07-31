<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Illuminate\Support\Facades\Redirect;
use Carbon;
use Session;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public static function userByID($userID, $status = '')
    {
        $user = DB::table('users')->where('id', $userID);
        if ($status != 'all') {
            $user = $user->where('status', '1');
        }
        $user = $user->first();
        return $user;
    }
    public static function getUserById($userID)
    {
        return $user = DB::table('users')->where('id', $userID)->first();
    }
    public static function userByKey($user_uuid)
    {
        return $user = DB::table('users')->where('user_uuid', $user_uuid)->first();
    }
    public static function userByPhoneNumber($phoneNumber)
    {
        return $user = DB::table('users')->where('phone_number', $phoneNumber)->whereNull('deleted_at')->first();
    }
    public static function getUsersByIDs($userIDS)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        return $Corefunctions->convertToArray(DB::table('users')->select('first_name', 'last_name', 'email', 'id', 'phone_number', 'country_code', 'profile_image')->whereIn('id', $userIDS)->get());
    }
    public static function getUserDetailsByEmail($input)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $userDetails = $Corefunctions->convertToArray(User::where('email', $input['email'])->where('phone_number', $input['phone_number'])->withTrashed()->first());
        return $userDetails;
    }
    public static function getUserByPhone($input, $countryCodeId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $userDetails = $Corefunctions->convertToArray(DB::table('users')->where('email', $input['email'])->where('phone_number', $input['phone_number'])->where('country_code', $countryCodeId)->orderBy('id', 'desc')->whereNull('deleted_at')->first());

        return $userDetails;
    }
    public static function getUserByPhoneCountry($input, $countryCodeId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userDetails = $Corefunctions->convertToArray(DB::table('users')->select('id', 'user_uuid', 'phone_number', 'last_login_clinic_id', 'timezone_id')->where('phone_number', $input['phonenumber'])->where('country_code', $countryCodeId)->whereNull('deleted_at')->first());

        return $userDetails;
    }
    public static function getUserByPhoneCountryWithTrashed($phone, $countryCodeId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userDetails = $Corefunctions->convertToArray(DB::table('users')->select('id', 'user_uuid', 'phone_number', 'last_login_clinic_id', 'timezone_id')->where('phone_number', $phone)->where('country_code', $countryCodeId)->first());

        return $userDetails;
    }

    public static function getUserTimeZone($timezoneOffset)
    {
        $timezone = DB::table('ref_timezones')->where('timezone_format', 'LIKE', '%' . $timezoneOffset . '%')->first();
        return   $timezone;
    }

    public static function getUserTimeZoneById($timezoneId)
    {
        $timezone = DB::table('ref_timezones')->where('id', $timezoneId)->whereNull('deleted_at')->first();
        return   $timezone;
    }
    public static function getTimeZone()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $timezone = $Corefunctions->convertToArray(DB::table('ref_timezones')->whereNull('deleted_at')->get());
        return   $timezone;
    }

    public static function getUserByEmail($email)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userDetails = $Corefunctions->convertToArray(DB::table('users')->select('id', 'user_uuid', 'phone_number', 'email', 'first_name', 'country_id', 'last_login_clinic_id')->where('email', $email)->first());
        return   $userDetails;
    }

    public static function getUserByEmailPhone($input, $countryCodeId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userDetails = $Corefunctions->convertToArray(User::where('email', $input['email'])->first());

        $userDetailsPhone = $Corefunctions->convertToArray(User::where('phone_number', $input['phone_number'])->where('country_code', $countryCodeId)->first());

        $hasData = empty($userDetails) && empty($userDetailsPhone) ? 1 : 0;

        return $hasData;
    }
    public static function getCountryCodes()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $countryDetails = $Corefunctions->convertToArray(DB::table('ref_country_codes')->select('country_name', 'country_code', 'short_code', 'id')->whereNull('deleted_at')->get());
        return $countryDetails;
    }
    public static function getStates()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $stateDetails = $Corefunctions->convertToArray(DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->get());
        return $stateDetails;
    }
    public static function getDesignations()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $designationDetails = $Corefunctions->convertToArray(DB::table('ref_designations')->select('name', 'id')->get());
        return $designationDetails;
    }
    public static function getSpecialities()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $specialities = $Corefunctions->convertToArray(DB::table('ref_specialties')->select('id', 'specialty_name')->get());
        return $specialities;
    }
    public static function checkAdminExist($userID)
    {
        $adminexist = DB::table('clinic_users')->where('clinic_id', session('user.clinicID'))->where('id', '!=', $userID)->where('user_type_id', '1')->where('status', '1')->whereNull('deleted_at')->count();
        return $adminexist;
    }
    public static function removeAccount($userid, $phone, $email)
    {
        DB::table('users')->where('id', $userid)->limit(1)->update(array(
            'phone_number' => $phone . '_' . Carbon\Carbon::now(),
            'email' => $email . '_' . Carbon\Carbon::now(),
            'account_deleted' => '1',
            'deleted_at' => Carbon\Carbon::now()
        ));
        DB::table('patients')->where('user_id', $userid)->limit(1)->update(array(
            'phone_number' => $phone . '_' . Carbon\Carbon::now(),
            'email' => $email . '_' . Carbon\Carbon::now(),
            'account_deleted' => '1',
            'deleted_at' => Carbon\Carbon::now()
        ));
    }
    public static function removeClinicUserAccount($clinicuserid, $userid, $phone, $email)
    {
        DB::table('users')->where('id', $userid)->limit(1)->update(array(
            'phone_number' => $phone . '_' . Carbon\Carbon::now(),
            'email' => $email . '_' . Carbon\Carbon::now(),
            'account_deleted' => '1',
            'deleted_at' => Carbon\Carbon::now()
        ));
        DB::table('clinic_users')->where('id', $clinicuserid)->limit(1)->update(array(
            'phone_number' => $phone . '_' . Carbon\Carbon::now(),
            'email' => $email . '_' . Carbon\Carbon::now(),
            'account_deleted' => '1',
            'deleted_at' => Carbon\Carbon::now()
        ));
    }

    public static function updateUserTimezone($userID, $timezoneId)
    {
        DB::table('users')->where('id', $userID)->limit(1)->update(array(
            'timezone_id' => $timezoneId,
            'updated_at' => Carbon\Carbon::now()
        ));
    }

    public function designation()
    {
        return $this->belongsTo(RefDesignation::class, 'designation_id', 'id');
    }

    public static function updateUsers($parentDetails, $userID)
    {
        DB::table('users')->where('id', $userID)->limit(1)->update(array(
            'status' => '1',
            'last_login_clinic_id' => $parentDetails['clinic_id'],
            'profile_image' => isset($parentDetails['logo_path']) && $parentDetails['logo_path'] != '' ? $parentDetails['logo_path'] : '',
            'updated_at' => Carbon\Carbon::now()
        ));
    }

    public static function getUserDetails($input, $type = '', $countryId = '')
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userDetails = User::whereNull('deleted_at')->where('status', '1');

        if (isset($type) && $type == 'email') {
            $userDetails = $userDetails->where('email', $input['email'])->first();
        } else {
            $userDetails = $userDetails->where('phone_number', $input['phone_number'])->where('country_code', $countryId)->first();
        }
        $userDetails = $Corefunctions->convertToArray($userDetails);
        return $userDetails;
    }
    public static function updateLastLoginClinic($userID, $clinicID)
    {
        DB::table('users')->where('id', $userID)->update(array(
            'last_login_clinic_id' => $clinicID,
            'updated_at' => Carbon\Carbon::now(),
        ));
    }
    public static function updateUser($input, $clinicID)
    {
        DB::table('users')->where('email', $input['email'])->where('phone_number', $input['phone_number'])->update(array(
            'first_name'           => $input['first_name'],
            'last_name'           => isset($input['last_name']) ? $input['last_name'] : '',
            'last_login_clinic_id' => $clinicID,
            'status' => '1',
        ));
    }



    public static function checkUserExistance($input, $countryID, $type, $clinicUserId = null)
    {

        // Check for email associated with a different phone number
        $userDetails = User::withTrashed()
            ->where('email', $input['user_email'])
            ->where('phone_number', '!=', $input['user_phone'])
            ->when($clinicUserId, fn($q) => $q->where('id', '!=', $clinicUserId))
            ->exists();

        if ($userDetails) {
            return [
                'error' => false,
                'message' => 'Email is already associated with another number.',
            ];
        }

        // Check for phone number associated with a different email
        $phoneDetails = User::withTrashed()
            ->where('phone_number', $input['user_phone'])
            ->where('email', '!=', $input['user_email'])
            ->when($clinicUserId, fn($q) => $q->where('id', '!=', $clinicUserId))
            ->exists();

        if ($phoneDetails) {
            return [
                'error' => 1,
                'message' => 'Phone number is already associated with another email.',
            ];
        }

        return ['valid' => true]; // No conflicts found
    }


    public static function insertUser($input, $userCountryCode = array(), $clinicID = '', $status = '1')
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userUuid = $Corefunctions->generateUniqueKey("10", "users", "user_uuid");
        $insertid = DB::table('users')->insertGetId(array(
            'user_uuid'            => $userUuid,
            'first_name'           => $input['first_name'],
            'middle_name'          => (isset($input['middle_name']) && $input['middle_name'] != '') ? $input['middle_name'] : '',
            'last_name'            => isset($input['last_name']) ? $input['last_name'] : '',
            'phone_number'         => $input['user_phone'],
            'country_code'         => !empty($userCountryCode) ? $userCountryCode['id'] : $input['country_code'],
            'last_login_clinic_id' => $clinicID != '' ? $clinicID : null,
            'dob'                  => (isset($input['dob']) && $input['dob'] != '') ? date('Y-m-d', strtotime($input['dob'])) : NULL,
            'gender'               => isset($input['gender']) && $input['gender'] != '' ? $input['gender'] : null,
            'email'                => isset($input['user_email']) && $input['user_email'] != '' ? $input['user_email'] : $input['email'],
            'status'               => $status,
            'address'              => isset($input['address']) && ($input['address'] != '') ? $input['address'] : null,
            'city'                 => isset($input['city']) && ($input['city'] != '') ? $input['city']  : null,
            'zip_code'             => isset($input['zip']) && ($input['zip'] != '') ? $input['zip']  : null,
            'state'                => isset($input['state']) && ($input['state'] != '') ? $input['state'] : null,
            'state_id'             => isset($input['state_id']) && ($input['state_id'] != '') ? $input['state_id'] : null,
            'fax'                  => isset($input['fax']) && ($input['fax'] != '') ? $input['fax'] : null,
            'created_at'           => Carbon\Carbon::now()
        ));
        return $insertid;
    }
    public static function insertUserSession($userId)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userUuid = $Corefunctions->generateUniqueKey("32", "user_sessions", "user_session_id");
        $insertid = DB::table('user_sessions')->insertGetId(array(
            'user_session_id'            => $userUuid,
            'user_id'           => $userId,
            'created_at'           => Carbon\Carbon::now()
        ));
        return $insertid;
    }
    public static function insertUserConnection($userID, $connectionID, $sessionID)
    {

        $Corefunctions = new \App\customclasses\Corefunctions;

        return DB::table('user_connections')->insertGetId(array(
            'user_id'       =>  $userID,
            'connection_id' =>   $connectionID,
            'user_session_id'     =>  $sessionID,
            'status'        =>  '1',
            'created_at'     => Carbon\Carbon::now()
        ));
    }
    public static function getUserSessionID($sessionID)
    {

        $Corefunctions = new \App\customclasses\Corefunctions;

        $userSessions = DB::table('user_sessions')->where('id', $sessionID)->where('status', '1')->whereNull('deleted_at')->first();
        return $userSessions;
    }

    public static function updateUserData($input, $countryCodedetails, $userDetails)
    {

        DB::table('users')->where('id', $userDetails->id)->limit(1)->update(array(
            'first_name'    => $input['username'],
            'middle_name'   => isset($input['middle_name']) && $input['middle_name'] != '' ? $input['middle_name'] : null,
            'last_name'     => isset($input['last_name']) ? $input['last_name'] : null,
            'email'         => $input['email'],
            'phone_number'  => isset($input['phone_number']) ? $input['phone_number'] : $userDetails->phone_number,
            'country_code'  => !empty($countryCodedetails) ? $countryCodedetails['id'] : $userDetails->country_code,
            'profile_image' => isset($input['crppath']) ? $input['crppath'] : $userDetails->profile_image,
            'address'       => (isset($input['address']) && $input['address'] != '')  ? $input['address'] : $userDetails->address,
            'city'          => (isset($input['city']) && $input['city'] != '')  ? $input['city'] : $userDetails->city,
            'zip_code'      => (isset($input['zip']) && $input['zip'] != '')  ? $input['zip'] : $userDetails->zip_code,
            'state'         => isset($input['state']) && ($input['state'] != '')  ? $input['state'] : $userDetails->state,
            'state_id'      => isset($input['state_id']) && ($input['state_id'] != '') ? $input['state_id'] : $userDetails->state_id,
            'dob'           => (isset($input['dob']) && $input['dob'] != '') ? date('Y-m-d', strtotime($input['dob'])) : $userDetails->dob,
            'fax'           => (isset($input['fax']) && $input['fax'] != '') ? $input['fax'] : '',
            'updated_at'    => Carbon\Carbon::now()
        ));
    }

    public static function updateUserPhone($countryId, $phone, $userID)
    {
        DB::table('users')->where('id', $userID)->update(array(
            'country_code' => $countryId,
            'phone_number' => $phone
        ));
    }
    public static function updateUserAddress($parentDetails, $userId)
    {
        DB::table('users')->where('id', $userId)->update(array(
            "address" => $parentDetails['address'],
            "city" => $parentDetails['city'],
            "state" => isset($parentDetails['state']) && ($parentDetails['state'] != '')  ? $parentDetails['state'] : null,
            "state_id" => isset($parentDetails['state_id']) && ($parentDetails['state_id'] != '') ? $parentDetails['state_id'] : null,
            "zip_code" => $parentDetails['zip'],
            "status"  => '1',
            'updated_at' => Carbon\Carbon::now()
        ));
    }

    public static function updateImageToTable($table, $columnName, $userID, $image_path)
    {

        DB::table($table)->where('id', $userID)->update(array(
            $columnName => $image_path,
        ));
    }
    public static function validateUser($data, $clinicUserId, $field1, $field2, $countryID = '')
    {

        $userDetails = User::withTrashed()->where($field1, $data[$field1])->where($field2, '!=', $data[$field2])->where('country_code', $countryID)->when($clinicUserId, fn($q) => $q->where('id', '!=', $clinicUserId))->count();
        // echo $userDetails;die;
        return  $userDetails;
    }
    public static function validatePhoneUser($data, $clinicUserId, $field1, $field2, $countryID = '')
    {

        $userDetails = User::withTrashed()->where($field1, $data[$field1])->where($field2, '!=', $data[$field2])->where('country_code','!=',$countryID)->when($clinicUserId, fn($q) => $q->where('id', '!=', $clinicUserId))->count();
        // echo $userDetails;die;
        return  $userDetails;
    }
    public static function validateUserWithCountyCode($data, $clinicUserId, $field1, $field2, $countryID)
    {

        $userDetails = User::withTrashed()->where($field1, $data[$field1])->where($field2, $data[$field2])->where('country_code', '!=', $countryID)->when($clinicUserId, fn($q) => $q->where('id', '!=', $clinicUserId))->count();
        // print_r($userDetails);exit;
        return  $userDetails;
    }

    public static function validateUserByEmail($data, $clinicId, $clinicUserId, $table)
    {

        $parentdetails = DB::table($table)->where('email', $data['email'])->where('clinic_id', $clinicId)->when($clinicUserId, fn($q) => $q->where('user_id', '!=', $clinicUserId))->count();
        // print_r($parentdetails);exit;
        return  $parentdetails;
    }

    public static function validateUserByPhone($data, $clinicId, $clinicUserId, $table, $countryID)
    {

        $parentdetails = DB::table($table)->where('phone_number', $data['phone_number'])->where('country_code', $countryID)->where('clinic_id', $clinicId)->when($clinicUserId, fn($q) => $q->where('user_id', '!=', $clinicUserId))->count();
        
        return  $parentdetails;
    }

    public static function validateUserByEmailRegister($data, $clinicUserId, $table)
    {

        $parentdetails = DB::table($table)->where('email', $data['email'])->when($clinicUserId, fn($q) => $q->where('user_id', '!=', $clinicUserId))->count();
        // print_r($parentdetails);exit;
        return  $parentdetails;
    }

    public static function validateUserByPhoneRegister($data, $clinicUserId, $table, $countryID)
    {

        $parentdetails = DB::table($table)->where('phone_number', $data['phone_number'])->where('country_code', $countryID)->when($clinicUserId, fn($q) => $q->where('user_id', '!=', $clinicUserId))->count();
        return  $parentdetails;
    }
    public static function validateUserByProfile($data, $table, $countryID)
    {

        $parentdetails = DB::table($table)->where('phone_number', $data['phone_number'])->where('country_code', $countryID)->where('email', $data['email'])->count();
        return  $parentdetails;
    }

    public static function updateUserStatus($userId)
    {
        DB::table('users')->where('id', $userId)->update(array(
            'status' => '1',
            'updated_at' => Carbon\Carbon::now()
        ));
    }
    public static function disconnectConnection($connection_id)
    {
        DB::table('user_connections')->where('connection_id', $connection_id)->update(array(
            'status' => '0',
            'deleted_at' => Carbon\Carbon::now()
        ));
    }

    public static function addLoginInfo($city, $region, $country, $loc, $ip, $devicetype, $browser, $userID)
    {
        return DB::table('login_info')->insertGetId(array(
            'user_id' => $userID,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'location' => $loc,
            'ip' => $ip,
            'device_type' => isset($devicetype) ? $devicetype : 'web',
            'browser'  => $browser,
            'created_at' => Carbon\Carbon::now(),

        ));
        return $logininfoid;
    }
    public static function getSpecialityByID($specialityID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $specialities = $Corefunctions->convertToArray(DB::table('ref_specialties')->select('id', 'specialty_name', 'dosespot_speciality_id')->where('id', $specialityID)->first());
        return $specialities;
    }

    public static function updateClinicUserDosepotKey($userID, $dosepotid)
    {
        return  DB::table('users')->where('id', $userID)->update(array(
            "dosespot_clinician_id"      => $dosepotid,
            "updated_at"                 => Carbon\Carbon::now()
        ));
    }


    public static function updateDosepotUserData($input, $userDetails)
    {

        DB::table('users')->where('id', $userDetails->id)->limit(1)->update(array(
            'first_name'    => $input['username'],
            'last_name'     => isset($input['last_name']) ? $input['last_name'] : null,
            'address'       => (isset($input['user_address']) && $input['user_address'] != '')  ? $input['user_address'] : $userDetails->address,
            'city'          => (isset($input['user_city']) && $input['user_city'] != '')  ? $input['user_city'] : $userDetails->city,
            'zip_code'      => (isset($input['user_zip']) && $input['user_zip'] != '')  ? $input['user_zip'] : $userDetails->zip_code,
            'state'         => isset($input['user_state']) && ($input['user_state'] != '')  ? $input['user_state'] : $userDetails->state,
            'state_id'      => isset($input['user_state_id']) && ($input['user_state_id'] != '') ? $input['user_state_id'] : $userDetails->state_id,
            'dob'           => (isset($input['dob']) && $input['dob'] != '') ? date('Y-m-d', strtotime($input['dob'])) : $userDetails->dob,
            'fax'           => (isset($input['fax']) && $input['fax'] != '') ? $input['fax'] : '',
            'updated_at'    => Carbon\Carbon::now()
        ));
    }
    public static function UserByClinicianDosespotIDS($clinicianDosespotIDS)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        if (empty($clinicianDosespotIDS)) {
            return array();
        }
        $result = $Corefunctions->convertToArray(DB::table('users')->select('id', 'first_name', 'last_name', 'dosespot_clinician_id')->whereIn('dosespot_clinician_id', $clinicianDosespotIDS)->get());
        $result =    $Corefunctions->getArrayIndexed1($result, 'dosespot_clinician_id');
        return $result;
    }
    public static function updateAccountBalance($userId, $balanceAmount)
    {
        DB::table('users')->where('id', $userId)->update(array(
            'account_balance' => $balanceAmount
        ));
    }

    public static function getUserTypes()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $userTypes = $Corefunctions->convertToArray(DB::table('ref_user_types')->where('id', '!=', '4')->get());
        return $userTypes;
    }
    public static function userByIDS($userIDS = array())
    {
        if (empty($userIDS)) {
            return array();
        }
        $Corefunctions = new \App\customclasses\Corefunctions;
        $user = DB::table('users')->select('id', 'first_name', 'last_name', 'profile_image')->whereIn('id', $userIDS)->get();
        $user =  $Corefunctions->convertToArray($user);
        $user =    $Corefunctions->getArrayIndexed1($user, 'id');
        return $user;
    }
    public static function userByIDss($userID, $status = '')
    {
        $user = DB::table('users')->where('id', $userID);
        if ($status != 'all') {
            $user = $user->where('status', '1');
        }
        $user = $user->first();
        return $user;
    }
}
