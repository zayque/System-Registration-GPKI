<?php

session_start();

if (isset($_POST['submit'])){

		include_once '../config.php';

		$email = mysqli_real_escape_string($conn, $_POST['emailadd']);
		$password = mysqli_real_escape_string($conn, $_POST['pass']);
		$mdpass = md5($password);

		//Check if empty
		if(empty($email) || empty($password)){
			header("Location: ../admin.php?login=empty");
		        exit();
		} 

		else {
			$sql = "SELECT * FROM inv_user WHERE email ='$email' and password = '$mdpass'";
		    $result = mysqli_query($conn,$sql);
		    $row = mysqli_fetch_assoc($result);
		    $count  = mysqli_num_rows($result);

		    if($count == 1){
		    	$_SESSION['ID'] = $row['UserID'];
		        $_SESSION['email'] = $row['email'];
		        $_SESSION['pass'] = $row['password'];
		        $_SESSION['type'] = $row['acctype'];
		        if($_SESSION['type'] == "admin"){
		        	header("Location: ../dashboard.php?login=success");
		        }
		        elseif ($_SESSION['type'] == "ccm") {
		        	header("Location: ../CCM_Dashboard.php?login=success");
		        }
		        elseif ($_SESSION['type'] == "om") {
		        	header("Location: ../OM_Dashboard.php");
		        }
		        else {
		        	header("Location: ../gpki.php?login=error");
		        }
		        exit();
		    }

		    else {
		        header("Location: ../index.php?msg=failed");
		    }
		}
	}

	else {
		header("Location: ../index.php");
		exit();
	}

?>