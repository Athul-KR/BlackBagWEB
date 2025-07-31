<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
use Session;

class RefIcd10Code extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ref_icd10_codes';

    public static function geticdcodes($icsCodes){
        
        $Corefunctions = new \App\customclasses\Corefunctions;
        $icdcodes = DB::table('ref_icd10_codes')->select('id')->whereNull('deleted_at')->whereIn('icdcode',explode(',', $icsCodes))->get();
        $icdcodes = $Corefunctions->convertToArray($icdcodes);
        $icdcodesIDS = $Corefunctions->getIDSfromArray($icdcodes,'id');

        return $icdcodes ;
    }


}
