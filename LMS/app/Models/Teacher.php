<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'teacher_id',
        'department_id',
        'qualification',
        'specialization',
        'phone',
        'address',
        'joining_date',
        'status',
        'bio',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    // Relationships
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class)
            ->withPivot('is_lead_teacher')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getFormattedJoiningDateAttribute(): string
    {
        return $this->joining_date->format('M d, Y');
    }

    // Methods
    public function isLeadTeacherForBatch(Batch $batch): bool
    {
        return $this->batches()
            ->where('batch_id', $batch->id)
            ->where('is_lead_teacher', true)
            ->exists();
    }
}