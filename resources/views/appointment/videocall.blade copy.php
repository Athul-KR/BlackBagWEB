
<link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> @if(isset($seo['title']) && !empty($seo['title'])) {{$seo['title']  }} @else BlackBag  @endif</title>
<meta name='keywords' content="<?php echo (isset($seo['keywords']) && $seo['keywords']!= '') ? $seo['keywords'] : ''; ?>"/>
<meta name="description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : ''; ?> ">
<meta property="og:title" content="<?php echo (isset($seo['title']) && $seo['title']!= '') ? $seo['title'] : '{{ TITLE }}'; ?> ">
<meta property="og:description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : '{{ TITLE }}'; ?>">
<meta property="og:image" content="<?php echo (isset($seo['image']) && $seo['image']!= '') ? $seo['image'] : asset('images/og-img.png') ?>">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('js/meet/@zoom/videosdk-ui-toolkit/dist/videosdk-ui-toolkit.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=medication" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
    
    .row[_ngcontent-ng-c529306083] ,.mdc-linear-progress ,.mat-mdc-slider,.cdhhk-overlay-pane.mat-mdc-dialog-panel,.mat-mdc-tab-group.mat-mdc-tab-group-stretch-tabs>.mat-mdc-tab-header .mat-mdc-tab{
        display: none !important;
    }
/*
     .cdk-overlay-container:has(#cdk-overlay-0) .cdk-overlay-backdrop {
        display: none !important;
    }
    .cdk-overlay-container:has(#cdk-overlay-0){
        display: none !important;
    }
    .cdk-overlay-container:has(.cdk-overlay-connected-position-bounding-box) .cdk-overlay-backdrop,.cdk-overlay-container:has(#cdk-overlay-1) .cdk-overlay-backdrop {
        display: block !important;
    }
*/
/*
    .cdk-global-overlay-wrapper:has('app-audiokit') {
        display: none !important;;
    }
    
    .cdk-global-overlay-wrapper:has(app-audiokit) {
        display: none !important;;
    }
.cdk-global-overlay-wrapper:has(app-audiokit) {
        display: none !important;;
    }
*/
.advanced-margin[_ngcontent-ng-c1752840159] {
    display:none !important;}



    /* new */
    body {
        font-family: "Raleway", serif;
        font-feature-settings: 'lnum' 1 !important;
    }
    .self-view {
        width: 250px !important;
        max-width: 500px !important;
        position: absolute !important;
        z-index: 999;
        box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
        bottom: 70px;
        right: 15px;
        border-radius: 10px;
        /* background: #333; */
    }
    .self-view video {
        background: #000000 !important;
    }
    .user-view canvas {
        background: #333 !important;
        max-height: calc(100vh - 100px);
        object-fit: contain;

    }
    .videokit.ng-star-inserted {
        flex-direction: column !important;
        max-width: calc(100vw - 200px) !important;
        margin: 0 auto !important;
        max-height: calc(100vh - 100px);
    }
    /* .controlskit.ng-star-inserted {
        position: fixed;
        width: 100%;
        bottom: 0;
        background: #ffffff;
        margin-bottom: 0;
        height: 100px !important;
        margin-bottom: 0 !important;
    } */
    /* app-videokit {
        height: calc(100vh - 100px);
        display: block;
    } */
    button.ctrl-btn.mdc-fab.mat-mdc-fab-base.mat-mdc-fab.mat-primary.mat-mdc-button-base.ng-star-inserted {
        background: #000;
        margin-right: 10px;
        margin-left: 10px;
    }
    .mat-badge-content {
        background: #ffffff !important;
        border: 1px solid #dbdbdb !important;
        color: #000 !important;
    }
    .mat-badge-after .mat-badge-content {
        left: 90% !important;
        bottom: 85% !important;
    }
    uitoolkit-provider {
        height: 100vh;
        position: relative;
        display: block;
        background: #444444 !important;
    }
    .controlskit.ng-star-inserted {
        margin-bottom: 0 !important;
        position: fixed;
        bottom: 0;
    }
    .user-view {
        max-height: calc(100vh - 100px);
    }
    /* .ng-star-inserted canvas {
        background: #444444 !important;
    } */
    canvas#videosdk-uitoolkit-gallery-canvas {
        background: #444444 !important;
    }
    .hidden{
        display: none;
    }
    /* .ng-star-inserted {
        max-height: calc(100vh - 170px);
        margin: 0 auto;
    } */
    img.join-logo {
        width: 300px;
    }
    .join-page {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .join-sec {
        max-width: 800px;
        max-height: 500px;
    }
    button.btn.btn-primary {
        background: #000;
        color: #fff;
        padding: 10px;
        border-radius: 10px;
        border: 0;
        width: 180px;
        height: 50px;
        font-size: 18px;
        cursor: pointer;
    }
    .join-dtls-sec {
        padding-bottom: 15px;
        width: 100%;
    }
    .join-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px 0;
        color: #626262;
    }
    .join-label h4 {

    }
    .join-dtls p {
        margin: 0;
        font-weight: 500;
    }
    .profile-sec img {
        width: 35px;
        height: 35px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }
    .join-dtls {
        display: flex;
        flex-wrap: wrap;
        border: 1px solid #e3e3e3;
        padding: 10px;
        border-radius: 10px;
        width: 100%;
        max-width: 550px;
        margin: 30px auto;
    }
    .profile-sec {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .join-dtls-sec.join-dtls-sec-3 .join-label {
        padding-top: 20px;
        border-top: 1px solid #e3e3e3;
    }
    .join-label i {
        margin-right: 8px;
    }
    p.date-p {
        padding-left: 5px;
    }
    .gray {color: #8d8d8d;}
    img.join-logo.session-logo {
        position: fixed;
        bottom: 20px;
        right: 80px;
        z-index: 9;
        width: 125px;
    }
    .join-label h3 {
        margin: 0;
        font-weight: 500;
        color: #000;
        font-size: 25px;
    }
    /* div#videosdk-uitoolkit-avatarlist > div {
        padding: 10px;
    } */
    div#videosdk-uitoolkit-avatarlis mat-card.mat-mdc-card.mdc-card {
        left: 20px !important;
        bottom: 20px !important;
    }
    .notes-sec {
        position: absolute;
        z-index: 9999;
        right: 15px;
        bottom: 15px;
        width: 350px;
    }
    button.note-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 1px solid #5d5d5d;
        font-size: 22px;
        background: #333333;
        color: #fff;
        cursor: pointer;
        display: flex !important;
        align-items:center;
        justify-content: center;
    }
    .notesbox {
        padding: 15px;
        background: #fff;
        height: 100%;
        margin-bottom: 10px;
        border-radius: 10px;
        box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
        display: none;
    }

    .notesbox h3 {
        margin: 10px 0;
    }
    .note-footer {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-between;
        padding-top: 10px;
    }
    .note-footer textarea {
        width: 83%;
        min-width: 83%;
        min-height: 50px;
        border: 1px solid #dcdcdc;
    }
    button.send-btn {
        border: 1px solid #e3e3e3;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        font-size: 20px;
        background: #fff;
        cursor: pointer;
    }
    .note-txt {
        min-height: 150px;
    }
    .notesbox h4 {
        margin-top: 0;
        margin-bottom: 0;
    }
    .note-txt span {
        text-align: end;
        display: block;
        font-size: 12px;
        color: gray;
    }
    .note-txt p {
        font-size: 14px;
        line-height: 20px;
        font-weight: 500;
        color: #333;
        margin: 7px 0;
    }
    .note-txt {
        min-height: 150px;
        max-height: 600px;
        overflow-y: auto;
    }
    .note-txt div {
        margin-bottom: 10px;
    }
    .text-end {
        text-align: end;
    }
    .note-btn-sec {
        display: flex;
        justify-content: end;
    }
  /* Popup container */
    .popup {
        position: fixed;
        bottom: 80px;
        border-radius: 15px;
        left: 50%;
        min-width: 300px;
        height: auto;
        background-color: #000000;
        color: #fff;
        overflow-x: hidden;
        transition: 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
        transform: translateX(-50%);
    }
    /* Popup content */
    .popup-content {
        padding: 15px;
        text-align: center;
        display: flex;
        align-items: center;
    }
    .popup-content p {
        margin: 5px 10px;
        font-size: 14px;
    }
    /* Close button */
    /* .close-btn {
        position: absolute;
        top: -4px;
        right: 8px;
        font-size: 24px;
        cursor: pointer;
        color: #fff;
    } */
    button.accept-btn {
        background: green;
        color: #fff;
        border: 0;
        padding: 5px;
        border-radius: 4px;
        min-width: 70px;
        margin: 0 3px;
        cursor: pointer;
    }
    button.reject-btn {
        background: red;
        color: #fff;
        border: 0;
        padding: 5px;
        border-radius: 4px;
        min-width: 70px;
        margin: 0 3px;
        cursor: pointer;
    }
        div#gallery-vdieo-container canvas#videosdk-uitoolkit-gallery-canvas {
        max-height: calc(100vh - 100px);
    }
    p.nursetxt {
        max-width: 80%;
        margin: 20px auto 0;
        line-height: 25px;
    }
    .mat-mdc-menu-content {
        min-width: 140px;
        padding: 7px !important;
    }
    button.mat-mdc-menu-item.mat-mdc-focus-indicator {border-radius: 5px; text-align: center; margin: 0 !important;}
    button.mat-mdc-menu-item.mat-mdc-focus-indicator:hover {
        background: #333 !important;
        color: #fff;
    }
    .cdk-overlay-pane {
        margin-left: -50px;
        margin-bottom: 10px;
    }
    /* #gallery-vdieo-container.ng-star-inserted div:first-child {
        padding: 5px;
    } */
    .display-name-tag {
        font-size: 14px;
    }
    .avatar-content.active-user {
        outline: 0 !important;
    }
    #gallery-vdieo-container.ng-star-inserted .avatar-content {
        outline: 1px solid #7a7a7a !important;
    }
    .clinic-logo {
        display: flex;
        align-items: center;
        position: absolute;
        z-index: 99;
        bottom: 10px;
        left: 10px;
    }
    .clinic-logo img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .clinic-logo p {
        color: #fff;
    }
    .swal-footer{
        text-align: center !important;
    }
    .swal-button{
        background: #000 !important;
        border-color: #000 !important;
        min-width: 120px;
    }
    .swal2-cancel.swal2-styled:hover{
        background: transparent !important;
    }
    .swal2-actions button{
        min-width: 120px;
    }
    .swal-button--cancel,.swal2-cancel{
        background-color: #fff !important;
        border: 1px solid #000 !important;
        color: #000 !important;
    }
    .swal-button:focus{
        box-shadow: none !important;
    }
    .swal-button-container > button,.swal2-actions > button{
        transition: transform 0.2s ease-in;
    }
    .swal-button-container > button:hover,.swal2-actions > button:hover{
        transform: scale(1.05);
        transition: transform 0.2s ease-out;
    }
    .swal-text{
        text-align: center;
    }
    div:where(.swal2-container) .swal2-html-container{
        line-height: 1.7rem !important;
        font-family: "Raleway", sans-serif !important;
        font-weight: 500 !important;
        font-feature-settings: 'lnum' 1 !important;
    }
    div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-confirm) {
        border: 0;
        border-radius: .25em;
        background: initial;
        background-color: #000 !important;
        color: #fff !important;
        font-size: 1em;
    }
    .note-hd {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    a.chat-close {
        text-decoration: none;
        background: #444444;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        border-radius: 50%;
        font-size: 12px;
    }
    @media (max-width: 991px){
        .videokit.ng-star-inserted {
            max-width: 100% !important;
            border-radius: 0 !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100%;
        }
        .user-view canvas {border-radius: 0 !important;}
        .self-view{bottom: 75px !important}
        p.nursetxt {max-width: 100% !important;}
    }
    
    @media (max-width: 767px){
        button.ctrl-btn.mdc-fab.mat-mdc-fab-base.mat-mdc-fab.mat-primary.mat-mdc-button-base.ng-star-inserted {
            margin-right: 5px;
            margin-left: 5px;
        }
        img.join-logo.session-logo {
            top: 10px;
            right: 10px;
        }
        app-video-wrapper {
            display: flex;
            height: 100%;
            align-items: center;
            justify-content: center;
        }
        .display-name-tag {
            font-size: 12px;
        }
        .clinic-logo {
            top: 0;
            left: 10px;
            bottom: auto;
        }
        .clinic-logo img {
            width: 35px;
            height: 35px;
        }
        .clinic-logo p {font-size:14px;}
    }
    @media (max-width: 650px){
        img.join-logo.session-logo {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 9;
            width: 100px;
            bottom: auto;
        }
        .join-label h3 {
            font-size: 20px;
        }
        div#gallery-vdieo-container canvas#videosdk-uitoolkit-gallery-canvas {max-height: 100% !important;}
        
    }

    @media only screen and (max-width: 1024px) and (min-height: 1366px)  {
        .videokit.ng-star-inserted {
            max-width: 100% !important;
            border-radius: 0 !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100%;
        }
        .user-view canvas {border-radius: 0 !important;}
        .self-view{bottom: 75px !important}
    }
    @media only screen and (max-width: 1024px) and (min-height: 800px)  {
        .videokit.ng-star-inserted {
            max-width: 100% !important;
            border-radius: 0 !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100%;
        }
        .user-view canvas {border-radius: 0 !important;}
        .self-view{bottom: 75px !important}
    }
    @media (max-width: 520px){
        .controlskit.ng-star-inserted {
            justify-content: flex-start !important;
            left: 10px;
        }
        button.ctrl-btn {
            width: 40px !important;
            height: 40px !important;
            margin-right: 3px !important;
            margin-left: 3px !important;
        }
        .notes-sec {
            right: 10px;
            width: 340px;
        }
    }
    /* HEIGHT-RESPONSIVE */

    @media (max-height: 750px){
        .note-txt {
            min-height: 150px;
            max-height: 150px;
            overflow-y: auto;
        }
        .display-name-tag {
            font-size: 12px;
        }
    }
    @media (max-height: 640px){
        .note-txt {
            min-height: 150px;
            max-height: 150px;
            overflow-y: auto;
        }
        .notesbox {
            max-height: calc(100vh - 130px);
        }
        .display-name-tag {
            font-size: 12px;
        }
    }
</style>
   
            <div id="join-flow">
                <?php
                    $corefunctions = new \App\customclasses\Corefunctions;
                ?>
                <div class="join-page text-center">
                    <div class="join-sec">
                        <img src="{{ asset('frontend/images/logo.png')}}" class="img-fluid join-logo" alt="Logo">
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
                <p>{{$clinicDetails['name']}}</p>
            </div>
              <img src="{{ asset('frontend/images/videologo.png')}}" class="img-fluid join-logo session-logo" id="session-logo" alt="Logo">
            <div id='sessionContainer'>

                <div class="notes-sec" style="display:none;" id="notes-sec">
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
                    <div class="note-btn-sec">
                        <button class="note-btn" onclick="chatNotes()" id="chat-option"><i class="fa-solid fa-message"></i></button>
                    </div>
                    
                </div>
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
<script src="{{ asset('js/meet/@zoom/videosdk-ui-toolkit/index.js?v=2')}}" type="module"></script>
<script src="{{ asset('js/meet/scripts.js?v=2')}}" type="module"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

   <script src="{{ asset('js/sweetalert.js')}}"></script>
<script>
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
                      $('.btnsubmit').hide();
                      intervalId =setInterval(checkcallstatus, 3000);
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
