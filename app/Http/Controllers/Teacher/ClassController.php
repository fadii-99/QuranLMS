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
        $jwt = "eyJraWQiOiJ2cGFhcy1tYWdpYy1jb29raWUtMmFlOTJhOGJkYmQ3NDQxM2EwMmZkZjJjMDYyZGZmMGMvMTgzYjIyLVNBTVBMRV9BUFAiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJqaXRzaSIsImlzcyI6ImNoYXQiLCJpYXQiOjE3NDk4NjI5ODgsImV4cCI6MTc0OTg3MDE4OCwibmJmIjoxNzQ5ODYyOTgzLCJzdWIiOiJ2cGFhcy1tYWdpYy1jb29raWUtMmFlOTJhOGJkYmQ3NDQxM2EwMmZkZjJjMDYyZGZmMGMiLCJjb250ZXh0Ijp7ImZlYXR1cmVzIjp7ImxpdmVzdHJlYW1pbmciOnRydWUsIm91dGJvdW5kLWNhbGwiOnRydWUsInNpcC1vdXRib3VuZC1jYWxsIjpmYWxzZSwidHJhbnNjcmlwdGlvbiI6dHJ1ZSwicmVjb3JkaW5nIjp0cnVlLCJmbGlwIjpmYWxzZX0sInVzZXIiOnsiaGlkZGVuLWZyb20tcmVjb3JkZXIiOmZhbHNlLCJtb2RlcmF0b3IiOnRydWUsIm5hbWUiOiJmYXdkbXVoYW1tYWQxNCIsImlkIjoiZ29vZ2xlLW9hdXRoMnwxMDkxNTYyNzM0NDc5Njg1OTgxMTQiLCJhdmF0YXIiOiIiLCJlbWFpbCI6ImZhd2RtdWhhbW1hZDE0QGdtYWlsLmNvbSJ9fSwicm9vbSI6IioifQ.IpsBeantzff8WriDZ1J8YuRoDSCOgVKFoxIecl_ZB26peNx-MQzo5ans2LFfjleflcbRVdhgfQUIwMXdOfg5z1UnpF3833bKpvnwark9Dwae1UM-7IOHwsv0Omna1pvO7rMh_GEnZT0GkErF-3JIUG0GNtLcUAb7P0lmUw9OQ0ZCj969mBN1N8TQmrT24audMrd8Y-7oCP8V-XGNbYC2Ra-AkhoZVNz69oxC-C4GfOJ3CYkj1E6O6onyBVRlEt439baxUNgYnVcfIyyXE09QA8izDUXi8vkyoWY25AbJRFJq1e8doXcFEmTkr885pHLRv3Lb0OUEywe1ga9cCFgUDA";

        return view('teacher.jitsi_class', compact('room', 'role', 'class', 'jwt'));
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
            $jwt = "eyJraWQiOiJ2cGFhcy1tYWdpYy1jb29raWUtMmFlOTJhOGJkYmQ3NDQxM2EwMmZkZjJjMDYyZGZmMGMvMTgzYjIyLVNBTVBMRV9BUFAiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJqaXRzaSIsImlzcyI6ImNoYXQiLCJpYXQiOjE3NDk4NjI5ODgsImV4cCI6MTc0OTg3MDE4OCwibmJmIjoxNzQ5ODYyOTgzLCJzdWIiOiJ2cGFhcy1tYWdpYy1jb29raWUtMmFlOTJhOGJkYmQ3NDQxM2EwMmZkZjJjMDYyZGZmMGMiLCJjb250ZXh0Ijp7ImZlYXR1cmVzIjp7ImxpdmVzdHJlYW1pbmciOnRydWUsIm91dGJvdW5kLWNhbGwiOnRydWUsInNpcC1vdXRib3VuZC1jYWxsIjpmYWxzZSwidHJhbnNjcmlwdGlvbiI6dHJ1ZSwicmVjb3JkaW5nIjp0cnVlLCJmbGlwIjpmYWxzZX0sInVzZXIiOnsiaGlkZGVuLWZyb20tcmVjb3JkZXIiOmZhbHNlLCJtb2RlcmF0b3IiOnRydWUsIm5hbWUiOiJmYXdkbXVoYW1tYWQxNCIsImlkIjoiZ29vZ2xlLW9hdXRoMnwxMDkxNTYyNzM0NDc5Njg1OTgxMTQiLCJhdmF0YXIiOiIiLCJlbWFpbCI6ImZhd2RtdWhhbW1hZDE0QGdtYWlsLmNvbSJ9fSwicm9vbSI6IioifQ.IpsBeantzff8WriDZ1J8YuRoDSCOgVKFoxIecl_ZB26peNx-MQzo5ans2LFfjleflcbRVdhgfQUIwMXdOfg5z1UnpF3833bKpvnwark9Dwae1UM-7IOHwsv0Omna1pvO7rMh_GEnZT0GkErF-3JIUG0GNtLcUAb7P0lmUw9OQ0ZCj969mBN1N8TQmrT24audMrd8Y-7oCP8V-XGNbYC2Ra-AkhoZVNz69oxC-C4GfOJ3CYkj1E6O6onyBVRlEt439baxUNgYnVcfIyyXE09QA8izDUXi8vkyoWY25AbJRFJq1e8doXcFEmTkr885pHLRv3Lb0OUEywe1ga9cCFgUDA";
            return view('student.jitsi_class', compact('room', 'role', 'class', 'jwt'));
        }

        return redirect()->back()->with('error', 'Unauthorized access');
    }


    public function endClass($id)
    {
        $class = Klass::findOrFail($id);

        $class->ended = true;
        $class->save();

        $class = Klass::findOrFail($id);

        if ($class->teacher_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $class->ended = true;
        $class->status = 'completed';
        $class->save();

        Attendance::where('class_id', $class->id)
            ->where('teacher_id', $class->teacher_id)
            ->update([
                'status' => 'completed',
            ]);

        return response()->json(['success' => true, 'message' => 'Class ended successfully']);


        return response()->json(['success' => true, 'message' => 'Class ended']);
    }
}
