@if( !empty($timeslots) && !empty($timeslots['morning']) )
    <div class="col-12"> 
        <div class="slot-wrapper">
            <p class="fw-medium mb-2">Morning</p>
            <div class="row g-2">
                @foreach($timeslots['morning'] as $morningslot)
                    <div class="col-4 col-sm-3 col-xl-2">
                        <a class="btn-outline-secondary w-100 slot-btn @if(!empty($input) && $input['appointment_time'] == $morningslot) active @endif">{{$morningslot}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@if( !empty($timeslots) && !empty($timeslots['afternoon']) )
    <div class="col-12"> 
        <div class="slot-wrapper">
            <p class="fw-medium mb-2">Afternoon</p>
            <div class="row g-2 validationtime">
                @foreach($timeslots['afternoon'] as $afternoonslot)
                    <div class="col-4 col-sm-3 col-xl-2">
                        <a class="btn-outline-secondary w-100 slot-btn @if(!empty($input) && $input['appointment_time'] == $afternoonslot) active @endif">{{$afternoonslot}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@if(empty($timeslots['morning']) && empty($timeslots['afternoon']))
    <div class="col-12"> 
        <div class="slot-wrapper validationtime">
            <div class="text-center">
                <p class="fwt-bold primary mb-0">No Slots Available</p>
            </div>
        </div>
    </div>
@endif
<!--
@if( (!empty($timeslots) && !empty($timeslots['morning'])) || (!empty($timeslots) && !empty($timeslots['afternoon'])) )
    <div class="col-12"> 
        <div class="slot-wrapper">
            <div class="text-start mt-1 mb-3">
                <p class="sm-label fw-middle mb-0"><span class="asterisk">*</span><strong class="primary">Note:</strong> Appointment times are shown in EST.</p>
            </div>
        </div>
    </div>
@endif-->
