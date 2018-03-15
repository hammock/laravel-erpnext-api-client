# Laravel 5 ERPNext API Client

A simple Laravel 5 client for the [ERPNext](https://erpnext.com/) system.

## Installation

### Step 1: Install Through Composer
``` bash
composer require hammock/laravel-erpnext-api-client
```

### Step 2: Add the Service Provider
Add the service provider in `app/config/app.php`
```php
'provider' => [
    ...
    Hammock\LaravelERPNext\ERPNextServiceProvider::class,
    ...
];
```

### Step 3: Add the Facade
Add the alias in `app/config/app.php`
```php
'aliases' => [
    ...
    'ERPNext' => Hammock\LaravelERPNext\Facades\ERPNext::class,
    ...
];
```

### Step 4: Publish the configuration file
```php
php artisan vendor:publish --provider="Hammock\LaravelERPNext\ERPNextServiceProvider"
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.