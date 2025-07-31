@extends('frontend.master')
@section('title', 'Dashboard')
@section('content')

<section class="details_wrapper">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-xl-8 order-0 order-xl-0">
                <div class="row g-4"> 
                    <div class="col-12"> 
                        <div class="web-card min-h-auto dashboard-box position-relative overflow-hidden">
                            <div class="row align-items-center"> 
                                <div class="col-12 col-lg-5">
                                    <div class="user_inner user_inner_xl">
                                        <img src="{{asset('frontend/images/john_doe.png')}}" class="img-fluid">
                                        <div class="user_info">
                                            <h6 class="gray fw-medium m-0">Good Morning,</h6>
                                            <h3 class="m-0">{{$patientDetails['first_name']}} {{$patientDetails['last_name']}}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 d-lg-block d-none"> 
                                    <div class="vertical-gradient-line"></div>
                                </div>
                                <div class="col-12 col-lg-2 text-lg-start text-center mt-lg-0 mt-2">
                                    <h5 class="fwt-bold mb-1">{{$patientDetails['age']}} | {{ $patientDetails['gender'] == '1' ? 'Male' : ($patientDetails['gender'] == '2' ? 'Female' : 'Other') }}</h5>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="btn_alignbox justify-content-xl-end mt-xl-0 mt-3"> 
                                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#book_appointment">Book Appointment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"> 
                        <div class="web-card min-h-auto h-100">
                            <div class="text-start"> 
                                <h5 class="fw-bold mb-4">Upcoming Appointment</h5>
                            </div>

                            <div class="row g-3 align-items-center"> 
                                <div class="col-12 col-xl-4">
                                    <div class="user_inner user_inner_xl flex-column align-items-lg-baseline">
                                        <img src="{{asset('frontend/images/search4.png')}}" class="img-fluid">
                                        <div class="user_info">
                                            <h5 class="fw-bold m-0">HealthCrest Clinic & Family Planning Center </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-8 border-l">
                                    <div class="row g-3 ps-xl-3">
                                        <div class="col-12 col-lg-6"> 
                                             <div class="d-flex flex-lg-row flex-column align-items-center gap-3"> 
                                                <div class="text-lg-start text-center image-body">
                                                    <img src="{{asset('frontend/images/search5.png')}}"  class="user-img" alt="">
                                                </div>
                                                <div class="user_details text-lg-start text-center pe-lg-4">
                                                    <div class="innercard-info justify-content-center justify-content-lg-start flex-column align-items-start gap-1">
                                                        <h6 class="fw-bold m-0">Jelani Kasongo, NP</h6>
                                                        <p class="fw-medium mb-0">Cardiology</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6"> 
                                            <div class="btn_alignbox justify-content-lg-end"> 
                                                <button type="button" class="btn btn-outline-primary">Join Call</button>
                                            </div>
                                        </div>
                                        <div class="col-12"> 
                                            <div class="border rounded-2 p-3"> 
                                                <div class="row g-3"> 
                                                    <div class="col-12 col-lg-6"> 
                                                        <div class="d-flex align-items-center gap-2"> 
                                                            <div class="appointment-icon">
                                                                <span class="material-symbols-outlined">calendar_month</span>
                                                            </div>
                                                            <h6 class="mb-0 fw-bold">20 May, 2025</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6"> 
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="appointment-icon">
                                                                <span class="material-symbols-outlined">alarm</span>
                                                            </div>
                                                            <h6 class="mb-0 fw-bold">10:30 AM</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- <div class="text-center"> 
                                <img src="{{asset('frontend/images/nodata.png')}}" class="no-records-img">
                                <p class="fwt-bold primary mb-0">No Appointments Yet</p>
                            </div> --}}

                        </div>
                    </div>
                    <div class="col-12"> 
                        <div class="web-card min-h-auto h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap"> 
                                <div> 
                                    <p class="mb-0">Blood Pressure</p>
                                    <h3 class="mb-0">120/80</h3>
                                </div>
                                <div class="border rounded-2 p-2"> 
                                    <img src="{{asset('frontend/images/tool3.png')}}" class="tool-img">
                                </div>
                            </div>
                            <div class="grap-container"> 
                                <img src="{{asset('frontend/images/bb-graph.png')}}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4 order-3 order-xl-1">
                <div class="web-card h-100">
                    <div class="row"> 
                        <div class="col-12"> 
                            <div id="calendar" class="calendar">
                                <span>Add something here</span>
                            </div>
                        </div>
                        <div class="col-12"> 
                            <div class="gray-border my-4"></div>
                        </div>
                        <div class="col-12"> 
                            <div class="text-start"> 
                                <h5 class="fw-bold">Appointments</h5>
                            </div>
                            <div class="text-center"> 
                                <img src="{{asset('frontend/images/nodata.png')}}" class="no-records-img">
                                <p class="fwt-bold primary mb-0">No Appointments Yet</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6 order-1 order-xl-2">
                <div class="web-card h-100 min-h-auto">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap"> 
                        <div> 
                            <p class="mb-0">SpO2</p>
                            <h3 class="mb-0">96%</h3>
                        </div>
                        <div class="border rounded-2 p-2"> 
                            <img src="{{asset('frontend/images/tool1.png')}}" class="tool-img">
                        </div>
                    </div>
                    <div class="grap-container"> 
                        <img src="{{asset('frontend/images/bar-graph.png')}}" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6 order-2 order-xl-3">
                <div class="web-card h-100 min-h-auto">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap"> 
                        <div> 
                            <p class="mb-0">Blood Sugar Level</p>
                            <h3 class="mb-0">95mg/dL</h3>
                        </div>
                        <div class="border rounded-2 p-2"> 
                            <img src="{{asset('frontend/images/tool2.png')}}" class="tool-img">
                        </div>
                    </div>
                    <div class="grap-container"> 
                        <img src="{{asset('frontend/images/sugar-graph.png')}}" class="img-fluid">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>


