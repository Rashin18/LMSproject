<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Show all students and teachers
    public function index()
    {
        $users = User::whereIn('role', ['student', 'teacher','applicant'])->get();
        return view('admin.users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('admin.users.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:student,teacher,applicant',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Edit user
    public function edit(User $user)
    {
        if (!in_array($user->role, ['student', 'teacher'])) {
            abort(403);
        }
        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        if (!in_array($user->role, ['student', 'teacher'])) {
            abort(403);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:student,teacher,applicant',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy(User $user)
    {
        if (!in_array($user->role, ['student', 'teacher'])) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    // Toggle active/inactive status
    public function toggleStatus(User $user)
    {
        if (!in_array($user->role, ['student', 'teacher'])) {
            abort(403);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User status updated.');
    }
    public function showResetForm()
{
    $users = User::whereIn('role', ['teacher', 'student','atc','applicant'])->get();
    return view('admin.users.password-reset', compact('users'));
}

public function resetPassword(Request $request, User $user)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'password' => 'required|confirmed|min:8'
    ]);
    
    $user = User::find($request->user_id);
    $user->password = Hash::make($request->password);
    $user->save();
    
    return back()->with('success', 'Password reset successfully');
}
}
