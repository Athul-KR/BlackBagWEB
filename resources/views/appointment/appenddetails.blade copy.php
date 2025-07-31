
<div class="row h-100">
        <div class="col-xl-8 col-12 mb-4">
        <div class="web-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-medium">Appointment Details</h5>
                @if($appointment['is_completed'] == '0' && $appointment['appointment_type_id'] == '1')
                    @if(session()->get('user.userType') == 'patient' && ($appointment['is_paid'] != '1' ))
                        <button onclick="joinMeet('{{$appointment['appointment_uuid']}}');" id="submitbtn"  class="btn btn-primary">Pay Now</button>
                    @else 
                    @if($appointment['appointment_type_id'] == '1' && ($appointment['is_paid'] == '1' ) && ($appointment['deleted_at'] == '' ))
                        <a class="opt-btn opt-view border-0" target ="_blank" href="{{url('meet/'.$appointment['appointment_uuid'])}}" data-bs-toggle="tooltip" title="Start Video Call"><span class="material-symbols-outlined">videocam</span></a>
                        @endif
                    @endif
                @endif
            </div>
            <hr>
            <div class="row">
            <div class="col-lg-4 col-12">
                <div class="form-group mb-4">
                <label class="mb-2">Patient</label>
                <div class="user_inner">
                   
                    <img alt="Blackbag" @if($patient->logo_path !='') src="{{($patient->logo_path)}}" @else src="{{asset('images/default_img.png')}}" @endif>
                    <div class="user_info">
                    @if(session()->get('user.userType') != 'patient')<a href="{{ url('patient/'.$patient->patients_uuid.'/details') }}">@endif
                        <h6 class="primary fw-medium m-0">{{$patient->user->first_name}}</h6>
                        <p class="m-0">{{$patient->age}} | {{ $patient->gender == '1' ? 'Male' : ($patient->gender == '2' ? 'Female' : 'Other') }}</p>
                    @if(session()->get('user.userType') != 'patient')</a>@endif
                    </div>
                </div>
                </div>
            </div>   
            <div class="col-lg-4 col-12">
                <div class="form-group mb-4"> 
                <label class="mb-2">Phone Number</label>
                <h6 class="fw-medium"><?php echo $countryCode['country_code']. '    '.$patientphone ?></h6>
                </div>
            </div>   
            <div class="col-lg-4 col-12">
                <div class="form-group mb-4"> 
                <label class="mb-2">Appointment Date & Time</label>
                <h6 class="fw-medium"><?php echo $corefunctions->timezoneChange($appointment['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment['appointment_time'],'h:i A') ?></h6>
                </div>
            </div>   
            <div class="col-lg-4 col-12">
                <div class="form-group mb-4"> 
                <label class="mb-2">Type</label>
                <h6 class="fw-medium">{{$appointmentTypes[$appointment['appointment_type_id']]['appointment_name']}}</h6>
                </div>
            </div>   
                
            <div class="col-lg-4 col-12">
                <div class="form-group mb-4"> 
                <label class="mb-2">Booked On</label>
                <h6 class="fw-medium"><?php echo $corefunctions->timezoneChange($appointment['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment['created_at'],'h:i A') ?></h6>
                </div>
            </div>   
            <div class="col-lg-4 col-12">
                <div class="form-group mb-4"> 
                <label class="mb-2">Booked By</label>
                <h6 class="fw-medium">{{$bookedBy}}</h6>
                </div>
            </div>   
            <div class="col-lg-4 col-12">
                <div class="form-group mb-4"> 
                <label class="mb-2">Clinician</label>
                <div class="user_inner">
                    <img alt="Blackbag" @if($doctor['logo_path'] !='') src="{{($doctor['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif>
                    <div class="user_info">
                    @if(session()->get('user.userType') != 'patient')<a href="{{url('user/'.$doctor->clinic_user_uuid.'/details')}}">@endif
                        <h6 class="primary fw-medium m-0">{{ $corefunctions -> showClinicanName($doctor,'1'); }}</h6>
                        <p class="m-0">{{$doctor->email}}</p>
                    @if(session()->get('user.userType') != 'patient')</a>@endif
                    </div>
                </div>
                </div>
            </div> 
            <div class="col-lg-4 col-12">
                <div class="form-group mb-4"> 
                <label class="mb-2">Nurse</label>
                <div class="user_inner">
                    <img alt="Blackbag" @if($nurse->logo_path !='') src="{{($nurse->logo_path)}}" @else src="{{asset('images/default_img.png')}}" @endif>
                    <div class="user_info appointment_info">
                    @if(session()->get('user.userType') != 'patient')<a href="{{url('user/'.$nurse->clinic_user_uuid.'/details')}}">@endif
                        <h6 class="primary fw-medium m-0">{{$nurse->user->first_name}}</h6>
                        <p class="m-0">{{$nurse->user->email}}</p>
                    @if(session()->get('user.userType') != 'patient')</a>@endif
                    </div>
                </div>
                </div>
            </div>                                        
            </div>        
        </div>
        </div>
        <div class="col-xl-4 col-12 mb-4">
        <div class="web-card h-100">
            <div class="detailsList">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-medium">Appointment Notes</h5>
                    <!-- <a class="btn opt-btn" href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editProfileModal"><span class="material-symbols-outlined">edit</span></a> -->
                </div>
                <hr>
                    @if(!empty($appointmentNotes))
                 
                    <div class="d-flex flex-column">
                        <h6 class="fw-medium">Notes</h6>
                        @foreach($appointmentNotes as $notes => $value)
                    
                        <p><?php echo $value->notes ?></p>
                        @endforeach
                    </div>
                    @elseif(isset($appointment['notes']) && $appointment['notes'] != '')
                    <div class="d-flex flex-column">
                        <h6 class="fw-medium">Notes</h6>
                        <p><?php echo $appointment['notes'] ?></p>
                    </div>
                    @else
                    <div class="d-flex flex-column">
                        <h6 class="fw-medium">Notes</h6>
                        <p>No notes added!</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if(!empty($participants) && session()->get('user.userType') != 'patient')
        <div class="col-12 mb-4">
        <div class="web-card min-h-auto card-table">
            <h5 class="fw-medium">Video Call Details</h5>
            <hr>
            <table class="table table-bordered">
            <thead>
                <tr>
                   
                    <th>Duration</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- Room Details Row -->
                <tr>
                   
                    <td>
                        @if($room->duration > 0 && $room->duration != '' )
                            @php
                                $totalSeconds = $room->duration;
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
                       </td>
                    <td>@if(isset($room->call_started) && $room->call_started != '') <?php echo $corefunctions->timezoneChange($room->call_started,"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($room->call_started,'h:i A','0') ?> @else -- @endif</td>
                    <td>@if(isset($room->call_ended) && $room->call_ended != '') <?php echo $corefunctions->timezoneChange($room->call_ended,"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($room->call_ended,'h:i A','0') ?> @else -- @endif</td>
                </tr>
                <!-- Participants Row -->
                <tr>
                    <td colspan="4" class="inner-tabledata">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Participant Name</th>
                                    <th>Type</th>
                                    <th class="text-end">Duration</th>
                                    <!-- <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participants as $participant)
                            
                                <tr>
                                    @if($participant['participant_type'] == 'patient')
                                    <td>{{ $patient->name }}</td>
                                    @else
                                    
                                       <td>@if(isset($clinicUserDetails[$participant['participant_id']])){{ $corefunctions -> showClinicanName($clinicUserDetails[$participant['participant_id']],'1');}}@endif</td>
                                    
                                    @endif
                                    @if($participant['participant_type'] == 'doctor')
                                    <td>Clinician</td>
                                    @else
                                    <td>@if($participant['participant_type'] == 'clinics') Clinician @else {{ ucfirst($participant['participant_type']) }} @endif</td>
                                    @endif
                                    
                                    <td class="text-end">
                                    @if($participant['total_duration'] > 0)
                                           
                                            @php
                                                $parts = explode(":", $participant['total_duration']); // Split duration (H:i:s)
                                                $hours = (int) $parts[0];
                                                $minutes = (int) $parts[1];
                                            @endphp

                                            @if($hours > 0)
                                                {{ $hours }} hours 
                                            @endif

                                            @if($minutes > 0)
                                                {{ $minutes }} minutes
                                            @endif

                                        @else
                                            --
                                        @endif
                                    </td>

                                    <!-- <td class="text-end">
                                        @if(isset($participant['initiated']) && $participant['initiated'] != '' && isset($participant['completed']) && $participant['completed'] != '' && $participant['is_reject'] == '0') 
                                            @php
                                                $differenceInMinutes = intdiv(abs($participant['completed'] - $participant['initiated']), 60);
                                            @endphp

                                            @if($differenceInMinutes >= 60)
                                                @php
                                                    $hours = intdiv($differenceInMinutes, 60);
                                                    $minutes = $differenceInMinutes % 60;
                                                @endphp

                                                {{ $hours }} {{ $hours > 1 ? 'hours' : 'hour' }} 
                                                @if($minutes > 0)
                                                    and {{ $minutes }} {{ $minutes > 1 ? 'minutes' : 'minute' }}
                                                @endif
                                            @else
                                                {{ $differenceInMinutes }} {{ $differenceInMinutes > 1 ? 'minutes' : 'minute' }}
                                            @endif
                                        @else -- @endif
                                    </td> -->
                                    <!-- <td>@if(isset($participant['initiated']) && $participant['initiated'] != '' && $participant['is_reject'] == '0') <?php echo $corefunctions->timezoneChange($participant['initiated'],"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($participant['initiated'],'h:i A','0') ?> @else -- @endif</td>
                                    <td>@if(isset($participant['completed']) && $participant['completed'] != ''  && $participant['is_reject'] == '0') <?php echo $corefunctions->timezoneChange($participant['completed'],"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($participant['completed'],'h:i A','0') ?> @else -- @endif</td>
                                    <td>@if(isset($participant['is_reject']) && $participant['is_reject'] == '1') Rejected by host @endif
                                    @if(isset($participant['completed']) && $participant['completed'] != '' && $participant['is_reject'] == '0') Completed @endif
                                    </td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                
                
            </tbody>
            </table>
        </div>
        
        </div>
        @endif
        <div class="col-12 mb-5">
        <div class="web-card min-h-auto">
            <div class="detailsList">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-medium">Previous Appointments</h5>
                </div>
                <hr>
                @if(!empty($previousAppointments))
                    @foreach($previousAppointments as $pak => $pav)
                    <div class="d-flex justify-content-between align-items-center"> 
                        <div class="row w-100"> 
                            <div class="col-lg-4 col-12"> 
                                <div class="form-group mb-4 br"> 
                                    <label class="mb-2">Appointment Date</label>
                                    <h6 class="fw-medium"><?php echo $corefunctions->timezoneChange($pav['appointment_date'],"M d, Y") ?></h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12"> 
                                <div class="form-group mb-4 br"> 
                                    <label class="mb-2">Appointment Time</label>
                                    <h6 class="fw-medium"><?php echo $corefunctions->timezoneChange($pav['appointment_time'],"h:i A") ?></h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12"> 
                                <div class="form-group mb-4"> 
                                    <label class="mb-2">Type</label>
                                    <h6 class="fw-medium">{{$appointmentTypes[$pav['appointment_type_id']]['appointment_name']}}</h6>
                                </div>
                            </div>
                        </div>
                        @if(session()->get('user.userType') != 'patient')
                        <div class="btn_alignbox justify-content-end w-100"> 
                            <a href="javascript:void(0)" onclick="toggleVideoCallDetails('{{$pav['id']}}');" class="arrow_btn arrow-r" id="arrow_btn_rot{{ $pav['id'] }}" ><span class="material-symbols-outlined">arrow_forward_ios</span></a>
                        </div>
                        @endif
                    </div>
                    <div class="appointment-details" id="details_{{$pav['id']}}" style="display: none;">
                        <div class="row">
                            <div class="col-12" id="appendvideocalldetails_{{$pav['id']}}">
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
            
                    <div class="text-center w-100"> 
                        <p>No previous appointments found!</p>
                    </div>
                    
                @endif
                </div>
            </div>
        </div>
    </div>

<!-- New-design -->

    <section class="mb-5 appointment-details">
        <div class="row">
            <div class="col-12">
                <div class="web-card appointment-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="row align-items-center">
                               <div class="col-md-4 my-2">
                                    <div class="form-group">
                                        <div class="user_inner appnmt-user">
                                            <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                            <div class="user_info">
                                                <h6 class="primary fw-medium m-0">John Doe</h6>
                                                <p class="m-0">johndoe@gmail.com</p>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-md-2 my-2">
                                <div class="d-flex">
                                    <span><i class="fa-solid fa-calendar-days"></i></span>
                                    <div class="form-group ms-2"> 
                                        <label class="mb-1">Age</label>
                                        <h6 class="fw-medium">65 Years</h6>
                                    </div>
                                </div>
                               </div>
                               <div class="col-md-2 my-2">
                                    <div class="d-flex gender">
                                        <span><i class="fa-solid fa-mars"></i></span>
                                        <div class="form-group ms-2"> 
                                            <label class="mb-1">Gender</label>
                                            <h6 class="fw-medium">Male</h6>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-md-4 my-2">
                                    <div class="d-flex">
                                        <span><i class="fa-solid fa-phone"></i></span>
                                        <div class="form-group ms-2"> 
                                            <label class="mb-1">Phone Number</label>
                                            <h6 class="fw-medium">+1 86006 70098</h6>
                                        </div>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                <a class="opt-btn opt-view border-0" target="_blank" href="" data-bs-toggle="tooltip" title="Start Video Call"><span class="material-symbols-outlined">videocam</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="web-card mb-4">
                    <h5 class="fw-medium mb-4">Appointment Details</h5>
                    <div class="form-group mb-4"> 
                        <label class="mb-2">Appointment Date & Time</label>
                        <h6 class="fw-medium">Dec 31 2024, 12:25 PM</h6>
                    </div>
                    <div class="form-group mb-4"> 
                        <label class="mb-2">Type</label>
                        <h6 class="fw-medium">Online Appointment</h6>
                    </div>
                    <div class="form-group mb-4"> 
                        <label class="mb-2">Booked On</label>
                        <h6 class="fw-medium">Dec 30 2024, 05:20 PM</h6>
                    </div>
                    <div class="form-group mb-4"> 
                        <label class="mb-2">Booked By</label>
                        <h6 class="fw-medium">Sandeep</h6>
                    </div>
                    <div class="form-group mb-4"> 
                        <label class="mb-2">Participants</label>
                        <div class="users-sec">
                            <a href="" class="users-img">
                            <img class="thumb-user-img" src="https://demoserver22.icwares.com/nov8tiv/dev/public/img/users/img01.jpg" alt="Blackbag">
                            </a>
                            <a href="" class="users-img">
                            <img class="thumb-user-img" src="https://demoserver22.icwares.com/nov8tiv/dev/public/img/users/img02.jpg" alt="Blackbag">
                            </a>
                            <a href="" class="users-img">
                            <img class="thumb-user-img" src="https://demoserver22.icwares.com/nov8tiv/dev/public/img/users/img03.jpg" alt="Blackbag">
                            </a>
                            <a href="" class="users-img">
                            <img class="thumb-user-img" src="https://demoserver22.icwares.com/nov8tiv/dev/public/img/users/img04.jpg" alt="Blackbag">
                            </a>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="mb-2">Appointment Notes</label>
                        <h6 class="fw-medium">Experiencing persistent dull headaches for the past week</h6>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <div class="web-card mb-4">
                    <h5 class="fw-medium mb-4">Soap Notes</h5>
                    <div>
                        <div class="text-center w-100"> 
                            <p>No Soap Notes found!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="web-card mb-4 prev-appntmnts">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-medium mb-0">External Participants</h5>
                        <a onclick="" class="btn btn-primary btn-align" data-bs-toggle="modal" data-bs-target="#inviteParticipants"><span class="material-symbols-outlined me-2">group_add</span>Invite Participants </a>
                    </div>
                    <div class="card-border mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="user_inner prtpnts-user">
                                        <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                        <div class="user_info">
                                            <h6 class="primary fw-medium m-0">John Doe</h6>
                                            <p class="m-0">johndoe@gmail.com</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"> 
                                    <label class="mb-2">Phone Number</label>
                                    <h6 class="fw-medium">+1 (888) 941-3936</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-end align-items-center">
                                    <a href="" class="btn btn-outline">Resend Invite </a>
                                    <a class="btn opt-btn ms-3" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1372px, 237px);">

                                        <li>
                                            <a id="view-appointment" href="https://demoserver22.icwares.com/blackbag/dev/appointment/2cba0f209d/details" class="dropdown-item fw-medium">
                                                <i class="fa-solid fa-eye me-2"></i>
                                                <span>View</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a id="edit-appointment" onclick="editAppointment('https://demoserver22.icwares.com/blackbag/dev/appointments/edit/2cba0f209d?status=open')" data-appointurl="https://demoserver22.icwares.com/blackbag/dev/appointments/edit/2cba0f209d" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editAppointment" class="dropdown-item fw-medium">
                                                <i class="fa-solid fa-pen me-2"></i>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a onclick="completeAppointment('2cba0f209d')" class="dropdown-item fw-medium">
                                                <i class="fa-solid fa-check me-2"></i>
                                                <span>Mark as Completed</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-appointmenturl="https://demoserver22.icwares.com/blackbag/dev/appointments/delete/2cba0f209d?status=open" class="delete-appt dropdown-item fw-medium">
                                                <i class="fa-solid fa-trash-can me-2"></i>
                                                <span>Cancel</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- Modal -->
<div class="modal fade" id="inviteParticipants" tabindex="-1" aria-labelledby="inviteParticipantsLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
    <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
      <div class="modal-body text-center">
        <h4 class="text-center fw-medium mb-0">Invite Participants </h4>
        <small class="gray">Please enter patient details and create an appointment.</small>
        <div>
            <form method="post" autocomplete="off" novalidate="novalidate">
    <input type="hidden" name="_token" value="wAvG6wAt1T98UFRT3jLRoGefTXaSd5sZNbodnM0f" autocomplete="off">   
     <div class="row mt-4">
        
        <div class="col-md-12 col-12">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input type="text" class="form-control" id="username" name="username">
            </div>
        </div>
        <div class="col-md-6 col-12">
        <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-control" id="email" name="email">
            </div>
</div>
        <div class="col-md-6 col-12">
        <div class="form-group form-outline mb-4">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCode" name="countrycode" value="US">
                </div>
                <i class="material-symbols-outlined me-2">call</i>
                <div class="intl-tel-input allow-dropdown separate-dial-code iti-sdc-2"><div class="flag-container"><div class="selected-flag" tabindex="0" title="United States: +1"><div class="iti-flag us"></div><div class="selected-dial-code">+1</div><div class="iti-arrow"></div></div></div><input type="text" class="form-control phone-number" id="phone_number" name="phone_number" placeholder="Phone Number" autocomplete="off" maxlength="14"></div>
            </div>
        </div>
        
        
        
        <div class="col-12 my-2">
            <div class="or-sec">
                <p class="mb-0">OR</p>
            </div>
        </div>

        <div class="col-12">
            <div class="btn_alignbox justify-content-end">
                <button id="" type="button" onclick="" class="btn btn-primary">Sent Invite</button>
            </div>
        </div>

    </div>

</form>
</script>

</div>
</div>
    </div>
  </div>
</div>
        <div class="row">
            <div class="col-12">
                <div class="web-card mb-4 prev-appntmnts">
                    <h5 class="fw-medium mb-4">Previous Appointments</h5>
                    <div>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <div class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    <div class="col-12">
                                        <div class="row align-items-center">
                                            <div class="col-md-10">
                                                <div class="row ">
                                                    <div class="col-md-3">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Appointment Date & Time</label>
                                                            <h6 class="fw-medium">Dec 31 2024, 12:25 PM</h6>
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-3">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Type</label>
                                                            <h6 class="fw-medium">Online Appointment</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Call Duration</label>
                                                            <h6 class="fw-medium">1h 25mins</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Start Time</label>
                                                            <h6 class="fw-medium">09:25 AM</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">End Time</label>
                                                            <h6 class="fw-medium">10:50 AM</h6>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                               <div class="d-flex align-items-center justify-content-end">
                                                <a class="drop-down-btn" href="javascript:void(0)"><i class="fa-solid fa-chevron-up"></i></a>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
</button>
                                </div>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <h5 class="fw-medium mb-4">Participants</h5>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                <div class="col-12">
                                        <div class="row align-items-center">
                                            <div class="col-md-10">
                                                <div class="row ">
                                                    <div class="col-md-3">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Appointment Date & Time</label>
                                                            <h6 class="fw-medium">Dec 31 2024, 12:25 PM</h6>
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-3">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Type</label>
                                                            <h6 class="fw-medium">Online Appointment</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Call Duration</label>
                                                            <h6 class="fw-medium">1h 25mins</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Start Time</label>
                                                            <h6 class="fw-medium">09:25 AM</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">End Time</label>
                                                            <h6 class="fw-medium">10:50 AM</h6>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                               <div class="d-flex align-items-center justify-content-end">
                                                <a class="drop-down-btn" href="javascript:void(0)"><i class="fa-solid fa-chevron-up"></i></a>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                <div class="accordion-body">
                                    <h5 class="fw-medium mb-4">Participants</h5>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                <div class="col-12">
                                        <div class="row align-items-center">
                                            <div class="col-md-10">
                                                <div class="row ">
                                                    <div class="col-md-3">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Appointment Date & Time</label>
                                                            <h6 class="fw-medium">Dec 31 2024, 12:25 PM</h6>
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-3">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Type</label>
                                                            <h6 class="fw-medium">Online Appointment</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Call Duration</label>
                                                            <h6 class="fw-medium">1h 25mins</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">Start Time</label>
                                                            <h6 class="fw-medium">09:25 AM</h6>
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <label class="mb-2">End Time</label>
                                                            <h6 class="fw-medium">10:50 AM</h6>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                               <div class="d-flex align-items-center justify-content-end">
                                                <a class="drop-down-btn" href="javascript:void(0)"><i class="fa-solid fa-chevron-up"></i></a>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                <div class="accordion-body">
                                    <h5 class="fw-medium mb-4">Participants</h5>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row light-gray-bg align-items-center mb-2">
                                        <div class="col-md-4 my-2">
                                            <div class="form-group">
                                                <div class="user_inner prtpnts-user">
                                                    <img alt="Blackbag" src="https://project-assets-myblackbag-dev.s3.amazonaws.com/users/resized_images/00000/5f8f62a8a9ca-150X150.jpg">
                                                    <div class="user_info">
                                                        <h6 class="primary fw-medium m-0">John Doe</h6>
                                                        <p class="m-0">johndoe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Role</label>
                                                <h6 class="fw-medium">Patient</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <div class="form-group"> 
                                                <label class="mb-2">Duration</label>
                                                <h6 class="fw-medium">1h 25mins</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New-design -->
