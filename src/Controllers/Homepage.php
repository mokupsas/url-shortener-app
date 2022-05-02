<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use UrlShortener\Template\MustacheEgine;

class Homepage implements iController
{
	public function __construct($vars)
	{
		
	}
	
	public function show()
	{
		$templateEngine = new MustacheEgine();
		return $templateEngine->render('Homepage', array());
	}
}