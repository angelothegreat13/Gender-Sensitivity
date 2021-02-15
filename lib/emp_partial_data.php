<?php 

require_once '../core/init.php';


if (Input::exists()) 
{   
    $employee = new Employee;
    $employee -> find(Input::get('empID'));
    $data = $employee -> data();
    
    exitJson(array(
        'evalID' => $data -> evalID,
        'empID' => $data -> empno, 
        'employeeFullName' => $data -> employeeFullName,
        'employeeType' => $data -> typedesc,
        'gender' => gender($data -> sex),
        'position' => $data -> posndesc,
        'civilStatus' => civilStatus($data -> cstatus),
        'office' => $data -> offdesc,
        'department' => ifNull($data -> deptdesc),
        'division' => ifNull($data -> divdesc),
        'section' => ifNull($data -> sectdesc),
        'photo' => pdsPicture($data -> photo,$data -> sex)
    ));  
}
else
{
    Redirect::to(404);    
}


?>