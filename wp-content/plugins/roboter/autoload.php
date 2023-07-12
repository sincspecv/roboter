<?php

namespace TFR;

spl_autoload_register(function ($class) {
    $prefix = __NAMESPACE__; // change this to your root namespace
    $dirname = dirname(__FILE__);
    $composer_autoload = "{$dirname}/vendor/autoload.php";
    $base_dir = "{$dirname}/classes"; // make sure this is the directory with your classes
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Load composer
    if (file_exists($composer_autoload)) {
        require_once($composer_autoload);
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }

});
