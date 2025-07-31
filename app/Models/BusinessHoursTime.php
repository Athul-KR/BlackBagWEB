<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Session;
use Carbon\Carbon;

class BusinessHoursTime extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [''];
    protected $table = 'bussinesshours_times';



    public function businessHours()
    {
        return $this->belongsTo(BusinessHour::class, 'id', 'bussiness_hour_id');
    }

    public static function insertToBusinessHoursTime($input,$businessHourID){

     
        $Corefunctions = new \App\customclasses\Corefunctions;
        $insertid = DB::table('bussinesshours_times')->insertGetId([
            'bussinesshour_time_uuid' => $Corefunctions->generateUniqueKey('8', 'bussinesshours_times', 'bussinesshour_time_uuid') ,
            'bussiness_hour_id'       => $businessHourID ,
            'from_time'               => $input['from'] !='' ? date('H:i:s', strtotime($input['from'])) : null,
            'to_time'                 => $input['to'] !='' ? date('H:i:s', strtotime($input['to'])) : null,
            'slot'                    => isset($input['slot']) ? $input['slot'] : 0,
            // 'clinic_id'               => $input['clinicId'],
            'status'                  => '1',
            'created_at'              => Carbon::now(),
        ]);
        return  $insertid ;
    }

public static function insertToBusinessHoursTimeNew($input,$businessHourID,$clinicDetails){

     
        $Corefunctions = new \App\customclasses\Corefunctions;
        $insertid = DB::table('bussinesshours_times')->insertGetId([
            'bussinesshour_time_uuid' => $Corefunctions->generateUniqueKey('8', 'bussinesshours_times', 'bussinesshour_time_uuid') ,
            'bussiness_hour_id'       => $businessHourID ,
            'from_time'               => $input['from'] !='' ? date('H:i:s', strtotime($input['from'])) : null,
            'to_time'                 => $input['to'] !='' ? date('H:i:s', strtotime($input['to'])) : null,
            'slot'                    => isset($input['slot']) ? $input['slot'] : 0,
            'timezone_id'               => !empty($clinicDetails) ? $clinicDetails->timezone_id : 6,
            'timezone_from_utc'               => $input['fromTimeUtc'] !='' ? $input['fromTimeUtc'] : null,
            'timezone_to_utc'               => $input['toTimeUtc'] !='' ? $input['toTimeUtc'] : null,
            'status'                  => '1',
            'created_at'              => Carbon::now(),
        ]);
        return  $insertid ;
    }


}
