<?php 
              // Include database connection

            include('session.php');
            if(!isset($_SESSION['login_user'])){
                echo "<script>alert('Username/Password Wrong');</script>";
                echo "<script>window.location='check.php?login=errormsg';</script>";
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
        }
    ?>

</head>
<style>
.active_nav:hover {
    background-color: #3d85c6;
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
                    <h1 class="creative_text">Information Details (<?php echo $jenis_session; ?>)</h1> <br>
                    <center>
                        <a onclick="myFunction()" class="btn btn-danger" href="logout.php">Log Out</a><br><br>
                        <form method="POST" action="#">
                            <div class="form-group">
                                <table>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                Nama
                                                &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $nama_session; ?> &nbsp</a></td>
                                    </tr>
                                    <!-- <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                No
                                                Kad Pengenalan &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                 &nbsp</a></td>
                                    </tr> -->
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                Zon
                                                &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $zon_session; ?>
                                                &nbsp</a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                E-mel &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $email_session; ?> &nbsp</a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                No.
                                                Telefon &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $notel_session; ?> &nbsp</a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                No.
                                                Pejabat &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $nopej_session; ?> &nbsp</a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                Peranan &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $peranan_session; ?> &nbsp</a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                Agensi &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $agensi_session; ?> &nbsp</a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                Kementerian &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $kementerian_session; ?> &nbsp</a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                Gred
                                                &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <?php echo $gred_session; ?> &nbsp</a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                Sistem ICT &nbsp</a></td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <li><?php echo $sistem_session; ?></li>
                                                &nbsp
                                            </a></td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                                QR
                                                Code
                                                &nbsp</a>
                                        </td>
                                        <td style="border:1px solid black"><a style="color:Blue; font-size:24px">&nbsp
                                                <img src="../userQr/<?php echo $qrimg_session; ?>">
                                                <button class="btn btn-success"><a
                                                        href="../userQr/<?php echo $qrimg_session; ?>" download>
                                                        Download
                                                    </a>
                                                </button>

                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <h2>Please download the QR Code and save it to your phone.<br> Dont forget to bring the
                                    qr code to the event.<br>Thankyou!</h2>
                            </div>
                        </form>

                        <br>

                    </center>
                    <br><br><br><br><br><br><br>
                </div>

            </div>

            <script>
            function myFunction() {
                alert("Thank You");
            }
            </script>

            <!--Contact_section end -->
            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="copyright_text">© 2019 All Rights Reserved. </p>
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