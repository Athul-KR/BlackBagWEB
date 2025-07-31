@if(!empty($medicathistoryDetails))
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
<form method="POST" id="intakeformheight" autocomplete="off">
    @csrf
    <div class="inner-history">
        <div class="row align-items-start">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="history-box">
                            <div class="form-group form-outline heightclserr">
                                <label class="float-label">height (cm or inches)</label>
                                <input type="text" class="form-control hieghtcls" id="heigh" name="height[height]" placeholder="" value="{{$medicathistoryDetails['height']}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="history-box">
                            <div class="form-group form-floating heightunitclserr">
                                <select class="form-select heightunitcls" name="height[unit]" placeholder="">
                                    <option value="">Select Unit Type</option>
                                    <option value="cm" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit']=='cm' ) selected @endif>cm</option>
                                    <option value="inches" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit']=='inches' ) selected @endif>inches</option>
                                    <option value="inches" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit']=='ft' ) selected @endif>ft</option>
                                </select>
                                <label class="select-label">Unit Type</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="history-box mb-3">
                            <div class="form-group form-outline">
                                <label class="float-label">Report Date</label>
                                <input type="text" class="form-control bpdate" name="height[reportdate]" placeholder="" value="@if( $medicathistoryDetails['reportdate'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reportdate'], "m/d/Y") ?> @endif">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control coucetype" id="key" name="height[key]" value="{{$medicathistoryDetails['height_tracker_uuid']}}">
                    <input type="hidden" class="form-control coucetype" id="coucetype" name="height[sourcetype]" @if(Session::get('user.userType')=='patient' ) value="2" @else value="3" @endif>
                </div>
            </div>
            <div class="col-md-2">
                <div class="btn_alignbox justify-content-end">
                    <a class="opt-btn" onclick="submitIntakeForm('height')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a>
                    <a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryDatapm('height')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                </div>
            </div>
        </div>
    </div>
</form>
@endif
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $('.bpdate').datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false,
        maxDate: new Date(), // This will allow only past dates and block future dates
    });

    $('.bptime').datetimepicker({
        format: 'hh:mm A',
        locale: 'en',
        useCurrent: false, // Prevents setting current time by default
        stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
        timeZone: userTimeZone
    });

    function validateEditFrom() {

        $("#intakeformheight").validate({
            rules: {
                "height[height]": {
                    required: true,
                    number: true,
                    min: 1,
                },
                "height[unit]": {
                    required: true,
                },
            },
            messages: {
                "height[height]": {
                    required: 'Please enter the height.',
                    number: 'Please enter a numeric value',
                    min: 'Please enter a value greater than 0',
                },
                "height[unit]": {
                    required: 'Please select unit type.',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("hieghtcls")) {
                    error.insertAfter(".heightclserr");
                } else if (element.hasClass("heightunitcls")) {
                    error.insertAfter(".heightunitclserr");
                } else {
                    error.insertAfter(element);
                }
            },

        });
    }

    function submitIntakeForm(formtype) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateEditFrom()
        if ($("#intakeformheight").valid()) {
            let formdata = $("#intakeformheight").serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype': formtype,
                    'patientID': patientID,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        getmedicalhistoryDatapm(formtype);
                    } else {

                    }
                },
                error: function(xhr) {

                    handleError(xhr);
                },
            });
        } else {
            if ($('.error:visible').length > 0) {
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: ($('.error:visible').first().offset().top - 100)
                    }, 500);
                }, 500);
            }
        }
    }
</script>

<script>
    $(document).ready(function() {
        function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');

            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }

        // Initialize all inputs on page load
        $('input, textarea').each(function() {
            toggleLabel(this);
        });

        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function() {
            toggleLabel(this);
        });

        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function(e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });
    });
</script>