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
    <title>Home</title>
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

    var checkDeleteArray = [];

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
                    <li class="breadcrumb-item " style="color: black">
                        <h4>Home (Seminar)</h4>
                    </li>
                </ol>
            </div>

            <div id="Approve_Request">
                <div class="container-form">
                    <div class="card mb-4">
                        <div class="title">



                            <center>
                                <br>
                                <div class="form-group">
                                    <label for="model"
                                        class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label"><b>Negeri
                                            Pengguna Seminar</b></label><br>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <form action="#" method="post">
                                            <select class="form-control" name="zon[]">
                                                <option value="">Sila pilih...</option>
                                                <option name="tengah" value="Tengah">Tengah</option>
                                                <option value="Timur">Timur</option>
                                                <option value="Utara">Utara</option>
                                                <option value="Selatan">Selatan</option>
                                                <option value="Sabah">Sabah</option>
                                                <option value="Sarawak">Sarawak</option>
                                            </select>
                                            <br>
                                            <input type="submit" name="submit" value="Klik" class="btn btn-success" />
                                        </form>
                                    </div>
                                </div>

                                <?php

                                    include_once 'config-mysqli.php';

                                    if(isset($_POST['submit'])){

                                    foreach ($_POST['zon'] as $select)
                                    {
                                                        $zon=$select;
                                                        switch($zon){
                                                            case "Tengah":
                                                            $negeri1 =  mysqli_query($conn,"select count(negeri_user) as put from user where negeri_user = 'Putrajaya' and jenis = 'Seminar'");
                                                            $negeri1= mysqli_fetch_array($negeri1);
                                                            $negeri2 =  mysqli_query($conn,"select count(negeri_user) as kul from user where negeri_user = 'Kuala Lumpur' and jenis = 'Seminar'");
                                                            $negeri2= mysqli_fetch_array($negeri2);
                                                            $negeri3 =  mysqli_query($conn,"select count(negeri_user) as sel from user where negeri_user = 'Selangor' and jenis = 'Seminar'");
                                                            $negeri3= mysqli_fetch_array($negeri3);  
                                                            echo "<br>";                  
                                                            echo "<b>Negeri</b>";
                                                            echo "<br><br>";
                                                            echo "Putrajaya : ";
                                                            echo $negeri1['put']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Kuala Lumpur : ";
                                                            echo $negeri2['kul']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Selangor : ";
                                                            echo $negeri3['sel']; // Displaying Selected Value
                                                            break;

                                                            case "Timur":
                                                            $negeri1 =  mysqli_query($conn,"select count(negeri_user) as kel from user where negeri_user = 'Kelantan' and jenis = 'Seminar'");
                                                            $negeri1= mysqli_fetch_array($negeri1);
                                                            $negeri2 =  mysqli_query($conn,"select count(negeri_user) as ter from user where negeri_user = 'Terengganu' and jenis = 'Seminar'");
                                                            $negeri2= mysqli_fetch_array($negeri2);
                                                            $negeri3 =  mysqli_query($conn,"select count(negeri_user) as pah from user where negeri_user = 'Pahang' and jenis = 'Seminar'");
                                                            $negeri3= mysqli_fetch_array($negeri3);
                                                            echo "<br>";
                                                            echo "<b>Negeri</b>";
                                                            echo "<br><br>";
                                                            echo "Kelantan : ";
                                                            echo $negeri1['kel']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Terengganu : ";
                                                            echo $negeri2['ter']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Pahang : ";
                                                            echo $negeri3['pah']; // Displaying Selected Value
                                                            break;

                                                            case "Utara":
                                                            $negeri1 =  mysqli_query($conn,"select count(negeri_user) as per from user where negeri_user = 'Perlis' and jenis = 'Seminar'");
                                                            $negeri1= mysqli_fetch_array($negeri1);
                                                            $negeri2 =  mysqli_query($conn,"select count(negeri_user) as ked from user where negeri_user = 'Kedah' and jenis = 'Seminar'");
                                                            $negeri2= mysqli_fetch_array($negeri2);
                                                            $negeri3 =  mysqli_query($conn,"select count(negeri_user) as pul from user where negeri_user = 'Pulau Pinang' and jenis = 'Seminar'");
                                                            $negeri3= mysqli_fetch_array($negeri3);
                                                            $negeri4 =  mysqli_query($conn,"select count(negeri_user) as perak from user where negeri_user = 'Perak' and jenis = 'Seminar'");
                                                            $negeri4= mysqli_fetch_array($negeri4);
                                                            echo "<br>";
                                                            echo "<b>Negeri</b>";
                                                            echo "<br><br>";
                                                            echo "Perlis : ";
                                                            echo $negeri1['per']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Kedah : ";
                                                            echo $negeri2['ked']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Pulau Pinang : ";
                                                            echo $negeri3['pul']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Perak : ";
                                                            echo $negeri4['perak']; // Displaying Selected Value
                                                            
                                                            break;

                                                            case "Selatan":
                                                            $negeri1 =  mysqli_query($conn,"select count(negeri_user) as joh from user where negeri_user = 'Johor' and jenis = 'Seminar'");
                                                            $negeri1= mysqli_fetch_array($negeri1);
                                                            $negeri2 =  mysqli_query($conn,"select count(negeri_user) as neg from user where negeri_user = 'Negeri Sembilan' and jenis = 'Seminar'");
                                                            $negeri2= mysqli_fetch_array($negeri2);
                                                            $negeri3 =  mysqli_query($conn,"select count(negeri_user) as mel from user where negeri_user = 'Melaka' and jenis = 'Seminar'");
                                                            $negeri3= mysqli_fetch_array($negeri3);
                                                            echo "<br>";
                                                            echo "<b>Negeri</b>";
                                                            echo "<br><br>";
                                                            echo "Johor : ";
                                                            echo $negeri1['joh']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Negeri Sembilan : ";
                                                            echo $negeri2['neg']; // Displaying Selected Value
                                                            echo "<br>";
                                                            echo "Melaka : ";
                                                            echo $negeri3['mel']; // Displaying Selected Value
                                                            break;

                                                            case "Sabah":
                                                            $negeri1 =  mysqli_query($conn,"select count(negeri_user) as sab from user where negeri_user = 'Sabah' and jenis = 'Seminar'");
                                                            $negeri1= mysqli_fetch_array($negeri1);   
                                                            echo "<br>";
                                                            echo "<b>Negeri</b>";
                                                            echo "<br><br>";
                                                            echo "Sabah : ";
                                                            echo $negeri1['sab']; // Displaying Selected Value
                                                            break;

                                                            case "Sarawak":
                                                            $negeri1 =  mysqli_query($conn,"select count(negeri_user) as sar from user where negeri_user = 'Sarawak' and jenis = 'Seminar'");
                                                            $negeri1= mysqli_fetch_array($negeri1);  
                                                            echo "<br>";
                                                            echo "<b>Negeri</b>";
                                                            echo "<br><br>";
                                                            echo "Sarawak : ";
                                                            echo $negeri1['sar']; // Displaying Selected Value
                                                            break;

                                    }
                                    }}
                                ?>

                                <hr>

                                <?php
 
                                        require 'config-mysqli.php';

                                        $query = "SELECT * FROM maklumat,maklumat2,limitlatihan,limitseminar ORDER BY maklumat_id,maklumat_id2,id_limit,id_limit2 ASC";
                                        $result = mysqli_query($conn,$query) or die(mysqli_error($conn,$query));

                                ?>

                                <?php

                                        require 'config-mysqli.php';
                                        $sql="SELECT count(jenis) AS latihan FROM user WHERE jenis LIKE '%Latihan%'";
                                        $result=mysqli_query($conn,$sql);
                                        $latihan1=mysqli_fetch_assoc($result);
                                        $latihan1=$latihan1['latihan'];
                                    
                                        $sql="SELECT count(jenis) AS seminar FROM user WHERE jenis LIKE '%Seminar%'";
                                        $result=mysqli_query($conn,$sql);
                                        $seminar1=mysqli_fetch_assoc($result);
                                        $seminar1=$seminar1['seminar'];

                                        $sql = "SELECT * FROM limitlatihan ORDER BY id_limit ASC";
                                        $result=mysqli_query($conn,$sql);
                                        $jumlahlimit1=mysqli_fetch_assoc($result);
                                        $jumlahlimit1=$jumlahlimit1['jumlah_limit'];

                                        $sql = "SELECT * FROM limitseminar ORDER BY id_limit2 ASC";
                                        $result=mysqli_query($conn,$sql);
                                        $jumlahseminar1=mysqli_fetch_assoc($result);
                                        $jumlahseminar1=$jumlahseminar1['jumlah_limit2'];
                              
                              
                                ?>




                                <?php
                                  require 'config-mysqli.php';
                                  $sql="SELECT COUNT(*) AS tengah FROM user WHERE jenis='Latihan' AND zon_user='Tengah' ";
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

                                  $sql="SELECT COUNT(*) AS sabah FROM user WHERE jenis='Latihan' AND negeri_user='Sabah'";
                                  $result=mysqli_query($conn,$sql);
                                  $sabah1=mysqli_fetch_assoc($result);
                                  $sabah1=$sabah1['sabah'];

                                  $sql="SELECT COUNT(*) AS sarawak FROM user WHERE jenis='Latihan' AND negeri_user='Sarawak'";
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



                            </center>
                            <center>
                                <br>
                                <b>
                                    <p>SENARAI KEHADIRAN SEMINAR<br> PRASARANA KEKUNCI AWAM KERAJAAN (GOVERNMENT PUBLIC
                                        KEY INFRASTRUCTURE (GPKI))</p>
                                </b>
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
                        //   $sql = "SELECT * FROM user " . $queryCondition;
                          $sql = "SELECT * FROM user WHERE jenis LIKE '%Seminar%' " . $queryCondition;

                          $href = 'dashboard.php';          
             
                          $query =  $sql . $orderby; 
                          $result = $db_handle->runQuery($query);
                          
                     
                        ?>
                        <li class="nav-item dropdown" style="list-style:none">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Jenis
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="dashboard.php">Latihan</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Seminar</a>
                            </div>
                        </li>
                        <br>
                        <div class="card-header">
                            <div class="card-body">
                                <button type="button" id="deleteSelectedBtn"  class="btn btn-danger text-white">Delete
                                    Selected</button>


                                <div class="float-right mb-4 mr-3">
                                    <a href="displayseminar.php"><button type="button"
                                            class="btn btn-secondary text-white">Print</button></a>
                                    <a href="csvseminar.php"><button type="button"
                                            class="btn btn-secondary text-white">Download</button></a>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-hover" cellpadding="10" cellspacing="1">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th><strong>Bil.</strong></th>
                                                <th><strong>Jenis</strong></th>
                                                <th><strong>Zon</strong></th>
                                                <th><strong>Nama</strong></th>
                                                <th><strong>No. KP</strong></th>
                                                <th><strong>Peranan</strong></th>
                                                <th><strong>Agensi</strong></th>
                                                <th><strong>Kementerian</strong></th>
                                                <th><strong>Gred</strong></th>
                                                <th><strong>No. Tel</strong></th>
                                                <th><strong>E-mel</strong></th>
                                                <th><strong>Sistem ICT</strong></th>
                                                <th><strong></strong></th>
                                                <!-- <th><strong>Masa</strong></th> -->

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                      $count=0;
                                      if(!empty($result)) {
                                        foreach($result as $k=>$v) {
                                          if(is_numeric($k)) { $count++;
                                      ?>
                                            <tr>
                                                <td><input type="checkbox" name="no" onchange="handleChange(this);"value="<?=$result[$k]["noic_user"];?>" /></td>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $result[$k]["jenis"]; ?></td>
                                                <td><?php echo $result[$k]["zon_user"]; ?></td>
                                                <td><?php echo strtoupper($result[$k]["nama_user"]);?> </td>
                                                <td><?php echo $result[$k]["noic_user"]; ?></td>
                                                <td><?php echo $result[$k]["peranan_user"]; ?></td>
                                                <td><?php echo strtoupper($result[$k]["agensi_user"]);?> </td>
                                                <td><?php echo $result[$k]["kementerian_user"]; ?></td>
                                                <td><?php echo $result[$k]["gred_user"]; ?></td>
                                                <td><?php echo $result[$k]["notel_user"]; ?></td>
                                                <td><?php echo $result[$k]["email_user"]; ?></td>
                                                <td><?php echo $result[$k]["sistem_user"]; ?></td>
                                                <!-- <td><?php //echo $result[$k]["masa"]; ?></td> -->
                                                <td>
                                                    <a
                                                        href="edituser.php?noic_user=<?php echo $result[$k]["noic_user"]; ?>">Kemaskini</a>
                                                    <br>
                                                    <a href="deleteuserseminar.php?action=delete&noic_user=<?php echo $result[$k]["noic_user"]; ?>"
                                                        onClick="return confirm('Anda pasti ?');">Padam</a>
                                                </td>
                                            </tr>
                                            <?php
                                          }
                                        }
                                                }
                                      //if(isset($result["perpage"])) {
                                      ?>
                                            <!-- <tr>
                                          <td colspan="12" style="border:1px white" align="right">
                                              <?php //echo $result["perpage"]; ?></td>
                                      </tr> -->
                                            <?php //} ?>
                                        <tbody>
                                    </table>
                                </div>


                            </div>
                        </div>

                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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

            
            var $button = $("#deleteSelectedBtn").hide(),
                $cbs = $('input[name="no"]').click(function() {
                    $button.toggle($cbs.is(":checked"));
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

        function handleChange(checkbox) {
            if (checkbox.checked == true) {
                // document.getElementById("submit").removeAttribute("disabled");
                checkDeleteArray.push(checkbox.value);
                console.log(checkDeleteArray);
            } else {
                // document.getElementById("submit").setAttribute("disabled", "disabled");
                var index = checkDeleteArray.indexOf(checkbox.value);
                if (index !== -1) {
                    checkDeleteArray.splice(index, 1);
                }

                console.log(checkDeleteArray);
            }
        }

        $('#deleteSelectedBtn').click(function() {

            if (confirm("Are you sure you want to delete the selected data ?")) {
                console.log(checkDeleteArray);

                $.post('includes/api.php', {
                    action: 'delete_selected',
                    itemArray: JSON.stringify(checkDeleteArray)
                }, function(data) {
                    var apiData = JSON.parse(data);

                    if (apiData['message'] == "Successful") {
                        location.reload();
                    }
                });
            }
        });
        </script>
        <!-- End Smooth Scroll -->

    </div>
</body>

</html>