<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class PDS 
{
    private $_db,
            $_data;


    public function __construct()
    {
        $this -> _db = DB::instance(Config::get('mysql/workforcedb'));    
    }

    public function newForm($fields)
    {
        if (!$this -> _db -> insert('tpdsmaininfo',$fields)) {
            throw new \Exception("There was a problem in Creating a New PDS");
        }
    }

    public function latestID()
    {
        return $this -> _db -> lastRow('tpdsmaininfo','appno',['appno']) -> appno;
    }

    public function futureID()
    {
		return str_pad($this -> latestID() + 1, 10, "0", STR_PAD_LEFT);
    }

    public function appNumber($empno)
    {
        $sql = "SELECT appno FROM tpdsmaininfo WHERE empno = ?";
        
        return $this -> _db -> query($sql,[$empno]) -> first() -> appno;
    }

    public function findEmpNumber($empno)
    {
        $sql = "SELECT empno FROM tpdsmaininfo WHERE empno = ?";

        if ($this -> _db -> query($sql,[$empno]) -> count()) {
            return 'exists';
        }
    }

    public function save($appno,$fields = array())
    {
        if (!$this -> _db -> update('tpdsmaininfo',$appno,$fields,'appno')) {
            throw new \Exception("There was a problem in Saving a PDS DATA");
        }
    }

    public function find($empno)
    {
        $data = $this -> _db -> get('tpdsmaininfo',array('empno','=',$empno));
        
        if ($data -> count()) 
        {
            $this -> _data = $data -> first();
            return true;
        }
        
		return false;
    }

    public function data()
    {
        return $this -> _data;
    }

    public function delete($appno)
    {
        if (!$this -> _db -> delete('tpdsmaininfo',array('appno','=',$appno))) {
            throw new \Exception("There was a problem in Deleting a PDS Data");
        }
    }
    
    public function getPhysicalStatusNames()
    {
        return $this -> _db -> select(['physical_status_name'],'rphysicalstatus');
    }

    public function getEmploymentTypes()
    {
        return $this -> _db -> all('remptype');        
    }

    public function getPrefixes()
    {
        return $this -> _db -> select(['prefixdesc'],'rprefixinfo');
    }

    public function getSuffixes()
    {
        return $this -> _db -> select(['suffixdesc'],'rsuffixinfo');
    }

    public function getCareerServices()
    {
        return $this -> _db -> select(['careerservicedesc'],'rcareerservice');
    }

    public function getPositions()
    {
        return $this -> _db -> select(['posndesc','posncode'],'rposninfo');

    }

    public function getGenderPreferences()
    {
        return $this -> _db -> all('rgenderpref');
    }

    public function getSurgeryTypes()
    {
        return $this -> _db -> all('refsurgtype');
    }

    public function getOrganizationTypes()
    {
        return $this -> _db -> all('reforgtype');
    }

    public function getOrganizationOrigins()
    {
        return $this -> _db -> all('reforgorigin');
    }

    public function getOrigins()
    {
        return $this -> _db -> all('origins');
    }
}

?>