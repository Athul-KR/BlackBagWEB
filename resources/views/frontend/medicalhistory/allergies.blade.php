<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fw-medium">Allergies</h5>
    <div class="btn_alignbox">
        <a href="javascript:void(0);" onclick="addAllergy();" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="history-wrapperBody">
    <div class="row">
        <div class="col-12 allergy-append">
        </div>
        <div class="col-12">
            @if(!empty($medicathistoryDetails))
            @foreach($medicathistoryDetails as $hsk => $hsv)
            <?php $sourceType = isset($hsv['source_type_id']) && $hsv['source_type_id'] == 1 ? 'Intake Form' : (isset($hsv['source_type_id']) && $hsv['source_type_id'] == 2 ? 'Patient' : 'Clinic');  ?>
            <div class="inner-history allergiescls_{{$hsv['allergies_uuid']}}">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="history-box">
                                    <h6>What Are You Allergic To?</h6>
                                    <p>@if(isset($hsv['allergy']) && $hsv['allergy'] != '') {{$hsv['allergy']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="history-box">
                                    <h6>Reaction / Side Effect</h6>
                                    <p>@if(isset($hsv['reaction']) && $hsv['reaction'] != '') {{$hsv['reaction']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="history-box">
                                    <h6>Source Type</h6>
                                    <p>{{$sourceType}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                    @if($hsv['created_by'] == Session::get('user.userID'))
                    <div class="col-3">
                        <div class="btn_alignbox justify-content-end">
                            <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a onclick="editMHSection('{{$hsv['allergies_uuid']}}','allergies')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                <li><a onclick="deleteMHSection('{{$hsv['allergies_uuid']}}','allergies')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="col-12">
                        <div class="history-info flex-wrap">
                            <h6 class="mb-0">
                                {{$userDetails[$hsv['created_by']]['first_name']}}{{$userDetails[$hsv['created_by']]['last_name']}}
                                @if(isset($clinicUser[$hsv['created_by']]['designation']['name'])), {{$clinicUser[$hsv['created_by']]['designation']['name']}}@else{{''}}@endif
                            </h6>
                            <div class="d-flex align-items-center flex-wrap">
                                <span class="update-info mx-1"></span>
                                <small>Last updated:</small> <small class="ms-1"> @if(isset($hsv['updated_at']) && $hsv['updated_at'] != '')
                                    <?php echo $corefunctions->timezoneChange($hsv['updated_at'], "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($hsv['updated_at'], "h:i A") ?>
                                    @else <?php echo $corefunctions->timezoneChange($hsv['created_at'], "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($hsv['created_at'], "h:i A") ?> @endif
                                </small>
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
</div>
<script>
    $(document).ready(function() {
        // getConditions();
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

    

    function addAllergy() {
        const allergyCount = document.querySelectorAll('div.allergy-append .row').length - 1;
        const allergyHtml = `
            <div class="inner-history allergy-item"> 
            <form method="POST" id="allergyform" autocomplete="off">
            @csrf
                <div class="row align-items-start"> 
                    <div class="col-md-10"> 
                        <div class="row"> 
                            <div class="col-md-6"> 
                                <div class="history-box"> 
                                    <div class="form-group form-outline">
                                        <label class="float-label">What Are You Allergic To?</label>
                                        <input type="text" class="form-control valcls" name="allergies[${allergyCount}][allergy]" placeholder="">
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="history-box"> 
                                    <div class="form-group form-outline">
                                        <label class="float-label">Reaction / Side Effect</label>
                                        <input type="text" class="form-control valcls" name="allergies[${allergyCount}][reaction]" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                            <input type="hidden" name="hasvalue" id="hasvalue" />
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="btn_alignbox justify-content-end">
                            <button type="button" class="opt-btn" id="submitallergybtn" href="javascript:void(0);" onclick="submitAllergyForm('allergies');" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">check</span>
                            </button>
                            <a class="opt-btn danger-icon" href="javascript:void(0);" onclick="removeAllergy(this);" data-bs-toggle="dropdown" aria-expanded="false">
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
        $('.allergy-append').append(allergyHtml);
        $('.no-records').hide();
    }

    function removeAllergy(element) {
        $(element).closest('.allergy-item').remove();
        if ($('.allergy-item').length == 0) {
            $('.no-records').show();
        }
    }

    function validateAllergyForms() {
        $("#allergyform").validate({
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

    

    function submitAllergyForm(formtype) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
       
        validateAllergyForms();
        hasFormValue();
        if ($("#allergyform").valid()) {
            $("#submitallergybtn").prop('disabled', true);
            let formdata = $("#allergyform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/allergy/store")}}',
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


</script>