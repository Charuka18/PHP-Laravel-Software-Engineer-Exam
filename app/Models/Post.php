<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
     // Mass assignable fields
    protected $fillable = ['title', 'content', 'user_id', 'image',];

    // Post belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
