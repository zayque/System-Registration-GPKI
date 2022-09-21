<?php
session_start();

  if(isset($_POST['SUBMIT'])){
  	include_once 'function.php';

	//Requester Information
	$requestnum = "";
	$date = date("Y-m-d");
	$companyname = $_POST["companyname"];
	$designation = $_POST["designation"];
	$applicantname = $_POST["applicantName"];
	$NRIC = $_POST["NRIC"];
	$address = $_POST["address"];
	$contactNo = $_POST["contact_no"];

	//Stock request
	$modelreq1 = $_POST["modelset1"];
	$quantity_index1 = $_POST["quantity_index1"];
	$modelreq2 = $_POST["modelset2"];
	$quantity_index2 = $_POST["quantity_case"];


	GenerateOrder();

	echo "This is last number ".$requestnum;

	echo "<br>Run this after generate order";

	include '../config.php';

	/*$sql = "INSERT INTO inv_orderinfo (RequestNumber,date,CompanyName,Designation,ApplicantName,NRIC,Address,ContactNo) VALUES ('$requestnum','$date','$companyname','$designation','$applicantname','$NRIC','$address','$contactNo')";*/

	$sql = "INSERT INTO inv_orderinfo (RequestNumber,date,CompanyName,Designation,ApplicantName,NRIC,Address,ContactNo,Status,pdf) VALUES ('$requestnum','$date','$companyname','$designation','$applicantname','$NRIC','$address','$contactNo','Pending','0')";

	if(mysqli_query($conn,$sql)){
		echo "Data entered";
		$sql2 = "INSERT INTO inv_reqorder(RequestNumber,ModelType,UsbTokenQty,TokenCasingQty,date) VALUES ('$requestnum','$modelreq1','$quantity_index1','$quantity_index2','$date')";
		if(mysqli_query($conn,$sql2)){
			echo "Second data entered";
			$_SESSION['alert'] = "success";
			$_SESSION['showreqno'] = $requestnum;

			SendMail($requestnum,$date,$companyname,$designation,$applicantname,$NRIC,$address,$contactNo,$modelreq1,$quantity_index1,$modelreq2,$quantity_index2);
		}
		else {
			echo "entah la nak";
		}
	}
	else {
		echo "something happend";
	}
	echo $quantity_index2;
  } 
  else {
  	header("Location: ../index.php");
  }
?>