<!-- STYLING PURPOSE ONLY -->
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Delete Complete</title>

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
    require "../koneksi.php";
    
    $id     = $_GET['id'];
    $target = $_GET['origin'];

    if($target == 'viewsiswa' || $target == 'viewspp'){
        $id_spp = $_GET['id_spp'];
        $query1 = "DELETE FROM tb_siswa WHERE nisn='$id'";
        $result1 = $koneksi->query($query1);
        if($result1){
            $query2 = "DELETE FROM tb_spp WHERE id_spp='$id_spp'";
            $result2 = $koneksi->query($query2);
            if($result2){
                echo "<script>alert('Delete data berhasil'); window.location='../view/".$target.".php';</script>";
            } else{
                die("Gagal menghapus data spp: ".$koneksi->errno);
            }
        } else{
            die("Gagal menghapus data siswa: ".$koneksi->errno);
        }
    }

    $table  = $_GET['tb'];
    $field  = $_GET['field'];

    $query = "DELETE FROM $table WHERE $field='$id'";
    $result = $koneksi->query($query);

    if($result){
        echo "<script>alert('Delete data berhasil'); window.location='../view/".$target.".php';</script>";
    } else{
        die("Error deleting data : ".$koneksi->errno." - ".$koneksi->error);
    }
?>