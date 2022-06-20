
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# A Laravel package to help track user onboarding steps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-onboard.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-onboard)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-onboard/run-tests?label=tests)](https://github.com/spatie/laravel-onboard/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-onboard/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/laravel-onboard/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-onboard.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-onboard)

This package lets you set up an onboarding flow for your application's users.

Here's an example of how it's set up:

```php
use App\User;
use Spatie\Onboard\Facades\Onboard;

Onboard::addStep('Complete Profile')
    ->link('/profile')
    ->cta('Complete')
    ->completeIf(function (User $model) {
        return $model->profile->isComplete();
    });

Onboard::addStep('Create Your First Post')
    ->link('/post/create')
    ->cta('Create Post')
    ->completeIf(function (User $model) {
        return $model->posts->count() > 0;
    });
```

You can then render this onboarding flow however you want in your templates:

```blade
@if (auth()->user()->onboarding()->inProgress())
    <div>
        @foreach (auth()->user()->onboarding()->steps as $step)
            <span>
                @if($step->complete())
                    <i class="fa fa-check-square-o fa-fw"></i>
                    <s>{{ $loop->iteration }}. {{ $step->title }}</s>
                @else
                    <i class="fa fa-square-o fa-fw"></i>
                    {{ $loop->iteration }}. {{ $step->title }}
                @endif
            </span>

            <a href="{{ $step->link }}" {{ $step->complete() ? 'disabled' : '' }}>
                {{ $step->cta }}
            </a>
        @endforeach
    </div>
@endif
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-onboard.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-onboard)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-onboard
```

## Usage

Add the `Spatie\Onboard\Concerns\GetsOnboarded` trait and `Spatie\Onboard\Concerns\Onboardable` interface to any model or class in your app, for example the `User` model:

```php
class User extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use \Spatie\Onboard\Concerns\GetsOnboarded;
    ...
```

### Example configuration

Configure your steps in your `App\Providers\AppServiceProvider.php`

```php
use App\User;
use Spatie\Onboard\Facades\Onboard;

class AppServiceProvider extends ServiceProvider
{
    // ...

    public function boot()
    {
	    Onboard::addStep('Complete Profile')
	    	->link('/profile')
	    	->cta('Complete')
	    	/**
             * The completeIf will pass the class that you've added the
             * interface & trait to. You can use Laravel's dependency
             * injection here to inject anything else as well.
             */
	    	->completeIf(function (User $model) {
	    		return $model->profile->isComplete();
	    	});

	    Onboard::addStep('Create Your First Post')
	    	->link('/post/create')
	    	->cta('Create Post')
	    	->completeIf(function (User $model) {
	    		return $model->posts->count() > 0;
	    	});
```

### Usage

Now you can access these steps along with their state wherever you like. Here is an example blade template:

```blade
@if (auth()->user()->onboarding()->inProgress())
	<div>
		@foreach (auth()->user()->onboarding()->steps as $step)
			<span>
				@if($step->complete())
					<i class="fa fa-check-square-o fa-fw"></i>
					<s>{{ $loop->iteration }}. {{ $step->title }}</s>
				@else
					<i class="fa fa-square-o fa-fw"></i>
					{{ $loop->iteration }}. {{ $step->title }}
				@endif
			</span>
						
			<a href="{{ $step->link }}" {{ $step->complete() ? 'disabled' : '' }}>
				{{ $step->cta }}
			</a>
		@endforeach
	</div>
@endif
```

Check out all the available features below:

```php
/** @var \Spatie\Onboard\OnboardingManager $onboarding **/
$onboarding = Auth::user()->onboarding();

$onboarding->inProgress();

$onboarding->percentageCompleted();

$onboarding->finished();

$onboarding->steps()->each(function($step) {
	$step->title;
	$step->cta;
	$step->link;
	$step->complete();
	$step->incomplete();
});
```

Definining custom attributes and accessing them:

```php
// Defining the attributes
Onboard::addStep('Step w/ custom attributes')
	->attributes([
		'name' => 'Waldo',
		'shirt_color' => 'Red & White',
	]);

// Accessing them
$step->name;
$step->shirt_color;
```

### Example middleware

If you want to ensure that your User is redirected to the next unfinished onboarding step, whenever they access your web application, you can use the following middleware as a starting point:

```php
<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectToUnfinishedOnboardingStep
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->onboarding()->inProgress()) {
            return redirect()->to(
                auth()->user()->onboarding()->nextUnfinishedStep()->link
            );
        }
        
        return $next($request);
    }
}
```

**Quick tip:** Don't add this middleware to routes that update the state of the onboarding steps, your users will not be able to progress because they will be redirected back to the onboarding step.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits
- [Rias Van der Veken](https://github.com/riasvdv)
- [All Contributors](../../contributors)

The original code from this package came from [Onboard](https://github.com/calebporzio/onboard) by [Caleb Porzio](https://github.com/calebporzio), who was gratious enough to let us continue development.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
