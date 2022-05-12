<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use Http\HttpRequest;

use UrlShortener\Template\MustacheEgine;
use UrlShortener\Database\MysqliClass;
use UrlShortener\Account\User;
use UrlShortener\UI\Header;

class Homepage implements iController
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
		$templateEngine = new MustacheEgine();
		$user = new User($this->db);
		$header = new Header($user);
		
		return $templateEngine->render('Homepage', array('title' => 'Homepage', 'header' => $header->get()));
	}
}