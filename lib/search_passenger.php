<?php 
require_once '../core/init.php';

use Gender\Classes\Passenger;

use Gender\Classes\Supports\Input;

$passenger = new Passenger;

$num_of_records = 30;

$page_num = page_number(Input::get('page'));

$offset = ($page_num - 1) * $num_of_records;

$search = Input::get('q');

$passengers = $passenger->search($offset,$num_of_records,$search);

$total_count = $passenger->totalSearchedWithoutLimit($search);

exitJson([
    'total_count' => $total_count,
    'items' => $passengers
]);