{{-- Book appointment --}}

<div class="modal login-modal fade" id="book_appointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4 px-xl-5 px-3">
                    <h4 class="text-center fw-bold mb-1">Book Appointment</h4>
                    <p class="gray fw-light mb-0">Select a preferred doctor for your appointment.</p>
                </div>

                <form>
                    <div class="row g-4"> 
                        <div class="col-12"> 
                            <div class="form-group form-outline mb-3 no-iconinput">
                                <label for="input">Select Patient</label>
                                
                                <div class="dropdownBody">
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                        </a>
                                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink" style="">
                                            <li class="dropdown-item">
                                                <div class="form-outline input-group ps-1">
                                                    <div class="input-group-append">
                                                        <button class="btn border-0" type="button"><i class="fas fa-search fa-sm"></i></button>
                                                    </div>
                                                    <input type="text" class="form-control border-0 small" placeholder="Search Patient" aria-label="Search" aria-describedby="basic-addon2">
                                                </div>
                                            </li>
                                            <li class="dropdown-item">
                                                <div class="dropview_body profileList">
                                                    
                                                    <img src="{{asset('frontend/images/search3.png')}}" class="img-fluid">
                                                    <p class="m-0">Justin Taylor</p>
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-0"> 
                            <h4 class="text-strat fw-bold mb-0 ">Select Doctor</h4>
                            <div class="gray-border my-3"></div>
                        </div>
                        <div class="col-12 col-xl-6"> 
                            <div class="border rounded-4 p-3">
                                <a href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#doctor_appointment">
                                    <div class="user_inner user_inner_xl">
                                        <img src="{{asset('frontend/images/search3.png')}}" class="img-fluid">
                                        <div class="user_info">
                                            <h5 class="fw-bold m-0 primary">Sarooj Kumar, MD</h5>
                                            <p class="m-0">Cardiology</p>
                                        </div>
                                    </div>
                                    <div class="gray-border my-3"></div>
                                    <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                                        <div class="text-xl-start text-center image-body">
                                            <img src="{{asset('frontend/images/search4.png')}}"  class="user-img" alt="">
                                        </div>
                                        <div class="user_details text-xl-start text-center pe-xl-4">
                                            <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                                <h6 class="fw-bold primary text-wrap mb-0">HealthCrest Clinic & Family Planning Center</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6"> 
                            <div class="border rounded-4 p-3"> 
                                <div class="user_inner user_inner_xl">
                                    <img src="{{asset('frontend/images/search3.png')}}" class="img-fluid">
                                    <div class="user_info">
                                        <h5 class="fw-bold m-0">Sarooj Kumar, MD</h5>
                                        <p class="m-0">Cardiology</p>
                                    </div>
                                </div>
                                <div class="gray-border my-3"></div>
                                <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                                    <div class="text-xl-start text-center image-body">
                                        <img src="{{asset('frontend/images/search4.png')}}"  class="user-img" alt="">
                                    </div>
                                    <div class="user_details text-xl-start text-center pe-xl-4">
                                        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                            <h6 class="fw-bold primary text-wrap mb-0">HealthCrest Clinic & Family Planning Center</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6"> 
                            <div class="border rounded-4 p-3"> 
                                <div class="user_inner user_inner_xl">
                                    <img src="{{asset('frontend/images/search3.png')}}" class="img-fluid">
                                    <div class="user_info">
                                        <h5 class="fw-bold m-0">Sarooj Kumar, MD</h5>
                                        <p class="m-0">Cardiology</p>
                                    </div>
                                </div>
                                <div class="gray-border my-3"></div>
                                <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                                    <div class="text-xl-start text-center image-body">
                                        <img src="{{asset('frontend/images/search4.png')}}"  class="user-img" alt="">
                                    </div>
                                    <div class="user_details text-xl-start text-center pe-xl-4">
                                        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                            <h6 class="fw-bold primary text-wrap mb-0">HealthCrest Clinic & Family Planning Center</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6"> 
                            <div class="border rounded-4 p-3"> 
                                <div class="user_inner user_inner_xl">
                                    <img src="{{asset('frontend/images/search3.png')}}" class="img-fluid">
                                    <div class="user_info">
                                        <h5 class="fw-bold m-0">Sarooj Kumar, MD</h5>
                                        <p class="m-0">Cardiology</p>
                                    </div>
                                </div>
                                <div class="gray-border my-3"></div>
                                <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                                    <div class="text-xl-start text-center image-body">
                                        <img src="{{asset('frontend/images/search4.png')}}"  class="user-img" alt="">
                                    </div>
                                    <div class="user_details text-xl-start text-center pe-xl-4">
                                        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                            <h6 class="fw-bold primary text-wrap mb-0">HealthCrest Clinic & Family Planning Center</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>                            
            </div>
        </div>
    </div>
