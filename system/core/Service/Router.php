<?php

namespace Core\Service;

use Noodlehaus\Config;
use Core\Service\Fonction;

/**
* Router
*/
class Router
{

	private static $_instance;

	private $routes;
	private $url;

	private $callable;
	private $arg_keys;
	private $args;

	public function __construct($url)
	{
		$this->url = $url;
	}

	public static function getRouter($url = "")
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new Router($url);
		}
		return self::$_instance;
	}

	public function setRoutes($routes)
	{
		$this->routes = $routes;
	}

	public function addRoute($path, $action)
	{
		$this->routes[$path] = $action;
	}

	public function call()
	{
		foreach ($this->routes as $path => $action) {

			preg_match_all('/:([\w]+)/', $path, $regexnames);
			$this->arg_keys = $regexnames[1];

			$regex = preg_replace('/:([\w]+)/', '([^/]+)', $path);
			if(preg_match("/^\/?".preg_replace("/\//", "\/", $regex)."$/", $this->url, $args)){

				$this->callable = $action;

				array_shift($args);
				$this->args = $args;

				return true;
			}
		}
		return false;
	}

	public function run()
	{
		if(preg_match("/^([^:]+):([^:]+)$/", $this->callable, $tmp)){
			list(, $controller, $action) = $tmp;

			$ctrl = "\\App\\Controller\\".$controller."Controller";

			if(class_exists($ctrl)){
				$class = new $ctrl();
				$action = $action."Action";

				if(method_exists($class, $action)){
					return $class->$action(...$this->args);
				} else throw new \ErrorException("Method inexist", 1);
			} else throw new \ErrorException("Class inexist", 1);
		}  else throw new \ErrorException("Invalid route", 1);
		

		return null;
	}

	public function url($name, $params = [])
	{
		foreach ($this->routes as $path => $action) {

			if($name == $action){

				foreach ($params as $name => $value) {
					$path = preg_replace("/:".preg_quote($name, "/")."/", $value, $path);
				}
				if(preg_match("/:([\w]+)/", $path)) continue;
				$path = trim($path, "/");
				return preg_replace("/[^\w\-\_\/]+/", "", $path);
			}
			
		}
		return "";
	}


	public function getCallable()
	{
		return $this->callable;
	}

	public function getArgs($name = null)
	{
		if($name){
			return array_combine($this->arg_keys, $this->args)[$name];
		} else return $this->args;
	}
}