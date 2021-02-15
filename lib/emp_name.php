<?php 
require_once '../core/init.php';

use Gender\Classes\Employee;
use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;

if (Input::exists()) 
{   
    $employee = new Employee;
    $employee -> findName(Input::get('employeeId'));
    $data = $employee -> name();
    
    exitJson([
        'employeeID' => $data -> empno,
        'lastname' => $data -> lname,
        'firstname' => $data -> fname,
        'middlename' => $data -> mname,
        'suffix' => $data -> suffix
    ]);
}
else {
    Redirect::to(404);
}

?>