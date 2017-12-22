<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite51728adcd0306c1741d399e0eb59dca
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/website/php-classes/src',
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
            $loader->prefixLengthsPsr4 = ComposerStaticInite51728adcd0306c1741d399e0eb59dca::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite51728adcd0306c1741d399e0eb59dca::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInite51728adcd0306c1741d399e0eb59dca::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite51728adcd0306c1741d399e0eb59dca::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}