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
     <section class="signin-page patient-signin-page" >
        <div class="container-fluid p-0">
            <div class="row align-items-center position-relative">
                <div  class="col-12 col-lg-4 d-lg-block d-none" >

                    <div  class="patient-sign-in-left-sec" >
                        <div class="d-flex justify-content-between w-100">
                            <img src="{{ asset('images/loginlogo.png')}}"  class="img-fluid" alt="Logo">
                        </div>
                       
                    </div>
                    <div class="d-lg-none d-block d-flex justify-content-center mob-logo w-100">
                        <img src="{{asset('images/loginlogo.png')}}" class="img-fluid logo_singin mb-4" alt="Logo">
                    </div>
                </div>

                <div class="col-12 col-lg-8" >
                    <div class="card-body">
                        <div class="row" id="login">
                            <div class="col-12 position-absolute top-0 end-0"> 
                                <div class="btn_alignbox justify-content-end p-lg-0 p-3"> 
                                    <a class="primary fw-medium d-flex align-items-center gap-1" href="{{url('/')}}"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-8 mx-auto">
                                <div class="login-form text-center position-relative">

                                    <p id="credslabel" class="top-error"></p>
                                    <div class="mt-4">

                                        <h1>Let's Set Up Your Profile</h1>
                                        <p>Help us get to know you better.</p>

                        
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="number" role="tabpanel" aria-labelledby="number-tab">
                                                <form method="POST" id="registerpatientform" autocomplete="off">
                                                @csrf
                                                <input type="hidden" class="form-control"  id="timezoneOffset" name="timezoneOffset" >
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="create-profile">
                                                            <div class="profile-img position-relative"> 
                                                                <img id="patientimage" src="{{asset('images/default_img.png')}}" class="img-fluid">
                                                                <a  href="{{ url('crop/patient')}}" id="upload-img" class="aupload"><img id="patientimg"src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                                                                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" style="display:none;"  onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>
                                                            </div>
                                                            <input type="hidden" id="tempimage" name="tempimage" value="">
                                                            <input type="hidden" name="isremove" id="isremove" value="0">
                                                        </div>
                                                    </div>

                                                  
                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group form-outline mb-4">
                                                        <label for="input" class="float-label">First Name</label>
                                                        <i class="fa-solid fa-circle-user"></i>
                                                        <input type="text"  name="first_name" class="form-control" id="exampleFormControlInput1" @if(!empty($clinicPatientDetails)) value="{{$clinicPatientDetails['first_name']}}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group form-outline mb-4">
                                                        <label for="input" class="float-label">Middle Name</label>
                                                        <i class="fa-solid fa-circle-user"></i>
                                                        <input type="text"  name="middle_name" class="form-control" id="exampleFormControlInput1" @if(!empty($clinicPatientDetails) && isset($clinicPatientDetails['middle_name']) && $clinicPatientDetails['middle_name'] != '') value="{{$clinicPatientDetails['middle_name']}}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group form-outline mb-4">
                                                        <label for="input" class="float-label">Last Name</label>
                                                        <i class="fa-solid fa-circle-user"></i>
                                                        <input type="text"  name="last_name" class="form-control" id="last_name" @if(!empty($clinicPatientDetails)) value="{{$clinicPatientDetails['last_name']}}" @endif>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-group form-floating mb-4">
                                                            <i class="material-symbols-outlined">id_card</i>
                                                            <select name="gender" id="gender" class="form-select">
                                                                <option value="">Select Gender</option>
                                                                    <option value="1" @if(!empty($clinicPatientDetails) && $clinicPatientDetails['gender'] == '1') selected @endif>Male</option>
                                                                    <option value="2" @if(!empty($clinicPatientDetails) && $clinicPatientDetails['gender'] == '2') selected @endif>Female</option>
                                                                    <option value="3" @if(!empty($clinicPatientDetails) && $clinicPatientDetails['gender'] == '3') selected @endif>Other</option>
                                                            </select>
                                                            <label class="select-label">Gender</label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $Corefunctions = new \App\customclasses\Corefunctions;
                                                    ?>

                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-group form-outline mb-4">
                                                        <label for="dob" class="float-label">Date of Birth</label>
                                                        <i class="material-symbols-outlined">date_range</i>
                                                        <input type="text" name="dob" id="dob" class="form-control" @if(!empty($clinicPatientDetails) && isset($clinicPatientDetails['dob']) && $clinicPatientDetails['dob'] != '') value="{{date('m/d/Y', strtotime($clinicPatientDetails['dob']))}}" @endif>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group form-outline mb-4">
                                                        <label for="email" class="float-label">Email</label>
                                                        <i class="fa-solid fa-envelope"></i>
                                                        <input type="email" name="email" id="email" class="form-control @if(!empty($clinicPatientDetails)) disabled @endif" @if(!empty($clinicPatientDetails)) value="{{$clinicPatientDetails['email']}}" @endif>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="phonenum_group">
                                                            <div class="country_code phone">
                                                                <input type="hidden" id="patientcountryCode" name="patient_countrycode"  value={{ !empty($clinicPatientDetails) && isset($countryCodedetails['short_code'])  ? $countryCodedetails['short_code'] : 'US' }}>
                                                                <input type="hidden" id="patientcountryCodeShort" name="patient_countryCodeShort" value="us" >
                                                            </div>
                                                            <div class="form-group form-outline mb-4 flex-grow-1">
                                                                <input type="tel" name="patient_phonenumber" class="form-control phone-number patient-phn  @if(!empty($clinicPatientDetails)) disabled @endif" id="patientphonenumber" placeholder="Enter phone number" required @if(!empty($clinicPatientDetails) && isset($clinicPatientDetails['phone_number'])) value="<?php echo isset($clinicPatientDetails['country_code'])  ? '+'.$clinicPatientDetails['country_code'] . $Corefunctions->formatPhone($clinicPatientDetails['phone_number']) : $Corefunctions->formatPhone($clinicPatientDetails['phone_number']) ?>" @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    
                                                    <input type="hidden" name="userType" id="userType" class="form-control" value="patient">
                                                    <input type="hidden" name="invitationkey" id="invitationkey" value="{{$invitationkey}}">

                                                    <a onclick="submitPatient()" class="btn btn-primary w-100" id="patientregister">Continue</a>
                                                    <p class="m-0 mt-5">Already have a BlackBag account?</p>
                                                    <div class="btn_inner">
                                                        <a class="primary fw-medium text-decoration-underline" href="{{url('login')}}">Sign In</a>
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
                                        <h4 class="text-center fw-medium mb-0">Verify Phone Number</h4>
                                        <small class="gray">OTP has been sent to <span class="fw-medium primary phn-otp" id="otpPhone"></span></small>

                                        <form method="POST" id="verifyotpform" autocomplete="off">
                                            @csrf
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

                         <!--  success page for patinet  -->

                        <div class="row" id="patientsuccess" style="display: none;">
                            <div class="col-12 position-absolute top-0 end-0"> 
                                <div class="btn_alignbox justify-content-end p-lg-0 p-3"> 
                                    <a class="primary fw-medium d-flex align-items-center gap-1 back-btn" href="{{url('/')}}"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-8 mx-auto">
                                <div class="login-form text-center">
                                   
                                    <div class="mt-4">
                                        <img src="{{asset('images/insurance_care.png')}}" class="care-img mb-3" alt="Care Us">
                                        <h4 class="text-center fw-medium mb-0">Help Us Care for You Better</h4>
                                        <p class="px-xl-5 px-lg-4">Share your health details to ensure personalized and accurate care tailored to your needs.</p>

                                        <div class="btn_alignbox flex-column">
                                            <a id="loginsubmit" class="btn btn-primary w-100" href="{{url('/intakeform')}}">Continue</a>
                                           
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

    <script type="text/javascript">
         function verifyOtp() {
            var invitationkey = "{{$invitationkey}}";
            var otpValue = '';
            // Gather OTP value from individual fields
            $('.otp-input-field').each(function() {
                otpValue += $(this).val();
            });

            $('#otp_value').val(otpValue);

            // If the form passes validation
            if ($("#verifyotpform").valid()) {
                $("#loginsubmit").addClass('disabled');
                $.ajax({
                    url: '{{ url("/verifyotp") }}',
                    type: "post",
                    data: {
                        'invitationkey':invitationkey,
                        'formdata': $("#verifyotpform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
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
                                        if (invitationkey != '') {
                                            window.location.href = "{{url('/subscriptionplans')}}";
                                        }else{
                                            $("#patientsuccess").show();
                                        }
                                        // window.location.href = "{{ url('/dashboard') }}"; // Redirect to the dashboard
                                    }, 2000);
                                    
                                }else{
                                    //alert(data.hasRedirect);
                                    if(data.hasRedirect == '0'){
                                        window.location.href = data.redirectURL;

                                        }else{
                                            window.location.href = "{{url('/myappointments')}}"; 
                                        }
                                }
                               
                                

                            }else{
                                if(data.isregister == '1'){
                                    $("#registerUser").modal('hide'); // Hide the registration modal
                                    $("#loader").modal('show'); // Show the loader modal
                                    // Show successSignin modal after 2 seconds
                                    setTimeout(function() {
                                        $("#loader").modal('hide'); // Hide the loader modal
                                        $("#successSignin").modal('show'); // Show the success modal
                                    }, 2000); // 2 seconds
                                }
                               
                                if(data.hasRedirect == 0){
                                    window.location.href = data.redirectURL;
                                }else{
                                    
                                    window.location.href = "{{url('/dashboard')}}";
                                }
                            }
                          
                           
                        } else {
                            $("#loginsubmit").removeClass('disabled');
                            $('.otp-input-field').val('');
                            // Optionally reset the hidden 'otp_value' field as well
                            $('#otp_value').val('');
                            // When OTP verification fails, show an error
                            showOtpError(data.errormsg); // Call the error display function
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

        function removeImage() {
            $("#tempimage").val('');
            $("#patientimage").attr("src", "{{asset('images/default_img.png')}}");
            $("#isremove").val('1');
            $("#removelogo").hide();
            $("#upload-img").show();
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



            // Scroll to the error message if needed
            $('html, body').animate({
                scrollTop: (otpField.offset().top - 100)
            }, 500);

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
                ,
            });

        }
        $(document).ready(function() {

            /* timezone */
            var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;            
            var timeZoneMapping = {
                "Asia/Calcutta": "Asia/Kolkata",       
            };
            var mappedTimeZone = timeZoneMapping[timeZone] || timeZone;
            $('#timezoneOffset').val(mappedTimeZone);

            // When typing in an OTP field
            $('.otp-input-field').on('keyup', function(e) {
                var key = e.which || e.keyCode;
                var $currentField = $(this);
                var $nextField = $currentField.next('.otp-input-field');
                var $prevField = $currentField.prev('.otp-input-field');

                // Move to the next field on valid input (0-9)
                if ($currentField.val().length == 1 && key >= 48 && key <= 57) {
                    $nextField.focus();
                }

                // Move to the previous field on backspace
                if (key === 8 && $prevField.length) {
                    $prevField.focus();
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

            //  // Check if all fields are filled
            // if ($('.otp-input-field').filter(function () { return this.value.length === 0; }).length === 0) {
            //     alert(4)
            //     verifyOtp(); // Automatically call verifyOtp if all fields are filled
            // }

        
            // Ensure only digits can be entered
            $('.otp-input-field').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-digit characters
            });

            // verifyOtp


        });

        function resendCountdown() {
            var timerDuration = 30; // Duration in seconds
            var timer = timerDuration; // Set the initial timer value


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
    $(document).ready(function () {
        $('#dob').datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false, 
        maxDate: moment().endOf('day') // Allows today but blocks future dates
    });
   
    $("#dob").on("change", function() {
        $('#dob').valid();
    });
    $(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });
    var patienttelInput = $("#patientphonenumber"),
    countryCodeInputP = $("#patientcountryCode"),
    countryCodeShortP = $("#patientcountryCodeShort"),
    errorMsg = $("#error-msg"),
    validMsg = $("#valid-msg");
    let onlyCountriesx = {!! json_encode($corefunctions->getCountry()) !!};
    // initialise plugin
    patienttelInput.intlTelInput({
        autoPlaceholder: "polite",
        initialCountry: "us",
        formatOnDisplay: false, // Enable auto-formatting on display
        autoHideDialCode: true,
        defaultCountry: "auto",
        ipinfoToken: "yolo",
        onlyCountries: onlyCountriesx,
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
        patienttelInput.removeClass("error");
        errorMsg.addClass("hide");
        validMsg.addClass("hide");
    };

    patienttelInput.on("countrychange", function(e, countryData) {
            var countryShortCode = countryData.iso2;
            countryCodeInputP.val(countryData.dialCode);
        countryCodeShortP.val(countryShortCode);
    });

    patienttelInput.blur(function() {
        reset();
        if ($.trim(patienttelInput.val())) {
            if (patienttelInput.intlTelInput("isValidNumber")) {
                validMsg.removeClass("hide");
            } else {
                patienttelInput.addClass("error");
                errorMsg.removeClass("hide");
            }
        }
    });

    patienttelInput.on("keyup change", reset);

    $('#patientphonenumber').mask('(ZZZ) ZZZ-ZZZZ', {
        translation: {
            'Z': {
            pattern: /[0-9]/,
            optional: false
            }
        }
    });

    let emailRules = {
        required: true,
        email: true,
        notOnlySpecialChar: true,
        strictEmail: true, 
    };
    let phoneRules = {
        required: true,
        NumberValids: true
    };

    // Conditionally add remote rule
    @if(!empty($clinicPatientDetails))
        emailRules.remote = {
            url: "{{ url('/validateuserphoneregister') }}",
            type: "post",
            data: {
                'type': 'patient',
                "id": "{{$clinicPatientDetails['user_id']}}",
                'country_code': function () {
                    return $("#patientcountryCodeShort").val();
                },
                'phone_number': function () {
                    return $("#patientphonenumber").val();
                },
                '_token': $('input[name=_token]').val()
            },
            dataFilter: function (response) {
                const res = JSON.parse(response);
                return res.valid ? true : "\"" + res.message + "\"";
            }
        };
        phoneRules.remote = {
            url: "{{ url('/validateuserphoneregister') }}",
            type: "post",
            data: {
                'type': 'patient',
                'id': "{{$clinicPatientDetails['user_id']}}",
                'email': function () {
                    return $("#email").val();
                },
                'country_code': function () {
                    return $("#patientcountryCodeShort").val();
                },
                '_token': $('input[name=_token]').val()
            },
            dataFilter: function (response) {
                const res = JSON.parse(response);
                return res.valid ? true : "\"" + res.message + "\"";
            }
        };
    @else
        emailRules.remote = {
            url: "{{ url('/frontend/checkEmailExist') }}",
            type: "post",
            data: {
                'type': 'patient',
                'uuid': "",
                '_token': $('input[name=_token]').val(),
                'clinic_id': function () {
                    return '';
                },
                'phone_number': function () {
                    return $("#patientphonenumber").val();
                },
                'country_code': function () {
                    return $("#patientcountryCodeShort").val();
                }
            }
        };
        phoneRules.remote = {
            url: "{{ url('/frontend/checkPhoneExist') }}",
            type: "post",
            data: {
                'type': 'patient',
                'uuid': "",
                '_token': $('input[name=_token]').val(),
                'clinic_id': function () {
                    return "";
                },
                'country_code': function () {
                    return $("#patientcountryCodeShort").val();
                },
                'email': function () {
                    return $("#email").val();
                },
                'phone_number': function () {
                    return $("#patientphonenumber").val();
                }
            }
            // Optional: enable dataFilter here as well if you want
        };
    @endif

    $("#registerpatientform").validate({
        ignore: [],
        rules: {
          
            first_name: {
                required: true,
                noWhitespace: true,
                notOnlySpecialChar: true,
                notOnlyNumbers: true,
            },
            middle_name: {
                notOnlySpecialChar: true
            },
            last_name: {
                required: true,
                noWhitespace: true,
                notOnlySpecialChar: true,
                notOnlyNumbers: true,
            },
         
            patient_phonenumber: phoneRules,
            email: emailRules,
            dob: 'required',
            gender: 'required',
        },

        messages: {
            first_name: {
                required: 'Please enter first name.',
                noWhitespace:'Please enter valid first name.',
                notOnlySpecialChar:'Please enter valid first name.',
                notOnlyNumbers :'Please enter valid last name.',
            },
            middle_name: {
                notOnlySpecialChar:'Please enter valid middle name.',
            },
            last_name: {
                required: 'Please enter last name.',
                noWhitespace: 'Please enter valid last name.',
                notOnlySpecialChar:'Please enter valid last name.',
                notOnlyNumbers :'Please enter valid last name.',
            },
            gender: "Please select gender.",
            dob: "Please select date of birth.",
            email: {
                required: 'Please enter email.',
                email: 'Please enter valid email.',
                remote: "Email id already exists in the system.",
                notOnlySpecialChar:'Please enter valid first name.',
                strictEmail: "Please enter a valid email address",
            },
            patient_phonenumber: {
                required: 'Please enter phone number.',
                NumberValids: 'Please enter valid phone number.',
                remote: "Phone number exists in the system."
            },
        },
        errorPlacement: function (error, element) {
            if (element.hasClass("phone-numberregister")) {
                error.insertAfter(".phone-numberregister");
                error.addClass("phone-numberregister");
            }else if(element.hasClass("patient-phn")){
                error.insertAfter(".intl-tel-input");
            } else {
                if (element.hasClass("phone-numberregistuser")) {
                    error.insertAfter(".phone-numberregistuser");
                } else {
                    error.insertAfter(element); // Place error messages after the input fields

                }
            }
        },
        success: function (label) {
            // If the field is valid, remove the error label
            label.remove();
        }
    });

    // Custom method: Strict Email Validation (rejects 122@122vvbg)
    jQuery.validator.addMethod("strictEmail", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value);
    }, "Please enter a valid email address.");
    jQuery.validator.addMethod("noWhitespace", function(value, element) {
      return $.trim(value).length > 0;
    }, "This field is required.");
    jQuery.validator.addMethod("notOnlyNumbers", function(value, element) {
        return this.optional(element) || /[a-zA-Z]/.test(value); 
        // Must contain at least one alphabet
    }, "Numbers only are not allowed.");
    // Custom method to ensure the value is not only special characters
    jQuery.validator.addMethod("notOnlySpecialChar", function(value, element) {
        // Allow if value contains at least one alphabet or number
        return this.optional(element) || /[a-zA-Z0-9]/.test(value);
    }, "Special characters only are not allowed.");


    $.validator.addMethod("format",function (value, element) {
        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(value);
        },"Please enter a valid email address.");
    });
    jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
        return this.optional(element) || phone_number.length < 14 &&
            phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
    });


