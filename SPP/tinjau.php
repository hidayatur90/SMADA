<?php
session_start();
$nama = $_SESSION['nama_asli'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Pembayaran SPP</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Pilih Menu</h1>
        <h4>Hallo, <?= $nama ?></h4>
        <ul>
            <a href="daftar_siswa.php?kelas=X-MIPA-1"><li>Data siswa</li></a>
            <a href="rekap.php?start=&end="><li>Rekap</li></a>
            <a href="laporan.php?start=&end="><li>Laporan</li></a>
            <a href="logout.php"><li>Logout</li></a>
        </ul>
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