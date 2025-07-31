<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-medium">Add Data</h4>
    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<form method="POST" id="saturationform" autocomplete="off">@csrf
    <div class="row align-items-center align-row">
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Date</label>
                <input type="text" class="form-control bpdate"  id="reportdate" name="reportdate" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Time</label>
                <input type="text" class="form-control bptime"  id="reporttime" name="reporttime" placeholder="">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group form-outline no-iconinput formmedicalhiscls">
                <label for="input" class="float-label">Saturation</label>
                <input type="text" class="form-control medicalhiscls" name="saturation" @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['saturation']}}" @endif>
            </div>
        </div>
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="sourcetype" value="3">
        
        @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['oxygen_saturation_uuid'])
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="glucose[key]" value="{{$medicathistoryDetails['oxygen_saturation_uuid']}}">
        @endif
    </div>
</form>
                
<div class="btn_alignbox mt-4">
    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('oxygen-saturations','saturationform','{{$formType}}')">Add Data</a>
</div>
<script>
    $('#saturationform').on('keydown', function(e) {
        if (e.key === 'Enter') {
            return ;
        }
    });
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

        $("#saturationform").validate({
            ignore: [],
            rules: {
                "reportdate": {
                    required: true,
                },
                "reporttime": {
                    required: true,
                },
                "saturation": {
                    required : true,
                    number : true,
                    max : 100 ,
                    min : 50 ,
                },
            },
            messages: {
                reportdate: {
                    required: 'Please select report date.',
                },
                reporttime: {
                    required: 'Please select report time.',
                },
                saturation: {
                    required : "Please enter saturation",
                    number : "Please enter a numeric value.",
                    max : "Please enter a valid value.",
                    min : "Please enter a valid value.",
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


    </script>