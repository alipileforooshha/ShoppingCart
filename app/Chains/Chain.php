<?php

namespace App\Chains;

abstract class Chain
{
    protected $successor;

    abstract function handle();

    public function setSuccesor(Chain $successor)
    {
        $this->successor = $successor;
    }

    public function next()
    {
        if($this->successor)
        {
            $this->successor->handle();
        }else{
            return;
        }
    }
}