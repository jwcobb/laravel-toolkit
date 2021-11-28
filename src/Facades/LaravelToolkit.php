<?php

namespace JWCobb\LaravelToolkit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JWCobb\LaravelToolkit\LaravelToolkit
 */
class LaravelToolkit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-toolkit';
    }
}
