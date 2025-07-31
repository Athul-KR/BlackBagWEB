<?php $title = 'Height'; ?>

@include('frontend.medicalhistory.header.chart')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fwt-bold"></h5>
    <div class="btn_alignbox">
        <a onclick="addHeight()" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="history-wrapperBody">
    <div class="row">
        <?php $cnt = 1; ?>
        <div id="height_{{$cnt}}" class="col-12">
        </div>


        <div class="col-12">
            @if(!empty(!$medicathistoryDetails->isEmpty()))
            @foreach($medicathistoryDetails as $bpd)

            <div class="col-12 heightcls_{{$bpd->height_tracker_uuid}} heightclsm" id="height_{{$cnt}}">
                <div class="inner-history" id="height_{{$bpd->height_tracker_uuid}}">
                    <div class="row">
                        <div class="col-sm-10 col-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="history-box">
                                        <h6>Height(Cm/Inches/Ft)</h6>
                                        <p>{{$bpd->height}} {{$bpd->unit}}</p>
                                    </div>
                                </div>
                                <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                                <div class="col-xxl-3 col-md-4">
                                    <div class="history-box mb-3">
                                        <h6>Report Date</h6>
                                        <p><?php echo $corefunctions->timezoneChange($bpd->reportdate, "M d, Y") ?></p>
                                    </div>
                                </div>
                                <?php $sourceType = isset($sourceTypes[$bpd->source_type_id]) ? $sourceTypes[$bpd->source_type_id]['source_type'] : '';  ?>

                                <div class="col-xxl-3 col-md-4">
                                    <div class="history-box">
                                        <h6>Source Type</h6>

                                        <p>{{$sourceType}}</p>

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
                                    <li><a onclick="editMHSection('{{$bpd->height_tracker_uuid}}','height')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                    <li><a onclick="deleteMHHieghtSection('{{$bpd->height_tracker_uuid}}','height')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                        <div class="col-12">
                            <div class="history-info flex-wrap">
                                <h6 class="mb-0">
                                    @if(isset( $userDetails[$bpd->created_by])) {{$userDetails[$bpd->created_by]['first_name']}} @endif
                                    @if(isset($clinicUser[$bpd->created_by]['designation']['name'])), {{$clinicUser[$bpd->created_by]['designation']['name']}}@else{{''}}@endif

                                </h6>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="update-info ms-1 me-1"></span>
                                    <small>Last updated: </small> <small class="ms-1 me-1"> @if(isset($bpd->updated_at) && $bpd->updated_at != '')
                                        <?php echo $corefunctions->timezoneChange($bpd->updated_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($bpd->updated_at, "h:i A") ?>
                                        @else <?php echo $corefunctions->timezoneChange($bpd->created_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($bpd->created_at, "h:i A") ?> @endif
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

            <div class="flex justify-center">
                <div class="text-center  no-records-body">
                    <img src="{{asset('images/nodata.png')}}"
                        class=" h-auto" alt="no records">
                    <p>No records found</p>
                </div>
            </div>

            @endif
            <div class="col-12">



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
            function deleteMHHieghtSection(key, type) {
                swal({
                    text: 'Are you sure you want to delete the medical history?',
                    icon: "warning",
                    buttons: {
                        cancel: "Cancel",
                        confirm: {
                            text: "OK",
                            value: true,
                            closeModal: false // Keeps the modal open until AJAX is done
                        }
                    },
                    dangerMode: true
                }).then((willConfirm) => {
                    if (willConfirm) {
                        $.ajax({
                            url: '{{ url("/medicalhistory/deleteform")}}',
                            type: "post",
                            data: {
                                'formtype': type,
                                'key': key,
                                '_token': $('input[name=_token]').val()
                            },
                            success: function(data) {
                                if (data.success == 1) {
                                    swal.close();
                                    $('#' + type + '_' + key).remove();
                                    console.log('test' + type)
                                    if (type == 'weight' || type == 'height') {

                                        getmedicalhistoryDatapm(type);
                                    } else {

                                        getmedicalhistoryData(type);
                                    }
                                } else {

                                }
                            },
                            error: function(xhr) {

                                handleError(xhr);
                            },
                        });
                    }
                });
            }

            function addHeight() {
                var mdcls = $('.heightclsm').length;
                var ctCnt = mdcls + 1;

                var type = 'height';
                var bphtml =
                    `
            <div class="col-12 heightclsm"  id="height_${ctCnt}"> 
             <form method="POST" id="intakeformheight_${ctCnt}" autocomplete="off">@csrf
            <div class="inner-history"> 
                <div class="row align-items-start"> 
                    <div class="col-md-10"> 
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="history-box"> 
                                    <div class="form-group form-outline heightclserr${ctCnt}">
                                        <label class="float-label">Height (cm or inches)</label>
                                        <input type="text" class="form-control hieghtcls${ctCnt}" id="Height${ctCnt}" name="height[height]"  placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="history-box">
                                    <div class="form-group form-floating heightunitclserr${ctCnt}"> 
                                        <select class="form-select heightunitcls${ctCnt}" name="height[unit]" placeholder="">
                                            <option value="">Select Unit Type</option>
                                            <option value="cm">cm</option>
                                            <option value="inches">inches</option>
                                            <option value="ft">ft</option>
                                        </select>
                                         <label class="select-label">Unit Type</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="history-box mb-3"> 
                                    <div class="form-group form-outline">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control bpdate"  id="reportdate${ctCnt}" name="height[reportdate]" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control coucetype"  id="coucetype'+ctCnt+'" name="height[sourcetype]" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif>
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="btn_alignbox justify-content-end">
                            <button type="button" class="opt-btn" onclick="submitIntakeForm('height',${ctCnt})" id="submitheightbtn_${ctCnt}" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></button><a class="opt-btn danger-icon" onclick="remove('height',${ctCnt})" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </form></div>`;

                var idcn = ctCnt - 1;
                $('#height_1').before(bphtml);
                datetimePicker();
                ctCnt++;
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

            function submitIntakeForm(formtype, cnt) {
                var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
                validateFrom(cnt)
                if ($("#intakeformheight_" + cnt).valid()) {
                    $("#submitheightbtn_" + cnt).prop('disabled', true);
                    let formdata = $("#intakeformheight_" + cnt).serialize();
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
                                getmedicalhistoryDatapm(formtype);
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


            function validateFrom(cnt) {


                $("#intakeformheight_" + cnt).validate({
                    rules: {
                        "height[height]": {
                            required: true,
                            number: true,
                            min: 1,
                        },
                        "height[unit]": {
                            required: true,
                        },
                    },
                    messages: {
                        "height[height]": {
                            required: 'Please enter the height.',
                            number: 'Please enter a numeric value',
                            min: 'Please enter a value greater than 0',
                        },
                        "height[unit]": {
                            required: 'Please select unit type.',
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.hasClass("hieghtcls" + cnt)) {
                            error.insertAfter(".heightclserr" + cnt);
                        } else if (element.hasClass("heightunitcls" + cnt)) {
                            error.insertAfter(".heightunitclserr" + cnt);
                        } else {
                            error.insertAfter(element);
                        }
                    },

                });
            }
        </script>