<?php
    session_start();

    require_once "../comp.php";
    require_once "../koneksi.php";

    preventBypass("viewlogin", "dashboard");

    if(isset($_GET['id_kelas'])){
        $id_kelas = $_GET['id_kelas'];

        $query = "SELECT nisn, nis, tbs.nama, nominal, tahun, tbk.id_kelas, nama_kelas
        FROM tb_siswa tbs INNER JOIN tb_spp ts ON tbs.id_spp=ts.id_spp
        INNER JOIN tb_kelas tbk ON tbs.id_kelas=tbk.id_kelas
        WHERE tbk.id_kelas=$id_kelas";
        $data = $koneksi->query($query);
        $row = $data->fetch_all(MYSQLI_ASSOC);
    }
        $queryKelas = "SELECT nama_kelas, tbk.id_kelas FROM tb_kelas tbk
        INNER JOIN tb_siswa tbs ON tbk.id_kelas=tbs.id_kelas GROUP BY id_kelas";
        $dataKelas = $koneksi->query($queryKelas);
        $rowKelas = $dataKelas->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Data</title>
    
    <link rel="stylesheet" href="../design/style.css"/>
    <script src="../design/javascript.js"></script>

</head>
<style>
    .title h1{
        font-size: 22pt;
    }
    .subtitle h2{
        display: block;
        text-align: center;
        padding-bottom: 25px;
        padding-top: 5px;
    }
    .action{
        display: flex;
        align-items: center;
        padding-bottom: 10px;
    }
    .pilih{
        width: 100%;
        float: left;
        margin: 0;
    }
    .button-wrap{
        flex-grow: 2;
        padding: 10px 0 5px;
    }

    .table tfoot tr th, .table tfoot tr td{
        background-color: var(--dark-accent);
    }
    .table-wrapper{
        width: 100%;
    }
    .table{
        width: 100%;
    }
    .table tr th:first-child, .table tr td:first-child,
    .table tr th:nth-child(2), .table tr td:nth-child(2){
        min-width: revert;
        width: 50px;
    }
    .table tr td:last-child{
        text-align: right;
    }

    .logo{
        display: none;
    }
    @media only print{
        .action, .previous-page{
            display: none;
        }
        .title h1, .subtitle h2{
            font-size: 12pt;
            font-weight: normal;
        }
        .subtitle h2{
            display: block;
            margin: 0;
        }
        .logo{
            display: block;
        }
        .logo h1{
            color: black;
            font-family: sinkin-bold;
        }

        .table tr th:first-child, .table tr td:first-child{
            position: revert;
        }
        .table tr th, .table tr td{
            border: 2px solid black;
            padding: 5px 7px;
        }
        .table-cell{
            padding: 0;
        }
        .table thead tr th{
            text-align: center;
        }
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 previous-page">
                <div class="back-btn" onclick="location.href='dashboard.php'">
                    <img src="../support-files/img/back-btn.png" alt="">
                    <p>back</p> 
                </div>
            </div>
            <div class="col-2"></div>
            <div class="col-8">
                <div class="logo">
                    <h1>sistem spp</h1>
                </div>
                <div class="title" <?= (!isset($_GET['id_kelas'])) ? 'style="padding-bottom: 15px;"' : '' ?>>
                    <h1>laporan total kewajiban iuran sekolah</h1>
                </div>

                <?php if(isset($_GET['id_kelas'])){ ?>
                    <div class="subtitle">
                        <?php
                            $querySubtitle = "SELECT tbk.id_kelas, nama_kelas
                            FROM tb_siswa tbs
                            INNER JOIN tb_kelas tbk ON tbs.id_kelas=tbk.id_kelas
                            WHERE tbk.id_kelas=$id_kelas LIMIT 1";
                            $dataSubtitle = $koneksi->query($querySubtitle);
                            $rowSub = $dataSubtitle->fetch_assoc();
                        ?>

                        <h2><?= $rowSub['nama_kelas'] ?></h2>
                    </div>
                <?php } ?>

                <div class="action">
                    <form action="" method="GET" id="id_kelas">
                        <select name="id_kelas" class="pilih" onchange="document.getElementById('id_kelas').submit()">
                            <option disabled selected>Pilih Kelas</option>

                            <?php for($i=0;$i<count($rowKelas);$i++){ ?>
                                <option value="<?= $rowKelas[$i]['id_kelas'] ?>"  <?= (isset($_GET['id_kelas'])) ? (($id_kelas==$rowKelas[$i]['id_kelas']) ? 'selected' : '') : '' ?>>
                                    <?= $rowKelas[$i]['nama_kelas'] ?>
                                </option>
                            <?php } ?>

                        </select>
                    </form>
                    <?php if(isset($_GET['id_kelas'])){ ?>
                    <div class="button-wrap">
                        <button onclick="window.print()">Print</button>
                    </div>
                    <?php } ?>
                </div>

                <div class="table-container">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="first-col">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kewajiban</th>
                                </tr>
                            </thead>
                            
                            <?php if(isset($_GET['id_kelas'])){ ?>
                                <tbody>
                                    <?php 
                                        $no = 1;
                                        for($i=0;$i<count($row);$i++){
                                    ?>
                                    <tr>
                                        <td class="first-col"><div class="table-cell"><?= $no; ?></div></td>
                                        <td><div class="table-cell"><?= $row[$i]['nis'] ?></div></td>
                                        <td><div class="table-cell"><?= $row[$i]['nama'] ?></div></td>
                                        <td><div class="table-cell">
                                            <?= ($row[$i]['nominal']!=0) ? number_format($row[$i]['nominal'], 2) : '-' ?>
                                        </div></td>
                                    </tr>
                                    <?php 
                                        $no++; }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <?php
                                            $total = 0.00;
                                            for($i=0;$i<count($row);$i++){
                                                $total += (float)$row[$i]['nominal'];
                                            }
                                        ?>
                                        <th colspan="3">Total Kewajiban</th>
                                        <td><?= 'Rp. '.number_format($total, 2) ?></td>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</body>
</html>