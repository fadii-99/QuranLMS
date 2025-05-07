<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', User::ROLE_STUDENT)
        ->orderBy('created_at','desc')
        ->get();
        return view('admin.students_list', compact('students'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
          ]);
          $data['password'] = bcrypt($request->password); // or generate/send password
          $data['role']     = User::ROLE_STUDENT;
          $data['admin_id'] = auth()->id();

          User::create($data);

        return view('admin.students_list')->with('success', 'Student created successfully.');
    }
}
