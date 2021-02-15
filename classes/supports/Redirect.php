<?php 

namespace Gender\Classes\Supports;

class Redirect 
{   
    public static function to($location = null,$params = null)
    {
        if ($location) 
        {
            if (is_numeric($location)) 
            {
                switch ($location) 
                {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include DR.SITE_ROOT.'includes/errors/404.php';
                        exit();
                    break;
                }
            }
            
            header('Location: '.MODULE_URL.$location.'.php'.$params);
            exit();
        }
    }

    public static function back()
    {
        $referer = $_SERVER['HTTP_REFERER'];

        header("Location: $referer");
        exit();
    }
}
