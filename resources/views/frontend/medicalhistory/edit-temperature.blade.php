@if(!empty($medicathistoryDetails))
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
<form method="POST" id="temparatureform" autocomplete="off">
@csrf
<div class="inner-history"> 
        <div class="row align-items-start">
            <div class="col-md-10"> 
                <div class="row"> 
                    <div class="col-md-6 mb-3">
                        <div class="history-box"> 
                            <div class="form-group form-outline temperatureclserr">
                                <label class="float-label">Temperature(°C or °F )</label>
                                <input type="text" class="form-control temperaturecls" id="temperature" name="body_temperature[temperature]"  placeholder=""  value="@if(isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] =='c'){{$medicathistoryDetails['celsius']}}@else{{$medicathistoryDetails['farenheit']}}@endif">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="history-box">
                            <div class="form-group form-floating temperatureunitclserr"> 
                                <select class="form-select temparatureunitcls" name="body_temperature[unit]" placeholder="">
                                    <option value="">Select Unit Type</option>
                                    @if(!empty($temparatureTypes))
                                    @foreach($temparatureTypes as $type)
                                        <option value="{{$type['unit']}}" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] == $type['unit']) selected @endif>{{$type['type']}}</option>
                                       
                                    @endforeach
                                    @endif
                                </select>
                                <label class="select-label">Unit Type</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="history-box mb-3"> 
                            <div class="form-group form-outline">
                                <label class="float-label">Report Date</label>
                                <input type="text" class="form-control bpdate" name="body_temperature[reportdate]" placeholder="" value="@if( $medicathistoryDetails['reportdate'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reportdate'],"m/d/Y") ?> @endif">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4"> 
                        <div class="history-box"> 
                            <div class="form-group form-outline">
                                <label class="float-label">Report Time</label>
                                <input type="text" class="form-control bptime"   name="body_temperature[reportdatetime]" placeholder="" value="@if( $medicathistoryDetails['reporttime'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reporttime'],"h:i:A") ?> @endif">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" class="form-control coucetype"  id="coucetype'+ctCnt+'" name="body_temperature[key]" value="{{$medicathistoryDetails['body_temperature_uuid']}}">
                    <input type="hidden" class="form-control coucetype"  id="coucetype'+ctCnt+'" name="body_temperature[sourcetype]"@if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif>
                </div>
            </div>
            <div class="col-md-2"> 
                <div class="btn_alignbox justify-content-end">
                    <a class="opt-btn" onclick="submitIntakeForm('temparature')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a>
                    <a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('temparature')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                </div>
            </div>
        </div>
    </div>
</form>
@endif
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
     function validateEditform() {
    $("#temparatureform").validate({
        rules: {
            "body_temperature[temperature]": {
                required: true,
                number: true,
                min: 1,
                noSpecialChars: true,
                temperatureRange: true
            },
            "body_temperature[unit]": {
                required: true,
            },
            hasvalue: "required",
        },
        messages: {
            "body_temperature[temperature]": {
                required: 'Please enter the temperature',
                number: 'Please enter a numeric value.',
                min: 'Please enter a value greater than 0',
                pattern: "Special characters are not allowed",
                temperatureRange: "Please enter a valid temperature (30°C - 45°C or 86°F - 113°F).",
            },
            "body_temperature[unit]": {
                required: 'Please select the unit',
            },
            hasvalue: "Please enter any one of the record",
        },
        errorPlacement: function (error, element) {
            if (element.hasClass("temperaturecls")) {
                error.insertAfter(".temperatureclserr");
            } else if (element.hasClass("temparatureunitcls")) {
                error.insertAfter(".temperatureunitclserr");
            } else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod("noSpecialChars", function (value, element) {
        return this.optional(element) || /^[0-9]+(\.[0-9]+)?$/.test(value);
    }, "Special characters are not allowed");

    $.validator.addMethod("temperatureRange", function (value, element) {
        var unit = $('select[name="body_temperature[unit]"]').val();
        var temp = parseFloat(value);

        if (unit === 'c') {
            return temp >= 30 && temp <= 45;
        } else if (unit === 'f') {
            return temp >= 86 && temp <= 113;
        }
        return false;
    }, "Please enter a valid temperature (30°C - 45°C or 86°F - 113°F).");

}

    var now = moment(); // Get current time

    // Date Picker
    $('.bpdate').datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false,
        maxDate: moment().endOf('day')
    }).on('dp.change', function(e) {
        var selectedDate = e.date;
        var timePicker = $(this).closest('.row').find('.bptime');
        var now = moment();
        
        if (selectedDate && selectedDate.isSame(now, 'day')) {
            // For current date, restrict time selection
            timePicker.datetimepicker('destroy');
            timePicker.datetimepicker({
                format: 'hh:mm A',
                locale: 'en',
                useCurrent: false,
                stepping: 5,
                maxDate: now // Restrict to current time
            });
        } else {
            // For past dates, allow all times
            timePicker.datetimepicker('destroy');
            timePicker.datetimepicker({
                format: 'hh:mm A',
                locale: 'en',
                useCurrent: false,
                stepping: 5
            });
        }
    });

    // Time Picker
    $('.bptime').datetimepicker({
        format: 'hh:mm A',
        locale: 'en',
        useCurrent: false,
        stepping: 5
    }).on('dp.change', function(e) {
        var dateInput = $(this).closest('.row').find('.bpdate');
        var selectedDate = moment(dateInput.val(), 'MM/DD/YYYY');
        var selectedTime = e.date;
        var now = moment();

        if (selectedDate && selectedDate.isSame(now, 'day') && selectedTime.isAfter(now)) {
            $(this).val(''); // Simply clear the time if it's future time on current date
        }
    });

    function submitIntakeForm(formtype) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateEditform();
        if ($("#temparatureform").valid()) {
            let formdata = $("#temparatureform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype' : formtype,
                    'patientID' : patientID,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        console.log(formtype)
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
    
</script>

<script> 

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