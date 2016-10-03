<?php

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Security;

/**
 * Shared configuration security hash
 */
$di->set(
    "security",
    function () {
        $security = new Security();

        // Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);

        return $security;
    },
    true
);

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return new \Phalcon\Config\Adapter\Ini(APP_PATH . "/config/config.ini");
});

/**
 * Sets the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $connection = new $class([
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
    ]);

    return $connection;
});

/**
 * JWT Configuration
 */
$di->setShared('jwt', function(){
  return (object) array(
    'secret' => md5('m1S3Cr3T3'),
    'type' => array('HS256')
  );
});

/**
 * Route Ignore List
 */
$di->setShared('routerignore', function(){
  return array(
    '/api/auth' => '',
    '/version' => '',
  );
});

/**
 * Memcached Connection
 * @var FrontData
 */
$di->setShared(
    "storage",
    function () {

        // default save time 5 minuts
        $frontCache = new Phalcon\Cache\Frontend\Data(
            [
                "lifetime" => (5 * 60),
            ]
        );
        
        // connect
        return new Phalcon\Cache\Backend\Libmemcached(
            $frontCache,
             [
                "servers" => [
                    [
                        "host"   => "127.0.0.1",
                        "port"   => "11211",
                        "weight" => "1",
                    ]
                ]
            ]
        );
    }
);