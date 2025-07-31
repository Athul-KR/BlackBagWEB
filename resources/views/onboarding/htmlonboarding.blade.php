<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success | BlackBag</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    

    <link rel="stylesheet" type="text/css" href="{{ asset('css/colorbox.css') }}">
     <script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>         
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

</head>
<body>

<div id="navbar-wrapper" class="header-fixed">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="d-flex align-items-center d-md-block d-none">
                            <img src="{{asset('/images/logo.png')}}" class="img-fluid logo">
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary res-menu d-md-none" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasExample"><span class="material-symbols-outlined">menu
                            </span>
                        </a>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center nav-top">
                            <div class="right-sec">    
                                <div class="profile-hd">
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <img class="pfl-img" src="{{asset('/images/default_clinic.png')}}">
                                                <div class="pftl-txt-hd pftl-txt">
                                                    <span>Welcome</span>
                                                    <h6 class="mb-0 primary fw-medium">HealthCrest </h6>
                                                </div>
                                            </div>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end profile-drpdown p-0 py-3">
                                            <li class="px-3 mx-3">
                                                <button class="dropdown-item danger-btn p-0" type="button">
                                                    <div class=" d-flex align-items-center justify-content-start gap-1">
                                                        <span class="material-symbols-outlined danger">logout</span>
                                                        <p class="mb-0 danger">Logout</p>
                                                    </div>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<section class="mx-lg-5 px-lg-5">
    <div class="container-fluid">
        <div class="wrapper res-wrapper onboard-wrapper">
            <div class="web-card m-h-auto mb-3"> 
                <div class="text-center">
                    <h3 class="text-center mb-4 fw-bold">Clinic Onboarding</h3>
                    <div class="stepper-wrapper">

                        @if(!empty($onboardingSteps))
                            @foreach($onboardingSteps as $steps)
                            <div class="stepper" data-step="{{$steps['id']}}">
                                <div class="circle @if(isset($latestStep) && $latestStep == $steps['slug'] ) active @endif">{{$steps['id']}}</div>
                                <p class="mt-2 mb-0">{{$steps['step']}}</p>
                            </div>
                            @endforeach
                        @endif


                        <!-- <div class="stepper" data-step="2">
                            <div class="circle">2</div>
                            <p class="mt-2 mb-0">Timing & Charges</p>
                        </div>
                        <div class="stepper" data-step="3">
                            <div class="circle">3</div>
                            <p class="mt-2 mb-0">Payment Processing</p>
                        </div>
                        <div class="stepper" data-step="4">
                            <div class="circle">4</div>
                            <p class="mt-2 mb-0">Patient Subscriptions</p>
                        </div>
                        <div class="stepper" data-step="5">
                            <div class="circle">5</div>
                            <p class="mt-2 mb-0">Choose Addons</p>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="web-card"> 
                <div id="step-content">
                  
                    <div class="step-section" data-step="1">
                        <div class="onboard-box"> 
                            <h4 class="fw-bold mb-2">Business Details</h4>
                            <p class="fw-light">Provide your clinic’s essential information, including business hours and appointment fees.</p>
                            
                            <form>
                                <div class="row g-3"> 
                                    <div class="col-12">
                                        <h5 class="fw-medium mb-2">Clinic Details</h5>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <div class="create-profile d-inline-block text-center">
                                            <div class="profile-img position-relative m-0"> 
                                                <img id="patientimage" src="{{ asset("images/clinics-default.png") }}" class="img-fluid">
                                                <a href="" id="" class="upload-icon">
                                                    <span class="material-symbols-outlined">add_photo_alternate</span>
                                                </a>
                                            </div> 
                                            <label class="primary fw-medium mb-0">Upload Logo</label>    
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group form-outline">
                                            <label for="clinic_name" class="float-label">Clinic Name</label>
                                            <i class="material-symbols-outlined">home_health</i>
                                            <input type="text" name="" class="form-control" id="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline">
                                            <label for="input" class="float-label">Email</label>
                                            <i class="fa-solid fa-envelope"></i>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline">
                                            <label for="input" class="float-label">Phone Number</label>
                                            <i class="material-symbols-outlined">call</i>
                                            <input type="text" class="form-control" id="exampleFormControlInput1">
                                        </div> 
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group form-floating">
                                            <i class="material-symbols-outlined">public</i>
                                            <select name="designation" id="designation" class="form-select">
                                                <option value="">Select a Country</option>
                                                <option value="1">India</option>
                                                <option value="2">USA</option>
                                            </select>
                                            <label class="select-label">Country</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group form-outline">
                                            <label for="input" class="float-label">Address</label>
                                            <i class="material-symbols-outlined">home</i>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group form-outline">
                                            <label for="input" class="float-label">City</label>
                                            <i class="material-symbols-outlined">location_city</i>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group form-floating">
                                            <i class="material-symbols-outlined">location_city</i>
                                            <select name="designation" id="designation" class="form-select">
                                                <option value="">Select a State</option>
                                                <option value="1">India</option>
                                                <option value="2">USA</option>
                                            </select>
                                            <label class="select-label">State</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group form-outline">
                                            <label for="input" class="float-label">Zip</label>
                                            <i class="material-symbols-outlined">home_pin</i>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <h5 class="fw-medium mb-2">Primary Contact Details</h5>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <div class="create-profile d-inline-block text-center">
                                            <div class="profile-img position-relative m-0"> 
                                                <img id="patientimage" src="{{ asset("images/patient_portal.png") }}" class="img-fluid">
                                                <a href="" id="" class="upload-icon">
                                                    <span class="material-symbols-outlined">add_photo_alternate</span>
                                                </a>
                                            </div> 
                                            <label class="primary fw-medium mb-0">Upload Image</label>    
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline">
                                            <label for="clinic_name" class="float-label">First Name</label>
                                            <i class="fa-solid fa-circle-user"></i>
                                            <input type="text" name="" class="form-control" id="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline">
                                            <label for="input" class="float-label">Last Name</label>
                                            <i class="fa-solid fa-circle-user"></i>
                                            <input type="text" class="form-control" id="" name="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline">
                                            <label for="input" class="float-label">Email</label>
                                            <i class="fa-solid fa-envelope"></i>
                                            <input type="email" class="form-control" id="" name="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline">
                                            <label for="input" class="float-label">Phone Number</label>
                                            <i class="material-symbols-outlined">call</i>
                                            <input type="text" class="form-control" id="exampleFormControlInput1">
                                        </div> 
                                    </div>
                                    <div class="col-12"> 
                                        <div class="row g-3"> 
                                            <div class="col-12"> 
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="slot10">
                                                    <small class="primary">Are you a licensed medical practitioner?</small>
                                                 </div>
                                            </div>
                                            <div class="col-12"> 
                                                <div class="row"> 
                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-outline">
                                                            <label for="input" class="float-label">NPI</label>
                                                            <i class="material-symbols-outlined">diagnosis</i>
                                                            <input type="text" class="form-control" id="" name="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-floating">
                                                            <i class="material-symbols-outlined">id_card</i>
                                                            <select name="designation" id="designation" class="form-select">
                                                                <option value="">Select a Designation</option>
                                                                <option value="1">Surgeon</option>
                                                            </select>
                                                            <label class="select-label">Designation</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-floating">
                                                            <i class="material-symbols-outlined">workspace_premium</i>
                                                            <select name="designation" id="designation" class="form-select">
                                                                <option value="">Select a Speciality</option>
                                                                <option value="1">Cardiology</option>
                                                            </select>
                                                            <label class="select-label">Speciality</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="btn_alignbox justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary" onclick="goToStep(2)">Save & Continue</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="step-section" data-step="2" style="display: none;">
                        <div class="onboard-box"> 
                            <h4 class="fw-bold mb-2">Timing & Charges</h4>
                            <p class="fw-light">Set your clinic’s working hours and define fees for in-person and virtual appointments.</p>
                            <form>
                                <div class="row g-3"> 
                                    <div class="col-12"> 
                                        <h5 class="fw-medium mb-2">Standard Appointment Duration</h5>
                                        <p class="primary fw-light mb-0">How long do you typically need for each consultation?</p>
                                        <div class="row g-2">
                                            <div class="col-12"> 
                                                <div class="d-flex flex-wrap gap-lg-5 gap-4 my-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="slot10">
                                                        <label class="form-check-label" for="slot10">10 mins</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="slot15">
                                                        <label class="form-check-label" for="slot15">15 mins</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="slot20">
                                                        <label class="form-check-label" for="slot20">20 mins</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="slot30">
                                                        <label class="form-check-label" for="slot30">30 mins</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="slot45">
                                                        <label class="form-check-label" for="slot45">45 mins</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="slot60">
                                                        <label class="form-check-label" for="slot60">60 mins</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="slotCustom">
                                                        <label class="form-check-label" for="slotCustom">Custom</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6"> 
                                                <div class="form-group form-outline">
                                                    <label for="input" class="float-label">Appointment Duration (In Mins)</label>
                                                    <i class="material-symbols-outlined">alarm</i>
                                                    <input type="email" class="form-control" id="" name="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12"> 
                                        <h5 class="fw-medium mb-3">Business Hours</h5>
                                        <div class="slots-container"> 
                                            <div class="row">
                                                <div class="col-lg-2"> 
                                                    <div class="d-flex align-items-center gap-3">
                                                        <p class="m-0 day-type">Sunday</p>
                                                        <div class="d-flex gap-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input isopen" type="checkbox" id="Sunday" name="businessHours[Sunday][is_open]" value="1">
                                                            </div>
                                                            <p class="m-0 gray">Closed</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slots-container"> 
                                            <div class="row">
                                                <div class="col-lg-2"> 
                                                    <div class="d-flex align-items-center gap-3">
                                                        <p class="m-0 day-type">Monday</p>
                                                        <div class="d-flex gap-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input isopen" type="checkbox" id="Monday" name="businessHours[Monday][is_open]" value="1" checked>
                                                            </div>
                                                            <p class="m-0 primary">Open</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10"> 
                                                    <div class="row align-items-baseline mb-2">
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">From</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">To</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                            <div class="btn_alignbox justify-content-end mt-1"> 
                                                                <a href="" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2"> 
                                                            <div class="align_middle"> 
                                                                <small class="fst-italic fw-medium">4 slots available</small>
                                                                <a href="" class="dlt-btn btn-align"><span class="material-symbols-outlined">delete</span></a>
                                                            </div>      
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slots-container"> 
                                            <div class="row">
                                                <div class="col-lg-2"> 
                                                    <div class="d-flex align-items-center gap-3">
                                                        <p class="m-0 day-type">Tuesday</p>
                                                        <div class="d-flex gap-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input isopen" type="checkbox" id="Monday" name="businessHours[Monday][is_open]" value="1" checked>
                                                            </div>
                                                            <p class="m-0 primary">Open</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10"> 
                                                    <div class="row align-items-baseline mb-2">
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">From</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">To</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                            <div class="btn_alignbox justify-content-end mt-1"> 
                                                                <a href="" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slots-container"> 
                                            <div class="row">
                                                <div class="col-lg-2"> 
                                                    <div class="d-flex align-items-center gap-3">
                                                        <p class="m-0 day-type">Wednesday</p>
                                                        <div class="d-flex gap-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input isopen" type="checkbox" id="Wednesday" name="businessHours[Wednesday][is_open]" value="1" checked>
                                                            </div>
                                                            <p class="m-0 primary">Open</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10"> 
                                                    <div class="row align-items-baseline mb-2">
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">From</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">To</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                            <div class="btn_alignbox justify-content-end mt-1"> 
                                                                <a href="" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slots-container"> 
                                            <div class="row">
                                                <div class="col-lg-2"> 
                                                    <div class="d-flex align-items-center gap-3">
                                                        <p class="m-0 day-type">Thursday</p>
                                                        <div class="d-flex gap-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input isopen" type="checkbox" id="Thursday" name="businessHours[Thursday][is_open]" value="1" checked>
                                                            </div>
                                                            <p class="m-0 primary">Open</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10"> 
                                                    <div class="row align-items-baseline mb-2">
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">From</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">To</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                            <div class="btn_alignbox justify-content-end mt-1"> 
                                                                <a href="" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slots-container"> 
                                            <div class="row">
                                                <div class="col-lg-2"> 
                                                    <div class="d-flex align-items-center gap-3">
                                                        <p class="m-0 day-type">Friday</p>
                                                        <div class="d-flex gap-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input isopen" type="checkbox" id="Friday" name="businessHours[Friday][is_open]" value="1" checked>
                                                            </div>
                                                            <p class="m-0 primary">Open</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10"> 
                                                    <div class="row align-items-baseline mb-2">
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">From</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">To</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                            <div class="btn_alignbox justify-content-end mt-1"> 
                                                                <a href="" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slots-container"> 
                                            <div class="row">
                                                <div class="col-lg-2"> 
                                                    <div class="d-flex align-items-center gap-3">
                                                        <p class="m-0 day-type">Saturday</p>
                                                        <div class="d-flex gap-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input isopen" type="checkbox" id="Saturday" name="businessHours[Saturday][is_open]" value="1" checked>
                                                            </div>
                                                            <p class="m-0 primary">Open</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10"> 
                                                    <div class="row align-items-baseline mb-2">
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">From</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="form-group form-outline">
                                                                <label for="input" class="float-label">To</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="email" class="form-control" id="" name="">
                                                            </div>
                                                            <div class="btn_alignbox justify-content-end mt-1"> 
                                                                <a href="" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gray-border"></div>
                                        <div class="slots-final"> 
                                            <div class="row">
                                                <div class="col-lg-2"> 
                                                </div>
                                                <div class="col-lg-10"> 
                                                    <div class="row align-items-baseline mb-2">
                                                        <div class="col-12 col-lg-5"> 
                                                        </div>
                                                        <div class="col-12 col-lg-5"> 
                                                            <div class="text-end">
                                                                <p class="gray fw-light mt-2 mb-0">Total Available Slots Per Week</p> 
                                                                <h3 class="mb-0 primary fw-bold">40 Slots</h3>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12"> 
                                        <h5 class="fw-medium mb-3">Appointment Fee</h5>
                                        <p class="primary mb-0">Appointment types that you offer:</p>
                                        <div class="d-flex flex-wrap gap-lg-5 gap-4 my-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="slot10">
                                                <label class="form-check-label primary" for="slot10">In Person</label>
                                             </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="slot15">
                                                <label class="form-check-label primary" for="slot15">Virtual</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="slot20">
                                                <label class="form-check-label primary" for="slot20">Both</label>
                                            </div>     
                                        </div>
                                        <div class="row my-3">
                                            <div class="col-12 col-lg-6"> 
                                                <div class="form-group form-outline">
                                                    <label for="input" class="float-label">In Person</label>
                                                    <i class="material-symbols-outlined">local_atm</i>
                                                    <input type="email" class="form-control" id="" name="">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6"> 
                                                <div class="form-group form-outline">
                                                    <label for="input" class="float-label">Virtual</label>
                                                    <i class="material-symbols-outlined">local_atm</i>
                                                    <input type="email" class="form-control" id="" name="">
                                                </div>
                                            </div>
                                        </div>
                                         <small class="primary fw-middle mb-0"><span class="asterisk">*</span>These are the appointment types that will be available for patients to book.</small>
                                    </div>
                                </div>
                            </form>
                            <div class="btn_alignbox justify-content-end mt-1 mt-3">
                                <button type="button" class="btn btn-primary" onclick="goToStep(3)">Save & Continue</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="step-section" data-step="3" style="display: none;">
                        <div class="onboard-box"> 
                            <div class="d-flex justify-content-between"> 
                                <div> 
                                    <h4 class="fw-bold">Payment Processing Setup</h4>
                                    <p class="text-muted">Choose how you'd like to process payments and manage payouts securely.</p>
                                </div>
                                <a href="" class="primary align_middle fw-medium"><span class="material-symbols-outlined">keyboard_backspace</span>Back</a>
                            </div>
                            <div class="border rounded-4 p-4 bg-white">
                                <div class="row g-3">
                                    <div class="col-lg-4 col-12 text-center">
                                        <h5 class="fw-medium mb-0">Connect Your Bank Account</h5>
                                        <p class="gray mb-3">Enable Fast, Secure Payouts for Your Patient Payments.</p>
                                        <img src="{{asset('/images/stripe.png')}}" alt="Connect Bank" class="img-fluid onboard-innerImg">
                                    </div>
                                    <div class="col-lg-8 col-12">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <h6 class="fw-medium">Why Connect Now?</h6>
                                                <ul class="list-unstyled imp-point">
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Receive payouts from patient subscriptions directly to your bank account</li>
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Enable seamless and automated revenue flow</li>
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Ensure compliance with financial regulations</li>
                                                </ul>
                                            </div>
                                            <div class="col-12">
                                                <h6 class="fw-medium">What You’ll Need</h6>
                                                <ul class="list-unstyled imp-point">
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>A valid government-issued ID</li>
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Your bank account number and routing code</li>
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Business details</li>
                                                </ul>
                                            </div>
                                            <div class="col-12">
                                                <h6 class="fw-medium">How It Works</h6>
                                                <p class="gray">We use Stripe Connect, a secure and trusted payment platform, to manage payouts. You’ll be redirected to Stripe’s onboarding form where you can:</p>
                                                <ul class="list-unstyled imp-point">
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Verify your identity</li>
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Enter your bank account details</li>
                                                    <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Complete tax information (if required)</li>
                                                </ul>
                                            </div>
                                            <div class="col-12">
                                                <p class="primary fw-light"><span class="primary fw-bold">Note:</span> Your data is securely processed by Stripe. BlackBag does not store or access your banking information.</p>
                                            </div>
                                            <div class="btn_alignbox justify-content-end">
                                                <button class="btn btn-outline-primary">I'll do this later</button>
                                                <button type="button" class="btn btn-primary" onclick="goToStep(4)">Connect With Stripe</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-section" data-step="4" style="display: none;">
                        <div class="onboard-box"> 
                            <div class="d-flex justify-content-between"> 
                                <div> 
                                    <h4 class="fw-bold">Patient Subscription Plans</h4>
                                    <p class="gray">Patient subscriptions help you deliver consistent care and generate recurring revenue. You can create multiple plans to suit different patient needs.</p>
                                </div>
                                <a href="" class="primary align_middle fw-medium"><span class="material-symbols-outlined">keyboard_backspace</span>Back</a>
                            </div>

                            <div class="col-lg-7 col-sm-10 col-12 mx-auto text-center">
                                 
                                <div class="my-4">
                                    <img src="{{asset('/images/sub-plan.png')}}" alt="Subscription Plans" class="img-fluid onboard-innerImg">
                                </div>

                                <h5 class="fw-bold mb-2">Let’s Set Up Your First Patient Subscription Plan</h5>
                                <p class="gray">Click <span class="fw-bold">“Add Plan”</span> to get started with your first subscription offering.</p>


                                <div class="btn_alignbox my-4">
                                    <button class="btn btn-outline-primary align_middle"><span class="material-symbols-outlined">file_save</span> Use a Template </button>
                                    <button class="btn btn-primary align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#addPlan"><span class="material-symbols-outlined">add</span>Add Plan</button>
                                </div>

                                <p class="fw-middle text-decoration-underline primary">We do not offer Patient Subscription Plans.</p>
                                <p class="gray primary fw-light"><span class="asterisk">*</span> You can always come back and add Patient Subscription Plans from your account settings.</p>
                            
                            </div>
                            <div class="col-12">
                                <div class="border rounded-4 p-4 bg-white"> 
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h3 class="fw-bold">Essential Care</h3>
                                            <p class="gray mb-3">Ideal for patients who need regular check-ins and basic healthcare support. This plan includes priority booking, access to general consultations, and discounted rates on lab tests.</p>
                                        </div>
                                        <div class="btn_alignbox">
                                            <a class="btn opt-btn" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editProfileInfo">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                            <a class="btn opt-btn danger" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editProfileInfo">
                                                <span class="material-symbols-outlined">delete</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="gray-border"></div>

                                    <div class="row text-center mt-3">
                                        <div class="col-6 col-lg-4">
                                            <div class="d-flex gap-3 text-start"> 
                                                <h2 class="fw-bold mb-0 font-large">$19</h2>
                                                <small class="gray">Monthly<br>Subscription Fee</small>
                                            </div>
                                        </div>
                                        <div class="col-1 border-l"> 
                                        </div>
                                        
                                        <div class="col-6 col-lg-4">
                                            <div class="d-flex gap-3 text-start">
                                                <h2 class="fw-bold mb-0 font-large">$199</h2>
                                                <small class="gray">Annual<br>Subscription Fee</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="fw-bold my-3">Card on File</h5>
                                <div class="border rounded-4 p-4 bg-white"> 
                                    <div class="user_inner">
                                        <img src="{{asset('/images/mastercard_logo.png')}}">
                                        <div class="user_info">
                                            <h6 class="primary fw-medium mb-1">Card Ending in 4444</h6>
                                            <p class="m-0">Expiry 04/2029</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_alignbox justify-content-end mt-3"> 
                                <button type="button" class="btn btn-outline align_middle"><span class="material-symbols-outlined">add</span>Add  Plan</button>
                                <button type="button" class="btn btn-primary" onclick="goToStep(5)">Save & Continue</button>
                            </div>
                        </div>
                    </div>
                    <div class="step-section" data-step="5" style="display: none;">
                        <div class="onboard-box"> 
                            <div class="d-flex justify-content-between"> 
                                <div> 
                                    <h4 class="fw-bold">Choose Addons</h4>
                                    <p class="gray">Enhance Your Practice with Add-ons</p>
                                </div>
                                <a href="" class="primary align_middle fw-medium"><span class="material-symbols-outlined">keyboard_backspace</span>Back</a>
                            </div>


                            <div class="col-12">
                                <div class="border rounded-4 p-4 bg-white"> 
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-8 mb-3 mb-md-0">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{asset('/images/escribe.png')}}" alt="icon" class="escribe-icon">
                                                <div>
                                                    <h4 class="gray fw-medium mb-1">Optional Add-On</h4>
                                                    <h2 class="font-large mb-0 fw-bold">ePrescribe</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <h5 class="mb-0 fw-bold">$79.00</h5>
                                            <div class="text-muted small">Per month</div>
                                        </div>
                                    </div>

                                    <div class="gray-border"></div>

                                    <div class="mt-3">
                                        <small class="fw-exlight">Add-On includes:</small>
                                        <ul class="list-unstyled imp-point mt-2 mb-0">
                                            <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>One-time Setup: $250</li>
                                            <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>12-month minimum commitment required</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="btn_alignbox justify-content-end mt-3"> 
                                <button class="btn btn-outline align_middle">Skip</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#enableAddon">Enable Add-on</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Add Plans --}}