function patientImage(imagekey, imagePath) {
            $("#tempimage").val(imagekey);
            $("#patientimage").attr("src", imagePath);
            $("#patientimage").show();
            $("#upload-img").hide();
            $("#removelogo").show();
        }

// Function to toggle the 'active' class

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
    
        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function () {
            toggleLabel(this);
        });
    
        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function (e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });
    });
    

        function submitPatient() {
            var invitationkey ="{{$invitationkey}}";
            if ($("#registerpatientform").valid()) {
                $("#patientregister").addClass('disabled');
                $.ajax({
                    url: '{{ url("clinic/store") }}',
                    type: "post",
                    data: {
                        'userType' : 'patient',
                        'invitationkey':invitationkey,
                        'formdata': $("#registerpatientform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        if (data.success == 1) {
                           if(data.userType == 'patient' ){
                                //$("#registerpatient").hide();
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
                                $("#isregister").val('1');
                                Swal.fire({
                                    icon: 'success',
                                    title: '',
                                    text: "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                                });
                                resendCountdown();
                           }else{

                                setTimeout(function() {
                                    $("#loader").modal('hide'); // Hide the loader modal
                                    $("#successSignin").modal('show'); // Show the success modal
                                }, 2000); // 2 seconds
                                // Redirect to the dashboard after an additional 3 seconds
                                setTimeout(function() {
                                    $("#successSignin").modal('hide'); 
                                    $("#registerpatient").hide();
                                    $("#patientsuccess").show();
                                    // window.location.href = "{{ url('/dashboard') }}"; // Redirect to the dashboard
                                }, 2000); 
                           }
                          
                        } else {
                           
                            $("#patientregister").removeClass('disabled');
                        }
                    },
                    error: function(xhr) {
                        
                        handleError(xhr);
                    }
                });

            } else {
                $("#patientregister").removeClass('disabled');
                if ($('.error:visible').length > 0) {
                    setTimeout(function() {
                    }, 500);
                }
            }

        }

   
  
    </script>
    </body>
</html>
