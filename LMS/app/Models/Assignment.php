<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'teacher_id',
        'due_date',
        'max_score',
        'status'
    ];

    protected $dates = ['due_date'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
    public function scopeFilter($query, array $filters)
{
    $query->when($filters['search'] ?? false, function ($query, $search) {
        $query->where(function($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('course', function($query) use ($search) {
                      $query->where('title', 'like', '%' . $search . '%'); // Changed from 'name' to 'title'
                  })
                  ->orWhereHas('teacher', function($query) use ($search) {
                      $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%');
                  });
        });
    });
}
}