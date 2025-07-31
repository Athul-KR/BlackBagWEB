@if(!empty($medicathistoryDetails))
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
<div class="inner-history"> 
    <form method="POST" id="intakeformweight" autocomplete="off">
    @csrf
        <div class="row align-items-start">
            <div class="col-md-10"> 
                <div class="row"> 
                    <div class="col-md-6 mb-3">
                        <div class="history-box"> 
                            <div class="form-group form-outline weightclserr">
                                <label class="float-label">Weight (kg or lbs)</label>
                                <input type="text" class="form-control weightcls" id="weight" name="weight[weight]"  placeholder=""  value="{{$medicathistoryDetails['weight']}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="history-box">
                            <div class="form-group form-floating weightunitclserr"> 
                                <select class="form-select weightunitcls" name="weight[unit]" placeholder="">
                                    <option value="">Select Unit Type</option>
                                    <option value="kg" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] == 'kg') selected @endif>kg</option>
                                    <option value="lbs" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['unit']) && $medicathistoryDetails['unit'] == 'lbs') selected @endif>lbs</option>
                                </select>
                                <label class="select-label">Unit Type</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="history-box mb-3"> 
                            <div class="form-group form-outline">
                                <label class="float-label">Report Date</label>
                                <input type="text" class="form-control bpdate" name="weight[reportdate]" placeholder="" value="@if( $medicathistoryDetails['reportdate'] != '') <?php echo $corefunctions->timezoneChange($medicathistoryDetails['reportdate'],"m/d/Y") ?> @endif">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control coucetype"  id="coucetype'+ctCnt+'" name="weight[key]" value="{{$medicathistoryDetails['weight_tracker_uuid']}}">
                    <input type="hidden" class="form-control coucetype"  id="coucetype'+ctCnt+'" name="weight[sourcetype]"@if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif>
                </div>
            </div>
            <div class="col-md-2"> 
                <div class="btn_alignbox justify-content-end">
                    <a class="opt-btn" onclick="submitIntakeForm('weight')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a>
                    <a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryDatapm('weight')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
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
        maxDate: new Date() , // This will allow only past dates and block future dates
    });

    $('.bptime').datetimepicker({
        format: 'hh:mm A',
        locale: 'en',
        useCurrent: false, // Prevents setting current time by default
        stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
        timeZone: userTimeZone 
    });
    function validateWeightFrom(){
         $("#intakeformweight").validate({
            rules: {
                "weight[weight]": {
                    required: true,
                    number: true,
                    min:1,
                },
                "weight[unit]": {
                    required: true,
                },
            },
            messages: {
                "weight[weight]": {
                    required: 'Please enter the weight.',
                    number: 'Please enter a numeric value',
                    min: 'Please enter a value greater than 0',
                },
                "weight[unit]": {
                    required: 'Please select unit type',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("weightcls")) {
                    error.insertAfter(".weightclserr");
                } else if (element.hasClass("weightunitcls")) {
                    error.insertAfter(".weightunitclserr");
                } else {
                    error.insertAfter(element);
                }
            },
        });
    }


    function submitIntakeForm(formtype) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateWeightFrom();
        if ($("#intakeformweight").valid()) {
            let formdata = $("#intakeformweight").serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype' : formtype,
                    'patientID' : patientID,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        console.log(formtype)
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