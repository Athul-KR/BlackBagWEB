<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\clinics\DashboardController;
use App\Http\Controllers\clinics\DoctorsController;
use App\Http\Controllers\clinics\NurseController;
use App\Http\Controllers\clinics\PatientController;
use App\Http\Controllers\clinics\AppointmentController;
use App\Http\Controllers\clinics\MeetController;
use App\Http\Controllers\clinics\UserController;
use App\Http\Controllers\clinics\PaymentController;
use App\Http\Controllers\clinics\PayoutController;
use App\Http\Controllers\clinics\NotificationController;
use App\Http\Controllers\clinics\NotesController;
use App\Http\Controllers\clinics\LabsController;
use App\Http\Controllers\clinics\ImagingController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\frontend\PatientChatController;
use App\Http\Controllers\frontend\InTakeFormController;
use App\Http\Controllers\frontend\MyAccountsController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\SocketrequestController;
use App\Http\Controllers\VideotranscribeController;
use App\Http\Controllers\clinics\OnboardingController;
use App\Http\Controllers\clinics\DoctorOnboardingController;
use App\Http\Controllers\clinics\RevenueReportController;

use App\Http\Controllers\clinics\RpmController;
use App\Http\Controllers\clinics\DeviceController;
use App\Http\Controllers\clinics\PrescriptionController;
use App\Http\Controllers\clinics\ChatController;
use App\Http\Controllers\WebhookController;

define('TEMPDOCPATH', 'assets/tempDocs/');
define('SAMPLEPATH', 'assets/sampledocs/');
define('TITLE', 'BlackBag');
define('DEFAULTIMG', asset('images/default_img.png'));
define('INITIALSASSETPATH', 'assets/initials/');

define('GRACE_PERIOD', '2');
define('APPLICATION_FEE', '5');


use App\Http\Controllers\HealthScribeController;

Route::view('/healthscribe', 'appointment/notes/healthscribe');
Route::post('/healthscribe/live', [HealthScribeController::class, 'transcribe']);


Route::get('/runmigrate', function () {
    Artisan::call("migrate");
});

Route::get('/runseeder', function () {
   // Artisan::call('db:seed', ['--class' => 'RefSourceTypeSeeder']);
  //  Artisan::call('db:seed', ['--class' => 'AddonsSeeder']);
  //  Artisan::call('db:seed', ['--class' => 'RefUserTypes']);
   // Artisan::call('db:seed', ['--class' => 'RefUserParticipantTypes']);
    Artisan::call('db:seed', ['--class' => 'GenericSubscriptionSeeder']);
    // Artisan::call('db:seed', ['--class' => 'GenericSubscriptionSeeder']);
    // Artisan::call('db:seed', ['--class' => 'RefMedicationDispenseUnitSeeder']);
    // Artisan::call('db:seed', ['--class' => 'RefStatesSeeder']);
    // Artisan::call('db:seed', ['--class' => 'RefMedicationDispenseUnitSeeder']);
    // Artisan::call('db:seed', ['--class' => 'RefStrengthUnitSeeder']);
    // Artisan::call('db:seed', ['--class' => 'RefStrengthUnitSeeder']);
    //  Artisan::call('db:seed', ['--class' => 'RefInvoiceTypeSeeder']);
});

//Impersonate
Route::get('/impersonate/{token}', [ImpersonateController::class, 'handleImpersonation'])->name('impersonate.handle');
Route::post('/impersonate/force-logout', [ImpersonateController::class, 'forceLogout'])->name('impersonate.forceLogout');
//Route::post('track/socketrequest',[SocketrequestController::class, 'handleWSSEvent']); 
Route::get('clinic/onboarding',[AuthController::class, 'onBoarding']); 
Route::get('clinic/startonboard',[AuthController::class, 'startonBoarding']); 

Route::post('update/socketEvent',[AuthController::class, 'socketEvent']); 
/** Fronend urls */
// Route::get('/{type}/login', [AuthController::class, 'login'])->name('frontend.login');

Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/getstarted', [FrontendController::class, 'landingPage'])->name('frontend.landingpage');
Route::get('/for-doctors', [FrontendController::class, 'forDoctors'])->name('frontend.forDoctors');
Route::get('/find-doctors', [FrontendController::class, 'findDoctorsAndClinics'])->name('frontend.findDoctorsAndClinics');
Route::get('/contact-us', [FrontendController::class, 'contactUs'])->name('frontend.contactUs');
Route::get('/webhook/view', [FrontendController::class, 'viewWebhook'])->name('frontend.viewWebhook');
Route::get('/idpsuccess', [FrontendController::class, 'idpSuccess'])->name('frontend.idpSuccess');
// Route::get('/contact-us', function () {
//     return view('frontend.contact-us');
// })->name('frontend.contactUs');

// Route::get('/privacy-policy', function () {
//     return view('frontend.privacy-policy');
// })->name('frontend.privacyPolicy');
// Route::get('/terms-and-conditions', function () {
//     return view('frontend.terms-and-condition');
// })->name('frontend.termsAndCondition');

Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('frontend.privacyPolicy');
Route::get('/terms-and-conditions', [FrontendController::class, 'termsConditions'])->name('frontend.termsAndCondition');

Route::post('/contact-us-store', [FrontendController::class, 'storeContactUs'])->name('frontend.storeContactUs');
Route::get('/for-clinics', [FrontendController::class, 'forClinics'])->name('frontend.forClinics');
Route::get('/pricing', [FrontendController::class, 'pricing'])->name('frontend.pricing');

Route::get('/clinicprofile', [FrontendController::class, 'clinicProfile'])->name('frontend.clinicProfile');
Route::get('/tourism-profile', [FrontendController::class, 'tourismProfile'])->name('frontend.tourismProfile');
Route::post('/myappointments', [FrontendController::class, 'myAppointments'])->name('frontend.myAppointments');
Route::get('/myappointments', [FrontendController::class, 'myAppointmentsTemplate'])->name('frontend.myAppointmentsTemplate');
Route::get('/search-results', [FrontendController::class, 'searchResults'])->name('frontend.searchResults');
Route::get('/view-profile', [FrontendController::class, 'viewProfile'])->name('frontend.viewProfile');
Route::post('/profileUpdate', [FrontendController::class, 'profileUpdate'])->name('frontend.profileUpdate');
Route::post('/getcards', [FrontendController::class, 'getCards'])->name('frontend.getcards');
Route::post('/create-phonechange', [FrontendController::class, 'showPhoneNumberModal'])->name('frontend.showPhoneNumberModal');
Route::post('/get-note', [FrontendController::class, 'getNotes'])->name('frontend.getNote');
Route::post('getstripeclientsecret',[PaymentController::class,'getStripeClientSecret']);
Route::post('getclinicstripeclientsecret',[PaymentController::class,'getClinicStripeClientSecret']);

