<?php

    include('login.php'); // Includes Login Script
    if(isset($_SESSION['login_user'])){
    header("location: informationUser.php"); // Redirecting To Profile Page
    }

    ?>

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

        <?php
        if(isset($_SESSION['login_msg']) && $_SESSION['login_msg'] != ""){
            echo '<script> alert("' . $_SESSION['login_msg'] . '"); </script>';
           //$_SESSION['login_msg'] = "";
        }
    ?>

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
                                    <a class="nav-link active_nav" href="check.php" style="color:#6fa8dc;">CHECK</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="absent.php">ABSENT</a>
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
                    <h1 class="creative_text">Check Information Details</h1> <br>
                    <center>
                    <form class="form" action="" method="POST">
                            <div class="form-group">
                                <label style="color:blue">Sila Masukkan Email dan MyKad anda untuk menyemak maklumat yang telah
                                    anda isi...</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Email" name="email_user" value="<?php if(isset($_POST['submit'])){echo $_POST['email_user']; } ?>">
                                    <br>
                                <input type="password" class="form-control" id="myInput"
                                    aria-describedby="emailHelp" placeholder="No Mykad" name="noic_user" value="<?php if(isset($_POST['submit'])){echo $_POST['noic_user']; } ?>">
                                    &nbsp<input type="checkbox" onclick="myFunction()">&nbsp <a style="color:black">Papar No Mykad</a>

                                </div>
                            <br>
                            <button type="submit" class="btn btn-primary" name="submit">Semak</button>
                        </form>
                    </center>
                    <br><br><br><br><br><br><br>
                
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
            <script>
    $('.js-tilt').tilt({
        scale: 1.1
    })

    function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

   
    </script>
</body>

</html>