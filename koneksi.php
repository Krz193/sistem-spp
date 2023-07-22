<?php
    $host           = "localhost";
    $host_user      = "root";
    $host_pass      = "";
    $db_name        = "db_spp";

    $koneksi = new mysqli("$host", "$host_user", "$host_pass", "$db_name");
    
    if(!$koneksi){
        die("Could not connect :".$koneksi->connect_errno." - ".$koneksi->connect_error);
    }
?>