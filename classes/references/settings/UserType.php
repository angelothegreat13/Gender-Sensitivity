<?php namespace Gender\Classes\References\Settings;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class UserType {

    private $_db;
    
    private $_data;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        $data = $this->_db->get('ref_usertype',['deleted','=',0]);

        if (!$data->count()) {
            return false;
        }
        
        return $data->results();
    }

    public function bySource($source_id)
    {
        $sql = "SELECT ut.*, sr.id AS sr_id, sourcedesc 
                FROM ref_usertype ut 
                INNER JOIN ref_sources sr ON ut.source_id = sr.id 
                WHERE ut.source_id = ? and ut.deleted = 0";
        
        $data = $this->_db->query($sql,[$source_id]);

        if (!$data->count()) {
            return false;
        }

        return $data->results();
    }

    public function find($id)
    {
        $sql = "SELECT * 
                FROM ref_usertype 
                WHERE id = ? AND deleted = 0";

        $data = $this->_db->query($sql,[$id]);

        if ($data->count()) {
            $this->_data = $data->first();
            return true;
        }

        return false;
    }

    public function data()
    {
        return $this->_data;
    }

    public function delete($id)
    {
        $this->_db->softDelete('ref_usertype',['id','=',$id]);
    }

}