<?php 
require_once '../core/init.php';

use Gender\Classes\Visitor;

use Gender\Classes\Supports\Input;

$visitor = new Visitor;

$num_of_records = 30;

$page_num = page_number(Input::get('page'));

$offset = ($page_num - 1) * $num_of_records;

$search = Input::get('q');

$visitors = $visitor->search($offset,$num_of_records,$search);

$total_count = $visitor->totalSearchedWithoutLimit($search);

exitJson([
    'total_count' => $total_count,
    'items' => $visitors
]);