<?php 

namespace Gender\Classes;

use Gender\Core\DB;

use Gender\Classes\Supports\Config;
use Gender\Classes\Supports\Session;

class GuestAudit {

    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }   

    public function save(array $fields)
    {
        $columns = array_to_string_with_comma($fields);

        if (!$this->_db->query("CALL pr_guest_audits({$columns})")) {
            throw new \Exception("There was a problem in Creating a New Guest Audit");
        }
    }

    public function log($menu_id,$action_id)
    {
        $this->save([
            Session::get('SESS_GENDER_GUEST_ID'), 
            $menu_id, 
            $action_id, 
            get_ip_address(), 
            getMacAdd(),
            $_SERVER['SERVER_NAME'], 
            get_platform(), 
            get_user_browser() 
        ]);
    }

}


