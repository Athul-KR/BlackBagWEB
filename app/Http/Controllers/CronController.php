<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Routing\Controller;
use App\Models\Consultant;
use App\Models\Patient;
use App\Models\ClinicUser;
use App\Models\Clinic;
use App\Models\MedicalNote;
use App\Models\RefDesignation;
use App\Models\VideoCall;
use App\Models\Appointment;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\VideoCallTranscriptFile;
use App\Models\ClinicCard;
use App\Models\UserBilling;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\RefCountryCode;
use App\Models\PatientSubscription;
use App\Models\ClinicSubscription;
use App\Models\PatientCard;
use App\Models\RefState;
use App\Models\RpmOrders;
use App\customclasses\Corefunctions;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use File;
use Aws\S3\S3Client;
use Spatie\PdfToText\Pdf;
use Smalot\PdfParser\Parser;

class CronController extends Controller
{
    public function __construct()
    {
        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->stripePayment = new \App\customclasses\StripePayment;
    }

    public function paymentNotification(Request $request)
    {   
        /*due Date */
       $dueDate =   date('Y-m-d');
        // Calculate the date two days from today
         $limitDate = date('Y-m-d', strtotime('+2 days'));
      
        $appointmentsDetails = DB::table('appointments')->whereDate('appointment_date', '<=', $limitDate)->whereNull('deleted_at')->where('is_paid','0')->get();
        $appointmentsDetails = $this->Corefunctions->convertToArray($appointmentsDetails);

        /** get patientIDs */
        $patientIDs = $this->Corefunctions->getIDSfromArray($appointmentsDetails, 'patient_id');
        $patientDetails = $this->Corefunctions->convertToArray(Patient::whereIn('id',$patientIDs)->whereNull('deleted_at')->get());
        $patientDetails = $this->Corefunctions->getArrayIndexed1($patientDetails, 'id');

        $totalProcessed = 0;
        if(!empty($appointmentsDetails)){
            foreach ( $appointmentsDetails as $usk => $usv ) {

                    /* Add Notifications */
                    if(isset($patientDetails[$usv['patient_id']])){
                       
                        $this->Corefunctions->addNotifications(5,$usv["clinic_id"],$patientDetails[$usv['patient_id']]['user_id'],$usv['id']);
                  
                    }
                   
                    $totalProcessed++;
            }
        }

          
        print "Reminder Completed.Processed:".$totalProcessed;
        exit;

    }

    public function summarizePdf()
    {
        $lastID = (isset($_GET['lastid'])) ? $_GET['lastid'] : 0;
        $files = DB::table('fc_files')
            ->where('ai_generated', '0')
            ->where('consider_for_ai_generation', '1')
            ->where('ai_error', '0')
            ->where('id', '>', $lastID)
            ->whereNull('deleted_at')
            ->orderBy('id', 'asc')
            ->limit(5)
            ->get();

        $files = $this->Corefunctions->convertToArray($files);
        // print "<pre>";
        // print_r($files);exit;

        if (!empty($files)) {
            foreach ($files as $flk => $flv) {
                // Retrieve file from S3 using AWS SDK
                $fileContent = $this->getAWSS3File($flv['file_path']);
                if ($fileContent === false) {
                    continue; // Skip if unable to retrieve file from S3
                }
                //print_r($flv);die;
                $fileExtension = $flv['file_ext'];
                $tempFilePath = storage_path('app/temp_' . uniqid() . '.' . $fileExtension);
                file_put_contents($tempFilePath, $fileContent);

                $hash = md5_file($tempFilePath);
                $fileName = $hash . '_extracted_text.txt';
                $filePathToSave = storage_path('app/public/' . $fileName);

                if (file_exists($filePathToSave)) {
                    unlink($filePathToSave);
                }

                $textContent = '';

                // Process PDF files
                if ($fileExtension == 'pdf') {
                    $pdfParser = new Parser(); // Create a new parser instance
                    
                    $fileContent = file_get_contents($tempFilePath);
                    
                    if (substr($fileContent, 0, 5) === '%PDF-') {
                        // It's a valid PDF file
                        try {
                             
                            $pdf = $pdfParser->parseFile($tempFilePath);

                            $textContent = $pdf->getText();
                        } catch (\Smalot\PdfParser\Exception\PdfException $e) {
                            DB::table('fc_files')->where('id',$flv['id'])->update([
                            'ai_generated' => '0',
                            'ai_error' => '1',
                            'summarized_data' => $e->getMessage(),
                        ]);
                        }catch (\Exception $e) {
                            // Catch general exceptions, including memory limit issues
                            if (stripos($e->getMessage(), 'exhausted') !== false) {
                                DB::table('fc_files')->where('id',$flv['id'])->update([
                                    'ai_generated' => '0',
                                    'ai_error' => '1',
                                    'summarized_data' => "Memory limit exhausted. The PDF file is too large to process.",
                                ]);
                            } else {
                                DB::table('fc_files')->where('id',$flv['id'])->update([
                                    'ai_generated' => '0',
                                    'ai_error' => '1',
                                    'summarized_data' => $e->getMessage(),
                                ]);
                            }
                        }
                    } else {
                         DB::table('fc_files')->where('id',$flv['id'])->update([
                            'ai_generated' => '0',
                            'ai_error' => '1',
                            'summarized_data' => "Invalid PDF file: Missing PDF header.",
                        ]);
                       // echo "Invalid PDF file: Missing PDF header.";
                    }

                    
                } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                    $phpWord = IOFactory::load($tempFilePath);
                    foreach ($phpWord->getSections() as $section) {
                        foreach ($section->getElements() as $element) {
                            if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                                foreach ($element->getElements() as $textElement) {
                                    if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                        $textContent .= $textElement->getText() . "\n";
                                    }
                                }
                            } elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                                foreach ($element->getRows() as $row) {
                                    foreach ($row->getCells() as $cell) {
                                        foreach ($cell->getElements() as $cellElement) {
                                            if ($cellElement instanceof \PhpOffice\PhpWord\Element\TextRun) {
                                                foreach ($cellElement->getElements() as $textElement) {
                                                    if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                                        $textContent .= $textElement->getText() . "\n";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Save the extracted text to a .txt file
                file_put_contents($filePathToSave, $textContent);
                $file_path = storage_path('app/public/' . $fileName);

                // Process extracted data
                $this->generateSummarizedData($textContent, $flv['id'], $file_path);

                // Cleanup files after processing
                unlink(storage_path('app/public/' . $fileName));
                unlink($tempFilePath);

                // Update the last processed ID
                $lastID = $flv['id'];
            }

            // Redirect to continue the processing
            $toRedirect = url('summarizepdf') . '?lastid=' . $lastID;
            echo "<script>window.location.href = '$toRedirect';</script>";
        } else {
            echo "<pre>Completed</pre>";
            exit;
        }
    }

    // Function to retrieve private S3 file content
    private function getAWSS3File($filePath)
    {
        // AWS S3 Client Configuration
        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'), // Use the correct AWS region
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_PRIVATE_ID'),
                'secret' => env('AWS_SECRET_PRIVATE_ACCESS_KEY'),
            ],
        ]);

        try {
            // Assuming the file path is an S3 key, construct the S3 URL
            $bucketName = env('AWS_BUCKET_PRIVATE');
            $key = $filePath; // The path to the file in the S3 bucket

            // Get the object from S3
            $result = $s3Client->getObject([
                'Bucket' => $bucketName,
                'Key' => $key,
            ]);

            // Return the file content
            return $result['Body'];
        } catch (S3Exception $e) {
            // Handle error (e.g., file not found, access denied)
            \Log::error('Error accessing S3 file: ' . $e->getMessage());
            return false;
        }
    }
    
    public function generateSummarizedData($text,$fileid,$file_path){

        $url = env('AI_URL');

        $vars['model'] = 'gpt-4';
        $vars['messages'] = array(0 => array('role'=>'system','content'=>'You are an expert summarizer. Please summarize the document. If this is a lab report, then get the summary of the document based on each lab results. If its a prescription, get the summary based on the medications prescribed.'),
            1 => array('role'=>'user','content'=>file_get_contents($file_path))
                                    );
        $vars['temperature'] = 0.7;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars)); // Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer '.env('AI_AUTHORIZATION_KEY')
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($server_output,TRUE);
        
        if(!empty($result['choices'][0]['message']['content'])){
            $content = $result['choices'][0]['message']['content'];

            $content = preg_replace('/^\s*[\r\n]/m', '', $content);

            DB::table('fc_files')->where('id',$fileid)->update([
                'ai_generated' => '1',
                'summarized_data' => $content,
            ]);
        }elseif(!empty($result['error']['message'])){
            DB::table('fc_files')->where('id',$fileid)->update([
                'ai_generated' => '0',
                'ai_error' => '1',
                'summarized_data' => $result['error']['code'],
            ]);
        }
    }
    public function updateAppointmentsWithUserId(){
        $lastID = (isset($_GET['lastid'])) ? $_GET['lastid'] : 0;
        $appointments = DB::table('appointments')
            ->where('id', '>', $lastID)
            ->orderBy('id', 'asc')
            ->limit(5)
            ->get();

        $appointments = $this->Corefunctions->convertToArray($appointments);

        if (!empty($appointments)) {
            foreach ($appointments as $apk => $apv) {
                $consultantUser = DB::table('clinic_users')
                    ->where('id', $apv['consultant_id'])
                    ->value('user_id');
                $nurseUser = DB::table('clinic_users')
                    ->where('id', $apv['nurse_id'])
                    ->value('user_id');
                $patientUser = DB::table('patients')
                    ->where('id', $apv['patient_id'])
                    ->value('user_id');
                DB::table('appointments')
                    ->where('id', $apv['id'])
                    ->update([
                        'consultant_id' => $consultantUser ?? $apv['consultant_id'],
                        'nurse_id'      => $nurseUser ?? $apv['nurse_id'],
                        'patient_id'    => $patientUser ?? $apv['patient_id'],
                    ]);
                $lastID = $apv['id'];
            }
            $toRedirect = url('updateappointmentswithuserid') . '?lastid=' . $lastID;
            echo "<script>window.location.href = '$toRedirect';</script>";
        } else {
            echo "<pre>Completed</pre>";
            exit;
        }
    }


