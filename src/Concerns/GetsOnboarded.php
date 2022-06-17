<?php

namespace Spatie\Onboard\Concerns;

use Illuminate\Support\Facades\App;
use Spatie\Onboard\OnboardingManager;

trait GetsOnboarded
{
    public function onboarding(): OnboardingManager
    {
        return App::make(OnboardingManager::class, ['model' => $this]);
    }
}
