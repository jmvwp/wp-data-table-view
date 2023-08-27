<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit76e449280612ddb9d81eaf08c4cb80c5
{
    public static $files = array (
        'd767e4fc2dc52fe66584ab8c6684783e' => __DIR__ . '/..' . '/adbario/php-dot-notation/src/helpers.php',
        '53b3b608b18ef5b655166dcd8c512966' => __DIR__ . '/..' . '/jeffreyvanrossum/wp-settings/src/helpers.php',
        'b33e3d135e5d9e47d845c576147bda89' => __DIR__ . '/..' . '/php-di/php-di/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'M' => 
        array (
            'MVWP\\WPDataTableView\\' => 21,
        ),
        'L' => 
        array (
            'Laravel\\SerializableClosure\\' => 28,
        ),
        'J' => 
        array (
            'Jeffreyvr\\WPSettings\\' => 21,
        ),
        'I' => 
        array (
            'Invoker\\' => 8,
        ),
        'D' => 
        array (
            'DI\\' => 3,
        ),
        'A' => 
        array (
            'Adbar\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'MVWP\\WPDataTableView\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Laravel\\SerializableClosure\\' => 
        array (
            0 => __DIR__ . '/..' . '/laravel/serializable-closure/src',
        ),
        'Jeffreyvr\\WPSettings\\' => 
        array (
            0 => __DIR__ . '/..' . '/jeffreyvanrossum/wp-settings/src',
        ),
        'Invoker\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/invoker/src',
        ),
        'DI\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/php-di/src',
        ),
        'Adbar\\' => 
        array (
            0 => __DIR__ . '/..' . '/adbario/php-dot-notation/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit76e449280612ddb9d81eaf08c4cb80c5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit76e449280612ddb9d81eaf08c4cb80c5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit76e449280612ddb9d81eaf08c4cb80c5::$classMap;

        }, null, ClassLoader::class);
    }
}