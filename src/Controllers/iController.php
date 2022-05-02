<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

interface iController 
{
	public function __construct($vars);
	public function show();
}