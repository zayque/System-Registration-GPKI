<?php
	    
	require 'config-mysqli.php';

		//user
		$maklumat_id = $_POST['id1'];
		$maklumat_detail = $_POST['detail1'];
		$maklumat_zon = $_POST['zon1'];
		$maklumat_negeri = $_POST['negeri1'];
		$maklumat_tarikh = $_POST['tarikh1'];
		$maklumat_hari = $_POST['hari1'];
		$maklumat_masa = $_POST['masa1'];
		$maklumat_tempat = $_POST['tempat1'];
		$maklumat_tempat4 = $_POST['tempat4'];
		$maklumat_tempat3 = $_POST['tempat3'];


	$query = "UPDATE maklumat SET
				maklumat_detail = '$maklumat_detail',
				maklumat_zon = '$maklumat_zon',
				maklumat_negeri = '$maklumat_negeri',
				maklumat_tarikh = '$maklumat_tarikh',
				maklumat_hari  = '	$maklumat_hari ',
				maklumat_masa  = '	$maklumat_masa ',
				maklumat_tempat = '$maklumat_tempat',
				maklumat_tempat4 = '$maklumat_tempat4',
				maklumat_tempat3 = '$maklumat_tempat3'
				WHERE maklumat_id = '$maklumat_id'";

	mysqli_query($conn,$query) or die(mysqli_error($conn));

	echo'<script>alert("Berjaya Kemaskini")</script>';

	echo "<script>window.location='maklumatlatihan.php?maklumatlatihan=success';</script>";
	
?>