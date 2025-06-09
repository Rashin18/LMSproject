<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'student_id',
        'batch_id',
        'status',
        // Add other fields as needed
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
