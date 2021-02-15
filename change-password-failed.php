<?php 
    define('rootmain','http://'.$_SERVER['HTTP_HOST']);
    define('rootpathphp',$_SERVER['DOCUMENT_ROOT'].'/miaa/module/evaluate');
    define('rootpath','http://'.$_SERVER['HTTP_HOST'].'/miaa/module/evaluate');
    session_start(); 
    require_once(rootpathphp.'/auth.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo 'Evaluate Password Change'; ?></title>

<link href="../../assets/css/dropdown/dropdown_evaluation/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../../assets/css/dropdown/dropdown_evaluation/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../assets/css/main-evaluation-style.css" type="text/css" />
<link rel="stylesheet" href="../../assets/css/form-css/validationEngine.jquery.css" type="text/css" />

<script type="text/javascript" src="../../assets/js/form-script/jquery-1.6.min.js"></script>
<script type="text/javascript" src="../../assets/js/form-script/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../../assets/js/form-script/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="../../assets/js/form-script/formnamescript.js"></script>

</head>

<body>
		<div id="main-containers">
        		<div id="heading">
                		<?php include_once rootpathphp.'/lib/menu.php'; ?>
                <!-- START WRAPPERS -->
                <div id="wrapper">
                		<div id="form-login">
                        		<div id="form-left">
                                		<div id="img-acumen"><!-- IMG ACUMENT --></div>
                                        <div id="img-systems"><!-- IMG SYSTEMS --></div>
                                </div>
                                <div id="form-right">
										<div id="login-error">
                                        	<span style="font-size:13px; color:black; text-transform:none;">The current password you've entered is incorrect. Please enter a different password.</span> <span><a style="color:red; font-size:13px; text-transform:none;" href="change-password.php">Try Again</a></span>
                                        </div>
                                </div>
                        </div>
                </div>
                <!-- END WRAPPERS -->
        </div>
</body>
</html>