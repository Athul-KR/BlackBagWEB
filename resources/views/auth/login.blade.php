<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@if(isset($seo['title'])){{ $seo['title'] }}  @else BlackBag @endif</title>
    <meta name='keywords' content="<?php echo (isset($seo['keywords']) && $seo['keywords']!= '') ? $seo['keywords'] : ''; ?>"/>
    <meta name="description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : ''; ?> ">
    <meta property="og:title" content="<?php echo (isset($seo['title']) && $seo['title']!= '') ? $seo['title'] : '{{ TITLE }}'; ?> ">
    <meta property="og:description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : '{{ TITLE }}'; ?>">
    <meta property="og:image" content="<?php echo (isset($seo['image']) && $seo['image']!= '') ? $seo['image'] : asset('images/Home.jpg') ?>">
    <meta property="og:image" content="{{asset('/images/og-img.png')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tele-med.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/colorbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">

    <!-- Include jQuery FIRST -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>

    <!-- Bootstrap and Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-DzrzPb/tnD82N+zJr1d8e5Rk5iAGlfjq4zFYDkmxSjcRI65n9zU5DwmPHne9QvU8" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/jquery.colorbox.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    
    <!-- Your Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
</head>

@if (session()->has('error'))
      <div class="">
        {{-- {{session()->get('error')}} --}}

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            swal({
              title: 'Error!',
              text: "{{ session()->get('error') }}",
              icon: 'warning',
              confirmButtonText: 'OK'
            });
          });
        </script>
      </div>

 @endif

      
