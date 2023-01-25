# Changelog

All notable changes to `laravel-onboard` will be documented in this file.

## 2.4.1 - 2023-01-25

- support L10

## 2.4.0 - 2022-09-24

### What's Changed

- Allow steps to be limited to specific classes by @RhysLees in https://github.com/spatie/laravel-onboard/pull/15

### New Contributors

- @RhysLees made their first contribution in https://github.com/spatie/laravel-onboard/pull/15

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/2.3.0...2.4.0

## 2.3.0 - 2022-08-17

### What's Changed

- Add callable attributes support by @talelmishali in https://github.com/spatie/laravel-onboard/pull/12

### New Contributors

- @talelmishali made their first contribution in https://github.com/spatie/laravel-onboard/pull/12

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/2.2.0...2.3.0

## 2.2.0 - 2022-08-10

### What's Changed

- Added variable name clarification by @titonova in https://github.com/spatie/laravel-onboard/pull/5
- Bump dependabot/fetch-metadata from 1.3.1 to 1.3.3 by @dependabot in https://github.com/spatie/laravel-onboard/pull/6
- Add Arrayable support by @mpociot in https://github.com/spatie/laravel-onboard/pull/11

### New Contributors

- @titonova made their first contribution in https://github.com/spatie/laravel-onboard/pull/5
- @dependabot made their first contribution in https://github.com/spatie/laravel-onboard/pull/6
- @mpociot made their first contribution in https://github.com/spatie/laravel-onboard/pull/11

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/2.1.1...2.2.0

## 2.1.1 - 2022-06-23

### What's Changed

- Update binding method by @tompec in https://github.com/spatie/laravel-onboard/pull/4

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/2.1.0...2.1.1

## 2.1.0 - 2022-06-22

### What's Changed

- Fix code example by @tompec in https://github.com/spatie/laravel-onboard/pull/1
- Excluding steps based on condition by @MohmmedAshraf in https://github.com/spatie/laravel-onboard/pull/3

### New Contributors

- @tompec made their first contribution in https://github.com/spatie/laravel-onboard/pull/1
- @MohmmedAshraf made their first contribution in https://github.com/spatie/laravel-onboard/pull/3

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/2.0.0...2.1.0

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
