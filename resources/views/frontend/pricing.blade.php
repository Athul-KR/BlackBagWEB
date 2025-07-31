@extends('frontend.master_website')
@section('title', 'Pricing')
@section('content')


<section class="banner-container banner-pricing">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="content_box text-center">
                    <p class="mb-0">Simple, Transparent Pricing</p>
                    <h1 class="mb-3  mt-2">No monthly subscriptions, No hidden fees.</h1>
                    <p>Just pay as you go, with everything you need to run a modern in-person or virtual clinic.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card price-card">
                    <div class="row">
                        <div class="col-lg-9 col-md-12">
                            <div class="card-content">
                            <h2 class="m-0">Start Your Free <span>“Pay As You Go”</span> Plan Right Now</h2>
                            <strong >$0.00 Per Month</strong><br class="mb-4">
                            <small >No Monthly Fees</small>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 align-items-center d-flex justify-content-lg-end  justify-content-start mt-lg-0 mt-4">
                        <a href="{{url('getstarted')}}" class=" btn btn-primary" >Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
            <h3 class="pe-3">What’s Included</h3>
            <p class="my-3">You get <strong>unlimited</strong> access to core features- no limits on users, patients, or consultations.</p>
            </div>
        </div>
    </div>
</section>

<section class="mb-5">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="feature-card">
        <div class="d-flex align-items-center mb-3">
            <img src="{{asset('frontend/images/core.png')}}" class="img-fluid" alt="Blackbag">
          <div>
            <div class="feature-title">Core Features</div>
            <div class="feature-subtitle">Everything You Need, Right Out of the Box</div>
          </div>
        </div>
        <div class="g-gra-border"></div>
        <div class="row mt-4">
          <div class="col-12  col-lg-6 col-md-12">
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Integrated Telemedicine (Video & Chat)</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Patient Registration & Management</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Appointment Scheduling & Calendar Sync</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Appointment Billing & Invoicing</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Medical History & SOAP Notes</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Patient Portal</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span><span class="highlight">Unlimited Clinician Accounts</span></p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span><span class="highlight">Unlimited Patients</span></p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Print Labs & Imaging orders</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Remote Patient Monitoring Device Support</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>AI Transcription</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>AI Summarization with SOAP Notes</p>
          </div>
          <div class="col-12 col-lg-6 col-md-12">
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Personalized Clinic Branding</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Detailed Billing Reports</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Email & SMS Appointment Reminders</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>24/7 Live Chat & Ticket Support</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Onboarding & Migration Assistance</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Secure Data Storage & HIPAA/Compliance-Ready</p>
            <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Competitive Card Processing Fees</p>
                <div class="price-box">
                <div class="d-flex align-items-center mb-2">
                    <img src="{{asset('frontend/images/deliver.png')}}" class="img-fluid" alt="Blackbag">
                    <div>
                    <h5 class="fw-bold">You Only Pay When You Deliver Care</h5>
                    <span class="small">No ongoing subscription.</span>
                    </div>
                </div>
                <div class="w-gra-border"></div>
                <h5 class="price">$5 <span class="fs-6 fw-normal">Per patient consultations</span></h5>
                </div>
          </div>
        </div>

        <!-- Pricing box -->

      </div>
    </div>
  </div>
</div>
</section>

<section class="mb-3 add-on">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="justify-content-between d-flex align-items-center">
                    <div class="">
                        <div class="d-flex align-items-center gap-3">
                                <img src="{{asset('frontend/images/add-on.png')}}" class="img-fluid escribe-img" alt="escribe">
                            <div class="">
                                <p class="m-0">Optional Add-On</p>
                                <h2>ePrescribe</h2>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <h2 class="m-0">$79.00</h2>
                        <p class="m-0">Per month</p>
                    </div>
                </div>
                <div class="g-gra-border mt-4 mb-4"></div>
                <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>One-time Setup: $250</p>
                <p class="align-items-center d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>12-month minimum commitment required</p>
            </div>
        </div>
    </div>
</section>
<section class="mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="m-0 " style="font-size: 15px !important;font-style: italic;">*Prescriber has choice of medication, and the patient has choice of pharmacy.</p>
            </div>
        </div>
    </div>
</section>










<section>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 text-center">
                <h3 class="">Why Practitioners Choose BlackBag
                </h3>
            </div>
        </div>
        <div class="row g-4 mt-lg-2 mt-md-2  mt-3">
            <div class="col-12 col-md-6 col-lg-3">
            <div class="choose-box">
                <img src="{{asset('frontend/images/choose_a.webp')}}" alt="Blackbag">
                <p>No upfront investment or subscription lock-ins<sup>*</sup></p>
            </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
            <div class="choose-box">
            <img src="{{asset('frontend/images/choose_b.webp')}}" alt="Blackbag">
                <p>Scalable for solo practices to large virtual care networks</p>
            </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
            <div class="choose-box">
            <img src="{{asset('frontend/images/choose_c.webp')}}" alt="Blackbag">
                <p>AI-powered productivity with built-in transcription & SOAP note generation</p>
            </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
            <div class="choose-box">
            <img src="{{asset('frontend/images/choose_d.webp')}}" alt="Blackbag">
                <p>Streamlined billing, patient experience, and compliance.</p>
            </div>
            </div>
        </div>
        <div class="text-start mt-2 ms-1 feature-note">
            *except for ePrescribe add-on
        </div>
    </div>
</section>



