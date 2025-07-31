<form method="post" id="business_hours_form" autocomplete="off">
    @if(isset($businessHours) && count($businessHours) > 0)
        @foreach ($businessHours as $businessHour)

            <div class="col-12">
                <div class="row align-items-center mb-3">
                    <div class="col-3">
                        <div class="d-flex justify-content-between">
                            <h6>{{ $businessHour['day'] }}</h6>
                            <div class="form-check form-switch">
                                <input class="form-check-input isopen" type="checkbox" id="{{ $businessHour['day'] }}"
                                    name="businessHours[{{ $businessHour['day'] }}][is_open]" value="1"
                                    @if(($businessHour['is_open']) == 1) checked @endif>
                            </div>
                        </div>
                    </div>
                    <!-- hidden field -->
                    <input type="hidden" name="businessHours[{{$businessHour['day']}}]['bussinesshour_uuid']"
                        value="{{$businessHour['bussinesshour_uuid'] ?? ''}}">

                    <div class="col-9" id="{{ $businessHour['day'] }}-div">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group form-outline">

                                    <i class="material-symbols-outlined">alarm</i>
                                    <label class="float-label">Opening Time</label>
                                    <input type="text" class="form-control start_time" id="{{ $businessHour['day'] }}-start_time"
                                        name="businessHours[{{ $businessHour['day'] }}][start_time]"
                                        value="{{ $businessHour['start_time'] ?? '' }}" >
                                </div>
                                <div class="invalid-feedback" id="{{ $businessHour['day'] }}-start_time-error"></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group form-outline">
                                    
                                    <i class="material-symbols-outlined">alarm</i>
                                    <label class="float-label">Closing Time</label>
                                    <input type="text" class="form-control end_time" id="{{ $businessHour['day'] }}-end_time"
                                        name="businessHours[{{ $businessHour['day'] }}][end_time]"
                                        value="{{ $businessHour['end_time'] ?? '' }}">
                                </div>
                                <div class="invalid-feedback" id="{{ $businessHour['day'] }}-end_time-error"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div class="btn_alignbox justify-content-end mt-4">
        <a data-bs-dismiss="modal" class="btn btn-outline-primary">Close</a>
        <button type="button" id="avail_submit" onclick="updateHours()" class="btn btn-primary">Save Changes</button>
    </div>
</form>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script>
    $(document).ready(function () {



        $('.isopen').each(function () {
            var checkbox = $(this);
            var day = checkbox.attr('id'); // Get the day directly from the checkbox id
            var startTimeInput = $('#' + day + '-start_time'); // Related opening time input
            var endTimeInput = $('#' + day + '-end_time'); // Related closing time input
            var div = $('#' + day + '-div');

            // On page load, check if the checkbox is checked and enable the inputs
            if (checkbox.prop('checked')) {

                startTimeInput.prop('disabled', false);
                endTimeInput.prop('disabled', false);
                div.show();

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
                div.hide();

            }

            // Handle change event when the checkbox is toggled
            checkbox.change(function () {
                if ($(this).prop('checked')) {
                    startTimeInput.prop('disabled', false);
                    endTimeInput.prop('disabled', false);
                    div.show();

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
                    div.hide();


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
                    $('#' + day + '-start_time-error').text("Please enter a opening time.").show();
                }

                // Validate end time
                if (!endTime) {
                    isValid = false;
                    endTimeInput.addClass('is-invalid');
                    $('#' + day + '-end_time-error').text("Please enter an closing time.").show();
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
                        $('#' + day + '-end_time-error').text("Opening time must be earlier than closing time.").show();
                    }
                }


            }

        });




        if (isValid) {

            var url = "{{ route('clinic.businessHoursUpdate') }}";
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
                 
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                        window.location.reload();
                    });

                },
                error: function(xhr) {
                    
                    handleError(xhr);
                }
            });
        }
    }

    $(document).ready(function () {
    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
        const isFocused = $input.is(':focus');

        // Ensure .float-label is correctly selected relative to the input
        $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
    }

    // Initialize all inputs on page load
    $('input, textarea').each(function () {
        toggleLabel(this);
    });

    // Handle input events
    $(document).on('focus blur input change', 'input, textarea', function () {
        toggleLabel(this);
    });

    // Handle dynamic updates (e.g., Datepicker)
    $(document).on('dp.change', function (e) {
        const input = $(e.target).find('input, textarea');
        if (input.length > 0) {
            toggleLabel(input[0]);
        }
    });
});


</script>