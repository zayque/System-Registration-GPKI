<?php

session_start();

if (isset($_POST['submit'])){ 
	//Database connection
	include '../config.php';

	$tokennumber = $_POST['tokennumber'];
	$quantity = $_POST['quan'];
	$calc = $tokennumber + $quantity;
	$model = $_POST['type'];
	$date = date("Y-m-d");

	for($x = $tokennumber; $x < $calc; $x++){
			
		$sql ="INSERT INTO inv_inventory (ModelType,TokenNumber,Date) VALUES ('$model','$x','$date')";

		if(mysqli_query($conn, $sql)) {
			$_SESSION["statusinsert"] = "success";
				header("Location: ../dashboard.php?insr=TokenInserted");
			
		}else {
			$_SESSION["statusinsert"] = "error";
			$_SESSION["msg"] = mysqli_error($conn);
			header("Location: ../dashboard.php?error");
		}
	}
}
?>