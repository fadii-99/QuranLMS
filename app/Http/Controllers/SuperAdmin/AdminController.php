<?php

// app/Http/Controllers/SuperAdmin/AdminController.php
namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', User::ROLE_ADMIN)
        ->withCount([
            // your User model needs a teachers() relation that filters role=teacher
            'teachers',
            // and a students() relation filtering role=student
            'students'
        ])
        ->orderBy('created_at','desc')
        ->paginate(10);

        return view('superadmin.admins_list', compact('admins'));
    }


    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'academy_name' => 'required|string|max:255',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'academy_name' => $request->academy_name,
            'role' => User::ROLE_ADMIN,
            'is_paid' => true,
        ]);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin created successfully');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'academy_name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);
        
        // Cast the boolean values
        $request->merge([
            'is_paid' => (bool)$request->is_paid,
            'is_blocked' => (bool)$request->is_blocked,
        ]);

        $admin = User::findOrFail($id);
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        if ($admin->email !== $request->email) {
            $admin->email_verified_at = null;
        }
        if ($admin->academy_name !== $request->academy_name) {
            $admin->academy_name = $request->academy_name;
        }
        if ($admin->name !== $request->name) {
            $admin->name = $request->name;
        }
        if ($admin->is_paid != $request->is_paid) {
            $admin->is_paid = $request->is_paid;
        }
        if ($admin->is_blocked != $request->is_blocked) {
            $admin->is_blocked = $request->is_blocked;
        }

        $admin->save();

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin updated successfully');
    }
}
