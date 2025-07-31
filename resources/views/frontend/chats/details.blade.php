    <div class="offcanvas-header p-3 pt-0">
                            <div class="d-flex justify-content-between align-items-center flex-wrap w-100">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img class="img-fluid" src="{{$clinicUserDetails['chat_image']}}" alt="user img">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="mb-0">{{$clinicUserDetails['chat_name']}}</h4>
                                            <p class="mb-0">@if( !empty($speciality)) {{$speciality['specialty_name']}} | @endif @if( !empty($clinic)) {{$clinic['name']}} @endif </p>
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
                          @include('frontend.chats.inner_content')
                   
                              <section class="patientFiles" style="display: none">
                                        @include('frontend.chats.documents')
                            </section>
                        </div>



                        <div class="offcanvas-footer p-3 pb-0 mx-5"> 
                            <div class="send-box">
                                  <form method="POST" id="sendchatform" autocomplete="off">
                                                            @csrf
                                      
                                     <textarea  name="chat_message" id="chat_message" class="mention-box mention" placeholder="Hey there..."></textarea>
                                      <p id="appendfiles" style="display:none;"></p>
                                    <div class="btn_alignbox justify-content-end gap-3">
                                        <div class="button-wrapper">
                                            <span class="label"> <i class="fa-solid fa-paperclip"></i> </span>
                                            <input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                                        </div>
                                        <button type="button"><i class="fa fa-paper-plane" aria-hidden="true" onclick="sendChat()"></i> </button>
                                    </div>
                                </form>
                            </div>
                        </div> 

<script>
    
    let isLoading = false;
let page = 1; // Track pagination or offset if needed


 $(document).ready(function() {
     
  $('#upload').on('change', function () {
        var formData = new FormData();
        var file = $('#upload')[0].files[0];
        formData.append('upload', file);

        $.ajax({
            url: '{{ url("/patient/chat/uploaddocument")}}', // 🔁 Your upload endpoint
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
               
                var imageExtensions = ['png', 'jpg', 'jpeg', 'gif'];
                var pdfExtensions = ['pdf'];
                var excelExtensions = ['xls', 'xlsx', 'xlsm'];
                var videoExtensions = ['mp4', 'avi', 'mov', 'mkv'];
                var wordExtensions = ['doc', 'docx', 'bmp', 'webp'];

                    
                
                    var extension = response.ext;
                    if (imageExtensions.includes(extension)) {
                        var imagePath = response.tempdocpath;
                    } else if (pdfExtensions.includes(extension)) {
                        var imagePath = "{{ asset('images/pdf_img.png') }}";
                    } else if (excelExtensions.includes(extension)) {
                        var imagePath = "{{ asset('images/excel_icon.png') }}";
                    } else if (videoExtensions.includes(extension)) {
                        var imagePath = "{{ asset('images/mp4_img.png') }}";
                    } else if (wordExtensions.includes(extension)) {
                        var imagePath = "{{ asset('images/doc_image.png') }}";
                    } else {
                        var imagePath = "{{ asset('images/doc_image.png') }}";
                    }
                  
                    console.log(response.ext)
                    var appnd = '<div class="fileBody" id="chat_doc_'+response.tempkey+'"><div class="file_info"><img src="' + imagePath + '"><span>' + response.docname + '</span>' +
                        '</div><a onclick="removeChatDoc(\''+response.tempkey+'\')"><span class="material-symbols-outlined">close</span></a></div>' +
                        '<input type="hidden" class="file_count" name="chatdoc" id="chatdoc" value="' + response.tempkey + '" >';
                      
                
                    $("#appendfiles").html(appnd);
                    $("#appendfiles").show();
                    $("#upload").hide();
                
                
                
            },
            error: function () {
                alert('Upload failed.');
            }
        });
    });
    });
     
    
    function sendChat(){
        if( $("#sendchatform").valid() ){
           
             var todayLabel = "Today";

  // Chat container
  const $chatList = $('#chatList'); // update to match your actual <ul> ID

  // Check if today's divider exists
  if ($chatList.find(`.chat-divider:contains('${todayLabel}')`).length === 0) {
            const divider = `
              <li class="chat-divider">
                <div></div>
                <div class="d-inline-flex">
                  <small>${todayLabel}</small>
                </div>
                <div></div>
              </li>
            `;
            $chatList.append(divider);
          }

            var fakemessage = $("#chat_message").val();
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            const ampm = hours >= 12 ? 'pm' : 'am';

            hours = hours % 12 || 12; // Convert 0 to 12 for 12-hour format
            minutes = minutes < 10 ? '0' + minutes : minutes;

            const formattedTime = `${hours}.${minutes}${ampm}`;
            
            const currentTime =formattedTime;
            const fakeReplay = '<li class="replay"><div class="replay-box"><p class="white">'+fakemessage+'</p><div class="text-end"><small class="white">'+currentTime+'</small></div></div></li>';
            $chatList.append(fakeReplay);
            

            $('textarea.mention').mentionsInput('val', function(rawMessage) {

                const cleanedMessage = rawMessage.replace(/@\[(.*?)\]\((.*?)\)/g, function(_, label, meta) {
                    if (meta.startsWith('note:')) {
                        const id = meta.split(':')[1];
                        return `@[note:${id}]`;
                    }
                    return `@[${label}]`; // fallback for other formats
                });

                $('textarea.mention').mentionsInput('getMentions', function(mentions) {
                    const mentionIds = mentions.map(m => m.id);
                      var clinic_user_uuid = '{{$clinic_user_uuid}}';
                    $.ajax({
                        url: '{{ url("/patient/chat/add")}}',
                        type: "post",
                        data: {
                             "clinic_user_uuid": clinic_user_uuid,
                            'formData' :  $("#sendchatform").serialize(),
                            message: cleanedMessage, // the actual message content
                            mentionIds: mentionIds, // pass as JSON
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success == 1) {
                                $("#chat_message").html('');
                                $("#chat_message").val('');
                                sendSocket();
                                //chatDetails(patientuuid);
                            } else {

                            }
                        },
                        error: function(xhr) {

                            handleError(xhr);
                        },
                    });
                });
            });
        }

    }
  