<div class="modal login-modal fade" id="addPlan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">   
                <div class="text-start mb-3">           
                    <h4 class="fw-bold mb-0 primary">Add Subscription Plan</h4>
                    <small class="gray fw-light">Create flexible subscription plans with custom fees for in-person and virtual visits.</small>
                </div>
                <form>
                    <div class="row g-3"> 
                        <div class="col-12"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Plan Name</label>
                                <i class="material-symbols-outlined">workspace_premium</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-12"> 
                            <div class="form-group form-outline form-textarea">
                                <label for="" class="float-label">Plan Description</label>
                                <i class="fa-solid fa-file-lines"></i>
                                <textarea class="form-control" name="note" rows="4" cols="4"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Monthly Subscription Fee</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Yearly Subscription Fee</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-medium mt-4">Appointment Fee</h5>
                    <div class="form-check my-2">
                        <input class="form-check-input" type="checkbox" id="slot10">
                        <small class="primary">Do you have a different per appointment fee for this subscription.</small>
                    </div>
                    <div class="row"> 
                        <div class="col-12"> 
                            <p class="fw-medium primary mb-2">Enter your per appointment fee</p>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">In Person</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Virtual</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="btn_alignbox justify-content-end mt-3">
                    <a href="" class="btn btn-outline">Cancel</a>
                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#addCreditCard">Add Plan</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Credit Card --}}

