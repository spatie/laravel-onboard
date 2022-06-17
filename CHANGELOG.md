# Changelog

All notable changes to `laravel-onboard` will be documented in this file.

## 2.0.0 - 2022-06-17

### What's changed

- You can now add onboarding to any model using the trait & interface
- Added dependency injection to the `completeIf` callback
- The `completeIf` callback is now cached using `spatie/once` to only run once per request
- Added a `percentageCompleted` method

### Upgrading from v1 to v2

- Support for PHP 7.4 has been dropped
- Support for Laravel 7 and 8 has been dropped
- The `\Spatie\Onboard\OnboardFacade` has been moved to `\Spatie\Onboard\Facades\Onboard`
- The `\Spatie\Onboard\GetsOnboarded` trait has been moved to `\Spatie\Onboard\Concerns\GetsOnboarded`
- You should add the new `\Spatie\Onboard\Concerns\Onboardable` interface to your `User` model
- The `$user` parameter in the `completeIf` callback has been renamed to `$model` and it now supports dependency injection

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/1.0.0...2.0.0

## 1.0.0 - 2022-06-17

### First release

- Compatible with https://github.com/calebporzio/onboard
- Should only need to change the namespace

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/0.0.2...1.0.0

## 0.0.2 - 2022-06-17

Experimental release

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/0.0.1...0.0.2
