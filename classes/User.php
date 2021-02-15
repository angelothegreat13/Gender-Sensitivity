<?php namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;
use Gender\Classes\Supports\Session;

class User {

    private $_db,
            $_data;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/systemsdb'));

        if (validate_session('SESS_GENDER_USER_ID')) {
            $this->find(Session::get('SESS_GENDER_USER_ID'));
        }
    }

    public function usernameOnlyExists($username,$password)
    {
        $sql = "SELECT usr.username 
                FROM users usr 
                INNER JOIN access acs ON usr.id = acs.user_id 
                WHERE usr.username = ? AND usr.password != ? AND acs.modgen = 1";

        $data = $this->_db->query($sql,[$username,md5($password)]);

        if (!$data->count()) {
            return false;
        }

        return true;
    }

    public function login($username,$password)
    {
        $sql = "SELECT usr.* 
                FROM users usr 
                INNER JOIN access acs ON usr.id = acs.user_id 
                WHERE usr.username = ? AND usr.password = ? AND acs.modgen = 1";

        $data = $this->_db->query($sql,[$username,md5($password)]);

        if ($data -> count()) {
            $this->_data = $data->first();
            return true;
        }

        return false;
    }

    public function update($user_id,$fields)
    {
        if (!$this->_db->update('users',$user_id,$fields,'id')) {
            throw new \Exception("There was a problem in Updating a User");
        }
    }

    public function find($user_id)
    {
        $sql = "SELECT us.*, of.offdesc,of.offcod,dp.deptdesc,dp.deptcod,dv.divdesc
                FROM systems.users us 
                LEFT JOIN global_ref.roffinfo of ON us.office = of.offcode
                LEFT JOIN global_ref.rdeptinfo dp ON us.office = dp.offcode AND us.dept = dp.deptcode
                LEFT JOIN global_ref.rdivinfo dv ON dp.deptcode = dv.deptcode AND dv.divcode = us.divcode 
                WHERE us.id = ?";
        
        $data = $this->_db->query($sql,[$user_id]);

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

    public function checkCurrentPassword($current_pass)
    {
        if ($this->data()->password === md5($current_pass)) {
            return true;
        }

        return false;
    }

    public function changePassword($new_pass)
    {
        $this->update(Session::get('SESS_GENDER_USER_ID'),['password' => md5($new_pass)]);
    }

}