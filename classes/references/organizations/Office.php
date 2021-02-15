<?php namespace Gender\Classes\References\Organizations;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Office
{
    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {	
		return $this->_db->get('roffinfo',['deleted','=',0])->results();
    }

}

