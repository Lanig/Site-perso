<?php

namespace Core\Service;

/**
* Fonction
*/
class Fonction
{
	public static function camelCase($str, $capitaliseFirstChar = false)
	{
		$str = preg_replace('/[^a-z0-9]/i', "_", $str);
		$str = ucwords($str, "_");
		$str = preg_replace('/_/', "", $str);
		if(!$capitaliseFirstChar) $str = lcfirst($str);
		return $str;
	}
}