#!/usr/bin/env python3
"""
FastAPI Server for Quran LMS Smart Classroom Management
=====================================================

This server provides RESTful APIs for:
- Room creation and management
- Participant tracking
- Quality monitoring
- Recording management
- Analytics and reporting
"""

from fastapi import FastAPI, HTTPException, WebSocket, WebSocketDisconnect, BackgroundTasks
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
from pydantic import BaseModel, Field
from typing import List, Dict, Optional, Any
from datetime import datetime, timedelta
import asyncio
import json
import uuid
import logging
from contextlib import asynccontextmanager
import aiohttp
import uvicorn

# Import our classroom generator
from python_class_generator import ClassRoomGenerator, ClassRoom, Participant

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Global variables
classroom_generator = ClassRoomGenerator()
active_websockets: Dict[str, List[WebSocket]] = {}

# Pydantic models for API
class CreateRoomRequest(BaseModel):
    name: str = Field(..., description="Class name")
    subject: str = Field(..., description="Subject name")
    teacher_id: int = Field(..., description="Teacher user ID")
    student_ids: List[int] = Field(..., description="List of student user IDs")
    duration_minutes: int = Field(default=60, description="Class duration in minutes")
    start_time: Optional[datetime] = Field(default=None, description="Start time (optional)")

class JoinRoomRequest(BaseModel):
    room_code: str = Field(..., description="Room code to join")
    user_id: int = Field(..., description="User ID")
    name: str = Field(..., description="User name")
    role: str = Field(..., description="User role (teacher/student)")

class MediaUpdateRequest(BaseModel):
    room_code: str = Field(..., description="Room code")
    user_id: int = Field(..., description="User ID")
    video_enabled: Optional[bool] = None
    audio_enabled: Optional[bool] = None
    screen_sharing: Optional[bool] = None

class QualityMetrics(BaseModel):
    room_code: str
    participant_id: str
    video_resolution: str
    frame_rate: int
    bitrate: int
    packet_loss: float
    latency: int
    timestamp: datetime

# FastAPI app with lifespan for cleanup
@asynccontextmanager
async def lifespan(app: FastAPI):
    # Startup
    logger.info("🚀 Starting Quran LMS Classroom API Server")
    
    # Start background cleanup task
    cleanup_task = asyncio.create_task(periodic_cleanup())
    
    yield
    
    # Shutdown
    logger.info("🛑 Shutting down Classroom API Server")
    cleanup_task.cancel()
    try:
        await cleanup_task
    except asyncio.CancelledError:
        pass

app = FastAPI(
    title="Quran LMS Smart Classroom API",
    description="Advanced classroom management system with WebRTC support",
    version="1.0.0",
    lifespan=lifespan
)

# CORS middleware
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # In production, specify actual origins
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Background cleanup task
async def periodic_cleanup():
    """Periodically clean up expired rooms and inactive sessions"""
    while True:
        try:
            cleaned = classroom_generator.cleanup_expired_rooms()
            if cleaned > 0:
                logger.info(f"🧹 Cleaned up {cleaned} expired rooms")
            await asyncio.sleep(300)  # Run every 5 minutes
        except asyncio.CancelledError:
            break
        except Exception as e:
            logger.error(f"❌ Error in cleanup task: {e}")
            await asyncio.sleep(60)  # Wait 1 minute on error

# API Endpoints

@app.get("/")
async def root():
    """API health check and information"""
    return {
        "service": "Quran LMS Smart Classroom API",
        "version": "1.0.0",
        "status": "running",
        "timestamp": datetime.now().isoformat(),
        "features": [
            "Room Creation & Management",
            "WebRTC Signaling Support", 
            "Real-time Chat",
            "Quality Monitoring",
            "Recording Management",
            "Analytics & Reporting"
        ]
    }

@app.post("/api/rooms/create")
async def create_room(request: CreateRoomRequest):
    """Create a new classroom"""
    try:
        classroom = classroom_generator.create_class_room(
            name=request.name,
            subject=request.subject,
            teacher_id=request.teacher_id,
            student_ids=request.student_ids,
            duration_minutes=request.duration_minutes,
            start_time=request.start_time
        )
        
        logger.info(f"✅ Created room {classroom.room_code} for teacher {request.teacher_id}")
        
        return {
            "success": True,
            "message": "Room created successfully",
            "room_code": classroom.room_code,
            "room_id": classroom.id,
            "start_time": classroom.start_time.isoformat(),
            "end_time": classroom.end_time.isoformat(),
            "join_url": f"/classroom?room={classroom.room_code}",
            "room_details": {
                "name": classroom.name,
                "subject": classroom.subject,
                "max_participants": classroom.max_participants,
                "recording_enabled": classroom.recording_enabled
            }
        }
        
    except Exception as e:
        logger.error(f"❌ Error creating room: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/api/rooms/join")
