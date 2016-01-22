[![Total Downloads](https://poser.pugx.org/DarkaOnLine/swagger-lume/downloads.svg)](https://packagist.org/packages/DarkaOnLine/swagger-lume)

SwaggerLume
==========

Swagger 2.0 for Lumen 5

This package is a wrapper of [Swagger-php](https://github.com/zircote/swagger-php) and [swagger-ui](https://github.com/swagger-api/swagger-ui) adapted to work with Lumen 5.

Installation
============

```php
    composer require "darkaonline/swagger-lume ~1.0"
```


- Open your `bootstrap/app.php` file and: 

uncomment this line (around line 26) in `Create The Application` section:
```php
     $app->withFacades();
```

add this line before `Register Container Bindings` section:
```php
     $app->configure('swagger-lume');
```

add this line in `Register Service Providers` section:
```php
    $app->register(\SwaggerLume\ServiceProvider::class);
```


- Run `php artisan swagger-lume:publish-config` to publish configs (`config/swagger-lume.php`)
- Make configuration changes if needed 
- Run `swagger-lume:publish` to publish everything

Configuration
============
- Run `swagger-lume:publish-config` to publish configs (`config/swagger-lume.php`)
- Run `swagger-lume:publish-assets` to publish swagger-ui to your public folder (`public/vendor/swagger-lume`)
- Run `swagger-lume:publish-views` to publish views (`resources/views/vendor/swagger-lume`)
- Run `swagger-lume:publish` to publish everything
- Run `swagger-lume:generate` to generate docs


Swagger-php
======================
The actual Swagger spec is beyond the scope of this package. All SwaggerLume does is package up swagger-php and swagger-ui in a Laravel-friendly fashion, and tries to make it easy to serve. For info on how to use swagger-php [look here](http://zircote.com/swagger-php/). For good examples of swagger-php in action [look here](https://github.com/zircote/swagger-php/tree/master/Examples/petstore.swagger.io).
