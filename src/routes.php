<?php

$route->get(config('swagger-lumen.routes.docs') . '/{version}', [
    'as' => 'swagger-lumen.docs',
    'middleware' => config('swagger-lumen.routes.middleware.docs', []),
    'uses' => 'Http\Controllers\SwaggerLumenController@docs',
]);

$route->get(config('swagger-lumen.routes.api') . '/{version}', [
    'as' => 'swagger-lumen.api',
    'middleware' => config('swagger-lumen.routes.middleware.api', []),
    'uses' => 'Http\Controllers\SwaggerLumenController@api',
]);

$route->get(config('swagger-lumen.routes.assets') . '/{asset}', [
    'as' => 'swagger-lumen.asset',
    'middleware' => config('swagger-lumen.routes.middleware.asset', []),
    'uses' => 'Http\Controllers\SwaggerLumenAssetController@index',
]);

$route->get(config('swagger-lumen.routes.oauth2_callback'), [
    'as' => 'swagger-lumen.oauth2_callback',
    'middleware' => config('swagger-lumen.routes.middleware.oauth2_callback', []),
    'uses' => 'Http\Controllers\SwaggerLumenController@oauth2Callback',
]);
