<?php
    include('includes/core.php')

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Maklumat Latihan</title>
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

    <script type="text/javascript">
    window.history.forward();

    function noBack() {
        window.history.forward();
    }
    </script>

</head>
<style type="text/css">
.table {
    font-size: 14px;
    font-family: Arial;
}

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

    padding-left: 6%;
}

.form-group {
    margin: 2em !important;
}

.btn-latihan {
    margin: 1em;

}
</style>

<body class="fixed-nav sticky-footer bg-dark" id="page-top" onload="noBack();"
    onpageshow="if (event.persisted) noBack();" onunload="">
    <!-- Navigation-->
    <?php include('includes/nav.php'); ?>
    <!-- End Navigation-->

    <div class="content-wrapper">
        <div class="container-fluid">
            <marquee>
                <H4>SELAMAT DATANG KE LAMAN ADMIN GPKI</H4>
            </marquee>
            <!-- Breadcrumbs-->
            <div id="dashboard">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" style="color: black">
                        <h4>Maklumat Latihan</h4>
                    </li>
                </ol>
            </div>

            <div id="Approve_Request">
                <div class="container-form">
                    <div class="card mb-4">
                        <div class="title">




                            <?php
 
                                  require 'config-mysqli.php';

                                  $query = "SELECT * FROM maklumat,maklumat2,limitlatihan,limitseminar ORDER BY maklumat_id,maklumat_id2,id_limit,id_limit2 ASC";
                                  $result = mysqli_query($conn,$query) or die(mysqli_error($conn,$query));

                                ?>

                            <?php while($row = mysqli_fetch_array($result)){?>

                            <div class="form-group">
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12 control-label"><b>
                                        Maklumat Latihan </b> : <?php echo $row['maklumat_detail'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12 control-label"><b> Zon
                                    </b> : <?php echo $row['maklumat_zon'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12 control-label"><b>
                                        Negeri </b> : <?php echo $row['maklumat_negeri'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12 control-label"><b>
                                        Tarikh </b> : <?php echo $row['maklumat_tarikh'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12 control-label"><b> Hari
                                    </b> : <?php echo $row['maklumat_hari'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12 control-label"><b> Masa
                                    </b> : <?php echo $row['maklumat_masa'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12 control-label"><b>
                                        Tempat </b> : </label>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <?php echo $row['maklumat_tempat'];?>
                                    <?php echo $row['maklumat_tempat4'];?>
                                    <?php echo $row['maklumat_tempat3'];?>

                                    <?php

                                            require 'config-mysqli.php';
                                            $sql="SELECT count(jenis) AS latihan FROM user WHERE jenis LIKE '%Latihan%'";
                                            $result=mysqli_query($conn,$sql);
                                            $latihan1=mysqli_fetch_assoc($result);
                                            $latihan1=$latihan1['latihan'];

                                            $sql = "SELECT * FROM limitlatihan ORDER BY id_limit ASC";
                                            $result=mysqli_query($conn,$sql);
                                            $jumlahlimit1=mysqli_fetch_assoc($result);
                                            $jumlahlimit1=$jumlahlimit1['jumlah_limit'];
                                        
                                        ?>

                                </div>

                                <div class="btn-latihan">
                                    <a href="editmaklumat.php?maklumat_id=<?php echo $row['maklumat_id'];?>"><button
                                            class="btn btn-primary">Kemaskini</button></a>
                                    <a href="boranglatihan.php"><button class="btn btn-success"
                                            <?php if($latihan1 > $jumlahlimit1) echo "disabled"; ?>>Borang</button></a>
                                </div>
                                <br><br>
                                <hr>
                                <br>
                                <center>
                                    <label for="Name" class="col-lg-5 col-md-5 col-sm-5 col-xs-5 control-label"><b>
                                            Limit Latihan Borang </b> : <?php echo $row['jumlah_limit'];?></label>
                                    <br><br>
                                    <a href="editlimitlatihan.php?id_limit=<?php echo $row['id_limit'];?>"><button
                                            class="btn btn-primary">Kemaskini</button></a>
                                </center>

                            </div>
                            <br>
                            <hr>



                            <?php } ?>

                            <br>

                            <center>



                                <label for="Name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label"> <b>Jumlah
                                        LATIHAN Berdaftar </b> <?php echo $latihan1;?>/<?php echo $jumlahlimit1;?><div
                                        id="piechart"></div></label>


                                <div class="content-chart">



                                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
                                    </script>

                                    <script type="text/javascript">
                                    // Load google charts
                                    google.charts.load('current', {
                                        'packages': ['corechart']
                                    });
                                    google.charts.setOnLoadCallback(drawChart);

                                    // Draw the chart and set the chart values
                                    function drawChart() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['Latihan', 'Jumlah'],
                                            ['Latihan', <?php echo $latihan1;?>],
                                            ['Jumlah', <?php echo $jumlahlimit1;?>]
                                        ]);

                                        // Optional; add a title and set the width and height of the chart
                                        var options = {
                                            'title': '',
                                            'is3D': true,
                                            'width': 400,
                                            'height': 300
                                        };

                                        // Display the chart inside the <div> element with id="piechart"
                                        var chart = new google.visualization.PieChart(document.getElementById(
                                            'piechart'));
                                        chart.draw(data, options);
                                    }
                                    </script>
                                </div>




                                <?php
                                  require 'config-mysqli.php';
                                  $sql="SELECT COUNT(*) AS tengah FROM user WHERE jenis='Latihan' AND zon_user='Tengah'";
                                  $result=mysqli_query($conn,$sql);
                                  $tengah1=mysqli_fetch_assoc($result);
                                  $tengah1=$tengah1['tengah'];

                                  $sql="SELECT COUNT(*) AS utara FROM user WHERE jenis='Latihan' AND zon_user='Utara'";
                                  $result=mysqli_query($conn,$sql);
                                  $utara1=mysqli_fetch_assoc($result);
                                  $utara1=$utara1['utara'];

                                  $sql="SELECT COUNT(*) AS selatan FROM user WHERE jenis='Latihan' AND zon_user='Selatan'";
                                  $result=mysqli_query($conn,$sql);
                                  $selatan1=mysqli_fetch_assoc($result);
                                  $selatan1=$selatan1['selatan'];

                                  $sql="SELECT COUNT(*) AS sabah FROM user WHERE jenis='Latihan' AND zon_user='Sabah'";
                                  $result=mysqli_query($conn,$sql);
                                  $sabah1=mysqli_fetch_assoc($result);
                                  $sabah1=$sabah1['sabah'];

                                  $sql="SELECT COUNT(*) AS sarawak FROM user WHERE jenis='Latihan' AND zon_user='Sarawak'";
                                  $result=mysqli_query($conn,$sql);     
                                  $sarawak1=mysqli_fetch_assoc($result);
                                  $sarawak1=$sarawak1['sarawak'];

                                  $sql="SELECT COUNT(*) AS timur FROM user WHERE jenis='Latihan' AND zon_user='Timur'";
                                  $result=mysqli_query($conn,$sql);
                                  $timur1=mysqli_fetch_assoc($result);
                                  $timur1=$timur1['timur'];

                                  $sql="SELECT COUNT(*) AS selatanseminar FROM user WHERE jenis='Seminar' AND zon_user='Selatan'";
                                  $result=mysqli_query($conn,$sql);
                                  $selatanseminar1=mysqli_fetch_assoc($result);
                                  $selatanseminar1=$selatanseminar1['selatanseminar'];

                                  $sql="SELECT COUNT(*) AS sabahseminar FROM user WHERE jenis='Seminar' AND zon_user='Sabah'";
                                  $result=mysqli_query($conn,$sql);
                                  $sabahseminar1=mysqli_fetch_assoc($result);
                                  $sabahseminar1=$sabahseminar1['sabahseminar'];

                                  $sql="SELECT COUNT(*) AS sarawakseminar FROM user WHERE jenis='Seminar' AND zon_user='Sarawak'";
                                  $result=mysqli_query($conn,$sql);
                                  $sarawakseminar1=mysqli_fetch_assoc($result);
                                  $sarawakseminar1=$sarawakseminar1['sarawakseminar'];

                                  $sql="SELECT jenis,zon_user,COUNT(*) AS tengahseminar FROM user WHERE jenis='Seminar' AND zon_user='Tengah'";
                                  $result=mysqli_query($conn,$sql);
                                  $tengahseminar1=mysqli_fetch_assoc($result);
                                  $tengahseminar1=$tengahseminar1['tengahseminar'];


                               

                                ?>
                                <hr>
                                <div class="zon-content">
                                    <label for="Name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">
                                        <b>Status LATIHAN Peserta </b>

                                    </label>
                                    <div class="container" style="width:30%;">
                                        <div class="row row-cols-auto">
                                            <div class="col" style="border:1px solid gray; background-color:#e0e0eb">Zon Tengah</div>
                                            <div class="col" style="border:1px solid gray"><?php echo $tengah1;?></div>
                                        </div>
                                        <div class="row row-cols-auto">
                                            <div class="col" style="border:1px solid gray;background-color:#e0e0eb">Zon Utara</div>
                                            <div class="col" style="border:1px solid gray"><?php echo $utara1;?></div>
                                        </div>
                                        <div class="row row-cols-auto">
                                            <div class="col" style="border:1px solid gray; background-color:#e0e0eb">Zon Selatan</div>
                                            <div class="col" style="border:1px solid gray"><?php echo $selatan1;?></div>
                                        </div>
                                        <div class="row row-cols-auto">
                                            <div class="col" style="border:1px solid gray; background-color:#e0e0eb">Zon Timur</div>
                                            <div class="col" style="border:1px solid gray"><?php echo $timur1;?></div>
                                        </div>
                                        <div class="row row-cols-auto">
                                            <div class="col" style="border:1px solid gray; background-color:#e0e0eb">Zon Sabah</div>
                                            <div class="col" style="border:1px solid gray"><?php echo $sabah1;?></div>
                                        </div>
                                        <div class="row row-cols-auto">
                                            <div class="col" style="border:1px solid gray; background-color:#e0e0eb">Zon Sarawak</div>
                                            <div class="col" style="border:1px solid gray"><?php echo $sarawak1;?></div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
                                    </script>
                                    <script type="text/javascript">
                                    google.charts.load('current', {
                                        'packages': ['bar']
                                    });
                                    google.charts.setOnLoadCallback(drawStuff);

                                    function drawStuff() {
                                        var data = new google.visualization.arrayToDataTable([
                                            ['Peserta', 'Jumlah'],
                                            ["Zon Tengah", <?php echo $tengah1;?>],
                                            ["Zon Utara", <?php echo $utara1;?>],
                                            ["Zon Selatan", <?php echo $selatan1;?>],
                                            ["Zon Timur", <?php echo $timur1;?>],
                                            ["Zon Sabah", <?php echo $sabah1;?>],
                                            ["Zon Sarawak", <?php echo $sarawak1;?>]
                                        ]);

                                        var options = {
                                            width: 600,
                                            legend: {
                                                position: 'none',
                                                
                                                
                                                
                                            },
                                            chart: {
                                                title: '',
                                                subtitle: ''
                                           
                                            },
                                            axes: {
                                                x: {
                                                    0: {
                                                        side: 'top',
                                                        label: ''
                                                    } // Top x-axis.
                                                }
                                            },
                                            bar: {
                                                groupWidth: "70%"

                                            }
                                        };

                        

                                        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                                        // Convert the Classic options to Material options.
                                        chart.draw(data, google.charts.Bar.convertOptions(options));
                                    };
                                    </script>

                                    <div id="top_x_div" style="width: 700px; height: 400px;"></div>





                                </div>

                            </center>


                        </div>


                        <?php
                          require_once("perpage.php");  
                          require_once("dbcontroller.php");
                          $db_handle = new DBController();
                          
                          $nama_user = "";
                          $noic_user = "";
                          $peranan_user = "";
                          $agensi_user = "";
                          $kementerian_user = "";
                          $notel_user = "";
                          $nopej_user = "";
                          $email_user = "";
                          $jenis = "";
                          $zon_user = "";

                          $queryCondition = "";
                          if(!empty($_POST["search"])) {
                            foreach($_POST["search"] as $k=>$v){
                              if(!empty($v)) {

                                $queryCases = array("nama_user","noic_user","peranan_user","agensi_user","kementerian_user","notel_user","email_user","jenis","zon_user");
                                if(in_array($k,$queryCases)) {
                                  if(!empty($queryCondition)) {
                                    $queryCondition .= " AND ";
                                  } else {
                                    $queryCondition .= " WHERE ";
                                  }
                                }
                                switch($k) {
                                  case "nama_user":
                                    $nama_user = $v;
                                    $queryCondition .= "nama_user LIKE '" . $v . "%'";
                                    break;
                                  case "noic_user":
                                    $noic_user = $v;
                                    $queryCondition .= "noic_user LIKE '" . $v . "%'";
                                    break;
                                    case "peranan_user":
                                    $peranan_user = $v;
                                    $queryCondition .= "peranan_user LIKE '" . $v . "%'";
                                    break;
                                    case "agensi_user":
                                    $agensi_user = $v;
                                    $queryCondition .= "agensi_user LIKE '" . $v . "%'";
                                    break;
                                    case "kementerian_user":
                                    $kementerian_user = $v;
                                    $queryCondition .= "kementerian_user LIKE '" . $v . "%'";
                                    break;
                                    case "notel_user":
                                    $notel_user = $v;
                                    $queryCondition .= "notel_user LIKE '" . $v . "%'";
                                    break;
                                    case "nopej_user":
                                    $nopej_user = $v;
                                    $queryCondition .= "nopej_user LIKE '" . $v . "%'";
                                    break;
                                    case "email_user":
                                    $email_user = $v;
                                    $queryCondition .= "email_user LIKE '" . $v . "%'";
                                    break;
                                    case "jenis":
                                    $jenis = $v;
                                    $queryCondition .= "jenis LIKE '" . $v . "%'";
                                    break;
                                    case "zon_user";
                                    $zon_user = $v;
                                    $queryCondition .= "zon_user LIKE '" . $v . "%'";
                                    break;
                                }
                              }
                            }
                          }
                          $orderby = " ORDER BY zon_user DESC"; 
                          $sql = "SELECT * FROM user " . $queryCondition;
                          $href = 'dashboard.php';          
                            
                          // $perPage = 10; 
                          // $page = 1;
                          // if(isset($_POST['page'])){
                          //   $page = $_POST['page'];
                          // }
                          // $start = ($page-1)*$perPage;
                          // if($start < 0) $start = 0;
                            
                          $query =  $sql . $orderby; 
                          $result = $db_handle->runQuery($query);
                          
                          // if(!empty($result)) {
                          //   $result["perpage"] = showperpage($sql, $perPage, $href);
                          // }
                        ?>

                        <br>


                        <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-warning" href="process/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Logout Modal-->
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Page level plugin JavaScript-->
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <!-- Custom scripts for this page-->
        <!-- <script src="js/sb-admin-datatables.min.js"></script> -->

        <!-- Smooth Scroll -->
        <script>
        $(document).ready(function() {

            $('.table').DataTable({
                responsive: true
            });

            $("#success-alert").fadeTo(5000, 100).slideUp(1000, function() {
                $("#success-alert").slideUp(500);
            });

        });

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
        </script>
        <!-- End Smooth Scroll -->

    </div>
</body>

</html>