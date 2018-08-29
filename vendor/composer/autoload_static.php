<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5f243434b790ef813cec84fb6e0a135f
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\EventDispatcher\\' => 34,
        ),
        'O' => 
        array (
            'OpenTok\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'OpenTok\\' => 
        array (
            0 => __DIR__ . '/..' . '/opentok/opentok/src/OpenTok',
        ),
    );

    public static $prefixesPsr0 = array (
        'J' => 
        array (
            'JohnStevenson\\JsonWorks' => 
            array (
                0 => __DIR__ . '/..' . '/aoberoi/json-works/src',
            ),
        ),
        'G' => 
        array (
            'Guzzle\\Tests' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/guzzle/tests',
            ),
            'Guzzle' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/guzzle/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5f243434b790ef813cec84fb6e0a135f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5f243434b790ef813cec84fb6e0a135f::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit5f243434b790ef813cec84fb6e0a135f::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
