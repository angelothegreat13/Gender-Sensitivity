<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class PdsMain {

    private $_db;
    
    private $_data;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }

    public function list()
    {
        $sql = "SELECT pds.*, ut.user_typedesc AS pds_type  
                FROM tpdsmaininfo pds 
                INNER JOIN ref_usertype ut ON pds.pds_type_id = ut.id 
                ORDER BY pds.id DESC";

        return $this->_db->query($sql)->results();
    }

    public function save($fields)
	{
		if (!$this->_db->insert('tpdsmaininfo',$fields)) {
            throw new \Exception("There was a problem in Saving a PDS");
        }
    }

    public function update($id,$fields)
    {
        if (!$this->_db->update('tpdsmaininfo',$id,$fields,'id')) {
            throw new \Exception("There was a problem in Updating a PDS");
        }
    }

    public function delete($id)
    {
        if (!$this->_db->softDelete('tpdsmaininfo',['id','=',$id],'status')) {
            throw new \Exception("There was a problem in Deleting a PDS");
        }
    }

    public function restore($id)
    {
        $this->update($id,['status' => 0]);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM tpdsmaininfo WHERE id = ? AND status = 0";

        $data = $this->_db->query($sql,[$id]);
        
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

    public function latestID()
    {
        return $this->_db->lastID();
    }

    public function alreadyExists($id_type,$id)
    {
        $sql = "SELECT * 
                FROM tpdsmaininfo 
                WHERE {$id_type} = ? AND {$id_type} <> '' ";

        if (!$this->_db->query($sql,[$id])->count()) {
            return false;
        }

        return true;
    }

    public function saveImage($img,$id)
    {
        if ($img !== '') 
        {
            $loc = IMAGES.'pds/person_images'.DS.md5($id);

            $this->update($id,[
                'photo' => download_img($img,$loc)
            ]);
        }
    }

    /**
    * @param uniqueCol = unique column name of table
    * @param uniqueColVal = unique column value
    * @param idCol = column id 
    * @param idVal = id value
    */
    public function inputIsUnique($uniqueCol,$uniqueColVal,$idCol = null,$idVal = null)
    {
        $sql = "SELECT * FROM tpdsmaininfo WHERE ";
        $params = [];

        if (!$idVal) {
            $sql .= "{$uniqueCol} = ?";            
            $params = [$uniqueColVal];
        }
        else {
            $sql .= "{$idCol} <> ? AND {$uniqueCol} = ?";
            $params = [$idVal,$uniqueColVal];
        }

        if ($this->_db->query($sql,$params)->count()) {
            return false;
        }

        return true;
    }
	

}

