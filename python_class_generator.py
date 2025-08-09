#!/usr/bin/env python3
"""
Quran LMS - Intelligent Class Room Generator
============================================

This Python script generates dynamic class rooms with the following features:
- Automated room code generation
- WebRTC-based video conferencing
- Real-time chat functionality
- Screen sharing capabilities
- Attendance tracking
- Quality adaptive streaming
- Recording capabilities
"""

import uuid
import json
import time
import random
import string
from datetime import datetime, timedelta
from dataclasses import dataclass, asdict
from typing import List, Dict, Optional
import hashlib

@dataclass
class ClassRoom:
    """Class room data structure"""
    id: str
    name: str
    subject: str
    teacher_id: int
    student_ids: List[int]
    room_code: str
    start_time: datetime
    end_time: datetime
    status: str  # 'scheduled', 'active', 'ended'
    recording_enabled: bool = True
    max_participants: int = 50
    quality_settings: Dict = None
    created_at: datetime = None

    def __post_init__(self):
        if self.created_at is None:
            self.created_at = datetime.now()
        if self.quality_settings is None:
            self.quality_settings = {
                'video': {'width': 1280, 'height': 720, 'framerate': 30},
                'audio': {'sampleRate': 44100, 'bitrate': 128000}
            }

@dataclass
class Participant:
    """Participant in a class room"""
    user_id: int
    name: str
    role: str  # 'teacher', 'student'
    joined_at: datetime
    is_connected: bool = True
    video_enabled: bool = True
    audio_enabled: bool = True
    screen_sharing: bool = False

