<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class FcUserFolder extends Model
{
    use HasFactory, SoftDeletes;   

    public static function addFolder($folderName,$patientID,$clinicID,$userType,$createdBy){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $folderUuid = $Corefunctions->generateUniqueKey("10", "fc_user_folders", "fc_user_folder_uuid");
        DB::table('fc_user_folders')->insertGetId(array(
            'fc_user_folder_uuid' => $folderUuid,
            'user_id' => $patientID,
            'folder_id' => 0,
            'folder_name' => $folderName,
            'is_default' => '0',
            'user_type' => $userType,
            'clinic_id' => $clinicID,
            'created_by' => $createdBy,
            'created_at' => Carbon\Carbon::now(),
        ));
    }
    public static function updateFolder($key,$folderName){
        DB::table('fc_user_folders')->where('fc_user_folder_uuid',$key)->update(array(
            'folder_name' => $folderName,
            'updated_at' => Carbon\Carbon::now(),
        ));
    }
    public static function folderByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $folderDetails = DB::table('fc_user_folders')->where('fc_user_folder_uuid',$key)->first();
        $folderDetails = $Corefunctions->convertToArray($folderDetails);

        return $folderDetails;
    }
    public static function getFolders($userID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $folders = DB::table('fc_user_folders')->where('user_id',$userID)->whereNull('deleted_at')->get();
        $folders = $Corefunctions->convertToArray($folders);

        return $folders;
    }
    public static function getFoldersByClinicId($userID,$clinicID){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $folders = DB::table('fc_user_folders')->where('user_id',$userID)
            ->where(function ($query) use ($clinicID) {
                $query->whereNull('clinic_id')
                    ->orWhere('clinic_id', $clinicID);
            })
            ->whereNull('deleted_at')->get();
        $folders = $Corefunctions->convertToArray($folders);

        return $folders;
    }
    public static function removeFolder($key){
        DB::table('fc_user_folders')->where('fc_user_folder_uuid',$key)->update(array(
            'deleted_at' => Carbon\Carbon::now(),
        ));
    }
    public static function updateFolderTimestamp($folderUUID)
    {
        return DB::table('fc_user_folders')
            ->where('fc_user_folder_uuid', $folderUUID)
            ->update(['updated_at' => Carbon\Carbon::now()]);
    }
}
