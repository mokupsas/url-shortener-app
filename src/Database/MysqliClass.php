<?php
declare(strict_types = 1);

namespace UrlShortener\Database;

class MysqliClass
{
	private $db;
	
	public function __construct($host, $username, $password, $dbname)
	{
		$this->db = new \mysqli($host, $username, $password, $dbname);
	}
	
	public function get()
	{
		return $this->db;
	}
}