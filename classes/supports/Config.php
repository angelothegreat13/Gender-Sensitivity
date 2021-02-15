<?php

namespace Gender\Classes\Supports;

class Config
{
	
	public static function get($path = null)
	{
		if ($path) {
			$config = $GLOBALS['config']; //accessing the GLOBALS config array in init.php
			$path = explode('/',$path);

			// print_r($path);

			foreach ($path as $bit) 
			{	
				//checking if the parameter that pass is exist in GLOBAL config
				if (isset($config[$bit])) {
					$config = $config[$bit];
				}
			}

			return $config;
		}

		return false;
	}
}

