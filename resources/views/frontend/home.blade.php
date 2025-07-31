@extends('frontend.master_website')
@section('title', 'Home')
@section('content')

<section class="banner-container vedio-banner m-0 pt-0">
    <video autoplay muted loop playsinline class="" oncontextmenu="return false">
        <source src="{{ asset('frontend/images/banner-bg.mp4')}}" type="video/mp4">
    </video>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-10 col-xxl-9 mx-auto">
                <div class="content_box text-center mt-lg-0 mt-5">
                    <p class="mb-0 white banner-tag fw-middle mb-3">Reconnect with Your Patients. Let AI Do the Rest.</p>
                    <h1 class="white mb-0">Elegant Concierge Practice Management</h1>
                    <p class="white sub-text lg-font my-3">The first AI-powered system built from the ground up for direct primary care (DPC) and the concierge practitioner.</p>
                    <a class="btn btn-outline-primary" href="{{url('getstarted')}}">Try BlackBag Today !</a>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="even-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12 order-1 order-lg-0">
                <div class="content_box">
                    <p class="primary mb-0 mt-lg-0 mt-3">Simplify Your Practice</p>
                    <h3 class="pe-3 my-3">Your Search is Over</h3>
                    <p class="mb-3 primary">If you have considered a concierge practice, let BlackBag help you rediscover why you got into medicine. A turnkey system that allows you to focus on what matters most – exceptional patient care.</p>
                    <a class="btn btn-outline-primary blue-shadow" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/simplify.webp')}}" class="img-fluid" alt="Top Specialists">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="odd-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/automate.webp')}}" class="img-fluid" alt="Schedule Appointments">
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="content_box ps-lg-5">
                    <p class="white mt-lg-0 mt-3">Why BlackBag?</p>
                    <h3 class="pe-3 white">Automate Routine Tasks </h3>
                    <p class="my-3 white">BlackBag automates note taking, appointments scheduling, reminders and billing - freeing up your time for patient care.</p>
                    <a class="btn btn-outline-primary" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="even-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12 order-1 order-lg-0">
                <div class="content_box">
                    <p class="primary mt-lg-0 mt-3">Tailored care </p>
                    <h3 class="pe-3 primary">Personalized Patient Experience </h3>
                    <p class="my-3 primary">A first class experience with seamless communication, virtual consultations and secure access to their data. The BlackBag experience supports the patient health journey by providing an individualized touch that promotes sustained satisfaction and a lasting connection.</p>
                    <a class="btn btn-outline-primary blue-shadow" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/tailored_care.webp')}}" class="img-fluid" alt="Highly Qualified Doctors">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ai-bg-img odd-section pb-0">
    <div class="container">
        <div class="contact ai">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h6>Features That Set Us Apart</h6>
                        <h3 class="fw-bold mb-4 mt-3">Time saving AI-enabled features throughout the platform</h3>
                        <div class="row align-items-center mb-5 ai-data mt-lg-5 mt-1 pt-3">
                            <div class="col-lg-7 col-md-12">
                                <div class="text-lg-start text-center">
                                    <img src="{{ asset('frontend/images/blackbag_scribe.png')}}" class="img-fluid " alt="">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12 text-lg-start text-center">
                                <div class="">
                                    <h6 class="">Revolutionize Note-Taking with AI</h6>
                                    <h4 class="mb-4">Effortless Videocall<br> Transcriptions & Summaries</h4>
                                    <p class="mb-3">Our advanced AI technology takes the hassle out of note-taking during calls. It transcribes conversations in real-time, summarizes critical points for doctors, ensuring every detail is captured and organized seamlessly.</p>
                                    <div class="notes">
                                        <div><p><span class="material-symbols-outlined">record_voice_over</span>Real-Time Transcription</p></div>
                                        <div><p><span class="material-symbols-outlined">summarize</span>Smart Summaries</p></div>
                                        <div><p><span class="material-symbols-outlined">sticky_note_2</span>SOAP Notes Creation</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-a.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5 class="mb-3">Automated Billing & Payment Processing</h5>
                                    <p>Simplify financial workflows and enhance revenue tracking.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-b.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5 class="mb-3">Patient Engagement Tools</h5>
                                    <p>Keep your patients informed with home health devices, reminders, secure messaging, and wellness tracking.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-c.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5 class="mb-3">24/7 Appointment Scheduling</h5>
                                    <p>Reduce wait times and manage patient visits efficiently.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-d.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5 class="mb-3">Telehealth Integration</h5>
                                    <p>Provide virtual consultations with secure video conferencing.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-e.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5 class="mb-3">Membership & Subscription Management</h5>
                                    <p>Easily track and manage patient memberships.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="ai-card-sub ai-card-left position-relative">
                                    <div class="inner-aicard">
                                        <img src="{{ asset('frontend/images/ai-img-f.png')}}" class="img-fluid " alt="Blackbag">
                                        <p>Built on Trust & Privacy</p>
                                        <h5 class="mb-3">Secure & Compliant</h5>
                                        <p>With robust security measures and HIPAA-compliant features, we ensure your data is protected and your practice meets all regulatory standards.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="ai-card-sub ai-card-right position-relative">
                                    <div class="inner-aicard">
                                        <img src="{{ asset('frontend/images/ai-img-g.png')}}" class="img-fluid " alt="Blackbag">
                                        <p>Adaptable for Any Size</p>
                                        <h5 class="mb-3">Scalable & Customizable</h5>
                                        <p>Whether you're an independent clinician or a multi-practitioner practice, our platform is designed to scale with your needs.</p>
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


<section class="get_started odd-section pb-0">
    <div class="container">
        <div class="info_wrapper blue_box text-center">
            <div class="content_box">
                <p class="primary mb-0">Modern tools for premium care</p>
                <h3 class="my-3">Transform Your Direct Primary Care<br> and Concierge Medical Practice Today</h3>
                <p class="primary mb-3">Experience the future of direct primary care and concierge medicine with BlackBag. Let us handle the complexities of practice management while you deliver top-tier healthcare.</p>
                <a class="btn btn-outline-primary blue-shadow" href="{{url('getstarted')}}">Get Started</a>
            </div>
        </div>
    </div>
</section>



@stop