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
    <title>Edit Maklumat Seminar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">

    <SCRIPT language=JavaScript>
    </script>
</head>

<style>
.form-input {
    width: 70%;
    margin-left: 10px;
    border-radius: 5px;
}

.panel-body-form {
    padding: 15px;
    padding-left: 25%;
    font-size: 15px;

}

.b {
    padding-left: 30%;
    padding-top: 20%;
}

.c {
    padding-left: 31%;

}

.no {
    padding-left: 80px;
}

.info {
    padding-left: 5%;
    font-size: 19px;
    font-family: arial;
}
</style>

<body>
    <?php

    include('config-mysqli.php');

    $maklumat_id2 = $_GET['maklumat_id2'];
    $sql = "SELECT * FROM maklumat2 WHERE maklumat_id2 = '$maklumat_id2'";
    $cari = mysqli_query($conn,$sql) or die(mysqli_error());
    $row = mysqli_fetch_array($cari);
?>

    <div class="container" style="margin-top: 20px">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body-form">

                    <form role="form" action="updatemaklumat2.php" method="post">
                        <br><br><br>

                        <div class="">

                            <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Maklumat
                                    Seminar</label>
                                <div class="col-lg-7 col-md-5 col-sm-5 col-xs-5">
                                    <input type="text" value="<?php echo $row['maklumat_detail2'];?>" name="detail1"
                                        id="Applicant_name" class="form-control input" required>
                                </div>
                            </div>


                        </div>
                        <br><br>
                        <div class="">

                            <div class="form-group">
                                <label for="Name"
                                    class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Tarikh</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $row['maklumat_tarikh2'];?>" name="tarikh1"
                                        id="Applicant_name" class="form-control input" required>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">

                            <div class="form-group">
                                <label for="I/C" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Hari</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $row['maklumat_hari2'];?>" name="hari1"
                                        class="form-control input" required>
                                </div>
                            </div>

                        </div>
                        <br><br>
                        <div class="">

                            <div class="form-group">
                                <label for="I/C" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Masa</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $row['maklumat_masa2'];?>" name="masa1"
                                        class="form-control input" required>
                                </div>
                            </div>

                        </div>
                        <br><br>
                        <div class="">
                            <div class="form-group">
                                <label for="model" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Zon</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <select class="form-control" name="zon1">
                                        <option value="<?php echo $row['maklumat_zon2'];?>"><?php echo $row['maklumat_zon2'];?></option>
                                        <option value="Tengah">Tengah</option>
                                        <option value="Timur">Timur</option>
                                        <option value="Utara">Utara</option>
                                        <option value="Selatan">Selatan</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">
                            <div class="form-group">
                                <label for="model"
                                    class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Negeri</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <select class="form-control" name="negeri1">
                                        <option value="<?php echo $row['maklumat_negeri2'];?>"><?php echo $row['maklumat_negeri2'];?></option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Selangor">Selangor</option>
                                        <option value="Putrajaya">Putrajaya</option>
                                        <option value="Kelantan">Kelantan</option>
                                        <option value="Terengganu">Terengganu</option>
                                        <option value="Pahang">Pahang</option>
                                        <option value="Perlis">Perlis</option>
                                        <option value="Kedah">Kedah</option>
                                        <option value="Pulau Pinang">Pulau Pinang</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Johor">Johor</option>
                                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                                        <option value="Melaka">Melaka</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">

                            <div class="form-group">
                                <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Tempat </label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <textarea rows="4" cols="50" type="text" name="tempat2"
                                        class="form-control input" required><?php echo $row['maklumat_tempat22'];?>
                                </textarea>

                                </div>
                            </div>

                        </div>
                        <br><br>
                        <br><br><br>
                        <div class="">

                            <div class="form-group">
                                <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Poskod </label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $row['maklumat_tempat23'];?>" name="tempat3"
                                        class="form-control input" required>

                                </div>
                            </div>

                        </div>
                        <br><br>
                        <div class="">

                            <div class="form-group">
                                <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Bandar </label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">

                                    <input type="text" value="<?php echo $row['maklumat_tempat24'];?>" name="tempat4"
                                        class="form-control input" required>

                                </div>
                            </div>

                        </div>
                        <div class="">

                            <div class="form-group">
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="hidden" value="<?php echo $row['maklumat_id2'];?>" name="id1"
                                        id="company_name" class="form-control" required>
                                </div>

                            </div>

                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="b">
                                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>

                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="c">
                        <a href="maklumatseminar.php"><button class="btn btn-primary">Back</button></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>