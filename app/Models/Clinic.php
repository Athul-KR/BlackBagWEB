<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
class Clinic extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function states()
    {
        return $this->belongsTo(RefState::class, 'state_id');
    }

    public function clinicUsers()
    {
        return $this->hasOne(ClinicUser::class, 'clinic_id')->where('user_type_id', '1');
    }
    
    public static function countryCodeByShortCode($countryCodeShort){
         return DB::table('ref_country_codes')
                ->select('id', 'short_code')
                ->where('short_code', $countryCodeShort)
                ->first();
    }
    public static function clinicByID($id){
        return DB::table('clinics')
               ->where('id', $id)
               ->first();
    }
    public static function latestClinic(){
        return DB::table('clinics')
               ->select('id', 'clinic_uuid', 'name', 'email', 'logo', 'stripe_connection_id', 'stripe_customer_id', 'account_locked', 'deleted_at')
               ->orderBy('id','desc')
               ->first();
    }
    public static function clinicByUUID($uuid){
         return DB::table('clinics')
                ->where('clinic_uuid', $uuid)
                ->first();
    }
    public static function getclinicByID($id){
        return DB::table('clinics')
               ->whereIn('id', $id)
               ->get();
    }
    public static function getClinicWithstate($clinicId,$type=''){
        if($type == 'tab'){
            return Clinic::with('states', 'clinicUsers')->find($clinicId);
        }else{
            return Clinic::with('states')->find($clinicId);
        }
        
    }
    public static function getReceiptClinicByID($id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $clinicDetails = $Corefunctions->convertToArray(DB::table('clinics')->select('name','phone_number','address as billing_address','state as billing_state','city as billing_city','zip_code as billing_zip','country_id as billing_country_id','state_id','country_code','logo')->where('id',$id)->limit(1)->first());
        return $clinicDetails ;
    }
    public static function updateClinic($uuid,$input,$crppathLogo,$crppathBanner,$countryCode){
        return  DB::table('clinics')->where('clinic_uuid', $uuid)->update(array(
            "name" => $input['name'],
            "email" => $input['email'],
            "phone_number" => $input['phone'],
            "country_code" => $countryCode['id'],
            "website_link" => isset($input['website_link']) ? $input['website_link'] : null,
            "timezone_id" => isset($input['timezone_id']) ? $input['timezone_id'] : 6,
            "address" => $input['address'],
            "city" => $input['city'],
            "state_id" => isset($input['state_id']) && $input['state_id'] != '' ? $input['state_id'] : null,
            "state" => isset($input['state']) && $input['state'] != '' ? $input['state'] : null,
            "country_id" => !empty($input['country_id']) ? $input['country_id'] : NULL,
            "zip_code" => $input['zip_code'],
            "logo" => $crppathLogo,
            "banner_img" => $crppathBanner,
        ));
    }

    public static function updateLastOnboarding($clinicId,$lastStep){
        return  DB::table('clinics')->where('id', $clinicId)->update(array(
            "last_onboarding_step" => $lastStep,
            "updated_at"           => Carbon\Carbon::now()
        ));
    }
    public static function completeOnboarding($clinicId){
        return  DB::table('clinics')->where('id', $clinicId)->update(array(
            "onboarding_complete" => '1',
            "updated_at"           => Carbon\Carbon::now()
        ));
    }


    public static function updateClinicAppoinmentFee($input,$clinicId){
        return  DB::table('clinics')->where('id', $clinicId)->update(array(
            "appointment_type_id"           => isset($input['appointment_type']) && $input['appointment_type'] !='' ?  $input['appointment_type'] : null ,
            "inperson_fee"                  => isset($input['appointment_type']) && ( $input['appointment_type'] =='2' || $input['appointment_type'] =='3' ) && isset($input['inperson_fee']) && $input['inperson_fee'] !='' ?  $input['inperson_fee'] : null ,
            "virtual_fee"                   => isset($input['appointment_type']) && ($input['appointment_type'] =='1' || $input['appointment_type'] =='3') && isset($input['virtual_fee']) && $input['virtual_fee'] !='' ?  $input['virtual_fee'] : null ,
            "in_person_mark_as_no_show_fee" => isset($input['appointment_type']) && ( $input['appointment_type'] =='2' || $input['appointment_type'] =='3' ) && isset($input['in_person_mark_as_no_show_fee']) && $input['in_person_mark_as_no_show_fee'] !='' ?  $input['in_person_mark_as_no_show_fee'] : null ,
            "in_person_cancellation_fee"    => isset($input['appointment_type']) && ( $input['appointment_type'] =='2' || $input['appointment_type'] =='3' ) && isset($input['in_person_cancellation_fee']) && $input['in_person_cancellation_fee'] !='' ?  $input['in_person_cancellation_fee'] : null ,
            "virtual_mark_as_no_show_fee"   => isset($input['appointment_type']) && ($input['appointment_type'] =='1' || $input['appointment_type'] =='3') && isset($input['virtual_mark_as_no_show_fee']) && $input['virtual_mark_as_no_show_fee'] !='' ?  $input['virtual_mark_as_no_show_fee'] : null ,
            "virtual_cancellation_fee"      => isset($input['appointment_type']) && ($input['appointment_type'] =='1' || $input['appointment_type'] =='3') && isset($input['virtual_cancellation_fee']) && $input['virtual_cancellation_fee'] !='' ?  $input['virtual_cancellation_fee'] : null ,
            // "consultation_time_id"       => isset($input['timeduration']) && $input['timeduration'] !='' ?  $input['timeduration'] : null ,
            // "consultation_time"          => isset($input['timeduration']) && $input['timeduration'] == '7' ?  $input['customduration'] : null ,
            "updated_at"                    => Carbon\Carbon::now()
        ));
    }



    public static function getAccessSeoDetails($clinicDetails){ 
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('seo')->where('clinicid',$clinicDetails['id']);
        
        $result = $result->first();
        $result = $Corefunctions->convertToArray($result);
        return $result;
    } 
    public static function addSeoDetils($clinicDetails,$seoDetails){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $seoKey = $Corefunctions->generateUniqueKey('6', 'seo', 'seokey');
                   
        $insertid = DB::table('seo')->insertGetId(array(
          'seokey' => $seoKey,
          'title' => $seoDetails['title'],
          'description' => $seoDetails['description'],
          'keywords' => $seoDetails['keywords'],
          'ogtitle' => $seoDetails['ogtitle'],
          'ogimage' => isset($seoDetails['ogimage']) ? $seoDetails['ogimage'] : '',
          'twittercard' => isset($seoDetails['twittercard']) ? $seoDetails['twittercard'] : '',
          'clinicid' => !empty($clinicDetails) ? $clinicDetails['id'] : '',
          'created_at' => Carbon\Carbon::now()
        ));
        return array('seokey'=>$seoKey,'seoid'=>$insertid);
    }
    public static function updateSeoDetils($seokey,$fieldname,$fielddata){      
        DB::table('seo')->where('seokey',$seokey)->limit(1)->update(array(
            $fieldname => $fielddata,
            'updated_at' => Carbon\Carbon::now()
        ));
        return ;
    }
    public static function getClinicUserByEmailPhone($input){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $clinicuserDetails = $Corefunctions->convertToArray(ClinicUser::where('phone_number', $input['phone_number'])->where('email', $input['email'])->withTrashed()->first());
        
        return $clinicuserDetails;
    }

    public static function getStripeConnectId($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $clinicDetails = $Corefunctions->convertToArray( DB::table('clinics')->where('id', $clinicId)->select('stripe_connection_id')->first());
        return $clinicDetails['stripe_connection_id'];
    }

    public static function insertClinic($input,$clinicCountryCode){
        $Corefunctions = new \App\customclasses\Corefunctions;
      
        $clinicUuid = $Corefunctions->generateUniqueKey("10", "clinics", "clinic_uuid");
        $insertid = DB::table('clinics')->insertGetId(array(
            'clinic_uuid'   => $clinicUuid,
            'name'          => $input['clinic_name'],
            'email'         => isset($input['email']) ? $input['email'] : null,
            'phone_number'  => isset($input['phone_number']) ? $input['phone_number'] : null ,
            'country_code'  => !empty($clinicCountryCode) ? $clinicCountryCode['id'] : null,
            'country_id'    => isset($input['country_id']) && !empty($input['country_id']) ? $input['country_id'] : null,
            'address'       => isset($input['address']) ? $input['address'] : null,
            'city'          => isset($input['city']) ? $input['city'] : null,
            'state_id'      => isset($input['state_id']) && $input['state_id'] != '' ? $input['state_id'] : null,
            'state'         => isset($input['state']) && $input['state'] != '' ? $input['state'] : null,
            'zip_code'      => isset($input['zip']) ? $input['zip'] : null,
            'created_at'    => Carbon\Carbon::now()

        ));
        return $insertid ;
    }

    public static function getClinicCountByEmail($email){
        $clinicCount = DB::table('clinics')->where('email', $email)->withTrashed()->count();
        
        return $clinicCount;
    }
    
    public static function insertClinicAddon($clinicId,$addonId){
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-01', strtotime('+1 month'));
        $id = DB::table('clinic_addons')->insertGetId(array(
            'add_on_id' => $addonId,
            'clinic_id' => $clinicId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'created_at' => Carbon\Carbon::now(),
        ));
        return $id;
    }

    public static function getEprescribeEnabledClinics(){
        return DB::table('clinic_addons')->join('clinics','clinics.id','=','clinic_addons.clinic_id')->whereNull('clinics.deleted_at')->whereNull('clinic_addons.deleted_at')->get();
    }

    public static function checkEprescribeEnabled($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray( DB::table('clinic_addons')->whereNull('deleted_at')->where('clinic_id',$clinicId)->first() );
        $isEprescribeEnabled = ( !empty( $result ) ) ? '1' : '0';
        return $isEprescribeEnabled;
    }

    public static function getPatientTaggedClinicIDs($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $patients =  $Corefunctions->convertToArray( DB::table('patients')->where('user_id',$userID)->get() );
        $clinicIDs = $Corefunctions->getIDSfromArray($patients, 'clinic_id');
        return $clinicIDs;
    }
    
    public static function getClinics($clinicIDs){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $clinics =  $Corefunctions->convertToArray( DB::table('clinics')->select('name','id','logo')->whereIn('id',$clinicIDs)->get() );
        return $clinics;
    }
      public static function updateDosepotKey($clinicId,$dosepotid,$dosepotkey){
        return  DB::table('clinics')->where('id', $clinicId)->update(array(
            "dosepot_id"          => $dosepotid,
            "dosepot_key"         => $dosepotkey,
            "updated_at"          => Carbon\Carbon::now()
        ));
    }
      public static function selectedClinicByID($id){
        return DB::table('clinics')->select('id','clinic_uuid','name','dosepot_id','dosepot_key','phone_number')->where('id', $id)->first();
    }
    
    public static function clinicByDosespotIDS($clinicDosespotIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
          if( empty($clinicDosespotIDS)){ return array(); }
        $result = $Corefunctions->convertToArray(DB::table('clinics')->select('id','dosepot_id')->whereIn('dosepot_id', $clinicDosespotIDS)->get());
         $result =    $Corefunctions->getArrayIndexed1($result,'dosepot_id');
        return $result ;
	}
    public static function clinicByIDS($clinicIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;
          if( empty($clinicIDS)){ return array(); }
        $result = $Corefunctions->convertToArray(DB::table('clinics')->whereIn('id', $clinicIDS)->get());
         $result =    $Corefunctions->getArrayIndexed1($result,'id');
        return $result ;
	}
     
    
}
