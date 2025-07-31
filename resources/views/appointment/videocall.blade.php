<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Cross-Origin-Opener-Policy" content="same-origin">
<meta http-equiv="Cross-Origin-Embedder-Policy" content="require-corp">
<link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    
<title>@if(isset($seo['title']) && !empty($seo['title'])){{$seo['title']}}@else BlackBag  @endif</title>

<meta name='keywords' content="<?php echo (isset($seo['keywords']) && $seo['keywords']!= '') ? $seo['keywords'] : ''; ?>"/>
<meta name="description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : ''; ?> ">
<meta property="og:title" content="<?php echo (isset($seo['title']) && $seo['title']!= '') ? $seo['title'] : '{{ TITLE }}'; ?> ">
<meta property="og:description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : '{{ TITLE }}'; ?>">
<meta property="og:image" content="<?php echo (isset($seo['image']) && $seo['image']!= '') ? $seo['image'] : asset('images/og-img.png') ?>">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="stylesheet" href="{{ asset('css/videochat/video.css')}}?v=<?php echo time(); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('js/meet/@zoom/videosdk-ui-toolkit/dist/videosdk-ui-toolkit.css')}}?v=<?php echo time(); ?>">


<!-- soft-notes -->

<!-- jQuery (Required for Morris.js) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

<!-- Include Raphael.js (required for Morris.js) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>

<!-- Include Morris.js -->
<script src="https://cdn.jsdelivr.net/npm/morris.js@0.5.0/morris.min.js"></script>

<!-- Morris.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.css">

<style>
    #uikit-footer-share-screen{
        display: none !important;
    }
    </style>
