<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

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
        $subjects = Subject::where('admin_id', $admin->id )->get();

        return view('admin.teachers_list', compact('teachers', 'subjects'));
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

    public function assignSubject(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Simple one-to-one assignment
        $teacher = User::where('id', $validated['teacher_id'])->first();
        $teacher->subject_id = $validated['subject_id'];
        $teacher->save();

        return response()->json(['success' => true, 'message' => 'Subject assigned successfully!']);
    }

    public function removeSubject(Request $request)
    {
        $validated = $request->validate([
            'pivot_id' => 'required|exists:users,id',
        ]);
        $teacher = User::where('id', $validated['pivot_id'])->first();
        $teacher->subject_id = null;
        $teacher->save();

        return response()->json(['success' => true, 'message' => 'Subject removed successfully!']);
    }
}
