<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;


class SubjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subjects = Subject::all();
        return view('admin.subject_list', compact('subjects'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject = Subject::create([
            'name' => $validated['name']
        ]);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully');
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update([
            'name' => $validated['name']
        ]);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully');
    }

    public function destroy(Request $request)
    {

        Subject::destroy($request->id);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully');
    }
}
