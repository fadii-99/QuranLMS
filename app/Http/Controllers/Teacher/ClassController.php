<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Klass;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\StudentSubject;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClassController extends Controller
{
    private $pythonApiUrl = 'http://localhost:8002/api';

    public function classList()
    {
        $user = Auth::user();
        $classes = Klass::where('teacher_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.class_list', compact('classes'));
    }

    public function startClass($id)
    {
        $class = Klass::findOrFail($id);

        if ($class->teacher_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Get enrolled students for this class
            $students = StudentSubject::where('subject_id', $class->subject_id)
                ->pluck('student_id')
                ->filter()
                ->unique()
                ->values()
                ->toArray();

            // If no students found, create empty array but still allow class to start
            if (empty($students)) {
                Log::info('No students enrolled in subject', ['subject_id' => $class->subject_id]);
                $students = [];
            }

            // If class not started yet, create room via Python API
            if (!$class->link) {
                $response = Http::post($this->pythonApiUrl . '/rooms/create', [
                    'name' => $class->title ?? 'Quran Class',
                    'subject' => $class->subject->name ?? 'Quran Studies',
                    'teacher_id' => $class->teacher_id,
                    'student_ids' => $students,
                    'duration_minutes' => 90
                ]);

                if ($response->successful()) {
                    $roomData = $response->json();
                    $class->link = $roomData['room_code'];
                    $class->teacherStarted = true;
                    $class->save();
                    
                    Log::info('Room created via Python API', ['room_code' => $roomData['room_code']]);
                } else {
                    // Fallback to local room generation
                    $roomCode = 'class_' . Str::random(12);
                    $class->link = $roomCode;
                    $class->teacherStarted = true;
                    $class->save();
                    
                    Log::warning('Python API unavailable, using fallback room generation');
                }
            }

            $timeNow = Carbon::now()->format('H:i:s');
            $adminId = Auth::user()->admin_id;

            // Record attendance for each enrolled student
            if (!empty($students)) {
                foreach ($students as $studentId) {
                    // Verify student exists before creating attendance record
                    if (User::find($studentId)) {
                        Attendance::updateOrCreate(
                            [
                                'admin_id'   => $adminId,
                                'class_id'   => $class->id,
                                'subject_id' => $class->subject_id,
                                'teacher_id' => $class->teacher_id,
                                'student_id' => $studentId,
                            ],
                            [
                                'attendance_id' => Str::uuid()->toString(),
                                'time'          => $timeNow,
                                'teacherJoined' => true,
                                'studentJoined' => false,
                                'status'        => 'started',
                            ]
                        );
                    } else {
                        Log::warning('Student not found when creating attendance', ['student_id' => $studentId]);
                    }
                }
            } else {
                Log::info('No students to create attendance records for');
            }

            return response()->json([
                'success' => true,
                'link' => route('teacher.class.smart', ['code' => $class->link]),
                'room_code' => $class->link,
                'message' => 'Class started successfully with smart classroom.',
                'python_api_status' => Http::get($this->pythonApiUrl)->successful() ? 'available' : 'unavailable'
            ]);

        } catch (\Exception $e) {
            Log::error('Error starting class: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to start class: ' . $e->getMessage()
            ], 500);
        }
    }

    public function customWebrtcRoom($code)
    {
        // Redirect to smart classroom instead
        return $this->smartClassroom($code);
    }

    public function smartClassroom($code)
    {
        $class = Klass::where('link', $code)->firstOrFail();
        $user = Auth::user();
        
        // Verify teacher access
        if ($class->teacher_id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $role = 'teacher';
        $room = $code;

        // Try to get room info from Python API
        try {
            $response = Http::get($this->pythonApiUrl . "/rooms/{$code}");
            $roomInfo = $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::warning('Could not fetch room info from Python API: ' . $e->getMessage());
            $roomInfo = null;
        }

        return view('smart_classroom', compact('room', 'role', 'class', 'roomInfo'));
    }


    public function endClass($id)
    {
        $class = Klass::findOrFail($id);

        if ($class->teacher_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Update class status
            $class->ended = true;
            $class->status = 'completed';
            $class->teacherStarted = false;
            $class->save();

            // Update attendance records
            Attendance::where('class_id', $class->id)
                ->where('teacher_id', $class->teacher_id)
                ->update([
                    'status' => 'completed',
                    'time' => Carbon::now()->format('H:i:s')
                ]);

            // Notify Python API about class end
            if ($class->link) {
                try {
                    Http::post($this->pythonApiUrl . "/rooms/{$class->link}/leave", [
                        'user_id' => Auth::id()
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Could not notify Python API about class end: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true, 
                'message' => 'Class ended successfully',
                'redirect' => route('teacher.class.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Error ending class: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to end class: ' . $e->getMessage()
            ], 500);
        }
    }

    public function endClassByCode($code)
    {
        $class = Klass::where('link', $code)->firstOrFail();
        $user = Auth::user();
        
        if ($class->teacher_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Update class status
            $class->ended = true;
            $class->teacherStarted = false;
            $class->status = 'completed';
            $class->save();

            // Update attendance records
            Attendance::where('class_id', $class->id)
                ->update([
                    'status' => 'completed',
                    'time' => Carbon::now()->format('H:i:s')
                ]);

            // Notify Python API about class end
            try {
                Http::post($this->pythonApiUrl . "/rooms/{$code}/leave", [
                    'user_id' => $user->id
                ]);
            } catch (\Exception $e) {
                Log::warning('Could not notify Python API about class end: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Class ended successfully',
                'redirect' => route('teacher.class.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Error ending class: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to end class: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getClassAnalytics($code)
    {
        $class = Klass::where('link', $code)->firstOrFail();
        $user = Auth::user();
        
        if ($class->teacher_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Get attendance report from Python API
            $response = Http::get($this->pythonApiUrl . "/rooms/{$code}/attendance");
            
            if ($response->successful()) {
                $pythonReport = $response->json();
            } else {
                $pythonReport = null;
            }

            // Get local attendance data
            $localAttendance = Attendance::where('class_id', $class->id)
                ->with(['student', 'subject'])
                ->get();

            $analytics = [
                'class_info' => [
                    'id' => $class->id,
                    'title' => $class->title,
                    'subject' => $class->subject->name ?? 'N/A',
                    'room_code' => $class->link,
                    'status' => $class->status ?? 'active'
                ],
                'attendance' => [
                    'total_enrolled' => $localAttendance->count(),
                    'present_count' => $localAttendance->where('studentJoined', true)->count(),
                    'attendance_rate' => $localAttendance->count() > 0 
                        ? round(($localAttendance->where('studentJoined', true)->count() / $localAttendance->count()) * 100, 2) 
                        : 0,
                    'details' => $localAttendance->map(function($record) {
                        return [
                            'student_name' => $record->student->name ?? 'N/A',
                            'joined' => $record->studentJoined,
                            'time' => $record->time,
                            'status' => $record->status
                        ];
                    })
                ],
                'python_api_data' => $pythonReport,
                'generated_at' => now()->toISOString()
            ];

            return response()->json([
                'success' => true,
                'analytics' => $analytics
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting class analytics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to get analytics: ' . $e->getMessage()
            ], 500);
        }
    }

    private function callPythonAPI($endpoint, $data = null, $method = 'GET')
    {
        $baseUrl = env('PYTHON_API_URL', 'http://localhost:8001');
        
        // ...existing code...
    }
}
