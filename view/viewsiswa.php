<?php
    session_start();
    
    require_once "../comp.php";
    require_once "../koneksi.php";

    preventBypass("viewlogin", "dashboard");

    $query = "SELECT *, nama_kelas FROM tb_siswa
    LEFT JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas
    INNER JOIN tb_spp ON tb_siswa.id_spp=tb_spp.id_spp
    ORDER BY nisn ASC";

    $data = $koneksi->query($query);
    $result = $data->fetch_all(MYSQLI_ASSOC);

    $queryKelas = "SELECT * FROM tb_kelas GROUP BY nama_kelas";
    $dataKelas = $koneksi->query($queryKelas);
    $resultKelas = $dataKelas->fetch_all(MYSQLI_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>

    <link rel="stylesheet" href="../design/style.css"/>
    <script src="../design/javascript.js"></script>

</head>
<style>
    .button-wrap{
        vertical-align: bottom;
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
                    $nisn = $_GET['nisn'];
                    $dataEdit = $koneksi->query("SELECT * FROM tb_siswa WHERE nisn='$nisn'");
                    while($rowEdit = $dataEdit->fetch_assoc()){
                ?>

                <form action="../edit/proses_edit.php?edit=siswa" method="POST" class="row" autocomplete="off">
                    <h1>Edit Data Siswa</h1>
                    <input type="hidden" name="nisn" value="<?= $_GET['nisn']; ?>">
                    <div class="form-item col-8">
                        <input type="text" name="nama" placeholder=" " value="<?= $rowEdit['nama'] ?>">
                        <label for="nama">Nama</label>
                    </div>
                    <div class="form-item col-4">
                        <select name="kelas" class="pilih">
                            <option selected="true" disabled>Pilih Kelas</option>
                            <?php
                                for($i=0;$i<count($resultKelas);$i++){
                            ?>
                                <option value="<?= $resultKelas[$i]['id_kelas']; ?>" <?php if($resultKelas[$i]['id_kelas']==$rowEdit['id_kelas']){echo 'selected="true"';} ?> ><?= $resultKelas[$i]['nama_kelas']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-item col-12">
                        <textarea name="alamat" class="textarea" rows="2" placeholder=" "><?= $rowEdit['alamat'] ?></textarea>
                        <label for="alamat">Alamat</label>
                    </div>
                    <div class="form-item col-6">
                        <input type="tel" name="noTelp" placeholder=" "  value="<?= $rowEdit['no_telp'] ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                        <label for="noTelp">No Telp</label>
                    </div>
                    <div class="form-item col-6">
                        <input type="password" name="password" placeholder=" " value="<?= $rowEdit['password'] ?>" id="password-field">
                        <label for="password">Password</label>
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
                <button role="button" class="show-form">Insert</button>
            </div>
            <div class="navbar-icon" id="tes">
                <label for="btnNavbar" class="navbarIcon"></label>
                <button type="button" role="button" class="btnNavbar" id="btnNavbar">Click me</button>
            </div>
        </div>

        <div class="main-content row <?php if(isset($_GET['edit'])){echo 'hide';} ?>">
            <div class="left-container col-9">

                <!-- form insert -->
                <div class="col-12 form-wrapper" id="form-insert">
                    <form action="../add/proses_addsiswa.php" method="POST" class="row" autocomplete="off">
                        <h1>Insert Data Siswa</h1>
                        <div class="form-item col-8">
                            <input type="text" name="nama" placeholder=" ">
                            <label for="nama">Nama</label>
                        </div>
                        <div class="form-item col-4">
                            <select name="kelas" class="pilih">
                                <option selected="true" disabled>Pilih Kelas</option>
                                <?php
                                    for($i=0;$i<count($resultKelas);$i++){
                                ?>
                                    <option value="<?= $resultKelas[$i]['nama_kelas']; ?>"><?= $resultKelas[$i]['nama_kelas']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-item col-12">
                            <textarea name="alamat" class="textarea" rows="2" placeholder=" "></textarea>
                            <label for="alamat">Alamat</label>
                        </div>
                        <div class="form-item col-6">
                            <input type="tel" name="noTelp" placeholder=" " onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            <label for="noTelp">No Telp</label>
                        </div>
                        <div class="form-item col-6">
                            <input type="password" name="password" placeholder=" " id="password-field">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-item col-12">
                            <input type="tel" name="nominal" placeholder=" " onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            <label for="nominal">Nominal</label>
                        </div>
                        <div class="button-wrap col-12">
                            <input type="reset" value="Clear Data">
                            <input type="submit" value="Submit Data">
                        </div>
                    </form>
                </div>

                <!-- view data -->
                <div class="col-12 title">
                    <h1>Data Siswa</h1>
                </div>
                <div class="col-12 table-container">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="first-col">NISN</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    for($i=0;$i<count($result);$i++){
                                ?>
                                <tr>
                                    <td class="first-col"><div class="table-cell"><?= $result[$i]['nisn']?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['nis']?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['nama']?></div></td>
                                    <td><div class="table-cell"><?= ($result[$i]['id_kelas']=='') ? 'Data Dihapus' : $result[$i]['nama_kelas']; ?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['alamat']?></div></td>
                                    <td><div class="table-cell"><?= $result[$i]['no_telp']?></div></td>
                                    <td><div class="table-cell action-btn">
                                        <a href="?edit=true&nisn=<?= $result[$i]['nisn']; ?>">
                                            <button type="button" name="edit-btn" role="button" id="edit-btn">Edit</button>
                                        </a>
                                        <a href="../delete/proses_delete.php?id=<?= $result[$i]['nisn']?>&id_spp=<?= $result[$i]['id_spp'] ?>&origin=viewsiswa" onclick="return confirm('PERINGATAN! Menghapus data ini akan menghapus juga data spp yang bersangkutan! Lanjutkan?')">
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
                <div class="row">
                    <div class="col-12 title">
                        <h1>Jumlah Data</h1>
                    </div>
                    <div class="progress">
                        <div class="row">
                            <?php
                                $queryPr = "SELECT tk.nama_kelas, ts.nama, CASE WHEN ts.id_kelas IS NULL THEN 'Data Dihapus' ELSE ts.id_kelas END AS kelas, COUNT(nama) AS total
                                FROM tb_siswa ts 
                                LEFT JOIN tb_kelas tk ON ts.id_kelas=tk.id_kelas
                                GROUP BY nama_kelas";
                            
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
                                    <p><?= ($resultPr[$i]['nama_kelas']=='') ? 'Data Dihapus' : $resultPr[$i]['nama_kelas']; ?></p>
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