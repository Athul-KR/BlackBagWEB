<form method="post" id="business_hours_form">
    <?php if(isset($businessHours) && count($businessHours) > 0): ?>
        <?php $__currentLoopData = $businessHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessHour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-12">
                <div class="row align-items-center mb-3">
                    <div class="col-2">
                        <h6><?php echo e($businessHour['day']); ?></h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input isopen" type="checkbox" id="<?php echo e($businessHour['day']); ?>"
                                name="businessHours[<?php echo e($businessHour['day']); ?>][is_open]" value="1"
                                <?php if(($businessHour['is_open']) == 1): ?> checked <?php endif; ?>>
                        </div>
                    </div>
                    <!-- hidden field -->
                    <input type="hidden" name="businessHours[<?php echo e($businessHour['day']); ?>]['bussinesshour_uuid']"
                        value="<?php echo e($businessHour['bussinesshour_uuid'] ?? ''); ?>">

                    <div class="col-5">
                        <div class="form-group form-outline">
                            <label class="float-label">Opening Time</label>
                            <i class="material-symbols-outlined">alarm</i>
                            <input type="text" class="form-control start_time" id="<?php echo e($businessHour['day']); ?>-start_time"
                                name="businessHours[<?php echo e($businessHour['day']); ?>][start_time]"
                                value="<?php echo e($businessHour['start_time'] ?? ''); ?>">
                        </div>
                        <div class="invalid-feedback" id="<?php echo e($businessHour['day']); ?>-start_time-error"></div>
                    </div>
                    <div class="col-5">
                        <div class="form-group form-outline">
                            <label class="float-label">Closing Time</label>
                            <i class="material-symbols-outlined">alarm</i>
                            <input type="text" class="form-control end_time" id="<?php echo e($businessHour['day']); ?>-end_time"
                                name="businessHours[<?php echo e($businessHour['day']); ?>][end_time]"
                                value="<?php echo e($businessHour['end_time'] ?? ''); ?>">
                        </div>
                        <div class="invalid-feedback" id="<?php echo e($businessHour['day']); ?>-end_time-error"></div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="btn_alignbox justify-content-end">
        <a data-bs-dismiss="modal" class="btn btn-outline-primary">Close</a>
        <button type="button" id="avail_submit" onclick="updateHours()" class="btn btn-primary">Save Changes</button>
    </div>
</form>

