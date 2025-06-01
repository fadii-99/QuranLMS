// server.js
const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 3001 });

let rooms = {};

console.log('Signaling server starting on ws://localhost:3001');

wss.on('connection', function connection(ws) {
    ws.id = Math.random().toString(36).substr(2, 9);
    console.log(`New connection: ${ws.id}`);

    ws.on('message', function incoming(message) {
        let data;
        try { 
            data = JSON.parse(message); 
        } catch (err) { 
            console.log('Invalid JSON received');
            return; 
        }

        console.log(`Received from ${ws.id}:`, data.type);

        // Handle join room
        if (data.type === "join") {
            ws.room = data.room;
            ws.role = data.role;
            
            if (!rooms[data.room]) {
                rooms[data.room] = [];
            }
            
            // Remove any existing connection for this client
            rooms[data.room] = rooms[data.room].filter(client => client.id !== ws.id);
            
            // Add new connection
            rooms[data.room].push(ws);
            
            console.log(`${ws.role} joined room ${ws.room}. Total participants: ${rooms[data.room].length}`);

            // Send updated participant count to all in room
            const participantCount = rooms[data.room].length;
            rooms[data.room].forEach(client => {
                if (client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify({
                        type: "participants",
                        count: participantCount
                    }));
                }
            });

            // Notify others of the new join
            rooms[data.room].forEach(client => {
                if (client !== ws && client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify({ 
                        type: "join", 
                        role: data.role, 
                        id: ws.id 
                    }));
                }
            });
            return;
        }

        // Handle leave room
        if (data.type === "leave") {
            handleClientLeave(ws);
            return;
        }

        // Handle chat messages
        if (data.type === "chat") {
            if (ws.room && rooms[ws.room]) {
                console.log(`Chat from ${ws.role}: ${data.message}`);
                rooms[ws.room].forEach(client => {
                    if (client.readyState === WebSocket.OPEN) {
                        client.send(JSON.stringify({ 
                            type: "chat", 
                            message: data.message, 
                            role: ws.role 
                        }));
                    }
                });
            }
            return;
        }

        // Handle WebRTC signaling (offer/answer/ice candidates)
        if (data.type === "signal") {
            if (ws.room && rooms[ws.room]) {
                console.log(`Relaying WebRTC signal from ${ws.role}`);
                rooms[ws.room].forEach(client => {
                    if (client !== ws && client.readyState === WebSocket.OPEN) {
                        client.send(JSON.stringify({
                            type: "signal",
                            signal: data.signal
                        }));
                    }
                });
            }
            return;
        }
    });

    ws.on('close', function () {
        console.log(`Connection closed: ${ws.id}`);
        handleClientLeave(ws);
    });

    ws.on('error', function (error) {
        console.log(`WebSocket error for ${ws.id}:`, error);
        handleClientLeave(ws);
    });
});

function handleClientLeave(ws) {
    if (ws.room && rooms[ws.room]) {
        // Remove client from room
        rooms[ws.room] = rooms[ws.room].filter(client => client.id !== ws.id);
        
        console.log(`${ws.role || 'Unknown'} left room ${ws.room}. Remaining: ${rooms[ws.room].length}`);
        
        // Notify remaining clients
        rooms[ws.room].forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(JSON.stringify({ 
                    type: "participants", 
                    count: rooms[ws.room].length 
                }));
                client.send(JSON.stringify({ 
                    type: "leave", 
                    id: ws.id 
                }));
            }
        });
        
        // Clean up empty rooms
        if (rooms[ws.room].length === 0) {
            delete rooms[ws.room];
            console.log(`Room ${ws.room} deleted (empty)`);
        }
    }
}

// Clean up disconnected clients periodically
setInterval(() => {
    Object.keys(rooms).forEach(roomName => {
        rooms[roomName] = rooms[roomName].filter(client => 
            client.readyState === WebSocket.OPEN
        );
        
        if (rooms[roomName].length === 0) {
            delete rooms[roomName];
        }
    });
}, 30000); // Every 30 seconds

console.log("Signaling server running on ws://localhost:3001");