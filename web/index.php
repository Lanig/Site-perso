<?php
require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../system/autoload.php';

use Core\Controller\ErrorController;

if($config->get('debug')){
	$router->call();
	$response = $router->run();
	echo $response;
} else {
	try {
		$router->call();
		$response = $router->run();
		echo $response;
	} catch(\ErrorException $e) {
		$response = (new ErrorController())->NotFoundAction();
		echo $response;
	}
}
