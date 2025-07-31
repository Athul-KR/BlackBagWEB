<!DOCTYPE html>
<html lang="en">

<head>
  
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
  <link rel="stylesheet" href="{{ asset('css/videochat/index.css')}}?v=10" />
  <link rel="stylesheet" href="{{ asset('css/videochat/join.css')}}?v=10" />
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=medication" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    body{
      background: #fff !important;
    }
    section.join-pg {
    text-align: center;
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: center;
    height: 100vh;
    margin-top: 0;
    background: #fff;
    position: absolute;
}
    img.hd-logo {
    max-width: 200px;
    height: auto;
}
.appntmnt-dtls h1 {
    font-size: 25px;
    font-weight: 700;
    margin-bottom: 20px;
}
.appntmnt-dtls h3 {
    font-size: 20px;
    font-weight: 700;
    color: #333;
}
.appntmnt-dtls p {
    font-size: 14px;
    color: #727272;
    font-weight: 600;
}
.appntmnt-dtls {
    margin: 20px 0;
}
    .pwrd-sec {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 50px;
}
.hello-sec {
    margin: 70px 0;
}
.hello-sec h3 {
    font-size: 16px;
    color: #a0a0a0;
    font-weight: 500;
    margin-bottom: 20px;
}
span {
    font-size: 24px;
    margin-left: 5px;
    color: #333;
    font-weight: 400;
}
.hello-sec p {
    color: #333;
    font-weight: 600;
    font-size: 14px;
}
a.btn.join-nw {
    background: #0aaef0;
    color: #fff;
    font-size: 15px;
    height: 50px;
    font-weight: 600;
    width: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin: 0 auto;
    padding-top: 13px;
}
.pwrd-sec p {
    margin-bottom: 0;
    margin-right: 16px;
    font-size: 13px;
    color: #a0a0a0;
}
.pwrd-sec img {
    width: 40px;
}
.vst-dtl {
    border: 1px solid #d9d9d9;
    padding: 10px;
    max-width: 400px;
    margin: 0 auto;
}
.vst-dtl h3 {
    font-size: 16px;
    /* font-weight: 600; */
    color: #868686;
}
.vst-dtl p {
    margin-bottom: 0;
    color: #555555;
    font-size: 15px;
}
p.msg-p {
    max-width: 600px;
    text-align: center;
    margin: 0 auto;
    margin-bottom: 20px;
    font-size: 13px;
    color: #555;
}
.participant.main {
    position: relative;

}
.vdo-cntrls {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 10px 0;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
}
.vdo-cntrls a {
    margin: 0 5px;
}
.cntrl-btns {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #1293fb;
    color: #fff;
    padding: 5px;
    font-size: 18px;
    box-shadow: rgba(0, 0, 0, 0.2) 0px 8px 24px;
}
.pwrd-sec {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 50px;
    position: absolute;
    bottom: 20px;
}  
@media (max-width: 500px) {
    section.join-pg {
    height: 100%;
    position: relative;
    display: block;
}
    .appntmnt-dtls h1 {font-size: 20px;}
    .hello-sec {
        margin: 0;
}
    .pwrd-sec {
        position: relative;
}

div.participant.main {
    height: calc(100vh - 450px);
}

div.participant.main>video {
    height: calc(100vh - 450px);
}
.pwrd-sec img {
    width: 30px;
}
.cntrl-btns {
    width: 40px;
    height: 40px;
    font-size: 15px;
    }

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
        margin: 0 auto;
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
        /* position: absolute; */
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
        color: #000;
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

.modal.drawer {
  display: flex !important;
  pointer-events: none;
}
.modal.drawer {
    top: 25px;
    left: -10px;
    height: auto;
}
.modal.drawer .modal-dialog {
  margin: 0px;
  display: flex;
  flex: auto;
  transform: translate(25%, 0);
}
.modal.drawer .modal-dialog .modal-content {
  border: none;
  border-radius: 0px;
}
.modal.drawer .modal-dialog .modal-content .modal-body {
  overflow: auto;
}
.modal.drawer.show {
  pointer-events: auto;
}
.modal.drawer.show * {
  pointer-events: auto;
}
.modal.drawer.show .modal-dialog {
  transform: translate(0, 0);
}
.modal.drawer.right-align {
  flex-direction: row-reverse;
}
.modal.drawer.left-align:not(.show) .modal-dialog {
  transform: translate(-25%, 0);
}
.user-img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 2px solid #fff;
    border-radius: 50%;
    padding: 5px;
}
.user-img img {
    height: 130px;
    width: 130px;
    object-fit: cover;
    border-radius: 50%;
}
img.participant-user-img {
    width: 60px;
    height: 60px;
    position: absolute;
    object-fit: cover;
    border-radius: 50%;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}
