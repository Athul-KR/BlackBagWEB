<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Cross-Origin-Opener-Policy" content="same-origin">
<meta http-equiv="Cross-Origin-Embedder-Policy" content="require-corp">
<link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
<title>@if(isset($seo['title']) && !empty($seo['title'])){{$seo['title']}}@else BlackBag  @endif</title>
<meta name='keywords' content="<?php echo (isset($seo['keywords']) && $seo['keywords']!= '') ? $seo['keywords'] : ''; ?>"/>
<meta name="description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : ''; ?> ">
<meta property="og:title" content="<?php echo (isset($seo['title']) && $seo['title']!= '') ? $seo['title'] : '{{ TITLE }}'; ?> ">
<meta property="og:description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : '{{ TITLE }}'; ?>">
<meta property="og:image" content="<?php echo (isset($seo['image']) && $seo['image']!= '') ? $seo['image'] : asset('images/og-img.png') ?>">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('js/meet/@zoom/videosdk-ui-toolkit/dist/videosdk-ui-toolkit.css?v=3')}}">
    <link rel="stylesheet" href="{{ asset('css/videochat/video.css?v=3')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=medication" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />




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
                             <!-- <div class="join-dtls-sec join-dtls-sec-1">
                                <div class="join-label">
                                    <i class="fa-solid fa-user"></i>
                                    <p>Patient</p>
                                </div>
                                <div class="profile-sec">
                                <img src="{{$patientDetails['logo_path']}}" alt="Patient">
                                <p>{{$patientDetails['name']}}</p>
                                </div>
                            </div>  -->
                            <div class="join-dtls-sec join-dtls-sec-2">
                                <div class="join-label">
                                    <!-- <i class="fa-solid fa-user-doctor"></i> -->
                                    <h3>You have an appointment with </h3>
                                </div>
                                <div class="profile-sec">
                                    <img src="{{$appoinmentToLogo}}" alt="Patient" id="patient-image" >
                                    <p>{{$appoinmentTo}}</p>
                                </div>
                            </div>
                            <div class="join-dtls-sec join-dtls-sec-3">
                                <div class="join-label">
                                    <i class="fa-regular fa-clock"></i>
                                    <p>Your appointment will start at </p>
                                </div>
                                <div class="profile-sec">
                                    <p class="date-p"><?php echo $corefunctions->timezoneChange($appointment->appointment_date,"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment->appointment_time,'h:i A') ?></p>
                                </div>
                            </div>
                            
                        </div>

                        <div>
<!--                             <button onclick="getVideoSDKJWT()" class="btn btn-primary btnsubmit">Join Session</button>-->
                            @if($startAppoinment == 1 )
                            <p class="gray" id="joindenied">Join the Appointment by clicking Join Session</p>
                            <button onclick="acceptcall()" class="btn btn-primary btnsubmit">Join Session</button>
                            <p class="nursetxt" id="appnurse"></p>
                            @elseif($overtime !=1)
                            <p>Once the appointment is available, the <strong>Start</strong> button will be enabled for the video.</p>
                            
                            @endif
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="clinic-logo">
                <?php $corefunctions = new \App\customclasses\Corefunctions;
                    $clinicDetails['logo'] = ($clinicDetails['logo'] != '') ? $corefunctions->getAWSFilePath($clinicDetails['logo']) : asset("images/default_clinic.png");?>
                <img src="{{$clinicDetails['logo']}}" class="img-fluid join-logo left-session-logo" id="session-logo" alt="Logo">
                <p class="mb-0">{{$clinicDetails['name']}}</p>
            </div>


              <img src="{{ asset('frontend/images/videologo.png')}}" class="img-fluid join-logo session-logo" id="session-logo" alt="Logo">
            
                <div id='sessionContainer' class="video-container test"> 

                <!-- <div class="notes-sec" style="display:none;" id="notes-sec">
                        <div class="notesbox" id="noteBox">
                            <div class="note-hd">
                                <h4 class="mt0">Notes</h4>
                                <a class="chat-close" href="javascript:void(0)" id="chat-close-btn" onclick="closeNotes()">X</a>
                            </div>
                            <div class="note-txt">
                                @foreach($appointmentNotes as $apn)
                                <div>
                                    <span><?php echo $corefunctions->timezoneChange($apn->created_at,"h:i A") ?> ,<?php echo $corefunctions->timezoneChange($apn->created_at,'m/d/Y') ?></span>
                                    <p>{{nl2br($apn->notes)}}</p>
                                </div>
                                @endforeach
                            </div>
                            <div class="note-footer ">
                                <textarea id="note" name="note" rows="" cols=""></textarea>
                                <button class="send-btn" onclick="sendnotesubmit()"><i class="fa-solid fa-paper-plane"></i></button>
                            </div>
                        </div>
                        <div class="note-btn-sec" style="display:none;">
                            <button class="note-btn" onclick="chatNotes()" id="chat-option"><i class="fa-solid fa-message"></i></button>
                        
                        </div>

                        
                    </div> -->
                    

                    <input type="hidden" value="" name="videocallparticipantID" id="videocallparticipantID">
                    <div id="left-popup" class="popup" style="display:none;">
                        <div class="popup-content">
                            <!-- <span id="close-popup" class="close-btn">&times;</span> -->
                            <p id="popup-message">Fetching data...</p>
                            <button class="accept-btn" onclick="acceptusercall()">Accept</button>
                            <button class="reject-btn" onclick="rejectusercall()">Reject</button>
                            <input type="hidden" value="" name="iswaiting" id="iswaiting">
                        </div>
                    </div>
                </div>

               
     



        
    
<script>
    
const name = @json($videoCallDetails->room_id);
const particpantID = @json($particpantID);
const roomkey = @json($videoCallDetails->room_key);
const userName = @json($username);

const roleparam = @json($role);
const usertype = @json($usertype);
   
</script>

<script src="{{ asset('js/meet/@zoom/videosdk-ui-toolkit/dist/videosdk-ui-toolkit.min.umd.js?v=2')}}" ></script>
        <script>
            window.uitoolkit = window.UIToolkit; 
        </script>
<script src="{{ asset('js/meet/scripts.js?v=3')}}" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('js/sweetalert.js')}}"></script>
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
    
    if(jsonObj.event =='waitingroom'){
         // Dynamically set the URL for the "Join Call" button
        const joinCallUrl = "{{url('meet/')}}/"+jsonObj.aptkey; // Assuming the URL comes from the response

        // Attach onclick event to the button after the AJAX response
        $('#joinCallBtn').click(function() {
            window.open(joinCallUrl, "_blank");
        });
        
            showSlidePopup(eventValue);
       
    }
    
    //$("#typing_message_" + jsonObj.joborderkey).html(eventValue)
}
// Call connectSocket to initiate the connection
connectSocket();


