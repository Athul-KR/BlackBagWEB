                <ul class="p-0 m-0" id="chatList">
                        @if( !empty($finalChats))
                        @foreach( $finalChats as $chak => $chat)
                         <li class="chat-divider">
                            <div></div>
                            <div class="d-inline-flex">
                                <p class="m-0">{{$chak}}</p>
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
                return '<span class="fwt-bold">' . $name . '</span>';
            }, $cv['message']);
                    $cv['message'] = $styledMessage;
          ?>


                        <li class="load-message text-center"> 
                            <img src="{{asset('images/loadinganimation.gif')}}">
                        </li>

                        @if( ( $cv['participant_type_id'] == '1' && $cv['user_id'] != $session_userid ) || ( $cv['participant_type_id'] == '2' )  )
                        <li class="sender">
                            <div class="sender-box">
                                <p class="primary mb-1"><?php echo nl2br($cv['message']);?></p>
                                @if( isset($cv['docInfo']) && !empty($cv['docInfo']) )
                                <div class="fileResult_inner mb-1">
                                        <img src="{{$cv['docInfo']['image']}}" alt="pdf">
                                        <div class="folderName">
                                            <a class="view-file" href="#" >
                                                <h6 class="primary m-0">{{$cv['docInfo']['title']}}</h6>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="text-end">
                                    <small class="gray">{{$cv['created_time']}}</small>   
                                </div>
                            </div>

                             @if($currentSender != $nextSender)
                            <div class="d-flex align-items-center gap-1 pt-1">
                                <img class="img-fluid chat-user-img" src="{{$cv['profile_image']}}" alt="user img">
                                <div>
                                    <small class="mb-0 fw-middle">{{$cv['name']}}</small>
                                </div>
                            </div>
                            @endif
                        </li>
                        @endif

                         @if(( $cv['participant_type_id'] == '1' && $cv['user_id'] == $session_userid ) )
                        <li class="replay">
                            <div class="replay-box">
                                <p class="white mb-1"><?php echo nl2br($cv['message']);?></p>
                                @if( isset($cv['docInfo']) && !empty($cv['docInfo']) )
                                <div class="fileResult_inner mb-1">
                                    <img src="{{$cv['docInfo']['image']}}" alt="pdf">
                                    <div class="folderName">
                                        <a class="view-file" href="#" >
                                            <h6 class="white m-0">{{$cv['docInfo']['title']}}</h6>
                                        </a>
                                    </div>
                                </div>
                                @endif
                                <div class="text-end">
                                    <small class="white">{{$cv['created_time']}}</small>
                                </div>
                            </div>
                        </li>
                        @endif

                        @endforeach
                        @endif
                        @endforeach
                        @endif
                    </ul>