<?php
declare(strict_types = 1);

namespace UrlShortener\Notification;

// Class to store user friendly messages
class UserMsg
{
	/*	Message structure
	
		[
			[string(message), string(type)],
			[string(message), string(type)]
		]
	*/
	private $msg = array();	// message array
	
	//-------------------------------------
	/** Add message to array
	@param string $message 	- message
	@param string $type		- message type, to resolve HTML */
	//-------------------------------------
	public function put($message, $type)
	{
		$this->msg[] = ['message' => $message, 'type' => $type];
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