<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["noic_user"])) {
    $query = "DELETE FROM user WHERE noic_user=".$_GET["noic_user"];
    $result = $db_handle->executeQuery($query);
	if(!empty($result)){
		header("Location:dashboard.php");
	}
}
?>