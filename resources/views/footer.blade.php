<script>
$(document).ready(function() {
    const connection_id = "{{ Session::get('user.connection_id') }}";
    if(connection_id==''){
        connectSocket();
    }
    
});  
     


var socket = null; // Initialize socket variable

    // Function to connect the WebSocket
    function connectSocket() {
      
        const socketUrl = "{{ env('WSS_SOCKET_END_POINT') }}";
      
        const participantKey = "{{ Session::get('user.userSessionID') }}";
        socket = new WebSocket(socketUrl);
        // socket = new WebSocket("wss://socketsbay.com/wss/v2/1/demo/");
        // WebSocket event listeners
        socket.onopen = function() {
            console.log('WebSocket connection opened.');
            // Define the JSON payload to send
            console.log('WebSocket connection established.');

            // Define the JSON payload to send
            const payload = {
                "action": "sendmessage",
                "data": {
                    "event": "connect",
                    "participant_uuid":participantKey
                }
            };
            // Convert the payload to JSON string
            const jsonPayload = JSON.stringify(payload);
            // Send the JSON payload to the server
            socket.send(jsonPayload);
            console.log('jsonPayload'+jsonPayload);
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

    socket.onmessage = handleMessage;
}

 function SendSocket(){
   
      if (socket && socket.readyState === WebSocket.OPEN) {
        console.log('Connection established');
        const participantKey = "{{ Session::get('user.userSessionID') }}";

        // Step 3: Send a request/message after the connection is open
        const requestMessage = {
            "action": "sendmessage",
            "data": {
                "roomkey": roomkey,
                "event": "waitingroom",
                "participantKey": participantKey,
            }
        };

        socket.send(JSON.stringify(requestMessage));  // Send the message as a stringified JSON object
    } else {
        console.error("WebSocket connection is not open.");
    }
     
}

       
  
// Function to handle incoming messages
function handleMessage(event) {
    console.log('Message received:', event.data);
    var jsonObj = JSON.parse(event.data);
    console.log(jsonObj)
    var eventValue = jsonObj.message;
    console.log(eventValue)
    updateSocketEvent(jsonObj);
}

 function updateSocketEvent(jsonObj) {
        $.ajax({
            type: "POST",
            url: '{{ url("/update/socketEvent") }}',
            data: {
              'socketdata': jsonObj,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                    //$("#calenderappd").html(response.view);
                }
             
            },
            error: function(xhr) {
              if(xhr.status != 403){
                handleError(xhr);
              }
            }
        })
    }
</script>        