<body class="bg-white">
    <style>
        .radio-input label{
            cursor: pointer;
        }
    </style>
    <section @if($userType == 'patient') class="signin-page patient-signin-page" @else class="signin-page client-signin-page" @endif>
        <div class="container-fluid p-0">
            <div class="row align-items-center position-relative">
                <div @if($userType == 'patient') class="col-12 col-lg-4 d-lg-block d-none" @else class="col-12 col-lg-6" @endif>

                    <div @if($userType == 'patient') class="patient-sign-in-left-sec" @else class="sign-in-left-sec" @endif>
                        <div class="d-flex justify-content-between w-100">
                            <img src="{{ asset('images/loginlogo.png')}}"  class="img-fluid" alt="Logo">
                            <a href="{{url('/login')}}" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
                        </div>
                        @if($userType != 'patient')
                        <div class="login-img-txt">
                            <h3>Virtual Care at Your Fingertips</h3>
                            <p>Providing you with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.</p>
                        </div>
                        @endif
                    </div>
                    <div class="d-lg-none d-block d-flex justify-content-center mob-logo w-100">
                        <img src="{{asset('images/loginlogo.png')}}" class="img-fluid logo_singin mb-4" alt="Logo">
                        <a href="{{url('/login')}}" onclick="backTologin()" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
                    </div>
                </div>

                <div @if($userType == 'patient') class="col-12 col-lg-8" @else class="col-12 col-lg-6" @endif >
                    <div class="card-body">
                        <div class="row" id="login">
                            <div class="col-12 position-absolute top-0 end-0"> 
                                <div class="btn_alignbox justify-content-end p-lg-0 p-3"> 
                                    <a class="primary fw-medium d-flex align-items-center gap-1 back-btn" href="{{url('/')}}"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-9 mx-auto">
                                <div class="login-form text-center position-relative">

                                    <p id="credslabel" class="top-error"></p>
                                    <div class="mt-4">

                                        <h1>Welcome Back</h1>
                                        <p>Please enter your details to sign in.</p>

                                        <ul class="nav nav-tabs login-tabs border-0 mb-4 gap-2" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                              <button class="nav-link active logintabs" id="number-tab" data-bs-toggle="tab" data-bs-target="#number" type="button" role="tab" aria-controls="number" aria-selected="true">Login with Mobile</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                              <button class="nav-link logintabs" id="mails-tab" data-bs-toggle="tab" data-bs-target="#mails" type="button" role="tab" aria-controls="mails" aria-selected="false">Login with Email</button>
                                            </li>
                                           
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="number" role="tabpanel" aria-labelledby="number-tab">
                                                <form method="POST" id="loginformuser" autocomplete="off">
                                                    @csrf
        
                                                    <input type="hidden" class="form-control"  id="timezoneOffset" name="timezoneOffset" >
                                                    <div class="phonenum_group">
        
                                                        <div class="country_code phone">
                                                            <input type="hidden" id="countryCode" name="countrycode" value="<?php echo isset($countrycode->country_code)  ? $countrycode->country_code : '+1' ?>">
                                                            <input type="hidden" id="countryCodeShort" name="countryCodeShort" value="<?php echo isset($countrycode->short_code)  ? $countrycode->short_code : 'us' ?>" >
                                                        </div>
        
                                                        <div class="form-group form-outline mb-4 flex-grow-1">
                                                            <input type="tel" name="phonenumber" class="form-control phone-number" id="phonenumber" placeholder="Enter phone number" @if(isset($phone) && $phone !='' ) value="<?php echo $phone ?>" @endif required>
                                                        </div>
                                                    </div>
        
                                                    <input type="hidden" name="invitationkey" id="invitationkey" class="form-control" value="@if(isset($_GET['invitationkey']) && $_GET['invitationkey'] !=''){{$_GET['invitationkey']}}@endif">
                                                    <input type="hidden" name="userType" id="userType" class="form-control" value="{{$userType}}">

        
                                                    <a id="sendotp" onclick="submitLogin()" class="btn btn-primary w-100">Send OTP</a>
                                                    <p class="m-0 mt-5">Don't have a BlackBag account?</p>
                                                    <div class="btn_inner">
                                                        <a class="primary fw-medium text-decoration-underline" onclick="signUp('{{$userType}}')">Sign Up</a>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="tab-pane fade" id="mails" role="tabpanel" aria-labelledby="mails-tab">

                                                <form method="POST" id="loginemailform" autocomplete="off">
                                                    @csrf
        
                                                    {{-- <a  onclick="continueWithEmail()" class="btn btn-outline d-flex align-items-center justify-content-center  w-100"><img src="{{ asset('images/googleImg.png')}}" class="img-fluid">Continue with Email</a> --}}
                                                   
                                                  
        
                                                    <input type="hidden" class="form-control"  id="timezoneOffset" name="timezoneOffset" >
                                                    <div class="form-group form-outline mb-4">
                                                        <label for="input" class="float-label">Email</label>
                                                        <i class="fa-solid fa-envelope"></i>
                                                        <input type="email" class="form-control" name="email" id="email">
                                                      </div>

                                                    <input type="hidden" name="invitationkey" id="invitationkey" class="form-control" value="@if(isset($_GET['invitationkey']) && $_GET['invitationkey'] !=''){{$_GET['invitationkey']}}@endif">
                                                    <input type="hidden" name="userType" id="userType" class="form-control" value="{{$userType}}">
        
                                                    <a onclick="submitEmailLogin()" class="btn btn-primary w-100">Send OTP</a>
                                                    <p class="m-0 mt-5">Don't have a BlackBag account?</p>
                                                    <div class="btn_inner">
                                                        <a class="primary fw-medium text-decoration-underline" onclick="signUp()">Sign Up</a>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                        </div>
                                          
                                        


                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- OTP -->
                        <div class="row" id="otpform" style="display: none;">
                            <div class="col-12 position-absolute top-0 end-0"> 
                                <div class="btn_alignbox justify-content-end p-lg-0 p-3"> 
                                    <a class="primary fw-medium d-flex align-items-center gap-1 back-btn" href="{{url('/')}}"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-8 mx-auto">
                                <div class="login-form text-center">
                                    <!-- <div class="top-login"></div> -->
                                    <div class="mt-4">
                                        <h4 class="text-center fw-medium mb-0" id="otptitle" >Verify Phone Number</h4>
                                        <small class="gray">OTP has been sent to <span class="fw-medium primary phn-otp" id="otpPhone"></span></small>

                                        <form method="POST" id="verifyotpform" autocomplete="off">
                                            @csrf
                                            <input type="hidden" class="form-control"  id="timezoneOffset" name="timezoneOffset" >
                                            <div class="form-group otp-input my-4">
                                                <input type="text" class="form-control otp-input-field" id="otp1" aria-describedby="emailHelp" maxlength="1">
                                                <input type="text" class="form-control otp-input-field" id="otp2" aria-describedby="emailHelp" maxlength="1">
                                                <input type="text" class="form-control otp-input-field" id="otp3" aria-describedby="emailHelp" maxlength="1">
                                                <input type="text" class="form-control otp-input-field" id="otp4" aria-describedby="emailHelp" maxlength="1">
                                                <input type="hidden" name="otp" id="otp_value" class="form-control">
                                                <input type="hidden" name="hasOtp" id="hasOtp" class="form-control" value="1">
                                                <input type="hidden" name="type" id="type" class="form-control" value="">
                                                <input type="hidden" name="userType" id="userTypes" class="form-control" value="">
                                                <input type="hidden" name="isregister" id="isregister" class="form-control" value="0">

                                                
                                            </div>
                                            <input type="hidden" name="logintype" class="form-control" id="logintype">
                                            <input type="hidden" name="email" class="form-control" id="emailsubmit">

                                            <input type="hidden" name="otpkey" class="form-control" id="otpkey">
                                            <input type="hidden" name="phonenumber" class="form-control" id="phonenumbers">
                                            <input type="hidden" name="countrycode" class="form-control" id="countrycode">
                                            <input type="hidden" name="countryCodeShort" class="form-control" id="countryCodeShorts">
                                        </form>
                                        <div class="btn_alignbox flex-column">
                                            <a id="loginsubmit" class="btn btn-primary w-100" onclick="verifyOtp()">Sign In</a>
                                            <p class="mt-3 mb-0">Didn’t get OTP Code?</p>
                                            <div class="d-flex">
                                                <a onclick="resendOtp()" href="javascript:void(0)" id="resendOtp" class="primary fw-medium text-decoration-underline disabled">Resend OTP</a><span id="timer" class="gray timeR ms-2"> in 30s</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                      

                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    

