<?php

session_start();

if(isset($_POST['submit'])){
	include '../config.php';

	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$retypepass = mysqli_real_escape_string($conn, $_POST['retypepassword']);
	$mdpass = md5($password);
	$ID = $_SESSION['ID'];

	if($password == $retypepass){
		
		$sql = "UPDATE inv_user SET password ='$mdpass'";
		$result = mysqli_query($conn,$sql);

		if($result){
		$_SESSION['chgpass'] = "success";
			header("Location: ../editprof.php?=Success");
		}
		else {
		$_SESSION['chgpass'] = "success";
			header("Location: ../editprof.php?=Error");
		}
	}
	else {
		echo "LALA";
	}
}


?>