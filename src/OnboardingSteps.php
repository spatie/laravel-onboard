<?php

namespace Spatie\Onboard;

use Illuminate\Support\Collection;
use Spatie\Onboard\Concerns\Onboardable;

class OnboardingSteps
{
    /** @var array<OnboardingStep> */
    protected array $steps = [];

    public function addStep(string $title): OnboardingStep
    {
        $this->steps[] = $step = new OnboardingStep($title);

        return $step;
    }

    public function steps(Onboardable $model): Collection
    {
        return collect($this->steps)->map(fn (OnboardingStep $step) => $step->setModel($model));
    }
}