</div>

{{-- Book Doctor Appointment --}}

<div class="modal login-modal fade" id="doctor_appointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4 px-xl-5 px-3">
                    <h4 class="text-center fw-bold mb-1">Select Date & Time</h4>
                    <p class="gray fw-light mb-0">Select appointment date and choose a time slot.</p>
                </div>

                <div class="border rounded-4 p-3 mb-4">
                    <div class="row g-4 align-items-center"> 
                        <div class="col-12 col-xl-5 border-r">
                            <div class="user_inner user_inner_xl">
                                <img src="{{asset('frontend/images/john_doe.png')}}" class="img-fluid">
                                <div class="user_info">
                                    <h5 class="primary fw-bold m-0">Sarooj Kumar, MD</h5>
                                    <p class="m-0">Cardiology</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 ps-xl-4 ps-xl-5">
                            <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                                <div class="text-xl-start text-center image-body">
                                    <img src="{{asset('frontend/images/search4.png')}}"  class="user-img" alt="">
                                </div>
                                <div class="user_details text-xl-start text-center pe-xl-4">
                                    <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                        <h6 class="fw-bold primary text-wrap mb-0">HealthCrest Clinic & Family Planning Center</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div> 
                </div>

                <form>
                    <div class="row g-4"> 
                        <div class="col-12"> 
                            <div class="form-group form-outline">
                                <label class="float-label">Appointment Date</label>
                                <i class="material-symbols-outlined">calendar_clock</i>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>

                        <div class="col-12"> 
                            <div class="gray-border my-3"></div>
                        </div>

                        <div class="col-12"> 
                            <div class="slot-wrapper">
                                <p class="fw-medium mb-2">Morning</p>
                                <div class="row g-2">
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary active w-100">09:00 AM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100">09:30 AM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary disabled w-100">10:00 AM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100" disabled>10:30 AM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100">11:00 AM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100">11:30 AM</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12"> 
                            <div class="slot-wrapper">
                                <p class="fw-medium mb-2">Afternoon</p>
                                <div class="row g-2">
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100" disabled>12:00 PM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary active w-100">02:00 PM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100" disabled>02:30 PM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100" disabled>03:00 PM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary disabled w-100" disabled>03:30 PM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary disabled w-100">04:00 PM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100" disabled>04:30 PM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100">05:00 PM</a>
                                    </div>
                                    <div class="col-4 col-sm-3 col-xl-2">
                                        <a class="btn-outline-secondary w-100">05:30 PM</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="btn_alignbox justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-primary">Go Back</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointment_summary">Continue</button>
                    </div>
                </form>                            
            </div>
        </div>
    </div>
