<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-medium">Add Data</h4>
    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<form method="POST" id="glucoseform" autocomplete="off">@csrf
    <div class="row align-items-center align-row">
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Date</label>
                <input type="text" class="form-control bpdate"  id="glucose_reportdate" name="glucose[glucosedate]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Time</label>
                <input type="text" class="form-control bptime"  id="glucose_reporttime" name="glucose[glucosetime]" placeholder="">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput formmedicalhiscls">
                <label for="input" class="float-label ">Glucose Value (mg/dL)</label>
                <input type="text" class="form-control medicalhiscls valcls" name="glucose[glucose]"   @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['bgvalue']}}" @endif>
                <input type="hidden" name="hasvalue" class="hasvalue" id="hasvalue" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput ">
                <label for="input" class="float-label">HbA1C (%)</label>
                <input type="text" class="form-control valcls" name="glucose[hba1c]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['hba1c']}}" @endif >
            </div>
                <input type="hidden" name="hasvalue" class="hasvalue" id="hasvalue" />
        </div>

        <input type="hidden" class="form-control coucetype"  id="coucetype" name="glucose[sourcetype]" value="3">
        @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['glucose_tracker_uuid'])
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="glucose[key]" value="{{$medicathistoryDetails['glucose_tracker_uuid']}}">
        @endif

    </div>
</form>
                
<div class="btn_alignbox mt-4">
    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('glucose','glucoseform','{{$formType}}')">Add Data</a>
</div>

<script>
    $(".valcls").on('input', function () { 
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
        $("#glucoseform").validate({
            ignore: [],
            rules: {
                "glucose[glucose]": {
                    // required: true,
                    number: true,
                    min:1,
                },
                "glucose[hba1c]": {
                    number: true,
                    min:1,
                },
                "glucose[glucosedate]": {
                    required: true,
                },
                "glucose[glucosetime]": {
                    required: true,
                },
                hasvalue: "required",
            
            },
            messages: {
                "glucose[glucose]": {
                    required :'Please enter glucose value.',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "glucose[hba1c]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "glucose[glucosedate]": {
                    required: 'Please select report date.',
                },
                "glucose[glucosetime]": {
                    required: 'Please select report time.',
                },
                hasvalue: "Please enter any one of the record",
            
            
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("medicalhiscls")) {
                    error.appendTo('.formmedicalhiscls');
                }else if(element.hasClass("hasvalueww")) {
                    error.appendTo('.formmedicalhiscls');
                }else{
                    error.insertAfter(element);
                }
                
            },
        });
    });
</script>