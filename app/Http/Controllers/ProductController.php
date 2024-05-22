<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\SendProductCreateEmailJob;
use App\Repositories\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    private $productInterface;
    
    /*
    * Inject ProductInterface as dependency
    */
    public function __construct(ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;    
    }

    /*
    * Return a list of all products
    */
    public function index()
    {
        try{
            $products = $this->productInterface->index();
            $result = ProductResource::collection($products);
            return Response::success(200,$result, 'لیست تمام محصولات با موفقیت بازگردانی شد');
        }catch(\Throwable $e)
        {
            return Response::failed(403,null,'در بازگردانی لیست محصولات مشکلی پیش آمده است');
        }
    }

    /*
    * Create a new product and send an email to the manager
    */
    public function create(CreateProductRequest $request)
    {
        
        // Using try catch to catch any exceptions possible
        try {
            //Passing request to ProductInterface for creation
            $product = $this->productInterface->create($request);
            //dispatching job to send alert email to manager
            SendProductCreateEmailJob::dispatch($product);
            return Response::success(200, null, 'محصول با موفقیت ساخته شد');
        } catch (\Throwable $e) {
        return $e;
            return Response::failed(422, null, $e);
        }
        return 0;
    }
}
