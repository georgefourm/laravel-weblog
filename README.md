# laravel-weblog
A Laravel package to view and manage your application's logs online
This package is meant to be used as a drop-in solution in order to manage and download your application's log files,

## Requirements
* PHP >= 5.6
* Laravel >= 5.4 (Although >=5.2 should work too, but isn't tested)

## Installation
* Run `composer install georgesdoe/laravel-weblog`
* Publish the main assets by running `php artisan vendor:publish --tag=main`,
and optionally if you want to edit the views `php artisan vendor:publish --tag=views`
* Add a new disk in your `filesystems.php` configuration file called `logs`pointing to where your logs are stored, for example
```php 
  'logs' => [
      'driver' => 'local',
      'root' => storage_path('logs'),
  ],
```
* Finally, register the package's Service Provider in your `app.php` configuration file by adding the following to the providers array
```php
Georgesdoe\Weblog\WeblogServiceProvider::class,
```
## Configuration
You are can modify the views as you wish after publishing them, or even use the routes as an API for your own front-end.

In the `weblog.php` configuration file, you can also configure the route prefix (which is "logs" by default) and the middleware to use for these routes.

**You should change the middleware to one that requires authentication so your logs aren't exposed**
