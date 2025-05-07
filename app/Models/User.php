<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\Pivot;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_SUPER_ADMIN = 'superadmin';
    const ROLE_ADMIN       = 'admin';
    const ROLE_TEACHER     = 'teacher';
    const ROLE_STUDENT     = 'student';
    const ROLE_PARENT      = 'parent';

    protected $fillable = [
        'name','email','password','role','academy_name',
        'is_active','is_verified','is_paid','is_blocked',
        'admin_id','remember_token'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Automatically hash passwords
    public function setPasswordAttribute($pw)
    {
        $this->attributes['password'] = Hash::needsRehash($pw) 
            ? Hash::make($pw) 
            : $pw;
    }

    //
    // —— ADMIN RELATIONS —— 
    //

    // Super- or Admin → Teachers they created
    public function teachers()
    {
        return $this->hasMany(self::class, 'admin_id')
                    ->where('role', self::ROLE_TEACHER);
    }

    // Super- or Admin → Students they created
    public function students()
    {
        return $this->hasMany(self::class, 'admin_id')
                    ->where('role', self::ROLE_STUDENT);
    }

    //
    // —— TEACHER↔STUDENT RELATIONS (M-to-M pivot) ——
    //

    // Teacher → their current students
    public function assignedStudents()
    {
        return $this->belongsToMany(
                    self::class,
                    'teacher_student',
                    'teacher_id',
                    'student_id'
                )
                ->withPivot('active','created_at')
                ->wherePivot('active', true)
                ->using(TeacherStudent::class);
    }

    // Student → their current teacher(s) (usually one)
    public function assignedTeachers()
    {
        return $this->belongsToMany(
                    self::class,
                    'teacher_student',
                    'student_id',
                    'teacher_id'
                )
                ->withPivot('active','created_at')
                ->wherePivot('active', true)
                ->using(TeacherStudent::class);
    }
}
