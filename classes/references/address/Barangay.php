<?php namespace Gender\Classes\References\Address;

use Gender\Classes\Supports\Config;
use Gender\Core\DB;

class Barangay {
	
    private $_db;
    
    public function __construct() {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        return $this->_db->select(['brgyDesc','brgyCode'],'refbrgy');
    }

    public function sort($regCode,$provCode,$citymunCode)
  	{	
        $sql = "SELECT brgyCode,brgyDesc 
                FROM refbrgy 
                WHERE regCode = ? AND provCode = ? AND citymunCode = ? 
                ORDER BY brgyDesc ASC"; 

        $data = $this->_db->query($sql,[$regCode,$provCode,$citymunCode]);

        return $data->results();
  	}

    
}

