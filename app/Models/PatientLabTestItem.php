<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
class PatientLabTestItem extends Model
{
    use HasFactory, SoftDeletes;
  
    public static function deleteLabTests($key){
        DB::table('patient_lab_test_items')->where('id',$key)->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }
   
    
}
