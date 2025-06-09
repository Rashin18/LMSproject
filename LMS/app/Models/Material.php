<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'title',
        'file_path',
        'type',         // video, pdf, assignment
        'subject',
        'download_count',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function assignedStudents()
{
    return $this->belongsToMany(User::class, 'material_user')
                ->withPivot('is_watched', 'progress')
                ->withTimestamps();
}


public function progressByStudents()
{
    return $this->belongsToMany(User::class, 'material_user', 'material_id', 'user_id')
        ->withPivot('progress', 'is_watched')
        ->using(\App\Models\MaterialUserPivot::class);
}




}



