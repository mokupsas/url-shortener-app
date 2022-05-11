<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use Http\HttpRequest;
use Http\HttpResponse;

use UrlShortener\Database\MysqliClass;
use UrlShortener\Account\User;
use UrlShortener\Template\MustacheEgine;

class Logout implements iController
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
		$user = new User($this->db);
		
		// If user is logged in redirect
		if($user->isLoggedIn())
		{
			$user->logout();
		}
			
		header("Location: /"); 
		exit();
	}
}