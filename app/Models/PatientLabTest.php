<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Session;
use Carbon\Carbon;
class PatientLabTest extends Model
{
    use HasFactory, SoftDeletes;
    public function patientlabtestitems()
    {
        return $this->hasMany(PatientLabTestItem::class, 'patient_lt_id', 'id');
    }
    public static function insertLabTests($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
      
        $insertid = DB::table('patient_lab_tests')->insertGetId([

            'lab_test_uuid' => $inputData['lab_test_uuid'],
            'patient_id'    => $inputData['patient_id'],
            'clinic_id'     => $inputData['clinic_id'],
            'test_date'     => isset($inputData['test_date']) && $inputData['test_date'] !='' ? $inputData['test_date'] : NULL,
            'created_by'    => Session::get('user.userID'),
            'created_at'    => Carbon::now(),
        ]);
        return  $insertid ;
    }
    public static function deleteAllLabTests($key){
        DB::table('patient_lab_tests')->where('lab_test_uuid',$key)->update(array(
        
            'deleted_at' => Carbon::now(),
        ));
    }

    public static function updateLabTests($inputData,$key){
        DB::table('patient_lab_tests')->where('lab_test_uuid',$key)->update(array(
            'test_date'     => isset($inputData['test_date']) && $inputData['test_date'] !='' ? $inputData['test_date'] : NULL,
            'updated_at' => Carbon::now(),
        ));
    }
    public static function insertLabTestItems($inputData,$labId){
        $Corefunctions = new \App\customclasses\Corefunctions;
      
        DB::table('patient_lab_test_items')->insertGetId([
            'patient_lt_id'  => $labId,
            'lab_test_id'    => $inputData['category_id'],
            'sub_lab_test_id'=> isset($inputData['subcategory_id']) && $inputData['subcategory_id'] !='' ? $inputData['subcategory_id'] : NULL,
            'description'   => isset($inputData['description']) && $inputData['description'] !='' ? $inputData['description'] : NULL,
            'created_at'    => Carbon::now(),
        ]);
    }

    public static function getPatientLabTest($key){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests = $Corefunctions->convertToArray(DB::table('patient_lab_tests')->where('lab_test_uuid',$key)->whereNull('deleted_at')->limit(1)->first());
		return $labtests;
	}

    public static function getPatientOrders($patientID){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests =  self::where('patient_id',$patientID)->whereNull('deleted_at')->first();
        $labtests = $Corefunctions->convertToArray($labtests);
        // $labtests = $Corefunctions->convertToArray(DB::table('patient_lab_tests')->where('patient_id',$patientID)->whereNull('deleted_at')->limit(1)->first());
		return $labtests;
	}
    public static function getAllPatientOrders($patientID,$page){
        $perPage = request()->get('perPage', 10);
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests =  self::where('patient_id',$patientID)->whereNull('deleted_at')->orderBy('id', 'desc')->paginate('10', ['*'], 'page', $page);
		return $labtests;
	}
    public static function getPatientLabItems($labid){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests = $Corefunctions->convertToArray(DB::table('patient_lab_test_items')->where('patient_lt_id',$labid)->whereNull('deleted_at')->get());
		return $labtests;
	}

    public static function validateSubcategory($labId,$sublabID){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests = $Corefunctions->convertToArray(DB::table('patient_lab_test_items')->where('patient_lt_id',$labId)->where('sub_lab_test_id',$sublabID)->whereNull('deleted_at')->count());
		return $labtests;
	}
    public static function getPatientLabItemsByIds($labid){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $labtests = $Corefunctions->convertToArray(DB::table('patient_lab_test_items')->whereIn('patient_lt_id',$labid)->whereNull('deleted_at')->limit(10)->get());
		return $labtests;
	}

    
}
