<?php $title = 'Weight' ; ?>

@include('frontend.medicalhistory.header.chart')


<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fwt-bold"></h5>
    <div class="btn_alignbox">
        <a onclick="addWeight()" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="history-wrapperBody">
    <div class="row">
         <?php $cnt = 1; ?>
        <div id="weight_{{$cnt}}" class="col-12 appendweight">
        </div>

          
            <div class="col-12">
            @if(!empty(!$medicathistoryDetails->isEmpty()))
            @foreach($medicathistoryDetails as $bpd)

            <div class="col-12 weightcls_{{$bpd->weight_tracker_uuid}} weightclsm" id="weight_{{$cnt}}">
                <div class="inner-history" id="weight_{{$bpd->weight_tracker_uuid}}">
                    <div class="row">
                        <div class="col-sm-10 col-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="history-box">
                                        <h6>Weight(kg/lbs)</h6>
                                        <p>{{$bpd->weight}} {{$bpd->unit}}</p>
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

                                <div class="col-xxl-8 col-md-4">
                                    <div class="history-box">
                                        <h6>Source Type</h6>
                                        @if(isset($bpd->device_image) && $bpd->rpm_deviceid != null)
                                            <div class="user_inner ">
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
                                    <li><a onclick="editMHSection('{{$bpd->weight_tracker_uuid}}','weight')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                    <li><a onclick="deleteMHSection('{{$bpd->weight_tracker_uuid}}','weight')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
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
                                    <span class="update-info mx-1"></span>
                                    <small>Last updated: </small><small class="ms-1">@if(isset($bpd->updated_at) && $bpd->updated_at != '')
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




<script>
    function deleteMHSection(key, type) {
        swal({
            text:'Are you sure you want to delete the medical history?',
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

    function addWeight() {
        var mdcls = $('.weightclsm').length;
        var ctCnt = mdcls + 1;
        console.log(ctCnt)
        var type = 'weight';
        var isheight = '{{$isheight}}' ;
        
        var highthtml ='';
        if( isheight == 0 ){
            highthtml =`<div class="col-md-6 mb-3">
                                <div class="history-box"> 
                                    <div class="form-group form-outline heightclserr${ctCnt} heightclserr">
                                        <label class="float-label">Height (cm or inches)</label>
                                        <input type="text" class="form-control hieghtcls${ctCnt} heightunitcls" id="Height${ctCnt}" name="height[height]"  placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="history-box">
                                    <div class="form-group form-floating heightunitclserr${ctCnt}"> 
                                        <select class="form-select heightunitcls${ctCnt}" name="height[unit]" placeholder="">
                                            <option value="">Select Unit Type</option>
                                            <option value="cm" selected>cm</option>
                                            <option value="inches">inches</option>
                                        </select>
                                         <label class="select-label">Unit Type</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control coucetype"  id="coucetype'+ctCnt+'" name="height[sourcetype]" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif>`;
        }
       

        var bphtml =
            `<div class="col-12 weightclsm" id="weight_${ctCnt}"> <form method="POST" id="intakeformweight_${ctCnt}" autocomplete="off">@csrf
            <div class="inner-history"> 
            <div class="row align-items-start"> 
                <div class="col-md-10"> 
                    <div class="row"> 
                        <div class="col-md-6 mb-3"> 
                            <div class="history-box"> 
                                <div class="form-group form-outline weightclserr${ctCnt}"> 
                                    <label class="float-label">Weight(kg or lbs)</label>
                                    <input type="text" class="form-control weightcls${ctCnt}" id="weight${ctCnt}" name="weight[weight]" placeholder=""> \
                                </div> 
                            </div> 
                        </div> 
                        <div class="col-md-6 mb-3"> 
                            <div class="history-box"> 
                                <div class="form-group form-floating weightunitclserr${ctCnt}"> 
                                    <select class="form-select weightunitcls${ctCnt}" name="weight[unit]" placeholder=""> 
                                        <option value="">Select Unit Type</option>
                                        <option value="kg">kg</option> 
                                        <option value="lbs">lbs</option> 
                                    </select> 
                                    <label class="select-label">Unit Type</label>
                                </div> 
                            </div> 
                        </div> 
                        <div class="col-md-6"> 
                            <div class="history-box mb-3"> 
                                <div class="form-group form-outline">
                                    <label class="float-label">Report Date</label>
                                    <input type="text" class="form-control bpdate"  id="reportdate_${ctCnt}" name="weight[reportdate]" placeholder="">
                                </div>
                            </div>
                        </div>${highthtml}
                        <input type="hidden" class="form-control coucetype" id="coucetype${ctCnt}" name="weight[sourcetype]" ' +
                        '@if(Session::get("user.userType") == "patient") value="2" @else value="3" @endif> 
                    </div> 
                </div> 
                <div class="col-md-2"> 
                    <div class="btn_alignbox justify-content-end"> 
                        <button type="button" class="opt-btn" onclick="submitIntakeForm('weight',${ctCnt})" id="submitweightbtn_${ctCnt}" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined success">check</span> 
                        </button> 
                        <a class="opt-btn danger-icon" onclick="removeWeight('weight',${ctCnt})" data-bs-toggle="dropdown" aria-expanded="false"> 
                            <span class="material-symbols-outlined danger">close</span> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form></div>`;

        var idcn = ctCnt - 1;
        $('.appendweight').append(bphtml);
        datetimePicker();
        ctCnt++;
    }

    function removeWeight(type, cnt) {
        console.log(type + cnt)
        $('#' + type + '_' + cnt).remove();
    }

    $(document).ready(function() {


    });
    function validateFrom(cnt){
         $("#intakeformweight_"+cnt).validate({
            rules: {
                "weight[weight]": {
                    required: true,
                    number: true,
                    min:1,
                },
                "weight[unit]": {
                    required: true,
                },
                "height[height]": {
                    required: true,
                    number: true,
                    // min:1,
                },
            },
            messages: {
                "weight[weight]": {
                    required: 'Please enter the weight.',
                    number: 'Please enter a numeric value',
                    min: 'Please enter a value greater than 0',
                },
                "weight[unit]": {
                    required: 'Please select unit type',
                },
                "height[height]": {
                    required :'Please enter height.',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("weightcls"+cnt)) {
                    error.insertAfter(".weightclserr"+cnt);
                } else if (element.hasClass("weightunitcls"+cnt)) {
                    error.insertAfter(".weightunitclserr"+cnt);
                } else if (element.hasClass("heightunitcls")) {
                    error.insertAfter(".heightclserr");
                } else {
                    error.insertAfter(element);
                }
            },
        });
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

    function submitIntakeForm(formtype,cnt) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateFrom(cnt);
        if ($("#intakeformweight_"+cnt).valid()) {
            $("#submitweightbtn_"+cnt).prop('disabled', true);
            let formdata = $("#intakeformweight_"+cnt).serialize();
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
</script>