<?php

//Import Mailer classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Execption;




function GenerateOrder(){
	start:
	include '../config.php';
	global $requestnum;
	$requestnum = "T".rand(1000,9999);

	$sql = "SELECT RequestNumber FROM inv_userorder WHERE RequestNumber = '$requestnum'";
	$result = mysqli_query($conn,$sql);

	if (mysqli_num_rows($result) > 0) {
		goto start;
	} 

	else {
	    //echo "Insert data without hesitation<br>";
	}
}

function CheckReturn(){
	include '../config.php';
	start:
	global $returnid;
	$returnid = rand(1000,9999);

	//Check in databse for unique
	$sql = "SELECT returnid FROM inv_returnstorage WHERE returnid = '$returnid'";
	$result = mysqli_query($conn,$sql);

	if (mysqli_num_rows($result) > 0) {
		goto start;
	} else {
		//Do nothing;
	}
}

function UploadPDF() {

	include '../config.php';

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
	
	$final_file=str_replace(' ','-',$new_file_name);

	if(move_uploaded_file($file_loc,$folder.$final_file)){ 
		$sql = "INSERT INTO inv_uploads (RequestNumber,file,type,size) VALUES ('$requestnum','$final_file','$file_type','$new_size')";

		mysqli_query($conn, $sql);
		?>
		<script>
		alert('successfully uploaded');
        window.location.href='index.php?success';
        </script>
        <?php 
	} else {
		?>
		<script>
		alert('error while uploading file');
        window.location.href='index.php?fail';
        </script>
        <?php
	}
}

function SendMailGPKI($requestnum,$date,$companyname,$designation,$applicantname,$NRIC,$address,$inhand,$modelreq1,$quantity_index1){

	ob_start();

	$location = $_SESSION['pdf'];
	$req = $_SESSION['showreqno'];

	//Composer
	require '../vendor/autoload.php';

	$mail = new PHPMailer(true);
	try {
		//Server Setting
		$mail->SMTPDebug = 2;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = 'm.ilham3232';
		$mail->Password = 'il1221ilham';
		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
			);

		//Recipients
		$mail->setFrom('no-reply@gmail.com');
		$mail->FromName = ''.$companyname.''; //Big title
		$mail->addAddress('syarifuddin1231@gmail.com'); //Siapa yg akan terima
		$mail->addReplyTo('no-reply@gmail.com'); //Akan reply dekat siapa

		//Content
		$mail->isHTML(true);
		$mail->AddAttachment('uploads/'.$location.'');
		$mail->AddAttachment('invoice/'.$req.'.pdf');
		$mail->Subject = 'Token Inquiry';
		$mail->Body = 'Token Inquiry';
		$mail->AltBody = 'Augmented'; //For non HTML mail people

		if($mail->send()) {
			header("Location: ../gpki.php?=Order Submitted");
			ob_end_flush();
		}

	} catch (Exception $e) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErorrInfo;
	}
}

