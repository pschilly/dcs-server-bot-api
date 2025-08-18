<?php

namespace Pschilly\DcsServerBotApi\Commands;

use Illuminate\Console\Command;

class DcsServerBotApiCommand extends Command
{
    public $signature = 'dcs-server-bot-api:install {apiUrl?} {--force : Overwrite existing value without confirmation}';

    public $description = 'Config the DCS Server Bot API by adding the DCS Server Bot Websockets URL to the .env';

    public function handle(): int
    {
        $apiUrl = $this->argument('apiUrl');
        $force = $this->option('force');

        if (! $apiUrl) {
            $apiUrl = $this->ask('Enter the DCS Server Bot Websockets API URL, include the port # if applicable. EG: http://localhost:9876');
        }

        // Normalize the API URL
        if (! preg_match('/^https?:\/\//', $apiUrl)) {
            $apiUrl = 'http://'.$apiUrl;
        }
        // Add default port if not present
        $parsed = parse_url($apiUrl);
        if (
            (! isset($parsed['port']) || empty($parsed['port'])) &&
            ! preg_match('/:\d+$/', $apiUrl)
        ) {
            $apiUrl = rtrim($apiUrl, '/');
            $apiUrl .= ':9876';
        }

        $envPath = base_path('.env');
        $comment = '# DCS Server Bot Websockets API URL';

        $envContent = file_exists($envPath) ? file_get_contents($envPath) : '';

        // Check if DCS_BOT_API_URL is already set
        if (preg_match('/^(# DCS Server Bot Websockets API URL\s*)?^DCS_BOT_API_URL=.*$/m', $envContent, $matches)) {
            $currentValue = '';
            if (preg_match('/^DCS_BOT_API_URL=(.*)$/m', $envContent, $valMatch)) {
                $currentValue = $valMatch[1];
            }
            if (! $force) {
                $this->info("DCS_BOT_API_URL is already set to: {$currentValue}");
                if (! $this->confirm('Do you want to overwrite it?', false)) {
                    $this->info('No changes made.');

                    return self::SUCCESS;
                }
            }
            // Overwrite existing value and comment (replace both comment and env line)
            $envContent = preg_replace(
                '/(^# DCS Server Bot Websockets API URL\s*)?^DCS_BOT_API_URL=.*$/m',
                "{$comment}\nDCS_BOT_API_URL={$apiUrl}",
                $envContent
            );
        } else {
            // Add new value
            $envContent .= "\n{$comment}\nDCS_BOT_API_URL={$apiUrl}\n";
        }

        file_put_contents($envPath, $envContent);
        $this->info('DCS_BOT_API_URL set in .env file.');

        return self::SUCCESS;
    }
}
