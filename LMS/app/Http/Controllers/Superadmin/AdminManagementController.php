<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    // Show list of users with 'admin' role
    public function index(Request $request)
    {
        $query = User::role('admin'); // admins only here

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $admins = $query->paginate(10);
        return view('superadmin.admins.index', compact('admins'));
    }

    // Show form to create a new user (admin/teacher/student)
    public function create()
    {
        return view('superadmin.admins.create'); // Your form must have a role select field
    }

    // Store new user with assigned role from form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,student,teacher,atc,applicant',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            
        ]);

        // Assign the selected role via Spatie Permission
        $user->assignRole($validated['role']);

        // Redirect according to role created
        if ($validated['role'] === 'admin') {
            return redirect()->route('superadmin.admins.index')
                ->with('success', 'Admin created successfully.');
        } elseif ($validated['role'] === 'teacher') {
            return redirect()->route('superadmin.teachers.index') // create this route/view
                ->with('success', 'Teacher created successfully.');
        }elseif ($validated['role'] === 'atc') {
            return redirect()->route('superadmin.atc.index') // create this route/view
                ->with('success', 'atc created successfully.');
        }elseif ($validated['role'] === 'applicant') {
            return redirect()->route('superadmin.applicant.index') // create this route/view
                ->with('success', 'applicant created successfully.');
        }else {
            return redirect()->route('superadmin.students.index') // create this route/view
                ->with('success', 'Student created successfully.');
        }

        
    }

    // Edit admin only
    public function edit(User $admin)
    {
        return view('superadmin.admins.edit', compact('admin'));
    }

    // Update admin only
    public function update(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        $admin->save();
    
        $admin->syncRoles(['admin']);
    
        return redirect()->route('superadmin.admins.index')->with('success', 'Admin updated successfully.');
    }
    
    // Delete admin only
    public function destroy(User $admin)
    {
        $admin->removeRole('admin');
        $admin->delete();

        return back()->with('success', 'Admin deleted successfully.');
    }

    // Block/unblock admin only
    public function toggleBlock(User $admin)
    {
        $admin->is_blocked = !$admin->is_blocked;
        $admin->save();

        return back()->with('success', 'Admin status updated.');
    }
}
