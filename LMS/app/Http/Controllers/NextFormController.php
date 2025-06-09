<?php

namespace App\Http\Controllers;

use App\Models\Eoi;
use App\Models\Proposal;
use App\Mail\ProposalSubmittedNotification;
use App\Mail\ProposalConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NextFormController extends Controller
{
    public function create($eoiId)
    {
        $eoi = Eoi::findOrFail($eoiId);
        
        if ($eoi->status !== 'approved') {
            return redirect()->route('home')
                ->with('error', 'This form requires an approved Expression of Interest');
        }

        return view('proposal-form.create', [
            'eoi' => $eoi,
            'formDeadline' => now()->addDays(14)->format('F j, Y')
        ]);
    }

    public function store(Request $request, $eoiId)
    {
        \Log::info('Form submission started', ['eoi_id' => $eoiId, 'input' => $request->all()]);

        $eoi = Eoi::findOrFail($eoiId);

        $validator = Validator::make($request->all(), [
            'project_title' => 'required|string|max:255',
            'detailed_description' => 'required|string|min:100',
            'budget' => 'required|numeric|min:0',
            'timeline' => 'required|string|max:100',
            'team_members' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'terms' => 'required|accepted'
        ], [
            'terms.accepted' => 'You must accept the terms and conditions'
        ]);

        if ($validator->fails()) {
            return redirect()->route('proposal-form.create', $eoiId)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $proposal = Proposal::create([
                'eoi_id' => $eoi->id,
                'project_title' => $request->project_title,
                'detailed_description' => $request->detailed_description,
                'budget' => $request->budget,
                'timeline' => $request->timeline,
                'team_members' => $request->team_members,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'ip_address' => $request->ip(),
                'status' => 'pending'
            ]);

            \Log::info('Proposal created', ['proposal_id' => $proposal->id]);

            // Send notifications
            Mail::to(config('mail.admin_address'))
                ->send(new ProposalSubmittedNotification($proposal));
                
            Mail::to($request->contact_email)
                ->send(new ProposalConfirmation($proposal));

            return redirect()->route('proposal-form.thank-you')
                ->with('proposal_id', $proposal->id);

        } catch (\Exception $e) {
            \Log::error('Proposal submission failed: '.$e->getMessage());
            return redirect()->route('proposal-form.create', $eoiId)
                ->with('error', 'Submission failed. Please try again later.')
                ->withInput();
        }
    }

    public function thankYou()
    {
        if (!session()->has('proposal_id')) {
            return redirect()->route('home');
        }

        return view('proposal-form.thank-you', [
            'proposal_id' => session('proposal_id'),
            'support_email' => config('mail.support_email')
        ]);
    }
}