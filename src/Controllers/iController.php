<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

interface iController 
{
	public function show($vars);
}