/**clinics */
Route::group(['prefix' => 'clinic/settings'], function () {
    Route::post('/plans/add', [OnboardingController::class, 'addPlan'])->name('addPlan');
    Route::post('/plan/{type}', [OnboardingController::class, 'editPlan'])->name('editPlan');
    Route::post('/{type}', [OnboardingController::class, 'onBoardingSteps'])->name('onBoardingSteps');
});
/** intake form details */
Route::group(['prefix' => 'intakeform'], function () {
 
    Route::get('/', [InTakeFormController::class, 'inTakeForm'])->name('frontend.intakeform');
    Route::post('/store', [InTakeFormController::class, 'storeIntake'])->name('intakeform.storeIntake');
    Route::post('/medication/store', [InTakeFormController::class, 'storeMedication'])->name('intakeform.storeMedication');
    Route::post('/getforms', [InTakeFormController::class, 'getForms'])->name('intakeform.getforms');
    Route::get('/condition/search', [InTakeFormController::class, 'getConditions'])->name('intakeform.getconditions');
    Route::get('/medicine/search', [InTakeFormController::class, 'getMedicines'])->name('intakeform.getmedicines');
    Route::post('/medicationhistory/store', [InTakeFormController::class, 'storeMedicationHistory'])->name('intakeform.storeMedicationHistory');
    Route::post('/medicationhistoryintake/store', [InTakeFormController::class, 'storeMedicationHistoryIntake'])->name('intakeform.storeMedicationHistoryIntake');
    Route::post('/medicalcondition/store', [InTakeFormController::class, 'storeMedicalCondition'])->name('intakeform.storeMedicalCondition');
    Route::post('/familyhistory/store', [InTakeFormController::class, 'storeFamilyHistory'])->name('intakeform.storeFamilyHistory');
    Route::post('/familyhistory/update', [InTakeFormController::class, 'updateFamilyHistory'])->name('intakeform.updateFamilyHistory');
    Route::post('/medicationhistory/update', [InTakeFormController::class, 'updateMedicationHistory'])->name('intakeform.updateMedicationHistory');
    Route::post('/immunization/store', [InTakeFormController::class, 'storeImmunization'])->name('intakeform.storeImmunization');
    Route::post('/immunization/update', [InTakeFormController::class, 'updateImmunization'])->name('intakeform.updateImmunization');
    Route::post('/allergy/store', [InTakeFormController::class, 'storeAllergy'])->name('intakeform.storeAllergy');
    Route::post('/allergy/update', [InTakeFormController::class, 'updateAllergy'])->name('intakeform.updateAllergy');
    Route::post('/patientmedication/store', [InTakeFormController::class, 'storePatientMedication'])->name('intakeform.storePatientMedication');
    Route::post('/patientmedication/update', [InTakeFormController::class, 'updatePatientMedication'])->name('intakeform.updatePatientMedication');
    Route::post('/checkconditionexists', [InTakeFormController::class, 'checkconditionexists'])->name('intakeform.checkconditionexists');
    Route::post('/checkrelationexists', [InTakeFormController::class, 'checkrelationexists'])->name('intakeform.checkrelationexists');
    Route::post('/saturation/store', [InTakeFormController::class, 'storeSaturation'])->name('intakeform.storesaturation');
    Route::post('/saturation/update', [InTakeFormController::class, 'updateSaturation'])->name('intakeform.updatesaturation');
});

Route::post('cancelappointment', [FrontendController::class, 'cancelAppointment'])->name('patient.cancelappointment');

/** medicatl history details */
Route::group(['prefix' => 'medicalhistory'], function () {
    Route::get('/', [InTakeFormController::class, 'medicalHistory'])->name('frontend.medicalhistory');
    Route::post('/edit', [InTakeFormController::class, 'editmedicalHistory'])->name('frontend.edit');
    Route::post('/editform', [InTakeFormController::class, 'editForm'])->name('frontend.editform');
    Route::post('/deleteform', [InTakeFormController::class, 'deleteForm'])->name('frontend.deleteform');
});
Route::post('appointment/medicalhistorygraph', [InTakeFormController::class, 'medicalHistoryGraph'])->name('medicalHistoryGraph');
Route::post('appointment/medicalhistory', [InTakeFormController::class, 'appointmentMedicalHistory'])->name('appointmentMedicalHistory');


Route::get('frontend/login', [FrontendController::class, 'login'])->name('frontend.login');
Route::post('frontend/submitlogin', [FrontendController::class, 'submitlogin'])->name('frontend.submitlogin');
Route::post('frontend/verifyotp', [FrontendController::class, 'verifyotp'])->name('frontend.verifyotp');
Route::post('frontend/clinic/store', [FrontendController::class, 'storeClinic'])->name('frontend.store');
Route::post('frontend/registerclinic', [FrontendController::class, 'registerClinic'])->name('frontend.registerclinic');
Route::post('frontend/noteUpdate', [FrontendController::class, 'noteUpdate'])->name('frontend.noteUpdate');
Route::post('frontend/delete', [FrontendController::class, 'delete'])->name('frontend.deletePatient');
Route::post('frontend/checkEmailExist', [FrontendController::class, 'checkEmailExist'])->name('frontend.checkEmailExist');
Route::post('frontend/checkPhoneExist', [FrontendController::class, 'checkPhoneExist'])->name('frontend.checkPhoneExist');
Route::post('frontend/storeDocs', [FrontendController::class, 'storeDocs'])->name('frontend.storeDocs');
Route::post('frontend/removeDocs', [FrontendController::class, 'removeDocs'])->name('frontend.removeDocs');
Route::post('frontend/changePhoneNumber', [FrontendController::class, 'changePhoneNumber'])->name('frontend.changePhoneNumber');
Route::post('frontend/patient/create', [FrontendController::class, 'createPatient'])->name('frontend.createPatient');
Route::post('frontend/patient/store', [FrontendController::class, 'storePatient'])->name('frontend.storePatient');
Route::post('frontend/update-patient', [FrontendController::class, 'updatePatient'])->name('frontend.updatePatient');
Route::post('frontend/show-login', [FrontendController::class, 'showLogin'])->name('frontend.showLogin');
Route::get('/patient/dashboard', [FrontendController::class, 'dashboard'])->name('frontend.dashboard');
Route::get('/myaccounts', [FrontendController::class, 'myAccounts'])->name('frontend.myaccounts');
Route::post('/getgraphdata', [FrontendController::class, 'getGraphData'])->name('frontend.getgraphdata');



