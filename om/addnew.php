<?php
session_start();

		include '../config.php';

		$req = $_SESSION['x'];

		$SerialNumber = $_POST['serial_no'];
		$quantity = $_POST['quantity'];

		$calc = $SerialNumber + $quantity;

		for($x = $SerialNumber; $x < $calc; $x++){
			mysqli_query($conn, "INSERT INTO inv_tempapp (id_temp,SerialNumber) VALUES (NULL,'$x')");
			$_SESSION['x'] = null;
		}
		header("Location: ../view_detail_approve_request.php?req=$req");

?>