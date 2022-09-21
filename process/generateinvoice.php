<?php
session_start();

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


?>