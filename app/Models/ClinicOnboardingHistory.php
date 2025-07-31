<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;

class ClinicOnboardingHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clinic_onboarding_history';

    public static function insertOnboardingHistory($clinicId,$stepID,$parentID=''){
        $Corefunctions = new \App\customclasses\Corefunctions;
        
        $insertid = DB::table('clinic_onboarding_history')->insertGetId([
            'onboarding_history_uuid' => $Corefunctions->generateUniqueKey('8', 'clinic_onboarding_history', 'onboarding_history_uuid') ,
            'clinic_id'               => $clinicId,
            'parent_id'               => (isset($parentID) && $parentID != '') ? $parentID : NULL,
            'step_id'                 => $stepID,
            'created_at'              => Carbon::now(),
        ]);
        return  $insertid ;
    }
  
    // Get completed steps for a clinic
    public static function getCompletedSteps($clinicId)
    {
        return self::where('clinic_id', $clinicId)
            ->whereNull('deleted_at')
            ->with('step')
            ->get();
    }

} 