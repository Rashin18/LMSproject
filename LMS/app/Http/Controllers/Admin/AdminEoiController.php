<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Eoi;
use Illuminate\Support\Facades\Mail;
use App\Mail\EoiApprovalMail;
class AdminEoiController extends Controller
{
    public function index()
    {
        $eois = Eoi::with('user')->latest()->paginate(10);
        return view('admin.eois.index', compact('eois'));
    }

    public function show(Eoi $eoi)
    {
        return view('admin.eois.show', compact('eoi'));
    }

    public function approve(Eoi $eoi)
    {
        $eoi->update(['status' => 'approved']);
        
        // Send approval email
        $recipientEmail = $eoi->user_id ? $eoi->user->email : $eoi->email;
        Mail::to($recipientEmail)->send(new EoiApprovalMail($eoi));

        return back()->with('success', 'EOI approved and notification sent.');
    }
    public function updateStatus(Request $request, Eoi $eoi)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected'
    ]);

    $eoi->update(['status' => $request->status]);

    // Optional: Send email notification about status change
    // Mail::to($eoi->email)->send(new EoiStatusUpdated($eoi));

    return back()->with('success', 'Status updated successfully');
}

    public function reject(Eoi $eoi)
    {
        $eoi->update(['status' => 'rejected']);
        return back()->with('success', 'EOI rejected.');
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

  
   
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
