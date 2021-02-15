<?php namespace Gender\Classes\References\Address;

use Gender\Classes\Supports\Config;
use Gender\Core\DB;

class Municipality
{
    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        return $this->_db->select(['cityMunDesc','cityMunCode'],'refcitymun');
    }

    public function sort($regCode,$provCode)
  	{	
        $sql = "SELECT cityMunCode,cityMunDesc 
                FROM refcitymun 
                WHERE regDesc = ? AND provCode = ? 
                ORDER BY cityMunDesc ASC";
                
        $data = $this->_db->query($sql,[$regCode,$provCode]);

        return $data->results();
  	}

}

