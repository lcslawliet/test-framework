<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("config/init.php");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'foo',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$router = new AltoRouter();
$router->setBasePath(Config::getConfig('basePath'));

$routerConfiguration = Config::readConfigFile('routing.php');

$routerList = array();
foreach ($routerConfiguration as $key => $val) {
    $router->map($val['method'], $val['match'], $val['controller'], $key);
    $routerList[$key] = $val;
}