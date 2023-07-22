<?php
    session_start();

    require_once "../comp.php";
    require_once "../koneksi.php";

    preventBypass("viewlogin", "dashboard");

    $query = "SELECT nisn, nis, nama, tb_siswa.id_spp, nominal FROM tb_siswa INNER JOIN tb_spp ON tb_siswa.`id_spp`=tb_spp.`id_spp`";
    $data = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>

    <link rel="stylesheet" href="../design/style.css"/>
    <script src="../design/javascript.js"></script>

</head>
<style>
    .button-wrap{
        text-align: center;
        padding-top: 25px;
    }
    .form-wrapper.show{
        padding: 50px 15px;
    }
    .container{
        height: 100%;
    }
    .logo{
        display: none;
    }
    .data-transaksi, .detail-transaksi{
        display: flex;
        justify-content: center;
        max-height: 100%;
        margin: auto;
        float: none;
        padding: 50px 15px 20px;
    }

    .table-cell{
        padding: 0;
    }

    .table{
        width: 80%;
    }
    .table thead tr th{
        text-align: center;
        font-size: 16pt;
        line-height: 2;
    }
    .table tbody tr th, .table tbody tr td{
        line-height: 1.8;
    }
    .table tbody tr th{
        text-align: right;
    }
    .table tbody tr td{
        text-align: left;
    }

    .table tr td{
        max-width: revert;
    }
    .table tr th, .table tr td{
        min-width: 200px;
        background-color: revert;
    }
    .table tr{
        background-color: var(--dark-gray);
    }
    .table tbody tr:nth-child(odd), .table tbody tr:nth-child(odd) td{
        background-color: var(--light-gray);
    }

    .table tr{
        border-bottom: 2px solid var(--dark-accent);
    }
    .table tbody tr th{
        border-right: 3px solid var(--dark-accent);
    }

    .field-bayar{
        padding: 15px !important;
    }

    .button-wrap{
        display: flex;
        justify-content: space-around;
        margin: 0 auto;
        float: none;
    }

    /* print */
    @media only print{
        .button-wrap, .back-btn{
            display: none;
        }
        .logo{
            padding-top: 60px;
            display: block;
        }
        .logo h1{
            color: black;
        }
        .detail-transaksi{
            padding-top: 25px;
        }
        .detail-transaksi .table tr td, .detail-transaksi .table tr th, .detail-transaksi .table tr{
            border: 2px solid black;
            padding: 5px 15px;
        }
    }
