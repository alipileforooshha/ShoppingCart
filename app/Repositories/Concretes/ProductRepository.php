<?php

namespace App\Repositories\Concretes;

use App\Models\Product;
use App\Repositories\Interfaces\ProductInterface;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductInterface 
{
    /*
    * Returns a list of all products
    */
    public function index()
    {
        $products = Product::all();
        return $products;
    }

    /*
    * Adds a new Product
    */
    public function create($request)
    {
        //remove cached data because we are adding a new product
        Cache::forget('products');
        //create product using request parameters
        $product = Product::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price
        ]);

        return $product;
    }

    public function decrementStock($id, $count)
    {
        $product = Product::findOrFail($id);
        $product->stock = $product->stock - $count;
        $product->save();
    }
}