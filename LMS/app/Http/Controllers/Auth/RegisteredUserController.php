<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Hash,
    Validator,
};

class RegisteredUserController extends Controller
{
    /**
     * Display the registration form for the super admin to register a new user.
     */
    public function create()
    {
        return view('superadmin.users.create');
    }

    /**
     * Handle the registration of a new user.
     */
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,teacher,student,atc,applicant',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Assuming 'role' is a column in your users table
        ]);

        // Redirect back with a success message
        return redirect()->route('superadmin.dashboard')
            ->with('success', "User '{$user->name}' registered successfully!");
    }
}