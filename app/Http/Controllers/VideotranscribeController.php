<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\VideoCall;
use App\Models\Appointment;
use App\Models\VideoCallTranscriptFile;
use App\Models\Patient;
use App\Models\UserConnection;
use App\customclasses\Corefunctions;
use Carbon\Carbon;

class VideotranscribeController extends Controller
{
    protected $Corefunctions;

    public function __construct(Request $request)
    {
        $this->Corefunctions = new Corefunctions;
    }

    public function handleEvent()
    {
        $inputfileData = file_get_contents('php://input');
        $jsonData = json_decode($inputfileData, true);

        // Zoom URL validation
        if ($jsonData['event'] === 'endpoint.url_validation') {
            $plainToken = $jsonData['payload']['plainToken'];
            $encryptedToken = hash_hmac('sha256', $plainToken, env('VIDEOSCRIBE_SECRET'));

            return response()->json([
                'plainToken' => $plainToken,
                'encryptedToken' => $encryptedToken,
            ]);
        }

        $sessionName = $jsonData['payload']['object']['session_name'] ?? null;
        $downloadUrl = $jsonData['payload']['object']['recording_files'][0]['download_url'] ?? null;
        $downloadToken = $jsonData['download_token'] ?? null;

        if (!$sessionName || !$downloadUrl || !$downloadToken) {
            return response()->json(['error' => 'Missing required data'], 400);
        }

        // Build download URL
        $urlWithToken = $downloadUrl . "?access_token=" . urlencode($downloadToken);

        // Get associated video call
        $videocall = VideoCall::getvideoCallByRoomID($sessionName);

        if (!$videocall) {
            return response()->json(['error' => 'Video call not found'], 404);
        }

        // Prepare input for DB insert
        $video_call_file_uuid = $this->Corefunctions->generateUniqueKey(8, 'video_call_transcript_files', 'video_call_file_uuid');

        $input = [
            'transcript_data' => $inputfileData,
            'call_id' => $videocall->id,
            'appointment_id' => $videocall->appointment_id,
            'video_call_file_uuid' => $video_call_file_uuid,
        ];

        $videoCallTranscriptFileID = VideoCallTranscriptFile::insertVideoCallTranscriptFile($input);

        // Update appointment status
        Appointment::updateTranscriptFileAdded($videocall->appointment_id, '0');

        // Prepare AWS upload path
        $awsPath = $this->Corefunctions->getMyPathForAWS(
            $videoCallTranscriptFileID,
            $video_call_file_uuid,
            'vtt',
            'uploads/videotranscript/'
        );

        $filename = $video_call_file_uuid . '.vtt';

        // Download and save file using cURL
        $ch = curl_init($urlWithToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $content = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json(['error' => 'cURL Error: ' . curl_error($ch)], 500);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $content) {
            $this->Corefunctions->uploadDocumenttoAWSPrivate($awsPath, $content);
            VideoCallTranscriptFile::updateVideoCallTranscriptFile($videoCallTranscriptFileID, $awsPath);
            return response()->json(['success' => 1, 'message' => "File saved successfully to: $awsPath"]);
        } else {
            return response()->json(['error' => "Failed to download. HTTP Status: $httpCode"], 500);
        }
    }

    public function getZoomAccessToken($clientId, $clientSecret, $accountId)
    {
        $url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=$accountId";

        $headers = [
            "Authorization: Basic " . base64_encode("$clientId:$clientSecret"),
            "Content-Type: application/x-www-form-urlencoded"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $data = json_decode($response, true);
        return $data['access_token'] ?? null;
    }
}
