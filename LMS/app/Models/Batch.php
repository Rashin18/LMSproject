<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
        'start_date',
        'end_date'
    ];

    /**
     * The students that belong to the batch
     */
   // app/Models/Batch.php
   public function students()
   {
       return $this->belongsToMany(User::class, 'batch_student', 'batch_id', 'student_id')
                  ->where('role', 'student')
                  ->withTimestamps();
   }
}