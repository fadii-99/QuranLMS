<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TeacherStudent;
use App\Models\StudentSubject;
use App\Models\Klass;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
    public function studentsList()
    {
        $user = Auth::user();
        $students = TeacherStudent::with([
            'student.assignedClass'
        ])->where('teacher_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.students_list', compact('students'));
    }

    public function assignClass(Request $request)
    {
        // Validation
        $request->validate([
            'student_id'      => 'required|exists:users,id',
            'class_time_from' => 'required|date_format:H:i',
            'class_time_to'   => 'required|date_format:H:i|after:class_time_from',
        ]);

        // Student fetch karo
        $student = User::findOrFail($request->student_id);


        if (Klass::where('student_id', $student->id)
            ->exists()
        ) {
            // Agar class already exists hai, toh error
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class already assigned at this time',
                ]);
            }
            return back()
                ->withErrors(['Class already assigned at this time'])
                ->withInput();
        }

        // Availability check
        if (
            $request->class_time_from < $student->available_from ||
            $request->class_time_to > $student->available_to
        ) {
            // Agar form via AJAX hai, toh JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class time must be within student\'s available time',
                ]);
            }
            // Nahi toh normal redirect
            return back()
                ->withErrors(['Class time must be within student\'s available time'])
                ->withInput();
        }

        
        $subject = StudentSubject::where('student_id', $student->id)->first(); // ya apni logic
        if (!$subject) {
            return back()->withErrors(['Student is not assigned any subject'])->withInput();
        }

        $admin_id   = $student->admin_id;

        // Time format: 03:00-04:00
        $class_time = $request->class_time_from . '-' . $request->class_time_to;

        // Create new Klass using model
        Klass::create([
            'admin_id'   => $admin_id,
            'subject_id' => $subject->subject_id,
            'teacher_id' => auth()->id(),
            'student_id' => $student->id,
            'time'       => $class_time,
            'is_active'  => true,
        ]);

        // AJAX or Normal response
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Class assigned successfully!',
            ]);
        }

        return back()->with('success', 'Class assigned successfully!');
    }


    public function removeClass(Request $request)
    {
        $request->validate([
            'klass_id' => 'required|exists:klasses,id',
        ]);

        $klass = \App\Models\Klass::find($request->klass_id);
        if (!$klass) {
            return response()->json(['success' => false, 'message' => 'Class not found!'], 404);
        }

        // Optional: Only allow teacher who owns the class to delete (security)
        if ($klass->teacher_id != auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized!'], 403);
        }

        $klass->delete();

        return redirect()->route('teacher.students.index')
            ->with('success', 'Class removed successfully!');
    }
}
