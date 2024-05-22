<?php

namespace App\Chains\ProductSale;

use App\Chains\Chain;
use App\Exceptions\CheckoutException;
use App\Models\Product;
use App\Repositories\Interfaces\CartInterface;

class CartFull extends Chain {
    
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
        if($userCart->count() == 0)
        {
            throw new CheckoutException('سبد خرید خالی است',3);
        }
        if($this->successor)
        {
            $this->successor->handle();
        }else{
            return;
        }
    }
}