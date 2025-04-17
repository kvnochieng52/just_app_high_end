<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubRegion extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_region_name',
        'is_active'
        // add any other fillable fields here
    ];
}
