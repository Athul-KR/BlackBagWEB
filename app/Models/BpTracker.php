<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;
use Session;

class BpTracker extends Model
{
    use HasFactory, SoftDeletes;

    // protected $casts = [
    //     'systolic' => 'string',
    // ];
    public static function insertBpTracker($inputData)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        /** generate key  */
        $key = $Corefunctions->generateUniqueKey('8', 'bp_tracker', 'bp_tracker_uuid');

        DB::table('bp_tracker')->insertGetId([

            'bp_tracker_uuid' => $key,
            'user_id'         => $inputData['user_id'],
            'clinic_id'       => $inputData['clinic_id'],
            'systolic'        => isset($inputData['systolic']) && $inputData['systolic'] != '' ? $inputData['systolic'] : NULL,
            'diastolic'       => isset($inputData['diastolic']) && $inputData['diastolic'] != '' ? $inputData['diastolic'] : NULL,
            'pulse'           => isset($inputData['pulse']) && $inputData['pulse'] != '' ? $inputData['pulse'] : NULL,
            'source_type_id'  => isset($inputData['sourceType']) && $inputData['sourceType'] != '' ? $inputData['sourceType'] : NULL,
            'reportdate'      => $inputData['reportdate'],
            'reporttime'      => $inputData['reporttime'],
            'created_by'      => Session::get('user.userID'),
            'created_at'      => Carbon::now(),

        ]);
    }
    public static function getBpTracker($userID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('bp_tracker')->select('user_id', 'systolic', 'diastolic', 'pulse', 'updated_at', 'bp_tracker_uuid', 'created_by', 'updated_by', 'source_type_id', 'created_at', 'reportdate', 'reporttime')->whereNull('deleted_at')->where('user_id', $userID)->orderBy('id', 'desc')->limit(20)->get();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails;
    }
    public static function getBpTrackerBySourceType($userID, $sourceType)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('bp_tracker')->select('user_id', 'systolic', 'diastolic', 'pulse', 'updated_at', 'bp_tracker_uuid', 'created_by', 'updated_by', 'source_type_id', 'created_at', 'reportdate', 'reporttime')->whereNull('deleted_at')->where('user_id', $userID)->where('source_type_id', $sourceType)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails;
    }
    public static function getBpTrackerByKey($key)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalDetails = DB::table('bp_tracker')->select('user_id', 'systolic', 'diastolic', 'pulse', 'updated_at', 'bp_tracker_uuid', 'created_by', 'updated_by', 'created_at', 'reportdate', 'reporttime')->whereNull('deleted_at')->where('bp_tracker_uuid', $key)->limit(1)->first();
        $medicalDetails = $Corefunctions->convertToArray($medicalDetails);

        return $medicalDetails;
    }

    public static function updateBpTracker($inputData)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;

        DB::table('bp_tracker')->where('bp_tracker_uuid', $inputData['key'])->update(array(

            'user_id'         => $inputData['user_id'],
            'systolic'        => isset($inputData['systolic']) && $inputData['systolic'] != '' ? $inputData['systolic'] : NULL,
            'diastolic'       => isset($inputData['diastolic']) && $inputData['diastolic'] != '' ? $inputData['diastolic'] : NULL,
            'pulse'           => isset($inputData['pulse']) && $inputData['pulse'] != '' ? $inputData['pulse'] : NULL,
            'source_type_id'  => isset($inputData['sourceType']) && $inputData['sourceType'] != '' ? $inputData['sourceType'] : NULL,
            'reportdate'      => $inputData['reportdate'],
            'reporttime'      => $inputData['reporttime'],
            'updated_by'      => $inputData['user_id'],
            'updated_at'      => Carbon::now(),

        ));
    }

    public static function deleteBpTracker($key)
    {
        DB::table('bp_tracker')->where('bp_tracker_uuid', $key)->update(array(
            'deleted_at' => Carbon::now(),
        ));
    }


    // public static function getLatestMedicalHistory($userID, $table,$startDate,$endDate,$label)
    // {
    //     $Corefunctions = new \App\customclasses\Corefunctions;

    //     $query = DB::table($table)->where('user_id', $userID)->whereNull('deleted_at');
    //     // Apply date range filter if both start and end dates are provided
    //     if (!empty($startDate) && !empty($endDate)) {
    //         print_r($startDate); exit;
    //         $query->whereBetween('created_at', [$startDate, $endDate]);
    //     }
    //     $data = $query->orderBy('id', 'desc')->limit(20)->get();
    //     return $Corefunctions->convertToArray($data);
    // }

    public static function getLatestMedicalHistory($userID, $table, $startDate, $endDate, $label, $viewtype, $page, $pagelimit)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $medicalHistoryPaginate = array();
        $query = DB::table($table)->where('user_id', $userID)->whereNull('deleted_at');
        // foreach ($fields as $field) {

        //     $query->whereNotNull($field);
        // }
        if (($label != '')) {
            $label = str_replace('+', ' ', $label); //  Normalize label
            switch (strtolower($label)) {

                case 'today':

                    $query->whereDate('reportdate', Carbon::today());
                    break;

                case 'yesterday':
                    $query->whereDate('reportdate', Carbon::yesterday());
                    break;

                case 'this month':
                    $query->whereBetween('reportdate', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    break;

                case 'last month':
                    $query->whereBetween('reportdate', [
                        Carbon::now()->subMonth()->startOfMonth(),
                        Carbon::now()->subMonth()->endOfMonth()
                    ]);
                    break;

                case 'recent':
                    $query->limit(25);
                    break;
                    break;

                case 'last 7 days':
                    $query->where('reportdate', '>=', Carbon::now()->subDays(7));
                    break;

                case 'last 30 days':
                    $query->where('reportdate', '>=', Carbon::now()->subDays(30));
                    break;

                case 'custom range':
                    if (!empty($startDate) && !empty($endDate)) {
                        $query->whereBetween('reportdate', [$startDate, $endDate]);
                    }
                    break;

                default:
                    // Fallback: apply custom range if provided
                    if (!empty($startDate) && !empty($endDate)) {
                        $query->whereBetween('reportdate', [$startDate, $endDate]);
                    }
            }

            if ($viewtype == 'chart') {
                $data = $query->orderBy('reportdate', 'desc')->get();
                $data =  $Corefunctions->convertToArray($data);
                return ['medicalHistoryList' => $data, 'medicalHistoryPaginate' => $medicalHistoryPaginate];
            }
        }
        /** for fronent view pages  */
        if ($viewtype == 'patient') {

            $medicathistoryChart = $query->orderBy('reportdate', 'desc')->get();
            $medicathistoryChart =  $Corefunctions->convertToArray($medicathistoryChart);

            $medicathistoryDetails = $query->orderBy('reportdate', 'desc')->paginate(10, ['*'], 'page', $page);
            return ['medicathistoryDetails' => $medicathistoryDetails, 'medicathistoryChart' => $medicathistoryChart];
        } else {

            $data = $query->orderBy('reportdate', 'desc')->paginate($pagelimit, ['*'], 'page', $page);
            $medicalHistoryDetails = $Corefunctions->convertToArray($data);
            return ['medicalHistoryList' => $medicalHistoryDetails['data'], 'medicalHistoryPaginate' => $data];
        }

        // $data =  $Corefunctions->convertToArray($data);
        // return $data;
    }
    // public static function getLatestMedicalHistoryCount($userID, $table,$fields,$startDate,$endDate,$label)
    // {
    //     $Corefunctions = new \App\customclasses\Corefunctions;

    //     $query = DB::table($table)->where('user_id', $userID)->whereNull('deleted_at');
    //     foreach ($fields as $field) {
    //         $query->whereNotNull($field);
    //     }
    //     if (($label !='') ) {
    //         $label = str_replace('+', ' ', $label); //  Normalize label
    //         switch (strtolower($label)) {

    //             case 'today':

    //                 $query->whereDate('created_at', Carbon::today());
    //                 break;

    //             case 'yesterday':
    //                 $query->whereDate('created_at', Carbon::yesterday());
    //                 break;

    //             case 'this month':
    //                 $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
    //                 break;

    //             case 'last month':
    //                 $query->whereBetween('created_at', [
    //                     Carbon::now()->subMonth()->startOfMonth(),
    //                     Carbon::now()->subMonth()->endOfMonth()
    //                 ]);
    //                 break;

    //             case 'recent':

    //             break;

    //             case 'custom range':
    //                 if (!empty($startDate) && !empty($endDate)) {
    //                     $query->whereBetween('created_at', [$startDate, $endDate]);
    //                 }
    //                 break;

    //             default:
    //                 // Fallback: apply custom range if provided
    //                 if (!empty($startDate) && !empty($endDate)) {
    //                     $query->whereBetween('created_at', [$startDate, $endDate]);
    //                 }
    //         }

    //     }

    //     $data = $query->orderBy('id', 'desc')->count();
    //     return $data;
    // }

    public static function getLastMedicalHistory($userID, $table)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $result = $Corefunctions->convertToArray(DB::table($table)->where('user_id', $userID)->whereNull('deleted_at')->orderBy('id', 'desc')->first());
        return $result;
    }
}
