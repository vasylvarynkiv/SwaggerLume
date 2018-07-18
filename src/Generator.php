<?php

namespace SwaggerLume;

use Illuminate\Support\Facades\File;

class Generator
{
    public static function generateDocs()
    {
        $version = config('swagger-lume.version');
        foreach ($version as $key => $val) {
            $appDir = config('swagger-lume.paths.annotations') . '/' . $val;
            $docDir = config('swagger-lume.paths.docs') . '/' . $val;
            if (!File::exists($docDir) || is_writable($docDir)) {
                // delete all existing documentation
                if (File::exists($docDir)) {
                    File::deleteDirectory($docDir);
                }

                self::defineConstants(config('swagger-lume.constants') ?: []);

                File::makeDirectory($docDir);
                $excludeDirs = config('swagger-lume.paths.excludes');
                $swagger = \Swagger\scan($appDir, ['exclude' => $excludeDirs]);

                if (config('swagger-lume.paths.base') !== null) {
                    $swagger->basePath = config('swagger-lume.paths.base');
                }

                $filename = $docDir . '/' . config('swagger-lume.paths.docs_json');
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
