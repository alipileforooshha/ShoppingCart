<?php

namespace App\Repositories\Interfaces;

interface ProductInterface {
    public function index();
    public function create($request);
}