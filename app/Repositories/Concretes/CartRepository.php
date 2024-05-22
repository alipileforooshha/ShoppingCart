<?php

namespace App\Repositories\Concretes;

use App\Http\Requests\EditCartRequest;
use App\Models\Cart;
use App\Repositories\Interfaces\CartInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class CartRepository implements CartInterface 
{
    public function index()
    {
        $cacheDuration = 60 * 24 * 7;
        return Cache::remember('cart:userId',$cacheDuration,function(){
            return Cart::all();
        });
    }

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
}