</style>
<body>
    <div class="container">

        <div class="row">
            <div class="col-12 previous-page">
                <div class="back-btn" onclick="history.back()">
                    <img src="../support-files/img/back-btn.png" alt="">
                    <p>back</p> 
                </div>
            </div>
        </div>
        <?php if(!isset($_GET['nis'])){ ?>
        <div class="row">
            <div class="col-4 form-wrapper <?php if(!isset($_POST['cari_nis'])){echo 'show';} ?>">
                <form action="" method="GET" autocomplete="off">
                    <h1>Entri Transaksi</h1>
                    <div class="form-item col-12">

                        <!-- mencari data siswa yang akan melakukan transaksi -->
                        <input type="text" list="nis" name="nis" maxlength="6" placeholder=" "> 
                        <label for="nis">NISN / NIS</label>

                        <datalist id="nis">
                            <?php
                                while($row = $data->fetch_assoc()){
                            ?>
                            <option value="<?= $row['nis'] ?>"></option>
                            <?php } ?>
                        </datalist>
                    </div>
                    <div class="button-wrap col-12">
                        <input type="submit" value="Cari Data" name="cari_nis">
                    </div>
                </form>
            </div>
        </div>
        <?php } ?>

        <?php 
            if(isset($_GET['nis']) && !isset($_GET['detail_transaksi'])){ 
                $nis = $_GET['nis'];
                $queryTransaksi = "SELECT nisn, nis, nama, tb_siswa.id_spp, nominal FROM tb_siswa INNER JOIN tb_spp ON tb_siswa.`id_spp`=tb_spp.`id_spp` WHERE nis = '$nis'";
                $data = $koneksi->query($queryTransaksi);
                if($data->num_rows>0){
        ?>
                <div class="row">
                    <div class="col-5 data-transaksi">
                        <table class="table">
                            <?php
                                while($row = $data->fetch_assoc()){
                            ?>

                            <thead>
                                <tr>
                                    <th colspan="2">Transaksi - <?= $row['nis'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Petugas</th>
                                    <td><div class="table-cell"><?= $_SESSION['user'] ?></div></td>
                                </tr>
                                <tr>
                                    <th>Siswa</th>
                                    <td><div class="table-cell"><?= $row['nama'] ?></div></td>
                                </tr>
                                <tr>
                                    <th>Jumlah Tagihan</th>
                                    <td><div class="table-cell"><?= 'Rp. '.number_format($row['nominal'], 2); ?></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">

                        <!-- ENTRI TRANSAKSI -->
                        <div class="col-4 form-wrapper field-bayar show">
                            <form action="../add/proses_addtransaksi.php" method="POST" autocomplete="off">
                                <input type="hidden" name="nis" value="<?= $row['nis'] ?>">
                                <div class="form-item col-12">
                                    <input type="text" name="bayar" pattern="\d*" maxlength="13" placeholder=" ">
                                    <label for="bayar">Jumlah Bayar</label>
                                </div>

                                <div class="button-wrap col-12">
                                    <input type="submit" value="Bayar">
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
        <?php 
                } else{
                    echo "<script>alert('Data tidak ditemukan'); location='viewpembayaran.php';</script>";
                }
            }
        ?>

        <div class="row">

        <!-- DETAIL TRANSAKSI -->
            <?php if(isset($_GET['detail_transaksi'])){ ?>
            <div class="col-12 logo">
                <h1>sistem spp</h1>
            </div>
            <div class="col-6 detail-transaksi">
                <table class="table">
                    <?php
                        $id = $_GET['id'];
                        $queryTransaksi = "SELECT tbp.*, tbs.nama, tbs.nis, tp.nama_petugas FROM tb_siswa tbs
                        LEFT JOIN tb_pembayaran tbp ON tbs.nisn=tbp.nisn
                        INNER JOIN tb_petugas tp ON tbp.id_petugas=tp.id_petugas
                        WHERE id_pembayaran=$id
                        ORDER BY id_pembayaran";
                        $dataTransaksi = $koneksi->query($queryTransaksi);
                        while($row = $dataTransaksi->fetch_assoc()){
                    ?>

                    <thead>
                        <tr>
                            <th colspan="2">Transaksi - <?= $row['nis'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Petugas</th>
                            <td><div class="table-cell"><?= $row['nama_petugas'] ?></div></td>
                        </tr>
                        <tr>
                            <th>Siswa</th>
                            <td><div class="table-cell"><?= $row['nama'] ?></div></td>
                        </tr>
                        <tr>
                            <th>Jumlah Bayar</th>
                            <td><div class="table-cell"><?= 'Rp. '.number_format($row['jumlah_bayar'], 2); ?></div></td>
                        </tr>
                        <tr>
                            <th>Tanggal Bayar</th>
                            <td><div class="table-cell"><?= $row['tgl_bayar']; ?></div></td>
                        </tr>
                        <tr>
                            <th>Kembalian</th>
                            <td><div class="table-cell"><?= 'Rp. '.number_format($row['kembalian'], 2); ?></div></td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
            </div>
            <div class="button-wrap col-2">
                <button class="btn" onclick="location='history.php'">Back</button>
                <?php if($_SESSION['level']=='admin'){ ?>
                    <button class="btn" onclick='window.print()'>Print</button>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>