<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Show profile edit form
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Update profile
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'current_password' => [
                'nullable',
                'required_with:new_password',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The current password is incorrect.');
                    }
                }
            ],
            'new_password' => [
                'nullable',
                'confirmed',
                Password::min(8) // Only minimum length requirement
                    ->letters()  // Requires letters
                    ->numbers(), // Requires numbers
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    // Destroy (delete) profile
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        
        // Logout before deletion
        auth()->logout();
        
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been permanently deleted.');
    }
}