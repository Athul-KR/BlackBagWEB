<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-medium">Add Data</h4>
    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<form method="POST" id="temparaturefrom" autocomplete="off">@csrf
    <div class="row align-items-start align-row">
        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Date</label>
                <input type="text" class="form-control bpdate"  id="body_temperature_reportdate" name="body_temperature[reportdate]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput">
                <label class="float-label">Report Time</label>
                <input type="text" class="form-control bptime"  id="body_temperature_reporttime" name="body_temperature[reporttime]" placeholder="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group form-outline no-iconinput formsystoliccls">
                <label for="input" class="float-label">Temparature (°C or °F)</label>
                <input type="text" class="form-control systoliccls" name="body_temperature[temperature]"  @if(!empty($medicathistoryDetails)) value="@if(isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] =='c'){{$medicathistoryDetails['celsius']}}@else{{$medicathistoryDetails['farenheit']}} @endif @" @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-floating no-iconinput formmedicalhiscls">
                    <select class="form-select weightunitcls${ctCnt} medicalhiscls" name="body_temperature[unit]" placeholder=""> 
                    <option value="">Select Unit Type</option>
                    <option value="c"  @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] == 'c') selected @endif >Celsius</option> 
                    <option value="f"  @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] == 'f') selected @endif>Farenheit</option> 
                </select> 
            </div>
        </div>
    
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="body_temperature['sourcetype']" value="3">
        @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['body_temperature_uuid'])
        <input type="hidden" class="form-control coucetype"  id="coucetype" name="glucose[key]" value="{{$medicathistoryDetails['body_temperature_uuid']}}">
        @endif
    </div>
</form>
                
<div class="btn_alignbox mt-4">
    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('temparature','temparaturefrom','{{$formType}}')">Add Data</a>
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
        $("#temparaturefrom").validate({
            ignore: [],
            rules: {
                "body_temperature[reportdate]": {
                    required: true,
                },
                "body_temperature[reporttime]": {
                    required: true,
                },
                "body_temperature[temperature]": {
                    required: true,
                    number: true,
                    min: 1,
                    noSpecialChars: true,
                    temperatureRange: true
                },
                "body_temperature[unit]": {
                    required: true,
                },
            },
            messages: {
                "body_temperature[reportdate]": {
                    required: 'Please select report date.',
                },
                "body_temperature[reporttime]": {
                    required: 'Please select report time.',
                },
                "body_temperature[temperature]": {
                    required: 'Please enter the temperature',
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                    pattern: "Special characters are not allowed",
                    temperatureRange: "Please enter a valid temperature (30°C - 45°C or 86°F - 113°F).",
                },
                "body_temperature[unit]": {
                    required: 'Please select the unit',
                },
            },
            errorPlacement: function(error, element) {

                if (element.hasClass("medicalhiscls")) {
                
                    error.appendTo('.formmedicalhiscls');
                }else if (element.hasClass("systoliccls")) {
                
                error.appendTo('.formsystoliccls');
            } else {
                    error.insertAfter(element);
                }
            
            },
        });
        $.validator.addMethod("noSpecialChars", function (value, element) {
            return this.optional(element) || /^[0-9]+(\.[0-9]+)?$/.test(value);
        }, "Special characters are not allowed");

        $.validator.addMethod("temperatureRange", function (value, element) {
            var unit = $('select[name="body_temperature[unit]"]').val();
            var temp = parseFloat(value);

            if (unit === 'c') {
                return temp >= 30 && temp <= 45;
            } else if (unit === 'f') {
                return temp >= 86 && temp <= 113;
            }
            return false;
        }, "Please enter a valid temperature (30°C - 45°C or 86°F - 113°F).");
    });

</script>