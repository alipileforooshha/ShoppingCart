<?php

namespace App\Repositories\Interfaces;

interface CartInterface {
    public function index();
    public function addToCart($request);
    public function removeFromCart($request);
}