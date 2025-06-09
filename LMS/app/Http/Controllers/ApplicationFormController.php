<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Application;
use App\Mail\ApplicationSubmitted;
use App\Mail\ApplicationApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationApprovedWithAffiliation;
use Illuminate\Support\Str;
use App\Models\Affiliation;
class ApplicationFormController extends Controller
{
    // Public form access (no login required)
    public function create(Proposal $proposal, $token)
{
    // Check if token matches and is still valid (not expired)
    if (!$proposal->application_token || $proposal->application_token !== $token) {
        abort(403, 'Invalid or expired application link. Please request a new one.');
    }
    
    // Check if application already exists
    if ($proposal->application) {
        return redirect()->route('application-form.thank-you')
            ->with('message', 'Application already submitted');
    }

    return view('application-form.create', compact('proposal'));
}
    
    // Form submission
    public function store(Request $request, Proposal $proposal, $token)
{
    // Verify token again on submission
    if (!$proposal->isTokenValid() || $proposal->application_token !== $token) {
        return redirect()->back()
            ->with('error', 'Invalid or expired token. Please request a new application link.');
    }

    // Check if application already exists
    if ($proposal->application) {
        return redirect()->route('application-form.thank-you')
            ->with('message', 'Application already submitted');
    }

    $validated = $request->validate([
        // Your validation rules here
    ]);

    // Create the application
    $application = Application::create([
        'proposal_id' => $proposal->id,
        'data' => $validated,
        'status' => 'pending'
    ]);

    // Invalidate the token after successful submission
    $proposal->update(['application_token' => null]);

    // Send notifications
    Mail::to(config('mail.admin_address'))
        ->send(new ApplicationSubmitted($application));
    
    return redirect()->route('application-form.thank-you');
}
    // Admin views
    public function index()
    {
        $applications = Application::with('proposal')->latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }
    
    public function show(Application $application)
    {
        return view('admin.applications.show', compact('application'));
    }
    
    public function approve(Request $request, Application $application)
    {
        $application->update(['status' => 'approved']);
        
        // Create affiliation record and generate token
        $affiliation = Affiliation::create([
            'application_id' => $application->id,
            'token' => Str::random(60),
            'token_expires_at' => now()->addDays(14), // 2 weeks to complete
            'status' => 'pending'
        ]);

        // Generate affiliation form URL
        $affiliationFormUrl = route('affiliation-form.create', [
            'application' => $application->id,
            'token' => $affiliation->token
        ]);

        // Notify user with affiliation form link
        Mail::to($application->proposal->contact_email)
            ->send(new ApplicationApprovedWithAffiliation($application, $affiliationFormUrl));
            
        return back()->with('success', 'Application approved! Affiliation form link sent to user.');
    }
    public function thankYou()
{
    return view('application-form.thank-you');
}
}