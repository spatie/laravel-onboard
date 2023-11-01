<?php


use Spatie\Onboard\OnboardingManager;
use Spatie\Onboard\OnboardingStep;
use Spatie\Onboard\OnboardingSteps;
use Spatie\Onboard\Tests\Team;
use Spatie\Onboard\Tests\User;

beforeEach(function () {
    $this->user = new User();
    $this->team = new Team();
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
    $this->assertEquals(1, $onboardingSteps->steps(new Team())->count());

    $userStep = $onboardingSteps->steps(new User())->first();
    $teamStep = $onboardingSteps->steps(new Team())->first();

    expect($userStep->link)->toBe('/some/url')
        ->and($userStep->cta)->toBe('Test This!')
        ->and($userStep->title)->toBe('Test Step')
        ->and($userStep->another)->toBe('attribute');

    expect($teamStep->link)->toBe('/some/url')
        ->and($teamStep->cta)->toBe('Test This!')
        ->and($teamStep->title)->toBe('Test Step')
        ->and($teamStep->another)->toBe('attribute');
});

test('limited steps can be defined and configured', function () {
    $onboardingSteps = new OnboardingSteps();

    $onboardingSteps->addStep('Test Step', User::class)
        ->link('/some/url')
        ->cta('Test This!')
        ->attributes(['another' => 'attribute'])
        ->completeIf(function () {
            return true;
        });

    $this->assertEquals(1, $onboardingSteps->steps(new User())->count());
    $this->assertEquals(0, $onboardingSteps->steps(new Team())->count());

    $step = $onboardingSteps->steps(new User())->first();

    expect($step->link)->toBe('/some/url')
        ->and($step->cta)->toBe('Test This!')
        ->and($step->title)->toBe('Test Step')
        ->and($step->another)->toBe('attribute');
});

test('limited steps can be defined with normal steps', function () {
    $onboardingSteps = new OnboardingSteps();

    $onboardingSteps->addStep('Test Step', User::class);

    $onboardingSteps->addStep('Test Step Normal');

    $this->assertEquals(2, $onboardingSteps->steps(new User())->count());
});

test('multipe limited step models can be defined', function () {
    $onboardingSteps = new OnboardingSteps();

    $onboardingSteps->addStep('Test Step', User::class);

    $onboardingSteps->addStep('Test Step Team', Team::class);

    $this->assertEquals(1, $onboardingSteps->steps(new User())->count());
    $this->assertEquals(1, $onboardingSteps->steps(new Team())->count());
});

test('multipe limited step models can be defined with normal steps', function () {
    $onboardingSteps = new OnboardingSteps();

    $onboardingSteps->addStep('Test Step', User::class);

    $onboardingSteps->addStep('Test Step Normal', Team::class);

    $onboardingSteps->addStep('Test Step Normal');

    $this->assertEquals(2, $onboardingSteps->steps(new User())->count());
    $this->assertEquals(2, $onboardingSteps->steps(new Team())->count());
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

test('is finished when all steps are complete for limited models steps', function () {
    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Test Step', User::class)
        ->completeIf(function () {
            return true;
        });
    $onboardingSteps->addStep('Test Step', Team::class)
        ->completeIf(function () {
            return false;
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

test('step attrbiutes can be callable', function () {
    $this->user->name = fake()->name;

    $onboardingSteps = new OnboardingSteps();
    $onboardingSteps->addStep('Step 1')
        ->link('/some/url')
        ->cta('Test This!')
        ->attributes(function (User $model) {
            return [
                'user_name' => $model->name,
            ];
        });

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    $step = $onboarding->steps()->first();

    expect($step)
        ->user_name->not->toBeNull()
        ->user_name->toBe($this->user->name)
        ->title->tobe('Step 1');
});

test('can add step objects', function () {
    $onboardingSteps = new OnboardingSteps();
    $firstStep = (new OnboardingStep('Step 1'))
        ->link('/some/url')
        ->cta('Test This!');
    $secondStep = (new class ('Step 2') extends OnboardingStep {})
        ->link('/another/url')
        ->cta('Test That!');
    $onboardingSteps->addingStep($firstStep);
    $onboardingSteps->addingStep($secondStep);

    $onboarding = new OnboardingManager($this->user, $onboardingSteps);

    $step = $onboarding->steps()->first();

    expect($step)
        ->title->toBe('Step 1')
        ->cta->toBe('Test This!');

    expect($onboarding->steps()->last())
        ->title->toBe('Step 2')
        ->cta->toBe('Test That!');

    $firstStep->title = 'Step 11';
    $secondStep->title = 'Step 22';

    expect($step)
        ->title->toBe('Step 11')
        ->toArray()->toBe([
            'title' => 'Step 11',
            'link' => '/some/url',
            'cta' => 'Test This!',
            'complete' => false,
            'excluded' => false,
        ]);

    expect($onboarding->steps()->last())
        ->title->toBe('Step 22')
        ->toArray()->toBe([
            'title' => 'Step 22',
            'link' => '/another/url',
            'cta' => 'Test That!',
            'complete' => false,
            'excluded' => false,
        ]);
});
