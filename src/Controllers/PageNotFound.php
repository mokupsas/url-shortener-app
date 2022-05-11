<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use Http\HttpRequest;
use Http\HttpResponse;

use UrlShortener\Database\MysqliClass;
use UrlShortener\Account\User;
use UrlShortener\Template\MustacheEgine;

class PageNotFound implements iController
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
		
		return $templateEngine->render('404', array('title' => 'Page Not Found'));
	}
}