        
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Add Data</h4>
                    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <form method="POST" id="historyform" autocomplete="off">@csrf
                <div class="row align-items-center align-row">
                    <div class="col-md-12">
                        <div class="form-group form-outline no-iconinput formmedicalhiscls">
                            <label for="input" class="float-label">Condition(s)</label>
                            <input type="text" class="form-control condition" id="condition" name="medical_conditions[condition]"   @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['condition']}}" @endif>
                            <input class="patient-ctn" type="hidden" id="condition_id" name="medical_conditions[condition_id]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['condition_id']}}" @endif>
                            <input type="hidden" name="medical_conditions[relation]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['relation_id']}}" @else value="19" @endif >
                        </div>
                    </div>
                    <input type="hidden" class="form-control coucetype"  id="coucetype" name="medical_conditions[sourcetype]" value="3">
                    @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['patient_condition_uuid'])
                    <input type="hidden" class="form-control coucetype"  name="medical_conditions[key]" value="{{$medicathistoryDetails['patient_condition_uuid']}}">
                    @endif

                </div>
                </form>
                
                <div class="btn_alignbox mt-4">
                    <a type="button" class="btn btn-primary w-100"  id="submitcndtnbtn" onclick="submitIntakeForm('medical_conditions','historyform','history')">Add Data</a>
                </div>



    <script>
    $(document).ready(function() {

        $('#historyform').on('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitIntakeForm('medical_conditions','historyform','history');
            }
        });
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
            data: {
                // term : request.term,
            },
            select: function(event, ui) {
                var conditionInput = $(this);

                if (ui.item.key != '0') {
                    
                    conditionInput.siblings("#condition_id").val(ui.item.key);
                    var count = 1;
                    var countVal = '';
                } else {
                    conditionInput.val('');
                    conditionInput.siblings("#condition").val('');
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
        $(document).on("input", ".valcls, .condition", function () {
            console.log('error')
           
            $(this).valid(); // This ensures validation updates dynamically
        });

    }
    $(document).ready(function() {
        $(document).ready(function() {
            getConditions();
           
        });
        var userPatientID = "{{$userId}}";

        $("#historyform").validate({
            ignore: [],
            rules: {
                "medical_conditions[condition_id]": {
                    required: true,
                    remote: {
                        url: "{{ url('/intakeform/checkconditionexists') }}",
                        data: {
                            'patientID': userPatientID,
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                        async: false,
                    },
                },
            },
            messages: {
                "medical_conditions[condition_id]": {
                    required: "Please select condition",
                    remote: "Condition already added",
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("medicalhiscls")) {
                    error.appendTo('.formmedicalhiscls');
                }else{
                    error.insertAfter(element);
                }
                
            },
        });
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