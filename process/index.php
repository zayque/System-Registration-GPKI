<!DOCTYPE html>
<html>

<body>
	<?php 
		$dbh = new PDO("mysql:host=localhost;dbname=prototype","root", "");
		if (isset($_POST['btn'])) {
			$name = $_FILES['myfile']['name'];
			$type = $_FILES['myfile']['type'];
			$data = file_get_contents($_FILES['myfile']['tmp_name']);
			$stmt = $dbh->prepare("INSERT INTO myblob VALUES ('',?,?,?)");
			$stmt->bindParam(1,$name);
			$stmt->bindParam(2,$type);
			$stmt->bindParam(3,$data);
			$stmt->execute();
		}
	?>

	<form method="post" enctype="multipart/form-data">
		<input type="file" name="myfile">
		<button name="btn">Upload</button>
	</form>

	<p></p>
	<ol>
		<?php 
			$stmt = $dbh->prepare("SELECT * FROM myblob");
			$stmt->execute();
		while($row = $stmt->fetch()){
			echo "<li>".$row['name']."</li>"; 
		}
		?>
	</ol>
</body>
</html>