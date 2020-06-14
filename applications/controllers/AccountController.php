<?php

namespace applications\controllers;

use applications\core\Controller;

class AccountController extends Controller
{
	public function loginAction()
	{
		$this->views->render('Вход');		
	}

	public function registerAction()
	{
		$this->views->redirect('/');
		
	}
}