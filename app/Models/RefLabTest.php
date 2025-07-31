<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
class RefLabTest extends Model
{
    use HasFactory, SoftDeletes;

    public static function getSubcategoryListByCategory($categoryID,$search = null){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subcatogory = $Corefunctions->convertToArray(DB::table('ref_lab_tests')->whereNull('deleted_at')
        ->where('sub_of',$categoryID)
        ->when(!empty(trim($search)), function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->get());
		return $subcatogory;
	}
    public static function getOptionList(){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $options = $Corefunctions->convertToArray(DB::table('ref_imaging_options')->whereNull('deleted_at')->get());
		return $options;
	}
    
    public static function getImagingCategoryList($search = null){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $category = $Corefunctions->convertToArray(DB::table('ref_imaging_tests')->where('sub_of','0')->whereNull('deleted_at')
        ->when(!empty(trim($search)), function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->get());
		return $category;
	}
    public static function getImagingSubcategoryListByCategory($categoryID,$search){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subcatogory = $Corefunctions->convertToArray(DB::table('ref_imaging_tests')->whereNull('deleted_at')
        ->where('sub_of',$categoryID)->when(!empty(trim($search)), function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->get());
		return $subcatogory;
	}
    public static function getAllImagingCategoryList(){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subCategory = $Corefunctions->convertToArray(DB::table('ref_imaging_tests')->whereNull('deleted_at')->get());
		return $subCategory;
	}
    public static function getCategoryList($search = null){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $category = $Corefunctions->convertToArray(DB::table('ref_lab_tests')->where('sub_of','0')->whereNull('deleted_at')
        ->when(!empty(trim($search)), function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->get());
		return $category;
	}
    public static function getSubCategoryList(){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subCategory = $Corefunctions->convertToArray(DB::table('ref_lab_tests')->where('sub_of','!=','0')->whereNull('deleted_at')->get());
		return $subCategory;
	}
    public static function getAllCategoryList(){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $subCategory = $Corefunctions->convertToArray(DB::table('ref_lab_tests')->whereNull('deleted_at')->get());
		return $subCategory;
	}

    public static function getCategoryListByIds($testIds){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $category = $Corefunctions->convertToArray(DB::table('ref_lab_tests')->whereNull('deleted_at')->whereIn('id',$testIds)->get());
		return $category;
	}
    public static function getCategoryById($categoryID){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $category = $Corefunctions->convertToArray(DB::table('ref_lab_tests')->whereNull('deleted_at')->whereIn('id',$id)->first());
		return $category;
	}


    public static function getImageinfCtp($imagingIds){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $category = $Corefunctions->convertToArray(DB::table('ref_imaging_cpt_codes')->whereNull('deleted_at')->whereIn('imaging_test_id',$imagingIds)->get());
		return $category;
	}
    
    public static function getCptCodes($imagingIds){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $category = $Corefunctions->convertToArray(DB::table('ref_cpt_codes')->whereNull('deleted_at')->whereIn('id',$imagingIds)->get());
		return $category;
	}
    
  
}
