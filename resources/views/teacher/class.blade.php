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
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
        .panel {
            transition: transform 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .panel-hidden { transform: translateX(-100%); }
        .panel-right-hidden { transform: translateX(100%); }
        .screen-sharing { border-color: #22c55e !important; }
        .screen-sharing-label {
            background: #22c55e; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;
            position: absolute; top: 10px; right: 10px;
        }
        .toggle-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .toggle-btn:hover { background: rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="min-h-screen flex p-2">
    <div class="absolute top-6 left-6 bg-white/20 rounded-xl shadow px-3 py-2 flex gap-3 items-center z-40">
        <span class="text-white font-semibold">Role:</span>
        <select id="roleSelect" class="p-1 rounded">
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>
        <span class="text-white font-semibold ml-3">Room:</span>
        <input id="roomInput" class="p-1 rounded" style="width:120px;" placeholder="my-class-1" value="my-class-1">
        <button onclick="joinRoom()" class="bg-blue-600 text-white px-3 rounded">Join</button>
        <span id="status" class="ml-3 text-yellow-100 font-semibold"></span>
    </div>
    <div class="bg-gray-900 bg-opacity-90 shadow-2xl rounded-2xl w-full h-[98vh] flex flex-col backdrop-blur-md relative">
        <!-- Header -->
        <div class="flex items-center justify-between p-3 border-b border-gray-700">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Classroom: Cosmic Meet</h2>
            <span class="px-3 py-1 bg-green-500 text-white rounded-full text-sm font-semibold animate-pulse">Live</span>
        </div>
        <!-- Main Content -->
        <div class="flex flex-1 overflow-hidden relative">
            <!-- Participant Panel (Left) -->
            <div id="participantPanel" class="panel absolute top-0 left-0 w-60 h-full p-3 z-10">
                <div class="flex items-center justify-between mb-3">
                    <button onclick="toggleParticipantPanel()" class="text-white hover:text-blue-400">
                        <i id="participantToggleIcon" class="fas fa-chevron-left"></i>
                    </button>
                    <h3 class="text-lg font-semibold text-white">Participant</h3>
                </div>
                <div class="space-y-3 overflow-y-auto h-[calc(100%-70px)]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-pink-500 flex items-center justify-center text-white font-medium">S</div>
                        <span class="text-white font-medium" id="participantRoleText">Waiting...</span>
                    </div>
                </div>
            </div>
            <button id="participantToggleBtn" class="toggle-btn absolute top-1/2 left-0 p-2 rounded-r-lg text-white hidden z-20" onclick="toggleParticipantPanel()">
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
                <div class="space-y-3 overflow-y-auto h-[calc(100%-70px)]">
                    <div class="bg-gray-700 bg-opacity-50 p-2 rounded-lg text-white text-sm">Teacher: Welcome to the class!</div>
                    <div class="bg-blue-500 bg-opacity-50 p-2 rounded-lg text-white text-sm">Student: Hello, ready to learn!</div>
                </div>
            </div>
            <button id="chatToggleBtn" class="toggle-btn absolute top-1/2 right-0 p-2 rounded-l-lg text-white hidden z-20" onclick="toggleChatPanel()">
                <i class="fas fa-comments"></i>
            </button>
            <!-- Teacher Video/Screen -->
            <div class="flex-1 p-3">
                <div id="teacherVideoContainer" class="h-full flex items-center justify-center video-container">
                    <video id="teacherVideo" autoplay playsinline class="w-full h-full object- rounded-lg border-2 border-blue-400 shadow-xl hidden"></video>
                    <div id="teacherPlaceholder" class="text-white text-2xl font-medium opacity-80">Not Connected</div>
                    <div id="screenSharingLabel" class="screen-sharing-label hidden">Screen Sharing</div>
                </div>
            </div>
        </div>
        <!-- Controls -->
        <div class="flex gap-3 justify-center p-2 bg-gray-800 bg-opacity-80 rounded-lg" id="teacherControls" style="display:none;">
            <i onclick="startClass()" class="control-btn fas fa-play p-3 text-white rounded-lg shadow-lg cursor-pointer" title="Start Class"></i>
            <i onclick="toggleVideo()" class="control-btn fas fa-video p-3 text-white rounded-lg shadow-lg cursor-pointer" id="videoBtnIcon" title="Turn Off Video"></i>
            <i onclick="toggleMic()" class="control-btn fas fa-microphone p-3 text-white rounded-lg shadow-lg cursor-pointer" id="micBtnIcon" title="Mute Mic"></i>
            <i onclick="toggleScreenShare()" class="control-btn fas fa-desktop p-3 text-white rounded-lg shadow-lg cursor-pointer" id="screenShareBtnIcon" title="Share Screen"></i>
        </div>
        <div class="flex gap-3 justify-center p-2 bg-gray-800 bg-opacity-80 rounded-lg" id="studentControls" style="display:none;">
            <i onclick="leaveClass()" class="control-btn fas fa-sign-out-alt p-3 text-white rounded-lg shadow-lg cursor-pointer" title="Leave Class"></i>
        </div>
    </div>

    <script>
        // --- CONFIG ---
        const SIGNALING_URL = "ws://192.168.1.12:3001"; // <- apni local IP yahan set karo
        let userRole = "teacher";
        let room = "my-class-1";
        let ws, peer, myStream;
        let isVideoOn = true, isMicOn = true, isScreenSharing = false;
        let pendingSignals = [];

        // Role/Room UI
        document.getElementById('roleSelect').onchange = function() {
            userRole = this.value;
            updateUI();
        };
        document.getElementById('roomInput').onchange = function() {
            room = this.value;
        };

        function updateUI() {
            if(userRole === "teacher") {
                document.getElementById('teacherControls').style.display = "flex";
                document.getElementById('studentControls').style.display = "none";
                document.getElementById('participantRoleText').innerText = "Teacher";
            } else {
                document.getElementById('teacherControls').style.display = "none";
                document.getElementById('studentControls').style.display = "flex";
                document.getElementById('participantRoleText').innerText = "Student";
            }
        }
        updateUI();

        // Room join & signaling
        function joinRoom() {
            document.getElementById('status').innerText = "Joining room...";
            ws = new WebSocket(SIGNALING_URL);
            ws.onopen = () => {
                ws.send(JSON.stringify({ type: "join", room, role: userRole }));
                document.getElementById('status').innerText = "Connected to signaling.";
                if(userRole === "teacher") {
                    // Wait for student, show start controls
                } else {
                    studentInit();
                }
            };
            ws.onmessage = async (event) => {
                let data = JSON.parse(event.data);
                if(userRole === "teacher") {
                    if(data.type === "signal" && peer) {
                        peer.signal(data.signal);
                    }
                } else if(userRole === "student") {
                    if(data.type === "signal") {
                        if(peer) {
                            peer.signal(data.signal);
                        } else {
                            pendingSignals.push(data.signal);
                        }
                    }
                }
            };
        }

        // Teacher logic
        async function startClass() {
            document.getElementById('status').innerText = "Starting class...";
            try {
                myStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                showVideo(myStream);
                peer = new SimplePeer({ initiator: true, trickle: false, stream: myStream });
                peer.on('signal', data => {
                    ws.send(JSON.stringify({ type: "signal", signal: data }));
                });
                peer.on('stream', stream => {
                    showVideo(stream);
                });
                peer.on('error', err => {
                    document.getElementById('status').innerText = "WebRTC Error: " + err;
                });
                document.getElementById('status').innerText = "Class started. Waiting for student...";
            } catch (err) {
                alert('Camera/Mic access error!');
            }
        }

        // Student logic
        function studentInit() {
            peer = new SimplePeer({ initiator: false, trickle: false });
            peer.on('signal', data => {
                ws.send(JSON.stringify({ type: "signal", signal: data }));
            });
            peer.on('stream', stream => {
                showVideo(stream);
            });
            peer.on('error', err => {
                document.getElementById('status').innerText = "WebRTC Error: " + err;
            });
            document.getElementById('status').innerText = "Waiting for teacher...";
            while(pendingSignals.length) {
                peer.signal(pendingSignals.shift());
            }
        }

        // -- Video/Screen/Mic controls for TEACHER ONLY --
        function showVideo(stream) {
            const video = document.getElementById('teacherVideo');
            video.srcObject = stream;
            video.classList.remove('hidden');
            document.getElementById('teacherPlaceholder').style.display = 'none';
        }
        function toggleVideo() {
            isVideoOn = !isVideoOn;
            if(myStream) myStream.getVideoTracks().forEach(track => track.enabled = isVideoOn);
            document.getElementById('videoBtnIcon').classList.toggle('fa-video', isVideoOn);
            document.getElementById('videoBtnIcon').classList.toggle('fa-video-slash', !isVideoOn);
            document.getElementById('videoBtnIcon').title = isVideoOn ? 'Turn Off Video' : 'Turn On Video';
        }
        function toggleMic() {
            isMicOn = !isMicOn;
            if(myStream) myStream.getAudioTracks().forEach(track => track.enabled = isMicOn);
            document.getElementById('micBtnIcon').classList.toggle('fa-microphone', isMicOn);
            document.getElementById('micBtnIcon').classList.toggle('fa-microphone-slash', !isMicOn);
            document.getElementById('micBtnIcon').title = isMicOn ? 'Mute Mic' : 'Unmute Mic';
        }
        async function toggleScreenShare() {
            if(!peer) return;
            if(isScreenSharing) {
                const cameraStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                myStream = cameraStream;
                isScreenSharing = false;
                showVideo(myStream);
                const sender = peer.streams[0].getVideoTracks()[0];
                peer.replaceTrack(sender, myStream.getVideoTracks()[0], peer.streams[0]);
                document.getElementById('teacherVideo').classList.remove('screen-sharing');
                document.getElementById('screenSharingLabel').classList.add('hidden');
            } else {
                const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                myStream = screenStream;
                isScreenSharing = true;
                showVideo(myStream);
                const sender = peer.streams[0].getVideoTracks()[0];
                peer.replaceTrack(sender, screenStream.getVideoTracks()[0], peer.streams[0]);
                document.getElementById('teacherVideo').classList.add('screen-sharing');
                document.getElementById('screenSharingLabel').classList.remove('hidden');
                screenStream.getVideoTracks()[0].onended = () => { toggleScreenShare(); };
            }
        }
        function leaveClass() {
            if(peer) peer.destroy();
            location.reload();
        }

        // Side panel logic (unchanged)
        let isParticipantPanelOpen = true, isChatPanelOpen = true;
        function toggleParticipantPanel() {
            isParticipantPanelOpen = !isParticipantPanelOpen;
            const panel = document.getElementById('participantPanel');
            const toggleBtn = document.getElementById('participantToggleBtn');
            const toggleIcon = document.getElementById('participantToggleIcon');
            if (isParticipantPanelOpen) {
                panel.classList.remove('panel-hidden');
                toggleBtn.classList.add('hidden');
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            } else {
                panel.classList.add('panel-hidden');
                toggleBtn.classList.remove('hidden');
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
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
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            } else {
                panel.classList.add('panel-right-hidden');
                toggleBtn.classList.remove('hidden');
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            }
        }
    </script>
</body>
</html>
