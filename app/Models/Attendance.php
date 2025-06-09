<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'class_id',
        'status', 
        'teacher_id',
        'admin_id',
        'subject_id',
        'time',
        'teacherJoined',
        'studentJoined',
        'link',
    ];

   public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id')->where('role', User::ROLE_TEACHER);
    }

    // Relationship to student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id')->where('role', User::ROLE_STUDENT);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