function connectSocket() {
    const socketUrl = "{{env('WSS_SOCKET_END_POINT')}}";
    socket = new WebSocket(socketUrl);
const participantKey = "{{ $chatParticipant['chat_participant_uuid'] }}"; // Participant ID

    // WebSocket event listeners
    socket.onopen = function(event) {
        console.log('WebSocket connection opened.');
        // Define the JSON payload to send
        console.log('WebSocket connection established.');
        console.log("{{Session::get('socket.chats_participant_uuid')}}");

        const payload = {
            "action": "sendchatmessage",
            "data": {
                "event": "connect",
                "participant_uuid": participantKey
            }
        };
        console.log(payload);
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
    
    function handleMessage(event) {
    console.log('Message received:', event.data);
    var jsonObj = JSON.parse(event.data);
    console.log("event recive chat",jsonObj)
    var eventValue = jsonObj.message;
    var eventValuekey = jsonObj.messageuser;
       if(jsonObj.event =='chat'){
           var chat_uuid = "{{$chat['chat_uuid']}}";
           chatDetails(chat_uuid);
       }
   
 
    
    //$("#typing_message_" + jsonObj.joborderkey).html(eventValue)
}
    
     function removeChatDoc(key){
            swal("Are you sure you want to delete the document?", {
                title: "Delete!",
                icon: "warning",
                buttons: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $("#chat_doc_"+key).remove();
                     $("#upload").show();
                }
            });
    }
    
 function sendSocket() {
   // alert("pushed");
    // Define the JSON payload to send
     const participantKey = "{{ $chatParticipant['chat_participant_uuid'] }}";;  // Get the participant ID
   
    const payloadnew = {
        "action": "sendmessage",
        "data": {
            event: 'chat',
            participant_uuid: participantKey,
        }
    };
    socket.send(JSON.stringify(payloadnew));
}
 
    
@if( !empty($chatParticipant))
connectSocket();
@endif

     function initializeMentionInputs(){
           var clinicuuid = "{{$clinic['clinic_uuid']}}";
        setTimeout(function() {
            if ($.fn.mentionsInput) {
                $('textarea.mention').mentionsInput({
                    onDataRequest: function (mode, query, callback) {

                        $.ajax({
                            url: '{{ url("patient/getmentions") }}',
                            type: "post",
                            data: { query: query,clinicuuid: clinicuuid },
                            success: function(response) {

                                const users = response.users.map(function(user) {
                                    return {
                                        id: user.user_id, 
                                        name: user.user_name,
                                        avatar: user.image,
                                        type: 'note',                             
                                        value: `@[note:${user.user_id}]` 
                                    };
                                });
                                const results = _.filter(users, function(item) {
                                    return item.name.toLowerCase().includes(query.toLowerCase());
                                });

                                callback.call(this, results);
                            },
                            error: function(xhr) {
                                console.error('Mention fetch failed', xhr);
                                callback.call(this, []); // Return empty list on error
                            }
                        });
                    },

                });
            } else {
                console.warn('mentionsInput plugin not loaded');
            }
        }, 100)
  }
    



</script>