

<?php
 include "meRaviQr/qrlib.php";
 include "configqr1.php";

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendorphpmailer/autoload.php';

$mail = new PHPMailer(true);
	
if (isset($_POST['submit'])) {
	
	include_once 'config-mysqli.php';

   
    $qrImgName = "latihan".rand();


	$email1 = mysqli_real_escape_string($conn, $_POST['email1']);
	$nama1= mysqli_real_escape_string($conn, $_POST['nama1']);
	$noic1= mysqli_real_escape_string($conn, $_POST['noic1']);
	$notel1= mysqli_real_escape_string($conn, $_POST['notel1']);
	$notel2= mysqli_real_escape_string($conn, $_POST['notel2']);
	// $chk= mysqli_real_escape_string($conn, $_POST['chk']);
	$agensi1 = mysqli_real_escape_string($conn, $_POST['agensi1']);
	$kementerian1= mysqli_real_escape_string($conn, $_POST['kementerian1']);
	$gred1= mysqli_real_escape_string($conn, $_POST['gred1']);
	$peranan1= mysqli_real_escape_string($conn, $_POST['peranan1']);
	$zon= mysqli_real_escape_string($conn, $_POST['zon']);
	$negeri= mysqli_real_escape_string($conn, $_POST['negeri']);
	$latihan1= mysqli_real_escape_string($conn, $_POST['latihan1']);

	// check user
	$verify_userid =  mysqli_query($conn,"SELECT count(*) AS 'Total' FROM user WHERE noic_user = '".$noic1."' OR email_user = '".$email1."'");
	$f_verify_userid = mysqli_fetch_array($verify_userid);



	if($f_verify_userid['Total'] > 0){
		echo "<script>window.location='boranglatihan.php?msg=duplicate';</script>";
	}else{
		$checkbox1=$_POST['check'];  
		$chk="";  	
	
			foreach ($checkbox1 as $chk1){  
				$chk .= $chk1.",";  
		

				}  

				if ($resultCheck > 1) {
					header("Location: boranglatihan.php?boranglatihan=usertaken");
					exit();
				} 
				
				
				else{

					$nama1 = $nama1;
					$qrs = QRcode::png($nama1,"userQr/$qrImgName.png","H","3","3");
					$qrimage = $qrImgName.".png";
					$workDir = $_SERVER['HTTP_HOST'];
					$qrlink = $workDir."/qrcode".$qrImgName.".png";
					$insQr = $meravi->insertQr($email1,$nama1,$noic1,$notel1,$notel2,$chk,$agensi1,$kementerian1,$gred1,$peranan1,$zon,$negeri,$latihan1,$qrimage,$qrlink);

						$sql=mysqli_query($conn,"insert into user
							(email_user,nama_user,noic_user,notel_user,nopej_user,sistem_user,agensi_user,kementerian_user,gred_user,peranan_user,zon_user,negeri_user,jenis,qrImg,qrlink) 
							values 
							('$email1','$nama1','$noic1','$notel1','$notel2','$chk','$agensi1','$kementerian1','$gred1','$peranan1','$zon','$negeri','$latihan1','$qrimage','$qrlink')"); 

                         
                          

							// echo'<script>alert("Pengesahan pendaftaran tuan/puan untuk mengikuti Latihan Pengguna GPKI telah berjaya. Sila rujuk pengesahan yang akan dihantar ke e-mel tuan/puan dalam masa yang terdekat. Jika tidak mendapat sebarang pengesahan/makluman selepas 1 jam dari notifikasi ini, sila hubungi pihak urusetia seperti didalam agenda.")</script>';  
							$body1 =  mysqli_query($conn,"select * from email ORDER BY id_email ASC");
							$body1 = mysqli_fetch_array($body1);
							$subject1 =  mysqli_query($conn,"select * from email ORDER BY id_email ASC");
							$subject1 = mysqli_fetch_array($subject1);
							$altbody1 =  mysqli_query($conn,"select * from email ORDER BY id_email ASC");
							$altbody1 = mysqli_fetch_array($altbody1);


							echo "<script>window.location='keputusan.php';</script>";
						

								    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
								    $mail->isSMTP();                                      // Set mailer to use SMTP
								    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
								    $mail->SMTPAuth = true;                               // Enable SMTP authentication
								    $mail->Username = 'akmalhafizyakuza@gmail.com';                 // SMTP username
								    $mail->Password = 'Akmalhafiz321';                           // SMTP password
								    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
								    $mail->Port = 587;                                    // TCP port to connect to

								    //Recipients
								    $mail->setFrom('latihangpki@gmail.com', 'Latihan GPKI');
									$mail->addAddress($email1);     // Add a recipient

									$a= $body1['body_email'];
									$b= $subject1['subject_email'];
									$c= $altbody1['altbody_email'];

								    //Content
								    $mail->isHTML(true);                                  // Set email format to HTML
								    $mail->Subject = $b;
								    $mail->Body    = $a;
								    $mail->AltBody = $c;

								    $mail->send();
								    echo 'Message has been sent';
							
								exit;
				}
			}
			
}


?>