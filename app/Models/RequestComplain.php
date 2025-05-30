<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestComplain extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id', 'subject', 'message','admin_id', 'status', 'type', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
