                                    <?php  $corefunctions = new \App\customclasses\Corefunctions; ?>   
                                       
                                       <div class="outer-wrapper box-cnt-inner">
                                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                               
                                            @if($previousAppointments->isNotEmpty())
                                            @foreach($previousAppointments as $pak => $pav)
                                            
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                        <button class="accordion-button collapsed @if(session()->get('user.userType') == 'patient') patientprevappcls  @endif" type="button" data-bs-toggle="collapse" data-bs-target="#appendvideocalldetails_{{$pav['id']}}" aria-expanded="false" aria-controls="appendvideocalldetails_{{$pav['id']}}">
                                                            <div class="row align-items-center collapse-header w-100">

                                                                <div class="col-3 col-lg-3">
                                                                    <div class="collaspe-info">
                                                                        <small class="fw-light">Appointment Date & Time</small>
                                                                        <p class="fw-medium dark mb-0"><?php echo $corefunctions->timezoneChange($pav['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($pav['appointment_time'],"h:i A") ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3 col-lg-3">
                                                                    <div class="collaspe-info">
                                                                        <small class="fw-light">Type</small>
                                                                        <p class="fw-medium dark mb-0">{{$appointmentTypes[$pav['appointment_type_id']]['appointment_name']}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3 col-lg-2">
                                                                    <div class="collaspe-info">
                                                                        <small class="fw-light">Call Duration</small>
                                                                        <p class="fw-medium dark mb-0">  @if(isset($pav['videocall']->duration) && $pav['videocall']->duration > 0 && $pav['videocall']->duration != '' )
                                                                                                @php
                                                                                                    $totalSeconds = $pav['videocall']->duration;
                                                                                                    $hours = intdiv($totalSeconds, 3600);
                                                                                                    $minutes = round(($totalSeconds % 3600) / 60); // Rounded minutes
                                                                                                @endphp
                                                                                                @if($hours > 0)
                                                                                                    {{ $hours }} {{ $hours > 1 ? 'hours' : 'hour' }}
                                                                                                @endif

                                                                                                @if($minutes > 0)
                                                                                                    {{ $hours > 0 ? ' and ' : '' }} {{ $minutes }} {{ $minutes > 1 ? 'minutes' : 'minute' }}
                                                                                                @endif
                                                                                            @else
                                                                                                --
                                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3 col-lg-2">
                                                                    <div class="collaspe-info">
                                                                        <small class="fw-light">Start Time</small>
                                                                        <p class="fw-medium dark mb-0">@if(isset($pav['videocall']->call_started) && $pav['videocall']->call_started != '') <?php echo $corefunctions->timezoneChange($pav['videocall']->call_started,"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($pav['videocall']->call_started,'h:i A','0') ?> @else -- @endif</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3 col-lg-2">
                                                                    <div class="collaspe-info">
                                                                        <small class="fw-light">End Time</small>
                                                                        <p class="fw-medium dark mb-0">@if(isset($pav['videocall']->call_ended) && $pav['videocall']->call_ended != '') <?php echo $corefunctions->timezoneChange($pav['videocall']->call_ended,"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($pav['videocall']->call_ended,'h:i A','0') ?> @else -- @endif</p>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                            @if(session()->get('user.userType') != 'patient')   
                                                            <span id="arrow_btn_rot{{ $pav['id'] }}" onclick="appendVideoCallDetails('{{$pav['id']}}');" class="material-symbols-outlined arrow-btn"> keyboard_arrow_down</span>
                                                            @endif
                                                        </button>
                                                    </h2>
                                                  <div   id="appendvideocalldetails_{{$pav['id']}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                                    <!-- <div class="accordion-body">
                                                            <h6 class="fw-medium mb-3">Participants</h6> 
                                                            <div class="participant-wrapper"> 
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-4 d-flex align-items-center">
                                                                        <div class="user_inner">
                                                                            <img src="{{asset('images/nurse1.png')}}">
                                                                            <div class="user_info">
                                                                                <h6 class="primary fw-medium m-0">Jelani Kasongo</h6>
                                                                                <p class="m-0">jelanikasongo@gmail.com</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="collaspe-info">
                                                                            <small class="fw-light">Role:</small>
                                                                            <p class="fw-medium primary">Doctor</p>
                                                                        </div>
                        
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="collaspe-info">
                                                                            <small class="fw-light">Duration:</small>
                                                                            <p class="fw-medium primary">45mins</p>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="participant-wrapper"> 
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-4 d-flex align-items-center">
                                                                        <div class="user_inner">
                                                                            <img src="{{asset('images/nurse1.png')}}">
                                                                            <div class="user_info">
                                                                                <h6 class="primary fw-medium m-0">Jelani Kasongo</h6>
                                                                                <p class="m-0">jelanikasongo@gmail.com</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="collaspe-info">
                                                                            <small class="fw-light">Role:</small>
                                                                            <p class="fw-medium primary">Doctor</p>
                                                                        </div>
                        
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="collaspe-info">
                                                                            <small class="fw-light">Duration:</small>
                                                                            <p class="fw-medium primary">45mins</p>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
        
                                                        
                                                        </div> -->
                                                    </div>
                                                </div>
                                               
                                                @endforeach
                                                @else
                                               
                                                    <div class="no-data-box">
                                                        <p class="mb-0 align_middle"><span class="material-symbols-outlined primary">info</span>No previous appointments found!</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>