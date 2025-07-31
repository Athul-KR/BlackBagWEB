<form id="appointment_create_form" method="post" action="{{route('appointment.update')}}" autocomplete="off">
    @csrf
    <div class="row mt-4">
        <div class="col-12">
            <!-- Appointment uuid Hidden field -->
            <input type="hidden" name="appointment_uuid" value="{{$appointment->appointment_uuid}}">
            <div class="form-group form-outline form-dropdown mb-4">
                <label for="input" id="select_patient_label">Select Patient</label>
                <input id="patient_input" type="hidden" name="patient">
                <i class="fa-solid fa-circle-user"></i>
                <div class="dropdownBody">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle w-100" role="button" id="select_patient" data-bs-toggle="dropdown" aria-expanded="false" >
                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                        </a>
                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                            <li class="dropdown-item">
                                <div class="form-outline input-group ps-1">
                                    <div class="input-group-append">
                                        <button class="btn border-0" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                    <input id="search_patient" name="search_patient" class="form-control border-0 small" type="text" placeholder="Search Patient" aria-label="Search" aria-describedby="basic-addon2">
                                </div>
                            </li>

                            <input type="hidden" name="status" value="{{$status}}">

                            <input type="hidden" name="user_type" value="{{$userType}}">


                            <input type="hidden" name="type" value="{{$type}}">


                            <div id="search_li" @if($appointment->is_paid == '1') style="display:none;" @endif>

                                @foreach ($patients as $patient)
                                <li id="{{$patient['user_uuid']}}" class="dropdown-item  select_patient_list" @if($appointment->is_paid == '1') style="cursor:not-allowed; pointer-events:none; opacity:0.6" @else style="cursor:pointer" @endif>

                                    <div class="dropview_body profileList">
                                        <!-- <img src="{{asset('images/patient1.png')}}" class="img-fluid"> -->

                                        <p class="select_patient_item" data-id="{{$patient['id']}}">{{$patient['first_name']}} {{$patient['last_name']}}</p>

                                        @if ($appointment->patient_id == $patient['id'])
                                        <input id="patient-id" type="hidden" value="{{$patient['id']}}" data-content="{{$patient['first_name']}}{{$patient['last_name']}}">
                                        @endif
                                    </div>
                                </li>
                                @endforeach

                                @if (empty($patients))
                                <li class="dropdown-item">
                                    <div class="dropview_body profileList justify-content-center">
                                        <p>No patients found</p>
                                    </div>
                                </li>
                                @endif
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="col-12">
            <div class="mb-4">
                <a href="#" class="primary fw-medium d-flex justify-content-end" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#addPatientModal"><span class="material-symbols-outlined"> add </span>Add New Patient</a>
            </div>
        </div> --}}
        <?php
            $corefunctions = new \App\customclasses\Corefunctions;
        ?>
        <div class="col-md-6 col-12">
            <div class="form-group form-outline mb-4 date" id="datepicker">
                <label for="input" class="float-label">Appointment Date</label>
                <i class="material-symbols-outlined">calendar_clock</i>
                <input id="appt-date" type="text" name="appointment_date" value="<?php echo $corefunctions->timezoneChange($appointment->appointment_date,"m/d/Y") ?>" class="form-control" placeholder="">
            </div>
        </div>
        <!-- <div class="col-md-6 col-12">
            <div class="form-group form-outline mb-4 time" id="timepicker">
                <label for="input" class="float-label">Appointment Time</label>
                <i class="material-symbols-outlined">alarm</i>
                <input id="appt-time" type="text" name="appointment_time" value="<?php echo $corefunctions->timezoneChange($appointment->appointment_time,"h:i:A") ?>" class=" form-control">
            </div>
        </div> -->
        <div class="col-12 col-lg-6">
            <div class="form-group form-floating mb-4">
                <i class="material-symbols-outlined">assignment_turned_in</i>
                <select name="appointment_type_id" id="appointment_type_id" class="form-select @if(isset($clinicDetails['appointment_type_id']) && $clinicDetails['appointment_type_id'] != '' && ($clinicDetails['appointment_type_id'] == '1' || $clinicDetails['appointment_type_id'] == '2')) disabled @endif" onchange="triggerAmount();">
                    @if(isset($clinicDetails['appointment_type_id']) && $clinicDetails['appointment_type_id'] != '')
                        @php
                            $typeId = $clinicDetails['appointment_type_id'];
                        @endphp
                    @endif
                    <option value="">Select Appointment Type</option>
                    @foreach ($appointmentTypes as $appointmentType)
                    <option value="{{ $appointmentType['id'] }}" @if($appointment->appointment_type_id == $appointmentType['id']) selected @endif>{{ $appointmentType['appointment_name'] }}</option>
                    @endforeach
                </select>
                <label class="select-label">Appointment Type</label>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group form-outline non-editable mb-4">
                <label for="input" class="float-label">Appointment Fee</label>
                <i class="material-symbols-outlined">attach_money</i>
                <!-- <input type="hidden" class="form-control" value="{{ $appointment->appointment_fee ? number_format($appointment->appointment_fee, 0) : '' }}" class="form-control" name="appointment_fee" id="appointment_fee"> -->

                <input type="text" value="{{ $appointment->appointment_fee ? $appointment->appointment_fee : '' }}" class="form-control" name="appointment_fee" id="appointment_fee" @if($appointment->is_paid == '1') readonly @endif>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group form-outline form-dropdown mb-4">
                <label for="input" id="select_doctor_label">Assign Clinician</label>
                <i class="material-symbols-outlined">stethoscope</i>
                <input id="doctor_input" type="hidden" name="doctor">
                <div class="dropdownBody">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                        </a>
                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                            <li class="dropdown-item">
                                <div class="form-outline input-group ps-1">
                                    <div class="input-group-append">
                                        <button class="btn border-0" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                    <input id="search_doctor" name="search_doctor" class="form-control border-0 small" type="text" placeholder="Search Clinician" aria-label="Search" aria-describedby="basic-addon2">
                                </div>
                            </li>
                            <div id="search_li_doctor">
                                @foreach ($doctors as $doctor)
                                <li id="{{$doctor['user_uuid']}}" class="dropdown-item  select_doctor_list" style="cursor:pointer">
                                    <div class="dropview_body profileList">
                                        <!-- <img src="{{asset('images/patient1.png')}}" class="img-fluid"> -->
                                        <p class="select_doctor_item" data-id="{{$doctor['userID']}}">{{ $corefunctions -> showClinicanNameUser($doctor,'1');}}</p>

                                        @if ($appointment->consultant_id==$doctor['userID'])
                                        <input id="doctor-id" type="hidden" value="{{$doctor['userID']}}" data-content="{{ $corefunctions -> showClinicanNameUser($doctor,'1');}}">
                                        @endif
                                    </div>
                                </li>
                                @endforeach

                                @if (empty($doctors))
                                <li class="dropdown-item">
                                    <div class="dropview_body profileList justify-content-center">
                                        <p>No doctors found</p>
                                    </div>
                                </li>
                                @endif
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div id="append_timeslots">
                @include('frontend.appendtimeslots')
            </div>
            <input type="hidden" class="appointment_timecls"name="appointment_time" id="selected-time" value="<?php echo $corefunctions->timezoneChange($appointment->appointment_time,"h:i:A") ?>">
        </div>

        <div class="col-12">
            <div class="form-group form-outline form-dropdown mb-4">
                <label for="input" id="select_nurse_label">Assign Nurse</label>
                <i class="material-symbols-outlined">clinical_notes</i>
                <input id="nurse_input" type="hidden" name="nurse">

                <div class="dropdownBody">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                        </a>
                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                            <li class="dropdown-item">
                                <div class="form-outline input-group ps-1">
                                    <div class="input-group-append">
                                        <button class="btn border-0" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                    <input id="search_nurse" name="search_nurse" type="text" class="form-control border-0 small" placeholder="Search nurses" aria-label="Search" aria-describedby="basic-addon2">
                                </div>
                            </li>
                            <div id="search_li_nurse">

                                @foreach ($nurses as $nurse)
                                <li id="{{$nurse['user_uuid']}}" class="dropdown-item  select_nurse_list" style="cursor:pointer">

                                    <div class="dropview_body profileList">
                                        <!-- <img src="{{asset('images/patient1.png')}}" class="img-fluid"> -->
                                        <p class="select_nurse_item" data-id="{{$nurse['id']}}">{{$nurse['first_name']}}</p>
                                        @if ($appointment->nurse_id == $nurse['id'])
                                        <input id="nurse-id" type="hidden" value="{{$nurse['id']}}" data-content="{{$nurse['first_name']}}">
                                        <input id="nurse_uuid" name="nurse_uuid" type="hidden" value="{{$nurse['user_uuid']}}">
                                        @endif
                                    </div>
                                </li>
                                @endforeach

                                @if (empty($nurses))
                                <li class="dropdown-item">
                                    <div class="dropview_body profileList justify-content-center">
                                        <p>No nurses found</p>
                                    </div>
                                </li>
                                @endif
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group form-outline form-textarea mb-4">
                <label for="input" class="float-label">Notes</label>
                <i class="fa-solid fa-file-lines"></i>
                <textarea class="form-control" name="note" rows="4" cols="4">{{$appointment->notes}}</textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="btn_alignbox justify-content-end">
                <a href="#" data-bs-dismiss="modal" class="btn btn-outline-primary">Close</a>
                <button type="submit" id="appt_btn" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>

