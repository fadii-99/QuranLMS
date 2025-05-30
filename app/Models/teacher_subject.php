<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher_subject extends Model
{
    use HasFactory;
    protected $fillable = [
      'teacher_id',
      'subject_id',
      'active',
      'admin_id'
    ];


    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id'); // Fix here!
    }
    public function students()
{
    return $this->belongsToMany(User::class, 'student_subjects', 'teacher_subject_id', 'student_id');
}


}
