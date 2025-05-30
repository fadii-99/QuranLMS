<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\teacher_subject;


class TeacherController extends Controller
{
    public function index()
    {
        $admin = Auth::user();

        $teachers = User::query()
            ->where('admin_id', $admin->id)
            ->where('role', User::ROLE_TEACHER)
            ->withCount(['students1 as students_count'])
            ->with('subjects') // Load the subjects relation
            ->orderByDesc('created_at')
            ->paginate(10);
        $subjects = Subject::where('admin_id', $admin->id)->get();

        return view('admin.teachers_list', compact('teachers', 'subjects'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

         do {
            $roll_no = 'TCH' . mt_rand(10000000, 99999999);
        } while (User::where('roll_no', $roll_no)->exists());
        $data['password'] = bcrypt($request->password); // or generate/send password
        $data['role']     = User::ROLE_TEACHER;
        $data['admin_id'] = auth()->id();
        $data['roll_no'] = $roll_no;
        User::create($data);
        return redirect()->route('admin.teacher.index');
    }


    public function update(Request $request)
    {
        $teacher = User::findOrFail($request->id);
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        if ($request->filled('password')) {
            $teacher->password = bcrypt($request->password);
        }
        $teacher->save();
        return redirect()->route('admin.teacher.index');
    }

    public function assignSubject(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $teacher = User::findOrFail($validated['teacher_id']);
        $adminId = Auth::id();

        // Check if subject is already assigned with this admin_id
        $alreadyAssigned = $teacher->subjects()
            ->wherePivot('admin_id', $adminId)
            ->where('subject_id', $validated['subject_id'])
            ->exists();

        if ($alreadyAssigned) {
            return response()->json(['success' => false, 'message' => 'Subject already assigned!']);
        }

        // Attach with admin_id in the pivot table
        $teacher->subjects()->attach($validated['subject_id'], ['admin_id' => $adminId]);
        return response()->json(['success' => true, 'message' => 'Subject assigned!']);
    }


    public function removeSubject(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $teacher = User::findOrFail($validated['teacher_id']);
        $teacher->subjects()->detach($validated['subject_id']);
        return response()->json(['success' => true, 'message' => 'Subject removed!']);
    }

    public function destroy(Request $request)
    {
        try {
            User::destroy((int) $request->teacher_id);
            return response()->json(['success' => true, 'message' => 'Teacher deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete teacher'], 500);
        }
    }
}
