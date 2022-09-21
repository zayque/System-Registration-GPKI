<?php
	
	session_start();

		include '../config.php';

		$req = $_SESSION['x'];

		$SerialNumber = $_GET['id'];

		$newserial = $_POST['serial_no'];

		$sql = "SELECT COUNT(*) FROM inv_tempapp WHERE SerialNumber = '$newserial'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result);

		if ($row[0] > 0) {
			header("Location: ../view_detail_approve_request.php?req=$req");
		} else {
			mysqli_query($conn, "UPDATE inv_tempapp SET SerialNumber='$newserial' WHERE SerialNumber='$SerialNumber'");
			header("Location: ../view_detail_approve_request.php?req=$req");
		}
	

?>