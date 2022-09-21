		<!--Delete -->
		<div class="modal fade" id="del<?php echo $row["SerialNumber"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<!--Header -->
					<div class="modal-header">
						<center><h5 class="modal-title" id="myModalLabel">Are you sure you want to delete?</h5></center>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="ture">&times;</button>
					</div>

					<!--Body-->
					<div class="modal-body">
						<?php 
							$del = mysqli_query($conn, "SELECT * FROM inv_tempapp WHERE SerialNumber ='".$row['SerialNumber']."'");
							$drow = mysqli_fetch_array($del);
						?>
					</div>
					<div class="container-fluid">
						<h5><center>Serial Number: <strong><?php echo $drow['SerialNumber'] ?></strong></center></h5>
					</div>

					<!--Footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a href="om/delete.php?id=<?php echo $row['SerialNumber']; ?>" class="btn btn-danger">Delete</a>
					</div>
				</div>
			</div>
		</div>
		<!--End of Delete -->

		<!-- Start of Edit -->
		<div class="modal fade" id="edit<?php echo $row["SerialNumber"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- Header -->
					<div class="modal-header">
					<center><h5 class="modal-title" id="myModalLabel">Edit</h5></center>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>

					<!--Body -->
					<div class="modal-body">
						<?php 
							$edit = mysqli_query($conn, "SELECT * FROM inv_tempapp WHERE SerialNumber='".$row['SerialNumber']."'");
							$erow = mysqli_fetch_array($edit);
						?>
						<div class="container-fluid">
							<form action="om/edit.php?id=<?php echo $erow['SerialNumber']; ?>" method="POST">
								<div class="row">
									<div class="col-lg-4">
										<label style="position:relative; top: 7px;">Serial Number</label>
									</div>
									<div class="col-lg-8">
										<input type="text" name="serial_no" class="form-control" value="<?php echo $erow['SerialNumber'] ?>">
									</div>
								</div>
						</div>

							<!-- Footer -->
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-warning">Save</button>
							</div>
							</form>
					</div>
				</div>
			</div>
		</div>