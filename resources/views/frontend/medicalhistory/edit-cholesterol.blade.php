@if(!empty($medicathistoryDetails))
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
<div class="col-12 cholesterolcls_{{$medicathistoryDetails['cholestrol_tracker_uuid']}} chscls" id="cholestrol_{{$medicathistoryDetails['cholestrol_tracker_uuid']}}">
<form method="POST" id="intakeformcholesterol_{{$medicathistoryDetails['cholestrol_tracker_uuid']}}" autocomplete="off">
@csrf
<div class="inner-history"> 
        <div class="row align-items-start">
            <div class="col-md-10"> 
                <div class="row"> 
                    <div class="col-md-12"> 
                        <div class="history-box"> 
                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input fasting" id="fasting'+ctCnt+'" name="cholesterol[fasting]" placeholder="Fasting (mg/dL)" @if(isset($medicathistoryDetails['fasting']) && $medicathistoryDetails['fasting'] == '1')) checked @endif>
                                <label class="form-check-label" for="fasting">Fasting</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6"> 
                        <div class="history-box mb-3"> 
                            <div class="form-group form-outline chclserr{{$medicathistoryDetails['cholestrol_tracker_uuid']}}">
                                <label class="float-label">Total Cholesterol (mg/dL)</label>
                                <input type="text" class="form-control chcls valcls" id="cholesterol" name="cholesterol[cholesterol]" placeholder="" value="{{$medicathistoryDetails['cltotal']}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6"> 
                        <div class="history-box mb-3"> 
                            <div class="form-group form-outline hdlclserr{{$medicathistoryDetails['cholestrol_tracker_uuid']}}">
                                <label class="float-label">HDL (mg/dL)</label>
                                <input type="text" class="form-control hdlcls valcls" id="hdl"  name="cholesterol[hdl]" placeholder="" value="{{$medicathistoryDetails['HDL']}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6"> 
                        <div class="history-box mb-3"> 
                            <div class="form-group form-outline ldlclserr{{$medicathistoryDetails['cholestrol_tracker_uuid']}}">
                                <label class="float-label">LDL (mg/dL)</label>
                                <input type="text" class="form-control ldlcls valcls" id="ldl"  name="cholesterol[ldl]" placeholder="" value="{{$medicathistoryDetails['LDL']}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6"> 
                        <div class="history-box mb-3"> 
                            <div class="form-group form-outline triclserr{{$medicathistoryDetails['cholestrol_tracker_uuid']}}">
                                <label class="float-label">Triglycerides (mg/dL)</label>
                                <input type="text" class="form-control tricls valcls" id="triglycerides"  name="cholesterol[triglycerides]" placeholder="" value="{{$medicathistoryDetails['triglycerides']}}">
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-xl-4 col-md-6"> 
                        <div class="history-box mb-3"> 
                            <div class="form-group form-outline">
                                <label class="float-label">Report Date</label>
                                <input type="text" class="form-control repotdate bpdate"  id="reportdate{{$medicathistoryDetails['cholestrol_tracker_uuid']}}" name="cholesterol[chdate]" placeholder="" value="@if( $medicathistoryDetails['reportdate'] != '')<?php echo $corefunctions->timezoneChange($medicathistoryDetails['reportdate'],"m/d/Y") ?> @endif">
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6"> 
                        <div class="history-box"> 
                            <div class="form-group form-outline chtimeclserr{{$medicathistoryDetails['cholestrol_tracker_uuid']}}"">
                                <label class="float-label">Report Time</label>
                                <input type="text" class="form-control reporttime bptime chtimecls"  id="bptime{{$medicathistoryDetails['cholestrol_tracker_uuid']}}" name="cholesterol[chtime]" placeholder="" value="@if( $medicathistoryDetails['reporttime'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reporttime'],"h:i:A") ?> @endif">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control coucetype"  id="key{{$medicathistoryDetails['cholestrol_tracker_uuid']}}" name="cholesterol[key]" value="{{$medicathistoryDetails['cholestrol_tracker_uuid']}}">
                    <input type="hidden" class="form-control coucetype"  id="coucetype{{$medicathistoryDetails['cholestrol_tracker_uuid']}}" name="cholesterol[sourcetype]" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif>
                </div>
                <input type="hidden" name="haschvalue"  class="form-control" id="haschvalue_{{$medicathistoryDetails['cholestrol_tracker_uuid']}}" >

            </div>
            <div class="col-md-2"> 
                <div class="btn_alignbox justify-content-end">
                    <a class="opt-btn" onclick="submitIntakeForm('cholesterol','{{$medicathistoryDetails['cholestrol_tracker_uuid']}}')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('cholesterol')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                </div>
            </div>
        </div>
    </div>
</form>
    @endif
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
     function haschFormValue(cnt) {
        var hasVal = '';
        
        $(".valcls").each(function() {
            if ($(this).val() != '') {
                hasVal = 1;
            }
        });
        $("#haschvalue_"+cnt).val(hasVal);
    }
    // Add real-time validation
    $(document).ready(function() {
        $(".valcls").on('input', function() {
            var cnt = $(this).closest('.glucls').find('.chscls').first().attr('id').split('_')[1];
            haschFormValue(cnt);
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
    function validateCholesterolForms(cnt){
            $("#intakeformcholesterol_"+cnt).validate({
                ignore: [],
                rules: {
                    "cholesterol[cholesterol]": {
                        number: true,
                        min:1,
                    },
                    "cholesterol[hdl]": {
                        number: true,
                        min:1,
                    },
                    "cholesterol[ldl]": {
                        number: true,
                        min:1,
                    },
                    "cholesterol[triglycerides]": {
                        number: true,
                        min:1,
                    },
                    "cholesterol[chtime]": {
                        lesserThanOrEqualToNow: true,
                    },
                    haschvalue: "required",
                },
                messages: {
                    "cholesterol[cholesterol]": {
                        number: 'Please enter a numeric value.',
                        min: 'Please enter a value greater than 0',
                    },
                    "cholesterol[hdl]": {
                        number: 'Please enter a numeric value.',
                        min: 'Please enter a value greater than 0',
                    },
                    "cholesterol[ldl]": {
                        number: 'Please enter a numeric value.',
                        min: 'Please enter a value greater than 0',
                    },
                    "cholesterol[triglycerides]": {
                        number: 'Please enter a numeric value.',
                        min: 'Please enter a value greater than 0',
                    },
                    "cholesterol[chtime]": {
                        lesserThanOrEqualToNow: 'Report time must be lesser than current time.',
                    },
                    haschvalue: "Please enter any one of the record",
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass("chcls"+cnt)) {
                        error.insertAfter(".chclserr"+cnt);
                    } else if (element.hasClass("hdlcls"+cnt)) {
                        error.insertAfter(".hdlclserr"+cnt);
                    } else if (element.hasClass("ldlcls"+cnt)) {
                        error.insertAfter(".ldlclserr"+cnt);
                    } else if (element.hasClass("tricls")) {
                        error.insertAfter(".triclserr");
                    } else if (element.hasClass("chtimecls"+cnt)) {
                        error.insertAfter(".chtimeclserr"+cnt);
                    } else {
                        error.insertAfter(element);
                    }
                },
            });
        }

    function submitIntakeForm(formtype,cnt) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        haschFormValue(cnt);
        validateCholesterolForms(cnt)
        if ($("#intakeformcholesterol_"+cnt).valid()) {
            let formdata = $("#intakeformcholesterol_"+cnt).serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype' : formtype,
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

