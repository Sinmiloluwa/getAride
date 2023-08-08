<?php

namespace App\Services\Paystack;

class Paystack
{
    protected static function process(): Config
    {
        return new Config();
    }

    public static function __callStatic($method, $arguments){
        return self::process()->{$method}(...$arguments);
    }
}
