<?php 

require_once('../db/db_config.php');

session_start();
$nama = $_SESSION['nama_user'];
if (!isset($_SESSION['nama_user'])) {
    header("Location: ../index.php");
}
$nama_asli = $_SESSION['nama_asli'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <title>Pembayaran SPP</title>
    <style>
        body{
            background: url('../assets/img/bg.png');
            background-repeat: no-repeat;
            background-size: 100% 125%;
            font-family: "Arial", Times, sans-serif;
        }
        .icon {
            font-size: 100px;
        }
        .icon i {
            color: black;
        }
        .icon i:hover {
            color: #5271FF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-end mt-4"><strong style="color:#5271FF;">ADMINISTRASI KEUANGAN</strong></h2>
        <h4 class="text-end">SMAN 2 BONDOWOSO</h4>
        <h4 class="ms-5 mt-4">Selamat datang, <strong style="color:#5271FF;"><?= $nama_asli ?></strong></h4>
        <div class="row text-center mt-5">
            <div class="col-4">
                <div class="icon">
                    <a href="daftar_siswa.php?kelas=X-MIPA-1">
                        <i class="bi bi-person-lines-fill"></i>
                    </a>
                </div>
                <h5>Data Siswa</h5>
            </div>
            <div class="col-4">
                <div class="icon">
                    <a href="detail_pembayaran.php?cari=">
                        <i class="bi bi-coin"></i>
                    </a>
                </div>
                <h5>Pembayaran</h5>
            </div>
            <div class="col-4">
                <div class="icon">
                    <a href="pembatalan.php">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                </div>
                <h5>Pembatalan</h5>
            </div>
            <div class="col-4">
                <div class="icon">
                    <a href="rekap.php?start=&end=">
                        <i class="bi bi-clock-history"></i>
                    </a>
                </div>
                <h5>Rekap/History</h5>
            </div>
            <div class="col-4">
                <div class="icon">
                    <a href="laporan.php?kelas=Semua">
                        <i class="bi bi-journal-arrow-down"></i>
                    </a>
                </div>
                <h5>Laporan</h5>
            </div>
            <div class="col-4">
                <div class="icon">
                    <a href="../db/logout.php">
                        <i class="bi bi-box-arrow-left"></i>
                    </a>
                </div>
                <h5>Keluar</h5>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script 
        src="https://code.jquery.com/jquery-3.6.0.slim.js"  integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous">
    </script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
</html>