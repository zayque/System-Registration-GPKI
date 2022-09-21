<?php
	
	include '../config.php';

	session_start();

	$req = $_POST['Request_No'];
	$to = $_POST['Company_name'];

	//Info
	$verifiedby = $_POST['Verify_By'];
	$verifieddate = $_POST['Verified_Date'];
	$status = $_POST['optradio'];
	$reasonstatus = $_POST['Reason_status'];

	//Casing Approval
	$approvecasing = $_POST['Approved_Casing'];
	$approvetoken = $_POST['Approved_Token'];

	$reasoncasing = $_POST['reason_casing'];
	$reasontoken = $_POST['Reason_Token'];

	//Get total token
	$tsql = "SELECT COUNT(*) FROM inv_inventory";
	$tresult = mysqli_query($conn,$tsql);
	$trow = mysqli_fetch_array($tresult);

	$blc = $trow[0];

	$sql = "SELECT * FROM inv_tempapp";
	$result = mysqli_query($conn,$sql);
	if (mysqli_fetch_assoc($result) > 0) {

		$sql = "INSERT INTO `inv_approval` (`RequestNumber`, `VerifiedBy`, `VerifiedDate`, `Status`, `Reason`, `CasingQty`, `ReasonCase`, `TokenQty`, `ReasonToken`) VALUES ('$req','$verifiedby','$verifieddate','$status','$reasonstatus','$approvecasing','$reasoncasing','$approvetoken','$reasontoken')";

		if (mysqli_query($conn,$sql)) {
			$sql = "INSERT INTO `inv_transfer` (`RequestNumber`,`SerialNumber`,`Date`) SELECT '$req',SerialNumber,NOW() FROM inv_tempapp";

			if (mysqli_query($conn,$sql)) {
				//Delete all the SerialNumber from inventory
					$sql = "SELECT * FROM inv_tempapp";
					$result = mysqli_query($conn,$sql);
					while ($row = mysqli_fetch_array($result)) {
						$tempnum = $row[1];

						$dsql = "DELETE FROM inv_inventory WHERE SerialNumber ='$tempnum'";
						mysqli_query($conn,$dsql);
					}

					$sql = "SELECT COUNT(*) from inv_inventory";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_array($result);

					$tokencalc = $row[0];

					$subtoken = $tokencalc - $approvetoken;

					$sql = "INSERT INTO `inv_tokenlog` (`No`, `Date`, `Description`, `Token_In`, `Token_Out`, `Balance`, `Remarks`) VALUES (NULL,NOW(),'Approved to $to',NULL,'$approvetoken','$subtoken','$verifiedby')";

					if (mysqli_query($conn,$sql)) {
						$sql = "TRUNCATE inv_tempapp";
						if(mysqli_query($conn,$sql)){
							$sql = "UPDATE `inv_userorder` SET `Status` = 'Approved' WHERE `inv_userorder`.`RequestNumber` = '$req'";
							if (mysqli_query($conn,$sql)) {
								//Select Balance
								$sql = "SELECT * FROM inv_casing ORDER BY ID DESC LIMIT 1";
								$result = mysqli_query($conn,$sql);
								$row = mysqli_fetch_array($result);

								$casingbalance = $row[3];

								$aftercalc = $casingbalance - $approvecasing;

								$isql = "INSERT INTO inv_casing (ID,Quantity,Date,Balance) VALUES (NULL,'-$approvecasing',NOW(),'$aftercalc')";
								if (mysqli_query($conn,$isql)) {
									$lsql = "INSERT INTO inv_casinglogs (No,Date,Description,Casing_In,Casing_Out,Balance,Remarks) VALUES (NULL,NOW(),'Casing sent to $to',NULL,'$approvecasing','$aftercalc','$verifiedby')";
									if (mysqli_query($conn,$lsql)) {
										$_SESSION['app'] = "success";
										header("Location: ../OM_Dashboard.php");
									} else {
										echo "Error 4516";
									}
								} else {
									echo "Erro 7568";
								}
							} else {

							}
						} else {
							echo "Error 546";
						}
					} else {
						echo "Error log 1101";
					}
			} else {
				echo "Error on transfering";
			}

		} else {
			echo "Error";
		}
	} else {
		$_SESSION['check'] = "empty";
		header("Location: ../view_detail_approve_request.php?req=$req");
	}

	

?>