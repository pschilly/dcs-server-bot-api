# Laravel DCS Server Bot API Service

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pschilly/laravel-dcs-server-bot-api.svg?style=flat-square)](https://packagist.org/packages/pschilly/laravel-dcs-server-bot-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pschilly/laravel-dcs-server-bot-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pschilly/laravel-dcs-server-bot-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pschilly/laravel-dcs-server-bot-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pschilly/laravel-dcs-server-bot-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pschilly/laravel-dcs-server-bot-api.svg?style=flat-square)](https://packagist.org/packages/pschilly/laravel-dcs-server-bot-api)

This package acts as an interface service for the DCS Server Bot RestAPI in order to access information from the bot on a remote web server for display purposes.

## Installation

You can install the package via composer:

```bash
composer require pschilly/dcs-server-bot-api
```

Setup you API url:

```bash
php artisan dci-server-bot-api:install

-or-

php artisan dci-server-bot-api:install --url="http://localhost:9867" [--force]
```

you can publish the config file with:

```bash
php artisan vendor:publish --tag="dcs-server-bot-api-config"
```

This is the contents of the published config file:

```php
// config for Pschilly/DcsServerBotApi
return [

    /*
    |--------------------------------------------------------------------------
    | DCS Bot API URL
    |--------------------------------------------------------------------------
    |
    | This value is the base URL for the DCS Bot API, which will be used when
    | making requests to the API endpoints.
    |
    | See documentation of DCS Server Bot API for more details & configuration on your actual DCS Server Bot.
    |   WebService: https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/services/webservice/README.md
    |   RestAPI: https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/plugins/restapi/README.md
    |
    */

    'base_url' => env('DCS_BOT_API_URL', 'http://localhost:9876'),

];
```

## Usage

### Setup the API URL in your .env File

-   Use the command ``and follow the prompts, or,`php artisan dci-server-bot-api:install http://localhost:9876` to skip the prompts.

### Access the individual Rest API calls

-   Check the Wiki for more information.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Schilly](https://github.com/pschilly)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
