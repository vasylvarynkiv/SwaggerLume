<?php

namespace Tests;

use SwaggerLumen\Generator;

class GeneratorTest extends LumenTestCase
{
    /** @test */
    public function canGenerateApiJsonFile()
    {
        $this->setPaths();

        Generator::generateDocs();

        $this->assertTrue(file_exists($this->jsonDocsFile()));

        $response = $this->get(config('swagger-lumen.routes.docs'));

        $this->assertResponseOk();

        $this->assertContains('SwaggerLumen', $response->response->getContent());
        $this->assertContains('my-default-host.com', $response->response->getContent());
    }

    /** @test */
    public function canGenerateApiJsonFileWithChangedBasePath()
    {
        if ($this->isOpenApi() == true) {
            $this->markTestSkipped('only for openApi 2.0');
        }

        $this->setPaths();

        $cfg = config('swagger-lumen');
        $cfg['paths']['base'] = '/new_path/is/here';
        config(['swagger-lumen' => $cfg]);

        Generator::generateDocs();

        $this->assertTrue(file_exists($this->jsonDocsFile()));

        $response = $this->get(config('swagger-lumen.routes.docs'));

        $this->assertResponseOk();

        $this->assertContains('SwaggerLumen', $response->response->getContent());
        $this->assertContains('new_path', $response->response->getContent());
    }

    /** @test */
    public function canSetProxy()
    {
        $this->setPaths();

        $cfg = config('swagger-lumen');
        $cfg['proxy'] = 'http://proxy.dev';
        config(['swagger-lumen' => $cfg]);

        $this->get(config('swagger-lumen.routes.api'));

        $this->assertResponseOk();

        $this->assertTrue(file_exists($this->jsonDocsFile()));
    }

    /** @test */
    public function canSetValidatorUrl()
    {
        $this->setPaths();

        $cfg = config('swagger-lumen');
        $cfg['validator_url'] = 'http://validator-url.dev';
        config(['swagger-lumen' => $cfg]);

        $response = $this->get(config('swagger-lumen.routes.api'));

        $this->assertResponseOk();

        $this->assertContains('validator-url.dev', $response->response->getContent());

        $this->assertTrue(file_exists($this->jsonDocsFile()));
    }
}
