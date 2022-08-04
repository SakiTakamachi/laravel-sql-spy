# Laravel Sql Spy

This library is under development.

## Requirements

- PHP >= 8.x
- Laravel >= 8.x

## Installation

### Step 1: Install package

Use Composer command to add the package.

```
composer require sakiot/laravel-sql-spy
```

### Step 2: Register Service Provider

Register the Service Provider in your config file.

```php
// config/app.php

'providers' => [
    // Application Service Providers...
    // ...

    // Other Service Providers...
    LaravelSqlSpy\LaravelSqlSpyServiceProvider::class, // add
],
```

## Usage

Turn on debug mode in your environment file.

```
// .env

APP_DEBUG=true
```

Then you will see the Sql Spy button on the top right of the page.
By clicking this button, you can download the csv file.

Currently, I'm using sessions to hold data.
So if you open multiple tabs in your browser, the data of the last opened page will be retrieved.
The "page where the button was clicked" is irrelevant. You will always get the "last opened page" information!