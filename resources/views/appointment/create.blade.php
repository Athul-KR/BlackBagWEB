<form id="appointment_create_form" method="post" autocomplete="off">
    @csrf
    <div class="row mt-4">
        <div class="col-12">
            <div class="form-group form-outline form-dropdown mb-4">
                <label for="input" id="select_patient_label">Select Patient</label>
                <input id="patient_input" type="hidden" name="patient">
                <i class="fa-solid fa-circle-user"></i>
                <div class="dropdownBody">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle w-100" role="button" id="select_patient" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <div id="search_li">
                                @foreach ($patients as $patient)
                                <li id="{{$patient['user_uuid']}}" class="dropdown-item  select_patient_list" style="cursor:pointer">
                                    <div class="dropview_body profileList profileList-patient">
                                        <!-- <img src="{{asset('images/patient1.png')}}" class="img-fluid"> -->

                                        <p class="select_patient_item" data-id="{{$patient['id']}}">{{$patient['first_name']}} {{$patient['middle_name']}} {{$patient['last_name']}}</p>
                                    </div>
                                </li>
                                @endforeach

                                <li class="dropdown-item select_patient_list" id="nopatients" style="pointer-events: none; {{ empty($patients) ? 'display:block;' : 'display:none' }}">
                                    <div class="dropview_body profileList profileList-patient justify-content-center">
                                        <p>No patients found</p>

                                    </div>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor')
        <div class="col-12">
            <div class="d-inline-flex justify-content-end w-100 mb-4">
                <a onclick="createPatient('','frommodal')" class="primary fw-medium d-flex" ><span class="material-symbols-outlined"> add </span>Add New Patient</a>
            </div>
        </div>
        @endif
        <div class="col-md-6 col-12">
            <div class="form-group form-outline mb-4 date" id="datepicker">
                <label for="input" class="float-label">Appointment Date</label>
                <i class="material-symbols-outlined">calendar_clock</i>
                <input id="appt-date" type="text" name="appointment_date" class="form-control" @if(isset($selecteddate) && $selecteddate != '') value="<?php echo $selecteddate ?>" @endif>
            </div>
        </div>
        <!-- <div class="col-md-6 col-12">
            <div class="form-group form-outline mb-4 time" id="timepicker">
                <label for="input" class="float-label">Appointment Time</label>
                <i class="material-symbols-outlined">alarm</i>
                <input id="appt-time" type="text" name="appointment_time" class="form-control">
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
                    <option value="{{ $appointmentType['id'] }}" @if(isset($clinicDetails['appointment_type_id']) && $clinicDetails['appointment_type_id'] != '' && ($clinicDetails['appointment_type_id'] == '1' || $clinicDetails['appointment_type_id'] == '2') && $typeId == $appointmentType['id']) selected @endif>{{ $appointmentType['appointment_name'] }}</option>
                    @endforeach
                </select>
                <label class="select-label">Appointment Type</label>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Appointment Fee</label>
                <i class="material-symbols-outlined">attach_money</i>
                <input type="text" class="form-control" name="appointment_fee" id="appointment_fee">
                <!-- <input type="hidden" class="form-control" name="appointment_fee" id="appointment_fee"> -->
            </div>
        </div>
        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>

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
                                    </div>
                                </li>
                                @endforeach

                                @if (empty($doctors))
                                <li class="dropdown-item">
                                    <div class="dropview_body profileList justify-content-center">
                                        <p>No clinicians found</p>
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
            
            </div>
            <input type="hidden"class="appointment_timecls" name="appointment_time" id="selected-time">
        </div>

        <div class="col-12">
            <div class="form-group form-outline form-dropdown mb-4">
                <label for="input" id="select_nurse_label" class="float-label">Assign Nurse</label>
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

                                        <p class="select_nurse_item" data-id="{{$nurse['id']}}">{{$nurse['first_name']}} {{$nurse['last_name']}}</p>
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
                <textarea class="form-control" name="note" rows="4" cols="4"></textarea>
            </div>
        </div>

        <div class="col-12">
            <div class="btn_alignbox justify-content-end">
                <a href="#" data-bs-dismiss="modal" class="btn btn-outline-primary">Close</a>
                <button id="appt_btn" type="button" onclick="apptSubmit()" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>

</form>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
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
        // Initialize the date picker
        $('#appt-date').datetimepicker({
            format: 'MM/DD/YYYY',
            locale: 'en',
            useCurrent: true, // Prevents selecting the current date by default
            minDate: moment.tz(userTimeZone).startOf('day'), // Disable all past dates but allow today in UTC
        });
        // Listen for date change
        $('#appt-date').on('blur', function () {
          
            fetchAvailableSlots();
        });

        // Initialize the time picker
        $('#appt-time').datetimepicker({
            format: 'hh:mm A',
            locale: 'en',
            useCurrent: false, // Prevents setting current time by default
            stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
            timeZone: userTimeZone
        });

        var selectedValue = $('#appointment_type_id').val();
        if (selectedValue) {
            triggerAmount(); // Call function if value is prefilled
        }

    });
