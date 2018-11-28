<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit984b0364e013af94500cff675cd593d6
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JPush\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JPush\\' => 
        array (
            0 => __DIR__ . '/..' . '/jpush/jpush/src/JPush',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit984b0364e013af94500cff675cd593d6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit984b0364e013af94500cff675cd593d6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
