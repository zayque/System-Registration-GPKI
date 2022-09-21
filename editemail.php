

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Maklumat Email</title>
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
            padding-left: 30%;
            padding-top: 10%;
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

    $id_email = $_GET['id_email'];
    $sql = "SELECT * FROM email WHERE id_email = '$id_email'";
    $cari = mysqli_query($conn,$sql) or die(mysqli_error());
    $row = mysqli_fetch_array($cari);
?>

<div class="container" style="margin-top: 20px">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-body-form">
            
            <form role="form" action="updateemail.php" method="post" >
                <br>
                    <br><br>
                
                    <div class="">
                        
                            <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" >Subject</label>
                                 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                <input type="text" value="<?php echo $row['subject_email'];?>" name="subject1" id="Applicant_name" class="form-control input" required>
                            </div>
                            </div>
                    </div>
                    <br><br>
                    <div class="">
                        
                            <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" >Body</label>
                                 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                 <textarea rows="4" cols="50" type="text" value="<?php echo $row['body_email'];?>" name="body1" id="Applicant_name" class="form-control input" required><?php echo $row['body_email'];?></textarea>
                            </div>
                            </div>
                    </div>
                    <br><br><br><br><br>
                    <div class="">
 
                            <div class="form-group">
                                <label for="I/C" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Alt Body</label>
                                 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                <input type="text" value="<?php echo $row['altbody_email'];?>" name="altbody1" class="form-control input" required>
                            </div>
                            </div>
                        
                    </div>
               
                       <div class="">

                            <div class="form-group">
                                 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                <input type="hidden" value="<?php echo $row['id_email'];?>" name="idemail1" id="company_name" class="form-control" required>
                            </div>
                            
                            </div>
                        
                    </div>
                    
                <div class="panel-body">
                        <div class="row" >
                            <div class="b">
                                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
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