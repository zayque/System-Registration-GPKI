<?php

session_start();

include '../config.php';

$type = $_POST['type'];
$option = $_POST['optradio'];


if ($type == "Token") {
	if ($option == "Year") {
		$year = $_POST['years'];
		header("Location: ../generate_tokenlog.php?y=$year");
	} 

	elseif ($option == "Month"){
		$date = $_POST['monthdate'];
		header("Location: ../generate_tokenlog.php?y=$date");
	}
	
}

elseif ($type == "Casing") {
	if ($option == "Year") {
		$year = $_POST['years'];
		header("Location: ../generate_tokenlog.php?y=$year");
	} 

	elseif ($option == "Month"){
		$date = $_POST['monthdate'];
		header("Location: ../generate_tokenlog.php?y=$date");
	}
} 

else {
	header("Location: ../admin.php");
}

?>