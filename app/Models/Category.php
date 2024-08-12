<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use DB;

class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function product_list()
    {
        return $this->products()->latest()->take(4);
    }


    public function all_products()
    {
        return $this->products()->latest();
    }
}
