<?php

session_start();

if(isset($_POST['submit'])){
	//Database connection
	include '../config.php';

	$serialnumber = $_POST['singlereturn'];

	//Get the RequestNumber
	$sql = "SELECT * FROM inv_transfer WHERE TokenNumber = '$serialnumber'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	$reqnum = $row["RequestNumber"];

	//Check inv_return dh ada ke belum
	$sql = "SELECT COUNT(*) FROM inv_transfer WHERE TokenNumber = '$serialnumber'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if($row["COUNT(*)"] == 0){
		$_SESSION["returnsingle"] = "wrong";
		header("Location: ../dashboard.php?=error");
	}
	elseif($row["COUNT(*)"] == 1){
		//Check inside the return 
		$sql = "SELECT COUNT(*) FROM inv_return WHERE TokenNumber = '$serialnumber'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		//Can insert inside here
		if($row["COUNT(*)"] == 0){
			$sql = "INSERT INTO inv_return (RequestNumber,TokenNumber,Date) VALUES ('$reqnum','$serialnumber',NOW())";
			if(mysqli_query($conn, $sql)){
				//Check for all data 
				$sql = "SELECT COUNT(*) FROM inv_return WHERE RequestNumber = '$reqnum'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);

				$totalinreturn = $row["COUNT(*)"];

				$sql = "SELECT COUNT(*) FROM inv_transfer WHERE RequestNumber = '$reqnum'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);

				$totalintransfer = $row["COUNT(*)"];

				if($totalinreturn == $totalintransfer){
					$sql = "UPDATE inv_orderinfo SET Status = 'Returned',VerifiedDate = NOW(), pdf = '1' WHERE RequestNumber = '$reqnum'";
					if(mysqli_query($conn,$sql)){
						echo "Updated";
					}else{
						echo "Not updated";
					}
				} else{
					$_SESSION["returnsingle"] = "success";
					header("Location: ../dashboard.php?=success");
				}
			}
			else{
				echo "Nope";
			}
		}
		//Serial number same get out
		elseif($row["COUNT(*)"] > 0){
			$_SESSION["returnsingle"] = "error";
			header("Location: ../dashboard.php?=error");
		}
	}
	
}
else {
	echo "Is this?";
}

?>