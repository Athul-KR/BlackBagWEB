<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class RefDesignation extends Model
{
    use HasFactory, SoftDeletes;

    
 	public static function getDesignation(){
        $Corefunctions = new \App\customclasses\Corefunctions;
		return  $Corefunctions->convertToArray(DB::table('ref_designations')->where('type', 'doctor')->select('name', 'id')->get());
	}
	public static function designationByID($designationID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $designationDeatils = $Corefunctions->convertToArray(DB::table('ref_designations')->select('name', 'id')->where('id', $designationID)->first());
		return $designationDeatils ;
	}
	public static function fetchDesignation($designation){
        $Corefunctions = new \App\customclasses\Corefunctions;

		$designation = $Corefunctions->convertToArray(DB::table('ref_designations')->where('type', 'doctor')->select('name', 'id')->whereRaw('LOWER(name) = ?', [strtolower($designation)])->first());
		return $designation ;
	}

	public static function getDesignationByIDS($designationIds){
        $Corefunctions = new \App\customclasses\Corefunctions;
		$designationDeatils = $Corefunctions->convertToArray(DB::table('ref_designations')->whereIn('id', $designationIds)->select('name', 'id')->get());
		$designationDeatils = $Corefunctions->getArrayIndexed1($designationDeatils, 'id');
		return $designationDeatils ;

	}
}
