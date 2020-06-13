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
	}

	public function match()
	{
		$url = trim($_SERVER['REQUEST_URI'], '/');
		foreach($this->routes as $route => $param)
		{
			if(preg_match($route, $url))
			{
				echo 'есть роут';
				$this->params = $param;
				return true;
			}
			else
			{
				echo '404';
				return false;
			}
		}
	}

	public function run()
	{
		if($this->match())
		{
			$controller = 'applications\controllers\\' . ucfirst($this->params['controller']).'controller.php';
			if(class_exists($controller))
			{
				echo 'ok controller';
			}else
			{
				echo 'нет контролера';
			}
		};
	}
}