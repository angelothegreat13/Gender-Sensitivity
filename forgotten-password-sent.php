<?php
$contact_email = $_POST['email'];

if($contact_name == true) {
	$sender = $contact_email;
	$receiver = "digitscorporation@gmail.com, digitscorporation@yahoo.com";
	$client_ip = $_SERVER['REMOTE_ADDR'];
	$email_body = " 
					\nFull name: $contact_name
					\nEmail: $sender
					\nClient email: $contact_email
					\nIP: $client_ip 
					\nProvided by DIGITS";
					
	$extra = "From: $sender\r\n" . "Reply-To: $sender \r\n" . "X-Mailer: PHP/" . phpversion();

	if(mail($receiver, "DIGITS - Forgotten Reset Password - $contact_organization", $email_body, $extra))  {
		//echo "success=yes";
	}
	else {
		//echo "success=no";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo 'Gender Forgotten Password Sent'; ?></title>

<link href="../../assets/css/dropdown/dropdown_trail/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../../assets/css/dropdown/dropdown_trail/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../assets/css/main-trail-style.css" type="text/css" />
<link rel="stylesheet" href="../../assets/css/form-css/validationEngine.jquery.css" type="text/css" />

<script type="text/javascript" src="../../assets/js/form-script/jquery-1.6.min.js"></script>
<script type="text/javascript" src="../../assets/js/form-script/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../../assets/js/form-script/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="../../assets/js/form-script/formnamescript.js"></script>

</head>

<body>
		<div id="main-containers">
        		<div id="heading">
                		<div id="logo"><img src="../../assets/images/logo_trail.png" border="0" align="logo" title="logo" /></div>
                        <div id="logo-acumen"><img src="../../assets/images/miaa_logo.png" border="0" alt="logo acumen" title="logo acumen" /></div>
                            <div id="tanuan-lgu">
                                 
                                 <div id="borders"><!-- BORDERS --></div>
                                 
                            </div>
                </div>
                <!-- START WRAPPERS -->
                <div id="wrapper">
                		<div id="form-login">
                        		<div id="form-left">
                                		<div id="img-acumen"><!-- IMG ACUMENT --></div>
                                        <div id="img-systems"><!-- IMG SYSTEMS --></div>
                                </div>
                                <div id="form-right">
                                        <div id="login-error">
                                            Email Sent
                                            <p>Check your email to reset your password <a href="login.php">Go back to Login</a></p>
                                        </div>
                                </div>
                        </div>
                </div>
                <!-- END WRAPPERS -->
        </div>
</body>
</html>