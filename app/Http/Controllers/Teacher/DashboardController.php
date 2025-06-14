<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Klass;
use App\Models\TeacherStudent;
use App\Models\RequestComplain;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

         $students = TeacherStudent::with([
            'student.assignedClass'
        ])->where('teacher_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        $totalClasses = Klass::where('teacher_id', Auth::id())->count();
        $recentClasses = Klass::where('teacher_id', Auth::id())->where('teacherStarted', false)
            ->limit(3)
            ->get();

        return view('teacher.dashboard', compact(
            'students',
            'totalClasses',
            'recentClasses',
        ));
    }

    public function storeReqComp(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);
        $user = auth()->user();
        RequestComplain::create([
            'admin_id' =>  $user->admin_id,
            'user_id' =>  $user->id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        return response()->json(['success' => true, 'message' => 'Request sent!']);
    }
}
