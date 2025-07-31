@extends('layouts.app')
@section('title', 'Appointment')
@section('content')
   
<section id="content-wrapper">
                        <div class="container-fluid p-0">
                          <div class="row h-100">
                            <div class="col-12 mb-3">
                                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                                      <!-- <li class="breadcrumb-item"><a href="" class="primary">Appointment List</a></li> -->
                                      <li class="breadcrumb-item active" aria-current="page">Appointment Details</li>
                                    </ol>
                                  </nav>
                            </div>

                            <div class="col-xl-8 col-12  mb-3">
                                <div class="web-card h-100 mb-3 overflow-hidden">
                                    <div class="profileData patientProfile">
                                        <div class="row align-items-end h-100">
                                            <div class="col-lg-5 col-xl-3">
                                                <div class="user_details text-center">
                                                <h5 class="fw-medium dark">Appointment 1</h5>
                                                    <p>Online Appointment</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-xl-3">
                                                <div class="user_details text-center">
                                                <h5 class="fw-medium dark">Appointment Date</h5>
                                                    <p>2/1/2024, 2:30 pm</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-xl-9">
                                                <div class="d-flex justify-content-center justify-content-xl-end">


                                                </div>
                                            </div>                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-12 mb-3">
                              <div class="web-card h-100 mb-3">
                                <div class="detailsList cardList">
                                  <h5 class="fw-medium">Doctor Details</h5>
                                      <hr>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-medium">Name</h6>
                                            <p>Amal</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                              <h6 class="fw-medium">Email</h6>
                                              <p>test22@ic.oko</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                              <h6 class="fw-medium">Phone Number</h6>
                                              <p>9999999999</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-medium">Address</h6>

                                            <p>Lake Ave City</p>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-12 mb-3">
                              <div class="web-card h-100 mb-3">
                                <div class="detailsList cardList">
                                  <h5 class="fw-medium">Nurse Details</h5>
                                      <hr>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-medium">Name</h6>
                                            <p>Amal</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                              <h6 class="fw-medium">Email</h6>
                                              <p>test22@ic.oko</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                              <h6 class="fw-medium">Phone Number</h6>
                                              <p>9999999999</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-medium">Address</h6>

                                            <p>Lake Ave City</p>
                                        </div>
                                        
                                    </div>
                                </div>
                          </div>

                            <div class="col-xl-4 col-12 mb-3">
                              <div class="web-card h-100 mb-3">
                                <div class="detailsList cardList">
                                  <h5 class="fw-medium">Patient Details</h5>
                                      <hr>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-medium">Name</h6>
                                            <p>Amal</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                              <h6 class="fw-medium">Email</h6>
                                              <p>test22@ic.oko</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                              <h6 class="fw-medium">Phone Number</h6>
                                              <p>9999999999</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-medium">Address</h6>

                                            <p>Lake Ave City</p>
                                        </div>
                                        
                                    </div>
                                </div>
                          </div>
                            
                            <!-- <div class="col-xl-8 col-12 mb-xl-5 mb-3 order-1 order-xl-0">

                                <div class="web-card h-100">
                                    <div class="row align-items-center">
                                        <div class="col-sm-8 text-center text-sm-start">
                                          <h4 class="mb-md-0">Nurse Details</h4>
                                        </div>
                                        <div class="col-sm-4 text-center text-sm-end">
                                        </div>
      
                                
                
                                        <div class="col-lg-12 my-3">
                                          <div class="col-12">
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                              <li class="nav-item" role="presentation">
                                              <button class="nav-link online active" id="pills-home-tab" onclick="getAppointments()"  role="tab" aria-controls="pills-home" aria-selected="true">Online Appointments</button>
                                              </li>
                                              <li class="nav-item" role="presentation">
                                                  <button class="nav-link offline" id="pills-profile-tab" onclick="getAppointments()"  role="tab" aria-controls="pills-profile" aria-selected="false">In-person Appointments</button>
                                              </li>
                                            </ul>
                                              <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="appointmentspatients" role="tabpanel" aria-labelledby="pills-home-tab">  
                                                
                                                
                                              </div>

                                              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                              </div>
                                             
                                               
                                              </div>
                                            </div>
                                          </div> 
                                        </div>
                                    </div>
                                </div> -->
   
                            </div>

                            
                          </div>
                        </div>
                      </section>
                      <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
                      <script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

  


@stop