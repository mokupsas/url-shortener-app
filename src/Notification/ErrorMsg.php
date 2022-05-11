<?php
declare(strict_types = 1);

namespace UrlShortener\Notification;

// Class to store user friendly messages
class ErrorMsg
{
	/*	Message structure
	
		[
			[string(message), int(errno)],
			[string(message), int(errno)]
		]
	*/
	private $msg = array();	// message array
	
	//-------------------------------------
	/** Add message to array
	@param string $message 	- message
	@param string $type		- message type, to resolve HTML */
	//-------------------------------------
	public function put($message, $errno = 0)
	{
		$this->msg[] = ['message' => $message, 'errno' => $errno];
	}
	
	//-------------------------------------
	/** Get message from the end of array
	@return array */
	//-------------------------------------
	public function pop()
	{
		return array_pop($this->msg);
	}
	
	//-------------------------------------
	/** Get message from the beginning of array
	@return array */
	//-------------------------------------	
	public function shif()
	{
		return array_shift($this->msg);
	}
}