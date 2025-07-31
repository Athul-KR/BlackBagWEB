<?php

namespace App\customclasses;

use App\Models\FcFile;
use PDO;
use Illuminate\Mail\TransportManager;
use App;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\ClinicUser;
use App\Models\StripeConnection;
use App\Models\Patient;
use App\Models\BpTracker;
use App\Models\GlucoseTracker;
use App\Models\CholestrolTracker;
use App\Models\WeightTracker;
use App\Models\Clinic;
use App\Models\HeightTracker;
use App\Models\RefCountryCode;
use App\Models\Payment;
use App\Models\Otp;
use App\Models\Subscription;
use App\Models\OxygenSaturation;
use App\Models\BodyTemperature;
use App\Models\Medication;
use App\Models\PatientCondition;
use App\Models\Allergy;
use App\Models\Immunization;
use App\Models\RefOnboardingStep;
use App\Models\RefState;
use App\Models\PatientCard;
use App\Models\ClinicCard;
use App\Models\Appointment;
use App\Models\RefConsultationTime;
use App\Models\PatientSubscription;
use App\Models\ClinicSubscription;
use App\Models\Chats;
use App\Models\UserBilling;
use App\Models\FcUserFolder;
use Mail;
use DB;
use Imagick;
use File;
use Carbon\Carbon;
use Aws\CloudFront;
use \Crypt;
use Plivo\RestClient;
use Illuminate\Support\Str;
use View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class Corefunctions
{

  public function __construct() {}

  function convertToArray($dataArray)
  {
    $dataArray = json_decode(json_encode($dataArray), true);
    return $dataArray;
  }
  function getArrayIndexed($array, $index)
  {
    $finalArray = array();
    if (!empty($array)) {
      foreach ($array as $a) {
        $finalArray[$a->$index] = $a;
      }
    }
    return $finalArray;
  }

  function getArrayIndexed1($array, $index)
  {
    $finalArray = array();
    if (!empty($array)) {
      foreach ($array as $a) {
        $finalArray[$a[$index]] = $a;
      }
    }
    return $finalArray;
  }
  function getIDSfromArray($data, $field)
  {
    if (empty($data) || !is_array($data)) return array();
    $return = array();
    foreach ($data as $d) {
      if ($d[$field] != '') {
        $return[] = $d[$field];
      }
    }
    return $return;
  }

  function generateUniqueKey($count, $table, $field)
  {
    $ukey = substr(strtolower(md5(microtime() . rand())), 0, $count);
    while ($this->checkDuplicate($table, $field, $ukey)) {
      $ukey = substr(strtolower(md5(microtime() . rand())), 0, $count);
    }
    return $ukey;
  }




  function generateClinicianCode()
  {
    // Get the highest numeric part from existing codes
    $latestCode = ClinicUser::where('clinic_code', 'like', 'BB-%')
      ->selectRaw("MAX(CAST(SUBSTRING(clinic_code, 4) AS UNSIGNED)) as max_code")
      ->value('max_code');
    // If none exists, start from 1000
    $nextNumber = $latestCode ? $latestCode + 1 : 1001;
    // Generate new code
    $newCode = 'BB-' . $nextNumber;

    // Final double-check for uniqueness (rare edge cases)
    while (ClinicUser::where('clinic_code', $newCode)->exists()) {
      $nextNumber++;
      $newCode = 'BB-' . $nextNumber;
    }

    return $newCode;
  }




  function userInitials($fullName)
  {
    $nameParts = explode(" ", $fullName);

    // Get the first name (first part)
    $firstname = $nameParts[0];

    // Get the last name (remaining parts, joined back if there are middle names)
    $lastname = isset($nameParts[1]) ? implode(" ", array_slice($nameParts, 1)) : '';

    // Clean Initials
    $initial = $this->cleanInitials($firstname, $lastname);

    // Check File Exists or create new
    $initialUrl = $this->initialNameCreator($initial);

    return $initialUrl;
  }
  function cleanInitials($firstname, $lastname)
  {
    if ($lastname == '') {
      $lastname   =  substr(trim(strtoupper($firstname)), 1, 1);
    } else {
      $lastname   =  substr(trim(strtoupper($lastname)), 0, 1);
    }
    $firstname      =  substr(trim(strtoupper($firstname)), 0, 1);
    return $firstname . $lastname;
  }
  // function cleanInitials($firstname,$lastname){
  //     $firstname  =  substr(trim(strtoupper($firstname)), 0, 1);
  //     $lastname   =  substr(trim(strtoupper($lastname)) , 0, 1);
  //     return $firstname.$lastname;

  // }

  function initialNameCreator($initials)
  {
    $defaultUrl = url('/') . "/assets/default/initial.png";
    if ($initials == "") {
      return $defaultUrl;
    }
    /* Folder not exist create folder */
    if (!is_dir(INITIALSASSETPATH))
      mkdir(INITIALSASSETPATH);

    if (file_exists('assets/initials/' . $initials . ".png")) {
      return url(INITIALSASSETPATH) . '/' . $initials . ".png";
    } else {
      // Get Random Color
      $randColor = $this->getColor();

      //File Name
      $initialsFile  = "/" . $initials . ".png";

      // Create Image
      $my_img = imagecreatetruecolor(100, 100);
      $background = imagecolorallocate($my_img, $randColor[0], $randColor[1], $randColor[2]);
      $text_colour = imagecolorallocate($my_img, 255, 255, 255);

      $font_path = 'ITCFranklinGothic-Med.ttf';


      $red = imagecolorallocate($my_img, 255, 0, 0);




      $dimensions = array();
      $dimensions = imagettfbbox(30, 0, $font_path, $initials);
      $textWidth = abs($dimensions[4] - $dimensions[0]);
      $left = (100 - $textWidth) / 2;





      imagefill($my_img, 0, 0, $background);
      imagettftext($my_img, 30, 0,  $left, 60, $text_colour, $font_path, $initials);
      //imagestring( $my_img, 5, 15, 15, $initials , $text_colour );
      imagepng($my_img, INITIALSASSETPATH . $initialsFile);
      imagedestroy($my_img);
    }
    return url(INITIALSASSETPATH) . $initialsFile;
  }

  function getColor()
  {
    $rgbCodes = array(
      'black'   =>  array(52, 73, 94),
      'violet'  =>  array(155, 89, 182),
      'green'   =>  array(39, 174, 96),
      'red'     =>  array(231, 76, 60),
      'blue'  =>  array(41, 128, 185)
    );
    $randkey = array_rand($rgbCodes);
    return $rgbCodes[$randkey];
  }
  function checkDuplicate($table, $field1, $fieldvalue1, $field2 = '', $fieldvalue2 = '')
  {

    global $db;
    $db1 = $db;
    $query = DB::table($table)->where($field1, $fieldvalue1)->first();
    return $query ? true : false;
  }





  public function sendmail($data, $subject, $view)
  {
    try {
      Mail::send($view, $data, function ($message) use ($data, $subject) {
        $message->to($data['email'])->subject($subject);

        // Attach file if present
        if (isset($data['attachfile']) && isset($data['filename'])) {
          $message->attach($data['attachfile'], ['as' => $data['filename'], 'mime' => $data['mimetype']]);
        } elseif (isset($data['attachfile'])) {
          $message->attach($data['attachfile']);
        }

        // Attach image if present
        if (isset($data['cbcvimg'])) {
          $message->attach($data['cbcvimg']);
        }

        // Add CC if present
        if (isset($data['ccemail'])) {
          $message->cc($data['ccemail'])->subject($subject);
        }

        // Add BCC if present
        if (isset($data['bccemail'])) {
          $message->bcc($data['bccemail'])->subject($subject);
        }
      });

      // If mail sent successfully, return true
      return ['status' => 'success', 'message' => 'Mail sent successfully.'];
    } catch (\Exception $ex) {
      // Log the error for debugging
      \Log::error('Error sending email: ' . $ex->getMessage());

      // Return the error message with the exception
      return ['status' => 'error', 'message' => 'Error sending email: ' . $ex->getMessage()];
    }
  }



  function getMyPath1($id, $file_id, $ext, $upload_dir)
  {
    $explodePathArray = explode('/', $upload_dir);
    if (!empty($explodePathArray)) {
      $attachArray = array();
      foreach ($explodePathArray as $key => $value) {
        if ($value != '') {
          $attachArray[] = $value;
          $filePath = implode('/', $attachArray) . '/';
          if (!is_dir($filePath))
            mkdir($filePath);
        }
      }
    }
    $dx = sprintf("%05d", $id / 5000);
    $folder_path = $upload_dir . $dx;

    if (!is_dir($folder_path))
      mkdir($folder_path);
    $save_file = $folder_path . "/" . $file_id . "." . $ext;
    return $save_file;
  }

  function getMyPathForAWS($id, $file_id, $ext, $upload_dir)
  {
    $dx = sprintf("%05d", $id / 5000);
    $folder_path = $upload_dir . $dx;
    $save_file = $folder_path . "/" . $file_id . "." . $ext;
    return $save_file;
  }

  function getMyPathForAWSResize($id, $file_id, $ext, $upload_dir)
  {
    $dx = sprintf("%05d", $id / 5000);
    $folder_path = $upload_dir . $dx;
    $save_file = $folder_path;
    return $save_file;
  }



  function uploadDocumenttoAWS($crppath, $imagePath)
  {


    try {
      // Attempt to upload the file to S3
      if (Storage::disk('s3')->put($crppath, $imagePath)) {
        return true;
      } else {
        return false;
      }
    } catch (\Exception $e) {
      print_r($e->getMessage());
      exit;
      // Optionally return an error message to the user
      return back()->with('error', 'File upload failed: ' . $e->getMessage());
    }
  }
  function uploadDocumenttoAWSPrivate($crppath, $imagePath)
  {


    try {
      // Attempt to upload the file to S3
      if (Storage::disk('s3private')->put($crppath, $imagePath)) {
        return true;
      } else {
        return false;
      }
    } catch (\Exception $e) {
      print_r($e->getMessage());
      exit;
      // Optionally return an error message to the user
      return back()->with('error', 'File upload failed: ' . $e->getMessage());
    }
  }

  function uploadDocumenttoAWS1($crppath, $imagePath)
  {
    // print_r($imagePath); exit;
    if (Storage::disk('s3')->put($crppath, $imagePath)) {
      return true;
    } else {
      return false;
    }
  }

  public function resizeImageAWS($Id, $logo_path, $firstname, $width, $height, $parentTypeID = '1')
  {
    //$width = $height = 150;
    if ($logo_path != "") {

      $dx  = sprintf("%05d", $Id / 5000);
      $explodePath =  explode('/', $logo_path);
      if (isset($explodePath['3'])) {
        $explodePathextension = explode('.', $explodePath[3]);
        $explodePath[1] = $explodePath[3];
      } elseif (isset($explodePath['2'])) {
        $explodePathextension = explode('.', $explodePath[2]);
        $explodePath[1] = $explodePath[2];
      } else {
        $explodePathextension = explode('.', $explodePath[1]);
      }
      $thumbnail_path  = $this->getMyPathForAWSResize($Id, $explodePathextension[0], $explodePathextension[1], "users/resized_images/");

      $thumbnail_path = $thumbnail_path . '/' . $explodePathextension[0] . '-' . $width . 'X' . $height . '.' . $explodePathextension[1];

      if (Cache::has($thumbnail_path)) {
        $temporaryUrl = Cache::get($thumbnail_path);

        return $temporaryUrl;
      }

      /* Get Resized Images */
      $resizedImage = $this->convertToArray(DB::table('images_resized')->where('width', $width)->where('height', $height)->where('parent_id', $Id)->where('parent_type_id', $parentTypeID)->first());

      if (!empty($resizedImage)) {
        $thumbnail_path  = $this->getMyPathForAWSResize($Id, $explodePathextension[0], $explodePathextension[1], "users/resized_images/");

        $thumbnail_path = $thumbnail_path . '/' . $explodePathextension[0] . '-' . $width . 'X' . $height . '.' . $explodePathextension[1];
        //$thumbUrl = 'uploads/resizedprofileimages/'.$dx.'/'.$width. "X" . $height."-".$explodePath[1];
        // print_r($thumbnail_path);exit;
        if (Storage::disk('s3')->exists($thumbnail_path)) {
          return $this->getAWSFilePath($thumbnail_path);
        } else {
          return $this->createResizedImage($Id, $logo_path, $explodePathextension[0], $explodePathextension[1], $width, $height, $parentTypeID);
        }
      } else {

        return $this->createResizedImage($Id, $logo_path, $explodePathextension[0], $explodePathextension[1], $width, $height, $parentTypeID);
      }
    }
    return asset('images/default_img.png');
  }

  public function createResizedImage($id, $logo_path, $key, $ext, $width, $height, $parentTypeID = '1')
  {

    $image_path    =  $this->getAWSFilePath($logo_path);

    $url    = $image_path;

    // parsed path
    $path = parse_url($url, PHP_URL_PATH);
    $filename = basename($path);
    $ext = pathinfo($path, PATHINFO_EXTENSION); // to get extension

    if (!is_dir('storage/app/resized')) {
      mkdir('storage/app/resized');
    }
    $bytes = random_bytes(20);
    $writePath = 'storage/app/resized/' . bin2hex($bytes) . "-" . $width . "-" . $height . "." . $ext;

    try {
      $im = new imagick();

      $im->readImageBlob(file_get_contents($url));
      $im->resizeImage($width, $height, imagick::FILTER_LANCZOS, 1, true);
      $im->writeImage($writePath);



      $thumbnail_path  = $this->getMyPathForAWSResize($id, $key, $ext, "users/resized_images/");
      $thumbnail_path = $thumbnail_path . '/' . $key . '-' . $width . 'X' . $height . '.' . $ext;


      Storage::disk('s3')->put($thumbnail_path, file_get_contents($writePath));
      $imageExist = DB::table('images_resized')->where('parent_id', $id)->where('width', $width)->where('height', $height)->first();
      $imageExist = $this->convertToArray($imageExist);
      if (empty($imagExist)) {
        /* Insert Images Resized */
        $resizeID = DB::table('images_resized')->insertGetId(array(
          'parent_id' => $id,
          'parent_type_id' => $parentTypeID,
          'width' => $width,
          'height' => $height,
          'created_at' => carbon::now(),
        ));
      }

      unlink($writePath);
      return $this->getAWSFilePath($thumbnail_path);
    } catch (\ImagickException $ex) {
      /**@var \Exception $ex */
      return $this->getAWSFilePath($logo_path);
    }
  }

  public function getAWSFilePath($filePath)
  {
    $url = Storage::disk('s3')->url($filePath);
    // Check if the URL is already cached
    //        if (Cache::has($filePath)) {
    //            $temporaryUrl = Cache::get($filePath);
    //        } else {
    //            // Generate a new temporary URL and cache it
    //            $temporaryUrl = Storage::disk('s3')->temporaryUrl(
    //                    $filePath, Carbon::now()->addMinutes(60)
    //                );
    //            Cache::put($filePath, $temporaryUrl, Carbon::now()->addMinutes(55));
    //        }
    return $url;
  }
  public function getAWSPathPrivate($filePath)
  {
    if (Cache::has($filePath)) {
      $temporaryUrl = Cache::get($filePath);
    } else {
      // Generate a new temporary URL and cache it
      $temporaryUrl = Storage::disk('s3private')->temporaryUrl(
        $filePath,
        Carbon::now()->addMinutes(60)
      );
      Cache::put($filePath, $temporaryUrl, Carbon::now()->addMinutes(55));
    }
    return $temporaryUrl;
  }

  function validateCountryCode($country_code, $whatsapp_country_code)
  {
    // Normalize the input code by adding the `+` symbol if missing and removing any spaces
    $formattedCode = '+' . str_replace(' ', '', ltrim($country_code, '+'));
    $country = $this->convertToArray(DB::table('ref_country_codes')->where(DB::raw("REPLACE(country_code, ' ', '')"), $formattedCode)->orderBy('id', 'desc')->first());
    $isTrue = !empty($country) ? '1' : '0';

    if ($whatsapp_country_code != '') {
      // Normalize the input code by adding the `+` symbol if missing and removing any spaces
      $formattedWpCode = '+' . str_replace(' ', '', ltrim($whatsapp_country_code, '+'));
      // Query the database, removing spaces from the country code column for comparison
      $whatsappCountry = $this->convertToArray(DB::table('ref_country_codes')->where(DB::raw("REPLACE(country_code, ' ', '')"), $formattedWpCode)->orderBy('id', 'desc')->first());
      $isTrue = !empty($whatsappCountry) ? '1' : '0';
    }
    return $isTrue;
  }
  public function getCountry()
  {
    $country = $this->convertToArray(
      DB::table('ref_country_codes')
        ->select('short_code')
        ->whereNull('deleted_at')
        ->orderBy('id', 'desc')
        ->get()
    );

    $shortCodes = $this->getIDSfromArray($country, 'short_code');

    // Convert all codes to lowercase
    $shortCodes = array_map('strtolower', $shortCodes);

    return $shortCodes;
  }

  function validateUser()
  {


    $userDetails = $this->convertToArray(User::select('id', 'user_uuid', 'phone_number')->where('id', session()->get('user.userID'))->whereNull('deleted_at')->first());

    if (empty($userDetails)) {
      return false;
    }
    if (session()->get('user.userType') != 'patient') {
      /*  check user is active */
      $clinicDetails = $this->convertToArray(ClinicUser::where('clinic_user_uuid', session()->get('user.clinicuser_uuid'))->where('clinic_users.user_id', $userDetails["id"])->whereNull('clinic_users.deleted_at')->first());
      if (empty($clinicDetails)) {
        return false;
      }
    }

    $clinicDetailsCount = ClinicUser::select('clinic_users.user_type_id')->join('clinics', 'clinics.id', '=', 'clinic_users.clinic_id')
      ->where('clinic_users.user_id', $userDetails["id"])->where('clinic_users.status', '1')->whereNull('clinics.deleted_at')->whereNull('clinic_users.deleted_at')->count();


    if (session()->get('user.userType') == 'patient') {

      $patientsCount = Patient::select('patients.user_type_id', 'patients.clinic_id', 'clinics.name', 'patients.clinic_user_uuid')
        ->join('clinics', 'clinics.id', '=', 'patients.clinic_id')
        ->where('patients.user_id', $userDetails["id"])->where('patients.status', '1')->whereNull('clinics.deleted_at')->whereNull('patients.deleted_at')->count();
      $clinicDetailsCount = $clinicDetailsCount + $patientsCount;
    }
    if ($clinicDetailsCount == 0) {
      return false;
    }
    return true;
  }



  public function addNotifications($notification_type_id, $clinic_id, $user_id, $parent_id)
  {

    /** generate uuid */
    $notififcationKey = $this->generateUniqueKey('10', 'notifications', 'notification_uuid');

    $fileid = DB::table('notifications')->insertGetId(array(
      'notification_uuid' => $notififcationKey,
      'notification_type_id' => $notification_type_id,
      'clinic_id' => $clinic_id,
      'user_id' => $user_id,
      'parent_id' => $parent_id,
      'created_at' => Carbon::now()
    ));
  }

  function getMyPath($id, $file_id, $ext, $upload_dir)
  {


    $dx = sprintf("%05d", $id / 5000);
    //$upload_dir = ROOT . "/uploads/" ;
    $folder_path = $upload_dir . "/" . $dx;

    $save_file = $folder_path . "/" . $file_id . "." . $ext;
    return $save_file;
  }

  function getUnreadNotCount()
  {

    $notificationDetails = DB::table('notifications')->where('user_id', session()->get('user.userID'))->where('clinic_id', session()->get('user.clinicID'))->where('is_read', '0')->whereNull('deleted_at')->count();

    return $notificationDetails;
  }
  /* get country code*/
  function getCountryCode($countryID)
  {

    $country = DB::table('ref_country_codes')->select('id', 'country_code')->where('id', $countryID)->first();
    return $country->country_code;
  }

  function getAppointmentCount()
  {
    if (session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') {
      $appointmentcount = DB::table('appointments')->where('consultant_id', session()->get('user.userID'))->where('clinic_id', session()->get('user.clinicID'))->where('appointment_date', date('Y-m-d'))->whereNull('deleted_at')->count();
    } elseif (session()->get('user.userType') == 'nurse') {
      $appointmentcount = DB::table('appointments')->where('nurse_id', session()->get('user.userID'))->where('clinic_id', session()->get('user.clinicID'))->where('appointment_date', date('Y-m-d'))->whereNull('deleted_at')->count();
    }
    return $appointmentcount;
  }

  public function formatAddress($data, $singleline = '0')
  {

    if (empty($data)) {
      return '';
    }

    $address = preg_replace('/(<br\s*\/?>\s*)+/', '<br/>', $data['address']);
    $address = preg_replace('/^(<br\s*\/?>)+|(<br\s*\/?>)+$/', '', $address);

    if ($singleline == 1) {
      $address .= ($address != '') ? ', ' : '';
    } else {
      $address .= ($address != '') ? '<br/>' : '';
    }
    if (isset($data['country_id']) &&  $data['country_id'] != '') {
      $country = DB::table('ref_country_codes')->select('id', 'country_name', 'short_code')->where('id', $data['country_id'])->first();
      $country->country_name = $country->short_code == 'US' ? 'USA' : $country->country_name;
    }
    $state = array();
    if (isset($data['state_id'])) {
      $state = DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->where('id', $data['state_id'])->first();
      $state = $this->convertToArray($state);
    }

    $statename = empty($state) && $data['state'] != '' ? $data['state']  : (isset($state['state_name']) ? $state['state_name'] : '');
    $address .= $data['city'];
    $address .= ($data['city'] != '' && isset($statename) && $statename != '') ? ', ' . $statename : '';
    // $address .= ( $data['state_id'] != '' && isset($data['country_id']) && $data['country_id'] != '' ) ? ', '. $country->country_name : '';
    $zip = (isset($data['zip_code'])  && $data['zip_code'] != '') ? $data['zip_code'] : ((isset($data['zip']) && $data['zip'] != '') ? $data['zip'] : '');
    $address .= ($statename != '' && $zip != '') ? ' ' . $zip : ' ' . $zip;


    $address .= (isset($data['country_id']) && $data['country_id'] != '') ? '<br/>' . $country->country_name : '';


    return $address;
  }
  public function formatBillingAddress($data, $singleline = '0')
  {
    if (empty($data)) {
      return '';
    }
    $address = $data['billing_address'];
    if ($singleline == 1) {
      $address .= ($data['billing_address'] != '') ? ', ' : '';
    } else {
      $address .= ($data['billing_address'] != '') ? '<br/>' : '';
    }
    if (isset($data['billing_country_id']) &&  $data['billing_country_id'] != '') {
      $country = DB::table('ref_country_codes')->select('id', 'country_name', 'short_code')->where('id', $data['billing_country_id'])->first();
      $short_code = $country->short_code == 'US' ? 'USA' : $country->country_name;
    }

    $statename = (isset($data['billing_state']) && $data['billing_state'] != '') ? $data['billing_state']  : '';
    if (isset($data['billing_state_id']) &&  $data['billing_state_id'] != '') {
      $state = DB::table('ref_states')->select('id', 'state_name')->where('id', $data['billing_state_id'])->first();
      $statename = $state->state_name != '' ? $state->state_name  : '';
    } else if (isset($data['billing_state_other']) &&  $data['billing_state_other'] != '') {
      $statename = $data['billing_state_other'];
    }


    $address .= $data['billing_city'];
    $address .= ($data['billing_city'] != '' && isset($statename) && $statename != '') ? ', ' . $statename : '';
    $zip = (isset($data['billing_zip'])  && $data['billing_zip'] != '') ? $data['billing_zip'] : '';
    $address .= ($statename != '' && $zip != '') ? ' ' . $zip : $zip;


    $address .= (isset($data['billing_country_id']) && $data['billing_country_id'] != '') ? '<br/>' . $short_code : '';

    return $address;
  }

  /* Return JSON With Error*/
  function returnError($errMsg, $errorCode = 0, $redirect = '')
  {

    return response()->json([
      'error' => 1,
      'errormsg' => $errMsg
    ]);
  }

  /** Set session data */
  function setSessionData($userDetails, $clinicDetails, $user_type, $clinicUseruuid, $stripe_connected, $clinicId, $clinicAdmin = 0, $patientID = '')
  {
    if ($user_type != 'patient') {
      $clinicDetails = $this->convertToArray(Clinic::clinicByID($clinicId));
      if ($clinicDetails['timezone_id'] != $userDetails['timezone_id']) {
        User::updateUserTimezone($userDetails["id"], $clinicDetails['timezone_id']);
      }
      $userDetails['timezone_id']  = $clinicDetails['timezone_id'];
      // Get user details by phone number
      // $userDetails = $this->convertToArray(User::where('id', $userDetails["id"])->whereNull('deleted_at')->first());
    }
    $timezoneDetails = DB::table('ref_timezones')->where('id', $userDetails['timezone_id'])->whereNull('deleted_at')->first();
    $timezoneDetails = $this->convertToArray($timezoneDetails);
    // Get clinic user details
    $clinicDetailsCount = ClinicUser::select('clinic_users.user_type_id', 'clinic_users.clinic_id', 'clinics.name', 'clinic_users.clinic_user_uuid')
      ->join('clinics', 'clinics.id', '=', 'clinic_users.clinic_id')
      ->where('clinic_users.user_id', $userDetails["id"])->where('clinic_users.status', '1')->whereNull('clinics.deleted_at')->count();

    $patientsCount = Patient::select('patients.user_type_id', 'patients.clinic_id')

      ->where('patients.user_id', $userDetails["id"])->where('patients.status', '1')->count();
    $clinicDetailsCount = $clinicDetailsCount + $patientsCount;

    $sessArray = array();
    $sessArray['user']['userID'] = $userDetails["id"];
    $sessArray['user']['firstName'] = $userDetails['first_name'];
    $sessArray['user']['middleName'] = $userDetails['middle_name'];
    $sessArray['user']['lastName'] = $userDetails['last_name'];
    $sessArray['user']['email'] = $userDetails["email"];
    $sessArray['user']['phone'] = $userDetails["phone_number"];
    $sessArray['user']['user_uuid'] = $userDetails['user_uuid'];
    $sessArray['user']['clinicuser_uuid'] = $clinicUseruuid;
    $sessArray['user']['image_path'] = (isset($userDetails['profile_image']) && $userDetails['profile_image'] != '') ? $userDetails['profile_image'] : '';
    $sessArray['user']['userType'] = $user_type;
    $sessArray['user']['clinicID'] = ($userDetails['last_login_clinic_id'] == NULL) ? $clinicId : $userDetails['last_login_clinic_id'];
    $sessArray['user']['clinicName'] = isset($clinicDetails['name']) ? $clinicDetails['name'] : '';
    $sessArray['user']['clinicUUID'] = isset($clinicDetails['clinic_uuid']) ? $clinicDetails['clinic_uuid'] : '';
    $sessArray['user']['userLogo'] = ($userDetails['profile_image'] != '') ? $userDetails['profile_image'] : '';
    $sessArray['user']['clinicLogo'] = (isset($clinicDetails['logo']) && $clinicDetails['logo'] != '') ? $this->getAWSFilePath($clinicDetails['logo']) : '';
    $sessArray['user']['hasWorkSpace'] = $clinicDetailsCount > 1 ? 1 : 0;
    $sessArray['user']['stripeConnection'] = $stripe_connected;
    $sessArray['user']['isClinicAdmin'] = $clinicAdmin;
    $sessArray['user']['patientID'] = isset($patientID) && $patientID != '' ? $patientID : null;
    $sessArray['user']['timezone'] = !empty($timezoneDetails) ? $timezoneDetails['timezone_format'] : 'UTC';
    $sessArray['user']['userSessionID'] = (isset($userDetails['userSessionID']) && $userDetails['userSessionID'] != '') ? $userDetails['userSessionID'] : '';;
    $sessArray['user']['licensed_practitioner'] = 0;
    $sessArray['user']['clinicCode'] = isset($userDetails['clinicCode']) ? $userDetails['clinicCode'] : '';
    session($sessArray);
    ClinicUser::updateAvailable($clinicUseruuid, '1');
  }

  function checkPermission()
  {

    $permission = 0;

    if (session()->get('user.isClinicAdmin') == 1) {

      $permission = 1;
    }
    return $permission;
  }

  function convertTimeZone($date, $format)
  {
    return Carbon::parse($date)->setTimezone('America/New_York')->format($format);
  }
  function currentTime()
  {
    return strtotime(Carbon::now('America/New_York'));
  }


  function intakeFormInsertion($section, $data)
  {

    if (!is_array($data) || !array_filter($data)) {
      return null;
    }
    $userTimeZone = session()->get('user.timezone');
    switch ($section) {
      case 'blood_pressure':
        if (isset($data['bpdate'])  && $data['bpdate'] != '') {
          $dateTimeString = $data['bpdate'];
          $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

          $dateTime->setTimezone(new \DateTimeZone('UTC'));
          $formattedDate = $dateTime->format('Y-m-d');
        } else {
          $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
        }
        if (isset($data['bptime'])  && $data['bptime'] != '') {
          $dateTimeString = $data['bptime'];
          $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

          $dateTime->setTimezone(new \DateTimeZone('UTC'));
          $formattedTime = $dateTime->format('H:i:s');
        } else {
          $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
        }
        //Seperating the single colmn into two columns systolic & sdiastolic into single field.
        $systolicData = '';
        $diastolicData = '';

        if (!empty($data['systolic/diastolic'])) {
          $parts = explode('/', $data['systolic/diastolic']);

          $systolicData = isset($parts[0]) ? trim($parts[0]) : '';
          $diastolicData = isset($parts[1]) ? trim($parts[1]) : '';
          // dd($systolicData . " " . $diastolicData);
        }


        $insertArray = [
          'systolic'   => isset($data['systolic']) ? $data['systolic'] : '',
          'diastolic'  => isset($data['diastolic']) ? $data['diastolic'] : '',
          // 'systolic'   => $systolicData,
          // 'diastolic'  => $diastolicData,
          'pulse'      => isset($data['pulse']) ? $data['pulse'] : '',
          'reportdate' => $formattedDate,
          'reporttime' => $formattedTime,
          'sourceType' => isset($data['sourcetype'])  && $data['sourcetype'] != '' ? $data['sourcetype']  : '1',
          'key'        => isset($data['key'])  && $data['key'] != '' ?  $data['key'] : '',
          'clinic_id'  => $data['clinic_id'],
          'user_id'    => $data['user_id']
        ];
        if (isset($data['key']) && $data['key'] != '') {
          /*** update to blood_pressure tracker  */
          BpTracker::updateBpTracker($insertArray);
        } else {
          /*** insert to blood_pressure tracker  */
          BpTracker::insertBpTracker($insertArray);
        }
        break;
      case 'cholesterol':
        if (isset($data['chdate'])  && $data['chdate'] != '') {
          $dateTimeString = $data['chdate'];
          $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

          $dateTime->setTimezone(new \DateTimeZone('UTC'));
          $formattedDate = $dateTime->format('Y-m-d');
        } else {
          $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
        }
        if (isset($data['chtime'])  && $data['chtime'] != '') {
          $dateTimeString = $data['chtime'];
          $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

          $dateTime->setTimezone(new \DateTimeZone('UTC'));
          $formattedTime = $dateTime->format('H:i:s');
        } else {
          $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
        }
        $insertArray = [
          'cholesterol'   => $data['cholesterol'],
          'hdl'           => $data['hdl'],
          'ldl'           => $data['ldl'],
          'triglycerides' => $data['triglycerides'],
          'reportdate'    => $formattedDate,
          'reporttime'    => $formattedTime,
          'fasting'       => isset($data['fasting']) ? $data['fasting'] : '',
          'clinic_id'     => $data['clinic_id'],
          'user_id'       => $data['user_id'],
          'key'           => isset($data['key'])  && $data['key'] != '' ?  $data['key'] : '',
          'sourceType'    => isset($data['sourcetype'])  && $data['sourcetype'] != '' ? $data['sourcetype']  : '1',
        ];
        if (isset($data['key']) && $data['key'] != '') {
          CholestrolTracker::updateCholesterol($insertArray);
        } else {
          /*** insert to Cholesterol tracker  */
          CholestrolTracker::insertCholesterol($insertArray);
        }
        break;
      case 'glucose':
        if (isset($data['glucosedate'])  && $data['glucosedate'] != '') {
          $dateTimeString = $data['glucosedate'];
          $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

          $dateTime->setTimezone(new \DateTimeZone('UTC'));
          $formattedDate = $dateTime->format('Y-m-d');
        } else {
          $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
        }
        if (isset($data['glucosetime'])  && $data['glucosetime'] != '') {
          $dateTimeString = $data['glucosetime'];
          $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

          $dateTime->setTimezone(new \DateTimeZone('UTC'));
          $formattedTime = $dateTime->format('H:i:s');
        } else {
          $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
        }
        $insertArray = [
          'bgvalue'    => isset($data['glucose']) ? $data['glucose'] : '',
          'a1c'        => isset($data['hba1c']) ? $data['hba1c'] : '',
          'reportdate' => $formattedDate,
          'reporttime' => $formattedTime,
          'sourceType' => isset($data['sourcetype'])  && $data['sourcetype'] != '' ? $data['sourcetype']  : '1',
          'clinic_id'  => $data['clinic_id'],
          'user_id'    => $data['user_id'],
          'key'        => isset($data['key'])  && $data['key'] != '' ?  $data['key'] : '',
        ];
        if (isset($data['key']) && $data['key'] != '') {
          /*** update to blood_pressure tracker  */
          GlucoseTracker::updateGlucoseTracker($insertArray);
        } else {
          /*** insert to GlucoseTracker   */
          GlucoseTracker::insertGlucoseTracker($insertArray);
        }
        break;
      case 'weight':
        if (isset($data['weight']) && $data['weight'] != '') {
          if (isset($data['reportdate'])  && $data['reportdate'] != '') {
            $dateTimeString = $data['reportdate'];
            $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedDate = $dateTime->format('Y-m-d');
          } else {
            $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
          }
          if (isset($data['reporttime'])  && $data['reporttime'] != '') {
            $dateTimeString = $data['reporttime'];
            $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedTime = $dateTime->format('H:i:s');
          } else {
            $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
          }
          if ($data['unit'] == 'kg') {
            $kgFrom = $data['weight'];
            $lbsFrom = round($kgFrom * 2.20462, 2);
            $data['kg']     = $data["weight"];
            $data['lbs']     = $lbsFrom;
          } else {
            $lbsFrom = $data['weight'];
            $kgFrom = round($lbsFrom / 2.20462, 2);
            $data['kg']   = $kgFrom;
            $data['lbs']  = $data["weight"];
          }
          /** calculate bmi with latest hight  */
          $bmi = $this->getBmiDetails($data);

          $insertArray = [
            'kg'        => $data['kg'],
            'lbs'       => $data['lbs'],
            'weight'    => $data['weight'],
            'reportdate' => $formattedDate,
            'reporttime' => $formattedTime,
            'user_id'    => $data['user_id'],
            'clinic_id'  => $data['clinic_id'],
            'key'        => isset($data['key'])  && $data['key'] != '' ?  $data['key'] : '',
            'unit'        => isset($data['unit'])  && $data['unit'] != '' ?  $data['unit'] : '',
            'sourceType' => isset($data['sourcetype'])  && $data['sourcetype'] != '' ? $data['sourcetype']  : '1',
            'bmi'        => isset($bmi)  && $bmi != '' ? $bmi  : '',

          ];


          if (isset($data['key']) && $data['key'] != '') {
            /*** insert to GlucoseTracker   */
            WeightTracker::updateWeight($insertArray);
          } else {
            /*** insert to GlucoseTracker   */
            WeightTracker::insertWeight($insertArray);
          }
        }

        if (isset($data['height']) && $data['height'] != '') {
          if (isset($data['reportdate'])  && $data['reportdate'] != '') {
            $dateTimeString = $data['reportdate'];
            $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedDate = $dateTime->format('Y-m-d');
          } else {
            $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
          }
          if (isset($data['reporttime'])  && $data['reporttime'] != '') {
            $dateTimeString = $data['reporttime'];
            $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedTime = $dateTime->format('H:i:s');
          } else {
            $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
          }

          //Old code
          // if ($data['unit'] == 'cm') {
          //   $cmFrom = $data['height'];
          //   $inchesFrom = round($cmFrom / 2.54, 2);
          //   $data['cm']     = $data["height"];
          //   $data['inches']     = $inchesFrom;
          // } else {
          //   $inchesFrom = $data['height'];
          //   $cmFrom = round($inchesFrom * 2.54, 2);
          //   $data['cm']   = $cmFrom;
          //   $data['inches']  = $data["height"];
          // }

          //New update with ft included
          if ($data['unit'] == 'cm') {
            $cmFrom = $data['height'];
            $inchesFrom = round($cmFrom / 2.54, 2);
            $ftFrom = round($inchesFrom / 12, 2);

            $data['cm']     = $cmFrom;
            $data['inches'] = $inchesFrom;
            $data['ft']     = $ftFrom;
          } elseif ($data['unit'] == 'inches') {
            $inchesFrom = $data['height'];
            $cmFrom = round($inchesFrom * 2.54, 2);
            $ftFrom = round($inchesFrom / 12, 2);

            $data['cm']     = $cmFrom;
            $data['inches'] = $inchesFrom;
            $data['ft']     = $ftFrom;
          } elseif ($data['unit'] == 'ft') {
            $ftFrom = $data['height'];
            $inchesFrom = round($ftFrom * 12, 2);
            $cmFrom = round($inchesFrom * 2.54, 2);

            $data['cm']     = $cmFrom;
            $data['inches'] = $inchesFrom;
            $data['ft']     = $ftFrom;
          }

          $insertArray = [
            'height'      => $data['height'],
            'cm'          => $data['cm'],
            'inches'      => $data['inches'],
            'ft'          => $data['ft'],
            'reportdate'  => $formattedDate,
            'reporttime'  => $formattedTime,
            'user_id'     => $data['user_id'],
            'clinic_id'   => $data['clinic_id'],
            'key'         => isset($data['key'])  && $data['key'] != '' ?  $data['key'] : '',
            'unit'        => isset($data['unit'])  && $data['unit'] != '' ?  $data['unit'] : '',
            'sourceType'  => isset($data['sourcetype'])  && $data['sourcetype'] != '' ? $data['sourcetype']  : '1',
          ];
          HeightTracker::insertHeight($insertArray);
        }


        break;
      case 'height':
        if (isset($data['height']) && $data['height'] != '') {
          if (isset($data['reportdate'])  && $data['reportdate'] != '') {
            $dateTimeString = $data['reportdate'];
            $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedDate = $dateTime->format('Y-m-d');
          } else {
            $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
          }
          if (isset($data['reporttime'])  && $data['reporttime'] != '') {
            $dateTimeString = $data['reporttime'];
            $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedTime = $dateTime->format('H:i:s');
          } else {
            $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
          }

          //Old code
          // if ($data['unit'] == 'cm') {
          //   $cmFrom = $data['height'];
          //   $inchesFrom = round($cmFrom / 2.54, 2);
          //   $data['cm']     = $data["height"];
          //   $data['inches']     = $inchesFrom;
          // } else {
          //   $inchesFrom = $data['height'];
          //   $cmFrom = round($inchesFrom * 2.54, 2);
          //   $data['cm']   = $cmFrom;
          //   $data['inches']  = $data["height"];
          // }

          //New update included ft
          if ($data['unit'] == 'cm') {
            $cmFrom = $data['height'];
            $inchesFrom = round($cmFrom / 2.54, 2);
            $ftFrom = round($inchesFrom / 12, 2);

            $data['cm']     = $cmFrom;
            $data['inches'] = $inchesFrom;
            $data['ft']     = $ftFrom;
          } elseif ($data['unit'] == 'inches') {
            $inchesFrom = $data['height'];
            $cmFrom = round($inchesFrom * 2.54, 2);
            $ftFrom = round($inchesFrom / 12, 2);

            $data['cm']     = $cmFrom;
            $data['inches'] = $inchesFrom;
            $data['ft']     = $ftFrom;
          } elseif ($data['unit'] == 'ft') {
            $ftFrom = $data['height'];
            $inchesFrom = round($ftFrom * 12, 2);
            $cmFrom = round($inchesFrom * 2.54, 2);

            $data['cm']     = $cmFrom;
            $data['inches'] = $inchesFrom;
            $data['ft']     = $ftFrom;
          }

          $insertArray = [
            'height'      => $data['height'],
            'cm'          => $data['cm'],
            'inches'      => $data['inches'],
            'ft'          => $data['ft'],
            'reportdate'  => $formattedDate,
            'reporttime'  => $formattedTime,
            'user_id'     => $data['user_id'],
            'clinic_id'   => $data['clinic_id'],
            'key'         => isset($data['key'])  && $data['key'] != '' ?  $data['key'] : '',
            'unit'        => isset($data['unit'])  && $data['unit'] != '' ?  $data['unit'] : '',
            'sourceType'  => isset($data['sourcetype'])  && $data['sourcetype'] != '' ? $data['sourcetype']  : '1',
          ];
          if (isset($data['key']) && $data['key'] != '') {
            HeightTracker::updateHeight($insertArray);
          } else {
            /*** insert to GlucoseTracker   */
            HeightTracker::insertHeight($insertArray);
          }
        }
        break;
      case 'saturation':
        if (isset($data['reportdate'])  && $data['reportdate'] != '') {
          $dateTimeString = $data['reportdate'];
          $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

          $dateTime->setTimezone(new \DateTimeZone('UTC'));
          $formattedDate = $dateTime->format('Y-m-d');
        } else {
          $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
        }
        if (isset($data['reporttime'])  && $data['reporttime'] != '') {
          $dateTimeString = $data['reporttime'];
          $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

          $dateTime->setTimezone(new \DateTimeZone('UTC'));
          $formattedTime = $dateTime->format('H:i:s');
        } else {
          $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
        }
        if (isset($data['saturation']) && $data['saturation'] != '') {
          $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
          $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
          $insertArray = [
            'saturation' => $data['saturation'],
            'reportdate' => $formattedDate,
            'reporttime' => $formattedTime,
            'user_id'    => $data['user_id'],
            'clinic_id'  => $data['clinic_id'],
            'sourceType' => isset($data['sourcetype'])  && $data['sourcetype'] != '' ? $data['sourcetype']  : '1',
          ];
          if (isset($data['key']) && $data['key'] != '') {
            /*** insert to GlucoseTracker   */
            OxygenSaturation::updateOxygenSaturation($data['key'], $insertArray, $data['user_id']);
          } else {
            /*** insert to GlucoseTracker   */
            OxygenSaturation::addOxygenSaturation($insertArray, $data['user_id']);
          }
        }
        break;

      case 'body_temperature':

        if (isset($data['temperature']) && trim($data['temperature']) != '') {
          if (isset($data['reportdate'])  && $data['reportdate'] != '') {
            $dateTimeString = $data['reportdate'];
            $dateTime = \DateTime::createFromFormat('m/d/Y', $dateTimeString, new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedDate = $dateTime->format('Y-m-d');
          } else {
            $formattedDate = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('Y-m-d');
          }
          if (isset($data['reporttime'])  && $data['reporttime'] != '') {
            $dateTimeString = $data['reporttime'];
            $dateTime = \DateTime::createFromFormat('h:i A', $dateTimeString, new \DateTimeZone($userTimeZone));

            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $formattedTime = $dateTime->format('H:i:s');
          } else {
            $formattedTime = now()->setTimezone($userTimeZone)->setTimezone('UTC')->format('H:i:s');
          }
          if ($data['unit'] == 'c') {
            $celFrom = $data['temperature'];
            $farenheitFrom = round(($celFrom * 9 / 5) + 32, 2);
            $data['celsius']         = $data["temperature"];
            $data['farenheit']     = $farenheitFrom;
          } else {
            $farFrom = $data['temperature'];
            $celFrom = round(($farFrom - 32) * 5 / 9, 2);
            $data['celsius']     = $celFrom;
            $data['farenheit']  = $data["temperature"];
          }

          $insertArray = [
            'celsius'    => $data['celsius'],
            'farenheit'  => $data['farenheit'],
            'temparature' => $data['temperature'],
            'unit'       => $data['unit'],
            'reportdate' => $formattedDate,
            'reporttime' => $formattedTime,
            'user_id'    => $data['user_id'],
            'clinic_id'  => $data['clinic_id'],
            'key'        => isset($data['key'])  && $data['key'] != '' ?  $data['key'] : '',
            'sourceType' => isset($data['sourcetype'])  && $data['sourcetype'] != '' ? $data['sourcetype']  : '1',
          ];
          if (isset($data['key']) && $data['key'] != '') {
            /*** update tem   */
            BodyTemperature::updateBodyTemperature($insertArray);
          } else {
            /*** insert to GlucoseTracker   */
            BodyTemperature::insertBodyTemperature($insertArray);
          }
        }
        break;
      case 'medications':

        if (isset($data['strength']) && trim($data['strength']) != '') {
          if (isset($data['key']) && $data['key'] != '') {
            if (isset($data['condition_id']) && $data['condition_id'] != '' && $data['condition_id'] != '0') {
              $conditionID = $data['condition_id'];
              Medication::updateMedication($data['key'], $data, $conditionID, session('user.userID'));
            } else {
              Medication::updateMedication($data['key'], $data, 0, session('user.userID'));
            }
          } else {
            if (isset($data['condition_id']) && $data['condition_id'] != '' && $data['condition_id'] != '0') {
              $conditionID = $data['condition_id'];
              Medication::addMedication($data, $conditionID, $data['user_id'], $data['clinic_id'], $data['sourcetype'], session('user.userID'));
            } else {
              Medication::addMedication($data, 0, $data['user_id'], $data['clinic_id'], $data['sourcetype'], session('user.userID'));
            }
          }
        }
        break;


      case 'medical_conditions':

        $relationID = (isset($data['relation']) && $data['relation'] != '') ? $data['relation'] : 0;
        $conditionID = (isset($data['condition_id']) && $data['condition_id'] != '') ? $data['condition_id'] : 0;
        if (isset($data['key']) && $data['key'] != '') {
          /*** update to   */
          PatientCondition::updatePatientCondition($data['key'], $relationID, $conditionID, session('user.userID'));
        } else {
          /*** insert  */
          PatientCondition::addPatientCondition($relationID, $conditionID, $data['sourcetype'], $data['user_id'], session('user.userID'), $data['clinic_id']);
        }


        break;
      case 'allergies':
        $title = (isset($data['allergy']) && $data['allergy'] != '') ? $data['allergy'] : '';
        $reaction = (isset($data['reaction']) && $data['reaction'] != '') ? $data['reaction'] : '';

        if (isset($data['key']) && $data['key'] != '') {
          /*** update to   */
          Allergy::updateAllergy($data['key'], $title, $reaction, session('user.userID'));
        } else {
          if ($title != '' || $reaction != '') {
            Allergy::addAllergy($title, $reaction, $data['sourcetype'], $data['user_id'], session('user.userID'), $data['clinic_id']);
          }
        }


        break;

      case 'immunizations':

        if (isset($data['key']) && $data['key'] != '') {
          /*** update to   */
          Immunization::updateImmunization($data['key'], $data['vaccine'], session('user.userID'));
        } else {
          Immunization::addImmunization($data['vaccine'], $data['user_id'], $data['clinic_id'], $data['sourcetype'], session('user.userID'));
        }

        break;
      case 'family_history':
        if (isset($data['key']) && $data['key'] != '') {
          $patientConditionDets = PatientCondition::getPatientConditionByKey($data['key']);
          $relationID = (isset($data['relation']) && $data['relation'] != '') ? $data['relation'] : 0;
          DB::table('patient_conditions')->where('relation_id', $patientConditionDets['relation_id'])->where('user_id', $data['user_id'])->where('source_type_id', $data['sourcetype'])->update(array(
            'deleted_at' => Carbon::now(),
          ));
          if (!empty($data['condition_id'])) {
            foreach ($data['condition_id'] as $condition_id) {
              $conditionID = (isset($condition_id) && $condition_id != '') ? $condition_id : 0;
              PatientCondition::addPatientCondition($relationID, $conditionID, $data['sourcetype'], $data['user_id'], session('user.userID'), $data['clinic_id']);
            }
          }
        } else {
          $relationID = (isset($data['relation']) && $data['relation'] != '') ? $data['relation'] : 0;
          if (!empty($data['condition_id'])) {
            foreach ($data['condition_id'] as $condition_id) {
              $conditionID = (isset($condition_id) && $condition_id != '') ? $condition_id : 0;
              PatientCondition::addPatientCondition($relationID, $conditionID, $data['sourcetype'], $data['user_id'], session('user.userID'), $data['clinic_id']);
            }
          }
        }

        break;

      default:


        // Handle unknown section
        break;
    }
    return $section;
  }

  function getBmiDetails($data)
  {

    $userID = $data['user_id'];
    /* get latest hieght */
    $height = HeightTracker::getLatestHeightTracker($userID);
    if (!empty($height)) {

      $weightKg = $data['unit'] == 'lbs' ? $data['weight'] * 0.453592  : $data['weight'];
      $heightM  = $height['unit'] == 'cm' ? $height['height'] / 100  : $height['height'] * 0.0254;

      $bmi = $weightKg / ($heightM * $heightM);
      return number_format($bmi, 2);
    } else {
      if (isset($data['height']) && $data['height'] != '') {
        $weightKg = $data['unit'] == 'lbs' ? $data['weight'] * 0.453592  : ($data['unit'] == 'kg' ? $data['weight'] : '');
        $heightM  = $data['unit'] == 'cm' ? $data['height'] / 100  : $data['height'] * 0.0254;

        $bmi = $weightKg / ($heightM * $heightM);
        return  number_format($bmi, 2);
      }
    }
  }
  function attachDefaultFolders($userId)
  {
    $folders = DB::table('ref_fc_folders')->get();
    if (!empty($folders)) {
      foreach ($folders as $key => $value) {
        $checkFolderExist = DB::table('fc_user_folders')->where('folder_id', $value->id)->where('user_id', $userId)->first();
        if (empty($checkFolderExist)) {
          $folderUuid = $this->generateUniqueKey("10", "fc_user_folders", "fc_user_folder_uuid");
          DB::table('fc_user_folders')->insertGetId(array(
            'fc_user_folder_uuid' => $folderUuid,
            'user_id' => $userId,
            'folder_id' => $value->id,
            'folder_name' => $value->folder_name,
            'is_default' => '1',
            'user_type' => '2',
            'created_by' => $userId,
            'created_at' => carbon::now(),
          ));
        }
      }
    }
  }
  /* Timezone */
  public function timezoneChange($date, $type = "", $isdate = 1)
  {
    $isDate = 'true';
    if ($isdate == 1) {
      $isDate = $this->checkIsAValidDate($date);
    }
    if ($isDate == 'true') {
      $userID           =  Session::get('user.userID');
      $timezoneDetails = array();
      $users = $this->convertToArray(DB::table('users')->select('timezone_id')->where('id', $userID)->whereNull('deleted_at')->first());
      if (!empty($users)) {
        $timezoneDetails = DB::table('ref_timezones')->where('id', $users['timezone_id'])->whereNull('deleted_at')->first();
        $timezoneDetails = $this->convertToArray($timezoneDetails);
      }

      $timezone = (!empty($timezoneDetails) ? $timezoneDetails['timezone_format'] : 'UTC');
      $originalTimestamp = $date;

      $originalDatetime = Carbon::parse($originalTimestamp, 'UTC');
      $localDatetime = $originalDatetime->setTimezone($timezone);
      $timezonedate = $localDatetime->format($type);

      return $timezonedate;
    } else {
      return $date;
    }
  }
  public function timezoneChangeAppointment($date, $time, $type = "Y-m-d H:i:s", $isdate = 1)
  {
    $isDate = 'true';
    if ($isdate == 1) {
      $isDate = $this->checkIsAValidDate($date);
    }

    if ($isDate == 'true') {
      $userID = Session::get('user.userID');
      $timezoneDetails = array();
      $users = $this->convertToArray(
        DB::table('users')->select('timezone_id')->where('id', $userID)->whereNull('deleted_at')->first()
      );

      if (!empty($users)) {
        $timezoneDetails = DB::table('ref_timezones')
          ->where('id', $users['timezone_id'])
          ->whereNull('deleted_at')
          ->first();
        $timezoneDetails = $this->convertToArray($timezoneDetails);
      }

      $timezone = (!empty($timezoneDetails) ? $timezoneDetails['timezone_format'] : 'UTC');

      // Combine date and time into a single DateTime string in UTC
      $combinedDateTime = $date . ' ' . $time;
      $originalDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $combinedDateTime, 'UTC'); // Parse as UTC

      // Convert to user's timezone
      $localDatetime = $originalDatetime->setTimezone($timezone);
      $timezonedate = $localDatetime->format($type); // Format based on the provided type

      return $timezonedate;
    } else {
      return $date;
    }
  }
  function checkIsAValidDate($originalTimestamp)
  {
    return (bool)strtotime($originalTimestamp);
  }

  /*jomy */
  function calculateAge($dob)
  {
    $dob = Carbon::parse($dob);
    if ($dob->diffInYears() < 1) {
      $months = round($dob->diffInMonths()); // Round to the nearest whole number
      $age = $months . ' MO';
    } else {
      $age = $dob->age . ' YO';
    }
    return $age;
  }

  /*jomy */

  function formatPhoneNumber($countryId, $phoneNumber)
  {

    $country_code = DB::table('ref_country_codes')->where('id', $countryId)->select('country_code')->first();
    $formattedNumber = $country_code->country_code . ' ' . $phoneNumber;
    return $formattedNumber;
  }
  /*lekshmi */
  function showClinicanName($consultant, $isarray = '0')
  {
    // dd($consultant);
    $designationId = ($isarray == 1) ? $consultant['designation_id'] : $consultant->designation_id;
    $username = ($isarray == 1) ? (isset($consultant['user']['first_name']) ? $consultant['user']['first_name'] . ' ' . $consultant['user']['last_name'] : $consultant['first_name'] . ' ' . $consultant['last_name']) : (isset($consultant->user->first_name) ? $consultant->user->first_name . ' ' . $consultant->user->last_name : $consultant->first_name . ' ' . $consultant->last_name);
    //$username = DB::table('users')->where('id',$user_id)->select('first_name')->first();
    $designation =  ($designationId != '') ? DB::table('ref_designations')->where('id', $designationId)->select('name')->first() : array();


    $consultantName = $username . (!empty($designation) ? ', ' . $designation->name : '');

    return $consultantName;
  }
  /*lekshmi */
  function showClinicanNameUser($consultant, $isactive = '0')
  {
    $designationId = $consultant['designation_id'];
    // $username = ($isactive == 1) ? $consultant['first_name'].' '.$consultant['last_name'] : $consultant['name'];
    $username = ($isactive == 1) ? $consultant['first_name'] . ' ' . $consultant['last_name'] : $consultant['first_name'] . ' ' . $consultant['last_name'];

    //$username = DB::table('users')->where('id',$user_id)->select('first_name')->first();
    $designation =  ($designationId != '') ? DB::table('ref_designations')->where('id', $designationId)->select('name')->first() : array();


    $consultantName = $username . (!empty($designation) ? ', ' . $designation->name : '');

    return $consultantName;
  }
  function showClinicanNamePayout($consultant, $designationId, $isactive = '1')
  {
    $username = ($isactive == 1) ? $consultant['first_name'] : $consultant['name'];
    $designation =  ($designationId != '') ? DB::table('ref_designations')->where('id', $designationId)->select('name')->first() : array();

    $consultantName = $username . (!empty($designation) ? ', ' . $designation->name : '');

    return $consultantName;
  }
  /*lekshmi */
  function getClinicLogo()
  {

    //$clinicDetails = Clinic::select('logo')->where('id', session()->get('user.clinicID'))->first();

    $clinicLogo = (Session::get('user.clinicLogo') != '') ? Session::get('user.clinicLogo') : asset('images/default_clinic.png');
    return $clinicLogo;
  }

  function connectStripe($urlArray)
  {

    $this->stripePayment = new \App\customclasses\StripePayment;
    //  Process clinic detsils
    $clinicDetails = ClinicUser::where('clinic_user_uuid', $urlArray['state'])->first();
    if (empty($clinicDetails)) {
      session()->flash("otperror", "The clinic users credentials missing.");
      return back();
    }

    $connectionresponse = $this->stripePayment->connectStripeAccount($urlArray['code']);
    $connectionresponse = json_decode(json_encode($connectionresponse['response']), true);

    if (empty($connectionresponse) && !isset($connectionresponse['stripe_user_id'])) {
      $this->AdditionalFunctions->returnError("Stripe connection failed");
    }

    if (!empty($connectionresponse) && isset($connectionresponse['stripe_user_id'])) {

      /** Inset StripeConnection info  */
      $stripeuuid = $this->generateUniqueKey("10", "stripe_connections", "stripe_connectionkey");
      $stripeObject = new StripeConnection();
      $stripeObject->stripe_connectionkey = $stripeuuid;
      $stripeObject->user_id = $clinicDetails['user_id'];
      $stripeObject->stripe_user_id = $connectionresponse['stripe_user_id'];
      $stripeObject->connection_response = json_encode($connectionresponse);
      $stripeObject->status = '1';
      $stripeObject->save();
      $connectionID = $stripeObject->id;

      DB::table('clinics')->where('id', $clinicDetails['clinic_id'])->update(array(
        'stripe_connection_id' => $connectionID,
        'updated_at' => Carbon::now(),
      ));
    }

    return $connectionID;
  }



  public function getFileName($folderId, $originalName, $extension)
  {
    // Get base name without extension
    $pathInfo = pathinfo($originalName);
    $baseName = $pathInfo['filename'];

    // Get all files with similar names in the folder
    $existingFiles = FcFile::where('folder_id', $folderId)
      ->where('file_name', 'LIKE', $baseName . '%' . '.' . $extension)
      ->pluck('file_name')
      ->toArray();

    if (empty($existingFiles)) {
      return $originalName;
    }

    // Find highest counter
    $maxCounter = 1;
    foreach ($existingFiles as $file) {
      if (preg_match('/' . preg_quote($baseName) . '\((\d+)\)\.' . $extension . '/', $file, $matches)) {
        $counter = (int)$matches[1];
        $maxCounter = max($maxCounter, $counter);
      }
    }
    // Generate new filename with next counter
    $newCounter = $maxCounter + 1;
    return $baseName . "(" . $newCounter . ")." . $extension;
  }



  /** Set session data */
  function setTempSessionData($userOtpData, $input, $userCountryCode, $countryShortCode)
  {

    $sessArray = array();
    $sessArray['tempuser']['otpkey'] = isset($userOtpData['otpUuid']) ? $userOtpData['otpUuid'] : '';
    $sessArray['tempuser']['otp'] = isset($userOtpData['userotp']) ? $userOtpData['userotp'] : '';
    $sessArray['tempuser']['phonenumbers'] = $input['user_phone'];
    $sessArray['tempuser']['countrycode'] = !empty($userCountryCode) ? $userCountryCode['country_code'] : null;
    $sessArray['tempuser']['countryCodeShorts'] = $countryShortCode;
    $sessArray['tempuser']['userTypes'] = 'clinics';
    $sessArray['tempuser']['isregister'] = '1';
    session($sessArray);
  }
  public function uploadImage($input, $userID, $userType, $parentID, $clinicUserKey = '')
  {

    /* Temp Image Details */
    $tempImageDetails = DB::table("temp_docs")->where("tempdoc_uuid", $input['tempimage'])->first();
    if (!empty($tempImageDetails)) {
      $originalpath = "storage/app/public/tempImgs/original/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
      $croppath = "storage/app/public/tempImgs/crop/" . $tempImageDetails->tempdoc_uuid . "." . $tempImageDetails->temp_doc_ext;
      if ($userType == 'patient') {
        $crppath = 'patients/' . $tempImageDetails->tempdoc_uuid . '.' . $tempImageDetails->temp_doc_ext;
      } else {
        $crppath = $this->getMyPathForAWS($parentID, $tempImageDetails->tempdoc_uuid, $tempImageDetails->temp_doc_ext, 'users/');
      }

      $image_path = $tempImageDetails->tempdoc_uuid . '.' . $tempImageDetails->temp_doc_ext;

      $image_path = File::get($croppath);
      if ($this->uploadDocumenttoAWS($crppath, $image_path)) {
        $image_path = $crppath;
        if ($userType != 'clinic' && $userType != 'clinicbanner') {

          User::updateImageToTable('users', 'profile_image', $userID, $image_path); // updte to users table
        }
        if ($userType == 'patient') {
          User::updateImageToTable('patients', 'logo_path', $parentID, $image_path); // updte to patients table
        } elseif ($userType == 'clinic' || $userType == 'clinicbanner') {
          $filed = ($userType == 'clinicbanner') ? 'banner_img' : 'logo';
          User::updateImageToTable('clinics', $filed, $parentID, $image_path); // updte to clinic table
          if ($userType == 'clinic') {
            $clinicLogo = $this->getAWSFilePath($crppath);
            Session::put("user.clinicLogo", $clinicLogo);   // Update only the clinicLogo in the session
          }
        } elseif ($userType == 'clinic_users') {

          User::updateImageToTable('clinic_users', 'logo_path', $parentID, $image_path); // updte to clinicuser table

          User::updateImageToTable('users', 'profile_image', $userID, $image_path); /// updte to users table
          if ($userType == 'clinic_users') {
            $userLogo = $this->getAWSFilePath($crppath);
            if ($userID == session('user.userID')) {
              Session::put("user.userLogo", $userLogo);
            }
          }
        }
      }
      unlink($croppath);
    }
  }
  public function updateAccountBalance($clinicid, $amount)
  {
    DB::table('clinics')->where('id', $clinicid)->limit(1)->update(array(
      'account_balance' => $amount,
      'updated_at' => Carbon::now()
    ));
  }
  public function updateAccountLocked($clinic_id, $user_id)
  {
    $userDetails = $this->convertToArray(DB::table('users')->where('id', $user_id)->whereNull('deleted_at')->limit(1)->first());

    $clinics = DB::table('clinics')->whereNull('deleted_at')->Where('id', $clinic_id)->first();
    $clinics = $this->convertToArray($clinics);
    if (!empty($clinics) && $clinics['account_locked'] == 1) {
      return;
    }
    Payment::updateAccountLocked($clinic_id, '1'); // Update account locked

    /* Notifications */
    $notificationType = '15';
    $this->addNotifications($notificationType, $clinics['id'], $userDetails['id'], $clinics['id']);

    $data['clinic_logo'] = (isset($clinics['logo']) && ($clinics['logo'] != '')) ? $this->getAWSFilePath($clinics['logo']) : '';
    $data['loginURL'] = url('/login');
    $data['email'] = $userDetails['email'];
    $data['userDetails'] = $userDetails;
    $subject = "Your Account is Locked – Payment Required for Reactivation";
    $this->sendmail($data, $subject, 'emails.accountlockedmail');
  }
  public function generateNewInvoice($subscriptionID, $planID, $userid, $clinicid, $billingInfo = array(), $intentID = '', $istrial = '', $fromtrial = '')
  {
    // fetch subscription details
    $planDetails = $this->convertToArray(DB::table('subscription_plans')->where('id', $planID)->whereNull('deleted_at')->limit(1)->first());
    $subscriptionDetails = $this->convertToArray(DB::table('subscriptions')->where('id', $subscriptionID)->whereNull('deleted_at')->limit(1)->first());
    $amount = $planDetails['amount'];
    if (isset($billingInfo['amount_to_pay'])) {
      $amount = $billingInfo['amount_to_pay'];
    }

    // Insert  invoice details 
    $invoiceDate = date('Y-m-d');
    $gracePeriod = GRACE_PERIOD;
    $payByDate = date('Y-m-d', strtotime($subscriptionDetails['end_date'] . ' + ' . $gracePeriod . ' days'));
    $retryDate = date('Y-m-d', strtotime($subscriptionDetails['end_date'] . ' + 5 days'));
    $expiryData = date("Y-m-d",  strtotime("+5 days"));
    $planDetails['start_date'] = date('Y-m-d');
    if ($planDetails['tenure_type_id'] == 1) {
      $planDetails['end_date'] = date('Y-m-d', strtotime('+1 years', time()));
    }
    if ($planDetails['tenure_type_id'] == 2) {
      $planDetails['end_date'] = date('Y-m-d', strtotime('+1 months', time()));
    }

    /* Invioce with zero amount-from create wrk space */
    if ($istrial == '1') {
      $planDetails['start_date'] = $subscriptionDetails['start_date'];
      $planDetails['end_date']   = $subscriptionDetails['end_date'];
      if ($fromtrial == 1) {
      } else {
        $amount = '0.00';
      }
    }
    $planDetails['fromtrial'] = $fromtrial;

    $invoiceID = Payment::insertInvoiceData($invoiceDate, $payByDate, $retryDate, $userid, $clinicid, $billingInfo, $amount, $planDetails, $intentID, $expiryData);

    //Insert invoice items
    $invoiceItemID = Payment::insertInvoiceItemData($invoiceID, $clinicid, $subscriptionID, $planID, $amount);
    return $invoiceID;
  }
  public function invoicePayment($invoiceID, $isrenewal = '', $hasAccountBalance = '', $finalAmountToPay = '')
  {
    $this->stripePayment = new \App\customclasses\StripePayment;
    $invoiceDetails = $this->getInvoiceDetails($invoiceID);
    if (empty($invoiceDetails)) {
      return;
    }

    $clinicSubscriptionDetails = $this->convertToArray(DB::table('subscriptions')->where('clinic_id', $invoiceDetails['clinic_id'])->whereNull('deleted_at')->limit(1)->first());
    if (empty($clinicSubscriptionDetails)) {
      return;
    }

    /* Subscription Details */
    $subscriptionDetails = $this->convertToArray(DB::table('subscription_plans')->where('id', $clinicSubscriptionDetails['subscription_plan_id'])->whereNull('deleted_at')->limit(1)->first());
    if ($subscriptionDetails['tenure_type_id'] != '') {
      $subscriptionDetails['duration'] = ($subscriptionDetails['tenure_type_id'] == '1') ? 'Yearly' : 'Monthly';
    }

    /* Renewal Subscription Details */
    $renewalSubscriptionDetails = $this->convertToArray(DB::table('subscription_plans')->where('id', $clinicSubscriptionDetails['renewal_plan_id'])->whereNull('deleted_at')->limit(1)->first());
    if (empty($renewalSubscriptionDetails)) {
      $this->updateAccountLocked($invoiceDetails['clinic_id'], $invoiceDetails['user_id']); // update clinic locking
      return;
    }

    if (!empty($renewalSubscriptionDetails)) {
      if ($renewalSubscriptionDetails['tenure_type_id'] != '') {
        $renewalSubscriptionDetails['duration'] = ($renewalSubscriptionDetails['tenure_type_id'] == '1') ? 'Yearly' : 'Monthly';
      }
    }

    $renewalPlanID = (!empty($renewalSubscriptionDetails)) ? $renewalSubscriptionDetails['id'] : NULL;

    /* Get Renewal Payment Details */
    $subscriptionPaymentDetails = $this->getSubscriptionPaymentDetails($invoiceDetails['clinic_id'], $subscriptionDetails['id'], $renewalPlanID);

    /* User Card */
    $userCard = $this->convertToArray(DB::table('clinic_cards')->where('clinic_id', $invoiceDetails['clinic_id'])->where('is_default', '1')->whereNull('deleted_at')->limit(1)->first());

    /* User Address */
    $userAddress = $this->convertToArray(DB::table('user_billing')->where('clinic_id', $invoiceDetails['clinic_id'])->whereNull('deleted_at')->limit(1)->first());

    /* User Details */
    $userDetails = $this->convertToArray(DB::table('users')->where('id', $invoiceDetails['user_id'])->whereNull('deleted_at')->limit(1)->first());

    /* Clinic Details */
    $clinicDetails = $this->convertToArray(DB::table('clinics')->where('id', $invoiceDetails['clinic_id'])->whereNull('deleted_at')->limit(1)->first());

    /* Clinic Admins */
    $isSuccess = '1';
    $backUpCardUsed = '0';
    $message = $subject = '';
    $requiresAction = '0';

    $startDate = date('Y-m-d');
    $paymentId = $amountToPay =  $recurrence_end_date = NULL;
    $recurrence_end_date = ($renewalSubscriptionDetails['tenure_type_id'] == '1') ? date('Y-m-d', strtotime($startDate . ' +1 month')) : date('Y-m-d', strtotime($startDate . ' +1 year'));

    if ($isSuccess == 1) {
      $amountToPay = $renewalSubscriptionDetails["amount"];
      if ($isrenewal == 1) {
        /** Remewal amount from account balance */
        $amountToPay = $finalAmountToPay;
      }
      echo $amountToPay;
      exit;
      $cents = (int) (((string) ($amountToPay * 100))); // convert doller to cent
      /* Update Invoice Amount */
      Payment::updateInvoiceAmount($invoiceID, $amountToPay);
      /* Debit Amount */
      $description = 'Subscription Renewal';

      $clinics = DB::table('clinics')->whereNull('deleted_at')->Where('id', $invoiceDetails['clinic_id'])->first();
      $clinics = $this->convertToArray($clinics);
      if ($amountToPay > 0) {
        $intentChargeResponse = $this->stripePayment->createPaymentIntent($cents, $clinicDetails['stripe_connection_id'], $userCard['stripe_card_id'], $description);
        $intentChargeResponse = json_decode(json_encode($intentChargeResponse), True);
        $intentresponse = $intentChargeResponse['response'];

        Payment::updateInvoiceIntentID($invoiceID, $intentresponse['id']);
      }

      if (isset($intentresponse['status']) && $intentresponse['status'] == 'requires_action') {
        $isSuccess = '0';
        $subject = 'Subscription Renewal Requires Action';
        $requiresAction = '1';

        Payment::updateInvoiceStatus($invoiceID, $paymentId, '1'); // update payment  success
        Payment::updateRetryDate($invoiceID, date('Y-m-d', strtotime($clinicSubscriptionDetails['renewal_date'] . ' + ' . GRACE_PERIOD . ' days')));
      }

      /* Insert Transactions */
      if ($amountToPay > 0) {
        $transactionID = Payment::insertTransactions(json_encode($intentChargeResponse), $userDetails['id'], $invoiceDetails['clinic_id']);
      }

      if (isset($intentresponse['status']) && ($intentresponse['status'] == 'succeeded' || $intentresponse['status'] == 'requires_action')) {
        $response = $intentChargeResponse['response'];

        $paymentStatus = ($intentresponse['status'] == 'requires_action') ? '-1' : '1';
        $paymentId = $this->insertPayment($response, $userDetails['id'], $invoiceID, $backUpCardUsed, $amountToPay, $transactionID, $paymentStatus);
        Payment::updateInvoicePaymentID($invoiceID, $paymentId); // update payment  success
      } else if ($amountToPay <= 0) {
        $isSuccess = '1';
        $transactionID = NULL;
        $response = array();
        $paymentId = $this->insertPayment($response, $userDetails['id'], $invoiceID, $backUpCardUsed, $amountToPay, $transactionID, 1);
        Payment::updateInvoicePaymentID($invoiceID, $paymentId); // update payment  success
      } else {
        /* Fetching back up card details & and replacing existing card info */
        $userCard = $backupCardDetails = DB::table('clinic_cards')->where('user_id', $userDetails['id'])->whereNull('deleted_at')->where('is_default', '0')->where('clinic_id', $invoiceDetails['clinic_id'])->limit(1)->first();
        $userCard = $backupCardDetails = $this->convertToArray($backupCardDetails);

        if (!empty($backupCardDetails)) {
          $intentChargeResponse = $this->stripePayment->createPaymentIntent($cents, $clinicDetails['stripe_connection_id'], $backupCardDetails['stripe_card_id'], $description);
          $intentChargeResponse = json_decode(json_encode($intentChargeResponse), True);

          $transactionID = Payment::insertTransactions(json_encode($intentChargeResponse), $userDetails['id'], $invoiceDetails['clinic_id']);

          $intentresponse = $intentChargeResponse['response'];
          Payment::updateInvoiceIntentID($invoiceID, $intentresponse['id']);
          if ($intentresponse['status'] == 'requires_action') {
            $isSuccess = '0';
            $subject = 'Subscription Renewal Requires Action';
            $requiresAction = '1';

            Payment::updateInvoiceStatus($invoiceID, $paymentId, '1'); // update payment  success
            Payment::updateRetryDate($invoiceID, date('Y-m-d', strtotime($clinicSubscriptionDetails['renewal_date'] . ' + ' . GRACE_PERIOD . ' days')));
          }

          //if (isset($intentChargeResponse['status']) && $intentChargeResponse['status'] == '1'  ) {
          if ($intentresponse['status'] == 'succeeded' || $intentresponse['status'] == 'requires_action') {
            $backUpCardUsed = '1';
            $response = $intentChargeResponse['response'];

            $paymentStatus = ($intentresponse['status'] == 'requires_action') ? '-1' : '1';
            $paymentId = $this->insertPayment($response, $userDetails['id'], $invoiceID, $backUpCardUsed, $amountToPay, $transactionID, $paymentStatus);
            Payment::updateInvoicePaymentID($invoiceID, $paymentId); // update payment  success
          } else {
            $isSuccess = '0';
            $subject = 'Failed Backup Card Payment';

            $message = (isset($intentChargeResponse['response'])) ? $intentChargeResponse['response'] : 'Something went wrong.';
            Payment::updateRetryDate($invoiceID, date('Y-m-d', strtotime($clinicSubscriptionDetails['renewal_date'] . ' + ' . GRACE_PERIOD . ' days')));
            $this->updateAccountLocked($invoiceDetails['clinic_id'], $invoiceDetails['user_id']); // account locked
            Payment::updateInvoiceStatus($invoiceID, NULL, '3');
          }
        } else {
          $isSuccess = '0';
          $subject = 'Backup card not added';
          $message = 'Backup card not added';

          $this->updateAccountLocked($invoiceDetails['clinic_id'], $invoiceDetails['user_id']); // account locked
          Payment::updateInvoiceStatus($invoiceID, NULL, '3');

          Payment::updateRetryDate($invoiceID, date('Y-m-d', strtotime($clinicSubscriptionDetails['renewal_date'] . ' + ' . GRACE_PERIOD . ' days')));
        }
      }
      if ($isSuccess == '1') {
        $intentChargeResponse = isset($intentChargeResponse) ? json_decode(json_encode($intentChargeResponse), True) : array();
        /*** billing info ***/
        $insertData['billing_info'] = $userAddress;
        $insertData['card_info'] = $userCard;
        $insertData['card_info']['card_number'] = $userCard['card_num'];
        $insertData['card_info']['expiry_year'] = $userCard['exp_year'];
        $insertData['card_info']['expiry_month'] = $userCard['exp_month'];
        $data['billing_info'] = $insertData['billing_info'];
        $data['card_info'] = $insertData['card_info'];
        $data['receipt_num'] = 1000 + $paymentId;

        $renewDate = ($recurrence_end_date != NULL) ? date('Y-m-d', strtotime('+1 day', strtotime($recurrence_end_date))) : NULL;

        /* Insert Subscription History */
        $historyID = DB::table('subscriptions_history')->insertGetId(array(
          'subscription_plan_id' => $renewalSubscriptionDetails['id'],
          'renewal_plan_id' => $renewalSubscriptionDetails['id'],
          'amount' => $amountToPay,
          'user_id' => $userDetails['id'],
          'start_date' => $startDate,
          'end_date' => $recurrence_end_date,
          'tenure_type_id' => $renewalSubscriptionDetails['tenure_type_id'],
          'payment_id' => $paymentId,
          'tenure_period' => '1',
          'clinic_id' => $invoiceDetails['clinic_id'],
          'created_at' => Carbon::now()
        ));

        /* Insert/Update User Subscription */
        $userSubscriptionDetails = $this->convertToArray(DB::table('subscriptions')->where('clinic_id', $invoiceDetails['clinic_id'])->whereNull('deleted_at')->limit(1)->first());

        if (!empty($userSubscriptionDetails)) {
          Subscription::updateUserSubscription($userSubscriptionDetails['id'], $renewalSubscriptionDetails['id'], $historyID, $startDate, $recurrence_end_date, $renewDate, $renewalSubscriptionDetails['id']);
        } else {
          $userSubscription = Subscription::insertUserSubscription($userDetails['id'], $renewalSubscriptionDetails['id'], $historyID, $startDate, $recurrence_end_date, $renewDate, $renewalSubscriptionDetails['id'], $usv['clinic_id']);
        }
        $userSubscriptionDetails = $this->convertToArray(DB::table('subscriptions')->where('clinic_id', $invoiceDetails['clinic_id'])->whereNull('deleted_at')->limit(1)->first());

        $data['userSubscriptionDetails'] = $userSubscriptionDetails;

        /* Update invoice  status & payment id **/
        Payment::updateInvoiceStatus($invoiceID, $paymentId, '2'); // update payment  success
        /* Update Existing Pending Invoices to Cancelled Status */
        $this->cancelInvoice($invoiceDetails['clinic_id']);

        /* update trail subscription status */
        Payment::updateTrialSubscriptionByUserPlanID($userSubscriptionDetails['id']);  // remove trial plan  for clinic
        Payment::updateAccountLocked($invoiceDetails['clinic_id'], '0'); // removed account locked
      }
    }

    $clinics = DB::table('clinics')->whereNull('deleted_at')->Where('id', $invoiceDetails['clinic_id'])->first();
    $clinics = $this->convertToArray($clinics);

    if ($isSuccess == 1) {
      if ($backUpCardUsed == 1) {
        $data['clinic_logo']        = (isset($clinics['logo']) && ($clinics['logo'] != '')) ? $this->getAWSFilePath($clinics['logo']) : '';

        $data['email'] = $userDetails['email'];
        $data['first_name'] = $userDetails['first_name'];
        $data['last_name'] = $userDetails['last_name'];
        $this->sendmail($data, 'BlackBag Subscription Renewal Confirmation - Backup Card Used', 'emails.renewal_backupcard');
      } else {
        /* Send Receipt Mail */
        $data['amount_label'] = '$' . number_format($amountToPay, 2);
        $data['email'] = $userDetails['email'];
        $data['userDetails'] = $userDetails;
        $data['subscriptionsDetails'] = $renewalSubscriptionDetails;
        $data['mailcontent'] = $message;
        $data['startDate'] = date('m/d/Y', strtotime($startDate));
        $data['endDate'] = $recurrence_end_date;
        $data['clinic_logo'] = (isset($clinics['logo']) && ($clinics['logo'] != '')) ? $this->getAWSFilePath($clinics['logo']) : '';
        $data['backUpCardUsed'] = $backUpCardUsed;

        $data['hasAccountBalance'] = ($hasAccountBalance == '1' && ($finalAmountToPay != '')) ? '1' : '0';
        $data['accountBalance'] =   $clinicDetails['account_balance'] > 0 ? '$' . number_format($clinicDetails['account_balance'], 2)  : 0.00;

        $data['url'] = url('login');
        $this->sendmail($data, 'BlackBag Payment Receipt', 'emails.invoicedetails');

        /* Notifications */
        $notificationType = '16';
        $this->addNotifications($notificationType, $clinicDetails['id'], $userDetails['id'], $userSubscriptionDetails['id']);
      }
    } else {
      if ($requiresAction == 1) {
        $data['url'] = url('login');
        $data['clinic_logo']        = (isset($clinics['logo']) && ($clinics['logo'] != '')) ? $this->getAWSFilePath($clinics['logo']) : '';
        $data['email'] = $userDetails['email'];
        $data['first_name'] = $userDetails['first_name'];
        $data['last_name'] = $userDetails['last_name'];

        $this->sendmail($data, 'BlackBag Subscription Renewal Requires Action', 'emails.renewal_requires_action');
      } else {
        $data['email'] = $userDetails['email'];
        $data['userDetails'] = $userDetails;
        $data['subscriptionsDetails'] = $renewalSubscriptionDetails;
        $data['startDate'] = date('m/d/Y', strtotime($startDate));
        $data['endDate'] = $recurrence_end_date;
        $data['clinic_logo']        = (isset($clinics['logo']) && ($clinics['logo'] != '')) ? $this->getAWSFilePath($clinics['logo']) : '';
        $this->sendmail($data, 'BlackBag Subscription Renewal Failure - Action Required', 'emails.failedrenewalmail');
      }
    }
  }

  public function insertPayment($response, $userid, $invoiceID, $backUpCard, $amountToPay, $transactionID, $status)
  {
    $invoiceDetails = $this->getInvoiceDetails($invoiceID);

    /* Clinic Details */
    $clinicDetails = $this->convertToArray(DB::table('clinics')->where('id', $invoiceDetails['clinic_id'])->whereNull('deleted_at')->limit(1)->first());

    /* User Card */
    $userCard = DB::table('clinic_cards')->where('clinic_id', $invoiceDetails['clinic_id'])->whereNull('deleted_at');
    if ($backUpCard == 1) {
      $userCard = $userCard->where('is_default', '0');
    } else {
      $userCard = $userCard->where('is_default', '1');
    }
    $userCard = $userCard->limit(1)->first();
    $userCard = $this->convertToArray($userCard);

    /* User Address */
    $userAddress = $this->convertToArray(DB::table('user_billing')->where('clinic_id', $invoiceDetails['clinic_id'])->whereNull('deleted_at')->limit(1)->first());

    $userDetails = $this->convertToArray(DB::table('users')->where('id', $userid)->whereNull('deleted_at')->limit(1)->first());

    $cardType = NULL;

    /* Payment Details */
    $paymentDetails['stripe_customerid'] = $clinicDetails['stripe_connection_id'];
    $paymentDetails['stripe_paymentid'] = isset($response['id']) ? $response['id'] : NULL;
    $paymentDetails['user_card_id'] = $userCard['id'];
    $paymentDetails['amount'] = $amountToPay;
    $paymentDetails['no_of_users'] = $clinicDetails['seats_purchased'];
    $paymenttypeid = '1';
    $paymentDetails['transactionid'] = $transactionID;
    $paymentDetails['payment_type_id'] = $paymenttypeid;
    $paymentDetails['cardinfo']['card_type'] = $cardType;

    /*** Insert payment ***/
    $insertData['billing_info'] = $userAddress;
    $insertData['billing_info']['billing_name'] = $userAddress['billing_company_name'];
    $insertData['billing_info']['state'] = $userAddress['billing_state_id'];
    $insertData['billing_info']['zip'] = $userAddress['billing_zip'];
    $insertData['billing_info']['billing_email'] = $userDetails['billing_email'];
    $insertData['billing_info']['state'] = ($userAddress['country_id'] == '236') ? $userAddress['billing_state_id'] : $userAddress['billing_state_other'];
    $country = $this->convertToArray(DB::table('ref_country_codes')->where('id', $userAddress['billing_country_id'])->limit(1)->first());
    $insertData['billing_info']['country'] = $country['country_name'];

    $insertData['card_info'] = $userCard;
    $insertData['card_info']['card_number'] = $userCard['card_num'];
    $insertData['card_info']['expiry_year'] = $userCard['exp_year'];
    $insertData['card_info']['expiry_month'] = $userCard['exp_month'];

    $paymentKey = $this->generateUniqueKey('10', 'payments', 'payment_uuid');
    $paymentId  = Payment::savePaymentData($insertData, $paymentKey, $userid, $paymentDetails, $status);
    return $paymentId;
  }
  public function getInvoiceDetails($invoiceID)
  {
    $invoiceDetails = $this->convertToArray(DB::table('invoices')->where('id', $invoiceID)->whereNull('deleted_at')->limit(1)->first());
    return $invoiceDetails;
  }
  public function getSubscriptionPaymentDetails($clinicid, $currentPlanID, $renewalPlanID, $isAccBlanc = '0')
  {
    $toUpgrade = $toDowngrade = $paymentAmount = $isAccountBalance =  0;
    $balanceAmount = '0.00';
    $usedAmounts = '0.00';
    $usedAmountsVal = '0.00';
    $amountLabel = '';
    $usedAmountLabel = '';
    $renewalSubscriptionAmount = '';
    $clinicSubscription = $this->convertToArray(DB::table('subscriptions')->select('subscription_plan_id', 'id', 'start_date', 'end_date', 'trial_subscription', 'renewal_plan_id')->where('clinic_id', $clinicid)->whereNull('deleted_at')->first());
    $currentSubscription = $this->convertToArray(DB::table('subscription_plans')->select('id', 'plan_name', 'tenure_type_id', 'amount')->where('id', $currentPlanID)->whereNull('deleted_at')->first());
    $renewalSubscription = $this->convertToArray(DB::table('subscription_plans')->select('id', 'plan_name', 'tenure_type_id', 'amount')->where('id', $renewalPlanID)->whereNull('deleted_at')->first());

    $paymentAmount = $yearlyAmount = $currentSubscription['amount'];

    $invoice      = $this->convertToArray(DB::table('invoices')->select('total_amount')->where('clinic_id', $clinicid)->whereNull('deleted_at')->first());
    if ($currentSubscription['tenure_type_id'] != '' && $currentPlanID != $renewalPlanID) {
      if (!empty($renewalSubscription)   && $clinicSubscription['trial_subscription'] != '1') {
        $toUpgrade = '1';

        $totalDays          = ceil(abs(strtotime($clinicSubscription['end_date']) - strtotime($clinicSubscription['start_date'])) / 86400);
        $perDayAmount       = number_format($yearlyAmount / $totalDays, 2, '.', '');
        $usedDays           = ceil(abs(time() - strtotime($clinicSubscription['start_date'])) / 86400);
        $usedAmount         = ($totalDays  - $usedDays) * $perDayAmount;

        $renewalAmount      = $renewalSubscription['amount'];

        $paymentAmount = number_format($renewalAmount - $usedAmount, 2, '.', '');

        /** Check for account balance  */
        $clinicDetails = $this->convertToArray(DB::table('clinics')->where('id', $clinicid)->whereNull('deleted_at')->limit(1)->first());
        $finalAmount = $paymentAmount;

        if (($finalAmount < 0) && ($isAccBlanc != '0') && ($clinicSubscription['trial_subscription'] != '1')) {
          $paymentAmount = 0.00;

          $renewalSubscriptionAmount = $renewalAmount;
          $usedAmounts = $usedAmount;
          /** Get the balance amount // if it negative then return zero  */
          $paymentAmountPerHead = ($usedAmounts < $renewalSubscriptionAmount) ? $renewalSubscriptionAmount - $usedAmounts : 0.00;
          $paymentAmount = $paymentAmountPerHead;
          /** get balace amount  for clinics update */
          $balanceAmount = number_format($usedAmounts - $renewalSubscriptionAmount, 2, '.', '');
          $balanceAmount = number_format($balanceAmount + $clinicDetails['account_balance'], 2, '.', '');
          $isAccountBalance = '1';
        } else {
          if (($clinicDetails['account_balance'] != '0.00') && ($clinicDetails['account_balance'] != '')) {
            $renewalSubscriptionAmount = $paymentAmount;
            $usedAmounts = $usedAmount;

            $paymentAmount = ($clinicDetails['account_balance'] < $renewalSubscriptionAmount) ? number_format($renewalSubscriptionAmount - $clinicDetails['account_balance'], 2, '.', '') : '0.00';
            /** Account balance updating if clinic already have balance  */
            $balanceAmount = ($clinicDetails['account_balance'] < $renewalSubscriptionAmount) ? 0.00 : number_format(($clinicDetails['account_balance'] - $renewalSubscriptionAmount), 2, '.', '');
            $isAccountBalance =  $balanceAmount > 0 ? '1' : '0';
          }
        }
        $usedAmountsVal = ($clinicDetails['account_balance'] != '' && $clinicDetails['account_balance'] > 0) ? $clinicDetails['account_balance'] : $usedAmounts;

        /** Get balance amount with label */
        $amountLabel = '$' . number_format($balanceAmount, 2);
        $usedAmountLabel = '$' . number_format($usedAmountsVal, 2);
        /** Update account balance to clinics table on makepayment fn */
        if ($isAccBlanc == '2') {
          $accountBalance = $this->updateAccountBalance($clinicid, $balanceAmount);
        }
        $toDowngrade = '1';
        if (!empty($renewalSubscription) && (($currentSubscription['related_plan_id'] == $renewalSubscription['id'] && $currentSubscription['tenure_type_id'] == 2 && $renewalSubscription['tenure_type_id'] == 1))) {
          $toDowngrade = '0';
        } else {
          $toDowngrade = '1';
        }
      } else {
        $toDowngrade = '1';
        $paymentAmount = 0.00;
      }
    }

    return array(
      'is_upgrade'                 => $toUpgrade,
      'is_downgrade'               => $toDowngrade,
      'payment_amount'             => $paymentAmount,
      'balanceAmount'              => $amountLabel,
      'isAccountBalance'           => $isAccountBalance,
      'usedAmountLabel'            => $usedAmountLabel,
      'usedAmount'                 => $usedAmountsVal,
      'subscription_amount'        => $renewalSubscriptionAmount,
      'remaining_account_balance'  => $balanceAmount,
    );
  }

  public function backupvalidatesUserPhone($data)
  {
    $type       = $data['type'];
    $phone      = (isset($data['user_phone']) && $data['user_phone'] != '') ? $data['user_phone'] : $data['phone_number'];
    $data['email'] = ($type == 'register') ? $data['user_email'] : $data['email'];
    $clinicUUID = isset($data['clinicUUID']) ? $data['clinicUUID'] : session()->get('user.clinicUUID');

    $clinicdata = Clinic::clinicByUUID($clinicUUID);
    Clinic::where('clinic_uuid', $clinicUUID)->value('id');
    $clinicId   = !empty($clinicdata) ? $clinicdata->id : '';

    if (isset($phone) && $phone != '' && (isset($data['country_code']) && $data['country_code'] != '')) {
      $countryCode = RefCountryCode::getCountryCodeByShortCode($data['country_code']);
    }


    /* check the email exist with in the whole system  with same number*/
    if ($data['email'] != '' && $phone != '') {

      $clinicUserId = $data['id'] ?? null;

      // Check for email associated with a different phone number in user
      $data['phone_number'] = $phone;
      $userDetails = User::validateUser($data, $clinicUserId, 'email', 'phone_number', $countryCode['id']);
      if ($userDetails > 0) {
        return ['error' => 1, 'message' => 'Email is already associated with another number.'];
      }

      // Check for phone number associated with a different email in user BB-241
      $userDetails = User::validateUser($data, $clinicUserId, 'phone_number', 'email', $countryCode['id']);
      if ($userDetails > 0) {
        return [
          'error' => 1,
          'message' => 'Phone number is already associated with another email.',
        ];
      }

      /* check in clinic_users table*/
      $clinicuserDetails = User::validateUserByEmail($data, $clinicId, $clinicUserId, 'clinic_users');
      if ($clinicuserDetails > 0) {
        return [
          'error' => 1,
          'message' => 'This account already exists in this clinic.',
        ];
      }

      /* check in patients table*/
      $patientDetails = User::validateUserByEmail($data, $clinicId, $clinicUserId, 'patients');
      if ($patientDetails > 0) {
        return [
          'error' => 1,
          'message' => 'This account already exists. You can login to add new clinic.',
        ];
      }

      // Check for clinic user exist with same phone number
      $clinicuserDetails = User::validateUserByPhone($data, $clinicId, $clinicUserId, 'clinic_users', $countryCode['id']);
      if ($clinicuserDetails > 0) {
        return [
          'error' => 1,
          'message' => 'This account already exists in this clinic.',
        ];
      }
      $patientDetails = User::validateUserByPhone($data, $clinicId, $clinicUserId, 'patients', $countryCode['id']);
      if ($patientDetails > 0) {
        return [
          'error' => 1,
          'message' => 'This account already exists. You can login to add new clinic.',
        ];
      }
    }
    return response()->json(['valid' => true]);
  }

  public function validateUserPhone($data)
  {

    $type = $data['type'] ?? null;
    $phone = $data['user_phone'] ?? $data['phone_number'] ?? null;
    $email = ($type === 'register') ? $data['user_email'] : $data['email'];
    $clinicUUID = $data['clinicUUID'] ?? session('user.clinicUUID');
    $fieldType = $data['field_type'] ?? null;
    $phone = str_replace(["(", ")", " ", "-"], "", $phone);
    // Fetch Clinic ID
    $clinic = Clinic::where('clinic_uuid', $clinicUUID)->first();
    $clinicId = $clinic->id ?? null;

    // Fetch Country Code
    $countryCode = ($data['country_code'] != '') ? RefCountryCode::getCountryCodeByShortCode($data['country_code']) : null;

    if (($email != '') && ($phone != '')) {
      $clinicUserId = $data['id'] ?? null;
      $data['phone_number'] = $phone;
      $data['email'] = $email;
      // Define validation checks
      /* for patient validation  */
      if (($type == 'patient') && ($fieldType == 'patient_phone')) {
        if ($fieldType == 'patient_phone') {
          $validationChecks = [
            ['method' => 'validateUserByPhone', 'args' => [$data, $clinicId, $clinicUserId, 'clinic_users', $countryCode['id'] ?? null], 'message' => 'This account already exists in this clinic.'],
            ['method' => 'validateUserByPhone', 'args' => [$data, $clinicId, $clinicUserId, 'patients', $countryCode['id'] ?? null], 'message' => 'This account already exists. You can login to add new clinic.'],
            ['method' => 'validateUser', 'args' => [$data, $clinicUserId, 'email', 'phone_number', $countryCode['id'] ?? null], 'message' => 'Email is already associated with another number.'],
            ['method' => 'validateUser', 'args' => [$data, $clinicUserId, 'phone_number', 'email', $countryCode['id'] ?? null], 'message' => 'Email is already associated with another number.'],
            ['method' => 'validateUserWithCountyCode', 'args' => [$data, $clinicUserId, 'phone_number', 'email', $countryCode['id'] ?? null], 'message' => ($fieldType === 'patient_phone')  ? 'Email is already associated with another number.' : 'Phone number is already associated with another email.'],

          ];
        }
      } else {
        $validationChecks = [
          ['method' => 'validateUserByEmail', 'args' => [$data, $clinicId, $clinicUserId, 'clinic_users'], 'message' => 'This account already exists in this clinic.'],
          ['method' => 'validateUserByEmail', 'args' => [$data, $clinicId, $clinicUserId, 'patients'], 'message' => 'This account already exists. You can login to add new clinic.'],
          ['method' => 'validateUser', 'args' => [$data, $clinicUserId, 'email', 'phone_number', $countryCode['id'] ?? null], 'message' => 'Email is already associated with another number.'],
          ['method' => 'validateUser', 'args' => [$data, $clinicUserId, 'phone_number', 'email', $countryCode['id'] ?? null], 'message' => 'Phone number is already associated with another email.'],
          ['method' => 'validateUserWithCountyCode', 'args' => [$data, $clinicUserId, 'phone_number', 'email', $countryCode['id'] ?? null], 'message' => ($fieldType === 'email')  ? 'This email is already associated with another number.' : 'Phone number is already associated with another email.'],
          ['method' => 'validateUserByPhone', 'args' => [$data, $clinicId, $clinicUserId, 'clinic_users', $countryCode['id'] ?? null], 'message' => 'This account already exists in this clinic.'],
          ['method' => 'validateUserByPhone', 'args' => [$data, $clinicId, $clinicUserId, 'patients', $countryCode['id'] ?? null], 'message' => 'This account already exists. You can login to add new clinic.'],
          ['method' => 'validatePhoneUser', 'args' => [$data, $clinicUserId, 'email', 'phone_number', $countryCode['id'] ?? null], 'message' => 'Email is already associated with another number.'],

        ];
      }
      // Run validation checks
      foreach ($validationChecks as $check) {
        if (User::{$check['method']}(...$check['args']) > 0) {
          return ['error' => 1, 'message' => $check['message']];
        }
      }
    }

    return ['success' => 1];
  }
  public function validateUserPhoneRegister($data)
  {

    $type = $data['type'] ?? null;
    $fieldType = $data['field_type'] ?? null;
    $phone = $data['user_phone'] ?? $data['phone_number'] ?? null;
    $email = ($type === 'register') ? $data['user_email'] : $data['email'];
    $clinicUUID = $data['clinicUUID'] ?? session('user.clinicUUID');
    $phone = preg_replace('/\D/', '', $phone);;
    // Fetch Clinic ID
    $clinic = Clinic::where('clinic_uuid', $clinicUUID)->first();
    $clinicId = $clinic->id ?? null;

    // Fetch Country Code
    $countryCode = ($data['country_code'] != '') ? RefCountryCode::getCountryCodeByShortCode($data['country_code']) : null;

    if (($email != '') && ($phone != '')) {
      $clinicUserId = $data['id'] ?? null;
      $data['phone_number'] = $phone;
      $data['email'] = $email;
      // Define validation checks
      $validationChecks = [
        ['method' => 'validateUser', 'args' => [$data, $clinicUserId, 'email', 'phone_number', $countryCode['id'] ?? null], 'message' => 'Email is already associated with another number.'],
        // ['method' => 'validateUser', 'args' => [$data, $clinicUserId, 'phone_number', 'email', $countryCode['id'] ?? null], 'message' => 'Phone number is already associated with another email.'],
        ['method' => 'validateUserWithCountyCode', 'args' => [$data, $clinicUserId, 'phone_number', 'email', $countryCode['id'] ?? null], 'message' => ($fieldType === 'email')  ? 'This email is already associated with another number.' : 'Phone number is already associated with another email.'],
        ['method' => 'validateUserByProfile', 'args' => [$data, 'clinic_users', $countryCode['id'] ?? null], 'message' => 'This account already exists. You can login to add new clinic.'],
        ['method' => 'validateUserByProfile', 'args' => [$data, 'patients', $countryCode['id'] ?? null], 'message' => 'This account already exists. You can login to add new clinic.'],
        ['method' => 'validateUserByEmailRegister', 'args' => [$data, $clinicUserId, 'clinic_users'], 'message' => 'This account already exists.'],
        ['method' => 'validateUserByEmailRegister', 'args' => [$data, $clinicUserId, 'patients'], 'message' => 'This account already exists. You can login to add new clinic.'],
        ['method' => 'validateUserByPhoneRegister', 'args' => [$data, $clinicUserId, 'clinic_users', $countryCode['id'] ?? null], 'message' => 'This account already exists in this clinic.'],
        ['method' => 'validateUserByPhoneRegister', 'args' => [$data, $clinicUserId, 'patients', $countryCode['id'] ?? null], 'message' => 'This account already exists. You can login to add new clinic.'],

      ];

      // Run validation checks
      foreach ($validationChecks as $check) {
        $result = User::{$check['method']}(...$check['args']);
        // echo $result.' '.$check['method'];
        if ($result > 0) {
          return ['error' => 1, 'message' => $check['message']];
        }
      }
    }

    return ['success' => 1];
  }

  function validateClincUserOnboarding()
  {
    $clinicDetails = $this->convertToArray(ClinicUser::select('onboarding_complete', 'last_onboarding_step')->whereIn('user_type_id', ['1', '2'])->where('clinic_user_uuid', session('user.clinicuser_uuid'))->where('onboarding_complete', 0)->first());

    if (empty($clinicDetails)) {
      return false;
    }
    $stepDetails = RefOnboardingStep::getOnboardingStepByID($clinicDetails['last_onboarding_step']);

    $responseArray['success'] = true;
    $responseArray['step'] = (empty($stepDetails)) ?  '' : $stepDetails['slug'];
    return $responseArray;
  }

  public function validateClinicUser($input, $countryID, $clinicUserDetails = array())
  {

    /** check email exist with in the same clinic */
    $emailExists = ClinicUser::getClinicUserByEmail($input, $clinicUserDetails);
    if (!empty($emailExists)) {
      return ['error' => 1, 'message' => 'User already exist with same email.'];
      // return $this->returnError('User already exist with same email.');

    }
    /** check phone number exist with in the same clinic */
    $phoneExists = ClinicUser::getClinicUserByPhone($input, $countryID, $clinicUserDetails);
    if (!empty($phoneExists)) {
      return ['error' => 1, 'message' => 'User already exist with same phone number.'];
      // return $this->returnError('User already exist with same phone number.');
    }

    /** check email exist with in the same clinic */
    $emailExists = Patient::getPatientByEmail($input);
    if (!empty($emailExists)) {
      return ['error' => 1, 'message' => 'The patient already exists with the same email in the clinic.'];
    }
    /** check phone number exist with in the same clinic */
    $phoneExists = Patient::getPatientByPhone($input, $countryID);
    if (!empty($phoneExists)) {
      return ['error' => 1, 'message' => 'The patient already exists with the same phone number in the clinic.'];
      // return $this->returnError('The patient already exists with the same phone number in the clinic.');

    }

    $clinicUserId = $clinicUserDetails->user_id ?? null;
    // Define validation checks
    $validationChecks = [
      ['method' => 'validateUser', 'args' => [$input, $clinicUserId, 'email', 'phone_number'], 'message' => 'Email is already associated with another number.'],
      ['method' => 'validateUser', 'args' => [$input, $clinicUserId, 'phone_number', 'email'], 'message' => 'Phone number is already associated with another email.'],

    ];

    // Run validation checks
    foreach ($validationChecks as $check) {

      if (User::{$check['method']}(...$check['args']) > 0) {
        // return $this->returnError($check['message']);
        return ['error' => 1, 'message' => $check['message']];
      }
    }
  }
  // Code Fix Required | Change this to private function  - Done
  public function insertToOtps($phoneNumber, $countryCode = array())
  {

    /* Deactivate previous otp generated for this phone number */
    Otp::updateOtp($phoneNumber, 'phone_number');

    // Generating unique UUID ,randon otpn & expiry time (3 minutes from now)
    $otpUuid = $this->generateUniqueKey("10", "otps", "otp_uuid");
    $userotp = rand(1000, 9999);
    Otp::insertOtp($phoneNumber, $countryCode, $otpUuid, $userotp);  // Insert OTP details into the 'otps' table
    /* return response */
    $responseArray['userotp'] = $userotp;
    $responseArray['otpUuid'] = $otpUuid;
    return $responseArray;
  }

  function formatPhone($phone)
  {
    if ($phone == '') {
      return;
    }
    $phoneNumber =  $phone;
    $areaCode = substr($phoneNumber, 0, 3);
    $prefix = substr($phoneNumber, 3, 3);
    $lineNumber = substr($phoneNumber, 6);

    $phone = '(' . $areaCode . ') ' . $prefix . '-' . $lineNumber;
    return $phone;
  }


  function appointmentMedicalHistory($userId)
  {


    $vitalTypes = [
      'bp_tracker' => ['table' => 'bp_tracker', 'title' => 'Blood Pressure', 'fields' => ['systolic'], 'unit' => 'mmHg', 'type' => 'blood_pressure'],
      // 'heart_rate' => ['table' => 'bp_tracker', 'title' => 'Heart Rate', 'fields' => ['pulse'], 'unit' => 'BPM', 'type' => 'heart_rate'],
      'glucose_tracker' => ['table' => 'glucose_tracker', 'title' => 'Blood Glucose', 'fields' => ['bgvalue'], 'unit' => 'mg/dl', 'type' => 'blood_glucose'],
      'cholestrol_tracker' => ['table' => 'cholestrol_tracker', 'title' => 'Cholesterol', 'fields' => ['cltotal'], 'unit' => 'mg/dl', 'type' => 'cholesterol'],
      // 'hba1c' => ['table' => 'glucose_tracker', 'title' => 'HbA1C', 'fields' => ['a1c'], 'unit' => '%', 'type' => 'hba1c'],
      'height' => ['table' => 'height_tracker', 'title' => 'Height', 'fields' => ['height'], 'unit' => 'cm', 'type' => 'height'],
      'weight' => ['table' => 'weight_tracker', 'title' => 'Weight', 'fields' => ['weight'], 'unit' => 'kg', 'type' => 'weight'],
      'bmi' => ['table' => 'weight_tracker', 'title' => 'BMI', 'fields' => ['bmi'], 'unit' => 'kg/m²', 'type' => 'bmi'],
      'oxygen_levels' => ['table' => 'oxygen_saturations', 'title' => 'Oxygen Levels', 'fields' => ['saturation'], 'unit' => '%', 'type' => 'oxygen_levels'],
      'body_temperature' => ['table' => 'body_temperature', 'title' => 'Temperature', 'fields' => ['celsius'], 'unit' => 'C', 'type' => 'temperature'],
    ];

    $vitals = [];



    foreach ($vitalTypes as $key => $config) {
      $record = DB::table($config['table'])->where('user_id', $userId)
        ->where(function ($q) use ($config) {
          foreach ($config['fields'] as $field) {
            $q->orWhereNotNull($field);
          }
        })
        ->orderBy('created_at', 'desc')
        ->first();

      foreach ($config['fields'] as $field) {

        if ($record && isset($record->$field)) {
          // Unit conversion
          if ($config['table'] == 'weight_tracker' && strtolower($record->unit ?? '') === 'lbs') {
            $record->$field = round($record->weight * 0.453592, 2);
          }
          if ($config['table'] == 'height_tracker' && strtolower($record->unit ?? '') === 'inches') {
            $record->$field = round($record->height * 2.54, 2);
          }
          if ($config['table'] == 'height_tracker' && strtolower($record->unit ?? '') === 'ft') {

            $ftFrom = $record->height;
            $inchesFrom = round($ftFrom * 12, 2);
            $cmFrom = round($inchesFrom * 2.54, 2);
            $record->$field = $cmFrom;
          }
        }
        if ($key == 'cholestrol_tracker') {
          $vitals[] = [
            'id' => $record->id ?? null,
            'title' => $config['title'],
            'value' => $record->$field ?? null,
            'value1' =>  $record->HDL ?? null,
            'value2' =>  $record->LDL ?? null,
            'unit' => $config['unit'],
            'type' => $config['type'],
            'date' => isset($record->created_at) ? date('j/n/Y', strtotime($record->created_at)) : null,
          ];
        } else {
          $value1 = ($key == 'glucose_tracker' && isset($record->a1c)) ? $record->a1c  : (isset($record->diastolic) ? $record->diastolic : '');
          $vitals[] = [
            'id' => $record->id ?? null,
            'title' => $config['title'],
            'value' => $record->$field ?? null,
            'value1' => $value1,
            'value2' =>  $record->pulse ?? null,
            'unit' => $config['unit'],
            'type' => $config['type'],
            'date' => isset($record->created_at) ? date('j/n/Y', strtotime($record->created_at)) : null,
          ];
        }
      }
    }


    return $vitals;
  }


  function getHistoryDetails($formType, $userID, $table, $startDate = null, $endDate = null)
  {

    $query = DB::table($table)->where('user_id', $userID)->whereNull('deleted_at');
    // Apply date range filter if both start and end dates are provided
    if ($formType == 'medical_conditions') {
      $query->where('relation_id', '=', '19');
    }
    if ($formType == 'family_history') {
      $query->where('relation_id', '!=', '19');
    }
    if (!empty($startDate) && !empty($endDate)) {
      $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    $data = $query->orderBy('id', 'desc')->get();

    $data = $this->convertToArray($data);
    return $data;
  }


  function validateClincOnboarding()
  {
    $clinicDetails = $this->convertToArray(Clinic::select('onboarding_complete', 'last_onboarding_step')->where('id', session('user.clinicID'))->where('onboarding_complete', '0')->whereNull('deleted_at')->first());

    if (empty($clinicDetails)) {
      return false;
    }

    $stepDetails = RefOnboardingStep::getOnboardingStepByID($clinicDetails['last_onboarding_step']);

    $responseArray['success'] = true;
    $responseArray['step'] = (empty($stepDetails)) ?  'business-details' : $stepDetails['slug'];
    return $responseArray;
  }
  function instantPayment($paymentIntentId, $stripeUserId, $patientDetails, $input, $appointment)
  {

    $this->stripePayment = new \App\customclasses\StripePayment;
    $appoinmentDate = $this->timezoneChange($appointment->appointment_date, "M d, Y") . ' | ' . $this->timezoneChange($appointment->appointment_time, 'h:i A');
    $clinic = Clinic::select('stripe_connection_id', 'name', 'phone_number', 'address as billing_address', 'state as billing_state', 'city as billing_city', 'zip_code as billing_zip', 'country_id as billing_country_id', 'state_id', 'country_code', 'logo')->whereNull('deleted_at')->where('id', $appointment->clinic_id)->first();
    try {
      if ($paymentIntentId != '') {

        $paymentIntentId = $this->stripePayment->retrievePaymentIntent($paymentIntentId, $stripeUserId);
        $intentDetails = json_decode(json_encode($paymentIntentId), true);

        $paymentMethodResponse = $this->stripePayment->retrievePaymentMethod($intentDetails['response']['payment_method'], $stripeUserId);
        $paymentMethodResponse = json_decode(json_encode($paymentMethodResponse['response']), true);

        if (!empty($intentDetails) && $intentDetails['success'] == 1) {
          if ($intentDetails['response']['status'] == 'requires_action') {
            return response()->json([
              'status' => 1,
              'action_url' => $intentDetails['response']['next_action']['redirect_to_url']['url'],
              'return_url' => url('stripe/webhooks/3dsecureauthentication'),
            ]);
          }
        }

        /** insert payment section */
        $cardDetails = !empty($paymentMethodResponse['card']) ? $paymentMethodResponse['card'] : array();

        // insert card details
        $card_uuid = $this->generateUniqueKey("10", "patient_cards", "patient_card_uuid");
        $cardObject = new PatientCard();
        $cardObject->patient_card_uuid = $card_uuid;
        $cardObject->exp_month = $cardDetails['exp_month'];
        $cardObject->exp_year = $cardDetails['exp_year'];
        $cardObject->name_on_card = isset($cardDetails['name_on_card']) ? $cardDetails['name_on_card'] : $patientDetails['first_name'] . ' ' . $patientDetails['last_name'];
        $cardObject->card_num = $cardDetails['last4'];
        $cardObject->card_type = $cardDetails['brand'];
        $cardObject->user_id = session()->get('user.userID');
        $cardObject->status = '1';
        $cardObject->save();
        $cardID = $cardObject->id;
      } else {

        $defaultCard = PatientCard::getDefaultUserCard($patientDetails['user_id']);
        $userDetails = $this->convertToArray(User::userByID($patientDetails['user_id']));
        $paymentcardId = (!empty($input) && isset($input['selected_card'])) ? $input['selected_card'] : $defaultCard['patient_card_uuid'];
        $cardDetails = payment::patientCardById($paymentcardId);

        if (empty($cardDetails)) {
          return response()->json([
            'status' => 0,
            'message' => 'Card is not valid',
          ]);
        }
        $cardID = $cardDetails['id'];
        if ($appointment->appointment_fee > '5') {

          $transferAmount = ($appointment->appointment_fee * (2.9 / 100)) + 0.3;
          $appoinmentData = array(
            'amount' => (int) (((string) ($appointment->appointment_fee * 100))), // convert doller to cent,
            'transferAmount' => (int) (((string) (env('APPLICATION_FEE') * 100))),
            'paymentMethodId' => $cardDetails['stripe_card_id'],
            'stripe_customer_id' => $userDetails['stripe_customer_id'],
            'descriptionApplicationFee' => 'Appointment fee  - ' . $patientDetails['first_name'] . ' ' . $patientDetails['last_name'] . ' | ' . $appoinmentDate,
            'description' => 'Payment for appointment dev : ' . $clinic->name . '/' . $appointment->appointment_fee . '/' . $appoinmentDate,
            'metaData' => array(
              'Name' => $patientDetails['first_name'] . ' ' . $patientDetails['last_name'],
              "Address" => $patientDetails['address'],
              "City" => $patientDetails['city'],
              "postal_code" => $patientDetails['zip'],
              "state" => $patientDetails['state'],
            ),
            "name" => $patientDetails['first_name'] . ' ' . $patientDetails['last_name'],
            "email" => $patientDetails['email'],
            "stripe_user_id" => $stripeUserId,
          );

          $clientSecretResponse = $this->stripePayment->setupPaymentIntentOnbehalf($appoinmentData);

          if (!empty($clientSecretResponse) && $clientSecretResponse['status'] == 1) {

            $clientSecret = $clientSecretResponse['response'];
            if ($userDetails['stripe_customer_id'] == '') {
              User::where('id', $userDetails['id'])->update(array(
                'stripe_customer_id' => $clientSecretResponse['customerID'],
              ));
            }
            $payment_intent_id = $clientSecretResponse['payment_intent_id'];
            $paymentstatus = $clientSecretResponse['paymentstatus'];
          } else {

            return ['status' => 0, 'message' => $clientSecretResponse['message']];
          }
          $userId = $patientDetails['user_id'];
        } else {
          if ($appointment->appointment_fee <= '5' && $appointment->appointment_fee > '0') {
            $appoinmentData = array(
              'amount' => (int) (((string) ($appointment->appointment_fee * 100))), // convert doller to cent,
              'paymentMethodId' => $cardDetails['stripe_card_id'],
              'stripe_customer_id' => $userDetails['stripe_customer_id'],
              'description' => 'Payment for appointment dev : ' . $clinic->name . '/' . $appointment->appointment_fee . '/' . $appoinmentDate,
              'metaData' => array(
                'Name' => $patientDetails['first_name'] . ' ' . $patientDetails['last_name'],
                "Address" => $patientDetails['address'],
                "City" => $patientDetails['city'],
                "postal_code" => $patientDetails['zip'],
                "state" => $patientDetails['state'],
              ),
              "name" => $patientDetails['first_name'] . ' ' . $patientDetails['last_name'],
              "email" => $patientDetails['email'],
              "stripe_user_id" => $stripeUserId,
            );

            $clientSecretResponse = $this->stripePayment->setupPaymentIntent($appoinmentData);

            if (!empty($clientSecretResponse) && $clientSecretResponse['status'] == 1) {
              $clientSecret = $clientSecretResponse['response'];
              if ($userDetails['stripe_customer_id'] == '') {
                User::where('id', $userDetails['id'])->update(array(
                  'stripe_customer_id' => $clientSecretResponse['customerID'],
                ));
              }
              $payment_intent_id = $clientSecretResponse['payment_intent_id'];
              $paymentstatus = $clientSecretResponse['paymentstatus'];
            } else {
              return ['status' => 0, 'message' => $clientSecretResponse['message']];
            }
          }
          $input['uuid'] = $appointment->appointment_uuid;
          $this->submitPayment($appointment->clinic_id, '5', $input);
          $userId = session()->get('user.userID');
        }
      }
      /** insert to transaction table */
      $transactionId = Payment::insertTransactions(json_encode($paymentIntentId), $userId, $appointment->clinic_id);

      $stripe_fee = ($appointment->appointment_fee * (2.9 / 100)) + 0.3;
      $platform_fee = env('APPLICATION_FEE');

      $stateID = (isset($patientDetails['user']['state_id']) && $patientDetails['user']['state_id'] != '') ? $patientDetails['user']['state_id'] : $patientDetails['state_id'];
      $state = $this->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id', $stateID)->whereNull('deleted_at')->first());
      $patientDetails['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] : ((isset($patientDetails['user']['state']) && $patientDetails['user']['state'] != '') ? $patientDetails['user']['state'] : $patientDetails['state_id']);

      // inputParams
      $inputParams = array();
      /** Input datea for store to payment table */
      $inputParams['billing_name'] = $patientDetails['first_name'] . ' ' . $patientDetails['last_name'];
      $inputParams['billing_email'] = $patientDetails['email'];
      $inputParams['country_id'] = $patientDetails['country_code'];
      $inputParams['phone_number'] = $patientDetails['phone_number'];
      $inputParams['address'] = (isset($patientDetails['user']['address']) && $patientDetails['user']['address'] != '') ? $patientDetails['user']['address'] : $patientDetails['address'];
      $inputParams['city'] =  (isset($patientDetails['user']['city']) && $patientDetails['user']['city'] != '') ? $patientDetails['user']['city'] : $patientDetails['city'];
      $inputParams['zip'] =  (isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code'] != '') ? $patientDetails['user']['zip_code'] : $patientDetails['zip'];
      $inputParams['state'] = $patientDetails['state'];
      $inputParams['name_on_card'] = $patientDetails['first_name'] . ' ' . $patientDetails['last_name'];
      $inputParams['card_number'] = $cardDetails['card_num'];
      $inputParams['card_type'] = $cardDetails['card_type'];
      $inputParams['expiry_year'] = $cardDetails['exp_year'];
      $inputParams['expiry_month'] = $cardDetails['exp_month'];
      $inputParams['stripe_fee'] = $stripe_fee;
      $inputParams['platform_fee'] = $platform_fee;

      $paymentDetails['stripe_customerid'] = $patientDetails['user']['stripe_customer_id'];
      $paymentDetails['stripe_paymentid'] = isset($clientSecretResponse['payment_intent_id']) ? $clientSecretResponse['payment_intent_id'] : null;
      $paymentDetails['card_id'] = $cardID;
      $paymentDetails['amount'] = $appointment->appointment_fee;
      $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

      $inputParams['appntID'] = $appointment->id;

      $paymentKey = $this->generateUniqueKey('10', 'payments', 'payment_uuid');

      $paymentIds = Payment::savePaymentData($inputParams, $paymentKey, $userId, $paymentDetails, '1', $clinic);

      return ['paymentIds' => $paymentIds, 'cardDetails' => $cardDetails];
    } catch (\Exception $e) {
      return ['status' => 0, 'message' => $e->getMessage()];
    }
  }
  function subscriptionPayment($stripeUserId, $patientDetails, $input, $amount, $clinicId, $subscriptionId, $balance = '', $type = '')
  {
    try {
      $this->stripePayment = new \App\customclasses\StripePayment;

      $defaultCard = PatientCard::getDefaultUserCard($patientDetails['user_id']);
      $paymentcardId = (!empty($input) && isset($input['selected_card'])) ? $input['selected_card'] : $defaultCard['patient_card_uuid'];
      $cardDetails = payment::patientCardById($paymentcardId);
      if (empty($cardDetails)) {
        return response()->json([
          'status' => 0,
          'message' => 'card is not valid',
        ]);
      }
      $userDetails = $this->convertToArray(User::userByID($patientDetails['user_id']));
      $cardID = $cardDetails['id'];
      $appoinmentData = array(
        'amount' => (int) (((string) ($amount * 100))), // convert doller to cent,
        'paymentMethodId' => $cardDetails['stripe_card_id'],
        'stripe_customer_id' => $userDetails['stripe_customer_id'],
        'description' => 'Payment for subscription',
        'metaData' => array(
          'Name' => $patientDetails['first_name'] . ' ' . $patientDetails['last_name'],
          "Address" => $patientDetails['address'],
          "City" => $patientDetails['city'],
          "postal_code" => $patientDetails['zip'],
          "state" => $patientDetails['state'],
        ),
        "name" => $patientDetails['first_name'] . ' ' . $patientDetails['last_name'],
        "email" => $patientDetails['email'],
      );

      $clientSecretResponse = $this->stripePayment->setupPaymentIntentNew($appoinmentData);

      if (!empty($clientSecretResponse) && $clientSecretResponse['status'] == 1) {
        $clientSecret = $clientSecretResponse['response'];
        if ($userDetails['stripe_customer_id'] == '') {
          User::where('id', $userDetails['id'])->update(array(
            'stripe_customer_id' => $clientSecretResponse['customerID'],
          ));
        }
        $paymentIntentId = $clientSecretResponse['payment_intent_id'];
        $paymentstatus = $clientSecretResponse['paymentstatus'];
      } else {
        return response()->json([
          'status' => 0,
          'message' => $clientSecretResponse['message'],
        ]);
      }
      /** insert to transaction table */
      $transactionId = Payment::insertTransactions(json_encode($paymentIntentId), $patientDetails['user_id'], $clinicId);

      $stripe_fee = ($amount * (2.9 / 100)) + 0.3;
      $platform_fee = 0.00;

      $stateID = (isset($patientDetails['user']['state_id']) && $patientDetails['user']['state_id'] != '') ? $patientDetails['user']['state_id'] : $patientDetails['state_id'];
      $state = $this->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id', $stateID)->whereNull('deleted_at')->first());
      $patientDetails['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] : ((isset($patientDetails['user']['state']) && $patientDetails['user']['state'] != '') ? $patientDetails['user']['state'] : $patientDetails['state_id']);
      $clinic = Clinic::select('stripe_connection_id', 'name', 'phone_number', 'address as billing_address', 'state as billing_state', 'city as billing_city', 'zip_code as billing_zip', 'country_id as billing_country_id', 'state_id', 'country_code', 'logo')->whereNull('deleted_at')->where('id', $clinicId)->first();

      // inputParams
      $inputParams = array();
      /** Input data for store to payment table */
      $inputParams['billing_name'] = $patientDetails['first_name'] . ' ' . $patientDetails['last_name'];
      $inputParams['billing_email'] = $patientDetails['email'];
      $inputParams['country_id'] = $patientDetails['country_code'];
      $inputParams['phone_number'] = $patientDetails['phone_number'];
      $inputParams['address'] = (isset($patientDetails['user']['address']) && $patientDetails['user']['address'] != '') ? $patientDetails['user']['address'] : $patientDetails['address'];
      $inputParams['city'] =  (isset($patientDetails['user']['city']) && $patientDetails['user']['city'] != '') ? $patientDetails['user']['city'] : $patientDetails['city'];
      $inputParams['zip'] =  (isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code'] != '') ? $patientDetails['user']['zip_code'] : $patientDetails['zip'];
      $inputParams['state'] = $patientDetails['state'];
      $inputParams['name_on_card'] = $patientDetails['first_name'] . ' ' . $patientDetails['last_name'];
      $inputParams['card_number'] = $cardDetails['card_num'];
      $inputParams['card_type'] = $cardDetails['card_type'];
      $inputParams['expiry_year'] = $cardDetails['exp_year'];
      $inputParams['expiry_month'] = $cardDetails['exp_month'];
      $inputParams['stripe_fee'] = $stripe_fee;
      $inputParams['platform_fee'] = $platform_fee;

      $paymentDetails['stripe_customerid'] = $userDetails['stripe_customer_id'];
      $paymentDetails['stripe_paymentid'] = isset($clientSecretResponse['payment_intent_id']) ? $clientSecretResponse['payment_intent_id'] : null;
      $paymentDetails['card_id'] = $cardID;
      $paymentDetails['amount'] = $amount;
      $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

      $inputParams['appntID'] = $subscriptionId;

      $paymentKey = $this->generateUniqueKey('10', 'payments', 'payment_uuid');
      $type = (isset($type) && $type != '') ? $type : 'subscription';
      $paymentIds = Payment::savePaymentData($inputParams, $paymentKey, $patientDetails['user_id'], $paymentDetails, '1', $clinic, $type, $balance);

      return ['paymentIds' => $paymentIds, 'cardDetails' => $cardDetails];
    } catch (\Exception $e) {
      return ['status' => 0, 'message' => $e->getMessage()];
    }
  }
  function calculateAddOnAmount($clinicusers, $clinicId, $isProrated)
  {
    $clinicDetails = $this->convertToArray(Clinic::clinicByID($clinicId));
    $addOnDetails = $this->convertToArray(DB::table('addons')->where('id', '1')->first());
    $isEprescribeEnabled = Clinic::checkEprescribeEnabled($clinicId);

    $userCount = !empty($clinicusers) ? count($clinicusers) : 0;
    if ($isProrated == '1') {
      $startDate = date('Y-m-d');
      $endDate = date('Y-m-t');
      $totalDaysInMonth = date('t');
      $remainingDays = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1;
      $dailyRate = $addOnDetails['amount'] / $totalDaysInMonth;
      $proRatedAmountPerUser = $dailyRate * $remainingDays;
    } else {
      $proRatedAmountPerUser = $addOnDetails['amount'];
    }

    if ($isEprescribeEnabled == '0') {
      $addOnAmount = empty($clinicusers) ? $addOnDetails['one_time_setup_amount'] : $addOnDetails['one_time_setup_amount'] + ($proRatedAmountPerUser * $userCount);
    } else {
      $addOnAmount = $proRatedAmountPerUser * $userCount;
    }

    return number_format($addOnAmount, 2, '.', '');
  }
  function getAddOnAmount()
  {
    $addOnDetails = $this->convertToArray(DB::table('addons')->where('id', '1')->first());
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-t');
    $totalDaysInMonth = date('t');
    $remainingDays = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1;
    $dailyRate = $addOnDetails['amount'] / $totalDaysInMonth;
    $proRatedAmountPerUser = $dailyRate * $remainingDays;

    return round($proRatedAmountPerUser, 4);
  }
  function submitPayment($clinicId, $amount, $input = array())
  {
    try {
      $this->stripePayment = new \App\customclasses\StripePayment;
      $clinicDetails = $this->convertToArray(Clinic::clinicByID($clinicId));
      $defaultCard = ClinicCard::getDefaultUserCard($clinicId);
      $paymentcardId = isset($input['selected_card']) ? $input['selected_card'] : $defaultCard['clinic_card_uuid'];
      $cardDetails = Payment::clinicCardById($paymentcardId);
      $billingCheck = UserBilling::getBillingInfo($clinicId);

      $state = (isset($billingCheck['billing_state_id']) && $billingCheck['billing_state_id'] != '') ? $this->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id', $billingCheck['billing_state_id'])->whereNull('deleted_at')->first()) : array();
      $billingCheck['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] : $billingCheck['billing_state_other'];
      if (!empty($input) && isset($input['uuid']) && $input['uuid'] != '') {
        $appointment = Appointment::appointmentByKey($input['uuid']);
        $appoinmentDate = $this->timezoneChange($appointment->appointment_date, "M d, Y") . ' | ' . $this->timezoneChange($appointment->appointment_time, 'h:i A');
        $description = 'Payment for appointment dev : ' . $clinicDetails['name'] . '/' . $appointment->appointment_fee . '/' . $appoinmentDate;
      } else {
        $description =  $clinicDetails['name'] . '/ ePrescribe Charges';
      }

      if (empty($cardDetails)) {
        return response()->json([
          'status' => 0,
          'message' => 'card is not valid',
        ]);
      }

      $cardID = $cardDetails['id'];
      $appoinmentData = array(
        'amount' => (int) (((string) ($amount * 100))), // convert doller to cent,
        'paymentMethodId' => $cardDetails['stripe_card_id'],
        'stripe_customer_id' => $clinicDetails['stripe_customer_id'],
        'description' => $description,
        'metaData' => array(
          'Name' => (isset($billingCheck['billing_company_name']) && $billingCheck['billing_company_name'] != '') ? $billingCheck['billing_company_name'] : $clinicDetails['name'],
          "Address" => (isset($billingCheck['billing_address']) && $billingCheck['billing_address'] != '') ? $billingCheck['billing_address'] : $clinicDetails['address'],
          "City" => (isset($billingCheck['billing_city']) && $billingCheck['billing_city'] != '') ? $billingCheck['billing_city'] : $clinicDetails['city'],
          "postal_code" => (isset($billingCheck['billing_zip']) && $billingCheck['billing_zip'] != '') ? $billingCheck['billing_zip'] : $clinicDetails['zip_code'],
          "state" => (isset($billingCheck['state']) && $billingCheck['state'] != '') ? $billingCheck['state'] : $clinicDetails['state'],
        ),
        "name" => $clinicDetails['name'],
        "email" => $clinicDetails['email'],
      );

      $clientSecretResponse = $this->stripePayment->setupPaymentIntentNew($appoinmentData);

      if (!empty($clientSecretResponse) && $clientSecretResponse['status'] == 1) {
        $clientSecret = $clientSecretResponse['response'];
        $paymentIntentId = $clientSecretResponse['payment_intent_id'];
        $paymentstatus = $clientSecretResponse['paymentstatus'];
      } else {
        return ['status' => 0, 'message' => $clientSecretResponse['message']];
      }
      /** insert to transaction table */
      $transactionId = Payment::insertTransactions(json_encode($paymentIntentId), $clinicDetails['id'], $clinicId);

      $stripe_fee = ($amount * (2.9 / 100)) + 0.3;
      $platform_fee = 0;

      $stateID = (isset($clinicDetails['state_id']) && $clinicDetails['state_id'] != '') ? $clinicDetails['state_id'] : '';
      $state = $this->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id', $stateID)->whereNull('deleted_at')->first());
      $clinicDetails['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] : $clinicDetails['state'];

      /** Input datea for store to payment table */
      $inputParams = array();
      $inputParams['billing_name'] = $clinicDetails['name'];
      $inputParams['billing_email'] = $clinicDetails['email'];
      $inputParams['country_id'] = $clinicDetails['country_code'];
      $inputParams['phone_number'] = $clinicDetails['phone_number'];
      $inputParams['address'] = (isset($clinicDetails['address']) && $clinicDetails['address'] != '') ? $clinicDetails['address'] : '';
      $inputParams['city'] =  (isset($clinicDetails['city']) && $clinicDetails['city'] != '') ? $clinicDetails['city'] : '';
      $inputParams['zip'] =  (isset($clinicDetails['zip_code']) && $clinicDetails['zip_code'] != '') ? $clinicDetails['zip_code'] : '';
      $inputParams['state'] = $clinicDetails['state'];
      $inputParams['name_on_card'] = $cardDetails['name_on_card'];
      $inputParams['card_number'] = $cardDetails['card_number'];
      $inputParams['card_type'] = $cardDetails['card_type'];
      $inputParams['expiry_year'] = $cardDetails['exp_year'];
      $inputParams['expiry_month'] = $cardDetails['exp_month'];
      $inputParams['stripe_fee'] = $stripe_fee;
      $inputParams['platform_fee'] = $platform_fee;

      $paymentDetails['stripe_customerid'] = $clinicDetails['stripe_customer_id'];
      $paymentDetails['stripe_paymentid'] = isset($clientSecretResponse['payment_intent_id']) ? $clientSecretResponse['payment_intent_id'] : null;
      $paymentDetails['card_id'] = $cardID;
      $paymentDetails['amount'] = $amount;
      $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

      $inputParams['appntID'] =  $clinicDetails['id'];

      $paymentKey = $this->generateUniqueKey('10', 'payments', 'payment_uuid');
      $paymentIds = Payment::savePaymentData($inputParams, $paymentKey, session()->get('user.userID'), $paymentDetails, '1', $clinicDetails, 'ePrescribe');

      return ['paymentIds' => $paymentIds, 'cardDetails' => $cardDetails];
    } catch (\Exception $e) {
      return ['status' => 0, 'message' => $e->getMessage()];
    }
  }
  function addSmartMeterAPI($url, $params, $token)
  {
    $apiKey     =   env('SMARTMETER_API_KEY');
    //   $apiKey     =   '0724597736f05548143044408005db702e421e53f4c190aec2418e13d63bcb41';
    $apiUrl     =   env('SMARTMETER_API_URL') . $url;
    // $apiUrl     =   "https://dev.api.smartmeterrpm.com/api/" . $url;

    $headers = [
      'Content-Type: application/json',
      'Accept: application/json',
      'X-API-KEY: ' . $apiKey,
      'Authorization: Bearer ' . $token
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);

    return $result;
  }
  function createSmartmeterBearerToken($url)
  {
    $token = '';
    $apiKey     =     env('SMARTMETER_API_KEY');
    $url        =     env('SMARTMETER_API_URL') . $url;

    $headers = [
      'Content-Type: application/json', // THIS WAS MISSING
      'Accept: application/json',
      'X-API-KEY: ' . $apiKey,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($http_code == 200 && !empty($response) && isset($response['data']) && isset($response['data']['jwt'])) {
      $token = $response['data']['jwt'];
    }
    return $token;
  }

  function getAvailableTimeSlots($date, $userId, $type = '', $editTime = '')
  {
    $userTimeZone = session('user.timezone');
    $clinicUser = DB::table('clinic_users')
      ->leftJoin('ref_consultation_times', 'clinic_users.consultation_time_id', '=', 'ref_consultation_times.id')
      ->where('clinic_users.user_id', $userId)
      ->select(
        'clinic_users.consultation_time_id',
        'clinic_users.consultation_time as custom_time',
        'ref_consultation_times.consultation_time as default_time'
      )
      ->first();

    $slotMinutes = ($clinicUser->consultation_time_id == 7) ? $clinicUser->custom_time : $clinicUser->default_time;
    $slotMinutes = (int) filter_var($slotMinutes, FILTER_SANITIZE_NUMBER_INT);

    // Step 2: Get Business Hours for the Day
    $dayOfWeek = ucfirst(strtolower(Carbon::parse($date)->format('l')));

    $businessHours = DB::table('bussiness_hours')->where('user_id', $userId)->whereNull('deleted_at')
      ->where('day', $dayOfWeek)
      ->where('isopen', '1')
      ->first();

    if (!$businessHours) {
      return []; // No working hours on this day
    }
    // print'<pre>';
    // print_r($clinicUser);  print_r($businessHours);
    $timeRange = DB::table('bussinesshours_times')->where('bussiness_hour_id', $businessHours->id)->whereNull('deleted_at')->get();


    $morningSlots = $afternoonSlots = array();

    foreach ($timeRange as $range) {

      $from = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $range->timezone_from_utc, 'UTC');
      $istDateTime = $from->copy()->setTimezone('Asia/Kolkata');
      print '<pre>';
      print_r($istDateTime);
      exit;
      $to = Carbon::createFromFormat('H:i:s', $range->timezone_to_utc);

      while ($from->copy()->addMinutes($slotMinutes)->lte($to)) {
        // Convert slot start to user timezone for display
        $slotStartUserTZ = $from->copy()->setTimezone($userTimeZone);
        $slotEndUserTZ = $from->copy()->addMinutes($slotMinutes)->setTimezone($userTimeZone);

        $start = $slotStartUserTZ->format('h:i A'); // What user sees
        $end = $slotEndUserTZ->format('h:i A');

        // UTC time for DB comparison
        $userDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $slotStartUserTZ->format('H:i:s'), $userTimeZone);
        $utcTime = $userDateTime->copy()->setTimezone('UTC')->format('H:i:s');

        $isBooked = Appointment::where('consultant_id', $userId)
          ->where('appointment_date', $date)
          ->where('appointment_time', $utcTime)
          ->exists();

        $currentUserTime = Carbon::now($userTimeZone);
        $slotDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $slotStartUserTZ->format('H:i:s'), $userTimeZone);

        if (!$isBooked && $slotDateTime->gt($currentUserTime) && $slotStartUserTZ->toDateString() == $userSelectedDate) {
          $hour = (int)$slotStartUserTZ->format('H');
          if ($hour < 12) {
            $morningSlots[] = $start;
          } else {
            $afternoonSlots[] = $start;
          }
        }

        $from->addMinutes($slotMinutes); // Still in UTC
      }
    }

    // Handle Edit Mode: Include the editTime in the list
    if ($type == 'edit' && $editTime) {

      // Convert editTime from UTC to user's timezone
      $editDateTimeUTC = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $editTime, 'UTC');
      $editDateTimeUser = $editDateTimeUTC->copy()->setTimezone($userTimeZone);
      $formattedTime = $editDateTimeUser->format('h:i A');
      $hour = (int) $editDateTimeUser->format('H');

      // Add to appropriate array if not already included
      if ($hour < 12 && !in_array($formattedTime, $morningSlots)) {
        $morningSlots[] = $formattedTime;
      } elseif ($hour >= 12 && !in_array($formattedTime, $afternoonSlots)) {
        $afternoonSlots[] = $formattedTime;
      }
    }
    sort($morningSlots);
    sort($afternoonSlots);


    return [
      'morning' => $morningSlots,
      'afternoon' => $afternoonSlots,
    ];
  }
  function getSubscriptionDetails($clinicId, $patientDetails, $clinicSubscription, $monthlychecked)
  {
    $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionNew($clinicId, $patientDetails['id']);
    $amount = ($monthlychecked == '1') ? $clinicSubscription['monthly_amount'] : $clinicSubscription['annual_amount'];

    $isProrated = 0;
    $isUpgrade = 0;
    $isDowngrade = 0;
    $creditAmount = 0;
    $payableAmount = $amount;

    // No existing subscription, treat as new
    if (empty($patientSubscriptionDets)) {
      return [
        'amount' => round($payableAmount, 2),
        'is_prorated' => $isProrated,
        'upgrade' => 0,
        'downgrade' => 0,
      ];
    }

    // Determine if it's upgrade/downgrade
    $currentPlan = ClinicSubscription::find($patientSubscriptionDets['clinic_subscription_id']);
    if (!$currentPlan) {
      return [
        'amount' => round($payableAmount, 2),
        'is_prorated' => $isProrated,
        'upgrade' => 0,
        'downgrade' => 0,
      ];
    }

    if ($currentPlan->id == $clinicSubscription['id']) {
      // Same plan, check tenure type change
      if ($patientSubscriptionDets['tenure_type_id'] == '1' && $monthlychecked == '0') {
        $isUpgrade = 1;
      } elseif ($patientSubscriptionDets['tenure_type_id'] == '2' && $monthlychecked == '1') {
        $isDowngrade = 1;
      }
    } else {
      if ($currentPlan->sort_order < $clinicSubscription['sort_order']) {
        $isUpgrade = 1;
      } elseif ($currentPlan->sort_order > $clinicSubscription['sort_order']) {
        $isDowngrade = 1;
      }
    }

    // Check expiration
    $now = Carbon::now();
    $startDate = Carbon::parse($patientSubscriptionDets['start_date']);
    $endDate = Carbon::parse($patientSubscriptionDets['end_date']);
    $currentAmount = $patientSubscriptionDets['amount'];

    if ($now->greaterThanOrEqualTo($endDate)) {
      return [
        'amount' => round($payableAmount, 2),
        'is_prorated' => $isProrated,
        'upgrade' => $isUpgrade,
        'downgrade' => $isDowngrade,
      ];
    }

    // Proration logic
    $totalDays = $startDate->diffInDays($endDate);
    $remainingDays = $now->diffInDays($endDate);

    if ($totalDays === 0) {
      return [
        'amount' => round($payableAmount, 2),
        'is_prorated' => $isProrated,
        'upgrade' => $isUpgrade,
        'downgrade' => $isDowngrade,
      ];
    }

    $isProrated = 1;
    $creditAmount = ($currentAmount / $totalDays) * $remainingDays;
    $proratedAmount = $amount - $creditAmount;

    $payableAmount = max($proratedAmount, 0);

    return [
      'amount' => round($payableAmount, 2),
      'is_prorated' => $isProrated,
      'upgrade' => $isUpgrade,
      'downgrade' => $isDowngrade,
    ];
  }
  function deviceOrderPayment($stripeUserId, $patientDetails, $input, $amount, $clinicId, $parentId)
  {
    $this->stripePayment = new \App\customclasses\StripePayment;

    $defaultCard = PatientCard::getDefaultUserCard($patientDetails['user_id']);
    $paymentcardId = (!empty($input) && isset($input['selected_card'])) ? $input['selected_card'] : $defaultCard['patient_card_uuid'];

    $cardDetails = payment::patientCardById($paymentcardId);
    if (empty($cardDetails)) {
      return response()->json([
        'status' => 0,
        'message' => 'card is not valid',
      ]);
    }
    $userDetails = $this->convertToArray(User::userByID($patientDetails['user_id']));
    $cardID = $cardDetails['id'];

    $appoinmentData = array(
      'amount' => (int) (((string) ($amount * 100))), // convert doller to cent,
      'paymentMethodId' => $cardDetails['stripe_card_id'],
      'stripe_customer_id' => $userDetails['stripe_customer_id'],
      'description' => 'Payment for RPM device order',
      'metaData' => array(
        'Name' => $patientDetails['first_name'] . ' ' . $patientDetails['last_name'],
        "Address" => $patientDetails['address'],
        "City" => $patientDetails['city'],
        "postal_code" => $patientDetails['zip'],
        "state" => $patientDetails['state'],
      ),
      "name" => $patientDetails['first_name'] . ' ' . $patientDetails['last_name'],
      "email" => $patientDetails['email'],
    );

    $clientSecretResponse = $this->stripePayment->setupPaymentIntentNew($appoinmentData);

    if (!empty($clientSecretResponse) && $clientSecretResponse['status'] == 1) {
      $clientSecret = $clientSecretResponse['response'];
      if ($userDetails['stripe_customer_id'] == '') {
        User::where('id', $userDetails['id'])->update(array(
          'stripe_customer_id' => $clientSecretResponse['customerID'],
        ));
      }
      $paymentIntentId = $clientSecretResponse['payment_intent_id'];
      $paymentstatus = $clientSecretResponse['paymentstatus'];
    } else {
      return ['status' => 0, 'message' => $clientSecretResponse['message']];
    }
    /** insert to transaction table */
    $transactionId = Payment::insertTransactions(json_encode($paymentIntentId), $patientDetails['user_id'], $clinicId);

    $stripe_fee = ($amount * (2.9 / 100)) + 0.3;
    $platform_fee = 0.00;

    $stateID = (isset($patientDetails['user']['state_id']) && $patientDetails['user']['state_id'] != '') ? $patientDetails['user']['state_id'] : $patientDetails['state_id'];
    $state = $this->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id', $stateID)->whereNull('deleted_at')->first());
    $patientDetails['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] : ((isset($patientDetails['user']['state']) && $patientDetails['user']['state'] != '') ? $patientDetails['user']['state'] : $patientDetails['state_id']);
    $clinic = Clinic::select('stripe_connection_id', 'name', 'phone_number', 'address as billing_address', 'state as billing_state', 'city as billing_city', 'zip_code as billing_zip', 'country_id as billing_country_id', 'state_id', 'country_code', 'logo')->whereNull('deleted_at')->where('id', $clinicId)->first();

    // inputParams
    $inputParams = array();
    /** Input datea for store to payment table */
    $inputParams['billing_name'] = $patientDetails['first_name'] . ' ' . $patientDetails['last_name'];
    $inputParams['billing_email'] = $patientDetails['email'];
    $inputParams['country_id'] = $patientDetails['country_code'];
    $inputParams['phone_number'] = $patientDetails['phone_number'];
    $inputParams['address'] = (isset($patientDetails['user']['address']) && $patientDetails['user']['address'] != '') ? $patientDetails['user']['address'] : $patientDetails['address'];
    $inputParams['city'] =  (isset($patientDetails['user']['city']) && $patientDetails['user']['city'] != '') ? $patientDetails['user']['city'] : $patientDetails['city'];
    $inputParams['zip'] =  (isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code'] != '') ? $patientDetails['user']['zip_code'] : $patientDetails['zip'];
    $inputParams['state'] = $patientDetails['state'];
    $inputParams['name_on_card'] = $patientDetails['first_name'] . ' ' . $patientDetails['last_name'];
    $inputParams['card_number'] = $cardDetails['card_num'];
    $inputParams['card_type'] = $cardDetails['card_type'];
    $inputParams['expiry_year'] = $cardDetails['exp_year'];
    $inputParams['expiry_month'] = $cardDetails['exp_month'];
    $inputParams['stripe_fee'] = $stripe_fee;
    $inputParams['platform_fee'] = $platform_fee;

    $paymentDetails['stripe_customerid'] = $userDetails['stripe_customer_id'];
    $paymentDetails['stripe_paymentid'] = isset($clientSecretResponse['payment_intent_id']) ? $clientSecretResponse['payment_intent_id'] : null;
    $paymentDetails['card_id'] = $cardID;
    $paymentDetails['amount'] = $amount;
    $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

    $inputParams['appntID'] =  $parentId;

    $paymentKey = $this->generateUniqueKey('10', 'payments', 'payment_uuid');

    $paymentIds = Payment::savePaymentData($inputParams, $paymentKey, $patientDetails['user_id'], $paymentDetails, '1', $clinic, 'deviceorder');

    return ['paymentIds' => $paymentIds, 'cardDetails' => $cardDetails];
  }
  public function rpmDeviceStatusChangeMail($orderInfo, $devices, $status = 'accept')
  {
    $clinicUserDetails  = $this->convertToArray(ClinicUser::userByID($orderInfo['clinic_user_id']));
    $clinicUserDoctor   = Appointment::getClinicUserDoctor(Session::get('user.clinicID'), $clinicUserDetails['user_id']);
    $clinicianName      = $this->showClinicanName($clinicUserDoctor, '0');
    $userDets           = $this->convertToArray(User::userByID(session('user.userID')));

    $emailData = [
      'email'         => $userDets['email'],
      'clinicianName'   => $clinicianName,
      'statusText'      => ($status == 'accept') ? 'accepted' : 'rejected',
      'orderInfo'       => $orderInfo,
      'rpmDevices'      => $devices,
      'username'        => $userDets['first_name'] . ' ' . $userDets['last_name'],
    ];
    $subjectTxt = ($status == 'accept') ? 'Accepted' : 'Rejected';

    $this->sendmail($emailData, $subjectTxt . ' the device order.', 'emails.deviceorderstatuschange');

    /* Notification To Patients */
    $this->addNotifications(22, Session::get('user.clinicID'), $clinicUserDetails['user_id'], $orderInfo['id']);
  }

  function checkAppoinmentExpiry($appointment, $doctorDetails)
  {

    $appointmentDate = Carbon::parse($appointment->appointment_date);
    $appointmentStart = Carbon::parse($appointment->appointment_time);

    $consultingTimeMinutes = 0;
    if ($doctorDetails->consultation_time_id == 7) {
      $consultingTimeMinutes = (int) $doctorDetails->consultation_time;
    } else {
      $consultingTime = RefConsultationTime::find($doctorDetails->consultation_time_id);
      $consultingTimeMinutes = (int) filter_var($consultingTime->consultation_time, FILTER_SANITIZE_NUMBER_INT);
    }
    // print_r($consultingTimeMinutes);exit;
    // Step 4: Combine appointment_date and start_time
    $appointmentDateTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);

    $appointmentEnd = $appointmentDateTime->copy()->addMinutes((int)$consultingTimeMinutes);

    //Check if appointment date is today or past AND time is expired
    $isDatePastOrToday = $appointmentDate->isSameDay(Carbon::today()) || $appointmentDate->lessThan(Carbon::today());
    $isExpired = $isDatePastOrToday && now()->greaterThan($appointmentEnd);

    // print'<pre>';
    // print_r($isDatePastOrToday);   print_r('----');
    // print_r($appointmentEnd);   print_r('----');
    // print_r($isExpired);   print_r('----');
    // exit;

    return $isExpired;
  }


  function validatePatientLogin($userID, $patientID)
  {

    $userDetails = $this->convertToArray(User::select('id', 'user_uuid', 'phone_number')->where('id', $userID)->whereNull('deleted_at')->first());

    if (empty($userDetails)) {
      return false;
    }

    $patientsDetails = $this->convertToArray(Patient::where('patients.user_id', $userDetails["id"])->where('patients.status', '1')->where('id', $patientID)->whereNull('patients.deleted_at')->get());

    if (empty($patientsDetails)) {
      return false;
    }

    return true;
  }
  function createClinicDoseSpot($clinicDetails)
  {
    $token =  $this->generateDoseSpotToken();
    $address    = $this->getTrimmedAddress(trim($clinicDetails['address']));

    $stateName = (isset($clinicDetails['state'])) ? $clinicDetails['state'] : '';
    if (isset($clinicDetails['state_id'])) {
      $state = DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->where('id', $clinicDetails['state_id'])->first();
      $state = $this->convertToArray($state);
      if (!empty($state)) {
        $stateName = $state['state_name'];
      }
    }

    $apiUrl     = env('DOSESPOT_URL') . 'api/clinics';
    $params     = array();
    $params     = [
      "ClinicName"      => trim($clinicDetails['name']),
      "Address1"        => trim($address),
      "City"            => trim($clinicDetails['city']),
      "State"           => trim($stateName),
      "ZipCode"         => trim($clinicDetails['zip_code']),
      "PrimaryPhone"    => trim($clinicDetails['phone_number']),
      "PrimaryPhoneType"         => '5',


    ];

    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
      'Authorization: Bearer ' . $token
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);


    $isSuccess  = '0';
    if (!empty($result) && isset($result['ClinicId']) && isset($result['ClinicKey'])) {
      $isSuccess = '1';
      Clinic::updateDosepotKey($clinicDetails['id'], $result['ClinicId'], $result['ClinicKey']);
    }

    $errors = [];
    // Loop through ModelState to extract error messages
    if (isset($result['ModelState']) && is_array($result['ModelState'])) {
      foreach ($result['ModelState'] as $field => $messages) {
        foreach ($messages as $message) {
          $errors[] = $message;
        }
      }
    }

    if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
      $errors[]  = $result['Result']['ResultDescription'];
    }

    $finalArr = array();
    $finalArr['success'] = $isSuccess;
    $finalArr['errors']  = (!empty($errors)) ? implode(',', $errors) : '';
    return $finalArr;
  }
  function generateDoseSpotToken($userName = '', $tokenInfo = array())
  {
    $apiUrl     =   env('DOSESPOT_URL') . 'connect/token';
    $userName   =   ($userName != '') ? $userName : '3060939';

    $params     = array();
    $params     = [
      "grant_type"      => env('DOSESPOT_GRANTTYPE'),
      "Username"        => $userName,
      "Password"        => (!empty($tokenInfo) && isset($tokenInfo['Password']) && $tokenInfo['Password'] != '') ? $tokenInfo['Password'] : env('DOSESPOT_PWD'),
      "client_id"       => (!empty($tokenInfo) && isset($tokenInfo['client_id']) && $tokenInfo['client_id'] != '') ? $tokenInfo['client_id'] : env('DOSESPOT_CLIENTID'),
      "client_secret"   => (!empty($tokenInfo) && isset($tokenInfo['client_secret']) && $tokenInfo['client_secret'] != '') ? $tokenInfo['client_secret'] : env('DOSESPOT_SECRET'),
      "scope"           => env('DOSESPOT_SCOPE'),

    ];

    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);
    $token      = (!empty($result) && isset($result['access_token'])) ? $result['access_token'] : '';

    return $token;
  }
  function createClinicUserDoseSpot($clinicUserDets, $userDets, $additionalInfo = array())
  {

    $hasDoseSpotAdmin = '0';
    $doseSpotAdmin = ClinicUser::doseSpotAdminByClinicID($clinicUserDets['clinic_id']);
    $clinicDetails = $this->convertToArray(Clinic::selectedClinicByID($clinicUserDets['clinic_id']));

    $userName       = '';
    $tokenInfo      = array();
    if (!empty($doseSpotAdmin)) {
      $dosespotUserDets           = $this->convertToArray(User::userByID($doseSpotAdmin['user_id']));
      if (!empty($dosespotUserDets)) {
        $hasDoseSpotAdmin = '1';
        $tokenInfo['client_id']     = $clinicDetails['dosepot_id'];
        $tokenInfo['client_secret'] = $clinicDetails['dosepot_key'];
        $tokenInfo['Password']      = $clinicDetails['dosepot_key'];
        $userName                   = $dosespotUserDets['dosespot_clinician_id'];
      }
    } else {
      $tokenInfo['client_id']     = $clinicDetails['dosepot_id'];
      $tokenInfo['client_secret'] = $clinicDetails['dosepot_key'];
      $tokenInfo['Password']      = $clinicDetails['dosepot_key'];
    }

    $token      =  $this->generateDoseSpotToken($userName, $tokenInfo);
    $address    = $this->getTrimmedAddress(trim($userDets['address']));
    $ClinicianRoleType = (!empty($additionalInfo) && isset($additionalInfo['ClinicianRoleType']) && !empty($additionalInfo['ClinicianRoleType'])) ? $additionalInfo['ClinicianRoleType'] : array('1');
    $stateName = (isset($userDets['state'])) ? $userDets['state'] : '';
    if (isset($userDets['state_id'])) {
      $state = DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->where('id', $userDets['state_id'])->first();
      $state = $this->convertToArray($state);
      if (!empty($state)) {
        $stateName = $state['state_name'];
      }
    }
    $createClinician        = '1';
    $dosespotClinicianId    = '';
    if ($userDets['dosespot_clinician_id'] != '') {
      $createClinician      = '0';
      $dosespotClinicianId = $userDets['dosespot_clinician_id'];
    }
    $isSuccess  = '0';
    $errors = [];
    $result = array();



    if ($createClinician == '1') {
      $apiUrl     = env('DOSESPOT_URL') . 'api/clinicians';
      $params     = array();
      $doseSpotSpecialityID = $this->getDosespotSpecialities($clinicUserDets['specialty_id']);


      $params     = [
        "FirstName"                 => trim($userDets['first_name']),
        "LastName"                  => trim($userDets['last_name']),
        "DateOfBirth"               => trim($userDets['dob']),
        "Email"                     => trim($userDets['email']),
        "Address1"                  => trim($address),
        "City"                      => trim($userDets['city']),
        "State"                     => trim($stateName),
        "ZipCode"                   => trim($userDets['zip_code']),
        "PrimaryPhone"              => trim($userDets['phone_number']),
        "PrimaryPhoneType"          => '5',
        "NPINumber"                 => trim($clinicUserDets['npi_number']),
        "ClinicianRoleType"         => $ClinicianRoleType,
        "PDMPRoleType"              => '1',
        "Active"                    => 'True',
        "EPCSRequested"             => 'True',

      ];
      if ($doseSpotSpecialityID != '') {
        //$params['ClinicianSpecialtyType'] = $doseSpotSpecialityID;
      }
      if (!empty($clinicDetails)) {
        $params['PrimaryFax'] = trim($clinicDetails['phone_number']);
      }

      $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
        'Authorization: Bearer ' . $token
      ];


      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $apiUrl);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

      $response   = curl_exec($ch);
      $result     = json_decode($response, true);


      if (!empty($result) && isset($result['Id']) && isset($result['Result']) && isset($result['Result']['ResultCode']) && $result['Result']['ResultCode'] == 'OK') {
        $isSuccess = '1';
        $dosespotClinicianId   = $result['Id'];
        User::updateClinicUserDosepotKey($userDets['id'], $result['Id']);
        if (!empty($additionalInfo) && isset($additionalInfo['dosespot_admin']) && $additionalInfo['dosespot_admin'] == '1') {
          ClinicUser::updateDoseSpotAdmin($clinicUserDets['id'], '1');
        }
      }
    }


    if (!empty($clinicDetails) && $clinicDetails['dosepot_id'] != '' && $userDets['dosespot_clinician_id'] != '' && $createClinician != '1') {
      $attachClinicianResponse = $this->addClinicianToClinics($clinicDetails, $userDets['dosespot_clinician_id']);

      if (!empty($attachClinicianResponse)) {
        $isSuccess  = '1';
        if ($attachClinicianResponse['success'] == '0') {
          $isSuccess  = '0';
          $errors     = $attachClinicianResponse['errors_as_array'];
        }
      }
    }

    // Loop through ModelState to extract error messages
    if (!empty($result) && isset($result['ModelState']) && is_array($result['ModelState'])) {
      foreach ($result['ModelState'] as $field => $messages) {
        foreach ($messages as $message) {
          $errors[] = $message;
        }
      }
    }
    if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
      $errors[]  = $result['Result']['ResultDescription'];
    }

    $finalArr = array();
    $finalArr['success'] = $isSuccess;
    $finalArr['errors']  = (!empty($errors)) ? implode(',', $errors) : '';
    return $finalArr;
  }
  function addClinicianToClinics($clinicDetails, $clinicianID)
  {

    $token =  $this->generateDoseSpotToken();

    $apiUrl     = env('DOSESPOT_URL') . 'api/clinicians/' . $clinicianID . '/clinics';
    $params     = array();
    $params     = [
      "ClinicIds"      => $clinicDetails['dosepot_id'],
    ];

    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
      'Authorization: Bearer ' . $token
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);

    $isSuccess  = '0';
    if (!empty($result) && isset($result['0']['Id']) && isset($result['0']['Result']) && isset($result['0']['Result']['ResultCode']) && $result['0']['Result']['ResultCode'] == 'OK') {
      $isSuccess = '1';
    }

    $errors = [];
    // Loop through ModelState to extract error messages
    if (isset($result['ModelState']) && is_array($result['ModelState'])) {
      foreach ($result['ModelState'] as $field => $messages) {
        foreach ($messages as $message) {
          $errors[] = $message;
        }
      }
    }

    if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
      $errors[]  = $result['Result']['ResultDescription'];
    }


    $finalArr = array();
    $finalArr['success']          = $isSuccess;
    $finalArr['errors']           = (!empty($errors)) ? implode(',', $errors) : '';
    $finalArr['errors_as_array']  = $errors;
    return $finalArr;
  }
  function sso(string $clinicKey, string $userId): array
  {
    $length = 32;
    $aZ09 = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    $randphrase = '';

    // Step 1-2: Generate random 32-character phrase
    for ($c = 0; $c < $length; $c++) {
      $randphrase .= $aZ09[random_int(0, count($aZ09) - 1)];
    }

    // Step 3: Append clinicKey to phrase
    $randkey = $randphrase . $clinicKey;

    // Step 4-5: Convert to UTF-8, hash with SHA-512
    $toencode = mb_convert_encoding($randkey, 'UTF-8');
    $output = hash('sha512', $toencode, true);

    // Step 6: Base64 encode
    $sso = base64_encode($output);

    // Step 6a: Strip '=='
    $ssocode = str_ends_with($sso, '==') ? substr($sso, 0, -2) : $sso;

    // Step 7: Prepend phrase
    $ssocode = $randphrase . $ssocode;

    // Step 8: Generate second hash for UserIdVerify
    $shortphrase = substr($randphrase, 0, 22);
    $uidv = $userId . $shortphrase . $clinicKey;

    $idencode = mb_convert_encoding($uidv, 'UTF-8');
    $idoutput = hash('sha512', $idencode, true);
    $idssoe = base64_encode($idoutput);

    $ssouidv = str_ends_with($idssoe, '==') ? substr($idssoe, 0, -2) : $idssoe;

    return [$ssocode, $ssouidv];
  }
  function editClinicUserDoseSpot($clinicUserDets, $userDets)
  {

    $token          =  $this->generateDoseSpotToken();
    $address        = $this->getTrimmedAddress(trim($userDets['address']));
    $clinicianID    = trim($userDets['dosespot_clinician_id']);
    $apiUrl         = env('DOSESPOT_URL') . 'api/clinicians/' . $clinicianID;

    $stateName = (isset($userDets['state'])) ? $userDets['state'] : '';
    if (isset($userDets['state_id'])) {
      $state = DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->where('id', $userDets['state_id'])->first();
      $state = $this->convertToArray($state);
      if (!empty($state)) {
        $stateName = $state['state_name'];
      }
    }


    $params         = array();
    $doseSpotSpecialityID = $this->getDosespotSpecialities($clinicUserDets['specialty_id']);

    $params     = [
      "FirstName"                 => trim($userDets['first_name']),
      "LastName"                  => trim($userDets['last_name']),
      // "Email"                     => trim($userDets['email']),
      "DateOfBirth"               => trim($userDets['dob']),
      "Address1"                  => trim($address),
      "City"                      => trim($userDets['city']),
      "State"                     => trim($stateName),
      "ZipCode"                   => trim($userDets['zip_code']),
      "PrimaryPhone"              => trim($userDets['phone_number']),
      "PrimaryPhoneType"          => '5',
      "NPINumber"                 => trim($clinicUserDets['npi_number']),
      "ClinicianRoleType"         => '1',
      "EPCSRequested"             => 'True',

    ];
    $clinicDetails = $this->convertToArray(Clinic::selectedClinicByID($clinicUserDets['clinic_id']));
    if ($doseSpotSpecialityID != '') {
      $params['ClinicianSpecialtyType'] = $doseSpotSpecialityID;
    }
    if (!empty($clinicDetails)) {
      $params['PrimaryFax'] = trim($clinicDetails['phone_number']);
    }



    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
      'Authorization: Bearer ' . $token
    ];




    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);


    $isSuccess  = '0';
    if (!empty($result) && isset($result['Id']) && isset($result['Id'])) {
      $isSuccess = '1';
    }

    $errors = [];
    // Loop through ModelState to extract error messages
    if (isset($result['ModelState']) && is_array($result['ModelState'])) {
      foreach ($result['ModelState'] as $field => $messages) {
        foreach ($messages as $message) {
          $errors[] = $message;
        }
      }
    }

    if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
      $errors[]  = $result['Result']['ResultDescription'];
    }
    $finalArr = array();
    $finalArr['success']          = $isSuccess;
    $finalArr['errors']           = (!empty($errors)) ? implode(',', $errors) : '';
    $finalArr['errors_as_array']  = $errors;
    return $finalArr;
  }
  function registrationStatus($clinicianID, $clinicDetails)
  {

    $userName       = '';
    $tokenInfo      = array();
    if (!empty($clinicDetails)) {
      $tokenInfo['client_id']     = $clinicDetails['dosepot_id'];
      $tokenInfo['client_secret'] = $clinicDetails['dosepot_key'];
      $tokenInfo['Password']      = $clinicDetails['dosepot_key'];
      $userName                   = $clinicianID;
    }
    $token          =  $this->generateDoseSpotToken($userName, $tokenInfo);
    $apiUrl     =   env('DOSESPOT_URL') . 'api/clinicians/' . $clinicianID . '/registrationStatus';

    $params     = array();

    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
      'Authorization: Bearer ' . $token
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);

    return $result;
  }

  function editClinicDoseSpot($clinicDetails)
  {
    $token =  $this->generateDoseSpotToken();
    $clinicianID    = trim($clinicDetails['dosepot_id']);

    $address    = $this->getTrimmedAddress(trim($clinicDetails['address']));

    $stateName = (isset($clinicDetails['state'])) ? $clinicDetails['state'] : '';
    if (isset($clinicDetails['state_id'])) {
      $state = DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->where('id', $clinicDetails['state_id'])->first();
      $state = $this->convertToArray($state);
      if (!empty($state)) {
        $stateName = $state['state_name'];
      }
    }


    $apiUrl     = env('DOSESPOT_URL') . 'api/clinics/' . $clinicianID;
    $params     = array();
    $params     = [
      "ClinicName"            => trim($clinicDetails['name']),
      "Address1"              => $address,
      "City"                  => trim($clinicDetails['city']),
      "State"                 => trim($stateName),
      "ZipCode"               => trim($clinicDetails['zip_code']),
      "ZipCode"               => "00501",
      "PrimaryPhone"          => trim($clinicDetails['phone_number']),
      "PrimaryPhoneType"      => '5',


    ];

    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
      'Authorization: Bearer ' . $token
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);


    $isSuccess  = '0';
    if (!empty($result) && isset($result['Id']) && isset($result['Id'])) {
      $isSuccess = '1';
    }

    $errors = [];
    // Loop through ModelState to extract error messages
    if (isset($result['ModelState']) && is_array($result['ModelState'])) {
      foreach ($result['ModelState'] as $field => $messages) {
        foreach ($messages as $message) {
          $errors[] = $message;
        }
      }
    }
    if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
      $errors[]  = $result['Result']['ResultDescription'];
    }

    $finalArr = array();
    $finalArr['success'] = $isSuccess;
    $finalArr['errors']  = (!empty($errors)) ? implode(',', $errors) : '';
    return $finalArr;
  }
  function removeClinicUserDoseSpot($clinicUserDets, $userDets)
  {
    $address    = $this->getTrimmedAddress(trim($userDets['address']));
    $token =  $this->generateDoseSpotToken();
    $clinicDetails = $this->convertToArray(Clinic::selectedClinicByID($clinicUserDets['clinic_id']));
    $clinicID      = trim($clinicDetails['dosepot_id']);

    $stateName = (isset($userDets['state'])) ? $userDets['state'] : '';
    if (isset($userDets['state_id'])) {
      $state = DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->where('id', $userDets['state_id'])->first();
      $state = $this->convertToArray($state);
      if (!empty($state)) {
        $stateName = $state['state_name'];
      }
    }

    $isSuccess     = '0';
    if (!empty($clinicDetails)) {
      $apiUrl     = env('DOSESPOT_URL') . 'api/clinics/clinicRemoveClinicians?clinicId=' . $clinicID;
      $params     = array();
      $params     = [
        "ClinicianIds"              => array($userDets['dosespot_clinician_id']),
        "Address1"                  => trim($address),
        "City"                      => trim($userDets['city']),
        "State"                     => trim($stateName),
        "ZipCode"                   => trim($userDets['zip_code']),
        "PrimaryPhone"              => trim($userDets['phone_number']),
        "ClinicName"                => trim($clinicDetails['name']),
        "PrimaryPhoneType"          => '5',
      ];

      $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
        'Authorization: Bearer ' . $token
      ];


      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $apiUrl);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

      $response   = curl_exec($ch);
      $result     = json_decode($response, true);

      if (!empty($result) && isset($result['Id']) && isset($result['Result']) && isset($result['Result']['ResultCode']) && $result['Result']['ResultCode'] == 'OK') {
        $isSuccess = '1';
        User::updateClinicUserDosepotKey($userDets['id'], NULL);
      }

      $errors = [];
      // Loop through ModelState to extract error messages
      if (isset($result['ModelState']) && is_array($result['ModelState'])) {
        foreach ($result['ModelState'] as $field => $messages) {
          foreach ($messages as $message) {
            $errors[] = $message;
          }
        }
      }
    }
    if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
      $errors[]  = $result['Result']['ResultDescription'];
    }

    $finalArr                     = array();
    $finalArr['success']          = $isSuccess;
    $finalArr['errors']           = (!empty($errors)) ? implode(',', $errors) : '';
    $finalArr['errors_as_array']  = $errors;
    return $finalArr;
  }
  function getDosespotSpecialities($specialtyID)
  {

    $speciality     = User::getSpecialityByID($specialtyID);
    $specialityName = '';
    $specialityID = '';
    if (!empty($speciality)) {
      $specialityName = $speciality['specialty_name'];
      $specialityID = $speciality['dosespot_speciality_id'];
    }

    return $specialityID;
  }
  function getTrimmedAddress($address)
  {
    $trimmedAddress = substr($address, 0, 35);
    return $trimmedAddress;
  }

  function formatAmount($amount)
  {

    $finalamount = floor($amount) == $amount ? number_format($amount, 0) : number_format($amount, 2);

    return $finalamount;
  }
  function checkuserData($userId)
  {

    $user = User::select(['id', 'address', 'dob', 'state', 'state_id', 'zip_code', 'city', 'fax',])->find($userId);
    $profileFields = ['address', 'dob', 'state', 'state_id', 'zip_code', 'city', 'fax'];

    $isShow = collect($profileFields)->contains(fn($field) => empty($user->$field));

    // Fields that must EACH be filled
    $soloFields = ['address', 'dob', 'zip_code', 'city', 'fax'];

    $missingSolo  = collect($soloFields)
      ->contains(fn($f) => blank($user->$f));

    // state / state_id rule: show only if BOTH are blank
    $missingState = blank($user->state) && blank($user->state_id);

    // Return 1 or 0 instead of a boolean
    return ($missingSolo || $missingState) ? 1 : 0;
  }
  function showPrescription($clinicuserUuid)
  {
    $showPrescrition = '0';
    $clinicUserDetails = $this->convertToArray(ClinicUser::getClinicUserByUuid($clinicuserUuid));

    if (!empty($clinicUserDetails) && $clinicUserDetails['eprescribe_enabled'] && $clinicUserDetails['eprescriber_id'] != '') {
      $prescriberDets = ClinicUser::eprescribeByID($clinicUserDetails['eprescriber_id']);

      $userDets       = $clinicUserDetails['user'];
      if (!empty($userDets) && $userDets['dosespot_clinician_id'] && !empty($prescriberDets) && $prescriberDets['onboarding_completed'] == '1') {
        $showPrescrition = '1';
      }
    }
    return $showPrescrition;
  }

  function createPatientDoseSpot($clinicUserDetails, $patientDets)
  {
    $userName = (!empty($clinicUserDetails) && isset($clinicUserDetails['user']) && $clinicUserDetails['user']['dosespot_clinician_id']) ? $clinicUserDetails['user']['dosespot_clinician_id'] : '';
    $isSuccess  = '0';
    $errors = [];

    $tokenInfo = array();
    $clinicDetails = $this->convertToArray(Clinic::selectedClinicByID($clinicUserDetails['clinic_id']));
    if (!empty($clinicDetails)) {
      $tokenInfo['client_id']     = $clinicDetails['dosepot_id'];
      $tokenInfo['client_secret'] = $clinicDetails['dosepot_key'];
      $tokenInfo['Password']      = $clinicDetails['dosepot_key'];
    }

    if ($userName != '') {
      $token      = $this->generateDoseSpotToken($userName, $tokenInfo);
      $userDets   = $patientDets['user'];
      $address    = $this->getTrimmedAddress(trim($userDets['address']));

      $stateName = (isset($userDets['state'])) ? $userDets['state'] : '';
      if (isset($userDets['state_id'])) {
        $state = DB::table('ref_states')->select('id', 'state_prefix', 'state_name')->where('id', $userDets['state_id'])->first();
        $state = $this->convertToArray($state);
        if (!empty($state)) {
          $stateName = $state['state_name'];
        }
      }
      $createPatient        = '1';
      if ($patientDets['dosepsot_patient_id'] != '') {
        $createPatient      = '0';
      }
      $genderArr  = array("1" => "Male", "2" => "Female", "3" => "Unknown");
      $result = array();
      if ($createPatient == '1') {
        $apiUrl     = env('DOSESPOT_URL') . 'api/patients';
        $params     = array();

        $params     = [
          "FirstName"                 => trim($userDets['first_name']),
          "MiddleName"                => trim($userDets['middle_name']),
          "LastName"                  => trim($userDets['last_name']),
          "DateOfBirth"               => trim($userDets['dob']),
          "Gender"                    => (!empty($genderArr) && isset($genderArr[$userDets['gender']])) ? $genderArr[$userDets['gender']] : '',
          "Address1"                  => trim($address),
          "City"                      => trim($userDets['city']),
          "State"                     => trim($stateName),
          "ZipCode"                   => trim($userDets['zip_code']),
          "PrimaryPhone"              => trim($userDets['phone_number']),
          "PrimaryPhoneType"          => '5',
          "Active"                    => 'True',

        ];


        $headers = [
          'Content-Type: application/x-www-form-urlencoded',
          'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
          'Authorization: Bearer ' . $token
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        $response   = curl_exec($ch);
        $result     = json_decode($response, true);

        if (!empty($result) && isset($result['Id']) && isset($result['Result']) && isset($result['Result']['ResultCode']) && $result['Result']['ResultCode'] == 'OK') {

          $isSuccess = '1';
          $dosespotId   = $result['Id'];
          Patient::updatePatientDosepotId($patientDets['id'], $dosespotId);
        }
      }

      // Loop through ModelState to extract error messages
      if (!empty($result) && isset($result['ModelState']) && is_array($result['ModelState'])) {
        foreach ($result['ModelState'] as $field => $messages) {
          foreach ($messages as $message) {
            $errors[] = $message;
          }
        }
      }
      if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
        $errors[]  = $result['Result']['ResultDescription'];
      }
    }
    $finalArr = array();
    $finalArr['success'] = $isSuccess;
    $finalArr['errors']  = (!empty($errors)) ? implode(',', $errors) : '';
    return $finalArr;
  }
  function transferPatient($clinicDetails, $dosepotID, $userName)
  {

    $token          =  $this->generateDoseSpotToken();
    $apiUrl     = env('DOSESPOT_URL') . 'api/patients/' . $dosepotID . '/transfer';
    $params     = [
      "ClinicIdToRemove"              => '989580',
      "ClinicIdToAdd"                 => trim($clinicDetails['dosepot_id']),


    ];

    $headers = [
      'Content-Type: application/x-www-form-urlencoded',
      'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
      'Authorization: Bearer ' . $token
    ];



    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);


    $isSuccess  = '0';

    if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && $result['Result']['ResultCode'] == 'OK') {
      $isSuccess = '1';
    }


    $errors = [];
    // Loop through ModelState to extract error messages
    if (isset($result['ModelState']) && is_array($result['ModelState'])) {
      foreach ($result['ModelState'] as $field => $messages) {
        foreach ($messages as $message) {
          $errors[] = $message;
        }
      }
    }

    if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
      $errors[]  = $result['Result']['ResultDescription'];
    }
    $finalArr = array();
    $finalArr['success']          = $isSuccess;
    $finalArr['errors']           = (!empty($errors)) ? implode(',', $errors) : '';
    $finalArr['errors_as_array']  = $errors;
    return $finalArr;
  }
  function patientPrescriptionUrl($clinicUserDetails, $patientDets)
  {

    $clinicDetails = $this->convertToArray(Clinic::selectedClinicByID($clinicUserDetails['clinic_id']));
    $ssoUrl = '';
    if (!empty($clinicUserDetails)) {
      $clinicID       = trim($clinicDetails['dosepot_id']);
      $clinicKey      = $clinicDetails['dosepot_key'];
      $clinicId       = $clinicDetails['dosepot_id'];
      $userId         = $clinicUserDetails['user']['dosespot_clinician_id'];
      $patientId      = $patientDets['dosepsot_patient_id'];

      list($encryptedClinicId, $userIdVerify) = $this->sso($clinicKey, $userId);

      $ssoUrl = "https://my.staging.dosespot.com/LoginSingleSignOn.aspx?" .
        "SingleSignOnClinicId=" . urlencode($clinicId) .
        "&SingleSignOnUserId=" . urlencode($userId) .
        "&PatientId=" . urlencode($patientId) .
        "&SingleSignOnPhraseLength=32" .
        "&SingleSignOnCode=" . urlencode($encryptedClinicId) .
        "&SingleSignOnUserIdVerify=" . urlencode($userIdVerify) .
        "&RefillsErrors=1";
    }
    return $ssoUrl;
  }

  //function getMedicationHistory(){
  function getMedicationHistory($patientDets, $clinicUserDets)
  {

    /*    $tokenInfo['client_id']     = '992785';
        $tokenInfo['client_secret'] = 'DRKNADMJGXVQG44X9Q63X2FRYMPMPXUP';
        $tokenInfo['Password']      = 'DRKNADMJGXVQG44X9Q63X2FRYMPMPXUP';
        
        
        $token          =  $this->generateDoseSpotToken('3066507',$tokenInfo);
        
        $patientID = "79363450";
        $startDate = "2025-07-06";
        $endDate = "2025-07-31";*/

    $isSuccess  = '0';
    $errors     = [];
    $tokenInfo  = array();
    $clinicDetails = $this->convertToArray(Clinic::selectedClinicByID($clinicUserDets['clinic_id']));
    if (!empty($clinicDetails)) {
      $patientID                  = $patientDets['dosepsot_patient_id'];
      $tokenInfo['client_id']     = $clinicDetails['dosepot_id'];
      $tokenInfo['client_secret'] = $clinicDetails['dosepot_key'];
      $tokenInfo['Password']      = $clinicDetails['dosepot_key'];
      $userName                   = $clinicUserDets['user']['dosespot_clinician_id'];

      $token          =  $this->generateDoseSpotToken($userName, $tokenInfo);

      $apiUrl     = env('DOSESPOT_URL') . 'api/patients/' . $patientID . '/prescriptions';
      //  $apiUrl     = env('DOSESPOT_URL').'api/patients/'.$patientID.'/logMedicationHistoryConsent';
      /* $params     = [
                "start"                         => $startDate,
                "end"                           => $endDate,

            ];*/
      $params = array();

      $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Subscription-Key: ' . env('DOSESPOT_SUBSCRIPTIONKEY'),
        'Authorization: Bearer ' . $token
      ];


      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $apiUrl);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

      $response   = curl_exec($ch);
      $result     = json_decode($response, true);


      if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && $result['Result']['ResultCode'] == 'OK') {
        $isSuccess = '1';
        $prescriptions = (isset($result['Items'])) ? $result['Items'] : array();
        if (!empty($prescriptions)) {
          $this->addDoseSpotMedications($prescriptions, $patientDets);
        }
      }

      // Loop through ModelState to extract error messages
      if (isset($result['ModelState']) && is_array($result['ModelState'])) {
        foreach ($result['ModelState'] as $field => $messages) {
          foreach ($messages as $message) {
            $errors[] = $message;
          }
        }
      }

      if (!empty($result) && isset($result['Result']) && isset($result['Result']['ResultCode']) && isset($result['Result']['ResultDescription']) && $result['Result']['ResultCode'] == 'ERROR') {
        $errors[]  = $result['Result']['ResultDescription'];
      }
    }
    $finalArr = array();
    $finalArr['success']          = $isSuccess;
    $finalArr['errors']           = (!empty($errors)) ? implode(',', $errors) : '';
    $finalArr['errors_as_array']  = $errors;
    return $finalArr;
  }
  function addDoseSpotMedications($prescriptions, $patientDets)
  {

    if (!empty($prescriptions)) {

      $statusesFromDosespot = array('eRxSent', 'Error', 'Entered', 'PharmacyVerified', 'Deleted');
      $toInsertStatuses     = array('eRxSent', 'PharmacyVerified');
      $medicationStatus     = array('Active');

      $removedDoseSpotPrescriptionIDS = array();
      $dosespotDispenseIDS = $formPrescriptionIDS = $clinicianDosepotIDS = $clinicianDosepotIDS = array();
      if (!empty($prescriptions)) {
        foreach ($prescriptions as $psv) {
          $dosespotDispenseIDS[] = (isset($psv['DispenseUnitId'])) ? $psv['DispenseUnitId'] : array();
          $formPrescriptionIDS[] = (isset($psv['PrescriptionId'])) ? $psv['PrescriptionId'] : array();
          $clinicDosepotIDS[] = (isset($psv['ClinicId'])) ? $psv['ClinicId'] : array();
          $clinicianDosepotIDS[] = (isset($psv['PrescriberId'])) ? $psv['PrescriberId'] : array();

          if (isset($psv['MedicationStatus']) && !in_array($psv['MedicationStatus'], $medicationStatus)) {
            $removedDoseSpotPrescriptionIDS[] = $psv['PrescriptionId'];
          }
        }
      }
      $dbMedications              = Medication::getDoseSpotMedications($patientDets['user_id'], $patientDets['clinic_id'], '5');
      $dbPrescriptionIDS          = $this->getIDSfromArray($dbMedications, 'dosespot_prescription_id');


      /* Clinic Details */
      $clinicDets    = Clinic::clinicByDosespotIDS($clinicDosepotIDS);

      /* Clinic User Details */
      $userDets = User::UserByClinicianDosespotIDS($clinicianDosepotIDS);

      /* Dispense Units */
      $dispenseUnits = Medication::dispenseUnitByDosespotIDS($dosespotDispenseIDS);



      $toInsert       = array_diff($formPrescriptionIDS, $dbPrescriptionIDS);
      $toDelete       = array_diff($dbPrescriptionIDS, $formPrescriptionIDS);



      foreach ($prescriptions as $prv) {

        if (in_array($prv['PrescriptionId'], $toInsert) && in_array($prv['MedicationStatus'], $medicationStatus) && in_array($prv['Status'], $toInsertStatuses)) {

          $medInfo = array();
          $medInfo['quantity']                  = (isset($prv['Quantity'])) ? $prv['Quantity'] : NULL;
          $medInfo['medicine_name']             = (isset($prv['DisplayName'])) ? $prv['DisplayName'] : NULL;
          $medInfo['clinic_id']                 = (!empty($clinicDets) && isset($clinicDets[$prv['ClinicId']])) ?  $clinicDets[$prv['ClinicId']]['id'] : NULL;
          $medInfo['prescribed_by']              = (!empty($userDets) && isset($userDets[$prv['PrescriberId']])) ?  $userDets[$prv['PrescriberId']]['first_name'] . ' ' . $userDets[$prv['PrescriberId']]['last_name'] : NULL;
          $medInfo['frequency']              = (isset($prv['Directions'])) ? $prv['Directions'] : NULL;
          $medInfo['start_date']              = (isset($prv['WrittenDate'])) ? date('Y-m-d', strtotime($prv['WrittenDate'])) : NULL;
          $medInfo['strength']             = (isset($prv['Strength'])) ? $prv['Strength'] : NULL;
          $medInfo['user_id']             = $patientDets['user_id'];
          $medInfo['dispense_unit_id']    = (!empty($dispenseUnits) && isset($dispenseUnits[$prv['DispenseUnitId']])) ? $dispenseUnits[$prv['DispenseUnitId']]['id'] : NULL;


          $medInfo['source_type_id']            = '5';

          $medInfo['dosespot_prescription_id']  = $prv['PrescriptionId'];
          $medInfo['dosespot_medication_data']  = serialize($prv);

          Medication::addDoseSpotMedication($medInfo);
        }
      }

      if (!empty($toDelete)) {
        Medication::removeMedications($patientDets['user_id'], $toDelete, $patientDets['clinic_id']);
      }
      if (!empty($removedDoseSpotPrescriptionIDS)) {
        Medication::removeMedications($patientDets['user_id'], $removedDoseSpotPrescriptionIDS, $patientDets['clinic_id']);
      }
    }
  }
  public function chatDocumentImage($docDets)
  {
    $image = '';
    $finalArr = array();
    if (!empty($docDets)) {

      $ext                = $docDets['doc_ext'];
      $imageExtensions    = ['png', 'jpg', 'jpeg', 'gif'];
      $pdfExtensions      = ['pdf'];
      $excelExtensions    = ['xls', 'xlsx', 'xlsm'];
      $videoExtensions    = ['mp4', 'avi', 'mov', 'mkv'];
      $wordExtensions     = ['doc', 'docx', 'bmp', 'webp'];
      if (in_array($ext, $imageExtensions)) {
        $image =    $this->getAWSFilePath($docDets['doc_path']);
      } else if (in_array($ext, $pdfExtensions)) {
        $image = asset('images/pdf_icon.png');
      } else if (in_array($ext, $excelExtensions)) {
        $image = asset('images/excel_icon.png');
      } else if (in_array($ext, $videoExtensions)) {
        $image = asset('images/mp4_img.png');
      } else if (in_array($ext, $videoExtensions)) {
        $image = asset('images/doc_image.png');
      }
    }
    $finalArr['image'] = $image;
    $finalArr['title'] = $docDets['original_name'];
    return $finalArr;
  }

  function uploadFileToFileCabinet($chatID, $chatDocID, $userID, $userType = '2')
  {
    $chatDocData = Chats::chatDocByID($chatDocID);
    $chatDoc = $this->convertToArray($chatDocData);
    $chat    = Chats::chatByID($chatID);
    $folderName = "Chat Documents";
    $clinicID   = $chat['clinic_id'];
    if (!empty($chatDoc) && !empty($chat)) {
      $checkFolderExist = $this->convertToArray(DB::table('fc_user_folders')->where('folder_name', $folderName)->where('user_id', $userID)->first());
      if (!empty($checkFolderExist)) {
        $folderID = $checkFolderExist['id'];
      }
      if (empty($checkFolderExist)) {
        $folderID = FcUserFolder::addFolder($folderName, $userID, $clinicID, $userType, $userID);
      }
      $fileName   = $chatDoc['original_name'];
      $chatDocData->temp_doc_ext =  $ext        = $chatDoc['doc_ext'];
      $fileKey    = $this->generateUniqueKey(10, 'fc_files', 'file_key');
      $fileId     = FcFile::addFile($fileKey, $userID, $folderID, $chatDocData, $userType, $clinicID, $userID, $fileName);

      $awsPath = $this->getMyPathForAWS($fileId, $fileKey, $ext, 'uploads/patientfiles/');
      Storage::disk('s3')->copy($chatDoc['doc_path'], $awsPath);
      FcFile::updateFilePath($fileId, $awsPath);
      /*$awsDocPath =    $this->getAWSFilePath($awsPath);

             print "<pre>";
             print_r($awsDocPath);
             exit;*/
      return;
    }
  }
  function convertTimeslot($clinicID, $timezoneId)
  {
    // 2. Get  business hours Clinic
    $businessHoursList = DB::table('bussiness_hours')
      ->where('clinic_id', $clinicID)
      ->whereNull('deleted_at')
      ->get();

    $userTimezone =  DB::table('ref_timezones')->where('id', $timezoneId)->whereNull('deleted_at')->first();
    foreach ($businessHoursList as $businessHour) {
      // 3. Get all time slots for this business hour
      $timeSlots = DB::table('bussinesshours_times')
        ->where('bussiness_hour_id', $businessHour->id)
        ->whereNotNull('timezone_to_utc')
        ->whereNotNull('timezone_from_utc')
        ->whereNull('deleted_at')
        ->get();

      foreach ($timeSlots as $slot) {
        $etTimezone = new \DateTimeZone($userTimezone->timezone_format); // ET includes DST
        $utcTimezone = new \DateTimeZone('UTC');

        $utcToTime = (new \DateTime($slot->to_time, $etTimezone))
          ->setTimezone($utcTimezone)
          ->format('H:i:s');
        $utcFromTime = (new \DateTime($slot->from_time, $etTimezone))
          ->setTimezone($utcTimezone)
          ->format('H:i:s');
        DB::table('bussinesshours_times')->where('id', $slot->id)->limit(1)->update(array(
          'timezone_from_utc' => $utcFromTime,
          'timezone_to_utc' => $utcToTime,
          'timezone_id' => $timezoneId
        ));
      }
    }
    return;
  }
  function checkIsUserUserForePrescribe($clinicDetails, $clinicUserDetails)
  {
    $isUsUser = '1';
    if ($clinicUserDetails['country_code'] != 185 || $clinicDetails['country_code'] != 185) {
      $isUsUser = '0';
    }
    return $isUsUser;
  }
  function cancelRPMOrder($url, $params, $token)
  {

    $apiKey     =   env('SMARTMETER_API_KEY');
    $apiUrl     =   env('SMARTMETER_API_URL') . $url;

    $headers = [
      'Content-Type: application/json',
      'Accept: application/json',
      'X-API-KEY: ' . $apiKey,
      'Authorization: Bearer ' . $token
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

    $response   = curl_exec($ch);
    $result     = json_decode($response, true);

    return $result;
  }
}
