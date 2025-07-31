@extends('frontend.master')
@section('title', 'Get Started')
@section('content')
<style>
     .wc-onboard {place-content: center;}
 .wc-onboard .inner-onboard h6{
  font-size: 46px !important;
    color: #000 !important;
    font-weight: 300 !important;
}
.wc-onboard .inner-onboard p{
  font-weight: 400 !important;
    font-size: 19px !important;
}
</style>
    <section class="details_wrapper min-h-auto patient-onboard-wrapper">
        <div class="container">
            <div class="web-card wc-onboard"> 
                <div class="row">
                    <div class="col-12 col-lg-8 col-xl-6 col-xxl-5 mx-auto"> 
                        <div class="text-center"> 
                            <!-- <img src="{{ asset("images/patient-onboard.png") }}" class="welcme-img" alt="welcome"> -->
                            <div class="inner-onboard"> 
                                <h6 class="gray fw-bold mt-3">Welcome to</h6>
                                <div class="d-flex flex-xl-row flex-column justify-content-center align-items-center my-3 mt-5 gap-2"> 
                                    <div class="text-lg-start text-center image-body-xl">
                                        <img src="{{$clinic['clinic_logo']}}" class="user-img" alt="">
                                    </div>
                                    <div class="user_details text-xl-start text-center pe-xl-4">
                                        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                            <h5 class="fw-bold primary text-wrap mb-0">{{$clinic['name']}}</h5>
                                        </div>
                                    </div>
                                </div>
                                @if($patientDetails['user']['is_taken_intakeform'] == '0')
                                    <p class="gray mb-4">To personalize your care experience, we’ll start with a few quick health questions.</p>
                                    <a href="{{url('/intakeform')}}" class="btn btn-primary">Get Started</a>
                                @else
                                    <p class="gray mb-4">We are committed to providing you with attentive, personalized care and ensuring your comfort throughout every visit. Our team is here to support you and handle all your healthcare needs with professionalism and compassion. Your health journey is important to us — together, we’ll make it smooth, comfortable, and empowering.</p>
                                    <a href="{{url('/patient/dashboard')}}" class="btn btn-primary">Get Started</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  
@endsection()