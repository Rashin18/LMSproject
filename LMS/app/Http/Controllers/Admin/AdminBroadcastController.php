<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\BroadcastMessage;

class AdminBroadcastController extends Controller
{
    public function create()
    {
        $recipientTypes = [
            'all' => 'All Users',
            'students' => 'Students Only',
            'teachers' => 'Teachers Only',
            'admins' => 'Admins Only',
            'atc' => 'ATC Only'
        ];
        
        return view('admin.broadcasts.create', compact('recipientTypes'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:all,students,teachers,admins,atc',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $query = User::query();
        
        if ($request->recipient_type !== 'all') {
            $query->where('role', $request->recipient_type);
        }

        $users = $query->get();
        // Log the broadcast
        $broadcast = \App\Models\Broadcast::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'recipient_type' => $request->recipient_type,
            'recipient_count' => $users->count(),
            'sender_id' => auth()->id()
        ]);

        foreach ($users as $user) {
            $user->notify(new BroadcastMessage(
                $request->subject,
                $request->message
            ));
        }

        return redirect()->route('admin.broadcasts.history')
            ->with('success', 'Broadcast sent successfully to ' . $users->count() . ' users');
    }

    public function history()
    {
        $broadcasts = \App\Models\Broadcast::with('sender')->latest()->paginate(10);
        return view('admin.broadcasts.history', compact('broadcasts'));
    }
}