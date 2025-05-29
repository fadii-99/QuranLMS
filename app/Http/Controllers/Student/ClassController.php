<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherStudent;
use App\Models\User;
use App\Models\Klass;

class ClassController extends Controller
{
    public function classList()
    {
        $user = Auth::user();
        $classes = Klass::where('student_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);

        return view('student.class_list', compact('classes'));
    }
}
