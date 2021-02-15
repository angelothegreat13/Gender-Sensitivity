<?php 

use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Pkcs7;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

use Carbon\Carbon;

use Gender\Classes\GuestSession;

function sanitize($dirty)
{
    return htmlentities(trim($dirty),ENT_QUOTES,'UTF-8');
}

function pretty_date($date)
{
    return Carbon::parse($date)->format('M d, Y h:i A');
}

function dateNow()
{
    return date("Y-m-d H:i:s");
}

function refresh()
{
    header("Refresh:0");
}

function varDumpJson($string)
{
    var_dump(json_encode($string));
}

function exitJson($data)
{
    exit(json_encode($data));
}

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function if_empty_org($origin)
{
    if ($origin == '') {
        return str_replace("Office of the", "", $_SESSION['complete_office']);
    }
    else {
        return $origin;
    }
}

function ifNull($data)
{   
    return ($data == NULL) ? '' : $data ;
}

function none($data)
{   
    return ($data == NULL || $data == "") ? "None" : $data;
}

function createOBJ(array $properties)
{
    $object = new stdClass;
 
    foreach ($properties as $property => $values) {
         $object -> $property = $values;
    }

    return $object;
}

function redirect_to_404()
{
    header('Location: includes/errors/404.php');
}

function deny_user_if_not_authenticated()
{
    if (!Session::exists('SESS_GENDER_USER_ID') || trim(Session::get('SESS_GENDER_USER_ID')) == '') {
        Redirect::to('access-denied');
		exit();
    }
}

function deny_guest_if_not_authenticated()
{
    if (!Session::exists('SESS_GENDER_GUEST_CODE') || trim(Session::get('SESS_GENDER_GUEST_CODE')) == '') {
        Redirect::to('guest-form');
		exit();
    }
}

function anonymous($data)
{
    return ($data == NULL || $data == '') ? 'Anonymous' : ucwords($data);
}

function gender($gender)
{
    return($gender == 1) ? 'Male' : 'Female' ;
}

function selected($data,$list)
{
    echo $data == $list ? ' selected="selected" ' : '';
}

function personImage($image,$gender)
{
    if (empty($image) && $gender == 1) {
        return '/miaa/assets/images/employees/male_avatar.svg';
    }
    elseif (empty($image) && $gender == 0) {
        return '/miaa/assets/images/employees/female_avatar.svg';
    }
    else {
        return $image;
    }
}

function orgImage($org_pic)
{
    return ($org_pic == "") ? '/miaa/assets/images/hierarchy.svg' : $org_pic ;
}

function imgURL($path)
{
    $pathArray = explode("/",$path);
    return end($pathArray);
}

function calculateAge($bday)
{   
    if ($bday == '0000-00-00') {
        return 0;
    }
    else {
        $from = new DateTime($bday);
        $to   = new DateTime('today');
        return $from->diff($to)->y;
    }
}

function pretty_success($msg)
{   
    $output ="";
    $output .="<div class='alert alert-success' role='alert' id='success-alert'>";
    $output .="<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
               </button>";
    $output .="<i class='fa fa-info-circle' aria-hidden='true'></i> ";
    $output .="<strong>".$msg."</strong>";          
    $output .="</div>";
    
    return  $output;
}

function pretty_errors($err)
{   
    $errors[] = $err;
    $output ="";
    
    $output .="<div class='alert alert-danger' role='alert' id='errors-alert'>";
    $output .="<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
               </button>";

    if (count($errors) === 1) {
        $output .="<label class='text-danger'><i class='fas fa-exclamation-triangle'></i>&nbsp; ". $errors[0]." </label>";
    }
    else {
        foreach ($errors as $error) {
            $output .="<li>".$error."</li>";        
        }  
    }
    $output .="</div>";
    
    return $output;
}

/*
* $pattern = /\s+/ (space)
* $string = string need to convert
*/
function snake_case_string($pattern,$string)
{
    return strtolower(preg_replace($pattern,'_',$string));
}

/*
* $string = string need to convert
*/
function camelCaseString($string)
{
    return lcfirst(preg_replace('/\s+/', '', ucwords($string)));
}


function csrf_field()
{   
    $key = Key::createNewRandomKey();
    $secret_key = "4PY8,r>+%&;=&U9`LDtGR+Q6D)q@bH.eZS5kaU%VHtph$.K!6aft(ywLg87ZvL)L";

    if (!Session::exists('GENDER_CSRF_TOKEN')) {
        Session::put('GENDER_CSRF_TOKEN',Crypto::encrypt($secret_key,$key));
    }

    return Session::get('GENDER_CSRF_TOKEN');
}

function csrf_protection()
{
    if (csrf_field() !== Input::get('token')) {
        Redirect::to(404);
    }
}

// netstat -ie in Linux
// ipconfig /all in Windows
function getMacAdd(){
	ob_start();
	system('ipconfig /all');
	$mycom=ob_get_contents();
	ob_clean();
	$findme = "Physical";
	$pmac = strpos($mycom, $findme);
	$mac=substr($mycom,($pmac+36),17);
	$macAdd = preg_replace('/[^a-zA-Z0-9]/', '',$mac);
	return $macAdd;
}

function getMacLinux() {
  exec('netstat -ie', $result);
   if(is_array($result)) {
    $iface = array();
    foreach($result as $key => $line) {
      if($key > 0) {
        $tmp = str_replace(" ", "", substr($line, 0, 10));
        if($tmp <> "") {
          $macpos = strpos($line, "HWaddr");
          if($macpos !== false) {
            $iface[] = array('iface' => $tmp, 'mac' => strtolower(substr($line, $macpos+7, 17)));
          }
        }
      }
    }
    return $iface[0]['mac'];
  } else {
    return "notfound";
  }
}

