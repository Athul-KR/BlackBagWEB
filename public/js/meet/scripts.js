console.log(name);
console.log(userName);
var userId = userName.trim();

var sessionContainer = document.getElementById('sessionContainer')
var authEndpoint = 'https://demoserver22.icwares.com/ecomm-dev/generateSignature'
var config = {
    videoSDKJWT: '',
    sessionName: name,
    userName: userId,
    sessionPasscode: '123',
    features: [ 'video', 'audio', 'settings', 'users'],
   featuresOptions: {
    virtualBackground: {
      enable: true,
      virtualBackgrounds: [
        {
          url: "https://images.unsplash.com/photo-1715490187538-30a365fa05bd?q=80&w=1945&auto=format&fit=crop",
        },
      ],
    },
  },
};

var role = roleparam;
window.getVideoSDKJWT = getVideoSDKJWT

function getVideoSDKJWT() {
    document.getElementById('join-flow').style.display = 'none'
    document.getElementById('session-logo').style.display = 'block';
    fetch(authEndpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            sessionName:  config.sessionName,
            role: role,
        })
    }).then((response) => {
        return response.json()
    }).then((data) => {
        if(data.signature) {
            console.log(data.signature)
            config.videoSDKJWT = data.signature
            joinSession()
        } else {
            console.log(data)
        }
    }).catch((error) => {
        console.log(error)
    })
}

function joinSession() {
  const newConfig = uitoolkit.migrateConfig(config);
  uitoolkit.joinSession(sessionContainer, newConfig);

  document.getElementById("header").style.display = "none";
  document.getElementById("join-flow").style.display = "none";

  uitoolkit.onSessionJoined(sessionJoined);
  uitoolkit.onSessionClosed(sessionClosed);
  uitoolkit.onSessionDestroyed(sessionDestroyed);
  uitoolkit.joinSession(sessionContainer, config);
  uitoolkit.onSessionClosed(sessionClosed);
    
}

var sessionTimer;
var sessionTimeout = 10 * 60 * 1000; // 10 minutes in milliseconds
var warningTime = 9 * 60 * 1000; // 9 minutes - shows warning with 1 minute remaining

var sessionJoined = () => {
    document.querySelector('button[title=""]').style.display = 'none';
  console.log("session joined");
  // Start the session timer
  sessionTimer = setTimeout(() => {
    console.log("Session timeout - leaving session");
    //uitoolkit.leaveSession();
  }, sessionTimeout);
 // Listen for closed caption (live transcript) events
//    uitoolkit.getClient().on('closed-caption-received', (payload) => {
//        console.log('Transcript:', payload.text);
//        
//        // Append to a transcript div
//        const transcriptDiv = document.getElementById('transcript');
//        if (transcriptDiv) {
//            transcriptDiv.innerHTML += `<div>${payload.text}</div>`;
//            transcriptDiv.scrollTop = transcriptDiv.scrollHeight; // Auto scroll
//        }
//    });
//  // Set warning timer
//  setTimeout(() => {
//    alert("Warning: You demo session will timeout in 1 minute!");
//  }, warningTime);
};

var sessionClosed = () => {
    alert("session closed")
  console.log("session closed");
  if (sessionTimer) {
    clearTimeout(sessionTimer);
  }
  if (document.getElementById("header")) {
    document.getElementById("header").style.display = "flex";
  }
  if (document.getElementById("join-flow")) {
    document.getElementById("join-flow").style.display = "block";
  }
  if (document.getElementById("rating")) {
    //document.getElementById("rating").style.display = "block";
  }
  const joinButton = document.querySelector(".join-flow button");
  joinButton.disabled = false;
  joinButton.textContent = "Join Session";
    sessionend(); // Additional cleanup if required

};

var sessionDestroyed = () => {
    alert("session destroyed");
  console.log("session destroyed");
  uitoolkit.destroy();
};