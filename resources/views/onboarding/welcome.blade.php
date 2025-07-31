@extends('onboarding.onboarding')
@section('title', 'Business Details')
@section('content') 
<section>
    <div class="container-fluid p-0">
        <div class="wrapper res-wrapper onboard-wrapper">
            <video autoplay muted loop class="video-bg">
                <source src="{{ asset('images/welcome-onboard.mp4')}}" type="video/mp4">
            </video>
            <div class="wl-content mt-4">
                <div class="text-center"> 
                    <!-- <img src="{{ asset('images/welcome-img.png') }}" class="welcme-img" alt="welcome"> -->
                    <div class="inner-onboard "> 
                        @if(Session::has('user') && ((session()->get('user.userType') == 'clinics' && $clinicDetails['onboarding_complete'] == '1') || session()->get('user.userType') == 'doctor' || (isset($isOnbrdType))) )
                            @php
                                $corefunctions = new \App\customclasses\Corefunctions;
                                $clinicLogo = $corefunctions->getClinicLogo();
                            @endphp
                            <h1 class="gray fw-medium mb-3">Welcome to</h1>
                            <div class="">
                                <div class="d-flex flex-xl-row flex-column justify-content-center align-items-center my-3 mt-5 gap-2">
                                    <div class="user_inner">
                                    <img src="{{$clinicLogo}}"  alt="user">                                                                                 
                                        <h5 class="primary fw-bold mb-0">{{Session::get('user.clinicName')}}</h5>
                                    </div>
                                </div>
                                <p class="gray mb-4">To begin scheduling appointments, please complete your onboarding. This includes setting up your clinic details and configure working hours. Once these steps are complete, you'll be ready to manage appointments with ease.</p>
                                <a  href="{{url('doctor/onboarding/contact-details')}}" class="btn btn-primary">Start Onboarding</a>
                            </div>
                           
                        @else
                            <h1 class="mb-3">Welcome to BlackBag!</h1>
                            <p class="gray mb-4">To begin scheduling appointments, please complete your onboarding. This includes setting up your clinic details, configuring patient subscription plans, and enabling any required add-ons. Once these steps are complete, you'll be ready to manage appointments with ease.</p>
                            <a   @if(Session::has('user') && ((session()->get('user.userType') == 'clinics' && $clinicDetails['onboarding_complete'] == '1') || session()->get('user.userType') == 'doctor')) href="{{url('doctor/onboarding/contact-details')}}" @else href="{{url('onboarding/business-details')}}" @endif class="btn btn-primary">Start Onboarding</a>
                        
                        @endif  
                    </div>
                </div>
            </div>
        </div>
      
    </div>
</section>
  

@stop