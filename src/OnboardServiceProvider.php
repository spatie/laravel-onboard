<?php

namespace Spatie\Onboard;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OnboardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-onboard');

        $this->app->scoped(OnboardingSteps::class);
    }
}
