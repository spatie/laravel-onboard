<?php

namespace Spatie\Onboard\Concerns;

use Spatie\Onboard\OnboardingManager;

interface Onboardable
{
    public function onboarding(): OnboardingManager;
}
