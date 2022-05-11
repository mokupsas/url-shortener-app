<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use Http\HttpRequest;
use Http\HttpResponse;

use UrlShortener\Database\MysqliClass;
use UrlShortener\Account\User;
use UrlShortener\Template\MustacheEgine;

class Login implements iController
{
	// Objects
	private $request;
	private $db;

	public function __construct(HttpRequest $request, MysqliClass $db)
	{
		$this->request = $request;
		$this->db = $db;
	}
	
	public function show($vars)
	{
		// Objects
		$templateEngine = new MustacheEgine();
		$user = new User($this->db);
		
		// If user is logged in redirect
		if($user->isLoggedIn())
		{
			header("Location: /"); 
			exit();
		}
			
		$email = $this->request->getParameter('email');
		$password = $this->request->getParameter('pass');
		
		$alert = null;	
		if($this->request->getParameter('submit'))
		{
			if(!$user->login($email, $password))
			{
				$alert = $user->getMsg()->pop()['message'];
			}
		}
		
		return $templateEngine->render('Login', array('title' => 'Login', 'alert' => $alert));
	}
}