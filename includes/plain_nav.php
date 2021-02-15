<header>
    <img alt="logo" src="<?=IMAGES;?>gender_banner.png" class="header-logo">
    <img alt="logo" src="<?=IMAGES;?>miaa_logo.png" class="header-miaa pull-right">
</header>

<nav class="navbar navbar-default nav-marg" role="navigation">
    
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="<?=SITE_URL;?>" class="navbar-brand miaa-brand">MANILA INTERNATIONAL AIRPORT AUTHORITY&nbsp; <i class="fa fa-home"></i></a>
        <a href="<?=SITE_URL;?>" class="navbar-brand miaa-home">MIAA <i class="fa fa-home"></i></a>
    </div>

    <div class="collapse navbar-collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">USER <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?=MODULE_URL;?>login.php">User Login</a></li>
                    <li><a href="<?=MODULE_URL;?>guest-form.php">Login as a Guest</a></li>
                    <li><a href="#">Forgot your Password?</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">SYSTEMS LOGIN <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?=MODULE;?>archive">Archive</a></li>
                    <li><a href="<?=MODULE;?>trail">Trail</a></li>
                    <li><a href="<?=MODULE;?>evaluate">Evaluate</a></li>
                    <li><a href="<?=MODULE;?>settings">Settings</a></li>
                    <li><a href="<?=MODULE;?>tools">Tools</a></li>
                    <li><a href="<?=MODULE;?>executive">Executive</a></li>
                </ul>
            </li>
        </ul>
    </div>
    
</nav>