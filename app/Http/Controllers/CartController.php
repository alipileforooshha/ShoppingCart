<?php

namespace App\Http\Controllers;

use App\Chains\ProductSale\CartFull;
use App\Chains\ProductSale\InvalidPrice;
use App\Chains\ProductSale\SufficentStock;
use App\Http\Requests\EditCartRequest;
use App\Http\Resources\CartResource;
use App\Repositories\Interfaces\CartInterface;
use App\Repositories\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    private $cartInterface;
    private $productInterface;

    /*
    * Inject CartInterface as dependency
    */
    public function __construct(CartInterface $cartInterface,
    ProductInterface $productInterface)
    {
        $this->cartInterface = $cartInterface;
        $this->productInterface = $productInterface;
    }

    /*
    * Returns user's Shopping Cart
    */
    public function index()
    {
        try{
            $cart = $this->cartInterface->index();
            $result = CartResource::collection($cart);
            return Response::success(200, $result, 'سبد خرید با موفقیت بازگردانده شد');
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
        $sufficentStock = new SufficentStock($this->cartInterface, $this->productInterface);
        $invalidPrice = new InvalidPrice($this->cartInterface);
        $cartFull = new CartFull($this->cartInterface);
        $invalidPrice->setSuccesor($cartFull);
        $cartFull->setSuccesor($sufficentStock);

        try{
            $invalidPrice->handle();
            $this->cartInterface->checkout();
            return Response::success(200,null,'تراکنش با موفقیت انجام شد');  
        }catch(\Throwable $e)
        {
            return Response::failed(406,null,$e->getMessage());
        }
    }
}
