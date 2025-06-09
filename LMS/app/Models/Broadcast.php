<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $fillable = [
        'subject',
        'message',
        'recipient_type',
        'recipient_count',
        'sender_id'
    ];
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