async def join_room(request: JoinRoomRequest):
    """Join a classroom"""
    try:
        result = classroom_generator.join_class_room(
            room_code=request.room_code,
            user_id=request.user_id,
            name=request.name,
            role=request.role
        )
        
        if result["success"]:
            logger.info(f"✅ {request.name} ({request.role}) joined room {request.room_code}")
            
            # Notify other participants via WebSocket
            await notify_room_participants(request.room_code, {
                "type": "participant_joined",
                "participant": {
                    "user_id": request.user_id,
                    "name": request.name,
                    "role": request.role,
                    "joined_at": datetime.now().isoformat()
                }
            })
            
        return result
        
    except Exception as e:
        logger.error(f"❌ Error joining room: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/api/rooms/{room_code}/leave")
async def leave_room(room_code: str, user_id: int):
    """Leave a classroom"""
    try:
        result = classroom_generator.leave_class_room(room_code, user_id)
        
        if result["success"]:
            logger.info(f"👋 User {user_id} left room {room_code}")
            
            # Notify other participants
            await notify_room_participants(room_code, {
                "type": "participant_left",
                "user_id": user_id
            })
            
        return result
        
    except Exception as e:
        logger.error(f"❌ Error leaving room: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/api/rooms/{room_code}")
async def get_room_info(room_code: str):
    """Get room information and participants"""
    try:
        info = classroom_generator.get_room_info(room_code)
        
        if info is None:
            raise HTTPException(status_code=404, detail="Room not found")
            
        return {
            "success": True,
            "data": info
        }
        
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"❌ Error getting room info: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/api/rooms")
async def list_rooms(active_only: bool = False):
    """List all rooms or only active ones"""
    try:
        all_rooms = []
        
        for room_code, room in classroom_generator.rooms.items():
            if active_only and room.status != 'active':
                continue
                
            participants = classroom_generator.active_sessions.get(room_code, [])
            room_data = {
                "room_code": room_code,
                "name": room.name,
                "subject": room.subject,
                "teacher_id": room.teacher_id,
                "status": room.status,
                "participant_count": len(participants),
                "max_participants": room.max_participants,
                "start_time": room.start_time.isoformat(),
                "end_time": room.end_time.isoformat(),
                "created_at": room.created_at.isoformat()
            }
            all_rooms.append(room_data)
        
        return {
            "success": True,
            "rooms": all_rooms,
            "total_count": len(all_rooms)
        }
        
    except Exception as e:
        logger.error(f"❌ Error listing rooms: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/api/rooms/{room_code}/media")
async def update_media_settings(room_code: str, request: MediaUpdateRequest):
    """Update participant media settings"""
    try:
        result = classroom_generator.update_participant_media(
            room_code=request.room_code,
            user_id=request.user_id,
            video_enabled=request.video_enabled,
            audio_enabled=request.audio_enabled,
            screen_sharing=request.screen_sharing
        )
        
        if result["success"]:
            # Notify other participants
            await notify_room_participants(room_code, {
                "type": "media_update",
                "user_id": request.user_id,
                "media_state": {
                    "video_enabled": request.video_enabled,
                    "audio_enabled": request.audio_enabled,
                    "screen_sharing": request.screen_sharing
                }
            })
            
        return result
        
    except Exception as e:
        logger.error(f"❌ Error updating media settings: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/api/rooms/{room_code}/attendance")
async def get_attendance_report(room_code: str):
    """Generate attendance report for a room"""
    try:
        report = classroom_generator.generate_attendance_report(room_code)
        return report
        
    except Exception as e:
        logger.error(f"❌ Error generating attendance report: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/api/rooms/{room_code}/quality")
async def submit_quality_metrics(room_code: str, metrics: QualityMetrics):
    """Submit quality metrics for monitoring"""
    try:
        # Store quality metrics (could be sent to analytics database)
        logger.info(f"📊 Quality metrics for room {room_code}: {metrics}")
        
        # You could store this in a database or send to monitoring service
        # For now, we'll just log it
        
        return {
            "success": True,
            "message": "Quality metrics recorded"
        }
        
    except Exception as e:
        logger.error(f"❌ Error recording quality metrics: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/api/analytics/summary")
