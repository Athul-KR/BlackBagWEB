<form id="appointment_create_form" method="post">
    <?php echo csrf_field(); ?>
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

                                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li id="<?php echo e($patient['clinic_user_uuid']); ?>" class="dropdown-item  select_patient_list" style="cursor:pointer">

                                    <div class="dropview_body profileList">
                                        <!-- <img src="<?php echo e(asset('images/patient1.png')); ?>" class="img-fluid"> -->

                                        <p class="select_patient_item" data-id="<?php echo e($patient['id']); ?>"><?php echo e($patient['name']); ?></p>

                                    </div>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php if($patients->isEmpty()): ?>
                                <li class="dropdown-item">

                                    <div class="dropview_body profileList justify-content-center">

                                        <p>No patients found</p>

                                    </div>

                                </li>
                                <?php endif; ?>

                            </div>


                        </ul>
                    </div>
                </div>
            </div>
        </div>


        
        <div class="col-md-6">
            <div class="form-group form-outline mb-4 date" id="datepicker">
                <label for="input" class="float-label">Appointment Date</label>
                <i class="material-symbols-outlined">calendar_clock</i>
                <input id="appt-date" type="text" name="appointment_date" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-outline mb-4 time" id="timepicker">
                <label for="input" class="float-label">Appointment Time</label>
                <i class="material-symbols-outlined">alarm</i>
                <input id="appt-time" type="text" name="appointment_time" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-outline form-dropdown mb-4">
                <label for="input" id="select_appointment_type_label">Appointment Type</label>
                <input type="hidden" name="appointment_type_id" id="appointment_type_input">
                <i class="material-symbols-outlined">assignment_turned_in</i>
                <div class="dropdownBody">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle w-100" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                        </a>
                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">

                            <?php $__currentLoopData = $appointmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointmentType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="dropdown-item select_appointment_type_list">
                                <div class="dropview_body">
                                    <p class="select_appointment_type_item  m-0" data-id="<?php echo e($appointmentType['id']); ?>"><?php echo e($appointmentType['appointment_name']); ?></p>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Appointment Fee</label>
                <i class="material-symbols-outlined">payments</i>
                <input type="text" class="form-control" name="appointment_fee">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group form-outline form-dropdown mb-4">
                <label for="input" id="select_doctor_label">Assign Doctor</label>
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
                                    <input id="search_doctor" name="search_doctor" class="form-control border-0 small" type="text" placeholder="Search Doctor" aria-label="Search" aria-describedby="basic-addon2">
                                </div>
                            </li>

                            <div id="search_li_doctor">

                                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li id="<?php echo e($doctor['clinic_user_uuid']); ?>" class="dropdown-item  select_doctor_list" style="cursor:pointer">

                                    <div class="dropview_body profileList">
                                        <!-- <img src="<?php echo e(asset('images/patient1.png')); ?>" class="img-fluid"> -->

                                        <p class="select_doctor_item" data-id="<?php echo e($doctor['id']); ?>"><?php echo e($doctor['name']); ?></p>

                                    </div>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php if($doctors->isEmpty()): ?>
                                <li class="dropdown-item">

                                    <div class="dropview_body profileList justify-content-center">

                                        <p>No doctors found</p>

                                    </div>

                                </li>
                                <?php endif; ?>

                            </div>


                        </ul>

                    </div>
                </div>
            </div>
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

                                <?php $__currentLoopData = $nurses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nurse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li id="<?php echo e($nurse['clinic_user_uuid']); ?>" class="dropdown-item  select_nurse_list" style="cursor:pointer">

                                    <div class="dropview_body profileList">
                                        <!-- <img src="<?php echo e(asset('images/patient1.png')); ?>" class="img-fluid"> -->

                                        <p class="select_nurse_item" data-id="<?php echo e($nurse['id']); ?>"><?php echo e($nurse['name']); ?></p>

                                    </div>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php if($nurses->isEmpty()): ?>
                                <li class="dropdown-item">

                                    <div class="dropview_body profileList justify-content-center">

                                        <p>No nurses found</p>

                                    </div>

                                </li>
                                <?php endif; ?>

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
<link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>">
<script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>

