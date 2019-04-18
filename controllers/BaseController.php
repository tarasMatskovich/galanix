<?php


namespace App\Controllers;


abstract class BaseController
{
    public function __call($methodName, $args)
    {
        throw new \Exception("Action:" . $methodName . " is not exist in controller file: " . static::class);
    }
}