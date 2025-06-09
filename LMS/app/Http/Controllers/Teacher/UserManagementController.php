<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['student']);
        })->get();

        return view('teacher.students.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::whereIn('name', ['student'])->get();
        return view('teacher.students.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:student',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('teacher.students.index')->with('success', 'User updated successfully.');
    }

    public function toggleStatus(User $user)
{
    $user->is_blocked = !$user->is_blocked;
    $user->save();

    return redirect()->route('teacher.students.index')->with('success', 'User status updated successfully.');
}

}
