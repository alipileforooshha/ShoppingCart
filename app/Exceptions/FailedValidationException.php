<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Response;

class FailedValidationException extends Exception
{
    public $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;    
    }

    public function render()
    {
        return Response::failed(422,$this->errors,'مقادیر ورودی باید از قوانین پیروی کنند');
    }
}
