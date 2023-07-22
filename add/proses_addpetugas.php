<!-- STYLING PURPOSE ONLY -->
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Insert Complete</title>

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
    </html>
<!-- STYLING PURPOSE ONLY -->

<?php
    include "../koneksi.php";

    $query = "INSERT INTO tb_petugas(username, `password`, nama_petugas, `level`) VALUES(?, ?, ?, ?)";

    if($stmt = $koneksi->prepare($query)){

        $username = $_POST["username"];
        $password = $_POST["password"];
        $nama     = $_POST["namaPetugas"];
        $level    = $_POST["level"];

        $stmt->bind_param("ssss", $username, $password, $nama, $level);

        $stmt->execute();

        echo "<script>alert('Insert data berhasil'); window.location='../view/viewpetugas.php';</script>";
    } else{
        echo "ERROR: Could not prepare query: $query. ".$koneksi->errno." - ".$koneksi->error;
    }

    $stmt->close();
?>