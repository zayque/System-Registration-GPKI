<?php
        session_start();
        if(session_destroy()) // Destroying All Sessions 
        {
        header("Location: check.php"); // Redirecting To Home Page
        }
?>