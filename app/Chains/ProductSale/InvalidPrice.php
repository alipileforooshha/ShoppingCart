<?php

namespace App\Chains\ProductSale;

use App\Chains\Chain;
use App\Exceptions\CheckoutException;
use App\Repositories\Interfaces\CartInterface;

class InvalidPrice extends Chain{

    private $cartInterface;

    public function __construct(CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;    
    }

    /*
    * Check if all the products have a valid price bigger than 0
    */
    public function handle()
    {
        $userCart = $this->cartInterface->index();
        foreach($userCart as $cart)
        {
            if($cart->product->price < 0)
            {
                throw new CheckoutException('قیمت محصولات نامعتبر است',1);
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