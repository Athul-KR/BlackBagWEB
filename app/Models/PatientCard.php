<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
class PatientCard extends Model
{
    use HasFactory, SoftDeletes;

    public static function getCardsById($userCardId){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $cardDetails = $Corefunctions->convertToArray(DB::table('patient_cards')->select('card_type')->where('id', $userCardId)->limit(1)->first());

		return $cardDetails;
	}
    public static function getUserCardByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $cardDetails     = DB::table('patient_cards')->where('patient_card_uuid', $key)->whereNull('deleted_at')->first();
        $cardDetails     = $Corefunctions->convertToArray($cardDetails);
        return $cardDetails;
    }
    public static function checkCardExists($userID,$input){ 
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = DB::table('patient_cards')->where('user_id',$userID)->whereNull('deleted_at')->where('card_num',$input['card_number'])->first();
        $result = $Corefunctions->convertToArray($result);
    
        return $result; 
    } 
    public static function getDefaultUserCards($userIDS){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCards = $Corefunctions->convertToArray(DB::table('patient_cards')->whereIn('user_id', $userIDS)->where('is_default','1')->whereNull('deleted_at')->get());
        return $userCards;
	}
    public static function getUserCardByUserIds($userIds){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCards = $Corefunctions->convertToArray(DB::table('patient_cards')->whereIn('user_id', $userIds)->where('is_default','1')->whereNull('deleted_at')->get());
        return $userCards;
	}
    public static function removeDefaultCard($userId){
        DB::table('patient_cards')->where('is_default', '1')->where('user_id', $userId)->whereNull('deleted_at')->update(array(
            'is_default' => '0'
        ));
	}
    public static function markAsDefault($key,$userId){
        DB::table('patient_cards')->where('patient_card_uuid', $key)->where('is_default', '0')->where('user_id', $userId)->limit(1)->update(array(
            'is_default' => '1',
        ));
	}
    public static function removeUserCard($key){
        DB::table('patient_cards')->where('patient_card_uuid',$key)->limit(1)->update(array(
            'deleted_at' => Carbon\Carbon::now()
        ));
    }
    public static function addUserCards($inputArray,$userId,$is_default = '0'){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $key = $Corefunctions->generateUniqueKey('10', 'patient_cards', 'patient_card_uuid');
        $Id =  DB::table('patient_cards')->insertGetId(array(
            'patient_card_uuid' =>  $key,
            'stripe_card_id' =>  $inputArray['stripe_cardid'],
            'exp_month' =>  $inputArray['exp_month'],
            'exp_year' =>  $inputArray['exp_year'],
            'card_type' =>  $inputArray['cardtype'],
            'name_on_card' =>  $inputArray['nameoncard'],
            'card_num' =>  $inputArray['card_number'],
            'user_id' =>  $userId,	  		    		  
            'is_default' =>  $is_default,	  	 
            'created_at' => Carbon\Carbon::now()
        ));
        return $Id;
    }
    public static function getUserCards($userId){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCards = $Corefunctions->convertToArray(DB::table('patient_cards')->where('user_id', $userId)->whereNull('deleted_at')->get());
        return $userCards;
	}
    public static function getDefaultUserCard($patientID){
        $Corefunctions = new \App\customclasses\Corefunctions;

        $userCards = $Corefunctions->convertToArray(DB::table('patient_cards')->where('user_id', $patientID)->where('is_default','1')->whereNull('deleted_at')->first());
        return $userCards;
	}
    
}
