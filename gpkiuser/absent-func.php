<?php

if (isset($_POST['submit'])) {
	
	include_once 'config-mysqli.php';

	$mykad1 = mysqli_real_escape_string($conn, $_POST['mykad1']);
	$comment1 = mysqli_real_escape_string($conn, $_POST['comment1']);
	
		
				if ($resultCheck > 0) {
					header("Location: absent.php?absent=usertaken");
					exit();
				} 
				else {
					
					//Insert the user into the database
					$sql = "INSERT INTO absent (mykad, sebab) VALUES ('$mykad1' , '$comment1' ); ";
					mysqli_query ($conn, $sql);
					
					echo "<script>alert('Terima Kasih Kerana Beri Kerjasama!');</script>";
					echo "<script>window.location='absent.php?absent=success';</script>";
					
					exit();
				}
} 
else {
	header("Location: absent.php");
	exit();
}