</div>

{{-- Appointment summary --}}

<div class="modal login-modal fade" id="appointment_summary" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4 px-xl-5 px-3">
                    <h4 class="text-center fw-bold mb-1">Appointment Summary</h4>
                    <p class="gray fw-light mb-0">Confirm your appointment details</p>
                </div>
                <div class="row g-4"> 
                    <div class="col-12 col-xl-6"> 
                        <div class="border rounded-4 p-3 h-100">
                            <a href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#doctor_appointment">
                                <div class="user_inner user_inner_xl">
                                    <img src="{{asset('frontend/images/search3.png')}}" class="img-fluid">
                                    <div class="user_info">
                                        <h5 class="fw-bold m-0 primary">Sarooj Kumar, MD</h5>
                                        <p class="m-0">Cardiology</p>
                                    </div>
                                </div>
                                <div class="gray-border my-3"></div>
                                <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                                    <div class="text-xl-start text-center image-body">
                                        <img src="{{asset('frontend/images/search4.png')}}"  class="user-img" alt="">
                                    </div>
                                    <div class="user_details text-xl-start text-center pe-xl-4">
                                        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                            <h6 class="fw-bold primary text-wrap mb-0">HealthCrest Clinic & Family Planning Center</h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6"> 
                        <div class="border rounded-4 p-3 h-100">
                            <div class="text-start"> 
                                <small class="gray fw-medium">Appointment Date</small>
                                <h5 class="mb-0 fw-bold">20 May, 2025</h5>
                            </div>
                             <div class="gray-border my-3"></div>
                            <div class="text-start"> 
                                <small class="gray fw-medium">Appointment Time </small>
                                <h5 class="mb-0 fw-bold">09:00 AM - 09:30 AM</h5>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="btn_alignbox justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-primary">Edit Booking</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#bookingSuccess">Confirm Booking</button>
                </div>                                       
            </div>
        </div>
    </div>
</div>

{{-- booking success --}}

<div class="modal login-modal fade" id="bookingSuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('frontend/images/sucess.png')}}" class="img-fluid">
                <h4 class="text-center fw-bold mt-3 mb-1">Booking Confirmed</h4>
                <p class="gray fw-light mb-0">You can now meet the doctor at the allotted time</p>
            </div>
        </div>
    </div>
</div>


<script> 

