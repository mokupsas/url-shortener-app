<?php
declare(strict_types = 1);

namespace UrlShortener\Common;

class Base62
{
	private static $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

	//-------------------------------------
	/** Base62 encodes numbers
	@param int $num	- number to encode
	@return string */
	//-------------------------------------		
	public static function to($num)
	{
		$dif = $num % 62;
		$out = substr(self::$alphabet, $dif, 1);
		$rounds = floor($num / 62);
		
		while($rounds)
		{
			$dif = $rounds % 62;
			$rounds = floor($rounds / 62);
			
			$out = substr(self::$alphabet, $dif, 1) . $out;
		}
		
		return $out;
	}
	
	//-------------------------------------
	/** Base62 decodes string
	@param string $string - string to decode
	@return string */
	//-------------------------------------	
	public static function from($string)
	{
		$limit = strlen($string);
		$out = 0;
		
		for($i = 0; $i < $limit; $i++)
		{
			$out = 62 * $out + strpos(self::$alphabet, (substr($string, $i, 1)));
		}
		return $out; 
	}	
}