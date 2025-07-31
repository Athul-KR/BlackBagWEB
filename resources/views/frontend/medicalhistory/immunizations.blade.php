<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fw-medium">Immunizations</h5>
    <div class="btn_alignbox">
        <a href="javascript:void(0);" onclick="addImmunization();" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="row">
    <div class="col-12 immunization-append">
    </div>
    <div class="col-12">
        @if(!empty($medicathistoryDetails))
        @foreach($medicathistoryDetails as $mdk => $mdv)
        <?php $sourceType = isset($mdv['source_type_id']) && $mdv['source_type_id'] == 1 ? 'Intake Form' : (isset($mdv['source_type_id']) && $mdv['source_type_id'] == 2 ? 'Patient' : 'Clinic');  ?>
        <div class="inner-history immunizationscls_{{$mdv['immunization_uuid']}}">
            <div class="row align-items-baseline">
                <div class="col-12">
                    <div class="row">

                        <div class="col-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="history-box">
                                        <h6>Pending Vaccine Name</h6>
                                        <small>@if(isset($mdv['immunization_type']) && $mdv['immunization_type'] != '') {{$mdv['immunization_type']}} @else -- @endif</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="history-box">
                                        <h6>Source Type</h6>
                                        <p>{{$sourceType}}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if($mdv['created_by'] == Session::get('user.userID'))
                        <div class="col-3">
                            <div class="btn_alignbox justify-content-end">
                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a onclick="editMHSection('{{$mdv['immunization_uuid']}}','immunizations')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                    <li><a onclick="deleteMHSection('{{$mdv['immunization_uuid']}}','immunizations')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                        <!-- <div class="col-12"> 
                                <div class="btn_alignbox justify-content-end my-3"> 
                                    <a href="" class="primary align_middle"><span class="material-symbols-outlined">add</span>Add Vaccine Name</a>
                                </div>
                            </div> -->
                        <div class="col-12">
                            <div class="history-info flex-wrap">
                                <h6 class="mb-0">
                                    {{$userDetails[$mdv['created_by']]['first_name']}}{{$userDetails[$mdv['created_by']]['last_name']}}
                                    @if(isset($clinicUser[$mdv['created_by']]['designation']['name'])), {{$clinicUser[$mdv['created_by']]['designation']['name']}}@else{{''}}@endif

                                </h6>
                                <div class="d-flex align-items-center flex-wrap">
                                    <span class="update-info mx-1"></span>
                                    <small>Last updated: </small><small class="ms-1">@if(isset($mdv['updated_at']) && $mdv['updated_at'] != '')
                                        <?php echo $corefunctions->timezoneChange($mdv['updated_at'], "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($mdv['updated_at'], "h:i A") ?>
                                        @else <?php echo $corefunctions->timezoneChange($mdv['created_at'], "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($mdv['created_at'], "h:i A") ?> @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
        <div class="flex justify-center no-records" @if(!empty($medicathistoryDetails)) style="display:none;" @else style="display:block;" @endif>
            <div class="text-center  no-records-body">
                <img src="{{asset('images/nodata.png')}}"
                    class=" h-auto" alt="no records">
                <p>No records found</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        hasFormValue();
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

    function addImmunization() {
        const immunizationCount = document.querySelectorAll('div.immunization-append .row').length - 1;
        const immunizationHtml = `
            <div class="inner-history immunization-item"> 
            <form method="POST" id="immunizationform" autocomplete="off">
            @csrf
                <div class="row align-items-start"> 
                    <div class="col-md-10"> 
                        <div class="row"> 
                            <div class="col-md-12"> 
                                <div class="form-group form-floating">
                                    <select class="form-select valcls" name="immunizations[${immunizationCount}][immunization]" placeholder="">
                                        <option value="">Select Vaccine</option>
                                        @if(!empty($immunizationTypes))
                                            @foreach($immunizationTypes as $imt)
                                                <option value="{{$imt['id']}}">{{$imt['immunization_type']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label class="select-label">Vaccine</label>
                                </div>
                            </div>
                            <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                            <input type="hidden" name="hasvalue" id="hasvalue" />
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="btn_alignbox justify-content-end mt-md-0 mt-3">
                            <button type="button" class="opt-btn" id="submitimmunizationbtn" href="javascript:void(0);" onclick="submitImmunization('immunizations');" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">check</span>
                            </button>
                            <a class="opt-btn danger-icon" href="javascript:void(0);" onclick="removeImmunization(this);" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">close</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            </div> `;

        $('.immunization-append').append(immunizationHtml);
        $('.no-records').hide();
    }

    function removeImmunization(element) {
        $(element).closest('.immunization-item').remove();
        if ($('.immunization-item').length == 0) {
            $('.no-records').show();
        }
    }

    function validateImmunizationForms() {
        $("#immunizationform").validate({
            ignore: [],
            rules: {
                hasvalue: "required",
            },
            messages: {
                hasvalue: "Please enter any one of the record",
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
        });
    }

    function validateEditImmunizationForms() {
        $("#editimmunizationform").validate({
            ignore: [],
            rules: {
                hasvalue: "required",
            },
            messages: {
                hasvalue: "Please enter any one of the record",
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
        });
    }

    function submitImmunization(formtype) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateImmunizationForms();
        hasFormValue();
        if ($("#immunizationform").valid()) {
            $("#submitimmunizationbtn").prop('disabled', true);
            let formdata = $("#immunizationform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/immunization/store")}}',
                type: "post",
                data: {
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
                }
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

    function updateImmunization(formtype, key) {
        validateImmunizationForms();
        hasFormValue();
        if ($("#editimmunizationform").valid()) {
            let formdata = $("#editimmunizationform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/immunization/update")}}',
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
                }
            });
        } else {
            if ($('.error:visible').length > 0) {
                setTimeout(function() {
                    // $('html, body').animate({
                    //     scrollTop: ($('.error:visible').first().offset().top - 100)
                    // }, 500);
                }, 500);
            }
        }
    }
</script>