<?php $title = 'Body Temperature' ; ?>

@include('frontend.medicalhistory.header.chart')

<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fwt-bold">Body Temperature Reading</h5>
    <div class="btn_alignbox">
        <a onclick="addTemparature()" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="history-wrapperBody">
    <div class="row">
    <?php $cnt = 1; ?>
            <div id="bodytemparature_{{$cnt}}" class="col-12 temparaturecls appendtemparature">
            </div>

       
            <div class="col-12">
            @if(!empty(!$medicathistoryDetails->isEmpty()))
            @foreach($medicathistoryDetails as $tpd)
            <?php $sourceType = isset($sourceTypes[$tpd->source_type_id]) ? $sourceTypes[$tpd->source_type_id]['source_type'] : '';  ?>

            <div class="col-12 temperaturecls_{{$tpd->body_temperature_uuid}} temparaturecls"  id="bodytemparature_{{$cnt}}">
                <div class="inner-history" id="temperature_{{$tpd->body_temperature_uuid}}">
                    <div class="row">
                        <div class="col-sm-10 col-9">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="history-box mb-3">
                                        <h6>Temperature(°C or °F )</h6>
                                        <p>
                                            @if(isset($tpd->unit) && $tpd->unit =='c')
                                                {{ is_numeric($tpd->celsius) && strpos($tpd->celsius, '.') !== false ? number_format($tpd->celsius, 2) : $tpd->celsius }}
                                            @else
                                                {{ is_numeric($tpd->farenheit) && strpos($tpd->farenheit, '.') !== false ? number_format($tpd->farenheit, 2) : $tpd->farenheit }}
                                            @endif
                                            °{{ strtoupper($tpd->unit) }}
                                        </p>
                                      
                                    </div>
                                </div>
                                
                                <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                                <div class="col-md-4">
                                    <div class="history-box mb-3">
                                        <h6>Report Date</h6>
                                        <p><?php echo $corefunctions->timezoneChange($tpd->reportdate, "M d, Y") ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="history-box mb-3">
                                        <h6>Report Time</h6>
                                        <p><?php echo $corefunctions->timezoneChange($tpd->reporttime, "h:i A") ?></p>
                                    </div>
                                </div>
                                <!-- <div class="col-xxl-3 col-md-4">
                                    <div class="history-box">
                                        <h6>Source Type</h6>
                                        <p>{{$sourceType}}</p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        @if($tpd->created_by == Session::get('user.userID'))
                        <div class="col-sm-2 col-3">
                            <div class="btn_alignbox justify-content-end">
                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li><a onclick="editMHSection('{{$tpd->body_temperature_uuid}}','temperature')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>

                                    <li><a onclick="deleteMHSection('{{$tpd->body_temperature_uuid}}','temparature')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="history-info flex-wrap">
                                <h6 class="mb-0">
                                    @if(isset( $userDetails[$tpd->created_by])) {{$userDetails[$tpd->created_by]['first_name']}} @endif
                                    @if(isset($clinicUser[$tpd->created_by]['designation']['name'])), {{$clinicUser[$tpd->created_by]['designation']['name']}}@else{{''}}@endif
                                </h6>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="update-info ms-1 me-1"></span>
                                    <small>Last updated: </small><small class="ms-1">@if(isset($tpd->updated_at) && $tpd->updated_at != '')
                                        <?php echo $corefunctions->timezoneChange($tpd->updated_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($tpd->updated_at, "h:i A") ?>
                                        @else <?php echo $corefunctions->timezoneChange($tpd->created_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($tpd->created_at, "h:i A") ?> @endif</small>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <?php $cnt++; ?>
            @endforeach
            @endif

           
            <div class="flex justify-center no-records" @if($medicathistoryDetails->isEmpty()) style="display:block;" @else style="display:none;" @endif>
                <div class="text-center  no-records-body">
                    <img src="{{asset('images/nodata.png')}}"
                        class=" h-auto" alt="no records">
                    <p>No records found</p>
                </div>
            </div>
            </div>
      

    </div>
</div>

<div class="col-12">
    <div class="row justify-content-end">
        
        @if(isset($medicathistoryDetails) && !$medicathistoryDetails->isEmpty() )
        <div class="col-md-6">
            <div id="pagination-medical">
                {{ $medicathistoryDetails->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    console.log("jQuery version:", jQuery.fn.jquery);
    console.log("jQuery Validate loaded:", $.fn.validate ? "Yes" : "No");


    $(document).on("input", ".valcls", function () {
        hasFormValue();
    });
    $(document).ready(function() {
        // hasFormValue();
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

    function datetimePicker() {
        var now = moment(); // Get current time

        // Date Picker
        $('.bpdate').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false,
            maxDate: moment().endOf('day') // Ensures today is selectable
        }).on('dp.change', function(e) {
            var selectedDate = e.date;
            var timePicker = $(this).closest('.row').find('.bptime');
            var selectedTimeStr = timePicker.val();
            var selectedTime = selectedTimeStr ? moment(selectedTimeStr, 'hh:mm A') : null;
            
            // Enable/disable time picker based on selected date
            if (selectedDate && selectedDate.isSame(moment(), 'day')) {
                // If today is selected, initialize time picker with current time restrictions
                timePicker.datetimepicker('destroy');
                timePicker.datetimepicker({
                    format: 'hh:mm A',
                    locale: 'en',
                    useCurrent: false,
                    stepping: 5,
                    maxDate: moment() // Restrict to current time
                });
                
                // Validate existing time if present
                if (selectedTime && selectedTime.isAfter(now)) {
                    timePicker.val(''); // Clear invalid time
                }
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
            validateTimeSelection($(this));
        });
    }

    function validateTimeSelection(timeInput) {
        var dateInput = timeInput.closest('.row').find('.bpdate');
        var selectedDate = moment(dateInput.val(), 'MM/DD/YYYY');
        var selectedTime = moment(timeInput.val(), 'hh:mm A');
        var now = moment();
        var submitBtn = timeInput.closest('form').find('.opt-btn');
        var errorDiv = timeInput.siblings('.time-error');

        // Only validate if the selected date is today
        if (selectedDate.isSame(now, 'day')) {
            if (selectedTime.isAfter(now)) {
                if (!errorDiv.length) {
                    timeInput.parent().append('<div class="time-error text-danger">Cannot select future time for current date</div>');
                }
                timeInput.val(''); // Clear invalid time
                submitBtn.prop('disabled', true);
                return false;
            }
        }

        // Clear error if valid
        errorDiv.remove();
        submitBtn.prop('disabled', false);
        return true;
    }

  
    function validateform(cnt) {
    $("#temparatureform_" + cnt).validate({
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
            if (element.hasClass("temperaturecls" + cnt)) {
                error.insertAfter(".temperatureclserr" + cnt);
            } else if (element.hasClass("temparatureunitcls" + cnt)) {
                error.insertAfter(".temperatureunitclserr" + cnt);
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

    function addTemparature() {
        var temparaturecls = $('.temparaturecls').length;
        var ctCnt = temparaturecls + 1;
        var sourceType = "{{ Session::get('user.userType') == 'patient' ? 2 : 3 }}";
        var type = 'temparature';
        var ids = 'bodytemparature';
        var temperatureTypes = {!! json_encode($temparatureTypes) !!}; 
        console.log(temperatureTypes)
        // Generate options dynamically
        if (Array.isArray(temperatureTypes)) {
            var unitOptions = '<option value="">Select Unit Type</option>';
            temperatureTypes.forEach(function(unit) {
                unitOptions += '<option value="' + unit.unit + '">' + unit.type + '</option>';
            });
        } else {
            console.error("temperatureTypes is not an array:", temperatureTypes);
        }
        var bphtml =
           
            '<div class="col-12 temparaturecls" id="bodytemparature_' + ctCnt + '">'+ 
            '<form method="POST" id="temparatureform_' + ctCnt + '" autocomplete="off">@csrf'+
            '<div class="inner-history"> <div class="row align-items-start"> <div class="col-md-10"> <div class="row"> ' +
            '<div class="col-md-6 mb-3"><div class="history-box"> <div class="form-group form-outline temperatureclserr' + ctCnt + '"><label class="float-label">Temparature (°C or °F)</label><input type="text" class="form-control body_temparature temperaturecls' + ctCnt + '" id="temperature_' + ctCnt + '" name="body_temperature[temperature]"  placeholder=""></div></div></div>' +
            '<div class="col-md-6 mb-3"> <div class="history-box"> <div class="form-group form-floating temperatureunitclserr' + ctCnt + '"> <select class="form-select temparatureunitcls' + ctCnt + '" name="body_temperature[unit]" placeholder="">' + unitOptions + ' </select> <label class="select-label">Unit Type</label></div> </div> </div>' +
            '<div class="col-md-6"><div class="history-box mb-3"> <div class="form-group form-outline"><label class="float-label">Report Date</label><input type="text" class="form-control bpdate"  id="reportdate" name="body_temperature[reportdate]" placeholder=""></div></div></div>' +
            '<div class="col-md-6"> <div class="history-box"> <div class="form-group form-outline bptimeclserr"><label class="float-label">Report Time</label><input type="text" class="form-control bptime bptimecls"  id="bptime" name="body_temperature[reporttime]" placeholder=""></div></div></div>' +
            '<input type="hidden" class="form-control coucetype"  id="coucetype' + ctCnt + '" name="body_tempbody_temperaturearature[sourcetype]" value="' + sourceType + '"><input type="hidden" name="hasvalue" id="hasvalue" /></div></div><div class="col-md-2"> <div class="btn_alignbox justify-content-end">' +
            '<button type="button" class="opt-btn submitbp_' + ctCnt + '" id="submitbpbtn' + ctCnt + '" onclick="submitIntakeForm(\'' + type + '\',\'' + ctCnt + '\')"><span class="material-symbols-outlined success">check</span></button><a class="opt-btn danger-icon" onclick="remove(\'' + ids + '\',\'' + ctCnt + '\')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>' +
            '</div></div></div></div></form></div>';
            validateform(ctCnt);
        var idcn = ctCnt - 1;

        console.log(idcn);

        $('.appendtemparature').append(bphtml);
    
        datetimePicker();

        ctCnt++;
        $('.no-records').hide();
        

    }

    function submitIntakeForm(formtype, cnt) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateform(cnt);
        if ($("#temparatureform_"+cnt).valid()) {

            $("#submitbpbtn"+cnt).prop('disabled', true);
            let formdata = $("#temparatureform_"+cnt).serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype': formtype,
                    'patientID': patientID,
                    'formdata': formdata,
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

                }, 500);
            }
        }
    }
</script>