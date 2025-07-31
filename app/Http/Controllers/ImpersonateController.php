<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\ClinicUser;
use App\Models\Impersonate;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    public function __construct()
    {

        $this->Corefunctions = new \App\customclasses\Corefunctions;
    }

    public function handleImpersonation(Request $request, $token)
    {
        // $token = $request->query('token');

        if (!$token) {
            return redirect()->route('login')
                ->with('error', 'Invalid impersonation request');
        }

        // Get impersonation data 
        $impersonateData = Impersonate::getImpersonateData($token);

        if (!$impersonateData) {
            return redirect()->route('login')
                ->with('error', 'Invalid or expired impersonation token');
        }

        $user = Impersonate::getImpersonateUser($impersonateData);

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'User not found');
        }

        // Check if user is already logged in
        if (session()->has('user')) {

            return view('force-logout', compact('token'));
        }


        if ($user['last_login_clinic_id'] != NULL) {

            $clinicUserDetails = ClinicUser::getClinicUserWithUsers($this->Corefunctions->convertToArray($user));

            if (empty($clinicUserDetails)) {
                $response = $this->checkPatientDetails($this->Corefunctions->convertToArray($user), $input = null);
                $impersonateData->update(['is_used' => '1']);
                return redirect()->route('frontend.myAppointments')
                    ->with('success', 'You are now impersonating this user');
            }
        } else {
            $response = $this->checkPatientDetails($this->Corefunctions->convertToArray($user), $input = null);
            $impersonateData->update(['is_used' => '1']);
            return redirect()->route('frontend.myAppointments')
                ->with('success', 'You are now impersonating this user');
        }


        $patientID = $clinicId = '';
        $user_type                      = !empty($clinicUserDetails) && $clinicUserDetails['user_type_id'] == '2' ? 'doctor' : (!empty($clinicUserDetails) && $clinicUserDetails['user_type_id'] == '3' ? 'nurse' : 'clinics');
        $clinicId                       = !empty($clinicUserDetails) ? $clinicUserDetails['clinic_id'] : '';
        $logoPath                       = (isset($user['profile_image']) && $user['profile_image'] != '') ?  $this->Corefunctions->resizeImageAWS($user['id'], $user['profile_image'], $user['first_name'], 180, 180, '1') : '';
        $clinicuuid                     = !empty($clinicUserDetails) ? $clinicUserDetails['clinic_user_uuid'] : '';
        $user['profile_image']          = $logoPath;
        $clinicUserDetails['name']      = $user['first_name'];
        $user['first_name']             = $this->Corefunctions->showClinicanName($clinicUserDetails, '1');
        $clinicId                       = ($user['last_login_clinic_id'] != '') ? $user['last_login_clinic_id'] : $clinicId;
        $clinicAdmin                    = ((!empty($clinicUserDetails) && $clinicUserDetails['is_clinic_admin'] == '1') || $user_type == 'clinics')  ? 1 : 0;

        $clinicDetails = Clinic::clinicByID($clinicId);
        $clinicDetails = $this->Corefunctions->convertToArray($clinicDetails);

        if (empty($clinicDetails)) {

            return redirect()->route('login')
                ->with('error', 'Clinic not found');
        }

        // Code Fix Required | Stripe Connected cannot be set to 1 - Done   /** check for stripe connection */
        $stripe_connected = (!empty($clinicUserDetails) && $clinicAdmin == 1) && ($clinicDetails['stripe_connection_id'] != null || $clinicDetails['stripe_connection_id'] != 0) ? 1 : 0;

        //Store session 
        $sessionData = $this->Corefunctions->setSessionData($user, $clinicDetails, $user_type, $clinicuuid, $stripe_connected, $clinicId, $clinicAdmin);


        Auth::login($user);
        $impersonateData->update(['is_used' => '1']);
        return redirect()->route('dashboard')
            ->with('success', 'You are now impersonating this user');
    }


    public function forceLogout()
    {

        $token = request('token');

        if (!$token) {

            return response()->json([
                'error' => true,
                'message' => 'Invalid or expired impersonation token',
            ]);
        }

        $frontendUrl = route('impersonate.handle', ['token' => $token]);

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return response()->json([
            'success' => true,
            'redirect_url' => $frontendUrl,
            'message' => 'Logout success',
        ]);
    }




    private function checkPatientDetails($userDetails, $input)
    {

        $patientsDetails = Patient::getPatientWithClinic($userDetails["id"]);

        if (empty($patientsDetails)) {
            return redirect()->route('login')
                ->with('error', 'User not found');
        }

        if (!empty($patientsDetails)) {

            $clinicDetails = [
                'name'        => $patientsDetails['name'],
                'clinic_uuid' => $patientsDetails['clinic_uuid'],
                'logo'        => $patientsDetails['logo'],
            ];

            $clinicId                     = isset($patientsDetails['clinic_id']) ? $patientsDetails['clinic_id'] : '';
            $patientID                    = $patientsDetails['patientID'];
            $patient_uuid                 = $patientsDetails['patients_uuid'];
            $logoPath                     = (isset($userDetails['profile_image']) && $userDetails['profile_image'] != '') ? $this->Corefunctions->resizeImageAWS($userDetails['id'], $userDetails['profile_image'], $userDetails['first_name'], 180, 180, '1') : '';
            $userDetails['profile_image'] = $logoPath;
        }
        $sessionData = $this->Corefunctions->setSessionData($userDetails, $clinicDetails, 'patient', $patient_uuid, 0, $clinicId, 0, $patientID);
        $this->Corefunctions->attachDefaultFolders($userDetails["id"]);
    }
}
