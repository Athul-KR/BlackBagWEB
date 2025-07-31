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


                <!-- If the nurse uuid or key matches -->


                <div class="col-12 col-lg-6">
                    <div class="card-body">
                        <div class="row" id="login">
                            <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-8 mx-auto">
                                <div class="login-form text-center position-relative">

                                    <p id="credslabel" class="top-error"></p>
                                    <div class="login-inner-data mt-4">

                                        <h1 class="mb-3">Welcome</h1>

                                        <!-- If another user is already loged in make him logout -->
                                        @if ( session()->has('user'))

                                        <div class="text-center">
                                            <span class="material-symbols-outlined warning-icon">warning</span>
                                            <div class="invitation-wrapper mt-2 mb-4">
                                                <h5 class="mb-0">A user is already logged in to the system. Please logout to continue accepting the invite.</h5>
                                            </div>
                                            <div class="text-center mt-2">
                                                <a href=" {{url('logout?redirectinvite=invitation/'.$key.'/nurse')}}" class="btn btn-primary w-100">Logout</a>
                                            </div>
                                        </div>
                                        <!-- {{$clinicnurseDetails}} -->
                                        <!-- If user already created -->
                                        @elseif($clinicnurseDetails ==null)

                                        <div class="text-center">
                                            <span class="material-symbols-outlined primary error-icon"> running_with_errors</span>
                                            <div class="mt-2 mb-4">
                                                <h5 class="mb-0 primary">Invitation Expired!</h5>
                                            </div>
                                        </div>

                                        <div class="text-center mt-2">
                                            <a href=" {{url('/logout')}}" class="btn btn-primary w-100">Login</a>
                                        </div>

                                        <!-- If user is new -->
                                        @else
                                        <div class="text-center">
                                            <span class="material-symbols-outlined primary accept-icon">handshake</span>
                                            <div class="mt-2 mb-4">
                                                <h5 class="mb-0 primary">You have been invited to Join BlackBag.What would you like to do?</h5>
                                            </div>
                                        </div>
                                        <div id="invite-url" class="btn_alignbox flex-row" data-url="{{route('nurse.invitationStatusChange',['key'=>$key])}}">
                                            <a class="btn btn-outline-danger w-100 submitbtn" onclick="invitationStatusChange('0')">Decline</a>
                                            <a class="btn btn-primary w-100 submitbtn" onclick="invitationStatusChange('1')">Accept</a>
                                        </div>
                                        @endif



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


    <script type="text/javascript">
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
                // Redirect to the login page
                window.location.href = '/login';  // Explicit login redirect instead of reloading
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

        function invitationStatusChange(accept) {

            var alreadyLoggined = "{{session()->has('user')}}";
            var accessToken = "{{Session::get('user.authaccessToken')}}";
            var url = $('#invite-url').data('url');
            // console.log(url);
            var msg = (accept == 1) ? "Are you sure you want to accept the invitation?" : "Are you sure you want to decline the invitation?";

            if (accept == 1) {
                swal({
                        title: "Accept!",
                        text: msg,
                        icon: "warning",
                        buttons: true,
                        dangerMode: false,
                    })
                    .then((result) => {
                        if (result) {
                            $('.submitbtn').prop('disabled', true);
                            $.ajax({
                                type: "POST",
                                url: "{{ URL::to('nurse/invitation-status-change/'.$key)}}",
                                data: {

                                    'accept': accept,
                                    "_token": "{{ csrf_token() }}"
                                },
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);

                                    if (response.success == 1) {

                                        swal(response.message, {
                                            icon: "success",
                                            button: "OK",
                                        }).then((result) => {

                                            window.location.href = response.redirect;

                                        });
                                    } else {

                                        swal(response.message, {
                                            icon: "error",
                                            button: "OK",
                                        }).then((result) => {

                                            window.location.href = response.redirect;

                                        });

                                    }
                                },
                                error: function(xhr) {
                                    
                                    handleError(xhr);
                            });
                        }

                    });
            } else {
                swal({
                        title: "Decline!",
                        text: "Are you sure you want to decline the invitation ? ",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((result) => {
                        if (result) {

                            $('.submitbtn').prop('disabled', true);

                            $.ajax({
                                type: "POST",
                                url: "{{ URL::to('nurse/invitation-status-change/'.$key)}}",
                                data: {

                                    'accept': accept,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success == 1) {
                                        swal(response.message, {
                                            icon: "success",
                                            button: "OK",
                                        }).then((result) => {

                                            window.location.href = response.redirect;

                                        });


                                    } else {

                                        swal(response.message, {
                                            icon: "error",
                                            button: "OK",
                                        }).then((result) => {

                                            window.location.href = response.redirect;

                                        });

                                    }
                                },
                                error: function(xhr) {
                                    
                                    handleError(xhr);
                                }
                            });

                        }
                    });

            }

        }
    </script>