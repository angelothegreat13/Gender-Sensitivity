<?php namespace Gender\Classes\References\Organizations;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Division {

    private $_db;

    public function __construct() {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        return $this->_db->get('rdivinfo',['deleted','=',0])->results();
    }

    public function sort($deptcode)
    {   
        $sql = "SELECT * 
                FROM rdivinfo 
                WHERE deptcode = ? AND deleted = 0";

        $data = $this->_db->query($sql,[$deptcode]);
        
        if (!$data->count()) {
            return [];
        }

        return $data->results();
    }


}