async def get_analytics_summary():
    """Get overall analytics summary"""
    try:
        total_rooms = len(classroom_generator.rooms)
        active_rooms = len([r for r in classroom_generator.rooms.values() if r.status == 'active'])
        total_participants = sum(len(sessions) for sessions in classroom_generator.active_sessions.values())
        
        return {
            "success": True,
            "analytics": {
                "total_rooms_created": total_rooms,
                "active_rooms": active_rooms,
                "total_active_participants": total_participants,
                "server_uptime": datetime.now().isoformat(),
                "rooms_by_status": {
                    "scheduled": len([r for r in classroom_generator.rooms.values() if r.status == 'scheduled']),
                    "active": active_rooms,
                    "ended": len([r for r in classroom_generator.rooms.values() if r.status == 'ended'])
                }
            }
        }
        
    except Exception as e:
        logger.error(f"❌ Error getting analytics: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/api/rooms/{room_code}/export")
async def export_room_data(room_code: str):
    """Export room data and chat history"""
    try:
        info = classroom_generator.get_room_info(room_code)
        
        if info is None:
            raise HTTPException(status_code=404, detail="Room not found")
        
        # Get attendance report
        attendance = classroom_generator.generate_attendance_report(room_code)
        
        export_data = {
            "room_info": info,
            "attendance_report": attendance,
            "export_timestamp": datetime.now().isoformat(),
            "export_format": "json"
        }
        
        return {
            "success": True,
            "export_data": export_data,
            "download_ready": True
        }
        
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"❌ Error exporting room data: {e}")
        raise HTTPException(status_code=500, detail=str(e))

# WebSocket endpoint for real-time updates and WebRTC signaling
@app.websocket("/ws/{room_code}")
async def websocket_endpoint(websocket: WebSocket, room_code: str):
    """WebSocket endpoint for real-time room updates and WebRTC signaling"""
    await websocket.accept()
    
    # Add to active connections
    if room_code not in active_websockets:
        active_websockets[room_code] = []
    active_websockets[room_code].append(websocket)
    
    # Initialize connection properties
    websocket.user_id = None
    websocket.user_name = None
    websocket.user_role = None
    websocket.room_code = room_code
    
    # Auto-create room if it doesn't exist in our storage
    if room_code not in classroom_generator.rooms:
        logger.info(f"🏗️ Auto-creating room {room_code} for WebSocket connection")
        try:
            # Create a basic room structure
            classroom_generator.create_class_room(
                name=f"Auto-created Room {room_code}",
                subject="Quran Studies",
                teacher_id=1,  # Default teacher ID
                student_ids=[],
                duration_minutes=120
            )
        except Exception as e:
            logger.warning(f"Could not auto-create room {room_code}: {e}")
    
    logger.info(f"🔌 WebSocket connected to room {room_code} - Total connections: {len(active_websockets[room_code])}")
    
    try:
        while True:
            # Keep connection alive and handle incoming messages
            data = await websocket.receive_text()
            message = json.loads(data)
            
            logger.info(f"📨 Received message in room {room_code}: {message.get('type', 'unknown')} from {message.get('userName', 'unknown')}")
            
            await handle_websocket_message(websocket, message, room_code)
                
    except WebSocketDisconnect:
        logger.info(f"🔌 WebSocket disconnected from room {room_code}")
        await handle_websocket_disconnect(websocket, room_code)
    except Exception as e:
        logger.error(f"❌ WebSocket error in room {room_code}: {e}")
    finally:
        # Remove from active connections
        if room_code in active_websockets:
            try:
                active_websockets[room_code].remove(websocket)
                if not active_websockets[room_code]:
                    del active_websockets[room_code]
                logger.info(f"🔌 Cleaned up WebSocket for room {room_code} - Remaining connections: {len(active_websockets.get(room_code, []))}")
            except ValueError:
                pass

