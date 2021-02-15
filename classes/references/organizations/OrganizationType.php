<?php namespace Gender\Classes\References\Organizations;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class OrganizationType {

	private $_db;
    
    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        return $this->_db->all('reforgtype');
    }

}