<div class="modal login-modal fade" id="addCreditCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">  
                <div class="row">
                    <div class="col-sm-10 col-lg-8 mx-auto"> 
                        <div class="text-center mb-3">     
                            <img src="{{asset('/images/addcreditcard.png')}}" alt="Credit card" class="img-fluid onboard-innerImg">      
                            <h3 class="fw-bold my-3 primary">Zero-Dollar Appointments Require a Card on File</h3>
                            <p class="gray fw-light">To offer $0 appointments, a valid credit card must be saved to your account. A $5.00 service fee will be automatically charged to your card when the appointment begins. This ensures secure processing and uninterrupted access to appointment features.</p>
                        </div>    
                    </div>
                </div>
                <div class="btn_alignbox mt-3">
                    <a href="" class="btn btn-primary align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#addCard"><span class="material-symbols-outlined">add</span>Add Card</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Cards --}}

<div class="modal login-modal fade" id="addCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">   
                <div class="text-center mb-3">           
                    <h4 class="fw-bold mb-0 primary">Add New Card</h4>
                    <small class="gray fw-light">Please enter the card details</small>
                </div>
                <form>
                    <div class="row g-3"> 
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Card Number</label>
                                <i class="material-symbols-outlined">credit_card</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Name</label>
                                <i class="fa-solid fa-circle-user"></i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Expiry Month</label>
                                <i class="material-symbols-outlined">calendar_month</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Expiry Year</label>
                                <i class="material-symbols-outlined">calendar_month</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">CCV</label>
                                <i class="material-symbols-outlined">encrypted</i>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                </form>
           

                
                <div class="btn_alignbox justify-content-end mt-3">
                    <a href="" class="btn btn-outline">Close</a>
                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="">Add Card</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Users-enable add-on Modal -->
