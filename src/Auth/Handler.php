<?php
declare(strict_types = 1);

namespace UrlShortener\Auth;

use UrlShortener\Database\MysqliClass;

/** Handles auth processes */
class Handler
{
	private $db;
	
	public function __construct(MysqliClass $db)
	{
		$this->db = $db;
	}
	
	public function register()
	{
		return true;
	}
}