<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->belongsTo(
            Category::class,
        );
    }


    public static function productBySlug($slug)
    {

        // return self::with("category")
        //     ->where('slug',  $slug)
        //     ->first();

        return self::leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('slug',  $slug)
            ->first([
                'products.*',
                'categories.category_name'
            ]);
    }


    public static function searchProduct($request)
    {
        $query = self::select([
            'products.*',
            DB::raw("DATE_FORMAT(products.date_online,'%d/%m/%Y') AS formatted_date"),
            'category_name',
            'category_slug',
        ])
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('date_offline', '>=', Carbon::now());

        //if user has selected a category
        if (!empty($request->input('category'))) $query->where('products.category_id', $request->input('category'));

        // if user has provided a keyword
        if (!empty($request->input('keywords'))) {
            $query->where(function ($query) use ($request) {
                $query->where('products.title', 'like', '%' . $request->input('keywords') . '%')
                    ->orWhere('products.description', 'like', '%' . $request->input('keywords') . '%');
            });
        }
        // if user has provided Start from & start to amount
        if (!empty($request->input('price_from')) && !empty($request->input('price_to'))) {
            $query->where(function ($query) use ($request) {
                $query->where('price_from', '>=', $request->input('price_from'))
                    ->where('price_to', '<=', $request->input('price_to'));
            });
        }
        return $query;
    }
}
