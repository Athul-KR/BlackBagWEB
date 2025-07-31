<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-medium">Add Data</h4>
    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<form method="POST" id="cholesterolform" autocomplete="off">
@csrf
    <div class="row align-items-center align-row">
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Date</label>
                <input type="text" class="form-control bpdate"  id="cholesterol_reportdate" name="cholesterol[chdate]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Time</label>
                <input type="text" class="form-control bptime"  id="cholesterol_reporttime" name="cholesterol[chtime]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput formmedicalhiscls">
                <label for="input" class="float-label">Total Cholesterol (mg/dL)</label>
                <input type="text" class="form-control medicalhiscls valcls" name="cholesterol[cholesterol]"   @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['cltotal']}}" @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput ">
                <label for="input" class="float-label">HDL (mg/dL)</label>
                <input type="text" class="form-control valcls" name="cholesterol[hdl]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['HDL']}}" @endif >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput ">
                <label for="input" class="float-label">LDL (mg/dL)</label>
                <input type="text" class="form-control valcls" name="cholesterol[ldl]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['LDL']}}" @endif >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput ">
                <label for="input" class="float-label">Triglycerides (mg/dL)</label>
                <input type="text" class="form-control valcls" name="cholesterol[triglycerides]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['triglycerides']}}" @endif >
            </div>
        </div>
        <input type="hidden" name="hasvalue" class="hasvalue" id="hasvalue" />
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="cholesterol[sourcetype]" value="3">
        @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['cholestrol_tracker_uuid'])
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="cholesterol[key]" value="{{$medicathistoryDetails['cholestrol_tracker_uuid']}}">
        @endif

    </div>
</form>
<div class="btn_alignbox mt-4">
    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('cholesterol','cholesterolform','{{$formType}}')">Add Data</a>
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
        $("#cholesterolform").validate({
            ignore: [],
            rules: {
                "cholesterol[chdate]": {
                    required: true,
                },
                "cholesterol[chtime]": {
                    required: true,
                },
                "cholesterol[cltotal]": {
                    number: true,
                    min:1,
                },
                "cholesterol[LDL]": {
                    number: true,
                    min:1,
                },
                "cholesterol[HDL]": {
                    number: true,
                    min:1,
                },
                "cholesterol[triglycerides]": {
                    number: true,
                    min:1,
                },
                hasvalue: "required",
            
            },
            messages: {
                "cholesterol[chdate]": {
                    required: 'Please select report date.',
                },
                "cholesterol[chtime]": {
                    required: 'Please select report time.',
                },
                "cholesterol[cltotal]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "cholesterol[LDL]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "cholesterol[HDL]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "cholesterol[triglycerides]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
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