async def handle_websocket_message(websocket: WebSocket, message: dict, room_code: str):
    """Handle different types of WebSocket messages"""
    message_type = message.get("type")
    
    if message_type == "join":
        # User joining the room
        websocket.user_id = message.get("userId")
        websocket.user_name = message.get("userName") 
        websocket.user_role = message.get("role")
        
        # Get room info and current state
        room_info = classroom_generator.get_room_info(room_code)
        class_active = False
        teacher_present = False
        teacher_name = "Teacher"
        
        # Check current participants and room state
        participants = []
        for ws in active_websockets.get(room_code, []):
            if hasattr(ws, 'user_id') and ws.user_id and ws != websocket:
                participants.append({
                    "user_id": ws.user_id,
                    "name": ws.user_name,
                    "role": ws.user_role
                })
                # Check if teacher is present and get teacher's name
                if ws.user_role == "teacher":
                    teacher_present = True
                    teacher_name = ws.user_name
                    # If teacher is present, assume class is active
                    class_active = True
        
        # Also check if room has been marked as started in our system
        if room_info and room_info.get("status") == "active":
            class_active = True
        
        # Notify other participants about new user
        await notify_room_participants(room_code, {
            "type": "participant_joined",
            "participant": {
                "user_id": websocket.user_id,
                "name": websocket.user_name,
                "role": websocket.user_role,
                "joined_at": datetime.now().isoformat()
            }
        }, exclude_ws=websocket)
        
        # Send current participants list to new user
        await websocket.send_text(json.dumps({
            "type": "participants",
            "participants": participants,
            "count": len(participants) + 1
        }))
        
        # Handle different join scenarios
        if websocket.user_role == "teacher":
            # Teacher joined - if class was already active, restore state
            if class_active:
                logger.info(f"🎓 Teacher {websocket.user_name} rejoined active room {room_code}")
                # Notify all students that teacher is back and class is active
                await notify_room_participants(room_code, {
                    "type": "class_started",
                    "teacherName": websocket.user_name,
                    "message": "Teacher has reconnected - Class is active",
                    "timestamp": datetime.now().isoformat(),
                    "reconnection": True
                }, exclude_ws=websocket)
            else:
                logger.info(f"🎓 Teacher {websocket.user_name} joined room {room_code} - Class not yet started")
        
        elif websocket.user_role == "student":
            if class_active or teacher_present:
                # Class is already active - immediately send class_started
                logger.info(f"🎓 Student {websocket.user_name} joined active room {room_code} - Sending immediate class_started")
                await websocket.send_text(json.dumps({
                    "type": "class_started",
                    "teacherName": teacher_name,
                    "message": "Class is already in progress",
                    "timestamp": datetime.now().isoformat(),
                    "immediate": True
                }))
                
                # Also send current room state
                await websocket.send_text(json.dumps({
                    "type": "room_state",
                    "state": "active",
                    "teacher_present": teacher_present,
                    "teacher_name": teacher_name,
                    "message": "You have joined an active class"
                }))
            else:
                # No teacher yet or class not started
                logger.info(f"👤 Student {websocket.user_name} joined room {room_code} - Waiting for teacher")
                await websocket.send_text(json.dumps({
                    "type": "waiting_for_teacher",
                    "message": "Waiting for teacher to start the class...",
                    "timestamp": datetime.now().isoformat()
                }))
        
        # Mark room as having this participant
        if room_code in classroom_generator.rooms:
            room = classroom_generator.rooms[room_code]
            if room.status == "scheduled" and (teacher_present or websocket.user_role == "teacher"):
                room.status = "active"
                logger.info(f"📋 Room {room_code} status updated to active")
        
        logger.info(f"👤 {websocket.user_name} ({websocket.user_role}) joined room {room_code} - {len(active_websockets.get(room_code, []))} total participants")
    
    elif message_type == "signal":
        # WebRTC signaling (offer, answer, ice candidates)
        signal_data = message.get("signal")
        target_id = message.get("targetId")
        sender_role = websocket.user_role
        
        logger.info(f"🔄 WebRTC signal {signal_data.get('type')} from {sender_role} ({websocket.user_name}) in room {room_code}")
        
        if target_id:
            # Send to specific participant
            target_ws = None
            for ws in active_websockets.get(room_code, []):
                if hasattr(ws, 'user_id') and ws.user_id == target_id:
                    target_ws = ws
                    break
            
            if target_ws:
                await target_ws.send_text(json.dumps({
                    "type": "signal",
                    "signal": signal_data,
                    "senderId": websocket.user_id,
                    "senderRole": sender_role
                }))
        else:
            # Broadcast to all other participants (teacher to all students)
            participants_notified = 0
            for ws in active_websockets.get(room_code, []):
                if ws != websocket and hasattr(ws, 'user_id'):
                    try:
                        await ws.send_text(json.dumps({
                            "type": "signal", 
                            "signal": signal_data,
                            "senderId": websocket.user_id,
                            "senderRole": sender_role
                        }))
                        participants_notified += 1
                    except Exception as e:
                        logger.warning(f"Failed to send signal to participant: {e}")
            
            logger.info(f"📡 Broadcasted {signal_data.get('type')} signal to {participants_notified} participants")
        
    elif message_type == "chat":
        # Chat message
        chat_message = message.get("message", "").strip()
        if chat_message:
            await notify_room_participants(room_code, {
                "type": "chat",
                "message": chat_message,
                "userName": websocket.user_name,
                "role": websocket.user_role,
                "timestamp": datetime.now().isoformat()
            })
            logger.info(f"� Chat from {websocket.user_name}: {chat_message[:50]}...")
    
    elif message_type == "media_update":
        # Media state change (video/audio on/off, screen sharing)
        media_state = message.get("mediaState", {})
        user_name = message.get("userName", websocket.user_name)
        user_role = message.get("role", websocket.user_role)
        
        logger.info(f"🎛️ Media update from {user_name} ({user_role}): {media_state}")
        
        await notify_room_participants(room_code, {
            "type": "media_update",
            "userId": websocket.user_id,
            "userName": user_name,
            "role": user_role,
            "mediaState": media_state
        }, exclude_ws=websocket)
        
        # Log specific media changes
        if media_state.get("videoEnabled") is not None:
            video_status = "enabled" if media_state["videoEnabled"] else "disabled"
            logger.info(f"📹 {user_name} {video_status} video")
        
        if media_state.get("audioEnabled") is not None:
            audio_status = "enabled" if media_state["audioEnabled"] else "disabled"
            logger.info(f"🎤 {user_name} {audio_status} audio")
        
        if media_state.get("screenSharing") is not None:
            screen_status = "started" if media_state["screenSharing"] else "stopped"
            logger.info(f"🖥️ {user_name} {screen_status} screen sharing")
        
    elif message_type == "class_control":
        # Teacher class control (start, end, mute all, etc.)
        if websocket.user_role == "teacher":
            action = message.get("action")
            
            if action == "start":
                logger.info(f"🎓 Teacher {websocket.user_name} started class in room {room_code}")
                
                # Update room status to active
                if room_code in classroom_generator.rooms:
                    classroom_generator.rooms[room_code].status = "active"
                    logger.info(f"📋 Room {room_code} status updated to active")
                
                participants_count = len(active_websockets.get(room_code, []))
                logger.info(f"📊 Broadcasting class_started to {participants_count - 1} participants in room {room_code}")
                
                await notify_room_participants(room_code, {
                    "type": "class_started",
                    "teacherName": websocket.user_name,
                    "teacherId": websocket.user_id,
                    "timestamp": datetime.now().isoformat(),
                    "room_status": "active"
                }, exclude_ws=websocket)
                
                logger.info(f"✅ Class start notification sent to all participants in room {room_code}")
                
            elif action == "end":
                logger.info(f"🛑 Teacher {websocket.user_name} ended class in room {room_code}")
                
                # Update room status to ended
                if room_code in classroom_generator.rooms:
                    classroom_generator.rooms[room_code].status = "ended"
                    logger.info(f"📋 Room {room_code} status updated to ended")
                
                await notify_room_participants(room_code, {
                    "type": "class_ended", 
                    "reason": "teacher_ended",
                    "teacherName": websocket.user_name,
                    "timestamp": datetime.now().isoformat(),
                    "room_status": "ended"
                })
                
            elif action == "mute_all":
                logger.info(f"🔇 Teacher {websocket.user_name} muted all students in room {room_code}")
                await notify_room_participants(room_code, {
                    "type": "mute_all",
                    "teacherName": websocket.user_name
                }, exclude_ws=websocket)
        else:
            logger.warning(f"❌ Non-teacher {websocket.user_name} attempted class control in room {room_code}")
        
    elif message_type == "raise_hand":
        # Student raising hand
        if websocket.user_role == "student":
            await notify_room_participants(room_code, {
                "type": "hand_raised",
                "participant": {
                    "user_id": websocket.user_id,
                    "name": websocket.user_name
                }
            })
            logger.info(f"✋ {websocket.user_name} raised hand in room {room_code}")
    
    elif message_type == "ping":
        # Heartbeat
        await websocket.send_text(json.dumps({"type": "pong"}))
    
    elif message_type == "get_participants":
        # Send current participants list to requesting client
        participants = []
        for ws in active_websockets.get(room_code, []):
            if hasattr(ws, 'user_id'):
                participants.append({
                    "user_id": ws.user_id,
                    "name": ws.user_name,
                    "role": ws.user_role,
                    "videoEnabled": True,  # Default values
                    "audioEnabled": True
                })
        
        await websocket.send_text(json.dumps({
            "type": "participants",
            "participants": participants
        }))
        logger.info(f"📋 Sent participants list to {websocket.user_name} in room {room_code}")
    
    elif message_type == "quality_report":
        # Connection quality metrics
        stats = message.get("stats", {})
        logger.info(f"📊 Quality report from {websocket.user_name}: {stats}")
        
    else:
        logger.warning(f"❓ Unknown message type from {websocket.user_name}: {message_type}")

