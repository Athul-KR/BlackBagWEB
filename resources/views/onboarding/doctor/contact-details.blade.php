@extends('onboarding.onboarding')
@section('title', 'Business Details')
@section('content') 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places" async defer></script>

<section class="mx-lg-5 px-lg-5">
    <div class="container-fluid">
        <div class="wrapper res-wrapper onboard-wrapper">
                 @include('onboarding.doctortabs')

            <div class="web-card h-100 mb-5"> 
                <div id="step-content">
                    <div class="step-section" data-step="1">
        
                        <div class="onboard-box"> 
                            <h4 class="fw-bold mb-2">Contact Details</h4>
                            <p class="fw-light">Provide your complete contact information.</p>
                            
                            <form method="POST" id="registerform" autocomplete="off">
                            @csrf
                                <div class="row g-4"> 
                                  
                                    @php
                                            $corefunctions = new \App\customclasses\Corefunctions;
                                            $userLogo = (session('user.userLogo') != '') ? session('user.userLogo') : asset('images/default_img.png');

                                    @endphp

                                    <div class="col-12">
                                        <div class="border rounded-3 p-3">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-lg-6">
                                                    <div class="d-flex flex-lg-row flex-column align-items-center gap-3"> 
                                                        <div class="text-lg-start text-center image-body">
                                                            <img src="{{$userLogo}}" class="user-img" alt="">
                                                        </div>
                                                        <div class="user_details text-xl-start text-center pe-xl-4">
                                                            <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                                                <h5 class="fw-medium dark text-wrap mb-0">{{$corefunctions -> showClinicanName($clinicUserDetails,1)}}</h5>
                                                                <small class="sm-label mb-0">{{$clinicUserDetails['email']}}</small>
                                                                <input type="hidden" id="email" value="{{$clinicUserDetails['email']}}">
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="text-lg-start text-center"> 
                                                        <label class="sm-label mb-1">Phone Number</label>
                                                        <?php $cleanPhoneNumber = $corefunctions->formatPhone($clinicUserDetails['phone_number']) ?>
                                                    
                                                        <h6 class="fw-bold mb-0"> <?php echo isset($clinicUserDetails['country_code'])  ? $clinicUserDetails['country_code'] .' '.$cleanPhoneNumber : $cleanPhoneNumber ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12"> 
                                        <div class="row g-4"> 
                                            @if($clinicUserDetails['user_type_id'] == '1')
                                            <div class="col-12"> 
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" name="is_licensed_practitioner" type="checkbox" id="is_licensed_practitioner" @if( $clinicUserDetails['is_licensed_practitioner'] == '1' ) checked @endif>
                                                    <small class="primary">Are you a licensed medical practitioner?</small>
                                                 </div>
                                            </div>
                                            @endif

                                            <div class="col-12 licensedcls" @if( $clinicUserDetails['is_licensed_practitioner'] == '1' ) style="display:block" @else style="display:none" @endif > 
                                                <div class="row g-4"> 
                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-outline">
                                                            <label for="input" class="float-label">NPI</label>
                                                            <i class="material-symbols-outlined">diagnosis</i>
                                                            <input type="text" class="form-control" id="npi_number" name="npi_number" value="{{$clinicUserDetails['npi_number']}}" maxlength="10">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-floating">
                                                            <i class="material-symbols-outlined">id_card</i>
                                                            <select name="designation" id="designation" class="form-select">
                                                                @if(!empty($designationDetails))
                                                                <option value="">Select a Designation</option>
                                                                    @foreach($designationDetails as $dgn)
                                                                        <option value="{{$dgn['id']}}" @if($clinicUserDetails['designation_id'] == $dgn['id']) selected @endif>{{$dgn['name']}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <label class="select-label">Designation</label>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-4 col-12"> 
                                                        <div class="form-group form-floating">
                                                            <i class="material-symbols-outlined">workspace_premium</i>
                                                            <select name="speciality" id="speciality" class="form-select">
                                                            <option value="">Select a Speciality</option>
                                                                @foreach ($specialties as $specialty)
                                                                    <option value="{{$specialty['id']}}" {{$clinicUserDetails['specialty_id'] == $specialty['id'] ? 'selected': ''}}>{{$specialty['specialty_name']}}</option>
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
                                 <input type="hidden" id="user_type_id" value="{{$clinicUserDetails['user_type_id']}}">
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

function submitClinic(type) {
    if ($("#registerform").valid()) {
        $("#save_clinic").addClass('disabled');
        savedoctor(type,'registerform');

    } else {
        $("#save_clinic").removeClass('disabled');
        if ($('.error:visible').length > 0) {
            setTimeout(function() {
                
            }, 500);
        }
    }

}

function savedoctor(type,formname='',islater='') {
    
    if ((type == 'choose-addons' && islater !='1') && ( $('#planslist').length === 0 || !$('#planslist').is(':visible'))) {
        swal('Warning','Please add any plan to continue','warning');
        return ;
      

    }

   showPreloader("step_" + type);
   let formdata = formname !='' ? $("#"+formname).serialize() : '';
   var currentStepId = $("#"+type+"_stepId").val() || 1;
   $.ajax({
       type: "POST",
       url: '{{ url("doctor/onboarding/") }}/' + type,
       data: {
         'formdata': formdata,
         'formType' : 'onboarding',
           "currentStepId": 1,
           "nextstep": type,
           "islater" : islater ,
            "_token": "{{ csrf_token() }}"
       },
       success: function(response) {

           if(response.success == 1){
            if(response.complete == 1){
                window.location.href = "{{ url('dashboard/') }}/" ;
            }else{
                window.location.href = "{{ url('doctor/onboarding/') }}/" + response.step ;
            }
           
            
           
           }
       },
       error: function(xhr) {
           handleError(xhr);
       },
   })
}


   

 $(document).ready(function () {
  
    $('#is_licensed_practitioner').change(function() {
            if ($(this).is(':checked')) {
                $('.licensedcls').show();
                 // Show step 2
                $('.stepper[data-step="2"]').removeClass('d-none');
                $('.steppercls').removeClass('hidelinecls');
                
            } else {
                $('.licensedcls').hide();
                $('.stepper[data-step="2"]').addClass('d-none');
                $('.steppercls').addClass('hidelinecls');
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
    

        npi_number: {
            required :{
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked') || $('#user_type_id').val() == '2');
             
            }
          },
            number: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked') || $('#user_type_id').val() == '2');
             
            }
          },
            remote: {
                url: "{{ url('/validatenpinumber') }}",
                data: {
                    'type': 'npi_number',
                    'email': function () {
                        return $("#email").val(); // Get the updated value
                    },
                    '_token': $('input[name=_token]').val()
                },
                type: "post",
                
            },
            minlength: 10,
            maxlength: 10,
        },

      
                  
      
        designation: {
          required: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked') || $('#user_type_id').val() == '2');
             
            }
          },
        },
        speciality: {
          required: {
            depends: function (element) {
              return ($('#is_licensed_practitioner').is(':checked') || $('#user_type_id').val() == '2');
             
            }
          },
        },
        

      },

      messages: {
        npi_number: {
            
        required: "Please enter a NPI number.",
          number: "Please enter a valid NPI number.",
          remote : "NPI number already exists in the system.",
          minlength: "Please enter a valid NPI number.",
          maxlength: "Please enter a valid NPI number."
        },
        name: "Please enter clinic name.",
        country_id: "Please select country.",
        designation: "Please select designation.",
        speciality: "Please select speciality.",
        
      


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

    $.validator.addMethod("notInvalidValues", function(value, element) {
        const num = parseFloat(value);
        return this.optional(element) || ((num === 0 || num >= 5) && num !== 1 && num !== 2 && num !== 3 && num !== 4);
    }, "Please enter 0 or a value greater than or equal to 5, but not 1, 2, or 34.");



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


@stop