<script>
    $(document).ready(function() {
        // Initialize the date picker
        $('#appt-date').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false, // Prevents selecting the current date by default
            minDate: moment.utc().startOf('day'), // Disable all past dates but allow today in UTC
        });

        // Initialize the time picker
        $('#appt-time').datetimepicker({
            format: 'hh:mm A',
            useCurrent: false, // Prevents setting current time by default
            stepping: 15 // Optional: sets the minute interval (15 minutes in this case)
        });


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
            url: "<?php echo e(url('/appointment/search')); ?>" + "/" + type,
            data: {
                'search': searchData
            },
            success: function(response) {
                console.log(response);
                // Replace the dropdown items with the new HTML
                $('#search_li').html(response.view);
            },
            error: function(xhr) {
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
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
            url: "<?php echo e(url('/appointment/search')); ?>" + "/" + type,
            data: {
                'search': searchData
            },
            success: function(response) {
                console.log(response);
                // Replace the dropdown items with the new HTML
                $('#search_li_doctor').html(response.view);
            },
            error: function(xhr) {
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
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
            url: "<?php echo e(url('/appointment/search')); ?>" + "/" + type,
            data: {
                'search': searchData
            },
            success: function(response) {
                console.log(response);
                // Replace the dropdown items with the new HTML
                $('#search_li_nurse').html(response.view);
            },
            error: function(xhr) {
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
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
                greaterThanOrEqualToNow: true, // Updated method name
            },
            // appointment_time: "required",
            appointment_type_id: "required",
            appointment_fee: {
                required: true,
                amountCheck: true,
            },
            doctor: "required",
            nurse: "required",
            note: {
                // required: true,
                maxlength: 700,
            },
        },
        messages: {
            patient: "Please select a patient",
            appointment_date: {
                required: "Please select appointment date",
            },
            // appointment_time: "Please select appointment time",
            appointment_type_id: "Please select an appointment type",
            appointment_fee: {
                required: "Please enter appointment fees",
                digits: "Please enter a valid number",
            },
            doctor: "Please select a doctor",
            nurse: "Please select a nurse",
            note: {
                maxlength: "Minimum characters allowed is 700",
            },
            appointment_time: {
                required: 'Please select appointment time.',
                greaterThanOrEqualToNow: 'Appointment time must be greater than current time.',
            },
            department: "Please enter department",
            qualification: "Please enter qualification",
            specialties: "Please enter specialty",
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
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
        console.log('start');
        if ($('#appt-time').val() == '') return true; // Allow if empty
        if ($('#appt-date').val() == '') return true; // Allow if empty
        var startdate = $('#appt-date').val();
        var currentDate = moment.utc().format('MM/DD/YYYY');
        console.log(currentDate);
        var start = timeToInt($('#appt-time').val());
        var now = moment.utc(); // Get current UTC time
        var currentTime = now.hours() * 60 + now.minutes(); // Convert current UTC time to total minutes

        if (startdate === currentDate) {
            if (start == -1) {
                return false; // Invalid start time
            }

            if (start < currentTime) { // Check if start time is less than current time
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
    function timeToInt(time) {
        var now = moment.utc(); // Get current UTC time
        var dt = now.format("MM/DD/YYYY") + " " + time; // Combine current UTC date with the provided time
        var d = moment.utc(dt, "MM/DD/YYYY hh:mm A"); // Parse the date and time in UTC
        if (!d.isValid()) {
            return -1; // Return -1 for invalid time
        }
        return d.hours() * 60 + d.minutes(); // Convert to total minutes
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
                url: '<?php echo e(url("/appointment/store")); ?>',
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
                            button: "OK",
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
                }
            });
        }


    }

    $(document).on("click", ".close-modal", function() {
        $("#nurse-create-form").empty();
    });
    // });


    // floating label end
</script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/appointment/create.blade.php ENDPATH**/ ?>