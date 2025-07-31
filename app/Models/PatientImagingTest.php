<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Session;
use Carbon\Carbon;
class PatientImagingTest extends Model
{
    use HasFactory, SoftDeletes;
    public function patientlabtestitems()
    {
        return $this->hasMany(PatientLabTestItem::class, 'patient_lt_id', 'id');
    }
    public static function insertImagingTests($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
      
        $insertid = DB::table('patient_imaging_tests')->insertGetId([

            'imaging_test_uuid' => $inputData['imaging_test_uuid'],
            'patient_id'    => $inputData['patient_id'],
            'clinic_id'     => $inputData['clinic_id'],
            'test_date'     => isset($inputData['test_date']) && $inputData['test_date'] !='' ? $inputData['test_date'] : NULL,
            'created_by'    => Session::get('user.userID'),
            'created_at'    => Carbon::now(),
        ]);
        return  $insertid ;
    }
    public static function deleteAllLabTests($key){
        DB::table('patient_imaging_tests')->where('imaging_test_uuid',$key)->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }

    /** insert items  */

    public static function insertImagingTestItems($inputData,$imgId){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
      
        $insertid = DB::table('patient_imaging_test_items')->insertGetId([
            'imaging_items_uuid'  => $Corefunctions->generateUniqueKey('8', 'patient_imaging_test_items', 'imaging_items_uuid') ,
            'patient_imaging_id'  => $imgId,
            'lab_test_id'         => $inputData['category_id'],
            'sub_lab_test_id'     => isset($inputData['subcategory_id'])  && trim($inputData['subcategory_id'] !='') ? $inputData['subcategory_id'] : NULL, 
            'option_id'           => $inputData['option_id'],
            'description'         => isset($inputData['description']) && $inputData['description'] !='' ? $inputData['description'] : NULL,
            'created_at'          => Carbon::now(),
            'is_contrast'         => $inputData['is_contrast'],
        ]);
        return  $insertid ;
    }


    public static function updateImagingTests($inputData,$key){
        DB::table('patient_imaging_tests')->where('imaging_test_uuid',$key)->update(array(
            'test_date'     => isset($inputData['test_date']) && $inputData['test_date'] !='' ? $inputData['test_date'] : NULL,
            'updated_at' => Carbon::now(),
        ));
    }

    public static function getPatientImagingByKey($key){
        $clinicID = session()->get('user.clinicID') ;
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests = $Corefunctions->convertToArray(DB::table('patient_imaging_tests')->where('imaging_test_uuid',$key)->whereNull('deleted_at')->limit(1)->first());
		return $labtests;
	}
    public static function getPatientImagingItems($labid){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests = $Corefunctions->convertToArray(DB::table('patient_imaging_test_items')->where('patient_imaging_id',$labid)->whereNull('deleted_at')->limit(10)->get());
		return $labtests;
	}

    public static function validateSubcategory($labId,$subCatID){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests = $Corefunctions->convertToArray(DB::table('patient_imaging_test_items')->where('patient_imaging_id',$labId)->where('sub_lab_test_id',$subCatID)->whereNull('deleted_at')->count());
		return $labtests;
	}

    public static function getAllPatientImaging($patientID,$page){
        $perPage = request()->get('perPage', 10);
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests =  self::where('patient_id',$patientID)->whereNull('deleted_at')->orderBy('id','desc')->paginate('10', ['*'], 'page', $page);
		return $labtests;
	}

   

    
}
