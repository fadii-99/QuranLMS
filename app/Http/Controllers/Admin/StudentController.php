<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherStudent;
use App\Models\teacher_subject;
use App\Models\StudentSubject;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Load students with their assigned teachers AND subjects (with teacher & subject relations)
        $students = User::where('admin_id', $user->id)
            ->where('role', User::ROLE_STUDENT)
            ->with([
                'teacherStudent.teacher',
                'teachersSS',
                'subjectStud.subject',     // for assigning subjects
                'subjectStud.teacher',     // for assigning subjects
                'subjectsSS',              // for displaying assigned subjects in the table
            ])
            ->orderByDesc('created_at')
            ->paginate(10);

        // All teachers for this admin
        $teachers = User::where('admin_id', $user->id)
            ->where('role', User::ROLE_TEACHER)
            ->get();

        // All subject-teacher pairs (for modal dropdown) 
        $subjects = teacher_subject::with(['teacher', 'subject'])
            ->whereHas('teacher', function ($q) use ($user) {
                $q->where('admin_id', $user->id);
            })
            ->get();

        return view('admin.students_list', compact('students', 'teachers', 'subjects'));
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

         do {
            $roll_no = 'STD' . mt_rand(10000000, 99999999);
        } while (User::where('roll_no', $roll_no)->exists());

        $data['password'] = bcrypt($data['password']);
        $data['role']     = User::ROLE_STUDENT;
        $data['admin_id'] = auth()->id();
        $data['available_to'] = $request->available_to;
        $data['available_from'] =  $request->available_from;
        $data['roll_no'] =  $roll_no;

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

    public function update(Request $request)
    {
        $data = $request->validate([
            'id'       => 'required|exists:users,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $request->id,
            'available_from' => 'required',
            'available_to'   => 'required',
            // Password is optional in update
            'password' => 'nullable|string|min:8',
        ]);

        $student = User::findOrFail($request->id);

        $student->name           = $data['name'];
        $student->email          = $data['email'];
        $student->available_from = $data['available_from'];
        $student->available_to   = $data['available_to'];

        // Agar password diya hai to update karo warna chhoro
        if (!empty($data['password'])) {
            $student->password = bcrypt($data['password']);
        }

        $student->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'student' => $student,
            ], 200);
        }

        return redirect()
            ->route('admin.student.index')
            ->with('success', 'Student updated successfully');
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
        // if (TeacherStudent::where('student_id', $request->student_id)->exists()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Student already has a teacher assigned',
        //     ], 422);
        // }

        TeacherStudent::create([
            'teacher_id' => $request->teacher_id,
            'student_id' => $request->student_id,
            'admin_id' => Auth::id(),
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

        // 1. Find the TeacherStudent record
        $teacherStudent = TeacherStudent::find($request->pivot_id);
        if (! $teacherStudent) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment not found',
            ], 404);
        }

        $studentId = $teacherStudent->student_id;
        $teacherId = $teacherStudent->teacher_id;

        // 2. Find all teacher_subject IDs for this teacher
        $teacherSubjectIds = teacher_subject::where('student_id', $studentId)->pluck('id');

        // 3. Remove all StudentSubject assignments for this student and these teacher_subjects
        \App\Models\StudentSubject::where('student_id', $studentId)
            ->whereIn('subject_id', $teacherSubjectIds)
            ->delete();

        // 4. Remove the teacher-student assignment
        $teacherStudent->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teacher and related subject assignments removed successfully',
        ]);
    }



    // In StudentController.php

    public function showAssignSubjectModal($studentId)
    {
        $subjects = teacher_subject::with(['teacher', 'subject'])->get();
        $student = User::findOrFail($studentId);
        return view('admin.assign_subject_modal', compact('subjects', 'student'));
    }

    public function assignSubjectToStudent(Request $request, $studentId)
    {
        $student = User::findOrFail($studentId);
        $student->subjects()->attach($request->input('teacher_subject_id'));
        return redirect()->route('students.list')->with('success', 'Subject assigned!');
    }

    // Assign a subject to a student
    public function assignSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:teacher_subjects,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
        $ts = teacher_subject::find($request->subject_id);
        // Prevent duplicate assignment
        if (StudentSubject::where('student_id', $request->student_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Subject already assigned to this student'], 422);
        }
        if (StudentSubject::where('student_id', $request->student_id)->where('subject_id', $request->subject_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Subject already assigned to this student'], 422);
        }

        StudentSubject::create([
            'student_id' => (int) $request->student_id,
            'subject_id' => (int) $ts->subject_id,
            'admin_id' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Subject assigned successfully']);
    }


    // Remove a subject assignment
    public function removeSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pivot_id' => 'required|integer|exists:student_subjects,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $deleted = StudentSubject::destroy($request->pivot_id);

        if (! $deleted) {
            return response()->json(['success' => false, 'message' => 'Failed to remove subject assignment'], 500);
        }
        return response()->json(['success' => true, 'message' => 'Subject removed successfully']);
    }


    // In StudentController.php

    public function getSubjectsForStudent(Request $request)
    {
        $student_id = $request->input('student_id');

        // Find the teacher assigned to this student
        $teacherStudent = \App\Models\TeacherStudent::where('student_id', $student_id)->first();

        if (!$teacherStudent) {
            return response()->json(['subjects' => []]);
        }

        $teacher_id = $teacherStudent->teacher_id;

        // Find all subjects assigned to this teacher (teacher_subject table)
        $teacherSubjects = \App\Models\teacher_subject::with(['subject', 'teacher'])
            ->where('teacher_id', $teacher_id)
            ->get();

        // Format for frontend
        $data = $teacherSubjects->map(function ($ts) {
            return [
                'id' => $ts->id, // teacher_subject id
                'subject_name' => $ts->subject->name ?? '',
                'teacher_name' => $ts->teacher->name ?? '',
            ];
        })->values();

        return response()->json(['subjects' => $data]);
    }
}
