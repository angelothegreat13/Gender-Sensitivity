<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class PdsTable {

	private $_db;

    private $_totalFiltered;
    
    private $_results;

    private $_totalTblFiltered;

    private $_tblResults;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function totalData()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM tpdsmaininfo";

        return $this->_db->query($sql)->first()->total;
    }

    public function setTable($sql2,$search)
    {   
        $sql = "SELECT pds.id AS pds_id, CONCAT(pds.prefix,' ',pds.fname,' ',pds.mname,' ',pds.lname) AS full_name, 
                ut.user_typedesc AS pds_type, pds.photo, pds.sex, pds.created_at, 
                (CASE WHEN pds.status = 0 THEN 'Active' 
                WHEN pds.status = 1 THEN 'Inactive' END) AS pds_status 
                FROM tpdsmaininfo pds 
                INNER JOIN ref_usertype ut ON pds.pds_type_id = ut.id WHERE $sql2";

        $data = $this->_db->query($sql,[$search,$search,$search,$search,status_to_num($search)]);

        $this->_totalTblFiltered = $data->count();

        $this->_tblResults = $data->results();      
    }

    public function getTotalTblFiltered()
    {
        return $this->_totalTblFiltered;
    }

    public function getTblResults()
    {
        return $this->_tblResults;
    }

    public function getTableHTML()
    {   
        $table = [];

        foreach ($this->getTblResults() as $tbl) 
        {
            $row = [];
            $row[] = "<input type='radio' id='pds_id' name='pds_id' class='pds-radio' value='".$tbl->pds_id."'>";
            $row[] = $tbl->pds_id;
            $row[] = "<img src='".avatar($tbl->photo,$tbl->sex)."' height='50' width='50' class='img-circle'>";
            $row[] = ucwords($tbl->full_name);
            $row[] = $tbl->pds_type;
            $row[] = "<span class='label label-".pretty_status($tbl->pds_status)."'>".$tbl->pds_status."</span>";
            $row[] = pretty_date($tbl->created_at);
            $table[] = $row;
        }

        return $table;
    }


}