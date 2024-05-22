<?php

namespace App\Http\Controllers;

use App\Chains\ProductSale\InvalidPrice;
use App\Chains\ProductSale\SufficentStock;
use App\Http\Requests\EditCartRequest;
use App\Repositories\Interfaces\CartInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    private $cartInterface;

    /*
    * Inject CartInterface as dependency
    */
    public function __construct(CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;
    }

    /*
    * Returns user's Shopping Cart
    */
    public function index()
    {
        try{
            $cart = $this->cartInterface->index();
            return Response::success(200, $cart, 'سبد خرید با موفقیت بازگردانده شد');
        }catch(\Throwable $e)
        {
            return Response::failed(422, $cart, 'در بازگردانی سبد خرید مشکلی پیش آمده است');
        }
    }

    /*
    * Adds an Item to the user's ShoppingCart if Product already exists
    * adds one to the count
    */
    public function add(EditCartRequest $request)
    {
        try{
            $this->cartInterface->addToCart($request);
            return Response::success(200,null,'ویرایش سبد خرید با موفقیت انجام شد');
        }catch(\Throwable $e)
        {
            return Response::failed(403,null,'ویرایش سبد خرید با مشکل مواجه شد');
        }
    }
    
    /*
    * Removes an Item from the user's ShoppingCart if Product count is 
    * more than one decrements the count by 1 if count is 1 removes the product
    * from the Cart
    */
    public function remove(EditCartRequest $request)
    {
        try{
            $this->cartInterface->removeFromCart($request);
            return Response::success(200,null,'ویرایش سبد خرید با موفقیت انجام شد');
        }catch(\Throwable $e)
        {
            return Response::failed(403,null,'ویرایش سبد خرید با مشکل مواجه شد');
        }
    }

    /*
    * Checksout the user's shopping cart after validating conditions
    */
    public function checkout()
    {
        $sufficentStock = new SufficentStock($this->cartInterface);
        $invalidPrice = new InvalidPrice($this->cartInterface);
        $sufficentStock->setSuccesor($invalidPrice);
        $this->cartInterface->checkout();
        try{
            $sufficentStock->handle();
            return Response::success(200,null,'تراکنش با موفقیت انجام شد');  
        }catch(\Throwable $e)
        {
            return Response::failed(403,null,$e->getMessage());
        }
    }
}
