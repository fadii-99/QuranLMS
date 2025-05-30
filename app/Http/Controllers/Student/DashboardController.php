<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Klass;
use App\Models\Attendance;



class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user();
        $attendancePresentCount = Attendance::where('student_id', $student->id)
            // ->where('status', 'present')
            ->count();
        $attendanceAbsentCount = Attendance::where('student_id', $student->id)
            // ->where('status', 'absent')
            ->count();

        $latestClass = Klass::where('student_id', $student->id)
        ->orderByDesc('created_at')
        ->first();


        return view('student.dashboard', compact(
            'attendancePresentCount',
            'attendanceAbsentCount',
            'latestClass',
        ));
    }

}
