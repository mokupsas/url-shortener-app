<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use Http\HttpRequest;
use Http\HttpResponse;

use UrlShortener\Account\StatusCodes;
use UrlShortener\Account\UserHandler;
use UrlShortener\Security\Password;
use UrlShortener\Auth\Handler;
use UrlShortener\Database\MysqliClass;
use UrlShortener\Template\MustacheEgine;

class Signup implements iController
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
		//$authHandler = new Handler($this->db);
		$templateEngine = new MustacheEgine();
		$userHandler = new UserHandler($this->request, $this->db);
		
		$email = $this->request->getParameter('email');
		$password = $this->request->getParameter('pass');
		
		$alert = null;
		if($this->request->getParameter('submit'))
		{
			// Registration status code
			$status = $userHandler->register($email, $password);
			
			// Alert message with registration information for user
			$alert = $userHandler->statusToMessage($status);
		}
		
		//return $templateEngine->render('Homepage', array());
		return '
			'. $alert .'
			<form method="POST">
				<input type="text" name="email">
				<input type="password" name="pass">
				<input type="submit" name="submit">
			</form>
		';
	}
}