<?php

namespace Pschilly\LaravelDcsServerBotApi\Commands;

use Illuminate\Console\Command;

class LaravelDcsServerBotApiCommand extends Command
{
    public $signature = 'laravel-dcs-server-bot-api';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
