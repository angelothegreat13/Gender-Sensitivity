<?php namespace Gender\Classes\References\Terms;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Country
{
	private $_db;
	
	public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

	public function list()
	{
        return $this->_db->all('countries');
	} 
	
}

