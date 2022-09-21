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

    <style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
   
    .active_nav:hover{
        background-color:#3d85c6;
        opacity: 50px;
        border-radius: 30px;
    }

    </style>

</head>
<!-- body -->

<body>
    <div class="header_main">
        <h3>
            <marquee>Welcome to GPKI Event!</marquee>
        </h3>
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
                                    <a class="nav-link active_nav" href="index.php" style="color:#6fa8dc;">HOME<span
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
    <!--banner start -->
    <div class="banner-main">
        <div class="container">
            <div id="main_slider" class="carousel slide" data-ride="carousel">
                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="titlepage-h1">
                            <!-- <h1 class="bnner_title">We Create<br>
                <span style="color: #068b23">GREEN</span></h1> -->
                            <!-- <p class="img_version_0"><img src="images/a.png"></p> -->
                            <p class="long_text">
                                " Keselamatan Digital Teras Kepercayaan "
                            </p>
                        </div>
                        <div class="btn_main">
                            <!-- <button type="button" class="btn btn-dark btn-lg"><a href="contact.html">Contact</a></button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--banner end -->
    <!--services start -->
    <div class="services_main">
        <div class="container">
            <div class="creative_taital">
                <!-- <h1 class="creative_text">About Us</h1> <br>  -->
                <h3 class="creative_text_2">GOVERNMENT PUBLIC KEY INFRASTRUCTURE.</h3>
                <p class="text_about" style="color: #000000; text-align: center;">
                    Perkhidmatan Prasarana Kunci Awam Kerajaan (Government Public Key Infrastructure – GPKI) merupakan
                    salah satu perkhidmatan keselamatan ICT bagi memantapkan tahap keselamatan data dan maklumat bagi
                    sistem ICT Kerajaan.
                </p>
                <p class="img_about">
                    <img id="myImg" src="images/gpki_medium.jpg" ;
                        style="border-radius: 10px; width:100%;max-width:400px">
                </p>

            </div>

            <div id="myModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">
                <div id="caption"></div>
            </div>

            <script>
            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById("myImg");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            img.onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            }

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }
            </script>
            <!-- <div class="section_service_2">
    		    	<h1 class="service_text">Our Service</h1>
    		    </div> -->
            <!-- <div class="service_main">
    		    	<div class="container">
    		    		<div class="row">
    		    			<div class="col-md-6">
    		    				<div class="written_text">
    		    					<div class="like_icon"><img src="images/like-icon.png"></div>
    		    					<h1 class="written_text">Written with Love</h1>
    		    					<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, </p>
    		    				</div>
    		    			</div>
    		    			<div class="col-md-6">
    		    				<div class="written_text">
    		    					<div class="like_icon"><img src="images/fast-forword-icon.png"></div>
    		    					<h1 class="written_text">Fast Turnaround</h1>
    		    					<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, </p>
    		    				</div>
    		    			</div>
    		    		</div>
    		    	</div>
    		    </div> -->
            <!-- <div class="service_main">
    		    	<div class="container">
    		    		<div class="row">
    		    			<div class="col-md-6">
    		    				<div class="written_text">
    		    					<div class="like_icon"><img src="images/design-icon.png"></div>
    		    					<h1 class="written_text">Up to Date</h1>
    		    					<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, </p>
    		    				</div>
    		    			</div>
    		    			<div class="col-md-6">
    		    				<div class="written_text">
    		    				  <div class="like_icon"><img src="images/writing-icon.png"></div>
    		    					<h1 class="written_text">Premium Content</h1>
    		    					<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, </p>
    		    				</div>
    		    			</div>
    		    		</div>
    		    	</div>
    		    </div> -->
        </div>
    </div>
    <!--services end -->

    <!--quote_section start -->
    <!-- <div class="quote_section">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-6">
    				<h1 class="quote_text">Quote for Today</h1>
    				<p class="loan_text">It is a long established fact that a reader will be distracted by the readable content of a page </p>
    			</div>
    		    <div class="col-md-6">
    			    <div class="quote_btn">
    			        <button type="button" class="btn btn-dark btn-lg">Get A Quote</button>
    		        </div>
    		    </div>
    		</div>
    	</div>
    </div> -->

    <!--quote_section end -->
    <!--touch_section start -->

    <!-- <div class="touch_section">
        <div class="container">
            <h1 class="touch_text">Let's Get In Touch!</h1>
        </div>
    </div>

    <div class="lets_touch_main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="input_main">
                       <div class="container">
                          <form action="/action_page.php">
                            <div class="form-group">
                              <input type="text" class="email-bt" placeholder="Name" name="Name">
                            </div>
                            <div class="form-group">
                              <input type="text" class="email-bt" placeholder="Email" name="Email">
                            </div>
                            <form action="/action_page.php">
                                <div class="form-group">
                                  <textarea class="massage-bt" placeholder="Massage" rows="5" id="comment" name="text"></textarea>
                                </div>
                            </form>
                          </form>
                       </div> 
                       <div class="send_btn">
                        <button  type="button" class="main_bt"><a href="#">Send</a></button>
                       </div>                   
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <p class="lorem_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!--touch_section end -->
    <!--Contact_section start -->
    <div class="contact_main">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="touch_text">Contact Us</h1>
                </div>
            </div>
        </div>
        <div class="contact_section_2">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="map_icon">
                            <img src="images/map-icon.png" style="max-width: 100%;padding-left: 30px; ">
                            <p class="email-text"><a href="#">B, MKN Embassy Techzone, Jalan Teknokrat 2, Cyberjaya,
                                    63000 Cyberjaya, Selangor
                                    <br>MAMPU Malaysia</a></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="map_icon">
                            <!-- <img src="images/call-icon.png" style="max-width: 100%;padding-left: 30px;"> -->
                            <p class="email-text"><a href="#"></a></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="map_icon">
                            <img src="images/email-icon.png" style="max-width: 100%; padding-left: 30px;">
                            <p class="email-text"><a href="#">gpkievent@gmail.com
                                </a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Contact_section end -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="copyright_text">© 2021 All Rights Reserved.</p>
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