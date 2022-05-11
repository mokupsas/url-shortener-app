<?php
declare(strict_types = 1);

namespace UrlShortener\Database;

class MysqliClass
{
	private $db;
	
	//-------------------------------------
	/** Creates MysqliClass object
	@param string $host		- database host/url
	@param string $username	- database username
	@param string $password	- database password
	@param string $dbname	- database name */
	//-------------------------------------		
	public function __construct($host, $username, $password, $dbname)
	{
		$this->db = new \mysqli($host, $username, $password, $dbname);
	}
	
	//-------------------------------------
	/** Get database mysqli object */
	//-------------------------------------		
	public function get()
	{
		return $this->db;
	}
}