<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfbd92897e26cf172b6cf48890231cacd
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Hb\\ChangePathfile\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Hb\\ChangePathfile\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfbd92897e26cf172b6cf48890231cacd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfbd92897e26cf172b6cf48890231cacd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfbd92897e26cf172b6cf48890231cacd::$classMap;

        }, null, ClassLoader::class);
    }
}
