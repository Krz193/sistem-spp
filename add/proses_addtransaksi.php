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
    include "../comp.php";

    $nis = $_POST['nis'];
    $jumlah_bayar = $_POST['bayar'];
    $id_transaksi = auto_incr('tb_pembayaran');

    function insertTransaksi($id_petugas, $nisn, $tgl, $bulan, $tahun, $id_spp, $jumlah_bayar, $kembalian = 0){
        global $koneksi;
        $query = "INSERT INTO tb_pembayaran(id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar, kembalian)
        VALUES('$id_petugas', '$nisn', '$tgl', '$bulan', '$tahun', '$id_spp', $jumlah_bayar, $kembalian)";
        $result = $koneksi->query($query);
    }
    function updateTagihan($sisa, $id){
        global $koneksi;
        $query = "UPDATE tb_spp SET nominal='$sisa' WHERE id_spp='$id'";
        $result = $koneksi->query($query);
    }

    $query = "SELECT nisn, nis, nama, nominal, tb_siswa.id_spp FROM tb_siswa INNER JOIN tb_spp ON tb_siswa.`id_spp`=tb_spp.`id_spp` WHERE nis = '$nis'";
    $data = $koneksi->query($query);
    while ($row = $data->fetch_assoc()){
        $nisn = $row['nisn'];
        $id_petugas = $_SESSION['user_id'];
        $id_spp = $row['id_spp'];
        $tgl = date("y-m-d");
        $bulan = date("F");
        $tahun = date("Y");

        $total_tagihan = $row['nominal'];
        // $jumlah_bayar -= $total_tagihan;
        if ($jumlah_bayar > 0 && $jumlah_bayar < $total_tagihan){
            $sisa = $total_tagihan - $jumlah_bayar;
            insertTransaksi($id_petugas, $nisn, $tgl, $bulan, $tahun, $id_spp, $jumlah_bayar);
            updateTagihan($sisa, $id_spp);
        } else if($jumlah_bayar > $total_tagihan){
            $kembalian = $jumlah_bayar - $total_tagihan;
            insertTransaksi($id_petugas, $nisn, $tgl, $bulan, $tahun, $id_spp, $jumlah_bayar, $kembalian);
            updateTagihan(0, $id_spp);
        } else{
            die("Connection failed: ".$koneksi->errno." - ".$koneksi->error);
        }

        echo "<script>window.location='../view/viewpembayaran.php?id=$id_transaksi&nis=$nis&detail_transaksi=true'</script>";
    }
?>