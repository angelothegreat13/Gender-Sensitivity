<?php namespace  Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Passenger {
    
    private $_db;

    public function __construct()
	{
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function totalSearchedWithoutLimit($key)
    {   
        $sql = "SELECT COUNT(*) AS total 
                FROM passengers   
                WHERE passcode = ? OR CONCAT(fname,' ',lname) LIKE CONCAT('%',?,'%')";

        return $this->_db->query($sql,[$key,$key])->first()->total;
    }

    public function search($offset,$num_of_records,$key)
    {
        $sql = "SELECT passcode AS id, CONCAT(passcode,' - ',fname,' ',lname) AS id_name  
                FROM passengers   
                WHERE passcode = ? OR CONCAT(fname,' ',lname) LIKE CONCAT('%',?,'%') 
                LIMIT $offset, $num_of_records";

        $data = $this->_db->query($sql,[$key,$key]);

        if (!$data->count()) {
            return [];
        }

        return $data->results();
    }   

    /**
    * @param uniqueCol = unique column name of table
    * @param uniqueColVal = unique column value
    * @param idCol = column id 
    * @param idVal = id value
    */
    public function isUnique($uniqueCol,$uniqueColVal,$idCol = null,$idVal = null)
    {
        $sql = "SELECT * FROM passengers WHERE ";
        $params = [];

        if (!$idVal) {
            $sql .= "{$uniqueCol} = ?";            
            $params = [$uniqueColVal];
        }
        else {
            $sql .= "{$idCol} <> ? AND {$uniqueCol} = ?";
            $params = [$idVal,$uniqueColVal];
        }

        if ($this->_db->query($sql,$params)->count()) {
            return false;
        }

        return true;
    }

}


