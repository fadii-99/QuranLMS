<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherStudent;
use App\Models\User;
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

        if ($class->link) {
            return response()->json([
                'success' => true,
                'link' => $class->class_link,
                'message' => 'Class already started.'
            ]);
        }

        // Generate random session link (for your WebRTC app)
        $link = url('/webrtc/class/' . Str::random(16)); // Example: /webrtc/class/abcxyz123

        $class->link = $link;
        $class->teacherStarted = true;
        $class->save();

        return response()->json([
            'success' => true,
            'link' => $link,
            'message' => 'Class started successfully.'
        ]);
    }


    public function webrtcRoom($code)
    {
        // Optionally: Check if class exists in DB
        $class = Klass::where('link', url('/webrtc/class/' . $code))->first();
$room = $code; // Generate a random room ID
        // if (!$class) {
        return view('teacher.class', compact('room'));
    }
}
