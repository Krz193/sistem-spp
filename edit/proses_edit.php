<?php
    require_once "../koneksi.php";
    require_once "../comp.php";

    backdrop("Edit Data");

    $proses = $_GET['edit'];

    switch ($proses) {

        // edit siswa
        case 'siswa':
            $nama = $_POST['nama'];
            $idKelas = $_POST['kelas'];
            $alamat = $_POST['alamat'];
            $noTelp = $_POST['noTelp'];
            $password = $_POST['password'];
            $nisn = $_POST['nisn'];

            $query = "UPDATE tb_siswa SET nama=?, id_kelas=?, alamat=?, no_telp=?, `password`=? WHERE nisn=?";
            $stmt = $koneksi->prepare($query);
            if($stmt){
                $stmt->bind_param("sisssi", $nama, $idKelas, $alamat, $noTelp, $password, $nisn);
                $stmt->execute();
                $stmt->close();

                echo "<script>alert('Edit data berhasil'); window.location='../view/viewsiswa.php';</script>";
            } else{
                echo "Prepared query failed: ".$koneksi->errno." - ".$koneksi->error;
            }
            break;

        // edit petugas
        case 'petugas':
            $username = $_POST['username'];
            $password = $_POST['password'];
            $nama = $_POST['nama_petugas'];
            $level = $_POST['level'];
            $id = $_POST['id_petugas'];

            $query = "UPDATE tb_petugas SET `username`=?, `password`=?, nama_petugas=?, level=? WHERE id_petugas=?";
            $stmt = $koneksi->prepare($query);
            if($stmt){
                $stmt->bind_param("ssssi", $username, $password, $nama, $level, $id);
                $stmt->execute();
                $stmt->close();

                echo "<script>alert('Edit data berhasil'); window.location='../view/viewpetugas.php';</script>";
            } else{
                echo "Prepared query failed: ".$koneksi->errno." - ".$koneksi->error;
            }
            break;
        
        // edit kelas
        case 'kelas':
            $namaKelas = $_POST['nama_kelas'];
            $kompetensi = $_POST['kompetensi'];
            $id = $_POST['id'];

            $query = "UPDATE tb_kelas SET nama_kelas=?, kompetensi_keahlian=? WHERE id_kelas=?";
            $stmt = $koneksi->prepare($query);
            if($stmt){
                $stmt->bind_param("ssi", $namaKelas, $kompetensi, $id);
                $stmt->execute();
                $stmt->close();

                echo "<script>alert('Edit data berhasil'); window.location='../view/viewkelas.php';</script>";
            } else{
                echo "Prepared query failed: ".$koneksi->errno." - ".$koneksi->error;
            }
            break;

        // edit spp
        case 'spp':
            $tahun = $_POST['tahun'];
            $nominal = $_POST['nominal'];
            $id = $_POST['id'];

            $query = "UPDATE tb_spp SET tahun=?, nominal=? WHERE id_spp=?";
            $stmt = $koneksi->prepare($query);
            if($stmt){
                $stmt->bind_param("idi", $tahun, $nominal, $id);
                $stmt->execute();
                $stmt->close();

                echo "<script>alert('Edit data berhasil'); window.location='../view/viewspp.php';</script>";
            } else{
                echo "Prepared query failed: ".$koneksi->errno." - ".$koneksi->error;
            }
            break;

        default:
            echo "tidak halo";
            break;
    }
?>