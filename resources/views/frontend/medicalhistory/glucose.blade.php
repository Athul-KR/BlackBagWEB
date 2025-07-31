

<?php $title = 'Blood Glucose' ; ?>
@include('frontend.medicalhistory.header.chart')

<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fwt-bold">Blood Glucose Readings</h5>
    <div class="btn_alignbox">
        <a onclick="addGlucose()" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>


<div class="history-wrapperBody">
    <div class="row">
            <?php $cnt = 1; ?>
            <div id="glucose_{{$cnt}}" class="col-12 glucls appendglucose">
            </div>
      
            <div class="col-12">
                @if(!empty(!$medicathistoryDetails->isEmpty()))
                @foreach($medicathistoryDetails as $bpd)
              
               
                <?php $sourceType = isset($sourceTypes[$bpd->source_type_id]) ? $sourceTypes[$bpd->source_type_id]['source_type'] : '';  ?>

                <div id="glucose_{{$cnt}}" class="col-12 glucosecls_{{$bpd->glucose_tracker_uuid}} glucls">
                    <div class="inner-history" id="glucose_{{$bpd->glucose_tracker_uuid}}">
                        <div class="row">
                            <div class="col-sm-10 col-9">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="history-box mb-3">
                                            <h6>Glucose Value (mg/dL)</h6>
                                            <p>@if(isset($bpd->bgvalue) && $bpd->bgvalue != '') {{$bpd->bgvalue}} @else -- @endif</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="history-box mb-3">
                                            <h6>HbA1C (%)</h6>
                                            <p>@if(isset($bpd->a1c) && $bpd->a1c != '') {{$bpd->a1c}} @else -- @endif</p>
                                        </div>
                                    </div>
                                    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                                    <div class="col-md-4">
                                        <div class="history-box mb-3">
                                            <h6>Report Date</h6>
                                            <p><?php echo $corefunctions->timezoneChange($bpd->reportdate, "M d, Y") ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="history-box mb-3">
                                            <h6>Report Time</h6>
                                            <p><?php echo $corefunctions->timezoneChange($bpd->reporttime, "h:i A") ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                            <p>{{$sourceType}}</p>
                                            @endif
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
                                        <li><a onclick="editMHSection('{{$bpd->glucose_tracker_uuid}}','glucose')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                        <li><a onclick="deleteMHSection('{{$bpd->glucose_tracker_uuid}}','glucose')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
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
                                        <small>Last updated: </small><small class="ms-1 me-1"> @if(isset($bpd->updated_at) && $bpd->updated_at != '')
                                            <?php echo $corefunctions->timezoneChange($bpd->updated_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($bpd->updated_at, "h:i A") ?>
                                            @else <?php echo $corefunctions->timezoneChange($bpd->updated_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($bpd->created_at, "h:i A") ?> @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $cnt++; ?>
                @endforeach
                @else
            
                <div class="flex justify-center" id="norecords">
                    <div class="text-center  no-records-body">
                        <img src="{{asset('images/nodata.png')}}"
                            class=" h-auto" alt="no records">
                        <p>No records found</p>
                    </div>
                </div>
                @endif

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
    $(document).ready(function() {
        hasFormValue(1);
    });
    function validateGlucoseForms(cnt){
        $("#intakeformglocuse_"+cnt).validate({
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
                hasvalue: "required",
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
                hasvalue: "Please enter any one of the record",
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("glucosecls"+cnt)) {
                    error.insertAfter(".glucoseclserr"+cnt);
                } else if (element.hasClass("a1ccls")) {
                    error.insertAfter(".a1cclserr");
                } else if (element.hasClass("glucosetimecls"+cnt)) {
                    error.insertAfter(".glucosetimeclserr"+cnt);
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
        $("#hasvalue_"+cnt).val('');

        $(".valcls"+cnt).each(function() {
            if ($(this).val() != '') {
                hasVal = 1;
            }
        });
        $("#hasvalue_"+cnt).val(hasVal);
        $("#hasvalue_"+cnt).valid();
    }

    function addGlucose() {
        var mdcls = $('.glucls').length;
        var ctCnt = mdcls + 1;
        var sourceType = "{{ Session::get('user.userType') == 'patient' ? 2 : 3 }}";
        var type = 'glucose';

        var glucosehtml =
            '<div class="col-12 glucls" id="glucose_' + ctCnt + '"><form method="POST" id="intakeformglocuse_'+ ctCnt + '" autocomplete="off">@csrf <div class="inner-history"> <div class="row align-items-start"> <div class="col-md-10"> <div class="row"> ' +
            '<div class="col-xl-4 col-md-6"><div class="history-box mb-3"> <div class="form-group form-outline glucoseclserr' + ctCnt + '"><label class="float-label">Glucose Value (mg/dL)</label><input type="text" class="form-control glucosecls'+ ctCnt + ' valcls'+ ctCnt + '" id="glucose_' + ctCnt + '" name="glucose[glucose]"  placeholder=""></div></div></div>' +
            '<div class="col-xl-4 col-md-6"> <div class="history-box mb-3"> <div class="form-group form-outline a1cclserr"><label class="float-label">HbA1C (%)</label><input type="text" class="form-control a1ccls valcls'+ ctCnt + '" id="hba1c_' + ctCnt + '" name="glucose[hba1c]" placeholder=""></div></div></div>' +
            '<div class="col-xl-4 col-md-6"> <div class="history-box mb-3"> <div class="form-group form-outline"><label class="float-label">Report Date</label><input type="text" class="form-control bpdate"  id="reportdate' + ctCnt + '" name="glucose[glucosedate]" placeholder=""></div></div></div>' +
            '<div class="col-xl-4 col-md-6"> <div class="history-box"> <div class="form-group form-outline glucosetimeclserr' + ctCnt + '"><label class="float-label">Report Time</label><input type="text" class="form-control bptime glucosetimecls' + ctCnt + '"  id="bptime' + ctCnt + '" name="glucose[glucosetime]" placeholder=""></div></div></div>' +
            '<input type="hidden" class="form-control coucetype"  id="coucetype' + ctCnt + '" name="glucose[sourcetype]" value="' + sourceType + '"><input class="haserr' + ctCnt + '" type="hidden" name="hasvalue" id="hasvalue_'+ ctCnt + '" /></div></div><div class="col-md-2"> <div class="btn_alignbox justify-content-end">' +
            '<button type="button" class="opt-btn" id="submitglucosebtn_'+ ctCnt + '" onclick="submitIntakeForm(\'' + type + '\',\'' + ctCnt + '\')" aria-expanded="false"><span class="material-symbols-outlined success">check</span></button><a class="opt-btn danger-icon"  onclick="remove(\'' + type + '\',\'' + ctCnt + '\')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>' +
            '</div></div></div></div></form></div>';

        var idcn = ctCnt - 1;
        $('.appendglucose').append(glucosehtml);
        $('#norecords').hide();


        ctCnt++;
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


    function submitIntakeForm(formtype, cnt) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateGlucoseForms(cnt);
        hasFormValue(cnt);
        if ($("#intakeformglocuse_"+cnt).valid()) {
            $("#submitglucosebtn_"+cnt).prop('disabled', true);
            let formdata = $("#intakeformglocuse_"+cnt).serialize();
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

                }, 500);
            }
        }
    }
</script>