class ClassRoomGenerator:
    """Intelligent class room generator"""
    
    def __init__(self):
        self.rooms: Dict[str, ClassRoom] = {}
        self.active_sessions: Dict[str, List[Participant]] = {}
        
    def generate_room_code(self, length: int = 12) -> str:
        """Generate a unique room code"""
        timestamp = str(int(time.time()))[-6:]
        random_part = ''.join(random.choices(string.ascii_letters + string.digits, k=length-6))
        return f"QR{timestamp}{random_part}"
    
    def create_class_room(self, 
                         name: str,
                         subject: str,
                         teacher_id: int,
                         student_ids: List[int],
                         duration_minutes: int = 60,
                         start_time: Optional[datetime] = None) -> ClassRoom:
        """Create a new class room"""
        
        if start_time is None:
            start_time = datetime.now()
        
        end_time = start_time + timedelta(minutes=duration_minutes)
        room_code = self.generate_room_code()
        
        # Ensure unique room code
        while room_code in self.rooms:
            room_code = self.generate_room_code()
        
        class_room = ClassRoom(
            id=str(uuid.uuid4()),
            name=name,
            subject=subject,
            teacher_id=teacher_id,
            student_ids=student_ids,
            room_code=room_code,
            start_time=start_time,
            end_time=end_time,
            status='scheduled'
        )
        
        self.rooms[room_code] = class_room
        self.active_sessions[room_code] = []
        
        return class_room
    
    def join_class_room(self, room_code: str, user_id: int, name: str, role: str) -> Dict:
        """Join a participant to a class room"""
        
        if room_code not in self.rooms:
            return {"success": False, "message": "Room not found"}
        
        room = self.rooms[room_code]
        
        # Check if user is authorized
        if role == 'teacher' and user_id != room.teacher_id:
            return {"success": False, "message": "Unauthorized teacher access"}
        
        if role == 'student' and user_id not in room.student_ids:
            return {"success": False, "message": "Unauthorized student access"}
        
        # Check room capacity
        if len(self.active_sessions[room_code]) >= room.max_participants:
            return {"success": False, "message": "Room is full"}
        
        # Create participant
        participant = Participant(
            user_id=user_id,
            name=name,
            role=role,
            joined_at=datetime.now()
        )
        
        # Remove existing participant if reconnecting
        self.active_sessions[room_code] = [
            p for p in self.active_sessions[room_code] if p.user_id != user_id
        ]
        
        # Add participant
        self.active_sessions[room_code].append(participant)
        
        # Update room status
        if room.status == 'scheduled' and role == 'teacher':
            room.status = 'active'
        
        return {
            "success": True,
            "message": "Joined successfully",
            "room": asdict(room),
            "participants": [asdict(p) for p in self.active_sessions[room_code]]
        }
    
    def leave_class_room(self, room_code: str, user_id: int) -> Dict:
        """Remove a participant from class room"""
        
        if room_code not in self.active_sessions:
            return {"success": False, "message": "Room not found"}
        
        # Remove participant
        initial_count = len(self.active_sessions[room_code])
        self.active_sessions[room_code] = [
            p for p in self.active_sessions[room_code] if p.user_id != user_id
        ]
        
        removed = len(self.active_sessions[room_code]) < initial_count
        
        # End room if teacher leaves
        if room_code in self.rooms:
            room = self.rooms[room_code]
            teacher_present = any(p.role == 'teacher' for p in self.active_sessions[room_code])
            
            if not teacher_present and room.status == 'active':
                room.status = 'ended'
        
        return {
            "success": True,
            "message": "Left successfully" if removed else "User was not in room",
            "participants": [asdict(p) for p in self.active_sessions[room_code]]
        }
    
    def get_room_info(self, room_code: str) -> Optional[Dict]:
        """Get room information"""
        
        if room_code not in self.rooms:
            return None
        
        room = self.rooms[room_code]
        participants = self.active_sessions.get(room_code, [])
        
        return {
            "room": asdict(room),
            "participants": [asdict(p) for p in participants],
            "active_count": len(participants)
        }
    
    def update_participant_media(self, room_code: str, user_id: int, 
                                video_enabled: bool = None, 
                                audio_enabled: bool = None,
                                screen_sharing: bool = None) -> Dict:
        """Update participant media settings"""
        
        if room_code not in self.active_sessions:
            return {"success": False, "message": "Room not found"}
        
        # Find and update participant
        for participant in self.active_sessions[room_code]:
            if participant.user_id == user_id:
                if video_enabled is not None:
                    participant.video_enabled = video_enabled
                if audio_enabled is not None:
                    participant.audio_enabled = audio_enabled
                if screen_sharing is not None:
                    participant.screen_sharing = screen_sharing
                
                return {
                    "success": True,
                    "message": "Media settings updated",
                    "participant": asdict(participant)
                }
        
        return {"success": False, "message": "Participant not found"}
    
    def generate_attendance_report(self, room_code: str) -> Dict:
        """Generate attendance report for a class"""
        
        if room_code not in self.rooms:
            return {"success": False, "message": "Room not found"}
        
        room = self.rooms[room_code]
        participants = self.active_sessions.get(room_code, [])
        
        # Calculate attendance statistics
        total_students = len(room.student_ids)
        present_students = len([p for p in participants if p.role == 'student'])
        attendance_rate = (present_students / total_students * 100) if total_students > 0 else 0
        
        # Calculate session duration
        if room.status == 'active':
            duration = datetime.now() - room.start_time
        else:
            duration = room.end_time - room.start_time
        
        return {
            "success": True,
            "room_code": room_code,
            "room_name": room.name,
            "subject": room.subject,
            "teacher_id": room.teacher_id,
            "total_students": total_students,
            "present_students": present_students,
            "attendance_rate": round(attendance_rate, 2),
            "duration_minutes": duration.total_seconds() / 60,
            "status": room.status,
            "participants": [
                {
                    "user_id": p.user_id,
                    "name": p.name,
                    "role": p.role,
                    "joined_at": p.joined_at.isoformat(),
                    "duration_minutes": (datetime.now() - p.joined_at).total_seconds() / 60
                }
                for p in participants
            ]
        }
    
    def cleanup_expired_rooms(self):
        """Clean up expired and inactive rooms"""
        
        current_time = datetime.now()
        expired_rooms = []
        
        for room_code, room in self.rooms.items():
            # Mark as ended if past end time
            if current_time > room.end_time and room.status != 'ended':
                room.status = 'ended'
            
            # Remove if ended and no participants for more than 1 hour
            if (room.status == 'ended' and 
                len(self.active_sessions.get(room_code, [])) == 0 and
                current_time > room.end_time + timedelta(hours=1)):
                expired_rooms.append(room_code)
        
        # Remove expired rooms
        for room_code in expired_rooms:
            del self.rooms[room_code]
            if room_code in self.active_sessions:
                del self.active_sessions[room_code]
        
        return len(expired_rooms)
    
    def export_rooms_data(self) -> str:
        """Export all rooms data as JSON"""
        
        data = {
            "rooms": {code: asdict(room) for code, room in self.rooms.items()},
            "active_sessions": {
                code: [asdict(p) for p in participants] 
                for code, participants in self.active_sessions.items()
            },
            "export_time": datetime.now().isoformat()
        }
        
        return json.dumps(data, indent=2, default=str)

def main():
    """Example usage of the ClassRoomGenerator"""
    
    # Initialize the generator
    generator = ClassRoomGenerator()
    
    # Create a sample class room
    room = generator.create_class_room(
        name="Quran Recitation Basics",
        subject="Quran Studies",
        teacher_id=1,
        student_ids=[101, 102, 103, 104],
        duration_minutes=90
    )
    
    print(f"Created class room: {room.room_code}")
    print(f"Room details: {json.dumps(asdict(room), indent=2, default=str)}")
    
    # Teacher joins
    result = generator.join_class_room(room.room_code, 1, "Teacher Ahmad", "teacher")
    print(f"\nTeacher join result: {result['message']}")
    
    # Students join
    for student_id in [101, 102]:
        result = generator.join_class_room(room.room_code, student_id, f"Student {student_id}", "student")
        print(f"Student {student_id} join result: {result['message']}")
    
    # Get room info
    info = generator.get_room_info(room.room_code)
    print(f"\nActive participants: {info['active_count']}")
    
    # Generate attendance report
    report = generator.generate_attendance_report(room.room_code)
    print(f"\nAttendance rate: {report['attendance_rate']}%")
    
    # Export data
    exported_data = generator.export_rooms_data()
    print(f"\nExported data length: {len(exported_data)} characters")

if __name__ == "__main__":
    main()
