<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{   
    if (isset($_POST["view_pds_btn"]) && isset($_POST['empno']) != '') 
    {   
       $empno = htmlentities($_POST['empno'],ENT_QUOTES,'UTF-8');
       include_once 'includes/pds/show.php';
    }
    elseif (isset($_POST["add_pds_btn"])) 
    {
       include_once 'includes/pds/create.php';
    }
    elseif (isset($_POST['edit_pds_btn']) && isset($_POST['empno']) != '')
    {  
       $empno = htmlentities($_POST['empno'],ENT_QUOTES,'UTF-8');
       include_once 'includes/pds/edit.php';
    }
    elseif (isset($_POST['delete_pds_btn']) && isset($_POST['empno']) != '') 
    {
       $empno = htmlentities($_POST['empno'],ENT_QUOTES,'UTF-8');
       include_once 'includes/pds/delete.php';
    }
    else {
        header('Location: pds_list.php');
    }
}
else {
    header('Location: includes/errors/404.php');
}


?>