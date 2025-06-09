<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Mail\ProposalApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with('eoi')->latest()->paginate(10);
        return view('admin.proposals.index', compact('proposals'));
    }

    public function show(Proposal $proposal)
    {
        return view('admin.proposals.show', compact('proposal'));
    }

    public function approve(Request $request, Proposal $proposal)
{
    $proposal->update([
        'status' => 'approved',
        'application_token' => Str::random(60),
        'token_expires_at' => now()->addDays(7)
    ]);
    
    $applicationFormUrl = route('application-form.create', [
        'proposal' => $proposal->id,
        'token' => $proposal->application_token
    ]);
    
    Mail::to($proposal->contact_email)
        ->send(new ProposalApprovedNotification($proposal, $applicationFormUrl));
    
    return back()->with('success', 'Proposal approved and notification sent!');
}
}