function get_client_ip_web_host() {
    $ipaddress = '';
    
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

function get_client_ip_local_host() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

function get_ip_address()
{
    if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1','::1'])) {
        return get_client_ip_local_host();
    }

    return get_client_ip_web_host();
}

function get_platform() 
{ 
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform  = "Unknown OS Platform";

    $os_array = [
        '/windows nt 10/i'      =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    ];

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function get_user_browser()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $browser = "Unknown Browser";

    $browser_array = [
        '/msie|trident/i' => 'Internet Explorer',
        '/firefox/i'   => 'Firefox',
        '/safari/i'    => 'Safari',
        '/chrome/i'    => 'Chrome',
        '/edge/i'      => 'Edge',
        '/opera/i'     => 'Opera',
        '/netscape/i'  => 'Netscape',
        '/maxthon/i'   => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i'    => 'Handheld Browser'
    ];

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}

function session_destroy_forever()
{
    // Initialize the session.
    // If you are using session_name("something"), don't forget it now!

    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
}

function get_session($session_name) {
    if (Session::exists($session_name)) {
		return Session::get($session_name);
	}
}

function check_referer_header() 
{
    header('Content-Type: application/json');
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        $address = 'http://' . $_SERVER['SERVER_NAME'];
        if (strpos($address, $_SERVER['HTTP_ORIGIN']) !== 0) {
            Redirect::to('access-denied');
        }
    } else {
        Redirect::to('access-denied');
    }
}

function if_null($data,$str)
{
    return ($data == NULL || $data == "") ? $str : $data;
}

// use this when the request is json encoded
function request($name)
{
    $posts = file_get_contents("php://input");
    $post = json_decode($posts, true);    

    return sanitize($post[$name]);
}

function validate_session($session_name)
{
    if (Session::exists($session_name) && Session::get($session_name) != NULL) {
        return true;
    }

    return false;
}

/*
@param $data = $this->_db->query() || $this->_db->get()
@return false if not count
*/
function check($data)
{
    if (!$data->count()) {
        return false;
    }
}

function logout_date($date)
{
    return ($date != NULL) ?  pretty_date($date) : '' ;
}

/**
 * @param $string = string that need to encrypt
*/
function encrypt_url($string) 
{
    $data = base64_encode($string);
    
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    
    return $data;
}

/**
 * @param $string = string that need to decrypt
*/
function decrypt_url($string) 
{
    $data = str_replace(array('-','_'),array('+','/'),$string);
    
    $mod4 = strlen($data) % 4;
    
    if ($mod4) {
        $data .= substr('====', $mod4);
    }

    return base64_decode($data);
}

function auth_guard($type = 'user')
{
    $guest_session = new GuestSession;

    switch ($type) {

        // Only User can access
        case 'user':

            if (!validate_session('SESS_GENDER_USER_ID')) {
                Redirect::to('login');
            }

        break;

        // Only Guest can access
        case 'guest':

            if (!$guest_session->exists(get_session('SESS_GENDER_GUEST_CODE'))) {
                Redirect::to('login');
            }

        break;

        // User and Guest can access
        case 'user|guest':

            if (!$guest_session->exists(get_session('SESS_GENDER_GUEST_CODE')) && !validate_session('SESS_GENDER_USER_ID')) {
                Redirect::to('login');    
            }

        break;

        // Restrict User And Guest if authenticated
        case 'restrict':

            if (validate_session('SESS_GENDER_USER_ID')) {
                Redirect::to('dashboard');
            }    
            
            if ($guest_session->exists(get_session('SESS_GENDER_GUEST_CODE'))) {
                Redirect::to('surveys/survey-form');
            }

        break;
    }
} 

function array_to_string_with_comma(array $array)
{
    $string = '';

    foreach ($array as $value) {
        $string .= "'".$value."',";
    }

    $string =  rtrim($string,',');

    return $string;
}

function download_img($data,$loc)
{
    if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) 
    {
        $data = substr($data, strpos($data, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif

        if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
            throw new \Exception('invalid image type');
        }

        $data = base64_decode($data);

        if ($data === false) {
            throw new \Exception('base64_decode failed');
        }
    } 
    else {
        throw new \Exception('did not match data URI with image data');
    }

    $path = $loc.".{$type}";

    file_put_contents(DR.$path,$data);

    return $path;
}

function upload_image()
{

}

function post($item) {   
    return sanitize($_POST[$item]);
}   

function get($item) {
    return sanitize($_GET[$item]);
}

function avatar($img,$gender)
{
    if (empty($img) && $gender == "Male") {
        return IMAGES.'manbrown.svg';
    }
    elseif (empty($img) && $gender == "Female") {
        return  IMAGES.'womanblue.svg';
    }
    else {
        return $img;
    }
}

function id_type_label($user_type)
{
    switch ($user_type) {
        
        case '1':

        break;
        
        case '2':

        break;

        case '3':

        break;

        case '4':

        break;
    }
}

function label_status($status) {
    $label = '';
    $text = '';
    
    if ($status == 0) { 
        $label.= 'success'; 
        $text .= 'Active';
    }
    elseif ($status == 1) { 
        $label .= 'danger'; 
        $text .= 'Inactive';
    }

    return "<span class='label label-".$label."'>".$text."</span>";
} 


function status_to_num($status)
{
    if ($status == strtolower('active')) {
        return 0;
    }
    elseif ($status == strtolower('inactive')) {
        return 1;
    }
}

function pretty_status($status)
{
    return ($status == 'Active') ? 'success' : 'danger' ;
}













