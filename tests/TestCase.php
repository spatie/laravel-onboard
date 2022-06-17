<?php

namespace Spatie\Onboard\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Onboard\OnboardServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            OnboardServiceProvider::class,
        ];
    }
}
