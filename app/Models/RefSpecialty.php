<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class RefSpecialty extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function getSpeciality(){
        $Corefunctions = new \App\customclasses\Corefunctions;
		return  $Corefunctions->convertToArray(DB::table('ref_specialties')->select('id', 'specialty_name')->get());
	}
    public static function fetchSpeciality($specialty){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $specialties = $Corefunctions->convertToArray(DB::table('ref_specialties')->select('specialty_name', 'id')->whereRaw('LOWER(specialty_name) = ?', [strtolower($specialty)])->first());
        return $specialties ;
    }

    public static function getSpecialityByIDs($specialtyIds){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $specialtyDetails = $Corefunctions->convertToArray(DB::table('ref_specialties')->whereIn('id', $specialtyIds)->select('specialty_name', 'id')->get());
        $specialtyDetails = $Corefunctions->getArrayIndexed1($specialtyDetails, 'id');
        return $specialtyDetails ;

	}
}
