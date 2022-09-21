

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Limit</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
    
     <SCRIPT language=JavaScript>
    </script> 
</head>

    <style>
        .form-input{
            width:70%;
            margin-left: 10px;
            border-radius: 5px;
        }
        .panel-body-form{
            padding: 15px;
            padding-left: 25%;
            font-size: 15px;
        
        }
        .b{
            padding-right: 27%;
            padding-top: 1em;
            float:right;
        }
        .c{
            padding-left: 31%;
      
        }
        .no{
            padding-left: 80px;
        }
        .info{
            padding-left: 5%;
            font-size: 19px;
            font-family: arial;
        }
        #dt{text-indent: -500px;height:25px; width:200px;}
        
            </style>
<body>
<?php

    include('config-mysqli.php');

    $id_limit2 = $_GET['id_limit2'];
    $sql = "SELECT * FROM limitseminar WHERE id_limit2 = '$id_limit2'";
    $cari = mysqli_query($conn,$sql) or die(mysqli_error());
    $row = mysqli_fetch_array($cari);
?>

<div class="container" style="margin-top: 20px">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-body-form">
            
            <form role="form" action="updatelimitseminar.php" method="post" >
                <br>
                    
                    <div class="">
                        
                            <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" >Limit</label>
                                 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                <input type="text" value="<?php echo $row['jumlah_limit2'];?>" name="limit1" id="Applicant_name" class="form-control input" required>
                            </div>
                             <br><br><br>
                                  <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" >Mesej</label>
                                 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                 <textarea rows="7"  name="limit2" id="Applicant_name" class="form-control input" required><?php echo $row['mesej_limit2'];?></textarea>
                    
                            </div>
                            </div>
                    </div>
                       <div class="">

                            <div class="form-group">
                                 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                <input type="hidden" value="<?php echo $row['id_limit2'];?>" name="idlimit1" id="company_name" class="form-control" required>
                            </div>
                            
                            </div>
                        
                    </div>
                    
                <div class="panel-body">
                        <div class="row" >
                            <div class="b">
                                <button name="submit" type="submit" class="btn btn-success">Submit</button>
                                <a href="maklumatseminar.php"><button class="btn btn-primary" type="button">Back</button></a>
                            </div>
                        </div>
                    </div>
                </form>
<!--                 
                <div class="c">
               
                </div> -->
                    
                </div>
        </div>
    </div>
</div>
</body>
</html>