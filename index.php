

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Dashboard</title>
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
  .container-form{
    width: 90%;
    padding-left: 10%;}

    .search-form{
      padding-bottom: 15px;
    }
    .search{
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
    .pagination .next a, .pagination .prev a {
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
    .content-chart{
        
            padding-left:2%;
           
           
    }

</style>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="admin.php">
            <h5><i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Log In</span></h5>
          </a>
		  <a class="nav-link" href="index.php">
            <h5><i class="fa fa-fw fa-home"></i>
            <span class="nav-link-text">Dashboard</span></h5>
          </a>
        </li>

        
      </ul>
  
    </div>
  </nav>
<!-- End Navigation-->
  
  <div class="content-wrapper">
    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <div id="dashboard">
        <ol class="breadcrumb">
          <a style="color: black;"><h4>Dashboard Event Semasa </h4></a>
        </ol>
      </div>
        <br>
        <center>

        <?php

        include_once 'config-mysqli.php';

        $peranan1 =  mysqli_query($conn,"select count(peranan_user) as pengguna from user where peranan_user = 'PENGGUNA'");
        $peranan2 =  mysqli_query($conn,"select count(peranan_user) as authorized from user where peranan_user = 'AUTHORIZED PERSONNEL(AP)'");
        $peranan3 =  mysqli_query($conn,"select count(peranan_user) as sub from user where peranan_user = 'SUB ADMIN(SA)'");
        $peranan4 =  mysqli_query($conn,"select count(peranan_user) as pen from user where peranan_user = 'PENGURUSAN'");

     

        $peranan1 = mysqli_fetch_array($peranan1);
        $peranan2 = mysqli_fetch_array($peranan2);
        $peranan3 = mysqli_fetch_array($peranan3);
        $peranan4 = mysqli_fetch_array($peranan4);

      

        ?>

        <div class="peranan">
          <label for="" ><b>PERANAN AGENSI</b></label>
          <br>

          <div class="content-chart">
        <div id="piechart"></div>

          <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
          <script type="text/javascript">
          // Load google charts
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          // Draw the chart and set the chart values
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Peranan', 'Bilangan'],
            ['Pengguna',<?php echo $peranan1['pengguna'];?>],
            ['Authorized Personnel', <?php echo $peranan2['authorized'];?>],
            ['Sub Admin', <?php echo $peranan3['sub'];?>],
            ['Pengurusan', <?php echo $peranan4['pen'];?>]
      
          ]);

            // Optional; add a title and set the width and height of the chart
            var options = {'title':'', 'width':400, 'height':300};

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
          }
          </script>
        </div>

          <label for="">PENGGUNA : <?php echo $peranan1['pengguna'];?></label>
          <br>
          <label for="" >AUTHORIZED PERSONNEL (AP) : <?php echo $peranan2['authorized'];?></label>
          <br>
          <label for="" >SUB ADMIN (SA) : <?php echo $peranan3['sub'];?></label>
          <br>
          <label for="" >PENGURUSAN : <?php echo $peranan4['pen'];?></label>
        </div>
        

        <hr>
      
        
        <br>
        
        <?php

        include_once 'config-mysqli.php';

        $sistem1 =  mysqli_query($conn,"select count(sistem_user) as igf from user where sistem_user like '%iGFMAS,%'");
        $sistem2 =  mysqli_query($conn,"select count(sistem_user) as epe from user where sistem_user like '%ePerolehan,%'");

        $sistem3 =  mysqli_query($conn,"select count(sistem_user) as pow from user where sistem_user like '%POWER Gen 2,%'");
        $sistem4 =  mysqli_query($conn,"select count(sistem_user) as eve from user where sistem_user like '%eVetting,%'");

        $sistem5 =  mysqli_query($conn,"select count(sistem_user) as esy from user where sistem_user like '%E-Syariah,%'");
        $sistem6 =  mysqli_query($conn,"select count(sistem_user) as eke from user where sistem_user like '%eKehakiman,%'");

        $sistem7 =  mysqli_query($conn,"select count(sistem_user) as myg from user where sistem_user like '%MyGST,%'");
        $sistem8 =  mysqli_query($conn,"select count(sistem_user) as nc from user where sistem_user like '%NC4,%'");

        $sistem9 =  mysqli_query($conn,"select count(sistem_user) as eta from user where sistem_user like '%eTanah,%'");
        $sistem10 =  mysqli_query($conn,"select count(sistem_user) as eka from user where sistem_user like '%eKampus,%'");

        $sistem11 =  mysqli_query($conn,"select count(sistem_user) as ins from user where sistem_user like '%INSIST,%'");
        $sistem12 =  mysqli_query($conn,"select count(sistem_user) as myc from user where sistem_user like '%MyCukai,%'");

        $sistem13 =  mysqli_query($conn,"select count(sistem_user) as mye from user where sistem_user like '%MyeTaPP,%'");
        $sistem14 =  mysqli_query($conn,"select count(sistem_user) as ucu from user where sistem_user like '%uCustom,%'");

        $sistem15 =  mysqli_query($conn,"select count(sistem_user) as ero from user where sistem_user like '%eROSA,%'");
        $sistem16 =  mysqli_query($conn,"select count(sistem_user) as mygd from user where sistem_user like '%MyGDX,%'");
        $sistem17 =  mysqli_query($conn,"select count(sistem_user) as ekad from user where sistem_user like '%eKadaster,%'");



 
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
        
    
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"><b>SISTEM ICT</b></label><br><br>
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">iGFMAS : <?php echo $sistem1['igf'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">ePerolehan : <?php echo $sistem2['epe'];?></label> 
          <br>
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">POWER Gen 2 : <?php echo $sistem3['pow'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eVetting : <?php echo $sistem4['eve'];?></label> 
          <br>
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">E-Syariah : <?php echo $sistem5['esy'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eKehakiman : <?php echo $sistem6['eke'];?></label> 
          <br>
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">MyGST : <?php echo $sistem7['myg'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">NC4 : <?php echo $sistem8['nc'];?></label> 
          <br><br>
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eTanah : <?php echo $sistem9['eta'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eKampus : <?php echo $sistem10['eka'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">MyeTaPP : <?php echo $sistem13['mye'];?></label> 
          <br>
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">INSIST : <?php echo $sistem11['ins'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">MyCukai : <?php echo $sistem12['myc'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">uCustom : <?php echo $sistem14['ucu'];?></label> 
          <br>
        
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eROSA : <?php echo $sistem15['ero'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">MyGDX : <?php echo $sistem16['mygd'];?></label> 
          <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">eKadaster : <?php echo $sistem17['ekad'];?></label> 
          <br>
         
          <br>

          <hr>

            <br>

                                <div class="form-group">
                                    <label for="model" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label"><b>Zon</b></label><br>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <form action="#" method="post">
                                        <select class="form-control" name="zon[]" >
                                            <option value="">Sila pilih...</option>
                                            <option name="tengah" value="Tengah">Tengah</option>
                                            <option value="Timur">Timur</option>
                                            <option value="Utara">Utara</option>
                                            <option value="Selatan">Selatan</option>
                                            <option value="Sabah">Sabah</option>
                                            <option value="Sarawak">Sarawak</option>
                                        </select>
                                        <br>
                                        <input type="submit" name="submit" value="Klik"  class="btn btn-success"/>
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
                                      $negeri1 =  mysqli_query($conn,"select count(negeri_user) as put from user where negeri_user = 'Putrajaya'");
                                      $negeri1= mysqli_fetch_array($negeri1);
                                      $negeri2 =  mysqli_query($conn,"select count(negeri_user) as kul from user where negeri_user = 'Kuala Lumpur'");
                                      $negeri2= mysqli_fetch_array($negeri2);
                                      $negeri3 =  mysqli_query($conn,"select count(negeri_user) as sel from user where negeri_user = 'Selangor'");
                                      $negeri3= mysqli_fetch_array($negeri3);                    
                                      echo "<b>Negeri</b>";
                                      echo "<br>";
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
                                      $negeri1 =  mysqli_query($conn,"select count(negeri_user) as kel from user where negeri_user = 'Kelantan'");
                                      $negeri1= mysqli_fetch_array($negeri1);
                                      $negeri2 =  mysqli_query($conn,"select count(negeri_user) as ter from user where negeri_user = 'Terengganu'");
                                      $negeri2= mysqli_fetch_array($negeri2);
                                      $negeri3 =  mysqli_query($conn,"select count(negeri_user) as pah from user where negeri_user = 'Pahang'");
                                      $negeri3= mysqli_fetch_array($negeri3);
                                      echo "<b>Negeri</b>";
                                      echo "<br>";
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
                                      $negeri1 =  mysqli_query($conn,"select count(negeri_user) as per from user where negeri_user = 'Perlis'");
                                      $negeri1= mysqli_fetch_array($negeri1);
                                      $negeri2 =  mysqli_query($conn,"select count(negeri_user) as ked from user where negeri_user = 'Kedah'");
                                      $negeri2= mysqli_fetch_array($negeri2);
                                      $negeri3 =  mysqli_query($conn,"select count(negeri_user) as pul from user where negeri_user = 'Pulau Pinang'");
                                      $negeri3= mysqli_fetch_array($negeri3);
                                      $negeri4 =  mysqli_query($conn,"select count(negeri_user) as perak from user where negeri_user = 'Perak'");
                                      $negeri4= mysqli_fetch_array($negeri4);
                                      echo "<b>Negeri</b>";
                                      echo "<br>";
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
                                      $negeri1 =  mysqli_query($conn,"select count(negeri_user) as joh from user where negeri_user = 'Johor'");
                                      $negeri1= mysqli_fetch_array($negeri1);
                                      $negeri2 =  mysqli_query($conn,"select count(negeri_user) as neg from user where negeri_user = 'Negeri Sembilan'");
                                      $negeri2= mysqli_fetch_array($negeri2);
                                      $negeri3 =  mysqli_query($conn,"select count(negeri_user) as mel from user where negeri_user = 'Melaka'");
                                      $negeri3= mysqli_fetch_array($negeri3);
                                      echo "<b>Negeri</b>";
                                      echo "<br>";
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
                                      $negeri1 =  mysqli_query($conn,"select count(negeri_user) as sab from user where negeri_user = 'Sabah'");
                                      $negeri1= mysqli_fetch_array($negeri1);   
                                      echo "<b>Negeri</b>";
                                      echo "<br>";                                 
                                      echo "Sabah : ";
                                      echo $negeri1['sab']; // Displaying Selected Value
                                      break;

                                      case "Sarawak":
                                      $negeri1 =  mysqli_query($conn,"select count(negeri_user) as sar from user where negeri_user = 'Sarawak'");
                                      $negeri1= mysqli_fetch_array($negeri1);  
                                      echo "<b>Negeri</b>";
                                      echo "<br>";                                  
                                      echo "Sarawak : ";
                                      echo $negeri1['sar']; // Displaying Selected Value
                                      break;

                                  }
                                }}
                                ?>
                                <br>
                                <hr>
                                </center>
  

       
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
          <small>Copyright © Augmented Technology Sdn Bhd 2021</small>
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
    $('.table').DataTable();
} );
    </script>

    <!-- Smooth Scroll -->
    <script>
    $(document).ready(function(){
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
          }, 1000, function(){
       
            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        } // End if
      });
    });
    </script>

    <script>
      $("#success-alert").fadeTo(5000, 100).slideUp(1000, function(){
        $("#success-alert").slideUp(500);
      });
    </script>

    <!-- End Smooth Scroll -->


    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
   <!--  <script src="vendor/datatables/jquery.dataTables.js"></script> -->
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
  </div>
</body>

</html>
