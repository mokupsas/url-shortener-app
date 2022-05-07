<?php
declare(strict_types = 1);

namespace UrlShortener\Account;

class User
{
	private $email; 		// user email
	private $password;		// hashed password
	private $reg_ip;		// ip address on registration
	private $created;		// datetime when account has been created
	
	public function __construct($email, $password, $reg_ip, $created)
	{
		$this->email = $email;
		$this->password = $password;
		$this->reg_ip = $reg_ip;
		$this->created = $created;
	}
	
	public function getEmail()
	{
		return $this->email;
	}

	public function getPassword()
	{
		return $this->password;
	}
	
	public function getRegIp()
	{
		return $this->reg_ip;
	}
	
	public function getRegDatetime()
	{
		return $this->created;
	}
}