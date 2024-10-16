<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReelVideo extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'likes',
        'created_at',
        'updated_at'
    ];

    public function comments()
    {
        return $this->hasMany(ReelComment::class, 'video_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
