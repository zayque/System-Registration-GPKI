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
                                <li class="nav-item ">
                                    <a class="nav-link active_nav" href="index.php">HOME<span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="training.php"
                                        style="color:#6fa8dc;">TRAINING</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="seminar.php">SEMINAR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="check.php">CHECK</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active_nav" href="absent.php">ABSENT</a>
                                </li>
                                <li class="nav-item " href="#">
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

    <?php
 
        require 'config-mysqli.php';

        $query = "SELECT * FROM maklumat ORDER BY maklumat_id ASC";
        $result = mysqli_query($conn,$query) or die(mysqli_error($conn,$query));

    ?>

    <!--services start -->
    <div class="about_main">
        <div class="services_main">
            <div class="container">
                <div class="creative_taital">
                    <h1 class="creative_text">Training Event</h1> <br>
                    <?php while($row = mysqli_fetch_array($result)){?>
                    <p class="text_about_2" style="color: #000000; ">
                        <a style="color:blue; font-weight:bold; font-size:24px;">Maklumat Latihan :</a> <?php echo $row['maklumat_detail'];?>
                        <br><br>
                        <a style="color:blue; font-weight:bold; font-size:24px;">Zon :</a> <?php echo $row['maklumat_zon'];?>
                        <br><br>
                        <a style="color:blue; font-weight:bold; font-size:24px;"> Negeri :</a> <?php echo $row['maklumat_negeri'];?>
                        <br><br>
                        <a style="color:blue; font-weight:bold; font-size:24px;">Tarikh :</a> <?php echo $row['maklumat_tarikh'];?>
                        <br><br>
                        <a style="color:blue; font-weight:bold; font-size:24px;">Hari :</a> <?php echo $row['maklumat_hari'];?>
                        <br><br>
                        <a style="color:blue; font-weight:bold; font-size:24px;">Masa :</a> <?php echo $row['maklumat_masa'];?>
                        <br><br>
                        <a style="color:blue; font-weight:bold; font-size:24px;">Tempat :</a> <?php echo $row['maklumat_tempat'];?>, 
                        <?php echo $row['maklumat_tempat2'];?> <?php echo $row['maklumat_tempat4'];?> <?php echo $row['maklumat_tempat3'];?>
                        
                    </p>
                    <?php } ?>
		
                    <br>
                    <!-- <div class="img_version_2"><img src="images/c.png"></div> -->
                    <br><br><br>
                    <!-- <div class="btn_main">
    			    <button type="button" class="btn btn-dark btn-lg">Get started</button>
    		    </div> -->
                </div>
            </div>

            <!-- <div class="container">
                <div class="creative_taital">
                    <br><br><br>
                    <h1 class="creative_text">About The Company</h1> <br>
                    <p class="text_about_3" style="color: #000000; ">
                        VERDASTRO SDN BHD <br><br>
                        Incorporation No: 1367078-V
                    </p>

                    <p class="img_version_3"><img src="images/d.png"></p>

                    <a class="img_version_1"><img src="images/e.png"></a>
                    <div class="btn_main">
    			    <button type="button" class="btn btn-dark btn-lg">Get started</button>
    		    </div>
                </div>
            </div> -->

            <!-- <div class="container">
                <div class="creative_taital">
                    <br><br><br>
                    <h1 class="creative_text">R&D Team</h1> <br>

                    <p class="img_version_4"><img src="images/f.png" height="300"></p>


                    <a class="text_about_4" style="color: #000000; text-align: justify;">
                        Our R&D team innovates, develops new products and supports our clients in the development of
                        specific concepts and products. <br><br>
                        The team committed to:
                        <ul>
                            <li>Research and innovation to find the solutions and ingredients of tomorrow.</li>
                            <li>Delivering, developing and optimising our range of solutions.</li>
                            <li>Developing new functionalities and enhancing the nutritional value of our ingredients.
                            </li>
                            <li>Partnering with our clients in the development of their products.</li>
                        </ul>
                        <br>
                        Our R&D team has outlined long term strategic plans in anticipation of competition and rapid
                        technological changes in the global bio plastic industry.
                        To realise this plan, we have increased the number of research experts and support staff in
                        order to reinforce the capabilities of the R&D facility.
                    </a>

                    <p class="img_version_5"><img src="images/g.png" width="500"></p>

                </div>

                <a class="text_about_5" style="color: #000000; text-align: justify;">
                    Verdastro unique selling point is our
                    Palm Oil Trunk fibre reinforced
                    bioplastic resin. Our expert R&D
                    team has successfully found the
                    miracle of manufacturing the fully
                    biodegradable and bio compostable
                    resin by having the same strength as
                    the conventional petroleum-based plastic.<br>

                    This fibre resin degrades once it touches
                    the soils and rapid degradation if it touches
                    the ocean (salt water). <br>

                    Remember, this raw material is abundance.

                </a>
                <p class="img_version_6"><img src="images/h.png" width="500"></p>
            </div> -->


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