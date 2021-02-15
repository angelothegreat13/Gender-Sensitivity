<?php namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Concessionaire {
    
    private $_db;

    public function __construct()
	{
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function totalSearchedWithoutLimit($key)
    {   
        $sql = "SELECT COUNT(*) AS total 
                FROM concessionaires  
                WHERE concode = ? OR business LIKE CONCAT('%',?,'%')";

        return $this->_db->query($sql,[$key,$key])->first()->total;
    }

    public function search($offset,$num_of_records,$key)
    {
        $sql = "SELECT concode AS id, CONCAT(concode,' - ',business) AS id_business 
                FROM concessionaires  
                WHERE concode = ? OR business LIKE CONCAT('%',?,'%') 
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
        $sql = "SELECT * FROM concessionaires WHERE ";
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


