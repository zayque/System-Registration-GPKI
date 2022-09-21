<?php
	
	session_start();

		include '../config.php';

		$req = $_SESSION['x'];

		$sql = "TRUNCATE inv_tempapp";
		if(mysqli_query($conn,$sql)){
			header('Location: ../view_detail_approve_request.php?req=$req');	
		} else {
			echo "Error 11520";
		}
	
?>