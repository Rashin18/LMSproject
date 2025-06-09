<?php

// app/Models/Eoi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eoi extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'project_details',
        'status',
        'admin_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function proposal()
{
    return $this->hasOne(Proposal::class);
}
}
