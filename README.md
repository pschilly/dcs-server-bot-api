# Laravel DCS Server Bot API Service

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pschilly/laravel-dcs-server-bot-api.svg?style=flat-square)](https://packagist.org/packages/pschilly/laravel-dcs-server-bot-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pschilly/laravel-dcs-server-bot-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pschilly/laravel-dcs-server-bot-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pschilly/laravel-dcs-server-bot-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pschilly/laravel-dcs-server-bot-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pschilly/laravel-dcs-server-bot-api.svg?style=flat-square)](https://packagist.org/packages/pschilly/laravel-dcs-server-bot-api)

This package acts as an interface service for the DCS Server Bot RestAPI in order to access information from the bot on a remote web server for display purposes.

## Installation

You can install the package via composer:

```bash
composer require pschilly/laravel-dcs-server-bot-api
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-dcs-server-bot-api-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-dcs-server-bot-api-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-dcs-server-bot-api-views"
```

## Usage

```php
$laravelDcsServerBotApi = new Pschilly\LaravelDcsServerBotApi();
echo $laravelDcsServerBotApi->echoPhrase('Hello, Pschilly!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Schilly](https://github.com/pschilly)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
