<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlackBag</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tele-med.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


</head>

<body class="bg-white">
    <section class="signin-page">
        <div class="container-fluid p-0">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">

                    <div class="sign-in-left-sec">
                        <div class="d-flex justify-content-between w-100">
                            <img src="{{ asset('images/loginlogo.png')}}" class="img-fluid" alt="Logo">
                            <a href="{{url('/login')}}" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
                        </div>
                        <div class="login-img-txt">
                            <h3>Virtual Care at Your Fingertips</h3>
                            <p>Providing you with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.</p>
                        </div>
                    </div>
                    <div class="d-lg-none d-block d-flex justify-content-center mob-logo w-100">
                        <img src="{{asset('images/logo.png')}}" class="img-fluid logo_singin" alt="Logo">
                        <a href="{{url('/login')}}" onclick="backTologin()" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card-body">
                        <div class="row" id="login">
                            <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-8 mx-auto">
                                <div class="login-form text-center position-relative">

                                    <p id="credslabel" class="top-error"></p>
                                    <div class="mt-4">

                                        <h1>Welcome Back</h1>
                                        <p>Please enter your details to sign in.</p>
                                        <form method="POST" id="loginformuser" autocomplete="off">
                                            @csrf

                                            <a  onclick="continueWithEmail()" class="btn btn-outline d-flex align-items-center justify-content-center  w-100"><img alt="Blackbag" src="{{ asset('images/googleImg.png')}}" class="img-fluid">Continue with Email</a>
                                            <p class="my-4">OR</p>

                                            <div class="phonenum_group">

                                                <div class="country_code phone">
                                                    <input type="hidden" id="countryCode" name="countrycode" value="<?php echo isset($countrycode->country_code)  ? $countrycode->country_code : '+1' ?>">
                                                    <input type="hidden" id="countryCodeShort" name="countryCodeShort" value="<?php echo isset($countrycode->short_code)  ? $countrycode->short_code : 'us' ?>" >
                                                </div>

                                                <div class="form-group form-outline mb-4 flex-grow-1">
                                                    <input type="tel" name="phonenumber" class="form-control phone-number" id="phonenumber" placeholder="Enter phone number" required @if(isset($phone) && $phone !='' ) value="<?php echo isset($countrycode->country_code)  ? $countrycode->country_code . $phone : $phone ?>" @endif>
                                                </div>
                                            </div>

                                            <input type="hidden" name="invitationkey" id="invitationkey" class="form-control" value="@if(isset($_GET['invitationkey']) && $_GET['invitationkey'] !=''){{$_GET['invitationkey']}}@endif">
                                            

                                            <a onclick="submitLogin()" class="btn btn-primary w-100">Send OTP</a>
                                            <p class="m-0 mt-5">Don't have a BlackBag account?</p>
                                            <div class="btn_inner">
                                                <a class="primary fw-medium text-decoration-underline" onclick="signUp()">Sign Up</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- OTP -->
                        <div class="row" id="otpform" style="display: none;">
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

                                            </div>
                                            <input type="hidden" name="logintype" class="form-control" id="logintype">
                                            <input type="hidden" name="email" class="form-control" id="email">

                                            <input type="hidden" name="otpkey" class="form-control" id="otpkey">
                                            <input type="hidden" name="phonenumber" class="form-control" id="phonenumbers">
                                            <input type="hidden" name="countrycode" class="form-control" id="countrycode">
                                            <input type="hidden" name="countryCodeShort" class="form-control" id="countryCodeShorts">
                                        </form>
                                        <div class="btn_alignbox flex-column">
                                            <a class="btn btn-primary w-100" onclick="verifyOtp()">Sign In</a>
                                            <p class="mt-3 mb-0">Didn’t get OTP Code?</p>
                                            <div class="d-flex">
                                                <a onclick="resendOtp()" href="javascript:void(0)" id="resendOtp" class="primary fw-medium text-decoration-underline">Resend OTP</a><span id="timer" class="gray ms-2"> in 30s</span>
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



    <!-- Correct script order -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>
    <!-- Bootstrap JS (with Popper.js for modals to work) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

    <script type="text/javascript">
        function continueWithEmail(){
            $("#googlelogin").modal('show');
        }
        $(document).ready(function() {

            var telInput = $("#phonenumber"),
                countryCodeInput = $("#countryCode"),
                countryCodeShort = $("#countryCodeShort"),
                errorMsg = $("#error-msg"),
                validMsg = $("#valid-msg");

            // initialise plugin
            telInput.intlTelInput({
                autoPlaceholder: "polite",
                initialCountry: "us",
                formatOnDisplay: false, // Enable auto-formatting on display
                autoHideDialCode: true,
                defaultCountry: "auto",
                ipinfoToken: "yolo",
                onlyCountries: ['us', 'in'],
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

        });

        function validateUser() {
            $("#loginformuser").validate({
                rules: {
                    phonenumber: {
                        required: true,
                        maxlength: 13,
                        // number: true
                    }
                },
                messages: {
                    phonenumber: {
                        required: 'Please enter phone number.',
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

                            $("#email").val(data.email);
                             $("#logintype").val('email');

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
                            Swal.fire({
                                icon: 'error',
                                title: '',
                                text: data.errormsg,
                            });
                        }
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

                            Swal.fire({
                                icon: 'success',
                                title: '',
                                text: "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                            });

                            // swal("An OTP has been sent to your registered phone number.("+ data.otp+")", "", "success");
                            resendCountdown();
                        } else {
                            showOtpError(data.errormsg, 'login');
                        }
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


        function verifyOtp() {
            var otpValue = '';
            // Gather OTP value from individual fields
            $('.otp-input-field').each(function() {
                otpValue += $(this).val();
            });

            $('#otp_value').val(otpValue);

            // If the form passes validation
            if ($("#verifyotpform").valid()) {
                $.ajax({
                    url: '{{ url("/verifyotp") }}',
                    type: "post",
                    data: {
                        'formdata': $("#verifyotpform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            if(data.hasRedirect == 0){
                                window.location.href = data.redirectURL;
                              
                            }else{
                                
                                window.location.href = "{{url('/dashboard')}}";
                            }
                           
                        } else {
                            $('.otp-input-field').val('');
                            // Optionally reset the hidden 'otp_value' field as well
                            $('#otp_value').val('');
                            // When OTP verification fails, show an error
                            showOtpError(data.errormsg); // Call the error display function
                        }
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
                        $("#otpkey").val(data.key);
                        $("#phonenumbers").val(data.phonenumber);
                        $("#countrycode").val(data.countrycode);
                        $("#countryCodeShort").val(data.countryCodeShort);
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

        function signUp() {
            $("#signin").modal('show');
        }

        function registerUser() {
            $.ajax({
                url: '{{ url("registerclinic") }}',
                type: "post",
                data: {
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#registerUser").modal('show');
                        $("#registerUserForm").html(data.view);
                    } else {

                    }
                }
            });

            // $('#registerUser')[0].reset();
            // $('#registerUser').validate().resetForm();

        }

        function submitClinic() {
            if ($("#registerform").valid()) {
                $.ajax({
                    url: '{{ url("clinic/store") }}',
                    type: "post",
                    data: {
                        'formdata': $("#registerform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            $("#registerUser").modal('hide'); // Hide the registration modal
                            $("#loader").modal('show'); // Show the loader modal
                            // Show successSignin modal after 2 seconds
                            setTimeout(function() {
                                $("#loader").modal('hide'); // Hide the loader modal
                                $("#successSignin").modal('show'); // Show the success modal
                            }, 2000); // 2 seconds
                          
                            // Redirect to the dashboard after an additional 3 seconds
                            setTimeout(function() {

                                if(data.stripe_connected == 0){
                                    window.location.href = data.stripeURL;
                                }else{
                                    window.location.href = "{{url('/dashboard')}}";
                                }

                                // window.location.href = "{{ url('/dashboard') }}"; // Redirect to the dashboard
                            }, 2000); // 5 seconds (2 seconds + 3 seconds)
                            // 
                        } else {

                        }
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


          // floating label start

  $(document).ready(function () {
    // Function to toggle the 'active' class
    function toggleLabel(input) {
      $(input).parent().find('.float-label').toggleClass('active', $.trim(input.value) !== '');
    }

    // Check prefilled inputs and textareas on page load
    $('input, textarea').each(function () {
      toggleLabel(this);
    });

    // On focus, input, and focusout events for all input and textarea elements
    $('input, textarea').on('focus input focusout', function () {
      toggleLabel(this);
    });

    $('input,textarea').on('input change', function () {
      toggleLabel(this);
    });
  });


  // floating label end

    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="{{ asset('js/main.js')}}"></script>
         -->
</body>

</html>
