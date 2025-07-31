<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use DB;
use File;

class CropController extends Controller
{
  protected $headerdata;
  public function __construct()
  {
    $this->headerdata = array(
      'pageheadertitle' => 'admins',
      'lefttitle' => 'admins'
    );
    View::share('headerdata', $this->headerdata);
  }
  public function index(Request $request, $type, $count = NULL)
  {
    $Corefunctions = new \App\customclasses\Corefunctions;


    $tempStoragePath = 'storage/app/public/';
    $storagePath = storage_path('app/public/');
    $location = $storagePath . "tempImgs/";
    $tempStorage = $location . "original/";
    $tempCropStorage = $location . "crop/";
    $tempOrigianalStorage = 'tempImgs/original/';
    $tempCropStorageX = 'tempImgs/crop/';
    $haserror = 0;
    $imageArray = array(
      "profile" => array(
        "width" => 500,
        "height" => 500,
        "minwidth" => 500,
        "minheight" => 500

      ),
      "patient" => array(
        "width" => 250,
        "height" => 250,
        "minwidth" => 250,
        "minheight" => 250
      ),
      "patient_doc" => array(
        "width" => 500,
        "height" => 500,
        "minwidth" => 500,
        "minheight" => 500
      ),
      "doctor" => array(
        "width" => 250,
        "height" => 250,
        "minwidth" => 250,
        "minheight" => 250
      ),
      "nurse" => array(
        "width" => 500,
        "height" => 500,
        "minwidth" => 500,
        "minheight" => 500
      ),
      "clinic_logo" => array(
        "width" => 250,
        "height" => 250,
        "minwidth" => 250,
        "minheight" => 250
      ),
      "clinic_banner" => array(
        "width" => 550,
        "height" => 190,
        "minwidth" => 550,
        "minheight" => 190
      ),





    );
    if (!array_key_exists($type, $imageArray)) {
      exit;
    }
    $data["imageSizes"] = $imageArray[$type];
    $data["view"] = 1;
    $data["type"] = $type;
    $data["count"] = $count;
    $data["cropview"] = 0;
    $data["imgSizee"] = 0;
    /*if($croptype){
      $data["cropview"]      = 1;
      }*/
    $data['filesize'] = "";
    $data['error'] = $data['imagekey'] = $data['imageLink'] = $data['imagePath'] = "";
    // print_r($request->Input()); exit;
    if ($request->Input('fileupload') and $request->Input('fileupload') == '1') {

      if (!is_dir('storage/app')) {
        mkdir('storage/app');
      }
      if (!is_dir('storage/app/public')) {
        mkdir('storage/app/public');
      }
      if (!is_dir('storage/app/public/tempImgs')) {
        mkdir('storage/app/public/tempImgs');
      }
      // mkdir('storage/app/public');
      // mkdir('storage/app/public/tempImgs');
      // mkdir('tempImgs/original');
      // mkdir('tempImgs/crop');
      // }

      if (!is_dir('storage/app/public/tempImgs/crop')) {
        mkdir('storage/app/public/tempImgs/crop');
      }
      if (!is_dir('storage/app/public/tempImgs/original')) {
        mkdir('storage/app/public/tempImgs/original');
      }



      if ($request->file('file') and $request->file('file')->isValid()) {
        // print_r($request->Input()); exit;
        $image = $request->file('file');
        $data['filesize'] = filesize($request->file('file'));
        
        // Add file size check for doctor type
        // if ($request->Input('imtype') == 'doctor' && $data['filesize'] > 2 * 1024 * 1024) {
        //   $haserror = 1;
        //   $data["view"] = 1;
        //   $data['error'] = 'Please upload an image less than or equal to 2MB';
        // }
        
        list($width, $height, $type, $attr) = getimagesize($request->file('file'));
        // print_r(getimagesize($request->file('file')));exit();
        if ($width < $imageArray[$request->Input('imtype')]['minwidth'] || $height < $imageArray[$request->Input('imtype')]['minheight']) {
          $haserror = 1;
          $data["view"] = 1;
          if ($request->Input('imtype') == 'teamlogo') {
            $data['error'] = 'Upload within the size of ' . $imageArray[$request->Input('imtype')]['minwidth'] . ' X ' . $imageArray[$request->Input('imtype')]['minheight'] . ' px for better user experience';
          } else {
            $data['error'] = 'Please upload an image of size greater than ' . $imageArray[$request->Input('imtype')]['minwidth'] . ' X ' . $imageArray[$request->Input('imtype')]['minheight'] . ' pixels';
          }
        }
        // if ($width > $imageArray[$request->Input('imtype')]['width'] || $height > $imageArray[$request->Input('imtype')]['height']) {
        //   $haserror      = 1;
        //   $data["view"]  = 1;
        //   if($request->Input('imtype') == 'teamlogo'){
        //     $data['error'] = 'Upload within the size of ' . $imageArray[$request->Input('imtype')]['minwidth'] . ' X ' . $imageArray[$request->Input('imtype')]['minheight'] . ' px for better user experience';
        //   }else{
        //     $data['error'] = 'Please upload an image of size ' . $imageArray[$request->Input('imtype')]['width'] . ' X ' . $imageArray[$request->Input('imtype')]['height'] . ' pixels';

        //   }
        // }
        $ext = $image->getClientOriginalExtension();
        // print"<pre>";print_r($ext);exit;
        if ($ext == 'bmp' || $ext == 'gif' || $ext == 'webp') {
          $haserror = 1;
          $data['view'] = 1;
          $data['error'] = 'Please upload jpeg/png images';
        }



        $imgSizee = ($height >= $width) ? $width : $height;


        $data['imgSizee'] = $imgSizee;
        if ($haserror != 1) {
          $Corefunctions = new \App\customclasses\Corefunctions;
          $imgKey = $Corefunctions->generateUniqueKey('12', 'temp_docs', 'tempdoc_uuid');
          $ext = $image->getClientOriginalExtension();
          $originalName = $image->getClientOriginalName();

          $fileName = $imgKey . "." . $ext;
          $request->file('file')->move($tempStorage, $fileName);
          DB::table('temp_docs')->insert(array(
            'tempdoc_uuid' => $imgKey,
            'temp_doc_ext' => $ext,
            'file_size' => $data['filesize'],

            'original_name' => $originalName
          ));


          $data["cropview"] = 1;
          $data['imageLink'] = url($tempStoragePath . $tempOrigianalStorage . $fileName);
          $data["original_name"] = $originalName;

          $data['imagekey'] = $imgKey;
          $data['width'] = $width;
          $data['height'] = $height;
          $data["view"] = 2;
          $data['error'] = "";
        }
        // print_r($data); exit; 
      } else {

        $haserror = 1;
        $data['error'] = "Please select an image to proceed";
      }
    }
    if ($request->Input('thumbnail') and $request->Input('thumbnail') == '1') {

      // print_r($request->Input('thumbnail'));exit();
      if ($request->Input('imagekey') and $request->Input('imagekey') != '') {
        $tempImageDetails = DB::table('temp_docs')->where('tempdoc_uuid', $request->Input('imagekey'))->first();
        if (!empty($tempImageDetails)) {
          $tempSource = $tempStorage . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
          $cropDestination = $tempCropStorage . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
          $cropDestinationUrl = $tempCropStorageX . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
          $data['imageType'] = $tempSource;



          //$Corefunctions->folderExistCheck('tempImgs','1');

          if ($request->Input('withoutcrop') and $request->Input('withoutcrop') == 'yes') {
            list($imagewidth, $imageheight, $imageType) = getimagesize($tempSource);
            $imageType = image_type_to_mime_type($imageType);


            // print_r( $imageType);exit();
            if ($imageType == 'image/gif' || $imageType == 'image/webp' || $imageType == 'image/bmp') {
              $data["view"] = 1;
              $haserror = 1;
              $data['error'] = "Please upload valid image";
            }
            if (!File::copy($tempSource, $cropDestination)) {
              die("Couldn't copy file");
            }
          } else {

            list($imagewidth, $imageheight, $imageType) = getimagesize($tempSource);

            /* print "<pre>";
                    print_r ( getimagesize($tempSource) );
                    print_r ( $tempSource );
                    print "</pre>";
                    exit;*/
            $imageType = image_type_to_mime_type($imageType);
            // print_r( $imageType);exit();
            if ($imageType == 'image/gif' || $imageType == 'image/webp' || $imageType == 'image/bmp') {
              $data["view"] = 1;
              $haserror = 1;
              $data['error'] = "Please upload valid image";
            }


            if ($haserror != 1) {
              list($imagewidth, $imageheight, $imageType) = getimagesize($tempSource);
              $imageType = image_type_to_mime_type($imageType);
              switch ($imageType) {
                case "image/gif":
                $img_r = imagecreatefromgif($tempSource);
                break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                  $img_r = imagecreatefromjpeg($tempSource);
                  break;
                case "image/png":
                case "image/x-png":
                  $img_r = @imagecreatefrompng($tempSource);
                  break;
              }
              $imgSizee = ($imageheight >= $imagewidth) ? $imagewidth : $imageheight;

              $data['imgSizee'] = $imgSizee;
              if ($type != 'event') {

                ///$img_r = imagecreatefromjpeg( $tempSource );
                $dst_r = imagecreatetruecolor($imageArray[$type]['width'], $imageArray[$type]['height']);
                // Allocate the color
                $color = imagecolorallocate($dst_r, 255, 255, 255);

                // Fill the background with white
                imagefill($dst_r, 0, 0, $color);

                // Alpha blending must be enabled on the background!
                imagealphablending($dst_r, TRUE);

                //$dst_r = ImageCreateTrueColor( $imageArray[ $type ][ 'width' ], $imageArray[ $type ][ 'height' ] );
                imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x1'], $_POST['y1'], $imageArray[$type]['width'], $imageArray[$type]['height'], $_POST['w'], $_POST['h']);
              } else {

                $newheight = ($imageArray[$type]['width'] * $imageheight) / $imagewidth;
                //$dst_r = imagecreatetruecolor($_POST['w'], $_POST['h']);
                $dst_r = imagecreatetruecolor($imageArray[$type]['width'], $newheight);
                imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x1'], $_POST['y1'], $imageArray[$type]['width'], $newheight, $_POST['w'], $_POST['h']);
              }
              $cropDestinationpath = $tempCropStorage . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
              //  $cropDestinationpath = $tempStoragePath. $tempCropStorageX . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_image_ext;
              // $tempSource        = $tempStorage . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;

              switch ($imageType) {
                /* case "image/gif":
                        imagegif($dst_r, $cropDestinationpath);
                        break;*/
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":


                  imagejpeg($dst_r, $cropDestinationpath, 90);

                  break;
                case "image/png":
                case "image/x-png":
                  imagepng($dst_r, $cropDestinationpath);
                  break;
              }
            }
          }


          //imagejpeg( $dst_r, $cropDestination );
          $data['imagekey'] = $tempImageDetails->tempdoc_uuid;
          $data['imgName'] = $tempImageDetails->original_name;
          //$data['imagePath'] = $cropDestinationpath;
          $data['imagePath'] = url($tempStoragePath . $tempCropStorageX . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext);
          $data["view"] = 3;
          if (isset($imageType) && $imageType != '' && ($imageType == 'image/webp' || $imageType == 'image/gif')) {
            $data["view"] = 1;
          }
        }
      }
    }
    //  print_r($data); exit;

    return view('crop', compact('data'));
  }
}
