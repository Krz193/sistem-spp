<?php
    session_start();
    
    require_once "../comp.php";
    require_once "../koneksi.php";

    preventBypass("viewlogin", "dashboard");

    $query = "SELECT tbp.*, tbs.nama, tbs.nis FROM tb_siswa tbs
    INNER JOIN tb_pembayaran tbp ON tbs.nisn=tbp.nisn
    ORDER BY id_pembayaran";
    $data = $koneksi->query($query);
    $row = $data->fetch_all(MYSQLI_ASSOC);

    $query2 = "SELECT tbp.id_petugas, nama_petugas FROM tb_pembayaran tbp LEFT JOIN tb_petugas ON tbp.`id_petugas`=tb_petugas.`id_petugas` ORDER BY id_pembayaran";
    $data2 = $koneksi->query($query2);
    $row2 = $data2->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Transaksi</title>

    <link rel="stylesheet" href="../design/style.css"/>
    <script src="../design/javascript.js"></script>

</head>
<body>
    <div class="container">
        <div class="navbar <?php if(isset($_GET['edit'])){echo 'hide';} ?>">
            <div class="navbar-header">
                <h1>HALO<?php if(isset($_SESSION['user'])) echo ', '.$_SESSION['user'].'!'; ?></h1>
                <a href="../proses/proses_logout.php" class="btn-logout">Logout</a>
            </div>
            <div class="navbar-menu">
                <ul>
                    <li><a href="dashboard.php" class="menu-icon">Dashboard</a></li>
                    <?php if($_SESSION['level']=='admin'){ ?>
                        <li><a href="viewpetugas.php">Petugas</a></li>
                        <li><a href="viewsiswa.php">Siswa</a></li>
                        <li><a href="viewkelas.php">Kelas</a></li>
                        <li><a href="viewspp.php">Spp</a></li>
                    <?php } ?>
                    <li><a href="history.php">Transaksi</a></li>
                </ul>
                <button role="button" class="show-form" onclick="location='viewpembayaran.php'">Insert</button>
            </div>
            <div class="navbar-icon" id="tes">
                <label for="btnNavbar" class="navbarIcon"></label>
                <button type="button" role="button" class="btnNavbar" id="btnNavbar">Click me</button>
            </div>
        </div>

        <div class="main-content row">
            <div class="left-container col-9">

                <!-- view data -->
                <div class="col-12 title">
                    <h1>Data Transaksi</h1>
                </div>
                <div class="col-12 table-container">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="first-col">ID Transaksi</th>
                                    <th>Petugas</th>
                                    <th>NIS</th>
                                    <th>Siswa</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Kembalian</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($data2->num_rows>0){ for($i=0;$i<count($row);$i++){
                                ?>
                                <tr>
                                    <td class="first-col"><div class="table-cell"><?= $row[$i]['id_pembayaran']?></div></td>
                                    <td><div class="table-cell"><?= ($row2[$i]['id_petugas']!='') ? $row2[$i]['nama_petugas'] : 'Data Tidak Tersedia' ?></div></td>
                                    <td><div class="table-cell"><?= $row[$i]['nis']?></div></td>
                                    <td><div class="table-cell"><?= $row[$i]['nama']?></div></td>
                                    <td><div class="table-cell"><?= $row[$i]['tgl_bayar']?></div></td>
                                    <td><div class="table-cell"><?= 'Rp. '.number_format($row[$i]['jumlah_bayar'], 2)?></div></td>
                                    <td><div class="table-cell"><?= 'Rp. '.number_format($row[$i]['kembalian'], 2)?></div></td>
                                    <td><div class="table-cell action-btn">
                                        <a href="viewpembayaran.php?detail_transaksi=true&id=<?= $row[$i]['id_pembayaran'] ?>&nis=<?= $row[$i]['nis'] ?>">
                                            <button type="button" name="edit-btn" role="button" id="edit-btn">Detail</button>
                                        </a>

                                        <!-- hanya admin yang bisa delete data -->
                                        <?php if($_SESSION['level']=='admin'){ ?>
                                            <a 
                                            href="../delete/proses_delete.php?id=<?= $row[$i]['id_pembayaran']?>&origin=history&tb=tb_pembayaran&field=id_pembayaran" 
                                            onclick="return confirm('PERINGATAN! Data akan dihapus secara permanen dan tidak akan bisa dipulihkan. Ingin melanjutkan menghapus data ini?')">
                                                <button type="button" name="delete-btn" role="button">Delete</button>
                                            </a>
                                        <?php } ?>
                                    </div></td>
                                </tr>
                                <?php
                                    } }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            
            <?php if($_SESSION['level']=='admin' || $_SESSION['level']=='petugas'){ ?>
            <div class="col-3 support-content">
                <div class="row">
                    <div class="col-12 title">
                        <h1>Jumlah Data</h1>
                    </div>
                    <div class="progress">
                        <div class="row">
                            <?php
                                $queryPr = "SELECT MONTHNAME(tgl_bayar) AS bulan, tgl_bayar, COUNT(tgl_bayar) AS total FROM tb_pembayaran GROUP BY tgl_bayar";
                            
                                $dataPr = $koneksi->query($queryPr);
                                $resultPr = $dataPr->fetch_all(MYSQLI_ASSOC);

                                $progress = 0;
                                for($i=0;$i<count($resultPr);$i++){
                                    $total = $resultPr[$i]['total'];
                                    $progress += (int)$total;
                                }
                                for($i=0;$i<count($resultPr);$i++){
                                    $jumlah = (int)$resultPr[$i]['total'];
                            ?>
                            <div class="col-12 progress-bar-wrapper">
                                <div class="desc">
                                    <p><?= $resultPr[$i]['tgl_bayar']; ?></p>
                                    <p><?= $resultPr[$i]['total']; ?></p>
                                </div>
                                <div class="progress-bar-bg">
                                    <div class="progress-bar" style="width: calc(<?= $jumlah.'/'.$progress; ?> * 100%)"></div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>