Route::post('/myaccounts/subscriptiondetails', [MyAccountsController::class, 'subscriptionDetails'])->name('frontend.subscriptiondetails');

Route::post('/myaccounts/cancelsubscription', [MyAccountsController::class, 'cancelSubscription'])->name('myaccounts.cancelsubscription');

Route::post('/myaccounts/getdata', [MyAccountsController::class, 'getAccountDatas'])->name('frontend.getAccountsData');
Route::post('myaccounts/saveaddress', [MyAccountsController::class, 'saveAddress'])->name('saveaddress');
Route::post('/myaccounts/getclinic', [MyAccountsController::class, 'getClinic'])->name('frontend.getAccountsData');
Route::post('/myaccounts/addtoclinic', [MyAccountsController::class, 'addToClinic'])->name('frontend.addtoclinic');
Route::post('/myaccounts/fetchplandetails', [MyAccountsController::class, 'fetchPlanDetails'])->name('frontend.fetchplandetails');
Route::post('/myaccounts/fetchpaymentdetails', [MyAccountsController::class, 'fetchPaymentDetails'])->name('frontend.fetchpaymentdetails');
Route::post('/myaccounts/subscriptionpayment/submit', [MyAccountsController::class, 'confirmSubscriptionNew'])->name('frontend.confirmsubscription');
Route::post('/myaccounts/devices', [MyAccountsController::class, 'fetchDevices'])->name('frontend.fetchDevices');
Route::post('/devices/statuschange', [MyAccountsController::class, 'deviceStatuschange'])->name('frontend.deviceStatuschange');
Route::post('myaccounts/trackorder', [MyAccountsController::class, 'trackDeviceorder'])->name('frontend.trackDeviceorder');
Route::post('myaccounts/cancelorder', [MyAccountsController::class, 'cancelOrder'])->name('frontend.cancelOrder');
Route::post('myaccounts/getorderdevices', [MyAccountsController::class, 'getOrderDevices'])->name('frontend.getOrderDevices');
Route::post('myaccounts/leaveclinic', [MyAccountsController::class, 'leaveClinic'])->name('myaccounts.leaveClinic');


Route::get('frontend/logout', [FrontendController::class, 'logout'])->name('frontend.logout');
Route::post('frontend/logout', [FrontendController::class, 'logout'])->name('frontend.logout');
Route::get('myreceipts ', [FrontendController::class, 'myReceipt'])->name('payment.myReceipt');
Route::post('viewreceipt ', [FrontendController::class, 'viewReceipt'])->name('payment.viewreceipt');
Route::post('viewreceiptbyid ', [FrontendController::class, 'viewReceiptById'])->name('payment.viewreceiptbyid');
Route::get('receipt/{key}/download', [FrontendController::class, 'receiptDownload'])->name('receiptdownload');
Route::get('appointment/details/{key}', [FrontendController::class, 'appointmentDetails'])->name('appointmentDetails');
Route::post('appointment/addmedicalhistory', [AppointmentController::class, 'addMedicalhistory'])->name('addmedicalhistory');
Route::post('appointment/history', [AppointmentController::class, 'historyDetails'])->name('historyDetails');
Route::post('/appointment/medicalhistory/editvitails', [AppointmentController::class, 'editForm'])->name('appointment.editform');
Route::post('/patient/bookappointment', [FrontendController::class, 'bookAppointment'])->name('patient.bookappointment');
Route::post('/getclinicusers', [FrontendController::class, 'getClinicUsers'])->name('patient.getclinicusers');
Route::post('/patient/gettimeslots', [FrontendController::class, 'getTimeSlots'])->name('patient.gettimeslots');
Route::post('/fetchavailableslots', [FrontendController::class, 'fetchAvailableSlots'])->name('patient.fetchavailableslots');
Route::post('/appointment/submit', [FrontendController::class, 'submitAppointment'])->name('patient.submitappointment');
Route::post('/confirmbooking', [FrontendController::class, 'confirmBooking'])->name('patient.confirmbooking');
Route::post('/frontend/workspace/change', [FrontendController::class, 'workspaceChange'])->name('workspace.change');
Route::post('/frontend/workspace/select', [FrontendController::class, 'selectClinic'])->name('workspace.select');
Route::post('/frontend/add/workspace', [FrontendController::class, 'addWorkspace'])->name('addWorkspace');

/** notes  */
Route::post('appointment/addnotes', [NotesController::class, 'addNotes'])->name('addnotes');
 

/* File Cabinet */

Route::post('/validatePatient', [FrontendController::class, 'validatePatientLogin'])->name('frontend.validatePatientLogin');
Route::get('/filecabinet', [FrontendController::class, 'fileCabinet'])->name('frontend.filecabinet');
Route::get('/filecabinet/{key}/files', [FrontendController::class, 'files'])->name('frontend.files');
Route::post('/folder/store', [FrontendController::class, 'storeFolder'])->name('frontend.storefolder');
Route::post('/folder/edit', [FrontendController::class, 'editFolder'])->name('frontend.editfolder');
Route::post('/folder/update', [FrontendController::class, 'updateFolder'])->name('frontend.updatefolder');
Route::post('patients/getfolders', [FrontendController::class, 'getFolders'])->name('patient.getfolders');
Route::post('patients/getfiles', [FrontendController::class, 'getFiles'])->name('patient.getfiles');
Route::post('/patients/uploadfile', [FrontendController::class, 'uploadFile'])->name('patient.uploadfile');
Route::post('/file/store', [FrontendController::class, 'storeFile'])->name('frontend.storeFile');
Route::post('/patients/removefolder', [FrontendController::class, 'removeFolder'])->name('patient.removefolder');
Route::post('/patients/removefile', [FrontendController::class, 'removeFile'])->name('patient.removefile');
Route::get('/patients/downloadfile/{key}', [FrontendController::class, 'downloadFile'])->name('downloadfile');
Route::post('/file/getsummary', [FrontendController::class, 'getSummary'])->name('file.getsummary');
Route::post('/file/getaisummary', [FrontendController::class, 'getAISummary'])->name('file.getaisummary');
Route::get('/subscriptionplans', [FrontendController::class, 'subscriptionPlans'])->name('subscriptionplans');
Route::get('onboarding/getstarted',[FrontendController::class, 'startonBoarding'])->name('patientonboarding');
/** Fronend urls End */



Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/connecttostripe', [AuthController::class, 'connecttostripe'])->name('connecttostripe');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/submitlogin', [AuthController::class, 'submitlogin'])->name('submitlogin');
Route::post('/verifyotp', [AuthController::class, 'verifyotp'])->name('verifyotp');
Route::post('/clinic/store', [AuthController::class, 'registerUser'])->name('store');
Route::post('/registerclinic', [AuthController::class, 'registerClinic'])->name('registerclinic');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/success', [AuthController::class, 'success'])->name('success');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/cleartempuser', [AuthController::class, 'clearTempuser'])->name('cleartempuser');

