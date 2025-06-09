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

class ClassController extends Controller
{
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

        // If class not started yet, start it
        if (!$class->link) {
            $roomCode = 'class_' . Str::random(12);
            $class->link = $roomCode;
            $class->teacherStarted = true;
            $class->save();
        }

        $timeNow = Carbon::now()->format('H:i:s');
        $adminId = Auth::user()->admin_id; // fallback if admin_id is null


        // foreach ($students as $studentId) {
        Attendance::updateOrCreate(
            [
                'admin_id'      => $adminId,
                'class_id'      => $class->id,
                'subject_id'    => $class->subject_id,
                'teacher_id'    => $class->teacher_id,
                'student_id'    => $class->student_id,
                'time'          => $timeNow,
                'teacherJoined' => true,
                'studentJoined' => false,
                'status'        => 'started',
            ]
        );
        // }

        return response()->json([
            'success' => true,
            'link' => route('teacher.class.jitsi', ['code' => $class->link]),
            'message' => 'Class started and attendance recorded.',
        ]);
    }

    public function jitsiRoom($code)
    {
        $class = Klass::where('link', $code)->firstOrFail();
        $user = Auth::user();
        $role = ($class->teacher_id === $user->id) ? 'teacher' : 'student';
        $room = $code;

        return view('teacher.jitsi_class', compact('room', 'role', 'class'));
    }


    public function jitsiRoomStud($code)
    {
        $class = Klass::where('link', $code)->firstOrFail();
        if (!$class) {
            return redirect()->back()->with('error', 'Class not found');
        }

        $user = Auth::user();
        $role = ($class->student_id === $user->id) ? 'student' : 'teacher';
        $room = $code;

        if ($role === 'student') {
            Attendance::where('link', $code)
                ->update([
                    'studentJoined' => true,
                    'status' => 'joined',
                ]);

            $class->status = 'ongoing';
            $class->save();
            return view('student.jitsi_class', compact('room', 'role', 'class'));
        }

        return redirect()->back()->with('error', 'Unauthorized access');
    }
}
