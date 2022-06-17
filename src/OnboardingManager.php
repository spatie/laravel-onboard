<?php

namespace Spatie\Onboard;

/**
 * The gateway into the package. This class exposes the overall
 * state of the onboarding instance. It will typically be
 * accessed like so: $user->onboarding()
 */
class OnboardingManager
{
    /**
     * All defined onboarding steps.
     *
     * @var array
     */
    public $steps;

    /**
     * Create the Onboarding Manager (should always be a singleton).
     *
     * @param mixed $user The parent app's user model.
     * @param \Spatie\Onboard\OnboardingSteps $onboardingSteps
     */
    public function __construct($user, OnboardingSteps $onboardingSteps)
    {
        $this->steps = $onboardingSteps->steps($user);
    }

    /**
     * An accessor for the $steps property
     *
     * @return array
     */
    public function steps()
    {
        return $this->steps;
    }

    /**
     * Determine if the users's onboarding is still in progress.
     *
     * @return bool
     */
    public function inProgress()
    {
        return ! $this->finished();
    }

    /**
     * Determine if the users's onboarding is complete.
     *
     * @return bool
     */
    public function finished()
    {
        return collect($this->steps)->filter(function ($step) {
            // Leave only incomplete steps.
            return $step->incomplete();
        })
            // Report onboarding is finished if no incomplete steps remain.
            ->isEmpty();
    }

    /**
     * Get the next unfinished onboarding step, or null if already all steps are completed.
     *
     * @return null|OnboardingStep
     */
    public function nextUnfinishedStep()
    {
        return collect($this->steps)->first(function ($step) {
            return $step->incomplete();
        });
    }
}
