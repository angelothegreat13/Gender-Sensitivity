<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class UserPds {

	private $_db;

	public function __construct()
	{
		$this->_db = DB::instance(Config::get('mysql/globalrefdb'));
	}

	public function save($fields)
	{
		if (!$this->_db->insert('user_pds',$fields)) {
            throw new \Exception("There was a problem in Saving a User PDS");
        }
	}


}