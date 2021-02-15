<?php namespace Gender\Classes\References\Organizations;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Department {
    
    private $_db;
    
    public function __construct() {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        return $this->_db->get('rdeptinfo',['deleted','=',0])->results();
    }

    public function sort($offcode)
    {   
        $sql = "SELECT * 
                FROM rdeptinfo 
                WHERE offcode = ? AND deleted = 0";

        $data = $this->_db->query($sql,[$offcode]);
        
        if (!$data->count()) {
            return [];
        }

        return $data->results();
    }


}

