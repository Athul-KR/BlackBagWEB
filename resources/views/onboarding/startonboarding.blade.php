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
                                            <li class="px-3">
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

<section>
    <div class="container-fluid">
        <div class="wrapper res-wrapper onboard-wrapper">
            <div class="web-card"> 
                <div class="text-center"> 
                    <img src="{{ asset("images/welcome-img.png") }}" class="welcme-img" alt="welcome">
                    <div class="inner-onboard"> 
                        <h3 class="fw-bold mt-3">Welcome to BlackBag!</h3>
                        <h5 class="gray fw-middle mb-4">To begin scheduling appointments, please complete your onboarding.This includes setting up your clinic details, configuring patient subscription plans, and enabling any required add-ons. Once these steps are complete, you'll be ready to manage appointments with ease.</h5>
                        <a href="" class="btn btn-primary">Start Onboarding</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>