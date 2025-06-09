<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
class Proposal extends Model
{
    protected $fillable = [
        'eoi_id',
        'project_title',
        'detailed_description',
        'budget',
        'timeline',
        'team_members',
        'contact_email',
        'contact_phone',
        'status',
        'ip_address',
        'application_token',
        'token_expires_at' 
    ];
    protected $casts = [
        'token_expires_at' => 'datetime', // Add this line
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'token_expires_at'
    ];

    public function eoi()
    {
        return $this->belongsTo(Eoi::class);
    }
    public function isTokenValid()
{
    // Check if token exists
    if (!$this->application_token) {
        return false;
    }

    // Check expiration only if column exists and has value
    if (Schema::hasColumn('proposals', 'token_expires_at') && $this->token_expires_at) {
        // Ensure we're working with a Carbon instance
        $expiresAt = $this->token_expires_at instanceof \Carbon\Carbon 
            ? $this->token_expires_at 
            : \Carbon\Carbon::parse($this->token_expires_at);
            
        return $expiresAt->isFuture();
    }

    return true; // Token is valid if no expiration is set
}
}
