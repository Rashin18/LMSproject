<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('superadmin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = ['student'];
        return view('superadmin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:student',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $user->syncRoles([$validated['role']]);

        return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }


    public function adminsIndex()
    {
        $admins = User::role('admin')->get();
        return view('superadmin.admins.index', compact('admins'));
    }
    
    public function adminsEdit(User $user)
    {
        return view('superadmin.admins.edit', compact('user'));
    }
    
    public function adminsUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
    
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
            $user->save();
        }
    
        return redirect()->route('superadmin.admins.index')->with('success', 'Admin updated successfully.');
    }
    
    public function adminsDestroy(User $user)
    {
        $user->delete();
        return redirect()->route('superadmin.admins.index')->with('success', 'Admin deleted successfully.');
    }
    

}
