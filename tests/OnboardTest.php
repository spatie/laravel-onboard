<?php


use Spatie\Onboard\OnboardingSteps;
use Spatie\Onboard\OnboardingManager;

beforeEach(function () {
    $this->user = $this->mock('User');
});

test('steps can be defined and configured', function () {
    $onboardingSteps = new OnboardingSteps;

    $onboardingSteps->addStep('Test Step')
        ->link('/some/url')
        ->cta('Test This!')
        ->attributes(['another' => 'attribute'])
        ->completeIf(function () {
            return true;
        });

    $this->assertEquals(1, $onboardingSteps->steps(new stdClass())->count());

    $step = $onboardingSteps->steps(new stdClass())->first();

    $this->assertEquals('/some/url', $step->link);
    $this->assertEquals('Test This!', $step->cta);
    $this->assertEquals('Test Step', $step->title);
    $this->assertEquals('attribute', $step->another);
});

test('is in progress when all steps are incomplete', function () {
    $onboardingSteps = new OnboardingSteps;
    $onboardingSteps->addStep('Test Step');
    $onboardingSteps->addStep('Another Test Step');

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    $this->assertTrue($onboarding->inProgress());
    $this->assertFalse($onboarding->finished());
});

test('is finished when all steps are complete', function () {
    $onboardingSteps = new OnboardingSteps;
    $onboardingSteps->addStep('Test Step')
        ->completeIf(function () {
            return true;
        });

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    $this->assertTrue($onboarding->finished());
    $this->assertFalse($onboarding->inProgress());
});

test('it returns the correct next unfinished step', function () {
    $onboardingSteps = new OnboardingSteps;
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

    $this->assertNotNull($nextStep);
    $this->assertEquals("Step 2", $nextStep->title);
    $this->assertEquals("/step-2", $nextStep->link);
});

test('nextUnfinishedStep returns null if all steps are completed', function () {
    $onboardingSteps = new OnboardingSteps;
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

    $this->assertNull($nextStep);
});

test('the proper object gets passed into completion callback', function () {
    $user = $this->mock('User');
    $user->shouldReceive('testMe')->once();

    $onboardingSteps = new OnboardingSteps;
    $onboardingSteps->addStep('Test Step')
        ->completeIf(function ($user) {
            // if this gets called, it ensures that the right object was passed through.
            $user->testMe();
            return true;
        });

    $onboarding = new OnboardingManager($user, $onboardingSteps);

    // Calling finished() will triger the completeIf callback.
    $this->assertTrue($onboarding->finished());
});
