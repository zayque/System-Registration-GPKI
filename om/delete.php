<?php
	
	session_start();

		include '../config.php';

		$req = $_SESSION['x'];

		$SerialNumber = $_GET['id'];

		mysqli_query($conn, "DELETE from inv_tempapp WHERE SerialNumber ='$SerialNumber'");
		header("Location: ../view_detail_approve_request.php?req=$req");

	
	

?>