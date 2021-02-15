<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class GuestSession {

    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function save($fields)
	{
		if (!$this -> _db -> insert('guest_sessions',$fields)) {
            throw new \Exception("There was a problem in Saving a Guest");
        }
    }

    public function latestID()
	{
		return $this->_db->lastID();
	}
    
    public function futureID()
	{
		return $this->_db->lastRow('guest_sessions','id',['id'])->id + 1;
    }
    
    public function exists($guest_sess_code)
    {   
        $data = $this->_db->get('guest_sessions',['session_code','=',$guest_sess_code]);
        
        if ($data->count()) {
            return true;
        }

        return false;
    }

}