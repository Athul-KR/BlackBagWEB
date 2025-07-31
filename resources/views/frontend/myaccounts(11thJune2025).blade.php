@extends('frontend.master')
@section('title', 'My Receipts')
@section('content')

<section class="details_wrapper">
    <div class="container">
        <div class="row g-4">
            <div class="col-12"> 
                <div class="web-card h-100">
                    <div class="tabs-container">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="pill"  onclick="changeTab('myprofile')">My Profile</a>
                            </li>
                            <li class="nav-item position-relative">
                                <a class="nav-link" data-bs-toggle="pill" onclick="changeTab('devices')" >Devices <span class="badge bg-dark ms-1 rounded-circle">1</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill"  onclick="changeTab('subscriptions')">Subscriptions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" onclick="changeTab('receipts')" >Receipts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill"  onclick="changeTab('cards-billing')">Cards & Billing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" onclick="changeTab('myclinics')">My Clinics</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-4">
                            <div class="tab-pane fade show active tabschange" id="myprofile">
                               
                            </div>
                            <div class="tab-pane fade tabschange" id="devices">
                                <div class="tab-box-inner">
                                    <ul class="nav nav-pills mb-4 border-0" id="devicesTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active align_middle" id="current-tab" data-bs-toggle="pill" data-bs-target="#current" type="button" role="tab"><span class="material-symbols-outlined">browse_activity</span>Current Devices</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link align_middle" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button" role="tab"><span class="material-symbols-outlined">hourglass_bottom</span>Pending Orders</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link align_middle" id="rejected-tab" data-bs-toggle="pill" data-bs-target="#rejected" type="button" role="tab"><span class="material-symbols-outlined">block</span>Rejected</button>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Tab Content -->
                                <div class="tab-content" id="devicesTabContent">
                                    <div class="tab-pane fade show active" id="current" role="tabpanel">
                                        <div class="border rounded rounded-3 p-3 mb-3">
                                            <div class="row align-items-center">

                                                <div class="col-12">
                                                    <div class="row g-3 align-items-center"> 
                                                        <div class="col-lg-5"> 
                                                            <div class="user_inner tools_inner">
                                                                <img src="{{asset('frontend/images/tool2.png')}}">
                                                                <div class="user_info">
                                                                    <a href="">
                                                                        <h6 class="primary fw-bold m-0">iBlood pressure Classic</h6>
                                                                        <p class="m-0">Blood Pressure Monitor</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4"> 
                                                            <label class="sm-label">Ordered By:</label>
                                                            <div class="user_inner mt-1">
                                                                <img src="{{asset('frontend/images/search1.png')}}">
                                                                <div class="user_info">
                                                                    <a href="">
                                                                        <h6 class="primary fw-bold m-0">John</h6>
                                                                        <p class="m-0">Clinic Center </p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3"> 
                                                            <div class="row"> 
                                                                <div class="col-6"> 
                                                                    <label class="sm-label">Ordered By:</label>
                                                                    <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                                </div>
                                                                <div class="col-6"> 
                                                                    <label class="sm-label">Ordered By:</label>
                                                                    <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                 {{-- <div class="col-1"> 

                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pending Orders -->
                                    <div class="tab-pane fade" id="pending" role="tabpanel">
                                        <div class="border rounded rounded-3 p-3 mb-3">
                                            <div class="row g-3 align-items-center">

                                                <div class="col-12 col-lg-8">
                                                    <div class="row align-items-center"> 
                                                        <div class="col-lg-5"> 
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="border rounded rounded-3-2 p-2"> 
                                                                    <img src="{{asset('frontend/images/tool3.png')}}" class="tool-img">
                                                                </div>
                                                                <div class="border rounded rounded-3-2 p-2"> 
                                                                    <img src="{{asset('frontend/images/tool3.png')}}" class="tool-img">
                                                                </div>
                                                                <div class="border rounded rounded-3-2 p-2"> 
                                                                    <img src="{{asset('frontend/images/tool3.png')}}" class="tool-img">
                                                                </div>
                                                                <div class="border rounded rounded-3-2 p-2"> 
                                                                    <img src="{{asset('frontend/images/tool3.png')}}" class="tool-img">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3"> 
                                                            <label class="sm-label">Ordered By:</label>
                                                            <div class="user_inner mt-1">
                                                                <img src="{{asset('frontend/images/search1.png')}}">
                                                                <div class="user_info">
                                                                    <a href="">
                                                                        <h6 class="primary fw-bold m-0">John</h6>
                                                                        <p class="m-0">Clinic Center </p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4"> 
                                                            <div class="row"> 
                                                                <div class="col-6"> 
                                                                    <label class="sm-label">Ordered By:</label>
                                                                    <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                                </div>
                                                                <div class="col-6"> 
                                                                    <label class="sm-label">Ordered By:</label>
                                                                    <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                 <div class="col-12 col-lg-4"> 
                                                    <div class="btn_alignbox justify-content-md-end"> 
                                                        <button class="btn btn-outline-primary">Reject </button>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#orderDetails">Accept</a>
                                                        <button class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="material-symbols-outlined">more_vert</span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a href="#" class="dropdown-item fw-medium align_middle gap-0" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="material-symbols-outlined me-2">block</i>Cancel Subscription</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Rejected -->
                                    <div class="tab-pane fade" id="rejected" role="tabpanel">
                                        <div class="border rounded rounded-3 p-3 mb-3">
                                            <div class="row align-items-center">

                                                <div class="col-8">
                                                    <div class="row align-items-center"> 
                                                        <div class="col-lg-5"> 
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="border rounded rounded-3-2 p-2"> 
                                                                    <img src="{{asset('frontend/images/tool3.png')}}" class="tool-img">
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3"> 
                                                            <label class="sm-label">Ordered By:</label>
                                                            <div class="user_inner mt-1">
                                                                <img src="{{asset('frontend/images/search1.png')}}">
                                                                <div class="user_info">
                                                                    <a href="">
                                                                        <h6 class="primary fw-bold m-0">John</h6>
                                                                        <p class="m-0">Clinic Center </p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4"> 
                                                            <div class="row"> 
                                                                <div class="col-6"> 
                                                                    <label class="sm-label">Ordered By:</label>
                                                                    <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                                </div>
                                                                <div class="col-6"> 
                                                                    <label class="sm-label">Ordered By:</label>
                                                                    <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                 <div class="col-4"> 
                                                    <div class="btn_alignbox justify-content-end"> 
                                                         <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="material-symbols-outlined">more_vert</span>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a href="#" class="dropdown-item fw-medium align_middle gap-0" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="material-symbols-outlined me-2">block</i>Cancel Subscription</a></li>
                                                        </ul>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade tabschange" id="subscriptions">
                                <div class="d-flex flex-column gap-3"> 
                                    <div class="border rounded rounded-3 p-3 w-100">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9">
                                                <div class="row align-items-center"> 
                                                    <div class="col-lg-6"> 
                                                        <div class="user_inner tools_inner">
                                                            <img src="{{asset('frontend/images/search4.png')}}">
                                                            <div class="user_info">
                                                                <a href="">
                                                                    <h6 class="primary fw-bold m-0">HealthCrest Clinic & Family Planning Center </h6>
                                                                    
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4"> 
                                                    
                                                        <div class="user_inner plan-img">
                                                            <img src="{{asset('frontend/images/diamond.png')}}">
                                                            <div class="user_info">
                                                                <div class="align_middle justify-content-start"><p class="m-0">Clinic Center</p><a a type="button" class="popup-info" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#currentPlan"><span class="material-symbols-outlined">info</span></a></div>
                                                                <h5 class="primary fw-bold m-0">Pay As You Go Plan</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2"> 
                                                        {{-- <div class="row"> 
                                                            <div class="col-6"> 
                                                                <label class="sm-label">Ordered By:</label>
                                                                <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                            </div>
                                                            <div class="col-6"> 
                                                                <label class="sm-label">Ordered By:</label>
                                                                <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3"> 
                                                {{-- <div class="btn_alignbox justify-content-end"> 
                                                    <a href="" class="btn btn-primary">Upgrade Plan</a>
                                                    <a class="btn opt-btn align_middle"><span class="material-symbols-outlined">more_vert</span>  </a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border rounded rounded-3 p-3 w-100">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9">
                                                <div class="row align-items-center"> 
                                                    <div class="col-lg-6"> 
                                                        <div class="user_inner tools_inner">
                                                            <img src="{{asset('frontend/images/search4.png')}}">
                                                            <div class="user_info">
                                                                <a href="">
                                                                    <h6 class="primary fw-bold m-0">Premier Membership</h6>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4"> 
                                                    
                                                        <div class="user_inner plan-img">
                                                            <img src="{{asset('frontend/images/gold.png')}}">
                                                            <div class="user_info">
                                                                <div class="align_middle justify-content-start"><p class="m-0">Clinic Center</p><a href="" class="popup-info"><span class="material-symbols-outlined">info</span></a></div>
                                                                <h5 class="primary premium fw-bold m-0">Premier Membership</h5>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2"> 
                                                        <div class="row"> 
                                                            <div class="col-6"> 
                                                                <label class="sm-label">Next Renewal</label>
                                                                <h6 class="fw-bold mb-0">01/01/2026</h6>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3"> 
                                                <div class="btn_alignbox justify-content-end"> 
                                                    <a href="" class="btn btn-primary">Upgrade Plan</a>
                                                    <a class="btn opt-btn align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editProfileInfo"><span class="material-symbols-outlined">more_vert</span>  </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border rounded rounded-3 p-3 w-100">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9">
                                                <div class="row align-items-center"> 
                                                    <div class="col-lg-6"> 
                                                        <div class="user_inner tools_inner">
                                                            <img src="{{asset('frontend/images/search4.png')}}">
                                                            <div class="user_info">
                                                                <a href="">
                                                                    <h6 class="primary fw-bold m-0">HealthCrest Clinic & Family Planning Center </h6>
                                                   
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4"> 
                                                    
                                                        <div class="user_inner plan-img">
                                                            <img src="{{asset('frontend/images/diamond.png')}}">
                                                            <div class="user_info">
                                                                <div class="align_middle justify-content-start"><p class="m-0">Clinic Center</p><a type="button" class="popup-info" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#currentPlan"><span class="material-symbols-outlined">info</span></a></div>
                                                                <h6 class="primary fw-bold m-0">Pay As You Go Plan</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2"> 
                                                        {{-- <div class="row"> 
                                                            <div class="col-6"> 
                                                                <label class="sm-label">Ordered By:</label>
                                                                <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                            </div>
                                                            <div class="col-6"> 
                                                                <label class="sm-label">Ordered By:</label>
                                                                <h6 class="fw-bold mb-0">Jan 29, 2025</h6>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3"> 
                                                <div class="btn_alignbox justify-content-end"> 
                                                    <a href="" class="btn btn-primary">Upgrade Plan</a>
                                                    <a class="btn opt-btn align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editProfileInfo"><span class="material-symbols-outlined">more_vert</span>  </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row align-items-center my-4">
                                    <div class="col-12 col-lg-8">
                                        <div class="d-flex align-items-center gap-3">  
                                            <a href="" class="primary"><span class="material-symbols-outlined">arrow_back</span></a>
                                            <div class="user_inner tools_inner">
                                                <img src="{{asset('frontend/images/search4.png')}}">
                                                <div class="user_info">
                                                    <h5 class="primary fw-bold m-0">HealthCrest Clinic & Family Planning Center</h5> 
                                                    <p class="mb-0 gray">Upgrade plan or continue with current plan</p> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4"> 
                                        <div class="toggle-switch d-flex align-items-center justify-content-end">
                                            <span class="me-2 gray">Monthly</span>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="billingToggle">
                                            </div>
                                            <span class="gray">Yearly</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <div class="col-12 col-lg-5">
                                        <div class="border rounded rounded-3 p-4 h-100">
                                            <div class="d-flex flex-column justify-content-between h-100"> 
                                                <div class="plans-head position-relative"> 
                                                    <div class="current-plan d-inline-flex align_middle"><span class="material-symbols-outlined">license</span><small class="white">Current Plan</small></div>
                                                    <img src="{{asset('frontend/images/diamond.png')}}" alt="Badge" class="subtype-icon">
                                                    <h2 class="fw-bold my-2">Pay As You Go Plan</h2>
                                                    <p class="mb-0">Designed for flexibility and convenience, this plan allows you to access high-quality care only when you need it. No ongoing commitment — just pay per visit, whether in-person or virtual.</p>
                                                </div>
                                                <div> 
                                                    <div class="fees-container"> 
                                                        <div class="d-flex align-items-center gap-3"> 
                                                            <h2 class="mb-0">$150</h2>
                                                            <div> 
                                                                <p class="mb-0">Virtual</p>
                                                                <p class="mb-0">Appointment Fee</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fees-container border-bottom-0"> 
                                                        <div class="d-flex align-items-center gap-3"> 
                                                            <h2 class="mb-0">$250</h2>
                                                            <div> 
                                                                <p class="mb-0">In-Person</p>
                                                                <p class="mb-0">Appointment Fee</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fees-container-highlight"> 
                                                        <div class="d-flex align-items-center gap-3"> 
                                                            <h3 class="mb-0">$0</h3>
                                                            <div> 
                                                                <p class="mb-0 white">Virtual</p>
                                                                <p class="mb-0 white">Appointment Fee</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="btn_alignbox mt-4"> 
                                                        <button type="button" class="btn btn-outline-primary w-100">Current Plan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5">
                                        <div class="plan-highlighted rounded-3 p-4 h-100">
                                            <div class="d-flex flex-column justify-content-between h-100"> 
                                                <div class="plans-head"> 
                                                    <img src="{{asset('frontend/images/gold.png')}}" alt="Badge" class="subtype-icon">
                                                    <h2 class="fw-bold my-2">Premier Membership</h2>
                                                    <p class="mb-0">This all-inclusive annual membership is ideal for individuals and families seeking comprehensive, relationship-based care. It includes unlimited in-person and virtual visits, direct physician access, extended appointment times, and priority scheduling.</p>
                                                </div>
                                                <div> 
                                                    <div class="fees-container"> 
                                                        <div class="d-flex align-items-center gap-3"> 
                                                            <h2 class="mb-0">$0</h2>
                                                            <div> 
                                                                <p class="mb-0">Virtual</p>
                                                                <p class="mb-0">Appointment Fee</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="fees-container border-bottom-0"> 
                                                        <div class="d-flex align-items-center gap-3"> 
                                                            <h2 class="mb-0">$0</h2>
                                                            <div> 
                                                                <p class="mb-0">In-Person</p>
                                                                <p class="mb-0">Appointment Fee</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fees-container-highlight"> 
                                                        <div class="d-flex align-items-center gap-3"> 
                                                            <h3 class="mb-0">$3,000</h3>
                                                            <div> 
                                                                <p class="mb-0 white">Yearly</p>
                                                                <p class="mb-0 white">Subscription Fee</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="btn_alignbox mt-4"> 
                                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#upgradePlans">Upgrade Plan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade tabschange" id="receipts"></div>
                            <div class="tab-pane fade tabschange" id="cards-billing"></div>
                            <div class="tab-pane fade tabschange" id="myclinics">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- order deatils --}}

<div class="modal fade" id="orderDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl subscription-modal-xl">
        <div class="modal-content subscription-modal p-0">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close">
                <span class="material-symbols-outlined">close</span>
                </a>
            </div>
            <div class="modal-body p-0">
                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <div class="subscription-box">
                            <h4 class="mb-3">Ordered Devices</h4>
                            <div class="row g-3">
                                <div class="col-12"> 
                                    <div class="border border-white rounded rounded-2 p-2">
                                        <div class="row align-items-center w-100">
                                            <div class="col-lg-7 d-flex align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{asset('/images/tool4.png')}}" alt="tools" class="image-device">
                                                    <div class="checkbox-info text-start">
                                                        <p class="primary fw-bold mb-0">iGlucose Plus</p>
                                                        <small class="white">Blood Glucose Monitor</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row text-end">
                                                    <div class="col-7">
                                                        <p class="primary fw-bold mb-1">$20</p>
                                                        <small class="white">One time charge</small>
                                                    </div>
                                                    <div class="col-5 pe-0">
                                                        <p class="primary fw-bold mb-1">$50</p>
                                                        <small class="white">per month</small>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"> 
                                    <div class="border border-white rounded rounded-2 p-2">
                                        <div class="row align-items-center w-100">
                                            <div class="col-lg-7 d-flex align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{asset('/images/tool5.png')}}" alt="tools" class="image-device">
                                                    <div class="checkbox-info text-start">
                                                        <p class="primary fw-bold mb-0">iBlood Pressure Classic</p>
                                                        <small class="white">Blood Pressure Monitor</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row text-end">
                                                    <div class="col-7">
                                                        <p class="primary fw-bold mb-1">$100</p>
                                                        <small class="white">One time charge</small>
                                                    </div>
                                                    <div class="col-5 pe-0">
                                                        <p class="primary fw-bold mb-1">$50</p>
                                                        <small class="white">per month</small>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"> 
                                    <div class="border border-white rounded rounded-2 p-2">
                                        <div class="row align-items-center w-100">
                                            <div class="col-lg-7 d-flex align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{asset('/images/tool6.png')}}" alt="tools" class="image-device">
                                                    <div class="checkbox-info text-start">
                                                        <p class="primary fw-bold mb-0">iScale</p>
                                                        <small class="white">Weighing Device</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row text-end">
                                                    <div class="col-7">
                                                        <p class="primary fw-bold mb-1">$100</p>
                                                        <small class="white">One time charge</small>
                                                    </div>
                                                    <div class="col-5 pe-0">
                                                        <p class="primary fw-bold mb-1">$50</p>
                                                        <small class="white">per month</small>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"> 
                                    <div class="border border-white rounded rounded-2 p-2">
                                        <div class="row align-items-center w-100">
                                            <div class="col-lg-7 d-flex align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{asset('/images/tool7.png')}}" alt="tools" class="image-device">
                                                    <div class="checkbox-info text-start">
                                                        <p class="primary fw-bold mb-0">iPulse Ox</p>
                                                        <small class="white">Pulse Oximeters</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row text-end">
                                                    <div class="col-7">
                                                        <p class="primary fw-bold mb-1">$20</p>
                                                        <small class="white">One time charge</small>
                                                    </div>
                                                    <div class="col-5 pe-0">
                                                        <p class="primary fw-bold mb-1">$50</p>
                                                        <small class="white">per month</small>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="amount-list my-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <p>One time device charge</p>
                                    <h5 class="mb-0 fw-bold">$320.00</h5>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <p>Monthly RPM</p>
                                    <div class="text-end">
                                        <h5 class="mb-0 fw-bold">$200</h5>
                                        <small class="white fwt-light">(Starting from: 02/26/2025)</small>
                                    </div>
                                </div>
                                <hr/>
                                <div class="d-sm-flex justify-content-between align-items-center gap-2 text-end">
                                    <h4 class="fw-medium m-0">Total</h4>
                                    <h3 class="fw-bold m-0">$520.00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-container">
                            <form>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap"> 
                                    <h4 class="fw-bold mb-0">Prescribers</h4>

                                    <a  href="" class="btn btn-outline-primary align_middle"><span class="material-symbols-outlined">add</span>Add Card</a>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="border rounded-4 p-4 h-100">
                                            <div class="pay-card-sec">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 w-100">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        </div>
                                                        <div class="user_inner">
                                                            <img src="{{asset('/images/mastercard_logo.png')}}">
                                                            <div class="user_info">
                                                                <h6 class="primary fw-bold mb-0">Card Ending in 4444</h6>
                                                                <small class="m-0">Expiry 04/2029</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                        <p class="text-success fw-bold d-flex align-items-center mb-0">
                                                            <span class="material-symbols-outlined me-1 text-success">verified</span> Primary Card
                                                        </p>       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="sub-h fw-bold my-3">Billing Address</h6>

                            <div class="row mt-2 mb-4">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group form-outline no-iconinput">
                                        <label class="float-label">Address</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group form-outline no-iconinput">
                                        <label class="float-label">City</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group form-outline no-iconinput">
                                        <label class="float-label">ZIP</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group form-outline no-iconinput">
                                        <label class="float-label">State</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group form-outline no-iconinput">
                                        <label class="float-label">Country</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12"> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label gray" for="">
                                            Same as profile
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <small class="text-muted d-block mb-3">
                            <span class="text-danger">*</span> By confirming your subscription, you agree to an annual commitment and authorize BlackBag to charge you monthly in accordance with our terms. You may cancel anytime, and your subscription will remain active until the end of the billing period.
                            </small>


                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#successSubscription">
                            Confirm Payment
                            </button>

                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- upgrade plan --}}


<div class="modal fade" id="upgradePlans" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl subscription-modal-xl">
        <div class="modal-content subscription-modal p-0">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close">
                <span class="material-symbols-outlined">close</span>
                </a>
            </div>
            <div class="modal-body p-0" id="appendpaymentdata">
                
            </div>
        </div>
    </div>
</div>



{{-- current plan --}}

<div class="modal login-modal fade" id="currentPlan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center px-lg-5">
                    <h4 class="fw-bold">Add New Clinic</h4>
                    <p class="mb-4">Connect with your preferred clinic to manage appointments, view records, and stay in sync with your care.</p>
                </div>
                <div class="border rounded rounded-3 p-4 h-100"> 
                    <div class="plans-head"> 
                        <img src="{{asset('frontend/images/diamond.png')}}" alt="Badge" class="subtype-icon">
                        <h2 class="fw-bold my-2">Pay As You Go Plan</h2>
                        <p class="mb-3">Designed for flexibility and convenience, this plan allows you to access high-quality care only when you need it. No ongoing commitment — just pay per visit, whether in-person or virtual.</p>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12 col-lg-6">
                            <div class="fees-container border-bottom-0 border-r p-0 my-3"> 
                                <div class="d-flex align-items-center gap-3"> 
                                    <h2 class="mb-0">$150</h2>
                                    <div> 
                                        <p class="mb-0">Virtual</p>
                                        <p class="mb-0">Appointment Fee</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="fees-container border-bottom-0 p-0 my-3"> 
                                <div class="d-flex align-items-center gap-3"> 
                                    <h2 class="mb-0">$250</h2>
                                    <div> 
                                        <p class="mb-0">In-Person</p>
                                        <p class="mb-0">Appointment Fee</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fees-container-highlight"> 
                        <div class="d-flex align-items-center gap-3"> 
                            <h3 class="mb-0">$0</h3>
                            <div> 
                                <p class="mb-0 white">Virtual</p>
                                <p class="mb-0 white">Appointment Fee</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Add clinic --}}


<div class="modal login-modal fade" id="addClinic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center px-lg-5">
                    <h4 class="fw-bold">Add New Clinic</h4>
                    <p class="mb-0">Connect with your preferred clinic to manage appointments, view records, and stay in sync with your care.</p>
                </div>
                <div class="form-group form-outline my-4">
                    <label for="input" class="float-label">Enter your clinician code</label>
                    <i class="material-symbols-outlined">home_health</i>
                    <input type="clinic_code" class="form-control" id="clinic_code">
                </div>  
                <div class="border rounded rounded-3 p-4 h-100 "  style="display:none" id="clinicdetails"> 
                    <!-- <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                        <div class="text-lg-start text-center image-body-xl">
                            <img src="{{asset('frontend/images/search4.png')}}" class="user-img" alt="">
                        </div>
                        <div class="user_details text-xl-start text-center pe-xl-4">
                            <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                <h5 class="fw-bold primary text-wrap mb-0">HealthCrest Clinic & Family Planning Center </h5>
                            </div>
                        </div>
                    </div>
                    <div class="gray-border my-4"></div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="text-start">
                                <label class="sm-label mb-1">Email</label>
                                <h6 class="mb-0 fw-bold">healthcrestclinic@gmail.com</h6>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="text-start">
                                <label class="sm-label mb-1">Phone Number</label>
                                <h6 class="mb-0 fw-bold">+1 (703) 216-6334</h6>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="btn_alignbox justify-content-end mt-4"> 
                    <button type="button" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-outline-primary">Cancel</button>
                    <button type="button" class="btn btn-primary disabled" id="clinicbtn" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#confirmAddClinic" >Continue</button>
                    <!-- -->
                </div>
            </div>
        </div>
    </div>
</div>


{{-- confirmation modal --}}




<!-- Loader -->

<div class="modal login-modal fade" id="loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('frontend/images/loader.gif')}}" class="img-fluid">
            </div>
        </div>
    </div>
</div>

{{-- success modal --}}

<div class="modal login-modal fade" id="SuccessLoader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('frontend/images/sucess.png')}}" class="img-fluid">
                <h4 class="fw-bold mt-4">Clinic added successfully!</h4>
                <p class="mb-0">You can view appointments, records, and manage your care seamlessly.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal fade" id="successSubscription" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('images/success_signin.png')}}" class="img-fluid">
                <h4 class="text-center fw-medium mb-0 mt-4">Subscription Successful</h4>
                <small class="gray">Your subscription plan has been updated</small>
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal payment-success fade" id="add_card_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center amount_body">
                    <h4 class="text-center fwt-bold mb-1">Add New Card</h4>
                    <small class="gray">Please enter card details</small>
                </div>
                <form method="POST" action="" id="addcardsform" autocomplete="off">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group form-outline mb-4">
                                <i class="material-symbols-outlined">id_card</i>
                                <label for="input" class="float-label">Cardholder Name</label>
                                <input type="name" class="form-control" id="name_on_card" name="name_on_card">
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="add_card_element">

                            </div>
                        </div>
                        <div class="btn_alignbox mt-5">
                            <button type="submit" id="submitbtn" class="btn btn-primary w-100">Add Card</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fix Google Autocomplete dropdown inside modal */
    .pac-container {
        z-index: 9999 !important;
    }
</style>
<script src="https://js.stripe.com/v3/"></script>  

<script>
    function  subscriptionDetails(key,id){
        $('#subscriptionDetailsmodal').modal('show');
        showPreloader('subscriptionDetails');
        $.ajax({
                type: "POST",
                url: "{{ url('/myaccounts/subscriptiondetails') }}" ,
                data: {
                    "key": key,
                    "clinicId" : id,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle the successful response
                    if(response.success == 1){
                        $("#subscriptionDetails").html(response.view);

                    }
                },
                error: function(xhr) {
                    // handleError(xhr);
                },
            })
    }



      $(document).ready(function () {
        changeTab('myprofile');
      });   
 
        function changeTab(type,page=1,clinicId='',queryString = '') {
            if(type == 'myprofile' || type == 'cards-billing' || type == 'myclinics' || type == 'receipts' || type == 'subscriptions' ){
                showPreloader(type);
            }
            $(".tabschange").addClass('fade');
            $(".tabschange").hide();
            $("#"+type).removeClass('fade');
            $("#"+type).addClass('active');
            $("#"+type).show();
            
            $.ajax({
                type: "POST",
                url: "{{ url('/myaccounts/getdata') }}" + "?" + queryString,
                data: {
                    "viewType": type,
                    "page":page,
                    "clinicid":clinicId,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle the successful response
                    if(response.success == 1){
                        $("#"+type).html(response.view);

                          // Attach click event to pagination links
                          if(type == 'myclinics'){
                            $("#pagination-myclinic a").on("click", function(e) {
                                e.preventDefault();
                                const newPage = $(this).attr("href").split("page=")[1];
                                changeTab(type,newPage);
                            });
                          }
                      
                    }
                },
                error: function(xhr) {
                    // handleError(xhr);
                },
            })
        }

          $(document).ready(function() {
            $('#loader').on('shown.bs.modal', function () {
            setTimeout(function() {
                $('#loader').modal('hide'); 
                $('#SuccessLoader').modal('show'); 
            }, 2000);
            });
        });

        let autocomplete; // Store autocomplete globally
  function initializeAutocomplete() {
    let addressInput = document.getElementById('address');
    if (addressInput) {
        addressInput.setAttribute("placeholder", ""); // Ensures no placeholder
    }

    if (typeof google === "undefined" || !google.maps || !google.maps.places) {
        console.error("Google Maps API failed to load. Please check your API key.");
        return;
    }

    let input = document.getElementById('address');
    if (!input) {
        console.log("Address input field NOT found!");
        return;
    }

    let countryDropdown = document.querySelector('.autofillcountry'); // Get country code
    let defaultCountry = countryDropdown ? countryDropdown.value : "US"; // Default to US

    autocomplete  = new google.maps.places.Autocomplete(input, {
        types: ['geocode', 'establishment'],
         componentRestrictions: { country: defaultCountry } // Restrict to US addresses
    });

    console.log("Google Places Autocomplete initialized successfully.");

    autocomplete.addListener('place_changed', function () {
        console.log("Place changed event triggered.");
        
        var place = autocomplete.getPlace();
        if (!place || !place.address_components) {
            console.error("No address components found.");
            return;
        }
       // console.log(place);
        var addressComponents = {
          street_number: "",
          street: "",
          city: "",
          state: "",
          zip: "",
          country: ""
        };

        place.address_components.forEach(component => {
          const types = component.types;

          if (types.includes("street_number")) {
              addressComponents.street_number = component.long_name;
          }

          if (types.includes("route")) {
              addressComponents.street += (addressComponents.street ? " " : "") + component.long_name;
          }

          if (types.includes("locality")) {
              addressComponents.city = component.long_name;
          }

          if (types.includes("administrative_area_level_1")) {
              addressComponents.state = component.short_name;
          }

          if (types.includes("postal_code")) {
              addressComponents.zip = component.long_name;
          }

          if (types.includes("country")) {
              addressComponents.country = component.long_name;  // ✅ This should catch the country
          }
        });

        console.log("Extracted Address Components:", addressComponents);

        function safeSetValue(id, value) {
            let element = document.getElementById(id);
            if (element) {
                element.value = value;
                let label = element.closest(".form-group")?.querySelector(".float-label");
                if (label && value.trim() !== "") {
                    label.classList.add("active");
                   
                }
            }
        }

        safeSetValue('address', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
        safeSetValue('city', addressComponents.city || '');
        safeSetValue('zip', addressComponents.zip || '');
        safeSetValue('state', addressComponents.state || '');
        safeSetValue('country', addressComponents.country || '');

        let stateDropdown = document.getElementById('state_id');
        if (stateDropdown) {
          for (let option of stateDropdown.options) {
            if (option.dataset.shortcode === addressComponents.state) {
              option.selected = true;
              break;
            }
          }
        }
        let countryDropdown = document.getElementById('country_id');
        if (countryDropdown) {
          for (let option of countryDropdown.options) {
            if (option.text.trim().toLowerCase() === addressComponents.country.trim().toLowerCase()) {
              option.selected = true;
              break;
            }
          }
        }
        $("#address, #city, #zip, #state_id").each(function () {
          $(this).valid(); 
        });
    });

  
    let focusedIndex = -1;
    let suggestions = [];
    let textarea = document.getElementById('address');

    // Add event listeners for keyboard navigation
    textarea.addEventListener('keydown', function(e) {
        const suggestionsList = document.getElementsByClassName('pac-container')[0];
        if (!suggestionsList) return;

        suggestions = suggestionsList.getElementsByClassName('pac-item');
        
        // Handle special keys
        switch(e.key) {
            case 'ArrowDown':
                // Only prevent default if suggestions are showing
                if (suggestions.length > 0) {
                    e.preventDefault();
                    focusedIndex = Math.min(focusedIndex + 1, suggestions.length - 1);
                    updateFocus();
                }
                break;

            case 'ArrowUp':
                // Only prevent default if suggestions are showing
                if (suggestions.length > 0) {
                    e.preventDefault();
                    focusedIndex = Math.max(focusedIndex - 1, -1);
                    updateFocus();
                }
                break;

            case 'Enter':
                // Only prevent default if a suggestion is focused
                if (focusedIndex > -1 && suggestions.length > 0) {
                    e.preventDefault();
                    suggestions[focusedIndex].click();
                    focusedIndex = -1;
                }
                break;

            case 'Escape':
                focusedIndex = -1;
                textarea.blur();
                break;
        }
    });

    // Reset focus when the input changes
    textarea.addEventListener('input', function() {
        focusedIndex = -1;
    });
}

function updateFocus() {
        Array.from(suggestions).forEach((suggestion, index) => {
            if (index === focusedIndex) {
                suggestion.classList.add('pac-item-selected');
                suggestion.scrollIntoView({ block: 'nearest' });
            } else {
                suggestion.classList.remove('pac-item-selected');
            }
        });
    }

function updateAutocompleteCountry() {
    let selectedCountry = document.querySelector('.autofillcountry')?.value || 'US';
  console.log('new'+selectedCountry)
    if (autocomplete) {
        autocomplete.setComponentRestrictions({ country: selectedCountry });
    } else {
        initializeAutocomplete(); // Reinitialize if needed
    }
    $("#address, #city, #zip, #state_id,#state").each(function () {
        $(this).val(''); // Clear the input field
        toggleLabel(this);
    });
}

// Initialize on window load
window.onload = function () {
    initializeAutocomplete();
};
function changePlan(clinicId) {
    showPreloader('subscriptions');
    $.ajax({
        type: "POST",
        url: '{{ url("/myaccounts/fetchplandetails") }}',
        data: {
            "clinicid": clinicId,
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success == 1){
                $("#subscriptions").html(response.view);
            }
        },
        error: function(xhr) {
            // handleError(xhr);
        },
    })
}
function showPaymentModal(clinicId,subscriptionkey){
    var isMonthlyChecked = $("#billingToggle").prop("checked");
    var isMonthlyChecked = isMonthlyChecked ? 1 : 0; 

    $.ajax({
        type: "POST",
        url: '{{ url("/myaccounts/fetchpaymentdetails") }}',
        data: {
            "clinicid": clinicId,
            "subscriptionkey": subscriptionkey,
            "isMonthlyChecked":isMonthlyChecked,
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success == 1){
                $("#upgradePlans").modal('show');
                $("#appendpaymentdata").html(response.view);
                initializeAutocompleteBilling();
            }
        },
        error: function(xhr) {
            // handleError(xhr);
        },
    })
}

</script>


@stop