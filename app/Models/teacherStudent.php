<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeacherStudent extends Pivot
{
    protected $table = 'teacher_student';

    protected $fillable = [
      'teacher_id',
      'student_id',
      'active',
    ];

    public $timestamps = true;
}
