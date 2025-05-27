<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'admin_id',
        'is_active'
    ];

    public function teachers()
    {
        return $this->belongsToMany(
            User::class,          // related model (not the pivot!)
            'teacher_subject',    // pivot table
            'subject_id',         // this model's key on pivot
            'teacher_id'          // related model's key on pivot
        );
    }

    public function teacher()
{
    return $this->belongsTo(User::class, 'teacher_id');
}
}
