<?php
            $corefunctions = new \App\customclasses\Corefunctions;
        ?>
        <div>
            <div class="text-start mb-3">           
                <h4 class="fw-bold mb-0 primary">Reschedule Appointment</h4>
                <small class="gray fw-light">Select a new date and time for your appointment.</small>
            </div>
            <div class="border rounded-4 p-3">
                <form id="appointment_create_form"  method="post" action="" autocomplete="off">
                    @csrf
                    <input type="hidden" id="appointment_id" name="appointment_id">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-3">
                                <p class="mb-0 d-flex justify-content-between min-w-tag fw-light me-1"><span>Clinician</span> <span>: </span> </p>
                                <div class="user_inner">
                                    <img alt="Blackbag" @if($clinicUserDoctor['logo_path'] !='') src="{{$clinicUserDoctor['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif>
                                    <div class="user_info">  
                                        <h6 class="mb-0 fw-medium"> <?php echo $corefunctions->showClinicanName($clinicUserDoctor,'1'); ?> </h6>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($clinicUserNurse))
                            <div class="d-flex align-items-center mb-3">
                                <p class="mb-0 d-flex justify-content-between min-w-tag fw-light me-2"><span>Nurse</span> <span>: </span> </p>
                                <div class="user_inner">
                                    <img alt="Blackbag" @if($clinicUserNurse['logo_path'] !='') src="{{$clinicUserNurse['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif> 
                                    <div class="user_info">  
                                        <h6 class="mb-0 fw-medium"> {{ $clinicUserNurse['name']}} </h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="d-flex align-items-center mb-3">
                                <p class="mb-0 d-flex justify-content-between min-w-tag fw-light me-2"><span>Patient</span> <span>: </span> </p>
                                <div class="user_inner">
                                    <img alt="Blackbag"  @if($patientDetails['logo_path'] !='') src="{{$patientDetails['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif>
                                    <div class="user_info">  
                                        <h6 class="mb-0 fw-medium">{{$patientDetails['first_name']}} {{$patientDetails['last_name']}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group form-outline mb-3 dateclserrr">
                                <label for="appt-date-reschedule" class="float-label">Date</label>
                                <i class="material-symbols-outlined">calendar_today</i>
                                <input type="text" class="form-control datecls" id="appt-date-reschedule" name="appointment_date"  value="<?php echo $corefunctions->timezoneChange($appointment->appointment_date,"m/d/Y") ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group form-outline timeclserrr">
                                <label for="appt-time-reschedule" class="float-label">Time</label>
                                <i class="material-symbols-outlined">schedule</i>
                                <input type="text" class="form-control timecls" id="appt-time-reschedule" name="appointment_time" value="<?php echo $corefunctions->timezoneChange($appointment->appointment_time,"h:i:A") ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
                <div class="btn_alignbox justify-content-end mt-3">
                    <a class="btn btn-outline" data-bs-dismiss="modal">Cancel</a>
                    <a onclick="submitReschedule('{{$appointment->appointment_uuid}}')" id="reschedulebtn" class="btn btn-primary">Reschedule</a>
                </div>




<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<!-- <script src="{{asset('js/appointmentValidation.js')}}"></script> -->
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script>



    // floating label start

    $(document).ready(function() {

        //    // Initialize the date picker
        //    $('#appt-date').datetimepicker({
        //     format: 'MM/DD/YYYY',
        //     locale: 'en',
        //     useCurrent: true, // Prevents selecting the current date by default
        //     minDate: moment.tz(userTimeZone).startOf('day'), // Disable all past dates but allow today in UTC
        // });

        // // Initialize the time picker
        // $('#appt-time').datetimepicker({
        //     format: 'hh:mm A',
        //     locale: 'en',
        //     useCurrent: false, // Prevents setting current time by default
        //     stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
        //     timeZone: userTimeZone
        // });

        var form = $("#appointment_create_form");
        var isSubmitting = false; 
        var url = "{{route('appointment.update')}}";
        var formData = $("#appointment_create_form").serialize();
        console.log("Form Data" + formData);

        $(form).validate({
            ignore: [],
            rules: {
              
                appointment_date: {
                    required: true,
                    futureDateTime: true,
                },
                appointment_time: {
                    required: true,
                    greaterThanOrEqualToNow: true, // Updated method name
                },
                
            },
            messages: {
              
                appointment_date: {
                    required: "Please select appointment date.",
                    futureDateTime: "Please select future date.",
                },
                appointment_time: {
                    required: 'Please select appointment time.',
                    greaterThanOrEqualToNow: 'Appointment time must be greater than current time.',
                },
               
            },
            errorPlacement: function(error, element) {
                    // if(element.hasClass("datecls")){
                    //     error.insertAfter(".dateclserr");
                    // }else if(element.hasClass("timecls")){
                    //     error.insertAfter(".timeclserr");
                    // }else{
                    //     error.insertAfter(element);
                    // }
                    error.insertAfter(element);
                
            },
            submitHandler: function(form) {
                if (isSubmitting) return false; // Prevents multiple clicks
                  isSubmitting = true;
                // Disable the submit button to prevent multiple clicks
                var submitButton = $(form).find("#appt_btn");
                submitButton.prop("disabled", true);
                submitButton.text("Submitting..."); // Optionally change button text

                // Submit the form
                if (form.valid()) {
                    // alert("hh");
                    form.submit(); // Use native form submission
                }
            },
            success: function(label) {
                // Remove the validation message when validation passes
                label.remove();
            },
        });

     

        // Custom method to check if appointment time is greater than or equal to current UTC time
        jQuery.validator.addMethod("greaterThanOrEqualToNow", function(value, element) {
            var startdate = $('#appt-date-reschedule').val();
            var currentDate = moment.tz(userTimeZone).format('MM/DD/YYYY'); // Current date in the user's timezone
            console.log(currentDate);

            var start = timeToInt($('#appt-time-reschedule').val());

            // Get the current time in the user's timezone
            var now = moment.tz(userTimeZone); 
            var currentTime = now.hours() * 60 + now.minutes(); // Convert current time to total minutes in the chosen timezone
            console.log(currentTime);
            console.log(start);

            // Compare the appointment date with the current date
            if (startdate === currentDate) {
                if (start == -1) {
                    return false; // Invalid start time
                }

                if (start < currentTime) { // Check if the start time is less than current time in the chosen timezone
                    return false; // Invalid
                }
            }
            return true; // Valid
        }, 'Appointment time must be greater than current time.');

        // Custom method to check if appointment time is greater than or equal to current UTC time
        jQuery.validator.addMethod("futureDateTime", function(value, element) {

            if ($('#appt-date-reschedule').val() == '') return true; // Allow if empty
    
            // Get the start date from the input
            var startdate = moment($('#appt-date-reschedule').val(), 'MM/DD/YYYY');

            // Get the current date and time in user's timezone
            var currentDate = moment.tz(userTimeZone).startOf('day'); // Only compare the date, ignoring the time

            // Compare the start date with the current date
            if (startdate.isBefore(currentDate, 'day')) {
                return false; // Invalid if the start date is before the current date
            }
            return true; // Valid if the start date is the same or after current date
        }, 'Appointment time must be greater than current time.');


        $('#appt-date-reschedule').datetimepicker({
            format: 'MM/DD/YYYY',
            locale: 'en',
            useCurrent: false, // So it doesn't auto-select today's date
     
        });

        // Pre-fill the date picker with the appointment date if it exists
        var appointmentDate = $('#appt-date-reschedule').val();
        if (appointmentDate) {
            // Set the date using the same format as defined in the datetimepicker
            $('#appt-date-reschedule').data("DateTimePicker").date(moment(appointmentDate, 'MM/DD/YYYY'));
        }

        // Initialize the time picker
        $('#appt-time-reschedule').datetimepicker({
            format: 'hh:mm A',
            useCurrent: false, // Prevents setting current time by default
            stepping: 5 // Optional: sets the minute interval (5 minutes in this case)
        });


    });

  
    function timeToInt(time) {
        var now = moment.utc(); // Get current UTC time
        var dt = now.format("MM/DD/YYYY") + " " + time; // Combine current UTC date with the provided time
        var d = moment.utc(dt, "MM/DD/YYYY hh:mm A"); // Parse the date and time in UTC
        if (!d.isValid()) {
            return -1; // Return -1 for invalid time
        }
        return d.hours() * 60 + d.minutes(); // Convert to total minutes
    }

    //End Date Picker and Time picker


    function submitReschedule(key) {
        var form = $("#appointment_create_form");
        if (!form.valid()) {
            return false;
        }
        
        var url = "{{route('reschedule.store')}}";
        var formData = $("#appointment_create_form").serialize();
        $("#reschedulebtn").addClass('disabled');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'appointment_uuid' :key,
                formData: formData,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                if (response.success == 1) {
                    swal({
                        title: "Success!",
                        text: "Appointment rescheduled successfully",
                        icon: "success",
                        buttons: false,
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    $("#reschedulebtn").removeClass('disabled');
                    swal({
                        title: "Error!",
                        text: response.message || "Failed to reschedule appointment",
                        icon: "error",
                        buttons: false,
                        timer: 2000
                    });
                }
            },
            error: function(xhr) {
                handleError(xhr);
            }
        });
    }


      // Function to toggle the 'active' class

      function toggleLabel(input) {
    const $input = $(input);
    const hasValueOrFocus = $.trim($input.val()) !== '' || $input.is(':focus');
    $input.siblings('.float-label').toggleClass('active', hasValueOrFocus);
}

$(document).ready(function () {
    // Initialize labels for inputs on page load
    $('input, textarea').each(function () {
        toggleLabel(this);
    });

    // Handle focus, blur, input, and change events
    $(document).on('focus blur input change', 'input, textarea', function () {
        toggleLabel(this);
    });

    // Handle Date Range Picker value update
    $('#dateRange').on('apply.daterangepicker', function () {
        setTimeout(() => toggleLabel(this), 10); // Ensure label updates after value is set
    });

    // Ensure label stays active even if value is updated manually
    $('#dateRange').on('change', function () {
        setTimeout(() => toggleLabel(this), 10);
    });

    // Handle clearing of date (if cancel is used)
    $('#dateRange').on('cancel.daterangepicker', function () {
        setTimeout(() => toggleLabel(this), 10);
    });

    // Ensure floating label updates after the input loses focus
    $(document).on('blur', '#dateRange', function () {
        setTimeout(() => toggleLabel(this), 10);
    });
});




</script>