//-------- date picker ---------- //

    var calendarNode = document.querySelector("#calendar");

    var currDate = new Date();
    var currYear = currDate.getFullYear();
    var currMonth = currDate.getMonth() + 1;

    var selectedYear = currYear;
    var selectedMonth = currMonth;
    var selectedMonthName = getMonthName(selectedYear, selectedMonth);
    var selectedMonthDays = getDayCount(selectedYear, selectedMonth);

    renderDOM(selectedYear, selectedMonth);

    function getMonthName (year, month) {
        let selectedDate = new Date(year, month-1, 1);
        return selectedDate.toLocaleString('default', { month: 'long' });
    }

    function getMonthText () {
        if (selectedYear === currYear)
            return selectedMonthName;
        else
            return selectedMonthName + ", " + selectedYear;
    }

    function getDayName (year, month, day) {
        let selectedDate = new Date(year, month-1, day);
        return selectedDate.toLocaleDateString('en-US',{weekday: 'long'});
    }

    function getDayCount (year, month) {
        return 32 - new Date(year, month-1, 32).getDate();
    }

    function getDaysArray () {
        let emptyFieldsCount = 0;
        let emptyFields = [];
        let days = [];

        switch(getDayName(selectedYear, selectedMonth, 1))
        {
            case "Tuesday":
                emptyFieldsCount = 1;
                break;
            case "Wednesday":
                emptyFieldsCount = 2;
                break;
            case "Thursday":
                emptyFieldsCount = 3;
                break;
            case "Friday":
                emptyFieldsCount = 4;
                break;
            case "Saturday":
                emptyFieldsCount = 5;
                break;
            case "Sunday":
                emptyFieldsCount = 6;
                break;
        }
      
        emptyFields = Array(emptyFieldsCount).fill("");
        days = Array.from(Array(selectedMonthDays + 1).keys());
        days.splice(0, 1);
        
        return emptyFields.concat(days);
    }

    function renderDOM (year, month) {
      let newCalendarNode = document.createElement("div");
      newCalendarNode.id = "calendar";
      newCalendarNode.className = "calendar";
      
      let dateText = document.createElement("div");
      dateText.append(getMonthText());
      dateText.className = "date-text";
      newCalendarNode.append(dateText);
      
      let leftArrow = document.createElement("div");
      let leftIcon = document.createElement("i");
      leftIcon.className = "fa-solid fa-chevron-left";
      leftArrow.appendChild(leftIcon);
      leftArrow.className = "button";
      leftArrow.addEventListener("click", goToPrevMonth);
      newCalendarNode.appendChild(leftArrow);
      
      let curr = document.createElement("div");
      curr.append("");
      curr.className = "button";
      curr.addEventListener("click", goToCurrDate);
      newCalendarNode.append(curr);
      
      let rightArrow = document.createElement("div");
      let icon = document.createElement("i");
      icon.className = "fa-solid fa-chevron-right";
      rightArrow.appendChild(icon);
      rightArrow.className = "button";
      rightArrow.addEventListener("click", goToNextMonth);
      newCalendarNode.appendChild(rightArrow);
      
      let dayNames = ["M", "T", "W", "T", "F", "S", "S"];
      
      dayNames.forEach((cellText) => {
        let cellNode = document.createElement("div");
        cellNode.className = "cell cell--unselectable";
        cellNode.append(cellText);
        newCalendarNode.append(cellNode);
      });
      
      let days = getDaysArray(year, month);
      
      days.forEach((cellText) => {
        let cellNode = document.createElement("div");
        cellNode.className = "cell";
        cellNode.append(cellText);
        newCalendarNode.append(cellNode);
      });
      
      calendarNode.replaceWith(newCalendarNode);
      calendarNode = document.querySelector("#calendar");
    }

    function goToPrevMonth () {
        selectedMonth--;
        if (selectedMonth === 0) {
            selectedMonth = 12;
            selectedYear--;
        }
        selectedMonthDays = getDayCount(selectedYear, selectedMonth);
        selectedMonthName = getMonthName(selectedYear, selectedMonth);
      
        renderDOM(selectedYear, selectedMonth);
    }

    function goToNextMonth () {
        selectedMonth++;
        if (selectedMonth === 13) {
            selectedMonth = 0;
            selectedYear++;
        }
        selectedMonthDays = getDayCount(selectedYear, selectedMonth);
        selectedMonthName = getMonthName(selectedYear, selectedMonth);
      
        renderDOM(selectedYear, selectedMonth);
    }

    function goToCurrDate () {
        selectedYear = currYear;
        selectedMonth = currMonth;

        selectedMonthDays = getDayCount(selectedYear, selectedMonth);
        selectedMonthName = getMonthName(selectedYear, selectedMonth);
      
        renderDOM(selectedYear, selectedMonth);
    }



</script>

@endsection