<!-- Loader -->

<div class="modal login-modal fade" id="googlelogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
           

            <div class="modal-body">
                <h4 class="text-center fw-medium mb-4 px-md-5 px-3">Continue with Email</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="login-form text-center ">
                            <form class="" id="loginemailform" autocomplete="off">
                                <input type="hidden" class="form-control"  id="timezoneOffset" name="timezoneOffset" >
                                <a href="{{url('login/google')}}" class="btn btn-outline d-flex align-items-center justify-content-center  w-100 mb-3"><img src="{{ asset('images/googleImg.png')}}" class="img-fluid">Continue with Google</a>
                                <p class="my-4">OR</p>
                                <a onclick="emailLogin()" class="btn btn-outline d-flex align-items-center justify-content-center  w-100 mb-4" > <i class="fa-solid fa-envelope me-2"></i>Continue with Email</a>
                           
                                  
                                    <div class="form-group form-outline mb-4 loginemailcls"  style="display:none;" >
                                            <label for="input" class="float-label">Email</label>
                                            <i class="fa-solid fa-envelope"></i>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div> 
                                    <a style="display:none;" id="loginemails" onclick="submitEmailLogin()" class="btn btn-primary w-100 loginemailcls">Send OTP</a>
                           
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>



<!----Loader --->

<div class="modal login-modal fade" id="successSignin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('images/success_signin.png')}}" class="img-fluid">
                <h4 class="text-center fw-medium mb-0 ">Welcome to BlackBag</h4>
                <small class="gray">Your account has been successfully created.</small>
            </div>
        </div>
    </div>
</div>
<div class="modal login-modal fade" id="successphoneverify" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img alt="Blackbag" src="{{asset('images/invite-img.png')}}" class="img-fluid">
                <h4 class="fw-bold mb-1 mt-3">Phone Number Verified</h4>
                    </div>
        </div>
    </div>
</div>




<!------------- modal-signin -------------->

<div class="modal login-modal fade" id="signin" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content overflow-hidden">
            <div class="modal-header modal-bg p-0 position-relative">
                <img src="{{ asset('images/signin-bg.png')}}" class="img-fluid rounded-3" alt="">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <h4 class="text-center fw-medium mb-4 px-md-5 px-3">Create an account and connect with your patients</h4>
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="login-form text-center ">
                            <form class="">

                                <input type="hidden" class="form-control"  id="timezoneOffset" name="timezoneOffset" >

                                <!-- <a href="{{url('login/google')}}" class="btn btn-outline d-flex align-items-center justify-content-center  w-100 mb-3"><img src="{{ asset('images/googleImg.png')}}" class="img-fluid">Continue with Google</a> -->


                                <a onclick="registerUser()" class="btn btn-outline d-flex align-items-center justify-content-center  w-100 mb-3" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#create-your-profile"> <i class="fa-solid fa-envelope me-2"></i>Sign up with Email </a>
                            </form>
                            <p class="mx-auto">By signing up you agree to the <a href="#" class="primary text-decoration-underline">Terms of Service</a> and <a href="#" class="primary text-decoration-underline">Privacy Policy</a>, as well as the <a href="#" class="primary text-decoration-underline">Cookie Policy</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-----------------------------end--- modal-signin --------------------------------->


<!-------------------------------- create your profile --------------------------------->

<div class="modal login-modal fade" id="registerUser" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center" id="registerUserForm">



            </div>
        </div>
    </div>
</div>

