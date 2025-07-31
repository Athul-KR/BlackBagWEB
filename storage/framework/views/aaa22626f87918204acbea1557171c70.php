<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(asset('frontend/images/favicon.png')); ?>" sizes="64x64" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <title><?php if(isset($seo['title']) && !empty($seo['title'])): ?><?php echo e($seo['title']); ?><?php else: ?> BlackBag <?php endif; ?></title>
    <meta name='keywords' content="<?php echo (isset($seo['keywords']) && $seo['keywords']!= '') ? $seo['keywords'] : ''; ?>"/>
    <meta name="description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : ''; ?> ">
    <meta property="og:title" content="<?php echo (isset($seo['title']) && $seo['title']!= '') ? $seo['title'] : '{{ TITLE }}'; ?> ">
    <meta property="og:description" content="<?php echo (isset($seo['og_description']) && $seo['og_description']!= '') ? $seo['og_description'] : $seo['description']; ?>">
    
    <meta property="og:image" content="<?php if(isset($seo['og_image']) && $seo['og_image']!= ''): ?><?php echo e(asset($seo['og_image'])); ?><?php else: ?><?php echo e(asset('/images/og-blackbag.png')); ?><?php endif; ?>">
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jquery.colorbox.js')); ?>"></script>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Bootstrap JS (with Popper.js for modals to work) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- TelInput Country code -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <!-- Include Moment Timezone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_API_KEY')); ?>&libraries=places" async defer></script>
    <script src="<?php echo e(asset('/tinymce/tinymce.min.js')); ?>" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

      <!-- Daterangepicker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Moment.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
    <!-- Daterangepicker JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-datetimepicker.css')); ?>">
    
    <?php if(env('APP_ENV') == 'production'): ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-YVECXP6J1S"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-YVECXP6J1S');
        </script>
    <?php endif; ?>
</head>

