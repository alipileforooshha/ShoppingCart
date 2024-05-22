<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditCartRequest;
use App\Repositories\Interfaces\CartInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    private $cartInterface;

    public function __construct(CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;
    }

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
}
