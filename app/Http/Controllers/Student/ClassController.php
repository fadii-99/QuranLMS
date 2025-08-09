<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherStudent;
use App\Models\User;
use App\Models\Klass;
use App\Models\Attendance;
use App\Models\StudentSubject;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ClassController extends Controller
{
    private $pythonApiUrl = 'http://localhost:8002/api';

    public function classList()
    {
        $user = Auth::user();
        
        // Get classes for subjects the student is enrolled in
        $enrolledSubjects = \App\Models\StudentSubject::where('student_id', $user->id)
            ->where('active', true)
            ->pluck('subject_id');
            
        $classes = Klass::whereIn('subject_id', $enrolledSubjects)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.class_list', compact('classes'));
    }

    public function joinClass($code)
    {
        $class = Klass::where('link', $code)->firstOrFail();
        $user = Auth::user();

        // Verify student is enrolled in this class's subject
        $isEnrolled = \App\Models\StudentSubject::where('subject_id', $class->subject_id)
            ->where('student_id', $user->id)
            ->where('active', true)
            ->exists();

        if (!$isEnrolled) {
            return redirect()->back()->with('error', 'You are not enrolled in this class');
        }

        // Check if class has started
        if (!$class->teacherStarted) {
            return redirect()->back()->with('warning', 'Class has not started yet. Please wait for your teacher.');
        }

        try {
            // Join room via Python API
            $response = Http::post($this->pythonApiUrl . '/rooms/join', [
                'room_code' => $code,
                'user_id' => $user->id,
                'name' => $user->name,
                'role' => 'student'
            ]);

            if ($response->successful()) {
                $roomData = $response->json();
                Log::info('Student joined room via Python API', ['room_code' => $code, 'user_id' => $user->id]);
            } else {
                Log::warning('Python API unavailable for student join, proceeding with fallback');
            }

            // Update attendance
            Attendance::where('class_id', $class->id)
                ->where('student_id', $user->id)
                ->update([
                    'studentJoined' => true,
                    'status' => 'joined',
                    'time' => Carbon::now()->format('H:i:s')
                ]);

            $role = 'student';
            $room = $code;

            // Redirect to smart classroom
            return redirect()->route('student.class.smart', ['code' => $code]);

        } catch (\Exception $e) {
            Log::error('Error joining class: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to join class: ' . $e->getMessage());
        }
    }

    public function smartClassroom($code)
    {
        $class = Klass::where('link', $code)->firstOrFail();
        $user = Auth::user();
        
        // Verify student is enrolled in this class's subject
        $isEnrolled = StudentSubject::where('subject_id', $class->subject_id)
            ->where('student_id', $user->id)
            ->where('active', true)
            ->exists();

        if (!$isEnrolled) {
            return redirect()->back()->with('error', 'You are not enrolled in this class');
        }

        // Check if class has started
        if (!$class->teacherStarted) {
            return redirect()->back()->with('warning', 'Class has not started yet. Please wait for your teacher.');
        }

        $role = 'student';
        $room = $code;

        // Try to get room info from Python API
        try {
            $response = Http::get($this->pythonApiUrl . "/rooms/{$code}");
            $roomInfo = $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::warning('Could not fetch room info from Python API: ' . $e->getMessage());
            $roomInfo = null;
        }

        // Update attendance to show student joined
        Attendance::where('class_id', $class->id)
            ->where('student_id', $user->id)
            ->update([
                'studentJoined' => true,
                'status' => 'joined',
                'time' => Carbon::now()->format('H:i:s')
            ]);

        return view('smart_classroom', compact('room', 'role', 'class', 'roomInfo'));
    }

    public function leaveClass($code)
    {
        $class = Klass::where('link', $code)->firstOrFail();
        $user = Auth::user();

        // Verify student is enrolled in this class's subject
        $isEnrolled = \App\Models\StudentSubject::where('subject_id', $class->subject_id)
            ->where('student_id', $user->id)
            ->where('active', true)
            ->exists();

        if (!$isEnrolled) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Update attendance
            Attendance::where('class_id', $class->id)
                ->where('student_id', $user->id)
                ->update([
                    'status' => 'left',
                    'time' => Carbon::now()->format('H:i:s')
                ]);

            // Notify Python API about leaving
            try {
                Http::post($this->pythonApiUrl . "/rooms/{$code}/leave", [
                    'user_id' => $user->id
                ]);
            } catch (\Exception $e) {
                Log::warning('Could not notify Python API about student leaving: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Left class successfully',
                'redirect' => route('student.class.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Error leaving class: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to leave class: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMyAttendance()
    {
        $user = Auth::user();
        
        try {
            $attendance = Attendance::where('student_id', $user->id)
                ->with(['class', 'subject', 'teacher'])
                ->orderBy('created_at', 'desc')
                ->get();

            $stats = [
                'total_classes' => $attendance->count(),
                'attended_classes' => $attendance->where('studentJoined', true)->count(),
                'missed_classes' => $attendance->where('studentJoined', false)->count(),
                'attendance_rate' => $attendance->count() > 0 
                    ? round(($attendance->where('studentJoined', true)->count() / $attendance->count()) * 100, 2)
                    : 0
            ];

            return response()->json([
                'success' => true,
                'attendance' => $attendance,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting student attendance: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to get attendance data: ' . $e->getMessage()
            ], 500);
        }
    }
}
