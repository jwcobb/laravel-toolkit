# A collection of things I use in nearly every Laravel app.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jwcobb/laravel-toolkit.svg?style=flat-square)](https://packagist.org/packages/jwcobb/laravel-toolkit)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jwcobb/laravel-toolkit/run-tests?label=tests)](https://github.com/jwcobb/laravel-toolkit/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/jwcobb/laravel-toolkit/Check%20&%20fix%20styling?label=code%20style)](https://github.com/jwcobb/laravel-toolkit/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jwcobb/laravel-toolkit.svg?style=flat-square)](https://packagist.org/packages/jwcobb/laravel-toolkit)


What's included:
- Config
  - site (where I like to define miscellaneous stuff related to the app/site)
- Helpers
  - Common: General helper functions
  - Forms: Things I use when creating `<form>`s
  - Tickets: Functions used with ticket resale stuff
- Migrations
  - Create `email_addresses` table
  - Create `phone_numbers` table
  - Create `street_addresses` table
- Models
    - EmailAddress
    - PhoneNumber
    - Address
    - HasPrimary (trait)
- Presenters (uses [datacreativa/laravel-presentable](https://github.com/datacreativa/laravel-presentable))
    - EmailAddressPresenter
    - PhoneNumberPresenter
    - StreetAddressPresenter



## Installation

You can install the package via composer:

```bash
composer require jwcobb/laravel-toolkit
```

You can run some interactive scripts to set some things up and install common packages via Composer

```bash
php artisan laravel-toolkit:install
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="toolkit-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --tag="toolkit-config"
```



## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [J Cobb](https://github.com/jwcobb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
