<div class="tab-pane fade show active" id="pills-clinicprofile" role="tabpanel" aria-labelledby="pills-clinicprofile-tab">
    <div class="row g-3"> 
        <div class="col-12 col-lg-8 mx-auto"> 
            <div class="border rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="primary fw-medium mb-0">Clinic Details</h5>
                    @if(session()->get('user.isClinicAdmin') == '1')
                    <a class="btn opt-btn align_middle" onclick="editAppointmentFee()">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    @endif
                </div>
                <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                    <div class="text-lg-start text-center image-body">
                        <img src="{{$clinic['logo'] ?? asset('images/default_clinic.png')}}"  class="user-img" alt="">
                    </div>
                    <div class="user_details text-xl-start text-center pe-xl-4">
                        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                            <h5 class="fw-medium dark text-wrap mb-0">{{$clinic->name ?? "N/A"}}</h5>
                            <p class="gray mb-0">{{$clinic->email ?? "N/A"}}</p>
                            @if(!empty($clinic->website_link))
                            <div class="mb-2">
                                <strong>Website:</strong>
                                <a href="{{ $clinic->website_link }}" target="_blank" rel="noopener noreferrer">
                                    {{ $clinic->website_link }}
                                </a>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>  <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
              
               
                    <div class="gray-border my-4"></div>
                    <div class="d-flex flex-column gap-3">
                        <div class="border rounded-3 p-3">
                            <h5 class="primary fw-medium mb-0">Appointment Fee</h5>
                            <p class="mb-2"> Appointment types that you offer.</p>
                            <div class="border-bottom my-2"></div>
                            <div class="row">
                                <div class="col" @if($clinic->appointment_type_id == '1') style="display:none;" @endif>
                                    <p class="mb-1 text-muted">In Person</p>
                                    <strong>@if($clinic->inperson_fee !='') ${{$clinic->inperson_fee}}  @endif</strong>
                                </div>
                                <div class="col" @if($clinic->appointment_type_id == '2') style="display:none;" @endif>
                                    <p class="mb-1 text-muted">Virtual</p>
                                    <strong>@if($clinic->virtual_fee !='') ${{$clinic->virtual_fee}}  @endif</strong>
                                </div>
                            </div>
                        </div>

                     
                        <div class="border rounded-3 p-3">
                            <h5 class="primary fw-medium mb-0">No Show Fee</h5>
                             <div class="border-bottom my-2"></div>
                            <div class="row">
                                <div class="col" @if($clinic->appointment_type_id == '1') style="display:none;" @endif>
                                    <p class="mb-1 text-muted">In Person</p>
                                    <strong>@if($clinic->in_person_mark_as_no_show_fee  !='') ${{$clinic->in_person_mark_as_no_show_fee }}  @endif</strong>
                                </div>
                                <div class="col" @if($clinic->appointment_type_id == '2') style="display:none;" @endif>
                                    <p class="mb-1 text-muted">Virtual</p>
                                    <strong>@if($clinic->virtual_mark_as_no_show_fee  !='') ${{$clinic->virtual_mark_as_no_show_fee }}  @endif</strong>
                                </div>
                            </div>
                        </div>

                       
                        <div class="border rounded-3 p-3">
                            <h5 class="primary fw-medium mb-0">Cancellation Fee</h5>
                            <div class="border-bottom my-2"></div>
                            <div class="row">
                                <div class="col" @if($clinic->appointment_type_id == '1') style="display:none;" @endif>
                                    <p class="mb-1 text-muted">In Person</p>
                                    <strong>@if($clinic->in_person_cancellation_fee  !='') ${{$clinic->in_person_cancellation_fee }}  @endif</strong>
                                </div>
                                <div class="col" @if($clinic->appointment_type_id == '2') style="display:none;" @endif>
                                    <p class="mb-1 text-muted">Virtual</p>
                                    <strong>@if($clinic->virtual_cancellation_fee  !='') ${{$clinic->virtual_cancellation_fee }}  @endif</strong>
                                </div>
                             </div>
                        </div>

                        <small class="primary fw-middle mb-0"><span class="asterisk">*</span> These are the appointment types that will be available for patients to book.</small>

                    </div>
            

            </div>
        </div>
      
    </div>
</div>