</head>
    <body>
            <div id="join-flow">
                <?php
                    $corefunctions = new \App\customclasses\Corefunctions;
                ?>
                <div class="join-page text-center">
                    <div class="join-sec">
                        <img src="{{ asset('frontend/images/logo.png')}}" class="join-logo" alt="Logo">
                        
                        <div class="join-dtls">
                             
                            <div class="join-dtls-sec join-dtls-sec-2">
                                <div class="join-label">
                                   
                                    <h3>You have an appointment with </h3>
                                </div>
                                <div class="profile-sec">
                                    <img src="{{$appoinmentToLogo}}?v=<?php echo time()?>" alt="Patient" id="patient-image" >
                                    <p>{{$appoinmentTo}}</p>
                                </div>
                            </div>

                            @if($isExpired)
                            <div class="join-dtls-sec join-dtls-sec-3">
                                <div class="join-label">
                                    <i class="fa-regular fa-clock"></i>
                                    <p>Appointment Expired</p>
                                </div>
                                <div class="profile-sec">
                                @if($usertype == 'patient')
                                    <p>This appointment time has expired. Please contact your clinic to reschedule a new appointment.</p>
                                @else
                                <p>This appointment time has expired. Please reschedule with the patient.</p>
                                @endif                                
                                </div>
                            </div>

                            @else
                            <div class="join-dtls-sec join-dtls-sec-3">
                                <div class="join-label">
                                    <i class="fa-regular fa-clock"></i>
                                    <p>Your appointment will start at </p>
                                </div>
                                <div class="profile-sec">
                                    <p class="date-p"><?php echo $corefunctions->timezoneChange($appointment->appointment_date,"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment->appointment_time,'h:i A') ?></p>
                                </div>
                            </div>
                            @endif  
                            
                        </div>

                        <div>
<!--                             <button onclick="getVideoSDKJWT()" class="btn btn-primary btnsubmit">Join Session</button>-->
                            @if($startAppoinment == 1 &&  !($isExpired))
                            <p class="primary mb-3" id="joindenied">Join the Appointment by clicking Join Session</p>
                            <button onclick="acceptcall()" class="btn btn-primary btnsubmit">Join Session</button>
                            <p class="nursetxt" id="appnurse"></p>
                            @elseif($overtime !=1)
                            <p>Once the appointment is available, the <strong>Start</strong> button will be enabled for the video.</p>
                            
                            @endif
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="clinic-logo notes-sec" style="display:none !important;">
                <?php $corefunctions = new \App\customclasses\Corefunctions;
                    $clinicDetails['logo'] = ($clinicDetails['logo'] != '') ? $corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");?>
                <img src="{{$clinicDetails['logo']}}?v=<?php echo time()?>" class="img-fluid join-logo left-session-logo" id="session-logo" alt="Logo">
                <p class="mb-0">{{$clinicDetails['name']}}</p>
            </div>


              <img src="{{ asset('frontend/images/videologo.png')}}" class="img-fluid join-logo session-logo" id="session-logo" alt="Logo">
            
            <div class="container-flex expand-screen notes-sec" id="mainContainer"  style="display:none;">
                <div id='sessionContainer' class="video-container"> 

                    <input type="hidden" value="" name="videocallparticipantID" id="videocallparticipantID">
                   
                </div>
                <div id="slide-popup" class="popup join-popup" style="display:none;">
                    <div class="popup-content">
                            <!-- <span id="close-popup" class="close-btn">&times;</span> -->
                        <div class="user_inner">
                              <img src="{{ asset('images/nurse6.png') }}" alt="patient">
                              <div class="user_info">
                                  <h6 class="primary fw-medium m-0 pb-1">Patient Waiting</h6>
                                  <p class="m-0" ><span class="primary fw-medium" id="slide-message-user"></span><span id="slide-message"></span></p>
                              </div>
                            </div>
                            <div class="btn_alignbox ms-md-3 mt-md-0 mt-3">
                              <button type="button" class="slide-close">Close</button>

                            </div>
                        </div>
                    </div>
                    <div id="left-popup" class="popup" style="display:none;">
                        <div class="popup-content">
                            <!-- <span id="close-popup" class="close-btn">&times;</span> -->
                            <p id="popup-message">Fetching data...</p>
                            <button class="accept-btn" onclick="acceptusercall()">Accept</button>
                            <button class="reject-btn" onclick="rejectusercall()">Reject</button>
                            <input type="hidden" value="" name="iswaiting" id="iswaiting">
                        </div>
                    </div>
                <div class="form-container" id="rightPanel"  >
                    <div class="details-wrapper">
                        <div class="outer-wrapper box-wrapper">
                            <div class="patient_inner">
                            @if(isset($patientDetails))
                                <img  src="{{$patientDetails['logo_path']}}?v=<?php echo time()?>">
                                <div class="d-flex flex-column">
                                    <div class="patient_info">
                                        <h6 class="primary m-0 fw-medium">{{$patientDetails['first_name']}} {{$patientDetails['last_name']}}</h6>
                                        <p class="m-0">{{ $patientDetails['age']}} | @if($patientDetails['gender'] == '1') Male @elseif($patientDetails['gender'] == '2') Female @else Other @endif</p>
                                    </div>
<!--
                                    <div class="d-flex justify-content-bewteen gap-2 mt-1">
                                        <span class="device-info">Devices : 2</span>
                                        <a class="scribe"><img src="{{ asset('frontend/images/pen.png')}}" class="scribe-pen"></a>
                                    </div>
-->
                                </div>  
                                @endif
                            </div>

                            <div>
                                <div class="btn_alignbox justify-content-end mb-2">
                                    <button type="button" class="expand-btn primary d-lg-block d-none" onclick="multiexpand()"><span class="material-symbols-outlined">open_in_full</span></button>
                                    <button type="button" class="expand-btn cls-btn primary d-lg-none d-block"><span class="material-symbols-outlined">close</span></button>
                                </div>

                               @include('appointment.ordermenus', ['patientId' => $patientDetails['user_id'],'key' => $appointment->appointment_uuid])

                            </div>
                            
                        </div>
                        <div class="tab-scroller py-3">
                            <ul class="nav nav-pills gap-2 d-flex flex-nowrap" id="pills-tab" role="tablist">
                               <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-vitals-tab" data-bs-toggle="pill" data-bs-target="#pills-vitals" type="button" role="tab" onclick="getAppointmentMedicalHistory('vitals')" aria-controls="pills-vitals" aria-selected="true">
                        <span class="material-symbols-outlined">ecg_heart</span> Vitals
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-labs-tab" data-bs-toggle="pill" data-bs-target="#pills-labs" onclick="getAppointmentMedicalHistory('labs')" type="button" role="tab" aria-controls="pills-labs" aria-selected="false">
                        <span class="material-symbols-outlined">experiment</span> Labs
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-imaging-tab" data-bs-toggle="pill" data-bs-target="#pills-imaging" onclick="getAppointmentMedicalHistory('imaging')" type="button" role="tab" aria-controls="pills-imaging" aria-selected="false">
                        <span class="material-symbols-outlined">lab_profile</span> Imaging
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-medications-tab" data-bs-toggle="pill" onclick="getAppointmentMedicalHistory('medications')" data-bs-target="#pills-medications" type="button" role="tab" aria-controls="pills-medications" aria-selected="false">
                        <span class="material-symbols-outlined">pill</span> Medications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-notes-tab" data-bs-toggle="pill" onclick="getAppointmentMedicalHistory('notes')" data-bs-target="#pills-notes" type="button" role="tab" aria-controls="pills-notes" aria-selected="false">
                        <span class="material-symbols-outlined">draft</span> Notes
                    </button>
                </li>
 <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-history-tab" data-bs-toggle="pill" onclick="getAppointmentMedicalHistory('history')" data-bs-target="#pills-history" type="button" role="tab" aria-controls="pills-history" aria-selected="false">
                        <span class="material-symbols-outlined">history</span> History
                    </button>
                </li>
                            </ul>

                        </div>
                       <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade tabcls show active" id="appointmentspatients" role="tabpanel" aria-labelledby="pills-home-tab">  

                                    </div>

                                    <div class="tab-pane fade tabcls" id="pills-vitals" role="tabpanel" aria-labelledby="pills-vitals-tab">

                                    </div> 

                                    <div class="tab-pane fade tabcls" id="pills-labs" role="tabpanel" aria-labelledby="pills-labs-tab">

                                    </div>

                                    <div class="tab-pane fade tabcls" id="pills-imaging" role="tabpanel" aria-labelledby="pills-imaging-tab">

                                    </div>

                                    <div class="tab-pane fade tabcls" id="pills-medications" role="tabpanel" aria-labelledby="pills-medications-tab">

                                    </div>

                                    <div class="tab-pane fade tabcls" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">

                                    </div>

                                    <div class="tab-pane fade tabcls" id="pills-history" role="tabpanel" aria-labelledby="pills-historys-tab">

                                    </div>

                                    <div class="tab-pane fade tabcls" id="pills-previousappointments" role="tabpanel" aria-labelledby="pills-previousappointments-tab">

                                    </div>

                                    <div class="tab-pane fade tabcls" id="filecabinetpatients" role="tabpanel" aria-labelledby="pills-filecabinet-tab">

                                    </div>
                                    <input type="hidden" name="key" id="key" >
                                </div>

                             </div>  
                        </div>
                </div>

              @if($usertype != 'patient')
              <button id="toggleButton" type="button" class="btn open-btn toggle-btn notes-sec" style="display:none !important;">
                        <span class="material-symbols-outlined"> home_storage</span>
                    </button>
                @endif
   

<script src="{{ asset('js/meet/@zoom/videosdk-ui-toolkit/dist/videosdk-ui-toolkit.min.umd.js?v=2')}}" ></script>
        <script>
            window.uitoolkit = window.UIToolkit; 
        </script>
<script src="{{ asset('js/meet/scripts.js')}}?v=<?php echo time(); ?>" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('js/sweetalert.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Daterangepicker CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- Moment.js -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

<!-- Daterangepicker JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<link rel="stylesheet" type="text/css" href="{{ asset('css/virtual-select.min.css') }}">
	<script type="text/javascript" src="{{ asset('js/virtual-select.min.js') }}"></script>

<!-- soft-notes -->
  
@include('appointment.tabdetails', ['patientId' => $patientDetails['user_id'],'key' => $appointment->appointment_uuid,'viewType'=>'video'])
    
<script>
 



@if(!empty($videoCallDetails->room_id))
        const name = @json($videoCallDetails->room_id);
    @else
        const name = null; // or some default value
    @endif
const particpantID = @json($particpantID);
    @if(!empty($videoCallDetails->room_key))
const roomkey = @json($videoCallDetails->room_key);
     @else
        const roomkey = null; // or some default value
    @endif
const userName = @json($username);

const roleparam = @json($role);
const usertype = @json($usertype);
   
</script>


<script>
 function showPreloader(parmID,className='') {
          var loaderimgPath = "{{ asset('images/loader.gif') }}";
          $('#' + parmID).html('<div class="text-center '+ className +'"><img src="' + loaderimgPath + '" class="loaderImg"></div>');
        }
    $(document).ready(function () {
        $("#toggleButton").click(function () {
            $("#mainContainer").toggleClass("active");
            $('#pills-vitals-tab').trigger('click');
        });

        $("#closeButton").click(function () {
            $("#mainContainer").removeClass("active");
        });
    });

    function multiexpand(){
        $('.expand-screen').toggleClass('expanded'); 
    }

    
    document.querySelector('.cls-btn')?.addEventListener('click', () => {
    const container = document.querySelector('.container-flex');

    // Add a 'closing' class to start animation
    container.classList.add('closing');

    setTimeout(() => {
        container.classList.remove('active', 'closing');
    }, 300);
});

    // document.addEventListener("DOMContentLoaded", function () {
    //         var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    //         var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    //             return new bootstrap.Tooltip(tooltipTriggerEl);
    //         });
    //     });

        // $(document).ready(function() {
        //     $('#loader').on('shown.bs.modal', function () {
        //     setTimeout(function() {
        //         $('#loader').modal('hide'); 
        //         $('#SuccessLoader').modal('show'); 
        //     }, 1000);
        //     });
        // });


        function toggleLabel(input) {
          const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
          $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
        }

        $(document).ready(function() {

          // Initialize label state for each input
          $('input').each(function() {
            toggleLabel(this);
          });

          // Handle label toggle on focus, blur, and input change
          $(document).on('focus blur input change', 'input, textarea', function() {
            toggleLabel(this);
          });

          // Handle the datetime picker widget appearance by re-checking label state
          $(document).on('click', '.bootstrap-datetimepicker-widget', function() {
            const input = $(this).closest('.time').find('input');
            toggleLabel(input[0]);
          });

          // Trigger label toggle when modal opens
          $(document).on('shown.bs.modal', function(event) {
            const modal = $(event.target);
            modal.find('input, textarea').each(function() {
              toggleLabel(this);
              // Force focus briefly to trigger label in case of any timing issues
              $(this).trigger('focus').trigger('blur');
            });
          });

          // Reset label state when modal closes
          $(document).on('hidden.bs.modal', function(event) {
            const modal = $(event.target);
            modal.find('input, textarea').each(function() {
              $(this).parent().find('.float-label').removeClass('active');
            });
          });
        });


</script>



<script>

var socket = null; // Initialize socket variable

// Function to connect the WebSocket
function connectSocket() {
    const socketUrl = "{{env('WSS_SOCKET_END_POINT')}}";
    socket = new WebSocket(socketUrl);
const participantKey = "{{ Session::get('user.userSessionID') }}"; // Participant ID

    // WebSocket event listeners
    socket.onopen = function(event) {
        console.log('WebSocket connection opened.');
        // Define the JSON payload to send
        console.log('WebSocket connection established.');
        console.log("{{Session::get('socket.chats_participant_uuid')}}");

        const payload = {
            "action": "sendmessage",
            "data": {
                "event": "connect",
                "participant_uuid": participantKey
            }
        };
        const jsonPayload = JSON.stringify(payload);
        socket.send(jsonPayload);
    socket.onmessage = handleMessage;
    };

    socket.onerror = function(error) {
        console.error('WebSocket error:', error);
    };

    // Reconnect if the WebSocket connection is closed unexpectedly
    socket.onclose = function(event) {
        console.log("WebSocket connection closed unexpectedly. Reconnecting...");
       // setTimeout(connectSocket, 3000); // Reconnect after 3 seconds
    };

    // Handle incoming messages
    /*socket.onmessage = function(event) {
        console.log('Message received:', event.data);
        var jsonObj = JSON.parse(event.data);
        console.log(jsonObj)
        var eventValue = jsonObj.message;
        console.log(eventValue)
        $("#typing_message_" + jsonObj.joborderkey).html(eventValue)
    };*/
}
// Function to handle incoming messages
function handleMessage(event) {
    console.log('Message received:', event.data);
    var jsonObj = JSON.parse(event.data);
    console.log(jsonObj)
    var eventValue = jsonObj.message;
    var eventValuekey = jsonObj.messageuser;
   
    if(jsonObj.event =='acceptcallrequest' ){
       checkcallstatus();
    }
    if(jsonObj.event =='rejectcallrequest' ){
       $('.nursetxt').html('<b>You can\'t join this call.</b><br/>Someone in the call denied your request to join');
    }
    if(jsonObj.event =='waitingroom'){
         // Dynamically set the URL for the "Join Call" button
        const joinCallUrl = "{{url('meet/')}}/"+jsonObj.aptkey; // Assuming the URL comes from the response

        // Attach onclick event to the button after the AJAX response
        $('#joinCallBtn').click(function() {
            window.open(joinCallUrl, "_blank");
        });
        
      //  $('#iswaiting').val(jsonObj.participant_uuid);
           showPopup(eventValue,eventValuekey);
        
    }
    
    //$("#typing_message_" + jsonObj.joborderkey).html(eventValue)
}
// Call connectSocket to initiate the connection
connectSocket();

 function showSlidePopup(message,eventValuekey) {
        const popupMessage = document.getElementById('slide-message');
        const popupMessage1 = document.getElementById('slide-message-user');
        const popup = document.getElementById('slide-popup');
        popupMessage.textContent = message || 'Fetching data...';
        popupMessage1.textContent = eventValuekey || '';
        popup.style.display='block'; // Slide out
        // popup.style.left='50%'; // Slide out
    }  
// Function to send a typing started event
function SendSocket() {
   // alert("pushed");
    // Define the JSON payload to send
     const participantKey = "{{ Session::get('user.userSessionID') }}";  // Get the participant ID
   
    const payloadnew = {
        "action": "sendmessage",
        "data": {
            event: 'waitingroom',
            participant_uuid: participantKey,
            roomkey: roomkey,
        }
    };
    socket.send(JSON.stringify(payloadnew));
}


    let intervalId = '';
//if(roleparam == 0){
//      
//    console.log(intervalId);
//}

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function sendnote(){
    if($('#note').val()!='' && isEnterPressed){
        $.ajax({
            url: '{{ url("/addnote") }}',
            type: "post",
            data: {
              'roomkey': roomkey,
                'note': $('#note').val(),
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('#note').val('');
                isEnterPressed = false;
                $('.note-txt').html(data.view);

            },
            error: function(xhr) {
               
                handleError(xhr);
            }
          });
    }
}
function sendnotesubmit(){
    if($('#note').val()!='' ){
        $.ajax({
            url: '{{ url("/addnote") }}',
            type: "post",
            data: {
              'roomkey': roomkey,
                'note': $('#note').val(),
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('#note').val('');
                isEnterPressed = false;
                $('.note-txt').html(data.view);

            },
            error: function(xhr) {
               
                handleError(xhr);
            }
          });
    }
}
function acceptcall() {
    var button = $('.btnsubmitn'); // Make sure to replace with the actual button ID or class
    button.prop('disabled', true);  // Disable the button
    // connectSocket();
   
      $.ajax({
        url: '{{ url("/acceptcall") }}',
        type: "post",
        data: {
          'roomkey': roomkey,
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data.status == 0){
                swal("Error!", data.message, "error");
            }else{
                if(data.isdoctor =='1'){
                 
                    getVideoSDKJWT();
                    $('.notes-sec').show();
                    acceptcallcheck();
                   
                    
                  }else{
                      $('#appnurse').html('Your request to join the meeting has been sent. You will be admitted once the host approves your request. Please wait patiently.');
                     // alert("SendSocket");
                      SendSocket();
                      $('.btnsubmit').hide();
                      //intervalId =setInterval(checkcallstatus, 3000);
                  }
            }
          
         if(data.error =='1'){
            window.location.reload();
          }
        },
        error: function(xhr) {
               
            handleError(xhr);
        },
      });
}
    
// Get the leave button element by its ID
  const leaveButton = document.getElementById('leave-button');

 


function sessionend() {
      $.ajax({
        url: '{{ url("/videocallend") }}',
        type: "post",
        data: {
          'roomkey': roomkey,
          'videocallparticipantID': particpantID,
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
           clearInterval(intervalId);
             window.location.reload();
            console.log(intervalId);
            $('.notes-sec').hide();
        },
        error: function(xhr) {
               
            handleError(xhr);
        }
      });
}
    
// Function to send a typing started event
    function SendSocketForAcceptReject(event) {
       
        // Define the JSON payload to send
         const participantKey = "{{ Session::get('user.userSessionID') }}";  // Get the participant ID

        const payloadnewx = {
            "action": "sendmessage",
            "data": {
                event: event,
                participant_uuid: participantKey,
                roomkey: roomkey,
            }
        };
        socket.send(JSON.stringify(payloadnewx));
    }
function acceptusercall() {
    
      $.ajax({
        url: '{{ url("/acceptcall") }}',
        type: "post",
        data: {
            'act': 'accept',
            'roomkey': roomkey,
            'participantID': $('#iswaiting').val(),
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            $('#iswaiting').val('0');
            const popup = document.getElementById('left-popup');
            popup.style.display='none'; // Slide out
            SendSocketForAcceptReject('acceptcallrequest');
        },
        error: function(xhr) {
               
            handleError(xhr);
        }
      });
}
function rejectusercall() {
    
      $.ajax({
        url: '{{ url("/acceptcall") }}',
        type: "post",
        data: {
          'act': 'reject',
          'roomkey': roomkey,
          'participantID': $('#iswaiting').val(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          $('#iswaiting').val('0');
            const popup = document.getElementById('left-popup');
             popup.style.display='none'; // Slide out
            SendSocketForAcceptReject('rejectcallrequest');
        },
        error: function(xhr) {
               
            handleError(xhr);
        }
      });
}
 function showPopup(message,eventValuekey) {
        const popupMessage = document.getElementById('popup-message');
        const popup = document.getElementById('left-popup');
        popupMessage.textContent = eventValuekey+message || 'Fetching data...';
        popup.style.display='block'; // Slide out
        // popup.style.left='50%'; // Slide out
    } 
function acceptcallcheck() {
    const popup = document.getElementById('left-popup');
      $.ajax({
        url: '{{ url("/acceptcallcheck") }}',
        type: "post",
        data: {
          'roomkey': roomkey,
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data.iswaiting == '1'){
                 showPopup(data.message,''); // Update popup message on success
                $('#iswaiting').val(data.waitingID);
            }else if(data.iswaiting == '0'){
                $('#iswaiting').val('0');
                const popup = document.getElementById('left-popup');
                popup.style.left = '-300px'; // Slide out
            }
         
        
        },
        error: function(xhr) {
               
            handleError(xhr);
        }
      });
}
function checkcallstatus() {
      $.ajax({
        url: '{{ url("/acceptcallcheck") }}',
        type: "post",
        data: {
          'act': 'status',
          'roomkey': roomkey,
          'videocallparticipantID': particpantID,
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
           
            if(data.is_waiting == '0' && data.is_reject == '0'){
                getVideoSDKJWT();
                clearInterval(intervalId);
                $('.notes-sec').show();
                $('#appnurse').html('');
            }else if(data.is_reject == '1'){
                 $('#appnurse').html('<b>You can\'t join this call.</b><br/>Someone in the call denied your request to join');
                 $('#joindenied').html('');
                 
                //window.location.reload();
            }
         
        
        },
        error: function(xhr) {
               
            handleError(xhr);
        }
      });
}
    
    function handleError(xhr) {
    if (xhr.status === 419) {
        // Session expired logic
        const response = JSON.parse(xhr.responseText);
        if (response.message) {
            swal({
                icon: 'error',
                title: 'Session Expired',
                text: 'Your session has expired. Please log in again.',
                buttons: {
                    confirm: {
                        text: 'OK',
                        value: true,
                        visible: true,
                        className: 'btn-danger'
                    }
                }
            }).then(() => {
                // Redirect to the login page
                window.location.href = '/login';  // Explicit login redirect instead of reloading
            });
        }
    } 
}

function chatNotes() {
  var notes = document.getElementById("noteBox");
  if (notes.style.display === "block") {
    notes.style.display = "none";
  } else {
    notes.style.display = "block";
  }
}
    window.onload = function() {
    var img = document.getElementById('patient-image');
    img.src = img.src.split('?')[0] + "?v=" + new Date().getTime();  // Cache busting
  };
</script>
<script>
    function closeNotes() {
        document.getElementById("noteBox").style.display = "none";
    }
</script>







</body>
</html>