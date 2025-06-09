<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'proposal_id',
        'data',
        'status',
        'application_token'
    ];
    
    protected $casts = [
        'data' => 'array'
    ];
    
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}