Route::get('login/google', [AuthController::class, 'LoginWithGoogle'])->name('google_login');
Route::get('google/call-back', [AuthController::class, 'handleGoogleCallback']);

/** dashboard routes */
Route::get('/uploadfile/{type}', [DashboardController::class, 'uploadfile'])->name('uploadfile');
Route::post('/file/upload', [DashboardController::class, 'storeFile'])->name('file.upload');
Route::get('support', [DashboardController::class, 'support'])->name('support');
Route::post('support/store', [DashboardController::class, 'storeSupport'])->name('support.store');

Route::post('workspace/change', [DashboardController::class, 'workspaceChange'])->name('workspace.change');

Route::post('validatenpinumber', [AuthController::class, 'validateNpiNumber'])->name('validatenpinumber');

Route::post('validateemail', [AuthController::class, 'validateEmail'])->name('validateemail');
Route::post('validateemailnew', [AuthController::class, 'validateEmail'])->name('validateemailnew');
Route::post('validatephone', [AuthController::class, 'validatePhone'])->name('validatephone');
Route::post('validatephonenew', [AuthController::class, 'validatePhoneNew'])->name('validatePhoneNew');
Route::get('/invitation/{key}', [AuthController::class, 'invitationCheck'])->name('invitationcheck');
Route::get('/connect/stripe', [AuthController::class, 'connectStripe'])->name('connectStripe');
Route::post('/disconnect/stripe', [AuthController::class, 'disConnectStripe'])->name('disconnectStripe');
Route::post('workspace/select', [DashboardController::class, 'selectClinic'])->name('workspace.select');
Route::post('add/workspace', [DashboardController::class, 'addWorkspace'])->name('addWorkspace');
Route::post('store/clinic', [DashboardController::class, 'addClinic'])->name('addClinic');

Route::post('validateuserphone', [AuthController::class, 'validateUserPhone'])->name('validateuserphone');
Route::post('validateuserphonebypatient', [AuthController::class, 'validateUserPhoneByPatient'])->name('validateuserphonebypatient');
Route::post('validateuserphoneregister', [AuthController::class, 'validateUserPhoneRegister'])->name('validateuserphoneregister');
Route::get('globalsearchlist', [DashboardController::class, 'globalSearch'])->name('globalsearch');
Route::post('globalsearch', [DashboardController::class, 'searchTerm'])->name('searchTerm');

Route::post('/gettrialinfo', [DashboardController::class, 'getTrialInfo'])->name('getTrialInfo');
Route::get('/viewinvoicedetails/{key}',[AuthController::class,'viewInvoiceDetails'])->name('viewinvoicedetails');


// dashboard Routes
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/appointment', [DashboardController::class, 'appointmentList'])->name('appointment');
    Route::post('/appointmentlist', [DashboardController::class, 'getAppointments'])->name('getappointments');
});
Route::post('/dosespot/completeonboarding', [DashboardController::class, 'completeDosespotOnboarding'])->name('dosespot.completeonboarding');
Route::post('/dosespot/updatestatus', [DashboardController::class, 'updateStatus'])->name('dosespot.updatestatus');

/** notification routes */
// dashboard Routes
Route::group(['prefix' => 'notifications'], function () {
    Route::post('/list', [NotificationController::class, 'list'])->name('notification.list');
    Route::get('/', [NotificationController::class, 'notification'])->name('notification');

    Route::post('/clearall', [NotificationController::class, 'clearAll'])->name('clearall');
    Route::post('/markasread', [NotificationController::class, 'markAsRead'])->name('markasread');
});

Route::get('doctor/{key}/details', [DoctorsController::class, 'details'])->name('doctor.details');

// doctor Routes
Route::group(['prefix' => 'doctors'], function () {

    Route::get('list', [DoctorsController::class, 'list'])->name('doctor.list');
    Route::get('list/{status}', [DoctorsController::class, 'list'])->name('doctor.lists');
    Route::post('/create', [DoctorsController::class, 'create'])->name('doctor.create');
    Route::post('/store', [DoctorsController::class, 'store'])->name('doctor.store');
    Route::post('/import', [DoctorsController::class, 'import'])->name('doctor.import');
    Route::post('/importdoctors', [DoctorsController::class, 'importDoctors'])->name('doctor.importdoctors');
    Route::get('/download', [DoctorsController::class, 'downloadSampleDoc'])->name('doctor.download');
    Route::post('/import/store', [DoctorsController::class, 'storePreview'])->name('doctor.store');
    Route::post('/invitationstatuschange/{key}', [AuthController::class, 'invitationStatusChange'])->name('invitationstatuschange');
    Route::post('/import/delete', [DoctorsController::class, 'deleteDoc'])->name('doctor.delete');
    Route::post('/resend', [DoctorsController::class, 'resendInvitation'])->name('doctor.resend');
    Route::post('/edit', [DoctorsController::class, 'edit'])->name('doctor.edit');
    Route::post('/delete', [DoctorsController::class, 'delete'])->name('doctor.delete');
    Route::post('/update', [DoctorsController::class, 'update'])->name('doctor.update');
    Route::post('appointmentlist', [DoctorsController::class, 'appointmentList'])->name('doctor.appointmentlist');
    Route::get('excelpreview/{key}', [DoctorsController::class, 'excelPreview'])->name('doctor.excelpreview');
    Route::post('/importpreview', [DoctorsController::class, 'importPreview'])->name('doctor.importpreview');
    Route::post('/previewdetails', [DoctorsController::class, 'previewDetails'])->name('doctor.previewdetails');
    Route::post('/markasadmin', [DoctorsController::class, 'markAsAdmin'])->name('doctor.markasadmin');
});
Route::get('nurse/{uuid}/details', [NurseController::class, 'view'])->name('nurse.view');

