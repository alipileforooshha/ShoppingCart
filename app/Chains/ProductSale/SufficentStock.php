<?php

namespace App\Chains\ProductSale;

use App\Chains\Chain;
use App\Exceptions\CheckoutException;
use App\Models\Product;
use App\Repositories\Interfaces\CartInterface;

class SufficentStock extends Chain {
    
    private $cartInterface;

    public function __construct(CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;    
    }

    /*
    * Checks if all the products in the cart are in stock and the stock is not
    * negative
    */
    public function handle()
    {
        $userCart = $this->cartInterface->index();
        foreach($userCart as $cart)
        {
            if($cart->product->stock < 0 || $cart->product->stock < $cart->count)
            {
                throw new CheckoutException('موجودی انبار کافی نیست',1);
            }
        }
        if($this->successor)
        {
            $this->successor->handle();
        }else{
            return;
        }
    }
}