<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Aws\TranscribeService\TranscribeServiceClient;
use Illuminate\Support\Str;

class HealthScribeController extends Controller
{
    public function transcribe(Request $request)
    {
        $request->validate([
        'audio' => 'required|file|mimetypes:audio/webm,audio/wav,audio/ogg,video/webm'
    ]);
        $uuid = Str::uuid();
        $path = "livechunks/{$uuid}.wav";
        $localPath = $request->file('audio')->storeAs('public', $path);
        $filePath = storage_path("app/{$localPath}");

        // Wait briefly for Laravel to finish writing the file
        $tries = 0;
        while (!file_exists($filePath) && $tries < 10) {
            usleep(100000); // wait 100ms
            $tries++;
        }

        // Optional: check if still doesn't exist
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File was not saved successfully.'], 500);
        }
        $s3 = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);

        $bucket = env('AWS_BUCKET');

        $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $path,
            'SourceFile' => $filePath,
            'ACL' => 'private'
        ]);

        $mediaUrl = $s3->getObjectUrl($bucket, $path);

        $transcribe = new TranscribeServiceClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);

        $jobName = 'chunk-' . $uuid;

        $transcribe->startMedicalTranscriptionJob([
            'MedicalTranscriptionJobName' => $jobName,
            'LanguageCode' => 'en-US',
            'MediaFormat' => 'wav',
            'Media' => ['MediaFileUri' => $mediaUrl],
            'OutputBucketName' => $bucket,
            'Specialty' => 'PRIMARYCARE',
            'Type' => 'DICTATION',
        ]);

        sleep(6); // Small wait for job to complete

        $result = $transcribe->getMedicalTranscriptionJob([
            'MedicalTranscriptionJobName' => $jobName
        ]);

        if ($result['MedicalTranscriptionJob']['TranscriptionJobStatus'] === 'COMPLETED') {
            $uri = $result['MedicalTranscriptionJob']['Transcript']['TranscriptFileUri'];
            $json = json_decode(file_get_contents($uri), true);
            $text = $json['results']['transcripts'][0]['transcript'] ?? '';
            return response()->json(['transcription' => $text]);
        }

        return response()->json(['transcription' => null]);
    }
}