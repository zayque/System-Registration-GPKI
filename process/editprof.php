<?php

session_start();

if (isset($_POST['submit'])){
	include_once '../config.php';

	$email = mysqli_real_escape_string($conn, $_POST['emailedit']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$firstname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lastname = mysqli_real_escape_string($conn, $_POST['lname']);
	$oldemail = $_SESSION['email'];


	$sql = "UPDATE inv_user SET email ='$email', FirstName='$firstname', LastName='$lastname', PhoneNumber = '$phone' WHERE email = '$oldemail'";
	$result = mysqli_query($conn,$sql);

	if($result){
		$_SESSION['edit'] = "success";
		$_SESSION['email'] = $email;
		header("Location: ../editprof.php?=Success");
	}
	else {
		$_SESSION['edit'] = "error";
		header("Location ../editprof.php?=Error");
	}
}
?>