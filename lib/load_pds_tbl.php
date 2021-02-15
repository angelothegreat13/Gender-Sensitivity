<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\References\Pds\PdsTable;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$search = sanitize($_POST['search']['value']);
    $col_num = sanitize($_POST['order']['0']['column']); 
    $sort = sanitize($_POST['order']['0']['dir']); 
    $start = sanitize($_POST['start']);
    $length = sanitize($_POST['length']);
    $sql = "";

    $col = [
        0   =>  'pds_id',
        1   =>  'pds_id',
        3   =>  'full_name',
        4   =>  'pds_type',
        5   =>  'pds_status',
        6   =>  'created_at',
    ];  
    
    if (isset($search)) {
        $sql .= "pds.id = ? ";
        $sql .= "OR CONCAT(pds.prefix,' ',pds.fname,' ',pds.lname,' ',pds.suffix) LIKE CONCAT('%',?,'%') ";
        $sql .= "OR pds.created_at LIKE CONCAT('%',?,'%') ";
        $sql .= "OR pds.pds_type_id LIKE CONCAT('%',?,'%') ";
        $sql .= "OR pds.status = ? ";
    }

    $sql .= "ORDER BY {$col[$col_num]} {$sort} ";

    if (Input::get('length') != -1) {
        $sql .= "LIMIT {$start},{$length}";
    }

    $pds_tbl = new PdsTable;
    $pds_tbl->setTable($sql,$search);

    $output = [
        "draw"            =>  intval(Input::get("draw")),
        "recordsTotal"    =>  intval($pds_tbl->getTotalTblFiltered()),
        "recordsFiltered" =>  intval($pds_tbl->totalData()),
        "data"            =>  $pds_tbl->getTableHTML()
    ];  

    exitJson($output);

}