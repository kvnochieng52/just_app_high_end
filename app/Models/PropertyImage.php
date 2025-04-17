<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PropertyImage extends Model
{
    use HasFactory;


    protected $fillable = [
        'property_id',
        'image',
        'created_by',
        'updated_by'
    ];

    public static function getPropertyImages($propertyID)
    {
        return  self::where('property_id',  $propertyID)->get([
            'id',
            DB::raw("CONCAT('/',image) AS big"),
            DB::raw("CONCAT('/',image) AS thumb"),
            DB::raw("CONCAT('/',image) AS image"),
            'image AS app_image'
        ]);
    }
}
