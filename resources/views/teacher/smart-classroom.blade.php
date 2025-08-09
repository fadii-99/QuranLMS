// Configuration
const config = {
    pythonApiUrl: 'http://localhost:8001',
    wsUrl: 'ws://localhost:8001',
    roomCode: '{{ $roomCode }}',
    userId: {{ auth()->id() }},
    userName: '{{ auth()->user()->name }}',
    userRole: 'teacher'
};