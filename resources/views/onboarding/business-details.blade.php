@extends('onboarding.onboarding')
@section('title', 'Business Details')
@section('content') 

<section class="mx-lg-5 px-lg-5">
    <div class="container-fluid">
        <div class="wrapper res-wrapper onboard-wrapper">
                 @include('onboarding.tabs')

            <div class="web-card mb-5"> 
                <div id="step-content">
                    <div class="step-section" data-step="1">
        
                        <div class="onboard-box"> 
                            <h4 class="fw-bold mb-2">Business Details</h4>
                            <p class="fw-light">Provide your clinic's essential information, including business hours and appointment fees.</p>
                            
                            <form method="POST" id="registerform" autocomplete="off">
                            @csrf
                                <div class="row g-4"> 
                                    <div class="col-12">
                                        <h5 class="fw-medium mb-2">Clinic Details</h5>
                                    </div>
                                    <div class="col-12 mt-0 ">
                                        <div class="logodiv">
                                        <div class="create-profile d-inline-block text-center mt-0 ">
                                            <div class="profile-img position-relative m-0 logodiv"> 
                                                <img id="logodiv" src="{{ asset('images/clinics-default.png') }}" class="img-fluid">
                                                <a href="{{ url('crop/clinic_logo')}}" id="upload-img" class=" aupload upload-icon">
                                                    <span class="material-symbols-outlined">add_photo_alternate</span>
                                                </a>
                                            </div> 
                                            <label class="primary fw-medium mb-0 logodiv">Upload Logo</label>    
                                        </div>
                                        </div>
                                        <div class="files-container profile-files-container profileLogo mb-3">
        
                                            <div class="fileBody profliefileBody" id="cliniclogoimage"
                                                style="display:none">
                                                <div class="file_info">
                                                    <img src="{{ asset('images/clinics-default.png') }}" id="clinicimage" name="clinicimage">
                                                  
            
                                                    <!-- <span></span> -->
                                                </div>
                                                <a class="close-btn" href="javascript:void(0);" id="removelogo"
                                                    onclick="removeLogo()" data-bs-dismiss=" modal" aria-label="Close"><span
                                                        class="material-symbols-outlined">close</span>
                                                </a>
                                            </div>
                                        </div>
                                        <input type="hidden" id="tempimage" name="tempimage" value="">
                                        <input type="hidden" name="isremove" id="isremove" value="0">


                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline mb-lg-1 clinic_nameerr">
                                            <label for="clinic_name" class="float-label">Clinic Name</label>
                                            <i class="material-symbols-outlined">home_health</i>
                                            <input type="text" name="name" class="form-control clinic_name " id="clinic_name" value="{{$clinicDetails['name']}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline mb-lg-1">
                                            <label for="input" class="float-label">Email</label>
                                            <i class="fa-solid fa-envelope"></i>
                                            <input type="email" class="form-control" id="clinicemail" name="email" value="{{$clinicDetails['email']}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">

                                        <div class="form-group form-outline mb-lg-1 phoneregcls">
                                            <div class="country_code phone">
                                                <input type="hidden" id="cliniccountryCode1" name="clinic_countrycode" value='+1'>
                                                <input type="hidden" name="clinic_countryCodeShort" id="clinic_countryCodeShorts" value="us">

                                            </div>
                                            <i class="material-symbols-outlined me-2">call</i>
                                            <input type="text" name="phone" class="form-control phone-numberregister" id="clinic_phone_number" placeholder="Enter clinic phone number"  value="{{$clinicDetails['phone_number']}}">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12"> 
                                        <div class="form-group form-floating mb-lg-1">
                                            <i class="material-symbols-outlined">id_card</i>
                                            <select name="timezone_id" id="timezone_id" class="form-select">
                                                @if(!empty($timezoneDetails))
                                               
                                                    @foreach($timezoneDetails as $time)
                                                        <option value="{{$time['id']}}" @if($time['id'] == 6) selected @endif>{{$time['timezone']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label class="select-label">Timezone</label>
                                        </div>
                                    </div>


                                    <input type="hidden" name="business_details" id="business_details_stepId" value="1">
                                    <input type="hidden" name="user_type_id" id="user_type_id" value="1">
                                    <!-- <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline mb-lg-1">
                                            <label for="input" class="float-label">Phone Number</label>
                                            <i class="material-symbols-outlined">call</i>
                                            <input type="text" class="form-control" id="exampleFormControlInput1">
                                        </div> 
                                    </div> -->


                                    <div class="col-12">
                                        <div class="form-group form-floating mb-lg-1">
                                            <i class="material-symbols-outlined">public</i>
                                            <select name="country_id" id="country_id" data-tabid="basic" onchange="stateUS()" class="form-select autofillcountry">
                                            <option value="">Select a Country</option>

                                            @if(!empty($countryDetails))
                                                @foreach($countryDetails as $cds => $cd)
                                                    @if(!empty($cd['id'] == 185))
                                                        <option value="{{ $cd['id']}}" data-shortcode="{{$cd['short_code']}}" {{$cd['id'] == 185 ? 'selected' : ''}}>{{ $cd['country_name']}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                            </select>
                                            <label class="select-label">Country</label>
                                        </div>


                                        <!-- <div class="form-group form-floating mb-lg-1">
                                            <i class="material-symbols-outlined">public</i>
                                            <select name="designation" id="designation" class="form-select">
                                                <option value="">Select a Country</option>
                                                <option value="1">India</option>
                                                <option value="2">USA</option>
                                            </select>
                                            <label class="select-label">Country</label>
                                        </div> -->
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group form-outline mb-lg-1 addresserr">
                                            <label for="address" class="float-label">Address</label>
                                            <i class="material-symbols-outlined">home</i>
                                            <input type="text" class="form-control address" id="address" name="address" value="{{$clinicDetails['address']}}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group form-outline">
                                            <label for="city" class="float-label">City</label>
                                            <i class="material-symbols-outlined">location_city</i>
                                            <input type="text" class="form-control" id="city" name="city" value="{{$clinicDetails['city']}}">
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-4 col-12">
                                        <div class="form-group form-floating mb-lg-1">
                                            <i class="material-symbols-outlined">location_city</i>
                                            <select name="designation" id="designation" class="form-select">
                                                <option value="">Select a State</option>
                                                <option value="1">India</option>
                                                <option value="2">USA</option>
                                            </select>
                                            <label class="select-label">State</label>
                                        </div>
                                    </div> -->

                                    <div class="col-lg-4 col-12" id="states">
                                        <div class="form-group form-floating">
                                        <i class="material-symbols-outlined">map</i>
                                        {{-- <label for="input" class="">State</label> --}}
                                        <select name="state_id" id="state_id" data-tabid="basic" class="form-select">
                                            <option value="">Select State</option>
                                            @if(!empty($stateDetails))
                                            @foreach($stateDetails as $sds)
                                            <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}" @if($clinicDetails['state_id'] == $sds['id']) selected @endif>{{ $sds['state_name']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <label class="select-label">State</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-12" style="display: none;" id="stateOther">
                                        <div class="form-group form-outline">
                                        <label for="input" class="float-label">State</label>
                                        <i class="material-symbols-outlined">map</i>
                                        <input type="text" name="state" class="form-control" id="state">
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-12">
                                        <div class="form-group form-outline">
                                            <label for="zip_code" class="float-label">Zip</label>
                                            <i class="material-symbols-outlined">home_pin</i>
                                            <input type="text" class="form-control" id="zip" name="zip_code" value="{{$clinicDetails['zip_code']}}">
                                        </div>
                                    </div>


                                    <div class="col-12"> 
                                        <h5 class="fw-medium mb-1">Appointment Fee</h5>
                                        <p class="primary fw-medium mb-0">Appointment types that you offer:</p>
                                        <div class="d-flex flex-wrap gap-lg-5 gap-4 mt-1 appointmenttypeerr">
                                            <div class="form-check">
                                                <input class="form-check-input appointment-type appointment_typecls" value="2" type="radio" id="inperson" name="appointment_type">
                                                <label class="form-check-label primary" for="inperson">In Person</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input appointment-type appointment_typecls" type="radio" value="1" id="virtual" name="appointment_type">
                                                <label class="form-check-label primary" for="virtual">Virtual</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input appointment-type appointment_typecls" type="radio" id="both" value="3" name="appointment_type">
                                                <label class="form-check-label primary" for="both">Both</label>
                                            </div>     
                                        </div>
                                        <div class="row my-3">
                                            <div class="col-12 col-lg-6 inpersoncls appoinmentfee" style="display:none"> 
                                                <div class="form-group form-outline mb-lg-1 mb-4">
                                                    <label for="input" class="float-label">In Person</label>
                                                    <i class="material-symbols-outlined">local_atm</i>
                                                    <input type="text" class="form-control" id="inperson_fee" name="inperson_fee">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 virtualcls appoinmentfee" style="display:none"> 
                                                <div class="form-group form-outline mb-lg-1 mb-4">
                                                    <label for="input" class="float-label">Virtual</label>
                                                    <i class="material-symbols-outlined">local_atm</i>
                                                    <input type="text" class="form-control" id="virtual_fee" name="virtual_fee">
                                                </div>
                                            </div>
                                            <h5 class="fw-medium mb-2 mt-3">No Show Fee</h5>
                                            <div class="col-12 col-lg-6 inpersoncls appoinmentfee" style="display:none"> 
                                                <div class="form-group form-outline mb-lg-1 mb-4">
                                                    <label for="input" class="float-label">In Person</label>
                                                    <i class="material-symbols-outlined">local_atm</i>
                                                    <input type="text" class="form-control" id="in_person_mark_as_no_show_fee" name="in_person_mark_as_no_show_fee">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 virtualcls appoinmentfee" style="display:none"> 
                                                <div class="form-group form-outline mb-lg-1 mb-4">
                                                    <label for="input" class="float-label">Virtual</label>
                                                    <i class="material-symbols-outlined">local_atm</i>
                                                    <input type="text" class="form-control" id="virtual_mark_as_no_show_fee" name="virtual_mark_as_no_show_fee">
                                                </div>
                                            </div>
                                            <h5 class="fw-medium mb-2 mt-3">Cancellation Fee</h5>
                                            <div class="col-12 col-lg-6 inpersoncls appoinmentfee" style="display:none"> 
                                                <div class="form-group form-outline mb-lg-1 mb-4">
                                                    <label for="input" class="float-label">In Person</label>
                                                    <i class="material-symbols-outlined">local_atm</i>
                                                    <input type="text" class="form-control" id="in_person_cancellation_fee" name="in_person_cancellation_fee">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 virtualcls appoinmentfee" style="display:none"> 
                                                <div class="form-group form-outline mb-lg-1 mb-4">
                                                    <label for="input" class="float-label">Virtual</label>
                                                    <i class="material-symbols-outlined">local_atm</i>
                                                    <input type="text" class="form-control" id="virtual_cancellation_fee" name="virtual_cancellation_fee">
                                                </div>
                                            </div>
                                        </div>
                        
                                        <small class="primary fw-middle mb-0"><span class="asterisk">*</span>These are the appointment types that will be available for patients to book.</small>
                                    </div>
                                    
                                    <div class="col-12">
                                        <h5 class="fw-medium mb-2">Primary Contact Details</h5>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <div class="create-profile d-inline-block text-center doctorimage">
                                            <div class="profile-img position-relative m-0"> 
                                                <img id="doctorimage"  @if($clinicUserDetails['logo_path'] !='')  src="{{asset($clinicUserDetails['logo_path'])}}" @else src="{{ asset('images/patient_portal.png') }}" @endif class="img-fluid">
                                                <a  href="{{ url('crop/doctor')}}"  id="user-upload-img" class="aupload upload-icon" @if($clinicUserDetails['logo_path'] !='') style="display:none;" @endif>
                                                    <span class="material-symbols-outlined">add_photo_alternate</span>
                                                </a>
                                                <a class="profile-remove-btn" href="javascript:void(0);" id="userremovelogo" @if($clinicUserDetails['logo_path'] !='') style="" @else style="display:none;" @endif
                                            onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>
                                            </div> 
                                            <label class="primary fw-medium mb-0">Upload Image</label>    
                                        </div>
                                    </div>
                                    
                                    

                                    <input type="hidden" id="usertempimage" name="usertempimage" value="">
                                    <input type="hidden" name="userisremove" id="userisremove" value="0">


                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline mb-lg-1 first_nameerr">
                                            <label for="first_name" class="float-label">First Name</label>
                                            <i class="fa-solid fa-circle-user"></i>
                                            <input type="text" name="username" class="form-control first_name" id="first_name" value="{{$clinicUserDetails['first_name']}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline mb-lg-1 last_nameerr">
                                            <label for="last_name" class="float-label">Last Name</label>
                                            <i class="fa-solid fa-circle-user"></i>
                                            <input type="text" class="form-control last_name" id="last_name" name="last_name" value="{{$clinicUserDetails['last_name']}}" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline mb-lg-1">
                                            <label for="user_email" class="float-label">Email</label>
                                            <i class="fa-solid fa-envelope"></i>
                                            <input type="email" class="form-control" id="user_email" readonly name="user_email" value="{{$clinicUserDetails['email']}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-outline mb-lg-1 phoneregcls">
                                            <div class="country_code phone">
                                            <!-- <input type="hidden" id="user_countryCode" name="user_countryCode" value='+1'> -->
                                            <input type="hidden" name="user_countryCode" class="form-control" id="user_countryCode"  value="{{ isset($clinicUserDetails['short_code'])  ? $clinicUserDetails['short_code'] : 'US' }}">
                                            </div>
                                            <i class="material-symbols-outlined me-2">call</i>
                                            <?php $cleanPhoneNumber = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $clinicUserDetails['phone_number']); ?>
                                            <input type="text" name="user_phone" readonly class="form-control phone-numberregistuser" id="user_phone" value="<?php echo isset($clinicUserDetails['country_code'])  ? $clinicUserDetails['country_code'] . $cleanPhoneNumber : $cleanPhoneNumber ?>"
                                            placeholder="Enter phone number">
                                        </div>
                                        <!-- <div class="form-group form-outline mb-lg-1">
                                            <label for="input" class="float-label">Phone Number</label>
                                            <i class="material-symbols-outlined">call</i>
                                            <input type="text" class="form-control" id="exampleFormControlInput1">
                                        </div>  -->
                                    </div>

                                    
                                    <div class="col-12"> 
                                        <div class="row g-4"> 
                                            <div class="col-12"> 
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" name="is_licensed_practitioner" type="checkbox" id="is_licensed_practitioner" >
                                                    <small class="primary">Are you a licensed medical practitioner?</small>
                                                 </div>
                                            </div>


                                            <div class="col-12 licensedcls" style="display:none"> 
                                                <div class="row g-4"> 
                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-outline mb-lg-1">
                                                            <label for="input" class="float-label">NPI</label>
                                                            <i class="material-symbols-outlined">diagnosis</i>
                                                            <input type="text" class="form-control" id="npi_number" name="npi_number" maxlength="10" >
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-floating mb-lg-1">
                                                            <i class="material-symbols-outlined">id_card</i>
                                                            <select name="designation" id="designation" class="form-select">
                                                                @if(!empty($designationDetails))
                                                                <option value="">Select a Designation</option>
                                                                    @foreach($designationDetails as $dgn)
                                                                        <option value="{{$dgn['id']}}">{{$dgn['name']}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <label class="select-label">Designation</label>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-floating mb-lg-1">
                                                            <i class="material-symbols-outlined">workspace_premium</i>
                                                            <select name="speciality" id="speciality" class="form-select">
                                                            <option value="">Select a Speciality</option>
                                                                @foreach ($specialties as $specialty)
                                                                    <option value="{{$specialty['id']}}">{{$specialty['specialty_name']}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label class="select-label">Speciality</label>
                                                        </div>
                                                    </div>
                                              
                                                  

                                                    </div>


                                            </div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="btn_alignbox justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary"  id="save_clinic" onclick="submitClinic('working-hours')">Save & Continue</button>
                                </div>
                            </form>
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
<script>
    $('#dob').datetimepicker({
        format     : 'MM/DD/YYYY',
        useCurrent : false,                               // don’t auto‑fill today
        viewDate   : moment('01/01/2015', 'MM/DD/YYYY'),  // calendar lands on June 2015
        // ↓ hard limits so arrows can’t leave 1990‑2015
        // minDate    : moment('01/01/1990', 'MM/DD/YYYY'),
        // maxDate    : moment('12/31/2015', 'MM/DD/YYYY')
    });
    function submitClinic(type) {
        if ($("#registerform").valid()) {
            $("#save_clinic").addClass('disabled');
            getOnboardingDetails(type,'registerform');

        } else {
            $("#save_clinic").removeClass('disabled');
            if ($('.error:visible').length > 0) {
                setTimeout(function() {
                    
                }, 500);
            }
        }
    }
    $(document).ready(function () {
        $('#is_licensed_practitioner').change(function() {
    
            if ($(this).is(':checked')) {
             
                $('.licensedcls').show();
                 // Show step 2
                $('.stepper[data-step="2"]').removeClass('d-none');

            } else {
                $('.licensedcls').hide();
                $('.stepper[data-step="2"]').addClass('d-none');
            }
            // Renumber visible steps
            let stepCount = 1;
            $('.stepper:visible').each(function () {
                $(this).find('.circle').text(stepCount++);
            });

        });
        // Initialize label state for each input
        $('input').each(function() {
            toggleLabel(this);
        });
        $("#registerform").validate({
      ignore: [],
      rules: {
        username: {
          required: true,
          noWhitespace: true,
        },
        last_name: {
          required: true,
          noWhitespace: true,
        },
        // username: 'required',
        //  last_name: 'required',
        email: {
          required: true,
          format: true,
          email: true,
          emailFirstCharValid: true,
        },

        name: 'required',
        address: 'required',
        phone: {
          required: true,
          NumberValids: true,
        },
        city: 'required',
        country_id: 'required',
        state: {
          required: {
            depends: function (element) {
              return (($("#country_id").val() != '185'));
              // return (($("#country").val() =='236') );
            }
          },
        },
        state_id: {
          required: {
            depends: function (element) {
              return (($("#country_id").val() == '185'));
              // return (($("#country").val() =='236') );
            }
          },
        },

        // zip : 'required',
        zip_code: {
          required: true,
          //  digits: true,
          zipmaxlength: {
            depends: function (element) {
              return ( ($("#country_id").val() != '236') && $("#country").val() != '235' );
            }
          },
          regex: {
            depends: function (element) {
              return ($("#country_id").val() == '236');
            }
          },
          zipRegex: {
            depends: function (element) {
              return ($("#country_id").val() == '235');
            }
          },

        },


        npi_number: {
            required: {
                depends: function(element) { 
                    return $('#npi_number').is(':visible');
                }
            },
            number: {
                depends: function(element) { 
                    return $('#npi_number').is(':visible');
                }
            },
            minlength: 10,
            maxlength: 10,
            remote: {
                url: "{{ url('/validatenpinumber') }}",
                data: {
                    'type': 'npi_number',
                    'email': function () {
                            return $("#user_email").val(); // Get the updated value
                        },
                    '_token': $('input[name=_token]').val()
                },
                type: "post",
                  
            },
            
        },

        appointment_type: 'required',
                  
        inperson_fee:{
            required: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '2' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
            amountCheck: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '2' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
            greaterThanTen: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '2' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
        },
        virtual_fee:{
            required: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '1' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
            amountCheck: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '1' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
            greaterThanTen: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '1' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
        },
        in_person_mark_as_no_show_fee: {
            required: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '2' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
            amountCheck: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '2' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
        },
        in_person_cancellation_fee: {
            required: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '2' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
            amountCheck: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '2' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
        },
        virtual_mark_as_no_show_fee: {
            required: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '1' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
            amountCheck: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '1' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
        },
        virtual_cancellation_fee: {
            required: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '1' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
            amountCheck: {
                depends: function(element) { 
                    // Check if either "In Person" (2) or "Both" (3) is selected
                    return $('input[name="appointment_type"]:checked').val() == '1' || 
                        $('input[name="appointment_type"]:checked').val() == '3';
                }
            },
        },
        designation: {
          required: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked'));
             
            }
          },
        },
        speciality: {
          required: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked'));
             
            }
          },
        },

        user_address: {
          required: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked'));
             
            }
          },
        },
        user_city: {
          required: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked'));
             
            }
          },
        },
        user_state_id: {
          required: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked') && ($("#user_countryCode").val() == 'US') );
             
            }
          },
        },
        user_zip_code: {
          required: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked'));
             
            }
          },

        


        },


        user_state: {
          required: {
            depends: function (element) {
              return (($("#user_countryCode").val() != 'US')  && $('#is_licensed_practitioner').is(':checked'));
          
            }
          },
        },
        dob: {
          required: {
            depends: function (element) {
              return ( $('#is_licensed_practitioner').is(':checked'));
          
            }
          },
          dobRange: {
            depends: function (element) {
              return ( $('#is_licensed_practitioner').is(':checked'));
          
            }
          },
        },

        fax: {
          required: {
            depends: function (element) {
              return ( $('#is_licensed_practitioner').is(':checked'));
          
            }
          },
          faxPattern: function(element) {
            return ( $('#is_licensed_practitioner').is(':checked'));
            },

        },
     
    
        

      },

      messages: {
        dob: {
            required: 'Please enter date of birth.',
            dobRange: 'Invalid birth year. Please choose a year from 1900 to 2015.',
        },
        npi_number: {
            required: "Please enter a NPI number.",
            number: "Please enter a valid NPI number.",
            remote : "NPI number already exists in the system.",
            minlength: "Please enter a valid NPI number.",
            maxlength: "Please enter a valid NPI number."
        },
        fax: {
            required: 'Please enter fax.',
            faxPattern :'Please enter a valid fax number',
        },
        name: "Please enter clinic name.",
        country_id: "Please select country.",
        designation: "Please select designation.",
        speciality: "Please select speciality.",
        email: {
            required: 'Please enter email.',
            email: 'Please enter valid email.',
            remote: "Email id already exists in the system.",
            emailFirstCharValid : 'Please enter valid email.',
        },
        user_email: {
            required: 'Please enter email.',
            email: 'Please enter valid email.',
            remote: "Email id already exists in the system."
        },
        
        phone: {
            required: 'Please enter phone number.',
            NumberValids: 'Please enter valid phone number.',
            remote: "Phone number exists in the system."

        },
        user_phone: {
            required: 'Please enter phone number.',
            NumberValids: 'Please enter valid phone number.',
            remote: "Phone number exists in the system."
        },
        address: "Please enter address.",
        city: "Please enter city.",
        state: "Please enter state.",
        state_id: 'Please enter state',

        user_address: "Please enter address.",
        user_city: "Please enter city.",
        user_state: "Please enter state.",
        user_state_id: 'Please enter state',
        user_zip_code: {
            required: 'Please enter zip',
            zipmaxlength: 'Please enter a valid zip.',
            digits: 'Please enter a valid zip.',
            regex: 'Please enter a valid zip.',
            zipRegex: 'Please enter a valid zip.',
        },


        // zip : "Please enter zip." ,
        // username: "Please enter name.",
        username: {
            required: 'Please enter first name.',
            noWhitespace: 'Please enter valid first name.',
        },
        last_name: {
            required: 'Please enter last name.',
            noWhitespace: 'Please enter valid last name.',
        },
        zip_code: {
            required: 'Please enter zip',
            zipmaxlength: 'Please enter a valid zip.',
            digits: 'Please enter a valid zip.',
            regex: 'Please enter a valid zip.',
            zipRegex: 'Please enter a valid zip.',
        },

        appointment_type: "Please select type.",
        inperson_fee: {
            required: "Please enter appointment fees.",
            amountCheck: "Please enter a valid number.",
            greaterThanTen: "Please enter 0 or an amount greater than or equal to 10.",
        },
        virtual_fee: {
            required: "Please enter appointment fees.",
            amountCheck: "Please enter a valid number.",
            greaterThanTen: "Please enter 0 or an amount greater than or equal to 10.",
        },
        in_person_mark_as_no_show_fee: {
            required: "Please enter no show fees.",
            amountCheck: "Please enter a valid number.",
        },
        in_person_cancellation_fee: {
            required: "Please enter cancellation fees.",
            amountCheck: "Please enter a valid number.",
        },
        virtual_mark_as_no_show_fee: {
            required: "Please enter no show fees.",
            amountCheck: "Please enter a valid number.",
        },
        virtual_cancellation_fee: {
            required: "Please enter cancellation fees.",
            amountCheck: "Please enter a valid number.",
        },

      },
      errorPlacement: function (error, element) {
        if (element.hasClass("phone-numberregister")) {
          // Remove previous error label to prevent duplication
          // Insert error message after the correct element
          error.insertAfter(".phone-numberregister");

          error.addClass("phone-numberregister");
        }
        // else if(element.hasClass("address")){
        //     error.insertAfter(".addresserr");
        // }
        else if(element.hasClass("first_name")){
            error.insertAfter(".first_nameerr");
        }else if(element.hasClass("last_name")){
            error.insertAfter(".last_nameerr");
        }else if(element.hasClass("clinic_name")){
            error.insertAfter(".clinic_nameerr");
        }else if(element.hasClass("appointment_typecls")){
            error.insertAfter(".appointmenttypeerr");
        } else {
          if (element.hasClass("phone-numberregistuser")) {
            error.insertAfter(".phone-numberregistuser");
          } else {
            error.insertAfter(element); // Place error messages after the input fields

          }
        }

      },

    });

    $.validator.addMethod(
        'dobRange',
        function (value, element) {
            if (this.optional(element)) return true;          // allow empty
            const date = moment(value, 'MM/DD/YYYY', true);   // strict parse
            return date.isValid() &&
                    date.isSameOrAfter('1900-01-01') &&
                    date.isSameOrBefore('2015-12-31');
        },
        'Date of Birth must be between 01/01/1990 and 12/31/2015'
    );

    $.validator.addMethod("faxPattern",function (value, element) {
                return this.optional(element) || /^\+?[0-9\s\-\(\)]{6,20}$/.test(value);
            },
            "Please enter a valid fax number."
        );
    $.validator.addMethod(
        "greaterThanTen",
        function(value, element) {
            if (this.optional(element)) return true;

            var amount = parseFloat(value.replace(/,/g, '')); // Remove commas and parse

            return amount === 0 || amount >= 10;
        },
        "Please enter 0 or an amount greater than or equal to 10."
    );

    // Custom method to check for amount check
    $.validator.addMethod(
        "amountCheck", // Custom method name
        function(value, element) {
            // Regular expression for amount validation
            var regex = /^(?!0\d)(\d{1,3}(,\d{3})*|\d+)(\.\d{1,10})?$/;

            // Check if the value is optional or matches the regex
            return this.optional(element) || regex.test(value);
        },
        "Please enter a valid amount."
    );
    jQuery.validator.addMethod("noWhitespace", function(value, element) {
      return $.trim(value).length > 0;
    }, "This field is required.");

    jQuery.validator.addMethod("emailFirstCharValid", function(value, element) {
      const username = value.split('@')[0];
      return /^[a-zA-Z0-9]/.test(username);
    }, "Please enter valid email.");
    
    jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
        return this.optional(element) || phone_number.length < 14 &&
            phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
    });
    $.validator.addMethod(
      "format",
      function (value, element) {
        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(value);
      },
      "Please enter a valid email address."
    );
    $.validator.addMethod("regex", function (value, element) {
      return /^[0-9]{5}$/.test(value);
    }, "Please enter a valid ZIP code.");
    $.validator.addMethod("zipRegex", function (value, element) {
      return /^[a-zA-Z0-9]{5,7}$/.test(value);
    }, "Please enter a valid ZIP code.");

    $.validator.addMethod("zipmaxlength", function (value, element) {
      return /^\d{1,6}$/.test(value);
    }, "Please enter a valid ZIP code.");

   

  });

  function stateUS() {
    if ($("#country_id").val() == 185) {

      $("#states").show();
      $("#stateOther").hide();
      $("#state").val('');
    } else {

      $("#states").hide();
      $("#state_id").val('');
      $("#stateOther").show();
    }
    updateAutocompleteCountry();

  }


  let autocomplete ;
  function updateAutocompleteCountry() {
    let countryElement = document.getElementById("country_id");

    if (!countryElement) {
        console.error("Country select element not found.");
        return;
    }

    // Get the selected option's dataset shortcode
    let selectedOption = countryElement.options[countryElement.selectedIndex];
    let selectedCountry = selectedOption ? selectedOption.dataset.shortcode : 'US';

    // Validate the country code
    if (!selectedCountry || selectedCountry.length !== 2) {
        console.warn('Invalid country code, defaulting to US');
        selectedCountry = 'US';
    }

    console.log('Selected Country Code:', selectedCountry);


   
    var countrynew = $('#country_id').val(); // "John Doe"
    
    // console.log('Selected Country Code:', selectedCountrynew);
    if (autocomplete) {

        autocomplete.setComponentRestrictions({ country: selectedCountry });
    } else {
        //initializeAutocomplete();

    }

    $("#address, #city, #zip, #state_id,#state").each(function () {
        $(this).val('');
        toggleLabel(this);
    });
}
function initializeAutocomplete() {
   
    let addressInput = document.getElementById('address');
    if (addressInput) {
        addressInput.setAttribute("placeholder", "");
    }

    if (typeof google === "undefined" || !google.maps || !google.maps.places) {
        console.error("Google Maps API failed to load. Please check your API key.");
        // Disable address input if Google Maps fails to load
        if (addressInput) {
            addressInput.disabled = true;
            addressInput.placeholder = "Address autocomplete is currently unavailable";
        }
        return;
    }

    let input = document.getElementById('address');
    if (!input) {
        console.log("Address input field NOT found!");
        return;
    }
    var countrynew = $('#country_id').val();
    let defaultCountry = (countrynew == '185') ? 'US' : 'IN' ;
    let countryElement = document.getElementById("country_id");
    //   let defaultCountry = countryElement  ? countryElement.dataset.shortcode : 'US' ;
    //   defaultCountry = (defaultCountry == undefined ) ? 'US' : defaultCountry;
    console.log(defaultCountry)
    autocomplete  = new google.maps.places.Autocomplete(input, {
        types: ['geocode', 'establishment'],
        componentRestrictions: { country: defaultCountry } // Set initial country
    });
    // Validate the country code
    if (!defaultCountry || defaultCountry.length !== 2) {
        console.warn('Invalid country code, defaulting to US');
        defaultCountry = 'US';
    }

    // autocomplete = new google.maps.places.Autocomplete(input, {
    //     types: ['geocode', 'establishment'],
    //     componentRestrictions: { country: defaultCountry }
    // });

    console.log("Google Places Autocomplete initialized successfully.");


    autocomplete.addListener('place_changed', function () {
        console.log("Place changed event triggered.");
        
        var place = autocomplete.getPlace();
        if (!place || !place.address_components) {
            console.error("No address components found.");
            // alert("Invalid address selection. Please choose a valid address from the dropdown.");
            return;
        }

        var addressComponents = {
            street_number: "",
            street: "",
            city: "",
            state: "",
            zip: ""
        };

        place.address_components.forEach(component => {
            const types = component.types;
            if (!addressComponents.street_number) {
                addressComponents.street_number = '';
            }

            // Check if the component type is "establishment"
            if (place.types.includes("establishment")) {
                // Append the establishment name if it's not already in street_number
                if (!addressComponents.street_number.includes(place.name)) {
                    addressComponents.street_number += (addressComponents.street_number ? ", " : "") + place.name;
                }
            }

            // Check if the component type is "street_number"
            if (types.includes("street_number")) {
                // Append street number only if it's not already in the addressComponents
                if (!addressComponents.street_number.includes(component.long_name)) {
                    addressComponents.street_number += (addressComponents.street_number ? ", " : "") + component.long_name;
                }
            }

            // Check if the component type is "route"
            if (types.includes("route")) {
                // Append the route only if it's not already in street_number
                if (!addressComponents.street_number.includes(component.long_name)) {
                    addressComponents.street_number += (addressComponents.street_number ? ", " : "") + component.long_name;
                }
            }

            if (types.includes("locality")) addressComponents.city = component.long_name;
            if (types.includes("administrative_area_level_1")) addressComponents.state = component.short_name;
            if (types.includes("postal_code")) addressComponents.zip = component.long_name;
        });

        console.log("Extracted Address Components:", addressComponents);

        // Safe function to prevent errors
        function safeSetValue(id, value) {
            let element = document.getElementById(id);
            if (element) {
                element.value = value;

                 // Add "active" class if the field is prefilled
                let label = element.closest(".form-group").querySelector(".float-label");
                if (label && value.trim() !== "") {
                    label.classList.add("active");
                }

            }
        }

        safeSetValue('address', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
        safeSetValue('city', addressComponents.city || '');
        safeSetValue('zip', addressComponents.zip || '');
        safeSetValue('state', addressComponents.state || '');

        // Select the state in the dropdown
        let stateDropdown = document.getElementById('state_id');
        console.log(stateDropdown);
        if (stateDropdown) {
            for (let option of stateDropdown.options) {
              // console.log('op'+option.text)
              //   console.log('optt'+addressComponents.state)

                if (option.dataset.shortcode === addressComponents.state) {
                    option.selected = true;
                    break;
                }
            }
        }
        $("#address, #city, #zip, #state_id").each(function () {
          $(this).valid(); 
        });
    });

 
}


  $(document).ready(function () {

        // Initialize for user phone input
        var userTelInput = $("#user_phone"),
        userCountryCodeInput = $("#user_countryCode"),
        usercountryCodeShort = $("#user_countryCodeShorts"),
        userErrorMsg = $("#user_phone-error"),  // Updated target for user phone error message
        userValidMsg = $("#user_valid-msg");    // Assuming you have a unique valid message for user phone

        initializeIntlTelInput(userTelInput, userCountryCodeInput, userErrorMsg, userValidMsg, usercountryCodeShort);

        // Initialize for clinic phone input
        var clinicTelInput = $("#clinic_phone_number"),
        clinicCountryCodeInput = $("#cliniccountryCode1"),
        cliniccountryCodeShort = $("#clinic_countryCodeShorts"),
        clinicErrorMsg = $("#clinic_phone_number-error"),  // Updated target for clinic phone error message
        clinicValidMsg = $("#clinic_valid-msg");
        initializeIntlTelInput(clinicTelInput, clinicCountryCodeInput, clinicErrorMsg, clinicValidMsg, cliniccountryCodeShort,'clinic');


    });

        function initializeIntlTelInput(telInput, countryCodeInput, errorMsg, validMsg, countryCodeShort,type='') {
        // Initialize intlTelInput
        let onlyCountriesx;
        if (type === 'clinic') {
            // Only US allowed
              onlyCountriesx = ['us'];
        } else {
         
             onlyCountriesx = {!! json_encode($corefunctions->getCountry()) !!};
        }
      
            
        telInput.intlTelInput({
        initialCountry: "us",
        formatOnDisplay: true,
        autoHideDialCode: true,
        onlyCountries: onlyCountriesx,
        nationalMode: false,
        separateDialCode: true,
        geoIpLookup: function (callback) {
            $.get("http://ipinfo.io", function () { }, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
        });

        // Reset error/valid messages
        function reset() {
        telInput.removeClass("error");
        errorMsg.addClass("hide");
        validMsg.addClass("hide");
        }

        // Handle country change event 
        telInput.on("countrychange", function (e, countryData) {
        var countryShortCode = countryData.iso2;
        countryCodeShort.val(countryShortCode);
        countryCodeInput.val(countryData.dialCode);
        });
        // Handle clinic change even

        // Handle blur event
        telInput.blur(function () {
        reset();
        if ($.trim(telInput.val())) {
            if (telInput.intlTelInput("isValidNumber")) {
            validMsg.removeClass("hide");
            } else {
            telInput.addClass("error");
            errorMsg.removeClass("hide");
            }
        }
        });

        // Handle keyup/change event
        telInput.on("keyup change", reset);

        $('#clinic_phone_number, #user_phone').mask('(ZZZ) ZZZ-ZZZZ', {
        translation: {
            'Z': {
            pattern: /[0-9]/,
            optional: false
            }
        }
        });
        }






function clinicLogoImage(imagekey, imagePath, imgName) {

    $("#tempimage").val(imagekey);
    $("#clinicimage").attr("src", imagePath);
    $("#clinic_logo_name").text(imgName);
    $("#cliniclogoimage").show();
    $("#removelogo").show();
    $("#logodiv").hide();
    $(".logodiv").hide();
 
    

}
function removeLogo() {
    swal({
        title: '',
        text: 'Are you sure you want to remove this image?',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {


        if (willDelete) {
            event.preventDefault();
            $("#isremove").val('1');
            $("#cliniclogoimage").hide();
            $("#logodiv").show();
            $(".logodiv").show();
            $("#tempimage").val('');
            } else {
            }

        // $("#upload-img").show();

    });
}


function doctorImage(imagekey, imagePath) {
    
    $("#usertempimage").val(imagekey);
    $("#doctorimage").attr("src", imagePath);
    $("#doctorimage").show();
    $("#user-upload-img").hide();
    $("#userremovelogo").show();
    $(".doctorimage").hide();
}
function removeImage(){
    $("#doctorimage").attr("src","{{asset('images/default_img.png')}}");
    $("#userisremove").val('1');
    $("#userremovelogo").hide();
    $("#user-upload-img").show();
    $(".doctorimage").show();
    $("#usertempimage").val('');
}


    $(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });
    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
        const isFocused = $input.is(':focus');

        // Ensure .float-label is correctly selected relative to the input
        $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
    }

    $(document).on('change', '.appointment-type[type="radio"]', function() {
        // Hide all fee inputs first
        $('.appoinmentfee').hide();
        
        // Show relevant fee inputs based on selection
        if ($(this).is(':checked')) {
            if ($(this).val() == '3') {
                // Both selected - show both fee inputs
                $('.appoinmentfee').show();
            } else if ($(this).val() == '1') {
                // Virtual selected
                $('.virtualcls').show();
            } else if ($(this).val() == '2') {
                // In Person selected
                $('.inpersoncls').show();
            }
        }
    });





    
        </script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initializeAutocomplete" async defer></script>


@stop