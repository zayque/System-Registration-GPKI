

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>
  <style type="text/css">

      .body-from{
        width:98%;
        margin:0px auto;
        font-size: 11px;
      }

      

      @media print{
        @page {
          /* size: auto;   auto is the initial value */
          size: A4 landscape;
          margin: 0;  /* this affects the margin in the printer settings */
          border: 1px solid black;  /* set a border for all printed pages */

        }

        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
      }

  </style>

<body class="body-from">

          <center>
          <?php
 
          require 'config-mysqli.php';

          $query = "SELECT * FROM maklumat ORDER BY maklumat_id ASC";
          $result = mysqli_query($conn,$query) or die(mysqli_error());

          ?>

          <br><br><br><br>
          <?php while($row = mysqli_fetch_array($result)){?>
  <div class="info">
  <table >
  <tr>
    <th>Maklumat Latihan : </th>
    <td><div style="padding-left: 20px"><?php echo $row['maklumat_detail'];?></div></td>
  </tr>
  <tr>
    <th>Tarikh :  </th>
    <td><div style="padding-left: 20px"><?php echo $row['maklumat_tarikh'];?></div></td>
  </tr>
  <tr>
    <th>Hari :  </th>
    <td><div style="padding-left: 20px"><?php echo $row['maklumat_hari'];?></div></td>
  </tr>
  <tr>
    <th>Masa :  </th>
    <td><div style="padding-left: 20px"><?php echo $row['maklumat_masa'];?></div></td>
  </tr>
  <tr>
    <th>Lokasi :  </th>
    <td><div style="padding-left: 20px"><?php echo $row['maklumat_tempat'];?></div></td>
  </tr>
  <tr>
    <th></th>
    <td><div style="padding-left: 20px"><?php echo $row['maklumat_tempat2'];?></div></td>
  </tr>
  <tr>
    <th></th>
    <td><div style="padding-left: 20px"><?php echo $row['maklumat_tempat4'];?></div></td>
  </tr>
  <tr>
    <th></th>
    <td><div style="padding-left: 20px"><?php echo $row['maklumat_tempat3'];?></div></td>
  </tr>

  </table>
  </div>
  <?php } ?>
            </center>
            <br>
            <center>  
           
           <b><p>SENARAI KEHADIRAN SEMINAR<br>PRASARANA KEKUNCI AWAM KERAJAAN (GOVERNMENT PUBLIC KEY INFRASTRUCTURE (GPKI))</p></b>
      
     

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

          $queryCondition = "";
          if(!empty($_POST["search"])) {
            foreach($_POST["search"] as $k=>$v){
              if(!empty($v)) {

                $queryCases = array("nama_user","noic_user","peranan_user","agensi_user","kementerian_user","notel_user","email_user");
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
                }
              }
            }
          }
          $orderby = " ORDER BY nama_user desc"; 
          $sql = "SELECT * FROM user WHERE jenis LIKE '%Seminar%' " . $queryCondition;
          $href = 'dashboard.php';          
            
          $perPage = 200; 
          $page = 1;
          if(isset($_POST['page'])){
            $page = $_POST['page'];
          }
          $start = ($page-1)*$perPage;
          if($start < 0) $start = 0;
            
          $query =  $sql . $orderby .  " limit " . $start . "," . $perPage; 
          $result = $db_handle->runQuery($query);
          
          if(!empty($result)) {
            $result["perpage"] = showperpage($sql, $perPage, $href);
          }
        ?>


<div class="table-responsive"  >
               <div id="toys-grid">      
      <form name="frmSearch" method="post" action="dashboard.php">     
      <table cellpadding="3" cellspacing="1" >
       
        <thead>
          <tr>
              <th style="border: 1px solid black;"><strong>Bil.</strong></th>
              <th style="border: 1px solid black;"><strong>Nama</strong></th>        
              <th style="border: 1px solid black;"><strong>Peranan</strong></th>
              <th style="border: 1px solid black;"><strong>Agensi</strong></th>
              <th style="border: 1px solid black;"><strong>Kementerian</strong></th>
              <th style="border: 1px solid black;"><strong>Gred</strong></th>
              <th style="border: 1px solid black;"><strong>No. Tel</strong></th>
              <th style="border: 1px solid black;"><strong>E-mel</strong></th>
              <th style="border: 1px solid black;"><strong>Sistem ICT</strong></th>
              <th style="border: 1px solid black;"><strong>Masa</strong></th>
              <th style="border: 1px solid black;"><strong>Tandatangan</strong></th>
              
          </tr>
        </thead>
        <tbody>
          <?php
          $count=0;
          if(!empty($result)) {
            foreach($result as $k=>$v) {
              if(is_numeric($k)) { $count++;
          ?>
          <tr >
          <td style="border: 1px solid black;"><?php echo $count; ?></td>
          <td style="border: 1px solid black;"><?php echo strtoupper($result[$k]["nama_user"]);?> </td>
          <td style="border: 1px solid black;"><?php echo $result[$k]["peranan_user"]; ?></td>
          <td style="border: 1px solid black;"><?php echo strtoupper($result[$k]["agensi_user"]);?> </td>
          <td style="border: 1px solid black;"><?php echo $result[$k]["kementerian_user"]; ?></td>
          <td style="border: 1px solid black;"><?php echo $result[$k]["gred_user"]; ?></td>   
          <td style="border: 1px solid black;"><?php echo $result[$k]["notel_user"]; ?></td>
          <td style="border: 1px solid black;"><?php echo $result[$k]["email_user"]; ?></td> 
          <td style="border: 1px solid black;"><?php echo $result[$k]["sistem_user"]; ?></td>
          <td style="border: 1px solid black;"><?php echo $result[$k]["masa"]; ?></td> 
          <td style="border: 1px solid black;"></td> 
          </tr>
          <?php
              }
             }
                    }
          if(isset($result["perpage"])) {
          ?>
         <!--  <tr>
          <td colspan="10" align=right> <?php echo $result["perpage"]; ?></td>
          </tr> -->
          <?php } ?>
        </tbody>

      </table>
      </form> 
    </div> 
        </div>
        </center>
       
   <!--  <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a> -->
    <!-- Logout Modal-->
   <!--  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
   
        </div>
      </div>
    </div> -->
  <!-- End Logout Modal-->
  <br><br>
  
    
    <!-- Bootstrap core JavaScript-->
   <!--  <script src="vendor/jquery/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
    $('.table').DataTable();
} );
    </script> -->

    <!-- Smooth Scroll -->

    <!-- <script>
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
    </script> -->

   <!--  <script>
      $("#success-alert").fadeTo(5000, 100).slideUp(1000, function(){
        $("#success-alert").slideUp(500);
      });
    </script> -->

    <!-- End Smooth Scroll -->


    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>

    <script>
      window.print();
    </script>


  </div>
</body>

</html>
