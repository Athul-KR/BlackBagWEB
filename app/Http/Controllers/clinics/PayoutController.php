<?php

namespace App\Http\Controllers\clinics;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use DB;
use Carbon\Carbon;
use File;
use Spatie\PdfToText\Pdf;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Payment;

class PayoutController extends Controller
{
    public function __construct()
    {

        $this->Corefunctions = new \App\customclasses\Corefunctions;
        $this->middleware(function ($request, $next) {
            if (Session::has('user') && session()->get('user.userType') == 'patient') {
                return Redirect::to('/');
            }
            // Check if the session has the 'user' key (adjust as per your session key)
            $sessionCeck = $this->Corefunctions->validateUser();
            if (!$sessionCeck) {
                return Redirect::to('/logout');
            }
            if (!Session::has('user')) {
                // Redirect to login page if session does not exist
                return Redirect::to('/login'); // Adjust the URL to your login route
            }
            return $next($request);
        });
       
    }

    public function list(Request $request, $status = 'active')
    {
        if(session()->get('user.userType') == 'patient'){
            return Redirect::to('/dashboard'); // Adjust the URL to your login route
        }
      
        $limit = (isset($_GET['limit']) && ($_GET['limit'] != '')) ? $_GET['limit'] : 10;
        $startDate = (isset($_GET['startDate']) && ($_GET['startDate'] != '')) ? date('Y-m-d',strtotime($_GET['startDate'])) : '';
        $endDate = (isset($_GET['endDate']) && ($_GET['endDate'] != '')) ? date('Y-m-d',strtotime($_GET['endDate'])) : '';
        $patients = (isset($_GET['patient']) && ($_GET['patient'] != '')) ? $_GET['patient'] : '';

        $paymentDetails = Payment::getPayouts($startDate,$endDate,$limit) ;
        $paymentData    = $paymentDetails['paymentData'] ;
        $paymentDetails = $paymentDetails['paymentDetails'] ;
        
        /** get appointment Ids */
        $appintIds = $this->Corefunctions->getIDSfromArray($paymentData['data'], 'parent_id');
        
        $appointment = Appointment::with(['consultant','patient','consultantClinicUser','patientUser'])->whereIn('id', $appintIds);
        /** filter by patient */
        $appointmentWithPatients = $appointment->get();
        $appointmentWithPatients = $this->Corefunctions->convertToArray($appointmentWithPatients);

        if($patients!=''){
            $patientDetails = $this->Corefunctions->convertToArray(Patient::patientByUUID($patients));
            $appointment =$appointment->where('patient_id',$patientDetails['id']);
            
            
        }
        $appointment = $appointment->get();
        $appointment = $this->Corefunctions->convertToArray($appointment);
        $appointment = $this->Corefunctions->getArrayIndexed1($appointment, 'id');

        /** get patient details */
        $patientIds = $this->Corefunctions->getIDSfromArray($appointmentWithPatients, 'patient_id');
        $patientDetails = $this->Corefunctions->convertToArray(Patient::getPatientByUserID($patientIds,session()->get('user.clinicID')));
        
        $seo['title']           = "Payouts | " . env('APP_NAME');
        $seo['keywords']        = "Online Appointments, In-person Appointments, Book Patient Appointments, Doctor Consultation Booking, Schedule Appointment Online, Healthcare Appointment Management, Appointment Booking System, Real-Time Appointment Updates, Flexible Appointment Scheduling, Create Appointment Easily, Book Doctor Appointments Easily, Track Appointments Effortlessly";
        $seo['description']     = "Streamline your healthcare management with our easy-to-use appointment booking system. Whether you’re scheduling online or in-person appointments, track all patient consultations, doctor availability, appointment dates and times, and status updates";                  
        $seo['og_title']        = "Appointments | " . env('APP_NAME');
        $seo['og_description']  = "Streamline your healthcare management with our easy-to-use appointment booking system. Whether you’re scheduling online or in-person appointments, track all patient consultations, doctor availability, appointment dates and times, and status updates"; 

        return view('payouts.listing', compact('paymentData', 'appointment','seo','status','paymentDetails','limit','startDate','endDate','patientDetails'));
    }
    

 

}
