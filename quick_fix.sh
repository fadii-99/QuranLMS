#!/bin/bash

echo "🔧 Quick Fix for Current Classroom Session"
echo "=========================================="

# 1. Get the current room code from the URL
ROOM_CODE="QR430399ArDF37"
echo "🏠 Current room code: $ROOM_CODE"

# 2. Create the room in Python API to match Laravel
echo "📝 Creating room in Python API..."
curl -X POST http://localhost:8002/api/rooms/create \
  -H "Content-Type: application/json" \
  -d "{
    \"name\": \"Quran Class\",
    \"subject\": \"Quran Studies\", 
    \"teacher_id\": 3,
    \"student_ids\": [4, 5],
    \"duration_minutes\": 90
  }" > /dev/null 2>&1

echo "✅ Room created (if it wasn't already)"

# 3. Instructions for manual fix
echo ""
echo "🎯 Manual Steps to Fix Current Session:"
echo "1. Teacher: Refresh your browser page"
echo "2. Student: Refresh your browser page" 
echo "3. Teacher: Click 'Start Class' again"
echo "4. Student: Should now see teacher's video immediately"
echo ""
echo "📋 Debug Steps:"
echo "1. Open browser Developer Tools (F12)"
echo "2. Check Console tab for WebSocket messages"
echo "3. Look for 'class_started' message on student side"
echo ""
echo "🔄 If still not working:"
echo "1. Stop and restart servers: ./stop_servers.sh && ./start_servers.sh"
echo "2. Clear browser cache and cookies"
echo "3. Start a completely new class"
