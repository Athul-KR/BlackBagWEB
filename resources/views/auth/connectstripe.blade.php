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
    <section class="signin-page patient-signin-page">
        <div class="container-fluid p-0">
            <div class="row position-relative">
                <div class="col-12 col-lg-6">
                    <div class="sign-in-left-sec">
                        <div class="d-flex justify-content-between w-100">
                            <img src="{{ asset('images/loginlogo.png')}}"  class="img-fluid" alt="Logo">
                            <a href="{{url('/login')}}" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
                        </div>
                        <div>
                            <h1 class="white"><strong>Virtual Care at Your Fingertips</strong></h1>
                            <p class="white mb-0">Providing you with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.</p>
                        </div>
                    </div>
                    <div class="d-lg-none d-block d-flex justify-content-center mob-logo w-100">
                        <img src="{{asset('images/loginlogo.png')}}" class="img-fluid logo_singin mb-4" alt="Logo">
                        <a href="{{url('/login')}}" onclick="backTologin()" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card-body">
                        <div class="row" id="">
                            <!-- <div class="col-12 mb-3 mb-lg-5">
                                <div class="card trail-card">
                                    <div class="card-body d-flex align-items-center justify-content-center justify-content-md-start flex-wrap flex-md-nowrap">
                                        <img src="{{asset('images/time-icon.png')}}" class="img-fluid my-2" alt="Time">
                                        <div class="trail-card-txt ms-md-4 text-center text-md-start">
                                            <h2><strong>Your 15 day Trial Period Has Started! 🎉</strong></h2>
                                            <p class="mb-0">Enjoy full access to all features during your trial period. 
                                            Explore, experience, and make the most of it!</p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-8 col-lg-12 col-xl-6 col-xxl-6 mx-auto my-3 my-lg-5">
                               <div class="setup-pay text-center">
                                    <h1>Setup Payout</h1>
                                    <p>BlackBag integrates with Stripe to enable seamless payouts </p>
                                    <div class="d-flex align-items-center justify-content-center my-3 my-lg-5">
                                        <img src="{{asset('images/logo-icon.png')}}" class="img-fluid payout-logo" alt="Blackbag Logo">
                                        <img src="{{asset('images/stripe-loader.gif')}}" class="img-fluid mx-4 stripe-loader" alt="loader">
                                        <img src="{{asset('images/strip-icon.png')}}" class="img-fluid payout-logo" alt="Stripe Logo">
                                    </div>
                                    <p>When Stripe processes your first live payment, the initial payout to your bank account is typically scheduled within 7-14 days.</p>
                                    <a id="sendotp" href="" class="btn btn-primary w-100 mb-4">Connect Stripe</a>
                                    <a class="primary fw-medium text-decoration-underline" onclick="signUp('')">Sign Up</a>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Correct script order -->
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- Bootstrap JS (with Popper.js for modals to work) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function getQueryParam(name) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }
            let redirectURL = getQueryParam("redirectURL");
            if (redirectURL) {
                $("#sendotp").attr("href", redirectURL);
            }
        });
    </script>
</body>

</html>
