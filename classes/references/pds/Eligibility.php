<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Eligibility {   
    
    private $_db;

    private $_data;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function save($fields)
    {
        if (!$this->_db->insert('tpdscivservinfo',$fields)) {
            throw new Exception("There was a problem in Creating an Eligibility Information");
        }
    }

    public function update($id,$fields)
    {   
        if (!$this->_db->update('tpdscivservinfo',$id,$fields,'id')) {
            throw new Exception("There was a problem in Updating Eligibility Information");
        }
    }

    public function delete($eligibility_id)
    {
        if (!$this->_db->delete('tpdscivservinfo',['id','=',$eligibility_id])) {
            throw new Exception("There was a problem in Deleting an Eligibility Information");
        }
    }

    public function personEligibilities($pds_id)
    {   
        return $this->_db->get('tpdscivservinfo',['pds_id','=',$pds_id])->results();
    }

    public function find($id)
    {
        $data = $this->_db->get('tpdscivservinfo',['id','=',$id]);
        
        if ($data->count()) 
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



