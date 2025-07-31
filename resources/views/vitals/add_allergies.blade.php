        
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Add Data</h4>
                    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <form method="POST" id="historyform" autocomplete="off">@csrf
                <div class="row align-items-center align-row">
                    <div class="col-md-6">
                        <div class="form-group form-outline no-iconinput formallergyhiscls">
                            <label for="input" class="float-label">What Are You Allergic To?</label>
                            <input type="text" class="form-control allergycls" id="allergies" name="allergies[allergy]"   @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['allergy']}}" @endif>
                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-outline no-iconinput formreactionhiscls">
                            <label for="reaction" class="float-label">Reaction / Side Effect</label>
                            <input type="text" class="form-control reactioncls" id="reaction" name="allergies[reaction]"   @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['reaction']}}" @endif>
                           
                        </div>
                    </div>
                    <input type="hidden" class="form-control coucetype"  id="coucetype" name="allergies[sourcetype]" value="3">
                    @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['allergies_uuid'])
                    <input type="hidden" class="form-control coucetype"  name="allergies[key]" value="{{$medicathistoryDetails['allergies_uuid']}}">
                    @endif

                </div>
                </form>
                
                <div class="btn_alignbox mt-4">
                    <a type="button" class="btn btn-primary w-100"  id="submitcndtnbtn" onclick="submitIntakeForm('allergies','historyform','history')">Add Data</a>
                </div>



    <script>
   
 
    $(document).ready(function() {
        $('#historyform').on('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitIntakeForm('allergies','historyform','history');
            }
        });
        var userPatientID = "{{$userId}}";

        $("#historyform").validate({
                ignore: [],
                rules: {
                 
                        "allergies[allergy]": {
                            required: true,
                            validAllergy: true,
                            validTextOrNumber: true 
                        },
                        "allergies[reaction]": {
                           
                            validAllergyReact: true,
                            validTextOrNumber: true 
                        },
                      
                      
                },
                messages: {
                    "allergies[allergy]": {
                    required :'Please enter allergy details.',
                    validAllergy: 'Please enter valid allergy details',
                     validTextOrNumber: 'Please enter valid allergy details',
                },
                "allergies[reaction]": {
                  
                    validAllergyReact: 'Please enter valid data',
                     validTextOrNumber: 'Please enter valid data',
                },
                
                
                
                
                },
                errorPlacement: function(error, element) {
                    if(element.hasClass("allergycls")) {
                        error.appendTo('.formallergyhiscls');
                    }else if (element.hasClass("reactioncls")) {
                        error.appendTo('.formreactionhiscls');
                    }else{
                        error.insertAfter(element);
                    }
                   
                },
            });

            $.validator.addMethod("validAllergyReact", function(value, element) {
                // Remove all spaces
                var trimmed = $.trim(value);

                // Allow only if contains at least one alphanumeric character
                return this.optional(element) || /^[A-Za-z0-9].*/.test(trimmed);
            }, "Please enter valid allergy details.");

            $.validator.addMethod("validAllergy", function(value, element) {
                // Remove all spaces
                var trimmed = $.trim(value);

                // Allow only if contains at least one alphanumeric character
                return this.optional(element) || /^[A-Za-z0-9].*/.test(trimmed);
            }, "Please enter valid allergy details.");

                    // Add custom validation to check if input contains only numbers
            $.validator.addMethod("validTextOrNumber", function(value, element) {
                // Check if the value contains only numbers (no text)
                var trimmedValue = $.trim(value);
                return this.optional(element) || /^(?!\d+$).*$/g.test(trimmedValue); // Validates if it's not only numbers
            }, "Please enter a valid allergy details.");

    });

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