</form>


<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<!-- <script src="{{asset('js/appointmentValidation.js')}}"></script> -->
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script>
      $(document).on('click', '.slot-btn', function () {
            $('.slot-btn').removeClass('active');
            $(this).addClass('active');
            let selectedTime = $(this).text().trim();
            $('#selected-time').val(selectedTime);
            $('#selected-time').valid();
     });
     $('#appointment_fees').on('input', function () {
        let inputValue = $(this).val(); // Get the current input value
        // Remove any non-numeric characters except the period
        let rawValue = inputValue.replace(/[^0-9.]/g, '');
        let parsedValue = parseFloat(rawValue);
        console.log(parsedValue)
        if (!isNaN(parsedValue)) {
            // Format the visible input field
            $(this).val(`$${parsedValue.toFixed(2)}`);
            // Set the hidden input to the numeric value only
            $('#appointment_fee').val(parsedValue.toFixed(2));
        } else {
            // Clear the inputs if the value is invalid
            $(this).val('');
            $('#appointment_fee').val('');
        }
    });
    $(document).ready(function() {
        
        //setting nurse on document loads
        var nurseId = $('#nurse-id').val();
        var nurseName = $('#nurse-id').data('content');
        $('#select_nurse_label').text(nurseName);
        $('#nurse_input').val(nurseId);

        //setting doctor on document loads
        var doctorId = $('#doctor-id').val();
        var doctorName = $('#doctor-id').data('content');
        $('#select_doctor_label').text(doctorName);
        $('#doctor_input').val(doctorId);

        //setting patient on document loads
        var patientId = $('#patient-id').val();
        var patientName = $('#patient-id').data('content');
        $('#select_patient_label').text(patientName);
        $('#patient_input').val(patientId);

        //setting appointment type on document loads
        var appointment_typeId = $('#appointment_type-id').val();
        var appointment_typeName = $('#appointment_type-id').data('content');
        $('#select_appointment_type_label').text(appointment_typeName);
        $('#appointment_type_input').val(appointment_typeId);

        var selectedValue = $('#appointment_type_id').val();
        if (selectedValue) {
            // triggerAmount(); // Call function if value is prefilled
        }

    });

    //Patient Dropdown Section
    $(document).on('click', '.select_patient_list', function() {

        var patientItem = $(this).find('.select_patient_item').text();
        var patientId = $(this).find('.select_patient_item').data('id');
        $('#select_patient_label').text(patientItem);
        $('#patient_input').val(patientId);
         $("#patient_input").valid();

    })

    //Patient Search Section
    $('#search_patient').on('keyup', function() {

        var type = 'patient';
        var searchData = $('#search_patient').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "{{url('/appointments/search')}}" + "/" + type,
            data: {
                'search': searchData
            },
            success: function(response) {
                console.log(response);
                // Replace the dropdown items with the new HTML
                $('#search_li').html(response.view);
            },
            error: function(xhr) {
               
                handleError(xhr);
           },
        })

    })


    //Appointment Type Section
    $(document).on('click', '.select_appointment_type_list', function() {

        var appointmentTypeItem = $(this).find('.select_appointment_type_item').text();
        var appointmentTypeId = $(this).find('.select_appointment_type_item').data('id');
        $('#select_appointment_type_label').text(appointmentTypeItem);
        $('#appointment_type_input').val(appointmentTypeId);
        $("#appointment_type_input").valid();

    })



    //Doctor Section
    $(document).on('click', '.select_doctor_list', function() {

        var doctorItem = $(this).find('.select_doctor_item').text();
        var doctorId = $(this).find('.select_doctor_item').data('id');
        $('#select_doctor_label').text(doctorItem);
        $('#doctor_input').val(doctorId);
        fetchAvailableSlots();

    })


    //Doctor Search Section
    $('#search_doctor').on('keyup', function() {

        var type = 'doctor';
        var searchData = $('#search_doctor').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "{{url('/appointments/search')}}" + "/" + type,
            data: {
                'search': searchData
            },
            success: function(response) {
                console.log(response);
                // Replace the dropdown items with the new HTML
                $('#search_li_doctor').html(response.view);
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        })

    })


    //Nurse Section
    $(document).on('click', '.select_nurse_list', function() {

        var nurseItem = $(this).find('.select_nurse_item').text();
        var nurseId = $(this).find('.select_nurse_item').data('id');
        $('#select_nurse_label').text(nurseItem);
        $('#nurse_input').val(nurseId);
        $("#nurse_input").valid();
    })


    //Nurse Search Section
    $('#search_nurse').on('keyup', function() {

        var type = 'nurse';
        console.log(type);

        var searchData = $('#search_nurse').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "{{url('/appointments/search')}}" + "/" + type,
            data: {
                'search': searchData
            },
            success: function(response) {
                console.log(response);
                // Replace the dropdown items with the new HTML
                $('#search_li_nurse').html(response.view);
            },
            error: function(xhr) {
               
                handleError(xhr);
           },
        })

    })

    // floating label start

    $(document).ready(function() {
       
        var form = $("#appointment_create_form");
        var isSubmitting = false; 
        var url = "{{route('appointment.update')}}";
        var formData = $("#appointment_create_form").serialize();
        console.log("Form Data" + formData);

        $(form).validate({
            ignore: [],
            rules: {
                patient: "required",
                appointment_date: {
                    required: true,
                    futureDateTime: true,
                },
                appointment_time: {
                    required: true,
                },
                appointment_type_id: "required",
                appointment_fee: {
                    required: true,
                    amountCheck: true,
                    greaterThanTen: true,
                },
                doctor: "required",
                nurse: "required",
                note: {
                    // required: true,
                    maxlength: 700,
                },
            },
            messages: {
                patient: "Please select a patient.",
                appointment_date: {
                    required: "Please select appointment date.",
                    futureDateTime: "Please select future date.",
                },
                appointment_time: {
                    required: 'Please select appointment time.',
                },
                appointment_type_id: "Please select an appointment type.",
                appointment_fee: {
                    required: "Please enter appointment fees.",
                    digits: "Please enter a valid number.",
                    greaterThanTen: "Please enter 0 or an amount greater than or equal to 10.",
                },
                doctor: "Please select a clinician.",
                nurse: "Please select a nurse.",
                note: {
                    maxlength: "Minimum characters allowed is 700.",
                },
                department: "Please enter department.",
                qualification: "Please enter qualification.",
                specialties: "Please enter specialty.",
            },
            errorPlacement: function(error, element) {
             
                if (element.hasClass("appointment_timecls")) {
                    // Insert error message after the correct element
                    error.insertAfter(".validationtime");
                }else{
                    error.insertAfter(element);
                }
                
                
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

        // Custom method to check for amount check
        $.validator.addMethod(
            "amountCheck", // Custom method name
            function(value, element) {
                // Regular expression for amount validation
                var regex = /^(?!0\d)(\d{1,3}(,\d{3})*|\d+)(\.\d{2,10})?$/;

                // Check if the value is optional or matches the regex
                return this.optional(element) || regex.test(value);
            },
            "Please enter a valid amount."
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

        // Custom method to check if appointment time is greater than or equal to current UTC time
        jQuery.validator.addMethod("greaterThanOrEqualToNow", function(value, element) {
            var startdate = $('#appt-date').val();
            var currentDate = moment.tz(userTimeZone).format('MM/DD/YYYY'); // Current date in the user's timezone
            console.log(currentDate);

            var start = timeToInt($('#selected-time').val());

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

            if ($('#appt-date').val() == '') return true; // Allow if empty
    
            // Get the start date from the input
            var startdate = moment($('#appt-date').val(), 'MM/DD/YYYY');

            // Get the current date and time in user's timezone
            var currentDate = moment.tz(userTimeZone).startOf('day'); // Only compare the date, ignoring the time

            // Compare the start date with the current date
            if (startdate.isBefore(currentDate, 'day')) {
                return false; // Invalid if the start date is before the current date
            }
            return true; // Valid if the start date is the same or after current date
        }, 'Appointment time must be greater than current time.');


        $(document).on("click", ".close-modal", function() {
            $("#nurse-create-form").empty();
        });

        $('#appt-date').on('blur', function () {
          
            fetchAvailableSlots();
        });

        // Initialize the date picker
        $('#appt-date').datetimepicker({
            format: 'MM/DD/YYYY',
            locale: 'en',
            // minDate: moment().startOf('day'),
        });

        // Pre-fill the date picker with the appointment date if it exists
        var appointmentDate = $('#appt-date').val();
        if (appointmentDate) {
            // Set the date using the same format as defined in the datetimepicker
            $('#appt-date').data("DateTimePicker").date(moment(appointmentDate, 'MM/DD/YYYY'));
        }

        // Initialize the time picker
        $('#appt-time').datetimepicker({
            format: 'hh:mm A',
            useCurrent: false, // Prevents setting current time by default
            stepping: 5 // Optional: sets the minute interval (5 minutes in this case)
        });


    });

    function triggerAmount(){
        var type = $("#appointment_type_id").val();
        var patientId = $("#patient_input").val();
        $.ajax({
            url: '{{ url("/appointments/triggeramount") }}',
            type: "post",
            data: {
                'type': type,
                'patientId': patientId,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#appointment_fee").val(data.amount);
                    $('input, textarea, select').each(function () {
                        toggleLabel(this);
                    });
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }

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


    function update() {

        var form = $("#appointment_create_form");
        form.vaild();
        var url = "{{route('appointment.update')}}";
        var formData = $("#appointment_create_form").serialize();
        console.log("Form Data" + formData);


        $.ajax({
            type: "POST",
            url: url,
            data: {
                data: formData,
            },

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
                // Populate form fields with the logger details
                if (response.success == 1) {
                    console.log(response);
                } else {
                    console.log(response);

                    swal(
                        "Deleted!",
                        "The nurse has been deleted successfully",
                        "success"
                    ).then(() => {
                        // Refresh the page when the nurse clicks OK or closes the alert
                        window.location.href = "url('users')}}";
                    });
                }

            },
            error: function(xhr) {
               
                handleError(xhr);
            },
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

