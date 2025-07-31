    
 @extends('onboarding.onboarding')
@section('title', 'Business Details')
@section('content')    
<section class="mx-lg-5 px-lg-5">
    <div class="container-fluid">
        <div class="wrapper res-wrapper onboard-wrapper">
                @include('onboarding.doctortabs')
            <div class="web-card mb-5"> 
                <div id="step-content">
                    <div class="step-section" data-step="2">   
                
                        <div class="onboard-box"> 
                            <h4 class="fw-bold mb-2">Working Hours</h4>
                            @php
                                $appointmentTypeTexts = [
                                    '1' => 'virtual',
                                    '2' => 'in-person',
                                ];
                            @endphp

                            <p class="fw-light">
                                As a clinic user, set your working hours and define fees for
                                {{ $appointmentTypeTexts[$clinicDetails['appointment_type_id']] ?? 'both in-person and virtual' }} appointments.
                            </p>
                            <p class="fw-light">Note : Even if these are configured now, these settings can be changed from your profile at a later stage.</p>

                            <form method="POST" id="timingandchargesform" autocomplete="off">
                            @csrf
                                <div class="row g-4"> 
                                    <div class="col-12"> 
                                        <h5 class="fw-medium mb-3">Standard Appointment Duration</h5>
                                        <p class="primary fw-light mb-0">How long do you typically need for each consultation?</p>
                                        <div class="row g-2">
                                            <div class="col-12"> 
                                                <div class="d-flex flex-wrap gap-lg-5 gap-4 mt-1 timedurationerr">
                                                    @if($consultingTimes)
                                                        @foreach($consultingTimes as $time)
                                                            <div class="form-check time-section">
                                                                <input class="form-check-input ckecktime timedurationcls" type="checkbox" data-mins="{{$time['consultation_time']}}" id="time_{{$time['id']}}" name="timeduration" value="{{$time['id']}}">
                                                                <label class="form-check-label" for="slot10">{{$time['consultation_time']}}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                  
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 customcls" style="display:none"> 
                                                <div class="form-group form-outline">
                                                    <label for="input" class="float-label">Appointment Duration (In Mins)</label>
                                                    <i class="material-symbols-outlined">alarm</i>
                                                    <input type="text" class="form-control" id="custom" name="customduration">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12"> 
                                        <h5 class="fw-medium mb-3">Business Hours</h5>

                                      
                                        @if( !empty($businessHours))
                                        @foreach($businessHours as $key => $days)
                                        <div class="slots-container"> 
                                            <div class="row g-3">
                                                <div class="col-xl-3"> 
                                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                                        <p class="m-0 day-type">{{$days['day']}}</p>
                                                        <div class="d-flex gap-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input toggle-day {{$days['day']}}_{{$days['label']}}" data-label="label_{{$days['day']}}"  data-target=".business-hours-{{$key}}" type="checkbox" name="business_hours[{{$days['day']}}][is_open]"  @if($days['is_open'] == '1') checked @endif value="{{$days['is_open']}}">
                                                            </div>
                                                            <p class="m-0 primary label_{{$days['day']}}">{{$days['label']}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 business-hours-{{$key}}" @if($days['is_open'] == '0') style="display:none" @endif id="slots-{{$days['day']}}"> 
                                                    <div class="row align-items-baseline g-3 slot-row slot-row_{{$days['day']}} removeslocls_0_{{$days['day']}}">
                                                        <div class="col-sm-6 col-lg-4"> 
                                                            <div class="form-group form-outline" id="from_0_slots_{{$days['day']}}">
                                                                <label for="input" class="float-label">From</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="text" class="form-control fromtime"  name="business_hours[{{$days['day']}}][slots][0][from]">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-lg-4"> 
                                                            <div class="form-group form-outline" id="to_0_slots_{{$days['day']}}">
                                                                <label for="input" class="float-label">To</label>
                                                                <i class="material-symbols-outlined">alarm</i>
                                                                <input type="text" class="form-control totime"  name="business_hours[{{$days['day']}}][slots][0][to]">
                                                            </div>
                                                            <!-- <div class="btn_alignbox justify-content-end mt-1 " style="display:none"> 
                                                                <a onclick="addHours('{{$days['day']}}')" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                            </div> -->
                                                        </div>
                                                        <div class="col-12 col-lg-4"> 
                                                            <div class="row align-items-center g-3">
                                                                <div class="col-8 col-lg-10"> 
                                                                    <div class="text-start text-xl-end">
                                                                        <p class="fst-italic fw-medium mb-0" id="slot_0_{{$days['day']}}"></p>
                                                                        <input type="hidden" class="form-control timeslotforall" id="business_hours_{{$days['day']}}_0" name="business_hours[{{$days['day']}}][slots][0][slot]">
                                                                        <!-- <a style="display:none" onclick="removeSlot('0','{{$days['day']}}')" id="remove_{{$days['day']}}" class="dlt-btn btn-align remove_{{$days['day']}}"><span class="material-symbols-outlined">delete</span></a> -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 col-lg-2 remove_{{$days['day']}}" id="remove_{{$days['day']}}" style="display:none"> 
                                                                    <div class="btn_alignbox justify-content-end">
                                                                        <a  onclick="removeSlot('0','{{$days['day']}}')" class="dlt-btn btn-align remove_{{$days['day']}}"><span class="material-symbols-outlined">delete</span></a>
                                                                    </div>
                                                                </div>
                                                            </div>      
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 mt-xl-0 business-hours-{{$key}}" @if($days['is_open'] == '0') style="display:none" @endif>
                                                    <div class="btn_alignbox justify-content-end mt-1"> 
                                                        <a onclick="addHours('{{$days['day']}}')" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add hours</p></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                        @endif
                                        <input type="hidden" class="form-control"  id="hastimeslots" name="hastimeslots" value="">
                                     
                                        <div class="gray-border"></div>
                                        <div class="slots-final"> 
                                            <div class="row">
                                                <div class="col-lg-3"> 
                                                </div>
                                                <div class="col-lg-9"> 
                                                    <div class="row align-items-baseline mb-2">
                                                        {{-- <div class="col-12 col-lg-5"> 
                                                        </div> --}}
                                                        <div class="col-12 col-lg-8"> 
                                                            <div class="text-end">
                                                                <p class="gray fw-light mt-2 mb-0">Total Available Slots Per Week</p> 
                                                                <h3 class="mb-0 primary fw-bold" id="totalSlotCount">0 Slots</h3>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12"> 
                                       
                                    </div>
                                </div>
                                <input type="hidden" id="iscard" value="0" name="iscard">
                             </form>
                            <div class="btn_alignbox justify-content-end mt-1 mt-3">
                                <button type="button" id="savebtn" class="btn btn-primary" onclick="submitTiming('payment-processing')">Save & Continue</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function stripeElaments(){
     var stripe = Stripe('{{ env("STRIPE_KEY") }}');
    // Create an instance of Elements.
    var elements = stripe.elements();
    var style = {
        hidePostalCode: true,
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var elements = stripe.elements();
    var cardElement = elements.create('card', {hidePostalCode: true,style: style});
    cardElement.mount('#add-card-element');
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('add-card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    var cardholderName = document.getElementById('name_on_card');
    var clientSecret = '<?php echo $clientSecret;?>'
    var form = document.getElementById("addcardsform");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        stripe.confirmCardSetup(
            clientSecret,
            {
                payment_method: {
                    card: cardElement
                },
            }
        ).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('add-card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // The payment succeeded!
                console.log(result);
                stripeTokenHandler(result.setupIntent.payment_method,result.setupIntent.id);
            }
        });
    });
}
    // Submit the form with the token ID.
    function stripeTokenHandler(token,setupIntentID) {
        var form = document.getElementById('addcardsform');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token);
        form.appendChild(hiddenInput);
        var hiddenInput1 = document.createElement('input');
        hiddenInput1.setAttribute('type', 'hidden');
        hiddenInput1.setAttribute('name', 'setupintentid');
        hiddenInput1.setAttribute('id', 'setupintentid');
        hiddenInput1.setAttribute('value', setupIntentID);
        form.appendChild(hiddenInput1);

        if($("#addcardsform").valid()){
            submitCard();
        }
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
            
            

            if (!from || !to) {
                $row.find('.timeslotforall').val(0); // Ensure hidden input is 0 if times are not set
                updateTotalSlotCount();
                return;
            }
            let duration = getSelectedDuration();
            if (!duration || duration <= 0) return;
            // let duration = getSelectedDuration();
            // if (!duration || duration <= 0) {
            //     $row.find('.timeslotforall').val(0);
            //     $row.find(`#slot_${$row.index()}_${day}`).html('<span class="text-danger slot-message">Please select a valid consultation duration.</span>');
            //     updateTotalSlotCount();
            //     return;
            // }

            let diff = getDurationInMinutes(from, to);
            if (diff <= 0) return;


            let slots = Math.floor(diff / duration);
           
            // Check if slots is zero
            if (slots === 0) {
                // var fromGroup = $row.find('.fromtime').closest('.form-group');
                // // Invalid time range
              
                // $("#hastimeslots").val('0');
                // // alert(fromGroup)
                // $('<label class="error fromlabelerror error-message slot-message">Time range too short for selected duration</label>').insertAfter(fromGroup)


                // // $row.find(`#slot_${$row.index()}_${day}`).html('<span class="text-danger slot-message">Time range too short for selected duration.</span>');
                // $row.find('.timeslotforall').val(0); // Set hidden input to 0
            } else {
                 // Clear previous slot messages
                 $row.find('.slot-message').remove(); 
                $row.find(`#slot_${$row.index()}_${day}`).text(`${slots} slot${slots !== 1 ? 's' : ''} available`);
                $row.find('.timeslotforall').val(slots);
            }
            // let slotIndex = $row.index(); 
         
            // $(`#slot_${slotIndex}_${day}`).text(`${slots} slot${slots !== 1 ? 's' : ''} available`);
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
        /* function for time slot calculations end */
        function addcard() {
            $("#addCreditCard").modal('hide');
            $("#addCard").modal('hide');
        }
        /*  final submit function with validation check */
        function submitTiming(type) {
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
                $('.slots-container').each(function() {
                    let $container = $(this);
                    let isOpen = $container.find('.toggle-day').is(':checked');
                    let day = $container.find('.day-type').text().trim();
                    
                    if (isOpen) {
                        let hasTimeSlot = false;
                        $container.find('.slot-row').each(function() {
                            let from = $(this).find('.fromtime').val();
                            let to = $(this).find('.totime').val();
                            if (from && to) {
                                hasTimeSlot = true;
                                return false; // Break the loop if found
                            }
                        });
                        
                        if (!hasTimeSlot) {

                            $("#hastimeslots").val('0');
                            hasEmptySlots = true;
                            $container.find('.slot-row').first().find('.fromtime').closest('.form-group').append('<label class="error slotopencls">Please add at least one time slot for ' + day + '</label>');
                            return false; // Break the outer loop
                        }
                    }
                });

                const isChecked = $('.timedurationcls:checked').length > 0;

                if (!isChecked) {
                    $('.timedurationerr').after('<label class="error slotopencls">Please select any time duration.</label>');
                    return false;
                }
                if($('input[name="timeduration"]:checked').val() == '7'){
                    $('.customcls').after('<label class="error slotopencls">Please enter duration.</label>');
                }

                if (hasEmptySlots) {
                  
                    return;
                }
                
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
                            
                            if ($('.slot-message').is(':visible') && $('.timeslotforall').val() == '0') {
                                return ;
                            }else{
                             
                                $("#savebtn").addClass('disabled');
                                savedoctor(type,'timingandchargesform') ;
                               
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
                   
                } else {
                    $(target).slideUp(); // optional animation
                    $('.' + labelClass).text('Closed'); // Set label to "Closed"
                }
            });
            $("#timingandchargesform").validate({
                ignore: [],
                rules: {
                    timeduration : 'required',
                    // appointment_type: 'required',
                  
                    //  inperson_fee:{
                    //     required: {
                    //         depends: function(element) { 
                    //             // Check if either "In Person" (2) or "Both" (3) is selected
                    //             return $('input[name="appointment_type"]:checked').val() == '2' || 
                    //                    $('input[name="appointment_type"]:checked').val() == '3';
                    //         }
                    //     },
                    //     amountCheck: true,
                    // },
                    // virtual_fee:{
                    //     required: {
                    //         depends: function(element) { 
                    //             // Check if either "In Person" (2) or "Both" (3) is selected
                    //             return $('input[name="appointment_type"]:checked').val() == '1' || 
                    //                    $('input[name="appointment_type"]:checked').val() == '3';
                    //         }
                    //     // depends: function(element) { 
                    //     //     return (  $('.checkapptype').is(':checked') && $('.checkapptype').val() != 2 ); 
                    //     // },
                    //     },
                    //     amountCheck: true,
                    // },

                    customduration: {
                        required: {
                            depends: function(element) { 
                                return $('input[name="timeduration"]:checked').val() == '7';
                            }
                        },
                        digits: true,
                        max: 180    
                      
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
                        max:  "Maximum allowed is 180 minutes (3 hours)."

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
                    var regex = /^(?!0\d)(\d{1,3}(?:,\d{3})*|\d+)(?:\.\d{1,10})?$/;

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

                // updateSlotCount($row,day);

              
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
                        <div class="form-group form-outline" id="from_${newIndex}_slots_${day}">
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
                            let mins = parseInt($('input[name="timeduration"]:checked').data('mins')) || 60;
                            defaultToTime = moment(fromTimeVal, 'hh:mm A').add(mins, 'minutes');
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
            // container.find('.totime').last().datetimepicker({
            //     format: 'hh:mm A',
            //     useCurrent: false,
            //     stepping: 10
            // });
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
                            let mins = parseInt($('input[name="timeduration"]:checked').data('mins')) || 60;
                            defaultToTime = moment(fromTimeVal, 'hh:mm A').add(mins, 'minutes');
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

        // $(document).on('change', '.appointment-type[type="checkbox"]', function() {
        //     // Uncheck all other checkboxes
        //     $('.checkapptype[type="checkbox"]').not(this).prop('checked', false);
            
        //     // Check if the checked value is 7
        //     if ($(this).is(':checked') && $(this).val() == '3') {
        //             $('.appoinmentfee').show(); // Show the extra input
                
        //     } else {
        //         $('.appoinmentfee').hide(); 
        //         if($(this).val() == '1'){
        //             $('.virtualcls').show();
        //         }else{
        //             $('.inpersoncls').show();
        //         }
             
        //     }
        // });
    

        function savedoctor(type,formname='',islater='') {
    
    if ((type == 'choose-addons' && islater !='1') && ( $('#planslist').length === 0 || !$('#planslist').is(':visible'))) {
        swal('Warning','Please add any plan to continue','warning');
        return ;
      

    }

   showPreloader("step_" + type);
   let formdata = formname !='' ? $("#"+formname).serialize() : '';
   var currentStepId = $("#"+type+"_stepId").val() || 1;
   $.ajax({
       type: "POST",
       url: '{{ url("doctor/onboarding/") }}/' + type,
       data: {
         'formdata': formdata,
         'formType' : 'onboarding',
           "currentStepId": 1,
           "nextstep": type,
           "islater" : islater ,
            "_token": "{{ csrf_token() }}"
       },
       success: function(response) {

           if(response.success == 1){
          
                window.location.href = "{{ url('dashboard/') }}/" ;
            
           }
       },
       error: function(xhr) {
           handleError(xhr);
       },
   })
}

</script>


@stop