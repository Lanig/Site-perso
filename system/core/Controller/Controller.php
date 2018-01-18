<?php

namespace Core\Controller;

/**
* Controller
*/
abstract class Controller
{

	public function render($name, $args = [])
	{
		global $config;
		$args['config'] = $config->all();
		
		global $twig;
		try {
			return $twig->render($name, $args);
		} catch(\Exception $e){
			throw new \ErrorException("Error Processing Request", 1);
		}
		return null;
	}
}