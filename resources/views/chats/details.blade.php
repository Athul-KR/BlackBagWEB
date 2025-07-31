



            <div class="offcanvas-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap w-100">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img class="img-fluid" src="{{asset('images/johon_doe.png')}}" alt="user img">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-0">{{$patientDetails['first_name']}} {{$patientDetails['last_name']}}</h4>
                                <p class="mb-0">{{ $patientDetails['age']}} | @if($patientDetails['gender'] == '1') Male @elseif($patientDetails['gender'] == '2') Female @else Other @endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="btn_alignbox justify-content-end"> 
                            <button type="button" onclick="showFiles('{{$patientDetails['patients_uuid']}}')" class="btn opt-btn">
                                <span class="material-symbols-outlined">docs</span>
                            </button>                            
                            <a class="cls-btn" data-bs-dismiss="offcanvas" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="offcanvas-body chat-body" id="chat_innercontent" >
            @include('chats.inner_content')
                                                    
                <section class="patientFiles" style="display: none">
                    @include('chats.documents')
                </section>
                                
            </div>
            <div class="offcanvas-footer"> 
                <div class="send-box">
                    <form method="POST" id="sendchatform" autocomplete="off">
                    @csrf
                    <p id="appendfiles" class="mb-0" style="display:none;"></p>
                    <div class="d-flex align-items-center gap-3 w-100">                               
                        <textarea  name="chat_message" id="chat_message" class="mention-box mention" placeholder="Hey there..."></textarea>
                            <div class="btn_alignbox justify-content-end">
                                <div class="button-wrapper">
                                    <span class="label"> <i class="fa-solid fa-paperclip"></i> </span>
                                    <input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                                </div>
                                <button type="button"><i class="fa fa-paper-plane" aria-hidden="true" onclick="sendChat()"></i></button>
                            </div>
                        </div>                                        
                    </form>
                </div>
            </div>

<script>
    
    $(document).ready(function() {
     
    
    let isLoading = false;
    let page = 1; // Track pagination or offset if needed


     
  $('#upload').on('change', function () {
        var formData = new FormData();
        var file = $('#upload')[0].files[0];
        formData.append('upload', file);

        $.ajax({
            url: '{{ url("/clinic/chat/uploaddocument")}}', // 🔁 Your upload endpoint
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
     
  $("#sendchatform").validate({
          ignore: [],
          rules: {
              chat_message : {
                 // required: true,
                  //noWhitespace: true,
              },

              },

          messages: {
              chat_message :{
                  required : "Please enter a message",
                  noWhitespace: "Please enter a valid message",
              },

          },
          errorPlacement: function(error, element) {

                error.insertAfter(element.parent().parent('div')); // Place error messages after the input fields

          }
      });
      jQuery.validator.addMethod("noWhitespace", function(value, element) {
        return $.trim(value).length > 0;
      }, "This field is required.");



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
            
            var patientuuid = '{{$patient_uuid}}';

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
                    $.ajax({
                        url: '{{ url("/clinic/chat/add")}}',
                        type: "post",
                        data: {
                            "patient_uuid": patientuuid,
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
           var patientuuid = "{{$patientDetails['patients_uuid']}}";
            chatDetails(patientuuid);
            
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

</script>
                                               