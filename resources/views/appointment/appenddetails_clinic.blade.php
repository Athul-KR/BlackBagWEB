<section class="mb-5 appointment-details">
    <div class="row">
        <div class="col-12">
            <div class="web-card appointment-card mb-4">
                <div class="row g-2">
                    <div class="col-12 col-xl-3">  
                        <div class="form-group border-r">
                            <div class="user_inner appnmt-user flex-column align-items-start gap-2">
                                <img alt="Blackbag" @if($patient->logo_path !='') src="{{($patient->logo_path)}}" @else src="{{asset('images/default_img.png')}}" @endif>
                                <div class="user_info">
                                    <h5 class="primary fw-medium m-0">{{$patient->user->first_name}}</h5>
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

                            {{--   <div class="d-flex ">
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

                            <div class="appointment-info"> 
                                <?php $patientphone = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $patientphone); ?>
                                <p class="fw-middle m-0 btn_inline"><span class="material-symbols-outlined">call</span> <?php echo $countryCode['country_code']. '    '.$patientphone ?></p>
                            </div>
                            <div class="appointment-info"> 
                                <?php $cleanEmail = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '',$patient->user->email); ?>
                                <a href="{{ url('patient/'.$patient->patients_uuid.'/details') }}" ><p class="fw-middle m-0 btn_inline"><span class="material-symbols-outlined">mail</span> {{$cleanEmail}}</p> </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-9 ps-xxl-3"> 
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group mb-2"> 
                                    <label class="fw-medium mb-1">Appointment Date & Time</label>
                                    <h6 class="fwt-bold mb-0"><?php echo $corefunctions->timezoneChange($appointment['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment['appointment_time'],'h:i A') ?></h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group mb-2"> 
                                    <label class="fw-medium mb-1">Type</label>
                                    <h6 class="fwt-bold mb-0">{{$appointmentTypes[$appointment['appointment_type_id']]['appointment_name']}}</h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group mb-2"> 
                                    <label class="fw-medium mb-1">Booked By</label>
                                    <h6 class="fwt-bold mb-0">{{$bookedBy}}</h6>
                                    <label class="fw-medium mb-1"><?php echo $corefunctions->timezoneChange($appointment['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment['created_at'],'h:i A') ?></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group mb-2"> 
                                    <label class="fw-medium mb-1">Clinician</label>
                                    <h6 class="fwt-bold mb-0">{{$clinicianName}}</h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                @if(!empty($participants))
                                <div class="form-group mb-2"> 
                                    <label class="fw-medium mb-1">Participants</label>
                                    <div class="users-sec">
                                        @foreach($participants as $participant)
                                            <?php
                                                $profileimage = '';
                                                if($participant['participant_type'] == 'patient'){
                                                    $profileimage = $corefunctions->resizeImageAWS($patientDetails[$participant['participant_id']]['user']['id'], $patientDetails[$participant['participant_id']]['user']['profile_image'], $patientDetails[$participant['participant_id']]['user']['first_name'], 180, 180, '1');
                                                    $name = $patientDetails[$participant['participant_id']]['user']['first_name'] ;
                                                    $redirect = 'patient/'.$patientDetails[$participant['participant_id']]['patients_uuid'].'/details';
                                                }else{
                                                    $profileimage = $corefunctions->resizeImageAWS($clinicUserDetails[$participant['participant_id']]['user']['id'], $clinicUserDetails[$participant['participant_id']]['user']['profile_image'], $clinicUserDetails[$participant['participant_id']]['user']['first_name'], 180, 180, '1');
                                                    $name = $clinicUserDetails[$participant['participant_id']]['user']['first_name'] ;
                                                    $redirect = 'user/'.$clinicUserDetails[$participant['participant_id']]['clinic_user_uuid'].'/details';
                                                }
                                            ?>
                                            <a href="{{url($redirect)}}" class="users-img">
                                                <img alt="Blackbag" class="thumb-user-img"@if($profileimage !='') src="{{($profileimage)}}" @else src="{{asset('images/default_img.png')}}" @endif alt="User" data-bs-toggle="tooltip" title="{{$name}}">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-12"> 
                                <div class="form-group"> 
                                    <label class="fw-medium mb-1">Appointment Notes</label>
                                    @if(!empty($appointmentNotes))
                                    <div class="d-flex flex-column">
                                        @foreach($appointmentNotes as $value)
                                        <h6 class="fw-medium"><?php echo $value->notes ?></h6>
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

    {{-- <div class="col-md-4">
        <div class="d-flex align-items-center justify-content-end btn_alignbox">
            @if($appointment['is_completed'] == '0' && $appointment['appointment_type_id'] == '1')
                @if(session()->get('user.userType') == 'patient')
                    <button onclick="joinMeet('{{$appointment['appointment_uuid']}}');" id="submitbtn"  class="btn btn-primary">Pay Now</button>
                @else 
                @if($appointment['appointment_type_id'] == '1' && ($appointment['deleted_at'] == '' ))
                    <a class="opt-btn opt-view border-0" target ="_blank" href="{{url('meet/'.$appointment['appointment_uuid'])}}" data-bs-toggle="tooltip" title="Start Video Call"><span class="material-symbols-outlined">videocam</span></a>
                    @endif
                @endif
            @endif
        </div>
    </div> --}}

   <?php /*  <div class="row">
        <div class="col-12 col-lg-3">
            <div class="web-card mb-4">
                <h5 class="fw-medium mb-4">Appointment Details</h5>
                <div class="form-group mb-4"> 
                    <label class="mb-2">Booked On</label>
                    <h6 class="fw-medium"><?php echo $corefunctions->timezoneChange($appointment['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment['created_at'],'h:i A') ?></h6>
                </div>

            </div>
        </div>
    </div> */ ?>

    <div class="row" style="display:none;">
        <div class="col-12">
            <div class="web-card mb-4 prev-appntmnts">
                <h5 class="fw-medium mb-4">Previous Appointments</h5>
                <div>
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        @if(!empty($previousAppointments))
                            @foreach($previousAppointments as $pak => $pav)
                                <div class="accordion-item">
                                    <div class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"  data-bs-target="#appendvideocalldetails_{{$pav['id']}}" aria-expanded="true" aria-controls="appendvideocalldetails_{{$pav['id']}}">
                                            <div class="col-12">
                                                <div class="row align-items-center">
                                                    <div class="col-md-10">
                                                        <div class="row ">
                                                            <div class="col-md-3">
                                                                <div class="form-group"> 
                                                                    <label class="fw-medium mb-1">Appointment Date & Time test</label>
                                                                    <h6 class="fwt-bold mb-0"><?php echo $corefunctions->timezoneChange($pav['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($pav['appointment_time'],"h:i A") ?></h6>
                                                                </div>
                                                            </div>  
                                                            <div class="col-md-3">
                                                                <div class="form-group"> 
                                                                    <label class="fw-medium mb-1">Type</label>
                                                                    <h6 class="fwt-bold mb-0">{{$appointmentTypes[$pav['appointment_type_id']]['appointment_name']}}</h6>
                                                                </div>
                                                            </div> 
                                                            @if(!empty($pav['videocall']))
                                                            <div class="col-md-2">
                                                                <div class="form-group"> 
                                                                    <label class="fw-medium mb-1">Call Duration</label>
                                                                    <h6 class="fwt-bold mb-0">
                                                                        @if($pav['videocall']->duration > 0 && $pav['videocall']->duration != '' )
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
                                                                    </h6>
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <div class="form-group"> 
                                                                    <label class="fw-medium mb-1">Start Time</label>
                                                                    <h6 class="fwt-bold mb-0">@if(isset($pav['videocall']->call_started) && $pav['videocall']->call_started != '') <?php echo $corefunctions->timezoneChange($pav['videocall']->call_started,"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($pav['videocall']->call_started,'h:i A','0') ?> @else -- @endif</h6>
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-2">
                                                                <div class="form-group"> 
                                                                    <label class="fw-medium mb-1">End Time</label>
                                                                    <h6 class="fwt-bold mb-0">@if(isset($pav['videocall']->call_ended) && $pav['videocall']->call_ended != '') <?php echo $corefunctions->timezoneChange($pav['videocall']->call_ended,"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($pav['videocall']->call_ended,'h:i A','0') ?> @else -- @endif</h6>
                                                                </div>
                                                            </div> 
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if(session()->get('user.userType') != 'patient')   
                                                        <div class="col-md-2 text-end">
                                                            <div class="d-flex align-items-center justify-content-end">
                                                                <a class="drop-down-btn" href="javascript:void(0)" onclick="appendVideoCallDetails('{{$pav['id']}}');" id="arrow_btn_rot{{ $pav['id'] }}"><i class="fa-solid fa-chevron-up"></i></a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                    <div id="oldappendvideocalldetails_{{$pav['id']}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                        
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
            </div>
        </div>
    </div> 





    <div class="col-12 mb-xl-5 mb-3">

<div class="web-card h-100 mb-5">
    <div class="row align-items-center">
        {{-- <div class="col-sm-8 text-center text-sm-start">
            <h4 class="mb-md-0">Appointment Records</h4>
        </div> --}}
        {{-- <div class="col-sm-4 text-center text-sm-end">

            <a href="" class="btn btn-primary">Create Appointment</a>

        </div> --}}
 
                    @include('appointment.headermenus', ['patientId' => $patient->user_id,'key' => $appointment['appointment_uuid']])

                        
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
                     <img class="my-5" src="{{asset('images/invite-img.png')}}" class="img-fluid" alt="Blackbag">
                     <h1 class=""><strong>Participant Invited!</strong></h1>
                     <p>A email invite has been sent to the participant</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function submitOrderbacku() {
    var patientID = '{{$patient->user_id}}';
    
    if ($("#ordertestform").valid()) {

        $("#submitbpbtn").addClass('disabled');
        let formdata = $("#ordertestform").serialize();
        $.ajax({
            url: '{{ url("labs/submit")}}',
            type: "post",
            data: {
                'formdata': formdata,
                'patientID': patientID,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    // $('#ordertestform')[0].reset();
                    // Clear hidden inputs
                    $('#category_id').val('');
                    $('#subcategory_id').val('');
                    $('#description').val('');
                    $('#category_label').text('Category');
                    $('#subcategory_label').text('Sub Category');
                    $('#search_li_subcategory').empty().append(`
                        <li class="dropdown-item">
                            <div class="dropview_body profileList justify-content-center">
                                <p>No records found</p>
                            </div>
                        </li>
                    `);
                    
                    $('#key').val(data.key);
                    getPreviewList(data.key);
                } else {
                     swal("Error!", data.message, "error");
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    } else {
        if ($('.error:visible').length > 0) {
            setTimeout(function() {

            }, 500);
        }
    }
}
</script>






