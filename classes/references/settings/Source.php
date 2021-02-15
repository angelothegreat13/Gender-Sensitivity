<?php namespace Gender\Classes\References\Settings;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Source {

    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        $data = $this->_db->get('ref_sources',['deleted','=',0]);

        if (!$data->count()) {
            return false;
        }

        return $data->results();
    }

}