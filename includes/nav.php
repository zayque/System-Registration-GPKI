<style>
.responsive {
    width: 15%;
    height: auto;
    margin-left: 13%;
    border-radius: 100px;
}

.active_nav{
    background-color: #535151;
    border-radius: 10px;
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <!-- <a class="navbar-brand" href="OM_Dashboard.php"> </a> -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <img src="img/logo3.png" class="responsive">
    <?php

        $url=trim(substr($_SERVER['REQUEST_URI'], 10));  

    ?>

        <br><br>
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <br><br>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link <?php if($url=="dashboard.php" || $url=="dashboardseminar.php" ) echo "active_nav"; ?>"  href="dashboard.php">
                    <h5><i class="fa fa-home" aria-hidden="true"></i>
                        <span class="nav-link-text"> Home</span>
                    </h5>
                </a>
     
            <a class="nav-link <?php if($url=="maklumatlatihan.php") echo "active_nav"; ?>"  href="maklumatlatihan.php">
                <h5><i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span class="nav-link-text"> Latihan</span>
                </h5>
            </a>
            <a class="nav-link <?php if($url=="maklumatseminar.php") echo "active_nav"; ?>" href="maklumatseminar.php">
                <h5><i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span class="nav-link-text"> Seminar</span>
                </h5>
            </a>
            <a class="nav-link <?php if($url=="perananagensi.php" || $url=="perananagensiseminar.php" ) echo "active_nav"; ?>"  href="perananagensi.php">
                <h5><i class="fa fa-desktop" aria-hidden="true"></i>
                    <span class="nav-link-text"> Agensi & ICT</span>
                </h5>
            </a>
            <a class="nav-link <?php if($url=="absent.php") echo "active_nav"; ?>" href="absent.php">
                <h5><i class="fa fa-desktop" aria-hidden="true"></i>
                    <span class="nav-link-text"> Absent</span>
                </h5>
            </a>
            <a class="nav-link <?php if($url=="maklumatemail.php") echo "active_nav"; ?>" href="maklumatemail.php">
                <h5><i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <span class="nav-link-text"> E-mel</span>
                </h5>
            </a>
            </li>

        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="adminsignup.php">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>