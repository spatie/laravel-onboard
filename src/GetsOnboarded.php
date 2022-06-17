<?php

namespace Spatie\Onboard;

use Illuminate\Support\Facades\App;

/**
 * This is the trait to be added to the app's User class.
 */
trait GetsOnboarded
{
    /**
     * This provides a pathway for the package's API
     *
     * @return \Spatie\Onboard\OnboardingManager $onboarding
     */
    public function onboarding()
    {
        return App::make(OnboardingManager::class, ['user' => $this]);
    }
}