// Nurse Routes
Route::group(['prefix' => 'nurse'], function () {

    Route::get('create', [NurseController::class, 'create'])->name('nurse.create');
    Route::post('store', [NurseController::class, 'store'])->name('nurse.store');
    Route::get('list', [NurseController::class, 'list'])->name('nurse.list');
    Route::get('list/{status}', [NurseController::class, 'list'])->name('nurse.lists');
    Route::get('edit/{uuid}', [NurseController::class, 'edit'])->name('nurse.edit');
    Route::get('resend/{uuid}', [NurseController::class, 'resendInvitation'])->name('nurse.resendInvitation');
    Route::post('update/{uuid}', [NurseController::class, 'update'])->name('nurse.update');
    Route::post('appointment/list/{uuid}', [NurseController::class, 'appointmentList'])->name('nurse.appointmentList');
    Route::get('delete/{uuid}', [NurseController::class, 'delete'])->name('nurse.delete');
    Route::get('activate/{uuid}', [NurseController::class, 'activate'])->name('nurse.activate');
    Route::post('check-email-exist', [NurseController::class, 'checkEmailExist'])->name('nurse.checkEmailExist');
    Route::post('check-phone-exist', [NurseController::class, 'checkPhoneExist'])->name('nurse.checkPhoneExist');
    Route::get('import', [NurseController::class, 'import'])->name('nurse.import');
    Route::post('import-nurse', [NurseController::class, 'importNurse'])->name('nurse.importNurse');
    Route::post('import-preview', [NurseController::class, 'importPreview'])->name('nurse.importPreview');
    Route::post('/import/store', [NurseController::class, 'storePreview'])->name('nurse.storePreview');
    Route::post('/import/delete', [NurseController::class, 'deleteDoc'])->name('nurse.importDelete');
    Route::post('/invitation-status-change/{key}', [AuthController::class, 'nurseInvitationStatusChange'])->name('nurse.invitationStatusChange');

    Route::get('excelpreview/{key}', [NurseController::class, 'excelPreview'])->name('nurse.excelpreview');
    Route::post('/importpreview', [NurseController::class, 'importPreview'])->name('nurse.importpreview');
    Route::post('/previewdetails', [NurseController::class, 'previewDetails'])->name('nurse.previewdetails');
});
Route::get('nurse/download', [NurseController::class, 'downloadSampleDoc'])->name('nurse.downloadSampleDoc');


Route::get('appointment/{uuid}/details', [AppointmentController::class, 'viewNew'])->name('appointment.view');
Route::get('appointment/{uuid}/detailsnew', [AppointmentController::class, 'viewNew'])->name('appointment.viewnew');
// Appointments Routes

