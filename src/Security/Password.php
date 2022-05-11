<?php
declare(strict_types = 1);

namespace UrlShortener\Security;

class Password
{
	//-------------------------------------
	/** Hashed provided password
	@param string $password	- password to hash
	@return string */
	//-------------------------------------		
	public static function hash($password)
	{
		$options = [
			'cost' => 12,
		];
		
		return password_hash($password, PASSWORD_BCRYPT, $options);
	}
	
	//-------------------------------------
	/** Chechks if raw password matches hashed password
	@param string $password	- raw password
	@param string $hash		- hashed password
	@param bool */
	//-------------------------------------			
	public static function verify($password, $hash)
	{
		return password_verify($password, $hash);
	}
}