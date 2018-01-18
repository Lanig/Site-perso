<?php

use Core\Service\Router;
use Core\Service\Stylesheet;

$loader = new \Twig_Loader_Filesystem('views/');

$twig = new \Twig_Environment($loader, array(
	'debug' => $config->get('debug'),
    'cache' => '../var/cache/twig',
));
$twig->addExtension(new Twig_Extension_Core());
$twig->addExtension(new Twig_Extension_Escaper('html'));
$twig->addFunction(new Twig_SimpleFunction('asset', function($path) use($config){
	$e = explode(".", $path);
	$ext = end($e);
	switch ($ext) {
		case 'jpg':
		case 'jpeg':
		case 'png':
		case 'gif':
		case 'svg':
			return '/'.$config->get('base_dir').'imgs/'.$path; 
			break;
		case 'pdf':
			return '/'.$config->get('base_dir').'files/'.$path; 
			break;
		
		default:
			return '/'.$config->get('base_dir').$ext.'/'.$path; 
			break;
	}
}));

stream_context_set_default(
    array(
        'http' => array(
            'method' => 'HEAD'
        )
    )
);
$twig->addFunction(new Twig_SimpleFunction('url', function($name, $params = [], $ancre = null) use($config){
	$router = Router::getRouter();
	$url = '/'.$config->get('base_dir').$router->url($name, $params);
	if($ancre) $url .= "#{$ancre}";
	return $url;
}));
$twig->addFunction(new Twig_SimpleFunction('getAction', function(){
	$router = Router::getRouter();
	return $router->getCallable();
}));
$twig->addFunction(new Twig_SimpleFunction('getArgs', function($name = null){
	$router = Router::getRouter();
	return $router->getArgs($name);
}));

$scss = new Stylesheet($config->get('css_file'), $config->get('debug'));

$twig->addFunction(new Twig_SimpleFunction('css', function($arg) use ($scss) { $scss->css($arg); }));

define('BASE_DIR', $config->get('base_dir'));