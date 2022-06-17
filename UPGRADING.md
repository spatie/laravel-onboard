## Upgrading
### Upgrading from v1 to v2

* Support for PHP 7.4 has been dropped
* Support for Laravel 7 and 8 has been dropped
* The `\Spatie\Onboard\OnboardFacade` has been moved to `\Spatie\Onboard\Facades\Onboard`
* The `\Spatie\Onboard\GetsOnboarded` trait has been moved to `\Spatie\Onboard\Concerns\GetsOnboarded`
* You should add the new `\Spatie\Onboard\Concerns\Onboardable` interface to your `User` model
* The `$user` parameter in the `completeIf` callbacks has been renamed to `$model`
