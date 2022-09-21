<?php

session_start();

if(isset($_POST['submit'])){
	//Database connection
	include '../config.php';

	$return = $_POST['returnform'];

	//Check for status
	$sql = "SELECT * FROM inv_orderinfo WHERE RequestNumber = '$return'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if($row["Status"] == "Verified"){
		//Check for  1 | 0
		$sql = "SELECT * FROM inv_transfer WHERE RequestNumber = '$return'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$count = mysqli_num_rows($result);
		
		if($count > 0){
			echo "Error B<br>";
			$a = $row["TokenNumber"];
			for($x = 0;$x < $count;$x++){
				$total = $a + $x;
				//echo $total."<br>";
				$sql = "SELECT COUNT(*) FROM inv_return WHERE TokenNumber = '$total'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);

				if($row["COUNT(*)"] == 1){
					echo "Do nothing";
				}
				elseif($row["COUNT(*)"] == 0){
					$sql = "INSERT INTO inv_return (RequestNumber,TokenNumber,Date) VALUES ('$return','$total',NOW())";
					if(mysqli_query($conn, $sql)){
						echo "Inseted<br>";
					}
					else {
						echo "Why not";
					}
				}
				//Check all returned?
				$sql = "SELECT COUNT(*) FROM inv_return WHERE RequestNumber = '$return'";
				$result = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($result);

				$totalinreturn = $row["COUNT(*)"];

				$sql = "SELECT COUNT(*) FROM inv_transfer WHERE RequestNumber = '$return'";
				$result = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($result);

				$totalintransfer = $row["COUNT(*)"];

				if($totalinreturn == $totalintransfer){
					$sql = "UPDATE inv_orderinfo SET Status = 'Returned',VerifiedDate = NOW(), pdf = '1' WHERE RequestNumber = '$return'";
					if(mysqli_query($conn, $sql)){
						$_SESSION["return"] = "success";
						header("Location: ../dashboard.php?=Returned");
					}
					else{
						echo "Oh no";
					}
				}
				else {
					echo "Not yet<br>";
				}

			}
		} else{
			echo "lalala";
		}
	}

	elseif($row["Status"] == "Pending"){
		$_SESSION["return"] = "pending";
		header("Location: ../dashboard.php?=Error");
	}

	elseif($row["Status"] == "Returned"){
		$_SESSION["return"] = "error";
		header("Location: ../dashboard.php?=Error");
	} 

	else{
		$_SESSION["return"] = "wrong";
		header("Location: ../dashboard.php?=Error");
	}

	/*
	//Check for 
	$sql = "SELECT * FROM inv_transfer WHERE RequestNumber = '$return'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$count = mysqli_num_rows($result);
	
	if($count > 0){
		echo "Error B<br>";
		$a = $row["TokenNumber"];
		for($x = 0;$x < $count;$x++){
			$total = $a + $x;
			echo $total."<br>";
			$sql = "SELECT COUNT(*) FROM inv_return WHERE TokenNumber = '$total'";
		}
	} else{
		echo "Code not exist";
	}

	
	if($count > 0) {
		$sql = "INSERT INTO inv_return (RequestNumber,TokenNumber,Date) SELECT RequestNumber,TokenNumber,NOW() FROM inv_transfer WHERE RequestNumber = '$return'";
		if(mysqli_query($conn, $sql)){
				$sql = "UPDATE inv_orderinfo SET Status = 'Returned' WHERE RequestNumber = '$return'";
				if(mysqli_query($conn, $sql)){
					$_SESSION['return'] = "success";
					header("Location: ../dashboard.php?=tokenreturned");	
				}
				else {
					echo "Error 1";
				}
			}
		}
		else {
			echo "Error 3";
		}*/
}
?>