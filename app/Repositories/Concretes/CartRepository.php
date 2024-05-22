<?php

namespace App\Repositories\Concretes;

use App\Http\Requests\EditCartRequest;
use App\Models\Cart;
use App\Repositories\Interfaces\CartInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class CartRepository implements CartInterface 
{
    
    /*
    * Returns all the records and also caches the query for a week 
    */
    public function index()
    {
        $cacheDuration = 60 * 24 * 7;
        $cart = Cache::remember('cart:userId',$cacheDuration,function(){
            return Cart::with('Product')->get();
        });
        return $cart;
    }

    /*
    * Adds an item to the cart and if it already exists increments the count by * 1 
    */
    public function addToCart($request)
    {
        Cache::forget('cart:userId');
        $cart = Cart::where('product_id',$request->product_id)->first();
        if($cart)
        {
            $cart->count = $cart->count + 1;
            $cart->save();
            return;
        }else{
            Cart::create([
                'product_id' => $request->product_id,
                'count' => 1
            ]);
            return;
        }
    }
    
    /*
    * Removes an item from the cart and if count is more  
    * than 1 decrements it the count by 1  
    */
    public function removeFromCart($request)
    {
        Cache::forget('cart:userId');
        $cart = Cart::where('product_id',$request->product_id)->first();
        if($cart)
        {
            if($cart->count > 1)
            {
                $cart->count = $cart->count - 1;
                $cart->save();
                return;
            }else if($cart->count == 1){
                $cart->delete();
                return;
            }
        }else{
            throw new ModelNotFoundException('سبد خریدی با این آیدی پیدا نشد');
        }
        return 0;
    }

    public function checkout()
    {
        Cart::truncate();
        return;
    }
}