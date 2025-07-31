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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <!-- Your Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
</head>

<body class="bg-white">
     <section class="signin-page client-signin-page" >
        <div class="container-fluid p-0">
            <div class="row align-items-center position-relative">
                <div  class="col-12 col-lg-6 d-lg-block d-none" >

                    <div class="sign-in-left-sec"  >
                        <div class="d-flex justify-content-between w-100">
                            <img src="{{ asset('images/loginlogo.png')}}"  class="img-fluid" alt="Logo">
                        </div>
                       
                    </div>
                    <div class="d-lg-none d-block d-flex justify-content-center mob-logo w-100">
                        <img src="{{asset('images/loginlogo.png')}}" class="img-fluid logo_singin mb-4" alt="Logo">
                    </div>
                </div>

                <div class="col-12 col-lg-6" >
                    <div class="card-body">
                        <div class="row" id="login">
                            <div class="col-12 position-absolute top-0 end-0"> 
                                <div class="btn_alignbox justify-content-end p-lg-0 p-3"> 
                                    <a class="primary fw-medium d-flex align-items-center gap-1" href="{{url('/')}}"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-10 mx-auto">
                                <div class="login-form text-center position-relative">

                                    <p id="credslabel" class="top-error"></p>
                                    <div class="mt-4">
                                       @if (  $alreadyLoggined !=1)
                                        <h1>Let's Set Up Your Profile</h1>
                                        <p>Help us get to know you better.</p>
                                        @endif
                        
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="number" role="tabpanel" aria-labelledby="number-tab">
                                                <form method="POST" id="registerform" autocomplete="off">
                                                @csrf
                                                <input type="hidden" class="form-control"  id="timezoneOffset" name="timezoneOffset" >
                                                <div class="row g-3">

                                                @if (  $alreadyLoggined==1)
                                                      <div class="d-flex justify-content-center flex-column align-items-center gap-2">
                                                          <img src="{{$clinicDetails['logo'] ?? asset('images/default_clinic.png')}}" class="user-img actioncls" alt="">
                                                          <h1 class="my-3 actioncls">Welcome {{$name}},</h1>
                                                      </div>
                                                        @if (  $alreadyLoggined==1)
                                                        <div class="text-center">
                                                                <span class="material-symbols-outlined warning-icon">warning</span>
                                                                <div class="invitation-wrapper mt-2 mb-4">
                                                                    <h5 class="mb-0">A user is already logged in to the system. Please logout to continue accepting the invite.</h5>
                                                                </div>
                                                                <div class="text-center">
                                                                    <a  href=" {{url('frontend/logout?redirectinvite=register?invitationkey='.$key)}}"  class="btn btn-primary w-100">Logout</a>
                                                                </div>
                                                            </div>
                                                            @else
                                                            <div class="text-center actioncls">
                                                                <div class="mt-2 mb-4">
                                                                    <h5 class="mb-0 primary">You have been invited to join @if(!empty($clinicDetails)){{$clinicDetails['name']}}@endif by {{$clinicianname}}.</h5>
                                                                </div>
                                                            </div>
                                            
                                                            <div class="btn_alignbox d-flex gap-2 actioncls">
                                                                <a class="btn btn-primary flex-grow-1 submitbtn" onclick="acceptInvitation('1')">Accept</a>
                                                                <a class="btn btn-outline-danger flex-grow-1 submitbtn" onclick="acceptInvitation('0')">Decline</a>
                                                            </div>
                                                        @endif
                                                  

                                                    @else

                                                    <div class="col-12">
                                                      

                                                        <div class="create-profile d-inline-block text-center doctorimage">
                                                          <div class="profile-img position-relative m-0"> 
                                                              <img id="doctorimage"  @if($clinicUserDetails['logo_path'] !='')  src="{{asset($clinicUserDetails['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                                                              <a  href="{{ url('crop/doctor')}}"  id="user-upload-img" class="aupload upload-icon"  @if($clinicUserDetails['logo_path'] !='') style="display:none;" @endif>
                                                                  <span class="material-symbols-outlined">add_photo_alternate</span>
                                                              </a>
                                                              <a class="profile-remove-btn" href="javascript:void(0);" id="userremovelogo" @if($clinicUserDetails['logo_path'] !='') style="" @else style="display:none;" @endif onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

                                                              <!-- <a class="profile-remove-btn" href="javascript:void(0);" id="userremovelogo" style="display:none;"
                                                          onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a> -->
                                                          </div> 
                                                          <label class="primary fw-medium mb-0">Upload Image</label>    
                                                      </div>

                                                    </div>
                                                    <input type="hidden" id="usertempimage" name="usertempimage" value="">
                                                    <input type="hidden" name="userisremove" id="userisremove" value="0">


                                                  
                                                    <div class="col-lg-6 col-12">
                                                      <div class="form-group form-outline first_nameerr">
                                                        <label for="first_name" class="float-label">First Name</label>
                                                        <i class="fa-solid fa-circle-user"></i>
                                                        <input type="text" name="username" class="form-control first_name" id="first_name" value="{{$clinicUserDetails['first_name']}}">
                                                      </div>
                                                    </div>

                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-group form-outline last_nameerr">
                                                            <label for="last_name" class="float-label">Last Name</label>
                                                            <i class="fa-solid fa-circle-user"></i>
                                                            <input type="text" class="form-control last_name" id="last_name" name="last_name" value="{{$clinicUserDetails['last_name']}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                      <div class="form-group form-outline">
                                                          <label for="user_email" class="float-label">Email</label>
                                                          <i class="fa-solid fa-envelope"></i>
                                                          <input type="email" class="form-control" id="user_email" readonly name="user_email" value="{{$clinicUserDetails['email']}}">
                                                      </div>
                                                  </div>
                                      
                                                  
                                                    <?php
                                                        $Corefunctions = new \App\customclasses\Corefunctions;
                                                    ?>
                                                       <div class="col-12">
                                                        <div class="form-group form-outline phoneregcls">
                                                            <div class="country_code phone">
                                                            <!-- <input type="hidden" id="user_countryCode" name="user_countryCode" value='+1'> -->
                                                            <input type="hidden" name="user_countryCodeShort" class="form-control" id="user_countryCode"  value="{{ isset($clinicUserDetails['short_code'])  ? $clinicUserDetails['short_code'] : 'US' }}">
                                                            </div>
                                                            <i class="material-symbols-outlined me-2">call</i>
                                                            <?php $cleanPhoneNumber = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $clinicUserDetails['phone_number']); ?>
                                                            <input type="text" name="user_phone" readonly class="form-control phone-numberregistuser" id="user_phone" value="<?php echo isset($clinicUserDetails['country_code'])  ? $clinicUserDetails['country_code'] . $cleanPhoneNumber : $cleanPhoneNumber ?>"
                                                            placeholder="Enter phone number">
                                                        </div>
                                                      
                                                    </div>

                                                  
                                                    @endif
                                                  
                                                </div>
                                                @if (  $alreadyLoggined !=1)
                                                  
                                                    <input type="hidden" name="invitationkey" id="invitationkey" value="{{$invitationkey}}">

                                                    <a onclick="submitClinic()" class="btn btn-primary w-100 mt-4" id="save_clinic">Continue</a>
                                                    <p class="m-0 mt-5">Already have a BlackBag account?</p>
                                                    <div class="btn_inner">
                                                        <a class="primary fw-medium text-decoration-underline " href="{{url('login')}}">Sign In</a>
                                                    </div>
                                                    @endif
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
    @php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp
   <!-- Correct script order -->
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- Bootstrap JS (with Popper.js for modals to work) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

 


