<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb0175f2c9191a00fb4ac7780184982a0
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb0175f2c9191a00fb4ac7780184982a0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb0175f2c9191a00fb4ac7780184982a0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb0175f2c9191a00fb4ac7780184982a0::$classMap;

        }, null, ClassLoader::class);
    }
}
