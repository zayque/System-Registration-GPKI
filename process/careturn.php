<?php

session_start();

$remark = $_SESSION['email'];

//Information
$RequestNumber = $_POST['request_no'];
$Model = $_POST['TokenType'];
$Quantity = $_POST['Quantity'];
$Reason = $_POST['Reason'];

include '../config.php';

include 'function.php';

CheckReturn();

$setReturnid = $returnid;

if ($Model == 'Token Case') {
	$bsql = "SELECT * FROM inv_casing ORDER BY ID DESC LIMIT 1";
	$bresult = mysqli_query($conn,$bsql);
	$brow = mysqli_fetch_array($bresult);

	$sql = "SELECT * FROM inv_userorder WHERE RequestNumber = '$RequestNumber'";
	$result = mysqli_query($conn,$sql);
	if (mysqli_num_rows($result) > 0) {
		$sql = "INSERT INTO inv_casinglogs (No,Date,Description,Casing_In,Casing_Out,Balance,Remarks) VALUES (NULL,NOW(),'Casing return $RequestNumber','$Quantity',NULL,'$brow[3]','$remark')";
		if (mysqli_query($conn,$sql)) {
			$_SESSION['casing'] = "success";
			header("Location: ../view_detail_return_tokenByCA.php?=Success");
		}
	}
} else {
	$sql = "SELECT * FROM inv_userorder WHERE RequestNumber ='$RequestNumber'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_array($result);

		$file = $setReturnid."-".$_FILES['file']['name'];
	    $file_loc = $_FILES['file']['tmp_name'];
		$file_size = $_FILES['file']['size'];
		$file_type = $_FILES['file']['type'];
		$folder="careturn/";

		// new file size in KB
		$new_size = $file_size/1024;  
		// new file size in KB

		// make file name in lower case
		$new_file_name = strtolower($file);
		// make file name in lower case

		if ($file_type == 'application/pdf') {
			$final_file=str_replace(' ','-',$new_file_name);

			if(move_uploaded_file($file_loc,$folder.$final_file)){ 

				$sql = "INSERT INTO `inv_careturn` (`RequestNumber`, `CA`, `ModelType`, `QuantityReturn`, `Reason`, `Document`,`returnid`) VALUES ('$RequestNumber','$row[2]','$Model','$Quantity','$Reason','$final_file','$setReturnid')";
				if(mysqli_query($conn,$sql)){
					$sql = "INSERT INTO inv_returnstorage (RequestNumber,SerialNumber,ModelType,Date,returnid) SELECT '$RequestNumber',SerialNumber,'$Model',NOW(),'$setReturnid' FROM inv_tempreturn";
					if (mysqli_query($conn,$sql)) {
						$sql = "TRUNCATE inv_tempreturn";
						if (mysqli_query($conn,$sql)) {
							$sql = "INSERT INTO `inv_tokenlog` (`No`, `Date`, `Description`, `Token_In`, `Token_Out`, `Balance`, `Remarks`) VALUES (NULL,NOW(), '$Reason', NULL, NULL, NULL, '$remark')";
							if (mysqli_query($conn,$sql)) {
								$_SESSION["ret"] = "success";
								header("Location: ../view_detail_return_tokenByCA.php?=Success");
							} else {
								echo "Entah kenape";
							}
						}
					}
				} else {
					echo "Not Success";
				}
			} else {
				echo "Error 1150";
			}

		} else {
			echo "Not pdf";
		}

	} else {
		$_SESSION["ret"] = "wrong";
		header("Location: ../view_detail_return_tokenByCA.php?=Invalid Req Number");
	}
}






?>