<?php
    session_start();
    
    require_once "../comp.php";
    require_once "../koneksi.php";

    preventBypass("viewlogin", "dashboard");

    $query = "SELECT * FROM tb_petugas WHERE id_petugas>1 ORDER BY id_petugas ASC";
    $data = $koneksi->query($query);
    $result = $data->fetch_all(MYSQLI_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Petugas</title>

    <link rel="stylesheet" href="../design/style.css"/>
    <script src="../design/javascript.js"></script>

</head>
<style>
    .table-wrapper{  
        display: flex;
        justify-content: center;
    }
</style>
<body>
    <div class="container">

        <!-- form edit -->
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
                        $dataEdit = $koneksi->query("SELECT * FROM tb_petugas WHERE id_petugas='$id'");
                        while($rowEdit = $dataEdit->fetch_assoc()){
                    ?>

                    <form action="../edit/proses_edit.php?edit=petugas" method="POST" class="row" autocomplete="off">
                        <h1>Edit Data Petugas</h1>
                        <input type="hidden" name="id_petugas" value="<?= $_GET['id']; ?>">

                        <div class="form-item col-6">
                            <input type="text" name="nama_petugas" placeholder=" " value="<?= $rowEdit['nama_petugas'] ?>">
                            <label for="nama_petugas">Nama</label>
                        </div>
                        <div class="form-item col-6">
                            <input type="text" name="username" placeholder=" " value="<?= $rowEdit['username'] ?>">
                            <label for="username">Username</label>
                        </div>
                        <div class="form-item col-8">
                            <input type="password" name="password" placeholder=" " value="<?= $rowEdit['password'] ?>" id="password-field">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-item col-4">
                            <select name="level" class="pilih">
                                <option disabled>Pilih Level User</option>
                                <option value="admin" <?= ($rowEdit['level']=='admin') ? 'selected="true"' : ''?> >Admin</option>
                                <option value="petugas" <?= ($rowEdit['level']=='petugas') ? 'selected="true"' : ''?> >Petugas</option>
                            </select>
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

                <!-- insert petugas -->
                    <form action="../add/proses_addpetugas.php" method="post" class="row" autocomplete="off">
                        <h1>Insert Data Petugas</h1>
                        <div class="form-item col-6">
                            <input type="text" name="namaPetugas" placeholder=" ">
                            <label for="namaPetugas">Nama Petugas</label>
                        </div>
                        <div class="form-item col-6">
                            <input type="text" name="username" placeholder=" ">
                            <label for="username">Username</label>
                        </div>
                        <div class="form-item col-8">
                            <input type="password" name="password" placeholder=" ">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-item col-4">
                            <select name="level" class="pilih">
                                <option selected="true" disabled>Pilih Level User</option>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                            </select>
                        </div>
                        <div class="button-wrap col-12">
                            <input type="submit" value="Submit Data">
                        </div>
                    </form>
                </div>

                <!-- view petugas -->
                <div class="col-12 title">
                    <h1>Data Petugas</h1>
                </div>
                <div class="col-12 table-container">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="first-col">ID Petugas</th>
                                    <th>Nama Petugas</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    for($i=0;$i<count($result);$i++){
                                ?>
                                <tr>
                                    <td class="first-col"><div class="table-cell"><?= $result[$i]['id_petugas']?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['nama_petugas']?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['username']?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['level']?></div></td>
                                    <td><div class="table-cell action-btn">
                                        <a href="?edit=true&id=<?= $result[$i]['id_petugas']; ?>">
                                            <button type="button" name="edit-btn" role="button">Edit</button>
                                        </a>
                                        <a 
                                        href="../delete/proses_delete.php?tb=tb_petugas&field=id_petugas&id=<?= $result[$i]['id_petugas']; ?>&origin=viewpetugas" onclick="return confirm('PERINGATAN! Data akan dihapus secara permanen dan tidak akan bisa dipulihkan. Ingin melanjutkan menghapus data ini?')">
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
                                $queryPr = 'SELECT `level`, COUNT(`username`) AS total FROM tb_petugas GROUP BY `level`';
                            
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
                                    <p><?= $resultPr[$i]['level']; ?></p>
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