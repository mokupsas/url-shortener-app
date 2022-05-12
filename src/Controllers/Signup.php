<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use Http\HttpRequest;
use Http\HttpResponse;

use UrlShortener\Account\User;
use UrlShortener\Account\StatusCodes;
use UrlShortener\Account\UserHandler;
use UrlShortener\Security\Password;
use UrlShortener\Auth\Handler;
use UrlShortener\Database\MysqliClass;
use UrlShortener\Template\MustacheEgine;
use UrlShortener\UI\Header;
use UrlShortener\UI\Message;

class Signup implements iController
{
	// Objects
	private $request;
	private $db;

	//-------------------------------------
	/** Creates Login object
	@param HttpRequest $request	- website request handler class
	@param MysqliClass $db		- Mysqli object class */
	//-------------------------------------	
	public function __construct(HttpRequest $request, MysqliClass $db)
	{
		$this->request = $request;
		$this->db = $db;
	}

	//-------------------------------------
	/** Manages view to response
	@param array $vars - route pattern variables (i.e. '/user/{name}')
	@param string */
	//-------------------------------------		
	public function show($vars)
	{
		// Objects
		//$authHandler = new Handler($this->db);
		$templateEngine = new MustacheEgine();
		$user = new User($this->db);
		$userHandler = new UserHandler($this->request, $this->db);
		$header = new Header($user);
		
		$email = $this->request->getParameter('email');
		$password = $this->request->getParameter('pass');
		
		$alert = null;
		if($this->request->getParameter('submit'))
		{
			// Registration status code
			$status = $userHandler->register($email, $password); 
			
			// Alert message with registration information for user
			$alert = Message::alert($userHandler->statusToMessage($status));
		}
		
		return $templateEngine->render('Signup', array('title' => 'Signup', 'header' => $header->get(), 'alert' => $alert));
	}
}