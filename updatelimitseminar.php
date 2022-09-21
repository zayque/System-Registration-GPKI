<?php
	    
	require 'config-mysqli.php';

		//user
		$id_limit2 = $_POST['idlimit1'];
		$jumlah_limit2 = $_POST['limit1'];
		$mesej_limit2 = $_POST['limit2'];


	$query = "UPDATE limitseminar SET
				jumlah_limit2 = '$jumlah_limit2',
				mesej_limit2 = '$mesej_limit2'
				WHERE id_limit2 = '$id_limit2'";

	mysqli_query($conn,$query) or die(mysqli_error($conn));

	echo'<script>alert("Berjaya Kemaskini")</script>';

	echo "<script>window.location='maklumatseminar.php?maklumatseminar=success';</script>";
	
?>