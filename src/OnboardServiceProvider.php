<?php

namespace Spatie\Onboard;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\Onboard\Commands\OnboardCommand;

class OnboardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-livewire-onboard')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-livewire-onboard_table')
            ->hasCommand(OnboardCommand::class);
    }
}