<!------------------------------end-- create your profile --------------------------------->
 <!-- User Type -->

        <div class="modal login-modal fade" id="userTypemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body p-4">
                  <div class="text-center">
                    <h4 class="fw-bold mb-0">Choose Your User Type</h4>
                    <small>Select your user type to get started</small>
                  </div>
                  <div class="user_Type mt-4">
                    <div class="radio-input">
                      <input value="clinic" name="value-radio" id="value-1" type="radio" />
                        <label for="value-1" class="justify-content-between">
                            <div class="userTypeInner">
                                <img src="{{ asset('images/clinic.png')}}" class="img-fluid">
                                <div class="userTypeInfo">
                                    <h6 class="primary fw-medium mb-1">Provider/Clinic</h6>
                                    <small>Efficiently manage your clinic operations</small>
                                </div>
                            </div>
                             <span  style="display: none;" class="material-symbols-outlined selected-tick cliniccheck">task_alt</span>
                        </label>

                        <input value="patient" name="value-radio" id="value-2" type="radio" />
                        <label for="value-2" class="justify-content-between">
                            <div class="userTypeInner">
                                <img src="{{asset('images/patient.png')}}" class="img-fluid">
                                <div class="userTypeInfo">
                                    <h6 class="primary fw-medium mb-1">Patient</h6>
                                    <small>Connect with clinicians and get expert advice</small>
                                </div>
                            </div>
                            <span style="display: none;" class="material-symbols-outlined selected-tick patientcheck">task_alt</span>
                        </label>
                    </div>
                    <div class="btn_alignbox mt-4">
                      <a onclick="handleNextClick()" class="btn btn-primary w-100" >Next</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <!----User Type --->
        @php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp

    <!-- Correct script order -->
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- Bootstrap JS (with Popper.js for modals to work) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

    <script type="text/javascript">

function handleNextClick() {
            const selectedType = $('input[name="value-radio"]:checked').val();
            
            if (selectedType === 'clinic') {
                $("#userTypemodal").modal('hide');
               
                registerUser();
            } else if (selectedType === 'patient') {
                $("#userTypemodal").modal('hide');
                redirectToPatient();
            }
        }
    $(document).ready(function() {
            // Handle radio button changes
        $('input[name="value-radio"]').change(function() {
            // Remove selected class from all userTypeInner elements
            $('.userTypeInner').removeClass('selected');
            
            // Add selected class to the parent userTypeInner of the clicked radio button
            $(this).next('label').find('.userTypeInner').addClass('selected');
            
            const selectedType = $('input[name="value-radio"]:checked').val();
            $(".selected-tick").hide();
            if (selectedType === 'clinic') {
                $(".cliniccheck").show();
            } else if (selectedType === 'patient') {
                $(".patientcheck").show();
            }

        });
       
    });
