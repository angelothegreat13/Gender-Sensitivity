<?php namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class LoginHistory {

    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function save($fields)
    {
        if (!$this -> _db -> insert('login_history',$fields)) {
            throw new \Exception("There was a problem in Saving a Login History");
        }
    }

    public function latestID()
	{
		return $this->_db->lastID();
    }

    public function update($id,$fields)
    {
        if (!$this->_db->update('login_history',$id,$fields,'id')) {
            throw new \Exception("There was a problem in Updating a Login History");
        }
    }

    public function byUser($user_id)
    {
        $sql = "SELECT * 
                FROM login_history 
                WHERE user_id = ? 
                ORDER BY id DESC";

        $data = $this->_db->query($sql,[$user_id]);

        if ($data->count()) {
            return $data->results();            
        }

        return false;
    }   

}