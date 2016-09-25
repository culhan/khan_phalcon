<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

$loader->registerDirs(
    [
    	$config->application->helperDir,
        $config->application->modelsDir,        
        $config->application->controllerDir
    ]
)->register();

// register class
$classMap = require $config->application->vendorDir . 'composer/autoload_classmap.php';
$loader->registerClasses($classMap);

$loader->register();