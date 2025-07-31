@extends('onboarding.onboarding')
@section('title', 'Business Details')
@section('content')    
<style>
    /* Fix Google Autocomplete dropdown inside modal */
    .pac-container {
        z-index: 9999 !important;
    }
</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places" async defer></script>
<section class="mx-lg-5 px-lg-5">
    <div class="container-fluid">
        <div class="wrapper res-wrapper onboard-wrapper">
                @include('onboarding.tabs')
            <div class="web-card mb-5"> 
                <div id="step-content">
                    <div class="step-section" data-step="5" >  
                        <div class="onboard-box"> 
                            <div class="d-flex justify-content-between"> 
                                <div> 
                                    <h4 class="fw-bold">Choose Addons</h4>
                                    <p class="gray">Enhance Your Practice with Add-ons</p>
                                </div>
                                    <!-- <a href="" class="primary align_middle fw-medium"><span class="material-symbols-outlined">keyboard_backspace</span>Back</a> -->
                            </div>

                            <div class="col-12">
                                <div class="border rounded-4 p-4 bg-white"> 
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-8 mb-3 mb-md-0">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{asset('/images/escribe.png')}}" alt="icon" class="escribe-icon">
                                                <div>
                                                    <h4 class="gray fw-medium mb-1">Optional Add-On</h4>
                                                    <h2 class="font-large mb-0 fw-bold">ePrescribe</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <h5 class="mb-0 fw-bold">$79.00</h5>
                                            <div class="text-muted small">Per doctor per month</div>
                                        </div>
                                    </div>
                                    <div class="gray-border"></div>
                                    <div class="mt-3">
                                        <small class="fw-exlight">Add-On includes:</small>
                                        <ul class="list-unstyled imp-point mt-2 mb-0">
                                            <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>One-time Setup: $250</li>
                                            <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>12-month minimum commitment required</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="btn_alignbox justify-content-end mt-3" > 
                                <button onclick="getOnboardingDetails('eprescribe','','1')" class="btn btn-outline align_middle">Skip</button>

                                   
                                <button type="button" id="enableAddOnBtn" class="btn btn-primary @if( $isUsUser == 0) enablebtnfadeout @endif" @if( $isUsUser == 0) onclick="disableePrescribe()" @else @if(isset($clinicUserDetails) && !empty($clinicUserDetails) && ($isShow == '1') ) onclick="enableUsers('{{$clinicUserDetails['clinic_user_uuid']}}');" @else onclick="enableAddOn();" @endif @endif>Enable Add-on</button>
                              

  
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp


<div class="modal login-modal fade" id="addPlan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">   
                <div class="text-start mb-3">           
                    <h4 class="fw-bold mb-0 primary">Add Subscription Plan</h4>
                    <small class="gray fw-light">Create flexible subscription plans with custom fees for in-person and virtual visits.</small>
                </div>
                <form method="POST" id="addplanform" autocomplete="off">
                @csrf
                    <div class="row g-4"> 
                        <div class="col-12"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Plan Name</label>
                                <i class="material-symbols-outlined">workspace_premium</i>
                                <input type="text" name="plan_name" class="form-control" id="plan_name">
                            </div>
                        </div>
                        <div class="col-12"> 
                            <div class="form-group form-outline form-textarea">
                                <label for="" class="float-label">Plan Description</label>
                                <i class="fa-solid fa-file-lines"></i>
                                <textarea class="form-control" name="description" rows="4" cols="4"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Monthly Subscription Fee</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" name="monthly_amount" class="form-control" id="monthly_fee">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Yearly Subscription Fee</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" name="annual_amount" class="form-control" id="yearly_fee">
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-medium mt-4">Appointment Fee</h5>
                    <div class="form-check my-2">
                        <input class="form-check-input appointment-type" type="checkbox" id="appointmnetfee" name="has_per_appointment_fee">
                        <small class="primary">Do you have a different per appointment fee for this subscription.</small>
                    </div>
                    <div class="row appoinmentfee mt-3" style="display:none;"> 
                        <div class="col-12"> 
                            <p class="fw-middle primary mb-2">Enter your per appointment fee</p>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">In Person</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" name="inperson_fee" class="form-control" id="inperson_fee" @if(isset($clinicDetails) && !empty($clinicDetails)) value="{{$clinicDetails['inperson_fee']}}" @endif>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"> 
                            <div class="form-group form-outline">
                                <label for="" class="float-label">Virtual</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" name="virtual_fee" class="form-control" id="virtual_fee" @if(isset($clinicDetails) && !empty($clinicDetails)) value="{{$clinicDetails['virtual_fee']}}" @endif>
                            </div>
                        </div>
                    </div>
                </form>

                
                <div class="btn_alignbox justify-content-end mt-3">
                    <a class="btn btn-outline">Cancel</a>
                    <a onclick="addSubscriptionPlan()" class="btn btn-primary" >Add Plan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function disableePrescribe(){
        var errormsg = "ePrescirption can only be enabled for US based clinicians/admins";
         swal(errormsg, {
                icon: "error",
                text: errormsg,
                button: "OK",
              });
    }
 </script>  

@stop