<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb9d75565d562a1457a504b1ee5d1e708
{
    public static $prefixLengthsPsr4 = array (
        'v' => 
        array (
            'vCode\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'vCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/vCode/php-classes/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
        'R' => 
        array (
            'Rain' => 
            array (
                0 => __DIR__ . '/..' . '/rain/raintpl/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb9d75565d562a1457a504b1ee5d1e708::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb9d75565d562a1457a504b1ee5d1e708::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitb9d75565d562a1457a504b1ee5d1e708::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}