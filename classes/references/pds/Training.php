<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Training {

    private $_db;

    private $_data;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function save($fields)
    {
        if (!$this->_db->insert('tpdstrnginfo',$fields)) {
            throw new Exception("There was a problem in Creating Training Information");
        }
    }

    public function update($id,$fields)
    {   
        if (!$this->_db->update('tpdstrnginfo',$id,$fields,'id')) {
            throw new Exception("There was a problem in Updating Training Information");
        }
    }

    public function delete($educ_id)
    {
        if (!$this->_db->delete('tpdstrnginfo',['id','=',$educ_id])) {
            throw new Exception("There was a problem in Deleting Training Information");
        }
    }

    public function personTrainings($pds_id)
    {   
        return $this->_db->get('tpdstrnginfo',['pds_id','=',$pds_id])->results();
    }

    public function find($id)
    {
        $data = $this->_db->get('tpdstrnginfo',['id','=',$id]);
        
        if ($data -> count()) 
        {
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



