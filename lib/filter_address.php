<?php 
require_once '../core/init.php';


if (Input::exists()) 
{
    $address = new Address;
    $output = "";
    
    switch (Input::get('mode')) 
    {   
        case 'getProv':
            $output .= "<option value=''>Province</option>";
            foreach ($address -> getProvinces(Input::get('regionId')) as $province) {
                $output .= "<option value='".$province -> provCode."'>".$province -> provDesc."</option>";
            }
            exit($output);
        break;

        case 'getMun':
            $output .= "<option value=''>Municipality</option>";
            foreach ($address -> getMunicipalities(Input::get('regionId'),Input::get('provinceId')) as $municipality) {
                $output .= "<option value='".$municipality -> cityMunCode."'>".$municipality -> cityMunDesc."</option>";
            }
            exit($output);
        break;

        case 'getBrgy':
            $output .= "<option value=''>Barangay</option>";
            foreach ($address -> getBarangays(Input::get('regionId'),Input::get('provinceId'),Input::get('municipalityId')) as $barangay) {
                $output .= "<option value='".$barangay -> brgyCode."'>".$barangay -> brgyDesc."</option>";
            }
            exit($output);            
        break;
        
        default:
            Redirect::to(404);
        break;
    }
}
else {
    Redirect::to(404);
}

?>