async def handle_websocket_disconnect(websocket: WebSocket, room_code: str):
    """Handle WebSocket disconnection"""
    if hasattr(websocket, 'user_id') and websocket.user_id:
        # Notify other participants
        await notify_room_participants(room_code, {
            "type": "participant_left", 
            "user_id": websocket.user_id,
            "name": websocket.user_name
        }, exclude_ws=websocket)
        
        # If teacher left, end the class
        if hasattr(websocket, 'user_role') and websocket.user_role == "teacher":
            await notify_room_participants(room_code, {
                "type": "class_ended",
                "reason": "teacher_left"
            })
            
        logger.info(f"👋 {websocket.user_name} ({websocket.user_role}) left room {room_code}")

async def notify_room_participants(room_code: str, message: dict, exclude_ws: WebSocket = None):
    """Send message to all WebSocket connections in a room"""
    if room_code in active_websockets:
        disconnected = []
        
        for websocket in active_websockets[room_code]:
            if websocket == exclude_ws:
                continue
                
            try:
                await websocket.send_text(json.dumps(message))
            except:
                disconnected.append(websocket)
        
        # Remove disconnected websockets
        for ws in disconnected:
            try:
                active_websockets[room_code].remove(ws)
            except ValueError:
                pass

# Integration endpoints for Laravel
@app.post("/api/laravel/sync-room")
async def sync_room_with_laravel(room_data: dict):
    """Sync room data with Laravel backend"""
    try:
        # This endpoint can be called by Laravel to sync room data
        # You would implement the logic to update your Laravel database here
        
        logger.info(f"🔄 Syncing room data with Laravel: {room_data}")
        
        return {
            "success": True,
            "message": "Room data synced with Laravel"
        }
        
    except Exception as e:
        logger.error(f"❌ Error syncing with Laravel: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/api/laravel/room/{room_code}/participants")