function GenerateInvoiceGPKI($reqnum){

require('../fpdf/fpdf.php');

include ('../config.php');

class PDF extends FPDF {
	function Header(){
		include '../config.php';

		//Variable
		global $reqnum;
		$reqnum = $_SESSION["showreqno"];
	
		$this->SetFont('Arial','B',14);

		//Cell to put logo
		//$this->Cell(12,0,'',0,0);
		//is equivalent to:
		$this->Cell(12);

		// Insert a dynamic image from a URL
		$this->Image('../img/logo.jpg',10,10,35);

		//Dummy cell to give line spacing
		//$this->Cell(0,5,'',0,1);
		//Is equivalent to:
		$this->Ln(15);

		//set font to arial bold 14pt
		$this->SetFont('Arial','B',12);

		//Cell (width, height,text,border, end line , [align])
		$this->Cell(68	,5,'Augmented Technology Sdn Bhd',0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(62, 5,'982056-V',0,0);
		$this->Cell(59	,5,'',0,1);

		//set font to arial, regular, 12pt
		$this->SetFont('Arial','',12);

		$this->Cell(130	,5,'No 38 Jalan BM 7/19,Bandar Bukit Mahkota, 43000,Kajang,Selangor,Malaysia',0,0);
		$this->Cell(59	,5,'',0,1);

		$this->Cell(130	,5,'Tel: +(603) 89229474 Fax: +(603) 89229473',0,0);
		$this->Cell(59	,5,'',0,1);

		$this->Ln(5);

		//set font to arial bold 14pt
		$this->SetFont('Arial','B',14);

		$this->Cell(120	,5,'',0,0);
		$this->Cell(69	,5,'TOKEN GPKI REQUEST FORM',0,1);
		$this->Ln(5);
	}	
}

$pdf = new PDF('P','mm','A4'); //use new class

//define new alias for total page numbers

$pdf->AddPage();

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(189,10,'Requester Information',0,1,'C', TRUE);

$pdf->Ln(5);

$sql = "SELECT * FROM inv_userorder WHERE RequestNumber = '$reqnum'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)){
	$data = mysqli_fetch_assoc($result);
}

$pdf->Cell(40	,5,'Request Number',0,0);
$pdf->Cell(75	,5,':'.$reqnum.'',0,0);
$pdf->Cell(25	,5,'Date',0,0);
$pdf->Cell(46	,5,':'.date("M d,Y", strtotime($data["Date"])).'',0,1);

$pdf->Cell(40	,5,'Company Name',0,0);
$pdf->Cell(75	,5,':'.$data["CompanyName"].'',0,0);
$pdf->Cell(25	,5,'Designation',0,0);
$pdf->Cell(46	,5,':'.$data["Designation"].'',0,1);

$pdf->Cell(40	,5,'Applicant Name',0,0);
$pdf->Cell(75	,5,':'.$data["ApplicantName"].'',0,0);
$pdf->Cell(25	,5,'I/C No.',0,0);
$pdf->Cell(46	,5,':'.$data["NRIC"].'',0,1);

$pdf->Cell(40	,5,'',0,0);
$pdf->Cell(75	,5,'',0,0);
$pdf->Cell(25	,5,'Contact No.',0,0);
$pdf->Cell(46	,5,':'.$data["Contact"].'',0,1);

$pdf->Cell(40	,5,'Address ',0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(146	,5,': '.$data["Address"].'',0,1);

$pdf->Ln(5);

$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(189,10,'Stock Request Information',0,1,'C', TRUE);

$pdf->Ln(5);

$sql2 = "SELECT * FROM inv_orderdetails WHERE RequestNumber = '$reqnum'";
$result2 = mysqli_query($conn,$sql2);

if(mysqli_num_rows($result2)){
	$data2 = mysqli_fetch_assoc($result2);
}

$pdf->Cell(30	,5,'Model/Type',0,0);
$pdf->Cell(65	,5,': ST3 USB TOKEN',0,0);
$pdf->Cell(45	,5,'Quantity Required',0,0);
$pdf->Cell(46	,5,':'.$data2["Qty"].'',0,1);

$pdf->Ln(5);

$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(189,10,'Current Stock in Hand Information',0,1,'C', TRUE);

$pdf->Ln(5);

$pdf->Cell(30	,5,'Balance',0,0);
$pdf->Cell(65	,5,':'.$data["inhand"].'',0,1);


$pdf->Ln(5);

$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(189,10,'Rules and Regulations',0,1,'C', TRUE);

$pdf->SetFont('Arial','',10);
$pdf->Cell(10	,5,'1.',0,0);
$pdf->Cell(50	,5,'The Requester will:',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'a.',0,0);
$pdf->Cell(164	,5,'Ensure the requested stock to be keep in secured area/locker when not in use.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'b.',0,0);
$pdf->Cell(164	,5,'Do daily tracking/inventory of usage.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'c.',0,0);
$pdf->Cell(164	,5,'Use the stock only for company activity.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'d.',0,0);
$pdf->Cell(164	,5,'Report any malfunctions or defect to the company.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'e.',0,0);
$pdf->Cell(164	,5,'Return the given stock when required to the company.',0,1);

$pdf->Ln(5);

$pdf->Cell(10	,5,'2.',0,0);
$pdf->Cell(50	,5,'The Requester will NOT:',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'a.',0,0);
$pdf->Cell(164	,5,'Transfer possession, assign use or sell of the stock given to anyone else.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'b.',0,0);
$pdf->Cell(164	,5,'Tamper or repair by yourself in case of defect.',0,1);

$pdf->Ln(5);

$pdf->Cell(189	,5,'By completing and signing this form, I have read the rights and responsibilities of the stock take',0,1);
$pdf->Cell(189	,5,'as contained in this request form and agree to abide by the rues and regulations.',0,1);

$pdf->Ln(2);

$pdf->Cell(94	,5,'Requested By:',0,0);
$pdf->Cell(94	,5,'Approved By:',0,0);

$pdf->Ln(23);

$pdf->Cell(94	,5,'.........................................................................................',0,0);
$pdf->Cell(94	,5,'.........................................................................................',0,1);

$pdf->Ln(1);

$pdf->Cell(25	,5,'Name:',1,0);
$pdf->Cell(64	,5,'',1,0);
$pdf->Cell(4	,5,'',0,0);
$pdf->Cell(25	,5,'Name:',1,0);
$pdf->Cell(64	,5,'',1,1);

$pdf->Cell(25	,5,'IC No.:',1,0);
$pdf->Cell(64	,5,'',1,0);
$pdf->Cell(4	,5,'',0,0);
$pdf->Cell(25	,5,'IC No.:',1,0);
$pdf->Cell(64	,5,'',1,1);

$pdf->Cell(25	,5,'Designation:',1,0);
$pdf->Cell(64	,5,'',1,0);
$pdf->Cell(4	,5,'',0,0);
$pdf->Cell(25	,5,'Designation:',1,0);
$pdf->Cell(64	,5,'',1,1);

$pdf->Cell(25	,5,'Date:',1,0);
$pdf->Cell(64	,5,'',1,0);
$pdf->Cell(4	,5,'',0,0);
$pdf->Cell(25	,5,'Date:',1,0);
$pdf->Cell(64	,5,'',1,1);

$path = "invoice/".$reqnum.".pdf";


$pdf->Output($path, 'F');
}

function GenerateInvoiceEcourt($reqnum){


require('../fpdf/fpdf.php');

include ('../config.php');

class PDF extends FPDF {
	function Header(){
		include '../config.php';

		//Variable
		global $reqnum;
		$reqnum = $_SESSION["showreqno"];
	
		$this->SetFont('Arial','B',14);

		//Cell to put logo
		//$this->Cell(12,0,'',0,0);
		//is equivalent to:
		$this->Cell(12);

		// Insert a dynamic image from a URL
		$this->Image('../img/logo.jpg',10,10,35);

		//Dummy cell to give line spacing
		//$this->Cell(0,5,'',0,1);
		//Is equivalent to:
		$this->Ln(15);

		//set font to arial bold 14pt
		$this->SetFont('Arial','B',10);

		//Cell (width, height,text,border, end line , [align])
		$this->Cell(68	,5,'Augmented Technology Sdn Bhd',0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(62, 5,'982056-V',0,0);
		$this->Cell(59	,5,'',0,1);

		//set font to arial, regular, 12pt
		$this->SetFont('Arial','',10);

		$this->Cell(130	,5,'No 38 Jalan BM 7/19,Bandar Bukit Mahkota, 43000,Kajang,Selangor,Malaysia',0,0);
		$this->Cell(59	,5,'',0,1);

		$this->Cell(130	,5,'Tel: +(603) 89229474 Fax: +(603) 89229473',0,0);
		$this->Cell(59	,5,'',0,1);

		$this->Ln(5);

		//set font to arial bold 14pt
		$this->SetFont('Arial','B',14);

		$this->Cell(107	,5,'',0,0);
		$this->Cell(71	,5,'TOKEN ECOURT REQUEST FORM',0,1);
		$this->Ln(5);
	}	
}

$pdf = new PDF('P','mm','A4'); //use new class

//define new alias for total page numbers

$pdf->AddPage();

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(189,10,'Requester Information',0,1,'C', TRUE);

$pdf->Ln(5);

$sql = "SELECT * FROM inv_userorder WHERE RequestNumber = '$reqnum'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)){
	$data = mysqli_fetch_assoc($result);
}

$pdf->Cell(40	,5,'Request Number',0,0);
$pdf->Cell(75	,5,':'.$reqnum.'',0,0);
$pdf->Cell(25	,5,'Date',0,0);
$pdf->Cell(46	,5,':'.date("M d,Y", strtotime($data["Date"])).'',0,1);

$pdf->Cell(40	,5,'Company Name',0,0);
$pdf->Cell(75	,5,':'.$data["CompanyName"].'',0,0);
$pdf->Cell(25	,5,'Designation',0,0);
$pdf->Cell(46	,5,':'.$data["Designation"].'',0,1);

$pdf->Cell(40	,5,'Applicant Name',0,0);
$pdf->Cell(75	,5,':'.$data["ApplicantName"].'',0,0);
$pdf->Cell(25	,5,'I/C No.',0,0);
$pdf->Cell(46	,5,':'.$data["NRIC"].'',0,1);

$pdf->Cell(40	,5,'',0,0);
$pdf->Cell(75	,5,'',0,0);
$pdf->Cell(25	,5,'Contact No.',0,0);
$pdf->Cell(46	,5,':'.$data["Contact"].'',0,1);

$pdf->Cell(40	,5,'Address ',0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(146	,5,': '.$data["Address"].'',0,1);

$pdf->Ln(5);

$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(189,10,'Stock Request Information',0,1,'C', TRUE);

$pdf->Ln(5);

$sql2 = "SELECT * FROM inv_orderdetails WHERE RequestNumber = '$reqnum'";
$result2 = mysqli_query($conn,$sql2);

$x = 0;

while($row = mysqli_fetch_array($result2)){
	$y[$x] = $row[2];
	$x++;
}

$pdf->Cell(30	,5,'Model/Type',0,0);
$pdf->Cell(65	,5,': ST3 USB TOKEN',0,0);
$pdf->Cell(45	,5,'Quantity Required',0,0);
$pdf->Cell(46	,5,':'.$y[0].'',0,1);

$pdf->Cell(30	,5,'Model/Type',0,0);
$pdf->Cell(65	,5,': ST3 USB TOKEN',0,0);
$pdf->Cell(45	,5,'Quantity Required',0,0);
$pdf->Cell(46	,5,':'.$y[1].'',0,1);

$pdf->Ln(5);

$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(189,10,'Current Stock in Hand Information',0,1,'C', TRUE);

$pdf->Ln(5);

$pdf->Cell(30	,5,'Balance',0,0);
$pdf->Cell(65	,5,':'.$data["inhand"].'',0,1);


$pdf->Ln(5);

$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(189,10,'Rules and Regulations',0,1,'C', TRUE);

$pdf->SetFont('Arial','',10);
$pdf->Cell(10	,5,'1.',0,0);
$pdf->Cell(50	,5,'The Requester will:',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'a.',0,0);
$pdf->Cell(164	,5,'Ensure the requested stock to be keep in secured area/locker when not in use.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'b.',0,0);
$pdf->Cell(164	,5,'Do daily tracking/inventory of usage.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'c.',0,0);
$pdf->Cell(164	,5,'Use the stock only for company activity.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'d.',0,0);
$pdf->Cell(164	,5,'Report any malfunctions or defect to the company.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'e.',0,0);
$pdf->Cell(164	,5,'Return the given stock when required to the company.',0,1);

$pdf->Ln(5);

$pdf->Cell(10	,5,'2.',0,0);
$pdf->Cell(50	,5,'The Requester will NOT:',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'a.',0,0);
$pdf->Cell(164	,5,'Transfer possession, assign use or sell of the stock given to anyone else.',0,1);

$pdf->Cell(15	,5,'',0,0);
$pdf->Cell(10	,5,'b.',0,0);
$pdf->Cell(164	,5,'Tamper or repair by yourself in case of defect.',0,1);

$pdf->Ln(2);

$pdf->Cell(189	,5,'By completing and signing this form, I have read the rights and responsibilities of the stock take',0,1);
$pdf->Cell(189	,5,'as contained in this request form and agree to abide by the rues and regulations.',0,1);

$pdf->Ln(2);

$pdf->Cell(94	,5,'Requested By:',0,0);
$pdf->Cell(94	,5,'Approved By:',0,0);

$pdf->Ln(21);

$pdf->Cell(94	,5,'.........................................................................................',0,0);
$pdf->Cell(94	,5,'.........................................................................................',0,1);

$pdf->Ln(1);

$pdf->Cell(25	,5,'Name:',1,0);
$pdf->Cell(64	,5,'',1,0);
$pdf->Cell(4	,5,'',0,0);
$pdf->Cell(25	,5,'Name:',1,0);
$pdf->Cell(64	,5,'',1,1);

$pdf->Cell(25	,5,'IC No.:',1,0);
$pdf->Cell(64	,5,'',1,0);
$pdf->Cell(4	,5,'',0,0);
$pdf->Cell(25	,5,'IC No.:',1,0);
$pdf->Cell(64	,5,'',1,1);

$pdf->Cell(25	,5,'Designation:',1,0);
$pdf->Cell(64	,5,'',1,0);
$pdf->Cell(4	,5,'',0,0);
$pdf->Cell(25	,5,'Designation:',1,0);
$pdf->Cell(64	,5,'',1,1);

$pdf->Cell(25	,5,'Date:',1,0);
$pdf->Cell(64	,5,'',1,0);
$pdf->Cell(4	,5,'',0,0);
$pdf->Cell(25	,5,'Date:',1,0);
$pdf->Cell(64	,5,'',1,1);

$path = "invoice/".$reqnum.".pdf";


$pdf->Output($path, 'F');

}

function SendMailEcourt($requestnum,$companyname){

	ob_start();

	session_start();

	$location = $_SESSION['pdf'];
	$req = $_SESSION['showreqno'];

	//Composer
	require '../vendor/autoload.php';

	$mail = new PHPMailer(true);
	try {
		//Server Setting
		$mail->SMTPDebug = 2;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = 'm.ilham3232';
		$mail->Password = 'il1221ilham';
		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
			);

		//Recipients
		$mail->setFrom('no-reply@gmail.com');
		$mail->FromName = ''.$companyname.''; //Big title
		$mail->addAddress('ilham.zahari@aug-tech.com'); //Siapa yg akan terima
		$mail->addReplyTo('no-reply@gmail.com'); //Akan reply dekat siapa

		//Content
		$mail->isHTML(true);
		$mail->AddAttachment('uploads/'.$location.'');
		$mail->AddAttachment('invoice/'.$req.'.pdf');
		$mail->Subject = 'Token Inquiry';
		$mail->Body = 'Token Inquiry';
		$mail->AltBody = 'Augmented'; //For non HTML mail people

		if($mail->send()) {
			header("Location: ../ecourt.php?=Order Submitted");
			ob_end_flush();
		}

	} catch (Exception $e) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErorrInfo;
	}
}

function SendMailVerify($requestnum,$by) {
	ob_start();

	session_start();

	$em = $by;

	$req = $requestnum;

	//Composer
	require '../vendor/autoload.php';

	$mail = new PHPMailer(true);
	try {
		//Server Setting
		$mail->SMTPDebug = 2;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = 'm.ilham3232';
		$mail->Password = 'il1221ilham';
		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
			);

		//Recipients
		$mail->setFrom('no-reply@gmail.com');
		$mail->FromName = ''.$em.''; //Big title
		$mail->addAddress('ilham.zahari@aug-tech.com'); //Siapa yg akan terima
		$mail->addReplyTo('no-reply@gmail.com'); //Akan reply dekat siapa

		//Content
		$mail->isHTML(true);
		$mail->Subject = 'Token Verification';
		$mail->Body = 'Token '.$req.' has been verified';
		$mail->AltBody = 'Augmented'; //For non HTML mail people

		if($mail->send()) {
			header("Location: ../CCM_Dashboard.php");
			ob_end_flush();
		}

	} catch (Exception $e) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErorrInfo;
	}
}
?>