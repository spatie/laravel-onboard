<?php

namespace Spatie\Onboard;

use Illuminate\Support\Collection;

class OnboardingManager
{
    /** @var Collection<OnboardingStep> */
    public Collection $steps;

    public function __construct($model, OnboardingSteps $onboardingSteps)
    {
        $this->steps = $onboardingSteps->steps($model);
    }

    /** @return Collection<OnboardingStep> */
    public function steps(): Collection
    {
        return $this->steps;
    }

    public function inProgress(): bool
    {
        return ! $this->finished();
    }

    public function finished(): bool
    {
        return $this->steps
            ->filter(fn (OnboardingStep $step) => $step->incomplete())
            ->isEmpty();
    }

    public function nextUnfinishedStep(): ?OnboardingStep
    {
        return $this->steps->first(fn (OnboardingStep $step) => $step->incomplete());
    }

    public function percentageCompleted(): float
    {
        $totalCompleteSteps = $this->steps
            ->filter(fn (OnboardingStep $step) => $step->complete())
            ->count();

        return $totalCompleteSteps / $this->steps->count() * 100;
    }
}
