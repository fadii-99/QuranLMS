<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Klass;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function classList()
    {
        $user = Auth::user();
        $classes = Klass::where('teacher_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.class_list', compact('classes'));
    }

    public function startClass(Request $request, $id)
    {
        $class = Klass::findOrFail($id);

        if ($class->teacher_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($class->link) {
            // Already started
            return response()->json([
                'success' => true,
                'link' => route('teacher.class.jitsi', ['code' => $class->link]),
                'message' => 'Class already started.'
            ]);
        }

        // Generate random Jitsi room code
        $roomCode = 'class_' . Str::random(12);
        $class->link = $roomCode;
        $class->teacherStarted = true;
        $class->save();

        return response()->json([
            'success' => true,
            'link' => route('teacher.class.jitsi', ['code' => $roomCode]),
            'message' => 'Class started successfully.'
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
    $user = Auth::user();
    $role = ($class->teacher_id === $user->id) ? 'teacher' : 'student';
    $room = $code;

    return view('student.jitsi_class', compact('room', 'role', 'class'));
}

}
