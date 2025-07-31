@extends('frontend.master')
@section('title', 'Home')
@section('content')

<section class="banner-container home-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="content_box">
                    <p class="mb-0">Welcome to Your Health Connection</p>
                    <h1>Virtual Care at Your Fingertips</h1>
                    <p class="pe-lg-5">Providing you with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice</p>
                    <!-- <a class="btn btn-primary" href="#">Book an Appointment</a> -->
                </div>
            </div>
            <div class="col-lg-6 p-0">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/banner-right.webp')}}" class="img-fluid" alt="Banner Doctor">
                </div>
            </div>
        </div>
    </div>

</section>

<!-- <section class="slider_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center justify-content-lg-start flex-sm-row flex-column align-items-center">
                    <div class="content_box">
                        <h3>Our Specialities</h3>
                        <p class="mb-0">Comprehensive Care Across a Wide Range of Medical Fields</p>
                    </div>
                    <div class="mt-sm-0 mt-3">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="doctor-slider" class="owl-carousel">
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="{{ asset('frontend/images/slide1.png')}}" alt="General Physician">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>General Physician</h4>
                           
                        </div>
                    </div>
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="{{ asset('frontend/images/slide2.png')}}" alt="Dermatology">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>Dermatology</h4>
                           
                        </div>
                    </div>
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="{{ asset('frontend/images/slide3.png')}}" alt="Pediatrics">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>Pediatrics</h4>
                           
                        </div>
                    </div>
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="{{ asset('frontend/images/slide4.png')}}" alt="Urology">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>Urology</h4>
                          
                        </div>
                    </div>
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="{{ asset('frontend/images/slide5.png')}}" alt="Gynecology">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>Gynecology</h4>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section>
    <div class="container">
        <div class="row align-items-center mb-4 parallax-scroll">
            <div class="col-lg-6 col-12 order-1 order-lg-0">
                <div class="content_box">
                    <p>Expert Insights for Your Peace of Mind</p>
                    <h3 class="pe-3">Get Trusted Second Opinion from Top Specialists</h3>
                    <p class="my-3">When facing critical health decisions, obtaining a second opinion can provide valuable reassurance and clarity. Seeking a second opinion can help you make informed and confident decisions about your health.</p>
                    <ul class="text-center text-lg-start align-items-center align-items-lg-start">
                        <li><span class="material-symbols-outlined primary">check</span>Access to Leading Experts</li>
                        <li><span class="material-symbols-outlined primary">check</span>Comprehensive and Impartial Review</li>
                        <li><span class="material-symbols-outlined primary">check</span>Confidence in Your Healthcare Choices</li>
                    </ul>
                    <!-- <a class="btn btn-primary">Get Expert Advice</a> -->
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/img1.webp')}}" class="img-fluid" alt="Top Specialists">
                </div>
            </div>
        </div>
        <div class="row align-items-center mb-4 parallax-scroll">
            <div class="col-lg-6 col-12">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/img2.png')}}" class="img-fluid" alt="Schedule Appointments">
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="content_box ps-lg-5">
                    <p>Effortless Appointment Scheduling</p>
                    <h3 class="pe-3">Book Your Medical Appointments in Seconds</h3>
                    <p class="my-3">With just a few clicks, you can find and book an appointment with a trusted healthcare professional at a time that suits you. Our user-friendly interface ensures a smooth and stress-free booking experience.</p>
                    <ul class="text-center text-lg-start align-items-center align-items-lg-start">
                        <li><span class="material-symbols-outlined primary">check</span>Quick and Simple Process</li>
                        <li><span class="material-symbols-outlined primary">check</span>Real-Time Availability</li>
                        <li><span class="material-symbols-outlined primary">check</span>Reminders and Notifications</li>
                    </ul>
                    <!-- <a class="btn btn-primary">Book an Appointment</a> -->
                </div>
            </div>
        </div>
        <div class="row align-items-center mb-4 parallax-scroll">
            <div class="col-lg-6 col-12 order-1 order-lg-0">
                <div class="content_box">
                    <p>Trusted Healthcare Professionals</p>
                    <h3 class="pe-3">Experienced and Efficient Doctors at Your Service</h3>
                    <p class="my-3">Each doctor is carefully vetted to ensure they meet our high standards of professionalism and expertise. With us, you can be confident that you're receiving top-quality medical attention.</p>
                    <ul class="text-center text-lg-start align-items-center align-items-lg-start">
                        <li><span class="material-symbols-outlined primary">check</span>Highly Qualified Doctors</li>
                        <li><span class="material-symbols-outlined primary">check</span>Patient-Centered Care</li>
                        <li><span class="material-symbols-outlined primary">check</span>Efficient Consultations</li>
                    </ul>
                    <!-- <a class="btn btn-primary">Find Doctors Near You</a> -->
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/img3.png')}}" class="img-fluid" alt="Highly Qualified Doctors">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="get_started bg-white">
    <div class="container">
        <div class="info_wrapper text-center">
            <div class="content_box">
                <p>Secure Health Data</p>
                <h3>Your Information, Safeguarded with Advanced Security</h3>
                <p class="my-3">BlackBlag uses advanced encryption technologies and stringent security protocols to keep your personal and medical information safe from unauthorized access. Trust us to handle your data with the utmost care and security.</p>
                <!-- <a class="btn btn-primary">Get Started</a> -->
            </div>
        </div>
    </div>
</section>



@stop