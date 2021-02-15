<?php 
require_once '../core/init.php';

use Gender\Classes\Employee;

use Gender\Classes\Supports\Input;

$employee = new Employee;

$num_of_records = 30;

$page_num = page_number(Input::get('page'));

$offset = ($page_num - 1) * $num_of_records;

$search = Input::get('q');

$employees = $employee->search($offset,$num_of_records,$search);

$total_count = $employee->totalSearchedWithoutLimit($search);

exitJson([
    'total_count' => $total_count,
    'items' => $employees
]);

