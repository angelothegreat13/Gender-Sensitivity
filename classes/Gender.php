<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Gender
{
    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/workforcedb'));
    }

    public function byBirthMonth()
    {
        $sql = "SELECT MONTHNAME(bdate) AS birthmonth,
                COUNT(CASE WHEN sex = 1 THEN 1 END) AS total_male,
                COUNT(CASE WHEN sex = 0 THEN 1 END) AS total_female
                FROM tpdsmaininfo 
                GROUP BY birthmonth 
                ORDER BY MONTH(bdate) ASC";

        return $this -> _db -> query($sql) -> results();
    }

    public function totalNumberPerGender()
    {
        $sql = "SELECT (CASE WHEN sex = 1 THEN 'MALE' ELSE 'FEMALE' END) AS gender,COUNT(appno) AS total 
                FROM tpdsmaininfo 
                GROUP BY sex";
        
        return $this -> _db -> query($sql) -> results();
    }

    public function totalMaleAndFemalePerSource($source,$date_from,$date_to)
    {
        $sql = "SELECT ofc.offcod AS ofc_name,
                COUNT(CASE WHEN sex = 1 THEN 1 END) AS total_male,
                COUNT(CASE WHEN sex = 0 THEN 1 END) AS total_female
                FROM tpdsmaininfo pds 
                INNER JOIN roffinfo ofc ON pds.office = ofc.offcode 
                GROUP BY ofc_name";

        return $this -> _db -> query($sql);
    }

    public function totalGenderByBirthMonthPerSource($source)
    {
        $sql = "SELECT MONTHNAME(bdate) AS birthmonth,
                COUNT(CASE WHEN sex = 1 THEN 1 END) AS total_male,
                COUNT(CASE WHEN sex = 0 THEN 1 END) AS total_female
                FROM tpdsmaininfo 
                GROUP BY birthmonth 
                ORDER BY MONTH(bdate) ASC";

        return $this -> _db -> query($sql) -> results();
    }




}

?>