<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use DB;
use Carbon\Carbon;
use File;
use Spatie\PdfToText\Pdf;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;


class PdfController extends Controller
{
    public function __construct()
    {

        $this->Corefunctions = new \App\customclasses\Corefunctions;
        // Middleware for session check
       
    }

    public function uploadFile()
    {
        if (!Session::has('user')) {
            // Redirect to login page if session does not exist
            return Redirect::to('/login'); // Adjust the URL to your login route
        }

        $seo['title'] = "Dashboard | " . env('APP_NAME');
        return view('files.uploadfile', compact('seo'));
    }
    public function extractFile(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048', // 2MB max file size
        ]);

        // Handle the uploaded file
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');

            // Generate a unique file name using the file's hash (to identify duplicates)
            $hash = md5_file($file->getRealPath()); // Generate a hash based on the file content
            $fileName = $hash . '_extracted_text.txt';
            $filePathToSave = storage_path('app/public/' . $fileName); // Path to save the text file

            // Check if the file already exists
            if (file_exists($filePathToSave)) {
                unlink($filePathToSave); // Delete the existing file
            }


            // Extract text from the PDF
            $pdfParser = new Parser(); // Create a new parser instance
            $pdf = $pdfParser->parseFile($file->getRealPath()); // Parse the uploaded file directly
            $text = $pdf->getText(); // Get the text from the PDF

            // Save the extracted text to a .txt file
            file_put_contents($filePathToSave, $text); // Save the new file

            return view('files.dataextraction', [
                'text' => $text,  // Pass extracted text
                'file_path' => asset('storage/' . $fileName),  // Pass file path
            ]);

        }

        return response()->json(['error' => 'Uploaded valid file.'], 400);
    }

 

}
