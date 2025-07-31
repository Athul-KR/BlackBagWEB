<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-medium">Medications</h4>
    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<form method="POST" id="medicationform" autocomplete="off">
    @csrf
    <div class="row align-items-start align-row">
        <div class="col-md-6 mb-2">
            <div class="form-group form-floating no-iconinput">
                <select class="form-select valcls" id="type" name="medications[type]" onchange="toggleDrug(this);">
                    <option value="">Choose Drug Name</option>
                    <option value="list" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['medicine_id']) && $medicathistoryDetails['medicine_id'] != '' && $medicathistoryDetails['medicine_id'] != '0') selected @endif>Select from the list</option>
                    <option value="medicine" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['medicine_name']) && $medicathistoryDetails['medicine_name'] != '') selected @endif>Add your own medicine</option>
                </select>
                <label class="select-label">Drug Name</label>
            </div>
        </div>
        <div class="col-md-6 mb-2" id="drugnamediv" @if(!empty($medicathistoryDetails)) style="display:block;" @else style="display:none;" @endif>
            <div class="form-group form-outline no-iconinput">
                <label for="medicine_name" class="float-label">Drug Name</label>
                <input type="text" class="form-control drugncls valcls" name="medications[medicine_name]" @if(!empty($medicathistoryDetails)) @if(isset($medicathistoryDetails['medicine_name']) && $medicathistoryDetails['medicine_name'] != '') value="{{$medicathistoryDetails['medicine_name']}}" @else value="{{$medicine}}" @endif @endif placeholder="" id="medicine_name">
                <input type="hidden" id="medicine_id" name="medications[medicine_id]" value="">
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="form-group form-outline no-iconinput">
                <label for="input" class="float-label">Prescribed By</label>
                <input type="text" class="form-control valcls" name="medications[prescribed_by]" placeholder="" id="prescribed_by" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['prescribed_by']) && $medicathistoryDetails['prescribed_by'] != '') value="{{$medicathistoryDetails['prescribed_by']}}" @endif>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="form-group form-outline no-iconinput">
                <label for="input" class="float-label">Diagnosis</label>
                <input type="text" class="form-control condition" name="condition" id="condition" placeholder="" @if(!empty($medicathistoryDetails) && $medicathistoryDetails['condition_id'] != '0') value="{{$condition}}" @endif>
                <input class="patient-ctn" type="hidden" name="medications[condition_id]" id="condition_id" @if(!empty($medicathistoryDetails) && $medicathistoryDetails['condition_id'] != '0') value="{{$medicathistoryDetails['condition_id']}}" @endif>
            </div>
            <!-- <div class="multi-wrapper" id="multiselect">
                <div class='selected-conditions-container'>
                    @if(!empty($medicathistoryDetails) && $medicathistoryDetails['condition_id'] != '0')
                    <div class="selected-condition mt-2" data-id="{{$medicathistoryDetails['condition_id']}}">
                        <p>{{$condition}}</p>
                        <button type="button" class="remove-condition"><span class="material-symbols-outlined">close</span></button>
                    </div>
                    <input type="hidden" name="medications[condition_id]" value="{{$medicathistoryDetails['condition_id']}}">
                    @endif
                </div>
            </div> -->
        </div>
        <div class="col-md-6 mb-2">
            <div class="form-group form-outline no-iconinput">
                <label for="input" class="float-label">Quantity</label>
                <input type="text" class="form-control valcls" name="medications[quantity]" placeholder="" id="quantity" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['quantity']) && $medicathistoryDetails['quantity'] != '') value="{{$medicathistoryDetails['quantity']}}" @endif>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="form-group form-outline no-iconinput">
                <label for="input" class="float-label">Strength</label>
                <input type="text" class="form-control strengthcls" name="medications[strength]" placeholder="" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['strength']) && $medicathistoryDetails['strength'] != '' && $medicathistoryDetails['strength'] != '0') value="{{$medicathistoryDetails['strength']}}" @endif>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="form-group form-floating no-iconinput">
                <select class="form-select strengthunitcls" name="medications[strength_unit_id]" placeholder=""> 
                    <option value="">Strength Unit</option>
                    @foreach($strengthUnits as $suv)
                        <option value="{{$suv['id']}}" @if(!empty($medicathistoryDetails) && $medicathistoryDetails['strength'] != 0 && $suv['id'] == $medicathistoryDetails['strength_unit_id']) selected @endif>{{$suv['strength_unit']}}</option> 
                    @endforeach
                </select> 
                <label class="select-label">Strength Unit</label>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="form-group form-outline no-iconinput">
                <label for="input" class="float-label">Start Date</label>
                <input type="text" class="form-control strengthcls" name="medications[start_date]" id="startDate" placeholder="" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['start_date']) && $medicathistoryDetails['start_date'] != '') value="{{date('m/d/Y',strtotime($medicathistoryDetails['start_date']))}}" @endif>
            </div>
        </div>

        <div class="col-md-6 mb-2">
            <div class="form-group form-floating no-iconinput">
                <select class="form-select strengthunitcls" name="medications[dispense_unit_id]" placeholder=""> 
                    <option value="">Dispense Unit</option>
                    @foreach($dispenseUnits as $dv)
                        <option value="{{$dv['id']}}" @if(!empty($medicathistoryDetails) && $medicathistoryDetails['dispense_unit_id'] != 0 && $dv['id'] == $medicathistoryDetails['dispense_unit_id']) selected @endif>{{$dv['form']}}</option> 
                    @endforeach
                </select> 
                <label class="select-label">Dispense Unit</label>
            </div>
        </div>
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="medications[sourcetype]" value="3">
        @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['medication_uuid'])
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="medications[key]" value="{{$medicathistoryDetails['medication_uuid']}}">
        @endif
        <div class="col-md-12 mb-2">
            <div class="form-group form-outline no-iconinput">
                <label for="input" class="float-label">When to Take</label>
                <textarea class="form-control" rows="2" name="medications[frequency]" placeholder="">@if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['frequency']) && $medicathistoryDetails['frequency'] != '') {{ $medicathistoryDetails['frequency'] }} @endif</textarea>
            </div>
        </div>
    </div>
