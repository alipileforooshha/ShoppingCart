<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Repositories\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    private $productInterface;

    public function __construct(ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;    
    }

    public function create(CreateProductRequest $request)
    {
        // Using try catch to catch any exceptions possible
        try {
            //Passing request to ProductInterface for creation
            $this->productInterface->create($request);
            return Response::success(200, null, 'محصول با موفقیت ساخته شد');      
        } catch (\Throwable $e) {
            return Response::failed(422, null, $e->message);
        }
        return 0;
    }
}
