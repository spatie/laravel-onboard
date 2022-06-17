<?php

namespace Spatie\Onboard;

/**
 * A container for onboarding steps.
 */
class OnboardingSteps
{
    /**
     * The defined onboarding steps. Note: these do not contain a user
     * yet, therefore they should not be accessed directly.
     *
     * @var array
     */
    protected $steps = [];

    /**
     * Add an onboarding step starting with a title. This is the starting
     * method to initiate a fluent interface for configuring the step.
     *
     * @param string $title The title of the step.
     */
    public function addStep($title)
    {
        $this->steps[] = $step = new OnboardingStep($title);

        return $step;
    }

    /**
     * The accessor to retrieve all the defined steps. This does the important
     * job of ensuring each step has access to the current user object.
     *
     * @param  object $user The current user object
     * @return \Illuminate\Support\Collection
     */
    public function steps($user)
    {
        // Load each step with the current User object.
        return collect($this->steps)->map(function ($step) use ($user) {
            return $step->setUser($user);
        });
    }
}
