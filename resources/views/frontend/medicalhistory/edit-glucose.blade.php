@if(!empty($medicathistoryDetails))
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>  
<div class="col-12 glucls" id="glucose_{{$medicathistoryDetails['glucose_tracker_uuid']}}"> 
<form method="POST" id="intakeformglocuse" autocomplete="off">
@csrf                                      
    <div class="inner-history"> 
        <div class="row align-items-start">
            <div class="col-md-10"> 
                <div class="row"> 
                    <div class="col-md-4">
                        <div class="history-box"> 
                            <div class="form-group form-outline mb-3 glucoseclserr">
                                <label class="float-label">Glucose Value (mg/dL)</label>
                                <input type="text" class="form-control glucosecls valcls" id="glucose_{{$medicathistoryDetails['glucose_tracker_uuid']}}" name="glucose[glucose]"   placeholder=""  value="{{$medicathistoryDetails['bgvalue']}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4"> 
                        <div class="history-box"> 
                            <div class="form-group form-outline mb-3 a1cclserr">
                                <label class="float-label">HbA1C (%)</label>
                                <input type="text" class="form-control a1ccls valcls" id="hba1c{{$medicathistoryDetails['glucose_tracker_uuid']}}" name="glucose[hba1c]" placeholder="" value="{{$medicathistoryDetails['a1c']}}">
                            </div>
                        </div>
                    </div>

                    
                
                    <div class="col-md-4"> 
                        <div class="history-box"> 
                            <div class="form-group form-outline mb-3">
                                <label class="float-label">Report Date</label>
                                <input type="text" class="form-control bpdate"  id="reportdate{{$medicathistoryDetails['glucose_tracker_uuid']}}" name="glucose[glucosedate]" placeholder="" value="@if( $medicathistoryDetails['reportdate'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reportdate'],"m/d/Y") ?> @endif">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="history-box"> 
                            <div class="form-group form-outline">
                                <label class="float-label">Report Time</label>
                                <input type="text" class="form-control bptime"  id="bptime{{$medicathistoryDetails['glucose_tracker_uuid']}}" name="glucose[glucosetime]" placeholder="" value="@if( $medicathistoryDetails['reporttime'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reporttime'],"h:i:A") ?> @endif">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control coucetype"  name="glucose[key]" value="{{$medicathistoryDetails['glucose_tracker_uuid']}}">
                    <input type="hidden" class="form-control coucetype"  name="glucose[sourcetype]" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif>
                </div>
                <input type="hidden" name="hasglucosevalue"  class="form-control" id="hasglucosevalue_{{$medicathistoryDetails['glucose_tracker_uuid']}}" >
            </div>
            <div class="col-md-2"> 
                <div class="btn_alignbox justify-content-end">
                    <a class="opt-btn" onclick="submitIntakeForm('glucose','{{$medicathistoryDetails['glucose_tracker_uuid']}}')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('glucose')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
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
     function hasGlucoseFormValue(cnt) {
        var hasVal = '';
        
        $(".valcls").each(function() {
            if ($(this).val() != '') {
                hasVal = 1;
            }
        });
        $("#hasglucosevalue_"+cnt).val(hasVal);
    }
    // Add real-time validation
    $(document).ready(function() {
        $(".valcls").on('input', function() {
            var cnt = $(this).closest('.glucls').find('.valcls').first().attr('id').split('_')[1];
            hasGlucoseFormValue(cnt);
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
    $("#intakeformglocuse").validate({
            ignore: [],
            rules: {
                "glucose[glucose]": {
                    number: true,
                    min:1,
                },
                "glucose[hba1c]": {
                    number: true,
                    min:1,
                },
                "glucose[glucosetime]": {
                    lesserThanOrEqualToNow: true,
                },
                hasglucosevalue: "required",
            },
            messages: {
                "glucose[glucose]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "glucose[hba1c]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "glucose[glucosetime]": {
                    lesserThanOrEqualToNow: 'Report time must be lesser than current time.',
                },
                hasglucosevalue: "Please enter any one of the record",
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("glucosecls")) {
                    error.insertAfter(".glucoseclserr");
                } else if (element.hasClass("a1ccls")) {
                    error.insertAfter(".a1cclserr");
                } else if (element.hasClass("glucosetimecls")) {
                    error.insertAfter(".glucosetimeclserr");
                } else {
                    error.insertAfter(element);
                }
            },
        });
    });

function submitIntakeForm(formtype,cnt) {
    var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
    hasGlucoseFormValue(cnt)

    if ( $("#intakeformglocuse").valid()) {
        let formdata = $("#intakeformglocuse").serialize();
        $.ajax({
            url: '{{ url("/intakeform/store")}}',
            type: "post",
            data: {
                'formtype' : formtype,
                'formdata': formdata,
                'patientID' : patientID,
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