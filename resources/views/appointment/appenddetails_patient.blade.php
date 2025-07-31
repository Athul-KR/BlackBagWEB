<section class="mb-5 appointment-details">
    <div class="row">
        <div class="col-12">
            <div class="web-card appointment-card mb-4 min-height-auto">
                <div class="row g-2">
                    <div class="col-12 col-xl-3">  
                        <div class="form-group border-end">
                            <div class="user_inner appnmt-user flex-column align-items-start gap-2">
                                <img alt="Blackbag" @if($patient->logo_path !='') src="{{($patient->logo_path)}}" @else src="{{asset('images/default_img.png')}}" @endif>
                                <div class="user_info">
                                    <h5 class="primary fwt-bold m-0">{{$patient->user->first_name}}</h5>
                                </div>
                            </div>
                            <div class="appointment-info d-flex flex-row gap-3">
                                
                                <div class="form-group"> 
                                    <small class="d-block gray mb-1">{{$patient->age}} | {{ $patient->gender == '1' ? 'Male' : ($patient->gender == '2' ? 'Female' : 'Other') }}</small>
                                </div>
                                <!-- <div class="form-group gender"> 
                                    <p class="fw-medium gray mb-0">
                                        {{ $patient->gender == '1' ? 'Male' : ($patient->gender == '2' ? 'Female' : 'Other') }}
                                    </p>
                                </div> -->
                            </div>

                            {{--   <div class="d-flex">
                              <span>
                                    @if($patient->gender == '1')
                                        <i class="fa-solid fa-mars"></i>
                                    @elseif($patient->gender == '2')
                                        <i class="fa-solid fa-venus"></i>
                                    @else
                                        <i class="fa-solid fa-genderless"></i>
                                    @endif
                                </span> 
                            </div> --}}

                            <div class="appointment-info mb-2"> 
                                <?php $cleanEmail = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '',$patient->user->email); ?>
                                <small class="fw-middle m-0 d-flex align-items-center"><span class="material-symbols-outlined me-2"> mail</span> {{$cleanEmail}} </small>
                            </div>
                            <div class="appointment-info mb-2"> 
                                <?php $patientphone = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $patientphone); ?>
                                <a href="{{ url('patient/'.$patient->patients_uuid.'/details') }}" ><small class="fw-middle m-0 btn_inline d-flex align-items-center"><span class="material-symbols-outlined me-2">call</span> <?php echo $countryCode['country_code']. '    '.$patientphone ?> </small> </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-9 ps-xxl-3"> 
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group history-box mb-2"> 
                                    <p class="mb-1 gray fw-middle">Appointment Date & Time</p>
                                    <h6 class="fwt-bold mb-0"><?php echo $corefunctions->timezoneChange($appointment['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment['appointment_time'],'h:i A') ?></h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group history-box mb-2"> 
                                    <p class="mb-1 gray fw-middle">Type</p>
                                    <h6 class="fwt-bold mb-0">{{$appointmentTypes[$appointment['appointment_type_id']]['appointment_name']}}</h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group history-box mb-2"> 
                                    <p class="mb-1 gray fw-middle">Booked By</p>
                                    <h6 class="fwt-bold mb-0">{{$bookedBy}}</h6>
                                    <small class="fw-medium mb-1"><?php echo $corefunctions->timezoneChange($appointment['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment['created_at'],'h:i A') ?></small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                @if(count($participants) > 0)
                                    <div class="form-group history-box mb-2"> 
                                        <p class="mb-1 gray fw-middle">Participants</p>
                                        <div class="users-sec">
                                            @foreach($participants as $participant)
                                                <?php
                                                    $profileimage = '';
                                                    if($participant['participant_type'] == 'patient'){
                                                        $profileimage = $corefunctions->resizeImageAWS($patientDetails[$participant['participant_id']]['user']['id'], $patientDetails[$participant['participant_id']]['user']['profile_image'], $patientDetails[$participant['participant_id']]['user']['first_name'], 180, 180, '1');
                                                        $name = $patientDetails[$participant['participant_id']]['user']['first_name'] ;
                                                    }else{
                                                        $profileimage = $corefunctions->resizeImageAWS($clinicUserDetails[$participant['participant_id']]['user']['id'], $clinicUserDetails[$participant['participant_id']]['user']['profile_image'], $clinicUserDetails[$participant['participant_id']]['user']['first_name'], 180, 180, '1');
                                                        $name = $clinicUserDetails[$participant['participant_id']]['user']['first_name'] ;
                                                    }
                                                ?>
                                                <a href="javascript:void(0);" class="users-img">
                                                    <img alt="Blackbag" class="thumb-user-img"@if($profileimage !='') src="{{($profileimage)}}" @else src="{{asset('images/default_img.png')}}" @endif alt="User" data-bs-toggle="tooltip" title="{{$name}}">
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group history-box mb-2"> 
                                        <p class="mb-1 gray fw-middle">Participants</p>
                                        <div class="d-flex flex-column">
                                            <h6 class="fw-medium">No participants found!</h6>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12"> 
                                <div class="form-group history-box"> 
                                    <p class="mb-1 gray fw-middle">Appointment Notes</p>
                                  
                                    @if(($appointmentNotes->isNotEmpty()))
                                    <div class="d-flex flex-column">
                                        @foreach($appointmentNotes as $value)
                                        <p class="fw-medium"><?php echo $value->notes ?></p>
                                        @endforeach
                                    </div>
                                    @elseif(isset($appointment['notes']) && $appointment['notes'] != '')
                                    <div class="d-flex flex-column">
                                        <h6 class="fw-medium"><?php echo $appointment['notes'] ?></h6>
                                    </div>
                                    @else
                                    <div class="d-flex flex-column">
                                        <h6 class="fw-medium">No notes added!</h6>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
   

    <div class="row">
        <div class="col-12">
            <div class="web-card mb-4 prev-appntmnts">
                <h5 class="fwt-bold mb-4">Previous Appointments</h5>
                <div id="previousappopatient">
                    
                </div>
            </div>
        </div>
    </div> 
</section>

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
        </div>
    </div>
</div>

<div class="modal fade" id="resendInvite" tabindex="-1" aria-labelledby="resendInviteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div> -->
            <div class="modal-body text-center">
                <div>
                     <img alt="Blackbag" class="my-5" src="{{asset('images/invite-img.png')}}" class="img-fluid">
                     <h1 class=""><strong>Participant Invited!</strong></h1>
                     <p>A email invite has been sent to the participant</p>
                </div>
            </div>
        </div>
    </div>
</div>