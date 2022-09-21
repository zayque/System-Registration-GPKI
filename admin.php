<!DOCTYPE html>
<html>

<head>
    <title>ADMIN PANEL</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/Login_page.css">


    <script type="text/javascript">
    window.history.forward();

    function noBack() {
        window.history.forward();
    }
    </script>

</head>

<style>
.wrap-login::before,
.wrap-login::after {
    display: block;
    content: "";
    clear: both;
}
.responsive {
  width: 100%;
  height: auto;
}
</style>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">

    <div class="container">
        <div style="width:50%; height:700px; position:relative; margin:0px auto; margin-top:20%;">
        <img src="img/logo3.png" alt="Nature" class="responsive">
            <div class="text-center">
                <h2>ADMIN PANEL SISTEM GPKI</h2>
                </div>
                    <div>
                        <!-- <div style="width:50%; position:absolute; left:50%; top:50%; transform: translate(-50%, 50%)"> -->
                        <div class="wrap-login col-lg-12">
                            <h3 class="text-center">Please Login</h3><br>
                            <form action="adminlogin.php" method="post">
                                <div class="form-group">
                                    <label for="email">Username</label>
                                    <input name="uid" type="text" class="form-control" id="email" placeholder="Username"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="pwd" type="password" class="form-control" id="password"
                                        placeholder="Password" required>
                                </div>
                                <input type="submit" class="btn btn-block" value="Login" name="submit"></input>
                            </form>
                            <!-- <center style="margin-top:25px;"><a href="index.php">Back to main</a></center> -->
                        </div>
                    </div>

            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous">
        </script>
</body>

</html>