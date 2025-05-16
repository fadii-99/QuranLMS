<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
    public function studentsList()
    {
        $user = Auth::user();
        $students = User::where('id', $user->id)->where('role',User::ROLE_STUDENT)->orderBy('created_at','desc')
        ->paginate(10); 
        return view('teacher.students_list', compact('students'));
    }
}
