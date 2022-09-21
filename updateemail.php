<?php
	    
	require 'config-mysqli.php';

		//user
		$id_email = $_POST['idemail1'];
		$subject_email = $_POST['subject1'];
		$body_email = $_POST['body1'];
		$altbody_email = $_POST['altbody1'];



	$query = "UPDATE email SET
				subject_email = '$subject_email',
				body_email = '$body_email',
				altbody_email = '$altbody_email'
				WHERE id_email = '$id_email'";

	mysqli_query($conn,$query) or die(mysqli_error($conn));

	echo'<script>alert("Berjaya Kemaskini")</script>';

	echo "<script>window.location='maklumatemail.php?maklumatemail=success';</script>";
	
?>