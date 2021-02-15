<?php namespace Gender\Classes\References\Settings;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class RespondentType {

    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function list()
    {
        return $this->_db->all('respondent_types');
    }


}