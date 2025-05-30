<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\TeacherStudent;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RequestComplain;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $teachersData = User::where('admin_id', $user->id)->where('role', User::ROLE_TEACHER)->get();
        $teachers = $teachersData->count();
        $studentsData = User::where('admin_id', $user->id)->where('role', User::ROLE_STUDENT)->get();
        $students = $studentsData->count();

        $requests = RequestComplain::where('admin_id', $user->id)->where('status', 'pending')->limit(5)->get();

        return view('admin.dashboard', compact('teachers', 'students', 'requests', 'user'));
    }


    public function ReqComp(Request $request)
    {
        $user = Auth::user();
        $data = RequestComplain::where('admin_id', $user->id)->paginate(10);

        $viewId = $request->query('view_id');
        return view('admin.request-complains', compact('data', 'viewId'));
    }


    public function completeRequest($id)
    {
        $item = RequestComplain::findOrFail($id);
        $item->status = 'completed';
        $item->save();
        return response()->json(['success' => true, 'message' => 'Request marked as completed.']);
    }

    public function cancelRequest(Request $request, $id)
    {
        $item = RequestComplain::findOrFail($id);
        $item->status = 'canceled';
        $item->save();
        return response()->json(['success' => true, 'message' => 'Request canceled.']);
    }

    public function viewRequest($id)
    {
        $item = RequestComplain::with('user')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $item]);
    }
}
