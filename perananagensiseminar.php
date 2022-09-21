<?php
    include('includes/core.php');

   

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Agensi & ICT</title>
    <link rel="icon" type="image/ico" href="img/logo2.png" />

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet" />
</head>
<style type="text/css">
.container-form {
    width: 90%;
    padding-left: 10%;
}

.search-form {
    padding-bottom: 15px;
}

.search {
    border-radius: 5px;
}

.pagination {
    list-style-type: none;
    padding: 10px 0;
    float: right;
    display: inline-flex;
    justify-content: space-between;
    box-sizing: border-box;
}

.pagination li {
    box-sizing: border-box;
    padding-right: 10px;
}

.pagination li a {
    box-sizing: border-box;
    background-color: #e2e6e6;
    padding: 8px;
    text-decoration: none;
    font-size: 12px;
    font-weight: bold;
    color: #616872;
    border-radius: 4px;
}

.pagination li a:hover {
    background-color: #d4dada;
}

.pagination .next a,
.pagination .prev a {
    text-transform: uppercase;
    font-size: 12px;
}

.pagination .currentpage a {
    background-color: #518acb;
    color: #fff;
}

.pagination .currentpage a:hover {
    background-color: #518acb;
}

.content-chart {

    padding-left: 2%;


}
</style>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
    <!-- Navigation-->
    <?php include('includes/nav.php'); ?>
    <!-- End Navigation-->

    <div class="content-wrapper">
        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <div id="dashboard">
                <marquee>
                    <H4>SELAMAT DATANG KE LAMAN ADMIN GPKI</H4>
                </marquee>
                <ol class="breadcrumb">

                    <a style="color: black;">
                        <h4>Agensi & ICT </h4>
                    </a>
                </ol>
            </div>


            <?php

                    include_once 'config-mysqli.php';

                    // $peranan1 =  mysqli_query($conn,"select count(peranan_user) as pengguna from user where peranan_user = 'PENGGUNA' and jenis = 'Seminar'");
                    $peranan2 =  mysqli_query($conn,"select count(peranan_user) as authorized from user where peranan_user = 'AUTHORIZED PERSONNEL(AP)' and jenis = 'Seminar'");
                    $peranan3 =  mysqli_query($conn,"select count(peranan_user) as sub from user where peranan_user = 'SUB ADMIN(SA)' and jenis = 'Seminar'");
                    $peranan4 =  mysqli_query($conn,"select count(peranan_user) as pen from user where peranan_user = 'PENGURUSAN' and jenis = 'Seminar'");

                

                    // $peranan1 = mysqli_fetch_array($peranan1);
                    $peranan2 = mysqli_fetch_array($peranan2);
                    $peranan3 = mysqli_fetch_array($peranan3);
                    $peranan4 = mysqli_fetch_array($peranan4);

            ?>

            <li class="nav-item dropdown" style="list-style:none">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Jenis
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="perananagensi.php">Latihan</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="perananagensiseminar.php">Seminar</a>
                </div>
            </li>



            <center>
                <div style="width:80%; border: 1px solid rgb(221,221,221); border-radius:4px;">
                    <div class="peranan">

                        <br>
                        <label for=""><b>PERANAN AGENSI SEMINAR</b></label>
                        <br>

                        <div class="content-chart">

                            <div id="piechart"></div>

                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                            <script type="text/javascript">
                            // Load google charts
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawChart);

                            // Draw the chart and set the chart values
                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Peranan', 'Bilangan'],
                                    ['Pengurusan', <?php echo $peranan4['pen'];?>],
                                    ['Authorized Personnel',<?php echo $peranan2['authorized'];?>],
                                    ['Sub Admin', <?php echo $peranan3['sub'];?>]


                                ]);

                                // Optional; add a title and set the width and height of the chart
                                var options = {
                                    'title': '',
                                    'is3D': true,
                                    'width': 500,
                                    'height': 250
                                };

                                // Display the chart inside the <div> element with id="piechart"
                                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                chart.draw(data, options);
                            }
                            </script>
                        </div>


                        <div class="container" style="width:40%">
                            <!-- <div class="row row-cols-auto">
                                <div class="col" style="border:1px solid gray; background-color:#0040ff; color:white;">
                                    PENGGUNA </div>
                                <div class="col" style="border:1px solid gray"><?php echo $peranan1['pengguna'];?></div>
                            </div> -->
                            <div class="row row-cols-auto">
                                <div class="col" style="border:1px solid gray; background-color:#0040ff; color:white;">
                                    PENGURUSAN</div>
                                <div class="col" style="border:1px solid gray"><?php echo $peranan4['pen'];?></div>
                            </div>
                            <div class="row row-cols-auto">
                                <div class="col" style="border:1px solid gray; background-color:#0040ff; color:white;">
                                    AUTHORIZED PERSONNEL (AP)</div>
                                <div class="col" style="border:1px solid gray"><?php echo $peranan2['authorized'];?>
                                </div>
                            </div>
                            <div class="row row-cols-auto">
                                <div class="col" style="border:1px solid gray; background-color:#0040ff; color:white;">
                                    SUB ADMIN (SA)</div>
                                <div class="col" style="border:1px solid gray"><?php echo $peranan3['sub'];?></div>
                            </div>
                        </div>

                    </div>




                    <?php

                include_once 'config-mysqli.php';

                $sistem1 =  mysqli_query($conn,"select count(sistem_user) as igf from user where sistem_user like '%iGFMAS,%' and jenis = 'Seminar'");
                $sistem2 =  mysqli_query($conn,"select count(sistem_user) as epe from user where sistem_user like '%ePerolehan,%' and jenis = 'Seminar'");

                $sistem3 =  mysqli_query($conn,"select count(sistem_user) as pow from user where sistem_user like '%POWER Gen 2,%' and jenis = 'Seminar'");
                $sistem4 =  mysqli_query($conn,"select count(sistem_user) as eve from user where sistem_user like '%eVetting,%' and jenis = 'Seminar'");

                $sistem5 =  mysqli_query($conn,"select count(sistem_user) as esy from user where sistem_user like '%E-Syariah,%' and jenis = 'Seminar'");
                $sistem6 =  mysqli_query($conn,"select count(sistem_user) as eke from user where sistem_user like '%eKehakiman,%' and jenis = 'Seminar'");

                $sistem7 =  mysqli_query($conn,"select count(sistem_user) as myg from user where sistem_user like '%MyGST,%' and jenis = 'Seminar'");
                $sistem8 =  mysqli_query($conn,"select count(sistem_user) as nc from user where sistem_user like '%NC4,%' and jenis = 'Seminar'");

                $sistem9 =  mysqli_query($conn,"select count(sistem_user) as eta from user where sistem_user like '%eTanah,%' and jenis = 'Seminar'");
                $sistem10 =  mysqli_query($conn,"select count(sistem_user) as eka from user where sistem_user like '%eKampus,%' and jenis = 'Seminar'");

                $sistem11 =  mysqli_query($conn,"select count(sistem_user) as ins from user where sistem_user like '%INSIST,%' and jenis = 'Seminar'");
                $sistem12 =  mysqli_query($conn,"select count(sistem_user) as myc from user where sistem_user like '%MyCukai,%' and jenis = 'Seminar'");

                $sistem13 =  mysqli_query($conn,"select count(sistem_user) as mye from user where sistem_user like '%MyeTaPP,%' and jenis = 'Seminar'");
                $sistem14 =  mysqli_query($conn,"select count(sistem_user) as ucu from user where sistem_user like '%uCustom,%' and jenis = 'Seminar'");

                $sistem15 =  mysqli_query($conn,"select count(sistem_user) as ero from user where sistem_user like '%eROSA,%' and jenis = 'Seminar'");
                $sistem16 =  mysqli_query($conn,"select count(sistem_user) as mygd from user where sistem_user like '%MyGDX,%' and jenis = 'Seminar'");
                $sistem17 =  mysqli_query($conn,"select count(sistem_user) as ekad from user where sistem_user like '%eKadaster,%' and jenis = 'Seminar'");



        
                $sistem1= mysqli_fetch_array($sistem1);
                $sistem2= mysqli_fetch_array($sistem2);

                $sistem3= mysqli_fetch_array($sistem3);
                $sistem4= mysqli_fetch_array($sistem4);
                
                $sistem5= mysqli_fetch_array($sistem5);
                $sistem6= mysqli_fetch_array($sistem6);
                
                $sistem7= mysqli_fetch_array($sistem7);
                $sistem8= mysqli_fetch_array($sistem8);
                
                $sistem9= mysqli_fetch_array($sistem9);
                $sistem10= mysqli_fetch_array($sistem10);
                
                $sistem11= mysqli_fetch_array($sistem11);
                $sistem12= mysqli_fetch_array($sistem12);

                $sistem13= mysqli_fetch_array($sistem13);        
                $sistem14= mysqli_fetch_array($sistem14);

                $sistem15= mysqli_fetch_array($sistem15);
                $sistem16= mysqli_fetch_array($sistem16);
                $sistem17= mysqli_fetch_array($sistem17);

        ?>
                    <br>
                    <hr>
                    <br>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"><b>SISTEM
                            ICT SEMINAR</b></label><br><br>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">iGFMAS :
                        <?php echo $sistem1['igf'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">ePerolehan :
                        <?php echo $sistem2['epe'];?></label>
                    <br>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">POWER Gen 2 :
                        <?php echo $sistem3['pow'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eVetting :
                        <?php echo $sistem4['eve'];?></label>
                    <br>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">E-Syariah :
                        <?php echo $sistem5['esy'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eKehakiman :
                        <?php echo $sistem6['eke'];?></label>
                    <br>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">MyGST :
                        <?php echo $sistem7['myg'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">NC4 :
                        <?php echo $sistem8['nc'];?></label>
                    <br><br>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eTanah :
                        <?php echo $sistem9['eta'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eKampus :
                        <?php echo $sistem10['eka'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">MyeTaPP :
                        <?php echo $sistem13['mye'];?></label>
                    <br>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">INSIST :
                        <?php echo $sistem11['ins'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">MyCukai :
                        <?php echo $sistem12['myc'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">uCustom :
                        <?php echo $sistem14['ucu'];?></label>
                    <br>

                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eROSA :
                        <?php echo $sistem15['ero'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">MyGDX :
                        <?php echo $sistem16['mygd'];?></label>
                    <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eKadaster :
                        <?php echo $sistem17['ekad'];?></label>

                    <br><br><br>



                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawStuff);

                    function drawStuff() {
                        var data = new google.visualization.arrayToDataTable([
                            ['', ''],
                            ["iGFMAS", <?php echo $sistem1['igf'];?>],
                            ["ePerolehan", <?php echo $sistem2['epe'];?>],
                            ["POWER Gen 2", <?php echo $sistem3['pow'];?>],
                            ["eVetting", <?php echo $sistem4['eve'];?>],
                            ["E-Syariah", <?php echo $sistem5['esy'];?>],
                            ["eKehakiman", <?php echo $sistem6['eke'];?>],
                            ["MyGST", <?php echo $sistem7['myg'];?>],
                            ["NC4", <?php echo $sistem8['nc'];?>],
                            ["eTanah", <?php echo $sistem9['eta'];?>],
                            ["eKampus", <?php echo $sistem10['eka'];?>],
                            ["MyeTaPP", <?php echo $sistem13['mye'];?>],
                            ["INSIST", <?php echo $sistem11['ins'];?>],
                            ["MyCukai", <?php echo $sistem12['myc'];?>],
                            ["uCustom", <?php echo $sistem14['ucu'];?>],
                            ["eROSA", <?php echo $sistem15['ero'];?>],
                            ["MyGDX", <?php echo $sistem16['mygd'];?>],
                            ["eKadaster", <?php echo $sistem17['ekad'];?>]

                        ]);

                        var options = {
                            title: '',
                            width: 700,
                            legend: {
                                position: 'none'
                            },
                            chart: {
                                title: '',
                                subtitle: ''
                            },
                            bars: 'horizontal', // Required for Material Bar Charts.
                            axes: {
                                x: {
                                    0: {
                                        side: 'top',
                                        label: ''
                                    } // Top x-axis.
                                }
                            },
                            bar: {
                                groupWidth: "90%"
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                        chart.draw(data, options);
                    };
                    </script>


                    <div id="top_x_div" style="width: 700px; height: 500px;"></div>
                    <br>



                </div>

            </center>

            <br>
        </div>
    </div>
    </div>
    <!-- End DataTables Card-->
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Copyright © 2021</small>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->

    <!-- End Logout Modal-->
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // $('.table').DataTable();








    });
    </script>

    <!-- Smooth Scroll -->
    <script>
    $(document).ready(function() {
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (1000) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 1000, function() {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    });
    </script>

    <script>
    $("#success-alert").fadeTo(5000, 100).slideUp(1000, function() {
        $("#success-alert").slideUp(500);
    });
    </script>



    <!-- End Smooth Scroll -->


    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->

    </div>
</body>

</html>