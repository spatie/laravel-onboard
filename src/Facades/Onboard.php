<?php

namespace Spatie\Onboard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Onboard\Onboard
 */
class Onboard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-livewire-onboard';
    }
}
