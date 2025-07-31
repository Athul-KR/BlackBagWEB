<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ClinicGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = "clinic_gallery";
    public static function getTempDocs($tempID)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
        $tempDoc = DB::table('temp_docs')->where('id', $tempID)->whereNull('deleted_at')->first();
        $tempDoc = $Corefunctions->convertToArray($tempDoc);
        return $tempDoc ;
    }


    public static function insertTempDocs($tempkey, $ext, $filename)
    {
        return DB::table('temp_docs')->insertGetId(array(
            'tempdoc_uuid' => $tempkey,
            'temp_doc_ext' => $ext,
            'original_name' => $filename,
            'created_at' => Carbon::now()
        ));
    }

    public static function getGalleryByClinic($clinicId)
    {
        return self::where('clinic_id', $clinicId)->get();
    }
    public static function getGalleryByKey($key)
    {
        return self::where('gallery_uuid', $key)->first();
    }

    public static function insertToGallery($tempDoc,$clinicID,$dockey)
    {
        $Corefunctions = new \App\customclasses\Corefunctions;
       
        return DB::table('clinic_gallery')->insertGetId(array(
            'gallery_uuid' => $dockey,
            'clinic_id'    => $clinicID,
            'orginal_name' => $tempDoc['original_name'] ,
            'img_ext'      => $tempDoc['temp_doc_ext'] ,
            'created_at'   => Carbon::now()
        ));

    }

    public static function updateImageToGallery($docid,$imagepath)
    {
        return DB::table('clinic_gallery')->where('id',$docid)->limit(1)->update(array(
            'image_path' => $imagepath,
            'updated_at'   => Carbon::now()
        ));

    }


    

   
}
