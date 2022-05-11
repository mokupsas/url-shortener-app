<?php
declare(strict_types = 1);

namespace UrlShortener\Account;

use UrlShortener\Notification\UserMsg;
use UrlShortener\Notification\ErrorMsg;
use UrlShortener\Security\Password;
use UrlShortener\Database\MysqliClass;

class User
{
	private $db;
	
	// User status
	private $loggedIn = false;
	
	// User data from database
	private $id; 				// user id
	private $email; 			// user email
	private $password;			// hashed password
	private $reg_ip;			// ip address on registration
	private $created;			// datetime when account has been created
	
	// User data not associated with database
	private $loginDatetime;
	
	// Messages
	private $msg;				// UrlShortener\Notification\UserMsg object to store user friendly messages
	private $errors;			// UrlShortener\Notification\ErrorMsg object to store user error messages
	
	public function __construct(MysqliClass $db)
	{
		$this->db = $db;
		$this->msg = new UserMsg();
		$this->errors = new ErrorMsg();
		
		// Checking if user already is logged in, if so fill object with data from  database
		if($this->isLoggedInSession())
		{
			// Database data array
			$data = $this->getUserDbData('a@a.com');
			
			// Adding data to this object
			$this->loggedIn 		= true;
			$this->id 				= $data['id'];
			$this->email			= $data['email'];
			$this->password 		= $data['password'];
			$this->reg_ip 			= $data['reg_ip'];
			$this->created 			= $data['created'];
			$this->loginDatetime  	= $_SESSION['user']['loginDatetime'];			
		}
	}
	
	//-------------------------------------
	/** Get user email
	@return string */
	//-------------------------------------	
	public function getEmail()
	{
		return $this->email;
	}

	//-------------------------------------
	/** Get user hashed password
	@return string */
	//-------------------------------------	
	public function getPassword()
	{
		return $this->password;
	}
	
	//-------------------------------------
	/** Get user registration IP
	@return string */
	//-------------------------------------		
	public function getRegIp()
	{
		return $this->reg_ip;
	}
	
	//-------------------------------------
	/** Get user registration date and time
	@return string */
	//-------------------------------------		
	public function getRegDatetime()
	{
		return $this->created;
	}
	
	//-------------------------------------
	/** Get when user login datetime
	@return string */
	//-------------------------------------		
	public function getLoginDatetime()
	{
		return $this->loginDatetime;
	}
	
	//-------------------------------------
	/** Is user logged in
	@return bool */
	//-------------------------------------		
	public function isLoggedIn()
	{
		return $this->loggedIn;
	}
	
	//-------------------------------------
	/** Get user friendly messages
	@return Notification\UserMsg */
	//-------------------------------------		
	public function getMsg()
	{
		return $this->msg;
	}	
	
	//-------------------------------------
	/** Get error messages
	@return Notification\ErrorMsg */
	//-------------------------------------		
	public function getErrors()
	{
		return $this->errors;
	}
	
	//-------------------------------------
	/** Login a user
	@param string $email	- user email
	@param string $password	- user password
	@return bool */
	//-------------------------------------		
	public function login($email, $password)
	{
		if(empty($email) || empty($password))
		{
			$this->msg->put('All fields must be filled', 'warning');
			return false;
		}

		// getting user data from database
		if($data = $this->getUserDbData($email))
		{
			$datetime = date("Y-m-d H:i:s"); 		// datetime to save login time in session
			
			// Adding data to session
			$_SESSION['user']['id'] 			= $this->id 			= $data['id'];
			$_SESSION['user']['email'] 			= $this->email			= $email;
			$_SESSION['user']['loggedIn'] 		= $this->loggedIn 		= true;
			$_SESSION['user']['loginDatetime'] 	= $this->loginDatetime  = $datetime;
			
			$this->password = $data['password'];
			$this->reg_ip = $data['reg_ip'];
			$this->created = $data['created'];
			
			if(Password::verify($password, $data['password']))
			{
				return true;
			}
			else
			{
				$this->msg->put('Email or password is wrong', 'warning');
			}
		}
		return false;
	}
	
	//-------------------------------------
	/** Logout a user 
	@param bool $clean - clean object variables */
	//-------------------------------------			
	public function logout($clean = true)
	{
		if(!empty($_SESSION['user']['id']))
		{
			// Cleaning variables 
			foreach($this as &$var)
			{
				if(!$var instanceof MysqliClass &&
					!$var instanceof UserMsg &&
					!$var instanceof ErrorMsg)
				{
					$var = null;
				}
			}
			
			$this->loggedIn = false;
			unset($_SESSION['user']);
		}
	}
	
	//-------------------------------------
	/** Check whenever user has logged in session
	@return bool */
	//-------------------------------------			
	private function isLoggedInSession()
	{
		if(!empty($_SESSION['user']['loggedIn']) && $_SESSION['user']['loggedIn'] == true)
		{
			return true;
		}
		return false;
	}
	
	//-------------------------------------
	/** Get user data from database
	@param string $email	- user email
	@return array|bool false */
	//-------------------------------------	
	private function getUserDbData($email)
	{
 		// prepare and bind
		if($stmt = $this->db->get()->prepare("SELECT * FROM users WHERE email=? LIMIT 1"))
		{
			$stmt->bind_param("s", $email);

			if($stmt->execute())
			{
				$result = $stmt->get_result(); // get the mysqli result

				if($result->num_rows > 0)
				{
					return $result->fetch_assoc();
				}
			}
			else
			{
				$this->msg->put('An error occurred', 'warning');
				$this->errors->put(mysqli_error($this->db->get()), mysqli_errno($this->db->get()));
			}
		}
		else
		{
			$this->msg->put('An error occurred', 'warning');
			$this->errors->put(mysqli_error($this->db->get()), mysqli_errno($this->db->get()));
		}
		return false;		
	}
}