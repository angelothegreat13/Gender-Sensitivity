<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class PasswordRetry {

    private $_db,
            $_attempt,
            $_limit = 8;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function save($fields)
    {
        if (!$this->_db->insert('password_retry',$fields)) {
            throw new \Exception("There was a problem in saving your Password.");
        }
    }

    public function limitReached($username)
    {   
        $sql = "SELECT COUNT(*) AS i 
                FROM password_retry 
                WHERE ip_address = ? AND username = ? AND date > (now() - interval 4 minute)";

        $this->_attempt = (int)$this->_db->query($sql,[get_ip_address(),$username])->first()->i;

        if ($this->attempt() > $this->_limit) {
            return true; 
        }

        return false;
    }

    public function attempt()
    {
        return $this->_attempt;
    }

    public function attemptMsg()
    {
        return 'YOU ATTEMPTED '.$this->attempt().' OUT OF '. $this->_limit.' PASSWORD';
    }

    public function limitReachedMsg()
    {
        return 'YOU ARE ALLOWED '.$this->_limit.' ATTEMPTS IN 4 MINUTES ONLY';
    }

    public function refresh()
    {
        $sql = "DELETE FROM password_retry WHERE date > (now() - interval 4 minute)";

        if (!$this->_db->query($sql)) {
            throw new \Exception("There was a problem in Refresing yout Password Retry Table");
        }
    }

    
}