<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;



class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', User::ROLE_TEACHER)
        ->withCount([
            'teachers',
            'students'
        ])
        ->orderBy('created_at','desc')
        ->get();
        return view('admin.teachers_list', compact('teachers'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
          'name'  => 'required|string|max:255',
          'email' => 'required|email|unique:users,email',
        ]);
        $data['password'] = bcrypt('secret123'); // or generate/send password
        $data['role']     = User::ROLE_TEACHER;
        $data['admin_id'] = auth()->id();
        User::create($data);
        return redirect()->route('admin.teacher.index');
    }
}
