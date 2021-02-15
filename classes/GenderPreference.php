<?php namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class GenderPreference
{
    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        return $this->_db->all('rgenderpref');
    }

    public function byBirthMonth()
    {
        $sql = "SELECT MONTHNAME(bdate) AS birthmonth,
                COUNT(CASE WHEN genderpref = 1 THEN 1 END) AS masculine,
                COUNT(CASE WHEN genderpref = 2 THEN 1 END) AS feminine,
                COUNT(CASE WHEN genderpref = 3 THEN 1 END) AS gay,
                COUNT(CASE WHEN genderpref = 4 THEN 1 END) AS lesbian,
                COUNT(CASE WHEN genderpref = 5 THEN 1 END) AS bisexual,
                COUNT(CASE WHEN genderpref = 6 THEN 1 END) AS transgender,
                COUNT(CASE WHEN genderpref = 7 THEN 1 END) AS queer,
                COUNT(CASE WHEN genderpref = 8 THEN 1 END) AS questioning,
                COUNT(CASE WHEN genderpref = 9 THEN 1 END) AS intersex,
                COUNT(CASE WHEN genderpref = 10 THEN 1 END) AS asexual
                FROM tpdsmaininfo 
                GROUP BY birthmonth ORDER BY MONTH(bdate) ASC";
        
        return $this->_db->query($sql)->results();
    }

    public function totalNumberPerGenderPreference()
    {
        $sql = "SELECT b.genderdesc,COUNT(b.genderdesc) as total 
                FROM tpdsmaininfo a 
                INNER JOIN rgenderpref b ON a.genderpref = b.id 
                GROUP BY b.genderdesc";
        
        return $this->_db->query($sql)->results();
    }

    public function totalPercentages()
    {
        $sql = "SELECT b.genderdesc,ROUND((COUNT(b.id)/(SELECT COUNT(appno) FROM tpdsmaininfo))*100,2) 
                AS total 
                FROM tpdsmaininfo a
                INNER JOIN rgenderpref b ON a.genderpref = b.id 
                GROUP BY b.genderdesc";

        return $this -> _db -> query($sql) -> results();
    }
    
}