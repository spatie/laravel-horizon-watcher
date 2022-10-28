# Automatically restart Horizon when local file changes are detected

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-horizon-watcher.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-horizon-watcher)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-horizon-watcher/run-tests?label=tests)](https://github.com/spatie/laravel-horizon-watcher/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-horizon-watcher/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/spatie/laravel-horizon-watcher/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-horizon-watcher.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-horizon-watcher)

How many hours have lost debugging local jobs only to find out that you forgot to restart Horizon?

This package contains a command `horizon:watch` that will automatically restart Horizon when any PHP file is created, updated or deleted.

This command is meant to be used in local environment.

![screenshot](https://github.com/spatie/laravel-horizon-watcher/blob/main/docs/images/screenshot.jpg)

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-horizon-watcher.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-horizon-watcher)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-horizon-watcher
```



```bash
php artisan vendor:publish --tag="horizon-watcher-config"
```

This is the contents of the published config file:

```php
return [
    /*
     * Horizon will be restarted when any PHP file
     * inside these directories get created,
     * updated or deleted.
     */

    'paths' => [
        app_path(),
        resource_path('views'),
    ],

    /*
     * This command will be executed to start Horizon.
     */
    'command' => 'php artisan horizon',
];
```


## Usage

Run `php artisan horizon:watch` to start Horizon. When a PHP file in your project gets created, updated or deleted, Horizon will automatically restart.

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

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
