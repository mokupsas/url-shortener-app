<?php
declare(strict_types = 1);

namespace UrlShortener\Account;

use UrlShortener\Account\StatusCodes;
use UrlShortener\Database\MysqliClass;
use UrlShortener\Security\Password;
use Http\HttpRequest;

class UserHandler
{
	private $request;
	private $db;
	
	//-------------------------------------
	/** Creates UserHandler object
	@param HttpRequest $request	- website request handler class
	@param MysqliClass $db		- Mysqli object class */
	//-------------------------------------	
	public function __construct(HttpRequest $request, MysqliClass $db)
	{
		$this->request = $request;
		$this->db = $db;
	}
	
	//-------------------------------------
	/** Register a user
	@param string $email	- user email
	@param string $password	- user password 
	@return StatusCodes:int */
	//-------------------------------------		
	public function register($email, $password)
	{		
		// Getting POST parameters
		$email = $this->sanitize($email);
		$password = $this->sanitize($password);
		// Variables
		$datetime = date("Y-m-d H:i:s");
		$ip = $this->request->getIpAddress();
		
		// Validating data
		if(!$this->areFieldsFilled($email, $password))
			return StatusCodes::SIGNUP_INPUT_EMPTY;
		
		if(!$this->isEmailValid($email))
			return StatusCodes::SIGNUP_BAD_EMAIL; 
		
		if(!$this->isPasswordValid($password))
			return StatusCodes::SIGNUP_PASS_LENGTH;
		
		if($this->isEmailInUse($email))
			return StatusCodes::SIGNUP_EMAIL_IN_USE;

		if($this->countIpRegistrations($ip) >= 3)
			return StatusCodes::SIGNUP_IP_LIMIT;
		
		// Hashing password
		$hashed_password = Password::hash($password);
		
 		// Registering account to database
		if($stmt = $this->db->get()->prepare("INSERT INTO users (email, password, reg_ip, created) VALUES (?, ?, ?, ?)"))
		{
			$stmt->bind_param("ssss", $email, $hashed_password, $ip, $datetime);

			if($stmt->execute())
			{
				return StatusCodes::SIGNUP_SUCCESS;
			}
		}
		$stmt->close();	
		
		return StatusCodes::SIGNUP_ERROR;
	}
	
	//-------------------------------------
	/** Converts StatusCode values to user 
		friendly message
	@param int $status	- StatusCode value
	@param string $password	- user password 
	@return string */
	//-------------------------------------		
	public function statusToMessage($status)
	{
		if($status == StatusCodes::SIGNUP_NOT_SUBMITTED)
			return;
		
		if($status == StatusCodes::SIGNUP_SUCCESS)
			return 'Account successfully created';
		
		if($status == StatusCodes::SIGNUP_ERROR)
			return 'An error has occurred';
		
		if($status == StatusCodes::SIGNUP_INPUT_EMPTY)
			return 'All fields must be filled';
		
		if($status == StatusCodes::SIGNUP_BAD_EMAIL)
			return 'Wrong email';
		
		if($status == StatusCodes::SIGNUP_EMAIL_IN_USE)
			return 'Email is already in use';
		
		if($status == StatusCodes::SIGNUP_IP_LIMIT)
			return 'Registration limit reached';
		
		if($status == StatusCodes::SIGNUP_PASS_LENGTH)
			return 'Password must be at least 6 characters long';
	}	
	
	//-------------------------------------
	/** Sanitize user provided data
	@param string $data	- data to sanitize
	@return string */
	//-------------------------------------		
	private function sanitize($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}		
	
	//-------------------------------------
	/** Is email already registered in database
	@param string $mail - user provided email
	@return bool */
	//-------------------------------------		
	private function isEmailInUse($email)
	{
 		// prepare and bind
		if($stmt = $this->db->get()->prepare("SELECT * FROM users WHERE email=?"))
		{
			$stmt->bind_param("s", $email);

			if($stmt->execute())
			{
				$result = $stmt->get_result(); // get the mysqli result

				if($result->num_rows > 0)
					return true;
			}
		}
		$stmt->close();
		
		return false;
	}	
	
	//-------------------------------------
	/** Checks that both submissions are not empty
	@param string $email	- user email
	@param string $password	- user password 
	@return bool */
	//-------------------------------------		
	private function areFieldsFilled($email, $password)
	{
		if(empty($email) || empty($password))
			return false;
		
		return true;
	}

	//-------------------------------------
	/** Checks if email is valid
	@param string $email - user email
	@return string|bool */
	//-------------------------------------		
	private function isEmailValid($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	//-------------------------------------
	/** Checks if password meets requirements
	@param string $password	- user password 
	@return bool */
	//-------------------------------------		
	private function isPasswordValid($password)
	{
		if(strlen($password) < 6)
			return false;
	
		return true;
	}	
	
	//-------------------------------------
	/** Count how many registrations made by IP address
	@param string $ip	- IP address 
	@return int */
	//-------------------------------------		
	private function countIpRegistrations($ip) : int
	{
 		// prepare and bind
		if($stmt = $this->db->get()->prepare("SELECT reg_ip FROM users WHERE reg_ip=?"))
		{
			$stmt->bind_param("s", $ip);

			if($stmt->execute())
			{
				$result = $stmt->get_result(); // get the mysqli result

				return $result->num_rows;
			}
		}
		$stmt->close();
		
		return -1;
	}
}