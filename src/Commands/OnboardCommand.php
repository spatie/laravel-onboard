<?php

namespace Spatie\Onboard\Commands;

use Illuminate\Console\Command;

class OnboardCommand extends Command
{
    public $signature = 'laravel-livewire-onboard';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
