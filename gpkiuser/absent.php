<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>GPKI Event</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">

</head>
<style>
   .active_nav:hover{
        background-color:#3d85c6;
        opacity: 50px;
        border-radius: 30px;
    }


  
</style>

<!-- body -->

<body class="about_page">
    <div class="header_main">
        <div class="container">
            <div class="logo"><a href="index.html"><img src="images/mampu.jpg" style="border-radius:10px;"></a></div>
        </div>
    </div>
    </div>
    <div class="header">
        <div class="container">
            <!--  header inner -->
            <div class="col-sm-12">

                <div class="menu-area">
                    <nav class="navbar navbar-expand-lg ">
                        <!-- <a class="navbar-brand" href="#">Menu</a> -->
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">

                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link active_nav" href="index.php">HOME<span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="training.php">TRAINING</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="seminar.php">SEMINAR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="check.php">CHECK</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="absent.php" style="color:#6fa8dc;">ABSENT</a>
                                </li>
                                <li class="nav-item" href="#">
                                    <a class="nav-link active_nav" href="contact.php">CONTACT US</a>
                                </li>
                                <li class="nav-item">
                            </ul>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end header end -->
    <!--services start -->
    <div class="about_main">
        <div class="services_main">
            <div class="container">
                <div class="creative_taital">
                    <h1 class="creative_text">Absent Details</h1> <br>
                    <center>
                        <form action="absent-func.php" method="post">
                            <div class="form-group">
                                <label style="color:blue">Sila masukkan MyKad dan Sebab kenapa anda tidak
                                    hadir..</label>
                                <input type="text" name="mykad1" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="MyKad">
                                <br>
                                <textarea name="comment1" class="form-control" rows="4" cols="50" placeholder="Sebab.."></textarea>
                                
                                </textarea>
                            </div>
                            <br>
                            <button type="submit" name="submit" class="btn btn-primary">Hantar</button>
                        </form>
                    </center>
                    <br><br><br><br><br><br><br>
                    <!-- <div class="img_version_2"><img src="images/c.png"></div> -->

                    <!-- <div class="btn_main">
    			    <button type="button" class="btn btn-dark btn-lg">Get started</button>
    		    </div> -->
                </div>
            </div>
            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="copyright_text">© 2021 All Rights Reserved. </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Javascript files-->
            <script src="js/jquery.min.js"></script>
            <script src="js/popper.min.js"></script>
            <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>