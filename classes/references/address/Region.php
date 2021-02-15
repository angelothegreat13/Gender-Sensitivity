<?php namespace Gender\Classes\References\Address;

use Gender\Classes\Supports\Config;
use Gender\Core\DB;

class Region
{
    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        return $this->_db->select(['id','regDesc','regCode'],'refregion');
    }
}

