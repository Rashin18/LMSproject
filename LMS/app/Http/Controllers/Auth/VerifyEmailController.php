<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
{
    try {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to verify your email.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1')
            ->with('status', 'Email successfully verified!');

    } catch (\Exception $e) {
        \Log::error('Email verification failed: '.$e->getMessage());
        return redirect()->route('login')->with('error', 'Email verification failed. Please try again.');
    }
}
}