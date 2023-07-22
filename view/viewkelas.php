<?php
    session_start();
    
    require_once "../comp.php";
    require_once "../koneksi.php";

    preventBypass("viewlogin", "dashboard");

    $query = "SELECT * FROM tb_kelas ORDER BY id_kelas ASC";
    $data = $koneksi->query($query);
    $result = $data->fetch_all(MYSQLI_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas</title>

    <link rel="stylesheet" href="../design/style.css"/>
    <script src="../design/javascript.js"></script>

</head>
<style>
    .table-wrapper{  
        display: flex;
        justify-content: center;
    }
    .table tr th, .table tr td{
        max-width: 375px !important;
        white-space: nowrap;
    }
</style>
<body>
    <div class="container">

        <?php if(isset($_GET['edit'])){ ?>
        <div class="row">
            <div class="col-12 previous-page">
                <div class="back-btn" onclick="history.back()">
                    <img src="../support-files/img/back-btn.png" alt="">
                    <p>back</p> 
                </div>
            </div>
        </div>
        <div class="row form-edit">
            <div class="col-6 form-wrapper show" id="form-edit">

                <?php
                    $id = $_GET['id'];
                    $dataEdit = $koneksi->query("SELECT * FROM tb_kelas WHERE id_kelas='$id'");
                    while($rowEdit = $dataEdit->fetch_assoc()){
                ?>

                <form action="../edit/proses_edit.php?edit=kelas" method="POST" class="row" autocomplete="off">
                    <h1>Edit Data Kelas</h1>
                    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                    <div class="form-item col-5">
                        <input type="text" name="nama_kelas" placeholder=" " value="<?= $rowEdit['nama_kelas'] ?>">
                        <label for="nama_kelas">Nama Kelas</label>
                    </div>
                    <div class="form-item col-7">
                        <input type="text" name="kompetensi" placeholder=" " value="<?= $rowEdit['kompetensi_keahlian'] ?>">
                        <label for="kompetensi">Kompetensi Keahlian</label>
                    </div>
                    <div class="button-wrap col-12">
                        <input type="reset" value="Clear Data">
                        <input type="submit" value="Submit Data">
                    </div>
                </form>

                <?php } ?>

            </div>
        </div>
        <?php } ?>

        <div class="navbar <?php if(isset($_GET['edit'])){echo 'hide';} ?>">
            <div class="navbar-header">
                <h1>HALO<?php if(isset($_SESSION['user'])) echo ', '.$_SESSION['user'].'!'; ?></h1>
                <a href="../proses/proses_logout.php" class="btn-logout">Logout</a>
            </div>
            <div class="navbar-menu">
                <ul>
                    <li><a href="dashboard.php" class="menu-icon">Dashboard</a></li>
                    <li><a href="viewpetugas.php">Petugas</a></li>
                    <li><a href="viewsiswa.php">Siswa</a></li>
                    <li><a href="viewkelas.php">Kelas</a></li>
                    <li><a href="viewspp.php">Spp</a></li>
                    <li><a href="history.php">Transaksi</a></li>
                </ul>
                <a href="#" class="show-form">Insert</a>
            </div>
            <div class="navbar-icon" id="tes">
                <label for="btnNavbar" class="navbarIcon"></label>
                <button type="button" role="button" class="btnNavbar" id="btnNavbar" onclick="showNavbar()">Click me</button>
            </div>
        </div>

        <div class="main-content row <?php if(isset($_GET['edit'])){echo 'hide';} ?>">
            <div class="left-container col-9">
                <div class="col-12 form-wrapper" id="form-insert">

                    <!-- form insert -->
                    <form action="../add/proses_addkelas.php" method="POST" class="row" autocomplete="off">
                        <h1>Insert Data Kelas</h1>
                        <div class="form-item col-5">
                            <input type="text" name="namaKelas" placeholder=" ">
                            <label for="namaKelas">Nama Kelas</label>
                        </div>
                        <div class="form-item col-7">
                            <input type="text" name="kompetensi" list="kompetensi" placeholder=" ">
                            <label for="kompetensi">Kompetensi Keahlian</label>

                            <datalist id="kompetensi">
                                <option>Animasi</option>
                                <option>Rekayasa Perangkat Lunak</option>
                                <option>Desain Komunikasi Visual</option>
                                <option>Teknik Komputer dan Jaringan</option>
                                <option>Multimedia</option>
                            </datalist>

                        </div>
                        <div class="button-wrap col-12">
                            <input type="submit" value="Submit Data">
                        </div>
                    </form>
                </div>

                <div class="col-12 title">
                    <h1>Data Kelas</h1>
                </div>
                <div class="col-12 table-container">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="first-col">ID Kelas</th>
                                    <th>Nama Kelas</th>
                                    <th>Kompetensi Keahlian</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    for($i=0;$i<count($result);$i++){
                                ?>
                                <tr>
                                    <td class="first-col"><div class="table-cell"><?= $result[$i]['id_kelas']?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['nama_kelas']?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['kompetensi_keahlian']?></div></td>
                                    <td><div class="table-cell action-btn">
                                        <a href="?edit=true&id=<?= $result[$i]['id_kelas']; ?>">
                                            <button type="button" name="edit-btn" role="button" id="edit-btn">Edit</button>
                                        </a>
                                        <a href="../delete/proses_delete.php?tb=tb_kelas&field=id_kelas&id=<?= $result[$i]['id_kelas']?>&origin=viewkelas" onclick="return confirm('PERINGATAN! Data akan dihapus secara permanen dan tidak akan bisa dipulihkan. Ingin melanjutkan menghapus data ini?')">
                                            <button type="button" name="delete-btn" role="button">Delete</button>
                                        </a>
                                    </div></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-3 support-content">
                <div class="row" style="width: 100%;">
                    <div class="col-12 title">
                        <h1>Jumlah Data</h1>
                    </div>
                    <div class="progress">
                        <div class="row">
                            <?php
                                $queryPr = 'SELECT kompetensi_keahlian, COUNT(nama_kelas) AS total FROM tb_kelas GROUP BY kompetensi_keahlian';
                            
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
                                    <p><?= $resultPr[$i]['kompetensi_keahlian']; ?></p>
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
        </div>
    </div>
</body>
</html>