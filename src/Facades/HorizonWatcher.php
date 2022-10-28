<?php

namespace Spatie\HorizonWatcher\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\HorizonWatcher\HorizonWatcher
 */
class HorizonWatcher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Spatie\HorizonWatcher\HorizonWatcher::class;
    }
}