<script>

    
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
     
     function submitClinic() {
            if ($("#registerform").valid()) {
                $("#save_clinic").addClass('disabled');
                var invitationkey ="{{$invitationkey}}";
                $.ajax({
                    url: '{{ url("clinic/store") }}',
                    type: "post",
                    data: {
                      'userType' : 'doctor',
                      'invitationkey':invitationkey,
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

  $(document).ready(function () {
    function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');
    
            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }
    
        // Initialize all inputs on page load
        $('input, textarea').each(function () {
            toggleLabel(this);
        });
    
    $("#registerform").validate({
      ignore: [],
      rules: {
        first_name: {
          required: true,
          noWhitespace: true
        },
        last_name: {
          required: true,
          noWhitespace: true
        },
      

        // user_email: {
        //   required: true,
        //   format: true,
        //   email: true,
        //   emailFirstCharValid: true,
        //   remote: {
        //     url: "{{ url('/validateuserphone') }}",
        //     data: {
        //       'type': 'register',
        //       'email': function () {
        //           return $("#user_email").val();
        //        },
        //       'phone_number': function () {
        //           return $("#user_phone").val(); 
        //       }, 
        //       'country_code': function () {
        //           return $("#user_countryCodeShorts").val();
        //       },
        //       '_token': $('input[name=_token]').val()
        //     },
        //     type: "post",
        //     dataFilter: function (response) {
        //       const res = JSON.parse(response);
        //       if (res.valid) {
        //         return true;
        //       } else {
        //         return "\"" + res.message + "\"";
        //       }
        //     }
        //   },
        // },

        

        // user_phone: {
        //   required: true,
        //   NumberValids: true,
        //   remote: {
        //     url: "{{ url('/validateuserphone') }}",
        //     data: {
        //       'type': 'register',
        //       'user_email': function () {
        //         return $("#user_email").val();
        //       },
        //       'phone_number': function () {
        //         return $("#user_phone").val(); 
        //       }, 
        //       'country_code': function () {
        //         return $("#user_countryCodeShorts").val();
        //       },
        //       '_token': $('input[name=_token]').val()
        //     },
        //     type: "post",
        //       dataFilter: function (response) {
        //       const res = JSON.parse(response);
        //       if (res.valid) {
        //         return true;
        //       } else {
        //         return "\"" + res.message + "\"";
        //       }
        //     }
        //   },
        // },
       
        

      },

      messages: {
        clinic_name: "Please enter clinic name.",
        country_id: "Please select country.",

        email: {
          required: 'Please enter email.',
          email: 'Please enter valid email.',
          remote: "Email id already exists in the system."
        },
        user_email: {
          required: 'Please enter email.',
          email: 'Please enter valid email.',
          remote: "Email id already exists in the system.",
          emailFirstCharValid : "Please enter valid email."
        },
        
        phone_number: {
          required: 'Please enter phone number.',
          NumberValids: 'Please enter valid phone number.',
          remote: "Phone number exists in the system."

        },
        user_phone: {
          required: 'Please enter phone number.',
          NumberValids: 'Please enter valid phone number.',
          remote: "Phone number exists in the system."
        },
        first_name: {
          required: 'Please enter first name.',
          
          noWhitespace:'Please enter valid first name.',
        },
        last_name: {
          required: 'Please enter last name.',
        
          noWhitespace: 'Please enter valid last name.',
        },
        address: "Please enter address.",
        city: "Please enter city.",
        state: "Please enter state.",
        state_id: 'Please enter state',
        // zip : "Please enter zip." ,
        // first_name: "Please enter name.",

        zip: {
          required: 'Please enter zip',
          zipmaxlength: 'Please enter a valid zip.',
          digits: 'Please enter a valid zip.',
          regex: 'Please enter a valid zip.',
          zipRegex: 'Please enter a valid zip.',
        },

      },
      errorPlacement: function (error, element) {
        if (element.hasClass("phone-numberregister")) {
          // Remove previous error label to prevent duplication
          // Insert error message after the correct element
          error.insertAfter(".phone-numberregister");

          error.addClass("phone-numberregister");
        } else {
          if (element.hasClass("phone-numberregistuser")) {
            error.insertAfter(".phone-numberregistuser");
          } else {
            error.insertAfter(element); // Place error messages after the input fields

          }
        }

      },

    });
    jQuery.validator.addMethod("noWhitespace", function(value, element) {
      return $.trim(value).length > 0;
    }, "This field is required.");

    jQuery.validator.addMethod("emailFirstCharValid", function(value, element) {
      const username = value.split('@')[0];
      return /^[a-zA-Z0-9]/.test(username);
    }, "Please enter valid email.");

    jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
        return this.optional(element) || phone_number.length < 14 &&
            phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
    });
    $.validator.addMethod(
      "format",
      function (value, element) {
        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(value);
      },
      "Please enter a valid email address."
    );
    $.validator.addMethod("regex", function (value, element) {
      return /^[0-9]{5}$/.test(value);
    }, "Please enter a valid ZIP code.");
    $.validator.addMethod("zipRegex", function (value, element) {
      return /^[a-zA-Z0-9]{5,7}$/.test(value);
    }, "Please enter a valid ZIP code.");

    $.validator.addMethod("zipmaxlength", function (value, element) {
      return /^\d{1,6}$/.test(value);
    }, "Please enter a valid ZIP code.");


  });
 



  $(document).ready(function () {


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


    // Initialize for user phone input
    var userTelInput = $("#user_phone"),
      userCountryCodeInput = $("#user_countryCode"),
      usercountryCodeShort = $("#user_countryCodeShorts"),
      userErrorMsg = $("#user_phone-error"),  // Updated target for user phone error message
      userValidMsg = $("#user_valid-msg");    // Assuming you have a unique valid message for user phone

    initializeIntlTelInput(userTelInput, userCountryCodeInput, userErrorMsg, userValidMsg, usercountryCodeShort);

    

  });

  function initializeIntlTelInput(telInput, countryCodeInput, errorMsg, validMsg, countryCodeShort) {
    // Initialize intlTelInput
    let onlyCountriesx = {!! json_encode($corefunctions->getCountry()) !!};

    telInput.intlTelInput({
      initialCountry: "us",
      formatOnDisplay: true,
      autoHideDialCode: true,
      onlyCountries: onlyCountriesx,
      nationalMode: false,
      separateDialCode: true,
      geoIpLookup: function (callback) {
        $.get("http://ipinfo.io", function () { }, "jsonp").always(function (resp) {
          var countryCode = (resp && resp.country) ? resp.country : "";
          callback(countryCode);
        });
      },
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
    });

    // Reset error/valid messages
    function reset() {
      telInput.removeClass("error");
      errorMsg.addClass("hide");
      validMsg.addClass("hide");
    }

    // Handle country change event 
    telInput.on("countrychange", function (e, countryData) {
      var countryShortCode = countryData.iso2;
      countryCodeShort.val(countryShortCode);
      countryCodeInput.val(countryData.dialCode);
    });
    // Handle clinic change even

    // Handle blur event
    telInput.blur(function () {
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

    // Handle keyup/change event
    telInput.on("keyup change", reset);

    $('#clinic_phone_number, #user_phone').mask('(ZZZ) ZZZ-ZZZZ', {
      translation: {
        'Z': {
          pattern: /[0-9]/,
          optional: false
        }
      }
    });
  }

  let isRequestInProgress = false;
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
              var invitationkey = "{{$invitationkey}}";
              $.ajax({
                  url: '{{ url("/verifyotp") }}',
                  type: "post",
                  data: {
                    'invitationkey':invitationkey,
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
                                $("#otpform").hide(); // Hide the loader modal
                                $("#successSignin").modal('show');
                                setTimeout(function() {
                                  if(data.hasRedirect == '0'){

                                    window.location.href = data.redirectURL;

                                    }else{
                                    window.location.href = "{{url('/patient/dashboard')}}"; 
                                    }
                                  }, 2000);

                                  //alert(data.hasRedirect);
                                 
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

                                $("#otpform").hide(); // Hide the loader modal
                                $("#successSignin").modal('show');
                                setTimeout(function() {
                                    alert(data.hasRedirect);
                                  if(data.hasRedirect == '2'){
                                      window.location.href = "{{ url('doctor/onboarding') }}/"+data.lastStep ;
                                  }else if(data.hasRedirect == 0){
                                      window.location.href = "{{ url('/connecttostripe') }}?redirectURL=" + encodeURIComponent(data.redirectURL);
                                  }else{
                                      
                                      window.location.href = "{{url('/dashboard')}}";
                                  }
                                }, 2000); // 2 seconds
                                
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
   
function doctorImage(imagekey, imagePath) {
    
    $("#usertempimage").val(imagekey);
    $("#doctorimage").attr("src", imagePath);
    $("#doctorimage").show();
    $("#user-upload-img").hide();
    $("#userremovelogo").show();
    $(".doctorimage").hide();
}
function removeImage(){
        $("#doctorimage").attr("src","{{asset('images/default_img.png')}}");
        $("#userisremove").val('1');
        $("#userremovelogo").hide();
        $("#user-upload-img").show();
        $(".doctorimage").show();
    }


$(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });




</script>




<div class="modal login-modal fade" id="successSignin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
    </body>
</html>
