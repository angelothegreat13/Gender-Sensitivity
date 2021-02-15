<?php namespace Gender\Classes\References\Pds;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class PdsReport {

	private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/globalrefdb'));
    }


	/**
     * Total Number of Gender All (Internal)
     * Total Number of Gender All (External) 
     * Total Number of Gender All (Internal|External)
     * @param $source = source_id (Internal/External/Both)
     * @param $date_from = start date
     * @param $date_to = end date
	 */    
    public function totalNumberOfGenderBySource($source,$date_from,$date_to)
    {
        $src = '';
        $params = [$date_from,$date_to];

        if ($source != 'all') {
        	$src .= 'AND SRC = ? ';
        	$params[] = $source;
        }

    	$sql = "SELECT GENDER,COUNT(*) AS TOTAL 
				FROM (
				    SELECT tp.source_id AS SRC,tp.sex AS GENDER,tp.created_at AS DATE FROM global_ref.tpdsmaininfo tp 
				    UNION ALL
				    SELECT gs.source_id AS SRC,gs.gender AS GENDER,gs.date AS DATE FROM genderdb.guests gs 
				) pds_guest 
				WHERE DATE >= ? AND DATE <= ? {$src}
				GROUP BY GENDER";

		$data = $this->_db->query($sql,$params);

		return $data->results();
    }


    /**
     * Total Number of Gender Per Office
     * Total Number of Gender Per Department
     * Total Number of Gender Per Division
     * @param $org = get data of Office Table,Department Table or Division Table
     * @param $date_from = start date 
     * @param $date_to = end date
    */
    public function totalNumberOfGenderPerOrganization($org,$date_from,$date_to)
    {
        $select = '';
        $join = '';
        $where = '';
        $group = '';

        if ($org == 'office') {
            $select .= 'SELECT of.offcod AS OFFICE';
            $join .= 'INNER JOIN roffinfo of ON tp.office = of.offcode '; 
            $where .= 'WHERE of.deleted = 0 ';
            $group .= 'GROUP BY OFFICE';
        }
        elseif ($org == 'department') {
            $select .= 'SELECT dp.deptcod AS DEPT';
            $join .= 'INNER JOIN rdeptinfo dp ON tp.department = dp.deptcode '; 
            $where .= 'WHERE dp.deleted = 0 ';
            $group .= 'GROUP BY DEPT';
        }
        elseif ($org == 'division') {
            $select .= 'SELECT dv.divdesc AS DIVI';
            $join .= 'INNER JOIN rdivinfo dv ON tp.division = dv.divcode '; 
            $where .= 'WHERE dv.deleted = 0 ';
            $group .= 'GROUP BY DIVI';
        }

        $sql = "{$select}, 
                COUNT(CASE WHEN sex = 'Male' THEN 1 END) AS MALE_TOTAL, 
                COUNT(CASE WHEN sex = 'Female' THEN 1 END) AS FEMALE_TOTAL 
                FROM tpdsmaininfo tp 
                {$join} 
                {$where} AND tp.created_at >= ? AND tp.created_at <= ? 
                {$group}";

        $data = $this->_db->query($sql,[$date_from,$date_to]);

        return $data->results();
    }


    /**
     * Total Number of Gender (Passenger)
     * Total Number of Gender (Concessionaire) 
     * Total Number of Gender (Visitor/Walk In)
     * @param $user_type = user_type_id (Passenger/Concessionaire/Visitor/Walk In)
     * @param $date_from = start date
     * @param $date_to = end date
	 */
    public function totalNumberOfGenderByUserType($user_type,$date_from,$date_to)
    {
    	$sql = "SELECT GENDER,COUNT(*) AS TOTAL 
				FROM (
				    SELECT tp.pds_type_id AS USER_TYPE,tp.sex AS GENDER,tp.created_at AS DATE 
                    FROM global_ref.tpdsmaininfo tp 
				    UNION ALL
				    SELECT gs.user_type_id AS USER_TYPE,gs.gender AS GENDER,gs.date AS DATE 
                    FROM genderdb.guests gs 
				) pds_guest 
				WHERE USER_TYPE = ? AND DATE >= ? AND DATE <= ? 
				GROUP BY GENDER";

		$data = $this->_db->query($sql,[$user_type,$date_from,$date_to]);

		return $data->results();
    }


	/**
     * Total Number of Gender Preference All (Internal)
     * Total Number of Gender Preference All (External) 
     * Total Number of Gender Preference All (Internal|External)
     * @param $source = source_id (Internal/External/Both)
     * @param $date_from = start date
     * @param $date_to = end date
	 */
    public function totalNumberOfGenderPreferenceBySource($source,$date_from,$date_to)
    {
    	$src = '';
        $params = [$date_from,$date_to];

        if ($source != 'all') {
        	$src .= 'AND SRC = ? ';
        	$params[] = $source;
        }

    	$sql = "SELECT gp.genderdesc AS GENDERPREF,COUNT(*) AS TOTAL 
				FROM (
				    SELECT tp.source_id AS SRC, tp.genderpref AS GENDERPREF_ID, tp.created_at AS DATE FROM global_ref.tpdsmaininfo tp 
				    UNION ALL
				    SELECT gs.source_id AS SRC, gs.genderpref AS GENDERPREF_ID, gs.date AS DATE FROM genderdb.guests gs 
				) pds_guest 
				INNER JOIN global_ref.rgenderpref gp ON GENDERPREF_ID = gp.id 
				WHERE DATE >= ? AND DATE <= ? {$src}
				GROUP BY GENDERPREF";

		$data = $this->_db->query($sql,$params);

		return $data->results();
    }


    /**
     * Total Number of Gender Preference (Passenger)
     * Total Number of Gender Preference (Concessionaire) 
     * Total Number of Gender Preference (Visitor/Walk In)
     * @param $user_type = user_type_id (Passenger/Concessionaire/Visitor/Walk In)
     * @param $date_from = start date
     * @param $date_to = end date
	 */
    public function totalNumberOfGenderPreferenceByUserType($user_type,$date_from,$date_to)
    {
    	$sql = "SELECT gp.genderdesc AS GENDERPREF,COUNT(*) AS TOTAL 
				FROM (
				    SELECT tp.pds_type_id AS USER_TYPE, tp.genderpref AS GENDERPREF_ID, tp.created_at AS DATE FROM global_ref.tpdsmaininfo tp 
				    UNION ALL
				    SELECT gs.user_type_id AS USER_TYPE, gs.genderpref AS GENDERPREF_ID, gs.date AS DATE FROM genderdb.guests gs 
				) pds_guest 
				INNER JOIN global_ref.rgenderpref gp ON GENDERPREF_ID = gp.id 
				WHERE USER_TYPE = ? AND DATE >= ? AND DATE <= ? 
				GROUP BY GENDERPREF";

		$data = $this->_db->query($sql,[$user_type,$date_from,$date_to]);

		return $data->results();
    }


    /**
     * Total Number of Gender Preference Per Office
     * Total Number of Gender Preference Per Department
     * Total NUmber of Gender Preference Per Division
     * @param $org = get data of Office Table,Department Table or Division Table
     * @param $date_from = start date
     * @param $date_to = end date
    */
    public function totalNumberOfGenderPreferenceByOrganization($org,$date_from,$date_to)
    {
        $select = '';
        $join = '';
        $where = '';
        $group = '';

        if ($org == 'office') {
            $select .= 'SELECT of.offcod AS OFFICE';
            $join .= 'INNER JOIN roffinfo of ON tp.office = of.offcode '; 
            $where .= 'WHERE of.deleted = 0 ';
            $group .= 'GROUP BY OFFICE';
        }
        elseif ($org == 'department') {
            $select .= 'SELECT dp.deptcod AS DEPT';
            $join .= 'INNER JOIN rdeptinfo dp ON tp.department = dp.deptcode '; 
            $where .= 'WHERE dp.deleted = 0 ';
            $group .= 'GROUP BY DEPT';
        }
        elseif ($org == 'division') {
            $select .= 'SELECT dv.divdesc AS DIVI';
            $join .= 'INNER JOIN rdivinfo dv ON tp.division = dv.divcode '; 
            $where .= 'WHERE dv.deleted = 0 ';
            $group .= 'GROUP BY DIVI';
        }

        $sql = "{$select}, 
                COUNT(CASE WHEN genderpref = 1 THEN 1 END) AS MASCULINE_TOTAL, 
                COUNT(CASE WHEN genderpref = 2 THEN 1 END) AS FEMININE_TOTAL, 
                COUNT(CASE WHEN genderpref = 3 THEN 1 END) AS GAY_TOTAL, 
                COUNT(CASE WHEN genderpref = 4 THEN 1 END) AS LESBIAN_TOTAL, 
                COUNT(CASE WHEN genderpref = 5 THEN 1 END) AS BI_TOTAL, 
                COUNT(CASE WHEN genderpref = 6 THEN 1 END) AS TRANS_TOTAL, 
                COUNT(CASE WHEN genderpref = 7 THEN 1 END) AS QUEER_TOTAL, 
                COUNT(CASE WHEN genderpref = 8 THEN 1 END) AS QUESTIONING_TOTAL, 
                COUNT(CASE WHEN genderpref = 9 THEN 1 END) AS INTERSEX_TOTAL, 
                COUNT(CASE WHEN genderpref = 10 THEN 1 END) AS ASEXUAL_TOTAL,
                COUNT(CASE WHEN genderpref = 11 THEN 1 END) AS ALLY_TOTAL, 
                COUNT(CASE WHEN genderpref = 12 THEN 1 END) AS PANSEXUAL_TOTAL 
                FROM tpdsmaininfo tp 
                {$join} 
                {$where} AND tp.created_at >= ? AND tp.created_at <= ? 
                {$group}";

        $data = $this->_db->query($sql,[$date_from,$date_to]);

        return $data->results();
    }


    // SELECT of.offcod AS OFFICE,gp.genderdesc AS GENDER_PREF,COUNT(*) AS TOTAL  
    // FROM tpdsmaininfo tp 
    // INNER JOIN roffinfo of ON tp.office = of.offcode 
    // INNER JOIN rgenderpref gp ON tp.genderpref = gp.id 
    // GROUP BY OFFICE,GENDER_PREF

}