<!DOCTYPE html>
<html>
<head>
    <title>Live Class - WebRTC</title>
    <style>
        video { width: 45%; margin: 10px; background: black; }
        button { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Live Class - Role: {{ $role }}</h2>
    <video id="localVideo" autoplay muted></video>
    <video id="remoteVideo" autoplay></video>

    @if ($role === 'teacher')
        <button onclick="startScreenShare()">Share Screen</button>
    @endif

    <script>
        const roomId = "{{ $room }}";
        const role = "{{ $role }}";
        const signaling = new WebSocket('ws://YOUR_SERVER_IP:3000');
        const localVideo = document.getElementById('localVideo');
        const remoteVideo = document.getElementById('remoteVideo');

        let peerConnection;
        let localStream;

        const config = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                // Add TURN server here for production
            ]
        };

        signaling.onopen = () => {
            signaling.send(JSON.stringify({ type: 'join', room: roomId }));
        };

        signaling.onmessage = async ({ data }) => {
            const message = JSON.parse(data);

            if (message.type === 'ready') {
                if (role === 'teacher') {
                    await startCall();
                }
            }

            if (message.type === 'offer' && role === 'student') {
                await createPeer(false);
                await peerConnection.setRemoteDescription(new RTCSessionDescription(message.offer));
                const answer = await peerConnection.createAnswer();
                await peerConnection.setLocalDescription(answer);
                signaling.send(JSON.stringify({ type: 'answer', answer }));
            }

            if (message.type === 'answer' && role === 'teacher') {
                await peerConnection.setRemoteDescription(new RTCSessionDescription(message.answer));
            }

            if (message.type === 'candidate') {
                if (peerConnection) {
                    await peerConnection.addIceCandidate(new RTCIceCandidate(message.candidate));
                }
            }
        };

        async function createPeer(isInitiator = true) {
            peerConnection = new RTCPeerConnection(config);

            localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));
            localVideo.srcObject = localStream;

            peerConnection.ontrack = ({ streams: [stream] }) => {
                remoteVideo.srcObject = stream;
            };

            peerConnection.onicecandidate = (e) => {
                if (e.candidate) {
                    signaling.send(JSON.stringify({ type: 'candidate', candidate: e.candidate }));
                }
            };

            if (isInitiator) {
                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer);
                signaling.send(JSON.stringify({ type: 'offer', offer }));
            }
        }

        async function startCall() {
            await createPeer(true);
        }

        async function startScreenShare() {
            const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
            const screenTrack = screenStream.getVideoTracks()[0];
            const sender = peerConnection.getSenders().find(s => s.track.kind === 'video');
            sender.replaceTrack(screenTrack);

            screenTrack.onended = () => {
                sender.replaceTrack(localStream.getVideoTracks()[0]);
            };
        }
    </script>
</body>
</html>
