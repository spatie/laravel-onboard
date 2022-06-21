<?php


use Spatie\Onboard\OnboardingManager;
use Spatie\Onboard\OnboardingSteps;
use Spatie\Onboard\Tests\User;

beforeEach(function () {
    $this->user = new User();
});

test('steps can be defined and configured', function () {
    $onboardingSteps = new OnboardingSteps();

    $onboardingSteps->addStep('Test Step')
        ->link('/some/url')
        ->cta('Test This!')
        ->attributes(['another' => 'attribute'])
        ->completeIf(function () {
            return true;
        });

    $this->assertEquals(1, $onboardingSteps->steps(new User())->count());

    $step = $onboardingSteps->steps(new User())->first();

    expect($step->link)->toBe('/some/url')
        ->and($step->cta)->toBe('Test This!')
        ->and($step->title)->toBe('Test Step')
        ->and($step->another)->toBe('attribute');
});

test('is in progress when all steps are incomplete', function () {
    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Test Step');
    $onboardingSteps->addStep('Another Test Step');

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    expect($onboarding->inProgress())->toBeTrue()
        ->and($onboarding->finished())->toBeFalse();
});

test('is finished when all steps are complete', function () {
    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Test Step')
        ->completeIf(function () {
            return true;
        });

    $onboardingSteps->addStep('Excluded Step')
        ->excludeIf(function () {
            return true;
        })
        ->completeIf(function () {
            return false;
        });

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    expect($onboarding->finished())->toBeTrue()
        ->and($onboarding->inProgress())->toBeFalse();
});

test('it returns the correct next unfinished step', function () {
    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Step 1')
        ->link("/step-1")
        ->completeIf(function () {
            return true;
        });

    $onboardingSteps->addStep('Step 2')
        ->link("/step-2")
        ->completeIf(function () {
            return false;
        });

    $onboardingSteps->addStep('Step 3')
        ->link("/step-3")
        ->completeIf(function () {
            return false;
        });

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    $nextStep = $onboarding->nextUnfinishedStep();

    expect($nextStep)->not()->toBeNull()
        ->and($nextStep->title)->toBe("Step 2")
        ->and($nextStep->link)->toBe("/step-2");
});

test('nextUnfinishedStep returns null if all steps are completed', function () {
    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Step 1')
        ->completeIf(function () {
            return true;
        });

    $onboardingSteps->addStep('Step 2')
        ->completeIf(function () {
            return true;
        });

    $onboardingSteps->addStep('Step 3')
        ->completeIf(function () {
            return true;
        });

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    $nextStep = $onboarding->nextUnfinishedStep();

    expect($nextStep)->toBeNull();
});

test('the proper object gets passed into completion callback', function () {
    $user = $this->mock(User::class);
    $user->shouldReceive('testMe')->once();

    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Test Step')
        ->completeIf(function ($model) {
            // if this gets called, it ensures that the right object was passed through.
            $model->testMe();

            return true;
        });

    $onboarding = new OnboardingManager($user, $onboardingSteps);

    expect($onboarding->finished())->toBeTrue();
});

it('can get percentage completed', function () {
    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Step 1')
        ->link("/step-1")
        ->completeIf(function () {
            return true;
        });

    $onboardingSteps->addStep('Step 2')
        ->link("/step-2")
        ->completeIf(function () {
            return false;
        });

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    expect($onboarding->percentageCompleted())->toBe(50.0);
});

it('will only run complete callbacks once', function () {
    $called = 0;

    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Step 1')
        ->link("/step-1")
        ->completeIf(function () use (&$called) {
            $called++;

            return true;
        });

    $onboardingSteps->addStep('Step 2')
        ->link("/step-2")
        ->completeIf(function () {
            return false;
        });

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    $onboarding->finished();

    expect($called)->toBe(1);

    $onboarding->finished();

    expect($called)->toBe(1)
        ->and($onboarding->finished())->toBeFalse();
});
