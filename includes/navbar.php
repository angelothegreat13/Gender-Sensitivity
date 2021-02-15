<header>
    <img alt="logo" src="<?=IMAGES;?>gender_banner.png" class="header-logo">
    <img alt="logo" src="<?=IMAGES;?>miaa_logo.png" class="header-miaa pull-right">
</header>

<nav class="navbar navbar-default nav-marg" role="navigation">
    
    <?php if (validate_session('SESS_GENDER_GUEST_ID')) :?>
    <a class="navbar-brand guest-nav-brand" href="#">
        Gender Sensitivity System <i class="fas fa-venus-mars"></i>
    </a>
    <?php endif;?>
    
    <?php if (validate_session('SESS_GENDER_USER_ID')) :?>

    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        
        <a href="<?=MODULE_URL;?>dashboard.php" class="navbar-brand gender-nav-brand">
            Gender Sensitivity <i class="fas fa-venus-mars"></i>
        </a>
    </div>

    <div class="collapse navbar-collapse navbar-collapse">

        <ul class="nav navbar-nav">
            <li><a href="<?=MODULE_URL;?>dashboard.php"><i class="fas fa-tachometer-alt"></i>&nbsp; Dashboard</a></li>
            <li><a href="<?=MODULE_URL;?>guidelines.php"><i class="fas fa-chalkboard-teacher"></i>&nbsp; Guidelines</a></li>
            <li><a href="<?=MODULE_URL;?>surveys/surveys-list.php"><i class="fab fa-wpforms"></i>&nbsp; Survey</a></li>
            <li><a href="<?=MODULE_URL;?>reports-generator.php"><i class="fas fa-chart-area"></i>&nbsp; Reports</a></li>
            <li><a href="<?=MODULE_URL;?>pds/pds-list.php"><i class="far fa-id-card"></i>&nbsp; PDS</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-hands-helping"></i>&nbsp; Help <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#">How to use Gender Sensitivity System</a></li>
                    <li><a href="#">About Gender Sensitivity</a></li>
                </ul>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> WELCOME <?=get_session('SESS_GENDER_USERNAME');?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?=MODULE_URL;?>account-information.php">Account Information</a></li>
                    <li><a href="<?=MODULE_URL;?>change-password.php">Change Password</a></li>
                    <li><a href="<?=MODULE_URL;?>login-history.php">Login History</a></li>
                    <li><a href="<?=MODULE_URL;?>logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    
    <?php endif;?>

    </div>
    
</nav>

