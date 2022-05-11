<?php
declare(strict_types = 1);

namespace UrlShortener\Template;

class MustacheEgine implements iRender
{
	//-------------------------------------
	/** Chechks if raw password matches hashed password
	@param string $template	- template/html page name from views folder
	@param array $data		- template variables to render
	@param string */
	//-------------------------------------				
	public function render($template, $data)
	{
		/*
		 *	Templating engine
		 */
		$m_options = array('extension' => '.html');
		$mustache = new \Mustache_Engine(
			array(
				'loader' => new \Mustache_Loader_FilesystemLoader(dirname(dirname(__DIR__)).'/views', $m_options)
			)
		);
		return $mustache->render($template, $data);
	}
}