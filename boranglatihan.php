<?php
session_start();

	require 'config-mysqli.php';
	//////// End of connecting to database ////////

	@$zon=$_GET['zon']; // Use this line or below line if register_global is off
	if(strlen($zon) > 0 and !is_numeric($zon)){ // to check if $cat is numeric data or not. 
	echo "Data Error";
	exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Latihan Pengguna GPKI</title>
    <link rel="icon" type="image/ico" href="img/logo2.png" />

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  	
  	 <script language=JavaScript>

	function reload(form)
	{
	var val=form.zon.options[form.zon.options.selectedIndex].value;
	self.location='boranglatihan.php?zon=' + val ;
	}

	</script> 

			<script type="text/javascript">
                window.history.forward();
                function noBack() { window.history.forward(); }
            </script>
</head>

	<style>
	body{
		background-color:	#F7F7F7;
	}
		.form-input{
			width:70%;
			margin-left: 10px;
			border-radius: 5px;

		}
		.panel-body-form{
			padding: 15px;
    		padding-left: 25%;
    		font-size: 15px;	
    	
		}
		.b{
			margin-left: 30%;
			width: 5%;

		}
		.no{
			padding-left: 80px;

		}
		.info{
			
			font-size: 20px;
			font-family: arial;
			padding-left: 25%;

		}
		.note{
			color: red;
			padding-bottom: 40px;
			font-size: 12px;

		}
		span{
			color: red;
		}

		
			</style>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
			<div class="image-content">
				<center>
				<img src="img/mampu.jpg"/>
				</center>
			</div>
			<br>

<div class="container">

	
	<div class="col-lg-12">
		<!-- <a href="admin.php"><button type="Login" class="btn btn-default" style="float: right;">Login</button></a> -->
		 <?php
 
          require 'config-mysqli.php';

          $query = "SELECT * FROM maklumat ORDER BY maklumat_id ASC";
          $result = mysqli_query($conn,$query) or die(mysqli_error($conn,$query));

        ?>

	<br>
	<?php while($row = mysqli_fetch_array($result)){?>
	<div class="info">
	
		<b>Maklumat Latihan :</b>
		<br><?php echo $row['maklumat_detail'];?><br>
	
		<b>Zon :</b> 
		<?php echo $row['maklumat_zon'];?><br>

		<b>Negeri :</b> 
		<?php echo $row['maklumat_negeri'];?><br>
	
		<b>Tarikh : </b>
		<?php echo $row['maklumat_tarikh'];?><br>

		<b>Hari : </b>
		<?php echo $row['maklumat_hari'];?><br>

		
		<b>Masa : </b>
		<?php echo $row['maklumat_masa'];?><br>

		<b>Tempat : </b>
		<br><?php echo $row['maklumat_tempat'];?><br>
			
		<?php echo $row['maklumat_tempat2'];?>
		
		<?php echo $row['maklumat_tempat4'];?>
	
		<?php echo $row['maklumat_tempat3'];?>
	

	</div>
	<?php } ?>
		
		<h3 style="float: center; margin-top: 5%; text-align: center;"><b>Pendaftaran Latihan Pengguna GPKI </b></h3>
	
	</div>
</div>

<div class="container" style="margin-top: 20px">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-center"><b>Borang Pendaftaran Latihan </b></h3>
			</div>

			<div class="panel-body-form">
		

			<?php        
				include_once 'config-mysqli.php';
				
				$zon1 =  mysqli_query($conn,"select * from maklumat ORDER BY maklumat_id ASC");
				$zon1 = mysqli_fetch_array($zon1);
				$c= $zon1['maklumat_zon'];

		        $sql="SELECT COUNT(*) as bilangan from user WHERE jenis = 'Latihan' ";
		        $stmt = $conn->prepare($sql);
		        $stmt->execute();
		        $res = $stmt->get_result();
				$user = $res->fetch_array(MYSQLI_ASSOC);

				$limit1 =  mysqli_query($conn,"select * from limitlatihan ORDER BY id_limit ASC");
				$limit1 = mysqli_fetch_array($limit1);

				$b=$limit1['mesej_limit'];
				$a= $limit1['jumlah_limit'];

		        if ($user['bilangan'] < $a) {

				} else {
				
					echo'<script>alert("'.$b.'")</script>';

					// echo "<script>window.location='https://www.google.com/';</script>";
				};
		    ?>
			
			<form role="form" action="index_db.php" method="post" enctype="multipart/form-data">
					<br>
					<div class="">
						<div class="form-group">
							<label for="Name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label"></label>
							<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
							<input type="hidden" name="latihan1" id="company_name" class="form-control"  value="Latihan">
						</div>
						</div>
					</div>
							<br>
					<div class="">

							<div class="form-group">
								<label for="Name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">E-mel</label>
								 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
								<input type="email" name="email1" id="company_name" class="form-control" placeholder="Email" required oninvalid="this.setCustomValidity('Format : abc@example.com')">
								<span>Format : abc@example.com</span>
							</div>
							</div>
					</div>
					<br><br><br>
					<div class="">
						
							<div class="form-group">
								<label for="Name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label"> Nama</label>
								 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
								<input type="text" name="nama1" id="Applicant_name" class="form-control input" placeholder="Nama" required >
							</div>
							</div>
						
					
					</div>
					<br><br><br>
					<div class="">
						
							<div class="form-group">
								<label for="Name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label"> No. MyKad</label>
								 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
								<input type="text" name="noic1" id="Applicant_name" class="form-control input" placeholder="No. MyKad" maxlength="12" required oninvalid="this.setCustomValidity('Format : 930529011010 ')">
								<span>Format : 930529011010</span>
								</div>
							</div>
					</div>
					<br><br><br>
					<div class="">
							
							
							<div class="form-group">
								<label for="I/C" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">No. Telefon Bimbit </label>
								 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
								<input type="text" name="notel1" id="I/C" class="form-control input" placeholder="No. Telefon Bimbit" minlength="9" maxlength="12" required oninvalid="this.setCustomValidity('Format : 0178799802 ')">
								<span>Format : 0178799802</span>
							</div>
							</div>
						
						
					</div>
					<br><br><br>
					<div class="">
							<div class="form-group">
								<label for="I/C" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">No. Telefon Pejabat </label>
								 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
								 	<input type="tel" name="notel2"  class="form-control input" placeholder="No. Telefon Pejabat" minlength="9" maxlength="12" required oninvalid="this.setCustomValidity('Format : 60312345678 ')">
								 	<span>Format : 60312345678</span>
							     </div>
							</div>
					</div>
					<br><br><br>
					<div class="">
					
							<div class="form-group">
								<label for="I/C" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Agensi </label>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
								<input type="text" name="agensi1" id="I/C" class="form-control input" placeholder="Agensi" required>
							</div>
							</div>
						
					</div>
					<br><br><br>
					<div class="">
                                <div class="form-group">
                                    <label for="model" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Negeri</label>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                        <select class="form-control" name="negeri">
                                            <option value="">Sila pilih...</option>
                                            <option value="Kuala Lumpur">Kuala Lumpur</option>
                                            <option value="Selangor">Selangor</option>
                                            <option value="Putrajaya">Putrajaya</option>
                                            <option value="Kelantan">Kelantan</option>
                                            <option value="Terengganu">Terengganu</option>
                                            <option value="Pahang">Pahang</option>
                                            <option value="Perak">Perak</option>
                                            <option value="Perlis">Perlis</option>
                                            <option value="Kedah">Kedah</option>
                                            <option value="Pulau Pinang">Pulau Pinang</option>
                                            <option value="Johor">Johor</option>
                                            <option value="Negeri Sembilan">Negeri Sembilan</option>
                                            <option value="Melaka">Melaka</option>
                                            <option value="Sabah">Sabah</option>
                                            <option value="Sarawak">Sarawak</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
						<br><br><br>
					<div class="">
								<div class="form-group">
									<label for="model" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Kementerian</label>
									<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
									<select class="form-control" name="kementerian1">
										<option  value="">Sila pilih...</option>
										<option  value="PENTADBIRAN KERAJAAN NEGERI KEDAH">PENTADBIRAN KERAJAAN NEGERI KEDAH</option>
										<option  value="PENTADBIRAN KERAJAAN NEGERI SEMBILAN">PENTADBIRAN KERAJAAN NEGERI SEMBILAN</option>
										<option  value="KEMENTERIAN PEMBANGUNAN WANITA, KELUARGA, MASYARAKAT">KEMENTERIAN PEMBANGUNAN WANITA, KELUARGA, MASYARAKAT</option>
										<option value="PENTADBIRAN KERAJAAN NEGERI PULAU PINANG">PENTADBIRAN KERAJAAN NEGERI PULAU PINANG</option>
										<option value="KEMENTERIAN SAINS, TEKNOLOGI DAN INOVASI">KEMENTERIAN SAINS, TEKNOLOGI DAN INOVASI</option>
										<option value="JABATAN PERDANA MENTERI">JABATAN PERDANA MENTERI</option>
										<option  value="KEMENTERIAN PERUMAHAN DAN KERAJAAN TEMPATAN">KEMENTERIAN PERUMAHAN DAN KERAJAAN TEMPATAN</option>
										<option value="PENTADBIRAN KERAJAAN NEGERI PERLIS">PENTADBIRAN KERAJAAN NEGERI PERLIS</option>
										<option  value="KEMENTERIAN KEWANGAN">KEMENTERIAN KEWANGAN</option>
										<option value="PENTADBIRAN KERAJAAN NEGERI PAHANG">PENTADBIRAN KERAJAAN NEGERI PAHANG</option>
										<option  value="PENTADBIRAN KERAJAAN NEGERI JOHOR">PENTADBIRAN KERAJAAN NEGERI JOHOR</option>
										<option  value="PENTADBIRAN KERAJAAN NEGERI PERAK">PENTADBIRAN KERAJAAN NEGERI PERAK</option>
										<option value="KEMENTERIAN PERTAHANAN">KEMENTERIAN PERTAHANAN</option>
										<option value="KEMENTERIAN DALAM NEGERI">KEMENTERIAN DALAM NEGERI</option>
										<option  value="KEMENTERIAN SUMBER ASLI DAN ALAM SEKITAR">KEMENTERIAN SUMBER ASLI DAN ALAM SEKITAR</option>
										<option value="PENTADBIRAN KERAJAAN NEGERI SABAH">PENTADBIRAN KERAJAAN NEGERI SABAH</option>
										<option value="KEMENTERIAN KERJA RAYA">KEMENTERIAN KERJA RAYA</option>
										<option value="KEMENTERIAN PERTANIAN DAN INDUSTRI ASAS TANI">KEMENTERIAN PERTANIAN DAN INDUSTRI ASAS TANI</option>
										<option value="KEMENTERIAN TENAGA, TEKNOLOGI HIJAU DAN AIR">KEMENTERIAN TENAGA, TEKNOLOGI HIJAU DAN AIR</option>
										<option value="KEMENTERIAN LUAR NEGERI">KEMENTERIAN LUAR NEGERI</option>
										<option value="PENTADBIRAN KERAJAAN NEGERI SARAWAK">PENTADBIRAN KERAJAAN NEGERI SARAWAK</option>
										<option value="PENTADBIRAN KERAJAAN NEGERI KELANTAN">PENTADBIRAN KERAJAAN NEGERI KELANTAN</option>
										<option  value="KEMENTERIAN KOMUNIKASI DAN MULTIMEDIA">KEMENTERIAN KOMUNIKASI DAN MULTIMEDIA</option>
										<option value="KEMENTERIAN PENDIDIKAN TINGGI">KEMENTERIAN PENDIDIKAN TINGGI</option>
										<option value="PENTADBIRAN KERAJAAN NEGERI SELANGOR">PENTADBIRAN KERAJAAN NEGERI SELANGOR</option>
										<option  value="PENTADBIRAN KERAJAAN NEGERI TERENGGANU">PENTADBIRAN KERAJAAN NEGERI TERENGGANU</option>
										<option  value="KEMENTERIAN WILAYAH PERSEKUTUAN">KEMENTERIAN WILAYAH PERSEKUTUAN</option>
										<option  value="KEMENTERIAN KEMAJUAN LUAR BANDAR DAN WILAYAH">KEMENTERIAN KEMAJUAN LUAR BANDAR DAN WILAYAH</option>
										<option value="KEMENTERIAN PENGANGKUTAN">KEMENTERIAN PENGANGKUTAN</option>
										<option  value="KEMENTERIAN PERDAGANGAN DALAM NEGERI,KOPERASI DAN KEPENGGUNAAN">KEMENTERIAN PERDAGANGAN DALAM NEGERI,KOPERASI DAN KEPENGGUNAAN</option>
										<option  value="KEMENTERIAN PERDAGANGAN ANTARABANGSA DAN INDUSTRI">KEMENTERIAN PERDAGANGAN ANTARABANGSA DAN INDUSTRI</option>
										<option value="KEMENTERIAN BELIA DAN SUKAN">KEMENTERIAN BELIA DAN SUKAN</option>
										<option value="KEMENTERIAN SUMBER MANUSIA">KEMENTERIAN SUMBER MANUSIA</option>
										<option  value="KEMENTERIAN KEMENTERIAN SUMBER MANUSIA">KEMENTERIAN KEMENTERIAN SUMBER MANUSIA</option>
										<option value="PENTADBIRAN KERAJAAN NEGERI MELAKA">PENTADBIRAN KERAJAAN NEGERI MELAKA</option>
										<option  value="KEMENTERIAN KESIHATAN MALAYSIA">KEMENTERIAN KESIHATAN MALAYSIA</option>
										<option  value="KEMENTERIAN PERUSAHAAN PERLADANGAN DAN KOMODITI">KEMENTERIAN PERUSAHAAN PERLADANGAN DAN KOMODITI</option>
										<option  value="KEMENTERIAN PELANCONGAN DAN KEBUDAYAAN">KEMENTERIAN PELANCONGAN DAN KEBUDAYAAN</option>
									</select>
								</div>
								</div>
							
					</div>
					<br><br><br>
					<div class="">
						
							<div class="form-group">
								<label for="I/C" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Gred</label>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
								<input type="text" name="gred1" id="I/C" class="form-control input" placeholder="Gred" required>
							</div>
						</div>
					
					</div>
					<br><br><br>
					<div class="">
								<div class="form-group">
									<label for="model" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Peranan</label>
									<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
									<select class="form-control" name="peranan1">
										<option value="">Sila pilih...</option>
										<option value="PENGGUNA">PENGGUNA</option>
										<option value="AUTHORIZED PERSONNEL(AP)">AUTHORIZED PERSONNEL(AP)</option>
										<option value="SUB ADMIN(SA)">SUB ADMIN(SA)</option>
									</select>
								</div>
								</div>
					</div>
					<br><br><br>
				<div class="">
							<div class="form-group">
								<br>
								<table style="width:60%;">
									<label for="model" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Sistem ICT </label> 
								<tr>
									<td><input type="checkbox" name="check[]" value="iGFMAS"> iGFMAS</td>
									<td><input type="checkbox" name="check[]" value="ePerolehan"> ePerolehan</td>
									<td><input type="checkbox" name="check[]" value="POWER Gen 2"> POWER Gen 2 </td>
								</tr>
								<tr>
									 <td><input type="checkbox" name="check[]" value="eVetting"> eVetting</td>
									<td><input type="checkbox" name="check[]" value="E-Syariah"> E-Syariah</td>
									<td><input type="checkbox" name="check[]" value="eKehakiman"> eKehakiman</td>
								</tr>
								<tr>
									 <td><input type="checkbox" name="check[]" value="MyGST"> MyGST</td>
									<td><input type="checkbox" name="check[]" value="NC4"> NC4</td>
									<td><input type="checkbox" name="check[]" value="eTanah"> eTanah</td>
								</tr>
								<tr>
									 <td>  <input type="checkbox" name="check[]" value="eKampus"> eKampus</td>
									<td> <input type="checkbox" name="check[]" value="INSIST"> INSIST</td>
									<td><input type="checkbox" name="check[]" value="MyCukai"> MyCukai</td>
								</tr>
								<tr>
									 <td><input type="checkbox" name="check[]" value="MyeTaPP"> MyeTaPP</td>
									<td> <input type="checkbox" name="check[]" value="uCustom"> uCustom</td>
									<td><input type="checkbox" name="check[]" value="eROSA"> eROSA</td>
								</tr>
								<tr>
									 <td><input type="checkbox" name="check[]" value="MyGDX"> MyGDX</td>
									<td> <input type="checkbox" name="check[]" value="eKadaster"> eKadaster</td>
								</tr>
							</div>
							<br>

							<input type="hidden" name="zon" id="company_name" class="form-control"  value="<?php echo $c;?>">
					</div>
								</table>
									
						</div>
					</div>				
					<br>
				<div class="panel-body">
						<div class="row" >
							<div class="b">
								<button name="submit" type="submit" class="btn btn-primary" onClick="return confirm('Anda pasti ?');">Submit</button>
							</div>
						</div>
					</div>
				</form>
					
				</div>
		</div>
	</div>
</div>
</body>

<script>

function checkBox() {
    var x = document.getElementById("myCheck").required;
	}

function duplicate(){
    alert('Student ID / Email already exist!');
	}




	
</script>

<?php
    if(isset($_GET['msg'])){
        echo "<script> setTimeout(duplicate, 500); </script>";
    }
?>

<br>
	<footer>
		<!-- <center>
				<img src="img/Logo.png"><br>
				<label>Augmented Technology Sdn Bhd</label><br>
				No. 38 Jalan BM 7/19, Bandar Bukit Mahkota 43000, Kajang, Selangor, MALAYSIA<br>
				Tel: +(603) 8922 9474 Fax: +(603) 8922 9473
				<br><br><br>
		</center> -->
	</footer>
</html>