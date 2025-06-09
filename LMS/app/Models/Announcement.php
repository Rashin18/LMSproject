<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',          // Add this
        'message',        // Add this
        'start_at',       // Add this
        'end_at',         // Add this
        'user_id',        // Add this
        'is_active'       // Add this
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        // ... other casts
    ];

    // In app/Models/Announcement.php
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('start_at')
                  ->orWhere('start_at', '<=', now()->toDateTimeString());
            })
            ->where(function($q) {
                $q->whereNull('end_at')
                  ->orWhere('end_at', '>=', now()->toDateTimeString());
            });
    }
public function scopeForRole($query, $role)
{
    return $query->where(function($q) use ($role) {
        $q->where('visible_to', 'all')
          ->orWhere('visible_to', $role);
    });
}
}