<section class="faq">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-4">Frequently Asked Questions</h3>
            </div>
            <div class="col-12">
                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-1" aria-expanded="true" aria-controls="accordion-1">
                                1. What is BlackBag?
                            </button>
                        </h4>
                        <div id="accordion-1" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>BlackBag is a cloud-based, AI-powered platform built for concierge medical practices. It helps automate daily operations like documentation, appointment tracking, and team collaboration—so your practice can run more efficiently.</p>
                        </div>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button  class="accordion-button collapsed"  type="button" data-bs-toggle="collapse" data-bs-target="#accordion-2" aria-expanded="false" aria-controls="accordion-2">
                               2. Who is BlackBag designed for?
                            </button>
                        </h4>
                        <div id="accordion-2" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>BlackBag is ideal for concierge care providers, direct primary care (DPC) physicians, and private medical clinics seeking a smarter, streamlined way to manage their day-to-day tasks.</p>
                        </div>
                        </div>
                    </div>
                     <hr>
                    
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-3" aria-expanded="false" aria-controls="accordion-3">
                              3. What features does BlackBag offer?
                            </button>
                        </h4>
                        <div id="accordion-3" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>BlackBag includes:</p>
                            <ul>
                                <li>AI-generated SOAP notes</li>
                                <li>Appointment and follow-up tracking</li>
                                <li>Role-based staff assignments and collaboration tools</li>
                                <li>Automated status updates and internal commenting</li>
                                <li>Notifications via email, SMS, or voice call</li>
                            </ul>
                        </div>
                        </div>
                    </div>
                     <hr>
                                        
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-4" aria-expanded="false" aria-controls="accordion-4">
                               4. Can I tailor BlackBag to my clinic’s workflow?
                            </button>
                        </h4>
                        <div id="accordion-4" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Yes. You can manage your patients’ appointment schedules, set time availability, and maintain fee details to suit your practice’s operations.</p>
                        </div>
                        </div>
                    </div>
                     <hr>
                                                            
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-5" aria-expanded="false" aria-controls="accordion-5">
                               5. How does the AI summarization feature work?
                            </button>
                        </h4>
                        <div id="accordion-5" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>BlackBag’s AI engine processes your clinical content (e.g., consultation notes or transcripts) and generates structured SOAP notes. You can review and edit them before saving.</p>
                        </div>
                        </div>
                    </div>
                     <hr>
                                                                                
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-6" aria-expanded="false" aria-controls="accordion-6">
                               6. Do I need to install any software?
                            </button>
                        </h4>
                        <div id="accordion-6" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>No. BlackBag is entirely web-based. You can access it from any modern browser—no installation required.</p>
                        </div>
                        </div>
                    </div>
                     <hr>
                                                                                                    
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-7" aria-expanded="false" aria-controls="accordion-7">
                               7. What kind of support do you offer?
                            </button>
                        </h4>
                        <div id="accordion-7" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>We provide:</p>
                            <ul>
                                <li>Email support for all users</li>
                                <li>Guided onboarding to help you get started</li>
                                <li>Access to help documentation</li>
                            </ul>
                        </div>
                        </div>
                    </div>
                    <hr>
                                                                                                                        
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-8" aria-expanded="false" aria-controls="accordion-8">
                               8. How is my data protected?
                            </button>
                        </h4>
                        <div id="accordion-8" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>Your data is hosted on secure cloud infrastructure with encryption, user-level access control, and audit tracking for transparency and protection.</p>
                        </div>
                        </div>
                    </div>
                     <hr>
                                                                                                                                            
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-9" aria-expanded="false" aria-controls="accordion-9">
                              9. How is BlackBag priced?
                            </button>
                        </h4>
                        <div id="accordion-9" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>BlackBag operates on a pay-as-you-grow model with no monthly subscriptions or hidden fees. You only pay when you deliver care.</p>
                            <strong >Usage-Based Cost:</strong>
                            <ul class="pt-2">
                                <li>$5 per patient consultation</li>
                            </ul>
                             <strong >Optional Add-On:</strong>
                            <ul class="pt-2">
                                <li>ePrescribe: $79 per month with a one-time setup fee of $250 and a 12-month minimum commitment</li>
                            </ul>
                            <p>This flexible pricing allows your practice to scale without upfront investments or subscription lock-ins, except for the ePrescribe add-on.</p>
                        </div>
                        </div>
                    </div>
                     <hr>

                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-10" aria-expanded="false" aria-controls="accordion-10">
                               10. Can I cancel or change my subscription?
                            </button>
                        </h4>
                        <div id="accordion-10" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>There are no subscription plans for BlackBag’s core features - you pay only for patient consultations. The only subscription-based service is the optional ePrescribe add-on, which requires a monthly commitment and can be canceled or changed according to its terms.
</p>
                        </div>
                        </div>
                    </div>
                     <hr>

                </div>
            </div>
        </div>
    </div>
</section>















<section class="get_started bg-white price-ft">
    <div class="container">
        <div class="info_wrapper text-center">
            <div class="content_box">
                <p class="mb-3">Ready to Get Started?</p>
                <h3 class="mb-4">Deliver Smarter, More Affordable Care.<br> Only Pay When You Deliver Care.</h3>
                
                <a href="{{url('getstarted')}}" class=" btn btn-primary" >Get Started</a>
            </div>
        </div>
    </div>
</section>









<!-- Clinic Sign  Up Modal -->

<div class="modal login-modal fade" id="registerUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a onclick="$('#registerPatient').hide()" data-bs-dismiss="modal" aria-label="Close"><span
                        class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center" id="registerClinicForm">



            </div>
        </div>
    </div>
</div>





@endsection