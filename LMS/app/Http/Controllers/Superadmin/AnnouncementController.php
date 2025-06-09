<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('superadmin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('superadmin.announcements.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'visible_to' => 'required|in:all,teachers,students,admins', // Ensure this exists
        'start_at' => 'nullable|date',
        'end_at' => 'nullable|date|after:start_at',
        'is_active' => 'sometimes|boolean' // Ensure this exists
    ]);

    // Explicitly set critical fields
    $announcement = Announcement::create([
        
        'title' => $validated['title'],
        'message' => $validated['message'],
        'visible_to' => $validated['visible_to'],
        'is_active' => $request->boolean('is_active', true), // Default to true if not provided
        'start_at' => $validated['start_at'] ?? null,
        'end_at' => $validated['end_at'] ?? null,
        'user_id' => auth()->id()
    ]);
    if ($validated['start_at']) {
        $validated['start_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['start_at']);
    }
    
    if ($validated['end_at']) {
        $validated['end_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['end_at']);
    }

    return redirect()->route('superadmin.announcements.index')
        ->with('success', 'Announcement created successfully!');

}

    public function edit(Announcement $announcement)
    {
        return view('superadmin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'start_at' => 'nullable|date_format:Y-m-d\TH:i',
            'end_at' => 'nullable|date_format:Y-m-d\TH:i|after:start_at',
        ]);

        $announcement->update($validated + [
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('superadmin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted!');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['is_active' => !$announcement->is_active]);
        return back()->with('success', 'Status updated!');
    }
}