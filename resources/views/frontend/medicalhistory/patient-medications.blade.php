<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fw-medium">Medications</h5>
    <div class="btn_alignbox">
        <a href="javascript:void(0);" onclick="addMedication();" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
<div class="history-wrapperBody">
    <div class="row">
        <div class="col-12 medication-append">
        </div>
        <div class="col-12">
            @if(!empty($medicathistoryDetails))
            @foreach($medicathistoryDetails as $hsk => $hsv)
            <?php $sourceType = isset($hsv['source_type_id']) && $hsv['source_type_id'] == 1 ? 'Intake Form' : (isset($hsv['source_type_id']) && $hsv['source_type_id'] == 2 ? 'Patient' : 'Clinic');  ?>
            <div class="inner-history patient-medicationscls_{{$hsv['medication_uuid']}} medication-item">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Drug Name</h6>
                                    <p>@if(isset($hsv['medicine_name']) && $hsv['medicine_name'] != '') {{$hsv['medicine_name']}} @elseif(isset($hsv['medicine_id']) && $hsv['medicine_id'] != '' && $hsv['medicine_id'] != '0') {{$medicineDetails[$hsv['medicine_id']]['medicine']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Quantity</h6>
                                    <p>@if(isset($hsv['quantity']) && $hsv['quantity'] != '') {{$hsv['quantity']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Dosage</h6>
                                    <p>@if(isset($hsv['strength']) && $hsv['strength'] != '' && $hsv['strength'] != '0') {{$hsv['strength']}}{{$strengthUnits[$hsv['strength_unit_id']]['strength_unit']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Diagnosis</h6>
                                    <p>@if(isset($hsv['conditions']) && $hsv['conditions'] != '') {{$hsv['conditions']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>When to Take</h6>
                                    <p>@if(isset($hsv['frequency']) && $hsv['frequency'] != '') {{$hsv['frequency']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Date Started</h6>
                                    <p>@if(isset($hsv['start_date']) && $hsv['start_date'] != NULL) <?php echo $corefunctions->timezoneChange($hsv['start_date'], "M d, Y") ?> @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Prescribed By</h6>
                                    <p>@if(isset($hsv['prescribed_by']) && $hsv['prescribed_by'] != '') {{$hsv['prescribed_by']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Dispense Unit</h6>
                                    <p>@if(isset($hsv['dispense_unit_id']) && $hsv['dispense_unit_id'] != '' && $hsv['dispense_unit_id'] != '0') {{$dispenseUnits[$hsv['dispense_unit_id']]['form']}} @else -- @endif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($hsv['created_by'] == Session::get('user.userID'))
                    <div class="col-3">
                        <div class="btn_alignbox justify-content-end">
                            <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a onclick="editMHSection('{{$hsv['medication_uuid']}}','patient-medications')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                <li><a onclick="deleteMHSection('{{$hsv['medication_uuid']}}','patient-medications')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                    <div class="col-12">
                        <div class="history-info flex-wrap">
                            <h6 class="mb-0">
                                {{$userDetails[$hsv['created_by']]['first_name']}}{{$userDetails[$hsv['created_by']]['last_name']}}
                                @if(isset($clinicUser[$hsv['created_by']]['designation']['name'])), {{$clinicUser[$hsv['created_by']]['designation']['name']}}@else{{''}}@endif

                            </h6>
                            <div class="d-flex align-items-center flex-wrap">
                                <span class="update-info mx-1"></span>
                                <small>Last updated:</small><small class="ms-1">@if(isset($hsv['updated_at']) && $hsv['updated_at'] != '')
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
                <div class="text-center no-records-body">
                    <img src="{{asset('images/nodata.png')}}"
                        class=" h-auto" alt="no records">
                    <p>No records found</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="medicinemodal" tabindex="-1" aria-labelledby="pmedicinemodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <!-- <h4 class="fw-bold mb-0" id="patientNotesLabel"> Notes</h4> -->
                </div>
                <h4 class="fwt-bold mb-3">Select From the List</h4>
                <div class="form-group form-outline form-outer">
                    <label class="float-label">Medicine</label>
                    <input type="text" class="form-control medicine" name="medicine" id="medicine" placeholder="">
                    <input class="patient-ctn" type="hidden" name="medication_id" id="medication_id">
                    <input class="patient-ctn valcls" type="hidden" name="medication_name" id="medication_name">
                </div>
                <input type="hidden" name="count" id="count" />
                <div class="btn_alignbox justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary" onclick="hideMedicineModal()">Close</button>
                    <button type="button" onclick="saveMedicine()" id="saveButton" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('input, textarea').each(function () {
            toggleLabel(this);
        });
        hasFormMedicineValue();
        getMedicines();
        getConditions();
        datetimePicker();
    });
    function datetimePicker() {
        $('#startdate').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: true,
        });
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

                    if (selectedConditionsContainer.find('.selected-condition').length > 0) {
                        swal("Warning", "You have already selected a condition. Please remove it before selecting another one.", "error");
                        conditionInput.val(""); // Clear input
                        event.preventDefault();
                        return;
                    }
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
                        //conditionMultiselect.append(selectedConditionsContainer);
                    }

                    // Create the HTML for the new condition with remove button
                    var conditionHTML = `
                        <div class="selected-condition mt-2" data-id="${conditionID}">
                            <p>${conditionLabel}</p>
                            <button type="button" class="remove-condition">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                    `;

                    // Append the new condition to the container
                    selectedConditionsContainer.html(conditionHTML);

                    // Add the hidden input field for the condition ID
                    var hiddenInput = `<input type="hidden" name="medications[condition_ids]" value="${conditionID}">`;
                    selectedConditionsContainer.append(hiddenInput);

                    // Set the hascondition field to '1'
                    $("#hascondition").val('1');

                    // Clear the input field for the next selection
                    conditionInput.val(conditionLabel);
                    $("#condition_id").val(conditionID);
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
            $("input[name*='condition_id'][value='" + conditionID + "']").remove();

            // If there are no conditions left, clear the hascondition field
            var selectedConditions = $(".selected-condition").length;
            if (selectedConditions === 0) {
                $("#hascondition").val(""); // Clear hascondition
            }
        });
    }

    function getMedicines() {
        $(".medicine").autocomplete({
            autoFocus: true,
            source: function(request, response) {
                $.getJSON("{{ url('intakeform/medicine/search') }}", {
                        term: request.term
                    },
                    response);
            },
            minLength: 2,
            data: {
                // term : request.term,
            },
            select: function(event, ui) {
                var medicineInput = $(this);

                if (ui.item.key != '0') {
                    medicineInput.siblings("input[name=medication_id]").val(ui.item.key);
                    medicineInput.siblings("input[name=medication_name]").val(ui.item.label);
                    var count = 1;
                    var countVal = '';
                } else {
                    medicineInput.val('');
                    medicineInput.siblings("input[name=medicine]").val('');
                    event.preventDefault();
                }
            },
            focus: function(event, ui) {
                selectFirst: true;
                event.preventDefault();
            },
            open: function(event, ui) {
                $(this).autocomplete("widget")
                    .appendTo("#results").css({
                        'position': 'static',
                        'width': '100%'
                    });
                $('.ui-autocomplete').css('z-index', '9999');
                $('.ui-autocomplete').addClass('srchuser-dropdown');
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li><span class='srchuser-downname'>" + item.label + "</span></li>").data("ui-autocomplete-item", item.key).appendTo(ul);
        };
    }

    function hasFormMedicineValue() {
       
        var hasVal = '';
        $("#hasvalue").val('');

        $(".valcls").each(function() {
            if ($(this).val() != '' && $(this).val() != 'list') {
                hasVal = 1;
               
            }
        });
        $("#hasvalue").val(hasVal);
        $("#hasvalue").valid();
    }
    const strengthUnitOptions = `
        @foreach($strengthUnits as $suv)
            <option value="{{$suv['id']}}">{{$suv['strength_unit']}}</option> 
        @endforeach
    `;
    const dispenseUnitOptions = `
        @foreach($dispenseUnits as $suv)
            <option value="{{$suv['id']}}">{{$suv['form']}}</option> 
        @endforeach
    `;
    function addMedication() {
        const medicationCount = document.querySelectorAll('div.medication-append .row').length - 1;
        const medicationHtml = `
            <div class="inner-history medication-item"> 
            <form method="POST" id="medicationform" autocomplete="off">
            @csrf
                <div class="row align-items-start"> 
                    <div class="col-md-10"> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="history-box"> 
                                    <div class="form-group form-floating drugcls">
                                        <select class="form-select valcls" id="type_${medicationCount}" name="medications[${medicationCount}][type]" onchange="toggleDrug(this,${medicationCount});">
                                            <option value="">Drug Name</option>
                                            <option value="list">Select from the list</option>
                                            <option value="medicine">Add your own medicine</option>
                                        </select>
                                        <label class="select-label">Select Drug Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" id="drugnamediv" style="display:none;"> 
                                <div class="history-box"> 
                                    <div class="form-group form-outline drugnclserror">
                                        <label class="float-label active">Drug Name</label>
                                        <input type="text" class="form-control drugncls valcls" name="medications[${medicationCount}][medicine_name]" placeholder="" id="medicine_name_${medicationCount}">
                                        <input type="hidden" id="medicine_id_${medicationCount}" name="medications[${medicationCount}][medicine_id]" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="history-box"> 
                                    <div class="form-group form-outline">
                                        <label class="float-label active">Prescribed By</label>
                                        <input type="text" class="form-control" name="medications[${medicationCount}][prescribed_by]" placeholder="" data-medicationcount="${medicationCount}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="history-box"> 
                                    <div class="form-group form-outline">
                                        <label class="float-label active">Diagnosis</label>
                                        <input type="text" class="form-control condition" name="condition" placeholder="" data-medicationcount="${medicationCount}">
                                        <input class="patient-ctn" id="condition_id" type="hidden" name="medications[${medicationCount}][condition_id]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" id="quantitydiv">
                                <div class="history-box"> 
                                    <div class="form-group form-outline quantityclserror">
                                        <label class="float-label active">Quantity</label>
                                        <input type="text" class="form-control quantitycls" name="medications[${medicationCount}][quantity]" placeholder="" data-medicationcount="${medicationCount}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" id="strengthdiv">
                                <div class="history-box"> 
                                    <div class="form-group form-outline strengthclserror">
                                        <label class="float-label active">Strength</label>
                                        <input type="text" class="form-control strengthcls" name="medications[${medicationCount}][strength]" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" id="strengthunitdiv"> 
                                <div class="history-box"> 
                                    <div class="form-group form-floating strengthunitclserror ${medicationCount}"> 
                                        <select class="form-select ${medicationCount} strengthunitcls" name="medications[${medicationCount}][strength_unit_id]" placeholder=""> 
                                            <option value="">Select Stength Unit</option>
                                            ${strengthUnitOptions} 
                                        </select> 
                                        <label class="select-label">Stength Unit</label>
                                    </div> 
                                </div> 
                            </div> 
                            <div class="col-md-6 mb-3">
                                <div class="history-box"> 
                                    <div class="form-group form-outline">
                                        <label class="float-label active">Start Date</label>
                                        <input type="text" class="form-control startdate" name="medications[${medicationCount}][start_date]" id="startdate" placeholder="" data-medicationcount="${medicationCount}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3"> 
                                <div class="history-box"> 
                                    <div class="form-group form-floating"> 
                                        <select class="form-select ${medicationCount}" name="medications[${medicationCount}][dispense_unit_id]" placeholder=""> 
                                            <option value="">Select Dispense Unit</option>
                                            ${dispenseUnitOptions} 
                                        </select> 
                                        <label class="select-label">Dispense Unit</label>
                                    </div> 
                                </div> 
                            </div> 
                            <div class="col-md-6 mb-3">
                                <div class="history-box"> 
                                    <div class="form-group form-outline">
                                        <label class="float-label active">When to Take?</label>
                                        <textarea type="text" class="form-control" name="medications[${medicationCount}][frequency]" placeholder="" data-medicationcount="${medicationCount}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                            <input type="hidden" name="hasvalue" id="hasvalue" class="drunamecls"/>
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="btn_alignbox justify-content-end">
                            <button type="button" class="opt-btn" id="submitmedicationbtn" href="javascript:void(0);" onclick="submitMedication('patient-medications');" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">check</span>
                            </button>
                            <a class="opt-btn danger-icon" href="javascript:void(0);" onclick="removeMedication(this);" data-bs-toggle="dropdown" aria-expanded="false">
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
        $('.medication-append').append(medicationHtml);
        $('.no-records').hide();
        getConditions();
        datetimePicker();
    }

    function removeMedication(element) {
        $(element).closest('.medication-item').remove();
        if ($('.medication-item').length == 0) {
            $('.no-records').show();
        }
    }

    function validateMedicationForms() {
        $("#medicationform").validate({
            ignore: [],
            rules: {
                hasvalue: "required"
            },
            messages: {
                hasvalue: "Please select drug name"
            },
            errorPlacement: function (error, element) {
                if (element.hasClass("drunamecls")) {
                    error.insertAfter('.drugcls');
                }else if (element.hasClass("drugncls")) {
                    error.insertAfter('.drugnclserror');
                }else if (element.hasClass("strengthcls")) {
                    error.insertAfter('.strengthclserror');
                }else if (element.hasClass("strengthunitcls")) {
                    error.insertAfter('.strengthunitclserror');
                }else if (element.hasClass("quantitycls")) {
                    error.insertAfter('.quantityclserror');
                } else {
                    error.insertAfter(element);
                }
            }
        });
    }

    function submitMedication(formtype) {
        $("#medicationform").validate().destroy();
        validateMedicationForms();
        hasFormMedicineValue();
        if ($('#drugnamediv').is(':visible')) {
            $('#drugnamediv input').rules('add', {
                required: true,
                messages: {
                    required: 'Please enter a drug name.',
                }
            });
        } else {
            $('#drugnamediv input').rules('remove');
        }

        if ($('#strengthdiv').is(':visible')) {
            $('#strengthdiv input').rules('add', {
                required: true,
                number: true,
                min: 1,
                messages: {
                    required: 'Please enter strength.',
                    number: 'Please enter a valid value.',
                    min: 'Strength must be at least 1.',
                }
            });
        } else {
            $('#strengthdiv input').rules('remove');
        }

        if ($('#quantitydiv').is(':visible')) {
            $('#quantitydiv input').rules('add', {
                required: true,
                number: true,
                min: 1,
                messages: {
                    required: 'Please enter quantity.',
                    number: 'Please enter a valid value.',
                    min: 'Quantity must be at least 1.',
                }
            });
        } else {
            $('#quantitydiv input').rules('remove');
        }

        if ($('#strengthunitdiv').is(':visible')) {
            $('#strengthunitdiv select').rules('add', {
                required: true,
                messages: {
                    required: 'Please select strength unit.',
                }
            });
        } else {
            $('#strengthunitdiv input').rules('remove');
        }
        if ($("#medicationform").valid()) {
            // var selectedConditions = $("input[name='condition_id']").value;

            // if (selectedConditions == '') {
            //     // Show a warning if no conditions are selected
            //     swal({
            //         title: "Warning!",
            //         text: "You haven't selected any conditions fom our list. Do you still want to continue?",
            //         icon: "warning",
            //         buttons: true, // Two buttons: Cancel and OK
            //         dangerMode: true,
            //     }).then((willContinue) => {
            //         if (willContinue) {
            //             proceedWithSubmission(formtype); // Only runs if OK is clicked
            //         }
            //     });
            // } else {
                // If conditions are selected, proceed normally
                proceedWithSubmission(formtype);
            // /}
        }
    }

    // Separate function for submission logic
    function proceedWithSubmission(formtype) {
        $("#medicationform").validate().destroy();
        validateMedicationForms();
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        if ($("#medicationform").valid()) {
            $("#submitmedicationbtn").prop('disabled', true);
            let formdata = $("#medicationform").serialize();

            $.ajax({
                url: '{{ url("/intakeform/patientmedication/store")}}',
                type: "post",
                data: {
                    'patientID': patientID,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        getmedicalhistoryData(formtype);
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            });
        }
    }

    function validateEditMedicationForms() {
        $("#editmedicationform").validate({
            ignore: [],
            rules: {
                hasvalue: "required",
            },
            messages: {
                hasvalue: "Please select drug name",
            },
            errorPlacement: function (error, element) {
                if (element.hasClass("strengthclsedit")) {
                    element.closest('.strengthclserroredit').after(error);
                } else if (element.hasClass("drunameclsedit")) {
                    element.closest('.drugclsedit').after(error);
                } else if (element.hasClass("drugnclsedit")) {
                    element.closest('.drugnclserroredit').after(error);
                } else if (element.hasClass("strengthunitclsedit")) {
                    element.closest('.strengthunitclserroredit').after(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    }
    function updateMedication(formtype, key) {
        $("#editmedicationform").validate().destroy();
        validateEditMedicationForms();
        if ($('#drugnamediv_' + key).is(':visible')) {
            $('#drugnamediv_' + key + ' input').rules('add', {
                required: true,
                messages: {
                    required: 'Please enter a drug name.',
                },
            });
        } else {
            $('#drugnamediv_' + key + ' input').rules('remove');
        }

        if ($('#strengthdiv_' + key).is(':visible')) {
            $('#strengthdiv_' + key + ' input').rules('add', {
                required: true,
                number: true,
                messages: {
                    required: 'Please enter strength.',
                    number: 'Please enter a valid value.',
                },
            });
        } else {
            $('#strengthdiv_' + key + ' input').rules('remove');
        }

        if ($('#strengthunitdiv_' + key).is(':visible')) {
            $('#strengthunitdiv_' + key + ' select').rules('add', {
                required: true,
                messages: {
                    required: 'Please select strength unit.',
                }
            });
        } else {
            $('#strengthunitdiv_' + key + ' input').rules('remove');
        }
        if ($("#editmedicationform").valid()) {
            // var selectedConditions = $("input[name='condition_id[]']").length;

            // if (selectedConditions === 0) {
            //     // Show a warning if no conditions are selected
            //     swal({
            //         title: "Warning!",
            //         text: "You haven't selected any conditions fom our list. Do you still want to continue?",
            //         icon: "warning",
            //         buttons: true, // Two buttons: Cancel and OK
            //         dangerMode: true,
            //     }).then((willContinue) => {
            //         if (willContinue) {
            //             proceedWithUpdate(formtype, key); // Only runs if OK is clicked
            //         }
            //     });
            // } else {
                // If conditions are selected, proceed normally
                proceedWithUpdate(formtype, key);
            //}
        }
    }

    // Separate function for update logic
    function proceedWithUpdate(formtype, key) {
        $("#editmedicationform").validate().destroy();
        validateEditMedicationForms();
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";

        if ($("#editmedicationform").valid()) {
            let formdata = $("#editmedicationform").serialize();

            $.ajax({
                url: '{{ url("/intakeform/patientmedication/update")}}',
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
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
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

    function toggleDrug(ths, count) {
        if ($(ths).val() == 'list') {
            console.log('list')
            $("#medication_id").val('');
            $("#medicine").val('');
            $("#medicinemodal").modal('show');
            $('#medicationform')[0].reset();
            $('#medicationform').validate().resetForm();
            $("#count").val(count);
            $("#drugnamediv").hide();
            getMedicines();
        } else if ($(ths).val() == 'medicine') {
          
            $("#medicine_name_" + count).prop('readonly', false);
            $("#medicine_name_" + count).val('');
            $("#drugnamediv").show();
            $("#medicine_id_"+count).val('');
        }
    }

    function hideMedicineModal() {
        $("#medicinemodal").modal('hide');
        var count = $("#count").val();
        const targetDropdown = $("#medicine_id_" + count);
        targetDropdown.val('');
    }

    function saveMedicine() {
        var count = $("#count").val();
        var selectedMedicine = $("#medication_name").val();
        var selectedValue = $("#medication_id").val();
        if (!selectedValue || selectedValue === '') {
            swal({
                title: "Warning!",
                text: "Please select a medicine from the list",
                icon: "warning",
                buttons: false,
                timer: 2000
            });
            return false;
        }
        if (selectedMedicine.trim() !== "What is this prescribed for?") {
            $("#drugnamediv").show();
            $("#medicine_name_" + count).val(selectedMedicine);
            $("#medicine_name_" + count).prop('readonly', true);
            $("#medicine_id_" + count).val(selectedValue);
            $("#type_" + count).val('list');
            $("#medicinemodal").modal('hide');
        }
    }


</script>