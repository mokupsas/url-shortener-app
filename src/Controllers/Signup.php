<?php
declare(strict_types = 1);

namespace UrlShortener\Controllers;

use Http\HttpRequest;
use Http\HttpResponse;

use UrlShortener\Security\Password;
use UrlShortener\Auth\Handler;
use UrlShortener\Database\MysqliClass;
use UrlShortener\Template\MustacheEgine;

class Signup
{
	// Objects
	private $request;
	private $db;
	
	// Signup status codes
    private const SIGNUP_SUCCESS = 1;
    private const SIGNUP_ERROR = 2;
    private const SIGNUP_NOT_SUBMITTED = 3;
	private const SIGNUP_INPUT_EMPTY = 4;
	private const SIGNUP_BAD_EMAIL = 5;
	private const SIGNUP_PASS_LENGTH = 6;

	public function __construct(HttpRequest $request, MysqliClass $db)
	{
		$this->request = $request;
		$this->db = $db->get();
	}
	
	public function show()
	{
		// Objects
		//$authHandler = new Handler($this->db);
		$templateEngine = new MustacheEgine();
		
		// Registration status code
		$status = $this->register();
		
		// Alert message with registration information for user
		$alert = $this->alertMessage($status);
		
		//return $templateEngine->render('Homepage', array());
		return '
			'. $alert .'
			<form method="POST">
				<input type="text" name="email">
				<input type="password" name="pass">
				<input type="submit" name="submit">
			</form>
		';
	}
	
	private function register()
	{
		if(!$this->isFormSubmitted())
			return self::SIGNUP_NOT_SUBMITTED;
		
		// Getting POST parameters
		$email = $this->sanitize($this->request->getParameter('email'));
		$password = $this->sanitize($this->request->getParameter('pass'));
		
		// Validating data
		if(!$this->areFieldsFilled($email, $password))
			return self::SIGNUP_INPUT_EMPTY;
		
		if(!$this->isEmailValid($email))
			return self::SIGNUP_BAD_EMAIL; 
		
		if(!$this->isPasswordValid($password))
			return self::SIGNUP_PASS_LENGTH;
		
		if($this->createDbEntry($email, $password))
			return self::SIGNUP_SUCCESS;
		
		return self::SIGNUP_ERROR;
	}
	
	private function sanitize($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}	
	
	private function isFormSubmitted()
	{
		if(empty($this->request->getParameter('submit')))
			return false;
		
		return true;
	}	
	
	private function areFieldsFilled($email, $password)
	{
		if(empty($email) || empty($password))
			return false;
		
		return true;
	}
	
	private function isEmailValid($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	private function isPasswordValid($password)
	{
		if(strlen($password) < 6)
			return false;
	
		return true;
	}	
	
	private function alertMessage($status)
	{
		if($status == self::SIGNUP_NOT_SUBMITTED)
			return;
		
		if($status == self::SIGNUP_SUCCESS)
			return 'Account successfully created';
		
		if($status == self::SIGNUP_ERROR)
			return 'An error has occurred';
		
		if($status == self::SIGNUP_INPUT_EMPTY)
			return 'All fields must be filled';
		
		if($status == self::SIGNUP_BAD_EMAIL)
			return 'Wrong email';
		
		if($status == self::SIGNUP_PASS_LENGTH)
			return 'Password must be at least 6 characters long';
	}
	
	private function createDbEntry($email, $password)
	{
		$datetime = date("Y-m-d H:i:s");
		$ip = $this->request->getIpAddress();
		
		$password = Password::hash($password);
		
 		// prepare and bind
		if($stmt = $this->db->prepare("INSERT INTO users (email, password, ip, created) VALUES (?, ?, ?, ?)"))
		{
			$stmt->bind_param("ssss", $email, $password, $ip, $datetime);

			if($stmt->execute())
			{
				return true;
			}
		}
		$stmt->close();
		
		return false;
	}
}