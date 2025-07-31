<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class GlucoseTracker extends Model
{
    use HasFactory, SoftDeletes;

    public static function insertGlucoseTracker($inputData){
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
        $key = $Corefunctions->generateUniqueKey('8', 'glucose_tracker', 'glucose_tracker_uuid');
        DB::table('glucose_tracker')->insertGetId([
            'glucose_tracker_uuid' => $key,
            'user_id'              => $inputData['user_id'],
            'clinic_id'            => $inputData['clinic_id'],
            'bgvalue'              => isset($inputData['bgvalue']) && $inputData['bgvalue'] !='' ? $inputData['bgvalue'] : NULL,
            'a1c'                  => isset($inputData['a1c']) && $inputData['a1c'] !='' ? $inputData['a1c'] : NULL,
            'reportdate'           => $inputData['reportdate'],
            'reporttime'           => $inputData['reporttime'],
            'source_type_id'       => isset($inputData['sourceType']) && $inputData['sourceType'] !='' ? $inputData['sourceType'] : NULL,
            'created_by'           => Session::get('user.userID'),
            'created_at'           => Carbon\Carbon::now(),
            
        ]);
    }
    public static function getGlucoseTracker($userID,$startDate, $endDate, $label,$page){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $query = DB::table('glucose_tracker')->whereNull('deleted_at')->where('user_id',$userID);
        $medicathistoryChart =array();
     
        if (($label !='') ) {
        $label = str_replace('+', ' ', $label); //  Normalize label
            switch (strtolower($label)) {

                case 'today':
                    
                    $query->whereDate('created_at', Carbon\Carbon::today());
                    break;

                case 'yesterday':
                    $query->whereDate('created_at', Carbon\Carbon::yesterday());
                    break;

                case 'this month':
                    $query->whereBetween('created_at', [Carbon\Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    break;

                case 'last month':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subMonth()->startOfMonth(),
                        Carbon::now()->subMonth()->endOfMonth()
                    ]);
                    break;

                case 'recent':
                 
                break;

                case 'custom range':
                    if (!empty($startDate) && !empty($endDate)) {
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                    break;

                default:
                    // Fallback: apply custom range if provided
                    if (!empty($startDate) && !empty($endDate)) {
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }

                   
                 
            }
            $medicathistoryChart = $query->orderBy('id', 'desc')->get();
            $medicathistoryChart =  $Corefunctions->convertToArray($medicathistoryChart);
           
          
           
        }
        $medicathistoryDetails = $query->orderBy('id', 'desc')->paginate(10, ['*'], 'page', $page);
        return ['medicathistoryDetails' => $medicathistoryDetails, 'medicathistoryChart' => $medicathistoryChart];


        // $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        // return $medicalDetails ;
    }

    public static function getGlucoseTrackerBySourceType($userID,$sourceType){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('glucose_tracker')->whereNull('deleted_at')->where('user_id',$userID)->where('source_type_id',$sourceType)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }


    public static function getGlucoseTrackerByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('glucose_tracker')->select('user_id','bgvalue','a1c','reportdate','reporttime','glucose_tracker_uuid')->whereNull('deleted_at')->where('glucose_tracker_uuid',$key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails ;
    }
    public static function getLatYearGlucoseTracker($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $data = DB::table('glucose_tracker')->where('user_id', $userID)
        ->whereBetween('created_at', [now()->subYear(), now()]) // Last 1 year
        ->orderBy('created_at', 'asc')->get();
        $medicalDetails = $Corefunctions->convertToArray($data);
         return $medicalDetails ;

    }


    public static function updateGlucoseTracker($inputData){
        DB::table('glucose_tracker')->where('glucose_tracker_uuid', $inputData['key'])->update(array(

            'user_id'              => $inputData['user_id'],
            'bgvalue'              => isset($inputData['bgvalue']) && $inputData['bgvalue'] !='' ? $inputData['bgvalue'] : NULL,
            'a1c'                  => isset($inputData['a1c']) && $inputData['a1c'] !='' ? $inputData['a1c'] : NULL,
            'reportdate'           => $inputData['reportdate'],
            'reporttime'           => $inputData['reporttime'],
            'source_type_id'       => isset($inputData['sourceType']) && $inputData['sourceType'] !='' ? $inputData['sourceType'] : NULL,
            'updated_by'           => $inputData['user_id'],
            'updated_at'           => Carbon\Carbon::now(),

        ));
    }

    public static function deleteGlucoseTracker($key){
        DB::table('glucose_tracker')->where('glucose_tracker_uuid',$key)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }

}
