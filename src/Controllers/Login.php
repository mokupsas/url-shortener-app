<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use Http\HttpRequest;
use Http\HttpResponse;

use UrlShortener\Database\MysqliClass;
use UrlShortener\Account\User;
use UrlShortener\Template\MustacheEgine;
use UrlShortener\UI\Header;
use UrlShortener\UI\Message;

class Login implements iController
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
		$templateEngine = new MustacheEgine();
		$user = new User($this->db);
		$header = new Header($user);
		
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
			if($user->login($email, $password))
			{
				header("Location: /"); 
				exit();
			}
			else
			{
				$msg = $user->getMsg()->pop();
				$alert = Message::alert($msg['message'], $msg['type']);	
			}
		}

		return $templateEngine->render('Login', array('title' => 'Login', 'header' => $header->get(), 'alert' => $alert));
	}
}