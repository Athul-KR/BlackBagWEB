@if(!empty($medicathistoryDetails))
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
<div class="col-12 bpcls_{{$medicathistoryDetails['bp_tracker_uuid']}} bloodpressurecls" id="bloodpressure_{{$medicathistoryDetails['bp_tracker_uuid']}}">
    <form method="POST" id="intakeform" autocomplete="off">
        @csrf
        <div class="inner-history">
            <div class="row align-items-start">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-xxl-4 col-md-5">
                            <div class="history-box mb-3">
                                <div class="form-group form-outline systolicclserr">
                                    <label class="float-label">Systolic (mmHg)</label>
                                    <input type="text" class="form-control systoliccls valcls" id="systolic_{{$medicathistoryDetails['bp_tracker_uuid']}}" name="blood_pressure[systolic]" placeholder="" value=" {{$medicathistoryDetails['systolic']}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-4">
                            <div class="history-box mb-3">
                                <div class="form-group form-outline diastolicclserr">
                                    <label class="float-label">Diastolic (mmHg)</label>
                                    <input type="text" class="form-control diastoliccls valcls" id="diastolic_{{$medicathistoryDetails['bp_tracker_uuid']}}" name="blood_pressure[diastolic]" placeholder="" value="{{$medicathistoryDetails['diastolic']}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <div class="history-box mb-3">
                                <div class="form-group form-outline pulseclserr">
                                    <label class="float-label">Pulse (bpm)</label>
                                    <input type="text" class="form-control pulsecls valcls" id="pulse_{{$medicathistoryDetails['bp_tracker_uuid']}}" name="blood_pressure[pulse]" placeholder="" value="{{$medicathistoryDetails['pulse']}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <div class="history-box mb-3">
                                <div class="form-group form-outline">
                                    <label class="float-label">Report Date</label>
                                    <input type="text" class="form-control bpdate" id="reportdate{{$medicathistoryDetails['bp_tracker_uuid']}}" name="blood_pressure[bpdate]" placeholder="" value="@if( $medicathistoryDetails['reportdate'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reportdate'], "m/d/Y") ?> @endif">
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <div class="history-box">
                                <div class="form-group form-outline">
                                    <label class="float-label">Report Time</label>
                                    <input type="text" class="form-control bptime" id="bptime{{$medicathistoryDetails['bp_tracker_uuid']}}" name="blood_pressure[bptime]" placeholder="" value="@if( $medicathistoryDetails['reporttime'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reporttime'], "h:i:A") ?> @endif">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="key{{$medicathistoryDetails['bp_tracker_uuid']}}" name="blood_pressure[key]" value="{{$medicathistoryDetails['bp_tracker_uuid']}}">
                        <input type="hidden" class="form-control coucetype" id="scoucetype{{$medicathistoryDetails['bp_tracker_uuid']}}" name="blood_pressure[sourcetype]" @if(Session::get('user.userType')=='patient' ) value="2" @else value="3" @endif>
                    </div>
                    <input type="hidden" name="hasbpvalue" class="form-control" id="hasbpvalue_{{$medicathistoryDetails['bp_tracker_uuid']}}">


                </div>
                <div class="col-md-2">
                    <div class="btn_alignbox justify-content-end">
                        <a class="opt-btn" onclick="submitIntakeForm('bp','{{$medicathistoryDetails['bp_tracker_uuid']}}')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('bp')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endif
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    function hasEditFormValue(cnt) {
        var hasVal = '';

        $(".valcls").each(function() {
            if ($(this).val() != '') {
                hasVal = 1;
            }
        });
        $("#hasbpvalue_" + cnt).val(hasVal);
    }
    // Add real-time validation
    $(document).ready(function() {
        $(".valcls").on('input', function() {
            var cnt = $(this).closest('.bloodpressurecls').find('.valcls').first().attr('id').split('_')[1];
            hasEditFormValue(cnt);
        });
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
    $(document).ready(function() {
        $("#intakeform").validate({
            ignore: [],
            rules: {
                "blood_pressure[systolic]": {

                    number: true,
                    min: 1,
                },
                hasbpvalue: "required",
                "blood_pressure[diastolic]": {
                    number: true,
                    min: 1,
                },
                "blood_pressure[pulse]": {
                    number: true,
                    min: 1,
                },
            },
            messages: {
                hasbpvalue: "Please enter any one of the record",
                "blood_pressure[systolic]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "blood_pressure[diastolic]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "blood_pressure[pulse]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("systoliccls")) {
                    error.insertAfter(".systolicclserr");
                } else if (element.hasClass("diastoliccls")) {
                    error.insertAfter(".diastolicclserr");
                } else if (element.hasClass("pulsecls")) {
                    error.insertAfter(".pulseclserr");
                } else {
                    error.insertAfter(element);
                }
            },
        });
    });



    function submitIntakeForm(formtype, cnt) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        hasEditFormValue(cnt)
        // const isValid = validateUserForm('bloodpressure', cnt);
        // if (isValid) {
        if ($("#intakeform").valid()) {
            let formdata = $("#intakeform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype': formtype,
                    'formdata': formdata,
                    'patientID': patientID,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        getmedicalhistoryData(formtype);
                    } else {

                    }
                },
                error: function(xhr) {

                    handleError(xhr);
                },
            });
        } else {
            if ($('.error:visible').length > 0) {
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: ($('.error:visible').first().offset().top - 100)
                    }, 500);
                }, 500);
            }
        }
        // }
    }

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