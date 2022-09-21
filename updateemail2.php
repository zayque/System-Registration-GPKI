<?php
	    
	require 'config-mysqli.php';

		//user
		$id_email2 = $_POST['idemail1'];
		$subject_email2 = $_POST['subject1'];
		$body_email2 = $_POST['body1'];
		$altbody_email2 = $_POST['altbody1'];



	$query = "UPDATE email2 SET
				subject_email2 = '$subject_email2',
				body_email2 = '$body_email2',
				altbody_email2 = '$altbody_email2'
				WHERE id_email2 = '$id_email2'";

	mysqli_query($conn,$query) or die(mysqli_error($conn));

	echo'<script>alert("Berjaya Kemaskini")</script>';

	echo "<script>window.location='maklumatemail.php?maklumatemail=success';</script>";
	
?>