</form>            
<div class="btn_alignbox mt-4">
    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('medications','medicationform','{{$formType}}')">Save</a>
</div>

<script>
    $(document).ready(function() {
        // $('input, textarea').each(function () {
        //     toggleLabel(this);
        // });
        getMedicines();
        getConditions();
        $('#startDate').datepicker({
            format: 'MM/DD/YYYY',
            useCurrent: true,
        });
        $("#medicationform").validate({
            ignore: [],
            rules: {
                "medications[type]": {
                    required: true,
                },
                "medications[medicine_name]": {
                    required: true,
                    nospace: true
                },
                "medications[quantity]": {
                    required: true,
                    number: true,
                    min: 1
                },
                "medications[strength]": {
                    required: true,
                    number: true,
                    min: 1
                },
                "medications[strength_unit_id]": {
                    required: true,
                },
            },
            messages: {
                "medications[type]": {
                    required: 'Please enter drug name.',
                },
                "medications[medicine_name]": {
                    required: 'Please enter drug name.',
                    nospace: 'Please enter a valid drug name',
                },
                "medications[quantity]": {
                    required: 'Please enter quantity.',
                    number: 'Please enter a valid number.',
                    min: 'Quantity must be at least 1.'
                },
                "medications[strength]": {
                    required: 'Please enter strength.',
                    number: 'Please enter a valid number.',
                    min: 'Strength must be at least 1.'
                },
                "medications[strength_unit_id]": {
                    required: 'Please select strength unit.',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("medicalhiscls")) {
                    error.insertAfter('.formmedicalhiscls');
                }else{
                    error.insertAfter(element);
                }
                
            },
        });
        jQuery.validator.addMethod("nospace", function(value, element) {
            return $.trim(value).length > 0;
        }, "This field is required.");
    });
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
    function toggleDrug(ths) {
        if ($(ths).val() == 'list') {
            console.log('list')
            $("#medication_id").val('');
            $("#medicine").val('');
            $("#adddata").modal('hide');
            $("#medicinemodal").modal('show');
            $("#drugnamediv").hide();
            getMedicines();
        } else if ($(ths).val() == 'medicine') {
            $("#medicine_name").prop('readonly', false);
            $("#medicine_name").val('');
            $("#drugnamediv").show();
            $("#medicine_id").val('');
        }
    }
    function hideMedicineModal() {
        $("#medicinemodal").modal('hide');
        var count = $("#count").val();
        const targetDropdown = $("#medicine_id_" + count);
        targetDropdown.val('');
    }

    function saveMedicine() {
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
            $("#medicine_name").val(selectedMedicine);
            $("#medicine_name").prop('readonly', true);
            $("#medicine_id").val(selectedValue);
            $("#type").val('list');
            $("#medicinemodal").modal('hide');
            $("#adddata").modal('show');
        }
    }

    // Function to toggle the 'active' class

    $(document).ready(function () {
    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== '';
        const isFocused = $input.is(':focus');

        // Correct selector for all cases (only applies to visible inputs)
        $input.closest('.form-group').find('.float-label').toggleClass('active', hasValue || isFocused);
    }
    
    // Initialize only visible inputs on page load
    $('input:visible, textarea:visible').each(function () {
        toggleLabel(this);
    });

    // Handle input events (only on visible inputs)
    $(document).on('focus blur input change', 'input:visible, textarea:visible', function () {
        toggleLabel(this);
    });

    // Handle dynamic updates (e.g., Datepicker) — only trigger for visible inputs
    $(document).on('dp.change', function (e) {
        const input = $(e.target).find('input:visible, textarea:visible');
        if (input.length > 0) {
            toggleLabel(input[0]);
        }
    });
});




    

</script>