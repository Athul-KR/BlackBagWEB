// socket.js - Shared WebSocket Module

let socket = null;  // WebSocket instance

function connectSocket() {
    if (socket && socket.readyState === WebSocket.OPEN) {
        console.log("WebSocket already connected.");
        return socket;  // Return existing connection if already connected
    }

    const socketUrl = "{{ env('WSS_SOCKET_END_POINT') }}";
      
    const participantKey = "{{ Session::get('user.userSessionID') }}";

    socket = new WebSocket(socketUrl);

    socket.onopen = function() {
        console.log('WebSocket connection opened.');
        const payload = {
            "action": "sendmessage",
            "data": {
                "event": "connect",
                "participant_uuid": participantKey
            }
        };
        const jsonPayload = JSON.stringify(payload);
        socket.send(jsonPayload);
    };

    socket.onerror = function(error) {
        console.error('WebSocket error:', error);
    };

    socket.onclose = function(event) {
        console.log("WebSocket connection closed unexpectedly.");
    };

    return socket;  // Return the WebSocket connection
}

function getSocket() {
    if (!socket) {
        socket = connectSocket();
    }
    return socket;  // Return the current socket instance
}

function sendMessage(message) {
    const socket = getSocket();  // Ensure WebSocket is open
    if (socket && socket.readyState === WebSocket.OPEN) {
        socket.send(JSON.stringify(message));  // Send message
    } else {
        console.log("WebSocket is not open yet.");
    }
}

export { connectSocket, getSocket, sendMessage };
