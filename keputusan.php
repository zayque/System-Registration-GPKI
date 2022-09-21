<?php
session_start();

	require 'config-mysqli.php';
	//////// End of connecting to database ////////

	@$zon=$_GET['zon']; // Use this line or below line if register_global is off
	if(strlen($zon) > 0 and !is_numeric($zon)){ // to check if $cat is numeric data or not. 
	echo "Data Error";
	exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Keputusan Pengguna GPKI</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  	

            <script type="text/javascript">
                window.history.forward();
                function noBack() { window.history.forward(); }
            </script>
</head>

	<style>
		.form-input{
			width:70%;
			margin-left: 10px;
			border-radius: 5px;

		}
		.panel-body-form{
			padding: 15px;
    		
    		font-size: 40px;	
    	
		}
		.b{
			margin-left: 30%;
			width: 5%;

		}
		.no{
			padding-left: 80px;

		}
		.info{
			
			font-size: 25px;
			font-family: arial;
			padding-left: 25%;

		}
		.note{
			color: red;
			padding-bottom: 40px;
			font-size: 12px;

		}
		
			</style>

       

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
<div class="container" >
	<div class="col-lg-12">
		<!-- <a href="admin.php"><button type="Login" class="btn btn-default" style="float: right;">Login</button></a> -->
	<br>
		<h3 style="float: center; margin-top: 5%; text-align: center;"><b>Pendaftaran Pengguna GPKI</b></h3>
	</div>
</div>
<div class="container" style="margin-top: 20px">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-center"><b> </b></h3>
			</div>

			<div class="panel-body-form">
            <p>
            Pengesahan pendaftaran tuan/puan untuk mengikuti Seminar Pengguna GPKI telah berjaya. Sila rujuk pengesahan yang akan dihantar ke e-mel tuan/puan dalam masa yang terdekat. 
            </p>
            <p>
            Jika tidak mendapat sebarang pengesahan/makluman selepas 1 jam dari notifikasi ini, sila hubungi pihak urusetia seperti didalam agenda.
            </p>

	    </div>
		</div>
	</div>
</div>
</body>
<br>
	<footer>
		<!-- <center>
				<img src="img/Logo.png"><br>
				<label>Augmented Technology Sdn Bhd</label><br>
				No. 38 Jalan BM 7/19, Bandar Bukit Mahkota 43000, Kajang, Selangor, MALAYSIA<br>
				Tel: +(603) 8922 9474 Fax: +(603) 8922 9473
				<br><br><br>
		</center> -->
	</footer>
</html>