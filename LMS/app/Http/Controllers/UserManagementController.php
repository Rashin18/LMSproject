<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    // List all users
    public function index(Request $request)
{
    $query = User::query();

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        });
    }

    // Eager load roles to show correct roles in view
    $users = $query->with('roles')->paginate(10);

    return view('superadmin.users.index', compact('users'));
}


    // Show form to create a new user
    public function create()
    {
        return view('superadmin.users.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => ['required', Rule::in(['admin', 'teacher', 'student', 'superadmin','atc','applicant'])],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $user->assignRole($data['role']); 

        return redirect()->route('superadmin.users.index')->with('success', 'User created successfully.');
    }

    // Show form to edit an existing user
    public function edit(User $user)
    {
        return view('superadmin.users.edit', compact('user'));
    }

    // Update user details
  

public function update(Request $request, User $user)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'role' => ['required', Rule::in(['admin', 'teacher', 'student', 'superadmin','atc','applicant'])],
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // If password is set, hash it; otherwise remove from data to keep old password
    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }

    // Update user fields (except roles)
    $user->update($data);

    // Sync roles after update
    $user->syncRoles([$data['role']]);

    return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully.');
}


    // Delete a user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('superadmin.users.index')->with('success', 'User deleted successfully.');
    }

    // Toggle block/unblock status of a user
    public function toggleStatus(User $user)
{
    $user->is_blocked = !$user->is_blocked;
    $user->save();

    return redirect()->route('superadmin.users.index')->with('success', 'User status updated.');
}

}