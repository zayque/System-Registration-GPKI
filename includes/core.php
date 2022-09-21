<?php
      session_start(); 
     

      if(!isset($_SESSION['u_uid']) || empty($_SESSION['u_uid'])){
          header("Location: admin.php");
          session_unset();
          session_destroy();
      }

    ?>