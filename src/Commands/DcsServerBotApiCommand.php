<?php

namespace Pschilly\DcsServerBotApi\Commands;

use Illuminate\Console\Command;

class DcsServerBotApiCommand extends Command
{
    public $signature = 'dcs-server-bot-api:install {--url= : The DCS Server Bot Websockets API URL} {--force : Overwrite existing value without confirmation}';

    public $description = 'Config the DCS Server Bot API by adding the DCS Server Bot Websockets URL to the .env';

    public function handle(): int
    {
        $apiUrl = $this->option('url');
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

        // Ask for API key (optional but recommended)
        $apiKey = $this->ask('Enter your DCS Server Bot API Key (optional but HIGHLY recommended)', '');

        $envPath = base_path('.env');
        $commentUrl = '# DCS Server Bot Websockets API URL';
        $commentKey = '# DCS Server Bot API Key';

        $envContent = file_exists($envPath) ? file_get_contents($envPath) : '';

        // Handle DCS_BOT_API_URL
        if (preg_match('/^(# DCS Server Bot Websockets API URL\s*)?^DCS_BOT_API_URL=.*$/m', $envContent, $matches)) {
            $currentValue = '';
            if (preg_match('/^DCS_BOT_API_URL=(.*)$/m', $envContent, $valMatch)) {
                $currentValue = $valMatch[1];
            }

            $array =
                [
                    'Current Value' => $currentValue,
                    'New Value' => $apiUrl,
                ];

            if (! $force) {
                $this->newLine();
                $this->alert('WARNING: You are about to overwrite the existing DCS_BOT_API_URL!');
                $this->question('Are you sure you want to overwrite the existing URL?');
                $this->table(
                    ['Current Config', 'Newly Provided'],
                    [$array]
                );
                if (! $this->confirm('Proceed?', false)) {
                    $this->info('No changes made.');

                    return self::SUCCESS;
                }
            }
            // Overwrite existing value and comment (replace both comment and env line)
            $envContent = preg_replace(
                '/(^# DCS Server Bot Websockets API URL\s*)?^DCS_BOT_API_URL=.*$/m',
                "{$commentUrl}\nDCS_BOT_API_URL={$apiUrl}",
                $envContent
            );
        } else {
            // Add new value
            $envContent .= "\n{$commentUrl}\nDCS_BOT_API_URL={$apiUrl}\n";
        }

        // Handle DCS_SERVER_BOT_API_KEY (optional)
        if ($apiKey !== '') {
            $keyExists = preg_match('/^(# DCS Server Bot API Key\s*)?^DCS_BOT_API_KEY=.*$/m', $envContent);
            $currentKey = '';
            if ($keyExists && preg_match('/^DCS_BOT_API_KEY=(.*)$/m', $envContent, $keyMatch)) {
                $currentKey = $keyMatch[1];
            }

            $keyArray = [
                'Current Value' => $currentKey,
                'New Value' => $apiKey,
            ];

            if ($keyExists && ! $force) {
                $this->newLine();
                $this->alert('WARNING: You are about to overwrite the existing DCS_BOT_API_KEY!');
                $this->question('Are you sure you want to overwrite the existing API Key?');
                $this->table(
                    ['Current Config', 'Newly Provided'],
                    [$keyArray]
                );
                if (! $this->confirm('Proceed?', false)) {
                    $this->info('No changes made to API Key.');
                } else {
                    // Overwrite existing value and comment (replace both comment and env line)
                    $envContent = preg_replace(
                        '/(^# DCS Server Bot API Key\s*)?^DCS_BOT_API_KEY=.*$/m',
                        "{$commentKey}\nDCS_BOT_API_KEY={$apiKey}",
                        $envContent
                    );
                    $this->info('DCS_BOT_API_KEY set in .env file.');
                }
            } else {
                // Add new value or force overwrite
                if ($keyExists) {
                    $envContent = preg_replace(
                        '/(^# DCS Server Bot API Key\s*)?^DCS_BOT_API_KEY=.*$/m',
                        "{$commentKey}\nDCS_SERVER_BOT_API_KEY={$apiKey}",
                        $envContent
                    );
                } else {
                    $envContent .= "\n{$commentKey}\nDCS_BOT_API_KEY={$apiKey}\n";
                }
                $this->info('DCS_SERVER_BOT_API_KEY set in .env file.');
            }
        } else {
            $this->warn('No API key set. It is HIGHLY recommended to set one for security.');
        }

        file_put_contents($envPath, $envContent);
        $this->info('DCS_BOT_API_URL set in .env file.');

        return self::SUCCESS;
    }
}
