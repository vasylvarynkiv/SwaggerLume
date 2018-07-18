<?php

namespace Tests;

use SwaggerLumen\Generator;

class SecurityDefinitionsTest extends LumenTestCase
{
    /** @test */
    public function canGenerateApiJsonFileWithSecurityDefinition()
    {
        if ($this->isOpenApi()) {
            $this->markTestSkipped('only for openApi 2.0');
        }

        $this->setPaths();

        $cfg = config('swagger-lumen');
        $security = [
            'new_api_key_security' => [
                'type' => 'apiKey',
                'name' => 'api_key_name',
                'in' => 'query',
            ],
        ];
        $cfg['security'] = $security;
        config(['swagger-lumen' => $cfg]);

        tap(new Generator)->generateDocs();

        $this->assertTrue(file_exists($this->jsonDocsFile()));

        $response = $this->get(config('swagger-lumen.routes.docs'));

        $this->assertResponseOk();

        $this->assertContains('new_api_key_security', $response->response->getContent());
        $this->seeJson($security);
    }

    /** @test */
    public function canGenerateApiJsonFileWithSecurityDefinitionOpenApi3()
    {
        if (! $this->isOpenApi()) {
            $this->markTestSkipped('only for openApi 3.0');
        }

        $this->setPaths();

        $cfg = config('swagger-lumen');
        $security = [
            'new_api_key_security' => [
                'type' => 'apiKey',
                'name' => 'api_key_name',
                'in' => 'query',
            ],
        ];
        $cfg['security'] = $security;
        $cfg['swagger_version'] = '3.0';
        config(['swagger-lumen' => $cfg]);

        tap(new Generator)->generateDocs();

        $this->assertTrue(file_exists($this->jsonDocsFile()));

        $response = $this->get(config('swagger-lumen.routes.docs'));

        $this->assertResponseOk();

        $content = $response->response->getContent();

        $this->assertContains('new_api_key_security', $content);
        $this->assertContains('oauth2', $content);
        $this->seeJson($security);
    }
}
