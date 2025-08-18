<?php

namespace Pschilly\DcsServerBotApi;

use Pschilly\DcsServerBotApi\Commands\DcsServerBotApiCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DcsServerBotApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('dcs-server-bot-api')
            ->hasConfigFile()
            ->hasCommand(DcsServerBotApiCommand::class);
    }
}
