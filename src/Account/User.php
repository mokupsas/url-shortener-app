<?php
declare(strict_types = 1);

namespace UrlShortener\Account;

use UrlShortener\Security\Password;
use UrlShortener\Database\MysqliClass;

class User
{
	private $db;
	
	// User status
	private $loggedIn = false;
	
	// User data
	private $id; 			// user id
	private $email; 		// user email
	private $password;		// hashed password
	private $reg_ip;		// ip address on registration
	private $created;		// datetime when account has been created
	
	// Other
	private $msg = array();
	private $errors = array();
	
	public function __construct(MysqliClass $db)
	{
		$this->db = $db;
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
	
	public function isLoggedIn()
	{
		return $this->loggedIn;
	}
	
	public function login($email, $password)
	{
		if(empty($email) || empty($password))
		{
			return false;
		}
		
 		// prepare and bind
		if($stmt = $this->db->get()->prepare("SELECT * FROM users WHERE email=? LIMIT 1"))
		{
			$stmt->bind_param("s", $email);

			if($stmt->execute())
			{
				$result = $stmt->get_result(); // get the mysqli result

				if($result->num_rows > 0)
				{
					$data = $result->fetch_assoc();
					
					// Adding data to session
					$_SESSION['user']['id'] = $this->id = $data['id'];
					$_SESSION['user']['email'] = $this->email = $email;
					$_SESSION['user']['loggedIn'] = $this->loggedIn = true;
					$this->password = $data['password'];
					$this->reg_ip = $data['reg_ip'];
					$this->created = $data['created'];
					
					if(Password::verify($password, $data['password']))
					{
						return true;
					}
					else
					{
						// handle
					}
				}
			}
			else
			{
				// handle errors
			}
		}
		else
		{
			// handle errors
		}
		$stmt->close();
	}
	
	public function logout()
	{
		if(!empty($_SESSION['user']['id']))
		{
			unset($_SESSION['user']);
		}
	}
}