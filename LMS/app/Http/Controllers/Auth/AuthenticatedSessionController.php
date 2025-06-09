<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\{
    RedirectResponse,
    Request
};
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);


    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        
        // Redirect based on role
        return $this->redirectToRoleDashboard();
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');

}

protected function redirectToRoleDashboard()
{
    $user = Auth::user();
    
    return match($user->role) {
        'superadmin' => redirect()->route('superadmin.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        'teacher' => redirect()->route('teacher.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'atc' => redirect()->route('atc.dashboard'),
        'applicant' => redirect()->route('applicant.dashboard'),
        default => redirect('/home')
    };
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}