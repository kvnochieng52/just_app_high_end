<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReelVideo extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(ReelComment::class, 'video_id', 'id');
    }
}
