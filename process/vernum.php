<?php

session_start();

if(isset($_POST['submit'])){
	//Database connection
	include '../config.php';

	$reqnum = $_POST['vernum'];

	$sql = "SELECT * FROM inv_orderinfo WHERE RequestNumber = '$reqnum'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if($row["RequestNumber"] == $reqnum){
		if($row["Status"] == "Verified"){
			$_SESSION['ver'] = "error";
			header("Location: ../dashboard.php");
		}

		elseif($row["Status"] == "Pending"){
			$date = date("Y-m-d");
			$sql = "UPDATE inv_orderinfo SET Status = 'Verified',VerifiedDate ='$date', pdf = '1' WHERE `inv_orderinfo`.`RequestNumber` = '$reqnum'";
			if(mysqli_query($conn, $sql)){
				$sql = "SELECT * FROM inv_reqorder WHERE RequestNumber = '$reqnum'";
				$result = mysqli_query($conn,$sql);
				$row = mysqli_fetch_array($result);

				$ordertoken = $row['UsbTokenQty'];

				$sql = "INSERT INTO inv_transfer (RequestNumber,TokenNumber,Date) SELECT '$reqnum',TokenNumber,NOW() FROM inv_inventory LIMIT $ordertoken";
				if(mysqli_query($conn, $sql)){
					$sql = "SET GLOBAL FOREIGN_KEY_CHECKS=0";
					if(mysqli_query($conn, $sql)){

						$sql = "DELETE FROM inv_inventory LIMIT $ordertoken";
						if(mysqli_query($conn, $sql)){
							$_SESSION['ver'] = "success";
							header("Location: ../dashboard.php?action=success");
						} else{
							echo "Error 201";
						}
					}
					else {
						echo "Error 1001";
					}
				}
				else {
					echo "XAXAXA";
				}
			}

			else {
				echo "LALALA";
			}
		}

		elseif($row["Status"] == "Returned"){
			$_SESSION['ver'] = "wrong";
			header("Location: ../dashboard.php");
		}

	}

	else {
		$_SESSION['ver'] = "wrong";
		header("Location: ../dashboard.php");
	}
}





?>