<?php
	    
	require 'config-mysqli.php';

		//user
		$noic_user = $_POST['id1'];
		$nama_user = $_POST['nama1'];
		$peranan_user = $_POST['peranan1'];
		$agensi_user = $_POST['agensi1'];
		$kementerian_user = $_POST['kementerian1'];
		$notel_user = $_POST['notel1'];
		$nopej_user = $_POST['nopej1'];
		$email_user = $_POST['emel1'];
		

	$query = "UPDATE user SET
				nama_user = '$nama_user',
				peranan_user = '$peranan_user',
				agensi_user = '$agensi_user',
				kementerian_user = '$kementerian_user',
				notel_user  = '	$notel_user ',
				nopej_user = '$nopej_user',
				email_user = '$email_user'
				WHERE noic_user = '$noic_user'";

	mysqli_query($conn,$query) or die(mysqli_error($conn));

	echo'<script>alert("Berjaya Update")</script>';

	echo "<script>window.location='dashboard.php?dashboard=success';</script>";
	
?>