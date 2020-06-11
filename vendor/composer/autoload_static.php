<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit78604bdae1bc9233e6f9cb51bafaf412
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Nilambar\\NepaliDate\\' => 20,
        ),
        'D' => 
        array (
            'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 55,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Nilambar\\NepaliDate\\' => 
        array (
            0 => __DIR__ . '/..' . '/ernilambar/nepali-date/src',
        ),
        'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit78604bdae1bc9233e6f9cb51bafaf412::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit78604bdae1bc9233e6f9cb51bafaf412::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
