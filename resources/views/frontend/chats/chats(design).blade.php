@extends('frontend.master')
@section('title', 'Dashboard')
@section('content')

<section class="details_wrapper chat-wrapper-container">
    <div class="container">
        <div class="row g-3">
            <div class="col-12 col-lg-4 col-xl-5">
                <div class="web-card h-100">
                    <div class="chat-users"> 
                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">Chats</h4>
                            <form id="" method="GET" action="" novalidate="novalidate">
                                <div class="input-group search-box">
                                    <div class="input-group-text" id="basic-addon1">
                                        <span class="material-symbols-outlined">search</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search" name="searchterm" aria-label="" aria-describedby="" id="" value="">
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-12"> 

                                    <div class="chat-user-box active">
                                        <div class="row align-items-center">
                                            <div class="col-9 col-sm-10">
                                                <div class="d-flex align-items-start gap-2 flex-grow-1">
                                                    <div class="flex-shrink-0 position-relative">
                                                        <img class="img-fluid chat-user" src="{{asset('images/doct1.png')}}" alt="user img">
                                                        <span class="badge badge-danger unread-count">1</span>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="mb-1 fw-bold">Jelani Kasongo, NP</h5>
                                                        <div class="d-flex gap-2">
                                                            <p class="chat-text mb-0"><span class="fwt-bold">@Emily</span> could you please take a reading and let me know.</p>
                                                            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                                <span class="time-dot"></span>
                                                                <p class="mb-0 light-gray">8:10 AM</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-3 col-sm-2">
                                                <div class="btn_alignbox justify-content-end">
                                                    <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="material-symbols-outlined">more_vert</span>
                                                    </a> 
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item fw-medium" href="" data-bs-toggle="tooltip" title="Archive Chat"><i class="fa-solid fa-trash me-2"></i>Archive Chat</a></li>                                                    
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                            </div>
                            <div class="col-12"> 
                                <div class="chat-user-box">
                                    <div class="row align-items-center">
                                        <div class="col-9 col-sm-10">
                                            <div class="d-flex align-items-start gap-2 flex-grow-1">
                                                <div class="flex-shrink-0">
                                                    <img class="img-fluid chat-user" src="{{asset('images/drclark.png')}}" alt="user img">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="mb-1 fw-bold">James Carlos, MD</h5>
                                                    <div class="d-flex gap-2">
                                                        <p class="chat-text mb-0">Sure</p>
                                                        <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                            <span class="time-dot"></span>
                                                            <p class="mb-0 light-gray">2 days ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-3 col-sm-2">
                                            <div class="btn_alignbox justify-content-end">
                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </a> 
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item fw-medium" href="" data-bs-toggle="tooltip" title="Archive Chat"><i class="fa-solid fa-trash me-2"></i>Archive Chat</a></li>                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12"> 
                                <div class="chat-user-box">
                                    <div class="row align-items-center">
                                        <div class="col-9 col-sm-10">
                                            <div class="d-flex align-items-start gap-2 flex-grow-1">
                                                <div class="flex-shrink-0 position-relative">
                                                    <img class="img-fluid chat-user" src="{{asset('images/doct2.png')}}" alt="user img">
                                                    <span class="badge badge-danger unread-count">3</span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="mb-1 fw-bold">Deep Singh, MD</h5>
                                                    <div class="d-flex gap-2">
                                                        <p class="chat-text mb-0">Make sure you take those pills</p>
                                                        <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                            <span class="time-dot"></span>
                                                            <p class="mb-0 light-gray">3 days ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 col-sm-2">
                                            <div class="btn_alignbox justify-content-end">
                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </a> 
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item fw-medium" href="" data-bs-toggle="tooltip" title="Archive Chat"><i class="fa-solid fa-trash me-2"></i>Archive Chat</a></li>                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-lg-8 col-xl-7">
                <div class="web-card h-100">
                    <div class="chat-container">
                        <div class="offcanvas-header p-3 pt-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img class="img-fluid" src="{{asset('images/doct1.png')}}" alt="user img">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="mb-0">Jelani Kasongo, NP</h4>
                                            <p class="mb-0">Cardiology | HealthCrest Clinic & Family Planning Center </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="btn_alignbox justify-content-end"> 
                                        <button type="button" onclick="showFiles()" class="btn opt-btn">
                                            <span class="material-symbols-outlined">docs</span>
                                        </button>        
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="offcanvas-body p-3 mx-5">
                            <section class="message-area"> 
                                <div class="chat-area">
                                <!-- chatbox -->
                                    <div class="chatbox h-100">
                                        <div class="chatbox-scrollable h-100">
                                            <div class="msg-body h-100">
                                                <ul class="p-0 m-0">
                                                    <li class="chat-divider">
                                                        <div></div>
                                                        <div class="d-inline-flex">
                                                            <small>Today</small>
                                                        </div>
                                                        <div></div>
                                                    </li> 
                                                    <li class="replay">
                                                        <div class="replay-box">
                                                            <p class="white">Hello Doctor,</p>
                                                            <div class="text-end">
                                                                <small class="white">8:04 am</small>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="replay">
                                                        <div class="replay-box">
                                                            <p class="white">Can I postpone my appointment for tomorrow</p>
                                                            <div class="text-end">
                                                                <small class="white">8:05 am</small>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="sender">
                                                        <div class="sender-box">
                                                            <p class="primary">Sure, I’ll check my schedule and get back to you</p>
                                                            <div class="text-end">
                                                                <small class="gray">8:06 am</small>   
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-1 pt-1">
                                                            <img class="img-fluid chat-user-img" src="{{asset('images/doct1.png')}}" alt="user img">
                                                            <div>
                                                                <small class="mb-0 fw-light">Jelani Kasongo, NP</small>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="chat-divider new-messages">
                                                        <div></div>
                                                        <div class="d-inline-flex">
                                                            <small>New Messages</small>
                                                        </div>
                                                        <div></div>
                                                    </li> 
                                                    <li class="replay">
                                                        <div class="replay-box">
                                                            <p class="white">Okay Doctor,</p>
                                                            <div class="text-end">
                                                                <small class="white">8:10 am</small>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <!-- chatbox -->
                                </div>
                            </section>
                            <section class="patientFiles" style="display: none">
                                <div class="row"> 
                                    <div class="col-12 col-lg-6">
                                        <div class="fileBody_inner d-flex justify-content-between align-items-center">
                                            <div class="fileResult_inner">
                                                <img src="{{asset('images/pdf_icon.png')}}" alt="pdf">
                                                <div class="folderName">
                                                    <a class="view-file" href="#">
                                                        <h6 class="primary m-0">Patient_files.pdf</h6>
                                                    </a>
                                                    <p class="m-0">Nov 07, 2024</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="fileBody_inner d-flex justify-content-between align-items-center">
                                            <div class="fileResult_inner">
                                                <img src="{{asset('images/pdf_icon.png')}}" alt="pdf">
                                                <div class="folderName">
                                                    <a class="view-file" href="#">
                                                        <h6 class="primary m-0">ECG.pdf</h6>
                                                    </a>
                                                    <p class="m-0">Nov 10, 2024</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="fileBody_inner d-flex justify-content-between align-items-center">
                                            <div class="fileResult_inner">
                                                <img src="{{asset('images/pdf_icon.png')}}" alt="pdf">
                                                <div class="folderName">
                                                    <a class="view-file" href="#">
                                                        <h6 class="primary m-0">Blood_test.pdf</h6>
                                                    </a>
                                                    <p class="m-0">Nov 17, 2024</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>            
                            </section>
                        </div>
                        <div class="offcanvas-footer p-3 pb-0 mx-5"> 
                            <div class="send-box">
                                <form action="">
                                    <input type="text" class="form-control" aria-label="message…" placeholder="Hey there...">
                                    <div class="btn_alignbox justify-content-end gap-3">
                                        <div class="button-wrapper">
                                            <span class="label"> <i class="fa-solid fa-paperclip"></i> </span>
                                            <input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                                        </div>
                                        <button type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i> </button>
                                    </div>
                                </form>
                            </div>
                        </div>                                 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>

function showFiles() {
  const isVisible = $('.patientFiles').is(':visible');
  if (isVisible) {
    $('.patientFiles').hide();
    $('.message-area').show();
    $('.offcanvas-footer').show();
  } else {
    $('.patientFiles').show();
    $('.message-area').hide();
    $('.offcanvas-footer').hide();
  }
}

</script>

@stop