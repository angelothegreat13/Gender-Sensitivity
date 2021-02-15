<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Education {   

    private $_db;

    private $_data;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function save($fields)
    {
        if (!$this->_db->insert('tpdseducinfo',$fields)) {
            throw new Exception("There was a problem in Creating an Educational Information");
        }
    }

    public function update($id,$fields)
    {   
        if (!$this -> _db -> update('tpdseducinfo',$id,$fields,'id')) {
            throw new Exception("There was a problem in Updating an Educational Information");
        }
    }

    public function delete($id)
    {
        if (!$this->_db->delete('tpdseducinfo',['id','=',$id])) {
            throw new Exception("There was a problem in Deleting an Educational Information");
        }
    }

    public function personEducations($pds_id)
    {   
        return $this->_db->get('tpdseducinfo',['pds_id','=',$pds_id])->results();
    }

    public function find($id)
    {
        $data = $this->_db->get('tpdseducinfo',['id','=',$id]);
        
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

    public function latestID()
    {
        return $this->_db->lastID();
    }

}



