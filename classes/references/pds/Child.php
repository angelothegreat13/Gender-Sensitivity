<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Child {
   
    private $_db;

    private $_data;

    public function __construct() 
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function save($fields)
    {
        if (!$this->_db->insert('tpdschildinfo',$fields)) {
            throw new Exception("There was a problem in Creating a Child");
        }
    }

    public function update($id,$fields)
    {   
        if (!$this->_db->update('tpdschildinfo',$id,$fields,'id')) {
            throw new Exception("There was a problem in Updating a Child");
        }
    }

    public function delete($id)
    {
        if (!$this->_db->delete('tpdschildinfo',['id','=',$id])) {
            throw new Exception("There was a problem in Deleting a Child");
        }
    }

    public function personChildren($pds_id)
    {   
        return $this->_db->get('tpdschildinfo',['pds_id','=',$pds_id])->results();
    }

    public function find($id)
    {
        $data = $this->_db->get('tpdschildinfo',['id','=',$id]);
        
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



