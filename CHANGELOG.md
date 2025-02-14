# Changelog

All notable changes to `laravel-onboard` will be documented in this file.

## 2.6.1 - 2025-02-14

### What's Changed

* Bump dependabot/fetch-metadata from 1.6.0 to 2.2.0 by @dependabot in https://github.com/spatie/laravel-onboard/pull/40
* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot in https://github.com/spatie/laravel-onboard/pull/42
* Laravel 12.x Compatibility by @laravel-shift in https://github.com/spatie/laravel-onboard/pull/43

### New Contributors

* @laravel-shift made their first contribution in https://github.com/spatie/laravel-onboard/pull/43

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/2.6.0...2.6.1

## 2.6.0 - 2024-02-14

### What's Changed

* Add Laravel 11 support by @alexanderkroneis in https://github.com/spatie/laravel-onboard/pull/35

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/2.5.0...2.6.0

## 2.5.0 - 2023-11-01

### What's Changed

- Bump dependabot/fetch-metadata from 1.3.5 to 1.3.6 by @dependabot in https://github.com/spatie/laravel-onboard/pull/25
- update Onboard facade docblock by @alphaolomi in https://github.com/spatie/laravel-onboard/pull/26
- Fix inconsistent tabs/space usage in README by @arkoe in https://github.com/spatie/laravel-onboard/pull/27
- Bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/spatie/laravel-onboard/pull/28
- Bump dependabot/fetch-metadata from 1.4.0 to 1.5.1 by @dependabot in https://github.com/spatie/laravel-onboard/pull/30
- Bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/spatie/laravel-onboard/pull/31
- Alternative way to add onboarding steps by @fedeisas in https://github.com/spatie/laravel-onboard/pull/34
- Bump stefanzweifel/git-auto-commit-action from 4 to 5 by @dependabot in https://github.com/spatie/laravel-onboard/pull/33
- Bump actions/checkout from 3 to 4 by @dependabot in https://github.com/spatie/laravel-onboard/pull/32

### New Contributors

- @alphaolomi made their first contribution in https://github.com/spatie/laravel-onboard/pull/26
- @arkoe made their first contribution in https://github.com/spatie/laravel-onboard/pull/27
- @fedeisas made their first contribution in https://github.com/spatie/laravel-onboard/pull/34

**Full Changelog**: https://github.com/spatie/laravel-onboard/compare/2.4.1...2.5.0

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
