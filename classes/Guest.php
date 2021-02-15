<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;
use Gender\Classes\Supports\Session;

class Guest {

    private $_db,
            $_data;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
        
        if (Session::exists('SESS_GENDER_GUEST_ID') && Session::get('SESS_GENDER_GUEST_ID') != NULL) {
            $this->find(Session::get('SESS_GENDER_GUEST_ID'));    
        }
    }

    public function save($fields)
	{
		if (!$this -> _db -> insert('guests',$fields)) {
            throw new \Exception("There was a problem in Saving a Guest");
        }
    }

    public function find($id)
    {
        $sql = "SELECT gst.*,usr_type.user_typedesc AS user_type
                FROM guests gst 
                INNER JOIN global_ref.ref_usertype usr_type ON gst.user_type_id = usr_type.id 
                WHERE gst.id = ?";

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

    public function latestID()
	{
		return $this->_db->lastID();
    }

}