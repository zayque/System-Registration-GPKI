<?php

session_start();

if(isset($_POST['submit'])){
	//Database connection
	include '../config.php';

	$fname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lname = mysqli_real_escape_string($conn, $_POST['lname']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$pass = mysqli_real_escape_string($conn, $_POST['password']);
	$retype = mysqli_real_escape_string($conn, $_POST['retypepassword']);
	$mdpass = md5($pass);

	if($pass == $retype){
		$sql = "INSERT INTO inv_user (email,FirstName,LastName,password,PhoneNumber,acctype) VALUES ('$email','$fname','$lname','$mdpass','$phone','admin')";
		$result = mysqli_query($conn, $sql);

		if($result){
			header("Location: ../register.php?=Success");
		}
		else {
			header("Location: ../register.php?=ErrorSql");
		}
	}

	else {
		header("Location: ../register.php?Password=NonIdentical");
	}

}
else{
	header("Location: ../register.php");
}


?>