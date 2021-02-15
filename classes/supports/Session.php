<?php 

namespace Gender\Classes\Supports;

class Session
{

	public static function exists($name)// check if the session exists
	{
		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function put($name,$value)
	{
		return $_SESSION[$name] = $value;
	}

	public static function get($name)
	{
		return $_SESSION[$name];
	}

	public static function delete($name)
	{
		if (self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}

	public static function flash($name, $string = '')
	{
		if (self::exists($name)) {
			$session = self::get($name);
			self::delete($name);
			return $session;
		}
		else {
			self::put($name, $string);
		}
	}

	public static function message()
    {	
        if (self::exists('successMsg')) {
			echo pretty_success(self::get('successMsg'));
            self::delete('successMsg');
        }

        if (self::exists('errorMsg')) {
			echo pretty_errors(self::get('errorMsg'));
            self::delete('errorMsg');
        }
    }

    
}