<div class="modal fade" id="enableAddon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl subscription-modal-xl ">
        <div class="modal-content subscription-modal p-0">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body p-0 ">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="subscription-box">
                            <h4>Subscribe to Blackbag ePrescribe</h4>
                            <div class="amount">
                                <h1 class="display-5 fw-bold">$79.00</h1>
                                <div>
                                    <p>ePrescription</p>
                                    <p>Monthly Fee</p>
                                </div>
                            </div>

                            <div class="feature-box d-flex gap-3">
                                <img src="{{asset('images/bb-eprescribe.png')}}" class="escribe-icon">
                                <div>
                                    <strong>Blackbag ePrescribe</strong><br />
                                    <small>
                                    BlackBag ePrescribe unlocks fast, accurate, and secure digital prescribing — helping you save time, reduce errors, and deliver a seamless experience for your patients.
                                    </small>
                                </div>
                            </div>
                            <div class="amount-list mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <p>One Time Setup Fee</p>
                                    <span><strong>$250.00</strong></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <p>Amount Per Prescriber</p>
                                    <span>($79.00 × 1) <strong class="ms-1">$79.00</strong></span>
                                </div>
                                <hr />
                                <div class="d-sm-flex  justify-content-between     total-price text-end  ">
                                    <span>Total Due Today</span>
                                    <span class="ms-2">$344.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Subscription Form -->
                <div class="col-lg-6">
                    <div class="form-container ">
                    <form>
                    <!-- Prescriber Selection -->
                    <div class="mb-4">
                        <h4 class="fw-bold mb-3">Prescribers</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-outline mb-3 no-iconinput">
                                    <label for="input">Select Patient</label>
                                
                                    <div class="dropdownBody">
                                        <div class="dropdown">
                                            <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                            </a>
                                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                                <li class="dropdown-item">
                                                    <div class="form-outline input-group ps-1">
                                                        <div class="input-group-append">
                                                        <button class="btn border-0" type="button">
                                                            <i class="fas fa-search fa-sm"></i>
                                                        </button>
                                                        </div>
                                                        <input type="text" class="form-control border-0 small" placeholder="Search Patient" aria-label="Search" aria-describedby="basic-addon2">
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="slt-prescribers">
                                    <div class="user_inner">
                                        <img src="{{asset('images/doct1.png')}}" class="img-fluid">
                                        <div class="user_info">
                                            <h6 class="primary fw-medium m-0">Jelani Kasongo, MD</h6>
                                            <p class="m-0">jelanikasongo@gmail.com</p>
                                        </div>
                                    </div>
                                    <div class="gray-borde mt-3 mb-3"></div>
                                    <div class="d-flex prescribers flex flex-wrap ">
                                        <p class="m-0">Would you like to enable Blackbag ePrescribe for yourself.</p>
                                        <div class="d-flex ms-3">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">YES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">NO</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>


          <!-- Card Info -->
          <h5 class="fw-bold mb-2">Payment Method</h5>
          <h6 class="sub-h mb-3">Card Information</h6>
          <div class="row mt-2">
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Name On Card</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Card Number</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Expiry</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">CCV</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
          </div>

          <!-- Billing Address -->
          <h6 class="sub-h my-3">Billing Address</h6>
          <div class="row mt-2">
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Address</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">City</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">ZIP</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
                        
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">State</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
                                    
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Countrye</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
          </div>

          <!-- Disclaimer -->
          <small class="text-muted d-block mb-3">
            <span class="text-danger">*</span> By confirming your subscription, you agree to an annual commitment and authorize BlackBag to charge you monthly in accordance with our terms. You may cancel anytime, and your subscription will remain active until the end of the billing period.
          </small>

          <!-- Submit Button -->
          <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#successSubscription">Confirm Subscription</button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
</div>
</div>

<!-- Users-enable add-on Modal -->


{{-- success modal --}}

<div class="modal login-modal fade" id="successSubscription" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('images/success_signin.png')}}" class="img-fluid">
                <h4 class="text-center fw-medium mb-0 mt-4">Eprescription enabled successfully</h4>
                <!-- <small class="gray">Your subscription plan has been updated</small> -->
            </div>
        </div>
    </div>
</div>



<script>

  function goToStep(step) {
    // Show selected step, hide others
    $('.step-section').hide();
    $('.step-section[data-step="' + step + '"]').show();

    // Toggle active class
    $('.circle').removeClass('active');
    $('.stepper[data-step="' + step + '"] .circle').addClass('active');
  }

  $(document).ready(function () {
    // Stepper click
    $('.stepper').click(function () {
      const step = $(this).data('step');
      goToStep(step);
    });

    // Continue button click
    $('.continue').click(function () {
      const nextStep = $(this).data('next');
      goToStep(nextStep);
    });

    // Initialize
    goToStep(1);
  });


</script>
  


</body>
</html>