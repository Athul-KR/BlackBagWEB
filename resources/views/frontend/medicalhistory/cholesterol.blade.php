                        <?php $title = 'Cholesterol Levels' ; ?>
                        @include('frontend.medicalhistory.header.chart')
                        <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                            <h5 class="fwt-bold">Cholesterol Readings</h5>
                            <div class="btn_alignbox">
                                <a onclick="addCh()" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                            </div>
                        </div>
                        <div class="history-wrapperBody">
                            <div class="row">
                                <?php $cnt = 1; ?>
                                    <div id="cholestrol_{{$cnt}}" class="col-12 chscls appendcholesterol">
                                    </div>
                                
                                    <div class="col-12">
                                    @if(!empty(!$medicathistoryDetails->isEmpty()))
                                    @foreach($medicathistoryDetails as $bpd)
                                    <?php $sourceType = isset($sourceTypes[$bpd->source_type_id]) ? $sourceTypes[$bpd->source_type_id]['source_type'] : '';  ?>

                                    <div class="col-12 cholesterolcls_{{$bpd->cholestrol_tracker_uuid}} chscls" id="cholestrol_{{$cnt}}">
                                        <div class="inner-history" id="cholesterol_{{$bpd->cholestrol_tracker_uuid}}">
                                            <div class="row">
                                                <div class="col-sm-10 col-9">

                                                    <div class="row">
                                                        <div class="col-xl-4 col-md-6">
                                                            <div class="history-box mb-3">
                                                                <h6>Fasting</h6>
                                                                <p>@if(isset($bpd->fasting) && $bpd->fasting == '1') Yes @else No @endif</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6">
                                                            <div class="history-box mb-3">
                                                                <h6>Total Cholesterol (mg/dL)</h6>
                                                                <p>@if(isset($bpd->cltotal) && $bpd->cltotal != '') {{$bpd->cltotal}} @else -- @endif</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6">
                                                            <div class="history-box mb-3">
                                                                <h6>HDL (mg/dL)</h6>
                                                                <p>@if(isset($bpd->HDL) && $bpd->HDL != '') {{$bpd->HDL}} @else -- @endif</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6">
                                                            <div class="history-box mb-3">
                                                                <h6>LDL (mg/dL)</h6>
                                                                <p>@if(isset($bpd->LDL) && $bpd->LDL != '') {{$bpd->LDL}} @else -- @endif</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6">
                                                            <div class="history-box mb-3">
                                                                <h6>Triglycerides (mg/dL)</h6>
                                                                <p>@if(isset($bpd->triglycerides) && $bpd->triglycerides != '') {{$bpd->triglycerides}} @else -- @endif</p>
                                                            </div>
                                                        </div>
                                                        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                                                        <div class="col-xl-4 col-md-6">
                                                            <div class="history-box">
                                                                <h6>Report Date</h6>
                                                                <p><?php echo $corefunctions->timezoneChange($bpd->reportdate, "M d, Y") ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6">
                                                            <div class="history-box">
                                                                <h6>Report Time</h6>
                                                                <p><?php echo $corefunctions->timezoneChange($bpd->reporttime, "h:i A") ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6">
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
                                                            <li><a onclick="editMHSection('{{$bpd->cholestrol_tracker_uuid}}','cholesterol')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                            <li><a onclick="deleteMHSection('{{$bpd->cholestrol_tracker_uuid}}','cholesterol')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
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
                                                            <small>Last updated: </small><small class="ms-1"> @if(isset($bpd->updated_at) && $bpd->updated_at != '')
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
                            $(document).ready(function() {
                                hasFormValue();
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
                                        hasvalue: "required",
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
                                        hasvalue: "Please enter any one of the record",
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

                            jQuery.validator.addMethod("lesserThanOrEqualToNow", function(value, element) {
                                const dateField = $(element).closest('form').find('.repotdate').val();
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

                            function intiateDate() {
                                $('.repotdate').datetimepicker({
                                    format: 'MM/DD/YYYY',
                                    useCurrent: false,
                                    maxDate: moment().endOf('day'), // Ensures today is selectable
                                });

                                $('.reporttime').datetimepicker({
                                    format: 'hh:mm A',
                                    locale: 'en',
                                    useCurrent: false, // Prevents setting current time by default
                                    stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
                                    timeZone: userTimeZone
                                });
                            }

                            function addCh() {

                                var mdcls = $('.chscls').length;
                                var ctCnt = mdcls + 1;
                                var sourceType = "{{ Session::get('user.userType') == 'patient' ? 2 : 3 }}";
                                var type = 'cholesterol';
                                var typidse = 'cholestrol';
                                var bphtml =
                                    '<form method="POST" id="intakeformcholesterol_' + ctCnt + '" autocomplete="off">@csrf'+
                                    '<div class="col-12 chscls" id="cholestrol_' + ctCnt + '"> <div class="inner-history"> <div class="row align-items-start"> <div class="col-md-10"> <div class="row"> ' +
                                    '<div class="col-md-12"> <div class="history-box"> <div class="form-check form-switch mb-3"><input type="checkbox" class="form-check-input fasting" id="fasting' + ctCnt + '"  name="cholesterol[fasting]" placeholder="Fasting (mg/dL)"><label class="form-check-label" for="fasting">Fasting</label></div></div></div>' +
                                    '<div class="col-xl-4 col-md-6"><div class="history-box mb-3"> <div class="form-group form-outline chclserr' + ctCnt + '"><label class="float-label">Total Cholesterol (mg/dL)</label><input type="text" class="form-control chcls' + ctCnt + ' valcls' + ctCnt + '" id="cholesterol_' + ctCnt + '" name="cholesterol[cholesterol]"  placeholder=""></div></div></div>' +
                                    '<div class="col-xl-4 col-md-6"> <div class="history-box mb-3"> <div class="form-group form-outline hdlclserr' + ctCnt + '"><label class="float-label">HDL (mg/dL)</label><input type="text" class="form-control hdlcls' + ctCnt + ' valcls' + ctCnt + '" id="hdl' + ctCnt + '" name="cholesterol[hdl]" placeholder=""></div></div></div>' +
                                    '<div class="col-xl-4 col-md-6"> <div class="history-box mb-3"> <div class="form-group form-outline ldlclserr' + ctCnt + '"><label class="float-label">LDL (mg/dL)</label><input type="text" class="form-control ldlcls' + ctCnt + ' valcls' + ctCnt + '" id="ldl' + ctCnt + '"  name="cholesterol[ldl]" placeholder=""></div></div></div>' +
                                    '<div class="col-xl-4 col-md-6"> <div class="history-box mb-md-0 mb-3"> <div class="form-group form-outline triclserr' + ctCnt + '"><label class="float-label">Triglycerides (mg/dL)</label><input type="text" class="form-control tricls' + ctCnt + ' valcls' + ctCnt + '" id="triglycerides' + ctCnt + '"  name="cholesterol[triglycerides]" placeholder=""></div></div></div>' +

                                    '<div class="col-xl-4 col-md-6"> <div class="history-box mb-md-0 mb-3"> <div class="form-group form-outline"><label class="float-label">Report Date</label><input type="text" class="form-control repotdate bpdate"  id="reportdate" name="cholesterol[chdate]" placeholder=""></div></div></div>' +
                                    '<div class="col-xl-4 col-md-6"> <div class="history-box"> <div class="form-group form-outline chtimeclserr' + ctCnt + '"><label class="float-label">Report Time</label><input type="text" class="form-control reporttime bptime chtimecls' + ctCnt + '"  id="reporttime" name="cholesterol[chtime]" placeholder=""></div></div></div>' +
                                    '<input type="hidden" class="form-control coucetype"  id="coucetype' + ctCnt + '" name="cholesterol[sourcetype]" value="' + sourceType + '"><input type="hidden" name="hasvalue" id="hasvalue_' + ctCnt + '" /></div></div><div class="col-md-2"> <div class="btn_alignbox justify-content-end">' +
                                    '<button type="button" class="opt-btn" id="submitchbtn_' + ctCnt + '" onclick="submitIntakeForm(\'' + type + '\',\'' + ctCnt + '\')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></button><a class="opt-btn danger-icon"  onclick="remove(\'' + typidse + '\',\'' + ctCnt + '\')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>' +
                                    '</div></div></div></div></div></form>';


                                var idcn = ctCnt - 1;
                                console.log(idcn);
                                $('.appendcholesterol').append(bphtml);


                                ctCnt++;
                                intiateDate()
                            }

                            function submitIntakeForm(formtype, cnt) {
                                var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
                                validateCholesterolForms(cnt);
                                hasFormValue(cnt);
                                if($("#intakeformcholesterol_"+cnt).valid()){
                                    $("#submitchbtn_"+cnt).prop('disabled', true);
                                    let formdata = $("#intakeformcholesterol_"+cnt).serialize();
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