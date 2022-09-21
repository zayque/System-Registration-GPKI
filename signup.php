<?php

if (isset($_POST['submit'])) {
	
	include_once 'config-mysqli.php';

	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	//Error handlers
	//Check for empty fields
	if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)){
		header("Location: ../adminsignup.php?adminsignup=empty");
		exit();

	}
	 else {
		//Check if inout caharacters are valid
		if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
			header("Location: ../adminsignup.php?adminsignup=invalid");
			exit();
		} 
		else {
			//Check if email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				header("Location: ../adminsignup.php?adminsignup=email");
				exit();
			} 
			else {
				$sql = "SELECT * FROM adminlogin WHERE user_uid='$uid' ";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);

				if ($resultCheck > 0) {
					header("Location: ../adminsignup.php?adminsignup=usertaken");
					exit();
				} 
				else {
					//hashing the password
					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
					//Insert the user into the database
					$sql = "INSERT INTO adminlogin (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first' , '$last' , '$email' , '$uid', '$hashedPwd'); ";
					mysqli_query ($conn, $sql);
					
					echo "<script>alert('Thankyou for sign up !');</script>";
					echo "<script>window.location='../borangV2/adminsignup.php?adminsignup=success';</script>";
					
					exit();
				}
			}
		}
	}


} 
else {
	header("Location: ../adminsignup.php");
	exit();
}