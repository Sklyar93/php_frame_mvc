<?php

namespace applications\core;

class Router
{

	protected $routes = [];

	protected $params = [];

	public function __construct()
	{
		$routesArray = require 'applications/config/routes.php';
		
		foreach($routesArray as $route => $param)
		{
			$this->add($route, $param);
		}
	}

	public function add($route, $param)
	{
		$route = '#^'.$route.'$#';

		$this->routes[$route] = $param;
		$this->routes;
	}

	public function match()
	{
		$url = trim($_SERVER['REQUEST_URI'], '/');
		
		foreach($this->routes as $route => $param)
		{

			if(preg_match($route, $url))
			{
				$this->params = $param;

				return true;
			}
			
		}

		Views::errorCode('404');
		return false;
	}

	public function run()
	{
		if($this->match())
		{
		 $path = 'applications\controllers\\' . ucfirst($this->params['controller']).'Controller';
			
			if(class_exists($path))
			{
				$action = $this->params['action'].'Action';

				if(method_exists($path, $action)){// проверяет существует метод в классе
					$controller = new $path($this->params);
					$controller->$action();
				}
				
			}
		}

	}
}