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
    session_start();
    include "../koneksi.php";

    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $koneksi->real_escape_string($_POST['password']);

    // ambil data dari tb_petugas
    $queryAdmin  = "SELECT * FROM tb_petugas WHERE `username`='$username' AND `password`='$password'";
    $dataAdmin   = $koneksi->query($queryAdmin);
    $resultAdmin = $dataAdmin->fetch_assoc();

    // ambil data dari tb_siswa
    $querySiswa  = "SELECT * FROM tb_siswa WHERE nis='$username' AND `password`='$password'";
    $dataSiswa   = $koneksi->query($querySiswa);
    $resultSiswa = $dataSiswa->fetch_assoc();

    // seleksi data pada tb_petugas
    if($dataAdmin->num_rows>0){

        // memasukkan data login ke variabel session
        if($resultAdmin['level']=="admin" || $resultAdmin['level']=="petugas"){
            $_SESSION['level']=$resultAdmin['level'];
            $_SESSION['user']=$resultAdmin['username'];
            $_SESSION['user_id']=$resultAdmin['id_petugas'];
        }
    }

    // seleksi data pada tb_siswa
    else if($dataSiswa->num_rows>0){
        $_SESSION['level']="siswa";
        $_SESSION['user']=$resultSiswa['nama'];
        $_SESSION['nis']=$resultSiswa['nis'];
        $_SESSION['nisn']=$resultSiswa['nisn'];
    }

    // jika tidak ada data yang cocok dari kedua kedua tabel
    else{
        echo "<script>alert('Username atau password salah'); window.location='../view/viewlogin.php';</script>";
    }

    // redirect ke dashboard jika ada yang cocok
    if(isset($_SESSION['level'])){
        header("Location: ../view/dashboard.php");
    }
?>