<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherStudent;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $students = User::where('admin_id', $user->id)
            ->where('role', User::ROLE_STUDENT)
            ->with('teacherStudent.teacher')
            ->orderByDesc('created_at')
            ->paginate(10);

        $teachers = User::where('admin_id', $user->id)
            ->where('role', User::ROLE_TEACHER)
            ->get();

        return view('admin.students_list', compact('students', 'teachers'));
    }



    public function destroy(Request $request)
    {

        $student = User::find($request->student_id);
        if ($student) {
            $student->delete();
            return response()->json(['success' => true, 'message' => 'Student deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Student not found']);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role']     = User::ROLE_STUDENT;
        $data['admin_id'] = auth()->id();

        $student = User::create($data);

        // JSON (AJAX) vs redirect (normal form)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'student' => $student,
            ], 201);
        }

        return redirect()
            ->route('admin.student.index')
            ->with('success', 'Student created successfully');
    }

    public function assignTeacher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Prevent duplicates
        if (TeacherStudent::where('teacher_id', $request->teacher_id)
            ->where('student_id', $request->student_id)
            ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This teacher is already assigned to this student',
            ], 422);
        }

        // Prevent multiple teachers per student
        if (TeacherStudent::where('student_id', $request->student_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Student already has a teacher assigned',
            ], 422);
        }

        TeacherStudent::create([
            'teacher_id' => $request->teacher_id,
            'student_id' => $request->student_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher assigned successfully',
        ]);
    }

    public function removeTeacher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pivot_id' => 'required|integer|exists:teacher_students,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $deleted = TeacherStudent::destroy($request->pivot_id);

        if (! $deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove teacher assignment',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Teacher removed successfully',
        ]);
    }
}
