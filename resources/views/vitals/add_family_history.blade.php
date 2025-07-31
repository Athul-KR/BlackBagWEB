        
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Add Data</h4>
                    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <form method="POST" id="conditionform" autocomplete="off">@csrf
                <div class="row align-items-center align-row g-2">
                    <div class="col-12">
                        <div class="form-group form-floating no-iconinput unitercls">
                            
                            <select class="form-select relationcls unitformcls" name="family_history[relation]" id="relation" placeholder=""> 
                                <option value="">Select Relation</option>
                                @if(!empty($relations))
                                    @foreach($relations as $rl)
                                  
                                        <option value="{{$rl['id']}}" @if(isset($medicathistoryDetails['relation_id']) && $rl['id'] == $medicathistoryDetails['relation_id']) selected @endif >{{$rl['relation']}}</option>
                                    @endforeach
                                @endif
                            </select> 
                            <label class="select-label">Relation</label> 
                        </div>
                    </div>
                   
                    <div class="col-12">
                        <div class="form-group form-outline no-iconinput formsystoliccls">
                        <label class="float-label">Condition(s)</label>
                        <input type="text" class="form-control condition" name="condition" id="condition" placeholder="">
                        <input class="conditioncls" type="hidden" name="hascondition" id="hascondition"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value='1' @endif>

                        </div>
                        <div class="multi-wrapper" id="multiselect">

                        <div class='selected-conditions-container'>
                            @if(!empty($medicathistoryDetails['conditions']))
                            @foreach($medicathistoryDetails['conditions'] as $condition)
                                <div class="selected-condition mt-2" data-id="{{$condition['id']}}">
                                    <p>{{$condition['name']}}</p>
                                    <button type="button" class="remove-condition"><span class="material-symbols-outlined">close</span></button>
                                </div>
                                <input type="hidden" name="family_history[condition_id][]" value="{{$condition['id']}}">
                            @endforeach
                            @endif
                        </div>



                        </div>
                    </div>
                    <input type="hidden" name="family_history[sourcetype]" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                    <input type="hidden" name="hasvalue" id="hasvalue" />
                    @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['patient_condition_uuid'])
                    <input type="hidden" class="form-control" name="family_history[key]" value="{{$medicathistoryDetails['patient_condition_uuid']}}">
                    @endif
                </div>
                </form>
                
                <div class="btn_alignbox mt-4">
                    <a type="button" class="btn btn-primary w-100"  id="updatefhbtn" onclick="submitIntakeForm('family_history','conditionform','history')">Add Data</a>
                </div>



    <script>
    $(document).ready(function() {
        $('#conditionform').on('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitIntakeForm('family_history','conditionform','history');
            }
        });
        getConditions();
      
        $("#conditionform").validate({
            ignore: [],
            rules: {
                "family_history[relation]": {
                    required:true,
                    
                },
                hascondition: "required"
            },
            messages: {
                "family_history[relation]": {
                    required: "Please select relation",
                    remote: "Relation already added",
                },
                hascondition: "Please select atleast one condition"
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("unitformcls")) {
                    error.appendTo(".unitercls");
                }else if (element.hasClass("conditioncls")) {
                   error.appendTo('.formsystoliccls');
                } else {
                    error.insertAfter(element);
                }
            },
        });
    });
    function updateHistoryForm(formtype, key) {
        alert('testupdate')
        validateConditionForms();
        hasFormValue();
      alert('test')
        var patientID =  "{{$userId}}";
        
        if ($("#conditionform").valid()) {
            alert('form valid')
            $("#updatefhbtn").prop('disabled', true);
            let formdata = $("#conditionform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/familyhistory/update")}}',
                type: "post",
                data: {
                    'key': key,
                    'formdata': formdata,
                    'patientID': patientID,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success == 1) {
                        getHistoryDetails('family_history','history');
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
    function submitConditionForm(formtype) {
        var userPatientID = "{{$userId}}";
        if ($("#conditionform").valid()) {
            $("#submitfhbtn").prop('disabled', true);
            let formdata = $("#conditionform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/familyhistory/store")}}',
                type: "post",
                data: {
                    'patientID': userPatientID,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        getHistoryDetails('family_history','history');
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
                    var hiddenInput = `<input type="hidden" name="family_history[condition_id][]" value="${conditionID}">`;
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
            $("input[name*='family_history[condition_id][]'][value='" + conditionID + "']").remove();

            // If there are no conditions left, clear the hascondition field
            var selectedConditions = $(".selected-condition").length;
            if (selectedConditions === 0) {
                $("#hascondition").val(""); // Clear hascondition
            }
        });
    }

</script>