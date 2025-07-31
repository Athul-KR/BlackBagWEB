<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class ImportDoc extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function getImportDocs($importKey,$lastImportID){
      
        $Corefunctions = new \App\customclasses\Corefunctions;

        $excelDetails = DB::table('import_docs')->where('import_key', $importKey)->where('clinic_id', session()->get('user.clinicID'))->whereNull('deleted_at');
        if (isset($lastImportID) && ($lastImportID != '0')) {
            $excelDetails = $excelDetails->where('id', '<', $lastImportID);
        }
        $excelDetails = $excelDetails->orderBY('id', 'desc')->limit(10)->get();
        $excelDetails = $Corefunctions->convertToArray($excelDetails);
        return  $excelDetails ;

        

    }

    public static function getImportDocsByKey($importKey){
      
        $Corefunctions = new \App\customclasses\Corefunctions;
        $importDocList = $Corefunctions->convertToArray(DB::table('import_docs')->where('status', '0')->where('import_key',$importKey)->whereNull('deleted_at')->get());

        return  $importDocList ;
    }
    public static function importDocsByKey($importKey){
      
        $Corefunctions = new \App\customclasses\Corefunctions;
        $importDocList = $Corefunctions->convertToArray(DB::table('import_docs')->where('import_doc_uuid', $importKey)->whereNull('deleted_at')->first());

        return  $importDocList ;
    }
    public static function updateImportDoc($importKey){
      
        return DB::table('import_docs')->where('import_doc_uuid',$importKey)->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }



}
