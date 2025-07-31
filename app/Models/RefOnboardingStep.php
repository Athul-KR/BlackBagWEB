<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;

class RefOnboardingStep extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ref_onboarding_steps';

   

    // Get all steps with completion status for a specific clinic
    public static function getOnboardingSteps()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        return $Corefunctions->convertToArray(self::select('step','id','slug')->orderBy('ref_onboarding_steps.id')->whereNull('deleted_at')->get());
    }
    public static function getOnboardingStepsUser()
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        return $Corefunctions->convertToArray(self::select('step','id','slug')->whereIn('id', [1, 2])->orderBy('ref_onboarding_steps.id')->whereNull('deleted_at')->get());
    }
    /* get onboarding step */
    public static function getOnboardingStepByID($id)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        return $Corefunctions->convertToArray(self::select('slug')->where('id',$id)->whereNull('deleted_at')->first());
    }

} 