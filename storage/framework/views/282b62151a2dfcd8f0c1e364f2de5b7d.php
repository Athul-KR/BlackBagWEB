<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(asset('frontend/images/favicon.png')); ?>" sizes="64x64" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/style.css')); ?>">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <!-- google fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- TelInput Country code -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/colorbox.css')); ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jquery.colorbox.js')); ?>"></script>

    <!-- Scripts -->
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Bootstrap JS (with Popper.js for modals to work) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- TelInput Country code -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>


    <script src="<?php echo e(asset('/tinymce/tinymce.min.js')); ?>" defer></script>

    <title>BlackBag | <?php echo $__env->yieldContent('title'); ?></title>
</head>

<body>
    <?php if(session()->has('success')): ?>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Swal.fire({
                //     title: 'Success!',
                //     text: "{ session()->get('success') }}",
                //     icon: 'success',
                //     confirmButtonText: 'OK'
                // });

                swal(
                    "Success!",
                    "<?php echo e(session()->get('success')); ?>",
                    "success",
                );
                setTimeout(function() {
                    location.reload(); // Refresh the page
                }, 4000);
            });
        </script>
    <?php endif; ?>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-xl fixed-top p-3 nav-topbar">
            <a href="<?php echo e(route('index')); ?>"><img src="<?php echo e(asset('frontend/images/logo.png')); ?>" class="img-fluid logo-main"
                    alt="Logo">
            </a>

            <div class="d-flex align-items-center gap-xl-2 gap-sm-3 gap-2 order-xl-1 order-0">

                <?php if(session()->has('user') && session()->get('user.userType') == 'patient'): ?>
                                <div class="profile-hd">
                                    <div class="btn-group">
                                        <button type="button" class="dropdown-btn dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <div class="profile_wrapper">
                                                <div class="profile_innerbody">
                                                    <?php
                                                        //dd(session()->get('user.userLogo'));
                                                    ?>
                                                    <img class="pfl-img"
                                                        src="<?php echo e(session('user.userLogo') ?? asset('images/default_img.png')); ?>">

                                                </div>
                                                <div class="pftl-txt-hd pftl-txt">
                                                    <span>Welcome</span>
                                                    <h6 class="primary fwt-bold mb-0"><?php echo e(session()->get('user.firstName')); ?>

                                                        <?php echo e(session()->get('user.lastName')); ?>

                                                    </h6>
                                                </div>
                                            </div>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end profile-drpdown p-0">
                                            <li>
                                                <div class="profile_wrapper">
                                                    <div class="profile_innerbody">
                                                        <img class="pfl-img"
                                                            src="<?php echo e(session('user.userLogo') ?? asset('images/default_img.png')); ?>">
                                                    </div>
                                                    <div class="pftl-txt-hd pftl-txt">
                                                        <h6 class="primary fwt-bold mb-0"><?php echo e(session()->get('user.firstName')); ?>

                                                            <?php echo e(session()->get('user.lastName')); ?>

                                                        </h6>
                                                        <span><?php echo e(session()->get('user.country_code') . " "); ?>

                                                            <?php echo e(session()->get('user.phone')); ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="switch_workspace border-top border-bottom w-100">
                                                    <div class="workspace_text py-2 px-3">
                                                        <small>Current Organization</small>
                                                        <h6 class="fw-bold m-0 primary"><?php echo e(Session::get('user.clinicName')); ?></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- <li><a onclick="addClinic()">
                                                    <span class="material-symbols-outlined">service_toolbox</span>
                                                    Add Organization
                                                </a>
                                            </li> -->
                                            <li><a href="<?php echo e(route('frontend.myAppointmentsTemplate')); ?>"><span
                                                        class="material-symbols-outlined">list_alt</span>My Appointments</a></li>
                                            <li><a href="<?php echo e(route('frontend.medicalHistory')); ?>"><span
                                                        class="material-symbols-outlined">browse_activity</span>Medical History</a>
                                            </li>
                                            <li><a data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#settingsModal"><span
                                                        class="material-symbols-outlined">settings</span>Settings</a></li>
                                            <li>
                                                <form method="get" action="<?php echo e(route('logout')); ?>">
                                                    <a href="<?php echo e(route('frontend.logout')); ?>"><span
                                                            class="material-symbols-outlined">logout</span>Logout</a>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                <?php elseif(!Session::has('user.patientID')): ?>
                    <a class="btn btn-primary ms-lg-3" onclick="showLogin()" data-bs-toggle="modal" data-bs-dismiss="modal">Login/Sign Up</a>

                <?php endif; ?>

                <button class="navbar-toggler x" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="material-symbols-outlined">menu</span>
                </button>



            </div>

            <div class="collapse navbar-collapse justify-content-lg-center order-xl-0 order-1" id="navbarNav">
                <ul class="navbar-nav mb-2 mb-lg-0 mt-xl-0 mt-3">
                    <li class="nav-item <?php echo e(request()->routeIs('index') ? 'active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('index')); ?>">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <!-- <li class="nav-item <?php echo e(request()->routeIs('frontend.findDoctorsAndClinics') ? 'active': ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('frontend.findDoctorsAndClinics')); ?>">Find Doctors & Clinics</a>
                            </li>

                            <li class="nav-item <?php echo e(request()->routeIs('frontend.forDoctors') ? 'active': ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('frontend.forDoctors')); ?>">For Doctors</a>
                            </li> -->
                    <li class="nav-item <?php echo e(request()->routeIs('frontend.forClinics') ? 'active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('frontend.forClinics')); ?>">For Clinics</a>
                    </li>
                    <!--
                                        <li class="nav-item ">
                                            <a class="nav-link" href="">Medical Tourism</a>
                                        </li>
                            -->
                    <li class="nav-item <?php echo e(request()->routeIs('frontend.contactUs') ? 'active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('frontend.contactUs')); ?>">Contact Us</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>







    <?php echo $__env->yieldContent('content'); ?>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xxl-7 col-lg-5 col-12">
                            <div class="image-container">
                                <img src="<?php echo e(asset('frontend/images/transpernt_logo.png')); ?>" class="img-fluid">
                                <h5 class="mt-2">Virtual Care at Your Fingertips</h5>
                            </div>
                        </div>
                        <div class="col-xxl-5 col-lg-7 col-12">
                            <div class="footer-inner mt-lg-0 mt-3">
                                <div>
                                    <ul>
                                        <li class="fwt-bold">BlackBag</li>
                                        <!-- <li><a class="white" data-bs-toggle="modal" data-bs-dismiss="modal"
                                                data-bs-target="#changePass">Join Us</a>
                                        </li> -->
                                        <li><a href="<?php echo e(route('frontend.contactUs')); ?>" class="white">Contact Us</a></li>
                                    </ul>
                                </div>
                                <!-- <div>
                                    <ul>
                                        <li class="fwt-bold">For Patients</li>
                                        <li><a href="<?php echo e(route('frontend.findDoctorsAndClinics')); ?>" class="white">Find
                                                Doctors</a></li>
                                        <li><a class="white">Search Specialities</a></li>
                                    </ul>
                                </div> -->
                                <div>
                                    <ul>
                                        <li class="fwt-bold">More</li>
                                        <li><a href="<?php echo e(route('frontend.contactUs')); ?>" class="white">Help & Support</a></li>
                                        <li><a href="<?php echo e(route('frontend.privacyPolicy')); ?>" class="white">Privacy Policy</a></li>
                                        <li><a href="<?php echo e(route('frontend.termsAndCondition')); ?>" class="white">Terms & Conditions</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <ul class="my-sm-0 mb-3">
                                <li><?php echo e(env('APP_NAME')); ?> <?php echo e(date('Y')); ?> © All rights reserved</li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-12">
                            <ul class="social-media flex-row justify-content-center justify-content-sm-end">
                                <li><a href="" class="white"><i class="fa-brands fa-square-instagram"></i></a></li>
                                <li><a href="" class="white"><i class="fa-brands fa-square-facebook"></i></a></li>
                                <li><a href="" class="white"><i class="fa-brands fa-square-x-twitter"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- MOdals -->


    <!-- Sign in-->
    <div class="modal login-modal fade" id="login" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a  data-bs-dismiss="modal" aria-label="Close"><span
                            class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body text-center p-md-5 p-3 mt-3 position-relative" id="patient_login_modal">
                   
                </div>
            </div>
        </div>
    </div>

    <!-- Sign Up Modal -->

    <div class="modal login-modal fade" id="registerPatient" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" >
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a onclick="$('#registerPatient').hide()" data-bs-dismiss="modal" aria-label="Close"><span
                            class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body text-center" id="registerPatientsForm">



                </div>
            </div>
        </div>
    </div>

    <!-- OTP Modal -->

    <div class="modal login-modal fade" id="otpform_modal" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a aria-label="Close" onclick="closeOtpModal()"><span
                            class="material-symbols-outlined">close</span></a>
                </div>

                <div class="modal-body text-center">
                    <h4 class="text-center fw-bold mb-0">Verify Phone Number</h4>
                    <p>OTP has been sent to<span class="primary ms-2" id="otpPhone"></span></p>

                    <form method="POST" id="verifyotpform">
                        <?php echo csrf_field(); ?>
                        <div class="form-group otp-input position-relative my-4">
                            <input type="text" class="form-control otp-input-field" id="otp1" maxlength="1">
                            <input type="text" class="form-control otp-input-field" id="otp2" maxlength="1">
                            <input type="text" class="form-control otp-input-field" id="otp3" maxlength="1">
                            <input type="text" class="form-control otp-input-field" id="otp4" maxlength="1">
                            <input type="hidden" name="otp" id="otp_value" class="form-control">
                            <input type="hidden" name="hasOtp" id="hasOtp" class="form-control" value="1">
                            <input type="hidden" name="type" id="type" class="form-control" value="patient">

                        </div>

                        <input type="hidden" name="otpkey" class="form-control" id="otpkey">
                        <input type="hidden" name="phonenumber" class="form-control" id="phonenumbers">
                        <input type="hidden" name="countrycode" class="form-control" id="countrycode">
                        <input type="hidden" name="countryCodeShort" class="form-control" id="countryCodeShorts1">
                        <input type="hidden" name="countryId" class="form-control" id="countryId">
                        <p id="credslabel" class="top-error"></p>
                    </form>


                    <div class="btn_alignbox mt-3">
                        <a href="javascript:void(0)" onclick="verifyOtp()" class=" btn btn-primary w-100">Verify</a>
                    </div>
                    <div class="text-center mt-4">
                        <p class="fwt-light">Didn’t get OTP Code?</p>
                        <p>
                            <a onclick="resendOtp()" href="javascript:void(0)" id="resendOtp"
                                class="primary fw-medium text-decoration-underline">Resend OTP</a>
                            <span id="timer" class="gray ms-2"> in 30s</span>
                        </p>
                    </div>

                </div>


            </div>
        </div>
    </div>




    <!-- Loader -->
    <div class="modal login-modal fade" id="loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span
                            class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body text-center">
                    <img src="<?php echo e(asset('images/loader.gif')); ?>" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- settings modal -->


    <div class="modal login-modal fade" id="settingsModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content ">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span
                            class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body text-center settings_wrapper_modal">
                    <div class="row">

                        <div class="col-xl-3">
                            <div class="nav flex-xl-column flex-row nav-pills settings-tab gap-2 me-3" id="v-pills-tab"
                                role="tablist" aria-orientation="vertical">
                                <div class="text-start w-100">
                                    <h4 class="fwt-bold">Settings</h4>
                                </div>
                                <button onclick="profileUpdate()" class="nav-link active" id="v-pills-home-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true"><span
                                        class="material-symbols-outlined">account_circle</span>My Profile</button>
                                <button onclick="showPhoneNumberModal()" class="nav-link" id="v-pills-profile-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false"><span
                                        class="material-symbols-outlined">call</span>Phone Number</button>
                                <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-settings" type="button" role="tab"
                                    aria-controls="v-pills-settings" aria-selected="false"><span
                                        class="material-symbols-outlined">delete </span>Delete Account</button>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="tab-content mt-xl-0 mt-3" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">

                                    <!-- Modal Content -->

                                </div>
                                <div class="tab-pane " id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <div class="text-start">
                                        <h5 class="fwt-bold">Change Phone Number</h5>
                                    </div>
                                    <div class="row mt-4" id="change_phone_modal">
                                        <!-- Modal Content -->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                    aria-labelledby="v-pills-settings-tab">
                                    <div class="text-start">
                                        <h5 class="fwt-bold">Delete Account</h5>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="text-start my-2">
                                                <p>Are you sure? This will permanently delete your BlackBag account.
                                                    Once the deletion process begins, you won't be able to reactivate
                                                    your account or retrieve any data or information.</p>
                                            </div>
                                        </div>
                                        <form method="post">
                                            <div class="col-12">
                                                <div class="btn_alignbox justify-content-end">
                                                    <input type="hidden" name="uuid"
                                                        value="<?php echo e(session()->get('user.patientID')); ?>">
                                                    <a class="btn btn-danger" onclick="deleteuser()">Delete My
                                                        Account</a>
                                                </div>

                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- settings end -->


   <!-------------------------------- add clinic  --------------------------------->

   <div class="modal login-modal fade" id="registerUser" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span
                  class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center" id="registerUserForm">



            </div>
          </div>
        </div>
      </div>

      <!-- End -->





    <script>
        $(document).ready(function () {

         
        });



        function closeOtpModal() {
            $('#otpform_modal').modal('hide');
            $('#verifyotpform')[0].reset();


        }

       


        //Submit Login
        function submitLogin(type) {


            validateUser();

            if ($("#loginformuser").valid()) {


                var url = "<?php echo e(url('frontend/submitlogin')); ?>";

                // Get the original phone number from the input field
                var phoneNumber = $("#phonenumber").val();

                // Clean the phone number (remove non-numeric characters)
                var cleanedPhoneNumber = phoneNumber.replace(/[^0-9]/g, '');

                var formData = $("#loginformuser").serialize();

                // Append the cleaned phone number to the form data
                formData += '&phonenumber=' + encodeURIComponent(cleanedPhoneNumber);
                formData += '&user=' + encodeURIComponent(type); // Add the user parameter to the form data

                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        'formdata': formData,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        console.log(data);

                        if (data.success == 1) {
                            $("#login").modal('hide');
                            $('#loginformuser')[0].reset();
                            $('#loginformuser .error').removeClass('error'); // Remove error classes
                            $('#loginformuser .error-message').text('');  // Remove error messages
                            $("#otpform_modal").modal('show');
                            $("#countryCodeShorts1").val(data.countryCodeShort);


                            swal(
                                "Success!",
                                "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                                "success",
                            ).then(() => {

                                $('#otp1').focus();
                                $("#otpkey").val(data.key);
                                $("#phonenumbers").val(data.phonenumber);
                                $("#countrycode").val(data.countrycode);
                                $("#countryCodeShorts1").val(data.countryCodeShort);
                                $("#countryId").val(data.countryId);
                                $('#otpPhone').text( data.countrycode + ' ' + data.phonenumber);
                                $("#type").val(data.type);

                            });

                            // swal("An OTP has been sent to your registered phone number.("+ data.otp+")", "", "success");
                            resendCountdown();
                        } else {
                            showOtpError(data.errormsg, 'login');
                        }
                    }
                });

            }

        }



        //Verify Otp
        function verifyOtp() {

            var otpValue = '';
            // Gather OTP value from individual fields
            $('.otp-input-field').each(function () {
                otpValue += $(this).val();
            });

            $('#otp_value').val(otpValue);

            // If the form passes validation
            if ($("#verifyotpform").valid()) {
                $.ajax({
                    url: '<?php echo e(url("frontend/verifyotp")); ?>',
                    type: "post",
                    data: {
                        'formdata': $("#verifyotpform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success == 1) {

                            $("#otpform_modal").modal('hide');

                            swal(
                                "Success!",
                                data.message,
                                "success",
                            ).then(() => {
                                window.location.href = "<?php echo e(url('/home')); ?>";
                                console.log(data);

                            });
                        } else {
                            $('.otp-input-field').val('');
                            // Optionally reset the hidden 'otp_value' field as well
                            $('#otp_value').val('');
                            // When OTP verification fails, show an error
                            showOtpError('Invalid OTP. Please try again.'); // Call the error display function
                        }
                    }
                });
            }
            // else {
            //     // If form validation fails
            //     if ($('.error:visible').length > 0) {
            //         setTimeout(function () {
            //             $('html, body').animate({
            //                 scrollTop: ($('.error:visible').first().offset().top - 100)
            //             }, 500);
            //         }, 500);
            //     }
            // }
        }




        // Function to display OTP error message dynamically
        function showOtpError(message, type = '') {
            var otpField, errorElement;

            if (type == 'login') {
                otpField = $('#credslabel'); // The field where the OTP is entered
                errorElement = $('<label class="error"></label>').text(message);
                otpField.html(errorElement);
            } else {
                otpField = $('.otp-input'); // The field where the OTP is entered
                errorElement = $('<label class="error"></label>').text(message); // Create the error label
                otpField.after(errorElement); // Insert error message after the OTP input field
            }



            // Scroll to the error message if needed

            // $('html, body').animate({
            //     scrollTop: (otpField.offset().top - 100)
            // }, 500);

            // Fade out the error message after 10 seconds
            setTimeout(function () {
                errorElement.fadeOut(500, function () {
                    $(this).remove(); // Remove the element from the DOM after fading out
                });
            }, 3000); // 10000 milliseconds = 10 seconds

        }


        $(document).ready(function () {
            /** remove validation if exists */
            otpField = $('.phone-number');
            otpField.on('input', function () {
                if ($(this).val().length === 0) {

                    otpField.next('.error').fadeOut(500, function () {
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
                        required: 'Please enter your OTP.',
                        minlength: 'OTP must be at least 4 digits long.'
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element); // Place error messages after the input fields
                }
            });

        });




        function resendOtp() {

            $.ajax({
                url: '<?php echo e(url("frontend/submitlogin")); ?>',
                type: "post",
                data: {
                    'formdata': $("#verifyotpform").serialize(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success == 1) {
                        $("#login").hide();
                        $("#otpform_modal").modal('show');
                        // $("#otpform").show();
                        $("#otpkey").val(data.key);
                        $("#phonenumbers").val(data.phonenumber);
                        $("#countrycode").val(data.countrycode);
                        $("#countryCodeShort").val(data.countryCodeShort);

                        swal(
                            "Success!",
                            "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                            "success",
                        ).then(() => {
                            console.log(data);

                        });
                        resendCountdown()
                    } else {

                    }
                }
            });

        }
    </script>


    <script>
        $(document).ready(function () {

            // When typing in an OTP field
            $('.otp-input-field').on('keyup', function (e) {
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
            });

            // Ensure only digits can be entered
            $('.otp-input-field').on('input', function () {
                this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-digit characters
            });




        });

        function resendCountdown() {
            var timerDuration = 30; // Duration in seconds
            var timer = timerDuration; // Set the initial timer value


            // Start the countdown
            var countdown = setInterval(function () {
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

            $("#registerUser").modal('show');
            $("#registerClinicForm").html( '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px">' + '</div>');

            $.ajax({
                url: '<?php echo e(url("registerclinic")); ?>',
                type: "post",
                data: {
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success == 1) {
                        $("#registerUser").modal('show');
                        $("#registerClinicForm").html(data.view);
                    } else {

                    }
                }
            });

            // $('#registerUser')[0].reset();
            // $('#registerUser').validate().resetForm();

        }

        function submitClinic() {

            if ($("#registerform").valid()) {
                // If form is valid, enable the button and submit the form

                $('#save_clinic').addClass("disabled");
                $('#save_clinic').text("Submitting...");

            }
            if ($("#registerform").valid()) {

                $.ajax({
                    url: '<?php echo e(url("clinic/store")); ?>',
                    type: "post",
                    data: {
                        'formdata': $("#registerform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success == 1) {
                            $("#registerUser").modal('hide'); // Hide the registration modal
                            $("#loader").modal('show'); // Show the loader modal
                            // Show successSignin modal after 2 seconds
                            setTimeout(function () {
                                $("#loader").modal('hide'); // Hide the loader modal
                                $("#successSignin").modal('show'); // Show the success modal
                            }, 2000); // 2 seconds

                            // Redirect to the dashboard after an additional 3 seconds
                            setTimeout(function () {
                                window.location.href = "<?php echo e(url('/dashboard')); ?>"; // Redirect to the dashboard
                            }, 2000); // 5 seconds (2 seconds + 3 seconds)
                            // 
                        } else {

                        }
                    }
                });

            } else {

            }

        }

        // Function to toggle the 'active' class


        function toggleLabel(input) {
            const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
            $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
        }
        // function toggleLabel(input) {
        //         $(input).parent().find('.float-label').toggleClass('active', $.trim(input.value) !== '');
        //       }


        $(document).ready(function () {
            profileUpdate();
            // Initialize label state for each input
            $('input, textarea').each(function () {
                toggleLabel(this);
            });

            // Handle label toggle on focus, blur, and input change
            $(document).on('focus blur input change', 'input, textarea', function () {
                toggleLabel(this);
            });

            // Handle the datetime picker widget appearance by re-checking label state
            $(document).on('click', '.bootstrap-datetimepicker-widget', function () {
                const input = $(this).closest('.time').find('input');
                toggleLabel(input[0]);
            });

            // Trigger label toggle when modal opens
            $(document).on('shown.bs.modal', function (event) {
                const modal = $(event.target);
                modal.find('input, textarea').each(function () {
                    toggleLabel(this);
                    // Force focus briefly to trigger label in case of any timing issues
                    $(this).trigger('focus').trigger('blur');
                });
            });

            // Reset label state when modal closes
            $(document).on('hidden.bs.modal', function (event) {
                const modal = $(event.target);
                modal.find('input, textarea').each(function () {
                    $(this).parent().find('.float-label').removeClass('active');
                });
            });
        });




        function profileUpdate() {
            var url = "<?php echo e(route('frontend.profileUpdate')); ?>";
            var key = "<?php echo e(session()->get('user.user_uuid')); ?>";

            $("#v-pills-home").html(
                '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px">' + '</div>');

            $.ajax({
                url: url,
                type: "post",
                data: {
                    'key': key,
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success == 1) {
                        $('#v-pills-home').html(data.view);
                        $('input, textarea').each(function () {
                            toggleLabel(this);
                        });

                    } else {

                    }
                }
            });

        }


        function deleteuser() {
            var url = "<?php echo e(route('frontend.deletePatient')); ?>";
            var uuid = "<?php echo e(session()->get('user.user_uuid')); ?>";


            swal("Are you sure you want to delete your account?", {
                title: "Delete!",
                icon: "warning",
                buttons: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            'uuid': uuid,
                            '_token': $('input[name=_token]').val()
                        },
                        success: function (response) {
                            swal(
                                "Deleted!",
                                "Your account has been deleted successfully",
                                "success"
                            ).then(() => {
                                console.log(response);
                                // Refresh the page when the nurse clicks OK or closes the alert
                                window.location.replace(response.redirect);

                            });
                        },
                        error: function (xhr, status, error) {
                            if (xhr.status === 0) {
                                // Request was cancelled
                                console.log("Request was cancelled");
                            } else {
                                swal("Error!", "Failed to delete nurse ", "error");
                            }
                        },
                    });
                    // Cancel the request if the nurse navigates away
                    $(window).on("unload", function () {
                        xhr.abort();
                    });
                }
            });

        }


        function showPhoneNumberModal() {
            var url = "<?php echo e(route('frontend.showPhoneNumberModal')); ?>";

            $("#change_phone_modal").html(
                '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px">' + '</div>');

            $.ajax({
                url: url,
                type: "post",
                data: {
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success == 1) {
                        $('#change_phone_modal').html(data.view);
                    } else {

                    }
                }
            });

        }



        function createPatient() {
            $('#login').modal('hide');
            $('#registerPatient').modal('show');
            var url = "<?php echo e(route('frontend.createPatient')); ?>";
            $("#registerPatientsForm").html(
                '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px">' + '</div>');

            $.ajax({
                url: url,
                type: "post",
                data: {
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success == 1) {
                        $('#registerPatientsForm').html(data.view);
                    }
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 0) {
                        // Request was cancelled
                        console.log("Request was cancelled");
                    } else {
                        swal("Error!", "Something went wrong", "error");
                        console.log(error);

                    }
                },
            });

        }

        function addClinic() {
          $.ajax({
            url: '<?php echo e(url("add/workspace?type=frontend")); ?>',
            type: "post",
            data: {
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                console.log(data);
                
                $("#registerUser").modal('show');
                $("#registerUserForm").html(data.view);
              } else {

              }
            }
          });

        }


        function showLogin() {
            $("#patient_login_modal").html( '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px">' + '</div>');
          $.ajax({
            url: '<?php echo e(url("frontend/show-login")); ?>',
            type: "post",
            data: {
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                console.log(data);
                
                $("#login").modal('show');
                $("#patient_login_modal").html(data.view);
              } else {

              }
            }
          });

        }

        function joinMeet(appoinment_uuid) {
          $('#videomeet_modal').modal('show');
          $('#videomeet').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');

          $.ajax({
            type: "POST",
            url: "<?php echo e(url('appointment/joinvideo')); ?>",
            data: {
              'appoinment_uuid': appoinment_uuid,
            },

            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
              // Populate form fields with the logger details

              if (response.success == 1) {
               
                $("#videomeet").html(response.view);

              }
            },
            error: function(xhr) {
              // Handle errors
              var errors = xhr.responseJSON.errors;
              if (errors) {
                $.each(errors, function(key, value) {
                  console.log(value[0]); // Display first error message
                });
              }
            },
          });

        }


    </script>

   <!-- change clinic -->

      <div class="modal login-modal fade" id="videomeet_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" id="videomeet">

          </div>
        </div>
      </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"
        integrity="sha512-f8mwTB+Bs8a5c46DEm7HQLcJuHMBaH/UFlcgyetMqqkvTcYg4g5VXsYR71b3qC82lZytjNYvBj2pf0VekA9/FQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"
        integrity="sha512-A64Nik4Ql7/W/PJk2RNOmVyC/Chobn5TY08CiKEX50Sdw+33WTOpPJ/63bfWPl0hxiRv1trPs5prKO8CpA7VNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="<?php echo e(asset('frontend/js/script.js')); ?>"></script>

</body>

</html><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/master.blade.php ENDPATH**/ ?>