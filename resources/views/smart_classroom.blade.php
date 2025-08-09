<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quran LMS - Smart Classroom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-peer@9.11.1/simplepeer.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a, #4c1d95, #059669);
            animation: gradient 20s ease infinite;
            background-size: 300% 300%;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .video-container {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .video-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .control-btn {
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            position: relative;
            overflow: hidden;
        }

        .control-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .control-btn.bg-red-600 {
            background: linear-gradient(45deg, #dc2626, #b91c1c) !important;
        }

        .control-btn.bg-blue-600 {
            background: linear-gradient(45deg, #2563eb, #1d4ed8) !important;
        }

        .control-btn.bg-green-600 {
            background: linear-gradient(45deg, #16a34a, #15803d) !important;
        }

        .audio-status-indicator {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .control-btn:active {
            transform: translateY(0);
        }

        .control-btn.active {
            background: linear-gradient(45deg, #ef4444, #dc2626);
        }

        .participant-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .participant-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .chat-message {
            animation: fadeInUp 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .quality-indicator {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .quality-excellent { background: #10b981; color: white; }
        .quality-good { background: #f59e0b; color: white; }
        .quality-poor { background: #ef4444; color: white; }

        .screen-share-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #10b981;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .recording-indicator {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: #ef4444;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            animation: pulse 1.5s infinite;
        }

        .writing-mode-vertical {
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }

        /* Panel toggle animations */
        .panel-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), 
                       opacity 0.3s ease;
        }

        /* Video swap animations */
        .video-swap-transition {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Main Container -->
    <div class="glass-panel rounded-3xl shadow-2xl w-full h-screen flex flex-col m-4 overflow-hidden">
        
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-white/20">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white" id="roomTitle">Quran LMS Classroom</h1>
                    <p class="text-blue-200" id="roomSubject">Loading...</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="glass-panel px-4 py-2 rounded-full">
                    <span class="text-white font-medium">Room: </span>
                    <span class="text-blue-200 font-mono" id="roomCode">---</span>
                </div>
                <div class="glass-panel px-4 py-2 rounded-full">
                    <span class="text-white font-medium">Role: </span>
                    <span class="text-green-200 font-medium" id="userRole">---</span>
                </div>
                <div id="connectionStatus" class="px-4 py-2 rounded-full bg-yellow-500">
                    <span class="text-white font-medium">Connecting...</span>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-1 overflow-hidden">
            
            <!-- Participants Panel -->
            <div id="participantsPanel" class="glass-panel w-80 border-r border-white/20 flex flex-col transition-all duration-300">
                <div class="p-4 border-b border-white/20 flex items-center justify-between">
                    <h3 class="text-white font-semibold flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        Participants (<span id="participantCount">0</span>)
                    </h3>
                    <button onclick="toggleParticipantsPanel()" class="text-white/60 hover:text-white transition-colors">
                        <i class="fas fa-chevron-left" id="participantsToggleIcon"></i>
                    </button>
                </div>
                <div id="participantsList" class="flex-1 overflow-y-auto p-4 space-y-3">
                    <!-- Participants will be added here -->
                </div>
            </div>

            <!-- Participants Panel Toggle Button (when collapsed) -->
            <div id="participantsToggleBtn" class="hidden glass-panel w-12 border-r border-white/20 flex flex-col items-center justify-center cursor-pointer hover:bg-white/10 transition-all duration-300" onclick="toggleParticipantsPanel()">
                <i class="fas fa-users text-white/60 mb-2"></i>
                <span class="text-white/60 text-xs writing-mode-vertical transform rotate-180">Participants</span>
            </div>

            <!-- Video Area -->
            <div class="flex-1 flex flex-col">
                
                <!-- Main Video (Remote User - Bigger) -->
                <div class="flex-1 p-6">
                    <div class="video-container glass-panel rounded-2xl h-full relative">
                        <!-- Remote Video (Main/Large Display) -->
                        <video id="remoteVideo" autoplay playsinline class="w-full h-full object-cover rounded-2xl hidden"></video>
                        
                        <!-- Local Video (Small Overlay) -->
                        <div id="localVideoContainer" class="absolute top-4 right-4 w-64 h-48 rounded-xl overflow-hidden border-2 border-white/30 bg-black/50 cursor-pointer hover:scale-105 transition-transform duration-200" onclick="swapVideoLayout()">
                            <video id="mainVideo" autoplay playsinline muted class="w-full h-full object-cover rounded-xl"></video>
                            <div class="absolute bottom-2 left-2 bg-black/50 text-white text-xs px-2 py-1 rounded">
                                You
                            </div>
                        </div>
                        
                        <!-- Placeholder when no remote video -->
                        <div id="videoPlaceholder" class="flex items-center justify-center h-full text-white">
                            <div class="text-center">
                                <i class="fas fa-video-slash text-6xl mb-4 opacity-50"></i>
                                <p class="text-xl">Waiting for other participant...</p>
                                <div class="mt-4">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white mx-auto"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Overlays -->
                        <div id="qualityIndicator" class="quality-indicator hidden">HD</div>
                        <div id="screenShareIndicator" class="screen-share-indicator hidden">
                            <i class="fas fa-desktop mr-1"></i>Screen Sharing
                        </div>
                        <div id="recordingIndicator" class="recording-indicator hidden">
                            <i class="fas fa-circle mr-1"></i>REC
                        </div>
                        
                        <!-- Swap Video Layout Button -->
                        <button id="swapLayoutBtn" onclick="swapVideoLayout()" class="absolute top-4 left-4 glass-panel px-3 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/20 transition-all duration-200" title="Swap video layout">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                    </div>
                </div>

                <!-- Controls -->
                <div class="p-6 pt-0">
                    <div class="glass-panel rounded-2xl p-4 flex items-center justify-center space-x-4">
                        
                        <!-- Teacher Controls -->
                        <div id="teacherControls" class="flex space-x-4 hidden">
                            <button id="startClassBtn" onclick="startClass()" class="control-btn px-6 py-3 rounded-xl text-white font-medium">
                                <i class="fas fa-play mr-2"></i>Start Class
                            </button>
                            <button id="videoToggleBtn" onclick="toggleVideo()" class="control-btn px-4 py-3 rounded-xl text-white">
                                <i class="fas fa-video" id="videoIcon"></i>
                            </button>
                            <button id="audioToggleBtn" onclick="toggleAudio()" class="control-btn px-4 py-3 rounded-xl text-white">
                                <i class="fas fa-microphone" id="audioIcon"></i>
                            </button>
                            <button id="screenShareBtn" onclick="toggleScreenShare()" class="control-btn px-4 py-3 rounded-xl text-white">
                                <i class="fas fa-desktop" id="screenShareIcon"></i>
                            </button>
                            <button id="recordBtn" onclick="toggleRecording()" class="control-btn px-4 py-3 rounded-xl text-white">
                                <i class="fas fa-record-vinyl" id="recordIcon"></i>
                            </button>
                            <button onclick="endClass()" class="control-btn px-6 py-3 rounded-xl text-white font-medium bg-red-600 hover:bg-red-700">
                                <i class="fas fa-phone-slash mr-2"></i>End Class
                            </button>
                        </div>

                        <!-- Student Controls -->
                        <div id="studentControls" class="flex space-x-4 hidden">
                            <button id="studentVideoBtn" onclick="toggleStudentVideo()" class="control-btn px-4 py-3 rounded-xl text-white">
                                <i class="fas fa-video" id="studentVideoIcon"></i>
                            </button>
                            <button id="studentAudioBtn" onclick="toggleStudentAudio()" class="control-btn px-4 py-3 rounded-xl text-white">
                                <i class="fas fa-microphone-slash" id="studentAudioIcon"></i>
                            </button>
                            <button onclick="raiseHand()" class="control-btn px-4 py-3 rounded-xl text-white">
                                <i class="fas fa-hand-paper"></i>
                            </button>
                            <button onclick="leaveClass()" class="control-btn px-6 py-3 rounded-xl text-white font-medium bg-red-600 hover:bg-red-700">
                                <i class="fas fa-sign-out-alt mr-2"></i>Leave
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Chat Panel -->
            <div id="chatPanel" class="glass-panel w-80 border-l border-white/20 flex flex-col transition-all duration-300">
                <div class="p-4 border-b border-white/20 flex items-center justify-between">
                    <h3 class="text-white font-semibold flex items-center">
                        <i class="fas fa-comments mr-2"></i>
                        Chat
                    </h3>
                    <button onclick="toggleChatPanel()" class="text-white/60 hover:text-white transition-colors">
                        <i class="fas fa-chevron-right" id="chatToggleIcon"></i>
                    </button>
                </div>
                <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-3">
                    <!-- Chat messages will be added here -->
                </div>
                <div class="p-4 border-t border-white/20">
                    <div class="flex space-x-2">
                        <input id="chatInput" type="text" placeholder="Type a message..." 
                               class="flex-1 bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder-white/60 focus:outline-none focus:border-blue-400"
                               onkeypress="handleChatKeyPress(event)">
                        <button onclick="sendChatMessage()" class="control-btn px-4 py-2 rounded-xl text-white">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Chat Panel Toggle Button (when collapsed) -->
            <div id="chatToggleBtn" class="hidden glass-panel w-12 border-l border-white/20 flex flex-col items-center justify-center cursor-pointer hover:bg-white/10 transition-all duration-300" onclick="toggleChatPanel()">
                <i class="fas fa-comments text-white/60 mb-2"></i>
                <span class="text-white/60 text-xs writing-mode-vertical transform rotate-180">Chat</span>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Configuration
        const CONFIG = {
            PYTHON_WS_URL: 'ws://localhost:8002/ws',
            PYTHON_API_URL: 'http://localhost:8002/api',
            ICE_SERVERS: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' },
                { urls: 'stun:stun2.l.google.com:19302' }
            ]
        };

        // Global Variables
        let userRole = 'student';
        let roomCode = '';
        let userName = '';
        let userId = null;
        let ws = null;
        let peer = null;
        let localStream = null;
        let isVideoEnabled = true;
        let isAudioEnabled = true;
        let isScreenSharing = false;
        let isRecording = false;
        let isClassStarted = false;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            initializeClassroom();
        });

        async function initializeClassroom() {
            // Get room info from URL or Laravel data
            const urlParams = new URLSearchParams(window.location.search);
            roomCode = urlParams.get('room') || @json($room ?? 'test-room');
            userRole = @json($role ?? 'student');
            userName = @json(auth()->user()->name ?? 'User');
            userId = @json(auth()->user()->id ?? 1);

            // Update UI
            updateUIElements();
            
            // Initialize WebSocket connection
            await connectToSignaling();
            
            // Join room
            await joinClassroom();
        }

        function updateUIElements() {
            document.getElementById('roomCode').textContent = roomCode;
            document.getElementById('userRole').textContent = userRole.charAt(0).toUpperCase() + userRole.slice(1);
            
            // Show appropriate controls
            if (userRole === 'teacher') {
                document.getElementById('teacherControls').classList.remove('hidden');
                document.getElementById('roomTitle').textContent = 'Teaching: Quran Studies';
            } else {
                document.getElementById('studentControls').classList.remove('hidden');
                document.getElementById('roomTitle').textContent = 'Learning: Quran Studies';
            }
            
            // Update video placeholder based on role
            updateVideoLayoutForRole();
        }

        async function connectToSignaling() {
            return new Promise((resolve, reject) => {
                console.log(`🔌 Attempting to connect to WebSocket: ${CONFIG.PYTHON_WS_URL}/${roomCode}`);
                ws = new WebSocket(`${CONFIG.PYTHON_WS_URL}/${roomCode}`);
                
                ws.onopen = () => {
                    console.log('✅ Connected to Python WebSocket server');
                    updateConnectionStatus('connected');
                    
                    // Send join message
                    const joinMessage = {
                        type: 'join',
                        userId: userId,
                        userName: userName,
                        role: userRole
                    };
                    console.log('📤 Sending join message:', joinMessage);
                    sendSignalingMessage(joinMessage);
                    
                    // Request current participants list
                    setTimeout(() => {
                        console.log('📤 Requesting participants list...');
                        sendSignalingMessage({
                            type: 'get_participants'
                        });
                    }, 500);
                    
                    resolve();
                };

                ws.onmessage = handleSignalingMessage;
                
                ws.onclose = (event) => {
                    console.log('🔌 Disconnected from Python WebSocket server. Code:', event.code, 'Reason:', event.reason);
                    updateConnectionStatus('disconnected');
                    
                    // Only reconnect if it's not a user-initiated close and user hasn't left
                    if (!window.isLeavingClass && event.code !== 1000) {
                        console.log('🔄 Attempting to reconnect in 3 seconds...');
                        setTimeout(() => {
                            connectToSignaling().then(() => {
                                // If we're a student and class was started, request participants
                                if (userRole === 'student' && isClassStarted) {
                                    sendSignalingMessage({
                                        type: 'get_participants'
                                    });
                                }
                            }).catch(console.error);
                        }, 3000);
                    }
                };

                ws.onerror = (error) => {
                    console.error('❌ Python WebSocket error:', error);
                    updateConnectionStatus('error');
                    reject(error);
                };
            });
        }

        async function joinClassroom() {
            // Call Python API to join room
            try {
                const response = await fetch(`${CONFIG.PYTHON_API_URL}/rooms/join`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        room_code: roomCode,
                        user_id: userId,
                        name: userName,
                        role: userRole
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    console.log('✅ Successfully joined room via Python API');
                } else {
                    console.warn('⚠️ Failed to join room via Python API:', result.message);
                }
            } catch (error) {
                console.warn('⚠️ Python API unavailable for room join:', error);
            }

            // Handle different user roles
            if (userRole === 'teacher') {
                console.log('🎓 Teacher joining - initializing media and preparing to start class');
                await initializeMedia();
                // Auto-start class for teacher
                setTimeout(() => {
                    startClass();
                }, 1000);
            } else {
                console.log('📚 Student joining - waiting for room state information');
                // For students, show initial waiting state
                // The WebSocket join message will determine if class is already active
                document.getElementById('videoPlaceholder').innerHTML = `
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin text-6xl mb-4 text-blue-400"></i>
                        <p class="text-xl">Connecting to classroom...</p>
                        <div class="mt-4">
                            <div class="animate-pulse rounded-full h-3 w-32 bg-blue-400 mx-auto"></div>
                        </div>
                    </div>
                `;
                
                // Don't initialize media yet - wait for class_started event
                console.log('📚 Student: Waiting for server to send room state...');
            }
        }

        async function initializeMedia() {
            try {
                console.log('🎥 Initializing media devices...');
                
                localStream = await navigator.mediaDevices.getUserMedia({
                    video: { 
                        width: { ideal: 1280 }, 
                        height: { ideal: 720 }, 
                        framerate: { ideal: 30 }
                    },
                    audio: { 
                        echoCancellation: true, 
                        noiseSuppression: true,
                        autoGainControl: true,
                        sampleRate: 48000,
                        channelCount: 2,
                        latency: 0.1
                    }
                });
                
                console.log('✅ Media devices initialized successfully');
                
                // Set initial media state
                isVideoEnabled = true;
                isAudioEnabled = true;
                
                // Show local video in small overlay
                const mainVideo = document.getElementById('mainVideo');
                if (mainVideo) {
                    mainVideo.srcObject = localStream;
                    mainVideo.classList.remove('hidden');
                    mainVideo.muted = true; // Prevent feedback
                    mainVideo.volume = 0; // Ensure no local audio feedback
                    console.log('📹 Local video displayed in small overlay');
                }
                
                // Log audio track details
                const audioTracks = localStream.getAudioTracks();
                if (audioTracks.length > 0) {
                    console.log('🔊 Local audio tracks:', audioTracks.length);
                    audioTracks.forEach((track, index) => {
                        console.log(`Local audio track ${index}:`, {
                            enabled: track.enabled,
                            muted: track.muted,
                            label: track.label,
                            settings: track.getSettings ? track.getSettings() : 'N/A'
                        });
                    });
                } else {
                    console.warn('⚠️ No audio tracks in local stream');
                }
                
                // Don't hide placeholder initially - wait for remote video to connect
                // videoPlaceholder will be hidden when remote stream connects
                
                // Update button states
                const videoBtn = document.getElementById('videoToggleBtn');
                const audioBtn = document.getElementById('audioToggleBtn');
                const videoIcon = document.getElementById('videoIcon');
                const audioIcon = document.getElementById('audioIcon');
                
                if (videoBtn) {
                    videoBtn.classList.remove('bg-red-600');
                    videoBtn.classList.add('bg-blue-600');
                }
                if (audioBtn) {
                    audioBtn.classList.remove('bg-red-600');
                    audioBtn.classList.add('bg-blue-600');
                }
                if (videoIcon) videoIcon.className = 'fas fa-video';
                if (audioIcon) audioIcon.className = 'fas fa-microphone';
                
                // Update quality indicator
                updateQualityIndicator('excellent');
                
                // Optimize audio settings
                setTimeout(() => {
                    optimizeAudioSettings();
                }, 500);
                
                // Notify about initial media state after a short delay
                setTimeout(() => {
                    console.log('📡 Sending initial media state...');
                    notifyMediaUpdate();
                }, 1000);
                
                showNotification('Camera and microphone ready', 'success');
                
            } catch (error) {
                console.error('❌ Error accessing media devices:', error);
                
                let errorMessage = 'Camera/Microphone access denied';
                if (error.name === 'NotFoundError') {
                    errorMessage = 'No camera or microphone found';
                } else if (error.name === 'NotAllowedError') {
                    errorMessage = 'Please allow camera and microphone access';
                } else if (error.name === 'NotReadableError') {
                    errorMessage = 'Camera or microphone is already in use';
                }
                
                showNotification(errorMessage, 'error');
                
                // Set media state to disabled
                isVideoEnabled = false;
                isAudioEnabled = false;
                
                // Update button states for error
                const videoBtn = document.getElementById('videoToggleBtn');
                const audioBtn = document.getElementById('audioToggleBtn');
                if (videoBtn) videoBtn.classList.add('bg-red-600');
                if (audioBtn) audioBtn.classList.add('bg-red-600');
            }
        }

        function handleSignalingMessage(event) {
            const data = JSON.parse(event.data);
            console.log('📥 Received WebSocket message:', data.type, data);
            
            switch (data.type) {
                case 'participants':
                    updateParticipantsList(data.participants);
                    break;
                    
                case 'chat':
                    addChatMessage(data.message, data.userName, data.role);
                    break;
                    
                case 'signal':
                    handleWebRTCSignal(data.signal);
                    break;
                    
                case 'class_started':
                    console.log('🎓 Class started event received by:', userRole, data);
                    if (userRole === 'student') {
                        // Check if this is an immediate class start (for students joining active class)
                        if (data.immediate || data.reconnection) {
                            console.log('📚 Student joined active class - starting immediately');
                            showNotification(data.message || 'Joining active class...', 'success');
                        } else {
                            console.log('📚 Teacher started class - student connecting');
                            showNotification(`${data.teacherName} started the class!`, 'success');
                        }
                        onClassStarted();
                    } else if (userRole === 'teacher' && data.reconnection) {
                        console.log('🎓 Teacher reconnected - class was already active');
                        showNotification('Reconnected to active class', 'success');
                        isClassStarted = true;
                    }
                    break;
                    
                case 'waiting_for_teacher':
                    console.log('⏳ Waiting for teacher message received');
                    if (userRole === 'student') {
                        showNotification(data.message || 'Waiting for teacher to start class...', 'info');
                        document.getElementById('videoPlaceholder').innerHTML = `
                            <div class="text-center">
                                <i class="fas fa-clock text-6xl mb-4 text-yellow-400"></i>
                                <p class="text-xl">Waiting for teacher to start class...</p>
                                <div class="mt-4">
                                    <div class="animate-pulse rounded-full h-3 w-32 bg-yellow-400 mx-auto"></div>
                                </div>
                            </div>
                        `;
                    }
                    break;
                    
                case 'room_state':
                    console.log('📋 Room state update received:', data);
                    if (data.state === 'active' && userRole === 'student') {
                        console.log('📚 Room is active - student should connect');
                        showNotification(data.message || 'Connecting to active class...', 'success');
                    }
                    break;
                    
                case 'teacher_reconnected':
                    console.log('🎓 Teacher reconnected to class');
                    if (userRole === 'student') {
                        showNotification(`${data.teacherName} reconnected to class`, 'info');
                        // If class was active, ensure student is ready
                        if (isClassStarted) {
                            console.log('📚 Maintaining active class state for student');
                        }
                    }
                    break;
                    
                case 'class_ended':
                    console.log('🛑 Class ended event received');
                    onClassEnded();
                    break;
                    
                case 'media_update':
                    console.log('📡 Media update received:', data);
                    if (data.userId && data.mediaState) {
                        updateParticipantMedia(data.userId, data.mediaState);
                        
                        // Show notification for significant changes
                        const participantName = data.userName || `User ${data.userId}`;
                        const role = data.role || 'participant';
                        
                        if (data.mediaState.videoEnabled === false) {
                            showNotification(`${participantName} (${role}) turned off video`, 'info');
                        } else if (data.mediaState.videoEnabled === true) {
                            showNotification(`${participantName} (${role}) turned on video`, 'info');
                        }
                        
                        if (data.mediaState.audioEnabled === false) {
                            showNotification(`${participantName} (${role}) muted microphone`, 'info');
                        } else if (data.mediaState.audioEnabled === true) {
                            showNotification(`${participantName} (${role}) unmuted microphone`, 'info');
                        }
                    } else {
                        console.warn('⚠️ Invalid media update data:', data);
                    }
                    break;
                    
                case 'participant_joined':
                    console.log('👤 Participant joined:', data.participant.name);
                    showNotification(`${data.participant.name} joined the class`, 'info');
                    // Request updated participant list
                    sendSignalingMessage({
                        type: 'get_participants'
                    });
                    break;
                    
                case 'participant_left':
                    console.log('👋 Participant left:', data.name);
                    showNotification(`${data.name} left the class`, 'info');
                    // Request updated participant list
                    sendSignalingMessage({
                        type: 'get_participants'
                    });
                    break;
                    
                case 'hand_raised':
                    if (userRole === 'teacher') {
                        console.log('✋ Hand raised by:', data.participant.name);
                        showNotification(`${data.participant.name} raised their hand`, 'warning');
                    }
                    break;
                    
                case 'mute_all':
                    if (userRole === 'student') {
                        console.log('🔇 Teacher muted all students');
                        // Force mute student
                        if (isAudioEnabled) {
                            toggleStudentAudio();
                        }
                        showNotification('Teacher muted all students', 'warning');
                    }
                    break;
                    
                case 'pong':
                    // Heartbeat response
                    break;
                    
                default:
                    console.log('❓ Unknown message type:', data.type, data);
            }
        }

        function sendSignalingMessage(message) {
            if (ws && ws.readyState === WebSocket.OPEN) {
                console.log('📤 Sending WebSocket message:', message.type, message);
                ws.send(JSON.stringify(message));
            } else {
                console.error('❌ Cannot send message - WebSocket not connected. State:', ws ? ws.readyState : 'null');
            }
        }

        // Teacher Functions
        async function startClass() {
            if (!localStream) {
                await initializeMedia();
            }
            
            isClassStarted = true;
            const startBtn = document.getElementById('startClassBtn');
            if (startBtn) {
                startBtn.classList.add('hidden');
            }
            
            // First notify students that class has started
            sendSignalingMessage({
                type: 'class_control',
                action: 'start'
            });
            
            // Wait a moment for the message to be sent, then initialize WebRTC
            setTimeout(async () => {
                console.log('Teacher: Initializing WebRTC for broadcasting...');
                await initializeWebRTC();
            }, 1000);
            
            // Update UI to show class is live
            document.getElementById('videoPlaceholder').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-broadcast-tower text-6xl mb-4 text-green-400"></i>
                    <p class="text-xl">Broadcasting to students...</p>
                    <div class="mt-4">
                        <div class="animate-pulse rounded-full h-3 w-32 bg-green-400 mx-auto"></div>
                    </div>
                </div>
            `;
            
            showNotification('Class started successfully! Initializing broadcast...', 'success');
        }

        async function initializeWebRTC() {
            console.log('Initializing WebRTC for role:', userRole);
            
            // Clean up existing peer if any
            if (peer) {
                console.log('Cleaning up existing peer connection');
                peer.destroy();
                peer = null;
            }
            
            // Ensure we have local stream for both teacher and student
            if (!localStream) {
                console.log('No local stream - initializing media first...');
                await initializeMedia();
                if (!localStream) {
                    console.error('Failed to get local stream');
                    return;
                }
            }
            
            const config = {
                initiator: userRole === 'teacher',
                trickle: true, // Enable trickle for better connection
                config: { 
                    iceServers: CONFIG.ICE_SERVERS,
                    iceCandidatePoolSize: 10,
                    sdpSemantics: 'unified-plan',
                    rtcpMuxPolicy: 'require',
                    bundlePolicy: 'max-bundle'
                }
            };
            
            // Add stream for both teacher and student
            if (localStream) {
                config.stream = localStream;
                console.log(`${userRole}: Adding local stream to WebRTC`);
            }
            
            peer = new SimplePeer(config);
            console.log('WebRTC peer created with config:', config);

            peer.on('signal', (data) => {
                console.log('Sending WebRTC signal:', data.type, 'from role:', userRole);
                sendSignalingMessage({
                    type: 'signal',
                    signal: data,
                    room: roomCode,
                    role: userRole,
                    senderId: userId
                });
            });

            peer.on('stream', (stream) => {
                console.log('📺 Received remote stream for role:', userRole, 'Stream tracks:', stream.getTracks().length);
                
                // Log detailed stream information
                stream.getTracks().forEach((track, index) => {
                    console.log(`Track ${index}:`, {
                        kind: track.kind,
                        enabled: track.enabled,
                        muted: track.muted,
                        readyState: track.readyState,
                        label: track.label
                    });
                });
                
                // For both teacher and student, display remote stream in main area
                let remoteVideo = document.getElementById('remoteVideo');
                if (remoteVideo) {
                    remoteVideo.srcObject = stream;
                    remoteVideo.style.display = 'block';
                    remoteVideo.volume = 1.0; // Ensure full volume
                    remoteVideo.muted = false; // Allow audio from remote
                    
                    // Hide placeholder when remote video starts
                    const videoPlaceholder = document.getElementById('videoPlaceholder');
                    if (videoPlaceholder) {
                        videoPlaceholder.style.display = 'none';
                    }
                    
                    // Handle audio tracks specifically
                    const audioTracks = stream.getAudioTracks();
                    if (audioTracks.length > 0) {
                        console.log('🔊 Remote audio tracks found:', audioTracks.length);
                        audioTracks.forEach((track, index) => {
                            console.log(`Audio track ${index}:`, {
                                enabled: track.enabled,
                                muted: track.muted,
                                label: track.label,
                                settings: track.getSettings ? track.getSettings() : 'N/A'
                            });
                        });
                        
                        // Ensure audio tracks are enabled
                        audioTracks.forEach(track => {
                            track.enabled = true;
                        });
                    } else {
                        console.warn('⚠️ No audio tracks in remote stream');
                    }
                    
                    // Ensure video plays with audio
                    remoteVideo.play().catch(e => {
                        console.log('Auto-play prevented for remote video, user interaction required');
                        showNotification('Click to start remote video', 'info');
                        
                        // Add click handler to start playback
                        remoteVideo.onclick = () => {
                            remoteVideo.play().then(() => {
                                console.log('✅ Remote video playback started after user interaction');
                                remoteVideo.onclick = null; // Remove click handler
                            }).catch(err => {
                                console.error('❌ Failed to start remote video:', err);
                            });
                        };
                    });
                    
                    const remoteName = userRole === 'teacher' ? 'Student' : 'Teacher';
                    showNotification(`Connected to ${remoteName}!`, 'success');
                    updateConnectionStatus('connected');
                    
                    console.log('✅ Remote stream connected successfully - displaying in main area');
                } else {
                    console.error('❌ Could not find remote video element');
                }
            });

            peer.on('connect', () => {
                console.log('✅ WebRTC peer connected for role:', userRole);
                updateConnectionStatus('connected');
                showNotification('Peer-to-peer connection established', 'success');
            });

            peer.on('error', (error) => {
                console.error('❌ WebRTC error for role:', userRole, error);
                
                // Don't show user-initiated abort as error
                if (!error.message.includes('User-Initiated Abort')) {
                    showNotification('Connection error: ' + error.message, 'error');
                }
                
                // Only retry if it's not a user-initiated abort
                if (!error.message.includes('User-Initiated Abort') && !error.message.includes('Close called')) {
                    setTimeout(() => {
                        console.log('Attempting WebRTC reconnection...');
                        initializeWebRTC();
                    }, 3000);
                }
            });
            
            peer.on('close', () => {
                console.log('🔌 WebRTC peer connection closed for role:', userRole);
                updateConnectionStatus('disconnected');
            });
            
            // Log stream details
            if (localStream) {
                console.log('📊 Local stream details:', {
                    videoTracks: localStream.getVideoTracks().length,
                    audioTracks: localStream.getAudioTracks().length,
                    videoEnabled: localStream.getVideoTracks()[0]?.enabled,
                    audioEnabled: localStream.getAudioTracks()[0]?.enabled
                });
            }
        }

        function handleWebRTCSignal(signal) {
            console.log('Received WebRTC signal:', signal.type, 'from:', signal.senderId || 'unknown', 'to role:', userRole);
            
            // Students should initialize WebRTC when they receive an offer from teacher
            if (userRole === 'student' && signal.type === 'offer') {
                console.log('Student: Received offer from teacher, initializing WebRTC...');
                if (peer) {
                    console.log('Student: Destroying existing peer before creating new one');
                    peer.destroy();
                    peer = null;
                }
                
                // Ensure student has media stream before answering
                if (!localStream) {
                    console.log('Student: No local stream, initializing media first...');
                    initializeMedia().then(() => {
                        console.log('Student: Media initialized, now creating WebRTC connection...');
                        initializeWebRTC().then(() => {
                            if (peer && !peer.destroyed) {
                                try {
                                    peer.signal(signal);
                                    console.log('Student: Successfully handled teacher offer with media');
                                } catch (error) {
                                    console.error('Student: Error handling offer signal:', error);
                                }
                            } else {
                                console.error('Student: Peer not ready to handle offer');
                            }
                        }).catch(error => {
                            console.error('Student: Error initializing WebRTC:', error);
                        });
                    }).catch(error => {
                        console.error('Student: Error initializing media:', error);
                        // Try to proceed without media
                        initializeWebRTC().then(() => {
                            if (peer && !peer.destroyed) {
                                peer.signal(signal);
                            }
                        });
                    });
                } else {
                    // Student has media, proceed with WebRTC
                    initializeWebRTC().then(() => {
                        if (peer && !peer.destroyed) {
                            try {
                                peer.signal(signal);
                                console.log('Student: Successfully handled teacher offer');
                            } catch (error) {
                                console.error('Student: Error handling offer signal:', error);
                            }
                        } else {
                            console.error('Student: Peer not ready to handle offer');
                        }
                    }).catch(error => {
                        console.error('Student: Error initializing WebRTC:', error);
                    });
                }
                return;
            }
            
            // Handle other signal types if peer exists
            if (peer && !peer.destroyed) {
                try {
                    peer.signal(signal);
                    console.log('Successfully handled signal:', signal.type);
                } catch (error) {
                    console.error('Error handling signal:', error);
                    
                    // If signal handling fails, try to reinitialize for teachers
                    if (error.message.includes('cannot signal after peer is destroyed') && userRole === 'teacher') {
                        console.log('Teacher: Peer was destroyed, reinitializing...');
                        setTimeout(() => {
                            initializeWebRTC();
                        }, 1000);
                    }
                }
            } else {
                console.log('Received signal but no valid peer available:', {
                    signalType: signal.type,
                    userRole: userRole,
                    hasPeer: !!peer,
                    peerDestroyed: peer ? peer.destroyed : 'no peer',
                    isClassStarted: isClassStarted
                });
                
                // Store signal for later if student is waiting for class start
                if (userRole === 'student' && !isClassStarted) {
                    console.log('Student: Storing signal until class starts');
                    // You could implement a pending signals queue here if needed
                }
            }
        }

        function toggleVideo() {
            if (localStream) {
                const videoTrack = localStream.getVideoTracks()[0];
                if (videoTrack) {
                    if (isVideoEnabled) {
                        // Disable video - stop the track to turn off camera indicator
                        videoTrack.stop();
                        isVideoEnabled = false;
                        
                        // Remove the stopped track from the stream
                        localStream.removeTrack(videoTrack);
                        
                        console.log('❌ Video disabled and camera stopped');
                    } else {
                        // Enable video - get new video track
                        navigator.mediaDevices.getUserMedia({ 
                            video: { 
                                width: { ideal: 1280 }, 
                                height: { ideal: 720 }, 
                                framerate: { ideal: 30 }
                            } 
                        }).then(newStream => {
                            const newVideoTrack = newStream.getVideoTracks()[0];
                            if (newVideoTrack) {
                                // Add new video track to existing stream
                                localStream.addTrack(newVideoTrack);
                                isVideoEnabled = true;
                                
                                // Update the main video element
                                const mainVideo = document.getElementById('mainVideo');
                                if (mainVideo) {
                                    mainVideo.srcObject = localStream;
                                }
                                
                                // If we have an active peer connection, recreate it with the new stream
                                if (peer && !peer.destroyed) {
                                    recreatePeerWithNewStream();
                                }
                                
                                console.log('✅ Video enabled with new camera track');
                                updateVideoUI();
                                notifyMediaUpdate();
                                showNotification('Video enabled', 'info');
                            }
                        }).catch(error => {
                            console.error('❌ Failed to get new video track:', error);
                            showNotification('Failed to enable camera', 'error');
                            return;
                        });
                        return; // Exit here since we handle UI updates in the promise
                    }
                    
                    // Update UI for disable case
                    updateVideoUI();
                    notifyMediaUpdate();
                    showNotification(`Video ${isVideoEnabled ? 'enabled' : 'disabled'}`, 'info');
                } else {
                    console.error('❌ No video track found');
                    showNotification('No video track available', 'error');
                }
            } else {
                console.error('❌ No local stream available');
                showNotification('No camera access', 'error');
            }
        }
        
        function updateVideoUI() {
            const videoIcon = document.getElementById('videoIcon');
            const videoBtn = document.getElementById('videoToggleBtn');
            const mainVideo = document.getElementById('mainVideo');
            
            if (isVideoEnabled) {
                videoIcon.className = 'fas fa-video';
                videoBtn.classList.remove('bg-red-600');
                videoBtn.classList.add('bg-blue-600');
                if (mainVideo) mainVideo.style.display = 'block';
                console.log('✅ Video UI updated: enabled');
            } else {
                videoIcon.className = 'fas fa-video-slash';
                videoBtn.classList.remove('bg-blue-600');
                videoBtn.classList.add('bg-red-600');
                if (mainVideo) mainVideo.style.display = 'none';
                console.log('❌ Video UI updated: disabled');
            }
        }

        function toggleAudio() {
            if (localStream) {
                const audioTrack = localStream.getAudioTracks()[0];
                if (audioTrack) {
                    if (isAudioEnabled) {
                        // Disable audio - stop the track to turn off microphone indicator
                        audioTrack.stop();
                        isAudioEnabled = false;
                        
                        // Remove the stopped track from the stream
                        localStream.removeTrack(audioTrack);
                        
                        console.log('❌ Audio disabled and microphone stopped');
                    } else {
                        // Enable audio - get new audio track
                        navigator.mediaDevices.getUserMedia({ 
                            audio: { 
                                echoCancellation: true, 
                                noiseSuppression: true,
                                autoGainControl: true,
                                sampleRate: 48000,
                                channelCount: 2,
                                latency: 0.1
                            }
                        }).then(newStream => {
                            const newAudioTrack = newStream.getAudioTracks()[0];
                            if (newAudioTrack) {
                                // Add new audio track to existing stream
                                localStream.addTrack(newAudioTrack);
                                isAudioEnabled = true;
                                
                                // If we have an active peer connection, recreate it with the new stream
                                if (peer && !peer.destroyed) {
                                    recreatePeerWithNewStream();
                                }
                                
                                console.log('✅ Audio enabled with new microphone track');
                                updateAudioUI();
                                notifyMediaUpdate();
                                showNotification('Microphone enabled', 'info');
                            }
                        }).catch(error => {
                            console.error('❌ Failed to get new audio track:', error);
                            showNotification('Failed to enable microphone', 'error');
                            return;
                        });
                        return; // Exit here since we handle UI updates in the promise
                    }
                    
                    // Update UI for disable case
                    updateAudioUI();
                    notifyMediaUpdate();
                    showNotification(`Microphone ${isAudioEnabled ? 'enabled' : 'disabled'}`, 'info');
                } else {
                    console.error('❌ No audio track found');
                    showNotification('No microphone track available', 'error');
                }
            } else {
                console.error('❌ No local stream available');
                showNotification('No microphone access', 'error');
            }
        }
        
        function updateAudioUI() {
            const audioIcon = document.getElementById('audioIcon');
            const audioBtn = document.getElementById('audioToggleBtn');
            
            if (isAudioEnabled) {
                audioIcon.className = 'fas fa-microphone';
                audioBtn.classList.remove('bg-red-600');
                audioBtn.classList.add('bg-blue-600');
                console.log('✅ Audio UI updated: enabled');
            } else {
                audioIcon.className = 'fas fa-microphone-slash';
                audioBtn.classList.remove('bg-blue-600');
                audioBtn.classList.add('bg-red-600');
                console.log('❌ Audio UI updated: disabled');
            }
        }

        async function toggleScreenShare() {
            try {
                if (!isScreenSharing) {
                    console.log('🖥️ Starting screen share...');
                    const screenStream = await navigator.mediaDevices.getDisplayMedia({
                        video: {
                            mediaSource: 'screen',
                            width: { ideal: 1920 },
                            height: { ideal: 1080 },
                            framerate: { ideal: 30 }
                        },
                        audio: {
                            echoCancellation: false,
                            noiseSuppression: false,
                            autoGainControl: false
                        }
                    });
                    
                    console.log('📺 Screen stream obtained:', screenStream.getTracks().length, 'tracks');
                    
                    // Replace video track in peer connection
                    if (peer && !peer.destroyed) {
                        const videoTrack = screenStream.getVideoTracks()[0];
                        const audioTrack = screenStream.getAudioTracks()[0];
                        
                        console.log('🔄 Replacing stream for screen share...');
                        
                        // For SimplePeer, we need to recreate the connection with the new stream
                        try {
                            // Store original stream for restoration
                            window.originalStream = localStream;
                            
                            // Update local stream to screen stream
                            localStream = screenStream;
                            
                            // Recreate peer connection with screen stream using the helper function
                            recreatePeerWithNewStream();
                            
                        } catch (error) {
                            console.error('❌ Error setting up screen share:', error);
                            showNotification('Failed to start screen sharing', 'error');
                            return;
                        }
                        
                        // Update local video to show screen share
                        const mainVideo = document.getElementById('mainVideo');
                        if (mainVideo) {
                            mainVideo.srcObject = screenStream;
                        }
                        
                        // Handle screen share end
                        videoTrack.onended = () => {
                            console.log('🛑 Screen share ended');
                            stopScreenShare();
                        };
                        
                        isScreenSharing = true;
                        document.getElementById('screenShareIndicator').classList.remove('hidden');
                        updateScreenShareUI();
                        
                        // Notify participants about screen share
                        sendSignalingMessage({
                            type: 'media_update',
                            userId: userId,
                            userName: userName,
                            role: userRole,
                            mediaState: {
                                videoEnabled: isVideoEnabled,
                                audioEnabled: isAudioEnabled,
                                screenSharing: true
                            }
                        });
                        
                        showNotification('Screen sharing started', 'success');
                        console.log('✅ Screen sharing active');
                        
                    } else {
                        console.error('❌ No peer connection available for screen share');
                        showNotification('No active connection for screen sharing', 'error');
                    }
                    
                } else {
                    stopScreenShare();
                }
                
            } catch (error) {
                console.error('❌ Screen share error:', error);
                if (error.name === 'NotAllowedError') {
                    showNotification('Screen sharing permission denied', 'error');
                } else if (error.name === 'NotSupportedError') {
                    showNotification('Screen sharing not supported', 'error');
                } else {
                    showNotification('Screen sharing failed: ' + error.message, 'error');
                }
            }
        }
        
        async function stopScreenShare() {
            console.log('🛑 Stopping screen share...');
            
            try {
                // Restore original camera stream
                let cameraStream = window.originalStream || localStream;
                
                if (!cameraStream || !cameraStream.active) {
                    console.log('🎥 Original stream not available, getting new camera stream...');
                    cameraStream = await navigator.mediaDevices.getUserMedia({
                        video: { 
                            width: { ideal: 1280 }, 
                            height: { ideal: 720 }, 
                            framerate: { ideal: 30 }
                        },
                        audio: { 
                            echoCancellation: true, 
                            noiseSuppression: true,
                            autoGainControl: true,
                            sampleRate: 48000,
                            channelCount: 2,
                            latency: 0.1
                        }
                    });
                }
                
                // Replace screen stream with camera stream
                if (peer && !peer.destroyed) {
                    console.log('🔄 Replacing screen stream with camera stream...');
                    
                    // Update local stream reference
                    localStream = cameraStream;
                    
                    // Recreate peer connection with camera stream using the helper function
                    recreatePeerWithNewStream();
                }
                
                // Update local video to show camera
                const mainVideo = document.getElementById('mainVideo');
                if (mainVideo) {
                    mainVideo.srcObject = cameraStream;
                }
                
                // Update local stream reference
                localStream = cameraStream;
                
                // Clean up
                window.originalStream = null;
                isScreenSharing = false;
                document.getElementById('screenShareIndicator').classList.add('hidden');
                updateScreenShareUI();
                
                // Notify participants
                sendSignalingMessage({
                    type: 'media_update',
                    userId: userId,
                    userName: userName,
                    role: userRole,
                    mediaState: {
                        videoEnabled: isVideoEnabled,
                        audioEnabled: isAudioEnabled,
                        screenSharing: false
                    }
                });
                
                showNotification('Screen sharing stopped', 'info');
                console.log('✅ Screen sharing stopped, camera restored');
                
            } catch (error) {
                console.error('❌ Error stopping screen share:', error);
                showNotification('Error stopping screen share', 'error');
            }
        }

        function updateScreenShareUI() {
            const screenShareBtn = document.getElementById('screenShareBtn');
            const screenShareIcon = document.getElementById('screenShareIcon');
            
            if (isScreenSharing) {
                screenShareBtn.classList.add('active');
                screenShareIcon.className = 'fas fa-desktop text-red-400';
            } else {
                screenShareBtn.classList.remove('active');
                screenShareIcon.className = 'fas fa-desktop';
            }
        }

        function toggleRecording() {
            isRecording = !isRecording;
            
            const recordBtn = document.getElementById('recordBtn');
            const recordIcon = document.getElementById('recordIcon');
            const recordingIndicator = document.getElementById('recordingIndicator');
            
            if (isRecording) {
                recordBtn.classList.add('active');
                recordIcon.className = 'fas fa-stop';
                recordingIndicator.classList.remove('hidden');
                showNotification('Recording started', 'success');
            } else {
                recordBtn.classList.remove('active');
                recordIcon.className = 'fas fa-record-vinyl';
                recordingIndicator.classList.add('hidden');
                showNotification('Recording stopped', 'info');
            }
        }

        function endClass() {
            if (confirm('Are you sure you want to end the class?')) {
                window.isLeavingClass = true; // Prevent reconnection
                
                // Notify students first
                sendSignalingMessage({
                    type: 'class_control',
                    action: 'end'
                });
                
                // Clean up WebRTC connection
                if (peer) {
                    peer.destroy();
                    peer = null;
                }
                
                // Clean up media stream
                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                    localStream = null;
                }
                
                // Close WebSocket
                if (ws) {
                    ws.close(1000, 'Class ended by teacher');
                }
                
                showNotification('Class ended successfully', 'info');
                
                // Redirect to dashboard
                setTimeout(() => {
                    window.location.href = '/teacher/dashboard';
                }, 2000);
            }
        }

        // Student Functions
        function onClassStarted() {
            console.log('📚 Class started event received by student - Current state:', {
                isClassStarted: isClassStarted,
                localStream: !!localStream,
                peer: !!peer
            });
            
            isClassStarted = true;
            
            document.getElementById('videoPlaceholder').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-video text-6xl mb-4 text-green-400"></i>
                    <p class="text-xl">Connecting to teacher...</p>
                    <div class="mt-4">
                        <div class="animate-pulse rounded-full h-3 w-32 bg-green-400 mx-auto"></div>
                    </div>
                </div>
            `;
            
            // Ensure student controls are visible
            const studentControls = document.getElementById('studentControls');
            if (studentControls) {
                studentControls.classList.remove('hidden');
                console.log('📱 Student controls are now visible');
            }
            
            // Initialize student media for bidirectional communication
            if (!localStream) {
                console.log('🎥 Initializing student media for active class');
                initializeMedia().then(() => {
                    console.log('✅ Student media initialized successfully');
                    // Update button states for student
                    const studentVideoBtn = document.getElementById('studentVideoBtn');
                    const studentAudioBtn = document.getElementById('studentAudioBtn');
                    const studentVideoIcon = document.getElementById('studentVideoIcon');
                    const studentAudioIcon = document.getElementById('studentAudioIcon');
                    
                    if (studentVideoBtn && isVideoEnabled) {
                        studentVideoBtn.classList.add('bg-blue-600');
                        studentVideoBtn.classList.remove('bg-red-600');
                    }
                    if (studentAudioBtn && isAudioEnabled) {
                        studentAudioBtn.classList.add('bg-blue-600');
                        studentAudioBtn.classList.remove('bg-red-600');
                        studentAudioIcon.className = 'fas fa-microphone';
                    }
                }).catch(error => {
                    console.error('❌ Failed to initialize student media:', error);
                    showNotification('Could not access camera/microphone', 'error');
                });
            } else {
                console.log('✅ Student already has media stream');
            }
            
            // Student should be ready to receive teacher's offer
            console.log('📡 Student: Ready for bidirectional communication...');
            
            showNotification('Connected to class! Preparing video call...', 'success');
        }

        function onClassEnded() {
            showNotification('Class has ended', 'info');
            
            setTimeout(() => {
                window.location.href = '/student/dashboard';
            }, 3000);
        }
        
        // Helper function to recreate peer connection with updated stream
        // NOTE: This should only be used for major stream changes like screen sharing
        // NOT for simple track enable/disable operations (video/audio toggle)
        function recreatePeerWithNewStream() {
            if (peer && localStream && !peer.destroyed) {
                console.log('Recreating peer connection with completely new stream...');
                try {
                    // For SimplePeer, we need to recreate the peer with the new stream
                    // since SimplePeer doesn't support dynamic stream replacement like native WebRTC
                    console.log('Destroying and recreating peer connection...');
                    
                    // Store the current connection state
                    const wasConnected = peer.connected;
                    const wasInitiator = userRole === 'teacher';
                    
                    // Destroy current peer and recreate with stream
                    peer.destroy();
                    peer = null;
                    
                    // Short delay to ensure cleanup
                    setTimeout(() => {
                        // Reinitialize WebRTC which will include the current localStream
                        initializeWebRTC().then(() => {
                            console.log('✅ Peer recreated with updated stream');
                        }).catch(error => {
                            console.error('❌ Error recreating peer with stream:', error);
                        });
                    }, 100);
                    
                } catch (error) {
                    console.error('Error updating peer stream:', error);
                }
            } else {
                console.log('Cannot recreate peer:', {
                    hasPeer: !!peer,
                    hasStream: !!localStream,
                    peerDestroyed: peer ? peer.destroyed : 'no peer'
                });
            }
        }
        
        // Function to properly notify about media state changes
        function notifyMediaUpdate() {
            const mediaState = {
                videoEnabled: isVideoEnabled,
                audioEnabled: isAudioEnabled,
                screenSharing: isScreenSharing
            };
            
            console.log('📡 Sending media update:', mediaState);
            
            sendSignalingMessage({
                type: 'media_update',
                userId: userId,
                userName: userName,
                role: userRole,
                mediaState: mediaState
            });
        }
        
        // Function to handle audio quality and echo issues
        function optimizeAudioSettings() {
            if (localStream) {
                const audioTracks = localStream.getAudioTracks();
                audioTracks.forEach(track => {
                    const constraints = {
                        echoCancellation: true,
                        noiseSuppression: true,
                        autoGainControl: true,
                        sampleRate: 48000,
                        channelCount: 2
                    };
                    
                    if (track.applyConstraints) {
                        track.applyConstraints(constraints).then(() => {
                            console.log('✅ Audio constraints applied successfully');
                        }).catch(error => {
                            console.warn('⚠️ Could not apply audio constraints:', error);
                        });
                    }
                });
            }
        }

        function toggleStudentVideo() {
            // Student video control - properly stop/start camera
            if (localStream) {
                const videoTrack = localStream.getVideoTracks()[0];
                if (videoTrack) {
                    if (isVideoEnabled) {
                        // Disable video - stop the track to turn off camera indicator
                        videoTrack.stop();
                        isVideoEnabled = false;
                        
                        // Remove the stopped track from the stream
                        localStream.removeTrack(videoTrack);
                        
                        console.log('❌ Student video disabled and camera stopped');
                        updateStudentVideoUI();
                        notifyMediaUpdate();
                        showNotification('Camera disabled', 'info');
                    } else {
                        // Enable video - get new video track
                        navigator.mediaDevices.getUserMedia({ 
                            video: { 
                                width: { ideal: 1280 }, 
                                height: { ideal: 720 }, 
                                framerate: { ideal: 30 }
                            } 
                        }).then(newStream => {
                            const newVideoTrack = newStream.getVideoTracks()[0];
                            if (newVideoTrack) {
                                // Add new video track to existing stream
                                localStream.addTrack(newVideoTrack);
                                isVideoEnabled = true;
                                
                                // Update the main video element
                                const mainVideo = document.getElementById('mainVideo');
                                if (mainVideo && userRole === 'student') {
                                    mainVideo.srcObject = localStream;
                                }
                                
                                // If we have an active peer connection, recreate it with the new stream
                                if (peer && !peer.destroyed) {
                                    recreatePeerWithNewStream();
                                }
                                
                                console.log('✅ Student video enabled with new camera track');
                                updateStudentVideoUI();
                                notifyMediaUpdate();
                                showNotification('Camera enabled', 'success');
                            }
                        }).catch(error => {
                            console.error('❌ Failed to get new video track for student:', error);
                            showNotification('Failed to enable camera', 'error');
                        });
                    }
                } else {
                    console.error('❌ No video track found for student');
                    showNotification('No camera available', 'error');
                }
            } else {
                console.error('❌ No local stream available for student');
                // Initialize media if not already done
                if (!localStream) {
                    console.log('🎥 Initializing student media...');
                    initializeMedia().then(() => {
                        toggleStudentVideo(); // Try again after initialization
                    }).catch(error => {
                        console.error('❌ Failed to initialize student media:', error);
                        showNotification('Could not access camera', 'error');
                    });
                }
            }
        }
        
        function updateStudentVideoUI() {
            const studentVideoBtn = document.getElementById('studentVideoBtn');
            const studentVideoIcon = document.getElementById('studentVideoIcon');
            const mainVideo = document.getElementById('mainVideo');
            
            if (isVideoEnabled) {
                studentVideoIcon.className = 'fas fa-video';
                studentVideoBtn.classList.remove('bg-red-600');
                studentVideoBtn.classList.add('bg-blue-600');
                if (mainVideo && userRole === 'student') mainVideo.style.display = 'block';
                console.log('✅ Student video UI updated: enabled');
            } else {
                studentVideoIcon.className = 'fas fa-video-slash';
                studentVideoBtn.classList.remove('bg-blue-600');
                studentVideoBtn.classList.add('bg-red-600');
                if (mainVideo && userRole === 'student') mainVideo.style.display = 'none';
                console.log('❌ Student video UI updated: disabled');
            }
        }

        function toggleStudentAudio() {
            if (isAudioEnabled) {
                // Disable audio: stop track and remove from stream
                if (localStream) {
                    const audioTracks = localStream.getAudioTracks();
                    audioTracks.forEach(track => {
                        track.stop();
                        localStream.removeTrack(track);
                        // Remove from peer connections
                        if (teacherPeer && teacherPeer.getSenders) {
                            const senders = teacherPeer.getSenders();
                            senders.forEach(sender => {
                                if (sender.track === track) {
                                    teacherPeer.removeTrack(sender);
                                }
                            });
                        }
                    });
                }
                isAudioEnabled = false;
                updateStudentAudioUI();
                console.log('❌ Student audio disabled - track stopped');
                showNotification('Microphone disabled', 'info');
            } else {
                // Enable audio: get new track and add to stream
                navigator.mediaDevices.getUserMedia({ audio: true })
                    .then(newStream => {
                        const audioTrack = newStream.getAudioTracks()[0];
                        if (audioTrack) {
                            // Add to existing stream or create new one
                            if (!localStream) {
                                localStream = new MediaStream();
                            }
                            localStream.addTrack(audioTrack);
                            
                            // Add to peer connections
                            if (teacherPeer && teacherPeer.addTrack) {
                                teacherPeer.addTrack(audioTrack, localStream);
                            }
                            
                            isAudioEnabled = true;
                            updateStudentAudioUI();
                            console.log('✅ Student audio enabled - new track added');
                            showNotification('Microphone enabled', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Failed to get student audio:', error);
                        showNotification('Could not access microphone', 'error');
                    });
            }
            
            // Notify teacher about student's audio state
            notifyMediaUpdate();
        }
        
        function updateStudentAudioUI() {
            const studentAudioBtn = document.getElementById('studentAudioBtn');
            const studentAudioIcon = document.getElementById('studentAudioIcon');
            
            if (isAudioEnabled) {
                studentAudioIcon.className = 'fas fa-microphone';
                studentAudioBtn.classList.remove('bg-red-600');
                studentAudioBtn.classList.add('bg-blue-600');
                console.log('✅ Student audio UI updated: enabled');
            } else {
                studentAudioIcon.className = 'fas fa-microphone-slash';
                studentAudioBtn.classList.remove('bg-blue-600');
                studentAudioBtn.classList.add('bg-red-600');
                console.log('❌ Student audio UI updated: disabled');
            }
        }

        function raiseHand() {
            sendSignalingMessage({
                type: 'raise_hand'
            });
            
            showNotification('Hand raised!', 'success');
        }

        function leaveClass() {
            if (confirm('Are you sure you want to leave the class?')) {
                window.isLeavingClass = true; // Prevent reconnection
                
                // Clean up WebRTC connection
                if (peer) {
                    peer.destroy();
                    peer = null;
                }
                
                // Clean up media stream
                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                    localStream = null;
                }
                
                // Send leave message
                sendSignalingMessage({
                    type: 'leave',
                    room: roomCode,
                    userId: userId
                });
                
                // Close WebSocket with normal closure code
                if (ws) {
                    ws.close(1000, 'User left class');
                }
                
                // Redirect to dashboard
                setTimeout(() => {
                    window.location.href = '/student/dashboard';
                }, 500);
            }
        }

        // Chat Functions
        function sendChatMessage() {
            const chatInput = document.getElementById('chatInput');
            const message = chatInput.value.trim();
            
            if (message) {
                sendSignalingMessage({
                    type: 'chat',
                    message: message
                });
                
                chatInput.value = '';
            }
        }

        function handleChatKeyPress(event) {
            if (event.key === 'Enter') {
                sendChatMessage();
            }
        }

        function addChatMessage(message, senderName, senderRole) {
            const chatMessages = document.getElementById('chatMessages');
            
            const messageDiv = document.createElement('div');
            messageDiv.className = 'chat-message glass-panel rounded-xl p-3';
            
            const roleColor = senderRole === 'teacher' ? 'text-yellow-300' : 'text-blue-300';
            
            messageDiv.innerHTML = `
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 rounded-full ${senderRole === 'teacher' ? 'bg-yellow-500' : 'bg-blue-500'} flex items-center justify-center">
                        <i class="fas ${senderRole === 'teacher' ? 'fa-chalkboard-teacher' : 'fa-user-graduate'} text-white text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="${roleColor} font-medium text-sm">${senderName}</span>
                            <span class="text-white/60 text-xs">${new Date().toLocaleTimeString()}</span>
                        </div>
                        <p class="text-white text-sm">${message}</p>
                    </div>
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // UI Helper Functions
        function updateParticipantsList(participants) {
            const participantsList = document.getElementById('participantsList');
            const participantCount = document.getElementById('participantCount');
            
            participantsList.innerHTML = '';
            participantCount.textContent = participants.length;
            
            participants.forEach(participant => {
                const participantDiv = document.createElement('div');
                participantDiv.className = 'participant-item glass-panel rounded-xl p-3';
                participantDiv.dataset.userId = participant.user_id || participant.userId;
                
                const roleIcon = participant.role === 'teacher' ? 'fa-chalkboard-teacher' : 'fa-user-graduate';
                const roleColor = participant.role === 'teacher' ? 'text-yellow-300' : 'text-blue-300';
                
                participantDiv.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full ${participant.role === 'teacher' ? 'bg-yellow-500' : 'bg-blue-500'} flex items-center justify-center">
                            <i class="fas ${roleIcon} text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">${participant.name}</p>
                            <p class="${roleColor} text-sm capitalize">${participant.role}</p>
                        </div>
                        <div class="flex space-x-1">
                            ${participant.videoEnabled !== false ? '<i class="fas fa-video text-green-400 text-xs"></i>' : '<i class="fas fa-video-slash text-red-400 text-xs"></i>'}
                            ${participant.audioEnabled !== false ? '<i class="fas fa-microphone text-green-400 text-xs"></i>' : '<i class="fas fa-microphone-slash text-red-400 text-xs"></i>'}
                        </div>
                    </div>
                `;
                
                participantsList.appendChild(participantDiv);
            });
            
            console.log('Updated participants list with', participants.length, 'participants');
        }

        function updateConnectionStatus(status) {
            const statusElement = document.getElementById('connectionStatus');
            
            switch (status) {
                case 'connected':
                    statusElement.className = 'px-4 py-2 rounded-full bg-green-500';
                    statusElement.innerHTML = '<span class="text-white font-medium">Connected</span>';
                    break;
                case 'disconnected':
                    statusElement.className = 'px-4 py-2 rounded-full bg-red-500';
                    statusElement.innerHTML = '<span class="text-white font-medium">Disconnected</span>';
                    break;
                case 'error':
                    statusElement.className = 'px-4 py-2 rounded-full bg-red-600';
                    statusElement.innerHTML = '<span class="text-white font-medium">Error</span>';
                    break;
            }
        }

        function updateQualityIndicator(quality) {
            const qualityIndicator = document.getElementById('qualityIndicator');
            qualityIndicator.classList.remove('hidden');
            
            qualityIndicator.className = `quality-indicator quality-${quality}`;
            
            switch (quality) {
                case 'excellent':
                    qualityIndicator.textContent = 'HD';
                    break;
                case 'good':
                    qualityIndicator.textContent = 'SD';
                    break;
                case 'poor':
                    qualityIndicator.textContent = 'LOW';
                    break;
            }
        }

        function notifyMediaUpdate() {
            const mediaState = {
                videoEnabled: isVideoEnabled,
                audioEnabled: isAudioEnabled,
                screenSharing: isScreenSharing
            };
            
            console.log('Sending media update:', mediaState);
            
            sendSignalingMessage({
                type: 'media_update',
                userId: userId,
                userName: userName,
                role: userRole,
                mediaState: mediaState
            });
        }

        function updateParticipantMedia(userId, mediaState) {
            console.log('🔄 Updating participant media state:', { userId, mediaState });
            
            // Update participant media status in the UI
            const participantElements = document.querySelectorAll('.participant-item');
            
            participantElements.forEach(element => {
                const participantData = element.dataset.userId;
                if (participantData == userId) {
                    const videoIcon = element.querySelector('.fa-video, .fa-video-slash');
                    const audioIcon = element.querySelector('.fa-microphone, .fa-microphone-slash');
                    
                    if (videoIcon) {
                        if (mediaState.videoEnabled) {
                            videoIcon.className = 'fas fa-video text-green-400 text-xs';
                        } else {
                            videoIcon.className = 'fas fa-video-slash text-red-400 text-xs';
                        }
                    }
                    
                    if (audioIcon) {
                        if (mediaState.audioEnabled) {
                            audioIcon.className = 'fas fa-microphone text-green-400 text-xs';
                        } else {
                            audioIcon.className = 'fas fa-microphone-slash text-red-400 text-xs';
                        }
                    }
                }
            });
            
            // Also update the main participant display if it's the remote participant
            if (userId != window.userId) {
                const remoteVideoContainer = document.getElementById('remoteVideoContainer');
                if (remoteVideoContainer) {
                    // Update video visibility
                    const remoteVideo = remoteVideoContainer.querySelector('video');
                    if (remoteVideo) {
                        if (mediaState.videoEnabled) {
                            remoteVideo.style.display = 'block';
                            console.log('📹 Remote video enabled');
                        } else {
                            remoteVideo.style.display = 'none';
                            console.log('📹 Remote video disabled');
                        }
                    }
                    
                    // Update audio status indicator
                    let audioIndicator = remoteVideoContainer.querySelector('.audio-status-indicator');
                    if (!audioIndicator) {
                        audioIndicator = document.createElement('div');
                        audioIndicator.className = 'audio-status-indicator absolute top-2 right-2 px-2 py-1 rounded-full text-xs font-medium';
                        remoteVideoContainer.appendChild(audioIndicator);
                    }
                    
                    if (mediaState.audioEnabled) {
                        audioIndicator.innerHTML = '<i class="fas fa-microphone text-green-400"></i>';
                        audioIndicator.className = 'audio-status-indicator absolute top-2 right-2 px-2 py-1 rounded-full text-xs font-medium bg-green-500/20';
                    } else {
                        audioIndicator.innerHTML = '<i class="fas fa-microphone-slash text-red-400"></i>';
                        audioIndicator.className = 'audio-status-indicator absolute top-2 right-2 px-2 py-1 rounded-full text-xs font-medium bg-red-500/20';
                    }
                }
            }
            
            // Show notification for media state changes
            const participantName = userId == window.userId ? 'You' : 'Participant';
            if (mediaState.videoEnabled !== undefined) {
                const videoStatus = mediaState.videoEnabled ? 'enabled' : 'disabled';
                console.log(`📹 ${participantName} ${videoStatus} video`);
            }
            if (mediaState.audioEnabled !== undefined) {
                const audioStatus = mediaState.audioEnabled ? 'enabled' : 'disabled';
                console.log(`🎤 ${participantName} ${audioStatus} audio`);
            }
        }

        function showNotification(message, type = 'info') {
            // Create notification
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 glass-panel rounded-xl p-4 shadow-lg transform transition-all duration-300`;
            
            const bgColor = {
                'success': 'bg-green-500/20 border-green-400',
                'error': 'bg-red-500/20 border-red-400',
                'warning': 'bg-yellow-500/20 border-yellow-400',
                'info': 'bg-blue-500/20 border-blue-400'
            }[type];
            
            notification.className += ` ${bgColor}`;
            
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-info-circle text-white"></i>
                    <span class="text-white font-medium">${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Panel Toggle Functions
        function toggleParticipantsPanel() {
            const panel = document.getElementById('participantsPanel');
            const toggleBtn = document.getElementById('participantsToggleBtn');
            const toggleIcon = document.getElementById('participantsToggleIcon');
            
            if (panel.classList.contains('hidden')) {
                // Show panel
                panel.classList.remove('hidden');
                toggleBtn.classList.add('hidden');
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            } else {
                // Hide panel
                panel.classList.add('hidden');
                toggleBtn.classList.remove('hidden');
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            }
        }

        function toggleChatPanel() {
            const panel = document.getElementById('chatPanel');
            const toggleBtn = document.getElementById('chatToggleBtn');
            const toggleIcon = document.getElementById('chatToggleIcon');
            
            if (panel.classList.contains('hidden')) {
                // Show panel
                panel.classList.remove('hidden');
                toggleBtn.classList.add('hidden');
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            } else {
                // Hide panel
                panel.classList.add('hidden');
                toggleBtn.classList.remove('hidden');
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            }
        }

        // Video Layout Functions
        let isVideoLayoutSwapped = false;

        function swapVideoLayout() {
            const remoteVideo = document.getElementById('remoteVideo');
            const mainVideo = document.getElementById('mainVideo');
            const localContainer = document.getElementById('localVideoContainer');
            
            if (!remoteVideo || !mainVideo) {
                console.log('Cannot swap - videos not available');
                showNotification('Videos not available for swapping', 'warning');
                return;
            }
            
            isVideoLayoutSwapped = !isVideoLayoutSwapped;
            
            if (isVideoLayoutSwapped) {
                // Move local video to main area, remote to small
                const videoContainer = document.querySelector('.video-container');
                const remoteContainer = remoteVideo.parentElement;
                
                // Swap classes and positions
                remoteVideo.className = 'w-full h-full object-cover rounded-xl';
                mainVideo.className = 'w-full h-full object-cover rounded-2xl';
                
                console.log('📺 Video layout swapped: Local main, Remote small');
                showNotification('Video layout swapped', 'info');
            } else {
                // Restore default: Remote main, local small
                remoteVideo.className = 'w-full h-full object-cover rounded-2xl';
                mainVideo.className = 'w-full h-full object-cover rounded-xl';
                
                console.log('📺 Video layout restored: Remote main, Local small');
                showNotification('Video layout restored', 'info');
            }
        }

        // Update placeholder messages based on role
        function updateVideoLayoutForRole() {
            const videoPlaceholder = document.getElementById('videoPlaceholder');
            
            if (userRole === 'teacher') {
                if (videoPlaceholder) {
                    videoPlaceholder.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-users text-6xl mb-4 opacity-50"></i>
                            <p class="text-xl">Waiting for students to join...</p>
                            <p class="text-sm text-white/60 mt-2">Student video will appear here when they connect</p>
                            <div class="mt-4">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white mx-auto"></div>
                            </div>
                        </div>
                    `;
                }
            } else {
                if (videoPlaceholder) {
                    videoPlaceholder.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-chalkboard-teacher text-6xl mb-4 opacity-50"></i>
                            <p class="text-xl">Waiting for teacher...</p>
                            <p class="text-sm text-white/60 mt-2">Teacher video will appear here when class starts</p>
                            <div class="mt-4">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white mx-auto"></div>
                            </div>
                        </div>
                    `;
                }
            }
        }

    </script>
</body>
</html>
