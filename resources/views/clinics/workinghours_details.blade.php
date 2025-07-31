

<?php
                   $corefunctions = new \App\customclasses\Corefunctions;
                ?> 

                <div class="row">
                    <div class="col-12">
                        @if(isset($pageType) && $pageType !='myprofile')
                        <div class="d-flex align-items-center gap-3 mb-3">  
                            <a onclick="tabContent('workinghours')" class="primary"><span class="material-symbols-outlined">arrow_back</span></a>
                            <div class="innercard-info justify-content-center justify-content-xl-start mb-1"> 
                              
                                <div class="user_inner">
                                    <img alt="Blackbag" @if($userDetails['logo_path'] !='') src="{{$userDetails['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif>
                                    <div class="user_info">  
                                            <h5 class="fw-medium dark mb-0">@if($userDetails['user_type_id'] == '1' || $userDetails['user_type_id'] == '2') {{$corefunctions -> showClinicanName($userDetails,1)}} @else {{$userDetails['first_name']}} {{$userDetails['last_name']}} @endif</h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endif
                        <div class="col-lg-10 mx-auto" >
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="border rounded-4 p-4 h-100 durationdiv">
                                       
                                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                            <h5 class="primary fw-medium mb-0"> Standard Appoinment Duration </h5>
                                            {{-- <a class="btn opt-btn align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a> --}}
                                        </div>
                                        <p class="mb-1"> How long do you typically need for each consultation ? </p>
                                        <p class="mb-0 primary fw-bold"> @if($userDetails['consultation_time_id'] =='7' ) {{$userDetails['consultation_time'] }} mins @else {{$consultaionTime[$userDetails['consultation_time_id']]['consultation_time'] ?? ' --'}}@endif </p>
                                        <input class="form-check-input ckecktime timedurationcls" type="hidden" name="timeduration" @if($userDetails['consultation_time_id'] !='7' ) data-mins="{{$consultaionTime[$userDetails['consultation_time_id']]['consultation_time'] ?? ' --'}}" @endif value="{{$userDetails['consultation_time_id']}}">
                                      
                                    </div>
                                </div>
                                <div class="col-12" id="viewhours">
                                    <div class="border rounded-4 p-4 h-100">
                                        @if($businessHoursDetails->isNotEmpty())
                                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                            <h5 class="primary fw-medium mb-0">Working Hours</h5>
                                            <a onclick="editBussinessHour()" class="btn opt-btn align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                        </div>
                                        @endif
                                        @if($businessHoursDetails->isEmpty())
                                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                            <h5 class="primary fw-medium mb-0">Working Hours</h5>
                                            <a onclick="addBussinessHour()" class="btn opt-btn align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                        </div>

                                        @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                                        <div class="slots-container mt-4"> 
                                            <div class="row g-3">
                                                <div class="col-4 col-lg-6 col-xxl-7"> 
                                                    <div class="text-start">
                                                        <p class="gray m-0"> {{$day }}</p>
                                                    </div>
                                                </div>
                                                  
                                                 <div class="col-8 col-lg-6 col-xxl-5"> 
                                                    <div class="row">
                                                        <div class="col-12"> 
                                                            <div class="row align-items-baseline">
                                                                <div class="col-12 col-lg-6"> 
                                                                    <div class="text-end">
                                                                        <h6 class="fw-bold mb-0">Closed</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                        <?php  $totalSlots = 0; ?>
                                        @if($businessHoursDetails->isNotEmpty())
                                       
                                        @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                                        
                                        @php
                                            $dayIndex = strtolower($day);
                                            $dayData = $businessHoursDetails[$day]->first() ?? null;
                                        @endphp

                                            <div class="slots-container"> 
                                                <div class="row g-3">
                                                    <div class="col-4 col-lg-6 col-xxl-7"> 
                                                        <div class="text-start">
                                                            <p class="gray m-0"> {{$dayData->day }}</p>
                                                        </div>
                                                    </div>
                                                    @if($dayData && $dayData->isopen != '1')
                                                    <div class="col-8 col-lg-6 col-xxl-5"> 
                                                        <div class="row g-2">
                                                            <div class="col-12"> 
                                                                <div class="row align-items-baseline g-3">
                                                                    <div class="col-12 col-lg-6"> 
                                                                        <div class="text-end">
                                                                        <h6 class="fw-bold mb-0">Closed</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($dayData && $dayData->isopen == '1'  )
                                                      
                                                       
                                                            <div class="col-8 col-lg-6 col-xl-5"> 
                                                                <div class="row g-3">
                                                                    @foreach($dayData->slots as $slot)
                                                                    @php $totalSlots += (int) $slot->slot; @endphp
                                                                    <div class="col-12"> 
                                                                        <div class="row align-items-baseline g-3 ">
                                                                            <div class="col-12 col-lg-6"> 
                                                                                <div class="text-end">
                                                                                    <h6 class="fw-bold mb-0">

                                                                                    {{ date('g:i A', strtotime($slot->from_time)) }} - 
                                                                                    {{ date('g:i A', strtotime($slot->to_time)) }}
                                                                            <!-- {{ $slot->from_time }} - {{ $slot->to_time }}</h6> -->
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-6"> 
                                                                                <div class="text-end">
                                                                                    <h6 class="fst-italic fw-middle mb-0">{{$slot->slot}}  slots available</h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                    
                                                                </div>
                                                            </div>
                                                        
                                                    @endif



                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                      
                                        <div class="gray-border my-3"></div>
                                        <div class="slots-final text-end"> 
                                            <p class="gray fw-light mt-2 mb-0">Total Available Slots Per Week</p> 
                                            <h3 class="mb-0 primary fw-bold" id="totalSlotCounts">{{$totalSlots}} Slots</h3>
                                        </div>
                                        @if(count($vacationDetails) > 0)
                                        <div class="mb-3">
                                            <h5 class="primary fw-medium mb-0">Vacations</h5>
                                            <div class="gray-border my-3"></div>

                                            <div class="row g-2">
                                                @foreach($vacationDetails as $vacv)
                                                    @php
                                                        $from = \Carbon\Carbon::parse($vacv->vacation_from);
                                                        $to = \Carbon\Carbon::parse($vacv->vacation_to);
                                                        $diffDays = $from->diffInDays($to) + 1;

                                                        $dayLabel = $diffDays == 1 ? '1 Day' : $diffDays . ' Days';

                                                        if ($diffDays == 1) {
                                                            $dateStr = $from->format('D, M d, Y');
                                                        } else {
                                                            $dateStr = $from->format('D, M d') . ' – ' . $to->format('D, M d, Y');
                                                        }
                                                    @endphp
                                                <div class="col-12"> 
                                                    <div class="row">
                                                        <div class="col-6"> 
                                                            <div class="text-start"> 
                                                                <p class="gray m-0"> {{ $dayLabel }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-6"> 
                                                      
                                                                    <div class="text-end">
                                                                        <h6 class="fw-bold mb-0">{{ $dateStr }}</h6>
                                                                    </div>
                                                             
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        @endif
                                    </div>
                                </div>
                                <div class="col-12" id="edithours"  style="display:none;">
                                    @if($businessHoursDetails->isNotEmpty())
                                    @include("clinics.edit_bussinesshour")
                                    @endif
                                </div>
                                @if($businessHoursDetails->isEmpty())
                                <div class="col-12" id="addhours"  style="display:none;">
                                        <form method="POST" id="timingandchargesform" autocomplete="off">
                                        @csrf
                                            <div class="row g-3" > 
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
                                                                                <input class="form-check-input ckecktime timedurationcls" type="checkbox" id="time_{{$time['id']}}" name="timeduration" value="{{$time['id']}}">
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
                                                </div>
                                                <div class="col-12"> 
                                                    <div class="border rounded-4 p-4 h-100">
                                                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                                            <h5 class="fw-medium mb-3">Working Hours</h5>
                                                            <a class="btn opt-btn align_middle">
                                                                <span class="material-symbols-outlined">edit</span>
                                                            </a>
                                                        </div>

                                                    
                                                        @if( !empty($businessHours))
                                                        @foreach($businessHours as $key => $days)
                                                        <div class="slots-container"> 
                                                            <div class="row g-3"  id="{{strtolower($days['day'])}}-slots">
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
                                                                    <div class="row align-items-baseline g-3 slot-row slot-row_{{$days['day']}} removeslocls_0_{{$days['day']}} ">
                                                                        <div class="col-sm-6 col-lg-4"> 
                                                                            <div class="form-group form-outline time-slot-container" id="from_0_slots_{{$days['day']}}">
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
                                                        <input type="hidden" class="form-control "  id="hastimeslots" name="hastimeslots" value="">
                                                        <input type="hidden" class="form-control "  id="user_id" name="user_id" value="{{$userDetails['user_id']}}">
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
                                                </div>
                                                
                                            </div>
                                            <input type="hidden" id="iscard" value="0" name="iscard">
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
                                                        <!-- Vacation entries will be appended here -->
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <input type="hidden" id="validvacation" value="1" name="validvacation">


                                        </form>
                                        <div class="btn_alignbox justify-content-end mt-1 mt-3">
                                            <button type="button" id="savebtn" class="btn btn-primary" onclick="submitTiming('payment-processing')">Save & Continue</button>
                                        </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
  

    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== '';
        const isFocused = $input.is(':focus');

        // Correct selector for all cases (only applies to visible inputs)
        $input.closest('.form-group').find('.float-label').toggleClass('active', hasValue || isFocused);
    }

    function addBussinessHour(){
        $('#viewhours').hide();
        $('#addhours').show();
        $('.durationdiv').hide();
        $('input:visible, textarea:visible').each(function () {
            toggleLabel(this);
        });
    } 
    function editBussinessHour(){
        $('#viewhours').hide();
        $('#edithours').show();
        $('.durationdiv').hide();
        
        $('input:visible, textarea:visible').each(function () {
            toggleLabel(this);
        });
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
                // var fromGroup = $row.find('.fromtime').closest('.form-group');
                // // Invalid time range
              
                // $("#hastimeslots").val('0');
                // // alert(fromGroup)
                // $('<label class="error fromlabelerror error-message slot-message">Time range too short for selected duration</label>').insertAfter(fromGroup)


                // // $row.find(`#slot_${$row.index()}_${day}`).html('<span class="text-danger slot-message">Time range too short for selected duration.</span>');
                // $row.find('.timeslotforall').val(0); // Set hidden input to 0
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
            // alert(total)
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
function addvalidateVacations() {
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

            //   $('.slots-container').each(function() {
            //       let $container = $(this);
            //       let isOpen = $container.find('.toggle-day').is(':checked');
            //       let day = $container.find('.day-type').text().trim();
                  
            //       if (isOpen) {
            //           let hasTimeSlot = false;
            //           $container.find('.slot-row').each(function() {
            //               let from = $(this).find('.fromtime').val();
            //               let to = $(this).find('.totime').val();
            //               if (from && to) {
            //                   hasTimeSlot = true;
            //                   return false; // Break the loop if found
            //               }
            //           });
                      
            //           if (!hasTimeSlot) {
            //               $("#hastimeslots").val('0');
            //               hasEmptySlots = true;
            //               $container.find('.slot-row').first().find('.fromtime').closest('.form-group').append('<label class="error slotopencls">Please add at least one time slot.</label>');
            //           }
            //       }
            //   });
            
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
                    let vacationValid = addvalidateVacations();
                    
              
                // $('.slots-container').each(function() {
                //     let $container = $(this);
                //     let isOpen = $container.find('.toggle-day').is(':checked');
                //     let day = $container.find('.day-type').text().trim();
                    
                //     if (isOpen) {
                //         let hasTimeSlot = false;
                //         $container.find('.slot-row').each(function() {
                //             let from = $(this).find('.fromtime').val();
                //             let to = $(this).find('.totime').val();
                //             if (from && to) {
                //                 hasTimeSlot = true;
                //                 return false; // Break the loop if found
                //             }
                //         });
                        
                //         if (!hasTimeSlot) {

                //             $("#hastimeslots").val('0');
                //             hasEmptySlots = true;
                //             $container.find('.slot-row').first().find('.fromtime').closest('.form-group').append('<label class="error slotopencls">Please add at least one time slot .</label>');
                //             return false; // Break the outer loop
                //         }
                //     }
                // });

                // if (hasEmptySlots) {
                //     return;
                // }
                
                if ($("#timingandchargesform").valid()) {
                    if (!vacationValid) {
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
                            if ($('.slot-message').is(':visible') ) {
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
                                        $("#savebtn").addClass('disabled');
                           
                                        let formdata =$("#timingandchargesform").serialize();
                                        $.ajax({
                                            type: "POST",
                                            url: '{{ url("/onboarding/") }}/' + type,
                                            data: {
                                                'formdata': formdata,
                                                "currentStepId": 1,
                                                "nextstep": type,
                                                "islater" : '' ,
                                                    "_token": "{{ csrf_token() }}"
                                            },
                                            success: function(response) {
                                                if(response.success == 1){
                                                    tabContent('workinghours');
                                                
                                                }
                                            },
                                            error: function(xhr) {
                                                handleError(xhr);
                                            },
                                        })
                                    } else {
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
                        max: 180    
                    },
                    
                    // vacation_date: {
                    //     required: {
                    //         depends: function(element) {
                    //             return $("input[name='vacation_type']:checked").val() === 'specific';
                    //         }
                    //     },
                    //     date: true
                    // },
                    // vacation_from: {
                    //     // required: {
                    //     //     depends: function(element) {
                    //     //         return $("input[name='vacation_type']:checked").val() === 'range';
                    //     //     }
                    //     // },
                    //     date: {
                    //         depends: function(element) {
                    //             return $("input[name='vacation_type']:checked").val() === 'range';
                    //         }
                    //     },
                        
                    // },
                    // vacation_to: {
                    //      required: {
                    //         depends: function(element) {
                    //             return $("input[name='vacation_type']:checked").val() === 'range';
                    //         }
                    //     },
                    //     date: true,
                    //     greaterOrEqualToFrom: true
                    // },

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
                    vacation_date: {
                        required: "Please select a vacation date.",
                        date: "Please enter a valid date."
                    },
                    vacation_from: {
                        required: "Please select a from date for your vacation range.",
                        date: "Please enter a valid date."
                    },
                    vacation_to: {
                        date: "Please enter a valid date.",
                        greaterOrEqualToFrom: "To date must be the same or after the from date."
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
            // Custom method for vacation_to >= vacation_from
            $.validator.addMethod("greaterOrEqualToFrom", function(value, element) {
                var from = $("#vacation_from").val();
                var to = value;
                if (!to || !from) return true; // Only validate if both are filled
                var fromDate = new Date(from);
                var toDate = new Date(to);
                return toDate >= fromDate;
            }, "'To' date must be the same or after the 'From' date.");

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
            var newIndex = lastIndex ;
             
        
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


    $('#add-vacation-btn').on('click', function() {
        const html = getVacationEntryHtml(vacationIndex);
        $('#vacation-list').append(html);
        const $entry = $('#vacation-list .vacation-entry').last();
        initializeVacationEntry($entry);
        vacationIndex++;
    });

    function getVacationEntryHtml(index) {
        return `
        <div class="row align-items-center g-2 mt-2 vacation-entry" data-index="${index}">
            <div class="col-12">
                <div class="d-flex align-items-center gap-3 mt-3 mb-2 radio-box">
                    <label>
                        <input type="radio" name="vacations[${index}][vacation_type]" value="specific" checked> Specific Date
                    </label>
                    <label>
                        <input type="radio" name="vacations[${index}][vacation_type]" value="range"> Date Range
                    </label>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-6 vacation-date-section">
                        <div class="form-group form-outline">
                            <label class="float-label">Vacation Date</label>
                            <i class="material-symbols-outlined">event_busy</i>
                            <input type="text" class="form-control vacation_date" name="vacations[${index}][vacation_date]" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-6 vacation-range-section" style="display:none;">
                        <div class="form-group form-outline">
                            <label class="float-label">Vacation From</label>
                            <i class="material-symbols-outlined">event_busy</i>
                            <input type="text" class="form-control vacation_from" name="vacations[${index}][vacation_from]" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-6 vacation-range-section" style="display:none;">
                        <div class="form-group form-outline">
                            <label class="float-label">Vacation To</label>
                            <i class="material-symbols-outlined">event_busy</i>
                            <input type="text" class="form-control vacation_to" name="vacations[${index}][vacation_to]" autocomplete="off">
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-lg-3">
                <div class="btn_alignbox justify-content-end">
                    <button type="button" class="dlt-btn btn-align  remove-vacation-btn" title="Remove"><span class="material-symbols-outlined">delete</span></button>
                </div>
            </div>
        </div>
        `;
    }

    var vacationIndex = 0;
    function initializeVacationEntry($entry) {
        // Date pickers
        $entry.find('.vacation_date').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false,
            minDate: moment()
        });
        $entry.find('.vacation_from').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false,
            minDate: moment()
        });
        $entry.find('.vacation_to').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false,
            minDate: moment()
        });
        // Toggle sections
        $entry.find('input[type=radio][name^="vacations"]').on('change', function() {
            if ($(this).val() === 'specific') {
                $entry.find('.vacation-date-section').show();
                $entry.find('.vacation-range-section').hide();
                $entry.find('.vacation_from, .vacation_to').val('');
            } else {
                $entry.find('.vacation-date-section').hide();
                $entry.find('.vacation-range-section').show();
                $entry.find('.vacation_date').val('');
            }
        });
        // Remove button
        $entry.find('.remove-vacation-btn').on('click', function() {
            $entry.remove();
        });
    }
 // Add one entry by default
//  $(function() {
//         $('#add-vacation-btn').trigger('click');
//     });

    function checkAppointmentsForVacation($entry, vacationType, date, from, to) {
        var doctorID = $("#user_id").val();
        $.ajax({
            url: '{{ url("/checkappointmentsforvacation") }}',
            type: 'POST',
            data: {
                doctorID : doctorID ,
                vacation_type: vacationType,
                vacation_date: date,
                vacation_from: from,
                vacation_to: to,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success == 0) {
                    // Show warning or block form submission
                    swal('warning',response.message,'warning');
                    if (vacationType === 'specific') {
                        $entry.find('.vacation_date').val('');
                    } else if (vacationType === 'range') {
                        $entry.find('.vacation_from').val('');
                        $entry.find('.vacation_to').val('');
                    }
                    $('#validvacation').val('');
                    
                } else {
                    $('#validvacation').val('1');
                }
            }
        });
    }

    // Listen for changes
    $('#vacation-list').on('blur change', '.vacation_date, .vacation_from, .vacation_to, input[type=radio][name^="vacations"]', function() {
        var $entry = $(this).closest('.vacation-entry');
        $(this).closest('.vacation-entry').find('.vacation-error').remove();
        var index = $entry.data('index');
        var vacationType = $entry.find('input[type=radio][name="vacations['+index+'][vacation_type]"]:checked').val();
        var date = $entry.find('.vacation_date').val();
        var from = $entry.find('.vacation_from').val();
        var to = $entry.find('.vacation_to').val();

        if (vacationType === 'specific' && date) {
            checkAppointmentsForVacation($entry, vacationType, date, null, null);
        } else if (vacationType === 'range' && from) {
            checkAppointmentsForVacation($entry, vacationType, null, from, to);
        }
    });


</script>

