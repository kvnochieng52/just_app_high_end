<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use DB;


class ProductController extends Controller
{
    public function product_details($category_slug, $product_slug)
    {


        return Inertia::render('Product/Details', [
            'product_details' => Product::productBySlug($product_slug)
        ]);
    }


    public function category_products($category_slug)
    {

        $category = Category::with('products')->where('category_slug', $category_slug)->first();
        return Inertia::render('Product/Category', [
            'category_details' =>  $category,
            'products' =>  $category->products()->orderBy('id', 'DESC')->paginate(6),
            'categories' => Category::where('visible', 1)->pluck('category_name', 'id'),
        ]);
    }


    public function search_product(Request $request)
    {

        $this->validate($request, [
            'category' => 'required|numeric',
            'price_from' => 'numeric',
            'price_to' => 'numeric',
        ]);
        return Inertia::render('Product/Search', [
            'products' => Product::searchProduct($request)->paginate(10)->withQueryString(),
            'categories' => Category::where('visible', 1)->pluck('category_name', 'id')
        ]);
    }
}