<link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>">
<script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>
<script>
    $(document).ready(function () {



        $('.isopen').each(function () {
            var checkbox = $(this);
            var day = checkbox.attr('id'); // Get the day directly from the checkbox id
            var startTimeInput = $('#' + day + '-start_time'); // Related opening time input
            var endTimeInput = $('#' + day + '-end_time'); // Related closing time input

            // On page load, check if the checkbox is checked and enable the inputs
            if (checkbox.prop('checked')) {
                startTimeInput.prop('disabled', false);
                endTimeInput.prop('disabled', false);

                // Initialize time picker for start and end time inputs
                startTimeInput.datetimepicker({
                    format: 'hh:mm A',
                    useCurrent: false,
                    stepping: 10
                });

                endTimeInput.datetimepicker({
                    format: 'hh:mm A',
                    useCurrent: false,
                    stepping: 10
                });


            } else {
                startTimeInput.prop('disabled', true);
                endTimeInput.prop('disabled', true);
            }

            // Handle change event when the checkbox is toggled
            checkbox.change(function () {
                if ($(this).prop('checked')) {
                    startTimeInput.prop('disabled', false);
                    endTimeInput.prop('disabled', false);

                    // Initialize datetimepicker if checked
                    startTimeInput.datetimepicker({
                        format: 'hh:mm A',
                        useCurrent: false,
                        stepping: 10
                    });

                    endTimeInput.datetimepicker({
                        format: 'hh:mm A',
                        useCurrent: false,
                        stepping: 10
                    });
                } else {
                    startTimeInput.prop('disabled', true);
                    endTimeInput.prop('disabled', true);
                    startTimeInput.val(null);
                    endTimeInput.val(null);

                    // Optionally, destroy the datetimepicker if you want to clear it
                    startTimeInput.datetimepicker('destroy');
                    endTimeInput.datetimepicker('destroy');
                }

            });

            // Remove validation message and reset styling when user corrects the input
            startTimeInput.on('input change', function () {
                if (startTimeInput.val()) {
                    startTimeInput.removeClass('is-invalid');
                    $('#' + day + '-start_time-error').text('').hide();
                }
            });

            endTimeInput.on('input change', function () {
                if (endTimeInput.val()) {
                    endTimeInput.removeClass('is-invalid');
                    $('#' + day + '-end_time-error').text('').hide();
                }
            });

        });



    });


    function timeToMinutes(timeStr) {
        // Parse the time string (assuming it's in hh:mm A format)
        var time = moment(timeStr, 'hh:mm A');
        // Convert the time to minutes from midnight
        return time.hours() * 60 + time.minutes();
    }

    function updateHours() {


        // First, validate the time inputs
        var isValid = true;

        // Reset previous error messages
        $('.invalid-feedback').text('').hide();
        $('.form-control').removeClass('is-invalid');

        $('.isopen').each(function () {
            var checkbox = $(this);
            var day = checkbox.attr('id');
            var startTimeInput = $('#' + day + '-start_time');
            var endTimeInput = $('#' + day + '-end_time');

            if (checkbox.prop('checked')) {
                var startTime = startTimeInput.val();
                var endTime = endTimeInput.val();

                // Validate start time
                if (!startTime) {
                    isValid = false;
                    startTimeInput.addClass('is-invalid');
                    $('#' + day + '-start_time-error').text("Please enter a start time.").show();
                }

                // Validate end time
                if (!endTime) {
                    isValid = false;
                    endTimeInput.addClass('is-invalid');
                    $('#' + day + '-end_time-error').text("Please enter an end time.").show();
                }

                // Ensure start time is before end time
                if (startTime && endTime) {
                    // Convert both start time and end time to minutes from midnight
                    var startMinutes = timeToMinutes(startTime);
                    var endMinutes = timeToMinutes(endTime);

                    // Compare the start and end time
                    if (startMinutes >= endMinutes) {
                        isValid = false;
                        startTimeInput.addClass('is-invalid');
                        endTimeInput.addClass('is-invalid');
                        // $('#' + day + '-start_time-error').text("Start time must be earlier than end time.").show();
                        $('#' + day + '-end_time-error').text("Start time must be earlier than end time.").show();
                    }
                }


            }

        });




        if (isValid) {

            var url = "<?php echo e(route('clinic.businessHoursUpdate')); ?>";
            var formDataArray = $('#business_hours_form').serializeArray();

            // Initialize an empty array to store structured business hours data
            var businessHours = [];

            // Convert the serialized array into the desired structure
            formDataArray.forEach(item => {
                const matches = item.name.match(/^businessHours\[(\w+)\]\[(\w+)\]$/);

                if (matches) {
                    let day = matches[1];
                    let field = matches[2];

                    // Find or create an object for this day
                    let dayObj = businessHours.find(obj => obj.day === day);
                    if (!dayObj) {
                        dayObj = { day, is_open: 0 }; // Default `is_open` to 0
                        businessHours.push(dayObj);
                    }

                    // Set the specific field in the day's object
                    dayObj[field] = item.value;

                    // If the field is `is_open` and checkbox is checked, set to `1`
                    if (field === "is_open" && item.value === "1") {
                        dayObj.is_open = 1;
                    }
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    businessHours: businessHours
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                    swal(
                        "Success!",
                        response.message,
                        "success"
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function (xhr) {
                    swal(
                        "Error!",
                        "Error something went wrong",
                        "error"
                    );
                },
            });
        }
    }

</script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/clinics/business-hours.blade.php ENDPATH**/ ?>