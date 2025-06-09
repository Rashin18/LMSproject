<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'teacher_id',
        'batch_id',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    
    public function students()
    {
        return $this->belongsToMany(Student::class)
               ->withTimestamps(); // This requires timestamps in pivot table
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Your other relationships...
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}