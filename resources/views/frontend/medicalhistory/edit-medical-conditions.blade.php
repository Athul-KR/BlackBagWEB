@if(!empty($medicathistoryDetails))
    <div class="">  
        <form method="POST" id="edithistoryform" autocomplete="off">
        @csrf
            <div class="row align-items-center"> 
                <div class="col-md-10"> 
                    <div class="row"> 
                        <div class="col-md-12"> 
                            <div class="history-box"> 
                                <div class="form-group form-outline">
                                    <label class="float-label">Condition(s)</label>
                                    <input type="text" class="form-control condition valcls" name="condition" value="{{$condition}}" placeholder="">
                                    <input type="hidden" name="condition_id" value="{{$medicathistoryDetails['condition_id']}}" class="">
                                    <input type="hidden" name="relation" value="{{$medicathistoryDetails['relation_id']}}">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                        <input type="hidden" name="hasmedihisvalue" id="hasmedihisvalue" />
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="btn_alignbox justify-content-end">
                        <a class="opt-btn" onclick="updateHistoryForm('medical-conditions','{{$medicathistoryDetails['patient_condition_uuid']}}')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('medical-conditions')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endif
<script>
    $(document).ready(function () {
        getConditions();
        hasFormValue();
    });
    function getConditions(){
        $( ".condition" ).autocomplete({
            autoFocus: true,
            source: function(request, response) {
                $.getJSON('{{ url('intakeform/condition/search') }}', 
                    {  
                        term: request.term 
                    }, 
                    response);
            },
            minLength: 2,
            data: {
                // term : request.term,
            },
            select: function( event, ui ) {
                var conditionInput = $(this);
    
                if (ui.item.key != '0') {
                    conditionInput.siblings("input[name=condition_id]").val(ui.item.key);
                    var count = 1;
                    var countVal = '';
                } else {
                    conditionInput.val('');
                    conditionInput.siblings("input[name=condition]").val(''); 
                    event.preventDefault();
                }
            },
            focus: function (event, ui) {
                selectFirst: true;
                event.preventDefault();
            },
            open: function( event, ui ) {
                $(this).autocomplete("widget")
                    .appendTo("#results").css({'position' : 'static','width' : '100%'});
                $('.ui-autocomplete').css('z-index','9999');
                $('.ui-autocomplete').addClass('srchuser-dropdown');
            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li><span class='srchuser-downname'>"+item.label+"</span></li>" ).data( "ui-autocomplete-item", item.key ) .appendTo( ul );
        };
    }

    $(document).ready(function () {
    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
        const isFocused = $input.is(':focus');

        // Ensure .float-label is correctly selected relative to the input
        $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
    }

    // Initialize all inputs on page load
    $('input, textarea').each(function () {
        toggleLabel(this);
    });

    // Handle input events
    $(document).on('focus blur input change', 'input, textarea', function () {
        toggleLabel(this);
    });

    // Handle dynamic updates (e.g., Datepicker)
    $(document).on('dp.change', function (e) {
        const input = $(e.target).find('input, textarea');
        if (input.length > 0) {
            toggleLabel(input[0]);
        }
    });
});

</script>
