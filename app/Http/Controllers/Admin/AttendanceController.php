<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Get teacher attendance records with relationships
        $teacherAttendance = Attendance::whereHas('teacher')
            ->with('teacher')
            ->latest('created_at')
            ->paginate(10, ['*'], 'teacher_page');

        // Get student attendance records  
        $studentAttendance = Attendance::whereHas('student')
            ->with('student')
            ->latest('created_at')
            ->paginate(10, ['*'], 'student_page');

        return view('admin.attendance_list', compact('studentAttendance', 'teacherAttendance'));
    }
}
