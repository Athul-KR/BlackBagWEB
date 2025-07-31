<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Session;
use Carbon\Carbon;
class BusinessHour extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [''];
    protected $table = 'bussiness_hours';

    public function businessHourTime()
    {
        // Ensure foreign and local keys are correctly set for the relationship
        return $this->hasOne(BusinessHoursTime::class, 'bussiness_hour_id', 'id');
    }
    public function slots()
    {
        return $this->hasMany(BusinessHoursTime::class, 'bussiness_hour_id');
    }

    // To automatically delete related BusinessHourTime records when deleting a BusinessHour
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($businessHour) {
            $businessHour->businessHourTime()->delete();
        });
    }
    
    public static function getBusinessHour($clinicId)
    {

        return self::with('businessHourTime')->where('clinic_id', $clinicId)->where('status', '1')->get();
    }
    public static function getBusinessHourByDay($clinicId,$day)
    {
        
        return self::with('businessHourTime')->where('clinic_id', $clinicId)->where('status', '1')->where('day', $day)->first();
    }


    public static function saveBusinessHour($clinicId, $hour, $businessHourUuid, $businessHourTimeUuid)
    {
        // Update or create a BusinessHour entry
        $businessHour = self::updateOrCreate(
            ['clinic_id' => $clinicId, 'day' => $hour['day']],
            [
                'bussinesshour_uuid' => $businessHourUuid,
                'isopen' => $hour['is_open'],
                'status' => '1',
            ]
        );
        // Update or create a related BusinessHourTime entry for the business hour
        $businessHour->businessHourTime()->updateOrCreate(
            ['bussiness_hour_id' => $businessHour->id],
            [
                'bussinesshour_time_uuid' => $businessHourTimeUuid,
                'from_time' => date('H:i:s', strtotime($hour['start_time'])),
                'to_time' => date('H:i:s', strtotime($hour['end_time'])),
                'status' => '1',
            ]
        );

        return $businessHour;

     
    }



    public static function insertToBusinessHour($input){
        /* deactive the existing business hour */
        // self::where('clinic_id', $input['clinicId'])->where('user_id', $input['userID'])->where('day', $input['day'])->update(['status' => '0','deleted_at' => Carbon::now()]);

       
        $Corefunctions = new \App\customclasses\Corefunctions;
        $insertid = DB::table('bussiness_hours')->insertGetId([
            'bussinesshour_uuid' => $Corefunctions->generateUniqueKey('8', 'bussiness_hours', 'bussinesshour_uuid') ,
            'isopen'                  => isset($input['status']) && $input['status'] == '1' ?  '1' : '0' ,
            'day'                     => $input['day'],
            'clinic_id'               => $input['clinicId'],
            'user_id'                 => $input['userID'],
            'status'                  => '1',
            'created_at'              => Carbon::now(),
        ]);
        return  $insertid ;
    }

}
