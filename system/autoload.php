<?php

use Noodlehaus\Config;
use App\Controller\IndexController;
use Core\Service\Router;
use Core\Service\db;

$config = new Config(__DIR__ . '/config/config.json');
$routes = new Config(__DIR__ . '/config/'. $config->get('routing_file'));

define('REQUEST_URI', ltrim(preg_replace("/".str_replace('/', '\/', $config->get('base_dir'))."/", "", $_SERVER['REQUEST_URI']), "/"));

$router = Router::getRouter(REQUEST_URI);
$router->setRoutes($routes);

$databaseLogInfos = $config->get('database');
$db = new db($databaseLogInfos['host'],$databaseLogInfos['database'],$databaseLogInfos['user'],$databaseLogInfos['password'], $config->get('debug'));

require_once __DIR__ . '/functions.php';

set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});