<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class ClinicCard extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'clinic_cards';

    public static function getUserCardByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $cardDetails     = DB::table('clinic_cards')->select('is_default','id')->where('clinic_card_uuid', $key)->whereNull('deleted_at')->first();
        $cardDetails     = $Corefunctions->convertToArray($cardDetails);
        return $cardDetails;
    }
    public static function getUserCardCount($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCardCount = $Corefunctions->convertToArray(DB::table('clinic_cards')->where('clinic_id', $clinicId)->where('is_default','1')->whereNull('deleted_at')->limit(1)->count());
        return $userCardCount;
	}
    public static function getUserCards($clinicId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCards = $Corefunctions->convertToArray(DB::table('clinic_cards')->select('id','name_on_card', 'card_type', 'card_number', 'exp_year', 'exp_month','clinic_card_uuid','is_default')->orderBy('is_default','desc')->where('clinic_id', $clinicId)->whereNull('deleted_at')->get());
        return $userCards;
	}
    public static function removeDefaultCard($clinicId){
        DB::table('clinic_cards')->where('is_default', '1')->where('clinic_id', $clinicId)->whereNull('deleted_at')->update(array(
            'is_default' => '0'
        ));
	}
    public static function markAsDefault($key,$clinicId){
        DB::table('clinic_cards')->where('clinic_card_uuid', $key)->where('is_default', '0')->where('clinic_id', $clinicId)->limit(1)->update(array(
            'is_default' => '1',
        ));
	}
    public static function removeUserCard($key){
        DB::table('clinic_cards')->where('clinic_card_uuid',$key)->limit(1)->update(array(
            'deleted_at' => Carbon\Carbon::now()
        ));
    }
    public static function checkCardExists($clinicID,$input){ 
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('clinic_cards')->where('clinic_id',$clinicID)->whereNull('deleted_at')->where('card_number',$input['card_number'])->first();
        $result = $Corefunctions->convertToArray($result);
    
        return $result; 
    } 
    public static function getDefaultUserCards($clinicIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCards = $Corefunctions->convertToArray(DB::table('clinic_cards')->whereIn('clinic_id', $clinicIDS)->where('is_default','1')->whereNull('deleted_at')->get());
        return $userCards;
	}
    public static function getDefaultUserCard($clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCards = $Corefunctions->convertToArray(DB::table('clinic_cards')->where('clinic_id', $clinicID)->where('is_default','1')->whereNull('deleted_at')->first());
        return $userCards;
	}
    public static function getUserCardByUserIds($userIds){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCards = $Corefunctions->convertToArray(DB::table('clinic_cards')->whereIn('added_by', $userIds)->where('is_default','1')->whereNull('deleted_at')->get());
        return $userCards;
	}
    public static function addUserCards($inputArray,$userId,$is_default = '0',$clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('10', 'clinic_cards', 'clinic_card_uuid');
        $Id =  DB::table('clinic_cards')->insertGetId(array(
            'clinic_card_uuid' =>  $key,
            'stripe_card_id' =>  $inputArray['stripe_cardid'],
            'exp_month' =>  $inputArray['exp_month'],
            'exp_year' =>  $inputArray['exp_year'],
            'card_type' =>  $inputArray['cardtype'],
            'name_on_card' =>  $inputArray['nameoncard'],
            'card_number' =>  $inputArray['card_number'],
            'added_by' =>  $userId,	  		    		  
            'is_default' =>  $is_default,	  		  
            'clinic_id' =>  $clinicID,	  		  
            'created_at' => Carbon\Carbon::now()
        ));
        return $Id;
    }
}
