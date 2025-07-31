<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-medium">Add Data</h4>
    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<form method="POST" id="weightform" autocomplete="off">@csrf
    <div class="row align-items-start align-row">
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Date</label>
                <input type="text" class="form-control bpdate"  id="weight_reportdate" name="weight[reportdate]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Time</label>
                <input type="text" class="form-control bptime"  id="weight_reporttime" name="weight[reporttime]" placeholder="">
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group form-outline no-iconinput formmedicalhiscls">
                <label for="input" class="float-label">Weight</label>
                <input type="text" class="form-control medicalhiscls" name="weight[weight]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['weight']}}" @endif >
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="form-group form-floating no-iconinput unitercls">
                
                <select class="form-select weightunitcls${ctCnt} unitformcls" name="weight[unit]" placeholder=""> 
                    <option value="">Select Unit Type</option>
                    <option value="kg" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] == 'kg') selected @endif>kg</option> 
                    <option value="lbs" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] == 'lbs') selected @endif>lbs</option> 
                </select>
                <label class="select-label">Unit Type</label> 
            </div>
        </div>

        @if(isset($isheight) && $isheight == 0 )
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput formmedicalheightscls">
                <label for="input" class="float-label">Height</label>
                <input type="text" class="form-control heightcls" name="height[height]" >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-floating no-iconinput hieghtunitercls">
                
                <select class="form-select weightunitcls${ctCnt} heightunitformcls" name="height[heightunit]" placeholder=""> 
                    <option value="">Select Unit Type</option>
                    <option value="cm" selected >cm</option> 
                    <option value="inches">inches</option> 
                </select> 
                <label class="select-label">Unit Type</label> 
            </div>
        </div>
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="height[sourcetype]" value="3">
        @endif

        <input type="hidden" class="form-control coucetype"  id="coucetype" name="weight['sourcetype']" value="3">
        @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['weight_tracker_uuid'])
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="glucose[key]" value="{{$medicathistoryDetails['weight_tracker_uuid']}}">
        @endif

    </div>
</form>
                
<div class="btn_alignbox mt-4">
    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('weight','weightform','{{$formType}}')">Add Data</a>
</div>

<script>
    $(document).ready(function() {
        $('.bpdate').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false,
            maxDate: moment().endOf('day'), // Ensures today is selectable
        });
        $('.bptime').datetimepicker({
            format: 'hh:mm A',
            locale: 'en',
            useCurrent: false, // Prevents setting current time by default
            stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
            timeZone: userTimeZone
        });

        $("#weightform").validate({
            ignore: [],
            rules: {
                "weight[reportdate]": {
                    required: true,
                },
                "weight[reporttime]": {
                    required: true,
                },
                "weight[weight]": {
                    required: true,
                    number: true,
                },
                "weight[unit]": {
                    required: true,
                },
                "height[height]": {
                    required: true,
                    number: true,
                },
                "height[unit]": {
                    required: true,
                },
            },
            messages: {
                "weight[reportdate]": {
                    required: 'Please select report date.',
                },
                "weight[reporttime]": {
                    required: 'Please select report time.',
                },
                "weight[weight]": {
                    required :'Please enter weight.',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "weight[unit]": {
                    required :'Please  select unit.',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "height[height]": {
                    required :'Please enter height.',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "height[unit]": {
                    required :'Please  select unit.',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("medicalhiscls")) {
                    error.appendTo('.formmedicalhiscls');
                }else if (element.hasClass("unitformcls")) {
                    error.appendTo('.unitercls');
                }else if (element.hasClass("heightunitformcls")) {
                    error.appendTo('.heightunitercls');
                }else{
                    error.insertAfter(element);
                }
            },
        });
    });

    // Function to toggle the 'active' class
    function toggleLabel(input) {
        const hasValueOrFocus = $.trim(input.value) !== '';
        $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
    }
    // Initialize label state for each input
    $('input').each(function() {
        toggleLabel(this);
    });

    // Handle label toggle on focus, blur, and input change
    $(document).on('focus blur input change', 'input, textarea', function() {
        toggleLabel(this);
    });

    // Handle the datetime picker widget appearance by re-checking label state
    $(document).on('click', '.bootstrap-datetimepicker-widget', function() {
        const input = $(this).closest('.time').find('input');
        toggleLabel(input[0]);
    });

    // Trigger label toggle when modal opens
    $(document).on('shown.bs.modal', function(event) {
        const modal = $(event.target);
        modal.find('input, textarea').each(function() {
            toggleLabel(this);
            // Force focus briefly to trigger label in case of any timing issues
            $(this).trigger('focus').trigger('blur');
        });
    });

    // Reset label state when modal closes
    $(document).on('hidden.bs.modal', function(event) {
        const modal = $(event.target);
        modal.find('input, textarea').each(function() {
            $(this).parent().find('.float-label').removeClass('active');
        });
    });

</script>