<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyStatuses extends Model
{
    use HasFactory;

    const PENDING = 1;
    const PUBLISHED = 2;
    const REJECTED = 3;
    const DRAFT = 4;
}