<!-- edit Doctor Modal -->
<div class="modal login-modal fade" id="editDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="editDoctor">

            <h4 class="text-center fw-medium mb-0">Edit Appointment Fee</h4>
            <p class="gray mb-3">Appointment types that you offer:</p>
            <form method="POST" id="edituserform" autocomplete="off">
                @csrf
                <div class="row">            
                    <div class="text-start">
                        <h5 class="primary fw-medium mb-3">Appointment Fee</h5>
                    </div>
                    <div class="d-flex flex-wrap gap-lg-5 gap-4 mt-1 appointmenttypeerr">
                        <div class="form-check">
                            <input class="form-check-input appointment-type appointment_typecls" value="2" data-original="2" @if($clinic->appointment_type_id == '2') checked @endif type="radio" id="inperson" name="appointment_type">
                            <label class="form-check-label primary" for="inperson">In Person</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input appointment-type appointment_typecls" type="radio" value="1" id="virtual" data-original="1" name="appointment_type" @if($clinic->appointment_type_id == '1') checked @endif>
                            <label class="form-check-label primary" for="virtual">Virtual</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input appointment-type appointment_typecls" type="radio" id="both" value="3" data-original="3" name="appointment_type" @if($clinic->appointment_type_id == '3') checked @endif>
                            <label class="form-check-label primary" for="both">Both</label>
                        </div>     
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-lg-6 inpersoncls appoinmentfee" @if($clinic->appointment_type_id == '1') style="display:none" @endif > 
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">In Person</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" class="form-control" id="inperson_fee"   name="inperson_fee"  @if($clinic->inperson_fee !='') data-original="{{ $clinic->inperson_fee }}" value="{{$clinic->inperson_fee}}"   @endif>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 virtualcls appoinmentfee" @if($clinic->appointment_type_id == '2') style="display:none" @endif> 
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Virtual</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" class="form-control" id="virtual_fee" name="virtual_fee" @if($clinic->virtual_fee !='')  data-original="{{ $clinic->virtual_fee }}" value="{{$clinic->virtual_fee}}"   @endif>
                            </div>
                        </div>
                        <div class="text-start">
                            <h5 class="primary fw-medium mb-3">No Show Fee</h5>
                        </div>
                        <div class="col-12 col-lg-6 inpersoncls appoinmentfee" @if($clinic->appointment_type_id == '1') style="display:none" @endif> 
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">In Person</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" class="form-control" id="in_person_mark_as_no_show_fee" name="in_person_mark_as_no_show_fee" data-original="{{ $clinic->in_person_mark_as_no_show_fee }}" @if($clinic->in_person_mark_as_no_show_fee  !='') value="{{$clinic->in_person_mark_as_no_show_fee }}"  @endif>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 virtualcls appoinmentfee" @if($clinic->appointment_type_id == '2') style="display:none" @endif> 
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Virtual</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" class="form-control" id="virtual_mark_as_no_show_fee" name="virtual_mark_as_no_show_fee" data-original="{{ $clinic->virtual_mark_as_no_show_fee }}" @if($clinic->virtual_mark_as_no_show_fee  !='') value="{{$clinic->virtual_mark_as_no_show_fee }}"  @endif>
                            </div>
                        </div>
                        <div class="text-start">
                            <h5 class="primary fw-medium mb-3">Cancellation Fee</h5>
                        </div>
                        <div class="col-12 col-lg-6 inpersoncls appoinmentfee" @if($clinic->appointment_type_id == '1') style="display:none" @endif> 
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">In Person</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" class="form-control" id="in_person_cancellation_fee" name="in_person_cancellation_fee" data-original="{{ $clinic->in_person_cancellation_fee }}" @if($clinic->in_person_cancellation_fee  !='') value="{{$clinic->in_person_cancellation_fee }}"  @endif>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 virtualcls appoinmentfee" @if($clinic->appointment_type_id == '2') style="display:none" @endif> 
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Virtual</label>
                                <i class="material-symbols-outlined">local_atm</i>
                                <input type="text" class="form-control" id="virtual_cancellation_fee" name="virtual_cancellation_fee" data-original="{{ $clinic->virtual_cancellation_fee }}" @if($clinic->virtual_cancellation_fee  !='') value="{{$clinic->virtual_cancellation_fee }}"  @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn_alignbox justify-content-end mt-2">
                    <a href="javascript:void(0)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Close</a>
                    <a href="javascript:void(0)" id="updatedoctr" onclick="updateClinic('{{$clinic->clinic_uuid}}')" class="btn btn-primary" >Submit</a>
                </div>
            </form>


      </div>
    </div>
  </div>
</div>

<script>

function updateClinic(key) {
    if ($("#edituserform").valid()) {
        $("#updatedoctr").addClass('disabled');
        $.ajax({
            url: '{{ url("/profile/updateclinic") }}',
            type: "post",
            data: {
                'formdata': $("#edituserform").serialize(),
                'key' : key ,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#editDoctor_modal").modal('hide');
      
                    tabContent('settings')
                }
            },
            error: function(xhr) {
                    
                    handleError(xhr);
                }
        });

    } else {
        $("#save_clinic").removeClass('disabled');
        if ($('.error:visible').length > 0) {
            setTimeout(function() {
                
            }, 500);
        }
    }

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
                        



    function editAppointmentFee() {
        // Reset all inputs to their original values
        $('#editDoctor_modal input').each(function () {
            const originalVal = $(this).data('original');
            
            if ($(this).attr('type') === 'radio') {
                const name = $(this).attr('name');
                let selectedval = '{{$clinic->appointment_type_id}}' ;
                $('input[name="' + name + '"]').prop('checked', false); // uncheck all
                $('input[name="' + name + '"][data-original="' + selectedval + '"]').prop('checked', true); // recheck original
            } else {
                $(this).val(originalVal);
            }
        });

        // Show/hide fee fields based on the appointment type
        updateFeeFieldsVisibility();

        // Now show the modal
        $("#editDoctor_modal").modal('show');
    }
    function updateFeeFieldsVisibility() {
        // const selectedType = $('.appointment-type:checked').val();
        let selectedType = '{{$clinic->appointment_type_id}}' ;
        // alert(selectedType)
        if (selectedType == '1') { // Virtual
            $('.inpersoncls').hide();
            $('.virtualcls').show();
        } else if (selectedType == '2') { // In Person
            $('.inpersoncls').show();
            $('.virtualcls').hide();
        } else { // Both
            $('.inpersoncls').show();
            $('.virtualcls').show();
        }
    }



    // Function to toggle the 'active' class
    function toggleLabel(input) {
        const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
        $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
    }
    $(document).ready(function() {

        $("#edituserform").validate({
            ignore: [],
            rules: {
                
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
              
           
                

            },

            messages: {
           
               
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
             else if(element.hasClass("clinic_name")){
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

      });



   
  </script>
