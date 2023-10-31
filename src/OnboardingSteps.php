<?php

namespace Spatie\Onboard;

use Illuminate\Support\Collection;
use Spatie\Onboard\Concerns\Onboardable;

class OnboardingSteps
{
    /** @var array<OnboardingStep> */
    protected array $steps = [];

    public function addStep(string $title, string $model = null): OnboardingStep
    {
        $step = new OnboardingStep($title);

        return $this->addOnboardingStep($step, $model);
    }

    public function addOnboardingStep(OnboardingStep $step, string $model = null): OnboardingStep
    {
        if ($model && new $model() instanceof Onboardable) {
            return $this->steps[$model][] = $step;
        }

        return $this->steps['default'][] = $step;
    }

    public function steps(Onboardable $model): Collection
    {
        return collect($this->getStepsArray($model))
            ->map(fn (OnboardingStep $step) => $step->initiate($model))
            ->filter(fn (OnboardingStep $step) => $step->notExcluded());
    }

    private function getStepsArray(Onboardable $model): array
    {
        $key = get_class($model);

        if (key_exists($key, $this->steps)) {
            return array_merge(
                $this->steps[$key],
                $this->steps['default'] ?? []
            );
        }

        return $this->steps['default'] ?? [];
    }
}
