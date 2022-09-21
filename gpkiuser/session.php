<?php
        // mysqli_connect() function opens a new connection to the MySQL server.
        $conn = mysqli_connect("localhost", "root", "", "sistemborang");

        session_start();// Starting Session

        // Storing Session
        $user_check = $_SESSION['login_user'];

        // SQL Query To Fetch Complete Information Of User
        $query = "SELECT * from user where email_user = '$user_check'";
        $ses_sql = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($ses_sql);
        $zon_session = $row['zon_user'];
        $email_session = $row['email_user'];
        $nama_session = $row['nama_user'];
        $notel_session = $row['notel_user'];
        $nopej_session = $row['nopej_user'];
        $agensi_session = $row['agensi_user'];
        $kementerian_session = $row['kementerian_user'];
        $gred_session = $row['gred_user'];
        $peranan_session = $row['peranan_user'];
        $sistem_session = $row['sistem_user'];
       
        $jenis_session = $row['jenis'];
        $qrimg_session = $row['qrImg'];





?>