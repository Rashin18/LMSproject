<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Affiliation;
use App\Mail\AffiliationSubmitted;
use App\Mail\AffiliationApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AffiliationController extends Controller
{
    // Public form access (no login required)
    public function create(Application $application, $token)
    {
        $affiliation = Affiliation::where('token', $token)
            ->where('application_id', $application->id)
            ->firstOrFail();
    
        if ($affiliation->token_expires_at && $affiliation->token_expires_at->isPast()) {
            abort(403, 'This affiliation link has expired');
        }
    
        if ($affiliation->status !== 'pending') {
            return redirect()->route('affiliation-form.thank-you')
                ->with('message', 'Affiliation form already submitted');
        }
    
        return view('affiliation-form.create', [
            'affiliation' => $affiliation,
            'token' => $token // Make sure to pass the token to the view
        ]);
    }

    // Form submission
    public function store(Request $request, Application $application, $token)
    {
        $affiliation = Affiliation::where('token', $token)
            ->where('application_id', $application->id)
            ->firstOrFail();
    
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|in:educational,nonprofit,government,private,other',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'terms' => 'required|accepted'
        ]);
    
        // Update the affiliation
        $affiliation->update([
            'form_data' => $validated,
            'status' => 'submitted',
            'token' => null, // Now allowed since column is nullable
            'updated_at' => now() // Explicitly set updated_at
        ]);
    
        // Notify admin
        Mail::to(config('mail.admin_address'))
            ->send(new AffiliationSubmitted($affiliation));
    
        return redirect()->route('affiliation-form.thank-you');
    }

    // Thank you page
    public function thankYou()
    {
        return view('affiliation-form.thank-you');
    }

    // Admin views
    public function index()
    {
        $affiliations = Affiliation::with('application.proposal')->latest()->paginate(10);
        return view('admin.affiliations.index', compact('affiliations'));
    }

    public function show(Affiliation $affiliation)
    {
        return view('admin.affiliations.show', compact('affiliation'));
    }

    public function approve(Request $request, Affiliation $affiliation)
    {
        // Generate random password
        $password = Str::random(12); // or use a more complex generator
        
        // Create new ATC user
        $user = User::create([
            'name' => $affiliation->form_data['contact_person'],
            'email' => $affiliation->form_data['contact_email'],
            'password' => Hash::make($password),
            'role' => 'atc' // Make sure you have this column
            
        ]);
        
        // Update affiliation status
        $affiliation->update([
            'status' => 'approved',
            'user_id' => $user->id // Link affiliation to user
        ]);
        
        // Send approval email with credentials
        Mail::to($affiliation->form_data['contact_email'])
            ->send(new AffiliationApproved($affiliation, $password));
            
        return back()->with('success', 'Affiliation approved and ATC account created!');
    }
}