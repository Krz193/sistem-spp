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
    include "../comp.php";
    

    // auto_increment selanjutnya dari tb_spp
    $idSpp = auto_incr('tb_spp');
    // tahun sekarang
    $tahun = date('Y');

    // memberi awalan 0 pada nis
    $nis = str_pad($idSpp, 4, '0', STR_PAD_LEFT);
    // memberi awalan angka sesuai tahun pada nisn
    $nisn = substr($tahun, -2).$nis;

    // input user
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['noTelp'];
    $password = $_POST['password'];
    $nominal = $_POST['nominal'];

    // mencari id_kelas yang diinput
    $queryKelas = "SELECT id_kelas FROM tb_kelas WHERE nama_kelas='$kelas'";
    $dataKelas = $koneksi->query($queryKelas);
    $row = $dataKelas->fetch_assoc();
    $idKelas = $row['id_kelas'];

    // query insert siswa & spp
    $query = "INSERT INTO tb_spp(tahun, nominal) VALUES(?, ?)";
    $query2 = "INSERT INTO tb_siswa(nisn, nis, nama, id_kelas, alamat, no_telp, id_spp, `password`)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

    // prepare statement
    $stmt = $koneksi->prepare($query);
    $stmt2 = $koneksi->prepare($query2);

    if($stmt && $stmt2){
        // bind parameter
        $stmt->bind_param("sd", $tahun, $nominal);
        $stmt2->bind_param("ssssssss", $nisn, $nis, $nama, $idKelas, $alamat, $telp, $idSpp, $password);

        // eksekusi prepared statement
        $stmt->execute();
        $stmt2->execute();

        $stmt->close();
        $stmt2->close();

        echo "<script>alert('Insert data berhasil'); window.location='../view/viewsiswa.php';</script>";
    } else{
        echo "Prepared query failed: ".$koneksi->errno." - ".$koneksi->error;
    }
?>