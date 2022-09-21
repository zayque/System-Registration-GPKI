<?php
	    
	require 'config-mysqli.php';

		//user
		$maklumat_id2 = $_POST['id1'];
		$maklumat_detail2 = $_POST['detail1'];
		$maklumat_zon2 = $_POST['zon1'];
		$maklumat_negeri2 = $_POST['negeri1'];
		$maklumat_tarikh2 = $_POST['tarikh1'];
		$maklumat_hari2 = $_POST['hari1'];
		$maklumat_masa2 = $_POST['masa1'];
		$maklumat_tempat22 = $_POST['tempat2'];
		$maklumat_tempat23 = $_POST['tempat3'];
		$maklumat_tempat24 = $_POST['tempat4'];



	$query = "UPDATE maklumat2 SET
				maklumat_detail2 = '$maklumat_detail2',
				maklumat_zon2 = '$maklumat_zon2',
				maklumat_negeri2 = '$maklumat_negeri2',
				maklumat_tarikh2 = '$maklumat_tarikh2',
				maklumat_hari2 = '$maklumat_hari2',
				maklumat_masa2 = '$maklumat_masa2',
				maklumat_tempat22 = '$maklumat_tempat22',
				maklumat_tempat23 = '$maklumat_tempat23',
				maklumat_tempat24 = '$maklumat_tempat24'
				WHERE maklumat_id2 = '$maklumat_id2'";

	mysqli_query($conn,$query) or die(mysqli_error($conn));

	echo'<script>alert("Berjaya Kemaskini")</script>';

	echo "<script>window.location='maklumatseminar.php?maklumatseminar=success';</script>";
	
?>