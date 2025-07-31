                            <form method="POST" id="timingandchargesform" autocomplete="off">
                                @csrf
                                    <div class="row g-3"> 
                                        <div class="col-12"> 
                                            <div class="border rounded-4 p-4 h-100">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                                    <h5 class="fw-medium mb-0">Standard Appointment Duration</h5>  
                                                    <div class="btn_alignbox justify-content-end"> 
                                                        <a class="btn opt-btn align_middle" onclick="editDuration()">
                                                                <span class="material-symbols-outlined">edit</span>
                                                        </a>
                                                    </div>
                                                </div>
                                             
                                                <p class="primary fw-light mb-0">How long do you typically need for each consultation?</p>
                                                    

                                                <div id="viewdeuation">
                                                   
                                                    <p class="mb-0 primary fw-bold"> @if($userDetails['consultation_time_id'] =='7' ) {{$userDetails['consultation_time']}} mins @else {{$consultaionTime[$userDetails['consultation_time_id']]['consultation_time'] ?? ' --'}}@endif </p>
                                                    <input class="form-check-input ckecktime timedurationcls" type="hidden" name="timeduration" value="{{$userDetails['consultation_time_id']}}">
                                                   
                                               </div>

                                                <div class="row g-2" style="display:none;" id="editdeuation">
                                                    <div class="col-12"> 
                                                        <div class="d-flex flex-wrap gap-lg-5 gap-4 mt-1 timedurationerr">
                                                            @if($consultaionTime)
                                                                @foreach($consultaionTime as $time)
                                                                    <div class="form-check time-section">
                                                                        <input class="form-check-input ckecktime timedurationcls" @if(($userDetails['consultation_time_id']) == $time['id'] ) checked @endif type="checkbox" id="time_{{$time['id']}}" name="timeduration" value="{{$time['id']}}" >
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
                                                @if ($businessHoursDetails->isEmpty()) 
                                                    <p>No records found</p>
                                                @else
                                                @if( !empty($businessHoursDetails))
                                              
                                                @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                                                @php
                                                    $dayIndex = strtolower($day);
                                                    $days = $businessHoursDetails[$day]->first() ?? null;
                                                @endphp
                                                
                                                <div class="slots-container"> 
                                                    <div class="row g-3" id="{{strtolower($days->day)}}-slots">
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


                                                        <div class="col-xl-9 mt-xl-0 business-hours-{{$days->bussinesshour_uuid}}" @if($days->is_open == '0') style="display:none" @endif>
                                                            <div class="btn_alignbox justify-content-end mt-1"> 
                                                                <a onclick="addHours('{{$days->day}}')" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div>
                                                        </div>
                                                        


                                                        
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
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
                                                                                if (!empty($businessHoursDetails)) {
                                                                                    foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day) {
                                                                                        $dayData = $businessHoursDetails[$day]->first() ?? null;
                                                                                        if($dayData && $dayData->isopen == '1') {
                                                                                            foreach($dayData->slots as $slot) {
                                                                                                $totalSlots += (int) ($slot->slot ?? 0);
                                                                                            }
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
                                             @endif
                                        </div>
                                    </div>
                                    <input type="hidden" id="iscard" value="0" name="iscard">
                                </form>
                                <div class="btn_alignbox justify-content-end mt-1 mt-3">
                                    <button type="button" id="savebtn" class="btn btn-primary" onclick="updatetiming('payment-processing')">Save & Continue</button>
                                </div>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script>

function editDuration(){
    $("#viewdeuation").hide();
    $("#editdeuation").show();
}

    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== '';
        const isFocused = $input.is(':focus');

        // Correct selector for all cases (only applies to visible inputs)
        $input.closest('.form-group').find('.float-label').toggleClass('active', hasValue || isFocused);
    }

    /* function for time slot calculations start */
    function getDurationInMinutes(from, to) {
        const [fromHours, fromMinutes, fromPeriod] = from.match(/(\d+):(\d+)\s*(AM|PM)/i).slice(1);
        const [toHours, toMinutes, toPeriod] = to.match(/(\d+):(\d+)\s*(AM|PM)/i).slice(1);

        let fromTime = parseInt(fromHours) % 12 + (fromPeriod.toUpperCase() === 'PM' ? 12 : 0);
        let toTime = parseInt(toHours) % 12 + (toPeriod.toUpperCase() === 'PM' ? 12 : 0);

        let fromTotal = fromTime * 60 + parseInt(fromMinutes);
        let toTotal = toTime * 60 + parseInt(toMinutes);

        return toTotal - fromTotal;
    }

    function getSelectedDuration() {
        let selected = $('input[name="timeduration"]:checked').val();
        if (selected === '7') {
            return parseInt($('#custom').val()) || 0;
        }
        let text = $(`#time_${selected}`).siblings('label').text();
        return parseInt(text.match(/\d+/)) || 0;
    }

    function updateSlotCount($row, day) {
        let from = $row.find('.fromtime').val();
        let to = $row.find('.totime').val();
        if (!from || !to) return;

        let duration = getSelectedDuration();
        
        if (!duration || duration <= 0) return;

        let diff = getDurationInMinutes(from, to);
        if (diff <= 0) return;

        let slots = Math.floor(diff / duration);
        if (slots === 0) {
         
        } else {
            // Update the <small> tag and hidden input
            let slotIndex = $row.index(); 
            $(`#slot_${slotIndex}_${day}`).text(`${slots} slot${slots !== 1 ? 's' : ''} available`);

            $row.find('.timeslotforall').val(slots);
        }
        $row.find('input[type="hidden"]').val(slots);
        updateTotalSlotCount();
    }
    function updateTotalSlotCount() {
        let total = 0;

        $('.timeslotforall').each(function () {
            let val = parseInt($(this).val(), 10);
            if (!isNaN(val)) {
                total += val;
            }
        });
        $('#totalSlotCount').text(`${total} Slots`);
    }
    // Trigger on time or duration change
    $(document).on('change', '.fromtime, .totime, .timedurationcls', function () {
        
        $('.slot-row').each(function () {
            let $row = $(this);
            // Extract day from parent element ID
            let dayMatch = $row.closest('[id^="slots-"]').attr('id').match(/slots-(\w+)/);
            if (dayMatch) {
                let day = dayMatch[1];
                updateSlotCount($row, day);
            }
        });
    });
    $(document).on('change', '.timedurationcls', function () {
       
        $('.slot-row').each(function () {
                let $row = $(this);
            let day = $row.closest('.slots-container').find('.day-type').text().trim();
            setTimeout(function () {
                updateSlotCount($row, day);
            }, 1000);
        });
    });
    $(document).on('change', '.timedurationcls, #custom', function () {
       
        $('.slot-row').each(function () {
            let $row = $(this);
            let day = $row.closest('.slots-container').find('.day-type').text().trim();
            updateSlotCount($row, day);
        });
    });
     
    $(document).ready(function () {

        // On page load, show/hide based on initial checkbox state
        $('.toggle-day').each(function () {
            var target = $(this).data('target');
            if ($(this).is(':checked')) {
                $(target).show();
            } else {
                $(target).hide();
            }
        });

        // On checkbox change
        $('.toggle-day').on('change', function () {
            var target = $(this).data('target');
            var labelClass = $(this).data('label');

            if ($(this).is(':checked')) {
                
                $(target).slideDown(); // optional animation
                $('.' + labelClass).text('Open');
                $(this).val('1'); // Set value to 1
                
            } else {
                $(target).slideUp(); // optional animation
                $('.' + labelClass).text('Closed'); // Set label to "Closed"f
                $(this).val('0'); // Set value to 1
            }
        });
        $("#timingandchargesform").validate({
            ignore: [],
            rules: {
                timeduration : 'required',
            

                customduration: {
                    required: {
                        depends: function(element) { 
                            return $('input[name="timeduration"]:checked').val() == '7';
                        }
                    },
                    digits: true,
                    
                },

            },

            messages: {
                timeduration : "Please select any time duration.",
                appointment_type: "Please select type.",
                inperson_fee: {
                    required: "Please enter appointment fees.",
                    amountCheck: "Please enter a valid number.",
                },
                virtual_fee: {
                    required: "Please enter appointment fees.",
                    amountCheck: "Please enter a valid number.",
                },
                customduration: {
                    required: "Please enter duration.",
                    digits: "Please enter a valid duration.",
                },
            },
            errorPlacement: function (error, element) {
                if(element.hasClass("timedurationcls")){
                    error.insertAfter(".timedurationerr");
                }else if(element.hasClass("appointment_typecls")){
                    error.insertAfter(".appointmenttypeerr");
                }else{
                    error.insertAfter(element);
                }

            },
        });
            // Custom method to check for amount check
        $.validator.addMethod(
            "amountCheck", // Custom method name
            function(value, element) {
                // Regular expression for amount validation
                var regex = /^(?!0\d)(\d{1,3}(,\d{3})*|\d+)(\.\d{1,10})?$/;

                // Check if the value is optional or matches the regex
                return this.optional(element) || regex.test(value);
            },
            "Please enter a valid amount."
        );

    });

    /* function for time selecton overlap validation */
    function isTimeOverlap(start1, end1, start2, end2) {
        return (start1 < end2) && (start2 < end1);
    }

    function convertTo24Hour(timeStr) {
        return moment(timeStr, ["h:mm A"]).format("HH:mm");
    }


    function validateSlots(day) {
        var isValid = true;
        var times = [];
        $(".slotopencls").remove();
    
        $('#slots-' + day + ' .slot-row').each(function () {
            var $row = $(this);
            var from = $row.find('.fromtime').val();
            var to = $row.find('.totime').val();
            $row.find('.error-message').remove(); // Remove old messages
            var fromGroup = $row.find('.fromtime').closest('.form-group');
            var toGroup = $row.find('.totime').closest('.form-group');
            // Clear previous messages inside each form group
            fromGroup.find('.error-message').remove();
            toGroup.find('.error-message').remove();

            if (!from || !to) return true; // Skip empty fields

            var start = convertTo24Hour(from);
            var end = convertTo24Hour(to);
            var fromGroup = $row.find('.fromtime').closest('.form-group');
            // Invalid time range
            if (start >= end) {
                $("#hastimeslots").val('0');
                // alert(fromGroup)
                $('<label class="error fromlabelerror error-message">Start time must be earlier than end time.</label>').insertAfter(fromGroup)
                // $('<lavel class="class="error"">Start time must be earlier than end time.</label>').insertAfter($row);
                isValid = false;
                return isValid; // Continue checking other rows
            }else{
                $('.fromlabelerror').hide();
                $("#hastimeslots").val('1');
            }

            // Overlap check
            for (var i = 0; i < times.length; i++) {
                if (isTimeOverlap(start, end, times[i].start, times[i].end)) {
                    $('<label class="error fromlabelerror error-message">Time slot overlaps with another slot.</label>').insertAfter(fromGroup)
                    // $('<div class="error-message text-danger small">Time slot overlaps with another slot.</div>').insertAfter($row);
                    isValid = false;
                    $("#hastimeslots").val('0');
                    return isValid; 
                    // return true;
                }else{
                    $("#hastimeslots").val('1');
                }
            }

            let duration = getSelectedDuration();
        
            if (!duration || duration <= 0) return;

            let diff = getDurationInMinutes(from, to);
            if (diff <= 0) return;

            let slots = Math.floor(diff / duration);
            if (slots === 0) {
                var fromGroup = $row.find('.fromtime').closest('.form-group');
                // Invalid time range
                
                $("#hastimeslots").val('0');
                // alert(fromGroup)
                $('<label class="error  error-message slot-message">Time range too short for selected duration</label>').insertAfter(fromGroup)
                // $row.find(`#slot_${$row.index()}_${day}`).html('<span class="text-danger slot-message">Time range too short for selected duration.</span>');
                $row.find('.timeslotforall').val(0); // Set hidden input to 0
                let slotIndex = $row.index(); 
                $(`#slot_${slotIndex}_${day}`).text(`${slots} slot${slots !== 1 ? 's' : ''} available`);
                $row.find('input[type="hidden"]').val(slots);
            } else{
                $row.find('.slot-message').remove(); 
            }
            
            times.push({ start, end });
        });
        // $("#hastimeslots").val('1');
        return isValid;
    }
    function removeSlot(index, day) {
        $(`.removeslocls_${index}_${day}`).remove();

        var removeSlot = $('.slot-row_'+day).length;
        if(removeSlot == 1){
            $(".remove_"+day).hide();
        }

        // Update total slots after removal
        updateTotalSlotCount();
    }

    function addHours(day) {
        var container = $('#slots-' + day);
        var lastIndex = $('.slot-row_'+day).length;
        var newIndex = lastIndex 
            
    
        var slotHtml = `
            <div class="row align-items-baseline g-3 slot-row slot-row_${day} removeslocls_${newIndex}_${day}" data-index="${newIndex}">
                <div class="col-sm-6 col-lg-4">
                    <div class="form-group form-outline time-slot-container" id="from_${newIndex}_slots_${day}">
                        <label for="input" class="float-label">From</label>
                        <i class="material-symbols-outlined">alarm</i>
                        <input type="text" class="form-control fromtime" name="business_hours[${day}][slots][${newIndex}][from]">
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4"> 
                    <div class="form-group form-outline"  id="to_${newIndex}_slots_${day}">
                        <label for="input" class="float-label">To</label>
                        <i class="material-symbols-outlined">alarm</i>
                        <input type="text" class="form-control totime" name="business_hours[${day}][slots][${newIndex}][to]">
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="row align-items-center g-3">
                        <div class="col-8 col-lg-10"> 
                            <div class="text-start text-xl-end">
                                <p class="fst-italic fw-medium mb-0" id="slot_${newIndex}_${day}"></p>
                                <input type="hidden" class="form-control timeslotforall"  name="business_hours[${day}][slots][${newIndex}][slot]">                                
                            </div>
                        </div>
                        <div class="col-4 col-lg-2 remove_${day}"> 
                            <div class="btn_alignbox justify-content-end">
                                <a href="javascript:void(0)" onclick="removeSlot('${newIndex}','${day}')" class="dlt-btn btn-align remove_${day}"><span class="material-symbols-outlined">delete</span></a>                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.append(slotHtml);
        // Initialize datetimepicker for new inputs
        container.find('.fromtime').last().datetimepicker({
            format: 'hh:mm A',
            useCurrent: false,
            stepping: 5
        }).on('dp.show', function(e) {
            const picker = $(this).data('DateTimePicker');
            if (!$(this).val()) {
                picker.date(getRoundedHour());
            }
        });
        $('.totime').datetimepicker({
            format: 'hh:mm A',
            useCurrent: false,
            stepping: 5
        }).on('dp.show', function(e) {
            // const picker = $(this).data('DateTimePicker');
            // if (!$(this).val()) {
            //     picker.date(getRoundedHour());
            // }
            const picker = $(this).data('DateTimePicker');
            if (!$(this).val()) {
                // Get the from time from the same row
                const $row = $(this).closest('.slot-row');
                const fromTimeVal = $row.find('.fromtime').val();

                if (fromTimeVal) {
                    let selectedDurationType = $('input[name="timeduration"]:checked').val();
                    let customDurationValue = parseInt($('#custom').val());

                    let defaultToTime;
                    // If custom duration is selected and a value is entered, propose 2 hours later
                    if (selectedDurationType === '7' && customDurationValue > 0) {
                        
                        let hoursToAdd = Math.ceil(customDurationValue / 60);
                        defaultToTime = moment(fromTimeVal, 'hh:mm A').add(hoursToAdd, 'hours');
                        picker.date(defaultToTime);
                    } else {
                        defaultToTime = moment(fromTimeVal, 'hh:mm A').add(1, 'hours');
                        picker.date(defaultToTime);
                    }
                } else {
                    picker.date(getRoundedHour());
                }
            }

        });

        var removeSlot = $('.slot-row_'+day).length;
        if(removeSlot > 1){
            $(".remove_"+day).show();
        }
        
    }

    $(document).on('change.datetimepicker dp.change', '.fromtime, .totime', function () {
        console.log("Time changed");
        var day = $(this).closest('.slots-container').find('.day-type').text().trim();
        validateSlots(day);

        // Now add the slot update logic
        var $row = $(this).closest('.slot-row');
        updateSlotCount($row, day);
    });
    // Function to round current time to nearest lower hour
    function getRoundedHour() {
        return moment().startOf('hour'); // e.g., 11:00
    }

    $(document).ready(function() {
        $('input:visible, textarea:visible').each(function () {
            toggleLabel(this);
        });
    // Initialize time picker for start and end time inputs
        $('.fromtime').datetimepicker({
            format: 'hh:mm A',
            useCurrent: false,
            stepping: 5
        }).on('dp.show', function(e) {
            const picker = $(this).data('DateTimePicker');
            if (!$(this).val()) { // Only apply if input is empty
                picker.date(getRoundedHour());
            }
        });

        $('.totime').datetimepicker({
            format: 'hh:mm A',
            useCurrent: false,
            stepping: 5
        }).on('dp.show', function(e) {
            // const picker = $(this).data('DateTimePicker');
            // if (!$(this).val()) {
            //     picker.date(getRoundedHour());
            // }
            const picker = $(this).data('DateTimePicker');
            if (!$(this).val()) {
                // Get the from time from the same row
                const $row = $(this).closest('.slot-row');
                const fromTimeVal = $row.find('.fromtime').val();

                if (fromTimeVal) {
                    let selectedDurationType = $('input[name="timeduration"]:checked').val();
                    let customDurationValue = parseInt($('#custom').val());

                    let defaultToTime;
                    // If custom duration is selected and a value is entered, propose 2 hours later
                    if (selectedDurationType === '7' && customDurationValue > 0) {
                        
                        let hoursToAdd = Math.ceil(customDurationValue / 60);
                        defaultToTime = moment(fromTimeVal, 'hh:mm A').add(hoursToAdd, 'hours');
                        picker.date(defaultToTime);
                    } else {
                        defaultToTime = moment(fromTimeVal, 'hh:mm A').add(1, 'hours');
                        picker.date(defaultToTime);
                    }
                } else {
                    picker.date(getRoundedHour());
                }
            }
        });
    });


        $(document).on('change', '.ckecktime[type="checkbox"]', function() {
            // Uncheck all other checkboxes
            $('.ckecktime[type="checkbox"]').not(this).prop('checked', false);
        });
        $(document).on('change', '.ckecktime[type="checkbox"]', function () {
        
        // Check if the checked value is 7
        if ($(this).is(':checked') && $(this).val() == '7') {
                $('.customcls').show(); // Show the extra input
            } else {
                $('.customcls').hide(); // Hide the extra input
            }
        });


        /// copy



        /*  final submit function with validation check */
        function updatetiming(type) {
            // Check if at least one day is open
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
              
                 
                if($('input[name="timeduration"]:checked').val() == '7'){
                    $('.customcls').after('<label class="error slotopencls">Please enter duration.</label>');
                }
            $("#hastimeslots").val('1');
                $('.slots-container').each(function() {
                    let day = $(this).find('.day-type').text().trim();
                    const result = validateSlots(day);
                    console.log(result);
                    if (!result) {
                        return false;
                    }
                });
                
                if ($("#timingandchargesform").valid()) {
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
                           if($('#timingandchargesform').valid()){
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

                           }

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
                        getTabDetails('workinghours')
                    
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            })

        }
    </script>
