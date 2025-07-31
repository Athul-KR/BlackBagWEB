<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fw-medium">Family Medical History</h5>
    <div class="btn_alignbox">
        <a href="javascript:void(0);" onclick="addFamilyHistory();" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="history-wrapperBody">
    <div class="row">
        <div class="col-12 relation-append" id="family_history">
        </div>
        <div class="col-12">
            @if(!empty($medicathistoryDetails))
            @foreach($medicathistoryDetails as $hsk => $hsv)
            <?php $sourceType = isset($sourceTypes[$hsv['source_type_id']]) ? $sourceTypes[$hsv['source_type_id']]['source_type'] : '';  ?>
            <div class="inner-history family-historycls_{{$hsv['patient_condition_uuid']}}">
                <div class="row">
                    <div class="col-9">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="history-box">
                                    <h6>Relation</h6>
                                    <p>@if(isset($hsv['relation_id']) && $hsv['relation_id'] != 0) {{$relationDetails[$hsv['relation_id']]['relation']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="history-box">
                                    <h6>Condition(s)</h6>
                                    <p>@if(isset($hsv['conditions']) && $hsv['conditions'] != '') {{$hsv['conditions']}} @else -- @endif</p>
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
                                <li><a onclick="editMHSection('{{$hsv['patient_condition_uuid']}}','family-history')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                <li><a onclick="deleteMHSection('{{$hsv['patient_condition_uuid']}}','family-history')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
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
                                <span class="update-info ms-1 me-1"></span>
                                <small>Last updated:</small><small class="ms-1"> @if(isset($hsv['updated_at']) && $hsv['updated_at'] != '')
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
        getConditions();
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

    function getConditions() {
        $(".condition").autocomplete({
            autoFocus: true,
            source: function(request, response) {
                $.getJSON("{{ url('intakeform/condition/search') }}", {
                        term: request.term
                    },
                    response);
            },
            minLength: 2,
            select: function(event, ui) {
                var conditionInput = $(this);
                var conditionMultiselect = $("#multiselect");
                var selectedConditionsContainer = conditionMultiselect.find(".selected-conditions-container");

                if (ui.item.key !== '0') {
                    var conditionID = ui.item.key;
                    var conditionLabel = ui.item.label;

                    // Check if the condition is already selected
                    var existingCondition = selectedConditionsContainer.find(`.selected-condition[data-id="${conditionID}"]`);
                    if (existingCondition.length > 0) {
                        swal("Warning", "This condition is already selected!", "error");
                        conditionInput.val(""); // Clear the input field
                        event.preventDefault();
                        return; // Exit early to prevent duplication
                    }

                    // If selectedConditionsContainer doesn't exist, create it
                    if (selectedConditionsContainer.length == 0) {
                        selectedConditionsContainer = $("<div class='selected-conditions-container'></div>");
                        conditionMultiselect.append(selectedConditionsContainer);
                    }

                    // Create the HTML for the new condition with remove button
                    var conditionHTML = `
                        <div class="selected-condition mt-2 conditionvaluecls" data-id="${conditionID}">
                            <p>${conditionLabel}</p>
                            <button type="button" class="remove-condition">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                    `;

                    // Append the new condition to the container
                    selectedConditionsContainer.append(conditionHTML);

                    // Add the hidden input field for the condition ID
                    var hiddenInput = `<input type="hidden" name="condition_id[]" value="${conditionID}">`;
                    selectedConditionsContainer.append(hiddenInput);

                    // Set the hascondition field to '1'
                    $("#hascondition").val('1');
                    $("#hascondition").valid();
                    // Clear the input field for the next selection
                    conditionInput.val("");
                }

                event.preventDefault();
            },
            focus: function(event, ui) {
                event.preventDefault();
            },
            open: function() {
                $(this).autocomplete("widget")
                    .appendTo("#results").css({
                        'position': 'static',
                        'width': '100%'
                    });
                $('.ui-autocomplete').css('z-index', '9999');
                $('.ui-autocomplete').addClass('srchuser-dropdown');
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li><span class='srchuser-downname'>" + item.label + "</span></li>")
                .data("ui-autocomplete-item", item.key)
                .appendTo(ul);
        };

        // Event listener to remove selected conditions
        $(document).on("click", ".remove-condition", function() {
            var conditionElement = $(this).closest(".selected-condition");
            var conditionID = conditionElement.data("id");

            // Remove the condition from the UI and the hidden input
            conditionElement.remove();
            $("input[name*='condition_id[]'][value='" + conditionID + "']").remove();

            // If there are no conditions left, clear the hascondition field
            var selectedConditions = $(".selected-condition").length;
            if (selectedConditions === 0) {
                $("#hascondition").val(""); // Clear hascondition
            }
        });
    }

    function addFamilyHistory() {
        const relationHtml = `
            <div class="inner-history family-history-item"> 
            <form method="POST" id="conditionform" autocomplete="off">
            @csrf
                <div class="row align-items-start"> 
                    <div class="col-md-10"> 
                        <div class="row"> 
                            <div class="col-md-6"> 
                                <div class="history-box"> 
                                    <div class="form-group form-floating relationerr">
                                        <select class="form-select relationcls" name="relation" id="relation">
                                            <option value="">Select Relation</option>
                                            @if(!empty($relations))
                                                @foreach($relations as $rl)
                                                    <option value="{{$rl['id']}}">{{$rl['relation']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    <label class="select-label">Relation</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="history-box"> 
                                    <div class="form-group form-outline conditionerr">
                                        <label class="float-label">Condition(s)</label>
                                        <input type="text" class="form-control condition" name="condition" id="condition" placeholder="">
                                        <input class="conditioncls" type="hidden" name="hascondition" id="hascondition">
                                    </div>
                                    <div class="multi-wrapper" id="multiselect"></div>
                                </div>
                            </div>
                            <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                            <input type="hidden" name="hasvalue" id="hasvalue" />
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="btn_alignbox justify-content-end">
                            <button type="button" class="opt-btn" id="submitfhbtn" href="javascript:void(0);" onclick="submitConditionForm('family-history');" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">check</span>
                            </button>
                            <a class="opt-btn danger-icon" href="javascript:void(0);" onclick="removeFamilyHistory(this);" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">close</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        `;

        // Append the new vaccine select to the vaccine-append container
        $('#family_history').html(relationHtml);
        getConditions();
        $('.no-records').hide();
    }

    function removeFamilyHistory(element) {
        $(element).closest('.family-history-item').remove();
        if ($('.family-history-item').length == 0) {
            $('.no-records').show();
        }
    }

    function validateConditionForms() {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        $("#conditionform").validate({
            ignore: [],
            rules: {
                relation: {
                    required:true,
                    remote: {
                        url: "{{ url('/intakeform/checkrelationexists') }}",
                        data: {
                            'patientID': patientID,
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                        async: false,
                    },
                },
                hascondition: "required"
            },
            messages: {
                relation: {
                    required: "Please select relation",
                    remote: "Relation already added",
                },
                hascondition: "Please select atleast one condition"
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("relationcls")) {
                    error.insertAfter(".relationerr");
                } else if (element.hasClass("conditioncls")) {
                    error.insertAfter(".conditionerr");
                } else {
                    error.insertAfter(element);
                }
            },
        });
    }

    function validateEditHistoryForms() {
        $("#edithistoryform").validate({
            ignore: [],
            rules: {
                relation: "required",
                hascondition: "required"
            },
            messages: {
                relation: "Please select relation",
                hascondition: "Please select atleast one condition"
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("relationcls")) {
                    error.insertAfter(".relationerr");
                } else if (element.hasClass("conditioncls")) {
                    error.insertAfter(".conditionerr");
                } else {
                    error.insertAfter(element);
                }
            },
        });
    }

    function submitConditionForm(formtype) {
        validateConditionForms();
        hasFormValue();
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        if ($("#conditionform").valid()) {
            $("#submitfhbtn").prop('disabled', true);
            let formdata = $("#conditionform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/familyhistory/store")}}',
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

    function updateHistoryForm(formtype, key) {
        validateEditHistoryForms();
        hasFormValue();
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        if ($("#edithistoryform").valid()) {
            $("#updatefhbtn").prop('disabled', true);
            let formdata = $("#edithistoryform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/familyhistory/update")}}',
                type: "post",
                data: {
                    'key': key,
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
                    $('html, body').animate({
                        scrollTop: ($('.error:visible').first().offset().top - 100)
                    }, 500);
                }, 500);
            }
        }
    }
</script>