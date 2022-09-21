<?php
	    
	require 'config-mysqli.php';

		//user
		$id_limit = $_POST['idlimit1'];
		$jumlah_limit = $_POST['limit1'];
		$mesej_limit = $_POST['limit2'];


	$query = "UPDATE limitlatihan SET
				jumlah_limit = '$jumlah_limit',
				mesej_limit = '$mesej_limit'
				WHERE id_limit = '$id_limit'";

	mysqli_query($conn,$query) or die(mysqli_error($conn));

	echo'<script>alert("Berjaya Kemaskini")</script>';

	echo "<script>window.location='maklumatlatihan.php?maklumatlatihan=success';</script>";
	
?>