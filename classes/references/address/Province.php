<?php namespace Gender\Classes\References\Address;

use Gender\Classes\Supports\Config;
use Gender\Core\DB;

class Province 
{
    private $_db;
    
    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        return $this->_db->select(['provDesc','provCode'],'refprovince');
    }

  	public function sort($regCode)
  	{
        $sql = "SELECT provCode,provDesc FROM refprovince 
                WHERE regCode = ? 
                ORDER BY provDesc ASC";

        $data = $this->_db->query($sql,[$regCode]);

        return $data->results();
  	}

}

