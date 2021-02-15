<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Category
{
    private $_db;

    public function __construct()
    {
        $this -> _db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function list()
    {
        $data = $this->_db->get('refsurveycateg',['deleted','=',0]);

        if (!$data->count()) {
            return [];
        }

        return $data->results();
    }

}

?>