<body>
    <style>
        .daterangepicker {
            z-index: 1050 !important;
        }


        label.error {
            color: var(--danger);
            font-size: 0.75rem !important;
            position: relative;
            bottom: -22px !important;
            top: auto;
            left: 0;
            font-weight: 500;
        }
    </style>
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
    <header class="<?php if(isset($ishome) && $ishome == '1'): ?> home-nav <?php endif; ?>">
        <nav class="navbar navbar-expand-xl fixed-top p-3 nav-topbar">
            <a href="<?php echo e(route('frontend.index')); ?>" class="logo-section">
                <img <?php if(isset($ishome) && $ishome == '1'): ?> src="<?php echo e(asset('frontend/images/blackbagwhite.png')); ?>" <?php else: ?> src="<?php echo e(asset('frontend/images/logo.png')); ?>" <?php endif; ?> class="img-fluid logo-main" alt="BlackBag Logo">
            </a>
            <a href="<?php echo e(route('frontend.index')); ?>" class="home-logo">
                <img src="<?php echo e(asset('frontend/images/logo.png')); ?>" class="img-fluid logo-main" alt="BlackBag Logo">
            </a>

            <div class="d-flex align-items-center gap-xl-3 gap-2 order-xl-1 order-0">
           
              
                <?php if(session()->has('user') ): ?>
                    <?php if(env('app_env') != 'production'): ?>
                    <?php if(session()->get('user.userType') == 'patient'): ?>
            
                        <a class="btn btn-primary" href="<?php echo e(url('patient/dashboard')); ?>" >Access BlackBag</a>
                    <?php else: ?>
                        <a class="btn btn-primary" href="<?php echo e(url('dashboard')); ?>">Access BlackBag</a>

                    <?php endif; ?>
                      <?php endif; ?>
                <?php endif; ?>
                 <?php if(!session()->has('user') ): ?>
                <a class="btn btn-primary" href="<?php echo e(url('login')); ?>" >Login/Sign Up</a>
                    <?php endif; ?>
                <button class="navbar-toggler x" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="material-symbols-outlined">menu</span>
                </button>



            </div>

            <div class="collapse navbar-collapse justify-content-lg-center order-xl-0 order-1" id="navbarNav">
                <ul class="navbar-nav mb-2 mb-lg-0 mt-xl-0 mt-3">
                   
                    <li class="nav-item <?php echo e(request()->routeIs('frontend.index') ? 'active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('frontend.index')); ?>">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <?php /* <!-- <li class="nav-item {{request()->routeIs('frontend.findDoctorsAndClinics') ? 'active': ''}}">
                                <a class="nav-link" href="{{route('frontend.findDoctorsAndClinics')}}">Find Doctors & Clinics</a>
                            </li> -->*/?>
                    <li class="nav-item <?php echo e(request()->routeIs('frontend.forDoctors') ? 'active': ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('frontend.forDoctors')); ?>">For Doctors</a>
                    </li>
                    <li class="nav-item <?php echo e(request()->routeIs('frontend.forClinics') ? 'active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('frontend.forClinics')); ?>">For Clinics</a>
                    </li>
                    <li class="nav-item <?php echo e(request()->routeIs('frontend.pricing') ? 'active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('frontend.pricing')); ?>">Pricing</a>
                    </li>
                    <?php /* <!--
                                        <li class="nav-item ">
                                            <a class="nav-link" href="">Medical Tourism</a>
                                        </li>
                            -->*/?>
                    <li class="nav-item <?php echo e(request()->routeIs('frontend.contactUs') ? 'active' : ''); ?>">
                        <a class="nav-link" href="<?php echo e(route('frontend.contactUs')); ?>">Contact Us</a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>







    <?php echo $__env->yieldContent('content'); ?>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xxl-7 col-lg-5 col-12">
                            <div class="image-container">
                                <img src="<?php echo e(asset('frontend/images/transpernt_logo.png')); ?>" class="img-fluid" alt="BlackBag Logo">
                                <h5 class="mt-2">Virtual Care at Your Fingertips</h5>
                            </div>
                        </div>
                        <div class="col-xxl-5 col-lg-7 col-12">
                            <div class="footer-inner mt-lg-0 mt-3">
                                <div>
                                    <ul>
                                        <li class="fwt-bold">BlackBag</li>
                                        <?php /* <!-- <li><a class="white" data-bs-toggle="modal" data-bs-dismiss="modal"
                                                data-bs-target="#changePass">Join Us</a>
                                        </li> -->*/?>
                                       
                                        <li><a href="<?php echo e(route('frontend.contactUs')); ?>" class="white">Contact Us</a></li>
                                        <li><a href="<?php echo e(route('frontend.pricing')); ?>" class="white">Pricing</a></li>
                                        <!-- <li><a href="<?php echo e(route('frontend.contactUs')); ?>" class="white">Help & Support</a></li> -->
                                    </ul>
                                </div>
                                <?php /* <!-- <div>
                                    <ul>
                                        <li class="fwt-bold">For Patients</li>
                                        <li><a href="{{route('frontend.findDoctorsAndClinics')}}" class="white">Find
                                                Doctors</a></li>
                                        <li><a class="white">Search Specialities</a></li>
                                    </ul>
                                </div> -->*/?>
                                <div>
                                    <ul>
                                        <li class="fwt-bold">More</li>
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
                            <ul class="my-sm-0 mb-0">
                                 <li> Copyright © <?php echo e(env('APP_NAME')); ?> <?php echo e(date('Y')); ?>. All rights reserved.</li>
                            </ul>
                        </div>
                        <!-- <div class="col-md-6 col-12">
                            <ul class="social-media flex-row justify-content-center justify-content-sm-end">
                                <li><a  href="#" class="white" onclick="return false;"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"class="white" onclick="return false;"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="#"class="white" onclick="return false;"><i class="fa-brands fa-x-twitter"></i></a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- MOdals -->
