<?php $title = 'Blood Pressure'; ?>

@include('frontend.medicalhistory.header.chart')
@if(!empty(!$medicathistoryDetails->isEmpty()))
<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fwt-bold">Blood Pressure Readings</h5>
    <div class="btn_alignbox">
        <a onclick="addBP()" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="history-wrapperBody">
    <div class="row">

        <div id="bloodpressure_1" class="col-12 bloodpressurecls appendbp">
        </div>
        <?php $cnt = 2; ?>
        <div class="col-12">
            @if(!empty(!$medicathistoryDetails->isEmpty()))
            @foreach($medicathistoryDetails as $bpd)
            <?php $sourceType = isset($sourceTypes[$bpd->source_type_id]) ? $sourceTypes[$bpd->source_type_id]['source_type'] : '';  ?>

            <div class="col-12 bpcls_{{$bpd->bp_tracker_uuid}} bloodpressurecls" id="bloodpressure_{{$cnt}}">
                <div class="inner-history" id="innerbloodpressure_{{$cnt}}">
                    <div class="row">
                        <div class="col-sm-10 col-9">

                            <div class="row">
                                <div class="col-xxl-4 col-md-5">
                                    <div class="history-box mb-3">
                                        <h6>Systolic/Diastolic (mmHg)</h6>
                                        <p>
                                            @if(isset($bpd->systolic) && $bpd->systolic != '') {{$bpd->systolic}} @else -- @endif
                                            {{ '/' }}
                                            @if(isset($bpd->diastolic) && $bpd->diastolic != '') {{$bpd->diastolic}} @else -- @endif
                                        </p>
                                    </div>
                                </div>
                                <!-- <div class="col-xxl-3 col-md-4">
                                    <div class="history-box mb-3">
                                        <h6>Diastolic (mmHg)</h6>
                                        <p>@if(isset($bpd->diastolic) && $bpd->diastolic != '') {{$bpd->diastolic}} @else -- @endif</p>
                                    </div>
                                </div> -->
                                <div class="col-xxl-3 col-md-4">
                                    <div class="history-box mb-3">
                                        <h6>Pulse (bpm)</h6>
                                        <p>@if(isset($bpd->pulse) && $bpd->pulse != '') {{$bpd->pulse}} @else -- @endif</p>
                                    </div>
                                </div>
                                <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                                <div class="col-xxl-3 col-md-4">
                                    <div class="history-box mb-3">
                                        <h6>Report Date</h6>
                                        <p><?php echo $corefunctions->timezoneChange($bpd->reportdate, "M d, Y") ?></p>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-4">
                                    <div class="history-box mb-3">
                                        <h6>Report Time</h6>
                                        <p><?php echo $corefunctions->timezoneChange($bpd->reporttime, "h:i A") ?></p>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-4">
                                    <div class="history-box">
                                        <h6>Source Type</h6>
                                        @if(isset($bpd->device_image) && $bpd->rpm_deviceid != null)
                                        <div class="user_inner">
                                            <img class="patient-rpm-img" src="{{$bpd->device_image}}">
                                            <div class="user_info">
                                                <h6 class="primary fw-bold m-0"> {{$bpd->device_name}}</h6>

                                            </div>
                                        </div>
                                        @else
                                        <p> {{$sourceType}} </p> @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($bpd->created_by == Session::get('user.userID'))
                        <div class="col-sm-2 col-3">
                            <div class="btn_alignbox justify-content-end">
                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li><a onclick="editMHSection('{{$bpd->bp_tracker_uuid}}','bp')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>

                                    <li><a onclick="deleteMHSection('{{$bpd->bp_tracker_uuid}}','bp')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="history-info flex-wrap">
                                <h6 class="mb-0">
                                    @if(isset( $userDetails[$bpd->created_by])) {{$userDetails[$bpd->created_by]['first_name']}} @endif
                                    @if(isset($clinicUser[$bpd->created_by]['designation']['name'])), {{$clinicUser[$bpd->created_by]['designation']['name']}}@else{{''}}@endif
                                </h6>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="update-info ms-1 me-1"></span>
                                    <small>Last updated: </small><small class="ms-1">@if(isset($bpd->updated_at) && $bpd->updated_at != '')
                                        <?php echo $corefunctions->timezoneChange($bpd->updated_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($bpd->updated_at, "h:i A") ?>
                                        @else <?php echo $corefunctions->timezoneChange($bpd->created_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($bpd->created_at, "h:i A") ?> @endif</small>
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
@endif


<script>
    $(document).on("input", ".valcls", function() {
        hasFormValue();
    });
    $(document).ready(function() {
        hasFormValue();
    });

    function validateBpForms(cnt) {
        $("#intakeform_" + cnt).validate({
            ignore: [],
            rules: {
                "blood_pressure[systolic]": {
                    number: true,
                    min: 1,
                },
                "blood_pressure[diastolic]": {
                    number: true,
                    min: 1,
                },
                "blood_pressure[pulse]": {
                    number: true,
                    min: 1,
                },
                "blood_pressure[bptime]": {
                    lesserThanOrEqualToNow: true,
                },
                hasvalue: "required",
            },
            messages: {
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
                "blood_pressure[bptime]": {
                    lesserThanOrEqualToNow: "Report time must be less than or equal to the current time.",
                },
                hasvalue: "Please enter any one of the record",
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("systoliccls" + cnt)) {
                    error.insertAfter(".systolicclserr" + cnt);
                } else if (element.hasClass("diastoliccls")) {
                    error.insertAfter(".diastolicclserr");
                } else if (element.hasClass("pulsecls")) {
                    error.insertAfter(".pulseclserr");
                } else if (element.hasClass("bptimecls")) {
                    error.insertAfter(".bptimeclserr");
                } else {
                    error.insertAfter(element);
                }
            },
        });
    }


    jQuery.validator.addMethod("lesserThanOrEqualToNow", function(value, element) {
        const dateField = $(element).closest('form').find('.bpdate').val();
        const selectedDate = dateField ? moment(dateField, 'MM/DD/YYYY') : moment().startOf('day');

        // Parse the time value
        const selectedTime = moment(value, 'hh:mm A');

        // Combine date and time for comparison
        const selectedDateTime = moment(selectedDate).hour(selectedTime.hour()).minute(selectedTime.minute());
        const now = moment();

        // Return true if time is not in future
        return selectedDateTime <= now;
    }, 'Report time must be less than or equal to the current time.');


    function hasFormValue(cnt) {

        var hasVal = '';
        $("#hasvalue_" + cnt).val('');

        $(".valcls" + cnt).each(function() {
            if ($(this).val() != '') {
                hasVal = 1;
            }
        });
        $("#hasvalue_" + cnt).val(hasVal);
        $("#hasvalue_" + cnt).valid();
    }

    function datetimePicker() {
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
    }


    function addBP() {
        var bloodpressurecls = $('.bloodpressurecls').length;
        var ctCnt = bloodpressurecls + 1;
        var sourceType = "{{ Session::get('user.userType') == 'patient' ? 2 : 3 }}";
        var type = 'bp';
        var ids = 'bloodpressure';
        var bphtml =

            '<div class="col-12 bloodpressurecls" id="bloodpressure_' + ctCnt + '"><form method="POST" id="intakeform_' + ctCnt + '" autocomplete="off">@csrf <div class="inner-history"> <div class="row align-items-start"> <div class="col-md-10"> <div class="row"> ' +
            '<div class="col-xxl-3 col-md-4"><div class="history-box mb-3"> <div class="form-group form-outline systolicclserr' + ctCnt + '"><label class="float-label">Systolic (mmHg)</label><input type="text" class="form-control blood_pressure systoliccls' + ctCnt + ' valcls' + ctCnt + '" id="systolic_' + ctCnt + '" name="blood_pressure[systolic]"  placeholder=""></div></div></div>' +
            '<div class="col-xxl-3 col-md-4"> <div class="history-box mb-3"> <div class="form-group form-outline diastolicclserr"><label class="float-label">Diastolic (mmHg)</label><input type="text" class="form-control blood_pressure diastoliccls valcls' + ctCnt + '" id="diastolic_' + ctCnt + '" name="blood_pressure[diastolic]" placeholder=""></div></div></div>' +
            '<div class="col-xxl-3 col-md-4"> <div class="history-box mb-3"> <div class="form-group form-outline pulseclserr"><label class="float-label">Pulse (bpm)</label><input type="text" class="form-control blood_pressure pulsecls valcls' + ctCnt + '" id="pulse_' + ctCnt + '"  name="blood_pressure[pulse]" placeholder=""></div></div></div>' +
            '<div class="col-xxl-3 col-md-4"> <div class="history-box mb-3"> <div class="form-group form-outline"><label class="float-label">Report Date</label><input type="text" class="form-control bpdate"  id="reportdate' + ctCnt + '" name="blood_pressure[bpdate]" placeholder=""></div></div></div>' +
            '<div class="col-xxl-3 col-md-4"> <div class="history-box"> <div class="form-group form-outline bptimeclserr"><label class="float-label">Report Time</label><input type="text" class="form-control bptime bptimecls"  id="bptime" name="blood_pressure[bptime]" placeholder=""></div></div></div>' +
            '<input type="hidden" class="form-control coucetype"  id="coucetype' + ctCnt + '" name="blood_pressure[sourcetype]" value="' + sourceType + '"><input type="hidden" name="hasvalue" id="hasvalue_' + ctCnt + '" /></div></div><div class="col-md-2"> <div class="btn_alignbox justify-content-end">' +
            '<button type="button" class="opt-btn submitbp_' + ctCnt + '" id="submitbpbtn' + ctCnt + '" onclick="submitIntakeForm(\'' + type + '\',\'' + ctCnt + '\')"><span class="material-symbols-outlined success">check</span></button><a class="opt-btn danger-icon" onclick="remove(\'' + ids + '\',\'' + ctCnt + '\')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>' +
            '</div></div></div></div></form></div>';

        var idcn = ctCnt - 1;

        console.log(idcn);

        $('.appendbp').append(bphtml);
        // $('#bloodpressure_'+idcn).after(bphtml);
        datetimePicker();

        ctCnt++;
        $('.no-records').hide();


    }

    function submitIntakeForm(formtype, cnt) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateBpForms(cnt);
        hasFormValue(cnt);
        if ($("#intakeform_" + cnt).valid()) {
            $("#submitbpbtn" + cnt).prop('disabled', true);
            let formdata = $("#intakeform_" + cnt).serialize();
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