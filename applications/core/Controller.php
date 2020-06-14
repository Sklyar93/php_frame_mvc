<?php
	namespace applications\core;

	use applications\core\Views;
	use applications\libs\Bd;


	abstract class Controller
	{
		public $route;
		public $views;
		public $bd;

		public function __construct($route)
		{
			$this->route = $route;

			$this->views = new Views($route);

			$this->bd = new Bd;
		}
	}