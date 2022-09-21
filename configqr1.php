<?php 
class RaviKoQr
{
  public $server = "localhost";
  public $user = "root";
  public $pass = "";
  public $dbname = "sistemborang";
	public $conn;
  public function __construct()
  {
  	$this->conn= new mysqli($this->server,$this->user,$this->pass,$this->dbname);
  	if($this->conn->connect_error)
  	{
  		die("connection failed");
  	}
  }
 	public function insertQr($email1,$nama1,$noic1,$notel1,$notel2,$chk,$agensi1,$kementerian1,$gred1,$peranan1,$zon,$negeri,$latihan1,$qrimage,$qrlink)
 	{		
		 
 			$sql = "INSERT INTO user(email_user,nama_user,noic_user,notel_user,nopej_user,sistem_user,agensi_user,kementerian_user,gred_user,peranan_user,zon_user,negeri_user,jenis 
			 ,qrImg,qrlink) VALUES('$email1','$nama1','$noic1','$notel1','$notel2','$chk','$agensi1','$kementerian1','$gred1','$peranan1','$zon','$negeri','$latihan1',
			 '$qrimage','$qrlink')";
 			$query = $this->conn->query($sql);
 			return $query;

 	
 	}
 	public function displayImg()
 	{
 		$sql = "SELECT qrimg,qrlink from user where qrimg='$qrimage'";

 	}
}
$meravi = new RaviKoQr();