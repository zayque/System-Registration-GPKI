<?php

session_start();

if (isset($_POST['submit'])) {
	
	include 'config-mysqli.php';

	$uid = stripslashes($_POST['uid']);
	$pwd = stripslashes($_POST['pwd']);

	//Error handlers
	//Check if inputs are empty
	if (empty($uid) || empty($pwd)) {
			header("Location: admin.php?login=empty");
			exit();
	} 
	else {
		$sql = "SELECT * FROM adminlogin WHERE user_uid='$uid' OR user_email='$uid' ";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		var_dump($resultCheck);

		if($resultCheck != '1') {
			echo "<script>alert('Username/Password Wrong');</script>";
			echo "<script>window.location='admin.php?login=errormsg';</script>";

			exit();
		} 
		else {
			if ($row = mysqli_fetch_assoc($result)) {
				//De-hashing the password
				$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
				if ($hashedPwdCheck == false) {
					echo 'false';
					echo "<script>alert('Username/Password Wrong');</script>";
					echo "<script>window.location='admin.php?login=errormsg';</script>";

					exit();
				} 
				else {
					//Log in the user here
					$_SESSION['u_id'] = $row['user_id'];
					$_SESSION['u_first'] = $row['user_first'];
					$_SESSION['u_last'] = $row['user_last'];
					$_SESSION['u_email'] = $row['user_email'];
					$_SESSION['u_uid'] = $row['user_uid'];
					
					echo "<script>alert('Selamat Datang ke Laman Admin!');</script>";
					echo "<script>window.location='dashboard.php?login=success';</script>";

					
					
					exit();
				}
				
			}
		}
	}
} 	
else {
	header("Location: index.php?login=error");
	exit();
}

