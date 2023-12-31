<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2105b67fdbc0e244d28e44341adf328b
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Fh\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Fh\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit2105b67fdbc0e244d28e44341adf328b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2105b67fdbc0e244d28e44341adf328b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2105b67fdbc0e244d28e44341adf328b::$classMap;

        }, null, ClassLoader::class);
    }
}