<!-- change clinic -->

      <div class="modal login-modal fade" id="change_clinic_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center position-relative" id="cliniclist">

            </div>
          </div>
        </div>
      </div>

      <!-- change clinic -->

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
                    <p>OTP has been sent to<span class="fw-medium primary phn-otp ms-2" id="otpPhone"></span></p>

                    <form method="POST" id="verifyotpform" autocomplete="off">
                        <?php echo csrf_field(); ?>
                        <div class="form-group otp-input position-relative my-4">
                            <input type="text" class="form-control otp-input-field" id="otp1" maxlength="1">
                            <input type="text" class="form-control otp-input-field" id="otp2" maxlength="1">
                            <input type="text" class="form-control otp-input-field" id="otp3" maxlength="1">
                            <input type="text" class="form-control otp-input-field" id="otp4" maxlength="1">
                            <input type="hidden" name="otp" id="otp_value" class="form-control">
                            <input type="hidden" name="hasOtp" id="hasOtp" class="form-control" value="1">
                            <input type="hidden" name="type" id="type" class="form-control" value="<?php if(isset($type)): ?> <?php echo e($type); ?> <?php else: ?> patient <?php endif; ?>">

                        </div>

                        <input type="hidden" name="otpkey" class="form-control" id="otpkey">
                        <input type="hidden" name="phonenumber" class="form-control" id="phonenumbers">
                        <input type="hidden" name="countrycode" class="form-control" id="countrycode">
                        <input type="hidden" name="countryCodeShort" class="form-control" id="countryCodeShorts1">
                        <input type="hidden" name="countryId" class="form-control" id="countryId">
                        <p id="credslabel" class="top-error"></p>
                    </form>


                    <div class="btn_alignbox mt-3">
                        <a href="javascript:void(0)" onclick="verifyOtp()" class=" btn btn-primary w-100 btndisable">Verify</a>
                    </div>
                    <div class="text-center mt-4">
                        <p class="fwt-light">Didn’t get OTP Code?</p>
                        <p>
                            <a onclick="resendOtp()" href="javascript:void(0)" id="resendOtp"
                                class="primary fw-medium text-decoration-underline disabled">Resend OTP</a>
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
                    <img src="<?php echo e(asset('images/loader.gif')); ?>" class="img-fluid"  alt="Loader">
                </div>
            </div>
        </div>
    </div>

    <div class="modal login-modal payment-success fade" id="addcard_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="_modal">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body">
                    <div class="text-center amount_body mb-3">
                        <h4 class="text-center fwt-bold mb-1">Add New Card</h4>
                        <p class="fw-light gray">Please enter card details</p>
                    </div>
                    <form method="POST" action="" id="addcardsform" autocomplete="off">
                    <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-outline mb-4">
                                    <i class="material-symbols-outlined">id_card</i>
                                    <label for="input" class="float-label">Cardholder Name</label>
                                    <input type="name" class="form-control" id="name_on_card" name="name_on_card">
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="add-card-element">

                                </div>
                            </div>
                            <div class="btn_alignbox mt-5">
                                <button type="submit" id="submitbtn" class="btn btn-primary w-100">Add Card</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- settings modal -->
 <?php if(session()->has('user') && session()->get('user.userType') == 'patient'): ?>

    <div class="modal login-modal fade" id="settingsModal" data-bs-backdrop="static" data-bs-keyboard="false"tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
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
                                <!-- <button onclick="profileUpdate()" class="nav-link active" id="v-pills-home-tab"
                                    data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true"><span
                                        class="material-symbols-outlined">account_circle</span>My Profile</button>

                                <button onclick="getCards()" class="nav-link" id="v-pills-cards-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-cards" type="button" role="tab"
                                    aria-controls="v-pills-cards" aria-selected="false"><span
                                        class="material-symbols-outlined">credit_card </span>My Cards</button> -->

                                <button onclick="deleteAccount()" class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-settings" type="button" role="tab"
                                    aria-controls="v-pills-settings" aria-selected="false"><span
                                        class="material-symbols-outlined">delete </span>Delete Account</button>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="tab-content mt-xl-0 mt-3" id="v-pills-tabContent">
                                <div id="loaderset"> </div>
                                <div class="tab-pane fade" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">

                                    <!-- Modal Content -->

                                </div>
                                <div class="tab-pane fade" id="v-pills-cards" role="tabpanel"
                                    aria-labelledby="v-pills-cards-tab">

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
                                    <div class="text-center">
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
                                                <div class="btn_alignbox justify-content-center">
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

