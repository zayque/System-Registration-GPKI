<?php
    include('includes/core.php')

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Maklumat Email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">

    <SCRIPT language=JavaScript>
    </script>
</head>

<style>
.form-input {
    width: 50%;
    margin-left: 10px;
    border-radius: 5px;
}

.panel-body-form {
    padding: 4em;
    font-size: 15px;
}

.email-box{
    width:80%;
    border:1px solid rgb(211,211,211);
    border-radius:5px;
    padding:1em 1.5em;
}
</style>

<body>

    <div class="container" style="margin-top: 20px; border: 1px solid rgb(221,221,221); border-radius:4px; ">
        <center>
            <h2>Maklumat E-mel</h2>
        </center>

        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body-form">
                    <h3>LATIHAN</h3>
                    <hr>
                    <?php
 
                require 'config-mysqli.php';

                $query = "SELECT * FROM email ORDER BY id_email ASC";
                $result = mysqli_query($conn,$query) or die(mysqli_error());

                ?>
                    <?php while($row = mysqli_fetch_array($result)){?>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b>Subject</b></label>
                        <div class="email-box">
                            <?php echo $row['subject_email'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b>Body</b></label>
                        <div class="email-box">
                            <?php echo $row['body_email'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Alt Body </b></label>
                        <div class="email-box">
                            <?php echo $row['altbody_email'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="float:right; padding-right: 20%;">
                            <a href="editemail.php?id_email=<?php echo $row['id_email'];?>"><button
                                    class="btn btn-success">Kemaskini</button></a>
                            <a href="dashboard.php"><button class="btn btn-primary">Kembali</button></a>
                        </div>
                        
                    </div>


                    <?php } ?>



                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body-form">
                    <h3>SEMINAR</h3>
                    <hr>
                    <?php
 
                require 'config-mysqli.php';

                $query = "SELECT * FROM email2 ORDER BY id_email2 ASC";
                $result = mysqli_query($conn,$query) or die(mysqli_error());

                ?>
                    <?php while($row = mysqli_fetch_array($result)){?>
                    <br>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Subject </b></label>
                        <div class="email-box">
                            <?php echo $row['subject_email2'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Body </b></label>
                        <div class="email-box">
                            <?php echo $row['body_email2'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Alt Body </b></label>
                        <div class="email-box">
                            <?php echo $row['altbody_email2'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="float:right; padding-right: 20%;">
                            <a href="editemail2.php?id_email2=<?php echo $row['id_email2'];?>"><button
                                    class="btn btn-success">Kemaskini</button></a>
                            <a href="dashboard.php"><button class="btn btn-primary">Kembali</button></a>
                        </div>
                        
                    </div>


                    <?php } ?>



                </div>
            </div>
        </div>

    </div>

</body>

</html>