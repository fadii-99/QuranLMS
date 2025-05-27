<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherStudent;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $user =Auth::user();
        $teachersData = User::where('admin_id',$user->id )->where('role', User::ROLE_TEACHER)->get();
        $teachers = $teachersData->count();
        $studentsData = User::where('admin_id',$user->id )->where('role', User::ROLE_STUDENT)->get();
        $students = $studentsData->count();
        $students = User::where('admin_id',$user->id )->where('role', )->count();

        $requests = collect([
            [
            'id' => 1,
            'type' => 'class_change',
            'status' => 'pending',
            'student_name' => 'John Doe',
            'current_class' => 'Class A',
            'requested_class' => 'Class B',
            'created_at' => now()->subDays(2)
            ],
            [
            'id' => 2,
            'type' => 'class_change',
            'status' => 'pending',
            'student_name' => 'Jane Smith',
            'current_class' => 'Class C',
            'requested_class' => 'Class A',
            'created_at' => now()->subDay()
            ]
        ]);

        return view('admin.dashboard', compact('teachers','students','requests', 'user'));
    }
}
