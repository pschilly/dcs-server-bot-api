# Laravel DCS Server Bot API Service

[![Packagist Version](https://img.shields.io/packagist/v/pschilly/dcs-server-bot-api?style=for-the-badge)](https://packagist.org/packages/pschilly/dcs-server-bot-api)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/pschilly/dcs-server-bot-api/fix-php-code-style-issues.yml?branch=main&style=for-the-badge)](https://github.com/pschilly/dcs-server-bot-api/actions/workflows/phpstan.yml)
[![DCSServerBot](https://img.shields.io/badge/🤖_Requires-DCS_Server_Bot-green?style=for-the-badge)](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot)
[![Laravel v12 Required](https://img.shields.io/badge/Laravel-v12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)

This package acts as an interface service for the DCS Server Bot RestAPI in order to access information from the bot on a remote web server for display purposes.

In order for this to be function, you must already have the [DCS Server Bot](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot) setup and running, including the following plugin / service:

-   RestAPI [Docs](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/plugins/restapi/README.md)
-   WebService [Docs](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/services/webservice/README.md)

## Installation

You can install the package via composer:

```bash
composer require pschilly/dcs-server-bot-api
```

## Configuration

In order for the service to know where to make the API calls you must identify where the API server is located. By default, the service will look for `http://localhost:9876` - this is only going to be useful if you are running your website on the same server as the **master node** of the DCS Server bot.

To alter this default URL, run one of the following commands:

```bash
php artisan dcs-server-bot-api:install
```

```bash
php artisan dcs-server-bot-api:install --url="http://localhost:9867" [--force]
```

Although possible, it is not necessary to publish the config file given that the singular config parameter is pulled from your applications .env. Never the less, this is the command and contents of the published config file:

```bash
php artisan vendor:publish --tag="dcs-server-bot-api-config"
```

```php
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

Import the model:
```php
use Pschilly\DcsServerBotApi\DcsServerBotApi;
```

Call the endpoint that you need based on the [DCS Server Bot RestAPI Docs](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/plugins/restapi/README.md), eg:

```php
$data = DcsServerBotApi::getServerStats();
```

This will give you a json array that you can then do with what you please!

For more information on the API - you can enable "debug" mode on your WebService plugin where you will then be able to hit the API server with the following link `http://localhost:9678/docs` and get a full rundown on the API calls.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## TODO

-   Add Caching Support

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Schilly](https://github.com/pschilly)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
