<?php

namespace Pschilly\LaravelDcsServerBotApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Pschilly\LaravelDcsServerBotApi\Commands\LaravelDcsServerBotApiCommand;

class LaravelDcsServerBotApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-dcs-server-bot-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_dcs_server_bot_api_table')
            ->hasCommand(LaravelDcsServerBotApiCommand::class);
    }
}
