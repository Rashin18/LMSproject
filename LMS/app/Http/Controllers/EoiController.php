<?php

// app/Http/Controllers/EoiController.php
namespace App\Http\Controllers;

use App\Models\Eoi;
use App\Mail\EoiSubmissionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EoiApprovalNotification;

class EoiController extends Controller
{
    public function create()
    {
        return view('eoi.create');
    }

    public function store(Request $request)
{
    $rules = [
        'project_details' => 'required|string|min:20'
    ];

    if (!auth()->check()) {
        $rules['name'] = 'required|string|max:255';
        $rules['email'] = 'required|email';
    }

    $validated = $request->validate($rules);

    $data = [
        'project_details' => $validated['project_details'],
        'status' => 'pending'
    ];

    if (auth()->check()) {
        $data['user_id'] = auth()->id();
        $data['name'] = auth()->user()->name;
        $data['email'] = auth()->user()->email;
    } else {
        $data['name'] = $validated['name'];
        $data['email'] = $validated['email'];
    }

    // Create the EOI record first
    $eoi = Eoi::create($data);

    try {
        Mail::to(config('mail.admin_address'))
            ->send(new EoiSubmissionNotification($eoi));
            
        return back()->with('success', 'EOI submitted successfully!');
        
    } catch (\Exception $e) {
        \Log::error('Email failed: '.$e->getMessage());
        return back()->with('success', 'EOI submitted! Notification will follow.')
                    ->with('warning', 'Email notification failed: '.$e->getMessage());
    }
}
public function index()
    {
        $eois = Eoi::latest()->paginate(10);
        return view('admin.eois.index', compact('eois'));
    }

    public function show(Eoi $eoi)
    {
        return view('admin.eois.show', compact('eoi'));
    }

    public function updateStatus(Request $request, Eoi $eoi)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected'
    ]);

    $previousStatus = $eoi->status;
    $eoi->update(['status' => $request->status]);

    // Send approval email if status changed to approved
    if ($request->status == 'approved' && $previousStatus != 'approved') {
        $proposalFormUrl = route('proposal-form.create', $eoi);
        Mail::to($eoi->email)
            ->send(new EoiApprovalNotification($eoi, $proposalFormUrl));
    }

    return back()->with('success', 'Status updated successfully');
}
}