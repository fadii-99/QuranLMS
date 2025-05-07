<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class RecentActivityController extends Controller
{
    public function index()
    {
        $recent_activity = User::where('role', User::ROLE_ADMIN)->get();
        return view('superadmin.recent_activity', compact('recent_activity'));
    }
}
