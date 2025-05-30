<?php

// app/Http/Controllers/SuperAdmin/AdminController.php
namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            ->orderBy('created_at', 'desc')
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

        // Yes, there is a possibility that this number can be the same, especially if two admins are created at the same time (race condition) or if admins are deleted (causing sum to repeat). 
        // A better approach is to use the next auto-increment id or a unique sequence.


        do {
            $roll_no = 'AD' . mt_rand(100000, 999999);
        } while (User::where('roll_no', $roll_no)->exists());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'academy_name' => $request->academy_name,
            'role' => User::ROLE_ADMIN,
            'is_paid' => true,
            'roll_no' => $roll_no,
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

    public function delete(Request $request)
    {
        $admin = User::findOrFail($request->id);

        if ($admin->role !== User::ROLE_ADMIN) {
            // Check if AJAX (expects JSON)
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only admins can be deleted'
                ], 400);
            }
            // Normal form
            return redirect()->route('superadmin.admins.index')
                ->with('error', 'Only admins can be deleted');
        }

        // Soft delete
        $admin->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Admin deleted successfully'
            ]);
        }

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin deleted successfully');
    }
}
