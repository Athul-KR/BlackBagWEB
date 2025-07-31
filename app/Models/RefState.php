<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;

class RefState extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [''];

    public static function getState($state){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $state = $Corefunctions->convertToArray(DB::table('ref_states')->select('id')->where('state_name', $state)->orderBy('id', 'desc')->first());
        return $state ;
	}
    public static function getStateList(){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $state = $Corefunctions->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->whereNull('deleted_at')->get());
        return $state ;
	}

    public static function getStateByID($state_id){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $state = $Corefunctions->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id', $state_id)->whereNull('deleted_at')->first());
        return $state ;
	}
    public static function getStateByIDS($stateIds){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $state = $Corefunctions->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->whereIn('id', $stateIds)->whereNull('deleted_at')->get());
        $state = $Corefunctions->getArrayIndexed1($state, 'id');

        return $state ;
	}
}
