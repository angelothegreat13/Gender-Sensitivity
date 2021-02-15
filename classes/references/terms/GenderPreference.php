<?php 

namespace App\Models\Partials;

use Core\Model;
use Supports\Config;

class GenderPreference extends Model
{
	
	public function __construct()
	{
		parent::__construct(Config::get('mysql/workforcedb'));
	}

	public function lists()
    {
        return $this -> _db -> all('rgenderpref');
    }

}