Route::group(['prefix' => 'appointments'], function () {
    Route::post('/reschedule/store',[AppointmentController::class,'rescheduleUpdate'])->name('reschedule.store');
    Route::post('reschedule', [AppointmentController::class, 'reschedule'])->name('appointment.reschedule');
    Route::post('fetchvideocalldetails', [AppointmentController::class, 'fetchVideocallDetails'])->name('appointment.fetchvideocalldetails');
    Route::post('getvideocalldetails', [AppointmentController::class, 'getVideocallDetails'])->name('appointment.getvideocalldetails');
    Route::post('edit', [AppointmentController::class, 'editappointment'])->name('appointment.editappointment');
    Route::get('create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('search/{type}', [AppointmentController::class, 'search'])->name('appointment.search');
    Route::post('store', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('appointment-list', [AppointmentController::class, 'appointmentList'])->name('appointment.appointmentList');
    Route::get('edit/{uuid}', [AppointmentController::class, 'edit'])->name('appointment.edit');
    Route::post('update', [AppointmentController::class, 'update'])->name('appointment.update');
    Route::get('delete/{uuid}', [AppointmentController::class, 'delete'])->name('appointment.delete');
    Route::get('activate/{uuid}', [AppointmentController::class, 'activate'])->name('appointment.activate');
    Route::post('note', [AppointmentController::class, 'getNotes'])->name('appointment.note');
    Route::post('paymentresponse', [AppointmentController::class, 'getPaymentResponse'])->name('appointment.paymentresponse');
    Route::post('cancel', [AppointmentController::class, 'cancelAppointment'])->name('appointment.cancel');
    Route::post('joinvideo', [AppointmentController::class, 'joinVideo'])->name('appointment.joinVideo');
    Route::post('markascompleted', [AppointmentController::class, 'markAsCompleted'])->name('appointment.markascompleted');
    Route::post('markasnoshow', [AppointmentController::class, 'markAsNoShow'])->name('appointment.markasnoshow');
    Route::post('triggeramount', [AppointmentController::class, 'triggerAmount'])->name('appointment.triggeramount');
    Route::post('startappointment', [AppointmentController::class, 'startAppointment'])->name('appointment.startappointment');
    Route::post('cancelappointment', [AppointmentController::class, 'cancel'])->name('appointment.cancelappointment');
    Route::post('markasnoteslocked', [AppointmentController::class, 'markAsNotesLocked'])->name('appointment.markasnoteslocked');
});

Route::get('meet/{key}', [AppointmentController::class, 'joinMeet'])->name('appointment.joinMeet');
Route::group(['prefix' => 'meetnew'], function () {
    Route::post('joincall', [MeetController::class, 'acceptcall'])->name('meet.joincall');
    Route::get('completed/{key}', [MeetController::class, 'completedMeet'])->name('meet.completedMeet');
    Route::get('joinmeet/{key}', [MeetController::class, 'joinvideocall'])->name('meet.joinVideoCall');
    Route::post('checkVideoCallStatus', [MeetController::class, 'checkVideoCallStatus'])->name('meet.checkVideoCallStatus');
    Route::get('videochat/updateVideoCallStatus', [MeetController::class, 'updateVideoCallStatus'])->name('meet.updateVideoCallStatus');
    Route::get('videochat/initiateVideoCall', [MeetController::class, 'initiateVideoCall'])->name('meet.initiateVideoCall');
    Route::get('videochat/generatetoken', [MeetController::class, 'generatetoken'])->name('meet.generatetoken');

    Route::get('{key}', [MeetController::class, 'joinMeet'])->name('meet.joinMeet');
});
Route::post('addnote', [AppointmentController::class, 'addnote'])->name('appointment.addnote');

Route::post('acceptcall', [AppointmentController::class, 'acceptcall'])->name('appointment.acceptcall');
Route::post('acceptcallcheck', [AppointmentController::class, 'acceptcallcheck'])->name('appointment.acceptcallcheck');
Route::post('videocallend', [AppointmentController::class, 'videocallend'])->name('appointment.videocallend');
// Appointments Routes
Route::group(['prefix' => 'payment'], function () {

    Route::post('submitpayment', [PaymentController::class, 'submitPayment'])->name('appointment.submitPayment');
    Route::post('createpaymentIntent', [PaymentController::class, 'createpaymentIntent'])->name('appointment.createpaymentIntent');
});
Route::post('patient/submitpayment', [PaymentController::class, 'submitPayment'])->name('appointment.submitPayment');
Route::get('/viewrecieptdetails/{key}', [AuthController::class, 'viewReceiptDetails'])->name('viewrecieptdetails');
Route::post('/checkvideocall', [AuthController::class, 'checkvideocall'])->name('checkvideocall');
Route::get('labs/print/orders/{key}', [AuthController::class, 'printLabs'])->name('printLabs');
Route::get('imaging/print/orders/{key}', [AuthController::class, 'printImaging'])->name('printImaging');


Route::get('patient/{key}/details', [PatientController::class, 'details'])->name('patient.details');

// patient Routes
Route::group(['prefix' => 'patients'], function () {

    Route::get('/', [PatientController::class, 'list'])->name('patient.list');
    Route::get('list/{status}', [PatientController::class, 'list'])->name('patient.lists');
    Route::post('/create', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/store', [PatientController::class, 'store'])->name('patient.store');
    Route::post('/uploaddocument', [PatientController::class, 'uploadDocument'])->name('patient.uploaddocument');
    Route::post('/delete', [PatientController::class, 'destroy'])->name('patient.delete');
    Route::post('edit', [PatientController::class, 'edit'])->name('patient.edit');
    Route::post('update', [PatientController::class, 'update'])->name('patient.update');
    Route::post('refer', [PatientController::class, 'referPatient'])->name('patient.refer');

    Route::post('/import', [PatientController::class, 'import'])->name('patient.import');
    Route::post('/importpatient', [PatientController::class, 'importPatients'])->name('patient.importpatient');
    Route::post('/importpreview', [PatientController::class, 'importPreview'])->name('patient.importpreview');
    Route::post('/import/store', [PatientController::class, 'storePreview'])->name('patient.store');
    Route::get('/download', [PatientController::class, 'downloadSampleDoc'])->name('patient.download');
    Route::post('/resend', [PatientController::class, 'resendInvitation'])->name('patient.resend');
    Route::post('appointmentlist', [PatientController::class, 'appointmentList'])->name('patient.appointmentlist');
    Route::post('removedoc', [PatientController::class, 'removeDoc'])->name('patient.removedoc');

    Route::get('excelpreview/{key}', [PatientController::class, 'excelPreview'])->name('patient.excelpreview');
    Route::post('/importpreview', [PatientController::class, 'importPreview'])->name('patient.importpreview');
    Route::post('/previewdetails', [PatientController::class, 'previewDetails'])->name('patient.previewdetails');
    Route::post('/import/delete', [PatientController::class, 'deleteDoc'])->name('patient.delete');

    Route::get('/downloadtempdocs/{key}', [PatientController::class, 'downloaDocument'])->name('patient.downloadocument');
    Route::post('/markaspriority', [PatientController::class, 'markAsPriority'])->name('patient.markaspriority');
    Route::post('/fetchdevices', [PatientController::class, 'fetchDevices'])->name('patient.fetchdevices');
});

// appointment Routes
Route::group(['prefix' => 'appointments'], function () {

    Route::get('/', [AppointmentController::class, 'list'])->name('appointment.list');
});

Route::get('user/{uuid}/details', [UserController::class, 'details'])->name('user.details');
// Users
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'list'])->name('user.list');
    Route::get('list/{status}', [UserController::class, 'list'])->name('user.lists');
    Route::post('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/resend', [UserController::class, 'resendInvitation'])->name('user.resend');
    Route::post('/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/updateprofile', [UserController::class, 'updateProfile'])->name('user.updateprofile');
    Route::post('/markasadmin', [UserController::class, 'markAsAdmin'])->name('user.markasadmin');
    Route::post('/import', [UserController::class, 'import'])->name('user.import');
    Route::post('/importusers/{type}', [UserController::class, 'importUsers'])->name('user.importusers');
    Route::get('/download/{type}', [UserController::class, 'downloadSampleDoc'])->name('user.download');
    Route::post('/import/store', [UserController::class, 'storePreview'])->name('user.store');
    Route::post('/import/delete', [UserController::class, 'deleteDoc'])->name('user.delete');
    Route::get('excelpreview/{key}/{type}', [UserController::class, 'excelPreview'])->name('user.excelpreview');
    Route::post('/importpreview', [UserController::class, 'importPreview'])->name('user.importpreview');
    Route::post('/previewdetails', [UserController::class, 'previewDetails'])->name('user.previewdetails');
    Route::post('/deleteclinicuser', [UserController::class, 'deleteClinicUser'])->name('users.deleteclinicuser');
    Route::post('/checkappointmenttagged', [UserController::class, 'checkAppointmentTagged'])->name('users.checkappointmenttagged');
    Route::post('/verifyotp', [UserController::class, 'verifyotp'])->name('users.verifyotp');
    Route::post('/enableaddon', [UserController::class, 'enableAddOn'])->name('users.enableaddon');
    Route::post('/submitaddon', [UserController::class, 'submitAddOn'])->name('users.submitaddon');
    Route::post('/checkaddon', [UserController::class, 'checkAddon'])->name('users.checkaddon');
});

Route::group(['prefix' => 'payouts'], function () {
    Route::get('/', [PayoutController::class, 'list'])->name('payouts.list');
    Route::get('list/{status}', [PayoutController::class, 'list'])->name('payouts.lists');
});


