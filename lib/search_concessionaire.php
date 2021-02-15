<?php 
require_once '../core/init.php';

use Gender\Classes\Concessionaire;

use Gender\Classes\Supports\Input;

$concessionaire = new Concessionaire;

$num_of_records = 30;

$page_num = page_number(Input::get('page'));

$offset = ($page_num - 1) * $num_of_records;

$search = Input::get('q');

$concessionaires = $concessionaire->search($offset,$num_of_records,$search);

$total_count = $concessionaire->totalSearchedWithoutLimit($search);

exitJson([
    'total_count' => $total_count,
    'items' => $concessionaires
]);