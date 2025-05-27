<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\teacher_subject;
use Illuminate\Support\Facades\Auth;


class SubjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subjects = Subject::where('admin_id', $user->id)->orderByDesc('created_at')
            ->paginate(10);;
        return view('admin.subject_list', compact('subjects'));
    }

    public function create(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $subject = Subject::create([
            'name' => $validated['name'],
            'admin_id' => $user->id
        ]);

        return redirect()->route('admin.subject.index')
            ->with('success', 'Subject created successfully');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id'   => 'required|integer|exists:subjects,id',
            'name' => 'required|string|max:255',
        ]);

        $is_active = $request->has('is_active') ? 1 : false;
        
        if (!$is_active) {
            $assignedCount = teacher_subject::where('subject_id', $validated['id'])->count();
            if ($assignedCount > 0 && !$is_active) {
            return redirect()->back()
                ->with('error', 'Cannot deactivate subject with assigned teachers');
        }
        }
        $subject = Subject::findOrFail($validated['id']);


        

        if ($subject->admin_id !== Auth::id()) {
            return redirect()->route('admin.subject.index')
                ->with('error', 'You do not have permission to update this subject');
        }

        $subject->update([
            'name' => $validated['name'],
            'is_active' => $is_active,
        ]);

        return redirect()->route('admin.subject.index')
            ->with('success', 'Subject updated successfully');
    }


    public function destroy(Request $request)
    {
        try {
            Subject::destroy((int) $request->subject_id);
            return response()->json(['success' => true, 'message' => 'Subject deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete subject'], 500);
        }
    }
}