</script>


<script>
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
        $("#doctor_input").valid();
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



    //Validations
    // $(document).ready(function () {
    var form = $("#appointment_create_form");

    $(form).validate({
        ignore: [],
        rules: {
            patient: "required",
            appointment_date: {
                required: true,
                // futureDate: true,
            },
            appointment_time: {
                required: true,
            },
            // appointment_time: "required",
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
            },
            // appointment_time: "Please select appointment time",
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
            appointment_time: {
                required: 'Please select appointment time.',
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
            // Disable the submit button to prevent multiple clicks
            var submitButton = $(form).find("#appt_btn");
            submitButton.prop("disabled", true);
            submitButton.text("Submitting..."); // Optionally change button text

            // Submit the form

            // alert("hh");
            form.submit(); // Use native form submission

        },
        success: function(label) {
            // Remove the validation message when validation passes
            label.remove();
        },
    });
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

    // Custom method to check for future dates
    $.validator.addMethod(
        "futureDate",
        function(value, element) {
            const selectedDate = new Date(value);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Set hours to 0 for comparison
            return this.optional(element) || selectedDate > today;
        },
        "Please select a date in the future."
    );

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


    // $.validator.addMethod(
    //     "futureDateTime",
    //     function(value, element) {
    //         const appointmentDate = $("#appt-date").val();

    //         const appointmentTime = $("#appt-time").val();

    //         const selectedDateTime = new Date(
    //             `${appointmentDate}T${appointmentTime}`
    //         );
    //         const now = new Date();
    //         now.setSeconds(0, 0); // Set seconds and milliseconds to 0 for comparison

    //         return this.optional(element) || selectedDateTime > now;
    //     },
    //     "Please select a future date and time."
    // );
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
       if (!time) return -1;

        // Parse time in user's timezone
        var m = moment.tz(time, "hh:mm A", userTimeZone);
        if (!m.isValid()) return -1;

        return m.hours() * 60 + m.minutes();
    }

    function apptSubmit() {
        // var form = $("#appointment_create_form");
        // var submitButton = $(form).find("#appt_btn");


        // // Submit the form
        // if (form.valid()) {


        //     submitButton.prop("disabled", true);
        //     submitButton.text("Submitting..."); // Optionally change button text
        //     form.submit(); // Use native form submission
        // }

        if ($("#appointment_create_form").valid()) {

            var submitButton = $(form).find("#appt_btn");
            submitButton.prop("disabled", true);
            submitButton.text("Submitting..."); // Optionally change button text

            $.ajax({
                url: '{{ url("/appointments/store") }}',
                type: "post",
                data: {
                    'formdata': $("#appointment_create_form").serialize(),
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success == 1) {

                        swal(data.message, {
                            icon: "success",
                            text: data.message,
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                            // Refresh the page when the nurse clicks OK or closes the alert
                            window.location.reload();
                        });

                    } else {

                        swal(data.message, {
                            icon: "error",
                            text: data.message,
                            button: "OK",
                        });
                        submitButton.prop("disabled", false);
                        submitButton.text("Submit"); // Optionally change button text

                    }
                },
                error: function(xhr) {
                
                    handleError(xhr);
                },
            });
        }


    }

    $(document).on("click", ".close-modal", function() {
        $("#nurse-create-form").empty();
    });
    // });


    
            // Function to toggle the 'active' class


            function toggleLabel(input) {
            const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
            $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
        }

        $(document).ready(function () {
            // Initialize label state for each input
            $('input, textarea, select').each(function () {
                toggleLabel(this);
            });

            // Handle label toggle on focus, blur, and input change
            $(document).on('focus blur input change', 'input, textarea', function () {
                toggleLabel(this);
            });

            // Handle the datetime picker widget appearance by re-checking label state
            $(document).on('click', '.bootstrap-datetimepicker-widget', function () {
                const input = $(this).closest('.time').find('input');
                toggleLabel(input[0]);
            });

            // Trigger label toggle when modal opens
            $(document).on('shown.bs.modal', function (event) {
                const modal = $(event.target);
                modal.find('input, textarea').each(function () {
                    toggleLabel(this);
                    // Force focus briefly to trigger label in case of any timing issues
                    $(this).trigger('focus').trigger('blur');
                });
            });

            // Reset label state when modal closes
            $(document).on('hidden.bs.modal', function (event) {
                const modal = $(event.target);
                modal.find('input, textarea').each(function () {
                    $(this).parent().find('.float-label').removeClass('active');
                });
            });
        });



</script>