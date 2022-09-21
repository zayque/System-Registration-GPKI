<?php
session_start();
  if(isset($_SESSION['email']) && isset($_SESSION['pass'])){

  }
  else {
    header("Location: process/logout.php");
  }

  include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Register</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body style="background-color: #f8f8f8">
  <div class="container">
    <div class="text-center" style="padding-top: 70px">
    <img src="img/logo.png">
      <h3 class="text-center" style="padding-top: 10px">Augmented Technology</h3>
    </div>
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register New Account</div>
      <div class="card-body">
        <form action="process/register.php" method="POST">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="InputName">First name</label>
                <input name="fname" class="form-control" id="InputName" type="text" aria-describedby="nameHelp" placeholder="Enter first name" required>
              </div>
              <div class="col-md-6">
                <label for="InputLastName">Last name</label>
                <input name="lname" class="form-control" id="InputLastName" type="text" aria-describedby="nameHelp" placeholder="Enter last name" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="InputEmail1">Email address</label>
            <input name="email" class="form-control" id="InputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email" required>
          </div>
          <div class="form-group">
            <label for="InputNumber">Phone Number</label>
            <input name="phone" class="form-control" id="InputNumber" type="numb er" placeholder="Enter Number Phone" required>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="InputPassword1">Password</label>
                <input name="password" class="form-control" id="InputPassword1" type="password" placeholder="Password" required>
              </div>
              <div class="col-md-6">
                <label for="ConfirmPassword">Confirm password</label>
                <input name="retypepassword" class="form-control" id="ConfirmPassword" type="password" placeholder="Confirm password" required>
              </div>
            </div>
          </div>
          <button name="submit" class="btn btn-block btn-primary" type="submit" href="process/register.php">Register</button>
        </form>
        <div class="text-center">
          <a class="btn btn-secondary mt-3" href="dashboard.php">Back to Dashboard</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>