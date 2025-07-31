
<div class="tab-pane fade show active"  id="medicalhistorytab" role="tabpanel" aria-labelledby="medicalhistory-tab">
    <div class="row"> 
        <div class="col-12"> 
            <div class="btn_alignbox justify-content-end mb-4"> 
                <a class="primary d-flex align-items-center gap-1"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
            </div>
        </div>
        <div class="col-lg-10 col-xxl-8 mx-auto"> 
            <div class="content-box text-center mb-4"> 
                <h3 class="mb-2">Record Medical History</h3>
                <p class="px-lg-5 mx-lg-5">Your family’s health history helps us better understand your health and provide the best care possible.</p>
            </div>
        </div>
        <form method="POST" id="historyform" autocomplete="off">
        @csrf
            <div class="col-12"> 
                <div class="row">
                    <div class="col-12">
                        <h6 class="fwt-bold">Medical Conditions</h6>
                        <div class="row relation-append"> 
                            <div class="col-12">
                                <div class="row mb-3 relation-item">
                                    <div class="col-md-4"> 
                                        <div class="form-group form-floating">
                                            <select class="form-select relation-select" name="relations[1][relation]" placeholder="">
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
                                    <div class="col-md-8"> 
                                      
                                            <div class="form-group form-outline flex-grow-1 my-md-0 my-3">
                                                <label class="float-label">Condition(s)</label>
                                                <input type="text" class="form-control condition" name="relations[1][condition]" placeholder="" data-count="1">
                                            </div>
                                            <div class="multi-wrapper" id="multiselect_1"></div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-12"> 
                                <div class="btn_alignbox justify-content-end mb-3"> 
                                    <a href="javascript:void(0);" class="primary d-flex align-items-center gap-2" id="add-relation" onclick="addRelation();"><span class="material-symbols-outlined">add</span>Add Relation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="sourcetype" id="sourcetype" value="1">
                    <div class="col-12"> 
                        <div class="subt-btn btn_alignbox justify-content-end my-5"> 
                            <a class="btn text-decoration-underline skip_btn" onclick="getNextIntakeForm('success','1')">Skip</a>
                            <a class="btn btn-outline-primary" onclick="getNextIntakeForm('medication')">Previous</a>
                            <button class="btn btn-primary" id="historybutton" onclick="submitHistoryForm('success')">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    
  
    
    $(document).ready(function () {
        getConditions();
    });
    function getConditions() {
        $(".condition").autocomplete({
            autoFocus: true,
            source: function (request, response) {
                $.getJSON('{{ url('intakeform/condition/search') }}', 
                    {  
                        term: request.term 
                    }, 
                    response);
            },
            minLength: 2,
            select: function (event, ui) {
                var conditionInput = $(this);
                var relationCount = conditionInput.data('count');
                var conditionMultiselect = $("#multiselect_"+relationCount);
                var relationWrapper = conditionInput.closest('.relation-item'); // Get the specific relation item for this input field
                var selectedConditionsContainer = conditionMultiselect.find(".selected-conditions-container");

                if (ui.item.key !== '0') {
                    // Append the selected condition to the selected conditions container
                    var conditionID = ui.item.key;
                    var existingCondition = selectedConditionsContainer.find(`.selected-condition[data-id="${conditionID}"]`);
                    if (existingCondition.length > 0) {
                        swal("Warning","This condition is already selected!","error");
                        conditionInput.val("");
                        event.preventDefault();
                        return;
                    }
                    var conditionLabel = ui.item.label;

                    if (selectedConditionsContainer.length === 0) {
                        selectedConditionsContainer = $("<div class='selected-conditions-container'></div>");
                        conditionMultiselect.append(selectedConditionsContainer);
                    }

                    // Append the condition with a remove button
                    var conditionHTML = `
                        <div class="selected-condition mt-2" data-id="${conditionID}">
                            <p>${conditionLabel}</p>
                            <button type="button" class="remove-condition"><span class="material-symbols-outlined">close</span></button>
                        </div>
                    `;
                    selectedConditionsContainer.append(conditionHTML);

                    // Add a hidden input field for the condition ID (dynamically naming the hidden input)
                    var hiddenInputName = `relations[${relationCount}][condition_id][]`;  // Use the relation index to name the hidden input
                    var hiddenInput = `<input type="hidden" name="${hiddenInputName}" value="${conditionID}">`;
                    selectedConditionsContainer.append(hiddenInput);
                    conditionInput.valid();
                    $('.conditioncls').hide();
                    
                    // Clear the condition input field
                    conditionInput.val("");
                }

                event.preventDefault();
            },
            focus: function (event, ui) {
                event.preventDefault();
            },
            open: function () {
                $(this).autocomplete("widget")
                    .appendTo("#results").css({'position': 'static', 'width': '100%'});
                $('.ui-autocomplete').css('z-index', '9999');
                $('.ui-autocomplete').addClass('srchuser-dropdown');
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li><span class='srchuser-downname'>" + item.label + "</span></li>")
                .data("ui-autocomplete-item", item.key)
                .appendTo(ul);
        };

        // Event listener to remove selected conditions
        $(document).on("click", ".remove-condition", function () {
            var conditionElement = $(this).closest(".selected-condition");
            var conditionID = conditionElement.data("id");

            // Remove the condition from the UI and the hidden input
            conditionElement.remove();
            $("input[name*='condition_id[]'][value='" + conditionID + "']").remove();
        });

    }
    function addRelation() {
        $(".condition").autocomplete("destroy");
        const relationCount = document.querySelectorAll('div.relation-append .row').length + 1;

        const relationHtml = `
            <div class="col-12">
                <div class="row mb-3 relation-item">
                    <div class="col-md-4"> 
                        <div class="form-group form-floating">
                            <select class="form-select relation-select" name="relations[${relationCount}][relation]" 
                                placeholder="" value="" onchange="validateDuplicateRelation(this);">
                                <option value="">Select Relation</option>
                                @if(!empty($relations))
                                    @foreach($relations as $rl)
                                        <option value="{{$rl['id']}}">{{$rl['relation']}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label class="select-label">Relation</label>
                        </div>
                        <span class="error-message" style="color: red; display: none;">This relation has already been selected.</span>
                    </div>
                    <div class="col-md-7"> 
                        <div class="form-group form-outline flex-grow-1 my-md-0 my-3">
                            <label class="float-label">Condition(s)</label>
                            <input type="text" class="form-control condition" name="relations[${relationCount}][condition]" 
                                placeholder="" data-count="${relationCount}">
                        </div>
                        <div class="multi-wrapper" id="multiselect_${relationCount}"></div>
                    </div>
                    <div class="col-md-1"> 
                        <div class="btn_alignbox justify-content-end">
                            <a class="danger"><span class="material-symbols-outlined fwt-medium" onclick="removeRelation(this);">delete</span></a>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append the new relation select to the relation-append container
        $('.relation-append').append(relationHtml);
        getConditions();
    }

    // 🔹 Function to validate duplicate relation selection
    function validateDuplicateRelation(selectElement) {
        let selectedValue = $(selectElement).val();
        let isDuplicate = false;

        $(".relation-select").each(function () {
            if ($(this).val() === selectedValue && this !== selectElement) {
                isDuplicate = true;
            }
        });

        if (isDuplicate) {
            console.log('relation')
            $('.relationcls').hide();
            $(selectElement).closest('.form-group').next('.error-message').show();
            $(selectElement).val(""); // Reset dropdown
        } else {
            $(selectElement).closest('.form-group').next('.error-message').hide();
        }
    }
    function removeRelation(element) {
        $(element).closest('.relation-item').remove();
    }

    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".relation-select").forEach(function (select) {
        function toggleFloatingLabel() {
            const hasValue = select.value && select.value !== "";
            select.classList.toggle("has-value", hasValue);
        }

        // Initialize floating label correctly on page load
        toggleFloatingLabel();

        // Listen for changes
        select.addEventListener("change", toggleFloatingLabel);
    });
});
</script>