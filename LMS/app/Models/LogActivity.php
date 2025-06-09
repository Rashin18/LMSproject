<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $fillable = [
        'user_id', 
        'action', 
        'details', 
        'ip_address',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
