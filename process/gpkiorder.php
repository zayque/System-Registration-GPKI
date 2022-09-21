<?php

session_start([
    'cookie_lifetime' => 86400,
    'read_and_close'  => true,
]);
	
	if (isset($_POST['SUBMIT'])) {
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
		$modelreq1 = $_POST["modelset"];
		$quantity_index1 = $_POST["quantity_index1"];
		$inhand = $_POST["balance"];

		GenerateOrder();

		include '../config.php';

		//Attachment
		$file = $requestnum."-".$_FILES['file']['name'];
	    $file_loc = $_FILES['file']['tmp_name'];
		$file_size = $_FILES['file']['size'];
		$file_type = $_FILES['file']['type'];
		$folder="uploads/";

		$sql = "INSERT INTO inv_userorder (`RequestNumber`, `Date`, `CompanyName`, `Designation`, `ApplicantName`, `NRIC`, `Address`,`Contact`, `Status`, `VerifiedDate`, `VerifiedBy`, `pdf`,`inhand`,`casingqty`,`Reason`) VALUES ('$requestnum','$date','$companyname','$designation','$applicantname','$NRIC','$address','$contactNo','Pending', NULL, '', '0','$inhand','0','')";

		if(mysqli_query($conn, $sql)){
			$sql = "INSERT INTO inv_orderdetails (`RequestNumber`,`ModelType`,`Qty`) VALUES ('$requestnum','$modelreq1','$quantity_index1')";
			if (mysqli_query($conn,$sql)) {
				$file = $requestnum."-".$_FILES['file']['name'];
			    $file_loc = $_FILES['file']['tmp_name'];
				$file_size = $_FILES['file']['size'];
				$file_type = $_FILES['file']['type'];
				$folder="uploads/";

				// new file size in KB
				$new_size = $file_size/1024;  
				// new file size in KB

				// make file name in lower case
				$new_file_name = strtolower($file);
				// make file name in lower case

				if ($file_type == 'application/pdf') {
					$final_file=str_replace(' ','-',$new_file_name);

					if(move_uploaded_file($file_loc,$folder.$final_file)){ 
						$sql = "INSERT INTO inv_uploads (RequestNumber,file,type,size) VALUES ('$requestnum','$final_file','$file_type','$new_size')";

						if(mysqli_query($conn, $sql)){
							$_SESSION['alert'] = 'success';
					        $_SESSION['showreqno'] = $requestnum;
					        GenerateInvoiceGPKI($requestnum);
					        $_SESSION['pdf'] = $final_file;
					        SendMailGPKI($requestnum,$date,$companyname,$designation,$applicantname,$NRIC,$address,$inhand,$modelreq1,$quantity_index1);

							?>
							<script>
							alert('successfully uploaded');
					        window.location.href='../gpki.php?success';
					        </script>
					        <?php 
						}

						
					} else {
						?>
						<script>
						alert('error while uploading file');
				        window.location.href='../gpki.php?fail';
				        </script>
				        <?php
					}
				} else {
					$_SESSION['alert'] = 'failed';
					$_SESSION['showreqno'] = null;
					header("Location: ../gpki.php?fail");

				}
				
			} else {
				echo "Error ";
			}
		} else {
			echo "Error inserting into inv_useroder!";
		}
	} else {
		header("Location: ../gpki.php");
	}

	
?>