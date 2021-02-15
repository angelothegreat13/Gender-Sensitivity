<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class PdsImage 
{   
    private $_db,
            $_image,
            $_location;

    public function __construct($image,$location)
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
        $this->_image = $image;
        $this->_location = $location;
    }

    public function upload()
    {

    }



}