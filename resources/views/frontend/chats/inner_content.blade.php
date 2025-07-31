  <section class="message-area"> 
    <div class="chat-area">
    <!-- chatbox -->
    <div class="chatbox h-100">
    <div class="chatbox-scrollable h-100">
    <div class="msg-body h-100">
        <ul class="p-0 m-0" id="chatList">
            @if( !empty($finalChats))
            @foreach( $finalChats as $chak => $chat)
            <li class="chat-divider">
                <div></div>
                <div class="d-inline-flex">
                    <small>Today</small>
                </div>
                <div></div>
            </li> 
            @if( !empty($chat) )
                         @foreach( $chat as $ck => $cv )  
            
             <?php 
                $currentSender = $cv['participant_id'] . '_' . $cv['participant_type_id'];
                $nextSender = isset($chat[$ck + 1]) 
                    ? $chat[$ck + 1]['participant_id'] . '_' . $chat[$ck + 1]['participant_type_id'] 
                    : null;
            
            // Wrap names in a span with blue color
$styledMessage = preg_replace_callback('/@\[(.*?)\]/', function($matches) {
    $name = $matches[1];
    return '<span style="color:blue;">' . $name . '</span>';
}, $cv['message']);
        $cv['message'] = $styledMessage;


          ?>
 
        
            
            @if( $cv['participant_type_id'] == '1'   )
            <li class="sender">
                <div class="sender-box">
                    <p class="primary"<?php echo nl2br($cv['message']);?></p>
                    <div class="text-end">
                        <small class="gray">{{$cv['created_time']}}</small>   
                    </div>
                </div>
                
                      @if( isset($cv['docInfo']) && !empty($cv['docInfo']) )
                            <div class="fileResult_inner">
                                    <img src="{{$cv['docInfo']['image']}}" alt="pdf">
                                    <div class="folderName">
                                        <a class="view-file" href="#" >
                                            <h6 class="primary m-0">{{$cv['docInfo']['title']}}</h6>
                                        </a>
                                    </div>
                                </div>
                            @endif
                @if($currentSender != $nextSender)
                <div class="d-flex align-items-center gap-1 pt-1">
                    <img class="img-fluid chat-user-img" src="{{asset('images/doct1.png')}}" alt="user img">
                    <div>
                        <small class="mb-0 fw-light">{{$cv['name']}}</small>
                    </div>
                </div>
                @endif
            </li>
            @endif
             @if( $cv['participant_type_id'] == '2'   )
            <li class="replay">
                <div class="replay-box">
                    <p class="white"><?php echo nl2br($cv['message']);?></p>
                    <div class="text-end">
                        <small class="white">{{$cv['created_time']}}</small>
                    </div>
                </div>
            </li>
            @endif
            
                      @if( isset($cv['docInfo']) && !empty($cv['docInfo']) )
                            <div class="fileResult_inner">
                                    <img src="{{$cv['docInfo']['image']}}" alt="pdf">
                                    <div class="folderName">
                                        <a class="view-file" href="#" >
                                            <h6 class="primary m-0">{{$cv['docInfo']['title']}}</h6>
                                        </a>
                                    </div>
                                </div>
                            @endif

                         @endforeach
                        @endif
                        @endforeach
                        @endif
        </ul>
    </div>
    </div>
    </div>
    <!-- chatbox -->
    </div>
    </section>
