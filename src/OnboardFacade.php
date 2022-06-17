<?php

namespace Spatie\Onboard;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Onboard\OnboardingSteps
 */
class OnboardFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Spatie\Onboard\OnboardingSteps';
    }
}
