# ultra-helper

A personal package for undisclosed usage.

## Installation

You can install the package via composer:

```bash
composer require amyisme13/ultra-helper
```

Run the migration

```bash
php artisan migrate
```

Configure these environment variable

- ULTRA_URL
- ULTRA_SIGNATURE_KEY
- ULTRA_ENCRYPTION_KEY
- ULTRA_ENCRYPTION_IV

## Features

### Users Sync

Sync ultra_users table with the current Ultra users

```bash
php artisan ultra-helper:sync-users
```

### Login

Login using username & password or using token. These methods will return user data object.

```php
use Amyisme13\UltraHelper\UltraHelperFacade as UltraHelper;

$userData = UltraHelper::login('username', 'password');

$userData = UltraHelper::loginWithToken('encrypted-token');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email amy.azmim@gmail.com instead of using the issue tracker.

## Credits

-   [Azmi Makarima](https://github.com/amyisme13)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
