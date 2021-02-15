<?php 

require_once '../core/init.php';

if (Input::exists()) {   
    $personImg = new PdsImage;
    $personImg -> download(Input::get('app_number'),Input::get('data'),'person_images');
    
    exitJson(array(
        'status' => 'success',
        'imgURL' => '/miaa/assets/images/pds/person_images/'.imgURL($personImg -> file())
    ));
}

Redirect::to(404);    

?>