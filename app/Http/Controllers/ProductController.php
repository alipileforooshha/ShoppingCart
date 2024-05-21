<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Jobs\SendProductCreateEmailJob;
use App\Models\Product;
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
