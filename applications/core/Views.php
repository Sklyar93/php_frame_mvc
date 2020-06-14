<?php
	namespace applications\core;

	class Views 
	{
		public $path;

		public $route;

		public $layout = 'default';

		public function __construct($route)
		{
			$this->route = $route;
			$this->path = $route['controller'] . '/' . $route['action'];
		}

		public function render($title, $vars = [])
		{
			extract($vars);

			$path = 'applications/views/'.$this->path.'.php';

			if(file_exists($path))
			{
				ob_start();
				require $path;
				$contents = ob_get_clean();
				require 'applications/views/layouts/defaults.php';
			}
			
		}

		public function redirect($url)
		{
			header('location: ' . $url);
			exit;
		}

		public static function errorCode($errorCode)
		{
			http_response_code($errorCode);
			$path = 'applications/views/errors/serverErrorCode.php';
			if(file_exists($path))
			{
				require $path;
			}
		}	
	}