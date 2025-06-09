<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Announcement;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class AnnouncementsList extends Component
{
    public $announcements;
    
    public function __construct()
    {
        $query = Announcement::active();
        
        // Only apply role filtering if column exists
        if (Schema::hasColumn('announcements', 'visible_to')) {
            $role = Auth::user()->role; // Get current user's role
            $query->where(function($q) use ($role) {
                $q->where('visible_to', 'all')
                  ->orWhere('visible_to', $role);
            });
        }
        
        $this->announcements = $query->latest()->get();
    }
    
    public function render()
    {
        return view('components.announcements-list');
    }
}