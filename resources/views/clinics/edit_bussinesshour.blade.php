
                           
                           <form method="POST" id="timingandchargesform" autocomplete="off">
                                @csrf
                                    <div class="row g-3"> 
                                        <div class="col-12"> 
                                            <div class="border rounded-4 p-4 h-100">
                                                <h5 class="fw-medium mb-3">Standard Appointment Duration</h5>
                                                <p class="primary fw-light mb-0">How long do you typically need for each consultation?</p>
                                                <div class="row g-2">
                                                    <div class="col-12"> 
                                                        <div class="d-flex flex-wrap gap-lg-5 gap-4 mt-1 timedurationerr">
                                                            @if($consultingTimes)
                                                                @foreach($consultingTimes as $time)
                                                                    <div class="form-check time-section">
                                                                        <input class="form-check-input ckecktime timedurationcls" @if(($userDetails['consultation_time_id']) == $time['id'] ) checked @endif type="checkbox" id="time_{{$time['id']}}" name="timeduration" value="{{$time['id']}}" data-mins="{{$time['consultation_time']}}" >
                                                                        <label class="form-check-label" for="slot10">{{$time['consultation_time']}}</label>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 customcls" @if($userDetails['consultation_time_id'] =='7' ) @else style="display:none" @endif> 
                                                        <div class="form-group form-outline">
                                                            <label for="input" class="float-label">Appointment Duration (In Mins)</label>
                                                            <i class="material-symbols-outlined">alarm</i>
                                                            <input type="text" class="form-control" id="custom" name="customduration" value="{{$userDetails['consultation_time']}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12"> 
                                            <div class="border rounded-4 p-4 h-100">
                                                <h5 class="fw-medium mb-3">Business Hours</h5>
                                             
                                         
                                                @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                                                @php
                                                    $dayIndex = strtolower($day);
                                                    $days = $businessHoursDetails[$day]->first() ?? null;
                                                @endphp
                                                
                                                <div class="slots-container"> 
                                                    <div class="row g-3"  id="{{strtolower($days->day)}}-slots">
                                                        <div class="col-xl-3"> 
                                                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                                                <p class="m-0 day-type">{{$days->day}}</p>
                                                                <div class="d-flex gap-2">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input toggle-day {{$days->day}}_@if($days->isopen  == '1')Open@elseClosed@endif" id="togglebtn_{{$days->bussinesshour_uuid}}" data-label="label_{{$days->day}}"  data-target=".business-hours-{{$days->bussinesshour_uuid}}" type="checkbox" name="business_hours[{{$days->day}}][is_open]"  @if($days->isopen == '1') checked @endif value="{{$days->isopen }}">
                                                                    </div>
                                                                    <p class="m-0 primary label_{{$days->day}}">@if($days->isopen  == '1') Open @else Closed @endif</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($days->isopen == '0')
                                                  
                                                        <div class="col-xl-9 business-hours-{{$days->bussinesshour_uuid}}" @if($days->isopen  == '0') style="display:none" @endif id="slots-{{$days->day}}"> 
                                                           <?php $count = 0 ;?>
                                                    
                                                            <div class="row align-items-baseline g-3 slot-row slot-row_{{$days->day}} removeslocls_{{$count}}_{{$days->day}} business-hours-{{$days->bussinesshour_uuid}}">
                                                                <div class="col-sm-6 col-lg-4"> 
                                                                    <div class="form-group form-outline time-slot-container" id="from_$count_slots_{{$days->day}}">
                                                                        <label for="input" class="float-label">From</label>
                                                                        <i class="material-symbols-outlined">alarm</i>
                                                                        <input type="text" class="form-control fromtime"   name="business_hours[{{$days->day}}][slots][{{$count}}][from]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-lg-4"> 
                                                                    <div class="form-group form-outline" id="to_0_slots_{{$days->day}}">
                                                                        <label for="input" class="float-label">To</label>
                                                                        <i class="material-symbols-outlined">alarm</i>
                                                                        <input type="text" class="form-control totime"   name="business_hours[{{$days->day}}][slots][{{$count}}][to]">
                                                                    </div>
                                                                   
                                                                </div>
                                                                <div class="col-12 col-lg-4"> 
                                                                    <div class="row align-items-center g-3">
                                                                        <div class="col-8 col-lg-10"> 
                                                                            <div class="text-start text-xl-end">
                                                                                <p class="fst-italic fw-medium mb-0" id="slot_{{$count}}_{{$days->day}}">0  slots available</p>
                                                                                <input type="hidden" class="form-control timeslotforall" value="" id="business_hours_{{$days->day}}_{{$count}}" name="business_hours[{{$days->day}}][slots][{{$count}}][slot]">
                                                                            </div>
                                                                        </div>
                                                                    
                                                                        <div class="col-4 col-lg-2 remove_{{$days->day}}" id="remove_{{$days->day}}" @if($count == 0) style="display:none" @endif> 
                                                                            <div class="btn_alignbox justify-content-end">
                                                                                <a  onclick="removeSlot('{{$count}}','{{$days->day}}')" class="dlt-btn btn-align remove_{{$days->day}}"><span class="material-symbols-outlined">delete</span></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>      
                                                                </div>
                                                            </div>
                                                            
                                                        </div>


                                                        @else
                                                        <div class="col-xl-9 business-hours-{{$days->bussinesshour_uuid}}" @if($days->isopen  == '0') style="display:none" @endif id="slots-{{$days->day}}"> 
                                                           <?php $count = 0 ;?>
                                                           
                                                        
                                                        @foreach($days->slots as $slot)
                                                            <div class="row align-items-baseline g-3 slot-row slot-row_{{$days->day}} removeslocls_{{$count}}_{{$days->day}} business-hours-{{$days->bussinesshour_uuid}}">
                                                                <div class="col-sm-6 col-lg-4"> 
                                                                    <div class="form-group form-outline time-slot-container" id="from_$count_slots_{{$days->day}}">
                                                                        <label for="input" class="float-label">From</label>
                                                                        <i class="material-symbols-outlined">alarm</i>
                                                                        <input type="text" class="form-control fromtime"   @if($days->isopen  == '1') value="{{ date('h:i A', strtotime($slot->from_time)) }}" @endif name="business_hours[{{$days->day}}][slots][{{$count}}][from]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-lg-4"> 
                                                                    <div class="form-group form-outline" id="to_0_slots_{{$days->day}}">
                                                                        <label for="input" class="float-label">To</label>
                                                                        <i class="material-symbols-outlined">alarm</i>
                                                                        <input type="text" class="form-control totime"  @if($days->isopen  == '1') value="{{ date('h:i A', strtotime($slot->to_time)) }}" @endif name="business_hours[{{$days->day}}][slots][{{$count}}][to]">
                                                                    </div>
                                                                   
                                                                </div>
                                                                <div class="col-12 col-lg-4"> 
                                                                    <div class="row align-items-center g-3">
                                                                        <div class="col-8 col-lg-10"> 
                                                                            <div class="text-start text-xl-end">
                                                                                <p class="fst-italic fw-medium mb-0" id="slot_{{$count}}_{{$days->day}}">{{$slot->slot}}  slots available</p>
                                                                                <input type="hidden" class="form-control timeslotforall" value="{{$slot->slot}}" id="business_hours_{{$days->day}}_{{$count}}" name="business_hours[{{$days->day}}][slots][{{$count}}][slot]">
                                                                            </div>
                                                                        </div>
                                                                    
                                                                        <div class="col-4 col-lg-2 remove_{{$days->day}}" id="remove_{{$days->day}}" @if($count == 0) style="display:none" @endif> 
                                                                            <div class="btn_alignbox justify-content-end">
                                                                                <a  onclick="removeSlot('{{$count}}','{{$days->day}}')" class="dlt-btn btn-align remove_{{$days->day}}"><span class="material-symbols-outlined">delete</span></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>      
                                                                </div>
                                                            </div>
                                                            <?php $count++ ;?>
                                                        @endforeach
                                                        </div>

                                                        @endif


                                                        <div class="col-xl-9 mt-xl-0 business-hours-{{$days->bussinesshour_uuid}}" @if($days->is_open == '0') style="display:none" @endif>
                                                            <div class="btn_alignbox justify-content-end mt-1"> 
                                                                <a onclick="addHours('{{$days->day}}')" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div>
                                                        </div>
                                                        


                                                        
                                                    </div>
                                                </div>
                                                @endforeach
                                             
                                                <input type="hidden" class="form-control "  id="hastimeslots" name="hastimeslots" value="">
                                                <input type="hidden" class="form-control "  id="user_id" name="user_id" value="{{$userDetails['user_id']}}">
                                                <div class="gray-border"></div>
                                                <div class="slots-final"> 
                                                    <div class="row">
                                                        <div class="col-lg-3"> 
                                                        </div>
                                                        <div class="col-lg-9"> 
                                                            <div class="row align-items-baseline mb-2">
                                                                <div class="col-12 col-lg-12"> 
                                                                    <div class="text-end">
                                                                        <p class="gray fw-light mt-2 mb-0">Total Available Slots Per Week</p> 
                                                                        @php
                                                                            $totalSlots = 0;
                                                                            foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day) {
                                                                                $dayData = $businessHoursDetails[$day]->first() ?? null;
                                                                                if($dayData && $dayData->isopen == '1') {
                                                                                    foreach($dayData->slots as $slot) {
                                                                                        $totalSlots += (int) ($slot->slot ?? 0);
                                                                                    }
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <h3 class="mb-0 primary fw-bold" id="totalSlotCount">{{$totalSlots}} Slots</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="border rounded-4 p-4 h-100 mt-4">
                                            <div class="row align-items-end">
                                                <div class="col-lg-8"> 
                                                    <h5 class="fw-medium mb-0">Vacation</h5>
                                                    <p class="primary fw-light mb-0">Add one or more vacation periods. Each can be a specific date or a date range.</p>
                                                </div>
                                                <div class="col-lg-4"> 
                                                    <div class="btn_alignbox justify-content-end">
                                                        <button type="button" class="btn btn-primary align_middle" id="add-vacation-btn">
                                                            <span class="material-symbols-outlined">add</span> Add
                                                        </button> 
                                                    </div>
                                                </div>
                                                <div class="col-12">  
                                                    <div class="gray-border mt-3"></div>
                                                </div>
                                            </div>
                                            <div id="vacation-list">
                                                @if(isset($vacationDetails) && count($vacationDetails) > 0)
                                                    @foreach($vacationDetails as $i => $vacation)
                                                        <div class="row align-items-center g-2 mt-2 vacation-entry edit-mode" data-index="{{ $i }}">
                                                            <div class="col-12">
                                                               
                                                                <div class="d-flex align-items-center gap-3 mt-3 mb-2 radio-box">
                                                                    <label>
                                                                        <input type="radio" name="exist_vacations[{{ $i }}][vacation_type]" value="specific" {{ $vacation->vacation_type == 'specific' ? 'checked' : '' }}> Specific Date
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="exist_vacations[{{ $i }}][vacation_type]" value="range" {{ $vacation->vacation_type == 'range' ? 'checked' : '' }}> Date Range
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-9">
                                                                <div class="row">
                                                                    <div class="col-lg-6 vacation-date-section" @if($vacation->vacation_type != 'specific') style="display:none;" @endif>
                                                                        <div class="form-group form-outline">
                                                                            <label class="float-label">Vacation Date</label>
                                                                            <i class="material-symbols-outlined">event_busy</i>
                                                                            <input type="text" class="form-control vacation_date" name="exist_vacations[{{ $i }}][vacation_date]" value="{{ $vacation->vacation_type == 'specific' ? \Carbon\Carbon::parse($vacation->vacation_from)->format('m/d/Y') : '' }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 vacation-range-section" @if($vacation->vacation_type != 'range') style="display:none;" @endif>
                                                                        <div class="form-group form-outline">
                                                                            <label class="float-label">Vacation From</label>
                                                                            <i class="material-symbols-outlined">event_busy</i>
                                                                            <input type="text" class="form-control vacation_from" name="exist_vacations[{{ $i }}][vacation_from]" value="{{ $vacation->vacation_type == 'range' ? \Carbon\Carbon::parse($vacation->vacation_from)->format('m/d/Y') : '' }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 vacation-range-section" @if($vacation->vacation_type != 'range') style="display:none;" @endif>
                                                                        <div class="form-group form-outline">
                                                                            <label class="float-label">Vacation To</label>
                                                                            <i class="material-symbols-outlined">event_busy</i>
                                                                            <input type="text" class="form-control vacation_to" name="exist_vacations[{{ $i }}][vacation_to]" value="{{ $vacation->vacation_type == 'range'  ? \Carbon\Carbon::parse($vacation->vacation_to)->format('m/d/Y') : '' }}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" class="form-control " name="exist_vacations[{{ $i }}][vacation_id]" value="{{ $vacation->id }}" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="btn_alignbox justify-content-end">
                                                                    <button type="button" class="dlt-btn btn-align  remove-vacation-btn" title="Remove"><span class="material-symbols-outlined">delete</span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="validvacation" value="1" name="validvacation">
                                    
                                    
                                    <input type="hidden" id="iscard" value="0" name="iscard">
                                </form>
                                <div class="btn_alignbox justify-content-end mt-1 mt-3">
                                    @if(isset($pageType) && $pageType =='myprofile')
                                        <button type="button" onclick="tabContent('workinghours_details','{{$userDetails['clinic_user_uuid']}}')" class="btn btn-outline-primary " >Cancel</button>
                                    @endif
                                    <button type="button" id="savebtn" class="btn btn-primary" onclick="updatetiming('payment-processing')">Save & Continue</button>
                                 
                                    
                                </div>


<script>
    function validateVacations() {
    let vacationValid = true;
    $('.vacation-entry').each(function() {
        let $entry = $(this);
        let type = $entry.find('input[type="radio"][name*="[vacation_type]"]:checked').val();

        // Remove previous error messages
        $entry.find('.vacation-error').remove();

        if (type === 'specific') {
            let date = $entry.find('.vacation_date').val();
            if (!date) {
                $entry.find('.vacation_date').after('<label class="vacation-error text-danger mt-1"><small>Please select a date.</label>');
                vacationValid = false;
            }
        } else if (type === 'range') {
            let from = $entry.find('.vacation_from').val();
            let to = $entry.find('.vacation_to').val();
            if (!from) {
                $entry.find('.vacation_from').after('<label class="vacation-error text-danger mt-1">Please select a start date.</label>');
                vacationValid = false;
            }
            if (!to) {
                $entry.find('.vacation_to').after('<label class="vacation-error text-danger mt-1">Please select an end date.</label>');
                vacationValid = false;
            }
            // Only check order if both dates are present
            if (from && to) {
                // Convert to Date objects for comparison
                let fromDate = moment(from, 'MM/DD/YYYY');
                let toDate = moment(to, 'MM/DD/YYYY');
                if (toDate.isBefore(fromDate)) {
                    $entry.find('.vacation_to').after('<label class="vacation-error text-danger mt-1">End date must be greater than start date.</small></label>');
                    vacationValid = false;
                }
            }
        }
    });

    if (!vacationValid) {
        // Scroll to the first error
        $('html, body').animate({
            scrollTop: $('.vacation-error:visible').first().offset().top - 100
        }, 500);
    }

    return vacationValid;
}

        /*  final submit function with validation check */
        function updatetiming(type) {
            
           if ($('.toggle-day:checked').length === 0) {
                swal('Warning','Please select at least one business day.','warning');
                // alert('Please select at least one business day to set working hours.');
                return;
            }
              // Check if open days have time slots
              let hasEmptySlots = false;
              $(".slotopencls").remove();
              $("#hastimeslots").val('1');
              $.validator.addMethod("timeOrder", function (value, element) {
                let $row = $(element).closest(".slot-row");
                let fromTime = $row.find(".fromtime").val();
                let toTime = $row.find(".totime").val();

                if (fromTime && toTime) {
                    let from = convertTo24Hour(fromTime);
                    let to = convertTo24Hour(toTime);

                    return from < to; // Compare in 24-hour format
                }

                return true; // Let 'required' handle empty cases
            }, "From time must be less than To time.");

            // Apply rules to each time input
            $(".fromtime").each(function () {
                $(this).rules("add", {
                   required: {
                        depends: function(element) {
                            return $(element).is(":visible");
                        }
                    },
                    messages: {
                        required: "Please select from time."
                    }
                });
            });

            $(".totime").each(function () {
                $(this).rules("add", {
                    required: {
                        depends: function(element) {
                            return $(element).is(":visible");
                        }
                    },
                    timeOrder: true, // Apply the custom rule here
                    messages: {
                        required: "Please select to time.",
                        timeOrder: "To time must be after From time."
                    }
                });
            });
            let vacationIsValid = validateVacations();
            //  // Vacation validation
           
              
                if ($("#timingandchargesform").valid()) {
                      if (!vacationIsValid) {
                            return;
                      }
                    if($("#iscard").val() !='1' && (
                        ($("#inperson_fee").is(':visible') && ($("#inperson_fee").val()=='0' || $("#inperson_fee").val()=='')) || 
                        ($("#virtual_fee").is(':visible') && ($("#virtual_fee").val()=='0' || $("#virtual_fee").val()==''))
                    )){
              
                        $("#addCreditCard").modal('show');
                        stripeElaments();
                            
                    }else{
                        $('.slots-container').each(function() {
                            let day = $(this).find('.day-type').text().trim();
                            validateSlots(day)
                        });
                       
                        if($("#hastimeslots").val() == '1'){
                            if($("#validvacation").val() != '1'){
                                return ;
                            }
                            /** validate the timing for clinicina */
                            let formdata =$("#timingandchargesform").serialize();
                            $.ajax({
                                type: "POST",
                                url: '{{ url("/validateworkinghours/") }}' ,
                                data: {
                                    'formdata': formdata,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if(response.success == 1){
                                        $('.time-slot-error').remove();
                                        finalSubmitFunction(type);
                                    }else{
                                        // Clear any existing error messages
                                        $('.time-slot-error').remove();
                                        
                                        // Display errors for each day
                                        $.each(response.errors, function(day, errors) {
                                            const daySlotsContainer = $(`#${day.toLowerCase()}-slots`);
                                            if (daySlotsContainer.length) {
                                                $.each(errors, function(index, error) {
                                                    const timeSlotContainer = daySlotsContainer.find('.time-slot-container').eq(error.slot_index);
                                                    if (timeSlotContainer.length) {
                                                        timeSlotContainer.after(`
                                                          
                                                                <div class="time-slot-error text-danger mt-1">
                                                                    <small>This time slot ${error.time} overlaps with ${error.clinic}</small>
                                                                </div>
                                                            
                                                        `);
                                                    }
                                                });
                                            }
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    handleError(xhr);
                                },
                            })



                        }else{
                            $("#savebtn").removeClass('disabled');
                            // alert('Time slots are overlapped')
                        }
                    }

                } else {
                    $("#savebtn").removeClass('disabled');
                    if ($('.error:visible').length > 0) {
                        setTimeout(function() {
                            
                        }, 500);
                    }
                }
            
          

        }
        function finalSubmitFunction(type){
            
            $("#savebtn").addClass('disabled');
            let formdata =$("#timingandchargesform").serialize();
            $.ajax({
                type: "POST",
                url: '{{ url("/onboarding/") }}/' + type,
                data: {
                    'formdata': formdata,
                    "currentStepId": 1,
                    "actiontype" : "update",
                    "nextstep": type,
                    "islater" : '' ,
                        "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if(response.success == 1){
                        swal('Success','Working hours updated successfully','success')
                        var key ="{{$key}}" ;
                        
                        tabContent('workinghours_details',key);
                    
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            })

        }
    </script>
    
    <script>
$(document).ready(function() {
   
    // Remove vacation entry on button click
    $('#vacation-list').on('click', '.remove-vacation-btn', function() {
        $(this).closest('.vacation-entry').remove();
    });
});
   

$(document).ready(function () {
    // Loop through all existing vacation entries
    $('.vacation-entry').each(function () {
    var $entry = $(this);
    var isEdit = $entry.hasClass('edit-mode'); // <-- check if it's edit mode

    var options = {
        format: 'MM/DD/YYYY',
        useCurrent: false,
    };

    if (!isEdit) {
        options.minDate = moment(); // only restrict future dates for new entries
    }

    // Apply datepickers
    $entry.find('.vacation_date').datetimepicker(options);
    $entry.find('.vacation_from').datetimepicker(options);
    $entry.find('.vacation_to').datetimepicker(options);

    // Ensure vacation_to >= vacation_from
    $entry.find('.vacation_from').on("change.datetimepicker", function (e) {
        $entry.find('.vacation_to').datetimepicker('minDate', e.date);
    });
});

});

$(document).on('change', '.vacation-entry input[type="radio"][name^="exist_vacations"]', function () {
    var $entry = $(this).closest('.vacation-entry');

    if ($(this).val() === 'specific') {
        $entry.find('.vacation-date-section').show();
        $entry.find('.vacation-range-section').hide();
        $entry.find('.vacation_from, .vacation_to').val(''); // clear range fields
    } else {
        $entry.find('.vacation-date-section').hide();
        $entry.find('.vacation-range-section').show();
        $entry.find('.vacation_date').val(''); // clear specific date field
    }
});
  
   
</script>
