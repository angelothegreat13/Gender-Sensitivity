<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;
use Gender\Classes\Supports\Session;

class PdsTransaction {

	private $_db;

	public function __construct()
	{
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
	}

	public function store($fields)
	{
		if (!$this->_db->insert('pds_trans',$fields)) {
            throw new \Exception("There was a problem in Saving a PDS Transaction");
        }
    }

    public function save($pds_id,$action_id)
    {
    	$this->store([
	        'user_id' => Session::get('SESS_GENDER_USER_ID'),
	        'pds_id' => $pds_id,
	        'action_id' => $action_id,
	        'ip_address' => get_ip_address(), 
	        'mac_address' => getMacAdd(),
	        'server' => $_SERVER['SERVER_NAME'],
	        'browser' => get_user_browser(), 
	        'platform' => get_platform()
	    ]);
    }


}
