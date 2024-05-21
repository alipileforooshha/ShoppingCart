<?php

namespace App\Providers;

use App\Repositories\Concretes\ProductRepository;
use App\Repositories\Interfaces\ProductInterface;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function($status,$data,$message){
            return response()->json([
                'data' => $data,
                'message' => $message
            ],$status);
        });

        Response::macro('failed', function($status,$data,$message){
            return response()->json([
                'data' => $data,
                'message' => $message
            ],$status);
        });
    }
}