button.cntrol-btn span.flex-shrink-0 {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
}
button.cntrol-btn span.flex-shrink-0 svg {
    width: 20px;
    height: 20px;
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
        img.join-logo { max-width: 250px !important; margin: 0 auto; }
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
        .app-video-wrapper {
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
        .clinic-logo {
            bottom:auto;
            top: 10px;
        }
        img.join-logo.session-logo {
            position: fixed;
            top: 10px;
            right: 80px;
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
</head>


<body class="waitingtojoin">
   <div id="modals">
      <div class="modal fade" id="select-mic" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="select-mic-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="select-mic-label">Please select your microphone source</h5>
            </div>
            <div class="modal-body" style="text-align: center">
              <select style="width: 100%"></select>
              <svg focusable="false" viewBox="0 0 100 100" aria-hidden="true" height="100" width="100" style="margin: 10px 0">
                <defs>
                  <clipPath id="level-indicator">
                    <rect x="0" y="100" width="100" height="100" />
                  </clipPath>
                </defs>
                <path fill="rgb(220, 220, 220)" d="m52 38v14c0 9.757-8.242 18-18 18h-8c-9.757 0-18-8.243-18-18v-14h-8v14c0 14.094 11.906 26 26 26v14h-17v8h42v-8h-17v-14c14.094 0 26-11.906 26-26v-14h-8z"></path>
                <path fill="rgb(220, 220, 220)" d="m26 64h8c5.714 0 10.788-4.483 11.804-10h-11.887v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h11.887c-1.016-5.517-6.09-10-11.804-10h-8c-6.393 0-12 5.607-12 12v40c0 6.393 5.607 12 12 12z"></path>
                <path fill="#080" clip-path="url(#level-indicator)" d="m52 38v14c0 9.757-8.242 18-18 18h-8c-9.757 0-18-8.243-18-18v-14h-8v14c0 14.094 11.906 26 26 26v14h-17v8h42v-8h-17v-14c14.094 0 26-11.906 26-26v-14h-8z"></path>
                <path fill="#080" clip-path="url(#level-indicator)" d="m26 64h8c5.714 0 10.788-4.483 11.804-10h-11.887v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h11.887c-1.016-5.517-6.09-10-11.804-10h-8c-6.393 0-12 5.607-12 12v40c0 6.393 5.607 12 12 12z"></path>
              </svg>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Apply</button>
            </div>
          </div>
        </div>
      </div>
        <div class="modal fade" id="select-mic-flip" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="select-mic-flip-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="select-mic-flip-label">Please select your microphone source</h5>
            </div>
            <div class="modal-body" style="text-align: center">
              <select style="width: 100%"></select>
              <svg focusable="false" viewBox="0 0 100 100" aria-hidden="true" height="100" width="100" style="margin: 10px 0">
                <defs>
                  <clipPath id="level-indicator">
                    <rect x="0" y="100" width="100" height="100" />
                  </clipPath>
                </defs>
                <path fill="rgb(220, 220, 220)" d="m52 38v14c0 9.757-8.242 18-18 18h-8c-9.757 0-18-8.243-18-18v-14h-8v14c0 14.094 11.906 26 26 26v14h-17v8h42v-8h-17v-14c14.094 0 26-11.906 26-26v-14h-8z"></path>
                <path fill="rgb(220, 220, 220)" d="m26 64h8c5.714 0 10.788-4.483 11.804-10h-11.887v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h11.887c-1.016-5.517-6.09-10-11.804-10h-8c-6.393 0-12 5.607-12 12v40c0 6.393 5.607 12 12 12z"></path>
                <path fill="#080" clip-path="url(#level-indicator)" d="m52 38v14c0 9.757-8.242 18-18 18h-8c-9.757 0-18-8.243-18-18v-14h-8v14c0 14.094 11.906 26 26 26v14h-17v8h42v-8h-17v-14c14.094 0 26-11.906 26-26v-14h-8z"></path>
                <path fill="#080" clip-path="url(#level-indicator)" d="m26 64h8c5.714 0 10.788-4.483 11.804-10h-11.887v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h11.887c-1.016-5.517-6.09-10-11.804-10h-8c-6.393 0-12 5.607-12 12v40c0 6.393 5.607 12 12 12z"></path>
              </svg>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Apply</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="select-camera" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="select-camera-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="select-camera-label">Please select your camera</h5>
            </div>
            <div class="modal-body" style="text-align: center">
              <select style="width: 100%"></select>
              <video autoplay muted playsInline style="margin: 10px 0; width: 60%"></video>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Apply and Join</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="select-camera-flip" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="select-camera-flip-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="select-camera-flip-label">Please select your camera</h5>
            </div>
            <div class="modal-body" style="text-align: center">
              <select style="width: 100%"></select>
              <video autoplay muted playsInline style="margin: 10px 0; width: 60%"></video>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Apply</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="join-room" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="join-room-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="join-room-label">Video Chat</h5>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label id="room-name-label" for="room-name">Room Name</label>
                <input id="room-name" class="form-control" type="text" />
              </div>
              <div class="form-group">
                <label id="screen-name-label" for="screen-name">User Name</label>
                <input id="screen-name" class="form-control" type="text" value="Micheal"/>
              </div>
              <div class="alert alert-warning" role="alert">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark">Change Microphone and Camera</button>
              <button type="button" class="btn btn-primary">Join</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="show-error" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="show-error-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="show-error-label">Error</h5>
            </div>
            <div class="modal-body">
              <div class="alert alert-warning" role="alert">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   
  <div class="container-fluid">
 <!-- Local video display -->


    <div class="row joinsecalign" id="room" style="display:none;">
    <div id="active-participant" class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-8 col-xl-8" style="text-align: center">
      <!-- <div id="active-participant" class="col-12 col-xs-12 col-sm-9 col-md-9 col-lg-9 col-xl-10" style="text-align: center"> -->
        <div class="participant main" >
          <video  autoplay playsinline muted></video>
          <div id="user-image-<?php echo $loggineduserdetails['user_uuid']; ?>" class="user-img" style="display:none;">
            <img src="<?php echo $loggineduserdetails['profile_image']; ?>" alt="User Image" />
        </div>
             
        </div>
      
      </div>
      <div id="participants" class="col-12 col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-2 p0" style="text-align: center;display:none;">
      <p class="thub-msg">Click video thumbnail to switch between video streams.</p>
    </div>
      
        
    </div>
      
      <div class="join-page text-center" id="join-div">
                  
                      <?php
                    $corefunctions = new \App\customclasses\Corefunctions;
                ?>
               
                    <div class="join-sec">
                        <img src="{{ asset('frontend/images/logo.png')}}" class="join-logo" alt="Logo">
                        <div class="join-dtls">
                            
                            <div class="join-dtls-sec join-dtls-sec-2">
                                <div class="join-label">
                                    <!-- <i class="fa-solid fa-user-doctor"></i> -->
                                    <h3>You have an appointment with </h3>
                                </div>
                                <div class="profile-sec">
                                    <img src="{{$userdetails['logo_path']}}" alt="Patient" id="patient-image" >
                                    <p>{{$userdetails['user']['first_name']}}</p>
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

                          <div class="hello-sec">
                       

                            <p id="btnsubmit"></p>
                            <p  class="doctorwaiting" style="display:none;">Your request to join the meeting has been sent. You will be admitted once the host approves your request. Please wait patiently.</p>
                       
<!--                             <button onclick="getVideoSDKJWT()" class="btn btn-primary btnsubmit">Join Session</button>-->
                            @if($startappoinment == 1 )
                              <span class="doctorwaitingbtn">
                            <p class="primary" id="joindenied">Join the Appointment by clicking Join Session</p>
                            <button onclick="joinNow()" class="btn btn-primary btnsubmit">Join Session</button>
                           
                              </span>
                            @elseif($overtime !=1)
                            <p>Once the appointment is available, the <strong>Start</strong> button will be enabled for the video.</p>
                            
                            @endif
                            
                            
                        </div>
                    </div>
                       
                      
                   
                </div>
    

    <div class="row" id="room-settings" style="display:none;">
      <div class="vdo-footr">
      
              <div class="vdo-cntrls">
                <a class="cntrl-btns hasaudio" href="javascript:void(0)" id="button-audio"><i class="fas fa-microphone-alt"></i></a>
                 <a class="cntrl-btns hasvideo" href="javascript:void(0)" id="button-video"><i class="fas fa-video"></i></a>
                  <a class="cntrl-btns hasvideo" href="javascript:void(0)" id="button-settings"><i class="fa fa-ellipsis-v"></i></a>
            
                <div class="options-sec" style="display:none;" id="source-options">
                  <ul>
                    <li><a href="javascript:void(0)" id="video-source"><span><i class="fas fa-video"></i></span> Video Source </a></li>
                    <li> <a href="javascript:void(0)" id="audio-source"><span><i class="fas fa-microphone-alt"></i></span> Audio Source </a></li>
                    <li><a href="javascript:void(0)" onclick="toggleFullScreen()" id="full-screen"><span><i class="fas fa-expand"></i></span> View Full Screen </a></li>
                  </ul>
                    
                    
                  </div>
                  @if($usertype == 'nurse' || $usertype == 'patient')
                    <a class="cntrl-btns call-dscnct" href="javascript:void(0)" id="leave-room" ><i class="fas fa-phone"></i></a>
                 @else 
                   <a class="cntrl-btns call-dscnct" href="javascript:void(0)" id="leave-call" style="display:none;"><i class="fas fa-phone"></i></a>

                  <div class="options-sec" style="display:none;" id="leave-options">
                    <ul>
                        <li><a href="javascript:void(0)" id="leave-room"><span><i class="fas fa-phone-slash"></i></span> End Call </a></li>
                        <li><a href="javascript:void(0)" id="leave-room-all"><span><i class="fas fa-phone-slash"></i></span> End Call for all</a></li>
                    </ul>
                  </div>
                  @endif
                <input type="hidden" name="video_username" id="video_username" value="<?php echo $loggineduserdetails['profile_image']; ?>" />
        
                  <input type="hidden" name="showaudiosource" id="showaudiosource" value="1" />
              </div>
      </div>
                
            
    </div>
<div id="modals">
    <div class="modal fade" id="select-mic" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="select-mic-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="select-mic-label">Please select your microphone source</h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    <select style="width: 100%"></select>
                    <svg focusable="false" viewBox="0 0 100 100" aria-hidden="true" height="100" width="100" style="margin: 10px 0">
                        <defs>
                            <clipPath id="level-indicator">
                                <rect x="0" y="100" width="100" height="100" />
                            </clipPath>
                        </defs>
                        <path fill="rgb(220, 220, 220)" d="m52 38v14c0 9.757-8.242 18-18 18h-8c-9.757 0-18-8.243-18-18v-14h-8v14c0 14.094 11.906 26 26 26v14h-17v8h42v-8h-17v-14c14.094 0 26-11.906 26-26v-14h-8z"></path>
                        <path fill="rgb(220, 220, 220)" d="m26 64h8c5.714 0 10.788-4.483 11.804-10h-11.887v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h11.887c-1.016-5.517-6.09-10-11.804-10h-8c-6.393 0-12 5.607-12 12v40c0 6.393 5.607 12 12 12z"></path>
                        <path fill="#080" clip-path="url(#level-indicator)" d="m52 38v14c0 9.757-8.242 18-18 18h-8c-9.757 0-18-8.243-18-18v-14h-8v14c0 14.094 11.906 26 26 26v14h-17v8h42v-8h-17v-14c14.094 0 26-11.906 26-26v-14h-8z"></path>
                        <path fill="#080" clip-path="url(#level-indicator)" d="m26 64h8c5.714 0 10.788-4.483 11.804-10h-11.887v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h12.083v-4h-12.083v-4h11.887c-1.016-5.517-6.09-10-11.804-10h-8c-6.393 0-12 5.607-12 12v40c0 6.393 5.607 12 12 12z"></path>
                    </svg>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Apply</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="select-camera" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="select-camera-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="select-camera-label">Please select your camera</h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    <select style="width: 100%"></select>
                    <video autoplay muted playsInline style="margin: 10px 0; width: 60%"></video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Apply and Join</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="join-room" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="join-room-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="join-room-label">Video Chat</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label id="room-name-label" for="room-name">Room Name</label>
                        <input id="room-name" class="form-control" type="text" />
                    </div>
                    <div class="form-group">
                        <label id="screen-name-label" for="screen-name">User Name</label>
                        <input id="screen-name" class="form-control" type="text" />
                    </div>
                    <div class="alert alert-warning" role="alert">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark">Change Microphone and Camera</button>
                    <button type="button" class="btn btn-primary">Join</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="show-error" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="show-error-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="show-error-label">Error</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <div class="pwrd-sec">
        <div class="clinic-logo">
                <?php $corefunctions = new \App\customclasses\Corefunctions;
                    $clinicdetails['logo'] = ($clinicdetails['logo'] != '') ? $corefunctions->getAWSFilePath($clinicdetails['logo']) : asset("images/default_clinic.png");?>
                <img src="{{$clinicdetails['logo']}}" class="img-fluid join-logo left-session-logo" id="session-logo" alt="Logo">
                <p>{{$clinicdetails['name']}}</p>
            </div>
     </div>
  
    <script>
      var roomkey = '<?php echo $videocalldetails->room_key; ?>';
      var appointmentkey = '<?php echo $appointment->appointment_uuid; ?>';
      var usertype = '<?php echo $usertype; ?>';
      var participationkey = '<?php echo $loggineduserdetails['user_uuid']; ?>';
      var baseurl = "{{env('APP_URL')}}meet/";
     var userImages = @json($participantimages);
     var DEFAULTIMG = '<?php echo DEFAULTIMG; ?>';
        
       

    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="{{asset('js/videochat/uservideo.js')}}?v=<?php echo time(); ?>"></script>
    
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
        setTimeout(connectSocket, 3000); // Reconnect after 3 seconds
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
       checkVideoCallStatus();
    }
    if(jsonObj.event =='rejectcallrequest' ){
       $('.doctorwaiting').html('<b>You can\'t join this call.</b><br/>Someone in the call denied your request to join');
    }
    if(jsonObj.event =='waitingroom'){
         // Dynamically set the URL for the "Join Call" button
        const joinCallUrl = "{{url('meet/')}}/"+jsonObj.aptkey; // Assuming the URL comes from the response

        // Attach onclick event to the button after the AJAX response
        $('#joinCallBtn').click(function() {
            window.open(joinCallUrl, "_blank");
        });
        
        if (isElementVisible('#participants')) {
            showPopup(eventValue,eventValuekey);
            const popupx = document.getElementById('slide-popup');
            popupx.style.display='none'; // Slide out
        
        }else{
            showSlidePopup(eventValue,eventValuekey);
        }
        
    }
    
    //$("#typing_message_" + jsonObj.joborderkey).html(eventValue)
}

// Call connectSocket to initiate the connection
connectSocket();


// Function to send a typing started event
function SendSocket() {
    alert("pushed");
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
    function isElementVisible(element) {
        var $el = $(element);
        return $el.is(":visible");
    }
          var videoStatusTimer = null;   
         var videoInterval = 5000;
          var isUserWaiting=0;
          $(document).ready(function() {
              if (videoStatusTimer !== null) return;
              
              
              if (navigator.userAgent.indexOf("Firefox") != -1) {
                $("#audio-source").hide();
                $("#showaudiosource").val('0');
             }
              
              //setInterval(checkCallDisconnect, 2000);

              $( "body" ).dblclick(function() {
                  toggleFullScreen();
              });
              
              $("#button-settings").click(function () {
                $("#leave-call").addClass("call-dscnct");
                $("#leave-call").html('<i class="fas fa-phone"></i>');
                $("#leave-call").removeClass("call-close");
                $("#leave-options").hide();
                  
                if ($("#button-settings").hasClass("no-video")) {
                    
                } else {
                    if (!document.fullscreenElement &&    // alternative standard method
              !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {
                        $("#full-screen").html('<span><i class="fas fa-expand"></i></span> View Full Screen');
                    }else{
                        $("#full-screen").html('<span><i class="fas fa-expand"></i></span> Exit Full Screen');
                    }
                    
                    if ($("#button-settings").hasClass("btn-flipped")) {
                        $("#button-settings").removeClass("btn-flipped");
                        $("#button-settings").html('<i class="fas fa-times"></i>');
                        $("#button-settings").addClass("flip-close");
                        $("#source-options").show();
                    } else {
                        $("#button-settings").addClass("btn-flipped");
                        $("#button-settings").html('<i class="fa fa-ellipsis-v"></i>');
                        $("#button-settings").removeClass("flip-close");
                        $("#source-options").hide();
                    }
                }
            });
          });
        function joinNow(){
             $.ajax({
                url: '{{ url("meet/joincall") }}',
                type: "post",
                dataType: "json",
                data: {
                    'roomkey': roomkey,
                  '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                   
                    if(data.status == 0){
                        swal("Error!", data.message, "error");
                    }else{
                      if( data.callStarted == 1){
                          
                          setTimeout(function(){
                              $('body').removeClass('waitingtojoin');
                              $('#join-div').hide();
                              $('#room').show();
                              $('#room-settings').show();
                              $('#leave-call').show();
                              $('#participants').show();
                              $('#active-participant').attr('class','col-12 col-xs-12 col-sm-9 col-md-9 col-lg-9 col-xl-10');
                              $('#btnsubmit').click();
                              checkVideoCallStatus();
                          },2000);
                          
                        
                      }else{
                          
                          isUserWaiting =1;
                          $('.doctorwaitingbtn').hide();
                          $('.doctorwaiting').show();
                          SendSocket();
                      }
                        videoStatusTimer = setInterval(function() {
                            //checkVideoCallStatus();
                          }, videoInterval);
                    }
                }
                
            });
        }
        function checkVideoCallStatus(){
             $.ajax({
                url: '{{ url("meet/checkVideoCallStatus") }}',
                type: "post",
                dataType: "json",
                data: {
                    'roomkey': roomkey,
                  '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    
                   if(data.isCompleted == 0){
                      
                      if(data.hasWaiting == 1 ){
                          showPopup(data.waitingMessage);
                      }
                       if(isUserWaiting == 1 && data.callStarted == 0 ){
                          $('.doctorwaiting').html('<b>You can\'t join this call.</b><br/>Someone in the call denied your request to join');
                      }
                    if(isUserWaiting == 1 && data.callStarted == 1){
                        setTimeout(function(){
                              $('body').removeClass('waitingtojoin');
                              $('#join-div').hide();
                              $('#leave-room').show();
                            
                              $('#room').show();
                              $('#room-settings').show();
                              $('#participants').show();
                              $('#active-participant').attr('class','col-12 col-xs-12 col-sm-9 col-md-9 col-lg-9 col-xl-10');
                              $('#btnsubmit').click();
                            isUserWaiting =0;
                          },2000);
                    }
                   }else{
                       window.location.href="{{url('meet/completed')}}/"+data.appoinment_uuid;
                   }
                }
                
            });
        }
        function acceptusercall() {
    
              $.ajax({
                url: '{{ url("meet/joincall") }}',
                type: "post",
                data: {
                     'act': 'accept',
                  'roomkey': roomkey,
                  '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    
                    const popup = document.getElementById('left-popup');
                    popup.style.display='block'; // Slide out
                    // popup.style.left = '-300px'; // Slide out
                    SendSocketForAcceptReject('acceptcallrequest');
                },
                error: function(xhr) {

                    handleError(xhr);
                }
              });
        }
        function rejectusercall() {

              $.ajax({
                url: '{{ url("meet/joincall") }}',
                type: "post",
                data: {
                  'act': 'reject',
                  'roomkey': roomkey,
                  '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    const popup = document.getElementById('left-popup');
                    // popup.style.left = '-300px'; // Slide out
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
    function showSlidePopup(message,eventValuekey) {
        const popupMessage = document.getElementById('slide-message');
        const popupMessage1 = document.getElementById('slide-message-user');
        const popup = document.getElementById('slide-popup');
        popupMessage.textContent = message || 'Fetching data...';
        popupMessage1.textContent = eventValuekey || '';
        popup.style.display='block'; // Slide out
        // popup.style.left='50%'; // Slide out
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
        function toggleFullScreen() {
            $("#button-settings").addClass("btn-flipped");
            $("#button-settings").html('<i class="fa fa-ellipsis-v"></i>');
            $("#button-settings").removeClass("flip-close");
            $("#source-options").hide();
            
          if (!document.fullscreenElement &&    // alternative standard method
              !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
                $("#full-screen").html('<span><i class="fas fa-expand"></i></span> Exit Full Screen');
            if (document.documentElement.requestFullscreen) {
              document.documentElement.requestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
              document.documentElement.msRequestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
              document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
              document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
          } else {
                $("#full-screen").html('<span><i class="fas fa-expand"></i></span> View Full Screen');
            if (document.exitFullscreen) {
              document.exitFullscreen();
            } else if (document.msExitFullscreen) {
              document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
              document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
              document.webkitExitFullscreen();
            }
          }
        }
      </script>
</body>

</html>