Route::group(['prefix' => 'subscriptions'], function () {
    Route::post('/viewreceipt',[SubscriptionController::class,'viewreceipt'])->name('viewreceipt');
    Route::post('/viewinvoice',[SubscriptionController::class,'viewinvoice'])->name('viewinvoice');
    Route::post('/payinvoice',[SubscriptionController::class,'payInvoice'])->name('payinvoice');
});
Route::get('invoice/{key}/download', [SubscriptionController::class, 'invoiceDownload'])->name('invoiceDownload');
/* Settings */
Route::post('/getuserbilling', [SettingsController::class, 'getuserbilling'])->name('getuserbilling');
Route::post('/saveaddress', [SettingsController::class, 'saveAddress'])->name('saveaddress');
Route::post('/updateaddress', [SettingsController::class, 'updateAddress'])->name('updateaddress');
Route::post('/addcard', [SettingsController::class, 'addCard'])->name('addcard');
Route::post('/addnewaddress', [SettingsController::class, 'addAddress'])->name('addaddress');
Route::post('/addnewcard', [SettingsController::class, 'addNewCard'])->name('addnewcard');
Route::post('/removecard', [SettingsController::class, 'removeCard'])->name('removecard');
Route::post('/markasdefault', [SettingsController::class, 'markAsDefaultCard'])->name('markasdefault');
Route::post('/saveaddress',[SettingsController::class,'saveAddress'])->name('saveaddress');
Route::post('/addnewaddress',[SettingsController::class,'addAddress'])->name('addaddress');
Route::post('/updateaddress',[SettingsController::class,'updateAddress'])->name('updateaddress');


// Route Clinic
Route::get('profile', [ClinicController::class, 'profile'])->name('clinic.profile');
Route::post('profile', [ClinicController::class, 'profile'])->name('clinic.profile');
Route::post('profile-update', [ClinicController::class, 'updateProfile'])->name('clinic.updateProfile');
Route::post('profile/updateclinic', [ClinicController::class, 'updateClinic'])->name('clinic.updateclinic');
Route::get('myprofile', [ClinicController::class, 'myProfile'])->name('clinic.myprofile');
Route::post('myprofile', [ClinicController::class, 'myProfile'])->name('clinic.myprofile');
Route::post('myprofile/appointmentlist', [ClinicController::class, 'appointmentList'])->name('clinic.appointmentlist');
Route::post('myprofiletabs/{type}', [ClinicController::class, 'getMyProfileTab'])->name('clinic.getMyProfileTab');
Route::post('user-profile-update', [ClinicController::class, 'updateUserProfile'])->name('clinic.updateUserProfile');
Route::post('clinic/check-mail-exist', [ClinicController::class, 'checkMailExist'])->name('clinic.checkMailExist');
Route::post('clinic/check-phone-exist', [ClinicController::class, 'checkPhoneExist'])->name('clinic.checkPhoneExist');
Route::post('business-hours', [ClinicController::class, 'businessHoursCreate'])->name('clinic.businessHoursCreate');
Route::post('business-hours/update', [ClinicController::class, 'businessHoursUpdate'])->name('clinic.businessHoursUpdate');
Route::post('save-about', [ClinicController::class, 'saveAbout'])->name('clinic.saveAbout');
Route::post('clinic/upload-document', [ClinicController::class, 'galleryImages'])->name('clinic.galleryImages');
Route::post('clinic/save-document', [ClinicController::class, 'storeGalleryImage'])->name('clinic.storeGalleryImage');
Route::post('clinic/remove-image', [ClinicController::class, 'removeGalleryImage'])->name('clinic.removeGalleryImage');
Route::post('tab-content', [ClinicController::class, 'tabContent'])->name('clinic.tabContent');
Route::post('update-plan-order', [ClinicController::class, 'updatePlanOrder'])->name('clinic.updateplanorder');
Route::post('/checkappointmentsforvacation', [ClinicController::class, 'appointmentForVacation'])->name('checkappointmentsforvacation');
Route::post('/clinicuser/eprescription/cancel', [ClinicController::class, 'cancelUserEprescription'])->name('cancelusereprescription');
Route::post('/clinic/eprescription/cancel', [ClinicController::class, 'cancelClinicEprescription'])->name('cancelcliniceprescription');


/*  Crop  */
Route::get('crop/{type}', [CropController::class, 'index'])->name('profile.cropget');
Route::post('crop/{type}', [CropController::class, 'index'])->name('profile.croppost');

/** cron   */
Route::get('payment/notification', [CronController::class, 'paymentNotification'])->name('profile.croppost');
Route::get('summarizepdf', [CronController::class, 'summarizePdf'])->name('summarizepdf');
Route::get('updateappointmentswithuserid', [CronController::class, 'updateAppointmentsWithUserId'])->name('updateappointmentswithuserid');
Route::get('trialnotifications', [CronController::class, 'trialNotifications'])->name('trialnotifications');
Route::get('subscriptionrenewal', [CronController::class, 'subscriptionRenewal'])->name('subscriptionrenewal');
Route::get('videotranscribegenerate', [CronController::class, 'videoTranscribeGenerate'])->name('videoTranscribeGenerate');
Route::get('patientsubscriptionrenewal', [CronController::class, 'patientSubscriptionRenewal'])->name('patientSubscriptionRenewal');
Route::get('sendpatientsubscriptionrenewalreminder', [CronController::class, 'sendPatientSubscriptionRenewalReminder'])->name('sendpatientsubscriptionrenewalreminder');

/* clinic user migrate */
Route::get('clinicusers', [CronController::class, 'clinicUsers'])->name('clinicusers');
Route::get('updateclinicusername', [CronController::class, 'updateName'])->name('updateName');
Route::get('updatepatientname', [CronController::class, 'patientName'])->name('patientName');

/* ePrescribe cron */
Route::get('sendendofmonthinvoice', [CronController::class, 'sendEndOfMonthInvoice'])->name('sendendofmonthinvoice');
Route::get('autochargeinvoices', [CronController::class, 'autoChargeInvoices'])->name('autochargeinvoices');
Route::get('clinicCode', [CronController::class, 'clinicCode'])->name('clinicCode');

/* pdf extract */
Route::get('/uploadfile', [PdfController::class, 'uploadFile']);
Route::post('/extractfile', [PdfController::class, 'extractFile'])->name('extractfile');

Route::get('/trialnotifications', [CronController::class, 'trialNotifications'])->name('trialNotifications');

/* deletes use connection */
Route::get('removeuserconnection', [CronController::class, 'removeUserConnection'])->name('removeUserConnection');
/*appoinment waiting list */
Route::get('waitinglist', [CronController::class, 'waitingList'])->name('waitinglist');
Route::get('rpminvoice', [CronController::class, 'rpmInvoice'])->name('rpmInvoice');
Route::get('rpmdebitamount', [CronController::class, 'rpmDebitAmount'])->name('rpmDebitAmount');


