<?php $title = 'Oxygen Saturations' ; ?>

@include('frontend.medicalhistory.header.chart')

<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fw-medium">Oxygen Saturations Reading</h5>
    <div class="btn_alignbox">
        <a href="javascript:void(0);" onclick="addSaturation();" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="history-wrapperBody">
    <div class="row">
        <div class="col-12 saturation-append">
        </div>
        <div class="col-12">
            @if(!empty(!$medicathistoryDetails->isEmpty()))
            @foreach($medicathistoryDetails as $hsk => $hsv)
            <?php $sourceType = isset($hsv->source_type_id) && $hsv->source_type_id == 1 ? 'Intake Form' : (isset($hsv->source_type_id) && $hsv->source_type_id == 2 ? 'Patient' : 'Clinic');  ?>
            <div class="inner-history oxygen-saturationscls_{{$hsv->oxygen_saturation_uuid}}">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-xxl-3 col-md-3">
                                <div class="history-box">
                                    <h6>Saturation</h6>
                                    <p>@if(isset($hsv->saturation) && $hsv->saturation != '') {{$hsv->saturation}}% @else -- @endif</p>
                                </div>
                            </div>
                            <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                            <div class="col-xxl-3 col-md-3">
                                <div class="history-box mb-3">
                                    <h6>Report Date</h6>
                                    <p><?php echo $corefunctions->timezoneChange($hsv->reportdate, "M d, Y") ?></p>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-3">
                                <div class="history-box mb-3">
                                    <h6>Report Time</h6>
                                    <p><?php echo $corefunctions->timezoneChange($hsv->reporttime, "h:i A") ?></p>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-3">
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
                    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                    @if($hsv->created_by == Session::get('user.userID'))
                    <div class="col-3">
                        <div class="btn_alignbox justify-content-end">
                            <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a onclick="editMHSection('{{$hsv->oxygen_saturation_uuid}}','oxygen-saturations')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                <li><a onclick="deleteMHSection('{{$hsv->oxygen_saturation_uuid}}','oxygen-saturations')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="col-12">
                        <div class="history-info flex-wrap">
                            <h6 class="mb-0">
                                @if(isset($userDetails[$hsv->created_by])) {{$userDetails[$hsv->created_by]['first_name']}}{{$userDetails[$hsv->created_by]['last_name']}} @endif
                                @if(isset($clinicUser[$hsv->created_by]['designation']['name'])), {{$clinicUser[$hsv->created_by]['designation']['name']}}@else{{''}}@endif
                            </h6>
                            <div class="d-flex align-items-center flex-wrap">
                                <span class="update-info mx-1"></span>
                                <small>Last updated:</small> <small class="ms-1"> @if(isset($hsv->updated_at) && $hsv->updated_at != '')
                                    <?php echo $corefunctions->timezoneChange($hsv->updated_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($hsv->updated_at, "h:i A") ?>
                                    @else <?php echo $corefunctions->timezoneChange($hsv->created_at, "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($hsv->created_at, "h:i A") ?> @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    function addSaturation() {
        var saturation = $('.oxsaturationcls').length;
        var ctCnt = saturation + 1;
        const saturationCount = document.querySelectorAll('div.saturation-append .row').length - 1;
        const saturationHtml = `
            <div class="inner-history saturation-item oxsaturationcls"> 
            <form method="POST" id="saturationform_${ctCnt}" autocomplete="off">
            @csrf
                <div class="row align-items-start"> 
                    <div class="col-md-10"> 
                        <div class="row"> 
                            <div class="col-md-4"> 
                                <div class="history-box"> 
                                    <div class="form-group form-outline saturationclserr${ctCnt}">
                                        <label class="float-label">Saturation %</label>
                                        <input type="text" class="form-control saturationcls${ctCnt}" id="saturation${ctCnt}" name="saturation" placeholder="">
                                    </div> 
                                </div>
                            </div>
                            <input type="hidden" name="sourcetype" id="sourcetype${ctCnt}" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                            <div class="col-md-4"> 
                                <div class="history-box"> 
                                    <div class="form-group form-outline">
                                        <label class="float-label">Report Date</label>
                                        <input type="text" class="form-control reportdate"  id="reportdate${ctCnt}" name="reportdate" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="history-box"> 
                                    <div class="form-group form-outline reporttimeclserr">
                                        <label class="float-label">Report Time</label>
                                        <input type="text" class="form-control reporttime reporttimecls" id="reporttime${ctCnt}" name=reporttime" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="btn_alignbox justify-content-end">
                            <button type="button" class="opt-btn" id="submitsaturationbtn_${ctCnt}" href="javascript:void(0);" onclick="submitSaturationForm('oxygen-saturations','${ctCnt}');" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">check</span>
                            </button>
                            <a class="opt-btn danger-icon" href="javascript:void(0);" onclick="removeSaturation(this);" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">close</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            </div>
        `;

        // Append the new vaccine select to the vaccine-append container
        $('.saturation-append').append(saturationHtml);
        $('.no-records').hide();
        datetimePicker();
    }

    function datetimePicker() {
        // $('.reportdate').datetimepicker({
        //     format: 'MM/DD/YYYY',
        //     useCurrent: false,
        //     maxDate: moment().endOf('day'), // Ensures today is selectable
        // });

        // $('.reporttime').datetimepicker({
        //     format: 'hh:mm A',
        //     locale: 'en',
        //     useCurrent: false, // Prevents setting current time by default
        //     stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
        //     timeZone: userTimeZone
        // });

        var now = moment(); // Get current time

            // Date Picker
            $('.reportdate').datetimepicker({
                format: 'MM/DD/YYYY',
                useCurrent: false,
                maxDate: moment().endOf('day') // Ensures today is selectable
            }).on('dp.change', function (e) {
            
                var selectedDate = e.date; // Get selected date
                var timePicker = $('.reporttime').data("DateTimePicker");
                if (selectedDate) {
                    var isToday = selectedDate.isSame(moment(), 'day'); // Check if selected date is today
                    
                    if (isToday) {
                    timePicker.maxDate(moment()); // Restrict time selection to past & present for today
                        
                        var selectedTime = moment($('.reporttime').val(), 'hh:mm A'); // Get currently selected time

                        if (selectedTime.isAfter(moment())) {
                            $('.reporttime').val(''); // Clear time input if it's in the future
                            $('input, textarea').each(function () {
                                toggleLabel(this);
                            });
                        }
                    } else {
                        timePicker.maxDate(false); // Allow all times for past dates
                    }
                }
            });

            // Time Picker
            $('.reporttime').datetimepicker({
                format: 'hh:mm A',
                locale: 'en',
                useCurrent: false,
                stepping: 5,
            });
    }

    function removeSaturation(element) {
        $(element).closest('.saturation-item').remove();
        if ($('.saturation-item').length == 0) {
            $('.no-records').show();
        }
    }

    function validateSaturationForms(count) {
     
        $("#saturationform_"+count).validate({
            ignore: [],
            rules: {
                saturation: {
                    required : true,
                    number : true,
                    max : 100 ,
                    min : 50 ,
                },
            },
            messages: {
                saturation: {
                    required : "Please enter saturation",
                    number : "Please enter a numeric value.",
                    max : "Please enter a valid value.",
                    min : "Please enter a valid value.",
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("saturationcls"+count)) {
                    error.insertAfter('.saturationclserr'+count);
                } else {
                    error.insertAfter(element);
                }
            },
        });
    }

    function validateEditSaturationForms() {
        $("#editsaturationform").validate({
            ignore: [],
            rules: {
                editsaturation: {
                    required : true,
                    number : true,
                    max : 100,
                    min : 50,
                },
            },
            messages: {
                editsaturation: {
                    required : "Please enter saturation",
                    number : "Please enter a numeric value.",
                    max : "Please enter a valid value.",
                    min : "Please enter a valid value.",
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("editsaturationcls")) {
                    error.insertAfter('.editsaturationclserr');
                } else {
                    error.insertAfter(element);
                }
            },
        });
    }

    function submitSaturationForm(formtype,count) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateSaturationForms(count);
        if ($("#saturationform_"+count).valid()) {
            $("#submitsaturationbtn_"+count).prop('disabled', true);
            let formdata = $("#saturationform_"+count).serialize();
            $.ajax({
                url: '{{ url("/intakeform/saturation/store")}}',
                type: "post",
                data: {
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

    function updateSaturationForm(formtype, key) {
        validateEditSaturationForms();
        if ($("#editsaturationform").valid()) {
            let formdata = $("#editsaturationform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/saturation/update")}}',
                type: "post",
                data: {
                    'key': key,
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
                    $('html, body').animate({
                        scrollTop: ($('.error:visible').first().offset().top - 100)
                    }, 500);
                }, 500);
            }
        }
    }
</script>