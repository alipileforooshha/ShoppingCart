<?php

namespace App\Repositories\Concretes;

use App\Models\Product;
use App\Repositories\Interfaces\ProductInterface;

class ProductRepository implements ProductInterface 
{
    public function create($request)
    {
        //create product using request parameters
        $product = Product::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price
        ]);

        return $product;
    }
}