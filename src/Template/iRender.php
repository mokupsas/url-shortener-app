<?php
declare(strict_types = 1);

namespace UrlShortener\Template;

interface iRender 
{
	public function render($template, $data);
}