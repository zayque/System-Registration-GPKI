<?php
session_start();

include ('../config.php');


$reqnum;


//Verify the token.
$sql = "UPDATE `inv_orderinfo` SET `Status` = 'Verified' WHERE `inv_orderinfo`.`RequestNumber` = ''";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Requester Information</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  
</head>

<body>
	<div class="container">
	<h2>Ajax Update</h2>
	<p>Update something with Jquery Ajax</p>
	<table class="table">
		<thead>
			<tr>
				<th>Request Number</th>
				<th>Company Name</th>
				<th>Address</th>
				<th>Date</th>
				<th>Status</th>
				<th style="width: 130px">Download Link</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$table = mysqli_query($conn, 'SELECT * FROM inv_orderinfo');
				while($row = mysqli_fetch_array($table)) { ?>
					<tr>
						<td><?php echo $row['RequestNumber'] ?></td>
						<td><?php echo $row['CompanyName'] ?></td>
						<td><?php echo $row['Address'] ?></td>
						<td style="width:90px"><?php echo $row['Date'] ?></td>
						<td><?php 

						if($row['Status'] == 'Verified'){
							echo "<div class='alert alert-success'>
							  <strong>".$row['Status']."</strong>
							</div>";
						}

						else {
							echo "<div class='alert alert-danger'>
							  <strong>".$row['Status']."</strong>
							</div>";
						}
						?></td>
						<td style="text-align:center;"><a href="../invoice.php?req=<?php echo $row['RequestNumber'] ?>">Download</a></td>
					</tr>
				<?php }
			?>
		</tbody>
	</table>
	</div>
</body>