<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon;
use Session;

class FcFile extends Model
{
    use HasFactory, SoftDeletes;

    public static function fileByKey($key){
        $Corefunctions = new \App\customclasses\Corefunctions;
        $fileDets = $Corefunctions->convertToArray(DB::table('fc_files')->where('fc_file_uuid', $key)->whereNull('deleted_at')->first());
        return $fileDets;
    }
    public static function addFile($filekey, $patientID, $folderID, $tempDoc, $userType, $clinicID, $createdBy, $fileName)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $fileUuid = $Corefunctions->generateUniqueKey('10', 'fc_files', 'fc_file_uuid');
        return $id = DB::table('fc_files')->insertGetId(array(
            'fc_file_uuid' => $fileUuid,
            'user_id' => $patientID,
            'folder_id' => $folderID,
            'file_key' => $filekey,
            'file_name' => isset($fileName) ? $fileName : $tempDoc->temp_doc_name,
            'file_ext' => $tempDoc->temp_doc_ext,
            'user_type' => $userType,
            'orginal_name' => $tempDoc->original_name,
            'clinic_id' => $clinicID,
            'status' => '1',
            'consider_for_ai_generation' => ($tempDoc->temp_doc_ext == 'pdf' || $tempDoc->temp_doc_ext == 'docx' || $tempDoc->temp_doc_ext == 'doc') ? '1' : '0',
            'created_by' => $createdBy,
            'created_at' => Carbon\Carbon::now(),
        ));
    }
    public static function getFiles($folderID, $userID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $files = DB::table('fc_files')->where('folder_id', $folderID)->where('user_id', $userID)->whereNull('deleted_at')->get();
        $files = $Corefunctions->convertToArray($files);

        return $files;
    }
    public static function getFilesByClinicId($folderID, $userID, $clinicID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $files = DB::table('fc_files')->where('folder_id', $folderID)->where('user_id', $userID)
            ->where(function ($query) use ($clinicID) {
                $query->whereNull('clinic_id')
                    ->orWhere('clinic_id', $clinicID);
            })
            ->whereNull('deleted_at')->get();
        $files = $Corefunctions->convertToArray($files);

        return $files;
    }
    public static function removeFile($key){
        DB::table('fc_files')->where('fc_file_uuid', $key)->update(array(
            'deleted_at' => Carbon\Carbon::now()
        ));
    }
    public static function fileExists($folderId, $fileName)
    {
        return self::where('file_name', $fileName)->where('folder_id', $folderId)->exists();
    }
    public static function updateFilePath($fileId, $path)
    {
        return self::where('id', $fileId)->update([
            'file_path' => $path,
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
    public static function getTempDocById($id)
    {
        return DB::table('temp_docs')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }
}
