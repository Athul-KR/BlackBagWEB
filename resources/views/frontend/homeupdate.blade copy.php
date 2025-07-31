@extends('frontend.master_website')
@section('title', 'Home')
@section('content')

<section class="banner-container home-bg mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="content_box">
                    <p class="mb-0">Welcome to BlackBag - Powering the Renaissance of Medicine</p>
                    <h1>Elegant Concierge Practice Management</h1>
                    <p class="pe-lg-5">The first AI-powered system built from the ground up for the concierge practitioner.</p>
                    <a class="btn btn-primary" href="{{url('getstarted')}}">Get Started</a>
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



<section>
    <div class="container">
        <div class="row align-items-center mb-4 ">
            <div class="col-lg-6 col-12 order-1 order-lg-0 mt-3">
                <div class="content_box">
                    <p>Simplify Your Practice</p>
                    <h3 class="pe-3">Your Search is Over</h3>
                    <p class="my-3">If you have considered a concierge practice, let BlackBag help you rediscover why you got into medicine. A turnkey system that allows you to focus on what matters most – exceptional patient care.</p>
                    <a class="btn btn-primary" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/img_1.webp')}}" class="img-fluid" alt="Top Specialists">
                </div>
            </div>
        </div>
        <div class="row align-items-center mb-4 ">
            <div class="col-lg-6 col-12">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/img_2.png')}}" class="img-fluid" alt="Schedule Appointments">
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="content_box ps-lg-5">
                    <p>Why BlackBag?</p>
                    <h3 class="pe-3">Automate Routine Tasks </h3>
                    <p class="my-3">BlackBag automates note taking, appointments scheduling, reminders and billing - freeing up your time for patient care.</p>
                    <a class="btn btn-primary" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
        </div>
        <div class="row align-items-center mb-4 ">
            <div class="col-lg-6 col-12 order-1 order-lg-0">
                <div class="content_box">
                    <p>Tailored care </p>
                    <h3 class="pe-3">Personalized Patient Experience </h3>
                    <p class="my-3">A first class experience with seamless communication, virtual consultations and secure access to their data. The BlackBag experience supports the patient health journey by providing an individualized touch that promotes sustained satisfaction and a lasting connection.</p>
                   
                    <a class="btn btn-primary" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/img_3.png')}}" class="img-fluid" alt="Highly Qualified Doctors">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ai-bg-img">
    <div class="contact ai">
        <div class="row">
            <div class="col-12">
                <div class=" py-5 text-center">
                    <h6>Features That Set Us Apart</h6>
                    <h3 class="fw-bold mb-4 mt-3">Time saving AI-enabled features<br> throughout the platform</h3>
                        <div class="row align-items-center mb-5 ai-data mt-lg-5 mt-1 pt-3">
                            <div class="col-lg-7 col-md-12">
                                <img src="{{ asset('frontend/images/blackbag_scribe.png')}}" class="img-fluid " alt="">
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
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-a.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5>Automated Billing & Payment Processing</h5>
                                    <p>Simplify financial workflows and enhance revenue tracking.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-b.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5>Patient Engagement Tools</h5>
                                    <p>Keep your patients informed with home health devices, reminders, secure messaging, and wellness tracking.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-c.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5>24/7 Appointment Scheduling</h5>
                                    <p>Reduce wait times and manage patient visits efficiently.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-d.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5>Telehealth Integration</h5>
                                    <p>Provide virtual consultations with secure video conferencing.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="ai-card">
                                    <img src="{{ asset('frontend/images/ai-img-e.png')}}" class="img-fluid " alt="Blackbag">
                                    <h5>Membership & Subscription Management</h5>
                                    <p>Easily track and manage patient memberships.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="ai-card-sub">
                                    <img src="{{ asset('frontend/images/ai-img-f.png')}}" class="img-fluid " alt="Blackbag">
                                    <h6>Built on Trust & Privacy</h6>
                                    <h5 class="mb-3">Secure & Compliant</h5>
                                    <p>With robust security measures and HIPAA-compliant features, we ensure your data is protected and your practice meets all regulatory standards.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="ai-card-sub">
                                    <img src="{{ asset('frontend/images/ai-img-g.png')}}" class="img-fluid " alt="Blackbag">
                                    <h6>Adaptable for Any Size</h6>
                                    <h5 class="mb-3">Scalable & Customizable</h5>
                                    <p>Whether you're an independent clinician or a multi-practitioner practice, our platform is designed to scale with your needs.</p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="get_started bg-white">
    <div class="container">
        <div class="info_wrapper text-center">
            <div class="content_box">
                <p>Modern tools for premium care</p>
                <h3>Transform Your Concierge Medical Practice Today</h3>
                <p class="my-3">Experience the future of concierge medicine with BlackBag. Let us handle the complexities of practice management while you deliver top-tier healthcare.</p>
                <a class="btn btn-primary" href="{{url('getstarted')}}">Get Started</a>
            </div>
        </div>
    </div>
</section>



@stop