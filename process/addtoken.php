<?php
	session_start();

	$remark = $_SESSION['email'];

	include '../config.php';

	//Information 
	$DeliveryOrderNumber = $_POST['Delivery_Order'];
	$DeliveryOrderDate = $_POST['Delivery_Order_Date'];
	$Type = $_POST['model'];
	$Quantity = $_POST['Quantity'];

	//Adding token casing
	if ($Type == "Token Case") {
		$sql = "SELECT * FROM inv_casing ORDER BY ID DESC LIMIT 1";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);

		$balance = $row[3] + $Quantity;

		$isql = "INSERT INTO inv_casing (ID,Quantity,Date,Balance) VALUES (NULL,'$Quantity','$DeliveryOrderDate','$balance')";
		if (mysqli_query($conn,$isql)) {
			$isql = "INSERT INTO inv_casinglogs (No,Date,Description, Casing_In,Casing_Out,Balance,Remarks) VALUES (NULL,NOW(),'RECEIVED CASING','$Quantity',NULL,$balance,'$remark')";
			if (mysqli_query($conn,$isql)) {
				$_SESSION['casing'] = "success";
				header("Location: ../add_token_stock.php");
			} else {
				echo "Problem";
			}
		} else {
			$_SESSION['casing'] = "error";
			header("Location: ../add_token_stock.php");
		}
	} 

	else{
		//Dah ada ke belum
		$sql = "SELECT COUNT(*) FROM inv_inventory";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);

		$balanceni = $row[0] + $Quantity;



		$sql = "SELECT * FROM inv_tempadd";
		$result = mysqli_query($conn,$sql);
		if(mysqli_fetch_assoc($result) > 0){
			$sql = "INSERT INTO inv_inventory (ID,SerialNumber,ModelType,DeliveryOrderNumber) SELECT NULL,SerialNumber,'$Type','$DeliveryOrderNumber' FROM inv_tempadd";
			if (mysqli_query($conn,$sql)) {
				$sql = "TRUNCATE inv_tempadd";
				if(mysqli_query($conn,$sql)){
					$sql = "INSERT INTO inv_addtoken (DeliveryOrderNumber,DeliveryOrderDate,ModelType,Quantity) VALUES ('$DeliveryOrderNumber','$DeliveryOrderDate','$Type','$Quantity')";
					if (mysqli_query($conn,$sql)) {
						$sql = "INSERT INTO `inv_tokenlog` (`No`, `Date`, `Description`, `Token_In`, `Token_Out`, `Balance`, `Remarks`,`ModalType`) VALUES (NULL,'$DeliveryOrderDate','Token Add into Inventory','$Quantity',NULL,'$balanceni','$remark','$Type')";
						if (mysqli_query($conn,$sql)) {
							$_SESSION['token'] = "success";
							header("Location: ../add_token_stock.php");
						} else {
							echo "Ops";
						}
					} else {
						echo "Last error";
					}
				} else {
					echo "Truncate error";
				}
			} else {
				echo "No token";
			}
		} else {
			$_SESSION['token'] = "wrong";
			header("Location: ../add_token_stock.php");
		}

		
	}
?>