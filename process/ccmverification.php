<?php
session_start();

if (isset($_POST['submit'])) {
	include 'function.php';

	include '../config.php';

	//Applicant Information
	$reqnum = $_POST["Request_No"];

	$veriby = $_POST["Verify_By"];
	$veridate = $_POST["Verified_Date"];
	$casingqty = $_POST["Casing_Quantity"];
	$status = $_POST["optradio"];
	$reason = $_POST["Reason"];

	$sql = "SELECT * FROM inv_userorder WHERE RequestNumber = '$reqnum'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if($row["RequestNumber"] == $reqnum){
		if ($row["Status"] == "Verified") {
			$_SESSION['ver'] = "error";
			header("Location: ../CCM_Dashboard.php?Error");
		}

		elseif ($row["Status"] == "Pending") {
			$sql = "UPDATE inv_userorder SET VerifiedBy ='$veriby',VerifiedDate = '$veridate',casingqty = '$casingqty',Reason = '$reason',Status = '$status', pdf = '1' WHERE RequestNumber = '$reqnum'";
			if(mysqli_query($conn,$sql)){
				SendMailVerify($reqnum,$veriby);
				$_SESSION['ver'] = "success";
				header("Location: ../CCM_Dashboard.php?=success");
			} else {
				echo "Error exec SQL";
			}
		} 

		elseif ($row["Status"] == "Completed") {
			$_SESSION['ver'] = "error";
			header("Location: ../CCM_Dashboard.php?=success");
		} else {
			echo "Error 1101";
		}
	} else {
		echo "Not == RequestNumber";
	}

} else {
	echo "Something wrong";
}

?>