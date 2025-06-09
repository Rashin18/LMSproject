<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Batch;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    public const ROLES = ['super_admin', 'admin', 'teacher', 'student','atc','applicant'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = ['last_login_at'];

public function recordLogin()
{
    $this->last_login_at = now();
    $this->save();
}

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_student', 'student_id', 'batch_id')
                   ->withTimestamps();
    }
    
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }
    public function assignedMaterials()
    {
        return $this->belongsToMany(Material::class, 'material_user')
                    ->withPivot('is_watched', 'progress')
                    ->withTimestamps();
    }
    


public function materialProgress()
{
    return $this->belongsToMany(Material::class, 'material_user_progress')
                ->withPivot('is_watched', 'progress')
                ->withTimestamps();
}



public function teachingSubjects()
{
    return $this->hasMany(Subject::class, 'teacher_id');
}

public function courses()
{
    return $this->hasMany(Course::class, 'teacher_id');
}
public function hasSubmittedEoi()
{
    return $this->eois()->exists();
}

public function eois()
{
    return $this->hasMany(Eoi::class);
}

protected static function booted()
{
    static::created(function ($user) {
        // Mark EOI as completed when user registers
        Eoi::where('email', $user->email)
           ->where('status', 'approved')
           ->update(['user_id' => $user->id]);
    });
}

}