    public function clinicusers(){

    
        $lastID             = ( isset( $_REQUEST['lastid'] ) ) ? $_REQUEST['lastid'] : '0';

        /* get all clinic users from pending list */
        $clinicUsers     = $this->Corefunctions->convertToArray(DB::table('clinic_users')->where('status','-1')->whereNull('user_id')->where('id','>',$lastID)->limit('1')->orderBy('id','asc')->first());
        if( empty( $clinicUsers ) ){
            print "Completed";
            exit;
        }
       
        if( !empty($clinicUsers) ){
            /** get user details */
            $input['email'] = $clinicUsers['email'] ;
            $input['phone_number'] = $clinicUsers['phone_number'] ;
            $countryCodeId = $clinicUsers['country_code'] ;
            $userDetails = User::getUserByPhone($input,$countryCodeId);

            if (empty($userDetails)) {
                $userUuid = $this->Corefunctions->generateUniqueKey("10", "users", "user_uuid");
                $userObject = new User();
                $userObject->user_uuid = $userUuid;
                $userObject->first_name = $clinicUsers['name'];
                $userObject->phone_number = $clinicUsers['phone_number'];
                $userObject->email = $clinicUsers['email'];
                $userObject->country_code = $clinicUsers['country_code'] ; 
                $userObject->status = '-1';
                $userObject->save();
                $userID = $userObject->id;

               
            }else{
                $userID = $userDetails['id'];
            }
            DB::table('clinic_users')->where('id', $clinicUsers['id'])->update(array(
                'user_id' => $userID,
            ));
           
        }
        // print'<pre>';print_r($clinicUsers);exit;
       
        $lastID     = $clinicUsers['id'];
        ?>
        <html>
            <body>
                <script>
                    var lastID = '<?php echo $lastID; ?>';
                    var redirectURL = '<?php echo url('clinicusers?lastid='.$lastID); ?>';
                    window.location.href = redirectURL;
                </script>
            </body>
        </html>
  
        <?php 
  
    }
    public function videoTranscribeGenerate(){
        $appointments = Appointment::getAllAppointmentForTranscribe();
        if (!$appointments) {
            return ;
        }
        $transcriptFiles = VideoCallTranscriptFile::getVideoCallTranscriptFile($appointments->id);

        $mergedContent = '';

        foreach ($transcriptFiles as $file) {
            if ($file->transcript_file_path) {
                // Get content from AWS private storage
                $file_path_transcript = $this->Corefunctions->getAWSPathPrivate($file->transcript_file_path);
                $content = file_get_contents($file_path_transcript);
                if ($content) {
                    // Optional: remove duplicate headers if present in VTTs
                    $lines = explode("\n", $content);
                    $cleanedLines = array_filter($lines, function ($line) {
                        return trim($line) !== 'WEBVTT'; // remove header if repeated
                    });
                    $mergedContent .= implode("\n", $cleanedLines) . "\n";
                }
            }
        }
        
        // Final content with one header
        $finalVttContent = "WEBVTT\n\n" . $mergedContent;

        // Prepare AWS path
        $medical_note_uuid = $this->Corefunctions->generateUniqueKey(8, 'medical_notes', 'medical_note_uuid');

        // Get associated video call
        $videocall = VideoCall::getvideoCallByAppoinmentID($appointments->id);
        
        if (!$videocall) {
            return ;
        }

        $input = [
            'call_id' => $videocall->id,
            'clinic_id' => $appointments->clinic_id,
            'user_id' => $appointments->patient_id,
            'video_scribe' => '1',
            'appointment_id' => $appointments->id,
            'medical_note_uuid' => $medical_note_uuid,
        ];
        $medicalNoteID = MedicalNote::insertMedicalNotesTranscript($input);
        $awsPath = $this->Corefunctions->getMyPathForAWS($medicalNoteID, $medical_note_uuid, 'vtt', 'uploads/medicalnotes/');

        // Upload merged file
        $this->Corefunctions->uploadDocumenttoAWSPrivate($awsPath, $finalVttContent);
        $file_path = $this->Corefunctions->getAWSPathPrivate($awsPath);
        $updateData = [
            'transcript_file_path' => $awsPath
        ];
        MedicalNote::updateMedicalNotesTranscript($updateData,$medicalNoteID);
        // Optionally return path or save reference

        // Fetch doctor details
        $doctor = ClinicUser::getUserByUserId($appointments->consultant_id, $appointments->clinic_id);
        
         if (!$doctor) {
            return response()->json(['error' => 'doctor not found'], 404);
        }
         $doctorName = $this->Corefunctions->showClinicanName($doctor);
         //$doctorName = $doctor->user->first_name;
        // Fetch nurse details
        $nurse = ClinicUser::getUserByUserId($appointments->nurse_id, $appointments->clinic_id);
        if (!$nurse) {
            return response()->json(['error' => 'nurse not found'], 404);
        }
        $nurseName = $nurse->user->first_name;
        $patient = Patient::getPatientByClinicId($appointments->patient_id, $appointments->clinic_id);

        if (!$patient) {
            return response()->json(['error' => 'patient not found'], 404);
        }
        $patientName = $patient->user->first_name;
        $summary = $this->summaryTranscriptFile($doctorName,$nurseName,$patientName,$file_path);
        $updateData = [
            'summary' => $summary
        ];
        MedicalNote::updateMedicalNotesTranscript($updateData,$medicalNoteID);
        // Update appointment status
        Appointment::updateTranscriptFileAdded($appointments->id, '1');

        return;

    }
    
