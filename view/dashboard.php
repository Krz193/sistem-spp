<?php
    session_start();
    
    if(!isset($_SESSION['level'])){
        header("Location: viewlogin.php");
    }

    include ('../koneksi.php');

    $query = "SELECT * FROM tb_spp ORDER BY id_spp ASC";
    $data = $koneksi->query($query);
    $result = $data->fetch_all(MYSQLI_ASSOC);

    function countData($tb){
        global $koneksi;
        $query = "SELECT COUNT(*) AS total FROM $tb";
        $data = $koneksi->query($query);
        $result = $data->fetch_all(MYSQLI_ASSOC);
        
        $total = $result[0]['total'];

        return (int)$total;
    }
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../design/style.css"/>
    <script src="../design/javascript.js"></script>

</head>
<style>
    .konten-siswa{
        float: none;
        margin: 0 auto;
    }
</style>
<body>
    <div class="container">
        <div class="navbar">
            <div class="navbar-header">
                <h1>HALO<?php if(isset($_SESSION['user'])) echo ', '.$_SESSION['user'].'!'; ?></h1>
                <a href="../proses/proses_logout.php" class="btn-logout">Logout</a>
            </div>
        </div>

        <div class="dashboard-content row">
            <?php
                if($_SESSION['level']=='admin'){
                    $title = "Data Apa Yang Ingin Kamu Akses?";
                } else if($_SESSION['level']=='petugas'){
                    $title = "Data Apa Yang Akan Kamu Input?";
                }else{
                    $title = "Berikut Adalah Histori Pembayaran Kamu :)";
                }
            ?>
            <div class="col-12 title">
                <h1><?= $title; ?></h1>
            </div>

            <!-- KONTEN ADMIN & PETUGAS -->
            <?php if($_SESSION['level']=='admin'){ ?>
            <div class="col-4 card-wrapper">
                <div class="row card">
                    <div class="col-12 card-header">
                        <div class="row" style="width: 100%;">
                            <div class="col-12 data-count">N/A</div>
                            <div class="col-12 card-title">Generate Laporan</div>
                        </div>
                    </div>
                    <a href="laporan.php">
                        <div class="col-12 card-footer">
                            <p>Detail</p>
                            <span class="caret"></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-4 card-wrapper">
                <div class="row card">
                    <div class="col-12 card-header">
                        <div class="row" style="width: 100%;">
                            <div class="col-12 data-count"><?= countData('tb_siswa'); ?></div>
                            <div class="col-12 card-title">Data Siswa</div>
                        </div>
                    </div>
                    <a href="viewsiswa.php">
                        <div class="col-12 card-footer">
                            <p>Detail</p>
                            <span class="caret"></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-4 card-wrapper">
                <div class="row card">
                    <div class="col-12 card-header">
                        <div class="row" style="width: 100%;">
                            <div class="col-12 data-count"><?= countData('tb_kelas'); ?></div>
                            <div class="col-12 card-title">Data Kelas</div>
                        </div>
                    </div>
                    <a href="viewkelas.php">
                        <div class="col-12 card-footer">
                            <p>Detail</p>
                            <span class="caret"></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-4 card-wrapper">
                <div class="row card">
                    <div class="col-12 card-header">
                        <div class="row" style="width: 100%;">
                            <div class="col-12 data-count"><?= countData('tb_petugas'); ?></div>
                            <div class="col-12 card-title">Data Petugas</div>
                        </div>
                    </div>
                    <a href="viewpetugas.php">
                        <div class="col-12 card-footer">
                            <p>Detail</p>
                            <span class="caret"></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-4 card-wrapper">
                <div class="row card">
                    <div class="col-12 card-header">
                        <div class="row" style="width: 100%;">
                            <div class="col-12 data-count"><?= countData('tb_spp'); ?></div>
                            <div class="col-12 card-title">Data SPP</div>
                        </div>
                    </div>
                    <a href="viewspp.php">
                        <div class="col-12 card-footer">
                            <p>Detail</p>
                            <span class="caret"></span>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php if($_SESSION['level']=='admin' || $_SESSION['level']=='petugas'){ ?>
            <div class="col-4 card-wrapper">
                <div class="row card">
                    <div class="col-12 card-header">
                        <div class="row" style="width: 100%;">
                            <div class="col-12 data-count"><?= countData('tb_pembayaran'); ?></div>
                            <div class="col-12 card-title">Histori Pembayaran</div>
                        </div>
                    </div>
                    <a href="history.php">
                        <div class="col-12 card-footer">
                            <p>Detail</p>
                            <span class="caret"></span>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
            <!-- KONTEN ADMIN & PETUGAS -->

            <!-- KONTEN SISWA -->
            <?php if($_SESSION['level']=='siswa'){ ?>
            <div class="col-10 konten-siswa table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="first-col">ID Transaksi</th>
                                <th>Petugas</th>
                                <th>NIS</th>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Tanggal Bayar</th>
                                <th>Jumlah Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $nisn = $_SESSION['nisn'];

                                $query = "SELECT nama_petugas FROM tb_pembayaran INNER JOIN tb_petugas ON tb_pembayaran.`id_petugas`=tb_petugas.`id_petugas`";
                                $data = $koneksi->query($query);
                                $row = $data->fetch_all(MYSQLI_ASSOC);

                                $querySiswa = "SELECT tbp.*, tbs.nama, tbs.nis, tbk.nama_kelas FROM tb_siswa tbs
                                LEFT JOIN tb_pembayaran tbp ON tbs.nisn=tbp.nisn
                                LEFT JOIN tb_kelas tbk ON tbs.id_kelas=tbk.id_kelas WHERE tbp.nisn='$nisn'
                                ORDER BY id_pembayaran";
                                $dataSiswa = $koneksi->query($querySiswa);
                                $rowSiswa = $dataSiswa->fetch_all(MYSQLI_ASSOC);

                                for($i=0;$i<count($rowSiswa);$i++){
                            ?>
                            <tr>
                                <td class="first-col"><div class="table-cell"><?= $rowSiswa[$i]['id_pembayaran']?></div></td>
                                <td><div class="table-cell"><?= $row[$i]['nama_petugas']?></div></td>
                                <td><div class="table-cell"><?= $rowSiswa[$i]['nis']?></div></td>
                                <td><div class="table-cell"><?= $rowSiswa[$i]['nama']?></div></td>
                                <td><div class="table-cell"><?= $rowSiswa[$i]['nama_kelas']?></div></td>
                                <td><div class="table-cell"><?= $rowSiswa[$i]['tgl_bayar']?></div></td>
                                <td><div class="table-cell"><?= $rowSiswa[$i]['jumlah_bayar']?></div></td>
                            </tr>
                            <?php
                                } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
            <!-- KONTEN SISWA -->
        </div>
    </div>
    
</body>
</html>