/* labss */
Route::post('appointment/addlabs', [LabsController::class, 'addLabs'])->name('addlabs');
Route::post('/labs/search/{type}', [LabsController::class, 'labsearch'])->name('labsearch');
Route::post('labs/getsubcategory', [LabsController::class, 'getSubCategory'])->name('getsubcategory');
Route::post('labs/submit', [LabsController::class, 'submitLabTest'])->name('submitLabTest');
Route::post('labs/orderlist', [LabsController::class, 'orderList'])->name('orderList');
Route::get('labs/print/{key}', [LabsController::class, 'printLabsOrder'])->name('printLabs');
Route::post('labs/print/{key}', [LabsController::class, 'printLabsOrder'])->name('printLabs');
Route::post('labs/deleteitem', [LabsController::class, 'deleteitem'])->name('deleteitem');
Route::post('labs/getorderlist', [LabsController::class, 'getOrderList'])->name('getorderlist');
Route::post('labs/addorder', [LabsController::class, 'addOrder'])->name('addorder');
Route::post('labs/editorder', [LabsController::class, 'editOrder'])->name('editorder');


/* imaging */
Route::post('appointment/addimaging', [ImagingController::class, 'addimaging'])->name('addimaging');
Route::post('/imaging/search/{type}', [ImagingController::class, 'imagingsearch'])->name('imagingsearch');
Route::post('imaging/getsubcategory', [ImagingController::class, 'getSubCategory'])->name('getsubcategory');
Route::post('imaging/submit', [ImagingController::class, 'submitImaging'])->name('submitImaging');
Route::post('imaging/orderlist', [ImagingController::class, 'orderList'])->name('orderList');
Route::post('imaging/deleteitem', [ImagingController::class, 'deleteitem'])->name('deleteitem');
Route::post('imaging/delete', [ImagingController::class, 'deleteImaging'])->name('deleteitem');
Route::post('imaging/addorder', [ImagingController::class, 'imagingaddOrder'])->name('addorder');
Route::post('imaging/getorderlist', [ImagingController::class, 'getOrderList'])->name('getorderlist');

Route::get('imaging/print/{key}', [ImagingController::class, 'printImagingOrder'])->name('printImagingOrder');
Route::post('imaging/print/{key}', [ImagingController::class, 'printImagingOrder'])->name('printImagingOrder');
Route::post('imaging/editorder', [ImagingController::class, 'editOrder'])->name('editorder');


// dashboard Routes
Route::group(['prefix' => 'notes'], function () {
   
    Route::get('/', [NotesController::class, 'notes'])->name('notes');
    Route::post('/getsummary', [NotesController::class, 'getSummary'])->name('notes.getsummary');
    Route::post('/savenotes', [NotesController::class, 'saveNotes'])->name('notes.savenotes');
    Route::post('/details', [NotesController::class, 'notesDetails'])->name('notes.details');
    Route::post('/editnotes', [NotesController::class, 'addNotes'])->name('editNotes');
    Route::post('/updatenotes', [NotesController::class, 'updateNotes'])->name('notes.updatenotes');
    Route::post('/delete', [NotesController::class, 'deleteNotes'])->name('notes.deleteNotes');

     
});

// Onboarding 
Route::post('/validateplan', [OnboardingController::class, 'validatePlan'])->name('validateplan');
Route::post('/validateworkinghours', [OnboardingController::class, 'validateWorkingHours'])->name('validateworkinghours');

Route::get('/patient/onboarding', [AuthController::class, 'patientOnboarding'])->name('patientOnboarding');
Route::get('/doctor/onboarding', [DoctorOnboardingController::class, 'doctorOnboarding'])->name('doctorOnboarding');
Route::get('doctor/onboarding/{type}', [DoctorOnboardingController::class, 'doctoronBoardingSteps'])->name('onBoarding');
Route::post('doctor/onboarding/{type}', [DoctorOnboardingController::class, 'doctoronBoardingStore'])->name('onBoardingSteps');
Route::group(['prefix' => 'onboarding'], function () {
    Route::get('/', [OnboardingController::class, 'onboardingWelcome'])->name('onboardingWelcome');
    Route::get('/welcome', [OnboardingController::class, 'onboardingWelcome'])->name('onboardingWelcome');
    Route::post('/subscriptionplan', [OnboardingController::class, 'subscriptionPlan'])->name('subscriptionplan');
    Route::post('/plans/add', [OnboardingController::class, 'addPlan'])->name('addPlan');
    Route::post('/plan/{type}', [OnboardingController::class, 'editPlan'])->name('editPlan');
    Route::get('/{type}', [OnboardingController::class, 'onBoarding'])->name('onBoarding');
    Route::post('/{type}', [OnboardingController::class, 'onBoardingSteps'])->name('onBoardingSteps');
    Route::post('users/edit', [OnboardingController::class, 'userEdit'])->name('userEdit');
    Route::post('users/update', [OnboardingController::class, 'userUpdate'])->name('userUpdate');
    
});

Route::get('/smartmeterorder/add', [RpmController::class, 'addSmartMeterOrder'])->name('addSmartMeterOrder');
Route::post('/myaccounts/devices/submit', [RpmController::class, 'confirmOrderedDevices'])->name('confirmOrderedDevices');


Route::get('/smartmeter/addnotifications', [WebhookController::class, 'addSmartMeterNotifications'])->name('addSmartMeterNotifications');


Route::post('devices/add', [DeviceController::class, 'addDevices'])->name('addDevices');
Route::post('devices/checkselecteddeviceexist', [DeviceController::class, 'checkSelectedDeviceExist']);
Route::post('devices/cancelorder', [DeviceController::class, 'cancelOrder']);

Route::post('prescription/add', [PrescriptionController::class, 'addPrescription']);
Route::post('clinic/chat/details', [ChatController::class, 'chatDetails']);
Route::post('clinic/chat/add', [ChatController::class, 'addChat']);
Route::post('clinic/chat/uploaddocument', [ChatController::class, 'uploadDocument']);
Route::post('chat/getmentions', [ChatController::class, 'getMentions']);
Route::post('chat/documents', [ChatController::class, 'chatDocuments']);


Route::get('/patient/chats', [PatientChatController::class, 'chats'])->name('frontend.chats');
Route::post('patient/chat/details', [PatientChatController::class, 'chatDetails']);
Route::post('patient/chat/add', [PatientChatController::class, 'addChat']);
Route::post('patient/getmentions', [PatientChatController::class, 'getMentions']);
Route::post('patient/chat/uploaddocument', [PatientChatController::class, 'uploadDocument']);
Route::post('patient/chat/documents', [PatientChatController::class, 'chatDocuments']);


Route::prefix('reports')->group(function () {
    Route::get('/', [RevenueReportController::class, 'listing'])->name('reports.listing');
});



