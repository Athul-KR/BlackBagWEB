<div class="tab-pane fade show active" id="healthmetricstab" role="tabpanel" aria-labelledby="healthmetrics-tab">
    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
    <div class="row">
        <div class="col-12">
            <div class="btn_alignbox justify-content-end mb-4">
                <a class="text-link primary d-flex align-items-center gap-1"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
            </div>
        </div>
        <div class="col-lg-10 col-xxl-8 mx-auto">
            <div class="content-box text-center mb-4">
                <h3 class="mb-2">Let’s Begin Your Health Journey</h3>
                <p class="px-lg-5 mx-lg-5">Your health metrics to help us provide better care tailored to your needs.</p>
            </div>
        </div>
        <div class="col-12">
            <form method="POST" id="intakeform" autocomplete="off">
                @csrf
                <div class="row h-100 justify-content-between">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 mb-4" id="blood_pressure">
                                <h6 class="fwt-bold">Blood Pressure</h6>
                                <div class="inputBox-divider">
                                    @php
                                    $systolic = !empty($bpDetails) && isset($bpDetails['systolic']) ? trim($bpDetails['systolic']) : '';
                                    $diastolic = !empty($bpDetails) && isset($bpDetails['diastolic']) ? trim($bpDetails['diastolic']) : '';
                                    $bloodPressure = $systolic !== '' ? $systolic . ($diastolic !== '' ? '/' . $diastolic : '') : '';
                                    @endphp
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Systolic (mmHg)</label>
                                        <input type="text" class="form-control" name="blood_pressure[systolic]" value="{{ $bloodPressure }}" id="systolic" placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Diastolic (mmHg)</label>
                                        <input type="text" class="form-control" name="blood_pressure[diastolic]" id="diastolic" @if(!empty($bpDetails) && isset($bpDetails['diastolic']) && $bpDetails['diastolic'] !='' ) value="{{$bpDetails['diastolic']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Pulse (bpm)</label>
                                        <input type="text" class="form-control" name="blood_pressure[pulse]" id="pulse" @if(!empty($bpDetails) && isset($bpDetails['pulse']) && $bpDetails['pulse'] !='' ) value="{{$bpDetails['pulse']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control bpdate" id="blood_pressure_reportdate" name="blood_pressure[bpdate]" @if(!empty($bpDetails) && isset($bpDetails['reportdate']) && $bpDetails['reportdate'] !='' ) value="<?php echo $corefunctions->timezoneChange($bpDetails['reportdate'], "m/d/Y") ?>" @endif placeholder="">
                                    </div>
                                    <input type="hidden" class="form-control" name="blood_pressure[key]" id="key" @if(!empty($bpDetails) && isset($bpDetails['bp_tracker_uuid']) && $bpDetails['bp_tracker_uuid'] !='' ) value="{{$bpDetails['bp_tracker_uuid']}}" @endif>
                                </div>
                            </div>
                            <div class="col-12 mb-4" id="glucose">
                                <h6 class="fwt-bold">Glucose Levels</h6>

                                <div class="inputBox-divider">
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Glucose Value (mg/dL)</label>
                                        <input type="text" class="form-control" name="glucose[glucose]" id="glucose" @if(!empty($glucoseDetails) && isset($glucoseDetails['bgvalue']) && $glucoseDetails['bgvalue'] !='' ) value="{{$glucoseDetails['bgvalue']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">HbA1C (%)</label>
                                        <input type="text" class="form-control" name="glucose[hba1c]" id="hba1c" @if(!empty($glucoseDetails) && isset($glucoseDetails['a1c']) && $glucoseDetails['a1c'] !='' ) value="{{$glucoseDetails['a1c']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control bpdate" id="glucose_reportdate" name="glucose[glucosedate]" @if(!empty($glucoseDetails) && isset($glucoseDetails['reportdate']) && $glucoseDetails['reportdate'] !='' ) value="<?php echo $corefunctions->timezoneChange($glucoseDetails['reportdate'], "m/d/Y") ?>" @endif placeholder="">
                                    </div>
                                    <input type="hidden" class="form-control" name="glucose[key]" id="hbkeya1c" @if(!empty($glucoseDetails) && isset($glucoseDetails['glucose_tracker_uuid']) && $glucoseDetails['glucose_tracker_uuid'] !='' ) value="{{$glucoseDetails['glucose_tracker_uuid']}}" @endif>

                                </div>

                            </div>
                            <div class="col-12 mb-4" id="cholesterol">
                                <h6 class="fwt-bold">Cholesterol Levels</h6>

                                <div class="inputBox-divider">
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Total Cholesterol (mg/dL)</label>
                                        <input type="text" class="form-control" name="cholesterol[cholesterol]" id="totalcholesterol" @if(!empty($cholesterolDetails) && isset($cholesterolDetails['cltotal']) && $cholesterolDetails['cltotal'] !='' ) value="{{$cholesterolDetails['cltotal']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">HDL (mg/dL)</label>
                                        <input type="text" class="form-control" name="cholesterol[hdl]" id="hdl" @if(!empty($cholesterolDetails) && isset($cholesterolDetails['HDL']) && $cholesterolDetails['HDL'] !='' ) value="{{$cholesterolDetails['HDL']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">LDL (mg/dL)</label>
                                        <input type="text" class="form-control" name="cholesterol[ldl]" id="ldl" @if(!empty($cholesterolDetails) && isset($cholesterolDetails['LDL']) && $cholesterolDetails['LDL'] !='' ) value="{{$cholesterolDetails['LDL']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Triglycerides (mg/dL)</label>
                                        <input type="text" class="form-control" name="cholesterol[triglycerides]" id="triglycerides" @if(!empty($cholesterolDetails) && isset($cholesterolDetails['triglycerides']) && $cholesterolDetails['triglycerides'] !='' ) value="{{$cholesterolDetails['triglycerides']}}" @endif placeholder="">
                                    </div>
                                    <!-- <div class="form-group form-outline mb-3">
                                            <input type="text" class="form-control" name="cholesterol[reportdate]" id="reportdate" placeholder="Report Date">
                                        </div> -->
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control bpdate" id="cholesterol_reportdate" name="cholesterol[chdate]" @if(!empty($cholesterolDetails) && isset($cholesterolDetails['reportdate']) && $cholesterolDetails['reportdate'] !='' ) value="<?php echo $corefunctions->timezoneChange($cholesterolDetails['reportdate'], "m/d/Y") ?>" @endif placeholder="">
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="cholesterol[fasting]" id="fasting" @if(!empty($cholesterolDetails) && isset($cholesterolDetails['fasting']) && $cholesterolDetails['fasting']=='1' ) checked @endif>
                                        <label class="form-check-label" for="fasting">Fasting</label>
                                    </div>
                                    <input type="hidden" class="form-control" name="cholesterol[key]" id="key" @if(!empty($cholesterolDetails) && isset($cholesterolDetails['cholestrol_tracker_uuid']) && $cholesterolDetails['cholestrol_tracker_uuid'] !='' ) value="{{$cholesterolDetails['cholestrol_tracker_uuid']}}" @endif>
                                </div>

                            </div>
                            <div class="col-12 mb-4">
                                <h6 class="fwt-bold">Physical Measurements</h6>
                                <div class="inputBox-divider">
                                    <div class="form-group form-outline mb-4">
                                        <label class="float-label">Weight (kg or lbs)</label>
                                        <input type="text" class="form-control" name="weight[weight]" id="weight" @if(!empty($weightDetails) && isset($weightDetails['weight']) && $weightDetails['weight'] !='' ) value="{{$weightDetails['weight']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-4 select-outline">
                                        <select class="form-select intake-select" name="weight[unit]" placeholder="">
                                            <option value="kg" @if(!empty($weightDetails) && isset($weightDetails['unit']) && $weightDetails['unit']=='kg' ) selected @endif>kg</option>
                                            <option value="lbs" @if(!empty($weightDetails) && isset($weightDetails['unit']) && $weightDetails['unit']=='lbs' ) selected @endif>lbs</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-outline mb-4">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control bpdate" id="weight_reportdate" name="weight[reportdate]" @if(!empty($weightDetails) && isset($weightDetails['reportdate']) && $weightDetails['reportdate'] !='' ) value="<?php echo $corefunctions->timezoneChange($weightDetails['reportdate'], "m/d/Y") ?>" @endif placeholder="">
                                    </div>
                                    <input type="hidden" class="form-control" name="weight[key]" id="key" @if(!empty($weightDetails) && isset($weightDetails['weight_tracker_uuid']) && $weightDetails['weight_tracker_uuid'] !='' ) value="{{$weightDetails['weight_tracker_uuid']}}" @endif>
                                </div>
                                <div class="inputBox-divider">
                                    <div class="form-group form-outline mb-4">
                                        <label class="float-label">Height (cm or inches)</label>
                                        <input type="text" class="form-control" name="height[height]" id="height" @if(!empty($heightDetails) && isset($heightDetails['height']) && $heightDetails['height'] !='' ) value="{{$heightDetails['height']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-4 select-outline">
                                        <select class="form-select intake-select" name="height[unit]" placeholder="">
                                            <option value="cm" @if(!empty($heightDetails) && isset($heightDetails['unit']) && $heightDetails['unit']=='cm' ) selected @endif>cm</option>
                                            <option value="inches" @if(!empty($heightDetails) && isset($heightDetails['unit']) && $heightDetails['unit']=='inches' ) selected @endif>inches</option>
                                            <option value="ft" @if(!empty($heightDetails) && isset($heightDetails['unit']) && $heightDetails['unit']=='ft' ) selected @endif>ft</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-outline mb-4">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control bpdate" id="height_reportdate" name="height[reportdate]" @if(!empty($heightDetails) && isset($heightDetails['reportdate']) && $heightDetails['reportdate'] !='' ) value="<?php echo $corefunctions->timezoneChange($heightDetails['reportdate'], "m/d/Y") ?>" @endif placeholder="">
                                    </div>
                                    <input type="hidden" class="form-control" name="height[key]" id="height" @if(!empty($heightDetails) && isset($heightDetails['height_tracker_uuid']) && $heightDetails['height_tracker_uuid'] !='' ) value="{{$heightDetails['height_tracker_uuid']}}" @endif>
                                </div>

                            </div>
                            <div class="col-12 mb-4" id="oxygen-saturations">
                                <h6 class="fwt-bold">Oxygen Saturations</h6>
                                <div class="inputBox-divider">
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Saturation (%)</label>
                                        <input type="text" class="form-control" name="saturation[saturation]" id="saturation" @if(!empty($saturationDetails) && isset($saturationDetails['saturation']) && $saturationDetails['saturation'] !='' ) value="{{$saturationDetails['saturation']}}" @endif placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control bpdate" id="saturation_reportdate" name="saturation[reportdate]" @if(!empty($saturationDetails) && isset($saturationDetails['reportdate']) && $saturationDetails['reportdate'] !='' ) value="<?php echo $corefunctions->timezoneChange($saturationDetails['reportdate'], "m/d/Y") ?>" @endif placeholder="">
                                    </div>
                                    <input type="hidden" class="form-control" name="saturation[key]" id="saturationkey" @if(!empty($saturationDetails) && isset($saturationDetails['oxygen_saturation_uuid']) && $saturationDetails['oxygen_saturation_uuid'] !='' ) value="{{$saturationDetails['oxygen_saturation_uuid']}}" @endif>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <h6 class="fwt-bold">Body Temperature</h6>

                                <div class="inputBox-divider">
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Temperature (°C or °F )</label>
                                        <input type="text" class="form-control" name="body_temperature[temperature]" id="temperature"
                                            @if(!empty($temperatureDetails))
                                            value="{{ isset($temperatureDetails['unit']) && trim($temperatureDetails['unit']) == 'c' 
                                                        ? trim($temperatureDetails['celsius'] ?? '') 
                                                        : trim($temperatureDetails['farenheit'] ?? '') }}"
                                            @endif
                                            placeholder="">
                                    </div>
                                    <div class="form-group form-outline mb-3 select-outline">
                                        <select class="form-select" name="body_temperature[unit]" placeholder="">
                                            @if(!empty($temparatureTypes))
                                            @foreach($temparatureTypes as $type)
                                            <option value="{{$type['unit']}}" @if(!empty($temperatureDetails) && isset($temperatureDetails['unit']) && $temperatureDetails['unit']==$type['unit']) selected @elseif($type['unit']=='c' ) selected @endif>{{$type['type']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group form-outline mb-3">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control bpdate" id="body_temperature_reportdate" name="body_temperature[reportdate]" @if(!empty($temperatureDetails) && isset($temperatureDetails['reportdate']) && $temperatureDetails['reportdate'] !='' ) value="<?php echo $corefunctions->timezoneChange($temperatureDetails['reportdate'], "m/d/Y") ?>" @endif placeholder="">
                                    </div>
                                    <input type="hidden" class="form-control" name="body_temperature[key]" id="key" @if(!empty($temperatureDetails) && isset($temperatureDetails['body_temperature_uuid']) && $temperatureDetails['body_temperature_uuid'] !='' ) value="{{$temperatureDetails['body_temperature_uuid']}}" @endif>

                                </div>
                            </div>



                        </div>
                    </div>
                    <input type="hidden" name="sourcetype" id="sourcetype" value="1">
                    <div class="col-12">
                        <div class="subt-btn btn_alignbox justify-content-end my-5">
                            <a class="btn text-decoration-underline skip_btn" onclick="getNextIntakeForm('success','1')">Skip</a>
                            <button class="btn btn-primary" id="healthmetricsbutton" onclick="submitIntakeForm('medication')">Next</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</section>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    window.userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    $(document).ready(function() {

        // Get the current date and time
        const currentDate = moment().format('MM/DD/YYYY'); // Format current date
        const currentTime = moment().format('hh:mm A'); // Format current time

        // Set the values in the input fields
        $('#bpdate').val(currentDate);
        $('#bptime').val(currentTime);
        $('#bgdate').val(currentDate);
        $('#bgtime').val(currentTime);
    });
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
    $('#bpdate').datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false,
        maxDate: new Date(), // This will allow only past dates and block future dates
    });

    $('#bptime').datetimepicker({
        format: 'hh:mm A',
        locale: 'en',
        useCurrent: false, // Prevents setting current time by default
        stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
        timeZone: userTimeZone
    });
    $('#bgdate').datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false,
        maxDate: new Date(), // This will allow only past dates and block future dates
    });

    $('#bgtime').datetimepicker({
        format: 'hh:mm A',
        locale: 'en',
        useCurrent: false, // Prevents setting current time by default
        stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
        timeZone: userTimeZone
    });


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