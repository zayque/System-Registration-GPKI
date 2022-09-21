<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Maklumat Pengguna</title>
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
    padding-top: 10%;
}

.no {
    padding-left: 80px;
}

.info {
    padding-left: 5%;
    font-size: 19px;
    font-family: arial;
}

#dt {
    text-indent: -500px;
    height: 25px;
    width: 200px;
}
</style>

<body>
    <?php
        require_once("dbcontroller.php");
        $db_handle = new DBController();
        if(!empty($_POST["submit"])) {
            $query = "UPDATE user set nama_user = '".$_POST["nama_user"]."', peranan_user = '".$_POST["peranan_user"]."', agensi_user = '".$_POST["agensi_user"]."', kementerian_user = '".$_POST["kementerian_user"]."', notel_user = '".$_POST["notel_user"]."', nopej_user = '".$_POST["nopej_user"]."', email_user = '".$_POST["email_user"]."' WHERE  noic_user=".$_GET["noic_user"];

            $result = $db_handle->executeQuery($query);
            if(!$result){
                $message = "Problem in Editing! Please Retry!";
            } else {
                header("Location:dashboard.php");
            }
        }
        $result = $db_handle->runQuery("SELECT * FROM user WHERE noic_user='" . $_GET["noic_user"] . "'");
    ?>


    <div class="container" style="margin-top: 20px">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body-form">

                <form name="frmToy" method="post" action="" id="frmToy" onClick="return validate();">
                    <br><br>
                        <div class="">

                            <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Nama</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $result[0]["nama_user"];?>" name="nama_user"
                                    id="nama_user" class="form-control input" required>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">
                        <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Peranan</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $result[0]["peranan_user"];?>" name="peranan_user"
                                    id="peranan_user" class="form-control input" >
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">

                        <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Kementerian</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $result[0]["kementerian_user"];?>" name="kementerian_user"
                                    id="kementerian_user" class="form-control input" >
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">
                        <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">No Telefon</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $result[0]["notel_user"];?>" name="notel_user"
                                    id="notel_user" class="form-control input" required>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">
                        <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">No Pejabat</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $result[0]["nopej_user"];?>" name="nopej_user"
                                    id="nopej_user" class="form-control input" required>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">
                        <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">E-mel</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $result[0]["email_user"];?>" name="email_user"
                                    id="email_user" class="form-control input" required>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">
                        <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">No KP</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $result[0]["noic_user"];?>" name="noic_user"
                                    id="noic_user" class="form-control input" required>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="b">
                                <input type="submit" class="btn btn-primary" name="submit" id="btnAddAction" value="Simpan" />
                                    <a href="dashboard.php">Kembali ke admin panel</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>