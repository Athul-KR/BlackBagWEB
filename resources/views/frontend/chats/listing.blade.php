@extends('frontend.master')
@section('title', 'Dashboard')
@section('content')

  <script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js' type='text/javascript'></script>
<script src="https://cdn.jsdelivr.net/gh/podio/jquery-mentions-input/lib/jquery.elastic.js"></script>
  <link rel="stylesheet" href="{{ asset('css/mentionsInput.css')}}">
    <script src="{{ asset('js/mentionsInput.js') }}"></script>

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
                            <?php $count = 1; ?>
                            @if( !empty($chats) )
                            @foreach( $chats as $ch)
                            <div class="col-12"> 

                                    <div class="chat-user-box @if( $count == 1) active @endif">
                                        <div class="row align-items-center" onclick="chatDetails('{{$ch['chat_uuid']}}')">
                                            <div class="col-9 col-sm-10">
                                                <div class="d-flex align-items-start gap-2 flex-grow-1">
                                                    <div class="flex-shrink-0 position-relative">
                                                        <img class="img-fluid chat-user" src="{{$ch['profile_image']}}" alt="user img">
                                                        @if( isset($unreadChats[$ch['id']]) && isset($unreadChats[$ch['id']]['unread_count'])  )
                                                        <span class="badge badge-danger unread-count">{{$unreadChats[$ch['id']]['unread_count']}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="mb-1 fw-bold">{{$ch['user_name']}}</h5>
                                                     @if( !empty($lastChats) && isset($lastChats[$ch['id']]) )
                                                        <div class="d-flex gap-2">
                                                           
                                                            <p class="chat-text mb-0">{{$lastChats[$ch['id']]['message']}}</p>
                                                            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                                <span class="time-dot"></span>
                                                                <p class="mb-0 light-gray">{{$lastChats[$ch['id']]['last_chat_time']}}</p>
                                                            </div>
                                                        </div>
                                                        @endif
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
                            <?php $count++; ?>
                            @endforeach
                            @endif
                            
                           
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-lg-8 col-xl-7">
                <div class="web-card h-100">
                    <div class="chat-container" id="chatdetails">
                                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>

function showFiles(chatkey) {
  const isVisible = $('.patientFiles').is(':visible');
  if (isVisible) {
    $('.patientFiles').hide();
    $('.message-area').show();
    $('.offcanvas-footer').show();
  } else {
      
         $.ajax({
            url: '{{ url("patient/chat/documents") }}',
            type: "post",
            data: {
                'chatkey' : chatkey,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $('.patientFiles').show();
                    $('.message-area').hide();
                    $('.offcanvas-footer').hide();
                    $(".patientFiles").html(data.view);
                       
                } else {
                swal("error!", data.message, "success");
                
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
      

  }
}
    
       function chatDetails(chatuuid){
         showPreloader('chatdetails');
        $.ajax({
            url: '{{ url("patient/chat/details") }}',
            type: "post",
            data: {
                'key' : chatuuid,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#chatdetails").html(data.view);
                     initializeMentionInputs();
                } else {
                swal("error!", data.message, "success");
                
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }
    
    

</script>

@stop