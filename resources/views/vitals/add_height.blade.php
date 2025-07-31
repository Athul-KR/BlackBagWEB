<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-medium">Add Data</h4>
    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<form method="POST" id="heightform" autocomplete="off">@csrf
    <div class="row align-items-start align-row">
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Date</label>
                <input type="text" class="form-control bpdate" id="height_reportdate" name="height[reportdate]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Time</label>
                <input type="text" class="form-control bptime" id="height_reporttime" name="height[reporttime]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput formmedicalhiscls">
                <label for="input" class="float-label">Height</label>
                <input type="text" class="form-control heightcls" name="height[height]" @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['height']}}" @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-floating no-iconinput unitercls">

                <select class="form-select weightunitcls${ctCnt} unitformcls" name="height[unit]" placeholder="">
                    <option value="">Select Unit Type</option>
                    <option value="cm" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit']=='cm' ) selected @endif>cm</option>
                    <option value="inches" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit']=='inches' ) selected @endif>inches</option>
                    <option value="ft" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit']=='ft' ) selected @endif>ft</option>
                </select>
                <label class="select-label">Unit Type</label>
            </div>
        </div>
        <input type="hidden" class="form-control coucetype" id="coucetype" name="height[sourcetype]" value="3">


        @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['height_tracker_uuid'])
        <input type="hidden" class="form-control coucetype" id="coucetype" name="glucose[key]" value="{{$medicathistoryDetails['height_tracker_uuid']}}">
        @endif

    </div>
</form>
<div class="btn_alignbox mt-4">
    <a type="button" class="btn btn-primary w-100" id="submitbpbtn" onclick="submitIntakeForm('weight','heightform','{{$formType}}')">Add Data</a>
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

        $('input').each(function() {
            toggleLabel(this);
        });

        $("#heightform").validate({
            ignore: [],
            rules: {
                "height[reportdate]": {
                    required: true,
                },
                "height[reporttime]": {
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
                "height[reportdate]": {
                    required: 'Please select report date.',
                },
                "height[reporttime]": {
                    required: 'Please select report time.',
                },
                "height[height]": {
                    required: 'Please enter height.',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "height[unit]": {
                    required: 'Please  select unit.',

                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("medicalhiscls")) {
                    error.appendTo('.formmedicalhiscls');
                } else if (element.hasClass("unitformcls")) {
                    error.appendTo('.unitercls');
                } else {
                    error.insertAfter(element);
                }
            },
        });
    });
</script>