async def get_participants_for_laravel(room_code: str):
    """Get participant data formatted for Laravel"""
    try:
        info = classroom_generator.get_room_info(room_code)
        
        if info is None:
            raise HTTPException(status_code=404, detail="Room not found")
        
        # Format data for Laravel
        participants_data = []
        for participant in info["participants"]:
            participants_data.append({
                "user_id": participant["user_id"],
                "name": participant["name"],
                "role": participant["role"],
                "joined_at": participant["joined_at"],
                "is_connected": participant["is_connected"],
                "video_enabled": participant["video_enabled"],
                "audio_enabled": participant["audio_enabled"]
            })
        
        return {
            "success": True,
            "room_code": room_code,
            "participants": participants_data,
            "total_participants": len(participants_data)
        }
        
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"❌ Error getting participants for Laravel: {e}")
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    import uvicorn
    
    print("🚀 Starting Quran LMS Smart Classroom API Server")
    print("=" * 50)
    print("🎓 Server: FastAPI with WebSocket support")
    print("📡 API Endpoint: http://localhost:8002")
    print("📊 Documentation: http://localhost:8002/docs")
    print("🔌 WebSocket: ws://localhost:8002/ws/{room_code}")
    print("🔄 Auto-reload: Disabled")
    print("=" * 50)
    
    try:
        uvicorn.run(
            "classroom_api_server:app",
            host="0.0.0.0",
            port=8002,
            reload=False,  # Disabled auto-reload to prevent data loss
            log_level="info",
            access_log=True
        )
    except KeyboardInterrupt:
        print("\n🛑 Server stopped by user")
    except Exception as e:
        print(f"❌ Failed to start server: {e}")
        print("💡 Try changing the port in classroom_api_server.py")
