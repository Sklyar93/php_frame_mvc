<?php 

namespace applications\controllers;

use applications\core\Controller;

class MainController extends Controller
{
	public function indexAction()
	{
		$users = [
			'name' => 'Valera',
			'age' => 26,
			'position' => 'programmer'
		];
		$this->views->render('Главная Страница');
		$this->bd->createTableBd('user', $users);
	}
}