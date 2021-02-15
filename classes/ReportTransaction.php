<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class ReportTransaction {

    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function save($fields)
    {
        if (!$this -> _db -> insert('report_trans',$fields)) {
            throw new \Exception("There was a problem in Saving a Report Transaction");
        }
    }

    public function latestID()
    {
        return $this->_db->lastID();
    }

}