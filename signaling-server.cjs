// signaling-server.cjs
const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 3001 });

let rooms = {};

wss.on('connection', function connection(ws) {
    ws.on('message', function incoming(message) {
        let data = JSON.parse(message);

        // Join room
        if (data.type === "join") {
            ws.room = data.room;
            ws.role = data.role;
            if (!rooms[data.room]) rooms[data.room] = [];
            rooms[data.room].push(ws);
            return;
        }

        // Relay signaling
        if (rooms[ws.room]) {
            rooms[ws.room].forEach(client => {
                if (client !== ws) client.send(JSON.stringify(data));
            });
        }
    });

    ws.on('close', function () {
        if (ws.room && rooms[ws.room]) {
            rooms[ws.room] = rooms[ws.room].filter(client => client !== ws);
        }
    });
});
console.log("Signaling server running on ws://192.168.1.12:3001");