$(document).ready(function() {


    
    $('#phonenumber').mask('(ZZZ) ZZZ-ZZZZ', {
            translation: {
                'Z': {
                    pattern: /[0-9]/,
                    optional: false
                }
            }
        });

    // Handle tab switching
    $('.logintabs').on('click', function() {
        $("#phonenumber").val('');
        $("#email").val('');
    });
});
    

        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
         function handleError(xhr) {
    if (xhr.status === 419) {
        // Session expired logic
        const response = JSON.parse(xhr.responseText);
        var toURL = "{{ URL::to('/login')}}";
        if (response.message) {
            swal({
                icon: 'error',
                title: 'Session Expired',
                text: 'Your session has expired. Please log in again.',
                buttons: {
                    confirm: {
                        text: 'OK',
                        value: true,
                        visible: true,
                        className: 'btn-danger'
                    }
                }
            }).then(() => {
                // Redirect to the login page
                window.location.href = toURL;  // Explicit login redirect instead of reloading
            });
        }
    } else {
        // Handle other errors (e.g., server errors, network errors)
        swal({
            icon: 'error',
            title: 'An Error Occurred',
            text: xhr.responseText || 'Something went wrong. Please try again later.',
            buttons: {
                confirm: {
                    text: 'Close',
                    value: true,
                    visible: true,
                    className: 'btn-primary'
                }
            }
        });
    }
}


        function continueWithEmail(){
            $("#googlelogin").modal('show');
        }
        function showOTPPage(){
            $(".backbtn").show();
            $("#login").hide();
            $("#otpform").show();
            $('#otp1').focus();
            $("#otpkey").val("{{Session::get('tempuser.otpkey')}}");
            $("#phonenumbers").val("{{Session::get('tempuser.phonenumbers')}}");
            $("#countrycode").val("{{Session::get('tempuser.countrycode')}}");
            $("#countryCodeShorts").val("{{Session::get('tempuser.countryCodeShorts')}}");
            $('#otpPhone').text("{{Session::get('tempuser.countrycode')}}" + ' ' + "{{Session::get('tempuser.phonenumbers')}}");
            $("#userTypes").val('clinics');
            $("#isregister").val('1');
            let otp = "{{Session::get('tempuser.otp')}}"
            Swal.fire({
                icon: 'success',
                title: '',
                text: "An OTP has been sent to your registered phone number.(" + otp + ")",
            });
            resendCountdown();
             // Clear session values after function execution
            $.ajax({
                url: "{{ URL::to('cleartempuser/')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"  // CSRF token for security
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Session cleared successfully");
                },
                error: function(xhr) {
                    console.log("Error clearing session");
                }
            }); 
        }
        $(document).ready(function() {
            var isRegisterOtp = "{{Session::get('tempuser.isregister')}}";
            if(isRegisterOtp == '1'){
                showOTPPage(); 
            }

            var telInput = $("#phonenumber"),
                countryCodeInput = $("#countryCode"),
                countryCodeShort = $("#countryCodeShort"),
                errorMsg = $("#error-msg"),
                validMsg = $("#valid-msg");
                let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
                let initialCountryCode = "{{ $countrycode->short_code ?? 'us' }}";
            // initialise plugin
            telInput.intlTelInput({
                autoPlaceholder: "polite",
                initialCountry: initialCountryCode,
                formatOnDisplay: false, // Enable auto-formatting on display
                autoHideDialCode: true,
                defaultCountry: "auto",
                ipinfoToken: "yolo",
                onlyCountries: onlyCountries,
                nationalMode: false,
                numberType: "MOBILE",
                separateDialCode: true,
                geoIpLookup: function(callback) {
                    $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "";
                        callback(countryCode);
                    });
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Ensure latest version
            });

            var reset = function() {
                telInput.removeClass("error");
                errorMsg.addClass("hide");
                validMsg.addClass("hide");
            };

            telInput.on("countrychange", function(e, countryData) {
                var countryShortCode = countryData.iso2;
                countryCodeInput.val(countryData.dialCode);
                countryCodeShort.val(countryShortCode);
            });

            telInput.blur(function() {
                reset();
                if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                    } else {
                        telInput.addClass("error");
                        errorMsg.removeClass("hide");
                    }
                }
            });

            telInput.on("keyup change", reset);



            $('#loginformuser').keypress(function(event) {
                if (event.which === 13) { // Enter key code is 13
                    event.preventDefault(); // Prevent the default form submit
                    submitLogin(); // Trigger form submit
                }
            });
            $('#loginemailform').keypress(function(event) {
                if (event.which === 13) { // Enter key code is 13
                    event.preventDefault(); // Prevent the default form submit
                    submitEmailLogin(); // Trigger form submit
                }
            });


            /* timezone */
            var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;            
            var timeZoneMapping = {
                "Asia/Calcutta": "Asia/Kolkata",       
            };
            var mappedTimeZone = timeZoneMapping[timeZone] || timeZone;
            $('#timezoneOffset').val(mappedTimeZone);
          

        });

        function redirectToPatient() {
           window.location.href="{{url('register')}}"
        }
        function validateUser() {
            $("#loginformuser").validate({
                rules: {
                    phonenumber: {
                        required: true,
                        NumberValids: true,
                        // minlength: 10,
                        // maxlength: 13,
                        // number: true
                    }
                },
                messages: {
                    phonenumber: {
                        required: 'Please enter phone number.',
                        NumberValids: 'Please enter a valid number.',
                        minlength: 'Please enter a valid number.',
                        maxlength: 'Please enter a valid number.',
                        // number: 'Please enter a valid number.'
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass("phone-number")) {
                        // Remove previous error label to prevent duplication
                        $("#phonenumber-error").remove();
                        // Insert error message after the correct element
                        error.insertAfter(".separate-dial-code");
                    } else {
                        error.insertAfter(element);
                    }
                },
                success: function(label) {
                    // If the field is valid, remove the error label
                    label.remove();
                }
            });
            jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
            return this.optional(element) || phone_number.length < 14 &&
                phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
        });
        }

        function validateLoginUser() {
            $("#loginemailform").validate({
                rules: {
                    email: {
                        required: true,
                       
                    }
                },
                messages: {
                    email: {
                        required: 'Please enter email.',
                       
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass("phone-number")) {
                        // Remove previous error label to prevent duplication
                        $("#phonenumber-error").remove();
                        // Insert error message after the correct element
                        error.insertAfter(".separate-dial-code");
                    } else {
                        error.insertAfter(element);
                    }
                },
                success: function(label) {
                    // If the field is valid, remove the error label
                    label.remove();
                }
            });
        }


        function backTologin() {
            $("#login").show();
            $("#otpform").hide();
            $(".backbtn").hide();
        }
        function submitEmailLogin(){
            validateLoginUser();
            let formdata = $("#loginemailform").serialize();
            if ($("#loginemailform").valid()) {
                
                $("#loginemails").addClass('disabled');
                $.ajax({
                    url: '{{ url("/submitlogin")}}',
                    type: "post",
                    data: {
                        'logintype' : 'email' ,
                        'formdata': formdata,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            
                            $("#googlelogin").modal('hide');

                            $(".backbtn").show();
                            $("#login").hide();
                            $("#otpform").show();
                            $('#otp1').focus();
                            $("#otpkey").val(data.key);
                            $("#phonenumbers").val(data.phonenumber);
                            $("#countrycode").val(data.countrycode);
                            $("#countryCodeShorts").val(data.countryCodeShort);
                            $('#otpPhone').text(data.email );
                             $("#userTypes").val(data.userType);
                            $("#emailsubmit").val(data.email);
                             $("#logintype").val('email');
                             $('#otptitle').text('Verify email');
                             
                            $("#type").val(data.type);

                            Swal.fire({
                                icon: 'success',
                                title: '',
                                text: "An OTP has been sent to your email",
                            });

                            // swal("An OTP has been sent to your registered phone number.("+ data.otp+")", "", "success");
                            resendCountdown();
                        } else {
                            $("#loginemails").removeClass('disabled');
                           
                            showOtpError(data.errormsg, 'login');
                         
                        }
                    },
                    error: function(xhr) {
               
                        handleError(xhr);
                    }
                });

            } else {
                if ($('.error:visible').length > 0) {
                    setTimeout(function() {
                        $('html, body').animate({
                            scrollTop: ($('.error:visible').first().offset().top - 100)
                        }, 500);
                    }, 500);
                }
            }
        }

        function submitLogin(type='') {
            
            validateUser()
            if ($("#loginformuser").valid()) {
                $("#sendotp").addClass('disabled');
                let formdata = $("#loginformuser").serialize();
                $.ajax({
                    url: '{{ url("/submitlogin")}}',
                    type: "post",
                    data: {
                        'logintype' : type ,
                        'formdata': formdata,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            $(".backbtn").show();
                            $("#login").hide();
                            $("#otpform").show();
                            $('#otp1').focus();
                            $("#otpkey").val(data.key);
                            $("#phonenumbers").val(data.phonenumber);
                            $("#countrycode").val(data.countrycode);
                            $("#countryCodeShorts").val(data.countryCodeShort);
                            $('#otpPhone').text(data.countrycode + ' ' + data.phonenumber);
                            $("#type").val(data.type);
                            $("#userTypes").val(data.userType);
                            
                            Swal.fire({
                                icon: 'success',
                                title: '',
                                text: "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                            });
                            $("#sendotp").removeClass('disabled');
                            // swal("An OTP has been sent to your registered phone number.("+ data.otp+")", "", "success");
                            resendCountdown();
                        } else {
                            $("#sendotp").removeClass('disabled');
                            showOtpError(data.errormsg, 'login');
                        }
                    },
                    error: function(xhr) {
                        handleError(xhr);
                    }
                });

            } else {
                if ($('.error:visible').length > 0) {
                    setTimeout(function() {
                        $('html, body').animate({
                            scrollTop: ($('.error:visible').first().offset().top - 100)
                        }, 500);
                    }, 500);
                }
            }

        }

        let isRequestInProgress = false; // Flag to prevent multiple AJAX calls

        function verifyOtp() {
          
            if (isRequestInProgress) {
                return;
            }

           let otp = $('.otp-input-field').map(function () {
                        return this.value;
                    }).get().join('');
                    $('#otp_value').val(otp);

            // If the form passes validation
            if ($("#verifyotpform").valid()) {
                $("#loginsubmit").addClass('disabled');
               

                isRequestInProgress = true; // Set the flag to true when the request starts

                $.ajax({
                    url: '{{ url("/verifyotp") }}',
                    type: "post",
                    data: {
                        'formdata': $("#verifyotpform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        // alert(data);
                        if (data.success == 1) {
                            if(data.type == 'patient'){
                                
                                if(data.isregister == '1'){
                                    $("#loader").modal('show');
                                    setTimeout(function() {
                                        $("#loader").modal('hide');
                                        $("#otpform").hide(); // Hide the loader modal
                                        $("#successSignin").modal('show'); // Show the success modal
                                    }, 2000); // 2 seconds
                                    // Redirect to the dashboard after an additional 3 seconds
                                    setTimeout(function() {
                                        $("#successSignin").modal('hide'); 
                                        $("#registerpatient").hide();
                                        $("#patientsuccess").show();
                                        // window.location.href = "{{ url('/dashboard') }}"; // Redirect to the dashboard
                                    }, 2000);
                                    
                                }else{
                                 
                                    //alert(data.hasRedirect);
                                    if(data.hasRedirect == '0'){

                                        window.location.href = data.redirectURL;

                                    }else{
                                        window.location.href = "{{url('/patient/dashboard')}}"; 
                                    }
                                }
                               
                            }else{
                             
                                 //    BB-308
                                 if(data.isregister == '1'){
                                    $("#registerUser").modal('hide'); 
                                    $("#successphoneverify").modal('show');
                                    setTimeout(function() {

                                        window.location.href = "{{ url('/onboarding') }}" ;
                                    }, 2000); // 2 seconds

                                 }else{
                                 
                                    if(data.hasRedirect == '2'){
                                        window.location.href = "{{ url('doctor/onboarding') }}/"+data.lastStep ;
                                    }else if(data.hasRedirect == 0){
                                        window.location.href = "{{ url('/connecttostripe') }}?redirectURL=" + encodeURIComponent(data.redirectURL);
                                    }else{
                                        
                                        window.location.href = "{{url('/dashboard')}}";
                                    }
                                  
                                 }
                                if(data.isregister == '1'){
                                    $("#registerUser").modal('hide'); // Hide the registration modal
                                    $("#loader").modal('show'); // Show the loader modal
                                    // Show successSignin modal after 2 seconds
                                    // setTimeout(function() {
                                    //     $("#loader").modal('hide'); // Hide the loader modal
                                    //     $("#successSignin").modal('show'); // Show the success modal
                                    // }, 2000); // 2 seconds
                                }
                               
                              
                            }
                          
                           
                        } else {
                            $("#loginsubmit").removeClass('disabled');
                            $('.otp-input-field').val('');
                            // Optionally reset the hidden 'otp_value' field as well
                            $('#otp_value').val('');
                            $('.otp-input-field').each(function() {
                                $(this).blur(); // Remove focus from all OTP fields
                            });
                            $('.otp-input-field').first().focus();
                            // When OTP verification fails, show an error
                            showOtpError(data.errormsg); // Call the error display function
                             isRequestInProgress = false;
                        }
                    },
                    error: function(xhr) {
               
                        handleError(xhr);
                    }
                });
                    
                  
            } else {
                // If form validation fails
                if ($('.error:visible').length > 0) {
                    setTimeout(function() {
                        $('html, body').animate({
                            scrollTop: ($('.error:visible').first().offset().top - 100)
                        }, 500);
                    }, 500);
                }
            }
        }
     


        // Function to display OTP error message dynamically
        function showOtpError(message, type = '') {
            var otpField, errorElement;

            if (type == 'login') {
                otpField = $('#credslabel'); // The field where the OTP is entered
                errorElement = $('<label class="error"></label>').text(message);
                otpField.html(errorElement);
            } else {
                otpField = $('#otp_value'); // The field where the OTP is entered
                errorElement = $('<label class="error"></label>').text(message); // Create the error label
                otpField.after(errorElement); // Insert error message after the OTP input field
            }



            // Fade out the error message after 10 seconds
            setTimeout(function() {
                errorElement.fadeOut(500, function() {
                    $(this).remove(); // Remove the element from the DOM after fading out
                });
            }, 3000); // 10000 milliseconds = 10 seconds

        }


        $(document).ready(function() {
            /** remove validation if exists */
            otpField = $('.phone-number');
            otpField.on('input', function() {
                if ($(this).val().length === 0) {

                    otpField.next('.error').fadeOut(500, function() {
                        $(this).remove(); // Remove the error message when the field is cleared
                    });
                }
            });

            // Initialize form validation
            $("#verifyotpform").validate({
                ignore: [],
                rules: {
                    otp: {
                        required: true,
                        minlength: 4 // Ensure at least 4 digits
                    }
                },
                messages: {
                    otp: {
                        required: 'Please enter OTP.',
                        minlength: 'OTP must be at least 4 digits long.'
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element); // Place error messages after the input fields
                }
            });



        });



        function resendOtp() {
            $('#resendOtp').addClass('disabled');
            var logintype =   $("#logintype").val(); 
            $.ajax({
                url: '{{ url("/submitlogin") }}',
                type: "post",
                data: {
                    'logintype' :logintype ,
                    'formdata': $("#verifyotpform").serialize(),
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#login").hide();
                        $("#otpform").show();
                        $('.otp-input-field').val('');
                        $("#otpkey").val(data.key);
                        $("#phonenumbers").val(data.phonenumber);
                        $("#countrycode").val(data.countrycode);
                        $("#countryCodeShort").val(data.countryCodeShort);
                        //$("#userTypes").val(data.userType);
                        if(logintype == 'email'){
                            Swal.fire({
                                icon: 'success',
                                title: '',
                                text: "An OTP has been sent to your email",
                            });
                        }else{
                            Swal.fire({
                            icon: 'success',
                            title: '',
                            text: "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                        });
                        }
                      
                        resendCountdown()
                    } else {

                    }
                },
                error: function(xhr) {
                    handleError(xhr); 
                   
                }
            });

        }

        function emailLogin(){
            $(".loginemailcls").show();
        }

    </script>

    <script>
        $(document).ready(function() {

            // When typing in an OTP field

            $('.otp-input-field').on('keyup input', function(e) {
            var key = e.which || e.keyCode;
            var $currentField = $(this);
            var $nextField = $currentField.next('.otp-input-field');
            var $prevField = $currentField.prev('.otp-input-field');

            // Move to the next field on valid input (0-9 from both main row and keypad)
            if ($currentField.val().length === 1 && ((key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                if ($nextField.length) {
                    $nextField.focus();  // Move to the next input field
                }
            }

            // Move to the previous field on backspace
            if (key === 8 && $prevField.length && $currentField.val().length === 0) {
                $prevField.focus();  // Move to the previous input field
            }


            // Prevent non-numeric input (for both main number row 0-9 and numeric keypad)
            if ((key < 48 || key > 57) && (key < 96 || key > 105)) {
                e.preventDefault();
            }

            // Check if all fields are filled
             if ($('.otp-input-field').filter(function () { return this.value.length === 0; }).length === 0) {
                    // Combine the OTP fields' values into the hidden input
                    let otp = $('.otp-input-field').map(function () {
                        return this.value;
                    }).get().join('');
                    $('#otp_value').val(otp);

                    // Automatically call verifyOtp if all fields are filled
                    verifyOtp();
                }
        });



           
        
            // Ensure only digits can be entered
            $('.otp-input-field').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-digit characters
            });

            


        });

        function resendCountdown() {
            var timerDuration = 30; // Duration in seconds
            var timer = timerDuration; // Set the initial timer value

            console.log('timer')
            // Start the countdown
            var countdown = setInterval(function() {
                if (timer > 0) {
                    $('#resendOtp').addClass('disabled');
                    $('#timer').text(' in ' + timer + 's');
                    timer--;
                } else {
                    // Enable the Resend OTP link after countdown
                    clearInterval(countdown);
                    $('#timer').text(''); // Clear the timer text
                    $('#resendOtp').removeClass('disabled'); // Enable the link
                    $('#resendOtp').off('click'); // Remove the previous click event to allow resending
                }
            }, 1000); // 1 second interval


        }
        
        
        function signUp(userType) {
            //alert("test");
            $("#userTypemodal").modal('show');
            $('.userTypeInner').removeClass('selected');
            $('input[name="value-radio"]').prop('checked', false);
            $(".selected-tick").hide();
            /** for patient sign upo  page */
            
           
        }

        function registerUser() {
            var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;            
            var timeZoneMapping = {
                "Asia/Calcutta": "Asia/Kolkata",       
            };
            var mappedTimeZone = timeZoneMapping[timeZone] || timeZone;
            $.ajax({
                url: '{{ url("registerclinic") }}',
                type: "post",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'timezoneOffset': mappedTimeZone
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#userTypemodal").modal('hide');
                        $("#registerUser").modal('show');
                        $("#registerUserForm").html(data.view);
                        initializeAutocomplete();
                    } else {

                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });

            // $('#registerUser')[0].reset();
            // $('#registerUser').validate().resetForm();

        }

        function submitClinic() {
            if ($("#registerform").valid()) {
                $("#save_clinic").addClass('disabled');

                $.ajax({
                    url: '{{ url("clinic/store") }}',
                    type: "post",
                    data: {
                        'formdata': $("#registerform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        if (data.success == 1) {

                                $("#registerUser").modal('hide')
                                $(".backbtn").show();
                                $("#login").hide();
                                $("#otpform").show();
                                $('#otp1').focus();
                                $("#otpkey").val(data.key);
                                $("#phonenumbers").val(data.phonenumber);
                                $("#countrycode").val(data.countrycode);
                                $("#countryCodeShorts").val(data.countryCodeShort);
                                $('#otpPhone').text(data.countrycode + ' ' + data.phonenumber);
                                $("#type").val(data.type);
                                $("#userTypes").val('clinics');
                                $("#isregister").val('1');
                                Swal.fire({
                                    icon: 'success',
                                    title: '',
                                    text: "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                                });
                                resendCountdown();

                           
                        } else {
                            $("#save_clinic").removeClass('disabled');
                            if (data.error == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: '',
                                    text: data.message,
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        handleError(xhr);
                    }
                });

            } else {
                $("#save_clinic").removeClass('disabled');
                if ($('.error:visible').length > 0) {
                    setTimeout(function() {
                     
                    }, 500);
                }
            }

        }





// Function to toggle the 'active' class

function toggleLabel(input) {
     const hasValueOrFocus = $.trim(input.value) !== '';
    
     $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
   }

 

     // Initialize label state for each input
     $('input').each(function() {
       toggleLabel(this);
     });

     // Handle label toggle on focus, blur, and input change
     $(document).on('focus blur input change', 'input, textarea', function() {
       toggleLabel(this);
     });

     // Handle the datetime picker widget appearance by re-checking label state
     $(document).on('click', '.bootstrap-datetimepicker-widget', function() {
       const input = $(this).closest('.time').find('input');
       toggleLabel(input[0]);
     });

     // Trigger label toggle when modal opens
    //  $(document).on('shown.bs.modal', function(event) {
    //    const modal = $(event.target);
    //    modal.find('input, textarea').each(function() {
    //      toggleLabel(this);
        
    //    });
    //  });

     // Reset label state when modal closes
     $(document).on('hidden.bs.modal', function(event) {
       const modal = $(event.target);
       modal.find('input, textarea').each(function() {
         $(this).parent().find('.float-label').removeClass('active');
       });
     });




  // floating label end



    </script>

    
       
     
</body>

</html>
