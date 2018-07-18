<?php

namespace SwaggerLumen;

use Illuminate\Support\Facades\File;

class Generator
{
    public static function generateDocs()
    {
        $version = config('swagger-lumen.version');
        foreach ($version as $key => $val) {
            $appDir = config('swagger-lumen.paths.annotations') . '/' . $val;
            $docDir = config('swagger-lumen.paths.docs') . '/' . $val;
            if (!File::exists($docDir) || is_writable($docDir)) {
                // delete all existing documentation
                if (File::exists($docDir)) {
                    File::deleteDirectory($docDir);
                }

                self::defineConstants(config('swagger-lumen.constants') ?: []);

                File::makeDirectory($docDir);
                $excludeDirs = config('swagger-lumen.paths.excludes');
                $swagger = \Swagger\scan($appDir, ['exclude' => $excludeDirs]);

                if (config('swagger-lumen.paths.base') !== null) {
                    $swagger->basePath = config('swagger-lumen.paths.base');
                }

                $filename = $docDir . '/' . config('swagger-lumen.paths.docs_json');
                $swagger->saveAs($filename);

                $security = new SecurityDefinitions();
                $security->generate($filename);
            }
        }
    }

    protected static function defineConstants(array $constants)
    {
        if (! empty($constants)) {
            foreach ($constants as $key => $value) {
                defined($key) || define($key, $value);
            }
        }
    }
}
