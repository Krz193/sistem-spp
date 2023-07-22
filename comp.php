<?php
    require_once "koneksi.php";

    // function untuk mencari nilai auto_increment selanjutnya
    function auto_incr($tb){
        global $koneksi;
        $query = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES
        WHERE table_name = '$tb'";
        $data = $koneksi->query($query);
        $row = $data->fetch_assoc();
        $id = $row['auto_increment'];

        return $id;
    }

    function backdrop($title){
        echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>'.$title.'</title>

                    <style>
                        html, body{
                            background: rgb(18, 18, 18);
                            box-sizing: border-box;
                            margin: 0; padding: 0;
                            color: rgb(236, 233, 236);
                            font-family: Verdana, Geneva, Tahoma, sans-serif;
                        }
                    </style>

                </head>
                <body>

                </body>
            </html>';
    }

    function preventBypass($noLevel, $siswa){
        if(!isset($_SESSION['level'])){
            header("Location: $noLevel.php");
        } else{
            if($_SESSION['level']=='siswa'){
                header("Location: $siswa.php");
            }
        }
    }

    function execQuery($query){
        global $koneksi;
        $result = $koneksi->query($query);
        if(!$result){
            $row = false;
        } else{
            $row = $result;
        }
        return $row;
    }

?>