<?php endif; ?>
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
        
        const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        
         function selectTeam(clinicID) {

          $.ajax({

            url: '<?php echo e(url("/workspace/select")); ?>',
            type: "post",
            data: {
              'clinicID': clinicID,
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
              // checkSession(data);
              if (data.success == 1) {

                window.location.href=data.redirecturl;

              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
          });
        }

         function changeClinic() {
          $("#change_clinic_modal").modal('show');
          showPreloader('cliniclist');

          $.ajax({

            url: '<?php echo e(url("/workspace/change")); ?>',
            type: "post",
            data: {
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
              // checkSession(data);
              if (data.success == 1) {
                $("#cliniclist").html(data.view);
              }
            }, error: function(xhr, status, error) {
              handleError(xhr);
            }
          });
        }
         $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
         function handleError(xhr) {
    if (xhr.status === 419) {
        // Session expired logic
        const response = JSON.parse(xhr.responseText);
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
                 var toURL = "<?php echo e(URL::to('/login')); ?>";
                // Redirect to the login page
                window.location.href = toURL;  // Explicit login redirect instead of reloading
            });
        }
    } else {
       
        // Handle other errors (e.g., server errors, network errors)
        if (xhr.status != 0) {
            swal({
                icon: 'error',
                title: 'An Error Occurred',
                text: 'Something went wrong. Please try again later.',
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
}

        $(document).ready(function () {

         
        });



        function closeOtpModal() {
            $('#otpform_modal').modal('hide');
            $('#verifyotpform')[0].reset();
        }
        function showSettingsModal(){
            $("#settingsModal").modal('show');
            $('#v-pills-home').html('');
            $('#settingsModal').on('shown.bs.modal', function () {
                // $('#loaderset').html('<div id="settingsloader" class="justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');
                // profileUpdate();
                deleteAccount();
            });
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
                        '_token': $('meta[name="csrf-token"]').attr('content')
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
                    },
                    error: function(xhr) {
                        
                        handleError(xhr);
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
            $('.btndisable').addClass("disabled");
            // If the form passes validation
            if ($("#verifyotpform").valid()) {
                
                $.ajax({
                    url: '<?php echo e(url("frontend/verifyotp")); ?>',
                    type: "post",
                    data: {
                        'formdata': $("#verifyotpform").serialize(),
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.success == 1) {
                            console.log(data.token);
                            if (data.token == 'delete') {
                                window.location.href = "<?php echo e(route('frontend.logout')); ?>";
                            }

                            $("#otpform_modal").modal('hide');

                            swal({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                          window.location.href = "<?php echo e(url('/home')); ?>";
                        });

                         
                        } else {
                            $('.otp-input-field').val('');
                            // Optionally reset the hidden 'otp_value' field as well
                            $('#otp_value').val('');
                            $('.btndisable').removeClass("disabled");
                            // When OTP verification fails, show an error
                            showOtpError('Invalid OTP. Please try again.'); // Call the error display function
                        }
                    },
                    error: function(xhr) {
                        
                        handleError(xhr);
                    },
                });
            }else{
                $('.btndisable').removeClass("disabled");
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

                // Check if an error label already exists
                if (otpField.find('label.error').length === 0) {
                    errorElement = $('<label class="error"></label>').text(message); // Create a new error label
                    otpField.html(errorElement); // Replace the content with the error
                } else {
                    otpField.find('label.error').text(message); // Update the existing error message
                }
            } else {
                otpField = $('.otp-input'); // The field where the OTP is entered

                // Check if an error label already exists
                if (otpField.find('label.error').length === 0) {
                    errorElement = $('<label class="error"></label>').text(message); // Create a new error label
                    otpField.append(errorElement); // Insert error message after the OTP input field
                } else {
                    otpField.find('label.error').text(message); // Update the existing error message
                }
            }

            // Scroll to the error message if needed
            // $('html, body').animate({
            //     scrollTop: (otpField.offset().top - 100)
            // }, 500);

            // Fade out the error message after 3 seconds
            setTimeout(function () {
                otpField.find('label.error').fadeOut(500, function () {
                    $(this).remove(); // Remove the element from the DOM after fading out
                });
            }, 3000); // 3000 milliseconds = 3 seconds
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
                        required: 'Please enter OTP.',
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
                    '_token': $('meta[name="csrf-token"]').attr('content')
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
                        $("#countryCodeShorts1").val(data.countryCodeShort);

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
                },
                error: function(xhr) {
               
                    handleError(xhr);
                }
            });

        }
    </script>


    <script>
           function getNotificationsList(selectedDate='') {
  
 
            showPreloader('notificationlist');
          
            $.ajax({
                type: "POST",
                url: '<?php echo e(url("/notifications/list")); ?>',
                data: {
                    'date': selectedDate,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle the successful response
                    if(response.success == 1){
                        $("#notificationlist").html(response.view);
                    }
                
                }, 
                error: function(xhr) {
                    
                    handleError(xhr);
                },
            })
            }
     
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



        function signUp() {
            $("#signin").modal('show');
        }



        function registerUser() {
            var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;            
            var timeZoneMapping = {
                "Asia/Calcutta": "Asia/Kolkata",       
            };
            var mappedTimeZone = timeZoneMapping[timeZone] || timeZone;
            $("#registerUser").modal('show');
            $("#registerClinicForm").html( '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px"  alt="Loader">' + '</div>');

            $.ajax({
                url: '<?php echo e(url("registerclinic")); ?>',
                type: "post",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'timezoneOffset': mappedTimeZone
                },
                success: function (data) {
                    if (data.success == 1) {
                        $("#registerUser").modal('show');
                        $("#registerClinicForm").html(data.view);
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
                // If form is valid, enable the button and submit the form

                $('#save_clinic').addClass("disabled");
                $('#save_clinic').text("Submitting...");

            }
            if ($("#registerform").valid()) {

                $.ajax({
                    url: '<?php echo e(url("clinic/store")); ?>',
                    type: "post",
                    data: {
                        'formType' : 'forclinic',
                        'formdata': $("#registerform").serialize(),
                        '_token': $('meta[name="csrf-token"]').attr('content')
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
                                window.location.href = "<?php echo e(url('/login')); ?>"; // Redirect to the dashboard
                            }, 2000); // 5 seconds (2 seconds + 3 seconds)
                            // 
                        } else {

                        }
                    },
                    error: function(xhr) {
               
                        handleError(xhr);
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
        function getCards(){
            var url = "<?php echo e(route('frontend.getcards')); ?>";
            $('#v-pills-cards').html('');
            $('#loaderset').html('<div id="settingsloader" class="justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"  alt="Loader"></div>');
            $.ajax({
                url: url,
                type: "post",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.success == 1) {
                        $('#v-pills-settings').removeClass('active');
                        $('#v-pills-settings').removeClass('show');
                        $('#v-pills-settings-tab').removeClass('active');
                        $('#v-pills-settings-tab').removeClass('show');
                        $('#v-pills-home').removeClass('active');
                        $('#v-pills-home').removeClass('show');
                        $('#v-pills-home-tab').removeClass('active');
                        $('#v-pills-home-tab').removeClass('show');
                        $('#v-pills-cards').addClass('show');
                        $('#v-pills-cards').addClass('active');
                        $('#v-pills-cards-tab').addClass('show');
                        $('#v-pills-cards-tab').addClass('active');
                        $('#settingsloader').hide();
                        $('#v-pills-cards').html('');
                        $('#v-pills-cards').html(data.view);
                        $('input, textarea').each(function () {
                            toggleLabel(this);
                        });
                    } else {

                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        }
        function deleteAccount() {
            $('#v-pills-home').html('<div id="settingsloaderdelete" class="justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"  alt="Loader"></div>');
            $('#v-pills-home').removeClass('active');
            $('#v-pills-home').removeClass('show');
            $('#v-pills-home-tab').removeClass('active');
            $('#v-pills-home-tab').removeClass('show');
            $('#v-pills-cards').removeClass('active');
            $('#v-pills-cards').removeClass('show');
            $('#v-pills-cards-tab').removeClass('active');
            $('#v-pills-cards-tab').removeClass('show');
            $('#settingsloaderdelete').hide();
            $('#v-pills-settings').addClass('show');
            $('#v-pills-settings').addClass('active');
            $('#v-pills-settings-tab').addClass('show');
            $('#v-pills-settings-tab').addClass('active');
        }
        function profileUpdate() {
           
            var url = "<?php echo e(route('frontend.profileUpdate')); ?>";
            var key = "<?php echo e(session()->get('user.user_uuid')); ?>";
            $('#v-pills-home').html('');
            $('#loaderset').html('<div id="settingsloader" class="justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"  alt="Loader"></div>');
            // $("#v-pills-home").html(
            //     '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px">' + '</div>');

            $.ajax({
                url: url,
                type: "post",
                data: {
                    'key': key,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log('test')
                    if (data.success == 1) {
                        $('#v-pills-settings').removeClass('active');
                        $('#v-pills-settings').removeClass('show');
                        $('#v-pills-settings-tab').removeClass('active');
                        $('#v-pills-settings-tab').removeClass('show');
                        $('#v-pills-cards').removeClass('active');
                        $('#v-pills-cards').removeClass('show');
                        $('#v-pills-cards-tab').removeClass('active');
                        $('#v-pills-cards-tab').removeClass('show');
                        $('#v-pills-home-profile').addClass('show');
                        $('#v-pills-home-profile').addClass('active');
                        $('#v-pills-home-tab').addClass('show');
                        $('#v-pills-home-tab').addClass('active');
                        $('#settingsloader').hide();
                        $('#v-pills-home-profile').html('');
                        $('#v-pills-home-profile').html(data.view);

                        $('input, textarea').each(function () {
                            toggleLabel(this);
                        });
                        initializeAutocompleteSettings();
                        phonenumberEdit();
                    } else {

                    }
                },
                error: function(xhr) {
               
                    handleError(xhr);
                }
            });

        }


           function deleteuser() {
             var url = "<?php echo e(url('frontend/delete')); ?>";
            var phone = $('#phoneeditinput').val();
            var countryCode = $('#countryCodeEdit').val();
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
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                         

                                if (data.success == 1) {
                                    // $("#settingsModal").hide();
                                    $("#settingsModal").modal('hide');
                                    $("#otpform_modal").modal('show');
                                    // $("#otpform").show();
                                    $('#otp1').focus();
                                    $("#otpkey").val(data.key);
                                    $("#phonenumbers").val(data.phonenumber);
                                    $("#countrycode").val(data.countrycode);
                                    $("#countryCodeShorts").val(data.countryCodeShort);
                                    $("#countryCodeShorts1").val(data.countryCodeShort);
                                    $("#countryId").val(data.countryId);
                                    $('#otpPhone').text(data.countrycode + ' ' + data.phonenumber);
                                    $("#type").val(data.type);

                                    swal(
                                        "Success!",
                                        "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                                        "success",
                                    ).then(() => {
                                        // $("#otpform").addClass('show');
                                        console.log(data);

                                    });


                                    resendCountdown();
                                } else {
                                    showOtpError(data.errormsg, 'login');
                                    swal(
                                        "Error!",
                                        data.errormsg,
                                        "error",
                                    ).then(() => {
                                        console.log(data);


                                    });
                                }
                        },
                        
                        error: function(xhr) {
                            handleError(xhr);
                        }
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
                '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px"  alt="Loader">' + '</div>');

            $.ajax({
                url: url,
                type: "post",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.success == 1) {
                        $('#change_phone_modal').html(data.view);
                    } else {

                    }
                },
                error: function(xhr) {
                    
                    handleError(xhr);
                }
            });

        }



        function createPatient() {
            $('#login').modal('hide');
            $('#registerPatient').modal('show');
            var url = "<?php echo e(route('frontend.createPatient')); ?>";
            $("#registerPatientsForm").html(
                '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px"  alt="Loader">' + '</div>');

            $.ajax({
                url: url,
                type: "post",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.success == 1) {
                        $('#registerPatientsForm').html(data.view);
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
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
            },
            error: function(xhr) {
                handleError(xhr);
            },
          });

        }


        function showLogin() {
            $("#patient_login_modal").html( '<div class="d-flex justify-content-center py-5">' + '<img src="<?php echo e(asset('images/loader.gif')); ?>" width="250px"  alt="Loader">' + '</div>');
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
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
          });

        }

        function joinMeet(appoinment_uuid) {
          $('#videomeet_modal').modal('show');
          $('#videomeet').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"  alt="Loader"></div>');

          $.ajax({
            type: "POST",
            url: "<?php echo e(url('appointments/joinvideo')); ?>",
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

              }else{
                $('#videomeet_modal').modal('hide');
                swal({
                     icon: 'error',
                     text: response.message,
                   });
              }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
          });

        }
        function showPreloader(parmID) {
          var loaderimgPath = "<?php echo e(asset('images/loader.gif')); ?>";
          $('#' + parmID).html('<div class="modal-body text-center"><img src="' + loaderimgPath + '" class="loaderImg"  alt="Loader"></div>');
        }
        function joinSession(appointmentUuid) {
            online('open');
            $('#videomeet_modal').modal('hide');
            // If user confirms, redirect to the session URL
            window.open("<?php echo e(url('meet/')); ?>" + "/" + appointmentUuid, "_blank");
            
        }
        function online(status, page = 1, perPage = 10) {
          
            $("#pills-notes").hide();
            $("#pills-tabContent").show();

            var clinickey = $('#clinic').val();
            var url = $('#pills-home-tab').attr('data-url');
            console.log('clinic'+clinickey);
            $('#online-content').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"  alt="Loader"></div>');

            $.ajax({
                type: "post",
                url: url,
                data: {
                    'status': status,
                    'page': page,
                    'perPage': perPage,
                    'clinickey' : clinickey,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    if (response.success == 1) {
                        // Handle the successful response
                        $("#online-content").html(response.html);
                        $("#pagination-links").html(response.pagination); // Update pagination links

                        // Attach click event to pagination links
                        $("#pagination-links a").on("click", function(e) {
                            e.preventDefault();
                            const newPage = $(this).attr("href").split("page=")[1];
                            online(status, newPage);
                        });

                    } else {
                        
                        swal(
                            "Error!",
                            response.message,
                            "success",
                        ).then(() => {
                            console.log(response);
                            window.location.href(response.redirect);

                        });
                    }


                },
                error: function(xhr) {
                 
                    handleError(xhr);
                }
            })
        }
        
