<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use UrlShortener\Template\MustacheEgine;

class Homepage implements iController
{
	public function __construct()
	{
		
	}
	
	//-------------------------------------
	/** Manages view to response
	@param array $vars - route pattern variables (i.e. '/user/{name}')
	@param string */
	//-------------------------------------	
	public function show($vars)
	{
		$templateEngine = new MustacheEgine();
		return $templateEngine->render('Homepage', array());
	}
}