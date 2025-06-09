<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class Affiliation extends Model
{
    protected $fillable = [
        'application_id',
        'token',
        'token_expires_at',
        'form_data',
        'status'
    ];

    protected $casts = [
        'form_data' => 'array',
        'token_expires_at' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Accessors & Mutators
    protected function formData(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true) ?? [],
            set: fn ($value) => json_encode($value)
        );
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Methods
    public function isTokenValid()
    {
        if (!$this->token) {
            return false;
        }

        if ($this->token_expires_at && $this->token_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function markAsSubmitted()
    {
        $this->update([
            'status' => 'submitted',
            'token' => null // Invalidate token after submission
        ]);
    }

    public function getFormField($field)
    {
        return $this->form_data[$field] ?? null;
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}