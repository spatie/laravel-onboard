<?php

namespace Spatie\Onboard\Tests;

use Illuminate\Database\Eloquent\Model;
use Spatie\Onboard\Concerns\GetsOnboarded;
use Spatie\Onboard\Concerns\Onboardable;

class User extends Model implements Onboardable
{
    use GetsOnboarded;
}
