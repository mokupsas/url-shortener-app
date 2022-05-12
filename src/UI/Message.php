<?php
declare(strict_types = 1);

namespace UrlShortener\UI;

class Message
{
	//-------------------------------------
	/** Create HTML Bootsrap alert
	@param string $message 	- message to display
	@param string $type 	- alert box type (warning, danger, success, info...)
	@return string */
	//-------------------------------------		
	public static function alert($message, $type = 'primary')
	{
		return '
			<div class="alert alert-'. $type. ' mt-4" role="alert">
				'. $message .'
			</div>
		';
	}
}