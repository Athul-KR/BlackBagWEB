<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-medium">Add Data</h4>
    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<form method="POST" id="bloodpressureform" autocomplete="off">@csrf
    <div class="row align-items-center align-row">
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Date</label>
                <input type="text" class="form-control bpdate" id="blood_pressure_reportdate" name="blood_pressure[bpdate]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Time</label>
                <input type="text" class="form-control bptime" id="blood_pressure_reporttime" name="blood_pressure[bptime]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            @php
            $systolic = !empty($medicathistoryDetails) && isset($medicathistoryDetails['systolic']) ? trim($medicathistoryDetails['systolic']) : '';
            $diastolic = !empty($medicathistoryDetails) && isset($medicathistoryDetails['diastolic']) ? trim($medicathistoryDetails['diastolic']) : '';
            $bloodPressure = $systolic !== '' ? $systolic . ($diastolic !== '' ? '/' . $diastolic : '') : '';
            @endphp
            <div class="form-group form-outline no-iconinput formsystoliccls">
                <label for="input" class="float-label">Systolic (mmHg)</label>
                <input type="text" class="form-control systoliccls valcls" name="blood_pressure[systolic]" value="{{ $bloodPressure }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput formmedicalhiscls">
                <label for="input" class="float-label">Diastolic (mmHg)</label>
                <input type="text" class="form-control medicalhiscls valcls" name="blood_pressure[diastolic]" value="@if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) ){{$medicathistoryDetails['diastolic']}}@endif">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label for="input" class="float-label">Pulse (mmHg)</label>
                <input type="text" class="form-control  valcls" name="blood_pressure[pulse]" @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['pulse']}}" @endif>
            </div>
            <input type="hidden" name="hasvalue" id="hasvalue" />
        </div>

        <input type="hidden" class="form-control coucetype" id="coucetype" name="blood_pressure[sourcetype]" value="3">
        @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['bp_tracker_uuid'])
        <input type="hidden" class="form-control coucetype" id="coucetype" name="blood_pressure[key]" value="{{$medicathistoryDetails['bp_tracker_uuid']}}">
        @endif

    </div>
</form>

<div class="btn_alignbox mt-4">
    <a type="button" class="btn btn-primary w-100" id="submitbpbtn" onclick="submitIntakeForm('bp','bloodpressureform','{{$formType}}')">Add Data</a>
</div>

<script>
    $(".valcls").on('input', function() {
        hasFormValue();
    });

    function hasFormValue() {
        var hasVal = '';
        $("#hasvalue").val('');

        $(".valcls").each(function() {
            if ($(this).val() != '') {
                hasVal = 1;
            }
        });
        $("#hasvalue").val(hasVal);
        $("#hasvalue").valid();
    }
    $(document).ready(function() {
        $('.bpdate').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false,
            maxDate: moment().endOf('day'), // Ensures today is selectable
        });
        $('.bptime').datetimepicker({
            format: 'hh:mm A',
            locale: 'en',
            useCurrent: false, // Prevents setting current time by default
            stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
            timeZone: userTimeZone
        });
        // $('input, textarea').each(function () {
        //     toggleLabel(this);

        // });
        $("#bloodpressureform").validate({
            ignore: [],
            rules: {
                "blood_pressure[systolic]": {
                    // required: true,
                    number: true,
                    min: 1,
                },
                "blood_pressure[diastolic]": {
                    number: true,
                    // required: true,
                    min: 1,
                },
                "blood_pressure[pulse]": {
                    number: true,
                    min: 1,
                },
                "blood_pressure[bpdate]": {
                    required: true,
                },
                "blood_pressure[bptime]": {
                    required: true,
                },
                hasvalue: "required",

            },
            messages: {
                "blood_pressure[systolic]": {
                    required: 'Please enter systolic value.',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "blood_pressure[diastolic]": {
                    required: 'Please enter diastolic value.',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "blood_pressure[pulse]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "blood_pressure[bpdate]": {
                    required: 'Please select report date.',
                },
                "blood_pressure[bptime]": {
                    required: 'Please select report time.',
                },
                hasvalue: "Please enter any one of the record",

            },
            errorPlacement: function(error, element) {
                if (element.hasClass("medicalhiscls")) {
                    error.appendTo('.formmedicalhiscls');
                } else if (element.hasClass("systoliccls")) {
                    error.appendTo('.formsystoliccls');
                } else {
                    error.insertAfter(element);
                }

            },
        });
    });

    // Function to toggle the 'active' class
    $(document).ready(function() {
        function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');
            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }
        // Initialize all inputs on page load
        $('input, textarea').each(function() {
            toggleLabel(this);
        });

        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function() {
            toggleLabel(this);
        });

        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function(e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });
    });
</script>