// Function to send a typing started event
function SendSocket() {
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
let isEnterPressed = false;
document.getElementById('note').addEventListener('keydown', function(event) {
    if (event.key === 'Enter' && !event.shiftKey && !isEnterPressed) {
        isEnterPressed = true;
        event.preventDefault(); // Prevents a new line in the textarea
        console.log("Enter key pressed!");
        sendnote(); // Calls the function to send the note
    }
    // Reset isEnterPressed after the event cycle
    else if (event.key === 'Enter') {
        isEnterPressed = false;
    }
});
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

  // Add a click event listener to the leave button
  leaveButton.addEventListener('click', () => {
    console.log("Leave button clicked");

    // Call the function to leave the session (you can implement your custom logic here)
    alert("test")
  });


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
            $('#notes-sec').hide();
        },
        error: function(xhr) {
               
            handleError(xhr);
        }
      });
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
            popup.style.display='block'; // Slide out
            popup.style.left = '-300px'; // Slide out
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
            popup.style.left = '-300px'; // Slide out
        },
        error: function(xhr) {
               
            handleError(xhr);
        }
      });
}
function showPopup(message) {
    const popupMessage = document.getElementById('popup-message');
    const popup = document.getElementById('left-popup');
    popupMessage.textContent = message || 'Fetching data...';
    popup.style.display='block'; // Slide out
    popup.style.left='50%'; // Slide out
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
                 showPopup(data.message); // Update popup message on success
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