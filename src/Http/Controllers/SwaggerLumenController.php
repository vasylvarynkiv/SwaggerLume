<?php

namespace SwaggerLumen\Http\Controllers;

use SwaggerLume\Generator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class SwaggerLumenController extends BaseController
{
    /**
     * Dump api-docs.json content endpoint.
     *
     * @param null $jsonFile
     *
     * @return \Illuminate\Http\Response
     */
    public function docs($version, $jsonFile = null)
    {
        $filePath = config('swagger-lumen.paths.docs') . '/' . strtoupper($version) . '/' . (!is_null($jsonFile) ? $jsonFile : config('swagger-lumen.paths.docs_json'));

        if (!File::exists($filePath)) {
            abort(404, 'Cannot find ' . $filePath);
        }

        $content = File::get($filePath);

        return new Response($content, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Display Swagger API page.
     *
     * @return \Illuminate\Http\Response
     */
    public function api($version)
    {
        if (config('swagger-lumen.generate_always')) {
            Generator::generateDocs();
        }

        //need the / at the end to avoid CORS errors on Homestead systems.
        $response = new Response(view('swagger-lumen::index', [
            'secure' => Request::secure(),
            'urlToDocs' => route('swagger-lumen.docs', ['version' => $version]),
            'operationsSorter' => config('swagger-lumen.operations_sort'),
            'configUrl' => config('swagger-lumen.additional_config_url'),
            'validatorUrl' => config('swagger-lumen.validator_url'),
        ]), 200, ['Content-Type' => 'text/html']);

        return $response;
    }

    /**
     * Display Oauth2 callback pages.
     *
     * @return string
     */
    public function oauth2Callback()
    {
        return File::get(swagger_ui_dist_path('oauth2-redirect.html'));
    }
}
