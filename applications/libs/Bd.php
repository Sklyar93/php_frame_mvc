<?php
	namespace applications\libs;

	require 'applications/libs/rb.php';
	use R;
	
	 class Bd
	{
		protected $db;

		public function __construct()
		{
			require 'applications/config/bd.php';
			extract($db);
			R::setup('mysql:host=localhost;dbname=test','root',''); //испльзовать перемен
			R::freeze(false);
			if(!R::testConnection()){
				exit('нет подключения к БД');
			}
		}
		
		public function createTableBd($title, $contents = [])
		{
			$create = R::dispense($title);
			if(!empty($contents))
			{
				foreach($contents as $content =>$value)
				{
					$create->$content = $value;
				}
			}
			R::store($create);
		}
	}