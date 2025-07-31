<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @if(isset($seo['title']) && !empty($seo['title'])) {{$seo['title'] }} @else BlackBag @endif</title>
    <meta name="keywords" content="{{ isset($seo['keywords'])&& $seo['keywords']!='' ? $seo['keywords'] : '' }}">
    <meta name="description" content="{{ isset($seo['description'])&& $seo['description']!='' ? $seo['description'] : '' }}">

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
                                    <div class="login-inner-data mt-4">

                                        <h1 class="mb-3 actioncls">Welcome</h1>

                                        <div class="text-center">
                                            <span class="material-symbols-outlined warning-icon">warning</span>
                                            <div class="invitation-wrapper mt-2 mb-4">
                                                <h5 class="mb-0">A user is already logged in to the system. Are you sure you want to continue?</h5>
                                            </div>
                                            <div class="text-center btn_alignbox">
                                                <button id="logoutButton" class="btn btn-primary ">Yes</button>
                                                <a href="{{url('/login')}}" class="btn btn-primary">No</a>
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

    <!-- Correct script order -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- Bootstrap JS (with Popper.js for modals to work) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#logoutButton').click(function() {
                $.ajax({
                    url: '{{ route("impersonate.forceLogout") }}',
                    method: 'POST',
                    data: {
                        token: "{{ $token }}"
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);

                        window.location.href = response.redirect_url;

                    },
                    error: function(xhr) {
                        swal({
                            title: "Error",
                            text: "An error occurred while logging out.",
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>


</body>

</html>