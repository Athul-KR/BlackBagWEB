<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;

class RefCountryCode extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ref_country_codes';
    protected $guarded = [''];

    public static function getCountryCodeByShortCode($shortCode){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $countryCode = $Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id','country_code','short_code')->where('short_code', strtoupper($shortCode))->first());
        return $countryCode ;
	}
    public static function getCountryCodeById($countryID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $countryCode = $Corefunctions->convertToArray(DB::table('ref_country_codes')->select('country_code', 'id','short_code','country_name')->where('id',$countryID)->first());
        return $countryCode ;
	}

    public static function getCountryCodeByCode($countrycode){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $countryCodedetails = $Corefunctions->convertToArray(DB::table('ref_country_codes')->select('id','short_code')->where('country_code', $countrycode)->orWhere('country_code', '+' . $countrycode)->orderBy('id', 'desc')->first());
        return $countryCodedetails ;
	}
    public static function getCountryCodeByIDS($countrycodeIds){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $countryCodedetails = $Corefunctions->convertToArray(DB::table('ref_country_codes')->select('country_code', 'id')->whereIn('id', $countrycodeIds)->get());
        $countryCodedetails = $Corefunctions->getArrayIndexed1($countryCodedetails, 'id');
        return $countryCodedetails ;
	}
    public static function getAllCountry(){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $countryDetails = $Corefunctions->convertToArray(DB::table('ref_country_codes')->whereNull('deleted_at')->get());
        return $countryDetails ;
	}


    
}
