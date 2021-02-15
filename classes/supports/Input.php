<?php 

namespace Gender\Classes\Supports;

class Input {

    public static function exists($type='POST')
	{
		switch ($type) 
		{
			case 'POST':
				return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
			break;

			case 'GET':
				return ($_SERVER['REQUEST_METHOD'] == 'GET') ? true : false;
            break;
		}
	}

    public static function get($item)
    {
        if (isset($_POST[$item])) {
            return sanitize($_POST[$item]);
        }
        elseif (isset($_GET[$item])) {
            return sanitize($_GET[$item]);
        }
    }

    

}