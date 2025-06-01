<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom: Cosmic Meet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-peer@9.11.1/simplepeer.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a, #4c1d95);
            animation: gradient 15s ease infinite;
            overflow: hidden;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .video-container {
            transition: all 0.3s ease;
        }

        .video-container:hover {
            transform: scale(1.01);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .control-btn {
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
        }

        .control-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        .control-btn.disabled {
            background: linear-gradient(45deg, #6b7280, #9ca3af);
            cursor: not-allowed;
        }

        .panel {
            transition: transform 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .panel-hidden {
            transform: translateX(-100%);
        }

        .panel-right-hidden {
            transform: translateX(100%);
        }

        .screen-sharing {
            border-color: #22c55e !important;
        }

        .screen-sharing-label {
            background: #22c55e;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .toggle-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .video-full {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>

<body class="min-h-screen flex p-2">
    <div class="absolute top-6 left-6 bg-white/20 rounded-xl shadow px-3 py-2 flex gap-3 items-center z-40">
        <span class="text-white font-semibold">Role: <span id="roleDisplay">Teacher</span></span>
        <span class="text-white font-semibold ml-3">Room: <span id="roomDisplay">Room1</span></span>
        <span id="status" class="ml-3 text-yellow-100 font-semibold">Connecting...</span>
    </div>
    <div
        class="bg-gray-900 bg-opacity-90 shadow-2xl rounded-2xl w-full h-[98vh] flex flex-col backdrop-blur-md relative">
        <!-- Header -->
        <div class="flex items-center justify-between p-3 border-b border-gray-700">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Classroom: Cosmic Meet</h2>
            <span id="liveIndicator" class="px-3 py-1 bg-red-500 text-white rounded-full text-sm font-semibold">Offline</span>
        </div>
        <!-- Main Content -->
        <div class="flex flex-1 overflow-hidden relative">
            <!-- Participant Panel (Left) -->
            <div id="participantPanel" class="panel absolute top-0 left-0 w-60 h-full p-3 z-10">
                <div class="flex items-center justify-between mb-3">
                    <button onclick="toggleParticipantPanel()" class="text-white hover:text-blue-400">
                        <i id="participantToggleIcon" class="fas fa-chevron-left"></i>
                    </button>
                    <h3 class="text-lg font-semibold text-white">Participants</h3>
                </div>
                <div id="participantList" class="space-y-3 overflow-y-auto h-[calc(100%-70px)]">
                    <!-- Participants will be shown here -->
                </div>
            </div>
            <button id="participantToggleBtn"
                class="toggle-btn absolute top-1/2 left-0 p-2 rounded-r-lg text-white hidden z-20"
                onclick="toggleParticipantPanel()">
                <i class="fas fa-users"></i>
            </button>
            <!-- Chat Panel (Right) -->
            <div id="chatPanel" class="panel absolute top-0 right-0 w-60 h-full p-3 z-10">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-white">Chat</h3>
                    <button onclick="toggleChatPanel()" class="text-white hover:text-blue-400">
                        <i id="chatToggleIcon" class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div id="chatMessages" class="space-y-3 overflow-y-auto h-[calc(100%-110px)]">
                    <!-- Chat messages will be appended here -->
                </div>
                <div class="mt-3">
                    <input id="chatInput" class="w-full p-2 rounded bg-gray-700 text-white"
                        placeholder="Type a message..." onkeypress="handleChatKeyPress(event)">
                    <button onclick="sendChatMessage()"
                        class="mt-2 w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Send</button>
                </div>
            </div>
            <button id="chatToggleBtn"
                class="toggle-btn absolute top-1/2 right-0 p-2 rounded-l-lg text-white hidden z-20"
                onclick="toggleChatPanel()">
                <i class="fas fa-comments"></i>
            </button>
            <!-- Main Video Area -->
            <div class="flex-1 p-3" style="margin-left: 240px; margin-right: 240px;">
                <div id="mainVideoContainer" class="h-full flex items-center justify-center video-container relative">
                    <video id="mainVideo" autoplay playsinline muted
                        class="video-full rounded-lg border-2 border-blue-400 shadow-xl hidden"></video>
                    <div id="videoPlaceholder" class="text-white text-2xl font-medium opacity-80">
                        <div class="text-center">
                            <i class="fas fa-video-slash text-6xl mb-4 opacity-50"></i>
                            <p>Waiting for connection...</p>
                        </div>
                    </div>
                    <div id="screenSharingLabel" class="screen-sharing-label hidden">Screen Sharing</div>
                </div>
            </div>
        </div>
        <!-- Controls -->
        <div class="flex gap-3 justify-center p-3 bg-gray-800 bg-opacity-80 rounded-lg" id="controlsContainer">
            <!-- Teacher Controls -->
            <div id="teacherControls" class="flex gap-3" style="display: none;">
                <button onclick="toggleVideo()" id="videoBtn"
                    class="control-btn p-3 text-white rounded-lg shadow-lg"
                    title="Turn Off Video">
                    <i class="fas fa-video" id="videoBtnIcon"></i>
                </button>
                <button onclick="toggleMic()" id="micBtn"
                    class="control-btn p-3 text-white rounded-lg shadow-lg"
                    title="Mute Mic">
                    <i class="fas fa-microphone" id="micBtnIcon"></i>
                </button>
                <button onclick="toggleScreenShare()" id="screenShareBtn"
                    class="control-btn p-3 text-white rounded-lg shadow-lg"
                    title="Share Screen">
                    <i class="fas fa-desktop" id="screenShareBtnIcon"></i>
                </button>
                <button onclick="endClass()" id="endClassBtn"
                    class="control-btn p-3 text-white rounded-lg shadow-lg bg-red-600 hover:bg-red-700"
                    title="End Class">
                    <i class="fas fa-phone-slash"></i>
                </button>
            </div>
            <!-- Student Controls -->
            <div id="studentControls" class="flex gap-3" style="display: none;">
                <button onclick="toggleStudentMic()" id="studentMicBtn"
                    class="control-btn p-3 text-white rounded-lg shadow-lg"
                    title="Mute/Unmute Mic">
                    <i class="fas fa-microphone" id="studentMicBtnIcon"></i>
                </button>
                <button onclick="leaveClass()" id="leaveBtn"
                    class="control-btn p-3 text-white rounded-lg shadow-lg bg-red-600 hover:bg-red-700"
                    title="Leave Class">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>
    </div>
<script>
const SIGNALING_URL = "ws://localhost:3001";
let userRole = "teacher"; // Or "student"
let room = "room1"; // Dynamic as needed

let ws, peer, localStream = null, remoteStream = null;
let isVideoOn = true, isMicOn = true, isScreenSharing = false;
let pendingSignals = [];
let participants = [];
let connectionAttempts = 0;
const maxConnectionAttempts = 5;

document.getElementById('roleDisplay').textContent = userRole.charAt(0).toUpperCase() + userRole.slice(1);
document.getElementById('roomDisplay').textContent = room;
updateUI();

function updateUI() {
    document.getElementById('teacherControls').style.display = userRole === "teacher" ? "flex" : "none";
    document.getElementById('studentControls').style.display = userRole === "teacher" ? "none" : "flex";
    updateParticipantList();
}

function updateParticipantList() {
    const participantList = document.getElementById('participantList');
    participantList.innerHTML = '';
    // Add self
    const selfDiv = document.createElement('div');
    selfDiv.className = 'flex items-center gap-3 p-2 bg-blue-600 rounded-lg';
    selfDiv.innerHTML = `
        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-pink-500 flex items-center justify-center text-white font-medium">${userRole[0].toUpperCase()}</div>
        <span class="text-white font-medium">${userRole} (You)</span>
    `;
    participantList.appendChild(selfDiv);
    // Add other participants
    participants.forEach(participant => {
        if (participant.id !== 'self') {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 p-2 bg-gray-700 rounded-lg';
            div.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-500 to-blue-500 flex items-center justify-center text-white font-medium">${participant.role[0].toUpperCase()}</div>
                <span class="text-white font-medium">${participant.role}</span>
            `;
            participantList.appendChild(div);
        }
    });
}

function updateStatus(message, isError = false) {
    const statusEl = document.getElementById('status');
    statusEl.textContent = message;
    statusEl.className = `ml-3 font-semibold ${isError ? 'text-red-300' : 'text-yellow-100'}`;
}

function updateLiveIndicator(isLive) {
    const indicator = document.getElementById('liveIndicator');
    if (isLive) {
        indicator.textContent = 'Live';
        indicator.className = 'px-3 py-1 bg-green-500 text-white rounded-full text-sm font-semibold animate-pulse';
    } else {
        indicator.textContent = 'Offline';
        indicator.className = 'px-3 py-1 bg-red-500 text-white rounded-full text-sm font-semibold';
    }
}

// --- WebSocket connection and logic ---
function joinRoom() {
    if (connectionAttempts >= maxConnectionAttempts) {
        updateStatus("Connection failed. Please refresh.", true);
        return;
    }
    connectionAttempts++;
    updateStatus("Connecting...");
    ws = new WebSocket(SIGNALING_URL);

    ws.onopen = () => {
        connectionAttempts = 0;
        ws.send(JSON.stringify({ type: "join", room, role: userRole }));
        updateStatus("Connected");
        updateLiveIndicator(true);
        // Teacher only starts camera after connect (no peer connection yet)
        if (userRole === "teacher") {
            setTimeout(initializeTeacher, 500);
        }
    };

    ws.onmessage = async (event) => {
        let data;
        try { data = JSON.parse(event.data); } catch { return; }
        switch (data.type) {
            case "participants":
                handleParticipants(data);
                break;
            case "signal":
                handleSignal(data);
                break;
            case "join":
                handleJoin(data);
                break;
            case "leave":
                handleLeave(data);
                break;
            case "chat":
                handleChat(data);
                break;
        }
    };

    ws.onerror = (error) => {
        updateStatus("Connection error", true);
        updateLiveIndicator(false);
    };

    ws.onclose = () => {
        updateStatus("Disconnected. Reconnecting...");
        updateLiveIndicator(false);
        setTimeout(joinRoom, 2000);
    };
}

function handleParticipants(data) {
    updateStatus(`Connected (${data.count} participants)`);
    if (data.count === 2) {
        // Only teacher is initiator, student is always non-initiator
        setTimeout(() => {
            cleanupPeerConnection();
            if (userRole === "teacher") {
                initializePeerConnection(true);
            } else {
                initializePeerConnection(false);
            }
        }, 200); // slight delay for signaling to sync
    } else if (data.count === 1) {
        cleanupPeerConnection();
    }
}

function handleSignal(data) {
    if (peer && peer._pc && peer._pc.signalingState !== 'closed') {
        try { peer.signal(data.signal); } catch (err) {}
    } else {
        pendingSignals.push(data.signal);
    }
}

function handleJoin(data) {
    if (!participants.find(p => p.id === data.id)) {
        participants.push({ role: data.role, id: data.id });
        updateParticipantList();
    }
}

function handleLeave(data) {
    participants = participants.filter(p => p.id !== data.id);
    updateParticipantList();
    cleanupPeerConnection();
}

function handleChat(data) { appendChatMessage(data.message, data.role); }

// --- Teacher gets camera+mic only (not peer) ---
async function initializeTeacher() {
    try {
        updateStatus("Starting camera...");
        localStream = await navigator.mediaDevices.getUserMedia({
            video: { width: 1280, height: 720 },
            audio: true
        });
        showVideo(localStream, true);
        updateStatus("Camera ready");
    } catch (err) {
        updateStatus("Camera access denied", true);
        alert("Please allow camera and microphone access to start the class.");
    }
}

// --- Peer connection ---
function initializePeerConnection(isInitiator) {
    cleanupPeerConnection();
    const peerConfig = {
        initiator: isInitiator,
        trickle: false,
        config: {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        }
    };
    if (userRole === "teacher" && localStream) {
        peerConfig.stream = localStream;
    }
    peer = new SimplePeer(peerConfig);

    peer.on('signal', (data) => {
        if (ws && ws.readyState === WebSocket.OPEN) {
            ws.send(JSON.stringify({ type: "signal", signal: data }));
        }
    });

    peer.on('stream', (stream) => {
        remoteStream = stream;
        showVideo(stream, false);
        updateStatus("Connected and streaming");
    });

    peer.on('connect', () => {
        updateStatus("Peer connected");
    });

    peer.on('error', (err) => {
        updateStatus("Connection error: " + err.message, true);
    });

    peer.on('close', () => {
        cleanupPeerConnection();
    });

    // flush pending signals
    while (pendingSignals.length > 0) {
        const signal = pendingSignals.shift();
        try { peer.signal(signal); } catch {}
    }
}

function cleanupPeerConnection() {
    if (peer) { try { peer.destroy(); } catch {} }
    peer = null;
    document.getElementById('mainVideo').classList.add('hidden');
    document.getElementById('videoPlaceholder').style.display = 'block';
    document.getElementById('screenSharingLabel').classList.add('hidden');
    remoteStream = null;
    updateStatus("Waiting for connection...");
}

// --- Video handling ---
function showVideo(stream, isLocal = false) {
    const video = document.getElementById('mainVideo');
    const placeholder = document.getElementById('videoPlaceholder');
    video.srcObject = stream;
    video.classList.remove('hidden');
    placeholder.style.display = 'none';
    video.muted = isLocal; // Teacher mutes self for echo prevention
}

// --- Media controls ---
function toggleVideo() {
    if (!localStream) return;
    isVideoOn = !isVideoOn;
    localStream.getVideoTracks().forEach(track => { track.enabled = isVideoOn; });
    document.getElementById('videoBtnIcon').className = isVideoOn ? 'fas fa-video' : 'fas fa-video-slash';
}

function toggleMic() {
    if (!localStream) return;
    isMicOn = !isMicOn;
    localStream.getAudioTracks().forEach(track => { track.enabled = isMicOn; });
    document.getElementById('micBtnIcon').className = isMicOn ? 'fas fa-microphone' : 'fas fa-microphone-slash';
}

async function toggleScreenShare() {
    if (!peer) { alert('No active connection to share screen'); return; }
    try {
        if (isScreenSharing) {
            // Back to camera
            const cameraStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            localStream = cameraStream;
            isScreenSharing = false;
            await replaceTrack(cameraStream.getVideoTracks()[0], 'video');
            await replaceTrack(cameraStream.getAudioTracks()[0], 'audio');
            showVideo(cameraStream, true);
            document.getElementById('mainVideo').classList.remove('screen-sharing');
            document.getElementById('screenSharingLabel').classList.add('hidden');
        } else {
            const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
            const audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            const combinedStream = new MediaStream([
                ...screenStream.getVideoTracks(),
                ...audioStream.getAudioTracks()
            ]);
            localStream = combinedStream;
            isScreenSharing = true;
            await replaceTrack(screenStream.getVideoTracks()[0], 'video');
            await replaceTrack(audioStream.getAudioTracks()[0], 'audio');
            showVideo(combinedStream, true);
            document.getElementById('mainVideo').classList.add('screen-sharing');
            document.getElementById('screenSharingLabel').classList.remove('hidden');
            screenStream.getVideoTracks()[0].onended = () => { toggleScreenShare(); };
        }
    } catch (err) {
        alert('Screen sharing failed: ' + err.message);
    }
}

async function replaceTrack(newTrack, kind) {
    if (!peer || !peer._pc) return;
    const sender = peer._pc.getSenders().find(s => s.track && s.track.kind === kind);
    if (sender) await sender.replaceTrack(newTrack);
}

// --- Leave/end class ---
function endClass() {
    if (confirm('Are you sure you want to end the class?')) {
        cleanupPeerConnection();
        if (localStream) { localStream.getTracks().forEach(track => track.stop()); localStream = null; }
        if (ws && ws.readyState === WebSocket.OPEN) {
            ws.send(JSON.stringify({ type: "leave", room, role: userRole }));
        }
        updateStatus("Class ended");
        updateLiveIndicator(false);
    }
}
function leaveClass() {
    if (confirm('Are you sure you want to leave the class?')) {
        cleanupPeerConnection();
        if (ws && ws.readyState === WebSocket.OPEN) {
            ws.send(JSON.stringify({ type: "leave", room, role: userRole }));
        }
        updateStatus("Left class");
        updateLiveIndicator(false);
    }
}

// --- Chat ---
function appendChatMessage(message, role) {
    const chatMessages = document.getElementById('chatMessages');
    const div = document.createElement('div');
    div.className = `p-2 rounded-lg text-sm ${role === 'teacher' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white'}`;
    const time = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    div.innerHTML = `
        <div class="font-semibold">${role.charAt(0).toUpperCase() + role.slice(1)}</div>
        <div class="text-xs opacity-75">${time}</div>
        <div class="mt-1">${message}</div>
    `;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
function sendChatMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    if (message && ws && ws.readyState === WebSocket.OPEN) {
        ws.send(JSON.stringify({ type: "chat", message, role: userRole }));
        input.value = '';
    }
}

        function handleChatKeyPress(event) {
            if (event.key === 'Enter') {
                sendChatMessage();
            }
        }

        // Panel controls
        let isParticipantPanelOpen = true;
        let isChatPanelOpen = true;

        function toggleParticipantPanel() {
            isParticipantPanelOpen = !isParticipantPanelOpen;
            const panel = document.getElementById('participantPanel');
            const toggleBtn = document.getElementById('participantToggleBtn');
            const toggleIcon = document.getElementById('participantToggleIcon');
            
            if (isParticipantPanelOpen) {
                panel.classList.remove('panel-hidden');
                toggleBtn.classList.add('hidden');
                toggleIcon.className = 'fas fa-chevron-left';
            } else {
                panel.classList.add('panel-hidden');
                toggleBtn.classList.remove('hidden');
                toggleIcon.className = 'fas fa-chevron-right';
            }
        }

        function toggleChatPanel() {
            isChatPanelOpen = !isChatPanelOpen;
            const panel = document.getElementById('chatPanel');
            const toggleBtn = document.getElementById('chatToggleBtn');
            const toggleIcon = document.getElementById('chatToggleIcon');
            
            if (isChatPanelOpen) {
                panel.classList.remove('panel-right-hidden');
                toggleBtn.classList.add('hidden');
                toggleIcon.className = 'fas fa-chevron-right';
            } else {
                panel.classList.add('panel-right-hidden');
                toggleBtn.classList.remove('hidden');
                toggleIcon.className = 'fas fa-chevron-left';
            }
        }

        // Initialize connection
        joinRoom();
    </script>
</body>
</html>