    public function summaryTranscriptFile($doctorName,$nurseName,$patientName,$file_path){
        $url = env('AI_URL');

        $transcriptContent = file_get_contents($file_path);

        $vars['model'] = 'gpt-4';
        
        $vars['messages'] = [
            [
                'role' => 'system',
                'content' => "You are an expert medical summarizer. You will receive a transcript of a video consultation.

        Here are the participant roles:
        - Doctor: $doctorName
        - Nurse: $nurseName
        - Patient: $patientName

        Your task:
        - Generate a professional summary using these names.
        - Include:
          - A brief description of the patient’s concerns or symptoms.
          - Key points and observations made by the doctor.
          - Advice or follow-up instructions given by the nurse.
          - Any medication or treatment plans mentioned."
            ],
            [
                'role' => 'user',
                'content' => $transcriptContent
            ]
        ];
       
        $vars['temperature'] = 0.7;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars)); // Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('AI_AUTHORIZATION_KEY')
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($server_output, TRUE);
        $summary = $result['choices'][0]['message']['content'];
        return $summary;

       

    }
    public function trialNotifications(Request $request)
    {   
        /* Renew Date */
        $date = (  strtotime("+5 day", strtotime( date('Y-m-d')) ));
        $renewDate = date('Y-m-d',$date);

        $currentDate =  date('Y-m-d');
        $totalProcessed = 0;
        
        /* Fetch Trial Subscriptions With Renewal Date +5 days */
        $clinicSubscriptions = Subscription::getSubscriptionsByRenewDate($renewDate);


        $clinicIDS = $this->Corefunctions->getIDSfromArray($clinicSubscriptions,'clinic_id');

        $users = $clinics = array();
        /* Fetch Users By IDS */
        if( !empty( $userIDS ) ){
            $users = User::getUsersByIDs($userIDS);
            $users = $this->Corefunctions->getArrayIndexed1($users,'id');
        }

        /* Fetch Clinics By IDS */
        if( !empty( $clinicIDS ) ){
            $clinics = $this->Corefunctions->convertToArray(Clinic::getclinicByID($clinicIDS));
            $clinics = $this->Corefunctions->getArrayIndexed1($clinics,'id');
        }

     
        /* Fetch Clinic Admins */
        $clinicAdmins = array();
        if( !empty( $clinicIDS ) ){
            $clinicAdmins = $this->Corefunctions->convertToArray(ClinicUser::getClinicAdmins($clinicIDS));
            $clinicAdmins = $this->Corefunctions->getArrayIndexed1($clinicAdmins,'id');
        }
        
        /* Fetch All Plans */
        $subscriptionPlans =  SubscriptionPlan::getSubscriptionPlans();
        $subscriptionPlans = $this->Corefunctions->getArrayIndexed1($subscriptionPlans,'id');

        /* Get User's Default Card */
        $allClinicDefaultCards = array();
        if( !empty( $clinicIDS ) ){
            $allClinicDefaultCards = ClinicCard::getDefaultUserCards($clinicIDS);
            $allClinicDefaultCards = $this->Corefunctions->getArrayIndexed1($allClinicDefaultCards,'clinic_id');
        }
       
        if( !empty( $clinicSubscriptions ) ){
            foreach( $clinicSubscriptions as $cuk => $cuv ){
                if( isset( $users[$cuv['user_id']] ) && isset( $clinics[$cuv['clinic_id']] ) ){
                    
                    $data['email'] = $users[$cuv['user_id']]['email'];
                    $data['renewal_date'] = date('m/d/Y', strtotime( $cuv['renewal_date']));
                    $data['first_name'] = $users[$cuv['user_id']]['first_name'];
                    $data['last_name'] =  $users[$cuv['user_id']]['last_name'];

                    $amount =  ( $cuv['renewal_plan_id'] == $cuv['subscription_plan_id'] ) ?  $subscriptionPlans[$cuv['subscription_plan_id']]['amount'] : $subscriptionPlans[$cuv['renewal_plan_id']]['amount'];
                    
                    $data['amount'] = $amount;
                    $data['planname'] =  $subscriptionPlans[$cuv['subscription_plan_id']]['plan_name'];
                    $data['renewal_planname'] =  $subscriptionPlans[$cuv['renewal_plan_id']]['plan_name'];
                    $data['subscription_plan_id'] = $cuv['subscription_plan_id'];
                    $data['renewal_plan_id'] = $cuv['renewal_plan_id'];
                    $data['clinic_logo'] = (isset($clinics[$cuv['clinic_id']]['logo']) && ($clinics[$cuv['clinic_id']]['logo'] !='')) ? $this->Corefunctions->getAWSFilePath($clinics[$cuv['clinic_id']]['logo']) : '';
                    if($cuv['end_date'] == $currentDate ){
                        $this->Corefunctions->sendmail($data, 'Your Trial is Ending – Add Payment Details to Continue', 'emails.subscriptionend');

                        /* Notifications */
                        $notificationType = '13';
                        $this->Corefunctions->addNotifications($notificationType, $cuv['clinic_id'], $cuv['user_id'], $cuv['id']);
                    }else{
                        if( $cuv['trial_subscription'] == 1 ){

                            if( isset( $allClinicDefaultCards[$cuv['clinic_id']] ) && $cuv['subscription_plan_id'] == $cuv['renewal_plan_id'] ) {
                                $data['has_card'] = '1';

                                $this->Corefunctions->sendmail($data, 'Renewal Reminder – Subscription Plan Update', 'emails.trial_reminder');
                            }elseif( isset( $allClinicDefaultCards[$cuv['clinic_id']] ) && $cuv['subscription_plan_id'] != $cuv['renewal_plan_id'] ){
                                $data['has_card'] = '1';

                                $this->Corefunctions->sendmail($data, 'Renewal Reminder – Your BlackBag Subscription', 'emails.trial_reminder');
                            }else{
                                $data['has_card'] = '0';
                                
                                $this->Corefunctions->sendmail($data, 'Action Required – BlackBag Trial Expiring Soon', 'emails.trial_reminder');
                            }

                            /* Notifications */
                            $notificationType = '14';
                            $this->Corefunctions->addNotifications($notificationType, $cuv['clinic_id'], $cuv['user_id'], $cuv['id']);
                        }
                    }
                    $totalProcessed++;
                }
            }
        }

        print 'Notifications sent successfully for '.$totalProcessed .' users';
        exit;
    }
    
    public function sendPatientSubscriptionRenewalReminder()
    {
        $renewDate = date('Y-m-d', strtotime('+2 day'));
        $patientSubscriptions = PatientSubscription::getPatientSubscriptionsByRenewDate($renewDate);
        $patientSubscriptions = $this->Corefunctions->convertToArray($patientSubscriptions);

        if (empty($patientSubscriptions)) {
            echo "No subscriptions to renew.";
            exit;
        }

        $totalProcessed = 0;

        foreach ($patientSubscriptions as $subscription) {
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByID($subscription['patient_id']));
            $clinic = Clinic::clinicByID( $subscription['clinic_id'] );
            if (empty($clinic)) {
                echo "Invalid Clinic";
                exit;
            }

            $subscriptionDets = ClinicSubscription::getClinicSubscriptionById($subscription['clinic_id'],$subscription['renewal_plan_id']);
            if (empty($subscriptionDets)) {
                echo "Invalid Subscription";
                exit;
            }
            
            if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
                echo "Stripe not connected for this clinic";
                exit;
            }

            $amount = ($subscription['renewal_plan_tenure_type_id'] == 1) ? (float) str_replace(',', '', $subscriptionDets['monthly_amount']) : (float) str_replace(',', '', $subscriptionDets['annual_amount']);
            $amount = number_format($amount, 2);   
            $notes = "Your invoice for subscription renewal is now available. You will be autocharged \${$amount} on {$renewDate}.";
            $type = ($subscription['renewal_plan_tenure_type_id'] == 1) ? 'Monthly' : 'Yearly';
            $itemnotes = "{$type} Charges for Subscription";

            $userId = $patientDetails['user_id'];
            $billingInfo = UserBilling::getUserBillingByUserId($userId);
            if(isset($billingInfo['billing_country_id']) && $billingInfo['billing_country_id'] != ''){
                $countryCode = RefCountryCode::getCountryCodeById($billingInfo['billing_country_id']);
            }

            $cardInfo = PatientCard::getDefaultUserCard($userId);
            $cardInfo['expiry'] = $cardInfo['exp_month'].'/'.$cardInfo['exp_year'];

            $id = Invoice::insertInvoice($subscription['id'],$amount,'0',$billingInfo,$notes,2,$renewDate); 
            InvoiceItem::insertInvoiceItem($id,$subscription['id'],$amount,'0',$itemnotes);
            
            $invoiceDets = $this->Corefunctions->convertToArray(Invoice::getInvoiceById($id));
            $data['name'] =  $patientDetails['user']['first_name'];
            $data['email'] =  $patientDetails['email'];
            $data['invoiceNumber'] =  $invoiceDets['invoice_number'];
            $data['billingInfo'] =  $billingInfo;
            $data['cardInfo'] =  $cardInfo;
            $data['notes'] = $notes;
            $data['countryCode'] = $countryCode;
            $this->Corefunctions->sendmail($data, 'Your Subscription Renewal Invoice', 'emails.subscription_renewal_invoice');
        }
        print "Subscription Renewal Invoice Generation Completed.";
        exit;
    }
    public function patientSubscriptionRenewal(Request $request)
    {
        $renewDate = date('Y-m-d');
        $patientSubscriptions = PatientSubscription::getPatientSubscriptionsByRenewDate($renewDate);
        $patientSubscriptions = $this->Corefunctions->convertToArray($patientSubscriptions);

        if (empty($patientSubscriptions)) {
            echo "No subscriptions to renew.";
            exit;
        }

        $totalProcessed = 0;

        foreach ($patientSubscriptions as $subscription) {
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByID($subscription['patient_id']));
            $clinic = Clinic::clinicByID( $subscription['clinic_id'] );
            if (empty($clinic)) {
                echo "Invalid Clinic";
                exit;
            }

            $subscriptionDets = ClinicSubscription::getClinicSubscriptionById($subscription['clinic_id'],$subscription['renewal_plan_id']);
            if (empty($subscriptionDets)) {
                echo "Invalid Subscription";
                exit;
            }
            
            if ($clinic->stripe_connection_id == '' || $clinic->stripe_connection_id == null) {
                echo "Stripe not connected for this clinic";
                exit;
            }

            $userId = $patientDetails['user_id'];
            $userDetails = $this->Corefunctions->convertToArray(User::userByID($userId));
            $billingInfo = UserBilling::getUserBillingByUserId($userId);
            
            $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic->stripe_connection_id)->where('status', '1')->first();

            $amount = ($subscription['renewal_plan_tenure_type_id'] == 1) ? (float) str_replace(',', '', $subscriptionDets['monthly_amount']) : (float) str_replace(',', '', $subscriptionDets['annual_amount']);

            $userBalance = DB::table('users')->where('id', $patientDetails['user_id'])->value('account_balance');
            $usedBalance = 0;
            $amountToCharge = $amount;
            $input = array();

            if ($userBalance != null && $userBalance > 0) {
                if ($userBalance >= $amount) {
                    // Fully covered by balance
                    $usedBalance = $amount;
                    $amountToCharge = 0;
                    $balance = $userBalance-$usedBalance;

                    $paymentIntentId = null;
                    $transactionId = Payment::insertTransactions($paymentIntentId, $patientDetails['user_id'], $subscription['clinic_id']);

                    $stripe_fee = 0.00;
                    $platform_fee = 0.00;
                        
                    $stateID = (isset($patientDetails['user']['state_id']) && $patientDetails['user']['state_id'] !='') ? $patientDetails['user']['state_id'] : $patientDetails['state_id'];
                    $state = $this->Corefunctions->convertToArray(RefState::select('state_prefix', 'state_name', 'id')->where('id',$stateID)->whereNull('deleted_at')->first());
                    $patientDetails['state'] = (!empty($state) && isset($state['state_name'])) ? $state['state_name'] :( (isset($patientDetails['user']['state']) && $patientDetails['user']['state'] !='') ? $patientDetails['user']['state'] : $patientDetails['state_id'] );
                    $clinic = Clinic::select('stripe_connection_id','name','phone_number','address as billing_address','state as billing_state','city as billing_city','zip_code as billing_zip','country_id as billing_country_id','state_id','country_code','logo')->whereNull('deleted_at')->where('id', $subscription['clinic_id'])->first();

                    // inputParams
                    $inputParams = array();
                    /** Input datea for store to payment table */
                    $inputParams['billing_name'] = $patientDetails['first_name'].' '.$patientDetails['last_name'];
                    $inputParams['billing_email'] = $patientDetails['email'];
                    $inputParams['country_id'] = $patientDetails['country_code'];
                    $inputParams['phone_number'] = $patientDetails['phone_number'];
                    $inputParams['address'] = (isset($patientDetails['user']['address']) && $patientDetails['user']['address'] !='') ? $patientDetails['user']['address'] : $patientDetails['address'];
                    $inputParams['city'] =  (isset($patientDetails['user']['city']) && $patientDetails['user']['city'] !='') ? $patientDetails['user']['city'] : $patientDetails['city'];
                    $inputParams['zip'] =  (isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code'] !='') ? $patientDetails['user']['zip_code'] : $patientDetails['zip'];
                    $inputParams['state'] = $patientDetails['state'];
                    $inputParams['name_on_card'] = null;
                    $inputParams['card_number'] = null;
                    $inputParams['card_type'] = null;
                    $inputParams['expiry_year'] = null;
                    $inputParams['expiry_month'] = null;
                    $inputParams['stripe_fee'] = $stripe_fee;
                    $inputParams['platform_fee'] = $platform_fee;

                    $paymentDetails['stripe_customerid'] = $userDetails ['stripe_customer_id'];
                    $paymentDetails['stripe_paymentid'] = null;
                    $paymentDetails['card_id'] = null;
                    $paymentDetails['amount'] = $amount;
                    $paymentDetails['transactionid'] = isset($transactionId) ? $transactionId : null;

                    $inputParams['appntID'] = $subscriptionDets['id'];

                    $paymentKey = $this->Corefunctions->generateUniqueKey('10', 'payments', 'payment_uuid');

                    $paymentIds = Payment::savePaymentData($inputParams, $paymentKey, $patientDetails['user_id'], $paymentDetails, '1',$clinic,'subscription',$usedBalance);
                    
                    $cardDetails = array();
                } else {
                    // Partially covered by balance
                    $usedBalance = $userBalance;
                    $amountToCharge = $amount - $usedBalance;

                    $balance = 0;

                    // Charge remaining via card
                    $result = $this->Corefunctions->subscriptionPayment($stripeConnection->stripe_user_id,$patientDetails,$input,$amountToCharge,$subscription['clinic_id'],$subscriptionDets['id'],$usedBalance);

                    if (isset($result['status']) && $result['status'] == '0') {
                        $arr['error'] = 1;
                        $arr['errormsg'] = $result['message'];
                        return response()->json($arr);
                    }

                    $paymentIds = $result['paymentIds'];
                    $cardDetails = $result['cardDetails'];
                }
            } else {
                $currentAmount = (float) $subscription['amount']; // Current plan amount
                $newAmount = (float) $amount; // New plan amount (upgraded/downgraded)

                if ($currentAmount > $newAmount) {
                    $balance = round($currentAmount - $newAmount, 2);
                }
                // No balance at all, full charge
                $result = $this->Corefunctions->subscriptionPayment($stripeConnection->stripe_user_id,$patientDetails,$input,$amount,$subscription['clinic_id'],$subscriptionDets['id']);
                if (isset($result['status']) && $result['status'] == '0') {
                    $arr['error'] = 1;
                    $arr['errormsg'] = $result['message'];
                    return response()->json($arr);
                }

                $paymentIds = $result['paymentIds'];
                $cardDetails = $result['cardDetails'];
            }

            $historyId = PatientSubscription::insertPatientSubscriptionHistory($subscription['clinic_id'],$patientDetails['id'],$subscriptionDets,$paymentIds['id']);

            $patientSubscriptionDets = PatientSubscription::getPatientSubscriptionNew($subscription['clinic_id'],$patientDetails['id']);

            if(!empty($patientSubscriptionDets)){
                $monthlychecked = $patientSubscriptionDets['renewal_plan_tenure_type_id'] == '1' ? '1' : '0';
                PatientSubscription::updatePatientSubscription($patientSubscriptionDets['patient_subscription_uuid'],$subscription['clinic_id'],$subscriptionDets,$historyId,$monthlychecked);
            }
            $invoice = $this->Corefunctions->convertToArray(Invoice::getInvoiceByParentID($subscription['id']));
            
            Invoice::markAsPaid($invoice['id'], $paymentIds['id'],$paymentIds['receipt_num']);

            User::updateAccountBalance($patientDetails['user_id'],$balance);

            $totalProcessed++;
        }

        echo "Renewal Completed.<br/>Total Records: " . count($patientSubscriptions) . '<br/>Processed: ' . $totalProcessed;
        exit;
    }
    public function accountBalanceCheck($subscriptionDetails,$accountBalance,$invoiceID)
    {   
        $planDetails = SubscriptionPlan::getPlanById($subscriptionDetails['renewal_plan_id']);
       
        $amountToPay = $planDetails["amount"];
        $finalAmountToPay = $accountBalance > $amountToPay ? 0.00 : ($amountToPay - $accountBalance);
        $finalaccountBalance = $accountBalance > $amountToPay ? $accountBalance- $amountToPay   :  0.00;
     
        $planDetails = $this->Corefunctions->updateAccountBalance($subscriptionDetails['clinic_id'],$finalaccountBalance);
        
        Payment::updateInvoiceBalance($invoiceID,$finalAmountToPay);

        $data['finalAmountToPay'] = $finalAmountToPay;
        return $data;
    }


    public function removeUserConnection(){

        $lastID             = ( isset( $_REQUEST['lastid'] ) ) ? $_REQUEST['lastid'] : '0';
        /* get all softdeleted user connections */
        $userConnections     = $this->Corefunctions->convertToArray(DB::table('user_connections')->where('status','0')->whereNotNull('deleted_at')->orderBy('id','asc')->first());
        if( empty( $userConnections ) ){
            print "Completed";
            exit;
        }
        /* delete */
        if( !empty($userConnections) ){
            DB::table('user_connections')->where('id', $userConnections['id'])->delete();
        }
    
        $lastID     = $userConnections['id'];
        ?>
        <html>
            <body>
                <script>
                    var lastID = '<?php echo $lastID; ?>';
                    var redirectURL = '<?php echo url('removeuserconnection?lastid='.$lastID); ?>';
                    window.location.href = redirectURL;
                </script>
            </body>
        </html>
  
        <?php 
  
    }



    public function waitingList(){

    
        $lastID             = ( isset( $_REQUEST['lastid'] ) ) ? $_REQUEST['lastid'] : '0';

        /* get past appoinments in waiting list */
        $appointments     = $this->Corefunctions->convertToArray(DB::table('appointments')->whereDate('appointment_date', '<', Carbon::today())->where('reception_waiting','1')->whereNull('deleted_at')->orderBy('id','asc')->first());
        if( empty( $appointments ) ){
            print "Completed";
            exit;
        }
        /* update table */
        if( !empty($appointments) ){
            DB::table('appointments')->where('id',$appointments['id'])->update([
                'reception_waiting' => '0',
            ]);
        }
        $lastID     = $appointments['id'];
        ?>
        <html>
            <body>
                <script>
                    var lastID = '<?php echo $lastID; ?>';
                    var redirectURL = '<?php echo url('waitinglist?lastid='.$lastID); ?>';
                    window.location.href = redirectURL;
                </script>
            </body>
        </html>
  
        <?php 
  
    }


    /** update clinic users name */
    public function updateName(){

        $lastID             = ( isset( $_REQUEST['lastid'] ) ) ? $_REQUEST['lastid'] : '0';

        /* get clinic user details*/
        $clinicUser     = $this->Corefunctions->convertToArray(DB::table('clinic_users')->select('name','id')->whereNull('first_name')->orderBy('id','asc')->first());
        if( empty( $clinicUser ) ){
            print "Completed";
            exit;
        }
        /* update table */
        if( !empty($clinicUser) ){
            $nameParts = explode(' ', trim($clinicUser['name']), 2);
            $firstName = $nameParts[0];
            $secondName = isset($nameParts[1]) ? $nameParts[1] : null;

            
            DB::table('clinic_users')->where('id',$clinicUser['id'])->update([
                'first_name' =>  $firstName,
                'last_name' =>  $secondName,
            ]);
        }
        $lastID     = $clinicUser['id'];
        ?>
        <html>
            <body>
                <script>
                    var lastID = '<?php echo $lastID; ?>';
                    var redirectURL = '<?php echo url('updateclinicusername?lastid='.$lastID); ?>';
                    window.location.href = redirectURL;
                </script>
            </body>
        </html>
  
        <?php 
  
    }

    public function sendEndOfMonthInvoice()
    {
        $clinics = $this->Corefunctions->convertToArray(Clinic::getEprescribeEnabledClinics());
        if(!empty($clinics)){
            foreach ($clinics as $clinic) {
                $clinicUsers = $this->Corefunctions->convertToArray(ClinicUser::getEprescribeEnabledClinicUsers($clinic['clinic_id']));
                if(!empty($clinicUsers)){
                    $usercount = count($clinicUsers);
                    $addOnAmount = $this->Corefunctions->calculateAddOnAmount($clinicUsers,$clinic['clinic_id'],'0');
                    $nextMonth = Carbon::now()->addMonth();
                    $nextMonthName = $nextMonth->format('F Y');
                    $chargeDate = $nextMonth->startOfMonth()->format('M d, Y');
                    $amount = number_format($addOnAmount, 2);   
                    $notes = "Your invoice for the month of {$nextMonthName} is now available. You will be autocharged \${$amount} on {$chargeDate}.";
                    $itemnotes = "Monthly Fixed Charges for {$usercount} seats - {$nextMonthName}";

                    $billingInfo = UserBilling::getUserBilling($clinic['clinic_id']);
                    $countryCode   = RefCountryCode::getCountryCodeById($billingInfo['billing_country_id']);

                    $cardInfo = ClinicCard::getDefaultUserCard($clinic['clinic_id']);
                    $cardInfo['expiry'] = $cardInfo['exp_month'].'/'.$cardInfo['exp_year'];
 
                    $firstDayOfNextMonth = Carbon::now()->addMonth()->startOfMonth();
                    $firstDayOfNextMonth = $firstDayOfNextMonth->format('Y-m-d');
                    $id = Invoice::insertInvoice($clinic['clinic_id'],$addOnAmount,$usercount,$billingInfo,$notes,1,$firstDayOfNextMonth); 
                    InvoiceItem::insertInvoiceItem($id,$clinic['clinic_id'],$addOnAmount,$usercount,$itemnotes);      
                    
                    $toEmailUserDets = $this->Corefunctions->convertToArray(User::userByID($cardInfo['added_by']));
                    $invoiceDets = $this->Corefunctions->convertToArray(Invoice::getInvoiceById($id));
                    $data['name'] =  $toEmailUserDets['first_name'];
                    $data['email'] =  $toEmailUserDets['email'];
                    $data['invoiceNumber'] =  $invoiceDets['invoice_number'];
                    $data['billingInfo'] =  $billingInfo;
                    $data['cardInfo'] =  $cardInfo;
                    $data['notes'] = $notes;
                    $data['countryCode'] = $countryCode;
                    $this->Corefunctions->sendmail($data, 'Your ePrescribe Invoice for '.$nextMonthName, 'emails.next_month_invoice');
                }    
            }
            print "ePrescribe Invoice Generation Completed.";
            exit;
        }
    }

    public function autoChargeInvoices(){
        $invoices = $this->Corefunctions->convertToArray(Invoice::getUnpaidInvoicesForCurrentMonth());

        if (!empty($invoices)) {
            foreach ($invoices as $invoice) {
                $cardInfo = ClinicCard::getDefaultUserCard($invoice['parent_id']);
                $billingInfo = UserBilling::getUserBilling($invoice['parent_id']);
                $countryCode   = RefCountryCode::getCountryCodeById($billingInfo['billing_country_id']);
                $cardInfo = ClinicCard::getDefaultUserCard($invoice['parent_id']);
                $cardInfo['expiry'] = $cardInfo['exp_month'].'/'.$cardInfo['exp_year'];
                $nextMonth = Carbon::now()->addMonth();
                $nextMonthName = $nextMonth->format('F Y');

                $toEmailUserDets = $this->Corefunctions->convertToArray(User::userByID($cardInfo['added_by']));

                $result = $this->Corefunctions->submitPayment($invoice['parent_id'],$invoice['grandtotal']);

                if (isset($result['status']) && $result['status'] == '0') {
                    $data['name'] =  $toEmailUserDets['first_name'];
                    $data['email'] =  $toEmailUserDets['email'];
                    $data['nextMonthName'] =  $nextMonthName;
                    $data['invoiceNumber'] =  $invoice['invoice_number'];
                    $data['billingInfo'] =  $billingInfo;
                    $data['cardInfo'] =  $cardInfo;
                    $this->Corefunctions->sendmail($data, 'Your ePrescribe Renewal for '.$nextMonthName.' Failed', 'emails.next_month_invoice_failure');
                }else{
                    Invoice::markAsPaid($invoice['id'], $result['paymentIds']['id'],$result['paymentIds']['receipt_num']);

                    $clinicUsers = $this->Corefunctions->convertToArray(ClinicUser::getEprescribeEnabledClinicUsers($invoice['parent_id']));
                    if(!empty($clinicUsers)){
                        foreach($clinicUsers as $clinicuser){
                            DB::table('invoice_users')->insertGetId(array(
                                'invoice_id' => $invoice['id'],
                                'eprescriber_id' => $clinicuser['eprescriber_id'],
                                'status' => '1',
                                'created_at' => Carbon::now(),
                            ));
                        }
                    }

                    /* Update end date */
                    $endDate = date('Y-m-01', strtotime('+1 month'));
                    DB::table('clinic_addons')->where('clinic_id',$invoice['parent_id'])->whereNull('deleted_at')->update(array(
                        'end_date' => $endDate,
                        'updated_at' => Carbon::now(),
                    ));
                    
                    $data['name'] =  $toEmailUserDets['first_name'];
                    $data['email'] =  $toEmailUserDets['email'];
                    $data['nextMonthName'] =  $nextMonthName;
                    $data['invoiceNumber'] =  $invoice['invoice_number'];
                    $data['billingInfo'] =  $billingInfo;
                    $data['cardInfo'] =  $cardInfo;
                    $this->Corefunctions->sendmail($data, 'Your ePrescribe Has Been Renewed for '.$nextMonthName, 'emails.next_month_invoice_success');
                }
            }
        }

        print "ePrescribe Monthly Payment Completed.";
        exit;
    }


    /** update clinic users name */
    public function clinicCode(){

        $lastID             = ( isset( $_REQUEST['lastid'] ) ) ? $_REQUEST['lastid'] : '0';

        /* get clinic user details*/
        $clinicUser     = $this->Corefunctions->convertToArray(DB::table('clinic_users')->select('first_name','last_name','id','clinic_id')->whereNull('clinic_code')->orderBy('id','asc')->first());
        if( empty( $clinicUser ) ){
            print "Completed";
            exit;
        }
        /* update table */
        if( !empty($clinicUser) ){
            $cliniData = $this->Corefunctions->convertToArray(Clinic::select('name')->where('id', $clinicUser['clinic_id'])->first());
            $name= $clinicUser['first_name'].' '. $clinicUser['last_name'];
            $clinic_code = $this->Corefunctions->generateClinicianCode($cliniData['name'],$name);

            DB::table('clinic_users')->where('id',$clinicUser['id'])->update([
                'clinic_code' =>  $clinic_code,
              
            ]);
        }
        $lastID     = $clinicUser['id'];
        ?>
        <html>
            <body>
                <script>
                    var lastID = '<?php echo $lastID; ?>';
                    var redirectURL = '<?php echo url('clinicCode?lastid='.$lastID); ?>';
                    window.location.href = redirectURL;
                </script>
            </body>
        </html>

        <?php 

    }


     /** update clinic users name */
     public function patientName(){

        $lastID             = ( isset( $_REQUEST['lastid'] ) ) ? $_REQUEST['lastid'] : '0';

        /* get clinic user details*/
        $clinicUser     = $this->Corefunctions->convertToArray(DB::table('patients')->select('name','id')->whereNull('first_name')->orderBy('id','asc')->first());
        if( empty( $clinicUser ) ){
            print "Completed";
            exit;
        }
        /* update table */
        if( !empty($clinicUser) ){
            $nameParts = explode(' ', trim($clinicUser['name']), 2);
            $firstName = $nameParts[0];
            $secondName = isset($nameParts[1]) ? $nameParts[1] : null;

            
            DB::table('patients')->where('id',$clinicUser['id'])->update([
                'first_name' =>  $firstName,
                'last_name' =>  $secondName,
            ]);
        }
        $lastID     = $clinicUser['id'];
        ?>
        <html>
            <body>
                <script>
                    var lastID = '<?php echo $lastID; ?>';
                    var redirectURL = '<?php echo url('updatepatientname?lastid='.$lastID); ?>';
                    window.location.href = redirectURL;
                </script>
            </body>
        </html>
  
        <?php 
  
    }
    public function rpmInvoice(){
        
        $rpmPatients   = Patient::getRpmPatients();
        $rpmPatients   = $this->Corefunctions->getArrayIndexed1($rpmPatients, 'user_id');

        $userIDS     = $this->Corefunctions->getIDSfromArray($rpmPatients, 'user_id');
        $reportDate  = date('Y-m-d'); // today's date
        $invDate     = date('Y-m-d', strtotime('last day of -1 month', strtotime($reportDate)));
        $invDate     = date('Y-m-d', strtotime('last day of this month', strtotime($reportDate)));;
        $monthName = date('F', strtotime($invDate));
        $year      = date('Y', strtotime($invDate));

        $rpmOrders   = RpmOrders::getDeliveredOrders($userIDS,'4',$invDate);
        $rpmOrders   = $this->Corefunctions->getArrayIndexed1($rpmOrders, 'id');

        /* Ordered Devices */
        $orderIDS        = $this->Corefunctions->getIDSfromArray($rpmOrders, 'id');
        $rpmOrderDevices = RpmOrders::getDeliveredOrderDevices($orderIDS,'4');
        
        /* Devices */
        $deviceIDS       = $this->Corefunctions->getIDSfromArray($rpmOrderDevices, 'rpm_device_id');
        $devices         = RpmOrders::rpmDeviceByIDS($deviceIDS);
        
        if( !empty($rpmOrderDevices) ){
            foreach( $rpmOrderDevices as $dvo){
                if( isset($rpmOrders[$dvo['rpm_order_id']])){
                    $rpmOrders[$dvo['rpm_order_id']]['devices'][] = $dvo;
                }
            }
        }
        $billingInfos            = UserBilling::getUserBillingByUserIds($userIDS);
        $billingInfos            = $this->Corefunctions->getArrayIndexed1($billingInfos, 'user_id');
        $billingCountryIDS       = $this->Corefunctions->getIDSfromArray($billingInfos, 'billing_country_id');

        
        $autoChargeDate = date('Y-m-d',strtotime('first day of +1 month'));
        
        $cardInfos   = PatientCard::getDefaultUserCards($userIDS);
        $cardInfos   = $this->Corefunctions->getArrayIndexed1($cardInfos, 'user_id');
        
        $countryCodes   = RefCountryCode::getCountryCodeByIDS($billingCountryIDS);
        
        if( !empty($rpmOrders) ){
            foreach( $rpmOrders as $odv){
                if( isset($odv['devices']) && !empty($odv['devices'])){
                    $perMonthAmount = 0;
                    foreach( $odv['devices'] as $dv){
                        if( isset( $devices[$dv['rpm_device_id']] ) ){
                            $perMonthAmount += $devices[$dv['rpm_device_id']]['per_month_amount'];
                        }
                    }

                    $billingInfo = ( !empty($billingInfos) && isset($billingInfos[$odv['user_id']]) ) ? $billingInfos[$odv['user_id']] :  array();
                    if( !empty($billingInfo)){
                        $countryCode =  ( !empty($countryCodes) && isset($countryCodes[$billingInfo['billing_country_id']]) ) ? $countryCodes[$billingInfo['billing_country_id']] : array(); 
                        $perMonthAmount = (float) str_replace(',', '', $perMonthAmount); 
                        $notes          = "Payment for device order : ".$odv['order_code'];

                        $id         = Invoice::insertInvoice($odv['id'],$perMonthAmount,'0',$billingInfo,$notes,4,$autoChargeDate); 
                        InvoiceItem::insertInvoiceItem($id,$odv['clinic_id'],$perMonthAmount,'0',$notes);
                        $userDets = ( isset($rpmPatients[$odv['user_id']] ) ) ? $rpmPatients[$odv['user_id']] : array();
                        $autoChargeFormat = date('m/d/Y', strtotime( $autoChargeDate));

                        $mailNotes      = "Your invoice for the month of {$year} {$monthName}  is now available. You will be autocharged \${$perMonthAmount} on {$autoChargeFormat}.";

                        $cardInfo = ( !empty($cardInfos) && isset($cardInfos[$odv['user_id']] ) ) ? $cardInfos[$odv['user_id']] : array(); 


                        $invoiceDets            = $this->Corefunctions->convertToArray(Invoice::getInvoiceById($id));
                        $data['name']           =  $userDets['first_name'].' '.$userDets['last_name'];
                      //  $data['email']          = $userDets['email'];
                        $data['email']          = "tessy@swizzleup.com";
                        $data['invoiceNumber']  = $invoiceDets['invoice_number'];
                        $data['billingInfo']    = $billingInfo;
                        $data['cardInfo']       = $cardInfo;
                        $data['notes']          = $mailNotes;
                        $data['countryCode']    = $countryCode;
                        $emailBody = view('emails.rpminvoice', $data)->render();

                  

                        $this->Corefunctions->sendmail($data, 'Your rpm invoice for '.$monthName, 'emails.rpminvoice');
                    }

                }
            }
        }

        print "<pre>";
        print_r($rpmOrders);
        print_r($devices);
        exit;
    }
    
    public function rpmDebitAmount(){
        $reportDate  = date('Y-m-d');
        $rpmInvoices = RpmOrders::getRpmInvoices($reportDate,'4','1');
        $orderIDS    = $this->Corefunctions->getIDSfromArray($rpmInvoices,'parent_id');
        $orders      = RpmOrders::orderByIDS($orderIDS);
        $orders = $this->Corefunctions->getArrayIndexed1($orders, 'id');


        $clinicIDS = $this->Corefunctions->getIDSfromArray($orders,'clinic_id');
        $userIDS = $this->Corefunctions->getIDSfromArray($orders,'user_id');
        $patients =  $this->Corefunctions->convertToArray(Patient::getPatientsByUserIds($userIDS));
        $patients = $this->Corefunctions->getArrayIndexed1($patients, 'user_id');


        $clinics =  Clinic::clinicByIDS($clinicIDS);
    
        if( !empty($rpmInvoices)){
            foreach( $rpmInvoices as $rpm){
                if( !empty($orders) && isset($orders[$rpm['parent_id']])){
                    $rpmOrder= $orders[$rpm['parent_id']];
                    if( !empty($rpmOrder) && isset($clinics[$rpmOrder['clinic_id']])){
                        $clinic = $clinics[$rpmOrder['clinic_id']];
                        $stripeConnection = DB::table('stripe_connections')->select('stripe_user_id')->whereNull('deleted_at')->where('id', $clinic['stripe_connection_id'])->where('status', '1')->first();
                        if( !empty($stripeConnection)){
                            $patientDetails = ( isset($patients[$rpmOrder['user_id']]) ) ? $patients[$rpmOrder['user_id']] : array();

                            $result = $this->Corefunctions->deviceOrderPayment($stripeConnection->stripe_user_id,$patientDetails,array(),$rpm['grandtotal'],$clinic['id'],$rpm['id']);
                           
                        }

                    }
                }
                 
              
            }
        }
        print "<pre>";
        print_r($rpmInvoices);
        exit;
    }

    



}
