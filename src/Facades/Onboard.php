<?php

namespace Spatie\Onboard\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Spatie\Onboard\Concerns\Onboardable;
use Spatie\Onboard\OnboardingStep;
use Spatie\Onboard\OnboardingSteps;

/**
 * @method OnboardingStep addStep(string $title, string $model = null)
 * @method Collection<OnboardingStep> steps(Onboardable $model)
 */
class Onboard extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return OnboardingSteps::class;
    }
}
