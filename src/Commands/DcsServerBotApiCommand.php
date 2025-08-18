<?php

namespace Pschilly\DcsServerBotApi\Commands;

use Illuminate\Console\Command;

class DcsServerBotApiCommand extends Command
{
    public $signature = 'dcs-server-bot-api';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
