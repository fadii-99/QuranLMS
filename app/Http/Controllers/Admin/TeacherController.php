<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class TeacherController extends Controller
{
    public function index()
    {
        $admin = Auth::user();

        $teachers = User::query()
            ->where('admin_id', $admin->id)
            ->where('role', User::ROLE_TEACHER)
            ->withCount(['students1 as students_count'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.teachers_list', compact('teachers'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);
        $data['password'] = bcrypt($request->password); // or generate/send password
        $data['role']     = User::ROLE_TEACHER;
        $data['admin_id'] = auth()->id();
        User::create($data);
        return redirect()->route('admin.teacher.index');
    }
}