let socket = null;  // WebSocket instance

function connectSocket() {
    if (socket && socket.readyState === WebSocket.OPEN) {
        console.log("WebSocket already connected.");
        return socket;  // Return existing connection if already connected
    }

    const socketUrl = "<?php echo e(env('WSS_SOCKET_END_POINT')); ?>";
      
    const participantKey = "<?php echo e(Session::get('user.userSessionID')); ?>";

    socket = new WebSocket(socketUrl);

    socket.onopen = function() {
        console.log('WebSocket connection opened.');
        const payload = {
            "action": "sendmessage",
            "data": {
                "event": "connect",
                "participant_uuid": participantKey
            }
        };
        const jsonPayload = JSON.stringify(payload);
        socket.send(jsonPayload);
    };

    socket.onerror = function(error) {
        console.error('WebSocket error:', error);
    };

    socket.onclose = function(event) {
        console.log("WebSocket connection closed unexpectedly.");
    };

    return socket;  // Return the WebSocket connection
}

function getSocket() {
    if (!socket) {
        socket = connectSocket();
    }
    return socket;  // Return the current socket instance
}

function sendMessage(message) {
    const socket = getSocket();  // Ensure WebSocket is open
    if (socket && socket.readyState === WebSocket.OPEN) {
        socket.send(JSON.stringify(message));  // Send message
    } else {
        console.log("WebSocket is not open yet.");
    }
}

    </script>

   <!-- change clinic -->

      <div class="modal login-modal payment-success fade" id="videomeet_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content" id="videomeet">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
              </div>
            <div class="modal-body">

          </div>
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

</html><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/master_website.blade.php ENDPATH**/ ?>